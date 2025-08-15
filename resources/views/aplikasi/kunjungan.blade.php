<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan OPD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite('resources/css/app.css')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.14/index.global.min.js'></script>
    <style>
    /* Style for weekend days */
    .fc-day-sat, .fc-day-sun {
        background-color: #ffc10740; /* A light, transparent yellow */
    }
</style>
</head>

<body class="min-h-screen flex flex-col">
    <x-navbar />
    <header class="position-relative"
        style="height: 250px; background: url('/pictures/layanan/opd.jpg') bottom center / cover no-repeat;">
        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark" style="opacity: 0.75;"></div>
        <div class="position-absolute top-50 start-50 translate-middle text-white text-center">
            <h1 style="font-size: 40px;" class="fw-bold">Pengajuan Kunjungan</h1>
        </div>
    </header>
    <main class="container my-5">
        <div class="card shadow-lg">
            <div class="card-body p-4 p-md-5">

                <section class="mb-5">
                    <div class="row justify-content-center">
                        <div class="col-12 col-lg-8">

                            <div id="calendar"></div>

                            <div class="mt-3">
                                <span class="d-inline-block bg-warning border"
                                    style="width: 25px; height: 25px; vertical-align: middle;"></span>
                                <span class="ms-2">= Tidak Tersedia</span>
                            </div>

                        </div>
                    </div>
                </section>

                </section>

                <hr class="my-5">

                <form method="POST" action="{{ route('kunjungan.store') }}" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf
                    <section class="mb-5">
                        <h3 class="fw-bold mb-4">Data Diri Pengunjung</h3>

                        {{-- Nama Lengkap --}}
                        <div class="mb-3">
                            <label for="namaLengkap" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                                id="namaLengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}">
                            @error('nama_lengkap')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" name="email" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- NIK --}}
                        <div class="mb-3">
                            <label for="nik" class="form-label">NIK</label>
                            <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik"
                                name="nik" value="{{ old('nik') }}">
                            @error('nik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Instansi --}}
                        <div class="mb-3">
                            <label for="instansi" class="form-label">Instansi/Organisasi Asal</label>
                            <input type="text" class="form-control @error('instansi') is-invalid @enderror"
                                id="instansi" name="instansi" value="{{ old('instansi') }}">
                            @error('instansi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Jabatan --}}
                        <div class="mb-3">
                            <label for="jabatan" class="form-label">Jabatan/Posisi</label>
                            <input type="text" class="form-control @error('jabatan') is-invalid @enderror"
                                id="jabatan" name="jabatan" value="{{ old('jabatan') }}">
                            @error('jabatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </section>

                    <section class="mb-5">
                        <h3 class="fw-bold mb-4">Waktu Kunjungan</h3>
                        <div class="row">
                            {{-- Tanggal Kunjungan --}}
                            <div class="col-md-6 mb-3">
                                <label for="tanggalKunjungan" class="form-label">Tanggal</label>
                                <input type="date"
                                    class="form-control @error('tanggal_kunjungan') is-invalid @enderror"
                                    id="tanggalKunjungan" name="tanggal_kunjungan"
                                    value="{{ old('tanggal_kunjungan') }}">
                                @error('tanggal_kunjungan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Pukul Kunjungan --}}
                            <div class="col-md-6 mb-3">
                                <label for="pukulKunjungan" class="form-label">Pukul</label>
                                <input type="time"
                                    class="form-control @error('pukul_kunjungan') is-invalid @enderror"
                                    id="pukulKunjungan" name="pukul_kunjungan" value="{{ old('pukul_kunjungan') }}">
                                @error('pukul_kunjungan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </section>

                    <section class="mb-5">
                        <h3 class="fw-bold mb-4">Detail Kunjungan</h3>

                        {{-- Tujuan --}}
                        <div class="mb-3">
                            <label for="tujuan" class="form-label">Tujuan</label>
                            <input type="text" class="form-control @error('tujuan') is-invalid @enderror"
                                id="tujuan" name="tujuan" value="{{ old('tujuan') }}">
                            @error('tujuan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="bagianUnit" class="form-label">Bagian/Unit yang dituju</label>
                            {{-- <select class="form-select" id="bagianUnit" name="bagian_unit">
                                <option selected>Pilih salah satu...</option>
                                <option value="sekretariat">Sekretariat</option>
                                <option value="bidang_ikp">Bidang Informasi dan Komunikasi Publik</option>
                                <option value="bidang_aptika">Bidang Aptika</option>
                                <option value="bidang_statistik">Bidang Statistik</option>
                            </select> --}}

                            <select id="bidang" name="bidang_id" class="form-select" required>
                                <option value="">Pilih Bidang</option>
                                @foreach ($bidang as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </section>

                    <div class="text-center">
                        <button type="submit" class="btn btn-secondary px-5">Submit Formulir</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <x-footer />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script> {{-- Make sure you also have Bootstrap's JS --}}


    {{-- Script to handle success/error pop-ups --}}
    <script>
        // Check for a success message
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 3000, // Pop-up will close after 3 seconds
                showConfirmButton: false
            });
        @endif

        // Check for an error message
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
            });
        @endif
    </script>

    {{-- FullCalendar Initialization --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var visitDateField = document.getElementById('tanggalKunjungan');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev',
                    center: 'title',
                    right: 'next'
                },

                // Make weekends unselectable
                selectable: true,
                selectAllow: function(selectInfo) {
                    // Disallow selecting weekends (Saturday=6, Sunday=0)
                    const day = selectInfo.start.getDay();
                    return day !== 0 && day !== 6;
                },

                // Action when a date is clicked
                dateClick: function(info) {
                    // Check if the clicked date is in the past
                    const today = new Date();
                    today.setHours(0, 0, 0, 0); // Reset time to compare dates only

                    // We don't need to check for weekends here because 'selectAllow' already prevents it,
                    // but this is an extra safeguard.
                    if (info.dayEl.classList.contains('fc-day-sat') || info.dayEl.classList.contains(
                            'fc-day-sun')) {
                        return; // Do nothing if a weekend is clicked
                    }

                    if (info.date < today) {
                        return; // Do nothing if a past date is clicked
                    }

                    // Fill the date input field with the clicked date. NO alert.
                    visitDateField.value = info.dateStr; // format is 'YYYY-MM-DD'
                }
            });

            calendar.render();
        });
    </script>
</body>

</html>
