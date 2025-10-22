<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Buku - EduSelf</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
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
                            {{ request()->is('/') ? 'bg-white text-blue-600 font-bold shadow' : 'hover:bg-[#87C15A] hover:text-white' }}">
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="/tentang_kami" class="px-4 py-2 rounded transition
                            {{ request()->is('tentang_kami') ? 'bg-white text-blue-600 font-bold shadow' : 'hover:bg-[#87C15A] hover:text-white' }}">
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
                    @if($books->isEmpty())
                        <tr>
                            <td colspan="4" class="py-12 px-4 text-center">
                                <p class="text-gray-500 text-lg font-semibold">Tidak ada buku ditemukan.</p>
                                <p class="text-sm text-gray-400 mt-2">Coba kata kunci lain atau kosongkan pencarian untuk melihat semua buku.</p>
                            </td>
                        </tr>
                    @else
                        @foreach($books as $book)
                        <tr>
                            <td class="py-2 px-4 border-b text-center">{{ $book->title }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ $book->author }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ $book->year }}</td>
                            <td class="py-2 px-4 border-b text-center">
                                <button type="button"
                                    class="preview-btn inline-flex items-center px-3 py-1 bg-[#111A28] text-white rounded hover:bg-[#87C15A]"
                                    data-book-id="{{ $book->id }}"
                                    data-title="{{ e($book->title) }}"
                                    data-author="{{ e($book->author) }}"
                                    data-year="{{ e($book->year) }}"
                                    data-category="{{ e(optional($book->category)->name ?? '-') }}"
                                    data-stock="{{ e($book->stock ?? 'Tersedia') }}"
                                    data-description="{{ e($book->description ?? '-') }}"
                                    data-publisher="{{ e($book->publisher ?? '-') }}"
                                    data-cover="{{ $book->cover ? asset($book->cover) : asset('image/placeholder-book.png') }}">
                                    Lihat Preview
                                </button>

                                {{-- tombol Pinjam dipindahkan ke dalam modal --}}
                                @php
                                    $stockVal = $book->stock;
                                    $isAvailable = is_numeric($stockVal) ? ((int)$stockVal > 0) : (str_contains(strtolower((string)$stockVal),'tersedia') || str_contains(strtolower((string)$stockVal),'avail'));
                                @endphp

                                <!-- @if(! $isAvailable)
                                    <span class="ml-3 text-sm text-gray-500">Tidak tersedia</span>
                                @endif -->
                            </td>
                        </tr>
                        @endforeach
                    @endif
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
                <div class="w-36 h-52 overflow-hidden rounded-lg bg-[#2F3D55] mb-3">
                    <img id="modalCover"
                        src="{{ asset('image/placeholder-book.png') }}"
                        alt="Cover"
                        class="w-full h-full object-cover object-center block">
                </div>
            </div>

            <!-- Details (right) -->
            <div class="flex-1">
                <h3 id="modalTitle" class="text-2xl font-semibold text-[#111A28] mb-3">Judul Buku</h3>

                <dl class="grid grid-cols-2 gap-y-3 gap-x-6 text-sm text-gray-700">
                    <div class="flex items-start">
                        <dt class="font-medium text-gray-600 w-28">Judul</dt>
                        <dd id="modalTitleDetail" class="text-gray-900"></dd>
                    </div>
                    <div class="flex items-start">
                        <dt class="font-medium text-gray-600 w-28">Penulis</dt>
                        <dd id="modalAuthor" class="text-gray-900"></dd>
                    </div>
                    <div class="flex items-start">
                        <dt class="font-medium text-gray-600 w-28">Penerbit</dt>
                        <dd id="modalPublisher" class="text-gray-900"></dd>
                    </div>
                    <div class="flex items-start">
                        <dt class="font-medium text-gray-600 w-28">Tahun</dt>
                        <dd id="modalYear" class="text-gray-900"></dd>
                    </div>
                    <div class="flex items-start">
                        <dt class="font-medium text-gray-600 w-28">Kategori</dt>
                        <dd id="modalCategory" class="text-gray-900"></dd>
                    </div>
                    <div class="flex items-start">
                        <dt class="font-medium text-gray-600 w-28">Ketersediaan</dt>
                        <dd id="modalStock" class="text-gray-900"></dd>
                    </div>

                    <div class="col-span-2 mt-3">
                        <dt class="font-medium text-gray-600">Deskripsi</dt>
                        <dd id="modalDescription" class="mt-2 text-sm text-gray-600 text-justify"></dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Footer controls (bottom-right) -->
        <div class="p-4 border-t flex justify-end gap-3">
            @if($anggota)
                <!-- tambahkan inline style fallback agar terlihat walau Tailwind belum tercompile -->
                <button id="modalBorrowBtn" class="px-4 py-2 bg-green-600 text-white rounded hover:opacity-90 hidden" data-book-id=""
                        style="background:#87C15A;color:#fff;">
                    Pinjam
                </button>
            @endif
            <button id="modalCloseFooterBtn" class="px-4 py-2 bg-[#111A28] text-white rounded hover:opacity-90 border rounded">Tutup</button>
        </div>

        <!-- small top-right close -->
        <button id="modalCloseBtn" class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 text-2xl leading-none">&times;</button>
    </div>
</div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // tambahkan ini agar fetch punya CSRF token
            const csrfToken = '{{ csrf_token() }}';

            // apakah user anggota (untuk JS)
            const anggotaExists = {!! json_encode(!!$anggota) !!};
            // user menu script ...
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
            const modalPublisher = document.getElementById('modalPublisher');
            const modalBorrowBtn = document.getElementById('modalBorrowBtn');

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

                const stockVal = (data.stock || '').toString().trim().toLowerCase();
                const isBorrowed = stockVal === 'borrowed';
                if (modalBorrowBtn) {
                    modalBorrowBtn.dataset.bookId = data.bookId || '';
                    if (isBorrowed) {
                        modalBorrowBtn.classList.add('hidden');
                        modalBorrowBtn.disabled = true;
                    } else if (anggotaExists) {
                        modalBorrowBtn.classList.remove('hidden');
                        modalBorrowBtn.disabled = false;
                    } else {
                        modalBorrowBtn.classList.add('hidden');
                        modalBorrowBtn.disabled = true;
                    }
                }

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
                        publisher: this.dataset.publisher || '-',
                        bookId: this.dataset.bookId || ''
                    };
                    openModal(data);
                });
            });

            // modal borrow button handler (use same route)
            if (modalBorrowBtn) {
                modalBorrowBtn.addEventListener('click', async function () {
                    const bookId = this.dataset.bookId;
                    if (!bookId) return;
                    if (!confirm('Konfirmasi: pinjam buku ini?')) return;

                    try {
                        const res = await fetch("{{ route('perpustakaan.borrow') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ book_id: bookId })
                        });

                        const payload = await res.json().catch(() => null);

                        if (!res.ok) {
                            // tampilkan pesan server jika tersedia
                            alert(payload?.message || payload?.error || ('Gagal meminjam buku. (' + res.status + ')'));
                            return;
                        }

                        alert(payload?.message || 'Berhasil. Tunjukkan peminjaman aktif ke petugas.');

                        // update modal: hide borrow button and show stock status
                        modalBorrowBtn.classList.add('hidden');
                        modalBorrowBtn.disabled = true;
                        modalStock.textContent = payload?.new_stock || 'Tidak tersedia';

                        // update table row UI...
                        document.querySelectorAll('button[data-book-id]').forEach(el => {
                            if (el.dataset.bookId === String(bookId)) {
                                const row = el.closest('tr');
                                if (row) {
                                    const aksiCell = row.querySelector('td:last-child');
                                    if (aksiCell) {
                                        const tb = aksiCell.querySelector('.borrow-btn');
                                        if (tb) tb.remove();
                                        if (!aksiCell.querySelector('.not-available-label')) {
                                            const span = document.createElement('span');
                                            span.className = 'ml-3 text-sm text-gray-500 not-available-label';
                                            // span.textContent = 'Tidak tersedia';
                                            aksiCell.appendChild(span);
                                        }
                                    }
                                }
                            }
                        });

                    } catch (err) {
                        console.error(err);
                        alert(err?.message || 'Terjadi kesalahan, silakan coba lagi.');
                    }
                });
            }

            if(modalCloseBtn) modalCloseBtn.addEventListener('click', closeModal);
            if(modalCloseFooterBtn) modalCloseFooterBtn.addEventListener('click', closeModal);

            modal.addEventListener('click', function (e) {
                if (e.target === modal) closeModal();
            });

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeModal();
            });
        });
    </script>
</body>
</html>