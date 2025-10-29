<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pesanan Saya</h2>
    </x-slot>

```
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">

            {{-- Jika belum ada pesanan sama sekali --}}
            @if($orders->isEmpty())
                <p class="text-gray-600 text-center py-6">Pesanan tidak ada.</p>
            @else
                {{-- Loop semua pesanan yang dimiliki user --}}
                @foreach($orders as $order)
                    {{-- Pastikan hanya tampilkan pesanan yang punya item --}}
                    @if($order->items->isNotEmpty())
                        <h3 class="font-bold mt-4 mb-2">
                            Pesanan #{{ $order->id }} ({{ ucfirst($order->status) }})
                        </h3>
                        <ul>
                            @foreach($order->items as $item)
                                <li class="mb-2">
                                    {{ $item->product->name }} - 
                                    {{ $item->quantity }} x Rp {{ number_format($item->price,0,',','.') }}

                                    {{-- Form Update --}}
                                    <form action="{{ route('orders.update', $item) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="border px-1 w-16">
                                        <button type="submit" class="bg-blue-500 text-white px-2 rounded hover:bg-blue-600 transition">Update</button>
                                    </form>

                                    {{-- Form Hapus --}}
                                    <form action="{{ route('orders.destroy', $item) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus item ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-2 rounded hover:bg-red-600 transition">Hapus</button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                @endforeach

                {{-- Kalau semua pesanan tidak memiliki item --}}
                @if($orders->every(fn($o) => $o->items->isEmpty()))
                    <p class="text-gray-600 text-center py-6">Pesanan tidak ada.</p>
                @endif
            @endif

        </div>
    </div>
</div>
```

</x-app-layout>
