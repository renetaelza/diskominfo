<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Whistle Blowing System</title>
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
    <header class="position-relative" style="height: 250px; background: url('/pictures/layanan/wbs.jpg') center center / cover no-repeat;">
        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark" style="opacity: 0.75;"></div>
        <div class="position-absolute top-50 start-50 translate-middle text-white text-center">
            <h1 style="font-size: 40px;" class="fw-bold">Whistle Blowing System</h1>
        </div>
    </header>

    <div class="container section-layanan">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="pictures-layanan">
                    <a href="https://aplikasi.bandung.go.id/aplikasi/whistle-blowing-system-wbs/" target="_blank" class="img-wrapper">
                        <img src="/pictures/layanan/wbs_page.png" alt="Whistle Blowing System" class="img-hover-effect" />
                        <div class="hover-overlay">
                            <div class="overlay-text">Klik di sini untuk mengunjungi website</div>
                        </div>
                    </a>

                </div>
                <a href="https://aplikasi.bandung.go.id/aplikasi/whistle-blowing-system-wbs/" target="_blank" class="btn btn-kunjungi mt-3 d-block text-center">
                    Klik di sini untuk mengunjungi website
                </a>
            </div>
            <div class="col-lg-6 text-area-layanan">
                <h1 class="mb-4">Saluran Aman untuk Laporan Pelanggaran</h1>

                <p class="mb-4">
                    Whistle Blowing System (WBS) Kota Bandung adalah platform resmi yang disediakan untuk masyarakat dan aparatur pemerintah melaporkan dugaan pelanggaran hukum, etika, atau penyalahgunaan wewenang secara rahasia dan aman. Sistem ini membantu menjaga integritas dan akuntabilitas di lingkungan pemerintahan.
                </p>

                <div class="icon-list-layanan">
                    <p><i class="fas fa-user-secret"></i><strong> Pelaporan Rahasia & Aman</strong></p>
                    <p>Identitas pelapor dijamin kerahasiaannya untuk memberikan rasa aman dalam menyampaikan laporan.</p>

                    <p><i class="fas fa-gavel"></i><strong> Tindak Lanjut Profesional</strong></p>
                    <p>Setiap laporan yang masuk akan diverifikasi dan ditindaklanjuti oleh tim yang berwenang secara objektif.</p>

                    <p><i class="fas fa-shield-alt"></i><strong> Pencegahan & Transparansi</strong></p>
                    <p>WBS berfungsi sebagai alat pencegahan korupsi dan upaya mewujudkan pemerintahan yang bersih dan transparan.</p>
                </div>
            </div>
        </div>
    </div>
    <x-footer />
</body>

</html>
