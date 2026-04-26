<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $summary = [
            'title' => 'Ringkasan Finansial',
            'subtitle' => 'Kelola keuanganmu dengan bijak.',
            'main_balance' => 'Rp 82.450.000',
            'main_wallet' => 'Dompet Utama',
            'main_status' => 'Aktif',
            'saving_target' => 'Rencanakan pembelian aset digital atau liburanmu sekarang.',
            'allocation_total' => 'Rp 8.4jt',
        ];

        $wallets = [
            [
                'name' => 'Dompet Utama',
                'amount' => 'Rp 12.220.000',
                'change' => '8.2% dari bulan lalu',
                'icon' => 'fa-wallet',
                'icon_bg' => 'bg-blue-50',
                'icon_color' => 'text-blue-500',
            ],
            [
                'name' => 'Dompet Belanja',
                'amount' => 'Rp 25.070.000',
                'change' => '12.5% dari bulan lalu',
                'icon' => 'fa-cart-shopping',
                'icon_bg' => 'bg-orange-50',
                'icon_color' => 'text-orange-500',
            ],
            [
                'name' => 'Kas Tunai',
                'amount' => 'Rp 570.000',
                'change' => '2.4% dari bulan lalu',
                'icon' => 'fa-money-bill-wave',
                'icon_bg' => 'bg-emerald-50',
                'icon_color' => 'text-emerald-500',
            ],
            [
                'name' => 'Investasi',
                'amount' => 'Rp 2.680.000',
                'change' => '15.1% dari bulan lalu',
                'icon' => 'fa-chart-line',
                'icon_bg' => 'bg-violet-50',
                'icon_color' => 'text-violet-500',
            ],
        ];

        $transactions = [
            [
                'date' => 'Hari ini',
                'title' => 'Belanja Makan Siang',
                'category' => 'Makan',
                'amount' => '- Rp 55.000',
                'amount_color' => 'text-red-500',
                'badge' => 'bg-orange-50 text-orange-500',
                'icon' => 'fa-utensils',
                'icon_bg' => 'bg-emerald-50',
                'icon_color' => 'text-emerald-500',
            ],
            [
                'date' => 'Hari ini',
                'title' => 'Biaya Transport',
                'category' => 'Transport',
                'amount' => '- Rp 260.000',
                'amount_color' => 'text-red-500',
                'badge' => 'bg-blue-50 text-blue-500',
                'icon' => 'fa-car-side',
                'icon_bg' => 'bg-blue-50',
                'icon_color' => 'text-blue-500',
            ],
            [
                'date' => 'Kemarin',
                'title' => 'Pemasukan Gaji',
                'category' => 'Gaji',
                'amount' => '+ Rp 9.500.000',
                'amount_color' => 'text-emerald-500',
                'badge' => 'bg-emerald-50 text-emerald-500',
                'icon' => 'fa-wallet',
                'icon_bg' => 'bg-emerald-50',
                'icon_color' => 'text-emerald-500',
            ],
            [
                'date' => '20 Apr',
                'title' => 'Belanja Online',
                'category' => 'Belanja',
                'amount' => '- Rp 180.000',
                'amount_color' => 'text-red-500',
                'badge' => 'bg-red-50 text-red-500',
                'icon' => 'fa-bag-shopping',
                'icon_bg' => 'bg-violet-50',
                'icon_color' => 'text-violet-500',
            ],
        ];

        $allocations = [
            ['label' => 'Makan', 'percent' => 25, 'amount' => 'Rp 2,1jt', 'color' => '#f59e0b'],
            ['label' => 'Transport', 'percent' => 20, 'amount' => 'Rp 1,7jt', 'color' => '#6366f1'],
            ['label' => 'Belanja', 'percent' => 30, 'amount' => 'Rp 2,5jt', 'color' => '#ef4444'],
            ['label' => 'Gaji', 'percent' => 25, 'amount' => 'Rp 2,1jt', 'color' => '#10b981'],
        ];

        return view('Dashboard', compact('summary', 'wallets', 'transactions', 'allocations'));
    }
}
