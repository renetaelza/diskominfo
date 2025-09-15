<!DOCTYPE html>
<html lang="en" x-data>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dokumen Informasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
    <header class="relative h-64 sm:h-80 md:h-96 bg-center bg-cover" style="background-image: url('/pictures/dokumen.jpg')">
        <!-- Overlay gelap -->
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <!-- Teks header -->
        <div class="absolute inset-0 flex flex-col items-center justify-center text-center text-white px-4">
            <h1 class="font-bold text-3xl sm:text-4xl md:text-5xl lg:text-6xl mb-2">PPID</h1>
            <h3 class="font-semibold text-xl sm:text-2xl md:text-3xl lg:text-4xl">
                {{ Str::title(str_replace('-', ' ', $dokumen->judul)) }}
            </h3>
        </div>
    </header>

    <main class="container mx-auto px-5 md:px-10 py-10">
        <!-- Container Utama -->
        <div class="w-full max-w-7xl mx-auto bg-white shadow-lg rounded-2xl p-4 sm:p-6 lg:p-8">

            <!-- Judul dan Tanggal -->
            <div class="border-b pb-4 mb-6">
                <h2 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800 flex items-center gap-3">
                    <i class="fas fa-file-alt text-blue-500"></i>
                    {{ $dokumen->judul }}
                </h2>
                <p class="text-sm sm:text-base text-gray-500 mt-1 flex items-center gap-2">
                    <i class="fas fa-calendar-alt text-black"></i>
                    {{ $dokumen->tanggal->format('d M Y') }}
                </p>
            </div>


            <!-- Lampiran -->
            @php
                $lampiran = json_decode($dokumen->lampiran ?? '[]', true);
            @endphp

            @if(!empty($lampiran) && count($lampiran) > 0)
                <div class="space-y-4 max-h-[500px] overflow-y-auto pr-2">
                    @foreach($lampiran as $index => $file)
                        <div class="bg-white border-l-4 border-blue-500 rounded-lg shadow p-4 sm:p-5 lg:p-6 flex flex-col">
                            <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-2 flex items-center gap-2">
                                📎 Lampiran {{ $index+1 }}
                            </h3>
                            <a href="{{ asset('storage/'.$file) }}" target="_blank"
                            class="block truncate text-blue-600 hover:text-blue-800 font-medium sm:text-base lg:text-lg"
                            title="{{ basename($file) }}">
                            {{ basename($file) }}
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-400 italic">Tidak ada lampiran</p>
            @endif

        </div>
    </main>


    <x-footer />
</body>

</html>