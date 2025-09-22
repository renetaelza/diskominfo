<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Berita</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite('resources/css/app.css')
</head>

<body class="bg-light">
    <x-navbar />
    <header class="relative h-64 bg-center bg-cover" style="background-image: url('/pictures/berita.jpg')">
        <div class="absolute inset-0 bg-black opacity-75"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-white text-center">
            <h1 class="text-4xl md:text-5xl font-bold">Semua Berita</h1>
        </div>
    </header>

    <div class="py-12 px-4 sm:px-6 lg:px-8">
        <div class="container mx-auto">
            <form method="GET" action="{{ route('berita.index') }}">
                <div class="relative mb-6">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <i class="fa fa-search text-gray-400"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" class="w-full pl-10 pr-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Cari berita...">
                </div>

                <div class="flex flex-wrap gap-2 mb-10">
                    <button type="submit" name="topik_id" value=""
                        class="px-4 py-2 text-sm font-medium rounded-full {{ request('topik_id') == '' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                        Semua
                    </button>
                    @foreach($topikTerpakai as $topik)
                        @if(strtolower($topik->nama) !== 'semua topik')
                        <button type="submit" name="topik_id" value="{{ $topik->id }}"
                            class="px-4 py-2 text-sm font-medium rounded-full {{ request('topik_id') == $topik->id ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                            {{ $topik->nama }}
                        </button>
                        @endif
                    @endforeach
                </div>
            </form>

            @if ($semuaBerita->currentPage() == 1 && $beritaTerbaru->isNotEmpty())
            <div class="swiper mySwiper mb-10">
                <div class="swiper-wrapper">
                    @foreach ($beritaTerbaru as $item)
                    <div class="swiper-slide">
                        <a href="{{ route('berita.detail', $item->id) }}" class="block rounded-xl overflow-hidden shadow-lg group">
                            <div class="relative h-96 sm:h-[500px] lg:h-[650px]">
                                <div class="absolute inset-0 bg-center rounded-xl bg-cover transition-transform duration-500 group-hover:scale-110" 
                                     style="background-image: url('{{ asset($item->foto_utama ?? 'pictures/dummy_berita.jpg') }}')">
                                </div>
                                <div class="absolute inset-0 bg-gradient-to-t from-blue-700/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                                <div class="absolute bottom-0 left-0 p-6 text-white">
                                    <div class="text-sm opacity-80 mb-2">
                                        <i class="fa-regular fa-calendar mr-2"></i>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}
                                        <span class="ml-4"><i class="fas fa-tags mr-2"></i>{{ $item->topik->nama ?? 'Tanpa Topik' }}</span>
                                    </div>
                                    <h2 class="text-2xl lg:text-3xl font-bold leading-tight group-hover:underline">{{ $item->judul }}</h2>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
            </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($semuaBerita as $berita)
                <a href="{{ route('berita.detail', $berita->id) }}" class="group block text-white rounded-lg overflow-hidden shadow-lg relative">
                    <div class="h-72 bg-center bg-cover transition-transform duration-500 group-hover:scale-110" 
                         style="background-image: url('{{ asset($berita->foto_utama ?? 'pictures/dummy_berita.jpg') }}')">
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-blue-700/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 p-4">
                        <div class="text-xs opacity-80 mb-1">
                            <i class="fa-regular fa-calendar mr-2"></i>{{ \Carbon\Carbon::parse($berita->tanggal)->translatedFormat('d F Y') }}
                        </div>
                        <h5 class="font-semibold group-hover:underline">{{ $berita->judul }}</h5>
                    </div>
                </a>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $semuaBerita->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
    <x-footer />
</body>
<script>

    var swiper = new Swiper(".mySwiper", {
        spaceBetween: 30,
        centeredSlides: true,
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
    });

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
