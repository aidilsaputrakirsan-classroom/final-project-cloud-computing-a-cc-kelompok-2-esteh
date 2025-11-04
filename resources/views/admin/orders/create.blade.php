@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Buat Pesanan Baru</h3>

    <form action="{{ route('admin.orders.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>User ID (sementara manual dulu)</label>
            <input type="number" name="user_id" class="form-control" required>
        </div>

        <h5>Pilih Produk</h5>

        @foreach ($products as $product)
        <div class="d-flex align-items-center mb-2">
            <span class="me-3" style="width:150px">{{ $product->name }}</span>
            <input type="number" name="items[{{ $product->id }}]" min="0" placeholder="Qty" class="form-control" style="width:100px">
        </div>
        @endforeach

        <button class="btn btn-primary mt-3">Buat Pesanan</button>
    </form>
</div>
@endsection
