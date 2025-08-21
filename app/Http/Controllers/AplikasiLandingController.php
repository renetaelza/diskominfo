<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aplikasi;
use Illuminate\Support\Facades\Storage;

class AplikasiLandingController extends Controller
{
    public function indexAdmin()
    {
        $aplikasi = Aplikasi::where('landing', true)->get();
        return view('admin.aplikasi.indexLanding', compact('aplikasi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'link' => 'required|url',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Buat instance Aplikasi baru
        $aplikasi = new Aplikasi();
        $aplikasi->judul = $request->judul;
        $aplikasi->link = $request->link;
        $aplikasi->slug = ''; // Set statis ke true
        $aplikasi->tagline = ''; // Set statis ke true
        $aplikasi->landing = true; // Set statis ke true
        $aplikasi->save(); // Simpan dulu agar ID tersedia

        // Upload foto
        if ($request->hasFile('foto')) {
            if ($aplikasi->foto && Storage::exists(str_replace('storage/', '', $aplikasi->foto))) {
                Storage::delete(str_replace('storage/', '', $aplikasi->foto));
            }

            $foto = $request->file('foto');
            $namaFoto = "{$aplikasi->id}_landing." . $foto->getClientOriginalExtension();
            $pathFoto = $foto->storeAs('aplikasi', $namaFoto, 'public');

            $aplikasi->foto = 'storage/' . $pathFoto;
            $aplikasi->save();
        }

        return redirect()->back()->with('success', 'Aplikasi berhasil ditambahkan.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:aplikasi,id',
            'judul' => 'required|string|max:255',
            'link' => 'required|url',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $aplikasi = Aplikasi::findOrFail($request->id);
        $aplikasi->judul = $request->judul;
        $aplikasi->link = $request->link;
        $aplikasi->save();

        if ($request->hasFile('foto')) {
            if ($aplikasi->foto && Storage::exists(str_replace('storage/', '', $aplikasi->foto))) {
                Storage::delete(str_replace('storage/', '', $aplikasi->foto));
            }

            $foto = $request->file('foto');
            $namaFoto = "{$aplikasi->id}_landing." . $foto->getClientOriginalExtension();
            $pathFoto = $foto->storeAs('aplikasi', $namaFoto, 'public');
            $aplikasi->foto = 'storage/' . $pathFoto;
            $aplikasi->save();
        }

        return redirect()->route('admin.aplikasi.indexLanding')
                        ->with('success', 'Aplikasi berhasil diperbarui.');
    }

    public function destroy(Aplikasi $aplikasi)
    {
        // Hapus foto jika ada
        if ($aplikasi->foto && Storage::exists(str_replace('storage/', '', $aplikasi->foto))) {
            Storage::delete(str_replace('storage/', '', $aplikasi->foto));
        }

        $aplikasi->delete();

        return redirect()->route('admin.aplikasi.indexLanding')
                        ->with('success', 'Aplikasi berhasil dihapus.');
    }
}
