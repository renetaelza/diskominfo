<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Admin Panel')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script> 
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://balkan.app/js/OrgChart.js"></script>
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

    <style>
        [x-cloak] { display: none !important; }
    </style>

    
</head>
<body class="bg-gray-100 dark:bg-gray-900 dark:text-white text-gray-900 font-sans">
    
    <div class="flex h-screen overflow-hidden">
        <x-admin.sidebar />

        <main id="content-container" class="flex-1 overflow-auto bg-gray-50 dark:bg-gray-900">
            @yield('content')
        </main>
    </div>
    @stack('scripts')
</body>
</html>
