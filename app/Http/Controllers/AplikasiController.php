<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Bidang;
use App\Models\Aplikasi;

class AplikasiController extends Controller
{
    public function show($slug)
    {
        $aplikasi = Aplikasi::where('slug', $slug)->firstOrFail();

        return view("aplikasi.$slug", compact('aplikasi'));
    }

    public function index_kunjungan()
    {

        $bidang = Bidang::all();
        return view('aplikasi.kunjungan', compact('bidang'));
    }

    public function indexAdmin(Request $request)
    {
        return view('admin.aplikasi.indexNavigasi');
    }

    // GET
    public function get($judul)
    {
        $aplikasi = Aplikasi::where('judul', $judul)
        ->where('landing', false) // hanya ambil aplikasi non-landing
        ->first();
        
        if (!$aplikasi) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json($aplikasi);
    }

    // UPDATE
    public function update(Request $request)
    {
        $request->validate([
            'judul' => 'required|string',
            'tagline' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'subheading1' => 'nullable|string|max:255',
            'text1' => 'nullable|string',
            'subheading2' => 'nullable|string|max:255',
            'text2' => 'nullable|string',
            'subheading3' => 'nullable|string|max:255',
            'text3' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'link' => 'nullable|string|max:255'
        ]);

        $aplikasi = Aplikasi::where('judul', $request->judul)->firstOrFail();

        $aplikasi->tagline = $request->tagline;
        $aplikasi->deskripsi = $request->deskripsi;
        $aplikasi->subheading1 = $request->subheading1;
        $aplikasi->text1 = $request->text1;
        $aplikasi->subheading2 = $request->subheading2;
        $aplikasi->text2 = $request->text2;
        $aplikasi->subheading3 = $request->subheading3;
        $aplikasi->text3 = $request->text3;
        $aplikasi->link = $request->link;

        if ($request->hasFile('foto')) {
            if ($aplikasi->foto && Storage::exists(str_replace('storage/', '', $aplikasi->foto))) {
                Storage::delete(str_replace('storage/', '', $aplikasi->foto));
            }

            $foto = $request->file('foto');
            $namaFoto = "{$aplikasi->id}_utama." . $foto->getClientOriginalExtension();
            $pathFoto = $foto->storeAs('aplikasi', $namaFoto, 'public');

            $aplikasi->foto = 'storage/' . $pathFoto;
        }


        $aplikasi->save();

        return redirect()->back()->with('success', 'Data aplikasi berhasil diperbarui');
    }
}
