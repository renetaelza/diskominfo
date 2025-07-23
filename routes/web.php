<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BeritaController;

Route::get('/', function () {
    return view('landing');
});

Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
