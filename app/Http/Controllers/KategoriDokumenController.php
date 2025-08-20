<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriDokumen;

class KategoriDokumenController extends Controller
{
    public function index()
    {
        $kategoriDokumen = KategoriDokumen::latest()->get();
        return view('admin.kategoriDokumen.index', compact('kategoriDokumen'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255'
        ]);

        KategoriDokumen::create([
            'nama' => $request->nama
        ]);

        return back()->with('success', 'Kategoriberhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255'
        ]);

        $kategoriDokumen = KategoriDokumen::findOrFail($id);
        $kategoriDokumen->update(['nama' => $request->nama]);

        return back()->with('success', 'Kategori berhasil diperbarui');
    }


    public function destroy($id)
    {
        $kategoriDokumen = KategoriDokumen::findOrFail($id);
        $kategoriDokumen->delete();
        return back()->with('success', 'Kategori berhasil dihapus');
    }
}
