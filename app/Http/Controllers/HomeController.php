<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengumuman;
use App\Models\Aplikasi;
use App\Models\Berita;
use App\Models\HeroBanner;

class HomeController extends Controller
{
    public function index()
    {
        $pengumuman = Pengumuman::where('status', 'publikasi')
            ->orderByRaw('COALESCE(tanggal, created_at) DESC')
            ->take(5)
            ->get();

        $aplikasi = Aplikasi::where('landing', true)->get();

        $semuaBerita = Berita::with('topik')
            ->where('status', 'publikasi')
            ->orderByRaw('COALESCE(tanggal, created_at) DESC')
            ->take(3)
            ->get();

        $hero = HeroBanner::first(); 

        return view('home', compact('pengumuman', 'aplikasi', 'semuaBerita', 'hero'));
    }
}
