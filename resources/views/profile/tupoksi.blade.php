@extends('layouts.app')

@section('title', 'Tugas Pokok dan Fungsi')

@section('content')

{{-- Header Halaman --}}
<header class="relative h-[300px] bg-cover bg-center" style="background-image: url('/pictures/tupoksi.png');">
    <div class="absolute inset-0 bg-black/80"></div>
    <div class="relative z-10 h-full flex flex-col items-center justify-center text-white text-center p-4">
        <h1 class="text-4xl md:text-5xl font-bold">Tugas Pokok & Fungsi</h1>
        <p class="mt-3 text-lg text-gray-300 max-w-2xl">Dinas Komunikasi dan Informatika Kota Bandung</p>
    </div>
</header>

{{-- Konten Utama --}}
<div class="bg-gray-50">
    <div class="container mx-auto px-4 py-12 md:px-8 md:py-16">

        {{-- BAGIAN 1: TUPOKSI UTAMA DINAS --}}
        <div class="bg-white p-6 md:p-8 rounded-lg shadow-lg mb-12 border-l-4 border-blue-600">
            <div class="flex items-start gap-6 mb-6 border-b pb-4">
                {{-- Penambahan: Ikon Utama --}}
                <i class="fas fa-landmark text-4xl text-blue-600 mt-1"></i>
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Tupoksi Dinas Komunikasi dan Informatika</h2>
                    <p class="text-sm text-gray-500">Berdasarkan Peraturan Wali Kota Bandung Nomor 60 Tahun 2022</p>
                </div>
            </div>
            
            {{-- Penambahan: Layout 2 Kolom --}}
            <div class="grid md:grid-cols-2 md:gap-8">
                <div class="mb-6 md:mb-0">
                    <h3 class="text-xl font-semibold text-gray-700 mb-3 flex items-center gap-3"><i class="fas fa-bullseye"></i> Tugas Pokok</h3>
                    <p class="text-gray-600 leading-relaxed">{{ $tupoksiUtama['tugas'] }}</p>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-gray-700 mb-3 flex items-center gap-3"><i class="fas fa-tasks"></i> Fungsi</h3>
                    <ul class="space-y-2 text-gray-600">
                        @foreach ($tupoksiUtama['fungsi'] as $fungsi)
                            <li class="flex items-start gap-3">
                                <i class="fas fa-check-circle text-blue-500 mt-1"></i>
                                <span>{{ $fungsi }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 text-center">Tupoksi Bidang</h2>
            <div class="space-y-4">
                @php
                    // Array untuk memetakan nama bidang ke ikon Font Awesome
                    $icons = [
                        'Sekretariat Dinas' => 'fa-building-user',
                        'Bidang Perencanaan Teknologi Informasi dan Komunikasi' => 'fa-compass-drafting',
                        'Bidang Infrastruktur Teknologi Informasi dan Komunikasi' => 'fa-server',
                        'Bidang Diseminasi Informasi' => 'fa-bullhorn',
                        'Bidang Aplikasi Informatika, Persandian dan Keamanan Informasi' => 'fa-shield-halved',
                        'Bidang Data dan Statistik' => 'fa-chart-pie',
                    ];
                @endphp

                @foreach ($bidang as $b)
                <div x-data="{ open: false }" class="bg-white rounded-lg shadow-md transition-shadow hover:shadow-lg">
                    <button @click="open = !open" class="w-full flex justify-between items-center p-5 text-left gap-4">
                        <div class="flex items-center gap-4">
                            {{-- Penambahan: Ikon untuk setiap bidang --}}
                            <i class="fas {{ $icons[$b['nama']] ?? 'fa-sitemap' }} text-2xl text-blue-600 w-8 text-center"></i>
                            <span class="text-lg font-semibold text-gray-700">{{ $b['nama'] }}</span>
                        </div>
                        <i class="fas fa-chevron-down transition-transform duration-300" :class="{ 'rotate-180': open }"></i>
                    </button>
                    
                    <div x-show="open" x-transition class="p-5 border-t bg-gray-50/50">
                        <div class="grid md:grid-cols-2 md:gap-8">
                            <div class="mb-4 md:mb-0">
                                <h4 class="text-md font-semibold text-gray-700 mb-2">Tugas Pokok</h4>
                                <p class="text-gray-600 text-sm leading-relaxed">{{ $b['tugas'] }}</p>
                            </div>
                            <div>
                                <h4 class="text-md font-semibold text-gray-700 mb-2">Fungsi</h4>
                                <ul class="space-y-1 text-gray-600 text-sm">
                                    @foreach ($b['fungsi'] as $fungsi)
                                        <li class="flex items-start gap-2">
                                            <i class="fas fa-check text-blue-500 mt-1"></i>
                                            <span>{{ $fungsi }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
        {{-- Tombol Unduh PDF --}}
        <div class="text-center mt-16 bg-white p-8 rounded-lg shadow-lg">
            <h3 class="text-xl font-bold text-gray-800">Sumber Dokumen Resmi</h3>
            <p class="text-gray-600 max-w-xl mx-auto mt-2 mb-6">Informasi Tugas Pokok dan Fungsi ini didasarkan pada Peraturan Wali Kota Bandung yang berlaku. Anda dapat mengunduh dokumen lengkapnya dalam format PDF.</p>
            <a href="{{ asset('dokumen/2022pw3221060.pdf') }}" download class="inline-flex items-center gap-2 px-5 py-3 bg-gray-700 text-white rounded-lg shadow-md hover:bg-gray-800 transition-colors">
                <i class="fas fa-download"></i>
                Unduh Peraturan (PDF)
            </a>
        </div>

    </div>
</div>
@endsection
