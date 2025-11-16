<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="{{ asset('favicon.ico') }}" />
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicon/favicon-96x96.png') }}" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon/favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ asset('favicon/favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-touch-icon.png') }}" />
    <meta name="apple-mobile-web-app-title" content="EduSelf" />
    <link rel="manifest" href="{{ asset('favicon/site.webmanifest') }}" />
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login EduSelf</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> -->
</head>
<body class="bg-[#111A28] flex items-center justify-center min-h-screen">
    <div class="absolute top-6 left-6">
        <a href="{{ url('/') }}" class="text-[#87C15A] hover:text-[#87C15A] text-2xl font-bold">&times;</a>
    </div>
    <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-8">
        <div class="flex items-center justify-center mb-6">
            <img src="{{ asset('image/logo.png') }}" alt="Logo EduSelf" class="h-12 w-12 mr-2 rounded-full">
            <h1 class="text-2xl font-bold text-[#111A28]">Login EduSelf</h1>
        </div>
        <form action="{{ route('login_pengguna.store') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label for="email" class="block text-[#111A28] font-semibold mb-2">Email</label>
                <input type="email" id="email" name="email" pattern="^[^@]+@mhs\.unesa\.ac\.id$" required
                title="Gunakan email unesa"
                    class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label for="password" class="block text-[#111A28] font-semibold mb-2">Password</label>
                <input type="password" id="password" name="password" required
                    class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <button type="submit"
                class="w-full bg-[#111A28] text-white font-semibold py-2 rounded hover:bg-blue-700 transition">
                Login
            </button>
        </form>
        <div class="mt-6 text-center">
            <span class="text-gray-600">Belum punya akun?</span>
            <a href="{{ route('register_pengguna') }}" class="text-[#87C15A] font-semibold hover:underline ml-1">Register</a>
        </div>
    </div>
</body>
</html>