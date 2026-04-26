@extends('layouts.layout')

@section('header', $title)
@section('subheader', $subtitle)


@section('content')
<main class="px-4 pb-6 pt-5 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl space-y-6">
       <form action="#" method="POST">
        @csrf
        
        <label for="nama">Nama Kategori</label>
        <input type="text" placeholder="Masukan Nama Kategori">

        <label for="tipe">Tipe Kategori</label>
        <select name="tipe" id="tipe">
            <option value="pemasukan">Volvo</option>
            <option value="pengeluaran">Saab</option>
        </select>

        <button type="submit">Simpan</button>
       </form>
    </div>
</main>
@endsection

@section('scripts')
<script>
    let table = new DataTable('#CategoryTable', {
        responsive: true
    });
</script>
@endsection