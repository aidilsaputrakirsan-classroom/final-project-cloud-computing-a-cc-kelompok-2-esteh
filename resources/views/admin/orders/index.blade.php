<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-green-700 dark:text-green-300">
                Manajemen Monitoring Pesanan
            </h2>

            <a href="{{ route('dashboard') }}"
                class="bg-gray-600 dark:bg-gray-700 text-white px-3 py-1.5 rounded hover:bg-gray-700 dark:hover:bg-gray-600 text-sm">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg p-6">

                @if($orders->isEmpty())
                    <p class="text-gray-500 dark:text-gray-300 text-center py-10 text-lg">
                        Belum ada pesanan.
                    </p>
                @else

                    @foreach($orders as $order)
                        <div class="border rounded-lg shadow-sm p-5 mb-6 
                                    bg-gray-50 dark:bg-gray-700 
                                    border-gray-300 dark:border-gray-600">

                            {{-- HEADER PESANAN --}}
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100">
                                        Pesanan #{{ $order->id }} — {{ $order->user->name }}
                                    </h3>

                                    {{-- CATATAN --}}
                                    @if($order->note)
                                        <p class="text-gray-700 dark:text-gray-300 text-sm mt-1">
                                            <span class="font-semibold text-gray-800 dark:text-gray-200">Catatan:</span> 
                                            {{ $order->note }}
                                        </p>
                                    @endif
                                </div>

                                {{-- FORM UBAH STATUS --}}
                                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" 
                                      method="POST" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')

                                    {{-- STATUS PEMBAYARAN --}}
                                    @php
                                        $isPaid = isset($order->payment_status) && $order->payment_status === 'paid';
                                    @endphp

                                    <span class="px-3 py-1 rounded text-white text-xs
                                        {{ $isPaid ? 'bg-green-700' : 'bg-gray-600 dark:bg-gray-500' }}">
                                        {{ $isPaid ? 'Paid' : 'Unpaid' }}
                                    </span>

                                    <select name="status" 
                                        class="border rounded px-2 pr-7 py-1 text-sm
                                               bg-white dark:bg-gray-600
                                               text-gray-900 dark:text-gray-100
                                               border-gray-300 dark:border-gray-500"
                                        onchange="this.form.submit()">

                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="success" {{ $order->status == 'success' ? 'selected' : '' }}>Success</option>
                                        <option value="cancel"  {{ $order->status == 'cancel'  ? 'selected' : '' }}>Cancel</option>
                                    </select>

                                    {{-- BADGE STATUS --}}
                                    <span class="px-3 py-1 rounded text-white text-xs 
                                        {{ $order->status == 'pending' ? 'bg-yellow-500' :
                                           ($order->status == 'success' ? 'bg-green-600' : 'bg-red-600') }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </form>
                            </div>

                            {{-- TABEL ITEM --}}
                            @if($order->items->isNotEmpty())
                                <table class="w-full text-sm border-collapse">
                                    <thead>
                                        <tr class="bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-gray-100">
                                            <th class="p-2 border dark:border-gray-700">Produk</th>
                                            <th class="p-2 border dark:border-gray-700">Qty</th>
                                            <th class="p-2 border dark:border-gray-700">Harga</th>
                                            <th class="p-2 border dark:border-gray-700">Subtotal</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @php $total = 0; @endphp

                                        @foreach($order->items as $item)
                                            @php 
                                                $subtotal = $item->quantity * $item->price;
                                                $total += $subtotal;
                                            @endphp

                                            <tr class="bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-900 dark:text-gray-100">
                                                <td class="border dark:border-gray-700 p-2">
                                                    {{ $item->product->name }}
                                                </td>
                                                <td class="border dark:border-gray-700 p-2 text-center">
                                                    {{ $item->quantity }}
                                                </td>
                                                <td class="border dark:border-gray-700 p-2">
                                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                                </td>
                                                <td class="border dark:border-gray-700 p-2 text-green-700 dark:text-green-400 font-semibold">
                                                    Rp {{ number_format($subtotal, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        @endforeach

                                        <tr class="bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-200">
                                            <td colspan="3" class="p-2 border dark:border-gray-700 font-semibold text-right">
                                                Total:
                                            </td>
                                            <td class="p-2 border dark:border-gray-700 font-bold text-green-700 dark:text-green-300">
                                                Rp {{ number_format($total, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div class="flex justify-end mt-3">
                                    <form action="{{ route('admin.orders.destroy', $order) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus pesanan ini beserta itemnya?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                            Hapus Pesanan
                                        </button>
                                    </form>
                                </div>

                            @else
                                <p class="text-gray-500 dark:text-gray-300 text-sm py-3">
                                    Tidak ada detail item.
                                </p>
                            @endif

                        </div>
                    @endforeach

                @endif

            </div>
        </div>
    </div>

</x-app-layout>
