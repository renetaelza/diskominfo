@extends('layouts.app')

@section('content')

<!-- HERO SECTION -->
<header class="relative bg-gray-800 text-white overflow-hidden min-h-[90vh]">

    <img
        src="{{ ($hero && $hero->img_banner) ? asset('storage/' . $hero->img_banner) : asset('pictures/hero_landing.png') }}"
        alt="Gedung Diskominfo Bandung"
        class="absolute inset-0 w-full h-full object-cover opacity-20 z-0">

    <div class="relative z-10 container mx-auto px-6 sm:px-8 lg:px-16 flex flex-col justify-center pt-52 lg:pt-72 h-full space-y-10">

        <!-- BARIS PERTAMA: H1 + tagline (kiri) & clock/weather (kanan) -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center w-full gap-6">

            <!-- H1 + tagline -->
            <div class="lg:w-2/3 text-left">
                <h1 class="text-4xl lg:text-6xl font-extrabold tracking-tight">
                    DINAS KOMUNIKASI DAN INFORMATIKA <span class="text-orange-400">KOTA BANDUNG</span>
                </h1>

                <p class="mt-4 text-lg text-gray-200 max-w-2xl">
                    {{ $hero->tagline ?? 'Belum ada tagline yang diatur' }}
                </p>
            </div>

            <!-- Clock & Weather -->
            <div class="mt-6 lg:mt-0 flex flex-col items-start lg:items-end gap-3 text-lg font-semibold text-gray-200">
                <div id="live-clock" class="flex items-center gap-3">
                    <i class="far fa-clock text-xl"></i>
                    <span class="w-32">Memuat...</span>
                </div>
                <div id="weather-info" class="flex items-center gap-2">
                    <i class="fas fa-spinner fa-spin"></i>
                    <span class="w-48 text-left">Memuat...</span>
                </div>
            </div>
        </div>

        <!-- BARIS KEDUA: Button di tengah -->
        <div class="flex justify-center lg:pt-20">
            <a href="https://play.google.com/store/apps/details?id=gov.bdg.smartcitybdg"
               target="_blank"
               class="inline-flex items-center px-6 py-3 bg-blue-950 hover:bg-orange-600 text-white font-semibold rounded-lg shadow-md transform transition duration-200 hover:scale-105 active:scale-95">
                <i class="fab fa-google-play mr-2 text-lg"></i>
                Layanan Digital
            </a>
        </div>

    </div>
</header>

<!-- CARD SLIDER SECTION -->
<section class="relative z-20 -mt-24 md:-mt-20 pb-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div id="slider-container" class="w-full max-w-7xl mx-auto flex items-center justify-center gap-x-2 sm:gap-x-4">
            <!-- Prev Button -->
            <button id="prev-slide" class="flex-shrink-0 bg-white w-12 h-12 rounded-full shadow-lg flex items-center justify-center text-blue-950 hover:bg-gray-200 transition">
                <i class="fas fa-chevron-left"></i>
            </button>

            <!-- Viewport -->
            <div id="slider-viewport" class="w-full overflow-hidden py-4">
                <!-- Track -->
                <div class="flex gap-8 ml-4 transition-transform duration-500 ease-in-out" id="slider-track">
                    @forelse($aplikasi as $app)
                    <!-- Card Dinamis -->
                    <a href="{{ $app->link }}" target="_blank"
                        class="flex-shrink-0 w-[80vw] sm:w-64 h-64 rounded-2xl shadow-md overflow-hidden relative group cursor-pointer transition-transform duration-300 hover:-translate-y-2">

                        <!-- Gambar -->
                        @if($app->foto && Storage::disk('public')->exists(str_replace('storage/', '', $app->foto)))
                        <img src="{{ asset($app->foto) }}" alt="{{ $app->judul }}"
                            class="w-full h-full object-cover block">
                        @else
                        <div class="w-full h-full flex items-center justify-center bg-gray-200">
                            <i class="fas fa-image text-4xl text-gray-400"></i>
                        </div>
                        @endif

                        <!-- Overlay Hover -->
                        <div class="absolute inset-0 bg-gradient-to-t from-blue-900/70 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-end justify-center p-4 z-50">
                            <h3 class="text-white font-bold text-lg text-center">{{ $app->judul }}</h3>
                        </div>
                    </a>
                    @empty
                    <div class="w-full text-center text-gray-300 italic py-6">
                        <p>Belum ada aplikasi tersedia.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Next Button -->
            <button id="next-slide" class="flex-shrink-0 bg-white w-12 h-12 rounded-full shadow-lg flex items-center justify-center text-blue-950 hover:bg-gray-200 transition">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>
</section>


<!-- PENGUMUMAN SECTION -->
<section class="py-16 pt-32">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div id="announcement-carousel" class="relative rounded-2xl shadow-lg bg-white mt-16 md:mt-0">
            <!-- Image positioned absolutely -->
            <div class="absolute bottom-0 left-6 w-1/3 h-full hidden md:block">
                <img src="{{ asset('pictures/karakter_pengumuman1.png') }}" alt="Maskot Pengumuman" class="absolute bottom-0 h-[140%] w-auto max-w-none drop-shadow-lg">
            </div>
            <!-- Slides Wrapper with margin to avoid overlap -->
            <div class="md:ml-[18%] h-64">
                <div class="flex-1 overflow-hidden relative">
                    <!-- Slides Container (the moving part) -->
                    <div id="slides-container" class="flex transition-transform duration-500 ease-in-out">
                        @forelse ($pengumuman as $pengumuman)
                        <!-- Slide Dinamis -->
                        <div class="w-full flex-shrink-0 p-8 mt-6">
                            <div class="flex items-center mb-2">
                                <span class="text-black font-semibold">Pengumuman</span>
                                <div class="flex items-center gap-2">
                                    <button class="announcement-toggle p-1 rounded-full hover:bg-gray-100 transition-colors">
                                        <i class="fas fa-chevron-right transition-transform duration-300"></i>
                                    </button>
                                    <a href="{{route('pengumuman.index')}}" class="announcement-link text-orange-500 font-semibold text-sm hidden pointer-events-none transition-all duration-300">Lihat Selengkapnya &rarr;</a>
                                </div>
                            </div>
                            <h3 class="text-lg font-bold text-blue-950 truncate">{{ $pengumuman->judul }}</h3>
                            <p class="text-sm text-gray-600 mt-2">{{ Str::limit($pengumuman->isi_pengumuman, 100) }}</p>
                            <div class="mt-4 text-xs text-gray-500">
                                <span><i class="fa-solid fa-calendar-alt mr-2"></i>{{ \Carbon\Carbon::parse($pengumuman->tanggal ?? $pengumuman->created_at)->translatedFormat('d F Y') }}</span>
                            </div>
                        </div>
                        @empty
                        <!-- Fallback jika tidak ada pengumuman -->
                        <div class="w-full flex-shrink-0 p-8">
                            <h3 class="text-lg font-bold text-blue-950">Tidak Ada Pengumuman</h3>
                            <p class="text-sm text-gray-600 mt-2">Saat ini belum ada pengumuman terbaru yang dipublikasikan.</p>
                        </div>
                        @endforelse
                    </div>
                    <!-- Dots Navigation -->
                    <div id="dots-container" class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-12 bg-slate-100 px-10">
    <div class="container mx-auto py-16 px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold">Berita Terkini</h2>
            <a href="{{ route('berita.index') }}" class="text-sm font-medium text-black hover:underline">
                Lihat Semua Berita
            </a>
        </div>

        <!-- Grid Cards -->
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($semuaBerita as $berita)
            <a href="{{ route('berita.detail', $berita->id) }}" class="text-decoration-none block">
                <div class="rounded-2xl overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 card-news">
                    <!-- Image -->
                    <div class="h-60 bg-center bg-cover image"
                        style="background-image: url('{{ asset($berita->foto_utama ?? 'pictures/dummy_berita.jpg') }}')">
                    </div>

                    <!-- Overlay -->
                    <div class="bg-black/70 text-white p-4 overlay">
                        <div class="text-sm mb-2 meta flex items-center gap-4">
                            <span class="flex items-center gap-2">
                                <i class="fa-regular fa-calendar"></i>
                                {{ \Carbon\Carbon::parse($berita->tanggal)->translatedFormat('d F Y') }}
                            </span>
                            <span class="flex items-center gap-2">
                                <i class="fas fa-tags"></i>
                                {{ $berita->topik->nama ?? 'Tanpa Topik' }}
                            </span>
                        </div>

                        <h5 class="font-semibold text-lg mb-3 fw-semibold line-clamp-2">
                            {{ $berita->judul }}
                        </h5>

                        <div class="flex items-center justify-end">
                            <button class="text-white text-sm hover:text-gray-300"
                                onclick="event.preventDefault(); share('{{ route('berita.detail', $berita->id) }}', '{{ $berita->judul }}')">
                                <i class="fa-solid fa-share-nodes"></i>
                            </button>
                        </div>

                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

<section class="py-16 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold text-gray-800">Agenda Kegiatan</h2>
            <a href="{{ route('agenda.index') }}" class="text-sm font-medium text-black hover:underline">
                Lihat Kalender Penuh
            </a>
        </div>

        {{-- Kalender + Agenda --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Kalender --}}
            <div class="md:col-span-2 bg-white p-4 md:p-5 rounded-2xl shadow-lg border">
                <div id="calendar-beranda"></div>
            </div>

            {{-- 3 Agenda Terdekat --}}
            <div class="space-y-4 ">
                <h3 class="text-lg font-semibold text-gray-800">Agenda Terdekat</h3>
                <div id="nearest-agendas" class="space-y-3">
                    {{-- Will be filled dynamically --}}
                </div>
            </div>
        </div>
    </div>
</section>


<!-- GALERI VIDEO SECTION -->
@if($latestVideos->isNotEmpty())
<section x-data="videoGallery()" @mouseleave="resetOnLeave()" class="bg-white text-grey-900 antialiased">
    <!-- Main container for the gallery -->
    <div class="container mx-auto py-16 px-4 sm:px-6 lg:px-8">
        <header class="text-center mb-10">
            <h2 class="text-4xl md:text-5xl font-bold tracking-tight">Galeri Video</h2>
            <p class="mt-3 text-lg text-gray-400">Lihat lebih dekat kegiatan dan informasi dari kami.</p>
        </header>

        <!-- Alpine.js component initialization -->
        <div class="flex gap-4 h-[480px]">
            <!-- Loop through each video in the data -->
            <template x-for="(video, index) in videos" :key="index">
                <div
                    @mouseenter="setActive(index)"
                    class="relative flex-grow cursor-pointer overflow-hidden rounded-2xl shadow-2xl custom-transition group"
                    :class="{
                        'flex-grow-[5]': activeIndex === index,
                        'flex-grow-[2]': activeIndex !== index
                    }">
                    <div
                        class="absolute inset-0 bg-cover bg-center transition-all duration-500 ease-in-out"
                        :style="'background-image: url(https://img.youtube.com/vi/' + video.youtubeId + '/maxresdefault.jpg)'"
                        :class="{ 'blur-0 brightness-100': activeIndex === index, 'blur-sm brightness-50': activeIndex !== index }"></div>

                    <template x-if="playerIndex === index">
                        <iframe
                            class="w-full h-full object-cover absolute inset-0"
                            :src="'https://www.youtube.com/embed/' + video.youtubeId + '?autoplay=1&mute=1&controls=0&showinfo=0&rel=0&loop=1&playlist=' + video.youtubeId"
                            title="YouTube video player"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                    </template>

                    <div
                        class="absolute bottom-0 left-0 right-0 p-6 text-white transition-all duration-500"
                        style="background: linear-gradient(to top, rgba(0,0,0,0.9), transparent);">
                        <div
                            class="transform transition-all duration-500 ease-in-out"
                            :class="{
                                'translate-y-0 opacity-100': activeIndex === index,
                                'translate-y-10 opacity-0': activeIndex !== index
                            }">
                            <h2 class="text-2xl font-bold" x-text="video.title"></h2>
                            <p class="text-sm mt-2 opacity-80 max-w-md" x-text="video.description"></p>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
</section>
@endif

<div class="modal fade" id="eventDetailModal" tabindex="-1" aria-labelledby="eventDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 overflow-hidden shadow-lg">
            <div class="modal-header" style="background-color: #0a2463; color: white;">
                <h5 class="modal-title w-100 text-center" id="eventDetailModalLabel">Detail Kegiatan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <h2 class="fw-bold text-center mb-4" id="modal-title"></h2>
                <img id="modal-image" src="" class="img-fluid rounded-3 w-100 mb-4" style="max-height: 300px; object-fit: cover;" alt="Event Image">
                <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-calendar-event fs-4 me-3 text-dark"></i>
                    <span id="modal-date"></span>
                </div>
                <div class="d-flex align-items-center mb-4">
                    <i class="bi bi-geo-alt fs-4 me-3 text-dark"></i>
                    <span id="modal-location"></span>
                </div>
                <p id="modal-description"></p>
            </div>
        </div>
    </div>
</div>

@push('styles')
{{-- Style khusus untuk halaman ini --}}
<style>
    .fc-event { cursor: pointer; }
    #calendar-beranda { font-size: 0.85rem; max-width: 900px; margin: 0 auto; }
    .custom-transition { transition: all 600ms cubic-bezier(0.65, 0, 0.35, 1); }

    #agenda-list .agenda-date {
        background-color: #facc15;
        color: black;
        font-weight: bold;
        border-radius: 0.75rem;
        width: 60px;
        height: 60px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
    }
    #agenda-list .agenda-date span {
        font-size: 0.75rem;
    }
</style>
@endpush

@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.14/index.global.min.js'></script>
@endpush
<script>
    // --- SCRIPT UNTUK GALERI VIDEO ---
    const videoData = @json($latestVideos);

    function videoGallery() {
        return {
            activeIndex: 0,
            playerIndex: null,
            videos: videoData,
            setActive(index) {
                // Atur status visual aktif secara langsung
                this.activeIndex = index;

                // Jika video untuk kartu ini sudah diputar, jangan lakukan apa-apa
                if (this.playerIndex === index) return;

                // Hentikan video yang sedang berjalan
                this.playerIndex = null;

                // Atur jeda untuk memulai video baru, agar animasi selesai dulu
                setTimeout(() => {
                    // Hanya putar video jika pengguna masih berada di kartu yang sama
                    if (this.activeIndex === index) {
                        this.playerIndex = index;
                    }
                }, 600); // Durasi ini harus sama dengan durasi transisi CSS
            },
            resetOnLeave() {
                this.activeIndex = 0; // Kembalikan ke kartu pertama
                this.playerIndex = null; // Hentikan video
            }
        }
    }

    // Fungsi untuk mengupdate jam real-time
    function updateClock() {
        const clockElement = document.getElementById('live-clock');
        if (clockElement) {
            const options = {
                timeZone: 'Asia/Jakarta',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false
            };
            const timeString = new Date().toLocaleTimeString('id-ID', options);
            clockElement.innerHTML = `
                <i class="far fa-clock"></i>
                <span>${timeString.replace(/\./g, ':')} WIB</span>
            `;
        }
    }

    // Fungsi untuk mengambil data cuaca dari OpenWeatherMap
    async function getWeather() {
        const weatherElement = document.getElementById('weather-info');
        if (!weatherElement) return;

        // URL ke server lokal
        const url = '/api/weather';

        try {
            const response = await fetch(url);
            if (!response.ok) {
                throw new Error('Gagal mengambil data dari server');
            }
            const data = await response.json();

            // Cek jika ada error dari API OpenWeatherMap
            if (data.cod !== 200) {
                throw new Error(data.message || 'City not found');
            }

            const temperature = Math.round(data.main.temp);
            const description = data.weather[0].description;
            const icon = data.weather[0].icon;

            weatherElement.innerHTML = `
                <img src="https://openweathermap.org/img/wn/${icon}.png" alt="Ikon cuaca" class="inline-block w-10 h-10 -my-2">
                <span>${temperature}°C, ${description.charAt(0).toUpperCase() + description.slice(1)}</span>
            `;
        } catch (error) {
            console.error('Error:', error.message);
            weatherElement.innerHTML = `
                <i class="fas fa-exclamation-circle"></i>
                <span>Gagal memuat cuaca</span>
            `;
        }
    }

    // --- FUNGSI SLIDER---
    function initSlider() {
        const container = document.getElementById('slider-container');
        const track = document.getElementById('slider-track');
        const prevButton = document.getElementById('prev-slide');
        const nextButton = document.getElementById('next-slide');

        if (!container || !track || !prevButton || !nextButton) return;

        const cards = Array.from(track.children);
        const cardCount = cards.length;
        let isMoving = false;
        let intervalId;

        // Kloning kartu untuk efek loop
        cards.forEach(card => {
            const clone = card.cloneNode(true);
            track.appendChild(clone);
        });

        let currentIndex = 0;

        function moveSlider() {
            const cardWidth = cards[0].offsetWidth;
            const gap = 32; // Sesuai dengan class 'gap-8'
            const totalMove = (cardWidth + gap) * currentIndex;
            track.style.transform = `translateX(-${totalMove}px)`;
        }

        function handleNext() {
            if (isMoving) return;
            isMoving = true;
            currentIndex++;
            track.style.transition = 'transform 500ms ease-in-out';
            moveSlider();
        }

        // --- FUNGSI PREVIOUS---
        function handlePrev() {
            if (isMoving) return;
            isMoving = true;

            if (currentIndex === 0) {
                // 1. Matikan animasi untuk lompatan
                track.style.transition = 'none';
                // 2. Lompat ke posisi kloning terakhir (yang terlihat sama seperti kartu terakhir)
                currentIndex = cardCount;
                moveSlider();

                // 3. Paksa browser untuk menerapkan lompatan sebelum memulai animasi baru
                setTimeout(() => {
                    // 4. Aktifkan kembali animasi
                    track.style.transition = 'transform 500ms ease-in-out';
                    // 5. Geser ke kartu sebelum kloning (kartu terakhir yang asli)
                    currentIndex--;
                    moveSlider();
                }, 20); // Jeda singkat
            } else {
                currentIndex--;
                track.style.transition = 'transform 500ms ease-in-out';
                moveSlider();
            }
        }

        nextButton.addEventListener('click', handleNext);
        prevButton.addEventListener('click', handlePrev);

        // Event listener untuk "lompatan" tak terlihat saat loop maju
        track.addEventListener('transitionend', () => {
            isMoving = false;
            if (currentIndex >= cardCount) {
                currentIndex = 0;
                track.style.transition = 'none';
                moveSlider();
            }
        });

        // Fungsi untuk auto-slide
        function startAutoSlide() {
            stopAutoSlide(); // Hentikan dulu jika sudah ada
            intervalId = setInterval(handleNext, 3000); // Ganti 3000 (3 detik) sesuai keinginan
        }

        function stopAutoSlide() {
            clearInterval(intervalId);
        }

        // Mulai auto-slide dan hentikan saat di-hover
        container.addEventListener('mouseenter', stopAutoSlide);
        container.addEventListener('mouseleave', startAutoSlide);

        startAutoSlide();
    }

    // --- FUNGSI SLIDER PENGUMUMAN ---
    function initAnnouncementSlider() {
        const carousel = document.getElementById('announcement-carousel');
        const slidesContainer = document.getElementById('slides-container');
        const dotsContainer = document.getElementById('dots-container');
        if (!carousel || !slidesContainer || !dotsContainer) return;

        const slides = Array.from(slidesContainer.children);
        const totalSlides = slides.length;
        let currentIndex = 0;
        let slideInterval;

        function showSlide(index) {
            slidesContainer.style.transform = `translateX(-${index * 100}%)`;
            const dots = dotsContainer.querySelectorAll('.dot');
            dots.forEach((dot, i) => {
                dot.classList.toggle('bg-blue-950', i === index);
                dot.classList.toggle('bg-gray-300', i !== index);
            });
            currentIndex = index;
        }

        for (let i = 0; i < totalSlides; i++) {
            const dot = document.createElement('button');
            dot.classList.add('dot', 'w-2.5', 'h-2.5', 'rounded-full', 'transition', 'duration-300');
            dot.addEventListener('click', () => {
                showSlide(i);
                resetInterval();
            });
            dotsContainer.appendChild(dot);

            const toggleButton = slides[i].querySelector('.announcement-toggle');
            const link = slides[i].querySelector('.announcement-link');
            const icon = slides[i].querySelector('.announcement-toggle i');
            let rotation = 0;
            let isLinkVisible = false;

            if (toggleButton && link && icon) {
                toggleButton.addEventListener('click', () => {
                    rotation += 360;
                    icon.style.transform = `rotate(${rotation}deg)`;

                    isLinkVisible = !isLinkVisible;

                    if (isLinkVisible) {
                        link.classList.remove('hidden', 'pointer-events-none');
                    } else {
                        link.classList.add('hidden', 'pointer-events-none');
                    }
                });
            }
        }

        function startInterval() {
            stopInterval();
            slideInterval = setInterval(() => {
                const nextIndex = (currentIndex + 1) % totalSlides;
                showSlide(nextIndex);
            }, 4000);
        }

        function stopInterval() {
            clearInterval(slideInterval);
        }

        function resetInterval() {
            stopInterval();
            startInterval();
        }

        carousel.addEventListener('mouseenter', stopInterval);
        carousel.addEventListener('mouseleave', startInterval);

        showSlide(0);
        startInterval();
    }

     // Fungsi Calendar Beranda
    function initBerandaCalendar() {
        const calendarEl = document.getElementById('calendar-beranda');
        if (!calendarEl) return;

        const eventModal = new bootstrap.Modal(document.getElementById('eventDetailModal'));

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'id',
            headerToolbar: {
                left: 'prev',
                center: 'title',
                right: 'next'
            },
            events: '/api/public-events', // Menggunakan API publik yang sudah ada
            eventClick: function(info) {
                info.jsEvent.preventDefault();
                
                if (info.event.extendedProps.type === 'agenda') {
                    const event = info.event;
                    const props = event.extendedProps;

                    document.getElementById('modal-title').textContent = event.title;
                    document.getElementById('modal-date').textContent = new Date(event.start).toLocaleDateString('id-ID', {
                        day: 'numeric', month: 'long', year: 'numeric'
                    });
                    document.getElementById('modal-location').textContent = props.location;
                    document.getElementById('modal-description').textContent = props.description;
                    document.getElementById('modal-image').src = props.image;

                    eventModal.show();
                }
            }
        });
        calendar.render();
    }

    // Fungsi untuk memuat 3 agenda terdekat
    function loadNearestAgendas() {
    fetch("/api/nearest-agendas")
        .then(res => res.json())
        .then(agendas => {
            const container = document.getElementById("nearest-agendas");
            container.className = "space-y-4";
            container.innerHTML = "";

            if (agendas.length === 0) {
                container.innerHTML = `<p class="text-gray-500 text-sm">Tidak ada agenda terdekat</p>`;
                return;
            }

            agendas.forEach(agenda => {
                const tanggal = new Date(agenda.tanggal);
                const options = { day: "2-digit", month: "long", year: "numeric" };
                const formattedDate = tanggal.toLocaleDateString("id-ID", options);

                const item = `
                    <div class="flex items-center gap-4">
                            <div class="flex-shrink-0 text-center font-bold text-black-800 bg-blue-600/10 rounded-xl p-3 shadow-sm w-20 h-20 flex flex-col justify-center">
                                <div class="text-2xl">${tanggal.getDate()}</div>
                                <div class="text-sm">${tanggal.toLocaleDateString("id-ID", { month: "short" })}</div>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800 dark:text-black-100">${agenda.nama_agenda}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">${formattedDate}</p>
                            </div>
                        </div>
                `;
                container.innerHTML += item;
            });
        })
        .catch(err => {
            console.error("Gagal memuat agenda:", err);
        });
    }


    // Jalankan fungsi saat halaman selesai dimuat
    document.addEventListener('DOMContentLoaded', function() {
        // Mulai jam
        setInterval(updateClock, 1000);
        updateClock();

        // Ambil data cuaca
        getWeather();

        // Inisialisasi slider
        initSlider();

        // Inisialisasi slider pengumuman
        initAnnouncementSlider();

        // Inisialisasi kalender beranda
        initBerandaCalendar();

        // Muat agenda terdekat
        loadNearestAgendas();
    });
</script>

{{-- Style untuk galeri video --}}
<style>
    .custom-transition {
        transition: all 600ms cubic-bezier(0.65, 0, 0.35, 1);
    }
</style>
@endsection