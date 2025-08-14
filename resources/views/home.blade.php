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
<section class="relative z-20 -mt-24 md:-mt-48 pb-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center lg:text-left mb-8 lg:ml-8">
            <h2 class="text-3xl font-bold text-white">Layanan</h2>
            <p class="text-lg text-gray-300">Daftar Layanan Online Diskominfo</p>
        </div>

        <!-- Slider Component -->
        <div id="slider-container" class="relative w-full max-w-7xl mx-auto">
            <!-- Viewport -->
            <div id="slider-viewport" class="w-full overflow-hidden py-10">
                <!-- Track -->
                <div class="flex gap-8 ml-4 transition-transform duration-500 ease-in-out" id="slider-track">
                    <!-- Card 1 -->
                    <div class="flex-shrink-0 w-[80vw] sm:w-72 bg-white rounded-2xl shadow-md hover:shadow-xl p-6 text-center group hover:-translate-y-2 transition-all duration-300 cursor-pointer">
                        <div class="mx-auto w-20 h-20 flex items-center justify-center bg-orange-100 rounded-full">
                            <i class="fas fa-bullhorn text-3xl text-orange-500"></i>
                        </div>
                        <h3 class="mt-4 font-bold text-xl text-blue-950">Layanan Publik</h3>
                        <p class="mt-2 text-sm text-gray-600">Akses berbagai layanan publik Kota Bandung secara online.</p>
                    </div>
                    <!-- Card 2 -->
                    <div class="flex-shrink-0 w-[80vw] sm:w-72 bg-white rounded-2xl shadow-md hover:shadow-xl p-6 text-center group hover:-translate-y-2 transition-all duration-300 cursor-pointer">
                        <div class="mx-auto w-20 h-20 flex items-center justify-center bg-blue-100 rounded-full">
                            <i class="fas fa-database text-3xl text-blue-800"></i>
                        </div>
                        <h3 class="mt-4 font-bold text-xl text-blue-950">Open Data</h3>
                        <p class="mt-2 text-sm text-gray-600">Jelajahi dan manfaatkan data terbuka dari pemerintah kota.</p>
                    </div>
                    <!-- Card 3 -->
                    <div class="flex-shrink-0 w-[80vw] sm:w-72 bg-white rounded-2xl shadow-md hover:shadow-xl p-6 text-center group hover:-translate-y-2 transition-all duration-300 cursor-pointer">
                        <div class="mx-auto w-20 h-20 flex items-center justify-center bg-green-100 rounded-full">
                            <i class="fas fa-comments text-3xl text-green-600"></i>
                        </div>
                        <h3 class="mt-4 font-bold text-xl text-blue-950">Pengaduan</h3>
                        <p class="mt-2 text-sm text-gray-600">Sampaikan aspirasi dan pengaduan Anda dengan mudah.</p>
                    </div>
                    <!-- Card 4 -->
                    <div class="flex-shrink-0 w-[80vw] sm:w-72 bg-white rounded-2xl shadow-md hover:shadow-xl p-6 text-center group hover:-translate-y-2 transition-all duration-300 cursor-pointer">
                        <div class="mx-auto w-20 h-20 flex items-center justify-center bg-purple-100 rounded-full">
                            <i class="fas fa-chart-pie text-3xl text-purple-600"></i>
                        </div>
                        <h3 class="mt-4 font-bold text-xl text-blue-950">Info Grafis</h3>
                        <p class="mt-2 text-sm text-gray-600">Dapatkan informasi penting dalam format visual yang menarik.</p>
                    </div>
                    <!-- Card 5 -->
                    <div class="flex-shrink-0 w-[80vw] sm:w-72 bg-white rounded-2xl shadow-md hover:shadow-xl p-6 text-center group hover:-translate-y-2 transition-all duration-300 cursor-pointer">
                        <div class="mx-auto w-20 h-20 flex items-center justify-center bg-red-100 rounded-full">
                            <i class="fas fa-broadcast-tower text-3xl text-red-500"></i>
                        </div>
                        <h3 class="mt-4 font-bold text-xl text-blue-950">Radio Sonata</h3>
                        <p class="mt-2 text-sm text-gray-600">Dengarkan siaran radio resmi dari Pemerintah Kota Bandung.</p>
                    </div>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <button id="prev-slide" class="absolute top-1/2 -translate-y-1/2 bg-white w-12 h-12 rounded-full shadow-lg flex items-center justify-center text-blue-950 hover:bg-gray-200 transition left-0 -translate-x-1/2">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button id="next-slide" class="absolute top-1/2 -translate-y-1/2 bg-white w-12 h-12 rounded-full shadow-lg flex items-center justify-center text-blue-950 hover:bg-gray-200 transition right-0 translate-x-1/2">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>
</section>

{{-- <!-- PENGUMUMAN SECTION -->
<section class="py-16 bg-slate-100 pt-32">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative bg-white rounded-2xl shadow-lg p-8 pt-24 md:pt-8 flex flex-col md:flex-row items-center">
            <!-- Image Column -->
            <div class="absolute -top-20 md:top-auto md:relative md:-left-16 w-40 h-40 md:w-1/3 md:h-auto flex-shrink-0">
                <img src="{{ asset('pictures/pengumuman_women.png') }}" alt="Pengumuman" class="w-full h-full object-cover rounded-full md:rounded-2xl shadow-lg">
            </div>
            <!-- Text Column -->
            <div class="w-full text-center md:text-left md:pl-24">
                <span class="text-orange-500 font-semibold">Pengumuman</span>
                <h3 class="text-2xl font-bold text-blue-950 mt-1">Peresmian Bandung Sadayana</h3>
                <p class="mt-2 text-gray-600 max-w-2xl">Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptate blanditiis at voluptatibus magni quidem possimus, vitae tempora, itaque dolore dicta.</p>
                <div class="mt-6 flex items-center justify-center md:justify-start gap-4 text-sm text-gray-500">
                    <span><i class="fa-solid fa-calendar-alt mr-2"></i>14 Juli 2025</span>
                    <a href="#" class="font-bold text-orange-500 hover:underline">Lihat Selengkapnya &rarr;</a>
                </div>
            </div>
        </div>
    </div>
</section> --}}

{{-- <!-- AGENDA KEGIATAN SECTION -->
<section class="py-20 bg-slate-100">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-blue-950 text-center mb-12">Agenda Kegiatan</h2>
        <div class="max-w-4xl mx-auto space-y-8">
            <!-- Agenda Item 1 -->
            <div class="flex items-center gap-4 md:gap-8">
                <div class="flex-shrink-0 text-center bg-yellow-400 rounded-xl p-4 w-24">
                    <p class="text-4xl font-bold text-blue-950">04</p>
                    <p class="font-semibold text-blue-950">Juli</p>
                </div>
                <div class="flex-grow bg-white p-6 rounded-xl shadow-md">
                    <h3 class="font-bold text-xl text-blue-950">Peresmian Bandung Sadayana</h3>
                    <p class="text-sm text-gray-500 mt-1"><i class="fas fa-map-marker-alt mr-2"></i>Balai Kota Bandung</p>
                </div>
            </div>
            <!-- Agenda Item 2 -->
             <div class="flex items-center gap-4 md:gap-8">
                <div class="flex-shrink-0 text-center bg-yellow-400 rounded-xl p-4 w-24">
                    <p class="text-4xl font-bold text-blue-950">19</p>
                    <p class="font-semibold text-blue-950">Juli</p>
                </div>
                <div class="flex-grow bg-white p-6 rounded-xl shadow-md">
                    <h3 class="font-bold text-xl text-blue-950">Workshop Literasi Digital untuk UMKM</h3>
                     <p class="text-sm text-gray-500 mt-1"><i class="fas fa-map-marker-alt mr-2"></i>Hotel Grand Preanger</p>
                </div>
            </div>
            <!-- Agenda Item 3 -->
            <div class="flex items-center gap-4 md:gap-8">
                <div class="flex-shrink-0 text-center bg-yellow-400 rounded-xl p-4 w-24">
                    <p class="text-4xl font-bold text-blue-950">22</p>
                    <p class="font-semibold text-blue-950">Juli</p>
                </div>
                <div class="flex-grow bg-white p-6 rounded-xl shadow-md">
                    <h3 class="font-bold text-xl text-blue-950">Peluncuran Aplikasi Lapor Warga</h3>
                    <p class="text-sm text-gray-500 mt-1"><i class="fas fa-map-marker-alt mr-2"></i>Kantor Diskominfo</p>
                </div>
            </div>
        </div>
        <div class="text-center mt-12">
            <a href="#" class="bg-blue-950 text-white font-bold py-3 px-8 rounded-full hover:bg-blue-800 transition-colors">Lihat Agenda Detail</a>
        </div>
    </div>
</section> --}}

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


    // Jalankan fungsi saat halaman selesai dimuat
    document.addEventListener('DOMContentLoaded', function() {
        // Mulai jam
        setInterval(updateClock, 1000);
        updateClock();

        // Ambil data cuaca
        getWeather();

        // Inisialisasi slider
        initSlider();
    });

</script>
@endsection
