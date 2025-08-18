@extends('layouts.app')

@section('content')

<!-- HERO SECTION -->
<header class="relative bg-gray-800 text-white overflow-hidden">

    <!-- Gambar Latar Belakang -->
    <img src="{{ asset('pictures/hero_landing.png') }}" alt="Balai Kota Bandung" class="absolute inset-0 w-full h-full object-cover opacity-20 z-0">

    <!-- Konten Hero -->
    <div class="relative z-10 container mx-auto px-6 sm:px-8 lg:px-16">
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between min-h-[90vh] py-28">

            <!-- Grup Teks Utama (Kiri) -->
            <div class="lg:w-2/3 text-left">
                <h1 class="text-4xl lg:text-6xl font-extrabold tracking-tight">
                    DINAS KOMUNIKASI DAN INFORMASI <span class="text-orange-400">KOTA BANDUNG</span>
                </h1>
                <p class="mt-6 max-w-2xl text-lg text-gray-200">
                    Mewujudkan Bandung Smart City melalui Transformasi dan Inovasi Digital yang Inklusif.
                </p>
            </div>

            <!-- Info Jam & Cuaca (Kanan) -->
            <div class="mt-8 lg:mt-0 flex flex-col items-start lg:items-end gap-2 text-lg font-semibold text-gray-200">
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
<section class="py-16 bg-slate-100 pt-32">
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
                        <div class="w-full flex-shrink-0 p-8">
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
    <div class="container mx-auto px-4">
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

                        <div class="flex items-center justify-between">
                            <button class="text-white text-sm hover:text-gray-300"
                                onclick="event.preventDefault(); share('{{ route('berita.detail', $berita->id) }}', '{{ $berita->judul }}')">
                                <i class="fa-solid fa-share"></i>
                            </button>
                            <div class="text-sm flex items-center gap-1 eye-counter">
                                <i class="fa-regular fa-eye"></i>
                                {{ $berita->views ?? 0 }}
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- SCRIPT UNTUK JAM DAN CUACA -->
<script>
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
    });
</script>
@endsection