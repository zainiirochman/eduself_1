<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduSelf</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100">

    @php
        $anggota = null;
        if(session('anggota_id')) {
            $anggota = \App\Models\Anggota::find(session('anggota_id'));
        }
    @endphp

    <header class="bg-[#111A28] text-white py-4 shadow-lg">
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
                        <a href="/" class="px-4 py-2 rounded transition
                            {{ request()->is('/') ? 'bg-white text-[#111A28] font-bold shadow' : 'hover:bg-[#87C15A] hover:text-white' }}">
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="/tentang_kami" class="px-4 py-2 rounded transition
                            {{ request()->is('tentang_kami') ? 'bg-white text-[#111A28] font-bold shadow' : 'hover:bg-blue-600 hover:text-white' }}">
                            Tentang Kami
                        </a>
                    </li>
                    <li>
                        <a href="/perpustakaan" class="px-4 py-2 rounded transition
                            {{ request()->is('perpustakaan') ? 'bg-white text-[#111A28] font-bold shadow' : 'hover:bg-blue-600 hover:text-white' }}">
                            Perpustakaan
                        </a>
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
                            <a href="{{ route('login_pengguna') }}" class="px-4 py-2 rounded transition
                                {{ request()->is('login_pengguna') ? 'bg-white text-blue-600 font-bold shadow' : 'hover:bg-blue-600 hover:text-white' }}">
                                Login
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('register_pengguna') }}" class="px-4 py-2 rounded transition
                                {{ request()->is('register_pengguna') ? 'bg-white text-blue-600 font-bold shadow' : 'hover:bg-blue-600 hover:text-white' }}">
                                Register
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-[#23485B] to-[#111A28] py-16">
        <div class="container mx-auto flex flex-col md:flex-row items-center justify-between px-6">
            <div class="md:w-1/2 text-white">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">EduSelf</h2>
                <h1 class="text-4xl md:text-5xl font-extrabold mb-4 leading-tight">
                    Buka Jendela Dunia,<br>
                    Langsung dari<br>
                    Genggaman Anda
                </h1>
                <p class="text-lg mb-8">Pinjam, Baca, dan Kembalikan buku hanya dari gadget</p>
                <div class="flex space-x-4">
                    <a href="{{ route('register_pengguna') }}" class="bg-white text-[#111A28] font-bold px-8 py-3 rounded-lg shadow hover:bg-gray-100 transition">Register</a>
                    <a href="{{ route('login_pengguna') }}" class="bg-[#87C15A] text-white font-bold px-8 py-3 rounded-lg shadow hover:bg-green-600 transition">Login</a>
                </div>
            </div>
            <div class="md:w-1/2 flex justify-center mt-10 md:mt-0">
                <img src="{{ asset('image/hero.png') }}" alt="Reading Illustration" class="w-[800px] max-w-full md:w-[900px]">
            </div>
        </div>
    </section>

    <!-- Section Buku Populer -->
    <section class="bg-[#1A2536] py-12">
        <div class="container mx-auto px-6">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-white text-2xl font-semibold">Buku Populer</h2>
                <!-- <form class="flex items-center">
                    <input type="text" placeholder="Cari buku..." class="bg-[#2C374B] text-white px-4 py-2 rounded-l-lg focus:outline-none w-64" />
                    <button type="submit" class="bg-[#2C374B] px-4 py-2 rounded-r-lg">
                        <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8" />
                            <line x1="21" y1="21" x2="16.65" y2="16.65" />
                        </svg>
                    </button>
                </form> -->
            </div>
            <div class="grid grid-cols-2 md:grid-cols-6 gap-6">
                @foreach($books as $book)
                    <div class="flex flex-col items-center">
                        <!-- untuk tipe data longblob -->
                        <!-- <img src="data:image/jpeg;base64,{{ base64_encode($book->cover) }}" alt="Cover Buku" class="w-40 h-56 object-cover rounded-lg shadow-lg mb-2"> -->

                        <!-- untuk tipe data string -->
                        @if($book->cover)
                            <img src="{{ asset($book->cover) }}" alt="Cover Buku" class="w-40 h-56 object-cover rounded-lg shadow-lg mb-2">
                        @endif
                        
                        <span class="text-white text-medium">{{ $book->title }}</span>
                        <span class="text-white text-sm">{{ $book->category->name ?? 'Kategori' }}</span>
                        <span class="text-gray-300 text-xs">{{ $book->author }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <footer class="bg-[#87C15A] text-white py-4 text-center">
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