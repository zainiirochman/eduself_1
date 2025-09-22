<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - EduSelf</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    @php
        $anggota = null;
        if(session('anggota_id')) {
            $anggota = \App\Models\Anggota::find(session('anggota_id'));
        }
    @endphp

    <header class="bg-blue-500 text-white py-4 shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center">
                <img src="{{ asset('image/logo.png') }}" alt="Logo EduSelf" class="h-10 w-10 mr-3 rounded-full border-2 border-white shadow">
                <h1 class="text-2xl font-bold tracking-wide">EduSelf</h1>
            </div>
            <nav>
                <ul class="flex space-x-2 items-center">
                    <li>
                        <a href="/" class="px-4 py-2 rounded transition {{ request()->is('/') ? 'bg-white text-blue-600 font-bold shadow' : 'hover:bg-blue-600 hover:text-white' }}">Home</a>
                    </li>
                    <li>
                        <a href="/tentang_kami" class="px-4 py-2 rounded transition {{ request()->is('tentang_kami') ? 'bg-white text-blue-600 font-bold shadow' : 'hover:bg-blue-600 hover:text-white' }}">Tentang Kami</a>
                    </li>
                    <li>
                        <a href="/perpustakaan" class="px-4 py-2 rounded transition {{ request()->is('perpustakaan') ? 'bg-white text-blue-600 font-bold shadow' : 'hover:bg-blue-600 hover:text-white' }}">Perpustakaan</a>
                    </li>
                    @if($anggota)
                        <li class="relative">
                            <button id="userMenuBtn" class="px-4 py-2 rounded bg-yellow-300 text-blue-900 font-semibold focus:outline-none shadow hover:bg-yellow-400 transition">
                                Halo, {{ $anggota->name }}
                            </button>
                            <div id="userMenuDropdown" class="absolute left-0 mt-2 w-32 bg-white rounded shadow-lg z-10 hidden">
                                <form action="{{ route('logout_pengguna') }}" method="POST" class="block">
                                    @csrf
                                    <button type="submit" class="w-full text-red-600 px-4 py-2 text-left hover:bg-gray-100 rounded">Logout</button>
                                </form>
                            </div>
                        </li>
                    @else
                        <li>
                            <a href="{{ route('login_pengguna') }}" class="px-4 py-2 rounded transition {{ request()->is('login_pengguna') ? 'bg-white text-blue-600 font-bold shadow' : 'hover:bg-blue-600 hover:text-white' }}">Login</a>
                        </li>
                        <li>
                            <a href="{{ route('register_pengguna') }}" class="px-4 py-2 rounded transition {{ request()->is('register_pengguna') ? 'bg-white text-blue-600 font-bold shadow' : 'hover:bg-blue-600 hover:text-white' }}">Register</a>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </header>

    <main class="container mx-auto py-8">
        <div class="bg-white shadow-md rounded px-8 py-6 flex flex-col md:flex-row items-center">
            <div class="md:w-1/3 w-full flex justify-center mb-6 md:mb-0">
                <img src="{{ asset('image/perpustakaan.png') }}" alt="Foto Perpustakaan" class="rounded-lg shadow-lg w-64 h-64 object-cover">
            </div>
            <div class="md:w-2/3 w-full md:pl-8">
                <h2 class="text-2xl font-bold mb-2 text-blue-600">Profil Perpustakaan EduSelf</h2>
                <p class="mb-4 text-gray-700">Perpustakaan EduSelf adalah pusat literasi dan pembelajaran mandiri yang menyediakan berbagai koleksi buku pendidikan, teknologi, dan pengembangan diri. Kami berkomitmen untuk mendukung self-growth dan kemudahan akses informasi bagi seluruh pengguna.</p>
                <ul class="mb-4 text-gray-700">
                    <li><strong>Alamat:</strong> Jl. Dummy Raya No. 123, Kota Edu, Indonesia</li>
                    <li><strong>Email:</strong> info@eduself.com</li>
                    <li><strong>Telepon:</strong> (021) 12345678</li>
                    <li><strong>Jam Operasional:</strong> Senin - Jumat, 08.00 - 16.00 WIB</li>
                </ul>
                <div class="mb-2">
                    <strong>Fasilitas:</strong>
                    <ul class="list-disc ml-6">
                        <li>Ruang baca nyaman & ber-AC</li>
                        <li>WiFi gratis</li>
                        <li>Koleksi buku digital & fisik</li>
                        <li>Layanan peminjaman & pengembalian online</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="bg-white shadow-md rounded px-8 py-6 mt-8">
            <h3 class="text-lg font-semibold mb-4 text-blue-600">Lokasi Perpustakaan EduSelf</h3>
            <div class="w-full h-64 rounded overflow-hidden">
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d1509.9804637651591!2d112.72753586861805!3d-7.316052096908094!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sid!2sid!4v1758508700917!5m2!1sid!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </main>

    <footer class="bg-gray-800 text-white py-4 text-center">
        <p>&copy; 2025 EduSelf. All rights reserved.</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btn = document.getElementById('userMenuBtn');
            const dropdown = document.getElementById('userMenuDropdown');
            if(btn && dropdown){
                btn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    dropdown.classList.toggle('hidden');
                });
                document.addEventListener('click', function () {
                    dropdown.classList.add('hidden');
                });
            }
        });
    </script>
</body>
</html>