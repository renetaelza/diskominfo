<!DOCTYPE html>
<html lang="id"
    x-data="{ sidebarOpen: true}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tambah Berita</title>

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
                <h3 class="font-semibold text-gray-800 dark:text-white px-4">Tambah berita baru</h3>
            </div>

            <form id="form-berita" action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data" class="px-10">
                @csrf

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                    <!-- Judul -->
                    <div class="mb-4">
                        <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Judul</label>
                        <input type="text" name="judul" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>

                    <!-- Kategori -->
                    <div class="mb-4">
                        <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Kategori (Bidang)</label>
                        <select name="kategori_id" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option disabled selected>Pilih Bidang</option>
                            @foreach($bidang as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Isi Berita -->
                    <div class="mb-4">
                        <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Isi Berita</label>
                        <textarea name="isi_berita" rows="6" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
                    </div>

                    <!-- Upload Foto -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Foto Utama -->
                        <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">
                            <label class="block mb-2 font-medium text-gray-700 dark:text-gray-300">Foto Utama (Thumbnail)</label>
                            <input type="file" name="foto_utama" accept="image/*" onchange="previewFotoUtama(event)" class="w-full p-2 border rounded" required>
                            <div id="preview-utama" class="mt-3"></div>
                            <p class="text-sm text-gray-500 mt-2">Maksimal 1 foto, akan menimpa yang sebelumnya jika diganti.</p>
                        </div>

                        <!-- Foto Lainnya -->
                        <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">
                            <label class="block mb-2 font-medium text-gray-700 dark:text-gray-300">Foto Lainnya (Opsional)</label>
                            <input type="file" accept="image/*" id="foto-lain" class="w-full p-2 border rounded">
                            <div id="preview-container" class="flex flex-wrap gap-3 mt-3"></div>
                            <div id="hidden-files"></div>
                        </div>
                    </div>

                    <!-- Hidden Field for Date -->
                    <input type="hidden" name="tanggal" id="tanggal-input">
                    <input type="hidden" name="status" id="status-input" value="draft">

                    <!-- Tombol Aksi -->
                    <div class="flex gap-4 mt-8">
                        <!-- Publikasi -->
                        <div class="relative w-1/2">
                            <button type="button" onclick="setStatusAndSubmit('publikasi')" class="w-full py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold transition">Publikasi</button>
                            <!-- <button type="button" onclick="toggleJadwal()" class="absolute top-1/2 right-4 transform -translate-y-1/2 text-sm text-white hover:text-gray-200">&#9662;</button>

                            <!-- Pop-up Jadwal -->
                            <!-- <div id="jadwal-popup" class="absolute mt-2 w-64 bg-white border rounded-lg shadow-lg z-50 p-4 hidden">
                                <p class="font-semibold mb-2">Jadwalkan pengiriman</p>
                                <ul class="space-y-2 text-sm">
                                    <li><a href="#" onclick="jadwalkan('tomorrow-08')">Besok pagi <span class="float-right">08.00</span></a></li>
                                    <li><a href="#" onclick="jadwalkan('tomorrow-13')">Besok siang <span class="float-right">13.00</span></a></li>
                                    <li><a href="#" onclick="jadwalkan('nextday-08')">Lusa pagi <span class="float-right">08.00</span></a></li>
                                </ul>
                                <hr class="my-2">
                                <button type="button" onclick="document.getElementById('date-picker').showModal()" class="w-full mt-2 text-sm border p-2 rounded">Pilih tanggal & waktu</button>
                            </div> -->
                        </div>

                        <!-- Simpan Draft -->
                        <div class="w-1/2">
                            <button type="button" onclick="setStatusAndSubmit('draft')" class="w-full py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 font-semibold transition">Simpan Draft</button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Modal Tanggal -->
            <dialog id="date-picker" class="rounded-lg p-4 max-w-md mx-auto bg-white dark:bg-gray-800">
                <p class="font-semibold mb-4">Pilih tanggal & waktu</p>
                <input type="datetime-local" id="custom-date" class="w-full border p-2 rounded mb-4 min-w-0" min="{{ now()->addMinute()->format('Y-m-d\TH:i') }}">
                <div class="flex justify-end gap-2">
                    <button onclick="document.getElementById('date-picker').close()" class="text-sm px-4 py-2">Batal</button>
                    <button onclick="jadwalkan('custom')" class="bg-blue-600 text-white text-sm px-4 py-2 rounded">Simpan</button>
                </div>
            </dialog>
        </main>
    </div>
</body>
<script>
    const MAX_FILES = 5;
    let fotoTambahan = [];

    // Preview untuk foto utama
    function previewFotoUtama(event) {
        const container = document.getElementById('preview-utama');
        container.innerHTML = '';

        const file = event.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = (e) => {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.classList.add('h-24', 'rounded', 'border');
            container.appendChild(img);
        };
        reader.readAsDataURL(file);
    }

    // Preview untuk foto lainnya (tanpa mengubah file input)
    document.getElementById('foto-lain').addEventListener('change', function(event) {
        const files = Array.from(event.target.files);

        // Cegah melebihi 5
        if (fotoTambahan.length + files.length > MAX_FILES) {
            alert(`Maksimal ${MAX_FILES} foto tambahan.`);
            return;
        }

        files.forEach(file => {
            fotoTambahan.push(file);
        });

        updatePreview();
        event.target.value = ''; // Clear input
    });

    function updatePreview() {
        const container = document.getElementById('preview-container');
        const hiddenContainer = document.getElementById('hidden-files');
        container.innerHTML = '';
        hiddenContainer.innerHTML = '';

        fotoTambahan.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const wrapper = document.createElement('div');
                wrapper.classList.add('relative');

                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('h-24', 'rounded', 'border');

                const deleteBtn = document.createElement('button');
                deleteBtn.type = 'button';
                deleteBtn.innerHTML = '&times;';
                deleteBtn.className = 'absolute top-0 right-0 bg-red-500 text-white rounded-full w-5 h-5 text-xs';
                deleteBtn.onclick = () => {
                    fotoTambahan.splice(index, 1);
                    updatePreview();
                };

                wrapper.appendChild(img);
                wrapper.appendChild(deleteBtn);
                container.appendChild(wrapper);
            };
            reader.readAsDataURL(file);
        });

        // Simpan semua file ke FormData manual via hidden input (Trick)
        fotoTambahan.forEach((file, i) => {
            const input = document.createElement('input');
            input.type = 'file';
            input.name = `foto_lain[]`;
            input.files = createFileList([file]);
            input.style.display = 'none';
            hiddenContainer.appendChild(input);
        });
    }

    function createFileList(files) {
        const dataTransfer = new DataTransfer();
        files.forEach(file => dataTransfer.items.add(file));
        return dataTransfer.files;
    }

    // Fungsi untuk set status dan submit form
    function setStatusAndSubmit(status) {
        document.getElementById('status-input').value = status;
        document.getElementById('tanggal-input').value = new Date().toISOString();
        document.getElementById('form-berita').submit();
    }

    // Fungsi jadwal khusus (jika diaktifkan nanti)
    function jadwalkan(option) {
        const now = new Date();
        let date = new Date();

        if (option === 'tomorrow-08') {
            date.setDate(now.getDate() + 1);
            date.setHours(8, 0, 0, 0);
        } else if (option === 'tomorrow-13') {
            date.setDate(now.getDate() + 1);
            date.setHours(13, 0, 0, 0);
        } else if (option === 'nextday-08') {
            date.setDate(now.getDate() + 2);
            date.setHours(8, 0, 0, 0);
        } else if (option === 'custom') {
            const custom = document.getElementById('custom-date').value;
            if (custom) {
                date = new Date(custom);
            } else {
                alert('Tanggal custom tidak valid.');
                return;
            }
        }

        document.getElementById('status-input').value = 'publikasi';
        document.getElementById('tanggal-input').value = date.toISOString();
        document.getElementById('jadwal-popup').classList.add('hidden');
        document.getElementById('form-berita').submit();
    }
</script>

</html>