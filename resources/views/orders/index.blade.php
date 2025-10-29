<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pesanan Saya</h2>
    </x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">

            {{-- Notifikasi sukses --}}
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg flex justify-between items-center">
                    <span>{{ session('success') }}</span>
                    <button type="button" onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900">&times;</button>
                </div>
            @endif

            {{-- Daftar Pesanan --}}
            @if($orders->count())
                @foreach($orders as $order)
                    <h3 class="font-bold mt-4 mb-2">
                        Pesanan #{{ $order->id }} ({{ ucfirst($order->status) }})
                    </h3>
                    <ul>
                        @foreach($order->items as $item)
                            <li class="mb-3">
                                <div class="flex items-center gap-2">
                                    <span class="flex-1">
                                        {{ $item->product->name }} - {{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </span>

                                    {{-- Form update --}}
                                    <form action="{{ route('orders.update', $item) }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                                            class="border px-2 w-16 rounded">
                                        <button type="submit"
                                            class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded text-sm">
                                            Update
                                        </button>
                                    </form>

                                    {{-- Form hapus --}}
                                    <form action="{{ route('orders.destroy', $item) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus item ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-sm">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
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
```

</x-app-layout>
