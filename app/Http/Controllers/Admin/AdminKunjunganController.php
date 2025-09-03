<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\Bidang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\KunjunganStatusMail;
use App\Mail\KunjunganRescheduledMail;
use Illuminate\Validation\Rule;

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

        // NEW: Date Range Filter
        if ($request->filled('date_from')) {
            $query->whereDate('tanggal_kunjungan', '>=', $request->input('date_from'));
        }
        if ($request->filled('date_to')) {
            $query->whereDate('tanggal_kunjungan', '<=', $request->input('date_to'));
        }

        // NEW: Sorting Logic
        $sortBy = $request->input('sort_by', 'created_at'); // Default sort column
        $sortDirection = $request->input('sort_direction', 'desc'); // Default sort direction

        // Whitelist of sortable columns to prevent errors
        $sortableColumns = ['nama', 'tanggal_kunjungan', 'status', 'created_at'];
        if (in_array($sortBy, $sortableColumns)) {
            $query->orderBy($sortBy, $sortDirection);
        }

        $kunjungans = $query->paginate(10)->withQueryString();

        return view('admin.kunjungan.index', compact('kunjungans', 'sortBy', 'sortDirection'));
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

    public function edit(Kunjungan $kunjungan)
    {
        $bidang = Bidang::all();
        return view('admin.kunjungan.edit', compact('kunjungan', 'bidang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kunjungan $kunjungan)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'nama_instansi' => 'required|string|max:255',
            'tanggal_kunjungan' => ['required', 'date'],
            'pukul_kunjungan' => [
                'required',
                Rule::unique('kunjungan')->ignore($kunjungan->id)->where(function ($query) use ($request) {
                    return $query->where('tanggal_kunjungan', $request->tanggal_kunjungan)
                                 ->where('status', 'approved');
                }),
            ],
            'topik_diskusi' => 'required|string',
            'bidang_ids'   => 'required|array',
            'bidang_ids.*' => 'integer|exists:bidang,id',
        ], [
            'pukul_kunjungan.unique' => 'Jadwal pada tanggal dan waktu ini sudah dipesan. Silakan pilih waktu lain.'
        ]);

        $oldDate = $kunjungan->getOriginal('tanggal_kunjungan');
        $oldTime = $kunjungan->getOriginal('pukul_kunjungan');
        $isRescheduled = $kunjungan->tanggal_kunjungan->format('Y-m-d') != $request->tanggal_kunjungan || $kunjungan->pukul_kunjungan != $request->pukul_kunjungan . ':00';

        // Update data kunjungan
        $kunjungan->update([
            'nama' => $validatedData['nama'],
            'nama_instansi' => $validatedData['nama_instansi'],
            'tanggal_kunjungan' => $validatedData['tanggal_kunjungan'],
            'pukul_kunjungan' => $validatedData['pukul_kunjungan'],
            'topik_diskusi' => $validatedData['topik_diskusi'],
            'status' => 'approved' // Otomatis setujui saat di-reschedule
        ]);

        $kunjungan->bidangs()->sync($validatedData['bidang_ids']);

        // Jika dijadwalkan ulang, kirim email reschedule
        if ($isRescheduled) {
            try {
                Mail::to($kunjungan->email)->send(new KunjunganRescheduledMail($kunjungan, $oldDate, $oldTime));
            } catch (\Exception $e) {
                return redirect()->route('admin.kunjungan.index')->with('error', 'Kunjungan berhasil diupdate, tetapi notifikasi email gagal dikirim.');
            }
        }

        return redirect()->route('admin.kunjungan.index')->with('success', 'Kunjungan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kunjungan $kunjungan)
    {
        $kunjungan->delete();
        return redirect()->route('admin.kunjungan.index')->with('success', 'Pengajuan kunjungan berhasil dihapus.');
    }
}