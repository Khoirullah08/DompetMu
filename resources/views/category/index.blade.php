@extends('layouts.layout')

@section('header', $title)
@section('subheader', $subtitle)


@section('content')
<main class="px-4 pb-6 pt-5 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl space-y-6">
        <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" href="{{route('category.create')}}">Tambah Kategori</a>
       <table id="CategoryTable" class="display">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Type</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
               @php
                    $i = 1;
               @endphp
                @foreach($category as $c)
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{$c->nama}}</td>
                    <td>{{$c->tipe}}</td>
                    <td>x</td>
                </tr>
                @endforeach
            </tbody>
        </table>
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