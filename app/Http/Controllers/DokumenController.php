<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\KategoriDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenController extends Controller
{
    public function index(Request $request)
    {
        $query = Dokumen::where('status', 'publikasi')
            ->orderByRaw('COALESCE(tanggal, created_at) DESC');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama_dokumen', 'like', "%$search%")
                ->orWhere('deskripsi_dokumen', 'like', "%$search%");
        }

        if ($request->filled('kategori')) {
            $query->where('kategoriDokumen_id', $request->kategori);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        $dokumens = $query->orderByDesc('tanggal')->paginate(10)->withQueryString();

        $kategoriDokumens = \App\Models\KategoriDokumen::whereHas('dokumens')->get();

        $tahunList = Dokumen::selectRaw('YEAR(COALESCE(tanggal, created_at)) as tahun')
            ->where('status', 'publikasi')
            ->groupBy('tahun')
            ->orderByDesc('tahun')
            ->pluck('tahun');

        return view('informasi.dokumen', compact('dokumens', 'kategoriDokumens', 'tahunList'));
    }

    public function indexAdmin(Request $request)
    {
        $query = Dokumen::query();

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_dokumen', 'like', "%{$request->q}%")
                    ->orWhere('deskripsi_dokumen', 'like', "%{$request->q}%");
            });
        }

        if ($request->filled('status')) {
            $query->whereIn('status', $request->status);
        }

        if ($request->filled('kategori')) {
            $query->whereIn('kategoriDokumen_id', $request->kategori);
        }

        $dokumens = $query->orderByDesc('tanggal')->paginate(10)->withQueryString();

        $kategoriDokumen = KategoriDokumen::all();

        return view('admin.dokumen.index', compact('dokumens', 'kategoriDokumen'));
    }

    public function create()
    {
        $kategoriDokumen = KategoriDokumen::all();
        return view('admin.dokumen.create', compact('kategoriDokumen'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'deskripsi_dokumen' => 'required|string',
            'kategoriDokumen_id' => 'required|exists:kategori_dokumen,id',
            'tanggal' => 'required|date',
            'status' => 'required|in:publikasi,draft',
            'lampiran.*' => 'nullable|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        $dokumen = Dokumen::create([
            'nama_dokumen' => $request->nama_dokumen,
            'deskripsi_dokumen' => $request->deskripsi_dokumen,
            'kategoriDokumen_id' => $request->kategoriDokumen_id,
            'tanggal' => $request->tanggal,
            'status' => $request->status,
            'lampiran' => json_encode([]),
        ]);

        $lampiranPaths = [];
        if ($request->hasFile('lampiran')) {
            foreach ($request->file('lampiran') as $file) {
                $originalName = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('lampiran_dokumen', $originalName, 'public');
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
        $kategoriDokumen = KategoriDokumen::all();
        return view('admin.dokumen.edit', compact('dokumen', 'kategoriDokumen'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_dokumen'       => 'required|string|max:255',
            'deskripsi_dokumen'  => 'required|string',
            'kategoriDokumen_id' => 'required|exists:kategori_dokumen,id',
            'tanggal'            => 'required|date',
            'status'             => 'required|in:publikasi,draft',
            'lampiran.*'         => 'nullable|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        $dokumen = Dokumen::findOrFail($id);

        $lampiranPaths = is_array($dokumen->lampiran)
            ? $dokumen->lampiran
            : json_decode($dokumen->lampiran ?? '[]', true);

        if ($request->filled('hapus_lampiran')) {
            $hapusLampiran = (array) $request->hapus_lampiran;
            foreach ($hapusLampiran as $relativePath) {
                Storage::disk('public')->delete($relativePath);
            }
            $lampiranPaths = array_values(array_diff($lampiranPaths, $hapusLampiran));
        }

        if ($request->hasFile('lampiran')) {
            foreach ($request->file('lampiran') as $file) {
                $originalName = preg_replace('/\s+/', '_', $file->getClientOriginalName());
                $filename = uniqid() . '_' . $originalName;
                $path = $file->storeAs('lampiran_dokumen', $filename, 'public');
                $lampiranPaths[] = $path;
            }
        }

        $dokumen->update([
            'nama_dokumen'       => $request->nama_dokumen,
            'deskripsi_dokumen'  => $request->deskripsi_dokumen,
            'kategoriDokumen_id' => $request->kategoriDokumen_id,
            'tanggal'            => $request->tanggal,
            'status'             => $request->status,
            'lampiran'           => json_encode(array_values($lampiranPaths)),
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
