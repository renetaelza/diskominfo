@extends('layouts.app')

@section('content')

{{-- Inisialisasi Alpine.js untuk Modal Player dengan logika anti-scroll --}}
<div x-data="{ showPlayer: false, videoId: '' }" 
     x-init="$watch('showPlayer', value => {
        if (value) {
            const scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;
            document.body.style.overflow = 'hidden';
            document.body.style.paddingRight = `${scrollbarWidth}px`;
        } else {
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
        }
     })">

    <!-- Header Halaman dengan Gambar Statis -->
    <header class="relative h-[300px] bg-cover bg-center" style="background-image: url('/pictures/video-page.jpg');">
        <div class="absolute inset-0 bg-black bg-opacity-60"></div>
        <div class="relative z-10 h-full flex flex-col items-center justify-center text-white text-center p-4">
            <h1 class="text-4xl md:text-5xl font-bold">Galeri Video</h1>
            <p class="mt-3 text-lg text-gray-300 max-w-2xl">Kumpulan video dokumentasi dan informasi dari kami.</p>
        </div>
    </header>

    <!-- Container Utama -->
    <div class="container mx-auto px-4 py-12 md:px-8 md:py-16">

        <!-- 1. Video Utama (Featured Video) -->
        @if ($featuredVideo)
        <section class="mb-12 md:mb-16">
            <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
                <!-- Kontainer Aspect Ratio untuk Video Responsif -->
                <div class="aspect-video w-full">
                    <iframe 
                        src="https://www.youtube.com/embed/{{ $featuredVideo->youtube_id }}?rel=0&showinfo=0" 
                        title="{{ $featuredVideo->title }}" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen
                        class="w-full h-full"
                    ></iframe>
                </div>
                <div class="p-5 md:p-6">
                    <h2 class="text-xl md:text-2xl font-bold text-gray-900">{{ $featuredVideo->title }}</h2>
                    <p class="mt-2 text-gray-600 text-base line-clamp-3">{{ $featuredVideo->description }}</p>
                </div>
            </div>
        </section>
        @endif

        <!-- 2. Grid Video Lainnya -->
        <section>
            <div class="flex flex-wrap justify-between items-center gap-4 mb-8">
                <h3 class="text-2xl md:text-3xl font-bold text-gray-800">Semua Video</h3>
                <!-- Form Pencarian -->
                <form action="{{ route('main.galeri.video') }}" method="GET" class="w-full sm:w-auto sm:max-w-xs">
                    <div class="relative">
                        <input 
                            type="text" 
                            name="search" 
                            placeholder="Cari video..." 
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-full focus:ring-blue-500 focus:border-blue-500 transition"
                            value="{{ request('search') }}"
                        >
                        <div class="absolute top-0 left-0 inline-flex items-center p-3 text-gray-400">
                           <i class="fas fa-search"></i>
                        </div>
                    </div>
                </form>
            </div>

            @if ($videos->isEmpty())
                <div class="text-center py-16">
                    <p class="text-gray-500 text-lg">
                        @if(request('search'))
                            Video dengan kata kunci "{{ request('search') }}" tidak ditemukan.
                        @else
                            Saat ini belum ada video yang tersedia.
                        @endif
                    </p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-8">
                    @foreach ($videos as $video)
                    <div 
                        @click="showPlayer = true; videoId = '{{ $video->youtube_id }}'"
                        class="group cursor-pointer bg-white rounded-lg shadow-md overflow-hidden transform hover:-translate-y-2 transition-all duration-300"
                    >
                        <div class="relative">
                            <img src="https://img.youtube.com/vi/{{ $video->youtube_id }}/mqdefault.jpg" alt="{{ $video->title }}" class="w-full h-40 object-cover">
                            <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <i class="fas fa-play-circle text-white text-5xl"></i>
                            </div>
                        </div>
                        <div class="p-4">
                            <h4 class="font-semibold text-gray-800 truncate" title="{{ $video->title }}">{{ $video->title }}</h4>
                            <p class="text-sm text-gray-500 mt-1">{{ $video->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Paginasi -->
                <div class="mt-12">
                    {{ $videos->appends(['search' => request('search')])->links() }}
                </div>
            @endif
        </section>
    </div>

    <!-- Modal Video Player -->
    <div 
        x-show="showPlayer" 
        x-cloak
        @keydown.escape.window="showPlayer = false"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-80"
        x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
    >
        <div 
            @click.away="showPlayer = false" 
            class="relative w-full max-w-4xl bg-black rounded-lg shadow-xl overflow-hidden"
            x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
        >
            <div class="aspect-video">
                <iframe 
                    :src="showPlayer ? `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0` : ''" 
                    frameborder="0" 
                    allow="autoplay; encrypted-media" 
                    allowfullscreen
                    class="w-full h-full"
                ></iframe>
            </div>
        </div>
    </div>

</div>

@endsection
