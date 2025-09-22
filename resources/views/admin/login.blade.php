<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login</title>
  @vite('resources/css/app.css')
  @vite('resources/js/particles.js')
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen relative">

  	{{-- Particles background --}}
  	<div id="tsparticles" class="absolute inset-0 -z-10"></div>

  	{{-- Login Card --}}
	<div class="w-full max-w-md p-8 bg-white rounded-2xl shadow-xl relative z-10">
		<div class="flex flex-col items-center mb-6">
			<img src="{{ asset('pictures/logo_diskominfo.png') }}" alt="Logo Instansi" class="mx-auto mb-6 w-48 object-contain">
			<p class="text-sm text-gray-500">PORTAL ADMIN</p>
		</div>

		{{-- Flash message --}}
		@if (session('timeout'))
			<div class="mb-4 p-3 rounded bg-yellow-100 text-yellow-800 text-sm">
				{{ session('timeout') }}
			</div>
		@endif

		@if ($errors->any())
			<div class="mb-4 text-red-600 text-sm">
				{{ $errors->first() }}
			</div>
		@endif

		<form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-4">
		@csrf
			<div>
				<label class="block text-gray-700 text-sm mb-1">Username</label>
				<input type="text" name="username" required
					class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
				@error('username')
					<p class="text-sm text-red-500 mt-1">{{ $message }}</p>
				@enderror
			</div>
			<div class="pb-4">
				<label class="block text-gray-700 text-sm mb-1">Password</label>
				<div class="relative">
					<input type="password" name="password" id="password" required
							class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 pr-10">
					<button type="button" onclick="togglePassword('password', this)"
							class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
						<!-- Icon mata -->
						<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-open" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
									d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
									d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
						</svg>
						<!-- Icon mata dicoret -->
						<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-slash hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
									d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.967 9.967 0 012.132-3.592M6.1 6.1A9.977 9.977 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.97 9.97 0 01-4.132 5.592M15 12a3 3 0 00-4.95-2.122M3 3l18 18"/>
						</svg>
					</button>
				</div>
			</div>
			<button type="submit"
				class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
				Login
			</button>
		</form>
	</div>
</body>
<script>
function togglePassword(id, btn) {
    const input = document.getElementById(id);
    const eyeOpen = btn.querySelector('.eye-open');
    const eyeSlash = btn.querySelector('.eye-slash');

    if (input.type === "password") {
        input.type = "text";
        eyeOpen.classList.add('hidden');
        eyeSlash.classList.remove('hidden');
    } else {
        input.type = "password";
        eyeOpen.classList.remove('hidden');
        eyeSlash.classList.add('hidden');
    }
}
</script>
</html>
