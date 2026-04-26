@php
    $menuItems = [
        ['label' => 'Dashboard', 'icon' => 'fa-house', 'href' => route('dashboard'), 'active' => request()->routeIs('dashboard')],
        ['label' => 'Category', 'icon' => 'fa-wallet', 'href' => route('category'), 'active' => request()->routeIs('category')],
        ['label' => 'Dompet', 'icon' => 'fa-wallet', 'href' => '#', 'active' => false],
        ['label' => 'Transaksi', 'icon' => 'fa-right-left', 'href' => '#', 'active' => false],
        ['label' => 'Analisis', 'icon' => 'fa-chart-pie', 'href' => '#', 'active' => false],
    ];
@endphp

<aside class="fixed z-30 hidden h-full w-20 flex-col border-r border-emerald-100 bg-white/90 backdrop-blur-xl md:flex lg:w-64">
    <div class="flex items-center gap-3 px-6 pb-4 pt-6">
        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-[#0b6b5b] to-[#0f8b73] text-white shadow-lg shadow-emerald-100">
            <i class="fas fa-leaf text-sm"></i>
        </div>
        <div class="hidden lg:block">
            <span class="text-[22px] font-bold tracking-tight text-slate-800">SakuPintar</span>
        </div>
    </div>

    <nav class="flex-1 space-y-2 px-4 pt-4">
        @foreach ($menuItems as $item)
            <a
                href="{{ $item['href'] }}"
                class="flex items-center gap-4 rounded-2xl px-4 py-3.5 transition {{ $item['active'] ? 'bg-emerald-50 font-semibold text-[#0b6b5b] shadow-sm shadow-emerald-50' : 'text-slate-500 hover:bg-slate-50 hover:text-[#0b6b5b]' }}"
            >
                <i class="fas {{ $item['icon'] }} w-5 text-sm"></i>
                <span class="hidden lg:block">{{ $item['label'] }}</span>
            </a>
        @endforeach
    </nav>

    <div class="hidden px-4 pb-4 lg:block">
        <div class="card-shadow rounded-3xl border border-emerald-100 bg-gradient-to-br from-emerald-50 to-cyan-50 p-5">
            <h4 class="text-sm font-semibold text-slate-700">Upgrade ke SakuPintar Premium</h4>
            <p class="mt-2 text-xs leading-5 text-slate-500">Dapatkan analisis mendalam dan fitur eksklusif lainnya.</p>
            <button class="mt-4 w-full rounded-2xl bg-[#0b6b5b] px-4 py-3 text-sm font-semibold text-white transition hover:bg-[#085347]">
                <i class="fas fa-crown mr-2 text-xs"></i>Upgrade Sekarang
            </button>
        </div>
    </div>

    <div class="hidden px-4 pb-6 lg:block">
        <div class="rounded-2xl border border-slate-100 bg-white p-4">
            <p class="text-sm font-medium text-slate-700">Butuh bantuan?</p>
            <a href="#" class="mt-1 flex items-center justify-between text-xs text-slate-500 transition hover:text-[#0b6b5b]">
                <span>Hubungi kami</span>
                <i class="fas fa-chevron-right text-[10px]"></i>
            </a>
        </div>
    </div>
</aside>
~