
<!---- header partial ---->
<header class="fixed top-0 left-0 right-0 z-50 bg-[#111A28] text-white py-4 shadow-lg">
    <div class="container mx-auto flex justify-between items-center px-6">
        <div class="flex items-center space-x-3">
            <a href="/" class="flex items-center gap-3">
                <img src="{{ asset('image/logo.png') }}" alt="Logo EduSelf" class="h-10 w-10">
                <h1 class="text-2xl font-bold tracking-wide">
                    <span class="text-white">Edu</span><span class="text-[#87C15A]">Self</span>
                </h1>
            </a>
        </div>

        @php
            $anggota = session('anggota_id') ? \App\Models\Anggota::find(session('anggota_id')) : null;
        @endphp

        <nav>
            <ul class="flex items-center gap-3">
                <li>
                    <a href="/" class="px-4 py-2 rounded transition {{ request()->is('/') ? 'bg-white text-[#111A28] font-bold shadow' : 'hover:bg-white/5' }}">
                        Home
                    </a>
                </li>
                <li>
                    <a href="/perpustakaan" class="px-4 py-2 rounded transition {{ request()->is('perpustakaan*') ? 'bg-white text-[#111A28] font-bold shadow' : 'hover:bg-white/5' }}">
                        Perpustakaan
                    </a>
                </li>
                <li>
                    <a href="/tentang_kami" class="px-4 py-2 rounded transition {{ request()->is('tentang_kami') ? 'bg-white text-[#111A28] font-bold shadow' : 'hover:bg-white/5' }}">
                        Tentang Kami
                    </a>
                </li>

                @if($anggota)
                    <li class="relative">
                        <button id="userMenuBtn" class="px-6 py-2.5 rounded-lg bg-gradient-to-r from-[#87C15A] to-[#6FA849] text-white font-semibold shadow-md hover:shadow-lg transition-all duration-200 flex items-center">
                            <i class="fas fa-user-circle mr-2"></i>
                            <span class="truncate max-w-xs">{{ $anggota->name }}</span>
                        </button>

                        <div id="userMenuDropdown" class="absolute right-0 mt-3 w-56 bg-white rounded-lg shadow-xl z-10 hidden border border-gray-100 overflow-hidden">
                            <div class="bg-gradient-to-r from-[#23485B] to-[#111A28] px-4 py-3">
                                <p class="text-white font-semibold text-sm">{{ $anggota->name }}</p>
                                <p class="text-gray-300 text-xs">{{ $anggota->email ?? 'Anggota' }}</p>
                            </div>
                            <a href="/peminjaman-aktif" class="flex items-center px-4 py-3 text-[#23485B] hover:bg-[#87C15A] hover:text-white transition-all duration-200 border-b">
                                <i class="fas fa-book mr-3"></i> Peminjaman Aktif
                            </a>
                            <form action="{{ route('logout_pengguna') }}" method="POST" class="block">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-3 text-red-600 hover:bg-red-50 flex items-center">
                                    <i class="fas fa-sign-out-alt mr-3"></i> Logout
                                </button>
                            </form>
                        </div>
                    </li>
                @else
                    <li>
                        <a href="{{ route('login_pengguna') }}" class="px-6 py-2.5 rounded-lg bg-gradient-to-r from-yellow-400 to-yellow-500 text-[#111A28] font-bold shadow-md hover:shadow-lg transition-all duration-200 flex items-center">
                            <i class="fas fa-sign-in-alt mr-2"></i> Login
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</header>

<!-- spacer to prevent content being hidden under fixed header -->
<div class="h-20"></div>

<script>
    // header dropdown toggler (safe to include once per page)
    document.addEventListener('DOMContentLoaded', function () {
        const btn = document.getElementById('userMenuBtn');
        const dd = document.getElementById('userMenuDropdown');
        if (btn && dd) {
            btn.addEventListener('click', function (e) {
                e.stopPropagation();
                dd.classList.toggle('hidden');
            });
            document.addEventListener('click', function () {
                dd.classList.add('hidden');
            });
        }
    });
</script>