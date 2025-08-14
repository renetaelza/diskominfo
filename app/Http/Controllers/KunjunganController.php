<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bidang;
use App\Models\Kunjungan;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class KunjunganController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_lengkap'      => 'required|string|max:255',
            'email'             => 'required|email',
            'nik'               => 'required|string|size:16',
            'instansi'          => 'required|string|max:255',
            'jabatan'           => 'required|string|max:255',
            'tanggal_kunjungan' => 'required|date|after_or_equal:today',
            'pukul_kunjungan'   => 'required',
            'tujuan'            => 'required|string',
            'bidang_id'         => 'required|exists:bidang,id',
        ]);

        try {
            // It's good practice to set the status here if it's not nullable
            // $validatedData['status'] = 'pending'; // For example
            Kunjungan::create($validatedData);
            
            // Redirect back to the form page with a success message
            return redirect()->back()->with('success', 'Pengajuan kunjungan Anda telah berhasil dikirim. Mohon tunggu konfirmasi selanjutnya.');

        } catch (\Exception $e) {
            // Log the error for debugging
            // \Log::error('Kunjungan submission error: ' . $e->getMessage());
            
            // Redirect back with a generic error message
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.')->withInput();
        }
    }
}