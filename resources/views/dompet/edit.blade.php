@extends('layouts.layout')

@section('header', $title)
@section('subheader', $subtitle)

@section('content')
    <main class="px-4 pb-12 pt-8 sm:px-6 lg:px-8 bg-[#f8fafc] min-h-screen">
        <div class="mx-auto max-w-2xl">

            <!-- Header & Back Navigation -->
            <div class="mb-8">
                <a href="{{route('dompet.index')}}" class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-slate-800 transition mb-4 w-fit">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Tambah Dompet Baru</h1>
                <p class="text-sm text-slate-500 mt-1">Daftarkan rekening bank, e-wallet, atau kas tunai Anda ke dalam sistem.</p>
            </div>

            <!-- Form Card -->

            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                <form action="{{route('dompet.update', $dompet->id)}}" method="POST" class="p-6 sm:p-8">
                    @csrf
                    <div class="space-y-6">

                        <!-- Input: Nama Dompet -->
                        <div>
                            <label for="nama" class="block text-sm font-semibold text-slate-700 mb-2">Nama Dompet</label>
                            <input type="text"
                                   id="nama"
                                   name="nama"
                                   value="{{ old('nama', $dompet->nama) }}"
                                   placeholder="Contoh: BCA, GoPay, Tunai..."
                                   required
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none transition-all">
                        </div>

                        <!-- Input: Total Saldo -->
                        <div>
                            <label for="total" class="block text-sm font-semibold text-slate-700 mb-2">Saldo Awal</label>
                            <div class="relative">
                                <!-- Prefix Rp -->
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none border-r border-slate-200 pr-3 my-2.5">
                                    <span class="text-slate-500 font-bold text-sm">Rp</span>
                                </div>
                                <input type="number"
                                       id="total"
                                       name="total"
                                       value ="{{ old('total', $dompet->total) }}"
                                       placeholder="0"
                                       required
                                       class="w-full pl-16 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 font-semibold focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none transition-all">
                            </div>
                            <p class="text-xs text-slate-400 mt-2 font-medium">Masukkan nominal angka tanpa titik atau koma.</p>
                        </div>

                        <!-- Input: Status Aktif -->
                        <div>
                            <label for="aktif" class="block text-sm font-semibold text-slate-700 mb-2">Status Penggunaan</label>
                            <div class="relative">
                                <select id="aktif"
                                        name="aktif"
                                        required
                                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 font-medium appearance-none focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none transition-all cursor-pointer">
                                    <option value="1" @selected(old('aktif', $dompet->aktif)== 1)>Aktif (Dapat digunakan untuk transaksi)</option>
                                    <option value="0" @selected(old('aktif', $dompet->aktif)== 0)>Tidak Aktif (Disembunyikan sementara)</option>
                                </select>
                                <!-- Custom Dropdown Icon -->
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <i class="fas fa-chevron-down text-slate-400 text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="pt-6 mt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                            <a href="{{route('dompet.index')}}" class="px-5 py-2.5 text-sm font-semibold text-slate-500 hover:text-slate-800 hover:bg-slate-50 transition-colors rounded-xl">
                                Batal
                            </a>
                            <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-all active:scale-95">
                                Simpan Dompet
                            </button>
                        </div>

                    </div>
                </form>
            </div>

        </div>
    </main>
@endsection

@section('scripts')
@endsection
