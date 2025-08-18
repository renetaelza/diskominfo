<?php

namespace App\Http\Controllers;

use App\Models\Topik;
use Illuminate\Http\Request;

class TopikController extends Controller
{
    public function index()
    {
        $topiks = Topik::latest()->get();
        return view('admin.topik.index', compact('topiks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255'
        ]);

        Topik::create([
            'nama' => $request->nama
        ]);

        return back()->with('success', 'Topik berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255'
        ]);

        $topik = Topik::findOrFail($id);
        $topik->update(['nama' => $request->nama]);

        return back()->with('success', 'Topik berhasil diperbarui');
    }


    public function destroy($id)
    {
        $topik = Topik::findOrFail($id);
        $topik->delete();
        return back()->with('success', 'Topik berhasil dihapus');
    }
}
