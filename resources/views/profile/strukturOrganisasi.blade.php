<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Struktur Organisasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        body { 
            margin: 0; 
            font-family: 'Poppins', sans-serif; 
        }
        .body-modal-open {
            overflow-y: hidden;
        }
        #tree-wrapper {
            width: 100%;
            height: 700px;
            overflow: auto;
        }
        .modal-header-bg {
            background-image: url('https://plus.unsplash.com/premium_photo-1691850197766-a47d9cddfee1?q=80&w=779&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D?q=80&w=2070&auto=format&fit=crop');
            background-size: cover;
            background-position: center center;
            position: relative;
            border-top-left-radius: 0.75rem;
            border-top-right-radius: 0.75rem;
        }
        .modal-header-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            border-top-left-radius: 0.75rem;
            border-top-right-radius: 0.75rem;
        }
        #modalImg {
            background-color: #ffffff;
            padding: 4px;
            border-radius: 9999px;
            border: 4px solid #fff;
        }
    </style>
</head>
<body class="bg-gray-100">
    <x-navbar />

    <header class="relative h-[250px]" style="background: url('https://plus.unsplash.com/premium_photo-1691850197766-a47d9cddfee1?q=80&w=779&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D?q=80&w=2070&auto=format&fit=crop') center center / cover no-repeat;">
        <div class="absolute inset-0 bg-black/70"></div>
        <div class="absolute inset-0 flex items-center justify-center text-white text-center">
            <h1 class="text-4xl font-bold">Struktur Organisasi</h1>
        </div>
    </header>

    <main class="container mx-auto py-10 px-4">
        <div class="bg-white rounded-lg shadow-lg p-4">
            <div id="tree-wrapper">
                <div id="tree"></div>
            </div>
        </div>
    </main>

    <div 
        x-data="{ 
            showDetail: false, 
            detailPegawai: {},
            openModal: function(data) {
                const scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;
                document.body.style.paddingRight = `${scrollbarWidth}px`;
                document.body.classList.add('body-modal-open');
                
                this.showDetail = true;
                this.detailPegawai = data;
            },
            closeModal: function() {
                document.body.classList.remove('body-modal-open');
                document.body.style.paddingRight = '';

                this.showDetail = false;
            }
        }"
        x-show="showDetail"
        x-cloak
        class="fixed inset-0 z-[1050] flex items-center justify-center p-4 transition-opacity duration-300 bg-gray-900 bg-opacity-70"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @pegawai-detail.window="openModal($event.detail)"
    >
        <div
            class="relative w-full max-w-2xl mx-auto my-6 bg-white dark:bg-gray-800 rounded-xl shadow-2xl overflow-hidden transform transition-all duration-300"
            @click.away="closeModal()"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
        >
            <div class="relative p-8 text-white text-center modal-header-bg">
                <button type="button" @click="closeModal()" class="absolute top-3 right-3 text-white/80 hover:text-white transition-colors z-[1]">
                    <i class="fas fa-times text-xl"></i>
                </button>
                <div class="relative z-[1] flex flex-col items-center">
                    <img :src="detailPegawai.foto_url" alt="Foto Pegawai" class="w-32 h-32 mx-auto mb-4 object-cover rounded-full border-4 border-white shadow-lg">
                    <h2 class="text-2xl font-bold" x-text="detailPegawai.name"></h2>
                    <p class="text-sm font-light opacity-80" x-text="detailPegawai.title"></p>
                </div>
            </div>

            <div class="p-6 md:p-8 overflow-y-auto max-h-[60vh] text-black dark:text-gray-200">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="font-semibold">NIP</p>
                        <p x-text="detailPegawai.nip || 'Tidak Ada'"></p>
                    </div>
                    <div>
                        <p class="font-semibold">Bidang</p>
                        <p x-text="detailPegawai.bidang || 'Tidak Ada'"></p>
                    </div>
                    <div>
                        <p class="font-semibold">Atasan</p>
                        <p x-text="detailPegawai.atasan || 'Tidak Ada'"></p>
                    </div>
                    <div>
                        <p class="font-semibold">Asisten</p>
                        <p x-text="detailPegawai.is_assistant ? 'Ya' : 'Tidak'"></p>
                    </div>
                </div>

                <div class="mt-6">
                    <h3 class="font-semibold">Alamat</h3>
                    <p class="text-sm" x-text="detailPegawai.alamat || 'Tidak Ada'"></p>
                </div>

                <div class="mt-6">
                    <h3 class="font-semibold">Tupoksi</h3>
                    <p class="text-sm whitespace-pre-line leading-relaxed break-words" x-text="detailPegawai.tupoksi || 'Tidak Ada'"></p>
                </div>

                <div class="mt-6" x-show="(detailPegawai.bawahan && detailPegawai.bawahan.length > 0) && detailPegawai.bidang !== 'Kepala Dinas'">
                    <h3 class="font-semibold text-lg border-b pb-2 mb-3">Subordinat</h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <template x-for="bawahanItem in detailPegawai.bawahan" :key="bawahanItem.id">
                            <div class="flex items-center p-3 border rounded-lg bg-gray-50  shadow-sm hover:bg-gray-100 transition-colors duration-200">
                                <img 
                                    :src="bawahanItem.foto ? '/storage/foto_pegawai/' + bawahanItem.foto : defaultUserImageUrl" 
                                    alt="Foto Bawahan" 
                                    class="w-12 h-12 rounded-full object-cover mr-4 border-2 border-white"
                                >
                                <div>
                                    <p class="font-semibold text-black" x-text="bawahanItem.nama"></p>
                                    <p class="text-sm text-gray-500" x-text="bawahanItem.jabatan"></p>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://balkan.app/js/OrgChart.js"></script>
    <script>
        // Variabel ini dibuat untuk menyelesaikan konflik antara sintaks Blade dan JS.
        const defaultUserImageUrl = '{{ asset('pictures/default-user.png') }}';

        document.addEventListener('DOMContentLoaded', function() {
            const pegawaiData = @json($pegawai);

            const nodes = pegawaiData.map(p => {
                const tags = p.is_assistant == 1 ? ["assistant"] : [];
                const fotoUrl = p.foto 
                    ? `/storage/foto_pegawai/${p.foto}` 
                    : defaultUserImageUrl; // Menggunakan variabel JS
                
                return {
                    id: p.id,
                    pid: p.atasan_id,
                    name: p.nama,
                    title: p.jabatan,
                    img: fotoUrl,
                    tupoksi: p.tupoksi,
                    tags: tags,
                    nip: p.nip,
                    bidang: p.bidang ? p.bidang.nama : 'Tidak Ada',
                    atasan: p.atasan ? p.atasan.nama : 'Tidak Ada',
                    is_assistant: p.is_assistant,
                    alamat: p.alamat,
                    foto_url: fotoUrl,
                    bawahan: p.bawahan
                };
            });

            const chart = new OrgChart(document.getElementById("tree"), {
                template: "rony",
                nodeMenu: null,
                enableSearch: false,
                nodeMouseClick: OrgChart.action.none,
                mouseScroll: OrgChart.action.zoom,
                
                nodeBinding: {
                    field_0: "name",
                    field_1: "title",
                    img_0: "img"
                },
                tags: {
                    "assistant": {
                        template: "rony"
                    }
                },
                nodes: nodes
            });

            // CATATAN: Logika setTimeout tidak diubah sesuai permintaan.
            // Namun, sangat disarankan untuk mencari event 'ready' atau 'rendered'
            // dari dokumentasi OrgChart.js agar lebih andal.
            setTimeout(function() {
                chart.fit();

                chart.onNodeClick(function(args) {
                    const data = chart.get(args.node.id);
                    window.dispatchEvent(new CustomEvent('pegawai-detail', {
                        detail: data
                    }));
                    return false;
                });
            }, 100);
        });
    </script>
    <x-footer />
</body>
</html>