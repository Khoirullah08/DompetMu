@extends('layouts.layout')

@section('header', $title)
@section('subheader', $subtitle)

@section('content')
<main class="px-6 pb-12 pt-8 bg-[#f8fafc] min-h-screen">
    <div class="w-full">

        {{-- Page Header --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-6">
            <div>
                <nav class="flex text-xs font-bold text-emerald-600 uppercase tracking-widest mb-2">
                    <span>Finansial</span>
                    <span class="mx-2 text-gray-300">/</span>
                    <span class="text-gray-400">Daftar Transaksi</span>
                </nav>
                <h1 class="text-3xl font-black text-gray-900 tracking-tight">Kelola Transaksi</h1>
                <p class="text-gray-500 mt-1">Pantau semua pemasukan dan pengeluaranmu.</p>
            </div>

            <a href="{{ route('transaksi.create') }}"
               class="group flex items-center gap-3 bg-gray-900 hover:bg-emerald-600 text-white px-6 py-3.5 rounded-2xl shadow-xl shadow-gray-200 transition-all duration-300 active:scale-95">
                <div class="w-6 h-6 bg-white/10 rounded-lg flex items-center justify-center group-hover:bg-white group-hover:text-emerald-600 transition-colors">
                    <i class="fas fa-plus text-xs"></i>
                </div>
                <span class="text-sm font-bold uppercase tracking-wider">Tambah Transaksi</span>
            </a>
        </div>

        {{-- Toast --}}
        <div class="fixed top-6 right-6 z-[100] flex flex-col gap-3 pointer-events-none" id="toast-container">
            @if(session('success'))
            <div id="toast-success" class="pointer-events-auto flex items-center w-full max-w-sm p-4 bg-white border border-slate-100 rounded-2xl shadow-xl shadow-emerald-500/10 transform transition-all duration-500 translate-x-0 opacity-100">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-10 h-10 text-emerald-600 bg-emerald-50 rounded-xl">
                    <i class="fas fa-check-circle text-lg"></i>
                </div>
                <div class="ml-3 mr-4 text-sm font-semibold text-slate-800">{{ session('success') }}</div>
                <button type="button" onclick="closeToast('toast-success')" class="ml-auto bg-white text-slate-400 hover:text-slate-600 rounded-lg p-1.5 hover:bg-slate-50 transition-colors">
                    <i class="fas fa-times text-sm"></i>
                </button>
            </div>
            @endif

            @if(session('error'))
            <div id="toast-error" class="pointer-events-auto flex items-center w-full max-w-sm p-4 bg-white border border-slate-100 rounded-2xl shadow-xl shadow-rose-500/10 transform transition-all duration-500 translate-x-0 opacity-100">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-10 h-10 text-rose-600 bg-rose-50 rounded-xl">
                    <i class="fas fa-exclamation-circle text-lg"></i>
                </div>
                <div class="ml-3 mr-4 text-sm font-semibold text-slate-800">{{ session('error') }}</div>
                <button type="button" onclick="closeToast('toast-error')" class="ml-auto bg-white text-slate-400 hover:text-slate-600 rounded-lg p-1.5 hover:bg-slate-50 transition-colors">
                    <i class="fas fa-times text-sm"></i>
                </button>
            </div>
            @endif
        </div>

        {{-- Overview Card --}}
        <div class="bg-white rounded-[2.5rem] p-8 mb-10 border border-gray-100 shadow-sm flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-6">
                <div class="w-16 h-16 bg-emerald-50 rounded-3xl flex items-center justify-center text-emerald-600 text-2xl">
                    <i class="fas fa-right-left"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Transaksi</p>
                    <h2 class="text-4xl font-black text-gray-900 tracking-tighter italic">{{ $transaksi->count() }} Transaksi</h2>
                </div>
            </div>
            <div class="flex gap-4">
                <div class="px-6 py-3 bg-emerald-50 rounded-2xl text-center border border-emerald-100">
                    <p class="text-[10px] font-bold text-emerald-400 uppercase">Pemasukan</p>
                    <p class="text-lg font-black text-emerald-700">
                        Rp{{ number_format($transaksi->where('tipe', 'pemasukan')->sum('jumlah'), 0, ',', '.') }}
                    </p>
                </div>
                <div class="px-6 py-3 bg-red-50 rounded-2xl text-center border border-red-100">
                    <p class="text-[10px] font-bold text-red-400 uppercase">Pengeluaran</p>
                    <p class="text-lg font-black text-red-600">
                        Rp{{ number_format($transaksi->where('tipe', 'pengeluaran')->sum('jumlah'), 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Tabel Transaksi --}}
        @if($transaksi->isEmpty())
            <div class="text-center py-20 bg-white rounded-[3rem] border border-dashed border-gray-200">
                <div class="w-16 h-16 bg-gray-50 rounded-3xl flex items-center justify-center text-gray-300 text-3xl mx-auto mb-4">
                    <i class="fas fa-receipt"></i>
                </div>
                <p class="text-gray-400 font-bold uppercase tracking-widest text-xs mb-3">Belum ada transaksi yang dicatat</p>
                <a href="{{ route('transaksi.create') }}" class="text-emerald-600 text-xs font-bold underline underline-offset-2">Tambah sekarang</a>
            </div>
        @else
            <div class="bg-white rounded-[2rem] border border-gray-100">
                <div class="overflow-x-auto rounded-[2rem]">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100 text-gray-400 text-xs uppercase tracking-wider">
                                <th class="px-6 py-4 text-left font-semibold">Tanggal</th>
                                <th class="px-6 py-4 text-left font-semibold">Catatan</th>
                                <th class="px-6 py-4 text-left font-semibold">Kategori</th>
                                <th class="px-6 py-4 text-left font-semibold">Dompet</th>
                                <th class="px-6 py-4 text-left font-semibold">Tipe</th>
                                <th class="px-6 py-4 text-right font-semibold">Jumlah</th>
                                <th class="px-6 py-4 text-center font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($transaksi as $t)
                            <tr class="hover:bg-gray-50/60 transition-colors duration-150">
                                <td class="px-6 py-4 text-gray-400 text-xs whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($t->tanggal)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-gray-800 font-semibold max-w-[220px] truncate">
                                    {!! $t->catatan ?? '<span class="text-gray-300 font-normal italic">Tanpa catatan</span>' !!}
                                </td>
                                <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                                    {{ $t->kategori->nama ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                                    {{ $t->dompet->nama ?? '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($t->tipe === 'pemasukan')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-100 text-emerald-600 text-[10px] font-bold uppercase tracking-widest whitespace-nowrap">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                            Pemasukan
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-50 border border-red-100 text-red-500 text-[10px] font-bold uppercase tracking-widest whitespace-nowrap">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                                            Pengeluaran
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right font-black tracking-tight whitespace-nowrap {{ $t->tipe === 'pemasukan' ? 'text-emerald-600' : 'text-red-500' }}">
                                    {{ $t->tipe === 'pemasukan' ? '+' : '-' }}Rp{{ number_format($t->jumlah, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('transaksi.edit', $t->id) }}"
                                           class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-50 text-gray-400 hover:bg-blue-50 hover:text-blue-600 transition-all">
                                            <i class="fas fa-edit text-xs"></i>
                                        </a>
                                        <button onclick="openDeleteModal('{{ route('transaksi.delete', $t->id) }}')"
                                                class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-50 text-gray-400 hover:bg-red-50 hover:text-red-600 transition-all">
                                            <i class="fas fa-trash-alt text-xs"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

    </div>
</main>

@include('transaksi._delete')
@endsection


@section('scripts')
<script>
    function openDeleteModal(actionUrl) {
        document.getElementById('deleteForm').action = actionUrl;
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.getElementById('deleteForm').action = '';
    }

    function closeToast(id) {
        const toast = document.getElementById(id);
        if (toast) {
            toast.classList.remove('translate-x-0', 'opacity-100');
            toast.classList.add('translate-x-full', 'opacity-0');
            setTimeout(() => toast.style.display = 'none', 500);
        }
    }

    document.addEventListener("DOMContentLoaded", function () {
        ['toast-success', 'toast-error'].forEach(id => {
            const el = document.getElementById(id);
            if (el) setTimeout(() => closeToast(id), 4000);
        });
    });
</script>
@endsection