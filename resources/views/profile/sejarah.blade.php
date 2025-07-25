<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sejarah</title>
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
            <h1 style="font-size: 40px;" class="fw-bold">Sejarah</h1>
        </div>
    </header>

    <div class="container my-5">

    <div class="card shadow mb-4 border border-dark" style="background-color: #D4EBF8;">
        <div class="card-body p-4">
            <h2 class="card-title fw-bold mb-3">Sejarah Singkat Diskominfo Kota Bandung</h2>
            <p class="card-text mb-3">Pada mulanya Dinas Komunikasi dan Informatika (DISKOMINFO) Kota Bandung dibentuk berdasarkan salah satu lembaga teknis daerah yang berbentuk Badan, yaitu Badan Komunikasi dan Informatika dengan Singkatan BAKOMINFO.</p>
            <p class="card-text mb-3">BAKOMINFO Kota Bandung merupakan Lembaga Teknis Daerah dibentuk berdasarkan Peraturan Daerah Kota Bandung Nomor 12 Tahun 2007, Tanggal 4 Desember 2007 serta merupakan penggabungan Satuan Kerja Pemerintah Daerah (SKPD) Dinas dan Kantor di lingkungan Pemerintah Kota Bandung yaitu Dinas Informasi dan Komunikasi dengan Kantor Pengolahan Data Elektronik (KPDE). Dengan demikian BAKOMINFO terbentuk sejak diberlakukannya PERDA Nomor 12 Tahun 2007 tentang Pembentukan dan Susunan Organisasi Dinas Daerah Kota Bandung.</p>
            <p class="card-text">Berdasarkan Peraturan Daerah Kota Bandung Nomor 13 Tahun 2009 Tentang Perubahan atas Peraturan Daerah Kota Bandung Nomor 13 Tahun 2007 Tentang Pembentukan dan Susunan Organisasi Dinas Daerah Kota Bandung Tgl. 07 Agustus 2009, maka Badan Komunikasi dan Informatika Kota Bandung menjadi Dinas Komunikasi dan Informatika (DISKOMINFO) Kota Bandung</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow h-100 border border-dark">
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold">Visi</h5>
                    <p class="card-text">Terwujudnya efektivitas dan efisiensi komunikasi dan informatika penyelenggaraan pemerintah daerah dalam rangka mewujudkan kota bandung sebagai kota jasa bermartabat.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
        <div class="card shadow h-100 border border-dark">
            <div class="card-body p-4">
                <h5 class="card-title fw-bold mb-3">Misi</h5>
                <ol class="list-group list-group-numbered list-group-flush">
                    <li class="list-group-item border-0 px-0">Meningkatkan dan mengembangkan kemitraan, pemberdayaan dan pendayagunaan prasarana dan sarana komunikasi dan informatika</li>
                    <li class="list-group-item border-0 px-0">Meningkatkan layanan publik dan pemberdayaan masyarakat dalam rangka meningkatkan komunikasi dialogis</li>
                    <li class="list-group-item border-0 px-0">Meningkatkan pelayanan informasi dan pemberdayaan potensi masyarakat dalam rangka mewujudkan budaya masyarakat berbasis teknologi informasi</li>
                    <li class="list-group-item border-0 px-0">Meningkatkan kerjasama, kemitraan dan pemberdayaan lembaga komunikasi dan informatika pemerintah dan masyarakat</li>
                    <li class="list-group-item border-0 px-0">Mendorong peran media massa dalam rangka meningkatkan informasi yang beretika dan bertanggungjawab</li>
                    <li class="list-group-item border-0 px-0">Meningkatkan sumber daya manusia bidang komunikasi dan informatika yang handal</li>
                </ol>
            </div>
            </div>
        </div>
    </div>
</div>

    <x-footer />
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</html>