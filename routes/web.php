<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\TopikController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\AplikasiController;
use App\Http\Controllers\AplikasiLandingController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StrukturOrganisasiController;
use App\Http\Controllers\StrukturOrganisasiUserController;
use App\Http\Controllers\KunjunganController;
use App\Http\Controllers\Admin\AgendaController as AdminAgendaController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Api\CalendarController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriDokumenController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\PPIDController;
use App\Http\Controllers\ProfilPimpinanController;
use App\Http\Controllers\TupoksiController;
use App\Http\Controllers\VisiMisiController;
use App\Http\Controllers\Api\AvailabilityController;


//USER

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/api/weather', function () {
    // Cache data selama 10 menit (600 detik)
    return Cache::remember('weather_bandung', 600, function () {
        $apiKey = env('OPENWEATHER_API_KEY');
        if (!$apiKey) {
            return response()->json(['error' => 'API Key tidak ditemukan'], 500);
        }
        $response = Http::get("https://api.openweathermap.org/data/2.5/weather", [
            'q'     => 'Bandung,ID',
            'appid' => $apiKey,
            'units' => 'metric',
            'lang'  => 'id',
        ]);
        return $response->json();
    });
});

Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{id}', [BeritaController::class, 'show'])->name('berita.detail');

// Kunjungan
Route::post('/kunjungan', [KunjunganController::class, 'store'])->name('kunjungan.store');
Route::get('/aplikasi/kunjungan', [KunjunganController::class, 'index'])->name('kunjungan.index');
Route::get('/api/unavailable-times', [AvailabilityController::class, 'check']);

Route::get('/aplikasi/{slug}', [AplikasiController::class, 'show'])->name('aplikasi.show');

//PROFILE
Route::get('/profile/struktur-organisasi', [StrukturOrganisasiUserController::class, 'view'])->name('profile.strukturOrganisasi');
Route::get('/orgchart/page', function () {
    $pegawai = App\Models\Pegawai::with(['atasan', 'bidang', 'bawahan'])->get();

    $pegawai = $pegawai->map(function ($p) {
        if ($p->foto && Storage::disk('public')->exists('foto_pegawai/' . $p->foto)) {
            $path = Storage::disk('public')->path('foto_pegawai/' . $p->foto);
            $mime = mime_content_type($path);
            $base64 = base64_encode(file_get_contents($path));
            $p->foto_base64 = "data:$mime;base64,$base64";
        } else {
            $defaultPath = public_path('pictures/default-user.png');
            $mime = mime_content_type($defaultPath);
            $base64 = base64_encode(file_get_contents($defaultPath));
            $p->foto_base64 = "data:$mime;base64,$base64";
        }
        return $p;
    });

    return view('profile.orgchart-iframe', compact('pegawai'));
})->name('orgchart.page');

Route::get('/profile/sejarah', function () {
    return view('profile.sejarah');
})->name('sejarah.index');
Route::get('/profile/visimisi', [VisiMisiController::class, 'index'])->name('visimisi.index');
Route::get('/profile/visi-misi', [VisiMisiController::class, 'showPublic'])->name('showPublic');
Route::get('/profile/tupoksi', [TupoksiController::class, 'tupoksi'])->name('tupoksi');
Route::get('/profile/profil-pimpinan', [ProfilPimpinanController::class, 'showPublic'])->name('profile.show');

//INFORMASI
Route::get('/informasi/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');
Route::get('informasi/agenda', function () {
    return view('informasi.agenda');
})->name('agenda.index');
Route::get('/informasi/dokumen', [DokumenController::class, 'index'])->name('dokumen.index');

// GALERI
// galeri-video
Route::get('/galeri/video', [HomeController::class, 'indexVideoMain'])->name('main.galeri.video');

Route::get('/galeri/foto', [HomeController::class, 'indexFotoMain'])->name('main.galeri.foto');
Route::get('galeri/foto/{folder}', [HomeController::class, 'showFolder'])->name('main.galeri.folder.show');

// Public-facing API for FullCalendar
Route::get('/all-events', [CalendarController::class, 'index']);
Route::get('/public-events', [CalendarController::class, 'publicEvents']);
Route::get('/api/public-events', [CalendarController::class, 'publicEvents']);
Route::get('/api/nearest-agendas', [CalendarController::class, 'nearestAgendas']);

//PPID
Route::get('/ppid/{slug}', [PPIDController::class, 'show'])->name('ppid.show');
Route::get('/ppid/tentang/{slug}', [PPIDController::class, 'showText'])->name('ppid.show.text'); 

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

    //PENGUMUMAN
    Route::get('/pengumuman', [PengumumanController::class, 'indexAdmin'])->name('pengumuman.index');
    Route::get('/pengumuman/create', [PengumumanController::class, 'create'])->name('pengumuman.create');
    Route::post('/pengumuman', [PengumumanController::class, 'store'])->name('pengumuman.store');
    Route::delete('/pengumuman/{id}', [PengumumanController::class, 'destroy'])->name('pengumuman.destroy');
    Route::get('/pengumuman/{id}/edit', [PengumumanController::class, 'edit'])->name('pengumuman.edit');
    Route::put('/pengumuman/{id}', [PengumumanController::class, 'update'])->name('pengumuman.update');

    //BERITA
    Route::get('/berita', [BeritaController::class, 'indexAdmin'])->name('berita.index');
    Route::get('/berita/create', [BeritaController::class, 'create'])->name('berita.create');
    Route::post('/berita', [BeritaController::class, 'store'])->name('berita.store');
    Route::delete('/berita/{id}', [BeritaController::class, 'destroy'])->name('berita.destroy');
    Route::get('/berita/{id}/edit', [BeritaController::class, 'edit'])->name('berita.edit');
    Route::put('/berita/{id}', [BeritaController::class, 'update'])->name('berita.update');
    Route::get('/topik', [TopikController::class, 'index'])->name('topik.index');
    Route::post('/topik', [TopikController::class, 'store'])->name('topik.store');
    Route::put('/topik/{id}', [TopikController::class, 'update'])->name('topik.update');
    Route::delete('/topik/{id}', [TopikController::class, 'destroy'])->name('topik.destroy');


    //AGENDA
    Route::resource('agenda', AdminAgendaController::class);

    // PROFIL PIMPINAN
    Route::get('profil-pimpinan', [ProfilPimpinanController::class, 'edit'])->name('profil.edit');
    Route::put('profil-pimpinan', [ProfilPimpinanController::class, 'update'])->name('profil.update');

    // LAYANAN
    // navigasi
    Route::get('/aplikasi/navigasi', [AplikasiController::class, 'indexAdmin'])->name('aplikasi.indexNavigasi');
    Route::get('/aplikasi/navigasi/{judul}', [AplikasiController::class, 'get'])->name('aplikasi.get');
    Route::put('/aplikasi/navigasi/update', [AplikasiController::class, 'update'])->name('aplikasi.update');

    // landing
    Route::get('/aplikasi/landing', [AplikasiLandingController::class, 'indexAdmin'])->name('aplikasi.indexLanding');
    Route::post('/aplikasi/landing/store', [AplikasiLandingController::class, 'store'])->name('aplikasi.landing.store');
    Route::put('/aplikasi/landing/update', [AplikasiLandingController::class, 'update'])->name('aplikasi.landing.update');
    Route::delete('/aplikasi/landing/{aplikasi}', [AplikasiLandingController::class, 'destroy'])->name('aplikasi.landing.destroy');

    // Kunjungan
    Route::get('kunjungan', [App\Http\Controllers\Admin\AdminKunjunganController::class, 'index'])->name('kunjungan.index');
    Route::get('kunjungan/{kunjungan}', [App\Http\Controllers\Admin\AdminKunjunganController::class, 'show'])->name('kunjungan.show');
    Route::post('kunjungan/{kunjungan}/update-status', [App\Http\Controllers\Admin\AdminKunjunganController::class, 'updateStatus'])->name('kunjungan.updateStatus');
    Route::get('kunjungan/{kunjungan}/edit', [App\Http\Controllers\Admin\AdminKunjunganController::class, 'edit'])->name('kunjungan.edit');
    Route::put('kunjungan/{kunjungan}', [App\Http\Controllers\Admin\AdminKunjunganController::class, 'update'])->name('kunjungan.update');
    Route::delete('kunjungan/{kunjungan}', [App\Http\Controllers\Admin\AdminKunjunganController::class, 'destroy'])->name('kunjungan.destroy');

    //banner
    Route::get('/banner-utama', [BannerController::class, 'index'])->name('banner.index');
    Route::put('/banner-utama/update', [BannerController::class, 'update'])->name('banner.update');

    // gallery-video
    Route::get('/galeri/video', [GalleryController::class, 'indexVideo'])->name('galeri.video');
    Route::post('/galeri/video/store', [GalleryController::class, 'storeVideo'])->name('galeri.video.store');
    Route::put('/galeri/video/update', [GalleryController::class, 'updateVideo'])->name('galeri.video.update');
    Route::delete('/galeri/video/{video}', [GalleryController::class, 'destroy'])->name('galeri.video.destroy');

    // FOLDER (grup foto)
    Route::get('galeri/folders', [GalleryController::class, 'indexFolders'])->name('galeri.folders');
    Route::post('galeri/folders', [GalleryController::class, 'storeFolder'])->name('galeri.folders.store');
    Route::put('galeri/folders/{folder}', [GalleryController::class, 'updateFolder'])->name('galeri.folders.update');
    Route::delete('galeri/folders/{folder}', [GalleryController::class, 'destroyFolder'])->name('galeri.folders.destroy');

    // // FOTO dalam FOLDER
    Route::get('galeri/folders/{folder}', [GalleryController::class, 'showFolder'])->name('galeri.folders.show');
    Route::post('galeri/folders/{folder}/upload', [GalleryController::class, 'storePhoto'])->name('galeri.photos.store');
    Route::delete('galeri/folders/photos/{photo}', [GalleryController::class, 'destroyPhoto'])->name('galeri.photos.destroy');

    // dokumen informasi
    Route::get('/dokumen', [DokumenController::class, 'indexAdmin'])->name('dokumen.index');
    Route::get('/dokumen/create', [DokumenController::class, 'create'])->name('dokumen.create');
    Route::post('/dokumen', [DokumenController::class, 'store'])->name('dokumen.store');
    Route::delete('/dokumen/{id}', [DokumenController::class, 'destroy'])->name('dokumen.destroy');
    Route::get('/dokumen/{id}/edit', [DokumenController::class, 'edit'])->name('dokumen.edit');
    Route::put('/dokumen/{id}', [DokumenController::class, 'update'])->name('dokumen.update');
    Route::get('/kategori-dokumen', [KategoriDokumenController::class, 'index'])->name('kategoriDokumen.index');
    Route::post('/kategori-dokumen', [KategoriDokumenController::class, 'store'])->name('kategoriDokumen.store');
    Route::put('/kategori-dokumen/{id}', [KategoriDokumenController::class, 'update'])->name('kategoriDokumen.update');
    Route::delete('/kategori-dokumen/{id}', [KategoriDokumenController::class, 'destroy'])->name('kategoriDokumen.destroy');

    // Visi & Misi
    Route::get('visi-misi', [VisiMisiController::class, 'index'])->name('visimisi.index');
    Route::post('visi', [VisiMisiController::class, 'updateVision'])->name('vision.update');
    Route::post('misi', [VisiMisiController::class, 'storeMission'])->name('mission.store');
    Route::put('misi/{mission}', [VisiMisiController::class, 'updateMission'])->name('mission.update');
    Route::delete('misi/{mission}', [VisiMisiController::class, 'destroyMission'])->name('mission.destroy');

    //PPID
    Route::get('/ppid/tentang-ppid', [PPIDController::class, 'indexTentang'])->name('ppid.tentangPpid');
    Route::post('/ppid/tentang-ppid', [PPIDController::class, 'updatePage'])->name('ppid.tentangUpdate');
    Route::get('/ppid/tentang-ppid/{slug}', [PPIDController::class, 'getPage']);
    Route::post('/ppid/tentang-ppid/upload-image', [PPIDController::class, 'uploadImage'])->name('ppid.uploadImage');
    
    Route::get('/ppid/informasi-setiap-saat', [PPIDController::class, 'indexInformasiSetiapSaat'])->name('ppid.informasiSetiapSaat');
    Route::get('/ppid/informasi-berkala', [PPIDController::class, 'indexInformasiBerkala'])->name('ppid.informasiBerkala');
    Route::get('/ppid/informasi-serta-merta', [PPIDController::class, 'indexInformasiSertaMerta'])->name('ppid.informasiSertaMerta');
    Route::get('/ppid/informasi-dikecualikan', [PPIDController::class, 'indexInformasiDikecualikan'])->name('ppid.informasiDikecualikan');
    Route::post('/ppid/save', [PPIDController::class, 'storeOrUpdate'])->name('ppid.save');
    Route::get('/ppid/navigasi/{judul}', [PPIDController::class, 'getNavigasiData']);

    //Admin setting
    Route::get('/setting', [AdminSettingController::class, 'index'])->name('setting.index');
    Route::put('/setting/update', [AdminSettingController::class, 'update'])->name('setting.update');
});
