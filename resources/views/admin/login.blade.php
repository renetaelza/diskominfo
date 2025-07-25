<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login</title>
  @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
  <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-center mb-6">Login Admin</h2>
    @if ($errors->any())
      <div class="mb-4 text-red-600 text-sm">
        {{ $errors->first() }}
      </div>
    @endif
    <form method="POST" action="{{ route('admin.login.submit') }}">
      @csrf
      <div class="mb-4">
        <label class="block text-gray-700">Email</label>
        <input type="email" name="email" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>
      <div class="mb-4">
        <label class="block text-gray-700">Password</label>
        <input type="password" name="password" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>
      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">Login</button>
    </form>
  </div>
</body>
</html>
