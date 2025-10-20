<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - EduSelf</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    @php
        $anggota = null;
        if(session('anggota_id')) {
            $anggota = \App\Models\Anggota::find(session('anggota_id'));
        }
    @endphp
    <header class="fixed top-0 left-0 right-0 z-50 bg-[#111A28] text-white py-4 shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center">
                <img src="{{ asset('image/logo.png') }}" alt="Logo EduSelf" class="h-10 w-10 mr-3">
                <h1 class="text-2xl font-bold tracking-wide">
                    <span class="text-white">Edu</span><span class="text-[#87C15A]">Self</span>
                </h1>
            </div>
            <nav>
                <ul class="flex space-x-2 items-center">
                    <li>
                        <a href="/" class="px-4 py-2 rounded transition {{ request()->is('/') ? 'bg-white text-blue-600 font-bold shadow' : 'hover:bg-[#87C15A] hover:text-white' }}">Home</a>
                    </li>
                    <li>
                        <a href="/tentang_kami" class="px-4 py-2 rounded transition {{ request()->is('tentang_kami') ? 'bg-white text-[#111A28] font-bold shadow' : 'hover:bg-white hover:text-white' }}">Tentang Kami</a>
                    </li>
                    <li>
                        <a href="/perpustakaan" class="px-4 py-2 rounded transition {{ request()->is('perpustakaan') ? 'bg-white text-[#111A28] font-bold shadow' : 'hover:bg-[#87C15A] hover:text-white' }}">Perpustakaan</a>
                    </li>
                    @if($anggota)
                        <li class="relative">
                            <button id="userMenuBtn" class="px-6 py-2.5 rounded-lg bg-gradient-to-r from-[#87C15A] to-[#6FA849] text-white font-semibold shadow-md hover:shadow-lg hover:scale-105 transition-all duration-200">
                                <i class="fas fa-user-circle mr-2"></i>{{ $anggota->name }}
                            </button>
                            <div id="userMenuDropdown" class="absolute right-0 mt-3 w-56 bg-white rounded-lg shadow-xl z-10 hidden border border-gray-100 overflow-hidden">
                                <div class="bg-gradient-to-r from-[#23485B] to-[#111A28] px-4 py-3">
                                    <p class="text-white font-semibold text-sm">{{ $anggota->name }}</p>
                                    <p class="text-gray-300 text-xs">{{ $anggota->email ?? 'Anggota' }}</p>
                                </div>
                                <a href="{{ route('peminjaman_aktif') }}" class="flex items-center px-4 py-3 text-[#87C15A] hover:bg-[#87C15A] hover:text-[#23485B] transition-all duration-200 border-b border-gray-100">
                                    <i class="fas fa-book mr-3"></i>
                                    <span class="font-medium">Peminjaman Aktif</span>
                                </a>
                                <form action="{{ route('logout_pengguna') }}" method="POST" class="block">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center px-4 py-3 text-red-600 hover:bg-red-50 transition-all duration-200">
                                        <i class="fas fa-sign-out-alt mr-3"></i>
                                        <span class="font-medium">Logout</span>
                                    </button>
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

    <div class="h-20"></div>

    <main class="container mx-auto py-8 px-6">
        <div class="bg-white shadow-md rounded px-8 py-6 flex flex-col md:flex-row items-center">
            <div class="md:w-1/3 w-full flex justify-center mb-6 md:mb-0">
                <img src="{{ asset('image/perpustakaan.png') }}" alt="Foto Perpustakaan" class="rounded-lg shadow-lg w-64 h-64 object-cover">
            </div>
            <div class="md:w-2/3 w-full md:pl-8">
                <h2 class="text-2xl font-bold mb-2 text-[#111A28]">Profil Perpustakaan EduSelf</h2>
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
            <h3 class="text-lg font-semibold mb-4 text-[#111A28]">Lokasi Perpustakaan EduSelf</h3>
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