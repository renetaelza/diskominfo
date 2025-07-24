<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\LayananController;

Route::get('/', function () {
    return view('landing');
});

Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');

Route::get('/layanan/opendata', [LayananController::class, 'index_opendata'])->name('opendata.index');
Route::get('/layanan/kim', [LayananController::class, 'index_kim'])->name('kim.index');
Route::get('/layanan/opd', [LayananController::class, 'index_opd'])->name('opd.index');
Route::get('/layanan/lapor', [LayananController::class, 'index_lapor'])->name('lapor.index');
Route::get('/layanan/wbs', [LayananController::class, 'index_wbs'])->name('wbs.index');
Route::get('/layanan/csirt', [LayananController::class, 'index_csirt'])->name('csirt.index');
