@php
    $userName  = Auth::user()->name;
    $userEmail = Auth::user()->email;
    $avatarUrl = 'https://ui-avatars.com/api/?name=' . urlencode($userName) . '&background=0b6b5b&color=fff';

    $profileLinks = [
        ['label' => 'Akun Saya', 'icon' => 'fa-user-circle', 'href' => route('profile')],
        ['label' => 'Keamanan',  'icon' => 'fa-shield-alt',  'href' => '#'],
    ];
@endphp

<nav class="sticky top-0 z-20 flex items-start justify-between border-b border-emerald-100 bg-white/75 px-6 py-5 backdrop-blur-xl lg:px-8">
    <div>
        <h1 class="text-[30px] font-bold tracking-tight text-slate-800">@yield('header', 'Ringkasan Finansial')</h1>
        <p class="mt-1 text-sm text-slate-400">@yield('subheader', 'Kelola keuanganmu dengan bijak.')</p>
    </div>

    <div class="flex items-center gap-4 pt-1 lg:gap-6">

        {{-- Tombol Admin Panel hanya muncul kalau role admin --}}
        @if (Auth::user()->role === 'admin')
            <a href="{{ route('admin.index') }}"
               class="flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-semibold text-white transition hover:opacity-90"
               style="background: var(--brand)">
                <i class="fa-solid fa-shield-halved text-sm"></i>
                <span class="hidden lg:inline">Admin Panel</span>
            </a>
        @endif

        {{-- Notifikasi --}}
        <button type="button" class="relative text-slate-400 transition hover:text-[#0b6b5b]">
            <i class="far fa-bell text-xl"></i>
            <span class="absolute -right-1 -top-1 h-2 w-2 rounded-full border-2 border-white bg-red-500"></span>
        </button>

        {{-- Profile Dropdown --}}
        <div class="relative">
            <button id="profileBtn" type="button" class="group flex items-center gap-3 rounded-full focus:outline-none">
                <img src="{{ $avatarUrl }}" alt="{{ $userName }}" class="h-10 w-10 rounded-full border-2 border-emerald-50 transition group-hover:border-[#0b6b5b]">
                <div class="hidden text-left lg:block">
                    <p class="text-sm font-semibold text-slate-700">{{ $userName }}</p>
                </div>
                <i class="fas fa-chevron-down text-[10px] text-slate-400"></i>
            </button>

            <div id="profileDropdown" class="dropdown-menu absolute right-0 z-50 mt-3 w-56 rounded-2xl border border-slate-100 bg-white py-2 shadow-2xl shadow-slate-200/50">
                <div class="border-b border-slate-50 px-4 py-3">
                    <p class="text-sm font-bold text-slate-800">{{ $userName }}</p>
                    <p class="text-xs text-slate-400">{{ $userEmail }}</p>
                </div>

                @foreach ($profileLinks as $link)
                    <a href="{{ $link['href'] }}" class="mt-1 flex items-center gap-3 px-4 py-2 text-sm text-slate-600 transition hover:bg-slate-50">
                        <i class="fas {{ $link['icon'] }} w-5"></i>
                        {{ $link['label'] }}
                    </a>
                @endforeach

                @if (Auth::user()->role === 'admin')
                    <hr class="my-2 border-slate-50">
                    <a href="{{ route('admin.index') }}" class="flex items-center gap-3 px-4 py-2 text-sm font-semibold transition hover:bg-emerald-50" style="color: var(--brand)">
                        <i class="fa-solid fa-shield-halved w-5"></i>
                        Admin Panel
                    </a>
                @endif

                <hr class="my-2 border-slate-50">

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-3 px-4 py-2 text-sm font-semibold text-red-500 transition hover:bg-red-50">
                        <i class="fas fa-power-off w-5"></i>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>