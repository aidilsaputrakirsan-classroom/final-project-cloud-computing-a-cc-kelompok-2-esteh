<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-green-700 dark:text-green-300">
                Keranjang Belanja
            </h2>

            <a href="{{ route('dashboard') }}"
                class="bg-gray-600 text-white px-3 py-1.5 rounded hover:bg-gray-700 text-sm">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto py-6">
        <!-- PERBAIKAN: box ikut dark mode -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded shadow">
            @if($items->count() > 0)
                @foreach($items as $item)
                    <div class="border-b border-gray-300 dark:border-gray-600 py-2 flex justify-between items-center">
                        <span class="text-gray-800 dark:text-gray-200">
                            {{ $item->product->name }} (x{{ $item->quantity }})
                        </span>

                        <div>
                            <button type="button"
                                    class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700"
                                    data-action="{{ route('cart.remove', $item->id) }}"
                                    data-name="{{ $item->product->name }} (x{{ $item->quantity }})"
                                    onclick="openDeleteModalFromButton(this)">
                                Hapus
                            </button>
                        </div>
                    </div>
                @endforeach

                {{-- Catatan Pesanan --}}
                <form action="{{ route('cart.checkout') }}" method="GET" class="mt-4">
                    <label for="note" class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">
                        Catatan Pesanan (opsional)
                    </label>

                    <textarea
                        name="note"
                        id="note"
                        rows="3"
                        class="w-full border rounded p-2 mb-4
                               bg-white text-gray-900
                               dark:bg-gray-700 dark:text-white dark:border-gray-600"
                        placeholder="Contoh: Tidak terlalu manis, bungkus terpisah, dll">{{ old('note') }}</textarea>

                    <button type="submit"
                            class="w-full bg-green-600 text-white text-center py-2 rounded hover:bg-green-700">
                        Checkout
                    </button>
                </form>
            @else
                <p class="text-gray-500 dark:text-gray-300 text-center">Keranjang kosong</p>
            @endif
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="w-full max-w-md mx-4">
            <div class="rounded-lg overflow-hidden shadow-xl">
                <div class="bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 p-5">
                    <h2 class="text-lg font-semibold mb-2">
                        Apakah Anda yakin ingin menghapus item ini dari keranjang?
                    </h2>

                    <p id="deleteModalItem" class="text-sm text-gray-600 dark:text-gray-300 mb-4"></p>

                    <form id="deleteFormModal" method="POST" class="flex justify-end gap-3">
                        @csrf
                        @method('DELETE')

                        <!-- Tombol Tidak -->
                        <button type="button" onclick="closeDeleteModal()"
                            class="px-4 py-2 rounded border
                                   bg-white text-black
                                   dark:bg-gray-700 dark:text-white dark:border-gray-600">
                            Tidak
                        </button>

                        <!-- Tombol Ya -->
                        <button type="submit"
                            class="px-4 py-2 rounded
                                   bg-red-600 text-white
                                   dark:bg-red-500 dark:text-white">
                            Ya
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openDeleteModalFromButton(btn) {
            openDeleteModal(btn.getAttribute('data-action'), btn.getAttribute('data-name'));
        }

        function openDeleteModal(actionUrl, itemName) {
            const modal = document.getElementById('deleteModal');
            const form = document.getElementById('deleteFormModal');
            const itemEl = document.getElementById('deleteModalItem');

            form.action = actionUrl;
            itemEl.textContent = itemName || '';
            modal.classList.remove('hidden');

            modal.querySelector('button[type="button"]').focus();
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeDeleteModal();
        });

        document.getElementById('deleteModal').addEventListener('click', e => {
            if (e.target === e.currentTarget) closeDeleteModal();
        });
    </script>
</x-app-layout>
