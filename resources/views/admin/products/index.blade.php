@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Produk</h2>

    <a href="{{ route('admin.products.create') }}" class="btn btn-success mb-3">Tambah Produk</a>

    <table class="table table-bordered">
        <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Harga</th>
            <th>Gambar</th>
        </tr>

        @foreach ($products as $product)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $product->name }}</td>
            <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
            <td>
                @if($product->image)
                    <img src="{{ asset('storage/'.$product->image) }}" width="70">
                @else
                    -
                @endif
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
