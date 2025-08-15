<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengumuman;
use App\Models\Aplikasi;

class HomeController extends Controller
{
     public function index()
    {
        $pengumuman = Pengumuman::where('status', 'publikasi')
            ->orderByRaw('COALESCE(tanggal, created_at) DESC')
            ->take(5)
            ->get();
        
        $aplikasi = Aplikasi::where('landing', true)->get();
        return view('home', compact('pengumuman', 'aplikasi'));
    }
}
