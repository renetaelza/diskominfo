<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

use App\Models\Pengumuman;
use App\Models\Bidang;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumumans = Pengumuman::where('status', 'publikasi')
            ->orderByRaw('COALESCE(tanggal, created_at) DESC')
            ->get();

        return view('informasi.pengumuman', compact('pengumumans'));
    }

    public function indexAdmin(Request $request)
    {
        $query = Pengumuman::with('kategori')->latest();
        if ($request->filled('q')) {
            $query->where('judul', 'like', '%' . $request->q . '%');
        }
        if ($request->has('status')) {
            $query->whereIn('status', $request->status);
        }
        if ($request->has('bidang')) {
            $query->whereIn('kategori_id', $request->bidang);
        }
        $pengumumans = $query->paginate(10)->withQueryString();
        $bidang = Bidang::all();

        return view('admin.pengumuman.index', compact('pengumumans', 'bidang'));
    }


    public function create()
    {
        $bidang = Bidang::all();
        return view('admin.pengumuman.create', compact('bidang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi_pengumuman' => 'required|string',
            'kategori_id' => 'required|exists:bidang,id',
            'tanggal' => 'required|date',
            'status' => 'required|in:publikasi,draft',
            'lampiran.*' => 'nullable|mimes:pdf,doc,docx,jpeg,png,jpg',
        ]);

        $pengumuman = Pengumuman::create([
            'judul' => $request->judul,
            'isi_pengumuman' => $request->isi_pengumuman,
            'kategori_id' => $request->kategori_id,
            'tanggal' => $request->tanggal,
            'status' => $request->status,
            'views' => 0,
        ]);

        $lampiranPaths = [];

        if ($request->hasFile('lampiran')) {
            foreach ($request->file('lampiran') as $file) {
                $originalName = $file->getClientOriginalName();
                $path = $file->storeAs('lampiran_pengumuman', $originalName, 'public');
                $lampiranPaths[] = $path;
            }
        }

        $pengumuman->lampiran = json_encode($lampiranPaths);
        $pengumuman->save();

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil disimpan.');
    }


    public function destroy($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);

        // Hapus foto utama jika ada
        if ($pengumuman->foto_utama && file_exists(public_path($pengumuman->foto_utama))) {
            unlink(public_path($pengumuman->foto_utama));
        }

        // Hapus foto tambahan jika ada
        if ($pengumuman->foto_tambahan) {
            foreach (json_decode($pengumuman->foto_tambahan) as $foto) {
                if (file_exists(public_path($foto))) {
                    unlink(public_path($foto));
                }
            }
        }

        $pengumuman->delete();

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil dihapus.');
    }

    public function edit($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        $bidang = Bidang::all();

        return view('admin.pengumuman.edit', compact('pengumuman', 'bidang'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi_pengumuman' => 'required|string',
            'kategori_id' => 'required|exists:bidang,id',
            'tanggal' => 'required|date',
            'status' => 'required|in:publikasi,draft',
            'lampiran.*' => 'nullable|mimes:pdf,doc,docx,jpeg,png,jpg',
        ]);

        $pengumuman = Pengumuman::findOrFail($id);
        $lampiranPaths = json_decode($pengumuman->lampiran ?? '[]', true);

        // Hapus lampiran yang dicentang
        if ($request->has('hapus_lampiran')) {
            foreach ($request->hapus_lampiran as $fileUrl) {
                $relativePath = str_replace('/storage/', '', parse_url($fileUrl, PHP_URL_PATH));
                Storage::disk('public')->delete($relativePath);
                $lampiranPaths = array_filter($lampiranPaths, fn($item) => $item !== $fileUrl);
            }
            $lampiranPaths = array_values($lampiranPaths);
        }


        // ✅ Upload lampiran baru
        if ($request->hasFile('lampiran')) {
            foreach ($request->file('lampiran') as $file) {
                $originalName = $file->getClientOriginalName();
                $originalName = preg_replace('/\s+/', '_', $originalName);
                $originalName = preg_replace('/\.+(\.[a-z0-9]+)$/i', '$1', $originalName);
                $filename = uniqid() . '_' . $originalName;
                $path = $file->storeAs('lampiran_pengumuman', $filename, 'public');
                $lampiranPaths[] = $path;
            }
        }

        // Update data
        $pengumuman->update([
            'judul' => $request->judul,
            'isi_pengumuman' => $request->isi_pengumuman,
            'kategori_id' => $request->kategori_id,
            'tanggal' => $request->tanggal,
            'status' => $request->status,
            'lampiran' => json_encode($lampiranPaths),
        ]);

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }
}
