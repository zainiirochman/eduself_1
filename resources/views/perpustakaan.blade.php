<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Buku - EduSelf</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> -->
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
                <h1 class="text-2xl font-bold tracking-wide">EduSelf</h1>
            </div>
            <nav>
                <ul class="flex space-x-2 items-center">
                    <li>
                        <a href="/" class="px-4 py-2 rounded transition
                            {{ request()->is('/') ? 'bg-white text-blue-600 font-bold shadow' : 'hover:bg-white hover:text-white' }}">
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="/tentang_kami" class="px-4 py-2 rounded transition
                            {{ request()->is('tentang_kami') ? 'bg-white text-blue-600 font-bold shadow' : 'hover:bg-white hover:text-white' }}">
                            Tentang Kami
                        </a>
                    </li>
                    <li>
                        <a href="/perpustakaan" class="px-4 py-2 rounded transition
                            {{ request()->is('perpustakaan') ? 'bg-white text-[#111A28] font-bold shadow' : 'hover:bg-white hover:text-white' }}">
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
                <button type="submit" class="bg-[#111A28] text-white px-4 py-2 rounded hover:bg-[#111A29]">
                    Cari
                </button>
            </form>
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">Judul</th>
                        <th class="py-2 px-4 border-b">Penulis</th>
                        <th class="py-2 px-4 border-b">Tahun</th>
                        <th class="py-2 px-4 border-b">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($books as $book)
                    <tr>
                        <td class="py-2 px-4 border-b">{{ $book->title }}</td>
                        <td class="py-2 px-4 border-b">{{ $book->author }}</td>
                        <td class="py-2 px-4 border-b">{{ $book->year }}</td>
                        <td class="py-2 px-4 border-b">
                            <!-- Preview button: data attributes used to populate modal -->
                            <button type="button"
                                class="preview-btn text-blue-600 hover:underline"
                                data-title="{{ e($book->title) }}"
                                data-author="{{ e($book->author) }}"
                                data-year="{{ e($book->year) }}"
                                data-category="{{ e(optional($book->category)->name ?? '-') }}"
                                data-stock="{{ e($book->stock ?? 'Tersedia') }}"
                                data-description="{{ e($book->description ?? '-') }}"
                                data-cover="{{ $book->cover ? asset($book->cover) : asset('image/placeholder-book.png') }}">
                                Lihat Preview
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>

    <footer class="bg-gray-800 text-white py-4 text-center">
        <p>&copy; 2025 EduSelf. All rights reserved.</p>
    </footer>

    <!-- Modal (replace existing modal) -->
<div id="bookPreviewModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">
    <div class="bg-white rounded-lg shadow-lg max-w-4xl w-full overflow-hidden relative">
        <div class="p-6 md:p-8 flex flex-col md:flex-row items-start gap-6">
            <!-- Cover (left) -->
            <div class="flex-shrink-0">
                <div class="w-56 h-80 bg-gray-100 overflow-hidden rounded shadow">
                    <img id="modalCover" src="{{ asset('image/placeholder-book.png') }}" alt="Cover" class="w-full h-full object-cover">
                </div>
            </div>

            <!-- Details (right) -->
            <div class="flex-1">
                <h3 id="modalTitle" class="text-2xl font-semibold text-[#111A28] mb-3">Judul Buku</h3>

                <dl class="grid grid-cols-2 gap-y-3 gap-x-6 text-sm text-gray-700">
                    <div class="flex items-start">
                        <dt class="font-medium text-gray-600 w-28">Judul : </dt>
                        <dd id="modalTitleDetail" class="text-gray-900"></dd>
                    </div>
                    <div class="flex items-start">
                        <dt class="font-medium text-gray-600 w-28">Penulis : </dt>
                        <dd id="modalAuthor" class="text-gray-900"></dd>
                    </div>
                    <div class="flex items-start">
                        <dt class="font-medium text-gray-600 w-28">Penerbit : </dt>
                        <dd id="modalPublisher" class="text-gray-900"></dd>
                    </div>
                    <div class="flex items-start">
                        <dt class="font-medium text-gray-600 w-28">Tahun : </dt>
                        <dd id="modalYear" class="text-gray-900"></dd>
                    </div>
                    <div class="flex items-start">
                        <dt class="font-medium text-gray-600 w-28">Kategori : </dt>
                        <dd id="modalCategory" class="text-gray-900"></dd>
                    </div>
                    <div class="flex items-start">
                        <dt class="font-medium text-gray-600 w-28">Ketersediaan : </dt>
                        <dd id="modalStock" class="text-gray-900"></dd>
                    </div>

                    <div class="col-span-2 mt-3">
                        <dt class="font-medium text-gray-600">Deskripsi : </dt>
                        <dd id="modalDescription" class="mt-2 text-sm text-gray-600 text-justify"></dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Footer controls (bottom-right) -->
        <div class="p-4 border-t flex justify-end gap-3">
            <a id="modalDetailLink" href="#" class="px-4 py-2 bg-[#111A28] text-white rounded hover:opacity-90">Lihat Halaman Detail</a>
            <button id="modalCloseFooterBtn" class="px-4 py-2 border rounded">Tutup</button>
        </div>

        <!-- small top-right close -->
        <button id="modalCloseBtn" class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 text-2xl leading-none">&times;</button>
    </div>
</div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // user menu script (existing) ...
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

            // Book preview modal logic
            const modal = document.getElementById('bookPreviewModal');
            const modalCloseBtn = document.getElementById('modalCloseBtn');
            const modalCloseFooterBtn = document.getElementById('modalCloseFooterBtn');
            const modalTitle = document.getElementById('modalTitle');
            const modalTitleDetail = document.getElementById('modalTitleDetail');
            const modalAuthor = document.getElementById('modalAuthor');
            const modalYear = document.getElementById('modalYear');
            const modalCategory = document.getElementById('modalCategory');
            const modalStock = document.getElementById('modalStock');
            const modalDescription = document.getElementById('modalDescription');
            const modalCover = document.getElementById('modalCover');
            const modalDetailLink = document.getElementById('modalDetailLink');
            const modalPublisher = document.getElementById('modalPublisher');

            function openModal(data) {
                modalTitle.textContent = data.title;
                modalTitleDetail.textContent = data.title;
                modalAuthor.textContent = data.author;
                modalYear.textContent = data.year;
                modalCategory.textContent = data.category;
                modalStock.textContent = data.stock;
                modalDescription.textContent = data.description;
                modalCover.src = data.cover;
                modalPublisher.textContent = data.publisher || '-';
                modalDetailLink.href = data.detailUrl || '#';

                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }

            function closeModal() {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }

            document.querySelectorAll('.preview-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    const data = {
                        title: this.dataset.title || '-',
                        author: this.dataset.author || '-',
                        year: this.dataset.year || '-',
                        category: this.dataset.category || '-',
                        stock: this.dataset.stock || '-',
                        description: this.dataset.description || '-',
                        cover: this.dataset.cover || '{{ asset('image/placeholder-book.png') }}',
                        publisher: this.dataset.publisher || '',
                        detailUrl: this.dataset.detailUrl || ''
                    };
                    openModal(data);
                });
            });

            if(modalCloseBtn) modalCloseBtn.addEventListener('click', closeModal);
            if(modalCloseFooterBtn) modalCloseFooterBtn.addEventListener('click', closeModal);

            // close when clicking outside content
            modal.addEventListener('click', function (e) {
                if (e.target === modal) closeModal();
            });

            // close on Escape
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeModal();
            });
        });
    </script>
</body>
</html>