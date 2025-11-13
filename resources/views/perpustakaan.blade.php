<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Buku - EduSelf</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">

    @php
        $anggota = null;
        if(session('anggota_id')) {
            $anggota = \App\Models\Anggota::find(session('anggota_id'));
        }
    @endphp

    @include('partials.header')

    <div class="h-20"></div>

    <main class="container mx-auto py-8 px-6">
        <div class="bg-white shadow-md rounded px-8 py-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-semibold text-[#111A28]">Daftar Buku</h2>
                <div class="flex items-center gap-3">
                    <a href="/" class="text-sm text-gray-500 hover:underline">Kembali</a>
                    <a href="/perpustakaan" class="px-4 py-2 rounded-lg bg-gradient-to-r from-[#87C15A] to-[#6FA849] text-white text-sm shadow hover:opacity-95">Semua Buku</a>
                </div>
            </div>

            <!-- Search + hidden category input -->
            <form method="GET" action="{{ url('/perpustakaan') }}" class="mb-6 flex items-center gap-2">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari judul buku atau penulis..."
                    class="border rounded px-4 py-2 w-full max-w-md"
                >
                <input type="hidden" name="category" value="{{ request('category') }}">
                <button type="submit" class="bg-[#111A28] text-white px-4 py-2 rounded hover:bg-[#111A29]">
                    <i class="fas fa-search mr-2"></i> Cari
                </button>
                @if(request('category'))
                    <a href="/perpustakaan" class="ml-3 text-sm px-3 py-2 rounded bg-gray-100 text-gray-700 border">Hapus filter: {{ request('category') }}</a>
                @endif
            </form>

            <!-- category quick links (keep consistent with home) -->
            <div class="mb-6 flex gap-3 overflow-x-auto">
                @php
                    // build category list from books if not provided
                    $cats = $books->pluck('category')->filter()->map(fn($c)=>$c->name ?? null)->unique()->take(8);
                @endphp
                @foreach($cats as $c)
                    <a href="/perpustakaan?category={{ urlencode($c) }}" class="flex-none inline-block bg-[#f7fafc] px-4 py-2 rounded-lg border text-sm font-medium text-[#111A28] shadow-sm hover:scale-105 transition">
                        {{ $c }}
                    </a>
                @endforeach
            </div>

            <div class="overflow-x-auto rounded-lg border border-gray-100">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="py-3 px-4 border-b text-center">No</th>
                            <th class="py-3 px-4 border-b text-left">Judul</th>
                            <th class="py-3 px-4 border-b text-center">Penulis</th>
                            <th class="py-3 px-4 border-b text-center">Tahun</th>
                            <th class="py-3 px-4 border-b text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($books->isEmpty())
                            <tr>
                                <td colspan="5" class="py-12 px-4 text-center">
                                    <p class="text-gray-500 text-lg font-semibold">Tidak ada buku ditemukan.</p>
                                    <p class="text-sm text-gray-400 mt-2">Coba kata kunci lain atau kosongkan pencarian untuk melihat semua buku.</p>
                                </td>
                            </tr>
                        @else
                            @foreach($books as $index => $book)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 px-4 border-b text-center align-middle">{{ $index + 1 }}</td>
                                    <td class="py-3 px-4 border-b align-middle">{{ $book->title }}</td>
                                    <td class="py-3 px-4 border-b text-center align-middle">{{ $book->author }}</td>
                                    <td class="py-3 px-4 border-b text-center align-middle">{{ $book->year }}</td>
                                    <td class="py-3 px-4 border-b text-center align-middle">
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
                                            <i class="fas fa-eye mr-2"></i> Preview
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- pagination (if exists) -->
            <div class="mt-4">
                @if(method_exists($books, 'links'))
                    {{ $books->withQueryString()->links() }}
                @endif
            </div>
        </div>
    </main>

    <footer class="bg-gray-800 text-white py-4 text-center mt-8">
        <p>&copy; 2025 EduSelf. All rights reserved.</p>
    </footer>

    <!-- keep existing modal and scripts unchanged (copied from original) -->
    <div id="bookPreviewModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">
        <div class="bg-white rounded-lg shadow-lg max-w-4xl w-full overflow-hidden relative">
            <div class="p-6 md:p-8 flex flex-col md:flex-row items-start gap-6">
                <div class="flex-shrink-0">
                    <div class="w-36 h-52 overflow-hidden rounded-lg bg-[#2F3D55] mb-3">
                        <img id="modalCover" src="{{ asset('image/placeholder-book.png') }}" alt="Cover" class="w-full h-full object-cover object-center block">
                    </div>
                </div>

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

            <div class="p-4 border-t flex justify-end gap-3">
                @if($anggota)
                    <button id="modalBorrowBtn" class="px-4 py-2 bg-green-600 text-white rounded hover:opacity-90 hidden" data-book-id="" style="background:#87C15A;color:#fff;">
                        Pinjam
                    </button>
                @endif
                <button id="modalCloseFooterBtn" class="px-4 py-2 bg-[#111A28] text-white rounded hover:opacity-90 border">Tutup</button>
            </div>

            <button id="modalCloseBtn" class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 text-2xl leading-none">&times;</button>
        </div>
    </div>

    <script>
        // existing scripts left intact (preview modal, borrow flow, user dropdown)
        document.addEventListener('DOMContentLoaded', function () {
            const csrfToken = '{{ csrf_token() }}';
            const anggotaExists = {!! json_encode(!!$anggota) !!};
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
                            alert(payload?.message || payload?.error || ('Gagal meminjam buku. (' + res.status + ')'));
                            return;
                        }

                        alert(payload?.message || 'Berhasil. Tunjukkan peminjaman aktif ke petugas.');

                        modalBorrowBtn.classList.add('hidden');
                        modalBorrowBtn.disabled = true;
                        modalStock.textContent = payload?.new_stock || 'Tidak tersedia';

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