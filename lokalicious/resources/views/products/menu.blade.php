@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Daftar Produk Lokalicious</h1>

    @if(session('success'))
        <div class="bg-green-200 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach($products as $product)
            <div class="border rounded p-4 shadow">
                @if($product->image)
                    <img src="{{ asset('storage/'.$product->image) }}" class="w-full h-40 object-cover mb-2 rounded">
                @endif
                <h2 class="font-semibold text-lg">{{ $product->name }}</h2>
                <p class="text-gray-600">{{ $product->description }}</p>
                <p class="text-green-600 font-bold mt-2">Rp {{ number_format($product->price,0,',','.') }}</p>

                <form action="{{ route('orders.store') }}" method="POST" class="mt-2">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="number" name="quantity" value="1" min="1" class="w-16 border rounded px-2 py-1">
                    <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Pesan</button>
                </form>
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>
@endsection
