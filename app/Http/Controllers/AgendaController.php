<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agenda;

class AgendaController extends Controller
{
     public function getEventsForCalendar()
    {
        $agendas = Agenda::all()->map(function ($agenda) {
            return [
                'title' => $agenda->nama_agenda,
                'start' => $agenda->tanggal->format('Y-m-d'),
                'extendedProps' => [
                    'location' => $agenda->lokasi,
                    'description' => $agenda->deskripsi,
                    'image' => $agenda->foto ? asset('storage/' . $agenda->foto) : 'https://via.placeholder.com/800x400',
                ]
            ];
        });

        return response()->json($agendas);
    }
}
