<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bidang;

class LayananController extends Controller
{
    public function index_opendata()
    {
        return view('layanan.opendata');
    }
    public function index_kim()
    {
        return view('layanan.kim');
    }
    public function index_opd()
    {
        return view('layanan.opd');
    }
    public function index_lapor()
    {
        return view('layanan.lapor');
    }
    public function index_wbs()
    {
        return view('layanan.wbs');
    }
    public function index_csirt()
    {
        return view('layanan.csirt');
    }
    public function index_kunjungan()
    {

        $bidang = Bidang::all();
        return view('layanan.kunjungan', compact('bidang'));
    }
}
