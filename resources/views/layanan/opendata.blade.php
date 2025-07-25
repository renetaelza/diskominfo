<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Open Data Bandung</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen flex flex-col">
    <x-navbar />
    <header class="position-relative" style="height: 250px; background: url('/pictures/layanan/data.jpg') center center / cover no-repeat;">
        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark" style="opacity: 0.75;"></div>
        <div class="position-absolute top-50 start-50 translate-middle text-white text-center">
            <h1 style="font-size: 40px;" class="fw-bold">Open Data Kota Bandung</h1>
        </div>
    </header>

    <div class="container section-layanan">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="pictures-layanan">
                    <a href="https://opendata.bandung.go.id/" target="_blank" class="img-wrapper">
                        <img src="/pictures/layanan/opendata_page.png" alt="Open Data" class="img-hover-effect" />
                        <div class="hover-overlay">
                            <div class="overlay-text">Klik di sini untuk mengunjungi website</div>
                        </div>
                    </a>

                </div>
                <a href="https://opendata.bandung.go.id/" target="_blank" class="btn btn-kunjungi mt-3 d-block text-center">
                    Klik di sini untuk mengunjungi website
                </a>
            </div>
            <div class="col-lg-6 text-area-layanan">
                <h1 class="mb-4">Transparansi Data Publik untuk Semua.</h1>

                <p class="mb-4">
                    Akses mudah dan terbuka terhadap berbagai data resmi dari Pemerintah Kota Bandung. Platform ini memungkinkan masyarakat, peneliti, dan pengembang untuk mengeksplorasi, mengunduh, dan memanfaatkan data sebagai dasar pengambilan keputusan atau pengembangan inovasi.
                </p>

                <div class="icon-list-layanan">
                    <p><i class="fas fa-database"></i><strong> Akses Data Terbuka</strong></p>
                    <p>Menyediakan kumpulan data publik dari berbagai sektor pemerintahan yang dapat diunduh bebas.</p>

                    <p><i class="fas fa-chart-line"></i><strong> Visualisasi Interaktif</strong></p>
                    <p>Grafik dan dashboard untuk mempermudah pemahaman tren dan pola dari data yang tersedia.</p>

                    <p><i class="fas fa-code-branch"></i><strong> API untuk Pengembang</strong></p>
                    <p>Integrasi data lebih fleksibel melalui API bagi pengembang atau pihak ketiga.</p>
                </div>
            </div>
        </div>
    </div>
    <x-footer />
</body>

</html>
