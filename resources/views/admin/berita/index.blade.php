<!DOCTYPE html>
<html lang="id"
    x-data="{ sidebarOpen: true}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manage Berita</title>

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
                <h3 class="font-semibold text-gray-800 dark:text-white">Manajemen Berita</h3>
                <a href="{{ route('admin.berita.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow transition">
                    <i class="fas fa-plus mr-2"></i> Tambah Berita
                </a>
            </div>

            <!-- Kategori & Search Bar -->
            <!-- Filter & Search -->
            <div class="mb-6 px-10">
                <form method="GET" action="{{ route('admin.berita.index') }}" class="flex gap-4 items-start w-full">
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
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari berita..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none bg-white text-gray-800" />
                    </div>
                </form>
            </div>

            <!-- Tabel Berita -->
            <div class="px-10">
                <div class="bg-white rounded-lg overflow-auto shadow">
                    <table class="min-w-full text-sm text-left text-gray-700">
                        <thead class="bg-gray-100 text-xs uppercase text-gray-600">
                            <tr>
                                <th class="px-4 py-3">Foto</th>
                                <th class="px-4 py-3">Judul</th>
                                <th class="px-4 py-3">Kategori</th>
                                <th class="px-4 py-3">Tanggal</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Views</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($beritas as $berita)
                            <tr>
                                <!-- Foto -->
                                <td class="px-4 py-3">
                                    @php
                                    $fotoUtamaPath = 'storage/berita/' . $berita->id . '_utama.jpeg';
                                    @endphp
                                    @if (file_exists(public_path($fotoUtamaPath)))
                                    <img src="{{ asset($fotoUtamaPath) }}" class="w-16 h-10 object-cover rounded" alt="Foto Utama">
                                    @else
                                    <span class="text-gray-400 italic">Tidak ada</span>
                                    @endif
                                </td>

                                <!-- Judul -->
                                <td class="px-4 py-3 font-medium">{{ $berita->judul }}</td>

                                <!-- Kategori -->
                                <td class="px-4 py-3">{{ $berita->kategori->nama ?? '-' }}</td>

                                <!-- Tanggal -->
                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($berita->tanggal)->format('d M Y') }}</td>

                                <!-- Status -->
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 rounded-full text-xs font-medium
                    {{ $berita->status === 'publikasi' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700' }}">
                                        {{ ucfirst($berita->status) }}
                                    </span>
                                </td>

                                <!-- Views -->
                                <td class="px-4 py-3">
                                    @if($berita->status === 'draft')
                                    <span class="italic text-gray-500">Belum Publikasi</span>
                                    @else
                                    {{ $berita->views }} views
                                    @endif
                                </td>

                                <!-- Aksi -->
                                <td class="px-4 py-3 text-center space-x-1">
                                    <!-- Detail -->
                                    @php
                                    $fotoTambahan = $berita->foto_tambahan ? array_map(fn($p) => asset($p), json_decode($berita->foto_tambahan)) : [];
                                    @endphp

                                    <button type="button"
                                        @click="() => {
                                        detailData = {
                                            judul: @js($berita->judul),
                                            foto_utama: @js(asset($berita->foto_utama)),
                                            foto_tambahan: @js($fotoTambahan),
                                            isi_berita: @js($berita->isi_berita),
                                            kategori: @js($berita->kategori->nama ?? " -"),
                                        tanggal: @js(\Carbon\Carbon::parse($berita->tanggal)->format('d M Y'))
                                        };
                                        showDetailModal = true;
                                        }"
                                        title="Detail"
                                        class="text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    <!-- Edit -->
                                    <a href="{{ route('admin.berita.edit', $berita->id) }}" class="text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-pen"></i>
                                    </a>

                                    <!-- Delete -->
                                    <button type="button"
                                        @click="showDeleteModal = true; deleteUrl = '{{ route('admin.berita.destroy', $berita->id) }}'"
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

                        <!-- Judul -->
                        <h2 class="text-2xl font-semibold mb-4 text-gray-800" x-text="detailData.judul"></h2>

                        <!-- Foto Utama -->
                        <img :src="detailData.foto_utama" class="w-full h-[22rem] object-cover rounded mb-4" alt="Foto Utama" />

                        <!-- Foto Tambahan -->
                        <div class="flex gap-2 overflow-x-auto mb-4">
                            <template x-for="foto in detailData.foto_tambahan" :key="foto">
                                <div class="relative group">
                                    <img :src="foto" class="h-24 object-cover rounded shadow" />

                                    <!-- Overlay Tombol Preview -->
                                    <div
                                        class="absolute inset-0 bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center rounded cursor-pointer"
                                        @click="window.open(foto, '_blank')"
                                        title="Lihat gambar">
                                        <i class="fas fa-eye text-white text-lg"></i>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <!-- Kategori & Tanggal -->
                        <div class="text-sm text-gray-600 mb-2">
                            <span class="font-semibold">Kategori:</span> <span x-text="detailData.kategori"></span> |
                            <span class="font-semibold">Tanggal:</span> <span x-text="detailData.tanggal"></span>
                        </div>

                        <!-- Isi Berita -->
                        <div class="text-sm text-gray-700 text-justify space-y-4" x-html="formatIsi(detailData.isi_berita)"></div>
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
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Yakin ingin menghapus berita ini?</h2>
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