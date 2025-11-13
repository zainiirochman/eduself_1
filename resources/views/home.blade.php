<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>EduSelf</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- AOS (Animate On Scroll) -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <style>
        /* simple rotating carousel for hero covers */
        @keyframes floatUp {
            0% { transform: translateY(0); opacity: 1; }
            50% { transform: translateY(-8px); opacity: .9; }
            100% { transform: translateY(0); opacity: 1; }
        }
        .float-up { animation: floatUp 3s ease-in-out infinite; }

        /* subtle shimmer on CTA */
        .shimmer {
            background: linear-gradient(90deg, rgba(255,255,255,0.05), rgba(255,255,255,0.18), rgba(255,255,255,0.05));
            background-size: 200% 100%;
            animation: shimmer 3s linear infinite;
        }
        @keyframes shimmer {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 antialiased">
@php
    // fallback dummy data if controller doesn't provide
    $dummyBooks = $books ?? collect([
        (object)['title'=>'Belajar Laravel', 'author'=>'A. Dev', 'cover'=>null, 'category'=> (object)['name'=>'Pemrograman']],
        (object)['title'=>'Panduan PHP', 'author'=>'B. Code', 'cover'=>null, 'category'=> (object)['name'=>'Pemrograman']],
        (object)['title'=>'Sejarah Dunia', 'author'=>'C. Hist', 'cover'=>null, 'category'=> (object)['name'=>'Sejarah']],
        (object)['title'=>'Kisah Fiksi', 'author'=>'D. Story', 'cover'=>null, 'category'=> (object)['name'=>'Fiksi']],
        (object)['title'=>'Desain UI', 'author'=>'E. UX', 'cover'=>null, 'category'=> (object)['name'=>'Desain']],
    ]);
    $booksForView = $books ?? $dummyBooks;
    $categories = $booksForView->groupBy(fn($b) => $b->category->name ?? 'Tanpa Kategori')->keys();
@endphp

@php
    $anggota = session('anggota_id') ? \App\Models\Anggota::find(session('anggota_id')) : null;
@endphp

@include('partials.header')

<div class="h-20"></div>

<!-- HERO -->
<section class="container mx-auto px-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
        <div data-aos="fade-right">
            <h2 class="text-3xl md:text-4xl text-[#87C15A] font-semibold">Selamat Datang di EduSelf</h2>
            <h1 class="text-4xl md:text-5xl font-extrabold mt-3 text-[#111A28] leading-tight">
                Baca. Belajar. Tumbuh.<br/>
                Semua dari genggamanmu.
            </h1>
            <p class="mt-4 text-gray-600">Pinjam buku favorit, simpan riwayat, dan kelola pinjaman langsung dari aplikasi web kami.</p>

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

            <!-- stats -->
            <div class="mt-8 grid grid-cols-3 gap-4">
                <div class="bg-white rounded-lg p-4 text-center shadow">
                    <div class="text-2xl font-bold text-[#111A28] counter" data-target="1200">0</div>
                    <div class="text-sm text-gray-500">Total Buku</div>
                </div>
                <div class="bg-white rounded-lg p-4 text-center shadow">
                    <div class="text-2xl font-bold text-[#111A28] counter" data-target="874">0</div>
                    <div class="text-sm text-gray-500">Anggota</div>
                </div>
                <div class="bg-white rounded-lg p-4 text-center shadow">
                    <div class="text-2xl font-bold text-[#111A28] counter" data-target="342">0</div>
                    <div class="text-sm text-gray-500">Transaksi</div>
                </div>
            </div>
        </div>

        <div class="relative" data-aos="zoom-in">
            <!-- rotating book stack (simple CSS + tailwind) -->
            <div class="bg-gradient-to-br from-[#233044] to-[#17202a] rounded-2xl p-6 shadow-xl">
                <div class="flex items-center justify-center gap-4">
                    @foreach($booksForView->take(5) as $i => $b)
                        <div class="w-28 h-40 bg-white/5 rounded overflow-hidden transform transition-all duration-500 hover:scale-105 float-up" style="animation-delay: {{ $i * 0.2 }}s;">
                            @if($b->cover)
                                <img src="{{ asset($b->cover) }}" alt="cover" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-300 text-sm p-2">
                                    {{ $b->title }}
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 text-center text-gray-200">
                    <p class="text-sm">Rekomendasi Minggu Ini</p>
                    <h3 class="text-lg font-semibold text-white">Top Picks untuk Anda</h3>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories -->
<section class="container mx-auto px-6 mt-12" data-aos="fade-up">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-semibold text-[#111A28]">Kategori Populer</h3>
            <a href="/perpustakaan" class="text-sm text-[#87C15A] hover:underline">Lihat Semua</a>
        </div>
        <div class="flex gap-4 overflow-x-auto py-2">
            @foreach($categories as $cat)
                <a href="/perpustakaan?category={{ urlencode($cat) }}" 
                   class="flex-none inline-block bg-[#f7fafc] px-4 py-2 rounded-lg border text-sm font-medium text-[#111A28] shadow-sm hover:scale-105 transition">
                    {{ $cat }}
                </a>
            @endforeach
         </div>
    </div>
</section>

<!-- Featured / Dummy Data -->
<section class="container mx-auto px-6 mt-8" data-aos="fade-up">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h4 class="font-semibold text-[#111A28] mb-3">Buku Terbaru</h4>
            <ul class="space-y-3">
                @foreach($booksForView->take(3) as $b)
                    <li class="flex items-start gap-3">
                        <div class="w-12 h-16 bg-gray-100 rounded overflow-hidden flex items-center justify-center text-xs text-gray-500">
                            {{ $b->cover ? '' : 'No Image' }}
                        </div>
                        <div>
                            <div class="font-medium">{{ $b->title }}</div>
                            <div class="text-xs text-gray-500">{{ $b->author }}</div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h4 class="font-semibold text-[#111A28] mb-3">Top Penulis</h4>
            <ul class="text-sm text-gray-600 space-y-2">
                <li>Anna Developer</li>
                <li>Bagus Coder</li>
                <li>Citra Sejarah</li>
            </ul>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h4 class="font-semibold text-[#111A28] mb-3">Testimoni</h4>
            <div class="space-y-4 text-sm text-gray-600">
                <div class="bg-gray-50 p-3 rounded">
                    <strong>Alda</strong>
                    <p class="mt-1">Aplikasi mudah digunakan, koleksi lengkap!</p>
                </div>
                <div class="bg-gray-50 p-3 rounded">
                    <strong>Budi</strong>
                    <p class="mt-1">Proses pinjam cepat dan rapi.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter CTA -->
<section class="container mx-auto px-6 mt-10" data-aos="fade-up">
    <div class="bg-gradient-to-r from-[#23485B] to-[#111A28] rounded-lg p-8 text-white shadow-lg">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <h3 class="text-2xl font-bold">Dapatkan rekomendasi buku tiap minggu</h3>
                <p class="mt-2 text-gray-200">Daftar newsletter kami untuk update koleksi terbaru dan promo.</p>
            </div>
            <form class="flex gap-3 w-full md:w-auto">
                <input type="email" placeholder="Masukkan email" class="px-4 py-2 rounded-lg text-gray-800" />
                <button class="px-5 py-2 rounded-lg bg-[#87C15A] font-semibold hover:opacity-95 transition">Daftar</button>
            </form>
        </div>
    </div>
</section>

<footer class="mt-12 bg-[#87C15A] text-white py-6">
    <div class="container mx-auto px-6 text-center">
        <p class="font-semibold">EduSelf &mdash; Perpustakaan Digital</p>
        <p class="text-sm mt-2">© 2025 EduSelf. All rights reserved.</p>
    </div>
</footer>

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({ once: true, duration: 700 });

    // header dropdown
    document.addEventListener('DOMContentLoaded', function () {
        const btn = document.getElementById('userMenuBtn');
        const dropdown = document.getElementById('userMenuDropdown');
        if (btn && dropdown) {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                dropdown.classList.toggle('hidden');
            });
            document.addEventListener('click', function () {
                dropdown.classList.add('hidden');
            });
        }

        // counters
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
            update();
        });
    });
</script>
</body>
</html>