@extends('layouts.admin')

@section('title', 'Aplikasi | Landing Page')

@section('content')
<div x-data="{
    showModal: false,
    showEditModal: false,
    editData: { id: null, judul: '', link: '' },
    editAction: '',
    openEdit(app) {
        this.editData.id = app.id;
        this.editData.judul = app.judul;
        this.editData.link = app.link;
        this.showEditModal = true;
    }
}" x-cloak>
    
    <!-- Header -->
    <div class="bg-white dark:bg-gray-800 shadow-md px-10 py-3 mb-6 flex justify-between items-center">
        <h3 class="font-semibold text-gray-800 dark:text-white">Aplikasi Landing Page</h3>
        <button 
            @click="showModal = true" 
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow text-sm"
        >
            <i class="fas fa-plus mr-2"></i> Tambah Aplikasi
        </button>
    </div>

    <!-- Tabel / Pesan Kosong -->
    <div class="px-10">
        <div class="bg-white rounded-lg overflow-auto shadow">
            @forelse($aplikasi as $app)
                @if ($loop->first)
                    <table class="min-w-full text-sm text-left text-gray-700">
                        <thead class="bg-gray-100 text-xs uppercase text-gray-600">
                            <tr>
                                <th class="px-4 py-3">Foto</th>
                                <th class="px-4 py-3">Nama Aplikasi</th>
                                <th class="px-4 py-3">Link</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                @endif

                            <tr>
                                <!-- Foto -->
                                <td class="px-4 py-3">
                                    @if($app->foto && Storage::disk('public')->exists(str_replace('storage/', '', $app->foto)))
                                        <img src="{{ asset($app->foto) }}" class="w-16 h-10 object-cover rounded" alt="Foto">
                                    @else
                                        <span class="text-gray-400 italic">Tidak ada</span>
                                    @endif
                                </td>

                                <!-- Judul -->
                                <td class="px-4 py-3 font-medium">{{ $app->judul }}</td>

                                <!-- Link -->
                                <td class="px-4 py-3">
                                    <a href="{{ $app->link }}" class="text-blue-500 hover:underline" target="_blank">{{ $app->link }}</a>
                                </td>

                                <!-- Aksi -->
                                <td class="px-4 py-3 text-center space-x-2">
                                    <a href="#" @click.prevent="openEdit({ id: {{ $app->id }}, judul: '{{ addslashes($app->judul) }}', link: '{{ addslashes($app->link) }}' })" class="text-green-600 hover:text-green-800">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form id="delete-form-{{ $app->id }}" action="{{ route('admin.aplikasi.landing.destroy', $app->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete({{ $app->id }})" class="text-red-600 hover:text-red-800">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                @if ($loop->last)
                        </tbody>
                    </table>
                @endif
            @empty
                <p class="text-center text-gray-500 italic py-6">Belum ada aplikasi landing page.</p>
            @endforelse
        </div>
    </div>

    {{-- Modal Input --}}
    <div
        x-show="showModal"
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4 transition-opacity duration-300 bg-gray-900 bg-opacity-70"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >
        <div
            class="relative w-full max-w-lg mx-auto my-6 bg-white dark:bg-gray-800 rounded-xl shadow-2xl overflow-hidden transform transition-all duration-300"
            @click.away="showModal = false"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
        >
            <!-- Header Modal -->
            <div class="flex items-center justify-between p-5 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Tambah Aplikasi Landing</h2>
                <button
                    type="button"
                    @click="showModal = false"
                    class="text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400 transition-colors"
                >
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Isi Form -->
            <div class="p-6 overflow-y-auto max-h-[70vh]">
                <form method="POST" action="{{ route('admin.aplikasi.landing.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Nama Aplikasi -->
                    <div class="space-y-1">
                        <label for="judul" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Aplikasi</label>
                        <input
                            id="judul"
                            type="text"
                            name="judul"
                            class="block w-full px-3 py-2 text-sm text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            required
                        >
                    </div>

                    <!-- Upload Gambar -->
                    <div class="space-y-1">
                        <label for="foto" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Foto</label>
                        <input
                            id="foto"
                            type="file"
                            name="foto"
                            class="block w-full text-sm text-gray-900 dark:text-white dark:file:text-gray-700 file:border-0 file:bg-gray-200 file:px-4 file:py-2 file:rounded-lg file:mr-4 file:font-semibold"
                            accept="image/*"
                            required
                        >
                    </div>

                    <!-- Link -->
                    <div class="space-y-1">
                        <label for="link" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Link</label>
                        <input
                            id="link"
                            type="url"
                            name="link"
                            class="block w-full px-3 py-2 text-sm text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            required
                        >
                    </div>

                    <!-- Tombol -->
                    <div class="flex justify-end pt-6 mt-6 border-t border-gray-200 dark:border-gray-700">
                        <button
                            type="button"
                            @click="showModal = false"
                            class="px-5 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600"
                        >
                            Batal
                        </button>
                        <button
                            type="submit"
                            class="ml-3 px-5 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700"
                        >
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Update --}}
    <div
        x-show="showEditModal"
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4 transition-opacity duration-300 bg-gray-900 bg-opacity-70"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >
        <div
            class="relative w-full max-w-lg mx-auto my-6 bg-white dark:bg-gray-800 rounded-xl shadow-2xl overflow-hidden transform transition-all duration-300"
            @click.away="showEditModal = false"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
        >
            <!-- Header Modal -->
            <div class="flex items-center justify-between p-5 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Update Aplikasi Landing</h2>
                <button type="button" @click="showEditModal = false"
                        class="text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Isi Form -->
            <div class="p-6 overflow-y-auto max-h-[70vh]">
                <form action="{{ route('admin.aplikasi.landing.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" :value="editData.id">

                    <div class="space-y-1">
                        <label for="edit_judul" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Aplikasi</label>
                        <input id="edit_judul" type="text" name="judul" x-model="editData.judul"
                            class="block w-full px-3 py-2 text-sm text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            required>
                    </div>

                    <div class="space-y-1">
                        <label for="edit_link" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Link</label>
                        <input id="edit_link" type="url" name="link" x-model="editData.link"
                            class="block w-full px-3 py-2 text-sm text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            required>
                    </div>

                    <div class="space-y-1">
                        <label for="edit_foto" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Foto</label>
                        <input id="edit_foto" type="file" name="foto" accept="image/*"
                            class="block w-full text-sm text-gray-900 dark:text-white dark:file:text-gray-700 file:border-0 file:bg-gray-200 file:px-4 file:py-2 file:rounded-lg file:mr-4 file:font-semibold">
                    </div>

                    <div class="flex justify-end pt-6 mt-6 border-t border-gray-200 dark:border-gray-700">
                        <button type="button" @click="showEditModal = false"
                                class="px-5 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                            Batal
                        </button>
                        <button type="submit"
                                class="ml-3 px-5 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Notifikasi Sukses/Error --}}
    @if (session('success') || session('error'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" 
             x-transition 
             class="fixed bottom-6 right-6 px-6 py-4 rounded-lg shadow-lg text-white 
                    {{ session('success') ? 'bg-green-500' : 'bg-red-500' }}">
            {{ session('success') ?? session('error') }}
        </div>
    @endif
</div>
@endsection
@push('scripts')
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>
@endpush
