<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin EduSelf</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="absolute top-6 left-6">
        <a href="{{ url('/') }}" class="text-gray-500 hover:text-blue-600 text-2xl font-bold">&times;</a>
    </div>
    <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-8">
        <div class="flex items-center justify-center mb-6">
            <img src="{{ asset('image/logo.png') }}" alt="Logo EduSelf" class="h-12 w-12 mr-2 rounded-full">
            <h1 class="text-2xl font-bold text-blue-600">Login Admin</h1>
        </div>
        @if(session('status'))
            <div class="mb-4 text-green-600 font-semibold">
                {{ session('status') }}
            </div>
        @endif
        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf
            <div>
                <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                <input type="email" id="email" name="email" required autofocus autocomplete="username"
                    value="{{ old('email') }}"
                    class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                @error('email')
                    <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="password" class="block text-gray-700 font-semibold mb-2">Password</label>
                <input type="password" id="password" name="password" required autocomplete="current-password"
                    class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                @error('password')
                    <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="flex items-center justify-between">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>
                @if (Route::has('password.request'))
                    <a class="text-sm text-blue-600 hover:underline" href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                @endif
            </div>
            <button type="submit"
                class="w-full bg-blue-600 text-white font-semibold py-2 rounded hover:bg-blue-700 transition">
                Login
            </button>
        </form>
    </div>
</body>
</html>
