<!DOCTYPE html>
<html lang="id"
    x-data="{ sidebarOpen: true}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manage Aplikasi</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        primary: '#2196f3',
                        secondary: '#f50057'
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-100 dark:bg-gray-900 dark:text-white text-gray-900 font-sans">
    <div class="flex h-screen overflow-hidden">
        <x-admin.sidebar />

        <!-- Main Content -->
        <main class="flex-1 overflow-auto bg-gray-50 dark:bg-gray-900">
            <div class="bg-white dark:bg-gray-800 shadow-md pl-6 pr-6 py-5 mb-6 flex items-center">
                <h3 class="font-semibold text-gray-800 dark:text-white px-4">Manage Aplikasi</h3>
            </div>

            <div class="mb-6 text-center">
                <h4 class="font-semibold text-gray-800 dark:text-white mb-3">
                    Penjelasan Kolom &amp; Peletakan di Halaman User
                </h4>
                <img src="{{ asset('pictures/penjelasan_aplikasi.png') }}"
                    alt="Penjelasan Kolom Aplikasi"
                    class="rounded-lg shadow-md border mx-auto max-h-[400px] h-auto">
            </div>

            <!-- Form -->
            <form id="aplikasiForm" method="POST" enctype="multipart/form-data" action="{{ route('admin.aplikasi.update') }}" class="px-10">
                @csrf
                @method('PUT')

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                    <!-- Dropdown Pilihan Halaman -->
                    <h4 class="font-semibold text-gray-800 dark:text-white mb-3 text-center">Form Update Halaman</h4>
                    <div class="mb-4">
                        <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Pilih Halaman</label>
                        <select id="halamanSelect" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="loadHalamanData(this.value)">
                            <option value="">-- Pilih Halaman --</option>
                            <option value="Open Data">Open Data</option>
                            <option value="Kelompok Informasi Masyarakat">Kelompok Informasi Masyarakat</option>
                            <option value="Layanan OPD">Layanan OPD</option>
                            <option value="SP4N Lapor">SP4N Lapor</option>
                            <option value="Whistle Blowing System">Whistle Blowing System</option>
                            <option value="BandungKota-CSIRT Aduan Siber">BandungKota-CSIRT Aduan Siber</option>
                        </select>
                        <input type="hidden" name="judul" id="judulInput">

                    </div>

                    <!-- Tagline -->
                    <div class="mb-4">
                        <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Tagline</label>
                        <input type="text" name="tagline" id="tagline" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-4">
                        <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" rows="4" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>

                    <!-- Subheading & Text -->
                    @for ($i = 1; $i <= 3; $i++)
                        <div class="mb-4">
                        <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Subheading {{ $i }}</label>
                        <input type="text" name="subheading{{ $i }}" id="subheading{{ $i }}" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 mb-2">

                        <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Teks {{ $i }}</label>
                        <textarea name="text{{ $i }}" id="text{{ $i }}" rows="2" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>
                @endfor

                <!-- Foto -->
                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md mb-4">
                    <label class="block mb-2 font-medium text-gray-700 dark:text-gray-300">Foto</label>
                    <input type="file" name="foto" id="foto" accept="image/*" onchange="previewFoto(event)" class="w-full p-2 border rounded">
                    <p class="text-xs text-gray-500 mt-1">Ukuran foto maksimal 2 MB</p>
                    <div id="preview-foto" class="mt-3">
                        <img id="fotoPreview" src="" alt="Preview Foto" class="max-h-40 rounded hidden">
                    </div>
                </div>

                <!-- Link -->
                <div class="mb-4">
                    <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Link</label>
                    <input type="text" name="link" id="link" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Submit -->
                <div class="flex gap-4 mt-8">
                    <div class="w-full">
                        <button type="submit" class="w-full py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold transition">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
    </div>
    </form>
    @if (session('success') || session('error'))
    <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 4000)"
        x-show="show"
        x-transition
        class="fixed bottom-6 right-6 px-6 py-4 rounded-lg shadow-lg text-white
               {{ session('success') ? 'bg-green-500' : 'bg-red-500' }}">
        {{ session('success') ?? session('error') }}
    </div>
    @endif
    </main>
    </div>
</body>
<script>
    function loadHalamanData(judul) {
        document.getElementById('judulInput').value = judul;
        fetch(`/admin/aplikasi/${judul}`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('tagline').value = data.tagline ?? '';
                document.getElementById('deskripsi').value = data.deskripsi ?? '';
                for (let i = 1; i <= 3; i++) {
                    document.getElementById(`subheading${i}`).value = data[`subheading${i}`] ?? '';
                    document.getElementById(`text${i}`).value = data[`text${i}`] ?? '';
                }
                document.getElementById('link').value = data.link ?? '';
                if (data.foto) {
                    document.getElementById('fotoPreview').src = `/${data.foto}`;
                    document.getElementById('fotoPreview').classList.remove('hidden');
                }
            })
            .catch(err => console.error(err));
    }
</script>

</html>