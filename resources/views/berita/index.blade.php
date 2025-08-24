<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Berita</title>
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
            <form method="GET" action="{{ route('berita.index') }}">
                <div class="input-group search-group mb-4">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fa fa-search text-muted"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control border-start-0" placeholder="Cari berita...">
                </div>

                <div class="filter-buttons mb-5">
                    {{-- Tombol Semua --}}
                    <button type="submit" name="topik_id" value=""
                        class="btn btn-filter {{ request('topik_id') == '' ? 'active' : '' }}">
                        Semua
                    </button>

                    {{-- Tombol per Topik --}}
                    @foreach($topikTerpakai as $topik)
                    @if(strtolower($topik->nama) !== 'semua topik')
                    <button type="submit" name="topik_id" value="{{ $topik->id }}"
                        class="btn btn-filter {{ request('topik_id') == $topik->id ? 'active' : '' }}">
                        {{ $topik->nama }}
                    </button>
                    @endif
                    @endforeach
                </div>
            </form>

            @if ($semuaBerita->currentPage() == 1)
            <div id="newsCarousel" class="carousel slide hero-carousel mb-5" data-bs-ride="carousel" data-bs-interval="4000">
                <div class="carousel-inner">
                    @foreach ($beritaTerbaru as $index => $item)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <img src="{{ asset($item->foto_utama ?? 'pictures/dummy_berita.jpg') }}" class="bg-carousel" alt="Berita">
                        <div class="carousel-overlay-wrapper">
                            <div class="carousel-caption text-white">
                                <div class="meta">
                                    <i class="fa-regular fa-calendar me-2"></i>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}
                                    <i class="fas fa-tags mr-2 me-2"></i>{{ $item->topik->nama ?? 'Tanpa Topik' }}
                                </div>
                                <h5>{{ $item->judul }}</h5>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="carousel-indicators">
                    @foreach ($beritaTerbaru as $index => $item)
                    <button type="button" data-bs-target="#newsCarousel" data-bs-slide-to="{{ $index }}"
                        class="{{ $index === 0 ? 'active' : '' }}" aria-label="Slide {{ $index + 1 }}"></button>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Berita Cards -->
            <div class="row g-4">
                @foreach ($semuaBerita as $berita)
                <div class="col-md-4">
                    <a href="{{ route('berita.detail', $berita->id) }}" class="text-decoration-none">
                        <div class="card-news">
                            <div class="image" style="background: url('{{ asset($berita->foto_utama ?? 'pictures/dummy_berita.jpg') }}') center center / cover no-repeat;"></div>
                            <div class="overlay text-white">
                                <div class="meta mb-1">
                                    <i class="fa-regular fa-calendar me-2"></i>{{ \Carbon\Carbon::parse($berita->tanggal)->translatedFormat('d F Y') }}
                                    <span class="ms-3"><i class="fas fa-tags mr-2"></i>{{ $berita->topik->nama ?? 'Tanpa Topik' }}</span>
                                </div>
                                <h5 class="fw-semibold mb-3">
                                    {{ $berita->judul }}
                                </h5>
                                <div class="flex items-center justify-end">
                                    <button class="text-white text-sm hover:text-gray-300"
                                        onclick="event.preventDefault(); copyShare(
                                            '{{ route('berita.detail', $berita->id) }}',
                                            '{{ $berita->judul }}',
                                            '{{ asset($berita->foto_utama ?? 'pictures/dummy_berita.jpg') }}'
                                        )">
                                        <i class="fa-solid fa-share-nodes"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>

            <div class="mt-4 d-flex justify-content-center">
                {{ $semuaBerita->links('pagination::tailwind') }}
            </div>

        </div>
    </div>
    <x-footer />
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function copyShare(url, title, image) {
        if (navigator.share) {
            navigator.share({
                    title: title,
                    text: title,
                    url: url
                }).then(() => console.log('Berhasil share'))
                .catch((error) => console.log('Error share:', error));
        } else {
            const textToCopy = `${title}\n${url}\n${image}`;
            navigator.clipboard.writeText(textToCopy)
                .then(() => alert('📋 Tersalin:\n' + textToCopy))
                .catch(err => console.error('Gagal copy:', err));
        }
    }
</script>

</html>
