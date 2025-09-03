<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\profilPimpinan;
use Illuminate\Support\Facades\Storage;

class ProfilPimpinanController extends Controller
{
    /**
     * Menampilkan halaman profil pimpinan untuk publik.
     */
    public function showPublic()
    {
        // Ambil data profil, atau buat data kosong jika belum ada
        $profile = profilPimpinan::firstOrNew();
        return view('profile.profilPimpinan', compact('profile'));
    }

    /**
     * Menampilkan form edit profil di halaman admin.
     */
    public function edit()
    {
        // Ambil data profil, atau buat data kosong jika belum ada
        $profile = profilPimpinan::firstOrNew(['id' => 1]);
        return view('admin.profilPimpinan.edit', compact('profile'));
    }

    /**
     * Memperbarui data profil dari form admin.
     */
    public function update(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'title' => 'required|string|max:255',
        'welcome_message' => 'required|string',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);

    // Ambil data profil yang ada untuk mengecek foto lama
    $profile = profilPimpinan::firstOrNew(['id' => 1]);

    // Logika untuk upload foto
    if ($request->hasFile('photo')) {
        // Hapus foto lama jika ada
        if ($profile->photo_path) {
            Storage::disk('public')->delete($profile->photo_path);
        }
        // Simpan foto baru dan tambahkan path-nya ke data yang akan disimpan
        $path = $request->file('photo')->store('profile_photos', 'public');
        $validatedData['photo_path'] = $path;
    }
    
    // Gunakan updateOrCreate.
    // Ini akan mencari profil dengan id=1, lalu meng-update-nya dengan $validatedData.
    // Jika tidak ada, ia akan membuat record baru dengan gabungan id=1 dan $validatedData.
    profilPimpinan::updateOrCreate(['id' => 1], $validatedData);

    return back()->with('success', 'Profil Pimpinan berhasil diperbarui.');
}
}
