<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dompet;
use App\Models\Transaksi;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $summary = [
            "title" => "Ringkasan Finansial",
            "subtitle" => "Kelola keuanganmu dengan bijak.",
            "main_balance" => "Rp 82.450.000",
            "main_wallet" => "Dompet Utama",
            "main_status" => "Aktif",
            "saving_target" =>
                "Rencanakan pembelian aset digital atau liburanmu sekarang.",
        ];

        $dompets = Dompet::where("user_id", Auth::id())
            ->where("aktif", 1)
            ->get();

        $iconsDompet = [
            [
                "icon" => "fa-wallet",
                "icon_bg" => "bg-blue-50",
                "icon_color" => "text-blue-500",
            ],
            [
                "icon" => "fa-cart-shopping",
                "icon_bg" => "bg-orange-50",
                "icon_color" => "text-orange-500",
            ],
            [
                "icon" => "fa-money-bill-wave",
                "icon_bg" => "bg-emerald-50",
                "icon_color" => "text-emerald-500",
            ],
            [
                "icon" => "fa-chart-line",
                "icon_bg" => "bg-violet-50",
                "icon_color" => "text-violet-500",
            ],
        ];

        $wallets = $dompets->map(function ($item) use ($iconsDompet) {
            $randomIcons = collect($iconsDompet)->random();

            return [
                "id" => $item->id,
                "nama" => $item->nama,
                "total" => $item->total,
                "updated_at" => $item->updated_at,
                "icon" => $randomIcons["icon"],
                "icon_bg" => $randomIcons["icon_bg"],
                "icon_color" => $randomIcons["icon_color"],
            ];
        });

        $transaksi = Transaksi::where("user_id", Auth::id())->get();

        $transactionAsset = [
            [
                "badge" => "bg-orange-50 text-orange-500",
                "icon" => "fa-utensils",
                "icon_bg" => "bg-emerald-50",
                "icon_color" => "text-emerald-500",
            ],
            [
                "badge" => "bg-blue-50 text-blue-500",
                "icon" => "fa-car-side",
                "icon_bg" => "bg-blue-50",
                "icon_color" => "text-blue-500",
            ],
            [
                "badge" => "bg-emerald-50 text-emerald-500",
                "icon" => "fa-wallet",
                "icon_bg" => "bg-emerald-50",
                "icon_color" => "text-emerald-500",
            ],
            [
                "badge" => "bg-red-50 text-red-500",
                "icon" => "fa-bag-shopping",
                "icon_bg" => "bg-violet-50",
                "icon_color" => "text-violet-500",
            ],
        ];

        $transactions = $transaksi->map(function ($item) use (
            $transactionAsset,
        ) {
            $icons = collect($transactionAsset)->random();
            $nama = Kategori::where("id", $item->kategori_id)->first("nama");
            $flag = "";
            $color = "";
            if ($item->tipe == "pengeluaran") {
                $flag = "-";
                $color = "text-red-500";
            } else {
                $flag = "+";
                $color = "text-emerald-500";
            }
            return [
                "date" => $item->tanggal,
                "title" => $item->catatan,
                "category" => $nama->nama,
                "amount" => $flag . "" . $item->jumlah,
                "amount_color" => $color,
                "badge" => $icons["badge"],
                "icon" => $icons["icon"],
                "icon_bg" => $icons["icon_bg"],
                "icon_color" => $icons["icon_color"],
            ];
        });

        // "label" => "Makan",
        // "percent" => 25,
        // "amount" => "Rp 2,1jt",

        $chart = Transaksi::where("user_id", Auth::id())->get([
            "kategori_id",
            "jumlah",
        ]);

        $total = $chart->sum("jumlah");

        $summary["allocation_total"] = "Rp " . $total;

        $colorAlocations = [
            [
                "color" => "#f59e0b",
            ],
            [
                "color" => "#6366f1",
            ],
            [
                "color" => "#ef4444",
            ],
            [
                "color" => "#10b981",
            ],
        ];

        $allocations = $chart->map(function ($items) use (
            $colorAlocations,
            $total,
        ) {
            $color = collect($colorAlocations)->random();

            $label = Kategori::where("id", $items->kategori_id)->first();
            $percent = round(($items->jumlah / $total) * 100);
            return [
                "label" => $label->nama,
                "percent" => $percent,
                "amount" => $items->jumlah,
                "color" => $color["color"],
            ];
        });

        return view(
            "Dashboard",
            compact("summary", "wallets", "transactions", "allocations"),
        );
    }
}
