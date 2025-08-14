<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengumuman</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite('resources/css/app.css')

    <style>
        .highlight-date {
            background-color: #ffc107;
            color: #fff;
            border-radius: 50%;
            display: inline-block;
            width: 35px;
            height: 35px;
            line-height: 35px;
            text-align: center;
            font-weight: 600;
        }
    </style>
</head>

<body class="bg-light">
    <x-navbar />

    <header class="position-relative" style="height: 250px; background: url('/pictures/pengumuman.jpg') center center / cover no-repeat;">
        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark" style="opacity: 0.7;"></div>
        <div class="position-absolute top-50 start-50 translate-middle text-white text-center">
            <h1 style="font-size: 40px;" class="fw-bold">Pengumuman</h1>
        </div>
    </header>


    <main class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                @foreach($pengumumans as $pengumuman)
                <div class="bg-white rounded-lg shadow-md p-4 mb-5 hover:shadow-lg transition">
                    <!-- Tanggal -->
                    <div class="d-flex align-items-center mb-3">
                        <div class="highlight-date me-3">
                            {{ \Carbon\Carbon::parse($pengumuman->tanggal ?? $pengumuman->created_at)->format('d') }}
                        </div>
                        <div>
                            <div class="text-muted" style="font-size: 14px;">
                                {{ \Carbon\Carbon::parse($pengumuman->tanggal ?? $pengumuman->created_at)->translatedFormat('F Y') }}
                            </div>
                            <h3 class="fw-semibold text-dark" style="font-size: 20px;">
                                {{ $pengumuman->judul }}
                            </h3>
                        </div>
                    </div>

                    <!-- Isi -->
                    <div class="text-secondary mb-3 text-justify" style="line-height: 1.8; text-align: justify;">
                        {!! nl2br(e($pengumuman->isi_pengumuman)) !!}
                    </div>

                    <!-- Lampiran -->
                    @if($pengumuman->lampiran && is_array(json_decode($pengumuman->lampiran, true)))
                    <div class="mt-3">
                        <strong class="text-dark d-block mb-2">Lampiran:</strong>
                        <ul class="list-unstyled">
                            @foreach(json_decode($pengumuman->lampiran, true) as $file)
                            @php
                            // Jika file sudah URL lengkap, pakai langsung
                            if (preg_match('/^https?:\/\//', $file)) {
                            $fileUrl = $file;
                            } else {
                            // Kalau relatif, tambahkan asset storage
                            $fileUrl = asset('storage/' . ltrim($file, '/'));
                            }
                            @endphp
                            <li>
                                <a href="{{ $fileUrl }}" target="_blank" class="text-primary hover:underline">
                                    <i class="bi bi-paperclip"></i> {{ basename($file) }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
                @endforeach

                @if($pengumumans->isEmpty())
                <div class="alert alert-warning text-center">
                    Belum ada pengumuman.
                </div>
                @endif

            </div>
        </div>
    </main>

    <x-footer />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>