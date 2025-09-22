<!DOCTYPE html>
<html lang="en" x-data>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dokumen Informasi</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite('resources/css/app.css')

    <link rel="stylesheet" href="{{ asset('ckeditor5/ckeditor5.css') }}">
    <style>
        [x-cloak] { display: none !important; }

        .ck-content h1, 
        .ck-content h2, 
        .ck-content h3 {
            font-weight: 700;
            color: #1f2937;
            margin-top: 1.25rem;
            margin-bottom: 0.75rem;
        }
        .ck-content h1 { font-size: 2rem; line-height: 2.5rem; }
        .ck-content h2 { font-size: 1.5rem; line-height: 2rem; }
        .ck-content h3 { font-size: 1.25rem; line-height: 1.75rem; }

        /* Aturan umum untuk paragraf */
        .ck-content p {
            margin-bottom: 1rem;
            line-height: 1.75;
            color: #374151;
            text-align: justify;
        }

        /* Aturan untuk list */
        .ck-content ol,
        .ck-content ul {
            padding-left: 1.5rem;
            margin-bottom: 1rem;
        }
        .ck-content ol { list-style-type: decimal; }
        .ck-content ul { list-style-type: disc; }

        /* Aturan untuk tabel */
        .ck-content table {
            width: 100%;
            border-collapse: collapse;
            margin: 1.5rem 0;
        }
        .ck-content table th,
        .ck-content table td {
            border: 1px solid #d1d5db;
            padding: 0.75rem;
            text-align: left;
        }
        .ck-content table th {
            background-color: #f3f4f6;
            font-weight: 600;
        }

        /* Aturan "clearfix" untuk membersihkan float */
        .ck-content::after {
            content: "";
            display: block;
            clear: both;
        }
    </style>
</head>
<body class="bg-gray-50 font-[Poppins]">
    <x-navbar />

    <!-- Header -->
    <header class="relative h-64 sm:h-80 md:h-96 bg-center bg-cover" style="background-image: url('/pictures/dokumen.jpg')">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div class="absolute inset-0 flex flex-col items-center justify-center text-center text-white px-4">
            <h1 class="font-bold text-3xl sm:text-4xl md:text-5xl lg:text-6xl mb-2">PPID</h1>
            <h3 class="font-semibold text-xl sm:text-2xl md:text-3xl lg:text-4xl">
                {{ Str::title(str_replace('-', ' ', $text->judul)) }}
            </h3>
        </div>
    </header>

    <main class="bg-gray-50 py-10">
        <div class="container mx-auto px-5 md:px-16 lg:px-32">
            <p class="text-sm text-gray-500">
                Di perbarui
            </p>
            <p class="text-sm text-gray-500 mb-8">
                <i class="fas fa-calendar-alt text-gray-400"></i>
                {{ $text->tanggal->format('d M Y') }}
            </p>

            <!-- Konten CKEditor -->
            <article class="max-w-none ck-content text-gray-800">
                {!! $text->konten !!}
            </article>
        </div>
    </main>

    <x-footer />
</body>
</html>