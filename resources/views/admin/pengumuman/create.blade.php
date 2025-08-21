<!DOCTYPE html>
<html lang="id"
    x-data="{ sidebarOpen: true}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tambah Pengumuman</title>

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
                <h3 class="font-semibold text-gray-800 dark:text-white px-4">Tambah Pengumuman Baru</h3>
            </div>

            <form id="form-pengumuman" action="{{ route('admin.pengumuman.store') }}" method="POST" enctype="multipart/form-data" class="px-10">
                @csrf

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                    <!-- Judul -->
                    <div class="mb-4">
                        <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Judul</label>
                        <input type="text" name="judul" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>

                    <!-- Topik -->
                    <div class="mb-4">
                        <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Topik</label>
                        <select name="topik_id" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option value="" disabled selected>Pilih Topik</option>
                            @foreach($topiks as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Isi pengumuman -->
                    <div class="mb-4">
                        <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Isi Pengumuman</label>
                        <textarea name="isi_pengumuman" rows="6" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
                    </div>

                    <!-- Lampiran (Opsional) -->
                    <div class="mb-6">
                        <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">
                            <label class="block mb-2 font-medium text-gray-700 dark:text-gray-300">Lampiran (PDF, Word, Foto - Opsional)</label>
                            <input type="file" id="lampiran-input" name="lampiran[]" accept=".pdf,.doc,.docx,image/*" multiple class="w-full p-2 border rounded">
                            <p class="text-sm text-gray-500 mt-2">Bisa unggah lebih dari satu file. Maks: PDF, DOC, DOCX, JPG, PNG.</p>
                        </div>

                        <!-- Preview file -->
                        <div id="lampiran-preview" class="mt-4 space-y-2">
                            <!-- Preview items will be inserted here -->
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
                        </div>

                        <!-- Simpan Draft -->
                        <div class="w-1/2">
                            <button type="button" onclick="setStatusAndSubmit('draft')" class="w-full py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 font-semibold transition">Simpan Draft</button>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
</body>
<script>
    const inputLampiran = document.getElementById('lampiran-input');
    const previewContainer = document.getElementById('lampiran-preview');
    let fileList = [];

    inputLampiran.addEventListener('change', function(e) {
        const files = Array.from(e.target.files);

        for (const file of files) {
            if (!fileList.find(f => f.name === file.name)) {
                fileList.push(file);
            }
        }

        renderPreview();
        syncFileInput();
    });

    function renderPreview() {
        previewContainer.innerHTML = '';

        fileList.forEach((file, index) => {
            const wrapper = document.createElement('div');
            wrapper.className = 'flex items-center justify-between p-3 border rounded bg-gray-100 dark:bg-gray-700';

            const name = document.createElement('span');
            name.className = 'text-sm text-gray-800 dark:text-white truncate w-11/12';
            name.innerText = file.name;

            const removeBtn = document.createElement('button');
            removeBtn.innerHTML = '&times;';
            removeBtn.className = 'text-red-500 text-xl font-bold px-2';
            removeBtn.type = 'button';
            removeBtn.onclick = () => {
                fileList.splice(index, 1);
                renderPreview();
                syncFileInput();
            };

            wrapper.appendChild(name);
            wrapper.appendChild(removeBtn);
            previewContainer.appendChild(wrapper);
        });
    }

    function syncFileInput() {
        const dataTransfer = new DataTransfer();
        fileList.forEach(file => dataTransfer.items.add(file));
        inputLampiran.files = dataTransfer.files;
    }

    function setStatusAndSubmit(status) {
        document.getElementById('status-input').value = status;
        document.getElementById('tanggal-input').value = new Date().toISOString();
        document.getElementById('form-pengumuman').submit();
    }
</script>


</html>