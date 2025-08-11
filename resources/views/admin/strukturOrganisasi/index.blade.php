@extends('layouts.admin')

@section('title', 'Struktur Organisasi')

@section('content')
<div x-data="pegawaiModal()" x-cloak>
    <!-- Tambahkan style untuk x-cloak -->
    <style>[x-cloak] { display: none !important; }</style>

    <!-- 🔘 Header & Tombol Tambah -->
    <div class="bg-white dark:bg-gray-800 shadow-md px-10 py-3 mb-6 flex justify-between items-center">
        <h3 class="font-semibold text-gray-800 dark:text-white">Struktur Organisasi</h3>
        <button 
            @click="showModal = true" 
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow text-sm"
        >
            <i class="fas fa-plus mr-2"></i> Tambah Pegawai
        </button>
    </div>

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
            class="relative w-full max-w-2xl mx-auto my-6 bg-white dark:bg-gray-800 rounded-xl shadow-2xl overflow-hidden transform transition-all duration-300 sm:w-full sm:mx-0"
            @click.away="showModal = false"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
        >
            <div class="flex items-center justify-between p-5 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Tambah Pegawai</h2>
                <button
                    type="button"
                    @click="showModal = false"
                    class="text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400 transition-colors"
                >
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <div class="p-6 overflow-y-auto max-h-[70vh]">
                <form method="POST" action="{{ route('admin.strukturOrganisasi.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="sm:col-span-2 space-y-1">
                            <label for="add-nama" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama</label>
                            <input
                                id="add-nama"
                                type="text"
                                name="nama"
                                class="block w-full px-3 py-2 text-sm text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                required
                            >
                        </div>

                        <div class="sm:col-span-2 space-y-1">
                            <label for="add-nip" class="block text-sm font-medium text-gray-700 dark:text-gray-300">NIP</label>
                            <input
                                id="add-nip"
                                type="text"
                                name="nip"
                                class="block w-full px-3 py-2 text-sm text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                required
                            >
                        </div>

                        <div class="space-y-1">
                            <label for="add-bidang" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bidang</label>
                            <select
                                id="add-bidang"
                                name="bidang_id"
                                x-model="tambahData.bidang_id"
                                @change="updateBidang"
                                class="block w-full px-3 py-2 text-sm text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                required
                            >
                                <option value="">Pilih Bidang</option>
                                @foreach ($bidang as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-1">
                            <label for="add-jabatan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jabatan</label>
                            <input
                                id="add-jabatan"
                                type="text"
                                name="jabatan"
                                class="block w-full px-3 py-2 text-sm text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            >
                        </div>

                        <div class="sm:col-span-2 space-y-1">
                            <label for="add-atasan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Atasan</label>
                            <select
                                id="add-atasan"
                                name="atasan_id"
                                x-model="tambahData.atasan_id"
                                x-bind:disabled="isKepalaDinas"
                                class="block w-full px-3 py-2 text-sm text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            >
                                <option value="">Tidak ada</option>
                                @foreach ($pegawai as $atasan)
                                    <option value="{{ $atasan->id }}">{{ $atasan->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="sm:col-span-2 space-y-1">
                            <label for="add-alamat" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Alamat</label>
                            <textarea
                                id="add-alamat"
                                name="alamat"
                                rows="2"
                                class="block w-full px-3 py-2 text-sm text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            ></textarea>
                        </div>

                        <div class="sm:col-span-2 space-y-1">
                            <label for="add-tupoksi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tupoksi</label>
                            <textarea
                                id="add-tupoksi"
                                name="tupoksi"
                                rows="4"
                                class="block w-full px-3 py-2 text-sm text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            ></textarea>
                        </div>

                        <div class="sm:col-span-2 space-y-1">
                            <label for="add-foto" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Foto (Opsional)</label>
                            <input
                                id="add-foto"
                                type="file"
                                name="foto"
                                class="block w-full text-sm text-gray-900 dark:text-white dark:file:text-gray-700 file:border-0 file:bg-gray-200 file:px-4 file:py-2 file:rounded-lg file:mr-4 file:font-semibold"
                                accept="image/*"
                            >
                        </div>

                        <div class="sm:col-span-2 flex items-center space-x-2 pt-2">
                            <input type="hidden" name="is_assistant" value="0">
                            <input
                                type="checkbox"
                                name="is_assistant"
                                x-model="tambahData.is_assistant"
                                x-bind:disabled="isKepalaDinas"
                                class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:bg-gray-600 dark:border-gray-500"
                                value="1"
                            >
                            <label class="text-sm text-gray-700 dark:text-gray-300">Asisten (Membuat Garis Horizontal di Struktur)</label>
                        </div>
                    </div>

                    <div class="flex justify-end pt-6 mt-6 border-t border-gray-200 dark:border-gray-700">
                        <button
                            type="button"
                            @click="showModal = false"
                            class="px-5 py-2 text-sm font-medium text-gray-700 transition-colors bg-gray-200 rounded-lg hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600"
                        >
                            Batal
                        </button>
                        <button
                            type="submit"
                            class="ml-3 inline-flex items-center px-5 py-2 text-sm font-medium text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700"
                        >
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Detail Pegawai -->
    <div
        x-show="showDetail"
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
            class="relative w-full max-w-2xl mx-auto my-6 bg-white dark:bg-gray-800 rounded-xl shadow-2xl overflow-hidden transform transition-all duration-300 sm:w-full sm:mx-0"
            @click.away="showDetail = false"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
        >
            <div class="relative p-8 bg-blue-600 dark:bg-blue-800 text-white text-center">
                <button
                    type="button"
                    @click="showDetail = false"
                    class="absolute top-3 right-3 text-white/80 hover:text-white transition-colors"
                >
                    <i class="fas fa-times text-xl"></i>
                </button>
                
                <img
                    :src="detailPegawai.foto_url"
                    alt="Foto Pegawai"
                    class="w-32 h-32 mx-auto mb-4 object-cover rounded-full border-4 border-white shadow-lg"
                >
                <h2 class="text-2xl font-bold" x-text="detailPegawai.nama"></h2>
                <p class="text-sm font-light opacity-80" x-text="detailPegawai.jabatan"></p>
            </div>

            <div class="p-6 md:p-8 overflow-y-auto max-h-[60vh] text-gray-900 dark:text-gray-200">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="font-semibold text-gray-500 dark:text-gray-400">NIP</p>
                        <p x-text="detailPegawai.nip || 'Tidak Ada'"></p>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-500 dark:text-gray-400">Bidang</p>
                        <p x-text="detailPegawai.bidang || 'Tidak Ada'"></p>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-500 dark:text-gray-400">Atasan</p>
                        <p x-text="detailPegawai.atasan || 'Tidak Ada'"></p>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-500 dark:text-gray-400">Asisten</p>
                        <p x-text="detailPegawai.is_assistant ? 'Ya' : 'Tidak'"></p>
                    </div>
                </div>

                <div class="mt-6">
                    <h3 class="font-semibold text-gray-500 dark:text-gray-400 mb-1">Alamat</h3>
                    <p class="text-sm" x-text="detailPegawai.alamat || 'Tidak Ada'"></p>
                </div>

                <div class="mt-6">
                    <h3 class="font-semibold text-gray-500 dark:text-gray-400 mb-1">Tupoksi</h3>
                    <p class="text-sm whitespace-pre-line leading-relaxed" x-text="detailPegawai.tupoksi || 'Tidak Ada'" style="word-wrap: break-word;"></p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal Edit -->
    <div
        x-show="editModalOpen"
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
            class="relative w-full max-w-2xl mx-auto my-6 bg-white dark:bg-gray-800 rounded-xl shadow-2xl overflow-hidden transform transition-all duration-300 sm:w-full sm:mx-0"
            @click.away="editModalOpen = false"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
        >
            <div class="flex items-center justify-between p-5 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Edit Pegawai</h2>
                <button
                    type="button"
                    @click="editModalOpen = false"
                    class="text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400 transition-colors"
                >
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <div class="p-6 overflow-y-auto max-h-[70vh]">
                <form :action="`/admin/struktur-organisasi/edit-pegawai/${editData.id}`" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div class="space-y-1">
                            <label for="edit-nama" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama</label>
                            <input
                                id="edit-nama"
                                type="text"
                                name="nama"
                                x-model="editData.nama"
                                class="block w-full px-3 py-2 text-sm text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                required
                            >
                        </div>

                        <div class="space-y-1">
                            <label for="edit-nip" class="block text-sm font-medium text-gray-700 dark:text-gray-300">NIP</label>
                            <input
                                id="edit-nip"
                                type="text"
                                name="nip"
                                x-model="editData.nip"
                                class="block w-full px-3 py-2 text-sm text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            >
                        </div>

                        <div class="space-y-1">
                            <label for="edit-jabatan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jabatan</label>
                            <input
                                id="edit-jabatan"
                                type="text"
                                name="jabatan"
                                x-model="editData.jabatan"
                                class="block w-full px-3 py-2 text-sm text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            >
                        </div>

                        <div class="space-y-1">
                            <label for="edit-bidang" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bidang</label>
                            <select
                                id="edit-bidang"
                                name="bidang_id"
                                x-model="editData.bidang_id"
                                @change="updateBidang"
                                class="block w-full px-3 py-2 text-sm text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            >
                                @foreach ($bidang as $b)
                                    <option value="{{ $b->id }}">{{ $b->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-1">
                            <label for="edit-atasan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Atasan</label>
                            <select
                                id="edit-atasan"
                                name="atasan_id"
                                x-model="editData.atasan_id"
                                x-bind:disabled="isKepalaDinas"
                                class="block w-full px-3 py-2 text-sm text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            >
                                <option value="">Tidak ada</option>
                                @foreach ($pegawai as $atasan)
                                    <option value="{{ $atasan->id }}">{{ $atasan->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-1">
                            <label for="edit-alamat" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Alamat</label>
                            <input
                                id="edit-alamat"
                                type="text"
                                name="alamat"
                                x-model="editData.alamat"
                                class="block w-full px-3 py-2 text-sm text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            >
                        </div>
                    </div>

                    <div class="mt-6 space-y-1">
                        <label for="edit-tupoksi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tupoksi</label>
                        <textarea
                            id="edit-tupoksi"
                            name="tupoksi"
                            x-model="editData.tupoksi"
                            rows="4"
                            class="block w-full px-3 py-2 text-sm text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        ></textarea>
                    </div>

                    <div class="mt-6 flex items-center space-x-2">
                        <input type="hidden" name="is_assistant" value="0">
                        <input
                            type="checkbox"
                            name="is_assistant"
                            x-model="editData.is_assistant"
                            x-bind:disabled="isKepalaDinas"
                            value="1"
                            class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:bg-gray-600 dark:border-gray-500"
                        >
                        <label class="text-sm text-gray-700 dark:text-gray-300">Asisten</label>
                    </div>

                    <div class="flex justify-end pt-6 mt-6 border-t border-gray-200 dark:border-gray-700">
                        <button
                            type="button"
                            @click="editModalOpen = false"
                            class="px-5 py-2 text-sm font-medium text-gray-700 transition-colors bg-gray-200 rounded-lg hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600"
                        >
                            Batal
                        </button>
                        <button
                            type="submit"
                            class="ml-3 inline-flex items-center px-5 py-2 text-sm font-medium text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700"
                        >
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });

                Toast.fire({
                    icon: 'success',
                    title: @json(session('success'))
                });
            });
        </script>
    @endif

    <!-- 🔳 Layout Konten -->
    <div class="flex gap-4 px-6">
        <div class="w-3/4 bg-gray-100 dark:bg-gray-900 rounded-lg shadow-md p-4 min-h-[820px]">
            <h3 class="text-gray-600 dark:text-gray-300 font-semibold mb-2">Preview Struktur Organisasi</h3>
            <div id="tree" class="h-[750px] overflow-auto"></div>
        </div>


        <div class="w-1/4 flex flex-col gap-4">
            <div class="flex items-center w-full relative">
                <input
                    id="search-input"
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nama pegawai..."
                    class="flex-1 p-3 pl-10 pr-4 text-sm border bg-white text-gray-700 border-gray-700 rounded-full focus:outline-none focus:ring-1 focus:ring-blue-500 transition duration-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                />
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                @if(request('search'))
                    <button
                        type="button"
                        id="clear-search-btn"
                        onclick="clearSearch()"
                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-red-500 transition-colors"
                        title="Hapus Pencarian"
                    >
                        <i class="fas fa-times-circle"></i>
                    </button>
                @endif
            </div>

            <div id="daftar-pegawai-container" class="overflow-y-auto max-h-[730px] grid gap-3 pr-2">
                @forelse($pegawai as $item)
                    <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-xl hover:shadow-2xl transition duration-300 hover:-translate-y-1 hover:scale-[1.02]">
                        <div>
                            <h4 class="font-semibold text-gray-800 dark:text-white">{{ $item->nama }}</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-300">
                                {{ $item->jabatan }} - {{ $item->bidang->nama ?? '-' }}
                            </p>
                        </div>
                        <div class="flex gap-2 mt-2">
                            @php
                                $fotoUrl = $item->foto 
                                    ? asset('storage/foto_pegawai/' . $item->foto) 
                                    : asset('pictures/default-user.png');

                                $detail = [
                                    'id' => $item->id,
                                    'nama' => $item->nama,
                                    'nip' => $item->nip,
                                    'jabatan' => $item->jabatan,
                                    'bidang_id' => $item->bidang_id,
                                    'atasan_id' => $item->atasan_id,
                                    'alamat' => $item->alamat,
                                    'tupoksi' => $item->tupoksi,
                                    'is_assistant' => (bool) $item->is_assistant,
                                    'foto_url' => $fotoUrl,

                                    'bidang' => $item->bidang->nama ?? '-', 
                                    'atasan' => $item->atasan->nama ?? '-',
                                ];

                                $detailJson = json_encode($detail, JSON_HEX_QUOT | JSON_HEX_APOS);
                            @endphp

                            <button
                                @click='openDetailModal({{ $detailJson }})'
                                class="text-green-600 hover:text-green-800 text-sm"
                                title="Lihat Detail"
                            >
                                <i class="fas fa-eye"></i>
                            </button>

                            <!-- Tombol Edit -->
                            <button
                                @click='openEditModal({{ $detailJson }})'
                                class="text-blue-600 hover:text-blue-800 text-sm"
                                title="Edit Pegawai"
                            >
                                <i class="fas fa-pen"></i>
                            </button>


                            <button onclick="confirmDelete({{ $item->id }})" class="text-red-600 hover:text-red-800">
                                <i class="fas fa-trash"></i>
                            </button>

                            <form id="delete-form-{{ $item->id }}" action="{{ route('admin.strukturOrganisasi.destroy', $item->id) }}" method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-300">Belum ada data pegawai.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://balkan.app/js/OrgChart.js"></script>
<script>

    document.addEventListener("DOMContentLoaded", function() {
        // Ambil data pegawai dari Laravel dan konversi ke JSON
        // Pastikan variabel $pegawai dikirim dari controller
        const pegawaiData = @json($pegawai);

        // Buat array nodes dari data pegawai
        const nodes = pegawaiData.map(p => {
            // Siapkan array tags
            const tags = [];
            
            // Periksa jika pegawai adalah asisten (nilai 1)
            // Tambahkan tag 'assistant' jika kondisi terpenuhi
            if (p.is_assistant == 1) {
                tags.push("assistant");
            }

            const fotoUrl = p.foto 
            ? `{{ asset('storage/foto_pegawai') }}/${p.foto}` 
            : `{{ asset('pictures/default-user.png') }}`;
            
            return {
                id: p.id,
                pid: p.atasan_id,
                name: p.nama,
                title: p.jabatan,
                // Pastikan foto_url tersedia di objek pegawai
                img: fotoUrl,
                tupoksi: p.tupoksi,
                // Masukkan array tags ke dalam node
                tags: tags
            };
        });

        // Inisialisasi OrgChart dengan konfigurasi yang diperbarui
        const chart = new OrgChart(document.getElementById("tree"), {
            template: "rony",
            enableSearch: false,
            nodes: nodes,
            nodeMenu: null,
            nodeMouseClick: OrgChart.action.none,
            nodeBinding: {
                field_0: "name",
                field_1: "title",
                img_0: "img"
            },
            tags: {
                "assistant": {
                    template: "rony" 
                }
            }
        });

        const searchInput = document.getElementById('search-input');
        const daftarPegawaiContainer = document.getElementById('daftar-pegawai-container');
        
        // Asumsi fungsi openDetailModal, openEditModal, dan confirmDelete sudah ada di Alpine.js atau global scope.
        // Kita akan pastikan mereka bisa diakses dari window object.
        window.openDetailModal = function(pegawai) {
            // Logika untuk membuka modal detail
            // Ini akan memicu Alpine.data('pegawaiModal')
            const pegawaiModalData = document.querySelector('[x-data="pegawaiModal()"]')._x_dataStack[0];
            pegawaiModalData.openDetailModal(pegawai);
        }
        
        window.openEditModal = function(pegawai) {
            // Logika untuk membuka modal edit
            // Ini akan memicu Alpine.data('pegawaiModal')
            const pegawaiModalData = document.querySelector('[x-data="pegawaiModal()"]')._x_dataStack[0];
            pegawaiModalData.openEditModal(pegawai);
        }

        // Fungsi untuk merender ulang daftar pegawai
        function renderDaftarPegawai(pegawaiData) {
            let html = '';
            if (pegawaiData.length === 0) {
                html = '<p class="text-gray-500 dark:text-gray-300">Tidak ada data pegawai yang ditemukan.</p>';
            } else {
                pegawaiData.forEach(p => {
                    const fotoUrl = p.foto ? `/storage/foto_pegawai/${p.foto}` : '/pictures/default-user.png';
                    const bidangNama = p.bidang ? p.bidang.nama : '-';
                    const atasanNama = p.atasan ? p.atasan.nama : '-';
                    
                    // Objek detail yang akan dikirim ke Alpine.js
                    const detail = {
                        id: p.id,
                        nama: p.nama,
                        nip: p.nip,
                        jabatan: p.jabatan,
                        bidang_id: p.bidang_id,
                        atasan_id: p.atasan_id,
                        alamat: p.alamat,
                        tupoksi: p.tupoksi,
                        is_assistant: p.is_assistant,
                        foto_url: fotoUrl,
                        bidang: bidangNama, 
                        atasan: atasanNama 
                    };

                    const detailJson = encodeURIComponent(JSON.stringify(detail));
                    html += `
                        <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-xl hover:shadow-2xl transition duration-300 hover:-translate-y-1 hover:scale-[1.02]">
                            <div>
                                <h4 class="font-semibold text-gray-800 dark:text-white">${p.nama}</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-300">
                                    ${p.jabatan} - ${bidangNama}
                                </p>
                            </div>
                            <div class="flex gap-2 mt-2">
                                <button
                                    onclick='openDetailModal(JSON.parse(decodeURIComponent("${detailJson}")))'
                                    class="text-green-600 hover:text-green-800 text-sm"
                                    title="Lihat Detail"
                                >
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button
                                    onclick='openEditModal(JSON.parse(decodeURIComponent("${detailJson}")))'
                                    class="text-blue-600 hover:text-blue-800 text-sm"
                                    title="Edit Pegawai"
                                >
                                    <i class="fas fa-pen"></i>
                                </button>
                                <button onclick="confirmDelete(${p.id})" class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <form id="delete-form-${p.id}" action="/admin/struktur-organisasi/${p.id}" method="POST" class="hidden">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="_method" value="DELETE">
                                </form>
                            </div>
                        </div>
                    `;
                });
            }
            daftarPegawaiContainer.innerHTML = html;
        }

        // Fungsi utama untuk mengambil data via AJAX dan merender ulang
        function fetchAndRenderData(searchTerm = '') {
            const url = `{{ route('admin.strukturOrganisasi.index') }}?search=${searchTerm}`;
            
            daftarPegawaiContainer.innerHTML = '<p class="text-gray-500 dark:text-gray-300">Mencari...</p>';

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                renderDaftarPegawai(data);
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                daftarPegawaiContainer.innerHTML = '<p class="text-red-500">Gagal memuat data.</p>';
            });
        }

        // Debounce untuk pencarian
        let typingTimer;
        searchInput.addEventListener('input', () => {
            clearTimeout(typingTimer);
            const searchTerm = searchInput.value;
            typingTimer = setTimeout(() => {
                fetchAndRenderData(searchTerm);
            }, 500); 
        });
        
        // Fungsi untuk membersihkan pencarian
        window.clearSearch = function() {
            searchInput.value = '';
            fetchAndRenderData('');
        };

        // Panggil fungsi saat halaman dimuat pertama kali jika ada pencarian awal
        const initialSearchTerm = searchInput.value;
        if (initialSearchTerm) {
            fetchAndRenderData(initialSearchTerm);
        }
    });

    function confirmDelete(id) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: 'Data tidak bisa dikembalikan setelah dihapus!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-form-${id}`).submit();
            }
        })
    }

    document.addEventListener('alpine:init', () => {
        Alpine.data('pegawaiModal', () => ({
            showModal: false, // Untuk modal tambah
            showDetail: false,
            editModalOpen: false,

            // Data untuk modal Tambah Pegawai
            tambahData: {
                bidang_id: '',
                is_assistant: false,
                atasan_id: ''
            },
            
            // Data untuk modal Edit Pegawai
            editData: {
                id: null,
                nama: '',
                nip: '',
                jabatan: '',
                bidang_id: '',
                atasan_id: '',
                alamat: '',
                tupoksi: '',
                is_assistant: false,
                foto_url: ''
            },

            // Data untuk Modal Detail Pegawai
            detailPegawai: {
                id: null,
                nama: '',
                nip: '',
                jabatan: '',
                bidang_id: '',
                atasan_id: '',
                alamat: '',
                tupoksi: '',
                is_assistant: false,
                foto_url: ''
            },

            // Properti computed tunggal untuk mendeteksi Kepala Dinas
            get isKepalaDinas() {
                const bidang = @json($bidang);
                let selectedBidangId = null;

                if (this.showModal) {
                    selectedBidangId = this.tambahData.bidang_id;
                } else if (this.editModalOpen) {
                    selectedBidangId = this.editData.bidang_id;
                }

                if (!selectedBidangId) return false;

                const selectedBidang = bidang.find(b => b.id == selectedBidangId);
                return selectedBidang?.nama.toLowerCase().includes('kepala dinas') ?? false;
            },

            // Fungsi tunggal untuk memperbarui state saat bidang berubah di modal manapun
            updateBidang() {
                if (this.isKepalaDinas) {
                    if (this.showModal) {
                        this.tambahData.atasan_id = '';
                        this.tambahData.is_assistant = false;
                    } else if (this.editModalOpen) {
                        this.editData.atasan_id = '';
                        this.editData.is_assistant = false;
                    }
                }
            },

            // Fungsi untuk membuka modal tambah, mereset form jika perlu
            openTambahModal() {
                this.tambahData = {
                    bidang_id: '',
                    is_assistant: false,
                    atasan_id: ''
                };
                this.showModal = true;
            },

            openDetailModal(pegawai) {
                this.detailPegawai = pegawai;
                this.showDetail = true;
            },

            openEditModal(pegawai) {
                this.editData = pegawai;
                this.editModalOpen = true;
                this.updateBidang();
            },
        }));
    });
</script>
@endpush


