<!DOCTYPE html>
<html lang="id"
    x-data="{ sidebarOpen: true}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manage Dokumen</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        primary: '#2196f3',
                        secondary: '#f50057'
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-100 dark:bg-gray-900 dark:text-white text-gray-900 font-sans"
    x-data="{
    showDeleteModal: false,
    deleteUrl: '',
    showDetailModal: false,
    detailData: {},
    formatIsi(content) {
        return content
            .split(/\r?\n\s*\r?\n/)
            .map(p => `<p>${p.trim().replace(/\r?\n/g, ' ')}</p>`)
            .join('');
    }
}">

    <div class="flex h-screen overflow-hidden">
        <x-admin.sidebar />

        <!-- Main Content -->
        <main class="flex-1 overflow-auto bg-gray-50 dark:bg-gray-900">
            <!-- Page Title & Create Button -->
            <div class="bg-white dark:bg-gray-800 shadow-md px-10 py-3 mb-6 flex justify-between items-center">
                <h3 class="font-semibold text-gray-800 dark:text-white">Manajemen Dokumen</h3>
                <a href="{{ route('admin.pengumuman.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow transition">
                    <i class="fas fa-plus mr-2"></i> Tambah Dokumen
                </a>
            </div>

            <!-- Kategori & Search Bar -->
            <!-- Filter & Search -->
            <div class="mb-6 px-10">
                <form method="GET" action="{{ route('admin.pengumuman.index') }}" class="flex gap-4 items-start w-full">
                    <!-- Tombol Kategori -->
                    <div class="relative" x-data="{ openKategori: false }">
                        <button type="button" @click="openKategori = !openKategori"
                            class="h-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 text-sm text-gray-800 flex items-center gap-2">
                            <i class="fas fa-filter"></i> Kategori
                        </button>

                        <!-- Dropdown Content -->
                        <div x-show="openKategori" @click.away="openKategori = false" x-transition
                            class="absolute z-40 mt-2 w-64 bg-white border border-gray-200 rounded shadow p-4 space-y-4">

                            <!-- STATUS -->
                            <div>
                                <div class="text-sm font-semibold text-gray-700 mb-1">Status</div>
                                <div class="flex gap-2 flex-wrap">
                                    @foreach(['publikasi', 'draft'] as $s)
                                    <label class="flex items-center gap-1 text-sm">
                                        <input type="checkbox" name="status[]" value="{{ $s }}" {{ in_array($s, request()->get('status', [])) ? 'checked' : '' }}>
                                        {{ ucfirst($s) }}
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- BIDANG -->
                            <div>
                                <div class="text-sm font-semibold text-gray-700 mb-1">Bidang</div>
                                <div class="flex flex-wrap gap-2 max-h-40 overflow-y-auto">
                                    @foreach($bidang as $b)
                                    <label class="flex items-center gap-1 text-sm w-full">
                                        <input type="checkbox" name="bidang[]" value="{{ $b->id }}" {{ in_array($b->id, request()->get('bidang', [])) ? 'checked' : '' }}>
                                        {{ $b->nama }}
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Tombol Terapkan -->
                            <button type="submit"
                                class="mt-3 w-full px-3 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700">
                                Terapkan
                            </button>
                        </div>
                    </div>

                    <!-- Kolom Search Panjang -->
                    <div class="flex-1">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari pengumuman..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none bg-white text-gray-800" />
                    </div>
                </form>
            </div>

            <!-- Tabel Dokumen -->
            <div class="px-10">
                <div class="bg-white rounded-lg overflow-auto shadow">
                    <table class="min-w-full text-sm text-left text-gray-700">
                        <thead class="bg-gray-100 text-xs uppercase text-gray-600">
                            <tr>
                                <th class="px-4 py-3">Nama Dokumen</th>
                                <th class="px-4 py-3">Deskripsi</th>
                                <th class="px-4 py-3">Kategori</th>
                                <th class="px-4 py-3">Tanggal</th>
                                <th class="px-4 py-3">Total Unduh</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($dokumens as $dokumen)
                            <tr>
                                <!-- Nama Dokumen -->
                                <td class="px-4 py-3 font-medium">{{ $dokumen->nama_dokumen }}</td>

                                <!-- Deskripsi -->
                                <td class="px-4 py-3">{{ $dokumen->deskripsi_dokumen }}</td>

                                <!-- Kategori -->
                                <td class="px-4 py-3">{{ $dokumen->kategori }}</td>

                                <!-- Tanggal -->
                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($dokumen->tanggal)->format('d M Y') }}</td>

                                <!-- Total Unduh -->
                                <td class="px-4 py-3">{{ $dokumen->total_unduh }}</td>

                                <!-- Aksi -->
                                <td class="px-4 py-3 text-center space-x-1">
                                    @php
                                    $lampiran = $dokumen->lampiran ? json_decode($dokumen->lampiran) : [];
                                    @endphp

                                    <!-- Tombol Detail -->
                                    <button type="button"
                                        @click="() => {
                                detailData = {
                                    nama_dokumen: @js($dokumen->nama_dokumen),
                                    tanggal: @js(\Carbon\Carbon::parse($dokumen->tanggal)->format('d M Y')),
                                    deskripsi_dokumen: @js($dokumen->deskripsi_dokumen),
                                    lampiran: @js($lampiran),
                                    total_unduh: @js($dokumen->total_unduh),
                                    kategori: @js($dokumen->kategori),
                                };
                                showDetailModal = true;
                            }"
                                        title="Detail"
                                        class="text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    <!-- Edit -->
                                    <a href="{{ route('admin.dokumen.edit', $dokumen->id) }}" class="text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-pen"></i>
                                    </a>

                                    <!-- Delete -->
                                    <button type="button"
                                        @click="showDeleteModal = true; deleteUrl = '{{ route('admin.dokumen.destroy', $dokumen->id) }}'"
                                        title="Hapus"
                                        class="text-red-600 hover:text-red-800">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Popup Detail -->
            <div
                x-show="showDetailModal"
                x-transition
                class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-start justify-center p-4 overflow-auto"
                style="display: none">
                <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full relative mt-10">
                    <button @click="showDetailModal = false" class="absolute top-4 right-4 text-gray-600 hover:text-black z-10">
                        <i class="fas fa-times"></i>
                    </button>
                    <div class="p-6 max-h-[90vh] overflow-y-auto">

                        <!-- Nama Dokumen -->
                        <h2 class="text-2xl font-semibold mb-4 text-gray-800" x-text="detailData.nama_dokumen"></h2>

                        <!-- Tanggal & Kategori -->
                        <div class="text-sm text-gray-600 mb-2">
                            <span class="font-semibold">Tanggal:</span> <span x-text="detailData.tanggal"></span>
                        </div>
                        <div class="text-sm text-gray-600 mb-4">
                            <span class="font-semibold">Kategori:</span> <span x-text="detailData.kategori"></span>
                        </div>

                        <!-- Deskripsi -->
                        <div class="text-sm text-gray-700 text-justify space-y-4 mb-6" x-text="detailData.deskripsi_dokumen"></div>

                        <!-- Total Unduh -->
                        <div class="mb-6 text-sm text-gray-600">
                            <span class="font-semibold">Total Unduh:</span> <span x-text="detailData.total_unduh"></span>
                        </div>

                        <!-- Lampiran -->
                        <div class="border-t pt-4">
                            <h3 class="text-md font-semibold mb-2 text-gray-800">Lampiran</h3>
                            <template x-if="detailData.lampiran && detailData.lampiran.length > 0">
                                <div class="space-y-2">
                                    <template x-for="(file, index) in detailData.lampiran" :key="index">
                                        <a :href="'/storage/' + file"
                                            target="_blank"
                                            class="text-blue-600 underline hover:text-blue-800 block">
                                            <span x-text="file.split('/').pop()"></span>
                                        </a>
                                    </template>
                                </div>
                            </template>
                            <template x-if="!detailData.lampiran || detailData.lampiran.length === 0">
                                <p class="text-gray-500 italic">Tidak ada lampiran.</p>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Popup Konfirmasi Delete -->
            <div
                x-show="showDeleteModal"
                x-transition
                class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center"
                style="display: none">
                <div class="bg-white rounded-lg p-6 w-full max-w-sm shadow-lg text-center">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Yakin ingin menghapus pengumuman ini?</h2>
                    <div class="flex justify-center gap-4 mt-6">
                        <button @click="showDeleteModal = false"
                            class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-sm font-medium">Batal</button>
                        <form :action="deleteUrl" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-4 py-2 rounded bg-red-600 hover:bg-red-700 text-white text-sm font-medium">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>

            @if (session('success') || session('error'))
            <div
                x-data="{ show: true }"
                x-init="setTimeout(() => show = false, 4000)"
                x-show="show"
                x-transition
                class="fixed bottom-6 right-6 px-6 py-4 rounded-lg shadow-lg text-white
               {{ session('success') ? 'bg-green-500' : 'bg-red-500' }}">
                {{ session('success') ?? session('error') }}
            </div>
            @endif

        </main>
    </div>
</body>

</html>