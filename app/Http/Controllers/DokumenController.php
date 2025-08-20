<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenController extends Controller
{
    public function index()
    {
        $dokumens = Dokumen::orderByRaw('COALESCE(tanggal, created_at) DESC')->get();
        return view('informasi.dokumen', compact('dokumens'));
    }

    public function indexAdmin(Request $request)
    {
        $query = Dokumen::latest();

        if ($request->filled('q')) {
            $query->where('nama_dokumen', 'like', '%' . $request->q . '%');
        }
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $dokumens = $query->paginate(10)->withQueryString();
        return view('admin.dokumen.index', compact('dokumens'));
    }

    public function create()
    {
        return view('admin.dokumen.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'deskripsi_dokumen' => 'required|string',
            'kategori' => 'required|string|max:100',
            'tanggal' => 'required|date',
            'lampiran.*' => 'required|mimes:pdf,doc,docx',
        ]);

        $dokumen = Dokumen::create([
            'nama_dokumen' => $request->nama_dokumen,
            'deskripsi_dokumen' => $request->deskripsi_dokumen,
            'kategori' => $request->kategori,
            'tanggal' => $request->tanggal,
            'total_unduh' => 0,
        ]);

        $lampiranPaths = [];
        if ($request->hasFile('lampiran')) {
            foreach ($request->file('lampiran') as $file) {
                $originalName = preg_replace('/\s+/', '_', $file->getClientOriginalName());
                $filename = uniqid() . '_' . $originalName;
                $path = $file->storeAs('lampiran_dokumen', $filename, 'public');
                $lampiranPaths[] = $path;
            }
        }

        $dokumen->lampiran = json_encode($lampiranPaths);
        $dokumen->save();

        return redirect()->route('admin.dokumen.index')->with('success', 'Dokumen berhasil disimpan.');
    }

    public function edit($id)
    {
        $dokumen = Dokumen::findOrFail($id);
        return view('admin.dokumen.edit', compact('dokumen'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'deskripsi_dokumen' => 'required|string',
            'kategori' => 'required|string|max:100',
            'tanggal' => 'required|date',
            'lampiran.*' => 'nullable|mimes:pdf,doc,docx,jpeg,png,jpg',
        ]);

        $dokumen = Dokumen::findOrFail($id);
        $lampiranPaths = json_decode($dokumen->lampiran ?? '[]', true);

        // Hapus lampiran lama
        if ($request->has('hapus_lampiran')) {
            foreach ($request->hapus_lampiran as $fileUrl) {
                $relativePath = str_replace('/storage/', '', parse_url($fileUrl, PHP_URL_PATH));
                Storage::disk('public')->delete($relativePath);
                $lampiranPaths = array_filter($lampiranPaths, fn($item) => $item !== $fileUrl);
            }
            $lampiranPaths = array_values($lampiranPaths);
        }

        // Tambah lampiran baru
        if ($request->hasFile('lampiran')) {
            foreach ($request->file('lampiran') as $file) {
                $originalName = preg_replace('/\s+/', '_', $file->getClientOriginalName());
                $filename = uniqid() . '_' . $originalName;
                $path = $file->storeAs('lampiran_dokumen', $filename, 'public');
                $lampiranPaths[] = $path;
            }
        }

        $dokumen->update([
            'nama_dokumen' => $request->nama_dokumen,
            'deskripsi_dokumen' => $request->deskripsi_dokumen,
            'kategori' => $request->kategori,
            'tanggal' => $request->tanggal,
            'lampiran' => json_encode($lampiranPaths),
        ]);

        return redirect()->route('admin.dokumen.index')->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $dokumen = Dokumen::findOrFail($id);

        if ($dokumen->lampiran) {
            foreach (json_decode($dokumen->lampiran, true) as $file) {
                Storage::disk('public')->delete($file);
            }
        }

        $dokumen->delete();
        return redirect()->route('admin.dokumen.index')->with('success', 'Dokumen berhasil dihapus.');
    }
}
