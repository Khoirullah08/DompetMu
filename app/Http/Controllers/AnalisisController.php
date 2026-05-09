<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AnalisisController extends Controller
{
    public function index(Request $request)
    {
        $title = "Analisis";
        $subtitle = "Halaman Analisis";

        $bulan = $request->get('bulan', 'semua');
        $tahun = $request ->get('tahun', Carbon::now()->year);

        $data = $this->getData($tahun, $bulan,);

            if ($request->ajax()) {
            return response()->json($data);
        }

        // filter 
        $tahunPertama = Transaksi::where('user_id', Auth::id())->min('tanggal');
        $tahunAwal    = $tahunPertama ? Carbon::parse($tahunPertama)->year : now()->year;
        $daftarTahun  = range(now()->year, $tahunAwal);

          return view('analisis.index', array_merge($data, compact(
            'title', 'subtitle', 'tahun', 'bulan', 'daftarTahun'
        )));
    }

    private function getData($tahun, $bulan)
    {
    
        $query = Transaksi::where('user_id', Auth::id())
            ->whereYear('tanggal', $tahun);
 
        if ($bulan !== 'semua') {
            $query->whereMonth('tanggal', $bulan);
        }
 
        $transaksi = $query->with('kategori')->get();
 
        // Summary 
        $totalPemasukan   = $transaksi->where('tipe', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = $transaksi->where('tipe', 'pengeluaran')->sum('jumlah');
        $saldoBersih      = $totalPemasukan - $totalPengeluaran;
 
       
        if ($bulan === 'semua') {
            
            $bulanLabels     = [];
            $dataPemasukan   = [];
            $dataPengeluaran = [];
 
            for ($m = 1; $m <= 12; $m++) {
                $bulanLabels[]     = Carbon::create()->month($m)->locale('id')->monthName;
                $dataPemasukan[]   = (int) Transaksi::where('user_id', Auth::id())
                    ->whereYear('tanggal', $tahun)
                    ->whereMonth('tanggal', $m)
                    ->where('tipe', 'pemasukan')
                    ->sum('jumlah');
                $dataPengeluaran[] = (int) Transaksi::where('user_id', Auth::id())
                    ->whereYear('tanggal', $tahun)
                    ->whereMonth('tanggal', $m)
                    ->where('tipe', 'pengeluaran')
                    ->sum('jumlah');
            }
        } else {
            // filter bulan => minggu
            $bulanLabels     = ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'];
            $dataPemasukan   = [0, 0, 0, 0];
            $dataPengeluaran = [0, 0, 0, 0];
 
            foreach ($transaksi as $t) {
                $hari   = Carbon::parse($t->tanggal)->day;
                $minggu = min((int) ceil($hari / 7), 4) - 1;
 
                if ($t->tipe === 'pemasukan') {
                    $dataPemasukan[$minggu] += $t->jumlah;
                } else {
                    $dataPengeluaran[$minggu] += $t->jumlah;
                }
            }
 
            $dataPemasukan   = array_map('intval', $dataPemasukan);
            $dataPengeluaran = array_map('intval', $dataPengeluaran);
        }


        // pie chart kategori
        $kategoriData = $transaksi->whereIn('tipe', ['pengeluaran', 'pemasukan'])
            ->groupBy(fn($t) => optional($t->kategori)->nama ?? 'Lainnya')
            ->map(fn($group) => $group->sum('jumlah'))
            ->sortDesc();

        $kategoriLabels = $kategoriData->keys()->values()->toArray();
        $kategoriValues = $kategoriData->values()->map(fn($v) => (int) $v)->values()->toArray();

        // top kategori 
        $topKategori = $kategoriData;

        return compact(
            'totalPemasukan', 'totalPengeluaran', 'saldoBersih',
            'bulanLabels', 'dataPemasukan', 'dataPengeluaran',
            'kategoriLabels', 'kategoriValues', 'topKategori'
        );
    }
}
