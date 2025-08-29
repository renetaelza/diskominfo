<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Berita;
use App\Models\Pengumuman;
use App\Models\Agenda;
use App\Models\Kunjungan;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAgenda = Agenda::count();
        $totalKunjungan = Kunjungan::count();
        $totalBerita = Berita::count();
        $totalPengumuman = Pengumuman::count();

        $recentKunjungans = Kunjungan::where('status', 'pending')
                                     ->latest()
                                     ->take(5)
                                     ->get();

        return view('admin.dashboard', [
            'totalBerita' => $totalBerita,
            'totalPengumuman' => $totalPengumuman,
            'totalAgenda' => $totalAgenda,
            'totalKunjungan' => $totalKunjungan,
            'recentKunjungans' => $recentKunjungans,
        ]);
    }
}
