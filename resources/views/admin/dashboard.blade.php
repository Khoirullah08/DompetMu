@extends('layouts.layout')

@section('title', 'Admin Panel - SakuPintar')

@section('styles')
<style>
    .stat-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 12px 35px rgba(15, 23, 42, 0.07);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 16px 40px rgba(15, 23, 42, 0.11);
    }
</style>
@endsection

@section('content')
<div class="p-6 max-w-6xl mx-auto">

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold" style="color: var(--text-main)">Admin Panel</h1>
        <p class="text-gray-400 text-sm mt-1">Pantau dan kelola data pengguna SakuPintar</p>
    </div>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">

        {{-- Total User --}}
        <div class="stat-card px-6 py-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(11,107,91,0.1)">
                <i class="fa-solid fa-users text-lg" style="color: var(--brand)"></i>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-medium">Total User</p>
                <p class="text-2xl font-bold" style="color: var(--text-main)">{{ $totalUsers }}</p>
            </div>
        </div>

        {{-- User Bulan Ini --}}
        <div class="stat-card px-6 py-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(59,130,246,0.1)">
                <i class="fa-solid fa-user-plus text-lg text-blue-500"></i>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-medium">User Bulan Ini</p>
                <p class="text-2xl font-bold" style="color: var(--text-main)">{{ $newUsers }}</p>
            </div>
        </div>

        {{-- Total Admin --}}
        <div class="stat-card px-6 py-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(234,179,8,0.1)">
                <i class="fa-solid fa-shield-halved text-lg text-yellow-500"></i>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-medium">Total Admin</p>
                <p class="text-2xl font-bold" style="color: var(--text-main)">
                    {{ $users->where('role', 'admin')->count() }}
                </p>
            </div>
        </div>

    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl overflow-hidden" style="box-shadow: 0 12px 35px rgba(15,23,42,0.07)">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h2 class="font-semibold" style="color: var(--text-main)">Daftar User</h2>
                <p class="text-xs text-gray-400 mt-0.5">{{ $totalUsers }} pengguna terdaftar</p>
            </div>
        </div>

        <div class="p-6">
            <table id="usersTable" class="w-full text-sm">
                <thead>
                    <tr class="text-left">
                        <th class="pb-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">#</th>
                        <th class="pb-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Nama</th>
                        <th class="pb-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Email</th>
                        <th class="pb-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Bergabung</th>
                        <th class="pb-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Role</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($users as $index => $user)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 text-gray-400">{{ $index + 1 }}</td>
                        <td class="py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0"
                                     style="background: var(--brand)">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <span class="font-medium" style="color: var(--text-main)">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="py-3 text-gray-500">{{ $user->email }}</td>
                        <td class="py-3 text-gray-400">{{ $user->created_at->format('d M Y') }}</td>
                        <td class="py-3">
                            @if ($user->role === 'admin')
                                <span class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-full"
                                      style="background: rgba(11,107,91,0.1); color: var(--brand)">
                                    <i class="fa-solid fa-shield-halved text-xs"></i> Admin
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-full bg-gray-100 text-gray-500">
                                    <i class="fa-solid fa-user text-xs"></i> User
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center text-gray-400">
                            <i class="fa-solid fa-users-slash text-3xl mb-3 block"></i>
                            Belum ada user terdaftar.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#usersTable').DataTable({
            language: {
                search:     "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info:       "Menampilkan _START_ - _END_ dari _TOTAL_ user",
                paginate: {
                    previous: "‹",
                    next:     "›"
                },
                emptyTable:  "Tidak ada data tersedia",
                zeroRecords: "User tidak ditemukan"
            },
            pageLength: 10,
            order: [[0, 'asc']],
        });
    });
</script>
@endsection