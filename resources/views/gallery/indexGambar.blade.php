@extends('layouts.app')

@section('title', 'Galeri: ' . $folder->title)

@section('content')
<div 
    x-data="photoGallery()" 
    x-init='init(@json($photos->items()))'
    @keydown.escape.window="closeLightbox()"
    @keydown.arrow-right.window="if(showLightbox) nextPhoto()"
    @keydown.arrow-left.window="if(showLightbox) prevPhoto()"
>

    {{-- BAGIAN 1: LIGHTBOX / MODAL --}}
    <div 
        x-show="showLightbox" 
        x-cloak
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80"
    >
        <div
            x-show="showLightbox"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="relative w-full max-w-5xl mx-auto"
            @click.away="closeLightbox()"
        >
            <!-- Kontainer Gambar Utama -->
            <div class="relative flex items-center justify-center px-16">
                <!-- Tampilkan gambar yang sedang aktif -->
                <img :src="currentPhotoUrl" alt="Foto Galeri" class="max-h-[85vh] w-auto object-contain rounded-lg shadow-2xl">

                <!-- Tombol Previous -->
                <button 
                    @click.stop="prevPhoto()" 
                    class="absolute left-0 text-white text-5xl px-4 py-2 rounded-full hover:bg-black/50 transition"
                >&lsaquo;</button>

                <!-- Tombol Next -->
                <button 
                    @click.stop="nextPhoto()" 
                    class="absolute right-0 text-white text-5xl px-4 py-2 rounded-full hover:bg-black/50 transition"
                >&rsaquo;</button>
            </div>

            <!-- Tombol Close -->
            <button @click="closeLightbox()" class="absolute -top-2 -right-2 md:top-2 md:right-2 text-white bg-gray-800 rounded-full w-8 h-8 flex items-center justify-center">&times;</button>
        </div>
    </div>

    {{-- BAGIAN 2: KONTEN HALAMAN UTAMA --}}
    
    <!-- Header Halaman Detail -->
    <header class="relative h-[350px] bg-cover bg-center" style="background-image: url('{{ $photos->first() ? asset('storage/' . $photos->first()->image_path) : 'https://placehold.co/1920x400/333/FFF?text=Galeri' }}');">
        <div class="absolute inset-0 bg-black bg-opacity-60"></div>
        <div class="relative z-10 h-full flex flex-col items-center justify-center text-white text-center p-4">
            <h1 class="text-4xl md:text-5xl font-bold">{{ $folder->title }}</h1>
            @if($folder->description)
                <p class="mt-3 text-lg text-gray-300 max-w-3xl">{{ $folder->description }}</p>
            @endif
            <a href="{{ route('main.galeri.foto') }}" class="mt-6 inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-800 rounded-lg shadow-md hover:bg-gray-200 transition-colors">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Semua Folder
            </a>
        </div>
    </header>

    <div class="container mx-auto px-4 py-12 md:px-8">
        <!-- Galeri Foto dengan Layout Masonry -->
        @if($photos->isNotEmpty())
            <div class="columns-1 sm:columns-2 md:columns-3 lg:columns-4 xl:columns-5 gap-4">
                @foreach($photos as $index => $photo)
                    <div class="mb-4 break-inside-avoid group cursor-pointer" 
                         @click="openLightbox({{ $index }})">
                        <img src="{{ asset('storage/' . $photo->image_path) }}" 
                             alt="Foto dari galeri {{ $folder->title }}" 
                             class="w-full rounded-lg shadow-md hover:shadow-xl transform group-hover:scale-105 transition-all duration-300">
                    </div>
                @endforeach
            </div>

            <!-- Paginasi untuk foto -->
            <div class="mt-12">
                {{ $photos->links() }}
            </div>

        @else
            <div class="text-center py-16">
                <p class="text-gray-500 text-lg">
                    Folder ini belum memiliki foto.
                </p>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
function photoGallery() {
    return {
        photos: [], 
        showLightbox: false, 
        currentIndex: 0,

        init(initialPhotos = []) {
            this.photos = initialPhotos.map(photo => ({
                path: photo.image_path,
            }));
        },

        get currentPhotoUrl() {
            if (this.photos.length === 0) return '';
            const photo = this.photos[this.currentIndex] || {};
            return `{{ asset('storage') }}/${photo.path || ''}`;
        },
        
        openLightbox(index) {
            if (typeof index !== 'number' || index >= this.photos.length) return;
            this.currentIndex = index;
            this.showLightbox = true;
        },

        closeLightbox() { 
            this.showLightbox = false; 
        },

        nextPhoto() {
            if (this.photos.length === 0) return;
            this.currentIndex = (this.currentIndex + 1) % this.photos.length;
        },

        prevPhoto() {
            if (this.photos.length === 0) return;
            this.currentIndex = (this.currentIndex - 1 + this.photos.length) % this.photos.length;
        }
    }
}
</script>
@endpush
