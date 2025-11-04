<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Keranjang Belanja
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-6">
        <div class="bg-white p-6 rounded shadow">
            @if($items->count() > 0)
                @foreach($items as $item)
                    <div class="border-b py-2 flex justify-between">
                        <span>{{ $item->product->name }} (x{{ $item->quantity }})</span>
<form action="{{ route('cart.remove', $item->id) }}" method="POST" onsubmit="return confirm('Hapus item ini dari keranjang?')">
    @csrf
    @method('DELETE')
    <button type="submit" class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700">
        Hapus
    </button>
</form>

                    </div>
                @endforeach

                <a href="{{ route('cart.checkout') }}" 
                   class="mt-4 block bg-green-600 text-white text-center py-2 rounded hover:bg-green-700">
                    Checkout
                </a>

            @else
                <p class="text-gray-500 text-center">Keranjang kosong</p>
            @endif
        </div>
    </div>
</x-app-layout>
