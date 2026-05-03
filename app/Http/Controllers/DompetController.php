<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dompet;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class DompetController extends Controller
{
    public function index()
    {
        $title = "Dompet";
        $subtitle = "Halaman Dompet";

        $dompet = Dompet::where("user_id", Auth::id())->get();

        $total = $dompet->sum("total");
        $hitung = $dompet->count();
        return view(
            "dompet.index",
            compact("dompet", "title", "subtitle", "total", "hitung"),
        );
    }

    public function create()
    {
        $title = "Dompet";
        $subtitle = "Tambah Dompet";

        return view("dompet.create", compact("title", "subtitle"));
    }

    public function store(Request $request)
    {
        $request->validate([
            "nama" => "required|string|max:255",
            "total" => "required|int",
            "aktif" => "required|boolean",
        ]);

        try {
            Dompet::create([
                "nama" => $request->nama,
                "total" => $request->total,
                "aktif" => $request->aktif,
                "user_id" => Auth::id(),
            ]);

            return redirect()
                ->route("dompet.index")
                ->with(
                    "success",
                    "Berhasil Menambahkan Dompet " . $request->nama,
                );
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with("error", "Terjadi kesalahan saat menyimpan data.");
        }
    }

    public function edit($id)
    {
        $title = "Dompet";
        $subtitle = "Halaman Dompet";

        $dompet = Dompet::where("id", $id)->first();
        return view("dompet.edit", compact("title", "subtitle", "dompet"));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            "nama" => "required|string|max:255",
            "total" => "required|int",
            "aktif" => "required|boolean",
        ]);

        try {
            $dompet = Dompet::findOrFail($id);
            $dompet->update($data);

            return redirect()
                ->route("dompet.index")
                ->with(
                    "success",
                    "Berhasil Memperbarui Dompet " . $dompet->nama,
                );
        } catch (\Throwable $th) {
            return back()
                ->withinput()
                ->with(
                    "error",
                    "Terjadi Keasalahan Saat Memperbarui Dompet " .
                        $dompet->nama,
                );
        }
    }

    public function delete($id)
    {
        $nama = Dompet::where("id", $id)->get("nama");
        $dompet = Dompet::findOrFail($id)->delete();
        return redirect()
            ->route("dompet.index")
            ->with("success", "berhasil menghapus dompet " . $nama);
    }
}
