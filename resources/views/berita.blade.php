<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dinas Komunikasi dan Informatika Kota Bandung</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite('resources/css/app.css')
</head>

<body class="bg-light">
    <x-navbar />

    <header class="position-relative" style="height: 250px; background: url('/pictures/berita.jpg') center center / cover no-repeat;">
        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark" style="opacity: 0.75;"></div>
        <div class="position-absolute top-50 start-50 translate-middle text-white text-center">
            <h1 style="font-size: 40px;" class="fw-bold">Semua Berita</h1>
        </div>
    </header>

    <div class="berita">
        <div class="container">
            <div class="input-group search-group mb-4">
                <span class="input-group-text bg-white border-end-0">
                    <i class="fa fa-search text-muted"></i>
                </span>
                <input type="text" class="form-control border-start-0" placeholder="Cari berita...">
            </div>

            <div class="filter-buttons mb-5">
                <button class="btn btn-filter active">Semua</button>
                <button class="btn btn-filter">Sekretariat</button>
                <button class="btn btn-filter">Bidang Diseminasi</button>
                <button class="btn btn-filter">Bidang Persandian</button>
                <button class="btn btn-filter">Bidang Statistik</button>
                <button class="btn btn-filter">Bidang Infrastruktur</button>
            </div>


            <div id="newsCarousel" class="carousel slide hero-carousel mb-5" data-bs-ride="carousel" data-bs-interval="4000">
                <div class="carousel-inner">
                    <!-- ITEM 1 -->
                    <div class="carousel-item active">
                        <img src="{{ asset('pictures/dummy_berita.jpeg') }}" class="bg-carousel" alt="Berita">
                        <div class="carousel-overlay-wrapper">
                            <div class="carousel-caption text-white">
                                <div class="meta">
                                    <i class="fa-regular fa-calendar me-2"></i>22 Juli 2025
                                    <i class="fa-solid fa-building ms-3 me-2"></i>Bidang Infrastruktur
                                </div>
                                <h5>Relawan TIK Gandeng Diskominfo Gelar Seminar Literasi Digital "Bancakan"</h5>
                            </div>
                        </div>
                    </div>

                    <!-- ITEM 2 -->
                    <div class="carousel-item">
                        <img src="{{ asset('pictures/dummy_berita.jpeg') }}" class="bg-carousel" alt="Berita">
                        <div class="carousel-overlay-wrapper">
                            <div class="carousel-caption text-white">
                                <div class="meta">
                                    <i class="fa-regular fa-calendar me-2"></i>20 Juli 2025
                                    <i class="fa-solid fa-building ms-3 me-2"></i>Bidang Statistik
                                </div>
                                <h5>Pelatihan Big Data dan Statistik untuk ASN Diskominfo</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dots Navigasi -->
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#newsCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#newsCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                </div>
            </div>



            <!-- Berita Cards -->
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card-news">
                        <div class="image" style="background: url('/pictures/dummy_berita.jpeg');"></div>
                        <div class="overlay text-white">
                            <div class="meta mb-1">
                                <i class="fa-regular fa-calendar me-2"></i>07 Juli 2025
                                <span class="ms-3"><i class="fa-solid fa-building me-2"></i>Bidang Diseminasi Informasi</span>
                            </div>
                            <h5 class="fw-semibold mb-3">
                                Relawan TIK Gandeng Diskominfo Kota Bandung Gelar Seminar Literasi Digital "Bancakan"
                            </h5>
                            <div class="d-flex justify-content-between align-items-center">
                                <button class="btn btn-sm text-white p-0"><i class="fa-solid fa-share"></i></button>
                                <div class="eye-counter">
                                    <i class="fa-regular fa-eye"></i> 210
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-news">
                        <div class="image" style="background: url('/pictures/dummy_berita.jpeg');"></div>
                        <div class="overlay text-white">
                            <div class="meta mb-1">
                                <i class="fa-regular fa-calendar me-2"></i>07 Juli 2025
                                <span class="ms-3"><i class="fa-solid fa-building me-2"></i>Bidang Diseminasi Informasi</span>
                            </div>
                            <h5 class="fw-semibold mb-3">
                                Relawan TIK Gandeng Diskominfo Kota Bandung Gelar Seminar Literasi Digital "Bancakan"
                            </h5>
                            <div class="d-flex justify-content-between align-items-center">
                                <button class="btn btn-sm text-white p-0"><i class="fa-solid fa-share"></i></button>
                                <div class="eye-counter">
                                    <i class="fa-regular fa-eye"></i> 210
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-news">
                        <div class="image" style="background: url('/pictures/dummy_berita.jpeg');"></div>
                        <div class="overlay text-white">
                            <div class="meta mb-1">
                                <i class="fa-regular fa-calendar me-2"></i>07 Juli 2025
                                <span class="ms-3"><i class="fa-solid fa-building me-2"></i>Bidang Diseminasi Informasi</span>
                            </div>
                            <h5 class="fw-semibold mb-3">
                                Relawan TIK Gandeng Diskominfo Kota Bandung Gelar Seminar Literasi Digital "Bancakan"
                            </h5>
                            <div class="d-flex justify-content-between align-items-center">
                                <button class="btn btn-sm text-white p-0"><i class="fa-solid fa-share"></i></button>
                                <div class="eye-counter">
                                    <i class="fa-regular fa-eye"></i> 210
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <x-footer />
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</html>
