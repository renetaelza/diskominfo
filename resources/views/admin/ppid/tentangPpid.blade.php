<!DOCTYPE html>
<html lang="id" x-data="{ sidebarOpen: true }">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manage Dokumen Informasi Berkala</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- CKEditor 5 Classic Build -->
    <link rel="stylesheet" href="{{ asset('ckeditor5/ckeditor5.css') }}">
    <link rel="stylesheet" href="{{ asset('ckeditor5/ckeditor5-content.css') }}">
    <link rel="stylesheet" href="{{ asset('ckeditor5/ckeditor5-editor.css') }}">

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['Poppins', 'sans-serif'] },
                    colors: { primary: '#2196f3', secondary: '#f50057' }
                }
            }
        }
    </script>

    <style>
        .ck-content h1 { font-size: 2rem; font-weight: 700; }
        .ck-content h2 { font-size: 1.75rem; font-weight: 600; }
        .ck-content h3 { font-size: 1.5rem; font-weight: 500; }
        .ck-content p { font-size: 1rem; line-height: 1.6; }

        /* List umum */
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

        /* Marker ikut ukuran isi */
        .ck-content li::marker { font-size: 1rem; }

        /* Kalau li berisi heading → marker ikut heading */
        .ck-content li > h1 { font-size: 2rem; font-weight: 700; }
        .ck-content li:has(> h1)::marker { font-size: 2rem; font-weight: 700; }

        .ck-content li > h2 { font-size: 1.75rem; font-weight: 600; }
        .ck-content li:has(> h2)::marker { font-size: 1.75rem; font-weight: 600; }

        .ck-content li > h3 { font-size: 1.5rem; font-weight: 500; }
        .ck-content li:has(> h3)::marker { font-size: 1.5rem; font-weight: 500; }

        /* Alignment fix → ikuti child <p> atau heading */
        .ck-content li > p[style*="text-align:center"],
        .ck-content li > h1[style*="text-align:center"],
        .ck-content li > h2[style*="text-align:center"],
        .ck-content li > h3[style*="text-align:center"] {
        text-align: center;
        }
        .ck-content li > p[style*="text-align:right"],
        .ck-content li > h1[style*="text-align:right"],
        .ck-content li > h2[style*="text-align:right"],
        .ck-content li > h3[style*="text-align:right"] {
        text-align: right;
        }

        .ck-content li:has(> p[style*="text-align:center"]),
        .ck-content li:has(> h1[style*="text-align:center"]),
        .ck-content li:has(> h2[style*="text-align:center"]),
        .ck-content li:has(> h3[style*="text-align:center"]) {
        text-align: center;
        }

        /* Kalau child punya text-align:right → li ikut right */
        .ck-content li:has(> p[style*="text-align:right"]),
        .ck-content li:has(> h1[style*="text-align:right"]),
        .ck-content li:has(> h2[style*="text-align:right"]),
        .ck-content li:has(> h3[style*="text-align:right"]) {
        text-align: right;
        }

        @keyframes shake {
        0%, 100% { transform: translateX(0); }
        20%, 60% { transform: translateX(-5px); }
        40%, 80% { transform: translateX(5px); }
        }

        .shake {
        animation: shake 0.3s ease;
        }
    </style>
</head>

<body class="bg-gray-100 dark:bg-gray-900 dark:text-white text-gray-900 font-sans">
    <div class="flex h-screen overflow-hidden">
        <x-admin.sidebar />

        <main class="flex-1 overflow-auto bg-gray-50 dark:bg-gray-900">
            <div class="bg-white dark:bg-gray-800 shadow-md pl-6 pr-6 py-4 my-1 mb-6 flex items-center">
                <h3 class="font-semibold text-gray-800 dark:text-white px-4">Manage Tentang PPID</h3>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 max-w-5xl mx-auto">
                <form id="pageForm" method="POST" action="{{ route('admin.ppid.tentangUpdate') }}">
                    @csrf

                    <!-- Pilih Halaman -->
                    <div class="mb-4">
                        <label class="block font-medium mb-2 text-gray-700 dark:text-gray-300">Pilih Halaman</label>
                        <select id="halamanSelect" name="judul"
                                class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                onchange="loadPageData(this.value)">
                            <option value="">-- Pilih Halaman --</option>
                            <option value="Profile PPID Diskominfo">Profile PPID Diskominfo</option>
                            <option value="Agenda PPID">Agenda PPID</option>
                        </select>
                        <input type="hidden" name="slug" id="slugInput">
                        <p id="errorText" class="text-red-500 text-sm mt-1 hidden">Pilih halaman sebelum submit form.</p>
                    </div>

                    <!-- CKEditor -->
                    <div class="mb-4">
                        <label class="block font-medium mb-2 text-gray-700 dark:text-gray-300">Konten</label>
                        <textarea id="editor" name="konten" class="w-full border rounded-lg"></textarea>
                    </div>

                    <button type="submit"
                            class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition">
                        Simpan Perubahan
                    </button>
                </form>
            </div>

            <!-- Flash message -->
            @if (session('success') || session('error'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)"
                 x-show="show" x-transition
                 class="fixed bottom-6 right-6 px-6 py-4 rounded-lg shadow-lg text-white
                        {{ session('success') ? 'bg-green-500' : 'bg-red-500' }}">
                {{ session('success') ?? session('error') }}
            </div>
            @endif
        </main>
    </div>

    

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
            AutoImage,
            Autosave,
            BalloonToolbar,
            BlockQuote,
            Bold,
            Emoji,
            Essentials,
            FontBackgroundColor,
            FontColor,
            FontFamily,
            FontSize,
            GeneralHtmlSupport,
            Heading,
            ImageBlock,
            ImageCaption,
            ImageEditing,
            ImageInline,
            ImageInsert,
            ImageInsertViaUrl,
            ImageResize,
            ImageStyle,
            ImageTextAlternative,
            ImageToolbar,
            ImageUpload,
            ImageUtils,
            Indent,
            IndentBlock,
            Italic,
            Link,
            LinkImage,
            List,
            ListProperties,
            MediaEmbed,
            Mention,
            PageBreak,
            Paragraph,
            PasteFromOffice,
            SimpleUploadAdapter,
            SpecialCharacters,
            SpecialCharactersArrows,
            SpecialCharactersCurrency,
            SpecialCharactersEssentials,
            SpecialCharactersLatin,
            SpecialCharactersMathematical,
            SpecialCharactersText,
            Strikethrough,
            Subscript,
            Superscript,
            Table,
            TableCaption,
            TableCellProperties,
            TableColumnResize,
            TableLayout,
            TableProperties,
            TableToolbar,
            TextTransformation,
            TodoList,
            Underline
        } from 'ckeditor5';

        let editor;
        document.addEventListener('DOMContentLoaded', function () {
            
            ClassicEditor
                .create( document.querySelector( '#editor' ), {
                    licenseKey: 'GPL',
                    plugins: [
                        Alignment,
                        Autoformat,
                        AutoImage,
                        Autosave,
                        BalloonToolbar,
                        BlockQuote,
                        Bold,
                        Emoji,
                        Essentials,
                        FontBackgroundColor,
                        FontColor,
                        FontFamily,
                        FontSize,
                        GeneralHtmlSupport,
                        Heading,
                        ImageBlock,
                        ImageCaption,
                        ImageEditing,
                        ImageInline,
                        ImageInsert,
                        ImageInsertViaUrl,
                        ImageResize,
                        ImageStyle,
                        ImageTextAlternative,
                        ImageToolbar,
                        ImageUpload,
                        ImageUtils,
                        Indent,
                        IndentBlock,
                        Italic,
                        Link,
                        LinkImage,
                        List,
                        ListProperties,
                        MediaEmbed,
                        Mention,
                        PageBreak,
                        Paragraph,
                        PasteFromOffice,
                        SimpleUploadAdapter,
                        SpecialCharacters,
                        SpecialCharactersArrows,
                        SpecialCharactersCurrency,
                        SpecialCharactersEssentials,
                        SpecialCharactersLatin,
                        SpecialCharactersMathematical,
                        SpecialCharactersText,
                        Strikethrough,
                        Subscript,
                        Superscript,
                        Table,
                        TableCaption,
                        TableCellProperties,
                        TableColumnResize,
                        TableLayout,
                        TableProperties,
                        TableToolbar,
                        TextTransformation,
                        TodoList,
                        Underline
                    ],
                    toolbar: {
                        items: [
                            'undo',
                            'redo',
                            '|',
                            'heading',
                            '|',
                            'fontSize',
                            'fontFamily',
                            'fontColor',
                            'fontBackgroundColor',
                            '|',
                            'bold',
                            'italic',
                            'underline',
                            '|',
                            'link',
                            'insertImage',
                            'insertTable',
                            'insertTableLayout',
                            'blockQuote',
                            '|',
                            'alignment',
                            '|',
                            'bulletedList',
                            'numberedList',
                            'todoList',
                            'outdent',
                            'indent'
                        ],
                        shouldNotGroupWhenFull: false
                    },
                    simpleUpload: {
                        uploadUrl: '{{ route("admin.ppid.uploadImage") }}',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                    },

                    balloonToolbar: ['bold', 'italic', '|', 'link', 'insertImage', '|', 'bulletedList', 'numberedList'],

                    fontFamily: {
                        supportAllValues: true
                    },

                    fontSize: {
                        options: [10, 12, 14, 'default', 18, 20, 22],
                        supportAllValues: true
                    },

                    heading: {
                        options: [
                            {
                                model: 'paragraph',
                                title: 'Paragraph',
                                class: 'ck-heading_paragraph'
                            },
                            {
                                model: 'heading1',
                                view: 'h1',
                                title: 'Heading 1',
                                class: 'ck-heading_heading1'
                            },
                            {
                                model: 'heading2',
                                view: 'h2',
                                title: 'Heading 2',
                                class: 'ck-heading_heading2'
                            },
                            {
                                model: 'heading3',
                                view: 'h3',
                                title: 'Heading 3',
                                class: 'ck-heading_heading3'
                            },
                        ]
                    },

                    htmlSupport: {
                        allow: [
                            {
                                name: /^.*$/,
                                styles: true,
                                attributes: true,
                                classes: true
                            }
                        ]
                    },

                    image: {
                        toolbar: [
                            'toggleImageCaption',
                            'imageTextAlternative',
                            '|',
                            'imageStyle:inline',
                            'imageStyle:wrapText',
                            'imageStyle:breakText',
                            '|',
                            'resizeImage'
                        ]
                    },

                    link: {
                        addTargetToExternalLinks: true,
                        defaultProtocol: 'https://',
                        decorators: {
                            toggleDownloadable: {
                                mode: 'manual',
                                label: 'Downloadable',
                                attributes: {
                                    download: 'file'
                                }
                            }
                        }
                    },

                    list: {
                        properties: {
                            styles: true,
                            startIndex: true,
                            reversed: true
                        }
                    },
                    menuBar: {
                        isVisible: true
                    },

                    table: {
                        contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells', 'tableProperties', 'tableCellProperties']
                    }
                } )
                .then( editor => {
                    console.log( 'Editor berhasil dimuat menggunakan importmap!', editor );
                    window.editor = editor;
                } )
                .catch( error => {
                    console.error( 'GAGAL memuat editor via importmap:', error );
                } );
        });
    </script>
    <script>

        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById("pageForm");
            const select = document.getElementById("halamanSelect");
            const errorText = document.getElementById("errorText");

            // Saat submit → periksa value pakai "AJAX-style" (preventDefault dulu)
            form.addEventListener("submit", function(e) {
                if (select.value === "") {
                    e.preventDefault(); // cegah submit
                    errorText.classList.remove("hidden"); // tampilkan error

                    errorText.classList.remove("shake"); // reset dulu
                    void errorText.offsetWidth; // trigger reflow supaya animasi bisa diputar ulang
                    errorText.classList.add("shake");
                } else {
                    errorText.classList.add("hidden"); // hilangkan error
                }
            });

            // Saat dropdown berubah → otomatis sembunyikan error
            select.addEventListener("change", function() {
                if (this.value !== "") {
                    errorText.classList.add("hidden");
                }
            });
        });

        function loadPageData(judul) {
            if (!judul) return;

            const slug = judul.toLowerCase().replace(/\s+/g, '-');
            document.getElementById('slugInput').value = slug;

            fetch(`/admin/ppid/tentang-ppid/${slug}`)
                .then(res => res.json())
                .then(data => {
                    editor.setData(data.konten ?? '');
                })
                .catch(err => console.error(err));
        }
    </script>
</body>
</html>
