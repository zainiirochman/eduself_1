<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin EduSelf</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-30px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        body {
            background: linear-gradient(135deg, #111A28 0%, #1a2942 100%);
            position: relative;
            overflow-x: hidden;
        }
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 50%, rgba(135, 193, 90, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 80% 80%, rgba(135, 193, 90, 0.08) 0%, transparent 50%);
            pointer-events: none;
        }
        .login-container {
            animation: fadeIn 0.8s ease-out;
            position: relative;
            z-index: 1;
        }
        .logo-container {
            animation: slideIn 0.6s ease-out 0.2s backwards;
        }
        .logo-img {
            animation: float 3s ease-in-out infinite;
        }
        .form-group {
            animation: slideIn 0.6s ease-out 0.4s backwards;
        }
        .btn-submit {
            animation: slideIn 0.6s ease-out 0.6s backwards;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .btn-submit::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(135, 193, 90, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        .btn-submit:hover::before {
            width: 300px;
            height: 300px;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(135, 193, 90, 0.3);
        }
        .close-btn {
            transition: all 0.3s ease;
            animation: pulse 2s ease-in-out infinite;
        }
        .close-btn:hover {
            transform: rotate(90deg) scale(1.2);
            animation: none;
        }
        .input-field {
            transition: all 0.3s ease;
        }
        .input-field:focus {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(135, 193, 90, 0.2);
        }
        .card-shadow {
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }
        .particle {
            position: absolute;
            border-radius: 50%;
            background: rgba(135, 193, 90, 0.3);
            animation: float-particle 15s infinite ease-in-out;
            pointer-events: none;
        }
        @keyframes float-particle {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(100px, -100px) rotate(120deg); }
            66% { transform: translate(-100px, 100px) rotate(240deg); }
        }
        .particle:nth-child(1) { width: 80px; height: 80px; top: 10%; left: 10%; animation-delay: 0s; }
        .particle:nth-child(2) { width: 60px; height: 60px; top: 70%; left: 80%; animation-delay: 2s; }
        .particle:nth-child(3) { width: 100px; height: 100px; top: 50%; left: 5%; animation-delay: 4s; }
        .status-message {
            animation: fadeIn 0.5s ease-out;
        }
        .error-message {
            animation: fadeIn 0.3s ease-out;
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <!-- Floating particles -->
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>

    <div class="absolute top-6 left-6 z-10">
        <a href="{{ url('/') }}" class="close-btn text-[#87C15A] hover:text-[#87C15A] text-4xl font-bold">&times;</a>
    </div>

    <div class="login-container w-full max-w-md bg-white rounded-2xl card-shadow p-8 m-4">
        <div class="logo-container flex items-center justify-center mb-8">
            <img src="{{ asset('image/logo.png') }}" alt="Logo EduSelf" class="logo-img h-16 w-16 mr-3 rounded-full shadow-lg">
            <h1 class="text-3xl font-bold text-[#111A28]">Login <span class="text-[#87C15A]">Admin</span></h1>
        </div>

        @if(session('status'))
            <div class="status-message mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span class="font-semibold">{{ session('status') }}</span>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf
            <div class="form-group">
                <label for="email" class="block text-[#111A28] font-semibold mb-2">
                    <i class="fas fa-envelope mr-1"></i> Email
                </label>
                <input type="email" id="email" name="email" required autofocus autocomplete="username"
                    value="{{ old('email') }}"
                    placeholder="admin@eduself.com"
                    class="input-field w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#87C15A] focus:border-transparent">
                @error('email')
                    <div class="error-message text-red-600 text-sm mt-2 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="block text-[#111A28] font-semibold mb-2">
                    <i class="fas fa-lock mr-1"></i> Password
                </label>
                <input type="password" id="password" name="password" required autocomplete="current-password"
                    placeholder="Masukkan password"
                    class="input-field w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#87C15A] focus:border-transparent">
                @error('password')
                    <div class="error-message text-red-600 text-sm mt-2 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- <div class="flex items-center justify-between">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>
                @if (Route::has('password.request'))
                    <a class="text-sm text-blue-600 hover:underline" href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                @endif
            </div> -->

            <button type="submit"
                class="btn-submit w-full text-white font-bold py-3 rounded-lg relative z-10 shadow-lg"
                style="background: linear-gradient(135deg, #87C15A 0%, #87C15A 100%);">
                <span class="relative z-10 flex items-center justify-center">
                    <i class="fas fa-sign-in-alt mr-2"></i>Login Admin
                </span>
            </button>
        </form>

        <div class="mt-6 text-center pt-6 border-t border-gray-200">
            <p class="text-gray-600 text-sm">
                <i class="fas fa-shield-alt mr-1 text-[#87C15A]"></i>
                Admin Area - Authorized Personnel Only
            </p>
        </div>
    </div>
</body>
</html>
