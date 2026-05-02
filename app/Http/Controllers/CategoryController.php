<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Kategori;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        $title = 'Kategori';
        $subtitle = 'Halaman Kategori';

        $id = Auth::id();
        $category = Kategori::where('user_id', $id)->get();
        return view('category.index', compact('title', 'subtitle', 'category'));
    }

    public function create() {
        $title = 'Kategori';
        $subtitle = 'Halaman Kategori';

        return view('category.create', compact('title', 'subtitle'));
    }

   public function store(Request $request,) 
    {
        $validated = $request->validate([ 
            'nama' => ['required', 'string', 'max:255'],
            'tipe' => ['required', \Illuminate\Validation\Rule::in(['pemasukan', 'pengeluaran'])]
        ]);

        try {
            Kategori::create([
                'nama' => $validated['nama'],
                'tipe' => $validated['tipe'],
                'user_id' => Auth::id()
            ]);
            return redirect()
                    ->route('category.index')
                    ->with('success', 'Kategori ' . $request->nama . ' berhasil disimpan!');
        } catch (\Exception $e) {
            return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function edit($id){
        $title = 'Kategori';
        $subtitle = 'Halaman Kategori';

        $category = Kategori::where('id', $id)
        ->where('user_id', Auth::id())
        ->firstOrFail();

        return view('category.edit', compact('title', 'subtitle', 'category'));
    }

    public function update(Request $request, $id) {
        $validated = $request->validate([ 
            'nama' => ['required', 'string'],
            'tipe' => ['required', Rule::in('pemasukan', 'pengeluaran')]
         ]);

        try {
             $update = DB::table('kategori')->where('id', $id)->update([
                'nama' => $request->nama,
                'tipe' => $request->tipe
            ]);

          return redirect()
                    ->route('category.index',)
                    ->with('success', 'Kategori berhasil diedit!');
        }catch(\Exception $e) {
               return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
       
    }

    public function destroy($id) {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return redirect()->back()->with('success', 'data berhasil di hapus');
    }
}
