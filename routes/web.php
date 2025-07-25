<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\Admin\DashboardController;



Route::get('/', function () {
    return view('landing');
});

Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');
Route::middleware(['auth:admin', IsAdmin::class])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});

Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/profile/sejarah', function () {return view('profile.sejarah');})->name('sejarah.index');
Route::get('informasi/agenda', function () {return view('informasi.agenda');})->name('agenda.index');