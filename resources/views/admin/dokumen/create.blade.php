<!DOCTYPE html>
<html lang="id"
    x-data="{ sidebarOpen: true}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tambah Dokumen</title>

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
                <h3 class="font-semibold text-gray-800 dark:text-white px-4">Tambah Dokumen Baru</h3>
            </div>

            <form id="form-dokumen" action="{{ route('admin.dokumen.store') }}" method="POST" enctype="multipart/form-data" class="px-10">
                @csrf

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                    <!-- Nama Dokumen -->
                    <div class="mb-4">
                        <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Nama Dokumen</label>
                        <input type="text" name="nama_dokumen"
                            value="{{ old('nama_dokumen') }}"
                            class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('nama_dokumen') border-red-500 @enderror" required>
                        @error('nama_dokumen')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kategori -->
                    <div class="mb-4">
                        <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Kategori Dokumen</label>
                        <select name="kategoriDokumen_id"
                            class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('kategoriDokumen_id') border-red-500 @enderror" required>
                            <option disabled {{ old('kategoriDokumen_id') ? '' : 'selected' }}>Pilih Kategori</option>
                            @foreach($kategoriDokumen as $item)
                            <option value="{{ $item->id }}" {{ old('kategoriDokumen_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->nama }}
                            </option>
                            @endforeach
                        </select>
                        @error('kategoriDokumen_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-4">
                        <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Deskripsi Dokumen</label>
                        <textarea name="deskripsi_dokumen" rows="6"
                            class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('deskripsi_dokumen') border-red-500 @enderror" required>{{ old('deskripsi_dokumen') }}</textarea>
                        @error('deskripsi_dokumen')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Lampiran -->
                    <div class="mb-6">
                        <label class="block mb-2 font-medium text-gray-700 dark:text-gray-300">Lampiran</label>
                        <input type="file" id="lampiran-input" name="lampiran[]" accept=".pdf"
                            multiple class="w-full p-2 border rounded @error('lampiran') border-red-500 @enderror" required>
                        <p class="text-sm text-gray-500 mt-2">Bisa upload lebih dari satu file. Format: PDF maksimal 2 MB</p>
                        <div id="lampiran-preview" class="mt-4 space-y-2"></div>
                        <p id="lampiran-error" class="text-sm text-red-600 mt-2 hidden"></p>
                        @error('lampiran')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Hidden Field for Date -->
                    <input type="hidden" name="tanggal" id="tanggal-input">
                    <input type="hidden" name="status" id="status-input" value="draft">

                    <!-- Tombol Aksi -->
                    <div class="flex gap-4 mt-8">
                        <button type="button" onclick="setStatusAndSubmit('publikasi')" class="w-1/2 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Publikasi</button>
                        <button type="button" onclick="setStatusAndSubmit('draft')" class="w-1/2 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Simpan Draft</button>
                    </div>
                </div>
            </form>
        </main>
    </div>
</body>
<script>
    const inputLampiran = document.getElementById('lampiran-input');
    const errorMsg = document.getElementById('lampiran-error');
    const previewContainer = document.getElementById('lampiran-preview');
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

    function validateForm() {
        let isValid = true;
        document.querySelectorAll('.error-message').forEach(e => e.remove());
        document.querySelectorAll('#form-dokumen input, #form-dokumen select, #form-dokumen textarea')
            .forEach(el => el.classList.remove('border-red-500'));

        // cek nama dokumen
        const nama = document.querySelector('input[name="nama_dokumen"]');
        if (!nama.value.trim()) {
            showError(nama, 'Nama dokumen wajib diisi');
            isValid = false;
        }

        // cek kategori
        const kategori = document.querySelector('select[name="kategoriDokumen_id"]');
        if (!kategori.value) {
            showError(kategori, 'Kategori wajib dipilih');
            isValid = false;
        }

        // cek deskripsi
        const deskripsi = document.querySelector('textarea[name="deskripsi_dokumen"]');
        if (!deskripsi.value.trim()) {
            showError(deskripsi, 'Deskripsi wajib diisi');
            isValid = false;
        }

        // cek lampiran
        const lampiran = document.querySelector('#lampiran-input');
        if (lampiran.files.length === 0) {
            showError(lampiran, 'Minimal 1 lampiran harus diunggah');
            isValid = false;
        }

        return isValid;
    }

    function showError(element, message) {
        element.classList.add('border-red-500');
        const error = document.createElement('p');
        error.className = 'error-message text-red-500 text-sm mt-1';
        error.innerText = message;
        element.parentNode.appendChild(error);
    }

    function setStatusAndSubmit(status) {
        if (!validateForm()) return;
        document.getElementById('status-input').value = status;
        document.getElementById('tanggal-input').value = new Date().toISOString();
        document.getElementById('form-dokumen').submit();
    }
</script>


</html>
