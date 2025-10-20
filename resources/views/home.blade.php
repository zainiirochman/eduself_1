<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduSelf</title>
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
                        <a href="/" class="px-4 py-2 rounded transition
                            {{ request()->is('/') ? 'bg-white text-[#111A28] font-bold shadow' : 'hover:bg-white hover:text-white' }}">
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="/tentang_kami" class="px-4 py-2 rounded transition
                            {{ request()->is('tentang_kami') ? 'bg-white text-[#111A28] font-bold shadow' : 'hover:bg-[#87C15A] hover:text-white' }}">
                            Tentang Kami
                        </a>
                    </li>
                    <li>
                        <a href="/perpustakaan" class="px-4 py-2 rounded transition
                            {{ request()->is('perpustakaan') ? 'bg-white text-[#111A28] font-bold shadow' : 'hover:bg-[#87C15A] hover:text-white ' }}">
                            Perpustakaan
                        </a>
                    </li>
                    @if($anggota)
                        <li class="relative">
                            <button id="userMenuBtn" class="px-6 py-2.5 rounded-lg bg-gradient-to-r from-[#87C15A] to-[#6FA849] text-white font-semibold shadow-md hover:shadow-lg hover:bg-[#87C15A] transition-all duration-200">
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
                            <a href="{{ route('login_pengguna') }}" class="px-6 py-2.5 rounded-lg bg-gradient-to-r from-yellow-400 to-yellow-500 text-[#111A28] font-bold shadow-md hover:shadow-lg hover:scale-105 transition-all duration-200 flex items-center">
                                <i class="fas fa-sign-in-alt mr-2"></i>
                                Login
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </header>

    <!-- spacer to offset the fixed header height -->
    <div class="h-16"></div>

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
                    <a href="{{ route('register_pengguna') }}" class="bg-white text-[#111A28] font-bold px-8 py-3 rounded-lg shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-200 flex items-center">
                        <i class="fas fa-user-plus mr-2"></i>
                        Register
                    </a>
                    <a href="{{ route('login_pengguna') }}" class="bg-gradient-to-r from-[#87C15A] to-[#6FA849] text-white font-bold px-8 py-3 rounded-lg shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-200 flex items-center">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Login
                    </a>
                </div>
            </div>
            <div class="md:w-1/2 flex justify-center mt-10 md:mt-0">
                <img src="{{ asset('image/hero.png') }}" alt="Reading Illustration" class="w-[800px] max-w-full md:w-[900px]">
            </div>
        </div>
    </section>

    @php
        $categoryGroups = $books->groupBy(function ($book) {
            return $book->category->name ?? 'Tanpa Kategori';
        });
    @endphp

    <section class="bg-[#1A2536] py-16">
        <div class="container mx-auto px-6">
            <div class="flex items-center justify-between flex-wrap gap-4 mb-10">
                <h2 class="text-white text-2xl md:text-3xl font-semibold">Buku Populer</h2>
                <div class="flex items-center gap-6 text-sm font-semibold text-[#6B7280] border-b border-[#D6DDE8] w-full md:w-auto overflow-x-auto">
                    <button type="button" class="category-tab pb-3 border-b-2 border-transparent text-white hover:text-[#1A2536] transition"
                        data-category-tab="all">
                        Semua
                    </button>
                    @foreach($categoryGroups->keys() as $categoryName)
                        @php
                            $slug = \Illuminate\Support\Str::slug($categoryName) ?: 'tanpa-kategori';
                        @endphp
                        <button type="button" class="category-tab pb-3 border-b-2 border-transparent text-white hover:text-white transition whitespace-nowrap"
                            data-category-tab="{{ $slug }}">
                            {{ $categoryName }}
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-6 gap-4 justify-items-center">
                @foreach($books as $book)
                    @php
                        $categoryName = $book->category->name ?? 'Tanpa Kategori';
                        $categorySlug = \Illuminate\Support\Str::slug($categoryName) ?: 'tanpa-kategori';
                    @endphp
                    <div class="flex flex-col items-center bg-[#233044] rounded-xl p-3 w-36 h-52 flex-none snap-start"
                        data-category-card="{{ $categorySlug }}">
                        <div class="w-36 h-52 overflow-hidden rounded-lg bg-[#2F3D55] mb-3">
                            @if($book->cover)
                                <img src="{{ asset($book->cover) }}" alt="Cover Buku" class="w-36 h-52 object-cover">
                            @else
                                <div class="flex items-center justify-center w-36 h-52 text-gray-400 text-sm">
                                    No Image
                                </div>
                            @endif
                        </div>
                        <span class="text-white text-sm font-semibold text-center line-clamp-2">{{ $book->title }}</span>
                        <span class="text-gray-300 text-xs text-center mt-1">{{ $categoryName }}</span>
                        <span class="text-gray-400 text-[11px] text-center">{{ $book->author }}</span>
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
            if (btn && dropdown) {
                btn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    dropdown.classList.toggle('hidden');
                });
                document.addEventListener('click', function () {
                    dropdown.classList.add('hidden');
                });
            }

            const tabs = document.querySelectorAll('.category-tab');
            const cards = document.querySelectorAll('[data-category-card]');

            if (tabs.length) {
                const setActive = (slug) => {
                    tabs.forEach((tab) => {
                        const active = tab.dataset.categoryTab === slug;
                        tab.classList.toggle('border-[#1A2536]', active);
                        tab.classList.toggle('text-[#1A2536]', active);
                        tab.classList.toggle('border-transparent', !active);
                        tab.classList.toggle('text-[#6B7280]', !active);
                    });

                    cards.forEach((card) => {
                        const visible = slug === 'all' || card.dataset.categoryCard === slug;
                        card.classList.toggle('hidden', !visible);
                    });
                };

                tabs.forEach((tab) => tab.addEventListener('click', () => setActive(tab.dataset.categoryTab)));
                setActive('all');
            }
        });
    </script>

</body>
</html>