<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $berita->judul }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="bg-light">
    <x-navbar />

    <div class="container p-5">
        <!-- Judul & Meta -->
        <h1 class="fw-bold mb-2" style="font-size: 30px;">{{ $berita->judul }}</h1>
        <div class="d-flex align-items-center text-muted mb-4">
            <i class="fa-regular fa-calendar me-2"></i>{{ $berita->tanggal->translatedFormat('d F Y') }}
            <span class="ms-4">
                <i class="fas fa-tags mr-2 me-2"></i>{{ $berita->topik->nama ?? 'Tanpa Topik' }}
            </span>
            <span class="ms-auto">
                <strong>Bagikan:</strong>
                <button onclick="event.preventDefault(); share('{{ route('berita.detail', $berita->id) }}', '{{ $berita->judul }}')"><i class="fa-solid fa-share-nodes"></i></button>

            </span>
        </div>

        <!-- Foto Utama -->
        <div class="mb-4">
            <img src="{{ asset($berita->foto_utama ?? 'pictures/dummy_berita.jpeg') }}"
                alt="{{ $berita->judul }}"
                class="img-fluid rounded shadow w-100" style="max-height: 650px; object-fit: cover;">
        </div>

        <!-- Foto Tambahan -->
        @php
        $fotoTambahan = is_string($berita->foto_tambahan) ? json_decode($berita->foto_tambahan, true) : $berita->foto_tambahan;
        $jumlahFoto = is_array($fotoTambahan) ? count($fotoTambahan) : 0;
        @endphp

        <div class="mb-5" style="overflow-x: auto;">
            <div class="d-flex gap-3 mx-auto">
                @foreach($fotoTambahan as $foto)
                <div class="position-relative foto-tambahan-card" onclick="showImagePreview('{{ asset($foto) }}')"
                    style="width: 170px; height: 100px; cursor: pointer;">
                    <img src="{{ asset($foto) }}" class="rounded shadow w-100 h-100" style="object-fit: cover;" alt="Foto tambahan">
                    <div class="overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center rounded"
                        style="background: rgba(0,0,0,0.5); opacity: 0; transition: 0.3s;">
                        <i class="fa-solid fa-eye text-white fs-4"></i>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Konten & Terpopuler -->
        <div class="row">
            <!-- Konten -->
            <div class="col-lg-8">
                <div class="text-dark berita-content" style="line-height: 1.9; text-align: justify;">
                    {!! Str::of($berita->isi_berita)->replaceMatches('/\n{2,}/', "\n")->markdown(['html_input' => 'strip']) !!}
                </div>
            </div>

            <!-- Sidebar Terpopuler -->
            <div class="col-lg-4 mt-4 mt-lg-0">
                <h5 class="fw-semibold mb-3 border-bottom pb-2">TERPOPULER</h5>
                @foreach ($terpopuler as $item)
                <a href="{{ route('berita.detail', $item->id) }}" class="d-flex mb-3 text-decoration-none text-dark hover:text-primary">
                    <img src="{{ asset($item->foto_utama ?? 'pictures/dummy_berita.jpg') }}"
                        class="me-3 rounded" style="width: 120px; height: 80px; object-fit: cover;" alt="foto">
                    <div class="d-flex flex-column justify-content-center">
                        <small class="fw-semibold">{{ Str::limit($item->judul, 60) }}</small>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-transparent border-0">
                <div class="modal-body p-0 position-relative">
                    <img id="modalPreviewImage" src="" class="img-fluid rounded shadow" alt="Preview">
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-3 bg-white p-2 rounded-circle"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>

    <x-footer />
    <script>
        function showImagePreview(src) {
            document.getElementById('modalPreviewImage').src = src;
            new bootstrap.Modal(document.getElementById('imagePreviewModal')).show();
        }

        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.foto-tambahan-card').forEach(card => {
                const overlay = card.querySelector('.overlay');
                card.addEventListener('mouseover', () => overlay.style.opacity = '1');
                card.addEventListener('mouseout', () => overlay.style.opacity = '0');
            });
        });

        function share(url, title) {
            if (navigator.share) {
                navigator.share({
                    title: title,
                    url: url
                });
            } else {
                navigator.clipboard.writeText(url);
                alert('Link disalin: ' + url);
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
