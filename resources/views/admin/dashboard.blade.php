@extends('layouts.layout')

@section('title', 'Admin Panel - SakuPintar')

@section('styles')
<link rel="stylesheet" href="{{asset('asset/css/admin.css')}}"></style>
@endsection

@section('content')
<div class="admin-wrap">
    <div class="admin-body">

        {{-- Page Heading --}}
        <div>
            <div class="page-title">Selamat datang kembali</div>
            <div class="page-sub">Pantau dan kelola data pengguna di SakuPintar</div>
        </div>

        {{-- Stat Cards --}}
        <div class="cards">

            {{-- Total User --}}
            <div class="stat-card">
                <div class="icon-box icon-teal">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <circle cx="10" cy="6" r="3.5" stroke="#0b6b5b" stroke-width="1.5"/>
                        <path d="M3 17c0-3.314 3.134-6 7-6s7 2.686 7 6" stroke="#0b6b5b" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                </div>
                <div>
                    <div class="card-label">Total User</div>
                    <div class="card-val" data-count="{{ $totalUsers }}">{{ $totalUsers }}</div>
                    <div class="card-sub-teal">↑ aktif semua</div>
                </div>
            </div>

            {{-- New Users --}}
            <div class="stat-card">
                <div class="icon-box icon-blue">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <circle cx="9" cy="6" r="3" stroke="#185fa5" stroke-width="1.5"/>
                        <path d="M2 17c0-3 3-5.5 7-5.5" stroke="#185fa5" stroke-width="1.5" stroke-linecap="round"/>
                        <path d="M15 11v6M12 14h6" stroke="#185fa5" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                </div>
                <div>
                    <div class="card-label">New Users Bulan Ini</div>
                    <div class="card-val" data-count="{{ $newUsers }}">{{ $newUsers }}</div>
                    <div class="card-sub-blue">↑ pendaftar baru</div>
                </div>
            </div>

            {{-- Total Admin --}}
            <div class="stat-card">
                <div class="icon-box icon-amber">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M10 2l2.5 5 5.5.8-4 3.9.9 5.5L10 14.5 5.1 17.2l1-5.5L2 7.8 7.5 7z" stroke="#ba7517" stroke-width="1.5" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div>
                    <div class="card-label">Total Admin</div>
                    <div class="card-val" data-count="{{ $users->where('role', 'admin')->count() }}">{{ $users->where('role', 'admin')->count() }}</div>
                    <div class="card-sub-amber">hak akses penuh</div>
                </div>
            </div>

        </div>

        {{-- Charts --}}
        <div class="mid-row">

            {{-- Growth Chart --}}
            <div class="panel">
                <div class="panel-title">Pertumbuhan Pengguna (6 Bulan)</div>
                <div class="legend-row">
                    <span><span class="leg-dot" style="background:#0b8a6e"></span>Pendaftar baru</span>
                    <span><span class="leg-dot" style="background:#9fe1cb"></span>Kumulatif</span>
                </div>
                <div class="chart-wrap">
                <canvas id="growthChart"
                    role="img"
                    aria-label="Grafik pertumbuhan pengguna 6 bulan terakhir"
                    data-monthly='@json($monthlyGrowth ?? [])'
                    data-cumulative='@json($cumulativeGrowth ?? [])'
                    data-labels='@json($growthLabels ?? [])'>
                </canvas>
                </div>
            </div>

            {{-- Role Distribution --}}
            <div class="panel">
                <div class="panel-title">Distribusi Role</div>
                <div class="legend-row">
                    <span><span class="leg-dot" style="background:#0b8a6e"></span>User</span>
                    <span><span class="leg-dot" style="background:#fac775"></span>Admin</span>
                </div>
                <div class="chart-wrap">
                 <canvas id="roleChart"
                    role="img"
                    aria-label="Distribusi role pengguna"
                    data-user='{{ $users->where("role", "users")->count() }}'
                    data-admin='{{ $users->where("role", "admin")->count() }}'>
                </canvas>
                </div>
            </div>

        </div>

        {{-- User Table --}}
        <div class="table-section">

            <div class="table-header">
                <div>
                    <div class="table-title">Daftar Pengguna</div>
                    <div class="table-meta">{{ $totalUsers }} pengguna terdaftar</div>
                </div>
                <div class="controls">
                    <div class="search-wrap">
                        <svg viewBox="0 0 16 16" fill="none" stroke="currentColor">
                            <circle cx="7" cy="7" r="4.5" stroke-width="1.5"/>
                            <path d="M10.5 10.5L13 13" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                        <input type="text" id="searchInput" placeholder="Cari nama / email..." oninput="renderTable()">
                    </div>
                </div>
            </div>

            <table class="users-table">
                <thead>
                    <tr>
                        <th style="width:48px">No</th>
                        <th style="width:220px">Pengguna</th>
                        <th>Email</th>
                        <th style="width:120px">Bergabung</th>
                        <th style="width:90px">Role</th>
                    </tr>
                </thead>
                <tbody id="userTbody"></tbody>
            </table>

            <div id="emptyState" class="empty-state" style="display:none">
                Tidak ada pengguna ditemukan.
            </div>

            <div class="pager">
                <span id="pagerInfo"></span>
                <div class="pager-btns" id="pagerBtns"></div>
            </div>

        </div>

</div>{{-- /.admin-body --}}
</div>{{-- /.admin-wrap --}}

@endsection


@section('scripts')
<script>
   window.USERS_DATA = @json($usersJson);
</script>
<script src="{{ asset('asset/js/admin.js') }}"></script>
@endsection