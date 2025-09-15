@extends('layouts.app')

@section('title', 'Beranda - Dinas Komunikasi dan Informatika Kota Bandung')

@section('content')

    <!-- =================================================================== -->
    <!-- 1. HERO & SLIDER SECTION-->
    <!-- =================================================================== -->
    {{-- Wadah utama hero dibuat relative untuk menjadi acuan posisi slider --}}
    <header class="relative bg-gray-800 text-white">
        {{-- Gambar Latar --}}
        <img src="{{ ($hero && $hero->img_banner) ? asset('storage/' . $hero->img_banner) : asset('pictures/hero_landing.png') }}"
             alt="Gedung Diskominfo Bandung"
             class="absolute inset-0 w-full h-full object-cover opacity-20 z-0">
        {{-- Overlay Gradient untuk Kontras Teks yang Lebih Baik --}}
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/70 to-transparent"></div>

        <div class="relative z-10 container mx-auto px-6 sm:px-8 lg:px-16 flex flex-col justify-center min-h-[90vh] w-full space-y-10 pt-24 pb-32 sm:pb-40 md:pb-48">
            <!-- Konten Hero (H1, tagline, jam, cuaca, tombol) -->
            <div class="flex flex-col lg:flex-row justify-between lg:items-center w-full gap-8 md:mt-40">
                <div class="lg:w-2/3 text-left">
                    <h1 class="text-4xl lg:text-6xl font-extrabold tracking-tight">
                        DINAS KOMUNIKASI DAN INFORMATIKA <span class="text-orange-400">KOTA BANDUNG</span>
                    </h1>
                    <p class="mt-4 text-lg text-gray-200 max-w-2xl">
                        {{ $hero->tagline ?? 'Menyajikan Informasi dan Layanan Digital Terdepan untuk Warga Kota Bandung.' }}
                    </p>
                </div>
                <div class="mt-6 lg:mt-0 flex flex-col items-center lg:items-end gap-3 text-lg font-semibold text-gray-200 backdrop-blur-sm bg-gray-600/20 border-[0.5px] border-gray-400/30 p-4 rounded-lg">
                    <div id="live-clock" class="flex items-center gap-3"><i class="far fa-clock text-xl text-orange-400"></i><span class="w-32">Memuat...</span></div>
                    <div id="weather-info" class="flex items-center gap-2"><i class="fas fa-spinner fa-spin"></i><span class="w-48 text-left">Memuat cuaca...</span></div>
                </div>
            </div>

            <div class="flex justify-center pt-4 lg:pt-8 pb-4">
                <div class="bg-gray-600/20 border-[0.5px] border-gray-400/30 backdrop-blur-sm p-6 rounded-lg flex flex-col items-center space-y-3">
                    <i class="fa fa-mobile  mr-3 text-4xl"></i>
                    <p class="text-center text-white text-2xl font-bold">
                        Unduh  Aplikasi Layanan Digital
                    </p>
                    <p class="text-center text-white text-sm font-small">
                        Nikmati kemudahan mengakses layanan pemerintahan Kota Bandung
                    </p>
                    <p class="text-center text-white text-sm font-medium">
                        dalam genggaman anda
                    </p>
                    <button 
                        type="button" 
                        id="open-iklan-modal" 
                        class="inline-flex items-center px-8 py-4 bg-blue-950 hover:bg-orange-600 text-white font-semibold rounded-lg shadow-lg transform transition duration-200 hover:scale-105 active:scale-95">
                        <i class="fab fa-google-play mr-3 text-xl"></i>Layanan Digital
                    </button>
                    <p class="text-center  text-white/30 text-xs font-small">
                        Tersedia untuk Android · Gratis · Update · Terbaru 2024
                    </p>
                </div>
            </div>
        </div>

        <div class="absolute left-0 right-0 z-20 bottom-[-16rem] sm:bottom-[-14rem] md:bottom-[-12rem] lg:bottom-[-14rem]">
            <div 
                x-data="appSlider({{ $aplikasi->toJson() }})" 
                @mouseenter="isHovering = true" 
                @mouseleave="isHovering = false"
                class="container relative mx-auto px-6 sm:px-8 lg:px-16"
            >
                <div class="overflow-hidden rounded-xl py-5">
                    <div 
                        x-ref="slider" 
                        class="flex -mx-3 transition-transform duration-500 ease-in-out"
                        :style="`transform: translateX(-${currentIndex * 100 / visibleSlides}%)`"
                    >
                        <template x-for="app in apps" :key="app.id">
                            <div class="flex-shrink-0 w-full md:w-1/2 lg:w-1/4 px-3">
                                <a :href="app.link || '#'" target="_blank" rel="noopener noreferrer" 
                                   class="group relative block aspect-square rounded-xl shadow-lg transition-all duration-300 hover:shadow-xl hover:-translate-y-2">
                                    <div class="absolute inset-0 rounded-xl overflow-hidden">
                                        <img :src="app.foto ? '{{ asset('/') }}' + app.foto : '{{ asset('pictures/default-app-icon.png') }}'" 
                                             :alt="'Logo ' + app.judul" 
                                             class="w-full h-full object-cover transition-transform duration-300">
                                    </div>
                                    <div class="absolute inset-0 bg-gradient-to-t from-blue-900/80 to-transparent opacity-0 rounded-xl group-hover:opacity-100 transition-opacity duration-300 z-10"></div>
                                    <div class="absolute bottom-0 left-0 right-0 p-4 transform translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300 z-20">
                                        <h3 class="text-lg font-bold text-white text-center" x-text="app.judul"></h3>
                                    </div>
                                </a>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Tombol Navigasi Slider -->
                <div x-show="shouldShowControls" class="absolute inset-0 flex items-center justify-between pointer-events-none px-2 sm:px-4">
                    <button @click="prev()" :disabled="atStart" class="pointer-events-auto hover:bg-blue-950 bg-orange-600 text-white disabled:opacity-50 disabled:cursor-not-allowed w-10 h-10 rounded-full shadow-lg flex items-center justify-center transition-colors duration-200" aria-label="Previous Slide">
                        &#8249;
                    </button>
                    <button @click="next()" :disabled="atEnd" class="pointer-events-auto hover:bg-blue-950 bg-orange-600 text-white disabled:opacity-50 disabled:cursor-not-allowed w-10 h-10 rounded-full shadow-lg flex items-center justify-center transition-colors duration-200" aria-label="Next Slide">
                        &#8250;
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- =================================================================== -->
    <!-- 2. KONTEN HALAMAN UTAMA                                             -->
    <!-- =================================================================== -->

    <div class="bg-white pt-72 sm:pt-60 md:pt-56 lg:pt-72">
        {{-- PENGUMUMAN --}}
        <section id="pengumuman" class="py-16 sm:py-20">
            <div class="container mx-auto px-6 sm:px-8 lg:px-16">
                <div 
                    x-data="announcementSlider({{ $pengumuman->count() }})"
                    @mouseenter="isHovering = true"
                    @mouseleave="isHovering = false"
                    class="relative rounded-2xl shadow-xl bg-white flex"
                >
                    <!-- Gambar Maskot -->
                    <div class="relative lg:w-1/6 w-1/4 hidden md:block flex-shrink-0">
                        <img src="{{ asset('pictures/karakter_pengumuman1.png') }}" alt="Maskot Pengumuman" class="absolute bottom-0 left-6 h-[140%] w-auto max-w-none drop-shadow-lg">
                    </div>

                    <!-- Konten Slider -->
                    <div class="flex-1 overflow-hidden relative py-8 pr-4 md:pl-0 pl-2">
                        <!-- Slides Container -->
                        <div 
                            x-ref="slides"
                            class="flex transition-transform duration-500 ease-in-out h-full"
                            :style="`transform: translateX(-${currentIndex * 100}%)`"
                        >
                            @forelse ($pengumuman as $item)
                                <div class="w-full flex-shrink-0 px-4 md:px-8 flex flex-col justify-center">
                                    <div class="flex items-center mb-2">
                                        <div class="flex items-center gap-2">
                                            <span class="text-black font-semibold">Pengumuman</span>
                                            <button @click="toggleDetails('{{ $loop->index }}')" class="p-1 rounded-full hover:bg-gray-100 transition-colors">
                                                <i class="fas fa-chevron-right transition-transform duration-500" :style="{ transform: `rotate(${(rotations['{{ $loop->index }}'] || 0)}deg)` }"></i>
                                            </button>
                                            <a href="{{ route('pengumuman.index') }}" class="text-orange-500 font-semibold text-sm transition-all duration-300 whitespace-nowrap" :class="expanded['{{ $loop->index }}'] ? 'opacity-100' : 'opacity-0 pointer-events-none'">Lihat Selengkapnya</a>
                                        </div>
                                    </div>
                                    <h3 class="text-lg font-bold text-blue-950 truncate" title="{{ $item->judul }}">{{ $item->judul }}</h3>
                                    <p class="text-sm text-gray-600 mt-2 break-words line-clamp-2" title="{{ $item->isi_pengumuman }}">
                                        {{ $item->isi_pengumuman }}
                                    </p>
                                    
                                    <div class="mt-4 text-xs text-gray-500">
                                        <span><i class="fa-solid fa-calendar-alt mr-2"></i>{{ \Carbon\Carbon::parse($item->tanggal ?? $item->created_at)->translatedFormat('d F Y') }}</span>
                                    </div>
                                </div>
                            @empty
                                <div class="w-full flex-shrink-0 px-8 flex flex-col justify-center">
                                    <h3 class="text-lg font-bold text-blue-950">Tidak Ada Pengumuman</h3>
                                    <p class="text-sm text-gray-600 mt-2">Saat ini belum ada pengumuman terbaru yang dipublikasikan.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                    <!-- Dots Navigation -->
                        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2">
                            <template x-for="i in totalSlides" :key="i">
                                <button 
                                    @click="goTo(i - 1)" 
                                    class="w-2.5 h-2.5 rounded-full transition duration-300"
                                    :class="currentIndex === (i - 1) ? 'bg-blue-950' : 'bg-gray-300'"
                                ></button>
                            </template>
                        </div>
                </div>
            </div>
        </section>

        <!-- SEKSI BERITA TERKINI-->
        <section id="berita" class="pt-16 sm:pt-8">
            <div class="container mx-auto px-6 sm:px-8 lg:px-16">
                <!-- Header -->
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-2xl font-bold">Berita Terkini</h2>
                    <a href="{{ route('berita.index') }}" class="text-sm font-semibold text-orange-500 hover:text-orange-600 hover:underline transition-colors">
                        Lihat Semua Berita &rarr;
                    </a>
                </div>

                <!-- Grid Cards -->
                <div class="grid gap-6 md:grid-cols-3">
                    @foreach ($semuaBerita as $berita)
                        <a href="{{ route('berita.detail', $berita->id) }}" class="block group">
                            <!-- Tata Letak untuk HP (Horizontal) -->
                            <div class="flex items-center gap-4 md:hidden bg-white rounded-lg shadow-md p-2 transition-transform duration-300 group-hover:-translate-y-2">
                                <img src="{{ asset($berita->foto_utama ?? 'pictures/dummy_berita.jpg') }}" alt="{{ $berita->judul }}" class="w-24 h-24 object-cover rounded-lg flex-shrink-0">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-base mb-1 line-clamp-2">{{ $berita->judul }}</h3>
                                    <div class="text-xs text-gray-500 flex items-center gap-2">
                                        <span><i class="fa-regular fa-calendar mr-1"></i>{{ \Carbon\Carbon::parse($berita->tanggal)->translatedFormat('d M Y') }}</span>
                                        <span class="font-bold">&middot;</span>
                                        <span><i class="fas fa-tags mr-1"></i>{{ $berita->topik->nama ?? 'Umum' }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Tata Letak untuk Tablet & Desktop (Vertikal) -->
                            <div class="hidden md:flex flex-col aspect-[4/5] rounded-2xl overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 group-hover:-translate-y-2">
                                <div class="rounded-2xl lg:w-full  lg:h-full aspect-square overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 card-news">
                                    <div class="aspect-video w-full bg-center bg-cover image" style="background-image: url('{{ asset($berita->foto_utama ?? 'pictures/dummy_berita.jpg') }}')"></div>
                                    <div class="bg-black/70 text-white p-4 overlay">
                                        <div class="text-sm mb-2 meta flex items-center gap-4">
                                            <span class="flex items-center gap-2"><i class="fa-regular fa-calendar"></i>{{ \Carbon\Carbon::parse($berita->tanggal)->translatedFormat('d F Y') }}</span>
                                            <span class="flex items-center gap-2"><i class="fas fa-tags"></i>{{ $berita->topik->nama ?? 'Tanpa Topik' }}</span>
                                        </div>
                                        <h5 class="font-semibold text-lg mb-3 line-clamp-2">{{ $berita->judul }}</h5>
                                        <div class="flex items-center justify-end">
                                            <button class="text-white text-sm hover:text-gray-300" onclick="event.preventDefault(); share('{{ route('berita.detail', $berita->id) }}', '{{ $berita->judul }}')">
                                                <i class="fa-solid fa-share-nodes"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="agenda" class="relative bg-cover bg-center my-16 sm:my-20 pb-32 sm:pb-48" style="background-image: linear-gradient(to top, rgba(255, 255, 255, 0.918), rgba(255, 255, 255, 0.925)), url('{{ asset('pictures/bg-kalender.png') }}')">
            <div 
                x-data="calendarComponent()"
                x-init="init()"
                class="container relative mx-auto px-6 sm:px-8 lg:px-16 "
            >
                <!-- Header -->
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-3xl lg:text-4xl font-extrabold text-gray-900 tracking-tight">Agenda Kegiatan</h2>
                    <a href="{{ route('agenda.index') }}" class="text-sm font-semibold text-orange-500 hover:text-orange-600 hover:underline transition-colors">
                        Lihat Kalender Penuh &rarr;
                    </a>
                </div>
        
                <!-- Kalender + Agenda -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Kalender -->
                    <div class="md:col-span-2 bg-white/80 p-4 md:p-5 rounded-2xl shadow-lg border">
                        <div id="calendar-container" x-ref="calendar"></div>
                    </div>
        
                    <!-- Daftar Agenda Terdekat -->
                    <div class="space-y-4">
                        <h3 class="text-xl font-bold text-gray-800">Agenda Terdekat</h3>
                        <div class="space-y-4">
                            <template x-if="!nearestAgendasList || nearestAgendasList.length === 0">
                                <p class="text-gray-500 text-sm">Tidak ada agenda terdekat yang dijadwalkan.</p>
                            </template>
                            <template x-for="agenda in nearestAgendasList" :key="agenda.id">
                                <div class="flex items-center gap-4">
                                    <div class="flex-shrink-0 text-center font-bold text-gray-800 bg-blue-100 rounded-xl p-3 shadow-sm w-20 h-20 flex flex-col justify-center">
                                        <div class="text-2xl" x-text="new Date(agenda.tanggal).getDate()"></div>
                                        <div class="text-sm" x-text="new Date(agenda.tanggal).toLocaleDateString('id-ID', { month: 'short' })"></div>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="font-semibold text-gray-800 line-clamp-2" x-text="agenda.nama_agenda"></p>
                                        <p class="text-xs text-gray-500 mt-1 line-clamp-1" x-text="agenda.deskripsi || 'Tidak ada deskripsi'"></p>
                                        <div class="flex items-center text-gray-600 mt-1">
                                            <i class="fa-solid fa-location-dot text-sm mr-1 just text-orange-500 flex-shrink-0"></i>
                                            <span class="text-xs line-clamp-1" x-text="agenda.lokasi || 'Lokasi tidak tersedia'"></span>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Modal Detail Kegiatan -->
                <div 
                    x-show="isModalOpen"
                    x-cloak
                    @keydown.escape.window="isModalOpen = false"
                    class="fixed inset-0 bg-black/60 flex items-center justify-center z-50 p-4"
                >
                    <div @click.away="isModalOpen = false" class="bg-white rounded-xl shadow-xl w-full max-w-3xl max-h-[90vh] overflow-y-auto">
                        <div class="p-4 sm:p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-xl font-bold text-blue-900">Detail Kegiatan</h3>
                                <button @click="isModalOpen = false" class="text-gray-400 hover:text-gray-600">&times;</button>
                            </div>
                            <img :src="modalImage" alt="Gambar Kegiatan" class="w-full h-auto rounded-lg mb-4 cursor-pointer">
                            <h2 class="text-2xl font-bold text-center mb-4" x-text="modalTitle"></h2>
                            <div class="space-y-3 text-gray-700">
                                <div class="flex items-center gap-3">
                                    <i class="fa-solid fa-calendar-alt text-blue-900"></i>
                                    <span x-text="modalDate"></span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <i class="fa-solid fa-location-dot text-blue-900"></i>
                                    <span x-text="modalLocation"></span>
                                </div>
                                <p class="pt-2" x-text="modalDescription"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="absolute left-0 right-0 z-20 bottom-[-3rem] sm:bottom-[-7rem] md:bottom-[-4rem] lg:bottom-[-5rem]">
                <div class="container mx-auto px-6 sm:px-8 lg:px-16">
                    <div class="rounded-2xl shadow-xl border bg-white p-5 sm:p-8">
                        <div class="grid grid-cols-4 gap-8 text-center">
                            <!-- Stat 1 -->
                            <div class="sm:border-r border-gray-200">
                                <h3 class="text-md md:text-2xl lg:text-5xl font-bold text-blue-900">400+</h3>
                                <p class="text-xs sm:text-sm text-gray-600 mt-2">Aplikasi Publik</p>
                            </div>
                            <!-- Stat 2 -->
                            <div class="sm:border-r border-gray-200">
                                <h3 class="text-md md:text-2xl lg:text-5xl font-bold text-blue-900">50+</h3>
                                <p class="text-xs sm:text-sm text-gray-600 mt-2">Titik Wifi Gratis</p>
                            </div>
                            <!-- Stat 3 -->
                            <div class="sm:border-r border-gray-200">
                                <h3 class="text-md md:text-2xl lg:text-5xl font-bold text-blue-900">350+</h3>
                                <p class="text-xs sm:text-sm text-gray-600 mt-2">CCTV Terpantau</p>
                            </div>
                            <!-- Stat 4 -->
                            <div>
                                <h3 class="text-md md:text-2xl lg:text-5xl font-bold text-blue-900">70+</h3>
                                <p class="text-xs sm:text-sm text-gray-600 mt-2">Website OPD</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- SEKSI GALERI VIDEO-->
        {{-- <section id="video-gallery" class="pt-22 sm:pt-22"> --}}
        <section id="video-gallery" class="relative bg-contain bg-bottom bg-no-repeat" style="background-image: url('{{ asset('pictures/last-page.png') }}')">
            <div class="container mx-auto py-16 px-4 sm:px-6 lg:px-8">
                <header class="text-center mb-10">
                    <h2 class="text-4xl md:text-5xl font-bold tracking-tight text-gray-900">Galeri Video</h2>
                    <p class="mt-3 text-lg text-gray-500">Lihat lebih dekat kegiatan dan informasi dari kami.</p>
                </header>

                @if($latestVideos->isNotEmpty())
                <div x-data="videoGallery({{ $latestVideos->toJson() }})">
                    <!-- Tata letak untuk Desktop -->
                    <div @mouseleave="resetOnLeave()" class="hidden md:flex gap-4 h-[480px]">
                        <template x-for="(video, index) in videos" :key="index">
                            <div
                                @mouseenter="setActive(index)"
                                class="relative flex-grow cursor-pointer overflow-hidden rounded-2xl shadow-lg transition-all duration-500 ease-in-out group"
                                :class="{ 'flex-grow-[5]': activeIndex === index, 'flex-grow-[2]': activeIndex !== index }"
                            >
                                <div class="absolute inset-0 bg-cover bg-center transition-all duration-500 ease-in-out"
                                     :style="'background-image: url(https://img.youtube.com/vi/' + video.youtubeId + '/maxresdefault.jpg)'"
                                     :class="{ 'blur-0 brightness-100': activeIndex === index, 'blur-sm brightness-50': activeIndex !== index }"></div>

                                <template x-if="playerIndex === index">
                                    <iframe class="w-full h-full object-cover absolute inset-0"
                                            :src="'https://www.youtube.com/embed/' + video.youtubeId + '?autoplay=1&mute=1&controls=0&showinfo=0&rel=0&loop=1&playlist=' + video.youtubeId"
                                            frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                </template>

                                <div class="absolute bottom-0 left-0 right-0 p-6 text-white" style="background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);">
                                    <div class="transform transition-all duration-500 ease-in-out"
                                         :class="{ 'translate-y-0 opacity-100': activeIndex === index, 'translate-y-10 opacity-0': activeIndex !== index }">
                                        <h3 class="text-2xl font-bold" x-text="video.title"></h3>
                                        <p class="text-sm mt-2 opacity-80 max-w-md" x-text="video.description"></p>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Tata letak untuk Mobile -->
                    <div class="md:hidden space-y-6">
                        <template x-for="(video, index) in videos" :key="index">
                            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                                <div @click="window.open('https://www.youtube.com/watch?v=' + video.youtubeId, '_blank')" class="block relative aspect-video cursor-pointer">
                                    <img :src="'https://img.youtube.com/vi/' + video.youtubeId + '/hqdefault.jpg'" :alt="video.title" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <div class="bg-black/50 text-white rounded-full w-16 h-16 flex items-center justify-center">
                                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"><path d="M6.3 2.841A1.5 1.5 0 004 4.11v11.78a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"></path></svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <h3 class="font-bold text-gray-900" x-text="video.title"></h3>
                                    <p class="text-sm text-gray-600 mt-1 line-clamp-2" x-text="video.description"></p>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
                <!-- Tombol Lihat Semua Video -->
                <div class="mt-12 text-center">
                    <a href="{{ route('main.galeri.video') }}" class="inline-block bg-orange-600 hover:bg-blue-800 text-white font-semibold py-3 px-8 rounded-full shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                        Lihat Semua Video
                    </a>
                </div>
                @endif
            </div>
        </section>
    </div>

    <!-- =================================================================== -->
    <!-- 3. IKLAN MODAL                                                      -->
    <!-- =================================================================== -->
    <div id="iklan-modal" class="fixed inset-0 bg-black/60 flex items-center justify-center z-50 p-4 hidden opacity-0 transition-opacity duration-300">
        <div class="relative w-full max-w-2xl transform transition-all duration-300 scale-95">
            <button id="close-iklan-modal" class="absolute -top-3 -right-3 bg-white text-blue-950 w-8 h-8 rounded-full shadow-lg flex items-center justify-center text-lg hover:bg-gray-200 transition z-20">
                &times;
            </button>
            <img src="{{ asset('pictures/Bandung Sadayana.png') }}" alt="Iklan Layanan Digital" class="w-full h-auto rounded-2xl shadow-2xl block">
            <div class="absolute inset-0 flex flex-col justify-end p-6 sm:p-8 bg-gradient-to-t from-gray-900/80 to-transparent rounded-2xl">
                <div class="w-full flex flex-col sm:flex-row justify-center items-center gap-4">
                    <a href="https://play.google.com/store/apps/details?id=gov.bdg.smartcitybdg" target="_blank" class="w-full sm:w-auto inline-flex items-center justify-center px-3 py-1 bg-gray-100/90 text-black hover:bg-white font-semibold rounded-lg transition duration-200 backdrop-blur-sm">
                        <i class="fab fa-google-play mr-2 text-2xl"></i>
                        <div>
                            <p class="text-xs -mb-1 text-left">GET IT ON</p>
                            <p class="text-lg font-bold">Google Play</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    /* Menambahkan aturan CSS untuk menyembunyikan scrollbar secara cross-browser */
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-hide {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }

    /* Kelas utilitas kustom untuk membatasi teks ke 2 baris */
    .line-clamp-2 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
    }
    /* Kustomisasi gaya untuk FullCalendar agar sesuai dengan tema */
    .fc .fc-button-primary {
        background-color: #1e3a8a; /* bg-blue-900 */
        border-color: #1e3a8a;
    }
    .fc .fc-button-primary:hover, .fc .fc-button-primary:active {
        background-color: #ea580c !important; /* bg-orange-600 */
        border-color: #ea580c !important;
    }
    .fc .fc-button-primary:focus {
        box-shadow: none !important;
    }
    .fc .fc-daygrid-day.fc-day-today {
        background-color: #bfdbfe; /* bg-blue-200 */
    }
    /* Kustomisasi gaya untuk FullCalendar List View */
    .fc-list-event:hover td {
        background-color: #f3f4f6; /* bg-gray-100 */
    }
    .fc .fc-list-event-title a {
        color: #1e3a8a; /* text-blue-900 */
        text-decoration: none;
    }
    .fc .fc-list-event-dot {
        border-color: #ea580c; /* border-orange-600 */
    }
    .fc .fc-list-day-text {
        color: #111827; /* text-gray-900 */
        text-decoration: none;
        font-weight: 600;
    }
    /* Aturan untuk x-cloak */
    [x-cloak] { display: none !important; }

    @media (max-width: 1023px) { /* Dari 767px ke 1023px */
        .fc-header-toolbar {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            row-gap: 0.75rem;
            column-gap: 0.5rem;
        }
        .fc-toolbar-chunk:nth-child(2) {
            width: 100%;
            text-align: center;
            order: 1;
        }
        .fc-toolbar-chunk:nth-child(1) {
            order: 2;
        }
        .fc-toolbar-chunk:nth-child(3) {
            order: 3;
        }
    }
</style>
@endpush
@push('scripts')
<script>

    // fungsi untuk App Slider
    function appSlider(appsData) {
        return {
            apps: appsData,
            currentIndex: 0,
            isHovering: false,
            visibleSlides: 4,
            interval: null,
            
            get atStart() {
                return this.currentIndex === 0;
            },
            
            get atEnd() {
                return this.currentIndex >= this.apps.length - this.visibleSlides;
            },

            init() {
                this.updateVisibleSlides();
                this.startAutoScroll();
                window.addEventListener('resize', () => this.updateVisibleSlides());
            },
            
            destroy() {
                window.removeEventListener('resize', this.updateVisibleSlides);
                clearInterval(this.interval);
            },
            
            updateVisibleSlides() {
                if (window.innerWidth < 768) this.visibleSlides = 1;
                else if (window.innerWidth < 1024) this.visibleSlides = 2;
                else this.visibleSlides = 4;
                
                // Pastikan currentIndex tidak keluar batas setelah resize
                if(this.currentIndex > this.apps.length - this.visibleSlides) {
                    this.currentIndex = Math.max(0, this.apps.length - this.visibleSlides);
                }
            },

            get shouldShowControls() {
                return this.apps.length > this.visibleSlides;
            },

            next() {
                if(this.atEnd) return;
                this.currentIndex++;
            },

            prev() {
                if(this.atStart) return;
                this.currentIndex--;
            },

            startAutoScroll() {
                clearInterval(this.interval);
                this.interval = setInterval(() => {
                    if (!this.isHovering && this.shouldShowControls) {
                        if (this.atEnd) {
                            this.currentIndex = 0;
                        } else {
                            this.next();
                        }
                    }
                }, 4000);
            }
        }
    }

    // fungsi Announcement Slider
    function announcementSlider(count) {
        return {
            totalSlides: count,
            currentIndex: 0,
            isHovering: false,
            expanded: {}, // Menyimpan status "Lihat Selengkapnya" per slide
            rotations: {}, // Menyimpan nilai rotasi per slide
            interval: null,

            init() {
                if (this.totalSlides > 1) {
                    this.startAutoScroll();
                }
            },
            
            destroy() {
                clearInterval(this.interval);
            },
            
            goTo(index) {
                this.currentIndex = index;
                this.resetInterval();
            },
            
            next() {
                this.currentIndex = (this.currentIndex + 1) % this.totalSlides;
            },
            
            startAutoScroll() {
                clearInterval(this.interval);
                this.interval = setInterval(() => {
                    if (!this.isHovering) {
                        this.next();
                    }
                }, 4000);
            },
            
            resetInterval() {
                if (this.totalSlides > 1) {
                    this.startAutoScroll();
                }
            },
            
            toggleDetails(index) {
                // Toggle visibilitas link
                this.expanded[index] = !this.expanded[index];
                
                // Tambah nilai rotasi
                if (!this.rotations[index]) {
                    this.rotations[index] = 0;
                }
                this.rotations[index] += 360;
            }
        }
    }

    // Logic untuk Kalender Kegiatan
    function calendarComponent() {
        return {
            events: [],
            nearestAgendasList: [], // Data terpisah untuk daftar agenda
            isModalOpen: false,
            modalTitle: '',
            modalDate: '',
            modalLocation: '',
            modalDescription: '',
            modalImage: '',

            init() {
                this.isModalOpen = false; 
                // Panggilan API untuk kalender
                fetch('/api/public-events') 
                    .then(response => response.json())
                    .then(data => {
                        this.events = data;
                        this.renderCalendar();
                    })
                    .catch(error => console.error('Error fetching calendar events:', error));
                
                // Panggilan API untuk daftar agenda terdekat
                fetch('/api/nearest-agendas')
                    .then(response => response.json())
                    .then(data => {
                        this.nearestAgendasList = data;
                    })
                    .catch(error => console.error('Error fetching nearest agendas:', error));
            },

            renderCalendar() {
                const calendarEl = this.$refs.calendar;
                const calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    locale: 'id',
                    buttonText: { month: 'Bulan', list: 'Daftar' },
                    headerToolbar: {
                        left: 'prev',
                        center: 'title',
                        right: 'dayGridMonth,listMonth next'
                    },
                    events: this.events,
                    eventClick: (info) => {
                        if (!info.jsEvent || !info.jsEvent.isTrusted) {
                            return;
                        }
                        info.jsEvent.preventDefault();
                        this.showEventDetails(info.event);
                    }
                });
                calendar.render();
            },

            showEventDetails(event) {
                this.modalTitle = event.title;
                this.modalDate = new Date(event.start).toLocaleDateString('id-ID', {
                    weekday: 'long', day: 'numeric', month: 'long', year: 'numeric'
                });
                this.modalLocation = event.extendedProps.location || 'Lokasi tidak ditentukan';
                this.modalDescription = event.extendedProps.description || 'Deskripsi tidak tersedia.';
                this.modalImage = event.extendedProps.image || '{{ asset("pictures/dummy_berita.jpg") }}';
                this.isModalOpen = true;
            }
        }
    }

    // Logic untuk Galeri Video
    function videoGallery(videos) {
        return {
            activeIndex: 0,
            playerIndex: null,
            mobilePlayerIndex: null,
            videos: videos,
            setActive(index) {
                this.activeIndex = index;
                if (this.playerIndex === index) return;
                this.playerIndex = null;
                setTimeout(() => {
                    if (this.activeIndex === index) {
                        this.playerIndex = index;
                    }
                }, 600);
            },
            resetOnLeave() {
                this.activeIndex = 0;
                this.playerIndex = null;
            },
            // Fungsi untuk memutar video di mobile
            playMobileVideo(index) {
                this.mobilePlayerIndex = index;
            }
        }
    }

    // Fungsi Share Berita
    function share(url, title, image) {
        if (navigator.share) {
            navigator.share({
                    title: title,
                    text: title,
                    url: url
                }).then(() => console.log('Berhasil share'))
                .catch((error) => console.log('Error share:', error));
        } else {
            const textToCopy = `${title}\n${url}\n${image}`;
            navigator.clipboard.writeText(textToCopy)
                .then(() => alert('📋 Tersalin:\n' + textToCopy))
                .catch(err => console.error('Gagal copy:', err));
        }
    }

    // Fungsi untuk mengupdate jam real-time
    function updateClock() {
        const clockElement = document.getElementById('live-clock');
        if (clockElement) {
            const options = {
                timeZone: 'Asia/Jakarta',
                hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false
            };
            const timeString = new Date().toLocaleTimeString('id-ID', options);
            clockElement.innerHTML = `
                <i class="far fa-clock text-xl text-orange-400"></i>
                <span>${timeString.replace(/\./g, ':')} WIB</span>
            `;
        }
    }

    // Fungsi untuk mengambil data cuaca dari OpenWeatherMap
    async function getWeather() {
        const weatherElement = document.getElementById('weather-info');
        if (!weatherElement) return;
        const url = '/api/weather';
        try {
            const response = await fetch(url);
            if (!response.ok) throw new Error('Gagal mengambil data cuaca dari server');
            const data = await response.json();
            if (data.cod !== 200) throw new Error(data.message || 'Kota tidak ditemukan');
            const temperature = Math.round(data.main.temp);
            const description = data.weather[0].description;
            const icon = data.weather[0].icon;
            weatherElement.innerHTML = `
                <img src="https://openweathermap.org/img/wn/${icon}.png" alt="Ikon cuaca" class="inline-block w-10 h-10 -my-2">
                <span>${temperature}°C, ${description.charAt(0).toUpperCase() + description.slice(1)}</span>
            `;
        } catch (error) {
            console.error('Error memuat cuaca:', error.message);
            weatherElement.innerHTML = `
                <i class="fas fa-exclamation-circle text-red-400"></i>
                <span>Gagal memuat cuaca</span>
            `;
        }
    }

    // Jalankan fungsi saat halaman selesai dimuat
    document.addEventListener('DOMContentLoaded', function() {
        // Mulai jam
        setInterval(updateClock, 1000);
        updateClock(); // Panggil sekali agar tidak ada delay 1 detik

        // Ambil data cuaca
        getWeather();
        
        // --- SCRIPT UNTUK MODAL IKLAN ---
        const iklanModal = document.getElementById('iklan-modal');
        const openIklanModal = document.getElementById('open-iklan-modal');
        const closeIklanModal = document.getElementById('close-iklan-modal');
        const modalContent = iklanModal ? iklanModal.querySelector('.relative') : null;

        if (iklanModal && openIklanModal && closeIklanModal && modalContent) {
            const showIklanModal = () => {
                iklanModal.classList.remove('hidden');
                setTimeout(() => {
                    iklanModal.classList.remove('opacity-0');
                    modalContent.classList.remove('scale-95');
                }, 50); // Delay kecil untuk animasi
            };

            const hideIklanModal = () => {
                iklanModal.classList.add('opacity-0');
                modalContent.classList.add('scale-95');
                setTimeout(() => {
                    iklanModal.classList.add('hidden');
                }, 300); // Waktu transisi 
            };
            
            // Pemicu menampilkan modal saat tombol di hero diklik
            openIklanModal.addEventListener('click', showIklanModal);

            // Pemicu untuk menutup modal
            closeIklanModal.addEventListener('click', hideIklanModal);
            iklanModal.addEventListener('click', (event) => {
                // Tutup modal jika user mengklik area latar belakang gelap
                if (event.target === iklanModal) {
                    hideIklanModal();
                }
            });
        }
    });
</script>
@endpush

