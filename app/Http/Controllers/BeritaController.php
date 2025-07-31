<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

use App\Models\Berita;
use App\Models\Bidang;

use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index()
    {
        return view('berita');
    }

    public function indexAdmin(Request $request)
    {
        $query = Berita::with('kategori')->latest();

        // Filter judul
        if ($request->filled('q')) {
            $query->where('judul', 'like', '%' . $request->q . '%');
        }

        // Filter status (array)
        if ($request->has('status')) {
            $query->whereIn('status', $request->status);
        }

        // Filter bidang (kategori_id)
        if ($request->has('bidang')) {
            $query->whereIn('kategori_id', $request->bidang);
        }

        $beritas = $query->get();
        $bidang = Bidang::all();

        return view('admin.berita.index', compact('beritas', 'bidang'));
    }

    public function create()
    {
        $bidang = Bidang::all();
        return view('admin.berita.create', compact('bidang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi_berita' => 'required|string',
            'kategori_id' => 'required|exists:bidang,id',
            'tanggal' => 'required|date',
            'status' => 'required|in:publikasi,draft',
            'foto_utama' => 'required|image',
            'foto_lain.*' => 'nullable|image',
        ]);

        // Buat berita dulu untuk mendapatkan ID
        $berita = Berita::create([
            'judul' => $request->judul,
            'isi_berita' => $request->isi_berita,
            'kategori_id' => $request->kategori_id,
            'tanggal' => $request->tanggal,
            'status' => $request->status,
            'views' => 0,
        ]);

        // Simpan foto utama dengan nama [id]_utama.ext
        if ($request->hasFile('foto_utama')) {
            $fotoUtama = $request->file('foto_utama');
            $namaUtama = "{$berita->id}_utama." . $fotoUtama->getClientOriginalExtension();
            $pathUtama = $fotoUtama->storeAs('berita', $namaUtama, 'public');

            $berita->foto_utama = 'storage/' . $pathUtama;
        }

        // Simpan foto tambahan sebagai array path
        $fotoTambahanPaths = [];

        if ($request->hasFile('foto_lain')) {
            foreach ($request->file('foto_lain') as $index => $foto) {
                $namaFoto = "{$berita->id}_detail" . ($index + 1) . "." . $foto->getClientOriginalExtension();
                $pathFoto = $foto->storeAs('berita', $namaFoto, 'public');

                $fotoTambahanPaths[] = 'storage/' . $pathFoto;
            }
        }

        // Simpan path-path ke kolom
        $berita->foto_tambahan = json_encode($fotoTambahanPaths);
        $berita->save();

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil disimpan.');
    }

    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);

        // Hapus foto utama jika ada
        if ($berita->foto_utama && file_exists(public_path($berita->foto_utama))) {
            unlink(public_path($berita->foto_utama));
        }

        // Hapus foto tambahan jika ada
        if ($berita->foto_tambahan) {
            foreach (json_decode($berita->foto_tambahan) as $foto) {
                if (file_exists(public_path($foto))) {
                    unlink(public_path($foto));
                }
            }
        }

        $berita->delete();

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus.');
    }

    public function edit($id)
    {
        $berita = Berita::findOrFail($id);
        $bidang = Bidang::all();
        return view('admin.berita.edit', compact('berita', 'bidang'));
    }

    public function update(Request $request, $id)
    {
        $berita = Berita::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'isi_berita' => 'required|string',
            'kategori_id' => 'required|exists:bidang,id',
            'tanggal' => 'required|date',
            'status' => 'required|in:publikasi,draft',
            'foto_utama' => 'nullable|image',
            'foto_lain.*' => 'nullable|image',
        ]);

        $berita->update([
            'judul' => $request->judul,
            'isi_berita' => $request->isi_berita,
            'kategori_id' => $request->kategori_id,
            'tanggal' => $request->tanggal,
            'status' => $request->status,
        ]);

        // Ganti foto utama jika ada
        if ($request->hasFile('foto_utama')) {
            if ($berita->foto_utama && file_exists(public_path($berita->foto_utama))) {
                unlink(public_path($berita->foto_utama));
            }

            $file = $request->file('foto_utama');
            $namaUtama = "{$berita->id}_utama." . $file->getClientOriginalExtension();
            $path = $file->storeAs('berita', $namaUtama, 'public');
            $berita->foto_utama = 'storage/' . $path;
        }

        // Proses foto tambahan
        $existingPaths = json_decode($request->existing_foto_tambahan, true) ?? [];
        $pathsBaru = [];

        if ($request->hasFile('foto_lain')) {
            foreach ($request->file('foto_lain') as $index => $foto) {
                $namaFoto = "{$berita->id}_detail_" . time() . "_$index." . $foto->getClientOriginalExtension();
                $pathFoto = $foto->storeAs('berita', $namaFoto, 'public');
                $pathsBaru[] = 'storage/' . $pathFoto;
            }
        }

        $berita->foto_tambahan = json_encode(array_merge($existingPaths, $pathsBaru));
        $berita->save();

        return redirect()
            ->route('admin.berita.index')
            ->with('success', 'Berita berhasil diperbaharui.');
    }
}
