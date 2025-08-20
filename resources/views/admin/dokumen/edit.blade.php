<!DOCTYPE html>
<html lang="id" x-data="{ sidebarOpen: true }">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Dokumen</title>

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
                        sans: ['Poppins', 'sans-serif']
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
                <h3 class="font-semibold text-gray-800 dark:text-white px-4">Perbaharui Dokumen</h3>
            </div>

            <form id="form-dokumen"
                action="{{ route('admin.dokumen.update', $dokumen->id) }}"
                method="POST" enctype="multipart/form-data"
                class="px-10">
                @csrf
                @method('PUT')

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                    <!-- Nama Dokumen -->
                    <div class="mb-4">
                        <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Nama Dokumen</label>
                        <input type="text" name="nama_dokumen"
                            class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ old('nama_dokumen', $dokumen->nama_dokumen) }}" required>
                    </div>

                    <!-- Kategori Dokumen -->
                    <div class="mb-4">
                        <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Kategori Dokumen</label>
                        <select name="kategoriDokumen_id"
                            class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option disabled>Pilih Kategori</option>
                            @foreach($kategoriDokumen as $item)
                            <option value="{{ $item->id }}"
                                {{ $item->id == $dokumen->kategoriDokumen_id ? 'selected' : '' }}>
                                {{ $item->nama }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-4">
                        <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Deskripsi Dokumen</label>
                        <textarea name="deskripsi_dokumen" rows="6"
                            class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>{{ old('deskripsi_dokumen', $dokumen->deskripsi_dokumen) }}</textarea>
                    </div>

                    <!-- Lampiran -->
                    <div class="mb-6">
                        <label class="block mb-2 font-medium text-gray-700 dark:text-gray-300">Lampiran</label>
                        <input type="file" id="lampiran-input" name="lampiran[]" accept=".pdf" multiple
                            class="w-full p-2 border rounded">
                        <p class="text-sm text-gray-500 mt-2">Bisa upload lebih dari satu file. Format: PDF maksimal 2 MB.</p>
                        <p id="lampiran-error" class="text-red-500 text-sm hidden mt-2"></p>

                        <!-- Preview file -->
                        <div class="mt-4 space-y-2">
                            <!-- Lampiran Lama -->
                            <div id="lampiran-lama" class="space-y-2">
                                @foreach(json_decode($dokumen->lampiran ?? '[]', true) as $index => $file)
                                <div class="flex items-center justify-between p-2 border rounded bg-gray-100 dark:bg-gray-700 gap-4">
                                    <a href="{{ asset('storage/'.$file) }}" target="_blank"
                                        class="text-blue-600 underline truncate w-11/12">
                                        {{ basename($file) }}
                                    </a>
                                    <input type="checkbox" name="hapus_lampiran[]" value="{{ $file }}"
                                        class="hidden" x-ref="checkbox{{ $index }}">
                                    <button type="button"
                                        class="text-red-600 hover:text-red-800 font-bold ml-2"
                                        @click="$refs['checkbox{{ $index }}'].checked = true; $el.parentElement.style.display = 'none'">
                                        &times;
                                    </button>
                                </div>
                                @endforeach
                            </div>

                            <!-- Lampiran Baru -->
                            <div id="lampiran-baru" class="space-y-2"></div>
                        </div>
                    </div>

                    <!-- Hidden Field -->
                    <input type="hidden" name="tanggal" id="tanggal-input">
                    <input type="hidden" name="status" id="status-input" value="draft">

                    <!-- Tombol Aksi -->
                    <div class="flex gap-4 mt-8">
                        <div class="w-1/2">
                            <button type="button" onclick="setStatusAndSubmit('publikasi')"
                                class="w-full py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold transition">
                                Publikasi
                            </button>
                        </div>
                        <div class="w-1/2">
                            <button type="button" onclick="setStatusAndSubmit('draft')"
                                class="w-full py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 font-semibold transition">
                                Simpan Draft
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>

    <script>
        const inputLampiran = document.getElementById('lampiran-input');
        const previewBaru = document.getElementById('lampiran-baru');
        const errorMsg = document.getElementById('lampiran-error');
        let fileList = [];

        inputLampiran.addEventListener('change', function(e) {
            const files = Array.from(e.target.files);
            errorMsg.classList.add('hidden');
            for (const file of files) {
                if (file.size > 2 * 1024 * 1024) {
                    errorMsg.textContent = `File "${file.name}" melebihi 2MB dan tidak ditambahkan.`;
                    errorMsg.classList.remove('hidden');
                    continue;
                }
                if (!fileList.find(f => f.name === file.name)) {
                    fileList.push(file);
                }
            }
            renderPreviewBaru();
            syncFileInput();
        });

        function renderPreviewBaru() {
            previewBaru.innerHTML = '';
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
                    renderPreviewBaru();
                    syncFileInput();
                };

                wrapper.appendChild(name);
                wrapper.appendChild(removeBtn);
                previewBaru.appendChild(wrapper);
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
            document.getElementById('form-dokumen').submit();
        }
    </script>
</body>

</html>
