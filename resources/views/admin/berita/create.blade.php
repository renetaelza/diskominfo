<!DOCTYPE html>
<html lang="id" x-data="{ sidebarOpen: true}">

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
    <link rel="stylesheet" href="{{ asset('ckeditor5/ckeditor5.css') }}">
    <link rel="stylesheet" href="{{ asset('ckeditor5/ckeditor5-content.css') }}">
    <link rel="stylesheet" href="{{ asset('ckeditor5/ckeditor5-editor.css') }}">

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

    <style>
        .ck-content h1 {
            font-size: 2rem;
            font-weight: 700;
        }

        .ck-content h2 {
            font-size: 1.75rem;
            font-weight: 600;
        }

        .ck-content h3 {
            font-size: 1.5rem;
            font-weight: 500;
        }

        .ck-content p {
            font-size: 1rem;
            line-height: 1.6;
        }

        .ck-content ul,
        .ck-content ol {
            list-style-position: outside;
            padding-left: 2rem;
            margin: 0.5em 0;
        }

        .ck-content li {
            margin: 0.25em 0;
            line-height: 1.6;
        }

        .ck-content li::marker {
            font-size: 1rem;
        }

        .ck-content li>h1 {
            font-size: 2rem;
            font-weight: 700;
        }

        .ck-content li:has(> h1)::marker {
            font-size: 2rem;
            font-weight: 700;
        }

        .ck-content li>h2 {
            font-size: 1.75rem;
            font-weight: 600;
        }

        .ck-content li:has(> h2)::marker {
            font-size: 1.75rem;
            font-weight: 600;
        }

        .ck-content li>h3 {
            font-size: 1.5rem;
            font-weight: 500;
        }

        .ck-content li:has(> h3)::marker {
            font-size: 1.5rem;
            font-weight: 500;
        }

        .ck-content li>p[style*="text-align:center"],
        .ck-content li>h1[style*="text-align:center"],
        .ck-content li>h2[style*="text-align:center"],
        .ck-content li>h3[style*="text-align:center"] {
            text-align: center;
        }

        .ck-content li>p[style*="text-align:right"],
        .ck-content li>h1[style*="text-align:right"],
        .ck-content li>h2[style*="text-align:right"],
        .ck-content li>h3[style*="text-align:right"] {
            text-align: right;
        }

        .ck-content li:has(> p[style*="text-align:center"]),
        .ck-content li:has(> h1[style*="text-align:center"]),
        .ck-content li:has(> h2[style*="text-align:center"]),
        .ck-content li:has(> h3[style*="text-align:center"]) {
            text-align: center;
        }

        .ck-content li:has(> p[style*="text-align:right"]),
        .ck-content li:has(> h1[style*="text-align:right"]),
        .ck-content li:has(> h2[style*="text-align:right"]),
        .ck-content li:has(> h3[style*="text-align:right"]) {
            text-align: right;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            20%,
            60% {
                transform: translateX(-5px);
            }

            40%,
            80% {
                transform: translateX(5px);
            }
        }

        .shake {
            animation: shake 0.3s ease;
        }
    </style>
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
                        <input type="text" name="judul" id="judul"
                            class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <p id="error-judul" class="text-red-500 text-sm mt-1 hidden"></p>
                    </div>

                    <!-- Topik -->
                    <div class="mb-4">
                        <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Topik</label>
                        <select name="topik_id" id="topik"
                            class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="" disabled selected>Pilih Topik</option>
                            @foreach($topiks as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                        <p id="error-topik" class="text-red-500 text-sm mt-1 hidden"></p>
                    </div>

                    <!-- Isi Berita -->
                    <div class="mb-4">
                        <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Isi Berita</label>
                        <textarea id="editor" name="isi_berita" class="w-full border rounded-lg"></textarea>
                        <p id="error-isi" class="text-red-500 text-sm mt-1 hidden"></p>
                    </div>

                    <!-- Upload Foto -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Foto Utama -->
                        <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">
                            <label class="block mb-2 font-medium text-gray-700 dark:text-gray-300">Foto Utama (Thumbnail)</label>
                            <input type="file" name="foto_utama" id="foto_utama" accept="image/*"
                                onchange="previewFotoUtama(event)"
                                class="w-full p-2 border rounded">
                            <div id="preview-utama" class="mt-3"></div>
                            <p id="error-foto" class="text-red-500 text-sm mt-1 hidden"></p>
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
                        <div class="relative w-1/2">
                            <button type="button" onclick="setStatusAndSubmit('publikasi')" class="w-full py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold transition">Publikasi</button>
                        </div>
                        <div class="w-1/2">
                            <button type="button" onclick="setStatusAndSubmit('draft')" class="w-full py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 font-semibold transition">Simpan Draft</button>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
</body>

<script type="importmap">
    {
    "imports": {
        "ckeditor5": "{{ asset('ckeditor5/ckeditor5.js') }}",
        "ckeditor5/": "{{ asset('ckeditor5/') }}/"
    }
}
</script>

<script type="module">
    import {
        ClassicEditor,
        Alignment,
        Autoformat,
        Autosave,
        BalloonToolbar,
        BlockQuote,
        Bold,
        Essentials,
        FontBackgroundColor,
        FontColor,
        FontFamily,
        FontSize,
        GeneralHtmlSupport,
        Heading,
        Indent,
        IndentBlock,
        Italic,
        Link,
        List,
        ListProperties,
        MediaEmbed,
        Paragraph,
        PasteFromOffice,
        Strikethrough,
        Subscript,
        Superscript,
        Table,
        TableToolbar,
        TextTransformation,
        TodoList,
        Underline
    } from 'ckeditor5';

    let editorInstance;
    let isEditorReady = false;

    ClassicEditor.create(document.querySelector('#editor'), {
            licenseKey: 'GPL',
            plugins: [Alignment, Autoformat, Autosave, BalloonToolbar,
                BlockQuote, Bold, Essentials,
                FontBackgroundColor, FontColor, FontFamily, FontSize,
                GeneralHtmlSupport, Heading,
                Indent, IndentBlock, Italic,
                Link, List, ListProperties, MediaEmbed,
                Paragraph, PasteFromOffice,
                Strikethrough, Subscript, Superscript,
                Table, TableToolbar, TextTransformation,
                TodoList, Underline
            ],
            toolbar: {
                items: [
                    'undo', 'redo', '|', 'heading', '|',
                    'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', '|',
                    'bold', 'italic', 'underline', 'strikethrough', '|',
                    'link', 'blockQuote', 'insertTable', 'mediaEmbed', '|',
                    'alignment', '|', 'bulletedList', 'numberedList', 'todoList', 'outdent', 'indent'
                ],
                shouldNotGroupWhenFull: false
            }
        })
        .then(editor => {
            editorInstance = editor;
            isEditorReady = true;

            window.editorInstance = editorInstance;
            window.isEditorReady = isEditorReady;
        })
        .catch(error => console.error('CKEditor gagal dimuat:', error));
</script>

<script>
    const MAX_FILES = 5;
    let fotoTambahan = [];

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

    document.getElementById('foto-lain').addEventListener('change', function(event) {
        const files = Array.from(event.target.files);
        if (fotoTambahan.length + files.length > MAX_FILES) {
            alert(`Maksimal ${MAX_FILES} foto tambahan.`);
            return;
        }
        files.forEach(file => {
            fotoTambahan.push(file);
        });
        updatePreview();
        event.target.value = '';
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
        fotoTambahan.forEach((file) => {
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

    function setStatusAndSubmit(status) {
        console.log("Tombol diklik dengan status:", status); // cek apakah masuk sini
        let valid = true;
        const judul = document.getElementById('judul').value.trim();
        const topik = document.getElementById('topik').value;

        let isi = "";
        if (window.isEditorReady && window.editorInstance) {
            isi = window.editorInstance.getData().trim();
            document.getElementById('editor').value = isi;
        } else {
            isi = document.getElementById('editor').value.trim();
        }


        const fotoUtama = document.getElementById('foto_utama').files.length;

        // Reset error
        document.getElementById('error-judul').classList.add('hidden');
        document.getElementById('error-topik').classList.add('hidden');
        document.getElementById('error-isi').classList.add('hidden');
        document.getElementById('error-foto').classList.add('hidden');

        // Validasi
        if (judul === "") {
            document.getElementById('error-judul').innerText = "Judul wajib diisi.";
            document.getElementById('error-judul').classList.remove('hidden');
            valid = false;
        }
        if (topik === "") {
            document.getElementById('error-topik').innerText = "Pilih topik berita.";
            document.getElementById('error-topik').classList.remove('hidden');
            valid = false;
        }
        if (isi === "") {
            document.getElementById('error-isi').innerText = "Isi berita tidak boleh kosong.";
            document.getElementById('error-isi').classList.remove('hidden');
            valid = false;
        }
        if (fotoUtama === 0) {
            document.getElementById('error-foto').innerText = "Foto utama wajib diunggah.";
            document.getElementById('error-foto').classList.remove('hidden');
            valid = false;
        }

        if (!valid) {
            console.log("Form tidak valid, batal submit.");
            return;
        }

        console.log("Form valid, submit...");
        document.getElementById('status-input').value = status;
        document.getElementById('tanggal-input').value = new Date().toISOString();
        document.getElementById('form-berita').submit();
    }
</script>

</html>