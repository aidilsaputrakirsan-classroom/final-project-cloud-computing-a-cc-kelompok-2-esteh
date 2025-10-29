<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pesanan Saya</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">

                @if($orders->count())
                    @foreach($orders as $order)
                        <h3 class="font-bold mt-4 mb-2">Pesanan #{{ $order->id }} ({{ $order->status }})</h3>
                        <ul>
                            @foreach($order->items as $item)
                                <li class="mb-2">
                                    {{ $item->product->name }} - {{ $item->quantity }} x Rp {{ number_format($item->price,0,',','.') }}

                                    <form action="{{ route('orders.update', $item) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="border px-1 w-16">
                                        <button type="submit" class="bg-blue-500 text-white px-2 rounded">Update</button>
                                    </form>

                                    <form action="{{ route('orders.destroy', $item) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-2 rounded">Hapus</button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    @endforeach
                @else
                    <p>Belum ada pesanan.</p>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
