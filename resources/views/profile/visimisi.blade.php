<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visi & Misi Diskominfo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite('resources/css/app.css')
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .icon-box { font-size: 3rem; color: #18417F; }
    </style>
</head>

<body class="bg-light">
    <x-navbar />

    <header class="position-relative" style="height: 250px; background: url('/pictures/visimisi2.jpeg') center center / cover no-repeat;">
        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark" style="opacity: 0.75;"></div>
        <div class="position-absolute top-50 start-50 translate-middle text-white text-center">
            <h1 style="font-size: 40px;" class="fw-bold">Visi & Misi</h1>
        </div>
    </header>

    <div class="container my-5 py-5">

        <div class="row justify-content-center mb-5">
            <div class="col-lg-10 text-center">
                <i class="bi bi-bullseye icon-box mb-3"></i>
                <h2 class="fw-bold">Visi</h2>
                {{-- Cek apakah data visi ada --}}
                @if($vision)
                    <p class="lead text-muted">"{{ $vision->content }}"</p>
                @else
                    <p class="lead text-muted">Visi sedang dalam perumusan.</p>
                @endif
            </div>
        </div>

        <hr class="my-5">

        <div class="row text-center mb-4">
            <div class="col">
                <i class="bi bi-flag-fill icon-box mb-3"></i>
                <h2 class="fw-bold">Misi</h2>
            </div>
        </div>

        <div class="row g-4">
            {{-- Loop melalui setiap data misi --}}
            @forelse($missions as $mission)
                <div class="col-lg-4 col-md-6">
                    <div class="card shadow-sm h-100 border-0">
                        <div class="card-body text-center p-4">
                            {{-- Tampilkan ikon dari database --}}
                            <div class="icon-box mb-3"><i class="{{ $mission->icon_class }}"></i></div>
                            {{-- Tampilkan teks misi dari database --}}
                            <p class="card-text">{{ $mission->content }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="lead text-muted">Misi sedang dalam perumusan.</p>
                </div>
            @endforelse
        </div>

    </div>

    <x-footer />
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>