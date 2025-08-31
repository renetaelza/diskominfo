<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PPID;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PPIDController extends Controller
{
    public function show($slug)
    {
        $dokumen = PPID::where('slug', $slug)->firstOrFail();
        return view("ppid.ppid-dokumen", compact('dokumen'));
    }

    // Tentang PPID

    public function showText($slug)
    {
        $text = PPID::where('slug', $slug)->firstOrFail();
        return view("ppid.ppid-text", compact('text'));
    }

    public function indexTentang()
    {
        return view('admin.ppid.tentangPpid');
    }

    public function getPage($slug)
    {
        $dokumen = PPID::where('slug', $slug)->first();
        return response()->json([
            'judul' => $dokumen->judul ?? '',
            'konten' => $dokumen->konten ?? ''
        ]);
    }

    public function updatePage(Request $request)
    {
        $request->validate([
            'judul' => 'required|string',
            'slug' => 'required|string',
            'content' => 'nullable|string',
        ]);

        PPID::updateOrCreate(
            ['slug' => $request->slug],
            [
                'judul'  => $request->judul,
                'konten' => $request->konten,
                'lampiran' => "[]",
                'tanggal'=> now()
            ]
        );

        return redirect()->back()->with('success', 'Halaman berhasil disimpan.');
    }

    public function uploadImage(Request $request)
    {
        // Validasi file image
        $request->validate([
            'upload' => 'required|image|max:2048' // max 2MB
        ]);

        // Simpan ke storage/public/ppid
        $path = $request->file('upload')->store('ppid', 'public');

        // Return response JSON sesuai CKEditor format
        return response()->json([
            'url' => asset('storage/' . $path)
        ]);
    }

    // END Tentang PPID

    public function indexInformasiSetiapSaat()
    {
        $dokumen = PPID::first();
        return view('admin.ppid.informasiSetiapSaat');
    }

    public function indexInformasiBerkala()
    {
        $dokumen = PPID::first();
        return view('admin.ppid.informasiBerkala');
    }
    public function indexInformasiSertaMerta()
    {
        $dokumen = PPID::first();
        return view('admin.ppid.informasiSertaMerta');
    }
    public function indexInformasiDikecualikan()
    {
        $dokumen = PPID::first();
        return view('admin.ppid.informasiDikecualikan');
    }

    public function getNavigasiData($judul)
    {
        $dokumen = PPID::where('judul', $judul)->first();
        if (!$dokumen) {
            return response()->json([
                'error' => 'Dokumen tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'id' => $dokumen->id,
            'judul' => $dokumen->judul,
            'lampiran' => json_decode($dokumen->lampiran, true) ?? [],
            'tanggal' => $dokumen->tanggal,
        ]);
    }

    public function storeOrUpdate(Request $request)
    {
        $request->validate([
            'judul'      => 'required|string',
            'lampiran.*' => 'nullable|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        $dokumen = PPID::where('judul', $request->judul)->first();

        if (!$dokumen) {
            $dokumen = new PPID();
            $lampiranPaths = [];
        } else {
            $lampiranPaths = json_decode($dokumen->lampiran ?? '[]', true);
        }

        if ($request->filled('hapus_lampiran')) {
            $hapusLampiran = (array) $request->hapus_lampiran;
            foreach ($hapusLampiran as $relativePath) {
                Storage::disk('public')->delete($relativePath);
            }
            $lampiranPaths = array_values(array_diff($lampiranPaths, $hapusLampiran));
        }

        if ($request->hasFile('lampiran')) {
            foreach ($request->file('lampiran') as $file) {
                $namaFile = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
                $path = $file->storeAs('ppid_dokumen', $namaFile, 'public');
                $lampiranPaths[] = $path;
            }
        }

        $dokumen->judul    = $request->judul;
        $dokumen->slug     = Str::slug($request->judul);
        $dokumen->lampiran = json_encode(array_values($lampiranPaths));

        if (!$dokumen->exists || !$dokumen->tanggal) {
            $dokumen->tanggal = now()->toDateString();
        }

        $dokumen->save();


        return redirect()->back()->with('success', 'Dokumen berhasil disimpan / diperbarui');
    }
}
