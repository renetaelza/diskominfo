<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\KunjunganStatusMail;

class AdminKunjunganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Start building the query
        $query = Kunjungan::query();

        // Apply search filter if 'q' is present
        if ($request->filled('q')) {
            $searchTerm = $request->input('q');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nama', 'like', "%{$searchTerm}%")
                  ->orWhere('nama_instansi', 'like', "%{$searchTerm}%");
            });
        }

        // Apply status filter if 'status' is present
        if ($request->filled('status') && is_array($request->status)) {
            $query->whereIn('status', $request->status);
        }

        // Order by the newest and paginate
        $kunjungans = $query->latest()->paginate(10)->withQueryString();

        return view('admin.kunjungan.index', compact('kunjungans'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Kunjungan $kunjungan)
    {
        return view('admin.kunjungan.show', compact('kunjungan'));
    }

    /**
     * Update the status of the specified resource in storage.
     */
    public function updateStatus(Request $request, Kunjungan $kunjungan)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $kunjungan->status = $request->status;
        $kunjungan->save();

        try {
            Mail::to($kunjungan->email)->send(new KunjunganStatusMail($kunjungan));
        
        } catch (\Exception $e) {
            // DEBUGGING: Hentikan kode dan tampilkan pesan error yang sebenarnya.
            dd($e->getMessage()); 
        }
        
        return redirect()->route('admin.kunjungan.show', $kunjungan)
                         ->with('success', 'Status kunjungan berhasil diperbarui dan email notifikasi telah dikirim.');
    }
}