<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bidang;
use App\Models\Kunjungan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use App\Rules\ValidKunjunganDate;

class KunjunganController extends Controller
{
    public function index()
    {
        $bidang = Bidang::all();
        return view('aplikasi.kunjungan', compact('bidang'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'nama_instansi' => 'required|string|max:255',
            'nomor_hp' => 'required|string|max:20',
            'email' => 'required|email',
            'kab_kota' => 'required|string|max:255',
            'alamat_instansi' => 'required|string',
            'tanggal_kunjungan' => ['required', 'date', 'after_or_equal:today', new ValidKunjunganDate()],
            'topik_diskusi' => 'required|string',
            'jumlah_rombongan' => 'required|integer|min:1',
            'no_surat' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'surat_permohonan' => 'required|file|mimes:pdf|max:2048',
            'bidang_ids'   => 'required|array',
            'bidang_ids.*' => 'integer|exists:bidang,id',
            
            // 2. Add Custom Validation Rule for Time Slot Uniqueness
            'pukul_kunjungan' => [
                'required',
                Rule::unique('kunjungan')->where(function ($query) use ($request) {
                    return $query->where('tanggal_kunjungan', $request->tanggal_kunjungan)
                                 ->where('status', 'approved');
                }),
            ],
        ], [
            // 3. Add custom error message
            'pukul_kunjungan.unique' => 'Jadwal pada tanggal dan waktu ini sudah dipesan. Silakan pilih waktu lain.'
        ]);

        try {
            DB::transaction(function () use ($request, $validatedData) {
                // Prepare data for the Kunjungan model by excluding the relationship data.
                $kunjunganData = collect($validatedData)->except('bidang_ids')->toArray();

                // Handle file upload
                if ($request->hasFile('surat_permohonan')) {
                    $path = $request->file('surat_permohonan')->store('surat_kunjungan', 'public');
                    $kunjunganData['surat_permohonan'] = $path;
                }
                
                // 1. Create the Kunjungan using the filtered data.
                $kunjungan = Kunjungan::create($kunjunganData);

                // 2. Sync the relationship using the validated IDs.
                $kunjungan->bidangs()->sync($validatedData['bidang_ids']);
            });

            return redirect()->back()->with('success', 'Pengajuan kunjungan Anda telah berhasil dikirim.');
        } catch (\Exception $e) {
            Log::error('Kunjungan submission error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.')->withInput();
        }
    }
}