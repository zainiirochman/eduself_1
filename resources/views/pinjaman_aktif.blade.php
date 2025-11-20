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
    <title>Peminjaman Aktif - EduSelf</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    @php
        $member = null;
        if(session('member_id')) {
            $member = \App\Models\Member::find(session('member_id'));
        }
    @endphp

    <header id="mainHeader" class="fixed top-0 left-0 right-0 z-50 bg-[#0f2533] text-white py-3 shadow-md">
        <div class="container mx-auto flex items-center justify-between px-6">
            <a href="/" class="flex items-center gap-3">
                <img src="{{ asset('image/logo.png') }}" alt="Logo EduSelf" class="h-8 w-8">
                <div class="leading-tight">
                    <div class="text-lg font-bold"><span class="text-white">Edu</span><span class="text-[#87C15A]">Self</span></div>
                    <div class="text-xs text-gray-200 -mt-1">Perpustakaan Digital</div>
                </div>
            </a>

            <nav>
                <ul class="flex items-center gap-4 text-sm">
                    <li><a href="/" class="px-3 py-1 rounded {{ request()->is('/') ? 'bg-white text-[#111A28] font-semibold' : 'hover:bg-white/5' }}">Home</a></li>
                    <li><a href="/perpustakaan" class="px-3 py-1 rounded {{ request()->is('perpustakaan*') ? 'bg-white text-[#111A28] font-semibold' : 'hover:bg-white/5' }}">Perpustakaan</a></li>
                    <li><a href="/tentang_kami" class="px-3 py-1 rounded {{ request()->is('tentang_kami') ? 'bg-white text-[#111A28] font-semibold' : 'hover:bg-white/5' }}">Tentang Kami</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- dynamic spacer: akan di-set sesuai tinggi header -->
    <div id="headerSpacer" class="w-full"></div>

    <main class="container mx-auto py-8 px-6 space-y-12">
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
                        @forelse($loans as $index => $p)
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

        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Riwayat Peminjaman Saya</h2>

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
                            <th class="py-3 px-4 border text-center">Denda</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($histories as $index => $p)
                            @php
                                $jatuhTempo = \Carbon\Carbon::parse($p->due_date);
                                $isOverdue = $jatuhTempo->isPast();
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-4 border text-center">{{ $index + 1 }}</td>
                                <td class="py-3 px-4 border">{{ $p->buku->title ?? '-' }}</td>
                                <td class="py-3 px-4 border text-center">{{ \Carbon\Carbon::parse($p->loan_date)->format('d/m/Y') }}</td>
                                <td class="py-3 px-4 border text-center">{{ $jatuhTempo->format('d/m/Y') }}</td>
                                <td class="py-3 px-4 border text-center">Rp {{ number_format($p->denda ?? 0, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 px-4 text-center text-gray-500">
                                    Anda belum memiliki riwayat peminjaman.
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
            const header = document.getElementById('mainHeader');
            const spacer = document.getElementById('headerSpacer');
            function updateSpacer() {
                if (header && spacer) spacer.style.height = header.getBoundingClientRect().height + 'px';
            }
            updateSpacer();
            window.addEventListener('resize', updateSpacer);

            const btn = document.getElementById('userMenuBtn');
            const dd = document.getElementById('userMenuDropdown');
            if (btn && dd) {
                btn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    dd.classList.toggle('hidden');
                });
                dd.addEventListener('click', e => e.stopPropagation());
                document.addEventListener('click', () => dd.classList.add('hidden'));
                document.addEventListener('keydown', (ev) => { if (ev.key === 'Escape') dd.classList.add('hidden'); });
            }
        });
    </script>
</body>
</html>