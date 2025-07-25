<!DOCTYPE html>
<html lang="id"
      x-data="{ sidebarOpen: true, darkMode: localStorage.getItem('darkMode') === 'true' }"
      x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val));"
      :class="{ 'dark': darkMode }">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Dashboard</title>
  
  <!-- Tailwind & Alpine -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/alpinejs" defer></script>
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <script src="https://unpkg.com/heroicons@2.0.16/24/outline/index.js"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
    }
  </script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">
</head>
<body class="bg-gray-100 dark:bg-gray-900 dark:text-white text-gray-900 font-sans">

<div class="flex h-screen">

  <!-- Sidebar -->
  <div :class="sidebarOpen ? 'w-64' : 'w-16'"
       class="bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 transition-all duration-300 flex flex-col">

    <!-- Sidebar Header -->
    <div class="flex items-center justify-between h-16 px-4 border-b dark:border-gray-700">
      <span x-show="sidebarOpen" class="text-lg font-bold">Admin Panel</span>
      <button @click="sidebarOpen = !sidebarOpen"
              class="p-1 text-gray-500 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white focus:outline-none">
        <!-- Toggle Sidebar Icon -->
        <svg x-show="sidebarOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M6 18L18 6M6 6l12 12"/>
        </svg>
        <svg x-show="!sidebarOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
      </button>
    </div>

    <!-- Sidebar Links -->
    <nav class="flex-1 px-2 py-4 space-y-2">
      <a href="#" class="block px-4 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700" x-show="sidebarOpen">Dashboard</a>
      <a href="#" class="block px-4 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700" x-show="sidebarOpen">Berita</a>
      <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button type="submit"
                class="w-full text-left px-4 py-2 rounded hover:bg-red-100 dark:hover:bg-red-700 text-red-600 dark:text-red-400"
                x-show="sidebarOpen">Logout</button>
      </form>
    </nav>

    <!-- Sidebar Footer: Toggle Dark Mode -->
    <div class="px-2 py-2 border-t dark:border-gray-700 mt-auto">
        <button @click="darkMode = !darkMode"
                class="flex items-center gap-2 text-sm w-full px-3 py-2 rounded">
            <i :class="darkMode ? 'fas fa-sun text-yellow-400' : 'fas fa-moon text-gray-500'"></i>
            <span x-show="sidebarOpen" x-text="darkMode ? 'Light Mode' : 'Dark Mode'"></span>
        </button>
    </div>
  </div>

  <!-- Main Content -->
  <div :class="sidebarOpen ? 'ml-64' : 'ml-16'" class="flex-1 transition-all duration-300 p-6">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-semibold">Dashboard</h1>
    </div>
    <p>Selamat datang di halaman admin dashboard. Gunakan sidebar untuk navigasi.</p>
  </div>
</div>

</body>
</html>
