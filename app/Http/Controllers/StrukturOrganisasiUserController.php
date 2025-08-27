<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\Bidang;
use Illuminate\Support\Facades\Storage;

class StrukturOrganisasiUserController extends Controller
{
    public function view()
    {
        $pegawai = Pegawai::with(['atasan', 'bidang', 'bawahan'])->get();
        return view('profile.strukturOrganisasi', compact('pegawai'));
    }
}
