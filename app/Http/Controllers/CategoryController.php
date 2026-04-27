<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Kategori;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        $title = 'Kategori';
        $subtitle = 'Halaman Kategori';

        $category = Kategori::all();
        return view('category.index', compact('title', 'subtitle', 'category'));
    }

    public function create() {
        $title = 'Kategori';
        $subtitle = 'Halaman Kategori';

        return view('category.create', compact('title', 'subtitle'));
    }

   public function store(Request $request) 
    {
        $validated = $request->validate([ 
            'nama' => ['required', 'string', 'max:255'],
            'tipe' => ['required', \Illuminate\Validation\Rule::in(['pemasukan', 'pengeluarans'])]
        ]);

        try {
            Kategori::create([
                'nama' => $validated['nama'],
                'tipe' => $validated['tipe']
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

    public function edit(){
        $title = 'Kategori';
        $subtitle = 'Halaman Kategori';

        $category = Category::findOrfail($id);

        return view('category.edit', compact('title', 'subtitle', 'category'));
    }

    public function update($id) {
        $validated = $request->validate([ 
            'nama' => ['required', 'string'],
            'tipe' => ['required', Rule::in('pemasukan', 'pengeluarans')]
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
