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
                'start' => $agenda->tanggal->format('Y-m-d'),
                'color' => '#f44336', // <-- Red for fully booked days
                'display' => 'background', // <-- Renders as a background highlight
                'allDay' => true, // <-- Mark as an all-day event
                'extendedProps' => [
                    'type' => 'agenda',
                ]
            ];
        });

        // 2. Fetch all APPROVED Kunjungan requests
        $kunjungans = Kunjungan::where('status', 'approved')->get()->map(function ($kunjungan) {
            return [
                'title' => 'Waktu Telah Dipesan', // Generic title for privacy
                'start' => $kunjungan->tanggal_kunjungan . ' ' . $kunjungan->pukul_kunjungan,
                'color' => '#ff9800', // Orange for booked visits
                'display' => 'background', // Renders as a background highlight
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
        // 1. Fetch all Agenda events with full details
        $agendas = Agenda::all()->map(function ($agenda) {
            return [
                'title' => $agenda->nama_agenda, // The real title
                'start' => $agenda->tanggal->format('Y-m-d'),
                'color' => '#2196f3', // Blue for agendas
                'extendedProps' => [
                    'type' => 'agenda',
                    'location' => $agenda->lokasi,
                    'description' => $agenda->deskripsi,
                    'image' => asset('storage/' . $agenda->foto)
                ]
            ];
        });

        // 2. Fetch all APPROVED Kunjungan requests as background events
        $kunjungans = Kunjungan::where('status', 'approved')->get()->map(function ($kunjungan) {
            return [
                'title' => 'Waktu Telah Dipesan',
                'start' => $kunjungan->tanggal_kunjungan . ' ' . $kunjungan->pukul_kunjungan,
                'color' => '#ff9800',
                'display' => 'background', // Display as background on public page
                'extendedProps' => ['type' => 'kunjungan']
            ];
        });
        
        // 3. Merge both collections
        $events = $agendas->concat($kunjungans);

        return response()->json($events);
    }
}
