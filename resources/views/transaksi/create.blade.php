@extends('layouts.layout')

@section('header', 'Transaksi')
@section('subheader', 'Tambah transaksi baru.')

@section('content')
<main class="px-4 pb-12 pt-8 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-2xl">

        <div class="mb-8">
            <a href="{{ route('transaksi.index') }}"
               class="mb-2 flex items-center gap-2 text-xs font-medium text-slate-500 transition hover:text-slate-700">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar
            </a>
            <h1 class="text-xl font-semibold text-slate-800">Tambah Transaksi Baru</h1>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-8">
            <form action="{{ route('transaksi.store') }}" method="POST">
                @csrf
                <div class="space-y-5">

                    {{-- Tipe --}}
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Tipe Transaksi</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="flex cursor-pointer items-center gap-3 rounded-xl border border-slate-200 px-4 py-3 transition has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50">
                                <input type="radio" name="tipe" value="pemasukan"
                                       {{ old('tipe') == 'pemasukan' ? 'checked' : '' }}
                                       class="accent-emerald-600">
                                <span class="text-sm font-medium text-slate-700">
                                    <i class="fas fa-arrow-down mr-1 text-emerald-500"></i> Pemasukan
                                </span>
                            </label>
                            <label class="flex cursor-pointer items-center gap-3 rounded-xl border border-slate-200 px-4 py-3 transition has-[:checked]:border-red-400 has-[:checked]:bg-red-50">
                                <input type="radio" name="tipe" value="pengeluaran"
                                       {{ old('tipe') == 'pengeluaran' ? 'checked' : '' }}
                                       class="accent-red-500">
                                <span class="text-sm font-medium text-slate-700">
                                    <i class="fas fa-arrow-up mr-1 text-red-400"></i> Pengeluaran
                                </span>
                            </label>
                        </div>
                        @error('tipe')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Jumlah --}}
                    <div>
                        <label for="jumlah" class="mb-2 block text-sm font-medium text-slate-700">Jumlah</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm font-medium text-slate-400">Rp</span>
                            <input type="number" name="jumlah" id="jumlah"
                                   value="{{ old('jumlah') }}"
                                   placeholder="0"
                                   class="w-full rounded-lg border border-slate-200 bg-slate-50 py-2.5 pl-10 pr-4 text-sm outline-none transition focus:border-slate-900 focus:ring-2 focus:ring-slate-900/5 @error('jumlah') border-red-400 @enderror">
                        </div>
                        @error('jumlah')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Dompet --}}
                    <div>
                        <label for="dompet_id" class="mb-2 block text-sm font-medium text-slate-700">Dompet</label>
                        <select name="dompet_id" id="dompet_id"
                                class="w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm outline-none transition focus:border-slate-900 focus:ring-2 focus:ring-slate-900/5 @error('dompet_id') border-red-400 @enderror">
                            <option value="" disabled selected>Pilih dompet...</option>
                            @foreach($dompet as $d)
                                <option value="{{ $d->id }}" {{ old('dompet_id') == $d->id ? 'selected' : '' }}>
                                    {{ $d->nama }} — Rp{{ number_format($d->total, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                        @error('dompet_id')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kategori --}}
                    <div>
                        <label for="kategori_id" class="mb-2 block text-sm font-medium text-slate-700">Kategori</label>
                        <select name="kategori_id" id="kategori_id"
                                class="w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm outline-none transition focus:border-slate-900 focus:ring-2 focus:ring-slate-900/5 @error('kategori_id') border-red-400 @enderror">
                            <option value="" disabled selected>Pilih kategori...</option>
                            @foreach($kategori as $k)
                                <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama }} ({{ ucfirst($k->tipe) }})
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tanggal --}}
                    <div>
                        <label for="tanggal" class="mb-2 block text-sm font-medium text-slate-700">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal"
                               value="{{ old('tanggal', date('Y-m-d')) }}"
                               class="w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm outline-none transition focus:border-slate-900 focus:ring-2 focus:ring-slate-900/5 @error('tanggal') border-red-400 @enderror">
                        @error('tanggal')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Catatan --}}
                    <div>
                        <label for="catatan" class="mb-2 block text-sm font-medium text-slate-700">
                            Catatan <span class="text-slate-400">(opsional)</span>
                        </label>
                        <input type="text" name="catatan" id="catatan"
                               value="{{ old('catatan') }}"
                               placeholder="Contoh: Belanja bulanan, Gaji bulan ini..."
                               class="w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm outline-none transition focus:border-slate-900 focus:ring-2 focus:ring-slate-900/5">
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center justify-end gap-3 pt-2">
                        <a href="{{ route('transaksi.index') }}"
                           class="px-4 py-2 text-sm font-medium text-slate-500 transition hover:text-slate-700">Batal</a>
                        <button type="submit"
                                class="rounded-lg bg-slate-900 px-6 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-slate-800 active:scale-95">
                            Simpan Transaksi
                        </button>
                    </div>

                </div>
            </form>
        </div>

    </div>
</main>
@endsection