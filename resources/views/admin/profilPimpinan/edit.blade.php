@extends('layouts.admin')

@section('title', 'Manajemen Profil Pimpinan')

@section('content')
    {{-- Header Bar --}}
    <div class="bg-white dark:bg-gray-800 shadow-md px-10 py-3 mb-6 flex justify-between items-center">
        <h3 class="font-semibold text-gray-800 dark:text-white">Manajemen Profil Pimpinan</h3>
    </div>

    <div class="px-10">
        {{-- Toast Notification --}}
        @if (session('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" x-transition
                class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
                role="alert">
                {{ session('success') }}
            </div>
        @endif
        
        @if ($errors->any())
            <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <form action="{{ route('admin.profil.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    {{-- Foto Pimpinan --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Foto Pimpinan</label>
                        <div class="flex items-center gap-6">
                            @if ($profile->photo_path)
                                <img src="{{ Storage::url($profile->photo_path) }}" alt="Foto Pimpinan" class="h-24 w-24 rounded-full object-cover">
                            @else
                                <div class="h-24 w-24 rounded-full bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-500">No Photo</span>
                                </div>
                            @endif
                            <input type="file" name="photo" class="block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-blue-50 file:text-blue-700
                                hover:file:bg-blue-100 dark:file:bg-gray-700 dark:file:text-gray-300 dark:hover:file:bg-gray-600">
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Kosongkan jika tidak ingin mengubah foto. Format: JPG, PNG, WEBP. Maks 2MB.</p>
                    </div>

                    {{-- Nama Pimpinan --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nama Pimpinan</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $profile->name) }}" required
                               class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    </div>

                    {{-- Jabatan --}}
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Jabatan / Gelar</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $profile->title) }}" required
                               class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none"
                               placeholder="Contoh: KEPALA DINAS KOMUNIKASI DAN INFORMATIKA">
                    </div>

                    {{-- Kata Sambutan --}}
                    <div>
                        <label for="welcome_message" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Kata Sambutan</label>
                        <textarea name="welcome_message" id="welcome_message" rows="8" required
                                  class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">{{ old('welcome_message', $profile->welcome_message) }}</textarea>
                    </div>
                </div>

                <div class="text-right mt-6">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection