<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\Admin\DashboardController;

//USER
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

Route::get('/profile/sejarah', function () {
    return view('profile.sejarah');
})->name('sejarah.index');
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


//ADMIN-BERITA
Route::get('/admin/berita', [BeritaController::class, 'indexAdmin'])->name('admin.berita.index');
Route::get('/admin/berita/create', [BeritaController::class, 'create'])->name('admin.berita.create');
Route::post('/admin/berita', [BeritaController::class, 'store'])->name('admin.berita.store');
Route::delete('/admin/berita/{id}', [BeritaController::class, 'destroy'])->name('admin.berita.destroy');
Route::get('/admin/berita/{id}/edit', [BeritaController::class, 'edit'])->name('admin.berita.edit');
Route::put('/admin/berita/{id}', [BeritaController::class, 'update'])->name('admin.berita.update');
