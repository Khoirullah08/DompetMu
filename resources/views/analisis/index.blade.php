@extends('layouts.layout')

@section('header', $title)
@section('subheader', $subtitle)

@section('content')
<main class="px-4 pb-12 pt-8 sm:px-6 lg:px-8 bg-[#f8fafc] min-h-screen">
<div class="mx-auto max-w-6xl space-y-8">

   {{-- Page Header + Filter --}}
<div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
    <div>
        <nav class="flex text-xs font-bold text-emerald-600 uppercase tracking-widest mb-2">
            <span>Finansial</span>
            <span class="mx-2 text-gray-300">/</span>
            <span class="text-gray-400">Analisis</span>
        </nav>
        <h1 class="text-3xl font-black text-gray-900 tracking-tight">Laporan Keuangan</h1>
        <p class="text-gray-500 mt-1">Visualisasi pemasukan dan pengeluaranmu.</p>
    </div>

    {{-- Filter Form --}}
    <form method="GET" action="{{ route('analisis.index') }}" class="flex items-center gap-3 flex-wrap">
        <select name="bulan"
                class="text-sm border border-gray-200 rounded-xl px-4 py-2.5 bg-white font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-emerald-300">
            <option value="semua" {{ $bulan == 'semua' ? 'selected' : '' }}>Semua Bulan</option>
            @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $i => $namaBulan)
                <option value="{{ $i + 1 }}" {{ $bulan == $i + 1 ? 'selected' : '' }}>{{ $namaBulan }}</option>
            @endforeach
        </select>

        <select name="tahun"
                class="text-sm border border-gray-200 rounded-xl px-4 py-2.5 bg-white font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-emerald-300">
            @foreach($daftarTahun as $t)
                <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
            @endforeach
        </select>

        <button type="submit"
                class="bg-gray-900 hover:bg-emerald-600 text-white text-sm font-bold px-5 py-2.5 rounded-xl transition-all duration-200 active:scale-95">
            <i class="fas fa-filter mr-1"></i> Filter
        </button>
    </form>
</div>

    {{-- Filter Result Info Strip — baris tersendiri di luar flex --}}
    <div id="filterInfoStrip" class="hidden">
        <div class="flex flex-wrap items-center gap-x-4 gap-y-2 bg-emerald-50 border border-emerald-100 rounded-2xl px-5 py-3 text-sm">
            <span class="font-black text-emerald-700" id="stripPeriode">—</span>
            <span class="text-gray-300 hidden sm:inline">|</span>
            <span class="text-gray-500">Pemasukan:
                <span class="font-black text-emerald-600" id="stripPemasukan">—</span>
            </span>
            <span class="text-gray-300 hidden sm:inline">|</span>
            <span class="text-gray-500">Pengeluaran:
                <span class="font-black text-red-500" id="stripPengeluaran">—</span>
            </span>
            <span class="text-gray-300 hidden sm:inline">|</span>
            <span class="text-gray-500">Saldo:
                <span class="font-black" id="stripSaldo">—</span>
            </span>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

        <div class="bg-white rounded-[2rem] p-6 border border-gray-100 shadow-sm flex items-center gap-5">
            <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 text-xl flex-shrink-0">
                <i class="fas fa-arrow-down"></i>
            </div>
            <div>
                <p>Total Pemasukan</p>
                <p class="text-2xl font-black text-emerald-600 tracking-tight" id="totalPemasukan">
                    Rp{{ number_format($totalPemasukan, 0, ',', '.') }}
                </p>
            </div>
        </div>

        <div class="bg-white rounded-[2rem] p-6 border border-gray-100 shadow-sm flex items-center gap-5">
            <div class="w-14 h-14 bg-red-50 rounded-2xl flex items-center justify-center text-red-500 text-xl flex-shrink-0">
                <i class="fas fa-arrow-up"></i>
            </div>
            <div>
                <p>Total Pengeluaran</p>
                <p class="text-2xl font-black text-red-500 tracking-tight" id="totalPengeluaran">
                    Rp{{ number_format($totalPengeluaran, 0, ',', '.') }}
                </p>
            </div>
        </div>

        <div class="bg-white rounded-[2rem] p-6 border border-gray-100 shadow-sm flex items-center gap-5">
            <div class="w-14 h-14 {{ $saldoBersih >= 0 ? 'bg-blue-50 text-blue-600' : 'bg-orange-50 text-orange-500' }} rounded-2xl flex items-center justify-center text-xl flex-shrink-0">
                <i class="fas fa-scale-balanced"></i>
            </div>
            <div>
                <p>Saldo bersih</p>
               <p class="text-2xl font-black {{ $saldoBersih >= 0 ? 'text-blue-600' : 'text-orange-500' }} tracking-tight" id="saldoBersih">
                    {{ $saldoBersih >= 0 ? '+' : '-' }}Rp{{ number_format(abs($saldoBersih), 0, ',', '.') }}
                </p>
            </div>
        </div>

    </div>

    {{-- Charts Row --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Income vs Expense Bar Chart --}}
        <div class="lg:col-span-2 bg-white rounded-[2rem] p-6 border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Grafik Bulanan</p>
                    <h3 class="text-lg font-black text-gray-800">Pemasukan vs Pengeluaran</h3>
                </div>
                <div class="flex items-center gap-4 text-xs font-semibold text-gray-500">
                    <span class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded-sm bg-emerald-400 inline-block"></span> Pemasukan
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded-sm bg-red-400 inline-block"></span> Pengeluaran
                    </span>
                </div>
            </div>
            <div class="h-64">
                <canvas id="barChart"
                    data-pemasukan='@json($dataPemasukan)'
                    data-pengeluaran='@json($dataPengeluaran)'
                    data-labels='@json($bulanLabels)'>
                </canvas>
            </div>
        </div>

        {{-- Pie Chart Kategori --}}
            <div class="bg-white rounded-[2rem] p-6 border border-gray-100 shadow-sm">
                <div class="mb-6">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Breakdown</p>
                    <h3 class="text-lg font-black text-gray-800">Kategori</h3>
                </div>
                <div class="h-48 flex items-center justify-center relative">
                    <canvas id="pieChart"
                        data-labels='@json($kategoriLabels)'
                        data-values='@json($kategoriValues)'>
                    </canvas>
                    <p id="pieNoData" class="hidden text-center text-sm text-gray-400">Belum ada data.</p>
                </div>
            </div>

    </div>

    {{-- Top Kategori --}}
    <div class="bg-white rounded-[2rem] p-6 border border-gray-100 shadow-sm">
        <div class="mb-6">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Ranking</p>
            <h3 class="text-lg font-black text-gray-800">Top Kategori</h3>
        </div>

    
        <div id="topKategoriContainer">
        @if($topKategori->isEmpty())
                <div class="text-center py-10 text-gray-400">
                    <i class="fas fa-chart-pie text-3xl mb-2"></i>
                    <p class="text-sm font-medium">Belum ada data.</p>
                </div>
            @else
            @php $maxVal = $topKategori->max(); @endphp
                <div class="space-y-4">
                    @foreach($topKategori as $nama => $jumlah)
                    @php $persen = $maxVal > 0 ? round(($jumlah / $maxVal) * 100) : 0; @endphp
                    <div>
                        <div class="flex justify-between items-center mb-1.5">
                            <span class="text-sm font-bold text-gray-700">{{ $nama }}</span>
                            <span class="text-sm font-black text-gray-800">Rp{{ number_format($jumlah, 0, ',', '.') }}</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2">
                            <div class="bg-emerald-500 h-2 rounded-full transition-all duration-500"
                                style="width: {{ $persen }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

</div>
</main>
@endsection

@section('scripts')
<script>
    window.ANALISIS_URL = "{{ route('analisis.index') }}";
</script>
<script src="{{ asset('asset/js/analisis.js') }}"></script>
@endsection