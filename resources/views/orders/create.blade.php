@extends('layout')

@section('content')
<h2>Buat Pesanan</h2>
<form action="{{ route('orders.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Nama Customer</label>
        <input type="text" name="customer_name" class="form-control" value="{{ auth()->user()->name }}" required>
    </div>
    <h4>Pilih Produk</h4>
    @foreach($products as $product)
    <div class="mb-2">
        <label>{{ $product->name }} (Rp {{ $product->price }})</label>
        <input type="number" name="products[{{ $product->id }}]" value="0" min="0" class="form-control" style="width:100px;">
    </div>
    @endforeach
    <button class="btn btn-success">Pesan</button>
</form>
@endsection
