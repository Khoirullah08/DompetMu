@extends('layouts.layout')

@section('header', $title)
@section('subheader', $subtitle)

@section('content')
<main class="px-4 pb-12 pt-8 sm:px-6 lg:px-8 bg-[#f8fafc] min-h-screen">
    <div class="mx-auto max-w-5xl">

        <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-6">
            <div>
                <nav class="flex text-xs font-bold text-emerald-600 uppercase tracking-widest mb-2">
                    <span>Finansial</span>
                    <span class="mx-2 text-gray-300">/</span>
                    <span class="text-gray-400">Daftar Dompet</span>
                </nav>
                <h1 class="text-3xl font-black text-gray-900 tracking-tight">Kelola Dompet</h1>
                <p class="text-gray-500 mt-1">Pantau semua sumber dana dan saldo asetmu.</p>
            </div>

            <a href="{{ route('dompet.create')}}" class="group flex items-center gap-3 bg-gray-900 hover:bg-emerald-600 text-white px-6 py-3.5 rounded-2xl shadow-xl shadow-gray-200 transition-all duration-300 active:scale-95">
                <div class="w-6 h-6 bg-white/10 rounded-lg flex items-center justify-center group-hover:bg-white group-hover:text-emerald-600 transition-colors">
                    <i class="fas fa-plus text-xs"></i>
                </div>
                <span class="text-sm font-bold uppercase tracking-wider">Tambah Dompet</span>
            </a>
        </div>

        <div class="fixed top-6 right-6 z-[100] flex flex-col gap-3 pointer-events-none" id="toast-container">
            <!-- Toast Success -->
            @if(session('success'))
            <div id="toast-success" class="pointer-events-auto flex items-center w-full max-w-sm p-4 bg-white border border-slate-100 rounded-2xl shadow-xl shadow-emerald-500/10 transform transition-all duration-500 translate-x-0 opacity-100">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-10 h-10 text-emerald-600 bg-emerald-50 rounded-xl">
                    <i class="fas fa-check-circle text-lg"></i>
                </div>
                <div class="ml-3 mr-4 text-sm font-semibold text-slate-800">
                    {{ session('success') }}
                </div>
                <button type="button" onclick="closeToast('toast-success')" class="ml-auto bg-white text-slate-400 hover:text-slate-600 rounded-lg p-1.5 hover:bg-slate-50 transition-colors">
                    <i class="fas fa-times text-sm"></i>
                </button>
            </div>
            @endif

            <!-- Toast Error -->
            @if(session('error'))
            <div id="toast-error" class="pointer-events-auto flex items-center w-full max-w-sm p-4 bg-white border border-slate-100 rounded-2xl shadow-xl shadow-rose-500/10 transform transition-all duration-500 translate-x-0 opacity-100">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-10 h-10 text-rose-600 bg-rose-50 rounded-xl">
                    <i class="fas fa-exclamation-circle text-lg"></i>
                </div>
                <div class="ml-3 mr-4 text-sm font-semibold text-slate-800">
                    {{ session('error') }}
                </div>
                <button type="button" onclick="closeToast('toast-error')" class="ml-auto bg-white text-slate-400 hover:text-slate-600 rounded-lg p-1.5 hover:bg-slate-50 transition-colors">
                    <i class="fas fa-times text-sm"></i>
                </button>
            </div>
            @endif

            @if($errors->any())
            <div id="toast-validation" class="pointer-events-auto flex items-center w-full max-w-sm p-4 bg-white border border-slate-100 rounded-2xl shadow-xl shadow-orange-500/10 transform transition-all duration-500 translate-x-0 opacity-100">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-10 h-10 text-orange-600 bg-orange-50 rounded-xl">
                    <i class="fas fa-info-circle text-lg"></i>
                </div>
                <div class="ml-3 mr-4 text-sm font-semibold text-slate-800">
                    Terdapat input yang tidak valid. Periksa kembali form Anda.
                </div>
                <button type="button" onclick="closeToast('toast-validation')" class="ml-auto bg-white text-slate-400 hover:text-slate-600 rounded-lg p-1.5 hover:bg-slate-50 transition-colors">
                    <i class="fas fa-times text-sm"></i>
                </button>
            </div>
            @endif
        </div>

        <!-- Total Balance Card (Overview) -->
        <div class="bg-white rounded-[2.5rem] p-8 mb-10 border border-gray-100 shadow-sm flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-6">
                <div class="w-16 h-16 bg-emerald-50 rounded-3xl flex items-center justify-center text-emerald-600 text-2xl">
                    <i class="fas fa-wallet"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Saldo Keseluruhan</p>
                    <h2 class="text-4xl font-black text-gray-900 tracking-tighter italic">Rp {{$total}}</h2>
                </div>
            </div>
            <div class="flex gap-4">
                <div class="px-6 py-3 bg-gray-50 rounded-2xl text-center border border-gray-100">
                    <p class="text-[10px] font-bold text-gray-400 uppercase">Jumlah Dompet</p>
                    <p class="text-lg font-black text-gray-800">{{$hitung}} Unit</p>
                </div>
            </div>
        </div>

        <!-- Grid Dompet -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        @if($dompet->isEmpty())
            <div class="col-span-full text-center py-20 bg-white rounded-[3rem] border border-dashed border-gray-200">
                <img src="https://proicons.com/icon/313337.svg" class="w-40 mx-auto mb-6 opacity-50 bg-color">
                <p class="text-gray-400 font-bold uppercase tracking-widest text-xs">Belum ada dompet yang didaftarkan</p>
            </div>
        @else
        @foreach($dompet as $dompet)
            <div class="group bg-white rounded-[2rem] p-6 border border-gray-100 hover:border-emerald-200 hover:shadow-2xl hover:shadow-emerald-500/5 transition-all duration-300 relative overflow-hidden">
                <div class="flex justify-between items-start mb-8 relative z-10">
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-xl">
                        <i class="fas fa-university"></i>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{route('dompet.edit', $dompet->id)}}" class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-50 text-gray-400 hover:bg-blue-50 hover:text-blue-600 transition-all">
                            <i class="fas fa-edit text-xs"></i>
                        </a>
                        <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-50 text-gray-400 hover:bg-red-50 hover:text-red-600 transition-all" onclick="openDeleteModal('{{route('dompet.delete', $dompet->id)}}')">
                            <i class="fas fa-trash-alt text-xs"></i>
                        </button>
                    </div>
                </div>
                <div class="relative z-10">
                    <h4 class="text-lg font-black text-gray-800 tracking-tight">{{ $dompet->nama }}</h4>
                    <div class="flex justify-between items-end">
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase">Saldo Saat Ini</p>
                            <p class="text-2xl font-black text-emerald-600 tracking-tighter italic">Rp. {{$dompet->total}}</p>
                            @if($dompet->aktif == "1")
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-100 text-emerald-600 text-[10px] font-bold uppercase tracking-widest">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    Aktif
                                </span>
                            @elseif($dompet->aktif == "0")
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-50 border border-slate-200 text-slate-500 text-[10px] font-bold uppercase tracking-widest">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                                    Tidak Aktif
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="absolute -right-6 -top-6 w-32 h-32 bg-blue-50 opacity-50 rounded-full group-hover:scsale-110 transition-transform duration-500"></div>
            </div>
        @endforeach
        @endif
        </div>

    </div>
</main>

@include('dompet._delete')

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
        </script>

        <script>
            function closeToast(id) {
                const toast = document.getElementById(id);
                if (toast) {
                    toast.classList.remove('translate-x-0', 'opacity-100');
                    toast.classList.add('translate-x-full', 'opacity-0');

                    setTimeout(() => {
                        toast.style.display = 'none';
                    }, 500);
                }
            }

            document.addEventListener("DOMContentLoaded", function() {
                const toasts = ['toast-success', 'toast-error', 'toast-validation'];

                toasts.forEach(id => {
                    const el = document.getElementById(id);
                    if (el) {
                        setTimeout(() => {
                            closeToast(id);
                        }, 4000);
                    }
                });
            });
        </script>
@endsection
