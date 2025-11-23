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
    <title>Register EduSelf</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
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
        .register-container {
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
            animation: slideIn 0.6s ease-out calc(0.3s + var(--delay)) backwards;
        }
        .btn-submit {
            animation: slideIn 0.6s ease-out 1s backwards;
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
        .login-link {
            animation: slideIn 0.6s ease-out 1.2s backwards;
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
        .error-message {
            animation: fadeIn 0.3s ease-out;
        }
    </style>
</head>
<body class="bg-[#111A28] flex items-center justify-center min-h-screen py-8">
    <!-- Floating particles -->
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>

    <div class="absolute top-6 left-6 z-10">
        <a href="{{ url('/') }}" class="close-btn text-[#87C15A] hover:text-[#87C15A] text-4xl font-bold">&times;</a>
    </div>
    
    <div class="register-container w-full max-w-md bg-white rounded-2xl card-shadow p-8 m-4">
        <div class="logo-container flex items-center justify-center mb-8">
            <img src="{{ asset('image/logo.png') }}" alt="Logo EduSelf" class="logo-img h-16 w-16 mr-3 rounded-full shadow-lg">
            <h1 class="text-3xl font-bold text-[#111A28]">Register <span class="text-[#87C15A]">EduSelf</span></h1>
        </div>

        <form action="{{ route('register_pengguna.store') }}" method="POST" class="space-y-5" id="registerForm">
            @csrf
            <div class="form-group" style="--delay: 0s">
                <label for="name" class="block text-[#111A28] font-semibold mb-2">
                    <i class="fas fa-user mr-1"></i> Nama Lengkap
                </label>
                <input type="text" id="name" name="name" required
                    placeholder="Masukkan nama lengkap"
                    class="input-field w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#87C15A] focus:border-transparent">
            </div>

            <div class="form-group" style="--delay: 0.1s">
                <label for="gender" class="block text-[#111A28] font-semibold mb-2">
                    <i class="fas fa-venus-mars mr-1"></i> Jenis Kelamin
                </label>
                <select id="gender" name="gender" required
                    class="input-field w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#87C15A] focus:border-transparent">
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>

            <div class="form-group" style="--delay: 0.2s">
                <label for="prodi" class="block text-[#111A28] font-semibold mb-2">
                    <i class="fas fa-graduation-cap mr-1"></i> Program Studi
                </label>
                <select id="prodi" name="prodi" required
                    class="input-field w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#87C15A] focus:border-transparent">
                    <option value="">Pilih Program Studi</option>
                    <option value="Pend. Teknologi Informasi">Pend. Teknologi Informasi</option>
                    <option value="Sistem Informasi">Sistem Informasi</option>
                    <option value="Teknik Informatika">Teknik Informatika</option>
                </select>
            </div>

            <div class="form-group" style="--delay: 0.3s">
                <label for="email" class="block text-[#111A28] font-semibold mb-2">
                    <i class="fas fa-envelope mr-1"></i> Email Unesa
                </label>
                <input name="email" type="email" pattern="^[^@]+@mhs\.unesa\.ac\.id$" required
                    title="Gunakan email unesa"
                    placeholder="contoh@mhs.unesa.ac.id"
                    class="input-field w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#87C15A] focus:border-transparent">
            </div>

            <div class="form-group" style="--delay: 0.4s">
                <label for="hp" class="block text-[#111A28] font-semibold mb-2">
                    <i class="fas fa-phone mr-1"></i> Nomor HP
                </label>
                <input type="text" id="hp" name="hp" required
                    placeholder="08xxxxxxxxxx"
                    class="input-field w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#87C15A] focus:border-transparent">
            </div>

            <div class="form-group" style="--delay: 0.5s">
                <label for="password" class="block text-[#111A28] font-semibold mb-2">
                    <i class="fas fa-lock mr-1"></i> Password
                </label>
                <input type="password" id="password" name="password" required
                    placeholder="Minimal 6 karakter"
                    class="input-field w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#87C15A] focus:border-transparent">
            </div>

            <div class="form-group" style="--delay: 0.6s">
                <label for="password_confirmation" class="block text-[#111A28] font-semibold mb-2">
                    <i class="fas fa-lock mr-1"></i> Konfirmasi Password
                </label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    placeholder="Ulangi password"
                    class="input-field w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#87C15A] focus:border-transparent">
                <p id="passwordMismatch" class="error-message text-red-600 text-sm mt-2 hidden">
                    <i class="fas fa-exclamation-circle mr-1"></i> Password tidak sesuai.
                </p>
            </div>

            <button type="submit"
                class="btn-submit w-full bg-[#111A28] text-white font-bold py-3 rounded-lg relative z-10 hover:bg-[#87C15A]">
                <span class="relative z-10">Daftar Sekarang</span>
            </button>
        </form>

        <div class="login-link mt-6 text-center pt-6 border-t border-gray-200">
            <span class="text-gray-600">Sudah punya akun?</span>
            <a href="{{ route('login_pengguna') }}" 
               class="text-[#87C15A] font-bold hover:underline ml-1 hover:text-[#6fa847] transition">
                Login Sekarang
            </a>
        </div>
    </div>

    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('registerForm');
            const pwd = document.getElementById('password');
            const pwdConf = document.getElementById('password_confirmation');
            const err = document.getElementById('passwordMismatch');

            if (form && pwd && pwdConf && err) {
                form.addEventListener('submit', function (e) {
                    if (pwd.value !== pwdConf.value) {
                        e.preventDefault();
                        err.classList.remove('hidden');
                    } else {
                        err.classList.add('hidden');
                    }
                });

                // hide error once user fixes input
                [pwd, pwdConf].forEach(input => {
                    input.addEventListener('input', () => {
                        if (pwd.value === pwdConf.value) {
                            err.classList.add('hidden');
                        }
                    });
                });
            }
        });
    </script>
</body>
</html>