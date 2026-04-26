@extends('layouts.layout')

@section('header', $title)
@section('subheader', $subtitle)

@section('content')
<main class="px-4 pb-12 pt-8 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-3xl">
        
        <div class="mb-8">
            <a href="{{ route('category.index') }}" class="text-xs font-medium text-slate-500 hover:text-slate-700 transition flex items-center gap-2 mb-2">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar
            </a>
            <h1 class="text-xl font-semibold text-slate-800">Tambah Kategori Baru</h1>
        </div>

        <div class="bg-white border border-slate-200 rounded-xl p-8">
            <form action="{{ route('category.store') }}" method="POST">
                @csrf
                
                <div class="space-y-6">
                    <div>
                        <label for="nama" class="block text-sm font-medium text-slate-700 mb-2">Nama Kategori</label>
                        <input type="text" 
                               name="nama" 
                               id="nama" 
                               value="{{ old('nama') }}"
                               placeholder="Contoh: Makan Siang, Gaji Bulanan..." 
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition @error('nama') border-red-400 @enderror">
                        @error('nama')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tipe" class="block text-sm font-medium text-slate-700 mb-2">Tipe Kategori</label>
                        <select name="tipe" 
                                id="tipe" 
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition @error('tipe') border-red-400 @enderror">
                            <option value="" disabled selected>Pilih tipe...</option>
                            <option value="pemasukan" {{ old('tipe') == 'pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                            <option value="pengeluarans" {{ old('tipe') == 'pengeluarans' ? 'selected' : '' }}>Pengeluaran</option>
                        </select>
                        @error('tipe')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-4 flex items-center justify-end gap-3">
                        <a href="{{ route('category.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-700 px-4 py-2">Batal</a>
                        <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white text-sm font-medium px-6 py-2.5 rounded-lg transition shadow-sm active:scale-95">
                            Simpan Kategori
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection