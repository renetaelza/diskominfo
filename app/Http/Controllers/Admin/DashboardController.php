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

        return view('admin.dashboard', compact(
            'totalAgenda'
        ));
    }
}
