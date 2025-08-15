<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\AplikasiController;
use App\Http\Controllers\AplikasiLandingController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StrukturOrganisasiController;
use App\Http\Controllers\StrukturOrganisasiUserController;
use App\Http\Controllers\KunjunganController;
use App\Http\Controllers\Admin\AgendaController as AdminAgendaController;
use App\Http\Controllers\AgendaController as PublicAgendaController;
use App\Http\Controllers\HomeController;

//USER

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/api/weather', function () {
    // Ambil API Key yang sudah aman dari file .env
    $apiKey = env('OPENWEATHER_API_KEY');

    // Jika API Key tidak ada, kembalikan error
    if (!$apiKey) {
        return response()->json(['error' => 'API Key tidak ditemukan'], 500);
    }

    // Gunakan nama kota untuk query yang lebih andal
    $cityQuery = 'Bandung,ID';

    // Panggil API OpenWeatherMap menggunakan HTTP Client Laravel
    $response = Http::get("https://api.openweathermap.org/data/2.5/weather", [
        'q'     => $cityQuery,
        'appid' => $apiKey,
        'units' => 'metric',
        'lang'  => 'id',
    ]);

    // Kembalikan hasil dari API sebagai response JSON
    return $response->json();
});

Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{id}', [BeritaController::class, 'show'])->name('berita.detail');

Route::get('/aplikasi/{slug}', [AplikasiController::class, 'show'])->name('aplikasi.show');

// Kunjungan
Route::post('/kunjungan', [KunjunganController::class, 'store'])->name('kunjungan.store');
Route::get('/aplikasi/kunjungan', [AplikasiController::class, 'index_kunjungan'])->name('kunjungan.index');

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

// Public-facing API for FullCalendar
Route::get('/api/agenda-events', [PublicAgendaController::class, 'getEventsForCalendar']);

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
    Route::get('/berita', [BeritaController::class, 'indexAdmin'])->name('berita.index');
    Route::get('/berita/create', [BeritaController::class, 'create'])->name('berita.create');
    Route::post('/berita', [BeritaController::class, 'store'])->name('berita.store');
    Route::delete('/berita/{id}', [BeritaController::class, 'destroy'])->name('berita.destroy');
    Route::get('/berita/{id}/edit', [BeritaController::class, 'edit'])->name('berita.edit');
    Route::put('/berita/{id}', [BeritaController::class, 'update'])->name('berita.update');

    //ADMIN-AGENDA
    Route::resource('agenda', AdminAgendaController::class);

    //ADMIN-LAYANAN
    // navigasi
    Route::get('/aplikasi/navigasi', [AplikasiController::class, 'indexAdmin'])->name('aplikasi.indexNavigasi');
    Route::get('/aplikasi/navigasi/{judul}', [AplikasiController::class, 'get'])->name('aplikasi.get');
    Route::put('/aplikasi/navigasi/update', [AplikasiController::class, 'update'])->name('aplikasi.update');

    // landing
    Route::get('/aplikasi/landing', [AplikasiLandingController::class, 'indexAdmin'])->name('aplikasi.indexLanding');
    Route::post('/aplikasi/landing/store', [AplikasiLandingController::class, 'store'])->name('aplikasi.landing.store');
    Route::put('/aplikasi/landing/update', [AplikasiLandingController::class, 'update'])->name('aplikasi.landing.update');
    Route::delete('/aplikasi/landing/{aplikasi}', [AplikasiLandingController::class, 'destroy'])->name('aplikasi.landing.destroy');
});
