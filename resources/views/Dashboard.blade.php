@extends('layouts.layout')

@section('header', $summary['title'])
@section('subheader', $summary['subtitle'])

@section('styles')
<style>
    .hero-panel {
        background:
            radial-gradient(circle at 85% 20%, rgba(255, 255, 255, 0.14), transparent 22%),
            linear-gradient(135deg, #0b6b5b 0%, #075648 100%);
    }

    .hero-panel::after {
        content: '';
        position: absolute;
        right: -24px;
        bottom: -28px;
        width: 180px;
        height: 110px;
        background: linear-gradient(180deg, rgba(255, 255, 255, 0.12), rgba(255, 255, 255, 0.04));
        border-radius: 32px 32px 24px 24px;
        transform: rotate(-8deg);
    }

    .hero-panel::before {
        content: '';
        position: absolute;
        right: 36px;
        bottom: 32px;
        width: 88px;
        height: 36px;
        border: 6px solid rgba(255, 255, 255, 0.09);
        border-radius: 20px;
    }

    .piggy-illustration {
        position: absolute;
        right: 30px;
        bottom: 26px;
        width: 108px;
        height: 76px;
        background: radial-gradient(circle at 35% 35%, #ffffff 0%, #f4fff9 70%, #d8f1e6 100%);
        border-radius: 44px 46px 40px 38px;
        box-shadow: 0 16px 40px rgba(16, 185, 129, 0.16);
    }

    .piggy-illustration::before,
    .piggy-illustration::after {
        content: '';
        position: absolute;
        background: #effcf5;
        border-radius: 999px;
    }

    .piggy-illustration::before {
        width: 32px;
        height: 32px;
        top: 14px;
        right: -10px;
        box-shadow: inset -2px -3px 0 rgba(11, 107, 91, 0.08);
    }

    .piggy-illustration::after {
        width: 18px;
        height: 18px;
        left: 16px;
        bottom: -6px;
        box-shadow: 52px 0 0 #effcf5;
    }

    .piggy-ear,
    .piggy-tail,
    .piggy-coin,
    .piggy-snout {
        position: absolute;
    }

    .piggy-ear {
        width: 22px;
        height: 22px;
        top: -8px;
        left: 22px;
        background: #e2f7ea;
        border-radius: 6px;
        transform: rotate(-25deg);
    }

    .piggy-tail {
        right: -6px;
        bottom: 28px;
        width: 18px;
        height: 18px;
        border: 3px solid rgba(11, 107, 91, 0.25);
        border-left-color: transparent;
        border-bottom-color: transparent;
        border-radius: 50%;
        transform: rotate(10deg);
    }

    .piggy-coin {
        top: -14px;
        right: 18px;
        width: 16px;
        height: 24px;
        background: linear-gradient(180deg, #ffdc85, #ffb341);
        border-radius: 999px;
    }

    .piggy-snout {
        left: 8px;
        top: 26px;
        width: 26px;
        height: 18px;
        background: rgba(11, 107, 91, 0.08);
        border-radius: 999px;
    }

    .piggy-snout::before,
    .piggy-snout::after {
        content: '';
        position: absolute;
        top: 6px;
        width: 4px;
        height: 4px;
        background: rgba(11, 107, 91, 0.4);
        border-radius: 999px;
    }

    .piggy-snout::before { left: 7px; }
    .piggy-snout::after { right: 7px; }
</style>
@endsection

@section('content')
<main class="px-4 pb-6 pt-5 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl space-y-6">
        <div class="grid grid-cols-1 gap-6 xl:grid-cols-12">
            <section class="hero-panel card-shadow relative overflow-hidden rounded-[28px] border border-emerald-700/10 px-6 py-7 text-white sm:px-8 xl:col-span-8">
                <div class="relative z-10 flex flex-col gap-8 lg:flex-row lg:items-start lg:justify-between">
                    <div class="max-w-xl">
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-100">Akun Utama</p>
                        <div class="mt-3 flex flex-wrap items-center gap-3">
                            <h2 class="text-3xl font-bold tracking-tight">{{ $summary['main_wallet'] }}</h2>
                            <span class="rounded-full bg-emerald-400/25 px-3 py-1 text-xs font-semibold text-emerald-50">{{ $summary['main_status'] }}</span>
                        </div>
                        <p class="mt-3 text-sm text-emerald-50/90">
                            Pencatatan Keuangan Pribadi
                            <i class="fas fa-chevron-right ml-1 text-[10px]"></i>
                        </p>
                        <div class="mt-6 flex flex-wrap gap-3">
                            <button class="rounded-xl bg-white px-6 py-3 text-sm font-semibold text-[#0b6b5b] shadow-lg shadow-black/10 transition hover:-translate-y-0.5">
                                <i class="fas fa-paper-plane mr-2 text-xs"></i>Kirim Uang
                            </button>
                            <button class="rounded-xl border border-white/45 bg-white/5 px-6 py-3 text-sm font-semibold text-white transition hover:bg-white/10">
                                <i class="fas fa-rotate-right mr-2 text-xs"></i>Atur Ulang
                            </button>
                        </div>
                    </div>
                    <div class="relative z-10 shrink-0 text-left lg:pt-4 lg:text-right">
                        <p class="text-sm text-emerald-100">Saldo Tersedia</p>
                        <h3 class="mt-2 text-4xl font-bold tracking-tight sm:text-[48px]">{{ $summary['main_balance'] }}</h3>
                    </div>
                </div>
            </section>

            <section class="card-shadow relative overflow-hidden rounded-[28px] border border-emerald-100 bg-gradient-to-br from-[#f1fbf6] to-[#edf9f8] px-6 py-7 xl:col-span-4">
                <div class="relative z-10 max-w-[240px]">
                    <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-[#0b6b5b] shadow-sm">
                        <i class="fas fa-bullseye text-lg"></i>
                    </div>
                    <h3 class="text-2xl font-bold tracking-tight text-slate-800">Target Menabung</h3>
                    <p class="mt-3 text-sm leading-6 text-slate-500">{{ $summary['saving_target'] }}</p>
                    <button class="mt-6 rounded-xl bg-[#0b6b5b] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#085347]">
                        Buka Celengan
                    </button>
                </div>
                <div class="pointer-events-none absolute bottom-4 right-4 hidden sm:block">
                    <div class="piggy-illustration">
                        <span class="piggy-ear"></span>
                        <span class="piggy-tail"></span>
                        <span class="piggy-coin"></span>
                        <span class="piggy-snout"></span>
                    </div>
                </div>
            </section>
        </div>

        <section class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-4">
            @foreach ($wallets as $wallet)
                <article class="card-shadow rounded-[24px] border border-slate-100 bg-white px-5 py-5 transition hover:-translate-y-1 hover:border-emerald-200">
                    <div class="flex items-start gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl {{ $wallet['icon_bg'] }}">
                            <i class="fas {{ $wallet['icon'] }} {{ $wallet['icon_color'] }}"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-slate-500">{{ $wallet['nama'] }}</p>
                            <h3 class="mt-2 text-3xl font-bold leading-none tracking-tight text-slate-800">{{ $wallet['total'] }}</h3>
                            <p class="mt-4 text-xs font-medium text-emerald-500">
                                <i class="fas fa-arrow-trend-up mr-1"></i>{{ $wallet['updated_at'] }}
                            </p>
                        </div>
                    </div>
                </article>
            @endforeach
        </section>

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-12">
            <section class="card-shadow rounded-[28px] border border-slate-100 bg-white p-6 xl:col-span-6">
                <div class="mb-5 flex items-center justify-between">
                    <h3 class="text-xl font-bold tracking-tight text-slate-800">Transaksi Terakhir</h3>
                    <button class="flex items-center gap-2 rounded-xl bg-slate-50 px-4 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-100">
                        Lihat Semua
                        <i class="fas fa-chevron-right text-[10px]"></i>
                    </button>
                </div>
                <div class="space-y-3">
                    @foreach ($transactions as $transaction)
                        <div class="grid grid-cols-[44px_minmax(72px,88px)_minmax(160px,1fr)_auto_auto] items-center gap-3 rounded-2xl px-2 py-3 text-sm max-[900px]:grid-cols-1 max-[900px]:gap-2 max-[900px]:border max-[900px]:border-slate-100 max-[900px]:p-4">
                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl {{ $transaction['icon_bg'] }} {{ $transaction['icon_color'] }}">
                                <i class="fas {{ $transaction['icon'] }}"></i>
                            </div>
                            <div class="text-xs font-medium text-slate-400">{{ $transaction['date'] }}</div>
                            <div class="font-semibold text-slate-700">{{ $transaction['title'] }}</div>
                            <div>
                                <span class="rounded-full px-3 py-1 text-[10px] font-bold uppercase tracking-wide {{ $transaction['badge'] }}">{{ $transaction['category'] }}</span>
                            </div>
                            <div class="text-right text-sm font-bold {{ $transaction['amount_color'] }}">{{ $transaction['amount'] }}</div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="card-shadow rounded-[28px] border border-slate-100 bg-white p-6 xl:col-span-6">
                <div class="mb-5 flex items-center justify-between">
                    <h3 class="text-xl font-bold tracking-tight text-slate-800">Alokasi Dana</h3>
                    <button class="text-slate-300 transition hover:text-slate-500">
                        <i class="fas fa-ellipsis-vertical"></i>
                    </button>
                </div>
                <div class="grid grid-cols-1 items-center gap-6 lg:grid-cols-[280px_1fr]">
                    <div class="relative mx-auto h-[280px] w-[280px]">
                        <canvas id="donutChart"></canvas>
                        <div class="pointer-events-none absolute inset-0 flex flex-col items-center justify-center">
                            <span class="text-xs font-medium text-slate-400">Total Belanja</span>
                            <span class="mt-1 text-[40px] font-bold leading-none tracking-tight text-slate-800">{{ $summary['allocation_total'] }}</span>
                        </div>
                    </div>
                    <div class="space-y-5">
                        @foreach ($allocations as $allocation)
                            <div class="grid grid-cols-[16px_minmax(92px,1fr)_52px_auto] items-center gap-3 text-sm">
                                <span class="h-2.5 w-2.5 rounded-full" style="background-color: {{ $allocation['color'] }}"></span>
                                <span class="font-medium text-slate-700">{{ $allocation['label'] }}</span>
                                <span class="font-medium text-slate-500">{{ $allocation['percent'] }}%</span>
                                <span class="text-right text-slate-400">{{ $allocation['amount'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>

        <section class="card-shadow relative overflow-hidden rounded-[28px] border border-emerald-100 bg-gradient-to-r from-[#eefbf4] via-[#f8fffb] to-[#eef7f3] px-6 py-6">
            <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h3 class="text-lg font-bold text-[#0b6b5b]">Kelola keuanganmu lebih cerdas</h3>
                    <p class="mt-2 text-sm text-slate-500">Pantau pemasukan, pengeluaran, dan capai tujuan finansialmu bersama SakuPintar.</p>
                </div>
                <div class="flex items-center gap-4">
                    <button class="rounded-xl bg-[#10b981] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#0ea371]">
                        <i class="fas fa-bullseye mr-2 text-xs"></i>Buat Target Baru
                    </button>
                    <div class="hidden items-end gap-2 pr-2 sm:flex">
                        <span class="h-10 w-8 rounded-t-xl bg-orange-300 shadow-sm"></span>
                        <span class="h-14 w-8 rounded-t-xl bg-emerald-300 shadow-sm"></span>
                        <span class="h-20 w-8 rounded-t-xl bg-sky-300 shadow-sm"></span>
                        <i class="fas fa-arrow-trend-up -ml-2 mb-10 text-3xl text-emerald-400"></i>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>
@endsection

@section('scripts')
<script>
    const donutCanvas = document.getElementById('donutChart');

    if (donutCanvas) {
        const dtx = donutCanvas.getContext('2d');
        const allocationData = @json($allocations);

        if (window.dashboardDonutChart) {
            window.dashboardDonutChart.destroy();
        }

        window.dashboardDonutChart = new Chart(dtx, {
            type: 'doughnut',
            data: {
                labels: allocationData.map(item => item.label),
                datasets: [{
                    data: allocationData.map(item => item.percent),
                    backgroundColor: allocationData.map(item => item.color),
                    borderWidth: 0,
                    borderRadius: 10,
                    spacing: 2,
                    hoverOffset: 4
                }]
            },
            options: {
                cutout: '84%',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const item = allocationData[context.dataIndex];
                                return `${item.label}: ${item.percent}% (${item.amount})`;
                            }
                        }
                    }
                }
            }
        });
    }
</script>
@endsection
