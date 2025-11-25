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
            <div class="bg-gray-100 dark:bg-gray-800 dark:text-gray-200 shadow-md sm:rounded-lg p-6">

                {{-- Jika tidak ada pesanan --}}
                @if($orders->isEmpty() || $orders->every(fn($o) => $o->items->isEmpty()))
                    <p class="text-gray-500 text-center py-10 text-lg">
                        Belum ada pesanan.
                    </p>
                @else

                    @foreach($orders as $order)
                        @if($order->items->isNotEmpty())

                            <div class="border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm p-5 mb-6 bg-gray-50 dark:bg-gray-700 dark:text-gray-200">
                                <div class="flex justify-between items-center mb-3">
                                    <div>
                                        <h3 class="font-bold text-lg">
                                            Pesanan #{{ $order->id }}
                                        </h3>
                                        @if($order->note)
                                            <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                                                <strong>Catatan:</strong> {{ $order->note }}
                                            </p>
                                        @endif
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <span class="px-3 py-1 rounded text-white text-xs 
                                            {{ $order->status == 'pending' ? 'bg-yellow-500' :
                                               ($order->status == 'success' ? 'bg-green-600' : 'bg-red-600') }}">
                                            {{ ucfirst($order->status) }}
                                        </span>

                                        {{-- Status pembayaran --}}
                                        @php
                                            $isPaid = isset($order->payment_status) && $order->payment_status === 'paid';
                                        @endphp

                                        @if($isPaid)
                                            <span class="px-3 py-1 rounded text-white text-xs bg-green-700">Paid</span>
                                        @else
                                            <span class="px-3 py-1 rounded text-white text-xs bg-gray-600">Unpaid</span>
                                        @endif
                                    </div>
                                </div>

                                {{-- TABEL ITEM --}}
                                <table class="w-full text-sm border-collapse">
                                    <thead>
                                        <tr class="bg-gray-200 dark:bg-gray-600 dark:text-gray-100">
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
                                            @php 
                                                $subtotal = $item->quantity * $item->price; 
                                                $total += $subtotal; 
                                            @endphp
                                            <tr>
                                                <td class="border p-2">{{ $item->product->name }}</td>

                                                <td class="border p-2">
                                                    @if(!$isPaid && $order->status !== 'success')
                                                        <form action="{{ route('orders.update', $item) }}" method="POST" class="flex items-center gap-2">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                                                                class="border px-2 py-1 w-16 text-sm rounded">
                                                            <button class="bg-blue-500 text-white px-2 py-1 rounded text-xs hover:bg-blue-600">
                                                                Update
                                                            </button>
                                                        </form>
                                                    @else
                                                        <span class="text-gray-400 text-xs">Terkunci</span>
                                                    @endif
                                                </td>

                                                <td class="border p-2">
                                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                                </td>

                                                <td class="border p-2 font-semibold">
                                                    Rp {{ number_format($subtotal, 0, ',', '.') }}
                                                </td>

                                                <td class="border p-2 text-center">
                                                    @if(!$isPaid && $order->status !== 'success')
                                                        <!-- Tombol hapus dengan modal -->
                                                        <button type="button"
                                                            class="bg-red-500 text-white px-2 py-1 rounded text-xs hover:bg-red-600"
                                                            data-action="{{ route('orders.destroy', $item) }}"
                                                            data-name="{{ $item->product->name }} (x{{ $item->quantity }})"
                                                            onclick="openDeleteModalFromButton(this)">
                                                            Hapus
                                                        </button>
                                                    @else
                                                        <span class="text-gray-400 text-xs">Terkunci</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach

                                        {{-- TOTAL --}}
                                        <tr class="bg-gray-100 dark:bg-gray-600 dark:text-gray-100">
                                            <td colspan="3" class="p-2 border font-semibold text-right">Total:</td>
                                            <td class="p-2 border font-bold text-green-700">
                                                Rp {{ number_format($total, 0, ',', '.') }}
                                            </td>
                                            <td class="border p-2 text-center">

                                                @if(!$isPaid && $order->status !== 'success')
                                                    <a href="{{ route('orders.payment', $order) }}"
                                                       class="inline-block px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                                                        Bayar
                                                    </a>
                                                @else
                                                    <span class="inline-block px-3 py-1 bg-gray-100 dark:bg-gray-300 text-green-700 rounded">
                                                        Sudah dibayar
                                                    </span>
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

    <!-- Delete Confirmation Modal (Dark Theme Ready) -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="w-full max-w-md mx-4">
            <div class="rounded-lg overflow-hidden shadow-xl">
                <div class="bg-gray-800 text-gray-100 p-5">
                    <h2 class="text-lg font-semibold mb-2">Apakah Anda yakin ingin menghapus item ini?</h2>
                    <p id="deleteModalItem" class="text-sm text-gray-300 mb-4"></p>

                    <form id="deleteFormModal" method="POST" class="flex justify-end gap-3">
                        @csrf
                        @method('DELETE')

                        <button type="button"
                            onclick="closeDeleteModal()"
                            class="px-4 py-2 rounded border border-gray-500 bg-gray-700 text-gray-200 hover:bg-gray-600">
                            Tidak
                        </button>

                        <button type="submit"
                            class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700">
                            Ya
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openDeleteModalFromButton(btn) {
            let action = btn.getAttribute('data-action');
            let name = btn.getAttribute('data-name');
            openDeleteModal(action, name);
        }

        function openDeleteModal(actionUrl, itemName) {
            let modal = document.getElementById('deleteModal');
            let form = document.getElementById('deleteFormModal');
            let itemEl = document.getElementById('deleteModalItem');

            form.action = actionUrl;
            itemEl.textContent = itemName || '';

            modal.classList.remove('hidden');

            let cancelBtn = modal.querySelector('button[type="button"]');
            if (cancelBtn) cancelBtn.focus();
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        document.addEventListener('keydown', function(e){
            if (e.key === 'Escape') {
                let modal = document.getElementById('deleteModal');
                if (!modal.classList.contains('hidden')) closeDeleteModal();
            }
        });

        document.getElementById('deleteModal').addEventListener('click', function(e){
            if (e.target === this) closeDeleteModal();
        });
    </script>
</x-app-layout>
