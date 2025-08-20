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
            <div x-data="kategoriDokumenForm()" x-init="init()">
                <div class="bg-white dark:bg-gray-800 shadow-md px-10 py-3 mb-6 flex justify-between items-center">
                    <h3 class="font-semibold text-gray-800 dark:text-white">Manajemen Dokumen</h3>
                    <div class="flex gap-3">
                        <button @click="showKategoriModal = true"
                            class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg shadow transition">
                            <i class="fas fa-tags mr-2"></i> Tambah Kategori
                        </button>
                        <a href="{{ route('admin.dokumen.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow transition">
                            <i class="fas fa-plus mr-2"></i> Tambah Dokumen
                        </a>
                    </div>
                </div>

                <!-- Popup Kategori -->
                <div x-show="showKategoriModal" x-transition
                    class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4"
                    style="display: none">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-5xl relative">
                        <button @click="resetForm(); showKategoriModal = false"
                            class="absolute top-4 right-4 text-gray-600 hover:text-black dark:text-gray-300 dark:hover:text-white">
                            <i class="fas fa-times"></i>
                        </button>

                        <div class="grid grid-cols-1 md:grid-cols-2 divide-x divide-gray-200 dark:divide-gray-700">
                            <!-- Daftar Kategori -->
                            <div class="p-6 overflow-y-auto max-h-[70vh]">
                                <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">Daftar Kategori</h2>
                                <table class="w-full text-sm text-left border rounded-lg overflow-hidden">
                                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                                        <tr>
                                            <th class="px-3 py-2 border">No</th>
                                            <th class="px-3 py-2 border">Kategori</th>
                                            <th class="px-3 py-2 border text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y">
                                        @foreach($kategoriDokumen as $kategori)
                                        <tr>
                                            <td class="px-3 py-2 border">{{ $loop->iteration }}</td>
                                            <td class="px-3 py-2 border">{{ $kategori->nama }}</td>
                                            <td class="px-3 py-2 border text-center space-x-2">
                                                <!-- Edit -->
                                                <button type="button"
                                                    @click="editKategori({ id: {{ $kategori->id }}, nama: '{{ $kategori->nama }}' })"
                                                    class="p-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <!-- Delete -->
                                                <form action="{{ route('admin.kategoriDokumen.destroy', $kategori->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="p-2 bg-red-600 hover:bg-red-700 text-white rounded"
                                                        onclick="return confirm('Yakin hapus kategori ini? Semua dokumen yang berelasi juga akan ikut terhapus.')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Form Kategori -->
                            <div class="p-6 bg-gray-50 dark:bg-gray-900 flex items-center justify-center">
                                <div class="bg-white w-full max-w-sm p-6 rounded-xl shadow-lg border">
                                    <h2 class="text-lg font-semibold mb-4 text-gray-800" x-text="formTitle"></h2>

                                    <form :action="formAction" method="POST" class="space-y-5">
                                        @csrf
                                        <template x-if="isEdit">
                                            <input type="hidden" name="_method" value="PUT">
                                        </template>
                                        <div>
                                            <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                                            <input type="text" id="nama" name="nama" x-model="form.nama"
                                                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-400 transition duration-200 outline-none"
                                                placeholder="Masukkan nama kategori...">
                                        </div>
                                        <button type="submit"
                                            class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg shadow transition"
                                            x-text="isEdit ? 'Update Kategori' : 'Simpan Kategori'">
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kategori & Search Bar -->
            <!-- Filter & Search -->
            <div class="mb-6 px-10">
                <form method="GET" action="{{ route('admin.dokumen.index') }}" class="flex gap-4 items-start w-full">
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
                                        <input type="checkbox" name="status[]" value="{{ $s }}"
                                            {{ in_array($s, request()->get('status', [])) ? 'checked' : '' }}>
                                        {{ ucfirst($s) }}
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- KATEGORI -->
                            <div>
                                <div class="text-sm font-semibold text-gray-700 mb-1">Kategori</div>
                                <div class="flex flex-wrap gap-2 max-h-40 overflow-y-auto">
                                    @foreach($kategoriDokumen as $k)
                                    <label class="flex items-center gap-1 text-sm w-full">
                                        <input type="checkbox"
                                            name="kategori[]"
                                            value="{{ $k->id }}"
                                            {{ in_array($k->id, request()->get('kategori', [])) ? 'checked' : '' }}>
                                        {{ $k->nama }}
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
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari dokumen..."
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
                                <th class="px-4 py-3">Lampiran</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($dokumens as $dokumen)
                            <tr>
                                <td class="px-4 py-3 font-medium">{{ $dokumen->nama_dokumen }}</td>
                                <td class="px-4 py-3">{{ $dokumen->deskripsi_dokumen }}</td>
                                <td class="px-4 py-3">{{ $dokumen->kategoriDokumen->nama ?? '-' }}</td>
                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($dokumen->tanggal)->format('d M Y') }}</td>

                                <!-- Lampiran -->
                                <td class="px-4 py-3">
                                    @php
                                    $lampiran = $dokumen->lampiran ?? [];
                                    if (!is_array($lampiran)) {
                                    $lampiran = json_decode($lampiran, true) ?? [];
                                    }
                                    @endphp

                                    @if(count($lampiran) > 0)
                                    <div class="flex flex-col space-y-1">
                                        @foreach($lampiran as $file)
                                        <a href="{{ asset('storage/'.$file) }}"
                                            target="_blank"
                                            class="text-blue-600 underline hover:text-blue-800">
                                            {{ basename($file) }}
                                        </a>
                                        @endforeach
                                    </div>
                                    @else
                                    <span class="text-gray-500 italic">Tidak ada</span>
                                    @endif
                                </td>

                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 rounded-full text-xs font-medium
                                        {{ $dokumen->status === 'publikasi' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700' }}">
                                        {{ ucfirst($dokumen->status) }}
                                    </span>
                                </td>

                                <td class="px-4 py-3 text-center space-x-1">
                                    <!-- Edit -->
                                    <a href="{{ route('admin.dokumen.edit', $dokumen->id) }}" class="text-yellow-600 hover:text-yellow-800">
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

            <!-- Popup Konfirmasi Delete -->
            <div
                x-show="showDeleteModal"
                x-transition
                class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center"
                style="display: none">
                <div class="bg-white rounded-lg p-6 w-full max-w-sm shadow-lg text-center">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Yakin ingin menghapus dokumen ini?</h2>
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
<script>
    function kategoriDokumenForm() {
        return {
            showKategoriModal: false,
            isEdit: false,
            form: {
                id: null,
                nama: ''
            },
            formTitle: 'Tambah Kategori Baru',
            formAction: '{{ route("admin.kategoriDokumen.store") }}',

            editKategori(kategori) {
                this.isEdit = true;
                this.form.id = kategori.id;
                this.form.nama = kategori.nama;
                this.formTitle = 'Edit Kategori';
                this.formAction = '/admin/kategori-dokumen/' + kategori.id;
                this.showKategoriModal = true;
            },

            resetForm() {
                this.isEdit = false;
                this.form.id = null;
                this.form.nama = '';
                this.formTitle = 'Tambah Kategori Baru';
                this.formAction = '{{ route("admin.kategoriDokumen.store") }}';
            }
        }
    }
</script>

</html>
