<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agenda;
use App\Models\Kunjungan;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function index()
    {
        // 1. Fetch all Agenda events
        $agendas = Agenda::all()->map(function ($agenda) {
            return [
                'title' => 'Fully Booked',
                'start' => Carbon::parse($agenda->tanggal)->toDateString(),
                'color' => '#f44336', // Merah untuk fully booked
                'display' => 'background',
                'allDay' => true,
                'extendedProps' => [
                    'type' => 'agenda',
                ]
            ];
        });

        // 2. Fetch all APPROVED Kunjungan requests
        $kunjungans = Kunjungan::where('status', 'approved')->get()->map(function ($kunjungan) {
            $date = Carbon::parse($kunjungan->tanggal_kunjungan)->format('Y-m-d');
            $time = $kunjungan->pukul_kunjungan;

            return [
                'title' => 'Waktu Telah Dipesan',
                'start' => Carbon::parse($date . ' ' . $time)->toIso8601String(),
                'color' => '#ff9800', // Oranye untuk kunjungan
                'display' => 'background',
                'extendedProps' => [
                    'type' => 'kunjungan'
                ]
            ];
        });

        // 3. Merge both collections
        $events = $agendas->concat($kunjungans);

        return response()->json($events);
    }

    public function publicEvents()
    {
        // 1. Fetch all Agenda events dengan detail lengkap
        $agendas = Agenda::all()->map(function ($agenda) {
            return [
                'title' => $agenda->nama_agenda,
                'start' => Carbon::parse($agenda->tanggal)->toDateString(),
                'color' => '#18417F', // Biru untuk agenda publik
                'extendedProps' => [
                    'type' => 'agenda',
                    'location' => $agenda->lokasi,
                    'description' => $agenda->deskripsi,
                    'image' => asset('storage/' . $agenda->foto)
                ]
            ];
        });

        // 2. Fetch all APPROVED Kunjungan requests sebagai background
        $kunjungans = Kunjungan::where('status', 'approved')->get()->map(function ($kunjungan) {
            $date = Carbon::parse($kunjungan->tanggal_kunjungan)->format('Y-m-d');
            $time = $kunjungan->pukul_kunjungan;

            return [
                'title' => 'Waktu Telah Dipesan',
                'start' => Carbon::parse($date . ' ' . $time)->toIso8601String(),
                'color' => '#ff9800',
                'display' => 'background',
                'extendedProps' => ['type' => 'kunjungan']
            ];
        });

        // 3. Merge both collections
        $events = $agendas->concat($kunjungans);

        return response()->json($events);
    }

    public function nearestAgendas()
    {
        $agendas = Agenda::whereDate('tanggal', '>=', now()) // hanya yang akan datang
            ->orderBy('tanggal', 'asc')
            ->take(3)
            ->get();

        return response()->json($agendas);
    }
}
