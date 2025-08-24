<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mission;
use App\Models\Vision;

class VisiMisiController extends Controller
{
    /**
     * Menampilkan halaman Visi & Misi di sisi publik (frontend).
     */
    public function showPublic()
    {
        $vision = Vision::latest()->first();
        $missions = Mission::orderBy('id', 'asc')->get();
        return view('profile.visimisi', compact('vision', 'missions'));
    }

    /**
     * Menampilkan halaman manajemen Visi & Misi di admin panel.
     */
    public function index()
    {
        $vision = Vision::first(); // Ambil satu-satunya visi
        $missions = Mission::orderBy('id')->get(); // Ambil semua misi
        return view('admin.visimisi.index', compact('vision', 'missions'));
    }

    /**
     * Menyimpan atau memperbarui data Visi.
     */
    public function updateVision(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        // Gunakan updateOrCreate untuk membuat jika belum ada, atau update jika sudah ada.
        Vision::updateOrCreate(
            ['id' => 1], // Asumsi Visi selalu memiliki ID 1
            ['content' => $request->content]
        );

        return back()->with('success', 'Visi berhasil diperbarui.');
    }

    /**
     * Menyimpan Misi baru.
     */
    public function storeMission(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'icon_class' => 'required|string',
        ]);

        Mission::create($request->all());

        return back()->with('success', 'Misi baru berhasil ditambahkan.');
    }

    /**
     * Memperbarui data Misi yang sudah ada.
     */
    public function updateMission(Request $request, Mission $mission)
    {
        $request->validate([
            'content' => 'required|string',
            'icon_class' => 'required|string',
        ]);

        $mission->update($request->all());

        return back()->with('success', 'Misi berhasil diperbarui.');
    }

    /**
     * Menghapus Misi.
     */
    public function destroyMission(Mission $mission)
    {
        $mission->delete();
        return back()->with('success', 'Misi berhasil dihapus.');
    }
}

