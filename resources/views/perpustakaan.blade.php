<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Buku - EduSelf</title>
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
                        <a href="/" class="px-4 py-2 rounded transition
                            {{ request()->is('/') ? 'bg-white text-blue-600 font-bold shadow' : 'hover:bg-blue-600 hover:text-white' }}">
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="/tentang_kami" class="px-4 py-2 rounded transition
                            {{ request()->is('tentang_kami') ? 'bg-white text-blue-600 font-bold shadow' : 'hover:bg-blue-600 hover:text-white' }}">
                            Tentang Kami
                        </a>
                    </li>
                    <li>
                        <a href="/perpustakaan" class="px-4 py-2 rounded transition
                            {{ request()->is('perpustakaan') ? 'bg-white text-blue-600 font-bold shadow' : 'hover:bg-blue-600 hover:text-white' }}">
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

    <main class="container mx-auto py-8">
        <div class="bg-white shadow-md rounded px-8 py-6">
            <h2 class="text-xl font-semibold mb-4">Daftar Buku</h2>
            <form method="GET" action="{{ url('/perpustakaan') }}" class="mb-6 flex items-center">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari judul buku..."
                    class="border rounded px-4 py-2 w-full max-w-xs mr-2"
                >
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Cari
                </button>
            </form>
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">Judul</th>
                        <th class="py-2 px-4 border-b">Penulis</th>
                        <th class="py-2 px-4 border-b">Tahun</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($books as $book)
                    <tr>
                        <td class="py-2 px-4 border-b">{{ $book->title }}</td>
                        <td class="py-2 px-4 border-b">{{ $book->author }}</td>
                        <td class="py-2 px-4 border-b">{{ $book->year }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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