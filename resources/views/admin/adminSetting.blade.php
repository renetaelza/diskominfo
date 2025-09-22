@extends('layouts.admin')

@section('title', 'Admin|Setting')

@section('content')
<div class="h-screen flex flex-col">

    <div class="shrink-0 sticky top-0 z-40 bg-white dark:bg-gray-800 shadow-md px-6 md:px-10 h-14 mt-1 flex items-center">
        <h3 class="font-semibold text-gray-800 dark:text-white text-lg md:text-xl">Admin Setting</h3>
    </div>

    <div class="flex-1 overflow-y-auto bg-gray-200 p-6">
        <div class="max-w-xl mx-auto p-6">
            <form method="POST" action="{{ route('admin.setting.update') }}" class="space-y-4">
                @csrf
                @method('PUT')

                <!-- Section Username -->
                <div class="p-4 bg-white rounded-lg shadow">
                    <label class="block text-gray-700 dark:text-gray-300 mb-1">Username</label>
                    <input type="text" name="name" value="{{ old('name', auth('admin')->user()->name) }}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @error('name')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror

                    <button type="submit" name="action" value="username"
                        class="mt-3 w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg">
                        Simpan Username
                    </button>
                </div>

                <!-- Section Password -->
                <div class="p-4 bg-white rounded-lg shadow">
                    <!-- Password Lama -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 mb-1">Password Lama</label>
                        <div class="relative">
                            <input type="password" name="current_password" id="current_password"
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none pr-10">
                            <button type="button" onclick="togglePassword('current_password', this)"
                                class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                <!-- Icon mata -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-open" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <!-- Icon mata dicoret -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-slash hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.967 9.967 0 012.132-3.592M6.1 6.1A9.977 9.977 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.97 9.97 0 01-4.132 5.592M15 12a3 3 0 00-4.95-2.122M3 3l18 18"/>
                                </svg>
                            </button>
                        </div>
                        @error('current_password')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Baru -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 mb-1">Password Baru</label>
                        <div class="relative">
                            <input type="password" name="password" id="password"
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none pr-10">
                            <button type="button" onclick="togglePassword('password', this)"
                                class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                <!-- Icon mata -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-open" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <!-- Icon mata dicoret -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-slash hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.967 9.967 0 012.132-3.592M6.1 6.1A9.977 9.977 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.97 9.97 0 01-4.132 5.592M15 12a3 3 0 00-4.95-2.122M3 3l18 18"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 mb-1">Konfirmasi Password Baru</label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none pr-10">
                            <button type="button" onclick="togglePassword('password_confirmation', this)"
                                class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-open" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-slash hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.967 9.967 0 012.132-3.592M6.1 6.1A9.977 9.977 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.97 9.97 0 01-4.132 5.592M15 12a3 3 0 00-4.95-2.122M3 3l18 18"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit" name="action" value="password"
                        class="mt-3 w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 rounded-lg">
                        Simpan Password
                    </button>
                </div>
            </form>
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
function togglePassword(id, btn) {
    const input = document.getElementById(id);
    const eyeOpen = btn.querySelector('.eye-open');
    const eyeSlash = btn.querySelector('.eye-slash');

    if (input.type === "password") {
        input.type = "text";
        eyeOpen.classList.add('hidden');
        eyeSlash.classList.remove('hidden');
    } else {
        input.type = "password";
        eyeOpen.classList.remove('hidden');
        eyeSlash.classList.add('hidden');
    }
}
</script>
@endpush