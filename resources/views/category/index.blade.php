@extends('layouts.layout')

@section('header', $title)
@section('subheader', $subtitle)

@section('content')
<main class="px-4 pb-12 pt-8 sm:px-6 lg:px-8 bg-[#f8fafc] min-h-screen">
    <div class="mx-auto max-w-5xl">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-6">
            <div>
                <nav class="flex text-xs font-bold text-emerald-600 uppercase tracking-widest mb-2">
                    <span>Pengaturan</span>
                    <span class="mx-2 text-gray-300">/</span>
                    <span class="text-gray-400">Kategori</span>
                </nav>
                <h1 class="text-3xl font-black text-gray-900 tracking-tight">Kategori Keuangan</h1>
                <p class="text-gray-500 mt-1">Pisahkan pengeluaran dan pemasukanmu dengan rapi.</p>
            </div>
            
            <a href="{{ route('category.create') }}" class="group flex items-center gap-3 bg-gray-900 hover:bg-emerald-600 text-white px-6 py-3.5 rounded-2xl shadow-xl shadow-gray-200 transition-all duration-300 active:scale-95">
                <div class="w-6 h-6 bg-white/10 rounded-lg flex items-center justify-center group-hover:bg-white group-hover:text-emerald-600 transition-colors">
                    <i class="fas fa-plus text-xs"></i>
                </div>
                <span class="text-sm font-bold uppercase tracking-wider">Tambah Baru</span>
            </a>
        </div>

        <div class="space-y-4">
            <div class="grid grid-cols-12 px-8 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2 hidden md:grid">
                <div class="col-span-1">No</div>
                <div class="col-span-6">Detail Kategori</div>
                <div class="col-span-3">Tipe Aliran</div>
                <div class="col-span-2 text-right">Opsi</div>
            </div>

            @foreach($category as $index => $c)
            <div class="group bg-white rounded-[2rem] p-4 md:p-6 border border-gray-100 hover:border-emerald-200 hover:shadow-2xl hover:shadow-emerald-500/5 transition-all duration-300 flex flex-col md:grid md:grid-cols-12 md:items-center gap-4 relative overflow-hidden">
                
                <div class="col-span-1 hidden md:block">
                    <span class="text-xl font-black text-gray-100 group-hover:text-emerald-50 transition-colors italic leading-none">
                        {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                    </span>
                </div>

                <div class="col-span-6 flex items-center gap-5">
                    <div class="w-12 h-12 rounded-2xl {{ $c->tipe == 'Pemasukan' ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-500' }} flex items-center justify-center text-xl transition-transform group-hover:scale-110 duration-300">
                        <i class="fas {{ $c->tipe == 'Pemasukan' ? 'fa-arrow-down' : 'fa-arrow-up' }} text-sm"></i>
                    </div>
                    <div>
                        <h4 class="font-black text-gray-800 text-lg tracking-tight">{{ $c->nama }}</h4>
                        <p class="text-xs text-gray-400 font-medium">Terdaftar dalam sistem • {{ date('Y') }}</p>
                    </div>
                </div>

                <div class="col-span-3">
                    @if($c->tipe == 'Pemasukan')
                        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-500 text-white text-[10px] font-black uppercase tracking-wider shadow-lg shadow-emerald-100">
                            <i class="fas fa-check-circle"></i>
                            {{ $c->tipe }}
                        </div>
                    @else
                        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-red-500 text-white text-[10px] font-black uppercase tracking-wider shadow-lg shadow-red-100">
                            <i class="fas fa-minus-circle"></i>
                            {{ $c->tipe }}
                        </div>
                    @endif
                </div>

                <div class="col-span-2 flex justify-end items-center gap-2">
                    <a href="#" class="w-10 h-10 flex items-center justify-center rounded-xl text-gray-400 hover:bg-blue-50 hover:text-blue-600 transition-all border border-transparent hover:border-blue-100">
                        <i class="fas fa-edit text-sm"></i>
                    </a>
                    <button class="w-10 h-10 flex items-center justify-center rounded-xl text-gray-400 hover:bg-red-50 hover:text-red-600 transition-all border border-transparent hover:border-red-100">
                        <i class="fas fa-trash-alt text-sm"></i>
                    </button>
                </div>

                <div class="absolute left-0 top-0 bottom-0 w-1 {{ $c->tipe == 'Pemasukan' ? 'bg-emerald-500' : 'bg-red-500' }} opacity-0 group-hover:opacity-100 transition-opacity"></div>
            </div>
            @endforeach

            @if($category->isEmpty())
            <div class="text-center py-20 bg-white rounded-[3rem] border border-dashed border-gray-200">
                <img src="https://illustrations.popsy.co/gray/searching.svg" class="w-40 mx-auto mb-6 opacity-50">
                <p class="text-gray-400 font-bold uppercase tracking-widest text-xs">Belum ada kategori yang dibuat</p>
            </div>
            @endif
        </div>
    </div>
</main>
@endsection

@section('scripts')
@endsection