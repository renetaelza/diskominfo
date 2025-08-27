<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

use App\Models\Berita;
use App\Models\Topik;

use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $query = Berita::where('status', 'publikasi');

        if ($request->has('search') && $request->search != '') {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        if ($request->has('topik_id') && $request->topik_id != '') {
            $query->where('topik_id', $request->topik_id);
        }

        $semuaBerita = $query->orderByDesc('tanggal')->paginate(9)->withQueryString();

        $beritaTerbaru = Berita::where('status', 'publikasi')
            ->orderByDesc('tanggal')
            ->take(3)
            ->get();

        $topikTerpakai = Berita::select('topik_id')
            ->where('status', 'publikasi')
            ->distinct()
            ->with('topik')
            ->get()
            ->pluck('topik')
            ->unique('id');

        return view('berita.index', compact('semuaBerita', 'beritaTerbaru', 'topikTerpakai'));
    }


    public function show($id)
    {
        $berita = Berita::findOrFail($id);
        $berita->increment('views');

        $terpopuler = Berita::orderByDesc('views')->take(3)->get();

        return view('berita.detail', compact('berita', 'terpopuler'));
    }

    public function indexAdmin(Request $request)
    {
        $query = Berita::with('topik')->latest();

        if ($request->filled('q')) {
            $query->where('judul', 'like', '%' . $request->q . '%');
        }

        if ($request->has('status')) {
            $query->whereIn('status', $request->status);
        }

        if ($request->has('topik')) {
            $query->whereIn('topik_id', $request->topik);
        }

        $beritas = $query->orderByDesc('tanggal')->paginate(10)->withQueryString();

        $topiks = Topik::all();

        return view('admin.berita.index', compact('beritas', 'topiks'));
    }

    public function create()
    {
        $topiks = Topik::all();
        return view('admin.berita.create', compact('topiks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi_berita' => 'required|string',
            'topik_id' => 'required|exists:topik,id',
            'tanggal' => 'required|date',
            'status' => 'required|in:publikasi,draft',
            'foto_utama' => 'nullable|image',
            'foto_lain.*' => 'nullable|image',
        ]);

        $berita = Berita::create([
            'judul' => $request->judul,
            'isi_berita' => $request->isi_berita,
            'topik_id' => $request->topik_id,
            'tanggal' => $request->tanggal,
            'status' => $request->status,
            'views' => 0,
            'foto_utama' => '',
            'foto_tambahan' => '[]',
        ]);

        if ($request->hasFile('foto_utama')) {
            $fotoUtama = $request->file('foto_utama');
            $namaUtama = "{$berita->id}_utama." . $fotoUtama->getClientOriginalExtension();
            $pathUtama = $fotoUtama->storeAs('berita', $namaUtama, 'public');

            $berita->update([
                'foto_utama' => 'storage/' . $pathUtama
            ]);
        }

        if ($request->hasFile('foto_lain')) {
            $fotoTambahanPaths = [];
            foreach ($request->file('foto_lain') as $index => $foto) {
                $namaFoto = "{$berita->id}_detail" . ($index + 1) . "." . $foto->getClientOriginalExtension();
                $pathFoto = $foto->storeAs('berita', $namaFoto, 'public');

                $fotoTambahanPaths[] = 'storage/' . $pathFoto;
            }

            $berita->update([
                'foto_tambahan' => json_encode($fotoTambahanPaths)
            ]);
        }

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil disimpan.');
    }

    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);

        if ($berita->foto_utama && file_exists(public_path($berita->foto_utama))) {
            unlink(public_path($berita->foto_utama));
        }
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
        $topiks = Topik::all();
        return view('admin.berita.edit', compact('berita', 'topiks'));
    }

    public function update(Request $request, $id)
    {
        $berita = Berita::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'isi_berita' => 'required|string',
            'topik_id' => 'required|exists:topik,id',
            'tanggal' => 'required|date',
            'status' => 'required|in:publikasi,draft',
            'foto_utama' => 'nullable|image',
            'foto_lain.*' => 'nullable|image',
        ]);

        $berita->update([
            'judul' => $request->judul,
            'isi_berita' => $request->isi_berita,
            'topik_id' => $request->topik_id,
            'tanggal' => $request->tanggal,
            'status' => $request->status,
        ]);

        if ($request->hasFile('foto_utama')) {
            if ($berita->foto_utama && file_exists(public_path($berita->foto_utama))) {
                unlink(public_path($berita->foto_utama));
            }

            $file = $request->file('foto_utama');
            $namaUtama = "{$berita->id}_utama." . $file->getClientOriginalExtension();
            $path = $file->storeAs('berita', $namaUtama, 'public');
            $berita->foto_utama = 'storage/' . $path;
        }

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
