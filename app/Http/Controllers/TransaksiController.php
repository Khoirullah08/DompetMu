<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Dompet;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TransaksiController extends Controller
{
    public function index()
    {   
        $title = 'Transaksi';
        $subtitle = 'Halaman Transaksi';

        $transaksi = Transaksi::with(['dompet', 'kategori'])
            ->where('user_id', Auth::id())
            ->orderByDesc('tanggal')
            ->get();
 
        return view('transaksi.index', compact('title', 'subtitle', 'transaksi'));
    }

    public function create ()
    {
        $title = 'Transaksi';
        $subtitle = 'Halaman Transaksi';

        $dompet = Dompet::where('user_id', Auth::id())->get();
        $kategori = Kategori::where('user_id', Auth::id())->get();

        return view('transaksi.create', compact('title', 'subtitle', 'dompet', 'kategori'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'dompet_id' => ['required', 'exists:dompet,id'],
            'kategori_id' => ['required', 'exists:kategori,id'],
            'tipe' => ['required', Rule::in(['pemasukan', 'pengeluaran'])],
            'jumlah' => ['required', 'integer'],
            'catatan' => ['nullable', 'string', 'max:255'],
            'tanggal' => ['required', 'date'],
        ]);
        
       try {
        DB::transaction(function () use ($validated) {
            // Simpan transaksi
            Transaksi::create([
                ...$validated,
                'user_id' => Auth::id(),
            ]);
            // update saldo dompet
            $dompet = Dompet::findOrFail($validated['dompet_id']);

            if ($validated['tipe'] === 'pemasukan'){
                $dompet->increment('total', $validated['jumlah']);
            } else {
                $dompet->decrement('total', $validated['jumlah']);
            }
        });

        } catch (\Exception $e) {
             return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan transaksi.');
        }

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil ditambahkan.');

        }

    public function edit($id)
        {
            $title = 'Transaksi';
            $subtitle = 'Halaman Transaksi';

            $transaksi = Transaksi::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $dompet = Dompet::where('user_id', Auth::id())->get();
            $kategori = Kategori::where('user_id', Auth::id())->get();

            return view('transaksi.edit', compact('title', 'subtitle', 'transaksi', 'dompet', 'kategori'));
     }

    public function update(Request $request, $id)
        {
            $transaksi = Transaksi::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $validated = $request->validate([
                'dompet_id' => ['required', 'exists:dompet,id'],
                'kategori_id' => ['required', 'exists:kategori,id'],
                'tipe' => ['required', Rule::in(['pemasukan', 'pengeluaran'])],
                'jumlah' => ['required', 'integer'],
                'catatan' => ['nullable', 'string', 'max:255'],
                'tanggal' => ['required', 'date'],  
            ]);

            try {
                DB::transaction(function () use ($transaksi, $validated) {
                    // balikan transaksi lama ke dompet
                    $dompetLama = Dompet::findOrFail($transaksi->dompet_id);
                    if ($transaksi->tipe === 'pemasukan'){
                        $dompetLama->decrement('total', $transaksi->jumlah);
                    } else {
                        $dompetLama->increment('total', $transaksi->jumlah);
                    }
                    // update transaksi
                    $transaksi->update($validated);

                    // update transaksi dompet baru
                    $dompetBaru = Dompet::findOrFail($validated['dompet_id']);
                    if ($validated['tipe'] === 'pemasukan'){
                        $dompetBaru->increment('total', $validated['jumlah']);
                    } else {
                        $dompetBaru->decrement('total', $validated['jumlah']);    
                    }
                    });
  
            } catch (\Exception $e) {
                return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui transaksi.');
                 }
            return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diperbarui.');
        }

    public function destroy($id)
        {
            $transaksi = Transaksi::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

                try {
                    DB::transaction(function () use ($transaksi){
                        if ($transaksi->tipe === 'pemasukan' ){
                            $transaksi->dompet->decrement('total', $transaksi->jumlah);
                        } else {
                            $transaksi->dompet->increment('total', $transaksi->jumlah);
                        }
                        $transaksi->delete();
                    });
                    
                } catch (\Exception $e) {
                    return redirect()
                    ->back()
                    ->with('error', 'Terjadi kesalahan saat menghapus transaksi.');
                }
            return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
        }
}
