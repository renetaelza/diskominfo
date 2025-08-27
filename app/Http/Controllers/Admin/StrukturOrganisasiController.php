<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\Bidang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StrukturOrganisasiController extends Controller
{
    public function index(Request $request)
    {
        // Ambil nilai pencarian dari request
        $search = $request->input('search');

        // Query untuk mengambil data pegawai
        $query = Pegawai::with(['atasan', 'bidang'])
            ->when($search, function ($query, $search) {
                return $query->where('nama', 'like', "%{$search}%");
            });

        $pegawai = $query->latest()->get();

        // Deteksi jika request datang dari AJAX
        if ($request->ajax()) {
            return response()->json($pegawai);
        }
        
        // Ini akan dijalankan untuk permintaan non-AJAX (saat halaman dimuat pertama kali)
        $bidang = Bidang::all();
        $kepalaDinasId = $bidang->where('nama', 'Kepala Dinas')->first()?->id;

        return view('admin.strukturOrganisasi.index', compact('pegawai', 'bidang', 'kepalaDinasId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string',
            'nip' => 'required|unique:pegawai,nip',
            'bidang_id' => 'required|exists:bidang,id',
            'jabatan' => 'nullable|string',
            'atasan_id' => 'nullable|exists:pegawai,id',
            'alamat' => 'nullable|string',
            'tupoksi' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
            'is_assistant' => 'nullable|boolean',
        ]);

        $validated['is_assistant'] = filter_var($request->input('is_assistant'), FILTER_VALIDATE_BOOLEAN);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('foto_pegawai', 'public');
            $validated['foto'] = basename($path); // hanya simpan nama file saja
        }

        Pegawai::create($validated);

        return redirect()->route('admin.strukturOrganisasi.index')->with('success', 'Pegawai berhasil ditambahkan.');
    }

    public function update(Request $request, Pegawai $pegawai)
    {
        $validated = $request->validate([
            'nama' => 'required|string',
            'nip' => 'required|unique:pegawai,nip,' . $pegawai->id,
            'bidang_id' => 'required|exists:bidang,id',
            'jabatan' => 'nullable|string',
            'atasan_id' => 'nullable|exists:pegawai,id',
            'alamat' => 'nullable|string',
            'tupoksi' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
            'is_assistant' => 'nullable',
        ]);

        $validated['is_assistant'] = (bool) $request->input('is_assistant');

        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($pegawai->foto && Storage::disk('public')->exists('foto_pegawai/' . $pegawai->foto)) {
                Storage::disk('public')->delete('foto_pegawai/' . $pegawai->foto);
            }

            // Simpan foto baru
            $path = $request->file('foto')->store('foto_pegawai', 'public');
            $validated['foto'] = basename($path);
        }

        $pegawai->update($validated);

        return redirect()->route('admin.strukturOrganisasi.index')->with('success', 'Pegawai berhasil diupdate.');
    }

    public function destroy(Pegawai $pegawai)
    {
        if ($pegawai->foto && Storage::disk('public')->exists('foto_pegawai/' . $pegawai->foto)) {
            Storage::disk('public')->delete('foto_pegawai/' . $pegawai->foto);
        }

        $pegawai->delete();

        return redirect()->back()->with('success', 'Pegawai berhasil dihapus.');
    }
}
