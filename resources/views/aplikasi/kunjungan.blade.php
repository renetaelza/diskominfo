<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kunjungan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite('resources/css/app.css')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.14/index.global.min.js'></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <style>
        .fc-day-sat,
        .fc-day-sun {
            background-color: #ffc10740;
        }

        /* New class to visually disable a day */
        .day-disabled {
            background-color: #e0e0e0 !important;
            pointer-events: none;
            /* Makes the cell unclickable */
        }

        .day-disabled .fc-daygrid-day-number {
            text-decoration: line-through;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col">
    <x-navbar />
    <header class="position-relative"
        style="height: 250px; background: url('/pictures/kunjungan.jpg') center center / cover no-repeat;">
        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark" style="opacity: 0.75;"></div>
        <div class="position-absolute top-50 start-50 translate-middle text-white text-center">
            <h1 style="font-size: 40px;" class="fw-bold">Pengajuan Kunjungan</h1>
        </div>
    </header>

    <main class="container my-5">
        <div class="card shadow-lg">
            <div class="card-body p-4 p-md-5">

                {{-- Form --}}
                <form method="POST" action="{{ route('kunjungan.store') }}" enctype="multipart/form-data">
                    @csrf
                    {{-- Data Pemohon --}}
                    <section class="mb-5">
                        <h3 class="fw-bold mb-4">Data Pemohon (Perwakilan)</h3>

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                id="nama" name="nama" value="{{ old('nama') }}">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nama_instansi" class="form-label">Nama Instansi Pemohon</label>
                            <input type="text" class="form-control @error('nama_instansi') is-invalid @enderror"
                                id="nama_instansi" name="nama_instansi" value="{{ old('nama_instansi') }}">
                            @error('nama_instansi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nomor_hp" class="form-label">Nomor HP (dapat menerima panggilan)</label>
                            <input type="tel" class="form-control @error('nomor_hp') is-invalid @enderror"
                                id="nomor_hp" name="nomor_hp" value="{{ old('nomor_hp') }}">
                            @error('nomor_hp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email instansi/lembaga/pemohon</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" name="email" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="kab_kota" class="form-label">Kab/Kota</label>
                            <input type="text" class="form-control @error('kab_kota') is-invalid @enderror"
                                id="kab_kota" name="kab_kota" value="{{ old('kab_kota') }}">
                            @error('kab_kota')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="alamat_instansi" class="form-label">Alamat Instansi</label>
                            <textarea class="form-control @error('alamat_instansi') is-invalid @enderror" id="alamat_instansi"
                                name="alamat_instansi" rows="3">{{ old('alamat_instansi') }}</textarea>
                            @error('alamat_instansi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </section>

                    {{-- Data Tujuan Reservasi --}}
                    <section class="mb-5">
                        <h3 class="fw-bold mb-4">Data Tujuan Reservasi</h3>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tanggalKunjungan" class="form-label">Hari Kunjungan</label>
                                <input type="date"
                                    class="form-control @error('tanggal_kunjungan') is-invalid @enderror"
                                    id="tanggalKunjungan" name="tanggal_kunjungan"
                                    value="{{ old('tanggal_kunjungan') }}"
                                    min="{{ now()->format('Y-m-d') }}">
                                    <div class="form-text">Catatan: Hari Sabtu, Minggu, dan tanggal yang sudah memiliki agenda tidak dapat dipilih.</div>
                                @error('tanggal_kunjungan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="pukulKunjungan" class="form-label">Pukul Kunjungan</label>
                                <select class="form-select @error('pukul_kunjungan') is-invalid @enderror"
                                    id="pukulKunjungan" name="pukul_kunjungan">
                                    <option value="">Pilih Waktu</option>
                                    <option value="09:00" @if (old('pukul_kunjungan') == '09:00') selected @endif>09:00
                                    </option>
                                    <option value="09:30" @if (old('pukul_kunjungan') == '09:30') selected @endif>09:30
                                    </option>
                                    <option value="10:00" @if (old('pukul_kunjungan') == '10:00') selected @endif>10:00
                                    </option>
                                    <option value="10:30" @if (old('pukul_kunjungan') == '10:30') selected @endif>10:30
                                    </option>
                                    <option value="11:00" @if (old('pukul_kunjungan') == '11:00') selected @endif>11:00
                                    </option>
                                    <option value="13:00" @if (old('pukul_kunjungan') == '13:00') selected @endif>13:00
                                    </option>
                                </select>
                                @error('pukul_kunjungan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="topik_diskusi" class="form-label">Topik diskusi (terangkan dengan
                                jelas)</label>
                            <textarea class="form-control @error('topik_diskusi') is-invalid @enderror" id="topik_diskusi" name="topik_diskusi"
                                rows="3">{{ old('topik_diskusi') }}</textarea>
                            @error('topik_diskusi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="bidang_ids" class="form-label">Lokus/tujuan OPD yang akan dikunjungi</label>
                            <select class="form-select" id="bidang_ids" name="bidang_ids[]" multiple="multiple">
                                @foreach ($bidang as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                            @error('bidang_ids')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="jumlah_rombongan" class="form-label">Jumlah Rombongan</label>
                            <input type="number"
                                class="form-control @error('jumlah_rombongan') is-invalid @enderror"
                                id="jumlah_rombongan" name="jumlah_rombongan" value="{{ old('jumlah_rombongan') }}"
                                min="1">
                            @error('jumlah_rombongan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </section>

                    {{-- Data Surat --}}
                    <section class="mb-5">
                        <h3 class="fw-bold mb-4">Data Surat Permohonan</h3>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="no_surat" class="form-label">No. Surat Permohonan Kunjungan</label>
                                <input type="text" class="form-control @error('no_surat') is-invalid @enderror"
                                    id="no_surat" name="no_surat" value="{{ old('no_surat') }}">
                                @error('no_surat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_surat" class="form-label">Tanggal Surat</label>
                                <input type="date"
                                    class="form-control @error('tanggal_surat') is-invalid @enderror"
                                    id="tanggal_surat" name="tanggal_surat" value="{{ old('tanggal_surat') }}">
                                @error('tanggal_surat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="surat_permohonan" class="form-label">Upload Surat Permohonan Kunjungan</label>
                            <input class="form-control @error('surat_permohonan') is-invalid @enderror"
                                type="file" id="surat_permohonan" name="surat_permohonan" accept=".pdf">
                            <div class="form-text">File format PDF dan ukuran maks 2MB.</div>
                            @error('surat_permohonan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
    </script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        // Select2 Initialization
        $(document).ready(function() {
            $('#bidang_ids').select2({
                theme: "bootstrap-5",
                placeholder: 'Pilih satu atau lebih...',
                tokenSeparators: [',', ' ']
            });
        });

        // SweetAlert Pop-ups
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: @json(session('success')), // Safely passes the string to JS
                timer: 3000,
                showConfirmButton: false
            });
        @endif
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: @json(session('error')), // Safely passes the string to JS
            });
        @endif

        // FullCalendar Initialization and Dynamic Logic
        document.addEventListener('DOMContentLoaded', async function() {
        const visitDateField = document.getElementById('tanggalKunjungan');
        const visitTimeField = document.getElementById('pukulKunjungan');
        const allTimeOptions = Array.from(visitTimeField.options);

        // This object will store booked times
        const bookedSlots = {};
        // This array will store fully booked dates
        let fullyBookedDates = [];

        // 1. Fetch event data to know which dates are blocked
        try {
            const response = await fetch('/all-events');
            const events = await response.json();

            events.forEach(event => {
                const dateStr = event.start.substring(0, 10);
                if (event.extendedProps.type === 'agenda') {
                    fullyBookedDates.push(dateStr);
                } else if (event.extendedProps.type === 'kunjungan') {
                    if (!bookedSlots[dateStr]) {
                        bookedSlots[dateStr] = [];
                    }
                    const timeStr = event.start.substring(11, 16);
                    bookedSlots[dateStr].push(timeStr);
                }
            });
        } catch (error) {
            console.error("Error fetching event data:", error);
        }

        // 2. Add an event listener to the date input
        visitDateField.addEventListener('change', function() {
            const selectedDate = new Date(this.value);
            const dayOfWeek = selectedDate.getUTCDay(); // Sunday = 0, Saturday = 6
            const selectedDateStr = this.value;

            // 3. Check if the selected date is a weekend or has an agenda
            let isInvalid = false;
            if ([0, 6].includes(dayOfWeek)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Tanggal Tidak Valid',
                    text: 'Kunjungan tidak dapat dilakukan pada hari Sabtu atau Minggu.'
                });
                isInvalid = true;
            } else if (fullyBookedDates.includes(selectedDateStr)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Tanggal Tidak Tersedia',
                    text: 'Tanggal ini sudah penuh dengan agenda lain.'
                });
                isInvalid = true;
            }

            if (isInvalid) {
                this.value = ''; // Clear the invalid date
                visitTimeField.value = '';
                allTimeOptions.forEach(option => option.disabled = true);
                return;
            }
            
            // 4. If the date is valid, update the time dropdown
            const slotsForDay = bookedSlots[selectedDateStr] || [];
            visitTimeField.value = '';
            allTimeOptions.forEach(option => {
                if (option.value) { // Skip "Pilih Waktu"
                    option.disabled = slotsForDay.includes(option.value);
                } else {
                    option.disabled = false;
                }
            });
        });
    });
</script>
</body>

</html>
