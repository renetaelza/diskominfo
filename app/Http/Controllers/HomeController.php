<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengumuman;
use App\Models\Aplikasi;
use App\Models\Berita;
use App\Models\HeroBanner;
use App\Models\Videos;
use Illuminate\Support\Str;

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

         $latestVideos = Videos::latest()->take(3)->get()->map(function($video) {
            return [
                'title' => $video->title,
                'description' => Str::limit($video->description, 100),
                'youtubeId' => $video->youtube_id
            ];
        });

        return view('home', compact('pengumuman', 'aplikasi', 'semuaBerita', 'hero', 'latestVideos'));
    }

    public function indexVideoMain(Request $request)
    {
        // Cari satu video yang statusnya featured
        $featuredVideo = Videos::where('is_featured', true)->latest()->first();

        // Siapkan query untuk video lainnya
        $query = Videos::query();

        // Jika ada featured video, jangan tampilkan lagi di grid bawah
        if ($featuredVideo) {
            $query->where('id', '!=', $featuredVideo->id);
        }

        // Terapkan logika pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Ambil video lainnya dengan paginasi
        $videos = $query->orderBy('created_at', 'desc')->paginate(8); // Mungkin 8 lebih pas untuk grid 4 kolom

        // Kirim kedua variabel ke view
        return view('gallery.indexVideo', compact('featuredVideo', 'videos'));
    }
}
