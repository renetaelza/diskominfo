<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan OPD</title>
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
    <header class="position-relative" style="height: 250px; background: url('/pictures/layanan/opd.jpg') bottom center / cover no-repeat;">
        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark" style="opacity: 0.75;"></div>
        <div class="position-absolute top-50 start-50 translate-middle text-white text-center">
            <h1 style="font-size: 40px;" class="fw-bold">Layanan OPD</h1>
        </div>
    </header>

    <div class="container section-layanan">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="pictures-layanan">
                    <a href="https://pmo.bandung.go.id/" target="_blank" class="img-wrapper">
                        <img src="/pictures/layanan/pmo_page.png" alt="PMO Kota Bandung" class="img-hover-effect" />
                        <div class="hover-overlay">
                            <div class="overlay-text">Klik di sini untuk mengunjungi website</div>
                        </div>
                    </a>

                </div>
                <a href="https://pmo.bandung.go.id/" target="_blank" class="btn btn-kunjungi mt-3 d-block text-center">
                    Klik di sini untuk mengunjungi website
                </a>
            </div>
            <div class="col-lg-6 text-area-layanan">
                <h1 class="mb-4">Layanan Terintegrasi untuk OPD Kota Bandung</h1>

                <p class="mb-4">
                    Platform ini menyediakan berbagai layanan digital yang dirancang khusus untuk mendukung kebutuhan Organisasi Perangkat Daerah (OPD) di lingkungan Pemerintah Kota Bandung. Melalui sistem ini, setiap OPD dapat mengakses, memantau, dan mengelola program kerja dengan lebih efisien dan terstruktur.
                </p>

                <div class="icon-list-layanan">
                    <p><i class="fas fa-network-wired"></i><strong> Kolaborasi Antar OPD</strong></p>
                    <p>Meningkatkan koordinasi dan sinergi lintas OPD dalam menjalankan program dan kebijakan.</p>

                    <p><i class="fas fa-tasks"></i><strong> Monitoring Kinerja Program</strong></p>
                    <p>Memudahkan pemantauan pelaksanaan kegiatan dan pencapaian indikator kinerja secara real-time.</p>

                    <p><i class="fas fa-tools"></i><strong> Dukungan Teknis & Administratif</strong></p>
                    <p>Penyediaan bantuan teknis untuk pengelolaan data, sistem informasi, serta pelaporan internal OPD.</p>
                </div>
            </div>
        </div>
    </div>
    <x-footer />
</body>

</html>
