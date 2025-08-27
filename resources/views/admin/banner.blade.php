@extends('layouts.admin')

@section('title', 'Admin|Banner')

@section('content')
<div x-data="heroBannerData()" class="h-screen flex flex-col">

    <div class="shrink-0 sticky top-0 z-40 bg-white dark:bg-gray-800 shadow-md px-6 md:px-10 h-14 mt-1 flex items-center">
        <h3 class="font-semibold text-gray-800 dark:text-white text-lg md:text-xl">Banner Utama</h3>
    </div>

    <div class="flex-1 overflow-y-auto bg-gray-200">
        <div class="mb-8 container mx-auto px-4 mt-6">
            <header class="relative bg-gray-800 text-white overflow-hidden rounded-lg shadow-md min-h-[60vh]">
                <img :src="previewImg 
                            ? previewImg 
                            : '{{ $hero?->img_banner ? asset('storage/'.$hero->img_banner) : asset('pictures/hero_landing.png') }}'" 
                    class="absolute inset-0 w-full h-full object-cover opacity-20 z-0">

                <div class="relative z-10 px-6 md:px-8 py-28 flex flex-col justify-center items-start">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight leading-snug text-white">
                        DINAS KOMUNIKASI DAN INFORMATIKA <span class="text-orange-400">KOTA BANDUNG</span>
                    </h1>

                    <p x-text="tagline ? tagline : '{{ $hero?->tagline ?? 'Belum ada tagline banner' }}'" 
                    class="mt-4 text-gray-200 text-lg md:text-xl max-w-full lg:max-w-3xl"></p>
                </div>
            </header>
        </div>

        <div class="container mx-auto px-4 mb-12">
            <div class="bg-gray-50 p-6 rounded-lg shadow-md">
                <form action="{{ route('admin.banner.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-5">
                        <label class="block font-medium mb-2 text-gray-700">Tagline</label>
                        <input type="text" name="tagline" x-model="tagline" 
                            class="w-full p-3 border border-gray-300 rounded-md focus:ring focus:ring-blue-300 focus:outline-none">
                    </div>

                    <div class="mb-5">
                        <label class="block font-medium mb-2 text-gray-700">Gambar Banner</label>
                        
                        <input type="file" name="img_banner" @change="previewFile($event)" 
                            class="w-full text-gray-700 border border-gray-300 rounded-md p-2 @error('img_banner') border-red-500 @enderror">
                        
                        <p class="text-sm text-gray-500 mt-1">Hanya menerima file gambar (jpg, png, webp) dengan ukuran maksimal 20MB.</p>
                        @error('img_banner')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" 
                            class="w-full bg-blue-600 text-white px-4 py-3 rounded-md hover:bg-blue-700 transition-colors font-semibold">
                        Update Banner
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@if (session('success') || session('error'))
    <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 4000)"
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-x-8"
        x-transition:enter-end="opacity-100 transform translate-x-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform translate-x-0"
        x-transition:leave-end="opacity-0 transform translate-x-8"
        class="fixed bottom-6 right-6 px-6 py-4 rounded-lg shadow-lg text-white z-50
        {{ session('success') ? 'bg-green-500' : 'bg-red-500' }}">
        
        {{ session('success') ?? session('error') }}
    </div>
@endif

@endsection

@push('scripts')
<script>
function heroBannerData() {
    return {
        tagline: '{{ $hero?->tagline ?? '' }}',
        previewImg: '',
        previewFile(event) {
            const file = event.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = e => { this.previewImg = e.target.result };
            reader.readAsDataURL(file);
        }
    }
}
</script>
@endpush