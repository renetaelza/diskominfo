<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StrukturOrganisasiController;
use App\Http\Controllers\StrukturOrganisasiUserController;

//USER
Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{id}', [BeritaController::class, 'show'])->name('berita.detail');

Route::get('/layanan/opendata', [LayananController::class, 'index_opendata'])->name('opendata.index');
Route::get('/layanan/kim', [LayananController::class, 'index_kim'])->name('kim.index');
Route::get('/layanan/opd', [LayananController::class, 'index_opd'])->name('opd.index');
Route::get('/layanan/lapor', [LayananController::class, 'index_lapor'])->name('lapor.index');
Route::get('/layanan/wbs', [LayananController::class, 'index_wbs'])->name('wbs.index');
Route::get('/layanan/csirt', [LayananController::class, 'index_csirt'])->name('csirt.index');

//PROFILE
Route::get('/profile/struktur-organisasi', [StrukturOrganisasiUserController::class, 'view'])->name('profile.strukturOrganisasi');
Route::get('/profile/sejarah', function () {
    return view('profile.sejarah');
})->name('sejarah.index');

//INFORMASI
Route::get('/informasi/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');
Route::get('informasi/agenda', function () {
    return view('informasi.agenda');
})->name('agenda.index');

//ADMIN
Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');
Route::middleware(['auth:admin', IsAdmin::class])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});


Route::prefix('admin')->name('admin.')->middleware(['auth:admin', IsAdmin::class])->group(function () {
    // Pegawai
    Route::get('/struktur-organisasi', [StrukturOrganisasiController::class, 'index'])->name('strukturOrganisasi.index');
    Route::post('/struktur-organisasi', [StrukturOrganisasiController::class, 'store'])->name('strukturOrganisasi.store');
    Route::put('/struktur-organisasi/edit-pegawai/{pegawai}', [StrukturOrganisasiController::class, 'update'])->name('strukturOrganisasi.update');
    Route::delete('/struktur-organisasi/{pegawai}', [StrukturOrganisasiController::class, 'destroy'])->name('strukturOrganisasi.destroy');

    //ADMIN-PENGUMUMAN
    Route::get('/pengumuman', [PengumumanController::class, 'indexAdmin'])->name('pengumuman.index');
    Route::get('/pengumuman/create', [PengumumanController::class, 'create'])->name('pengumuman.create');
    Route::post('/pengumuman', [PengumumanController::class, 'store'])->name('pengumuman.store');
    Route::delete('/pengumuman/{id}', [PengumumanController::class, 'destroy'])->name('pengumuman.destroy');
    Route::get('/pengumuman/{id}/edit', [PengumumanController::class, 'edit'])->name('pengumuman.edit');
    Route::put('/pengumuman/{id}', [PengumumanController::class, 'update'])->name('pengumuman.update');

    //ADMIN-BERITA
    Route::get('/admin/berita', [BeritaController::class, 'indexAdmin'])->name('berita.index');
    Route::get('/admin/berita/create', [BeritaController::class, 'create'])->name('berita.create');
    Route::post('/admin/berita', [BeritaController::class, 'store'])->name('berita.store');
    Route::delete('/admin/berita/{id}', [BeritaController::class, 'destroy'])->name('berita.destroy');
    Route::get('/admin/berita/{id}/edit', [BeritaController::class, 'edit'])->name('berita.edit');
    Route::put('/admin/berita/{id}', [BeritaController::class, 'update'])->name('berita.update');
});
