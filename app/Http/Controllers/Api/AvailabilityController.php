<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AvailabilityController extends Controller
{
    public function check(Request $request)
    {
        $request->validate(['date' => 'required|date_format:Y-m-d', 'ignore_id' => 'nullable|integer']);

        $date = Carbon::parse($request->date);

        // Check for an all-day Agenda event
        $isAgendaDay = Agenda::whereDate('tanggal', $date)->exists();

        if ($isAgendaDay) {
            return response()->json([
                'is_unavailable' => true,
                'unavailable_times' => []
            ]);
        }

        // Bangun query untuk Kunjungan
        $query = Kunjungan::where('status', 'approved')
            ->whereDate('tanggal_kunjungan', $date);

        // Jika ada ID yang harus diabaikan, tambahkan ke query
        if ($request->filled('ignore_id')) {
            $query->where('id', '!=', $request->input('ignore_id'));
        }

        $bookedTimes = $query->pluck('pukul_kunjungan')
            ->map(fn($time) => Carbon::parse($time)->format('H:i'))
            ->toArray();

        return response()->json([
            'is_unavailable' => false,
            'unavailable_times' => $bookedTimes
        ]);
    }
}
