@extends('layouts.admin')

@section('title', 'Isi Folder - ' . $folder->title)

@section('content')
<div 
    x-data="photoGallery()" 
    x-init='init(@json($photos))'
    @keydown.escape.window="closeLightbox()"
    @keydown.arrow-right.window="if(showLightbox) nextPhoto()"
    @keydown.arrow-left.window="if(showLightbox) prevPhoto()"
    class="h-screen flex flex-col"
>

    <!-- 🔘 Header & Tombol Tambah -->
    <div class="sticky top-0 z-40 bg-white dark:bg-gray-800 md:px-10 shadow-md px-10 py-3 my-1 flex justify-between items-center">
        <h3 class="text-2xl font-semibold text-gray-900 dark:text-white">Manajemen Folder Galeri</h3>
    </div>

    <div class="flex-1 px-6 md:px-10 py-5 overflow-y-auto bg-gray-100 dark:bg-gray-900">
        {{-- BAGIAN 1: HEADER & FORM UPLOAD --}}
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md mb-8">
            <div class="flex flex-wrap justify-between items-center mb-4 gap-4">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $folder->title }}</h2>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $folder->description }}</p>
                </div>
                <a href="{{ route('admin.galeri.folders') }}" class="mt-6 inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-gray-800 rounded-lg shadow-md hover:bg-green-800 transition-colors">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Semua Folder
                </a>
            </div>
            
            <form action="{{ route('admin.galeri.photos.store', $folder) }}" method="POST" enctype="multipart/form-data"
                x-data="{ isUploading: false }"
                x-on:submit="isUploading = true"
                class="border-t dark:border-gray-700 pt-4">
                @csrf
                <label for="photos" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Upload Gambar Baru:</label>
                <div class="flex items-start gap-4">
                    <div class="flex-1">
                        <input type="file" name="photos[]" id="photos" multiple required class="block w-full text-sm text-gray-500 rounded-lg cursor-pointer file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-100 dark:file:bg-blue-900/50 file:text-blue-700 dark:file:text-blue-300 hover:file:bg-blue-200 dark:hover:file:bg-blue-800/50 @error('photos.*') border-red-500 @else border-gray-300 dark:border-gray-600 @enderror">
                        @error('photos.*')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400"><span class="font-medium">Oops!</span> {{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow-md transition whitespace-nowrap flex items-center gap-2">
                        <i class="fas fa-upload"></i>
                        <span>Upload</span>

                        <!-- Spinner muncul saat isUploading = true -->
                        <svg 
                            x-show="isUploading" 
                            class="animate-spin h-5 w-5 text-white" 
                            xmlns="http://www.w3.org/2000/svg" 
                            fill="none" 
                            viewBox="0 0 24 24"
                        >
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        {{-- BAGIAN 2: GRID FOTO DENGAN LIGHTBOX & TOMBOL HAPUS --}}
        <div class="columns-2 sm:columns-3 lg:columns-4 xl:columns-5 gap-4">
            @forelse ($photos as $index => $photo)
                <div class="mb-4 break-inside-avoid group relative">
                    {{-- Area Klik untuk Lightbox --}}
                    <div @click="openLightbox({{ $index }})" class="cursor-zoom-in">
                        <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Foto galeri" class="rounded-lg shadow-lg w-full group-hover:opacity-80 transition-opacity">
                    </div>

                    {{-- Tombol Hapus dengan @click.stop --}}
                    <button 
                        @click.stop="confirmPhotoDelete('{{ route('admin.galeri.photos.destroy', $photo->id) }}')"
                        title="Hapus foto ini"
                        class="absolute top-2 right-2 z-10 w-8 h-8 flex items-center justify-center bg-red-600/80 text-white rounded-full opacity-0 group-hover:opacity-100 transition-all hover:bg-red-700 focus:outline-none"
                    >
                        <i class="fas fa-trash-alt text-sm"></i>
                    </button>
                </div>
            @empty
                <p class="text-center text-gray-500">Belum ada gambar di folder ini.</p>
            @endforelse
        </div>
    </div>

    <div 
        x-show="showLightbox" 
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70"
        x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
    >
        <div
            class="relative w-full max-w-5xl mx-auto transform transition-all duration-300"
            @click.away="closeLightbox()"
            x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
        >
            <!-- Wrapper gambar dengan padding kiri/kanan untuk tombol -->
            <div class="relative flex items-center justify-center px-16">
                <!-- Gambar -->
                <img :src="currentPhoto.url" :alt="currentPhoto.caption" class="max-h-[75vh] w-auto object-contain rounded-lg shadow-2xl">

                <!-- Tombol Prev -->
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
            <button @click="closeLightbox()" class="absolute top-4 right-4 text-white text-3xl">&times;</button>
        </div>
    </div>


    {{-- BAGIAN 4: MODAL KONFIRMASI HAPUS FOTO --}}
    <div 
        x-show="showPhotoDeleteModal" 
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900 bg-opacity-70"
        x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
    >
        <div
            class="relative w-full max-w-md mx-auto bg-white dark:bg-gray-800 rounded-xl shadow-2xl transform transition-all duration-300"
            @click.away="showPhotoDeleteModal = false"
            x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
        >
            <!-- Konten modal hapus -->
            <div class="p-6 text-center">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                <h3 class="mt-5 text-lg font-medium text-gray-900 dark:text-white">Hapus Foto Ini?</h3>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Tindakan ini akan menghapus foto secara permanen dan tidak dapat dibatalkan.</p>
            </div>

            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 flex justify-center rounded-xl gap-4">
                <button @click="showPhotoDeleteModal = false" class="px-5 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">Batal</button>
                <form :action="deletePhotoUrl" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-5 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Notifikasi Sukses & Error --}}
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const Toast = Swal.mixin({ toast: true, position: 'top', showConfirmButton: false, timer: 3000, timerProgressBar: true });
                Toast.fire({ icon: 'success', title: @json(session('success')) });
            });
        </script>
    @endif
    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const Toast = Swal.mixin({ toast: true, position: 'top', showConfirmButton: false, timer: 4000, timerProgressBar: true });
                Toast.fire({ icon: 'error', title: @json(session('error')) });
            });
        </script>
    @endif
</div>
@endsection

@push('scripts')
<script>
function photoGallery() {
    return {
        photos: [], showLightbox: false, currentIndex: 0,
        showPhotoDeleteModal: false, deletePhotoUrl: '',

        init(initialPhotos = []) {
            this.photos = initialPhotos.map(photo => ({
                id: photo.id,
                path: photo.image_path,
                caption: `Foto ${photo.id}`
            }));
        },

        get currentPhoto() {
            const photo = this.photos[this.currentIndex] || {};
            return { ...photo, url: `{{ asset('storage') }}/${photo.path || ''}` };
        },
        get nextPhoto() {
            if (this.photos.length < 2) return this.currentPhoto;
            const nextIndex = (this.currentIndex + 1) % this.photos.length;
            return { ...this.photos[nextIndex], url: `{{ asset('storage') }}/${this.photos[nextIndex].path || ''}` };
        },
        get prevPhoto() {
            if (this.photos.length < 2) return this.currentPhoto;
            const prevIndex = (this.currentIndex - 1 + this.photos.length) % this.photos.length;
            return { ...this.photos[prevIndex], url: `{{ asset('storage') }}/${this.photos[prevIndex].path || ''}` };
        },
        openLightbox(index) {
            if (typeof index !== 'number' || index >= this.photos.length) return;
            this.currentIndex = index;
            this.showLightbox = true;
        },
        closeLightbox() { this.showLightbox = false; },
        nextPhoto() {
            if (this.photos.length === 0) return;
            this.currentIndex = (this.currentIndex + 1) % this.photos.length;
        },
        prevPhoto() {
            if (this.photos.length === 0) return;
            this.currentIndex = (this.currentIndex - 1 + this.photos.length) % this.photos.length;
        },
        confirmPhotoDelete(url) {
            this.deletePhotoUrl = url;
            this.showPhotoDeleteModal = true;
        }
    }
}
</script>
@endpush