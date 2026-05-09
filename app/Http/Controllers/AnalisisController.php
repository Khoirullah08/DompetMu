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

        $query = Transaksi::where("user_id", Auth::id())
        ->whereYear('tanggal', $tahun);

        if ($bulan !== 'semua') {
            $query->whereMonth('tanggal', $bulan);
        }

        $transaksi = $query->get();

        //summary 
        $totalPemasukan = $transaksi->where('tipe', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = $transaksi->where('tipe', 'pengeluaran')->sum('jumlah');
        $saldoBersih = $totalPemasukan - $totalPengeluaran;
        
        //income vs expense 
        $bulanLabels = [];
        $datapemassukan = [];
        $datapengeluaran = [];

       for ($m = 1; $m <= 12; $m++) {
            $bulanLabels[]     = Carbon::create()->month($m)->locale('id')->monthName;
            $dataPemasukan[]   = Transaksi::where('user_id', Auth::id())
                ->whereYear('tanggal', $tahun)
                ->whereMonth('tanggal', $m)
                ->where('tipe', 'pemasukan')
                ->sum('jumlah');
            $dataPengeluaran[] = Transaksi::where('user_id', Auth::id())
                ->whereYear('tanggal', $tahun)
                ->whereMonth('tanggal', $m)
                ->where('tipe', 'pengeluaran')
                ->sum('jumlah');
        }
        $kategoriData = $transaksi->whereIn('tipe', ['pengeluaran', 'pemasukan'])
            ->groupBy(fn($t) => $t->kategori->nama?? 'Lainnya')
            ->map(fn($group) => $group->sum('jumlah'))
            ->sortDesc();

        $kategoriLabels = $kategoriData->keys()->Values()->toArray();
        $kategoriValues = $kategoriData->values()->toArray();

        // top kategori 
        $topKategori = $kategoriData;

        // filter 
        $tahunPertama = Transaksi::where('user_id', Auth::id())->min('tanggal');
        $tahunAwal    = $tahunPertama ? Carbon::parse($tahunPertama)->year : now()->year;
        $daftarTahun  = range(now()->year, $tahunAwal);

        // filter
        if ($request->ajax()) {
            return response()->json([
                'totalPemasukan'   => $totalPemasukan,
                'totalPengeluaran' => $totalPengeluaran,
                'saldoBersih'      => $saldoBersih,
                'dataPemasukan'    => array_values($dataPemasukan),
                'dataPengeluaran'  => array_values($dataPengeluaran),
                'bulanLabels'      => $bulanLabels,
                'kategoriLabels'   => $kategoriLabels,
                'kategoriValues'   => $kategoriValues,
                'topKategori'      => $topKategori,
            ]);
        }

        return view('analisis.index', compact(
            'title', 'subtitle',
            'tahun', 'bulan',
            'totalPemasukan', 'totalPengeluaran', 'saldoBersih',
            'bulanLabels', 'dataPemasukan', 'dataPengeluaran',
            'kategoriLabels', 'kategoriValues',
            'topKategori', 'daftarTahun'
        ));
    }
}
