<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pimpinan Diskominfo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite('resources/css/app.css')
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .profile-card { max-width: 960px; margin: auto; }
        .profile-img-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .profile-img {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid #fff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .welcome-message p {
            text-align: justify;
            margin-bottom: 1.5rem;
            line-height: 1.8;
        }
    </style>
</head>
<body class="bg-light">
 <x-navbar />
    <header class="position-relative"
        style="height: 250px; background: url('/pictures/sejarah.jpg') center center / cover no-repeat;">
        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark" style="opacity: 0.75;"></div>
        <div class="position-absolute top-50 start-50 translate-middle text-white text-center">
            <h1 style="font-size: 40px;" class="fw-bold">Profil Pimpinan</h1>
        </div>
    </header>

    <div class="container my-5 py-5">

        @if($profile->name)
            <div class="card border-0 shadow-sm p-4 p-md-5 profile-card">
                <div class="row g-5">
                    {{-- Kolom Foto --}}
                    <div class="col-md-4 profile-img-container">
                        @if ($profile->photo_path)
                            <img src="{{ Storage::url($profile->photo_path) }}" alt="Foto {{ $profile->name }}" class="profile-img">
                        @else
                             {{-- Fallback jika tidak ada foto --}}
                            <img src="https://via.placeholder.com/200" alt="Foto Profil" class="profile-img">
                        @endif
                    </div>
                    {{-- Kolom Nama & Jabatan --}}
                    <div class="col-md-8 d-flex flex-column justify-content-center">
                        <h4 class="text-muted fw-normal">{{ $profile->title ?? 'Jabatan Belum Diatur' }}</h4>
                        <h2 class="fw-bold display-6">{{ $profile->name }}</h2>
                    </div>
                </div>

                <hr class="my-5">

                {{-- Kolom Kata Sambutan --}}
                <div class="row">
                    <div class="col-12 welcome-message">
                         {{-- nl2br akan mengubah baris baru (enter) dari textarea menjadi tag <br> --}}
                        {!! nl2br(e($profile->welcome_message)) !!}
                    </div>
                </div>
            </div>
        @else
            <div class="text-center">
                <p class="text-muted">Profil pimpinan belum diatur.</p>
            </div>
        @endif
    </div>
    <x-footer />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>