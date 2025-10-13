<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register EduSelf</title>
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
            <h1 class="text-2xl font-bold text-[#111A28]">Register EduSelf</h1>
        </div>
        <form action="{{ route('register_pengguna.store') }}" method="POST" class="space-y-5" id="registerForm">
            @csrf
            <div>
                <label for="name" class="block text-[#111A28] font-semibold mb-2">Nama Lengkap</label>
                <input type="text" id="name" name="name" required
                    class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label for="jk" class="block text-[#111A28] font-semibold mb-2">Jenis Kelamin</label>
                <select id="jk" name="jk" required
                    class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
            <div>
                <label for="prodi" class="block text-[#111A28] font-semibold mb-2">Program Studi</label>
                <select id="prodi" name="prodi" required
                    class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">Pilih Program Studi</option>
                    <option value="Pend. Teknologi Informasi">Pend. Teknologi Informasi</option>
                    <option value="Sistem Informasi">Sistem Informasi</option>
                    <option value="Teknik Informatika">Teknik Informatika</option>
                </select>
            </div>
            <div>
                <label for="hp" class="block text-[#111A28] font-semibold mb-2">Nomor HP</label>
                <input type="text" id="hp" name="hp" required
                    class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label for="password" class="block text-[#111A28] font-semibold mb-2">Password</label>
                <input type="password" id="password" name="password" required
                    class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label for="password_confirmation" class="block text-[#111A28] font-semibold mb-2">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                <p id="passwordMismatch" class="text-[#111A28] text-sm mt-1 hidden">Password tidak sesuai.</p>
            </div>

            <button type="submit"
                class="w-full bg-[#111A28] text-white font-semibold py-2 rounded hover:bg-blue-700 transition">
                Register
            </button>
        </form>
        <div class="mt-6 text-center">
            <span class="text-gray-600">Sudah punya akun?</span>
            <a href="{{ route('login_pengguna') }}" class="text-[#87C15A] font-semibold hover:underline ml-1">Login</a>
        </div>
    </div>
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