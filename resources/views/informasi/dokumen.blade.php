<!DOCTYPE html>
<html lang="en" x-data>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dokumen Informasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite('resources/css/app.css')
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-gray-50 font-[Poppins]">
    <x-navbar />

    <!-- Header -->
    <header class="position-relative" style="height: 250px; background: url('/pictures/dokumen.jpg') center center / cover no-repeat;">
        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark" style="opacity: 0.75;"></div>
        <div class="position-absolute top-50 start-50 translate-middle text-white text-center">
            <h1 style="font-size: 40px;" class="fw-bold">Dokumen Informasi</h1>
        </div>
    </header>

    <main class="container mx-auto px-5 md:px-10 py-10">

        <!-- Search + Filter -->
        <form method="GET" action="{{ route('dokumen.index') }}" class="mb-8">
            <div class="flex flex-col md:flex-row items-stretch gap-3">

                <!-- Filter -->
                <div class="relative" x-data="{ open: false }">
                    <button type="button" @click="open = !open"
                        class="px-5 py-2.5 rounded-lg text-white font-medium shadow-md flex items-center gap-2"
                        style="background-color:#18417F;">
                        <i class="fas fa-filter"></i> Filter
                    </button>

                    <!-- Dropdown -->
                    <div x-cloak x-show="open" @click.outside="open = false"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="absolute mt-2 bg-white border rounded-lg shadow-xl p-4 w-72 z-50">

                        <!-- Kategori (hanya tampil jika ada data) -->
                        @if($kategoriDokumens->count() > 0)
                        <div class="mb-4">
                            <h6 class="font-semibold mb-2">Kategori</h6>
                            <div class="flex flex-col space-y-1 max-h-32 overflow-y-auto text-sm">
                                @foreach($kategoriDokumens as $k)
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" class="rounded border-gray-300"
                                        name="kategori[]"
                                        value="{{ $k->id }}"
                                        {{ in_array($k->id, request()->get('kategori', [])) ? 'checked' : '' }}>
                                    {{ $k->nama }}
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Tahun -->
                        <div class="mb-4">
                            <h6 class="font-semibold mb-2">Tahun</h6>
                            <div class="flex flex-wrap gap-2 text-sm">
                                @foreach($tahunList as $tahun)
                                <label class="flex items-center gap-1">
                                    <input type="checkbox" class="rounded border-gray-300"
                                        name="tahun[]"
                                        value="{{ $tahun }}"
                                        {{ in_array($tahun, request()->get('tahun', [])) ? 'checked' : '' }}>
                                    {{ $tahun }}
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full py-2.5 rounded-lg text-white font-medium"
                            style="background-color:#18417F;">
                            Terapkan
                        </button>
                    </div>
                </div>

                <!-- Search -->
                <div class="flex-1">
                    <div class="flex items-center bg-white border rounded-lg shadow-sm px-3 py-2">
                        <i class="fa fa-search text-gray-400 mr-2"></i>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="w-full outline-none border-0 focus:ring-0 text-sm"
                            placeholder="Cari dokumen...">
                    </div>
                </div>

            </div>
        </form>


        <!-- List Dokumen -->
        @if($dokumens->count())
        <div class="space-y-6"> <!-- kasih jarak antar dokumen -->
            @foreach($dokumens as $dokumen)
            <div class="bg-white rounded-lg shadow p-6 hover:shadow-md transition">

                <!-- Nama Dokumen -->
                <h2 class="text-lg font-semibold text-gray-800 mb-1">
                    {{ $dokumen->nama_dokumen }}
                </h2>
                <div class="text-sm text-gray-500 mb-3">
                    <i class="bi bi-folder"></i> {{ $dokumen->kategoriDokumen->nama ?? '-' }}
                    | <i class="bi bi-calendar"></i> {{ \Carbon\Carbon::parse($dokumen->tanggal)->format('d M Y') }}
                </div>

                <p class="text-gray-600 text-sm mb-3">
                    {{ Str::limit($dokumen->deskripsi_dokumen, 150) }}
                </p>

                <!-- Lampiran -->
                @php
                $lampiran = $dokumen->lampiran ?? [];
                if (!is_array($lampiran)) {
                $lampiran = json_decode($lampiran, true) ?? [];
                }
                @endphp
                @if(count($lampiran) > 0)
                <div class="flex flex-col space-y-1 text-sm">
                    @foreach($lampiran as $file)
                    <a href="{{ asset('storage/'.$file) }}" target="_blank"
                        class="text-blue-600 underline hover:text-blue-800">
                        {{ basename($file) }}
                    </a>
                    @endforeach
                </div>
                @else
                <span class="text-gray-400 italic text-sm">Tidak ada lampiran</span>
                @endif

            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $dokumens->links('pagination::bootstrap-5') }}
        </div>

        @else
        <div class="text-center py-10 text-gray-500 bg-white rounded-lg shadow">
            Tidak ada dokumen ditemukan.
        </div>
        @endif

        <!-- Pagination -->
        <div class="mt-6">
            {{ $dokumens->links('pagination::bootstrap-5') }}
        </div>
    </main>

    <x-footer />
</body>

</html>