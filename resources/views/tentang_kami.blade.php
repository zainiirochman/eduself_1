<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - EduSelf</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- AOS for animations -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .float-up { animation: floatUp 3s ease-in-out infinite; }
        @keyframes floatUp {
            0% { transform: translateY(0); opacity: 1; }
            50% { transform: translateY(-8px); opacity: .95; }
            100% { transform: translateY(0); opacity: 1; }
        }
        .shimmer {
            background: linear-gradient(90deg, rgba(255,255,255,0.04), rgba(255,255,255,0.12), rgba(255,255,255,0.04));
            background-size: 200% 100%;
            animation: shimmer 3s linear infinite;
        }
        @keyframes shimmer { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }
    </style>
</head>
<body class="bg-gray-100 antialiased text-gray-800">

@php
    $anggota = null;
    if(session('anggota_id')) {
        $anggota = \App\Models\Anggota::find(session('anggota_id'));
    }
@endphp

<!-- replace include + spacer with inline header (same as home) -->
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

                @if($anggota)
                    <li class="relative">
                        <button type="button" id="userMenuBtn" aria-haspopup="true" aria-expanded="false"
                                class="ml-3 px-4 py-1 rounded-lg bg-gradient-to-r from-[#87C15A] to-[#6FA849] text-white font-medium shadow-sm flex items-center">
                            <i class="fas fa-user-circle mr-2"></i>
                            <span class="truncate max-w-[160px]">{{ $anggota->name }}</span>
                        </button>

                        <div id="userMenuDropdown" class="hidden bg-white rounded-lg shadow-lg border border-gray-100 w-56 absolute right-0 mt-2 z-50">
                            <div class="bg-gradient-to-r from-[#23485B] to-[#111A28] px-4 py-3 rounded-t-lg">
                                <p class="text-white font-semibold text-sm">{{ $anggota->name }}</p>
                                <p class="text-gray-300 text-xs">{{ $anggota->email ?? 'Anggota' }}</p>
                            </div>
                            <a href="/peminjaman-aktif" class="flex items-center px-4 py-3 text-[#23485B] hover:bg-[#f7f9fb] border-b">
                                <i class="fas fa-book mr-3"></i>Peminjaman Aktif
                            </a>
                            <form action="{{ route('logout_pengguna') }}" method="POST" class="block">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-3 text-red-600 hover:bg-red-50 flex items-center">
                                    <i class="fas fa-sign-out-alt mr-3"></i>Logout
                                </button>
                            </form>
                        </div>
                    </li>
                @else
                    <li><a href="{{ route('login_pengguna') }}" class="ml-3 px-4 py-1 rounded-lg bg-yellow-400 text-[#111A28] font-semibold">Login</a></li>
                @endif
            </ul>
        </nav>
    </div>
</header>

<!-- dynamic spacer: akan di-set sesuai tinggi header -->
<div id="headerSpacer" class="w-full"></div>

<main class="container mx-auto py-8 px-6">
    <!-- Hero -->
    <section class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center mb-8">
        <div data-aos="fade-right">
            <h2 class="text-3xl text-[#87C15A] font-semibold">Tentang EduSelf</h2>
            <h1 class="text-4xl md:text-5xl font-extrabold mt-3 text-[#111A28] leading-tight">
                Perpustakaan Digital<br> untuk Semua.
            </h1>
            <p class="mt-4 text-gray-600">Kami menyediakan koleksi buku fisik dan digital, layanan peminjaman online, serta dukungan untuk pembelajaran mandiri kapan saja.</p>

            <div class="mt-6 flex gap-4">
                <a href="/perpustakaan" class="inline-flex items-center px-6 py-3 rounded-lg bg-gradient-to-r from-[#87C15A] to-[#6FA849] text-white font-semibold shadow-lg shimmer">
                    <i class="fas fa-book-open mr-3"></i> Jelajahi Perpustakaan
                </a>
                @unless($anggota)
                <a href="{{ route('register_pengguna') }}" class="inline-flex items-center px-6 py-3 rounded-lg bg-white text-[#111A28] font-semibold shadow-lg hover:shadow-xl transition">
                    <i class="fas fa-user-plus mr-3"></i> Daftar Sekarang
                </a>
                @endunless
            </div>

            <div class="mt-8 grid grid-cols-3 gap-4">
                <div class="bg-white rounded-lg p-4 text-center shadow" data-aos="zoom-in" data-aos-delay="100">
                    <div class="text-2xl font-bold text-[#111A28] counter" data-target="1200">0</div>
                    <div class="text-sm text-gray-500">Total Buku</div>
                </div>
                <div class="bg-white rounded-lg p-4 text-center shadow" data-aos="zoom-in" data-aos-delay="200">
                    <div class="text-2xl font-bold text-[#111A28] counter" data-target="874">0</div>
                    <div class="text-sm text-gray-500">Anggota</div>
                </div>
                <div class="bg-white rounded-lg p-4 text-center shadow" data-aos="zoom-in" data-aos-delay="300">
                    <div class="text-2xl font-bold text-[#111A28] counter" data-target="342">0</div>
                    <div class="text-sm text-gray-500">Transaksi</div>
                </div>
            </div>
        </div>

        <div class="relative" data-aos="zoom-in">
            <div class="bg-gradient-to-br from-[#233044] to-[#17202a] rounded-2xl p-6 shadow-xl">
                <div class="flex items-center justify-center gap-4">
                    <div class="w-40 h-56 bg-white/5 rounded overflow-hidden flex items-center justify-center text-gray-200 p-3 float-up">
                        <img src="{{ asset('image/perpustakaan.png') }}" alt="Perpustakaan" class="object-cover w-full h-full rounded">
                    </div>
                </div>
                <div class="mt-6 text-center text-gray-200">
                    <p class="text-sm">Visi & Misi</p>
                    <h3 class="text-lg font-semibold text-white">Meningkatkan Akses Literasi</h3>
                    <p class="text-xs text-gray-300 mt-2">Memberikan kemudahan akses buku berkualitas untuk semua kalangan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Profile & Facilities -->
    <section class="bg-white rounded-lg shadow p-6 mb-8" data-aos="fade-up">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
            <div class="md:col-span-1 text-center md:text-left">
                <img src="{{ asset('image/perpustakaan.png') }}" alt="Foto Perpustakaan" class="rounded-lg shadow-lg w-64 h-64 object-cover mx-auto md:mx-0">
            </div>
            <div class="md:col-span-2">
                <h2 class="text-2xl font-bold mb-2 text-[#111A28]">Profil Perpustakaan EduSelf</h2>
                <p class="mb-4 text-gray-700">Perpustakaan EduSelf adalah pusat literasi dan pembelajaran mandiri yang menyediakan berbagai koleksi buku pendidikan, teknologi, dan pengembangan diri. Kami berkomitmen untuk mendukung self-growth dan kemudahan akses informasi bagi seluruh pengguna.</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <h4 class="font-semibold text-[#111A28]">Kontak</h4>
                        <p class="text-sm text-gray-600 mt-2">
                            Alamat: Jl. Dummy Raya No. 123, Kota Edu<br>
                            Email: info@eduself.com<br>
                            Telp: (021) 12345678
                        </p>
                    </div>
                    <div>
                        <h4 class="font-semibold text-[#111A28]">Fasilitas</h4>
                        <ul class="list-disc ml-5 mt-2 text-sm text-gray-600">
                            <li>Ruang baca nyaman & ber-AC</li>
                            <li>WiFi gratis</li>
                            <li>Koleksi buku digital & fisik</li>
                            <li>Layanan peminjaman & pengembalian online</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Location -->
    <section class="bg-white rounded-lg shadow p-6 mb-8" data-aos="fade-up">
        <h3 class="text-lg font-semibold mb-4 text-[#111A28]">Lokasi Perpustakaan EduSelf</h3>
        <div class="w-full h-64 rounded overflow-hidden">
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d1509.9804637651591!2d112.72753586861805!3d-7.316052096908094!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sid!2sid!4v1758508700917!5m2!1sid!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </section>

    <!-- CTA -->
    <section class="bg-gradient-to-r from-[#23485B] to-[#111A28] rounded-lg p-8 text-white shadow-lg" data-aos="fade-up">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <h3 class="text-2xl font-bold">Ingin tahu koleksi lengkap kami?</h3>
                <p class="mt-2 text-gray-200">Kunjungi perpustakaan dan temukan buku yang kamu butuhkan.</p>
            </div>
            <a href="/perpustakaan" class="px-6 py-3 rounded-lg bg-[#87C15A] font-semibold shadow hover:opacity-95 transition">Jelajahi Sekarang</a>
        </div>
    </section>
</main>

<footer class="bg-gradient-to-r from-[#23485B] to-[#111A28] text-white py-6 text-center mt-12">
    <p class="text-sm">&copy; 2025 EduSelf. All rights reserved.</p>
</footer>

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({ once: true, duration: 700 });

    // set spacer to header height + simple dropdown toggle (kept minimal)
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

    // counters animation
    const counters = document.querySelectorAll('.counter');
    counters.forEach(counter => {
        const update = () => {
            const target = +counter.getAttribute('data-target');
            const value = +counter.innerText;
            const increment = Math.ceil(target / 100);
            if (value < target) {
                counter.innerText = Math.min(value + increment, target);
                setTimeout(update, 20);
            } else {
                counter.innerText = target;
            }
        };
        // trigger when visible (simple)
        const io = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if(entry.isIntersecting) update(), io.disconnect();
            });
        }, { threshold: 0.4 });
        io.observe(counter);
    });
</script>
</body>
</html>