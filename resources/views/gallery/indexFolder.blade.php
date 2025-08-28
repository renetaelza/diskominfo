@extends('layouts.app')

@section('title', 'Galeri Foto')

@section('content')

<div x-data>
    <header class="relative h-[300px] bg-cover bg-center" style="background-image: url('/pictures/bg-fotoPage.png?text=Galeri+Foto');">
        <div class="absolute inset-0 bg-black bg-opacity-60"></div>
        <div class="relative z-10 h-full flex flex-col items-center justify-center text-white text-center p-4">
            <h1 class="text-4xl md:text-5xl font-bold">Galeri Foto</h1>
            <p class="mt-3 text-lg text-gray-300 max-w-2xl">Dokumentasi setiap kegiatan menarik yang tersimpan di folder kami.</p>
        </div>
    </header>

    <div class="container mx-auto px-4 py-12 md:px-8 md:py-16">

        <div class="mb-6">
            <form action="{{ route('main.galeri.foto') }}" method="GET">
                <div class="relative">
                    <input 
                        type="text" 
                        name="searchFolder" 
                        placeholder="Cari folder..." 
                        value="{{ $q ?? '' }}"
                        class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                    <div class="absolute top-0 left-0 h-full flex items-center px-3 text-gray-400">
                        <i class="fas fa-search"></i>
                    </div>
                </div>
            </form>
        </div>

        @if($folders->isNotEmpty())
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($folders as $folder)
                <a href="{{ route('main.galeri.folder.show', $folder) }}" class="text-decoration-none block">
                    <div class="rounded-2xl overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 card-news relative h-[350px]"
                         x-data="{ 
                             activeSlide: 1, 
                             isHovering: false, 
                             photoCount: {{ $folder->photos->count() }} 
                         }"
                         x-init="
                             setInterval(() => { 
                                 if (isHovering && photoCount > 1) { 
                                     activeSlide = (activeSlide % photoCount) + 1; 
                                 } 
                             }, 1500)
                         "
                         @mouseenter="isHovering = true"
                         @mouseleave="isHovering = false; activeSlide = 1">
                        
                        <div class="absolute inset-0">
                            @if($folder->photos->isNotEmpty())
                                @foreach($folder->photos as $photo)
                                    <div x-show="activeSlide === {{ $loop->iteration }}" 
                                         x-transition:enter="transition-opacity ease-in-out duration-500"
                                         x-transition:enter-start="opacity-0"
                                         x-transition:enter-end="opacity-100"
                                         x-transition:leave="transition-opacity ease-in-out duration-500"
                                         x-transition:leave-start="opacity-100"
                                         x-transition:leave-end="opacity-0"
                                         class="absolute inset-0">
                                        <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Foto {{ $folder->title }}" class="w-full h-full object-cover">
                                    </div>
                                @endforeach
                            @else
                                <div class="bg-gray-800 w-full h-full flex items-center justify-center">
                                    <i class="fas fa-camera fa-2x text-gray-500"></i>
                                </div>
                            @endif
                        </div>
                        
                        <div class="bg-black/70 text-white p-4 overlay absolute bottom-0 w-full">
                            <div class="text-sm mb-2 meta flex items-center gap-4">
                                <span class="flex items-center gap-2">
                                    <i class="fas fa-images"></i>
                                    {{ $folder->photos_count ?? 0 }} foto
                                </span>
                                <span class="flex items-center gap-2">
                                    <i class="fas fa-calendar"></i>
                                    {{ $folder->created_at->translatedFormat('d F Y') }}
                                </span>
                            </div>
                            <h5 class="font-semibold text-lg mb-3 fw-semibold line-clamp-2">
                                {{ $folder->title }}
                            </h5>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            {{-- PENAMBAHAN: Section Paginasi --}}
            <div class="mt-12">
                {{ $folders->links() }}
            </div>

        @else
            <div class="text-center py-16">
                <p class="text-gray-500 text-lg">
                    @if($q)
                        Folder dengan kata kunci "{{ $q }}" tidak ditemukan.
                    @else
                        Belum ada folder yang tersedia.
                    @endif
                </p>
            </div>
        @endif

    </div>
</div>

@endsection