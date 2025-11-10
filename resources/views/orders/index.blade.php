<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-green-700">
                Pesanan Saya
            </h2>

            <a href="{{ route('dashboard') }}"
                class="bg-gray-600 text-white px-3 py-1.5 rounded hover:bg-gray-700 text-sm">
                Kembali
            </a>
        </div>
    </x-slot>

<div class="py-10">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-md sm:rounded-lg p-6">

            {{-- Jika tidak ada pesanan --}}
            @if($orders->isEmpty() || $orders->every(fn($o) => $o->items->isEmpty()))
                <p class="text-gray-500 text-center py-10 text-lg">
                    Belum ada pesanan.
                </p>
            @else

                @foreach($orders as $order)
                    @if($order->items->isNotEmpty())

                        <div class="border rounded-lg shadow-sm p-5 mb-6 bg-gray-50">
                            <div class="flex justify-between items-center mb-3">
                                <h3 class="font-bold text-lg">
                                    Pesanan #{{ $order->id }}
                                </h3>
                                    @if($order->note)
                                        <p class="text-sm text-gray-600 mt-1">
                                            <strong>Catatan:</strong> {{ $order->note }}
                                        </p>
                                    @endif

                                <div class="flex items-center gap-2">
                                    <span class="px-3 py-1 rounded text-white text-xs 
                                        {{ $order->status == 'pending' ? 'bg-yellow-500' :
                                           ($order->status == 'success' ? 'bg-green-600' : 'bg-red-600') }}">
                                        {{ ucfirst($order->status) }}
                                    </span>

                                    {{-- Tampilkan juga info payment_status jika tersedia --}}
                                    @if(isset($order->payment_status))
                                        @if($order->payment_status === 'paid')
                                            <span class="px-3 py-1 rounded text-white text-xs bg-green-700">Paid</span>
                                        @else
                                            <span class="px-3 py-1 rounded text-white text-xs bg-gray-600">Unpaid</span>
                                        @endif
                                    @endif
                                </div>

                            </div>

                            <table class="w-full text-sm border-collapse">
                                <thead>
                                    <tr class="bg-gray-200">
                                        <th class="p-2 border">Produk</th>
                                        <th class="p-2 border">Qty</th>
                                        <th class="p-2 border">Harga Satuan</th>
                                        <th class="p-2 border">Subtotal</th>
                                        <th class="p-2 border">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @php $total = 0; @endphp
                                    @foreach($order->items as $item)
                                        @php $subtotal = $item->quantity * $item->price; $total += $subtotal; @endphp

                                        <tr>
                                            <td class="border p-2">{{ $item->product->name }}</td>

                                            <td class="border p-2">
                                                <form action="{{ route('orders.update', $item) }}" method="POST" class="flex items-center gap-2">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                                                        class="border px-2 py-1 w-16 text-sm rounded">
                                                    <button class="bg-blue-500 text-white px-2 py-1 rounded text-xs hover:bg-blue-600">
                                                        Update
                                                    </button>
                                                </form>
                                            </td>

                                            <td class="border p-2">
                                                Rp {{ number_format($item->price, 0, ',', '.') }}
                                            </td>

                                            <td class="border p-2 font-semibold">
                                                Rp {{ number_format($subtotal, 0, ',', '.') }}
                                            </td>

                                            <td class="border p-2 text-center">
                                                <form action="{{ route('orders.destroy', $item) }}" method="POST"
                                                      onsubmit="return confirm('Hapus item ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="bg-red-500 text-white px-2 py-1 rounded text-xs hover:bg-red-600">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>

                                    @endforeach

                                    <tr class="bg-gray-100">
                                        <td colspan="3" class="p-2 border font-semibold text-right">Total:</td>
                                        <td class="p-2 border font-bold text-green-700">
                                            Rp {{ number_format($total, 0, ',', '.') }}
                                        </td>

                                        {{-- Tambahkan kolom aksi: tombol Bayar atau status sudah dibayar --}}
                                        <td class="border p-2 text-center">
                                            @php
                                                // aman: cek apakah kolom payment_status ada
                                                $isPaid = isset($order->payment_status) && $order->payment_status === 'paid';
                                            @endphp

                                            @if(!$isPaid)
                                                {{-- Tombol Bayar mengarah ke halaman metode pembayaran --}}
                                                <a href="{{ route('orders.payment', $order) }}"
                                                   class="inline-block px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                                                    Bayar
                                                </a>
                                            @else
                                                <span class="inline-block px-3 py-1 bg-gray-100 text-green-700 rounded">Sudah dibayar</span>
                                            @endif
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>

                    @endif
                @endforeach
            @endif

        </div>
    </div>
</div>

</x-app-layout>
