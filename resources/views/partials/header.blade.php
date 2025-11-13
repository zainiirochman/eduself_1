
@php
    $anggota = session('anggota_id') ? \App\Models\Anggota::find(session('anggota_id')) : null;
@endphp

<header class="fixed top-0 left-0 right-0 z-50 bg-[#111A28] text-white py-4 shadow-lg">
    <div class="container mx-auto flex justify-between items-center px-6">
        <a href="/" class="flex items-center gap-3">
            <img src="{{ asset('image/logo.png') }}" alt="Logo EduSelf" class="h-10 w-10">
            <h1 class="text-2xl font-bold tracking-wide">
                <span class="text-white">Edu</span><span class="text-[#87C15A]">Self</span>
            </h1>
        </a>

        <nav>
            <ul class="flex items-center gap-3">
                <li><a href="/" class="px-4 py-2 rounded transition {{ request()->is('/') ? 'bg-white text-[#111A28] font-bold shadow' : 'hover:bg-white/5' }}">Home</a></li>
                <li><a href="/perpustakaan" class="px-4 py-2 rounded transition {{ request()->is('perpustakaan*') ? 'bg-white text-[#111A28] font-bold shadow' : 'hover:bg-white/5' }}">Perpustakaan</a></li>
                <li><a href="/tentang_kami" class="px-4 py-2 rounded transition {{ request()->is('tentang_kami') ? 'bg-white text-[#111A28] font-bold shadow' : 'hover:bg-white/5' }}">Tentang Kami</a></li>

                @if($anggota)
                    <li class="relative">
                        <button type="button" id="userMenuBtn" aria-haspopup="true" aria-expanded="false"
                                class="px-6 py-2.5 rounded-lg bg-gradient-to-r from-[#87C15A] to-[#6FA849] text-white font-semibold shadow-md flex items-center">
                            <i class="fas fa-user-circle mr-2"></i>
                            <span class="truncate max-w-xs">{{ $anggota->name }}</span>
                        </button>

                        <div id="userMenuDropdown" role="menu" aria-label="User menu"
                             class="hidden w-56 bg-white rounded-lg shadow-xl border border-gray-100 overflow-visible">
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
                    <li><a href="{{ route('login_pengguna') }}" class="px-6 py-2.5 rounded-lg bg-gradient-to-r from-yellow-400 to-yellow-500 text-[#111A28] font-bold shadow-md flex items-center"><i class="fas fa-sign-in-alt mr-2"></i>Login</a></li>
                @endif
            </ul>
        </nav>
    </div>
</header>

<!-- spacer to prevent content being hidden under fixed header -->
<div class="h-20"></div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('userMenuBtn');
    const dd = document.getElementById('userMenuDropdown');

    if (!btn || !dd) {
        console.warn('header: userMenuBtn or userMenuDropdown not found', { btn: !!btn, dd: !!dd });
        return;
    }

    console.log('header: dropdown script initialized');

    // ensure dropdown can receive clicks (prevent body-level click closing when clicking inside)
    dd.addEventListener('click', function (e) { e.stopPropagation(); });

    let moved = false;
    function moveToBody() {
        if (!moved) {
            document.body.appendChild(dd);
            moved = true;
        }
    }

    function positionDropdown() {
        const rect = btn.getBoundingClientRect();
        const ddW = dd.offsetWidth || 224;
        const left = Math.max(8 + window.scrollX, rect.right - ddW + window.scrollX);
        const top = rect.bottom + 8 + window.scrollY;
        dd.style.position = 'absolute';
        dd.style.left = left + 'px';
        dd.style.top = top + 'px';
        dd.style.zIndex = 9999;
    }

    btn.addEventListener('click', function (e) {
        e.stopPropagation();
        moveToBody();
        const open = !dd.classList.contains('hidden');
        if (open) {
            dd.classList.add('hidden');
            btn.setAttribute('aria-expanded', 'false');
            console.log('header: dropdown hidden');
        } else {
            positionDropdown();
            dd.classList.remove('hidden');
            btn.setAttribute('aria-expanded', 'true');
            console.log('header: dropdown toggled');
            // focus first focusable element
            (dd.querySelector('a, button') || dd).focus();
        }
    });

    window.addEventListener('resize', () => { if (!dd.classList.contains('hidden')) positionDropdown(); });
    window.addEventListener('scroll', () => { if (!dd.classList.contains('hidden')) positionDropdown(); }, { passive: true });

    // close when clicking outside or pressing Esc
    document.addEventListener('click', function () {
        if (!dd.classList.contains('hidden')) {
            dd.classList.add('hidden');
            btn.setAttribute('aria-expanded', 'false');
        }
    });
    document.addEventListener('keydown', function (ev) {
        if (ev.key === 'Escape' && !dd.classList.contains('hidden')) {
            dd.classList.add('hidden');
            btn.setAttribute('aria-expanded', 'false');
            btn.focus();
        }
    });
});
</script>