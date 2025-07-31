<!DOCTYPE html>
<html lang="id"
    x-data="{ sidebarOpen: true}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Admin DISKOMINFO</title>

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
            <!-- Header -->
            <header class="flex justify-between items-center px-5 py-4 bg-white dark:bg-gray-800 shadow-md border-b border-gray-200 dark:border-gray-700">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-300">Selamat datang, {{ Auth::guard('admin')->user()->name }}</p>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-user-circle text-xl text-gray-700 dark:text-gray-200"></i>
                    <span class="text-sm font-medium text-gray-800 dark:text-white">{{ Auth::guard('admin')->user()->name }}</span>
                </div>
            </header>

            <!-- Cards Section -->
            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @php
                $cards = [
                ['icon' => 'fa-newspaper', 'label' => 'Total Berita', 'value' => $totalBerita ?? 0, 'color' => 'blue'],
                ['icon' => 'fa-bullhorn', 'label' => 'Total Pengumuman', 'value' => $totalPengumuman ?? 0, 'color' => 'red'],
                ['icon' => 'fa-calendar-alt', 'label' => 'Total Agenda', 'value' => $totalAgenda ?? 0, 'color' => 'green'],
                ['icon' => 'fa-handshake', 'label' => 'Kunjungan', 'value' => $totalKunjungan ?? 0, 'color' => 'indigo'],
                ];
                @endphp

                @foreach($cards as $card)
                <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-5 transition hover:shadow-lg">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-{{ $card['color'] }}-100 text-{{ $card['color'] }}-600 dark:bg-{{ $card['color'] }}-900 dark:text-{{ $card['color'] }}-300">
                            <i class="fas {{ $card['icon'] }} fa-lg"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $card['label'] }}</p>
                            <p class="text-xl font-bold">{{ $card['value'] }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </main>
    </div>
</body>

</html>