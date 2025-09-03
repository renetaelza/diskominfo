@php
$isEdit = isset($berita);
$action = $isEdit ? route('admin.berita.update', $berita->id) : route('admin.berita.store');
$method = $isEdit ? 'PUT' : 'POST';

$fotoTambahanArray = is_array($berita->foto_tambahan)
? $berita->foto_tambahan
: json_decode($berita->foto_tambahan, true) ?? [];
@endphp

<!DOCTYPE html>
<html lang="id" x-data="{ sidebarOpen: true}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Berita</title>

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
</head>

<body class="bg-gray-100 dark:bg-gray-900 dark:text-white text-gray-900 font-sans">
    <div class="flex h-screen overflow-hidden">
        <x-admin.sidebar />

        <!-- Main Content -->
        <main class="flex-1 overflow-auto bg-gray-50 dark:bg-gray-900">
            <div class="bg-white dark:bg-gray-800 shadow-md pl-6 pr-6 py-5 mb-6 flex items-center">
                <h3 class="font-semibold text-gray-800 dark:text-white px-4">Edit Berita</h3>
            </div>

            <form id="form-berita" action="{{ route('admin.berita.update', $berita->id) }}" method="POST"
                enctype="multipart/form-data" class="px-10">
                @csrf
                @method('PUT')

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                    <!-- Judul -->
                    <div class="mb-4">
                        <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Judul</label>
                        <input type="text" name="judul" id="judul"
                            value="{{ old('judul', $berita->judul) }}"
                            class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <p id="error-judul" class="text-red-500 text-sm mt-1 hidden"></p>
                    </div>

                    <!-- Topik -->
                    <div class="mb-4">
                        <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Topik</label>
                        <select name="topik_id" id="topik"
                            class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="" disabled>Pilih Topik</option>
                            @foreach($topiks as $item)
                            <option value="{{ $item->id }}"
                                {{ old('topik_id', $berita->topik_id) == $item->id ? 'selected' : '' }}>
                                {{ $item->nama }}
                            </option>
                            @endforeach
                        </select>
                        <p id="error-topik" class="text-red-500 text-sm mt-1 hidden"></p>
                    </div>

                    <!-- Isi Berita -->
                    <div class="mb-4">
                        <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Isi Berita</label>
                        <textarea id="editor" name="isi_berita" class="w-full border rounded-lg">
                            {!! old('isi_berita', $berita->isi_berita) !!}
                        </textarea>
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
                            <div id="preview-utama" class="mt-3">
                                @if($berita->foto_utama)
                                <img src="{{ asset($berita->foto_utama) }}" class="h-24 rounded border">
                                @endif
                            </div>
                            <p id="error-foto" class="text-red-500 text-sm mt-1 hidden"></p>
                        </div>

                        <!-- Foto Lainnya -->
                        <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">
                            <label class="block mb-2 font-medium text-gray-700 dark:text-gray-300">Foto Lainnya (Opsional)</label>
                            <input type="file" accept="image/*" id="foto-lain" class="w-full p-2 border rounded" multiple>
                            <div id="preview-container" class="flex flex-wrap gap-3 mt-3">
                                @foreach($fotoTambahanArray as $index => $foto)
                                <div class="relative group" data-index="{{ $index }}">
                                    <img src="{{ asset($foto) }}" class="h-24 rounded border shadow">
                                    <button type="button"
                                        class="btn-hapus-foto absolute top-0 right-0 bg-red-500 text-white rounded-full w-5 h-5 text-xs">
                                        &times;
                                    </button>
                                </div>
                                @endforeach
                            </div>
                            <div id="hidden-files"></div>
                            <input type="hidden" name="existing_foto_tambahan" id="existing-foto-tambahan"
                                value='@json($fotoTambahanArray)'>
                        </div>
                    </div>

                    <!-- Hidden Field -->
                    <input type="hidden" name="tanggal" id="tanggal-input" value="{{ $berita->tanggal }}">
                    <input type="hidden" name="status" id="status-input" value="{{ old('status', $berita->status) }}">

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

<!-- CKEditor Import Map -->
<script type="importmap">
    {
    "imports": {
        "ckeditor5": "{{ asset('ckeditor5/ckeditor5.js') }}",
        "ckeditor5/": "{{ asset('ckeditor5/') }}/"
    }
}
</script>

<!-- CKEditor Init -->
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
            plugins: [
                Alignment, Autoformat, Autosave, BalloonToolbar,
                BlockQuote, Bold, Essentials,
                FontBackgroundColor, FontColor, FontFamily, FontSize,
                GeneralHtmlSupport, Heading, Indent, IndentBlock, Italic,
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

<!-- Script Foto + Submit -->
<script>
    const MAX_FILES = 5;
    let fotoTambahan = [];
    let fotoLama = JSON.parse(document.getElementById('existing-foto-tambahan').value || '[]');

    // Preview foto utama
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

    // Foto tambahan
    document.getElementById('foto-lain').addEventListener('change', function(e) {
        const selected = Array.from(e.target.files);
        if (fotoLama.length + fotoTambahan.length + selected.length > MAX_FILES) {
            alert('Maksimal 5 foto tambahan diperbolehkan!');
            return;
        }
        fotoTambahan.push(...selected);
        e.target.value = "";
        renderAllPreviews();
    });

    function renderAllPreviews() {
        const container = document.getElementById('preview-container');
        const hiddenContainer = document.getElementById('hidden-files');
        container.innerHTML = '';
        hiddenContainer.innerHTML = '';

        fotoLama.forEach((foto, index) => {
            const wrapper = document.createElement('div');
            wrapper.classList.add('relative');
            const img = document.createElement('img');
            img.src = '/' + foto;
            img.classList.add('h-24', 'rounded', 'border', 'shadow');
            const deleteBtn = document.createElement('button');
            deleteBtn.type = 'button';
            deleteBtn.innerHTML = '&times;';
            deleteBtn.className = 'absolute top-0 right-0 bg-red-500 text-white rounded-full w-5 h-5 text-xs';
            deleteBtn.onclick = () => {
                fotoLama.splice(index, 1);
                document.getElementById('existing-foto-tambahan').value = JSON.stringify(fotoLama);
                renderAllPreviews();
            };
            wrapper.appendChild(img);
            wrapper.appendChild(deleteBtn);
            container.appendChild(wrapper);
        });

        fotoTambahan.forEach((file, i) => {
            const reader = new FileReader();
            reader.onload = (e) => {
                const wrapper = document.createElement('div');
                wrapper.classList.add('relative');
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('h-24', 'rounded', 'border', 'shadow');
                const deleteBtn = document.createElement('button');
                deleteBtn.type = 'button';
                deleteBtn.innerHTML = '&times;';
                deleteBtn.className = 'absolute top-0 right-0 bg-red-500 text-white rounded-full w-5 h-5 text-xs';
                deleteBtn.onclick = () => {
                    fotoTambahan.splice(i, 1);
                    renderAllPreviews();
                };
                wrapper.appendChild(img);
                wrapper.appendChild(deleteBtn);
                container.appendChild(wrapper);
            };
            reader.readAsDataURL(file);
        });

        fotoTambahan.forEach(file => {
            const input = document.createElement('input');
            input.type = 'file';
            input.name = 'foto_lain[]';
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

    // Submit
    function setStatusAndSubmit(status) {
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

        if (judul === "") {
            document.getElementById('error-judul').classList.remove('hidden');
            valid = false;
        }
        if (topik === "") {
            document.getElementById('error-topik').classList.remove('hidden');
            valid = false;
        }
        if (isi === "") {
            document.getElementById('error-isi').classList.remove('hidden');
            valid = false;
        }

        if (!valid) return;

        document.getElementById('status-input').value = status;
        document.getElementById('tanggal-input').value = new Date().toISOString();
        document.getElementById('existing-foto-tambahan').value = JSON.stringify(fotoLama);

        document.getElementById('form-berita').submit();
    }

    renderAllPreviews();
</script>

</html>