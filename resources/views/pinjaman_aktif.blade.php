<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman Aktif - EduSelf</title>
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
        <div class="container mx-auto flex justify-between items-center px-6">
            <div class="flex items-center">
                <img src="{{ asset('image/logo.png') }}" alt="Logo EduSelf" class="h-10 w-10 mr-3">
                <h1 class="text-2xl font-bold tracking-wide">
                    <span class="text-white">Edu</span><span class="text-[#87C15A]">Self</span>
                </h1>
            </div>
            <nav>
                <ul class="flex space-x-2 items-center">
                    <li><a href="/" class="px-4 py-2 rounded hover:bg-[#87C15A] transition">Home</a></li>
                    <li><a href="/tentang_kami" class="px-4 py-2 rounded hover:bg-[#87C15A] transition">Tentang Kami</a></li>
                    <li><a href="/perpustakaan" class="px-4 py-2 rounded hover:bg-[#87C15A] transition">Perpustakaan</a></li>
                    @if($anggota)
                        <li class="relative">
                            <button id="userMenuBtn" class="px-6 py-2.5 rounded-lg bg-gradient-to-r text-white font-semibold shadow-md hover:shadow-lg hover:scale-105 transition-all duration-200">
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
                    @endif
                </ul>
            </nav>
        </div>
    </header>

    <div class="h-16"></div>

    <main class="container mx-auto py-8 px-6">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Peminjaman Aktif Saya</h2>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border">
                    <thead>
                        <tr class="bg-gray-200 text-gray-700">
                            <th class="py-3 px-4 border text-center">No</th>
                            <th class="py-3 px-4 border text-center">Judul Buku</th>
                            <th class="py-3 px-4 border text-center">Tanggal Pinjam</th>
                            <th class="py-3 px-4 border text-center">Jatuh Tempo</th>
                            <th class="py-3 px-4 border text-center">Status</th>
                            <th class="py-3 px-4 border text-center">Denda</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($peminjamans as $index => $p)
                            @php
                                $jatuhTempo = \Carbon\Carbon::parse($p->tanggal_jatuh_tempo);
                                $isOverdue = $jatuhTempo->isPast();
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-4 border text-center">{{ $index + 1 }}</td>
                                <td class="py-3 px-4 border">{{ $p->buku->title ?? '-' }}</td>
                                <td class="py-3 px-4 border text-center">{{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d/m/Y') }}</td>
                                <td class="py-3 px-4 border text-center">{{ $jatuhTempo->format('d/m/Y') }}</td>
                                <td class="py-3 px-4 border text-center">
                                    @if($isOverdue)
                                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-semibold">Terlambat</span>
                                    @else
                                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">Aktif</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 border text-center">Rp {{ number_format($p->denda ?? 0, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 px-4 text-center text-gray-500">
                                    Anda belum memiliki peminjaman aktif.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <footer class="bg-[#87C15A] text-white py-4 text-center mt-12">
        <p>&copy; 2025 EduSelf. All rights reserved.</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btn = document.getElementById('userMenuBtn');
            const dropdown = document.getElementById('userMenuDropdown');
            if (btn && dropdown) {
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