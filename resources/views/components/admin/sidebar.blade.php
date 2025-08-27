<aside x-data="{ sidebarOpen: true, openMenus: {} }"
    :class="sidebarOpen ? 'w-64' : 'w-20'"
    class="relative bg-white dark:bg-gray-800 shadow-md transition-all duration-300 flex flex-col">

    <!-- Header Logo -->
    <div class="flex items-center justify-between px-4 py-3 border-b border-gray-300 dark:border-gray-600">
        <div class="flex items-center space-x-2">
            <img src="{{ asset('pictures/logo_diskominfo2.png') }}" class="h-9 w-9 object-contain" alt="Logo Diskominfo">
            <span x-show="sidebarOpen" class="text-base font-semibold text-gray-800 dark:text-white">Dashboard Admin</span>
        </div>
    </div>

    <!-- Toggle Button -->
    <button
        @click="sidebarOpen = !sidebarOpen"
        class="absolute -right-2 top-5 z-50 bg-primary text-white rounded-full shadow-lg w-6 h-6 flex items-center justify-center hover:bg-blue-600 transition-all duration-300"
        :class="sidebarOpen ? 'rotate-180' : ''">
        <i class="fas fa-angle-left text-sm"></i>
    </button>

    <!-- Navigation -->
    <nav class="flex-1 flex flex-col px-2 py-4 space-y-1 text-sm">
        @php
        $menus = [
        ['icon' => 'fa-tachometer-alt', 'label' => 'Dashboard', 'route' => route('admin.dashboard')],
        ['icon' => 'fa-television', 'label' => 'Banner Utama', 'route' => route('admin.banner.index')],
        ['icon' => 'fa-newspaper', 'label' => 'Berita', 'route' => route('admin.berita.index')],
        ];

        $groups = [
        [
        'icon' => 'fa-info-circle',
        'label' => 'Informasi',
        'children' => [
        ['icon' => 'fa-file', 'label' => 'Dokumen Informasi', 'route' => route('admin.dokumen.index')],
        ['icon' => 'fa-bullhorn', 'label' => 'Pengumuman', 'route' => route('admin.pengumuman.index')],
        ['icon' => 'fa-calendar-alt', 'label' => 'Agenda', 'route' => route('admin.agenda.index')],
        ['icon' => 'fa-bullseye', 'label' => 'Visi Misi', 'route' => route('admin.visimisi.index')],
        ['icon' => 'fa-address-card', 'label' => 'Profil Pimpinan', 'route' => route('admin.profil.edit')],

        ]
        ],
        [
        'icon' => 'fa-photo-video',
        'label' => 'Galeri',
        'children' => [
        ['icon' => 'fa-video', 'label' => 'Galeri Video', 'route' => route('admin.galeri.video')],
        ['icon' => 'fa-image', 'label' => 'Galeri Foto', 'route' => route('admin.galeri.folders')],
        ]
        ],
        [
        'icon' => 'fa-solid fa-cubes',
        'label' => 'Aplikasi',
        'children' => [
        ['icon' => 'fa-compass', 'label' => 'Navigasi', 'route' => route('admin.aplikasi.indexNavigasi')],
        ['icon' => 'fa-plane', 'label' => 'Landing Page', 'route' => route('admin.aplikasi.indexLanding')],
        ]
        ]
        ];

        $others = [
        ['icon' => 'fa-users', 'label' => 'Struktur Organisasi', 'route' => route('admin.strukturOrganisasi.index')],
        ['icon' => 'fa-handshake', 'label' => 'Kunjungan', 'route' => route('admin.kunjungan.index')],
        ];
        @endphp

        <!-- Menu utama -->
        @foreach($menus as $menu)
        <a href="{{ $menu['route'] }}"
            class="flex items-center px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 transition">
            <i class="fas {{ $menu['icon'] }} mr-2 w-5 text-center"></i>
            <span x-show="sidebarOpen">{{ $menu['label'] }}</span>
        </a>
        @endforeach

        <!-- Menu grup -->
        @foreach($groups as $index => $group)
        <div>
            <button @click="openMenus[{{ $index }}] = !openMenus[{{ $index }}]"
                class="flex items-center w-full px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                <i class="fas {{ $group['icon'] }} mr-2 w-5 text-center"></i>
                <span x-show="sidebarOpen">{{ $group['label'] }}</span>
                <i class="fas fa-chevron-down ml-auto text-xs transition-transform duration-200"
                    :class="openMenus[{{ $index }}] ? 'rotate-180' : ''"
                    x-show="sidebarOpen"></i>
            </button>
            <div x-show="openMenus[{{ $index }}]" x-collapse x-transition class="ml-6 mt-1 space-y-1">
                @foreach($group['children'] as $child)
                <a href="{{ $child['route'] }}"
                    class="flex items-center px-4 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                    <i class="fas {{ $child['icon'] }} mr-2 w-4 text-center text-xs"></i>
                    <span x-show="sidebarOpen" class="text-sm">{{ $child['label'] }}</span>
                </a>
                @endforeach
            </div>
        </div>
        @endforeach

        <!-- Menu lainnya -->
        @foreach($others as $menu)
        <a href="{{ $menu['route'] }}"
            class="flex items-center px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 transition">
            <i class="fas {{ $menu['icon'] }} mr-2 w-5 text-center"></i>
            <span x-show="sidebarOpen">{{ $menu['label'] }}</span>
        </a>
        @endforeach
    </nav>

    <!-- Logout -->
    <div class=" dark:border-gray-700 px-4 py-7 mt-4">
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit"
                class="w-full flex items-center gap-3 px-4 py-2 rounded-lg bg-red-50 hover:bg-red-100 dark:bg-red-900 dark:hover:bg-red-800 text-red-600 dark:text-red-300 font-medium shadow-sm transition duration-200">
                <i class="fas fa-sign-out-alt text-lg w-5 text-center"></i>
                <span x-show="sidebarOpen">Logout</span>
            </button>
        </form>
    </div>
</aside>
