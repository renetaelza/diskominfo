<!DOCTYPE html>
<html lang="id"
    x-data="{ sidebarOpen: true}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manage Dokumen Informasi Serta Merta</title>

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
                <h3 class="font-semibold text-gray-800 dark:text-white px-4">Manage Dokumen Informasi Dikecualikan</h3>
            </div>

            <!-- Form -->
            <form id="formUpdate" method="POST" action="{{ route('admin.ppid.save') }}" enctype="multipart/form-data" class="p-7">
                @csrf

                <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-md">
                    <!-- Dropdown Pilihan Halaman -->
                    <h4 class="font-semibold text-gray-800 dark:text-white mb-3 text-center">Form Update Dokumen Informasi Dikecualikan</h4>

                    <div class="mb-4">
                        <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Pilih Halaman</label>
                        <select id="halamanSelect" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="loadHalamanData(this.value)">
                            <option value="">-- Pilih Halaman --</option>
                            <option value="Daftar Informasi Dikecualikan">Daftar Informasi Dikecualikan</option>
                            <option value="IKepwal Daftar Informasi Dikecualikan">Kepwal Daftar Informasi Dikecualikan</option>
                        </select>
                        <input type="hidden" name="judul" id="judulHidden">
                    </div>

                    <!-- Kolom Judul -->
                    <div class="mb-4">
                        <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Judul</label>
                        <input type="text" id="judulText" name="judul" readonly
                            class="w-full p-3 border rounded-lg bg-gray-100 text-gray-500 cursor-not-allowed"
                            placeholder="Judul akan muncul otomatis setelah pilih halaman"
                            value="{{ old('judul', $dokumen->judul ?? '') }}">
                    </div>

                    <!-- Lampiran -->
                    <div class="mb-6">
                        <label class="block mb-2 font-medium text-gray-700 dark:text-gray-300">Lampiran</label>

                        <!-- Upload Lampiran Baru -->
                        <input type="file" id="lampiran-input" name="lampiran[]" accept=".pdf" multiple
                            class="w-full mt-3 p-2 border rounded">
                        <p class="text-sm text-gray-500 mt-2">Bisa upload lebih dari satu file. Format: PDF maksimal 2 MB.</p>
                        <p id="lampiran-error" class="text-red-500 text-sm hidden mt-2"></p>

                        <!-- Lampiran Lama dari Database -->
                        <div id="lampiran-lama" class="space-y-2">
                            @foreach(json_decode($dokumen->lampiran ?? '[]', true) as $index => $file)
                            <div class="flex items-center justify-between p-2 border rounded bg-gray-100 dark:bg-gray-700 gap-4">
                                <a href="{{ asset('storage/'.$file) }}" target="_blank"
                                    class="text-blue-600 underline truncate w-11/12">
                                    {{ basename($file) }}
                                </a>
                                <!-- hidden checkbox untuk menandai hapus -->
                                <input type="checkbox" name="hapus_lampiran[]" value="{{ $file }}" id="hapus{{ $index }}">
                                <button type="button"
                                    class="text-red-600 hover:text-red-800 font-bold ml-2"
                                    onclick="document.getElementById('hapus{{ $index }}').checked = true; this.parentElement.style.display='none';">
                                    &times;
                                </button>
                            </div>
                            @endforeach
                        </div>


                    </div>

                    <!-- Preview Lampiran Baru -->
                    <div id="lampiran-preview" class="mt-3 space-y-2"></div>

                    <!-- Submit -->
                    <div class="mt-8">
                        <button type="submit"
                            class="w-full py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold transition">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>

            <!-- Flash message -->
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
    function renderLampiranLama(container, files) {
        container.innerHTML = '';

        if (files && files.length > 0) {
            files.forEach((file, idx) => {
                const div = document.createElement('div');
                div.className = "flex items-center justify-between p-2 border rounded bg-gray-100 dark:bg-gray-700 gap-4";
                div.innerHTML = `
                <a href="/storage/${file}" target="_blank"
                   class="text-blue-600 underline truncate w-11/12">${file.split('/').pop()}</a>
                <input type="checkbox" name="hapus_lampiran[]" value="${file}" id="hapus${idx}" class="hidden">
                <button type="button"
                    class="text-red-600 hover:text-red-800 font-bold ml-2"
                    onclick="document.getElementById('hapus${idx}').checked = true; this.parentElement.style.display='none';">
                    &times;
                </button>
            `;
                container.appendChild(div);
            });
        } else {
            container.innerHTML = `<p class="text-gray-400 italic text-sm">Belum ada lampiran</p>`;
        }
    }

    function loadHalamanData(judul) {
        if (!judul) return;

        fetch(`/admin/ppid/navigasi/${encodeURIComponent(judul)}`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('judulHidden').value = data.judul ?? judul;
                document.getElementById('judulText').value = data.judul ?? judul;

                const container = document.getElementById('lampiran-lama');
                renderLampiranLama(container, data.lampiran ?? []);
            })
            .catch(err => console.error(err));
    }


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

            if (file.type !== "application/pdf") {
                errorMsg.textContent = `File "${file.name}" bukan PDF dan tidak ditambahkan.`;
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
</script>

</html>