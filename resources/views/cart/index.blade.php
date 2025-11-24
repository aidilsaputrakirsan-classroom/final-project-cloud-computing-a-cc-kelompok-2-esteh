<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-green-700">
                Keranjang Belanja
            </h2>

            <a href="{{ route('dashboard') }}"
                class="bg-gray-600 text-white px-3 py-1.5 rounded hover:bg-gray-700 text-sm">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto py-6">
        <div class="bg-white p-6 rounded shadow">
            @if($items->count() > 0)
                @foreach($items as $item)
                    <div class="border-b py-2 flex justify-between items-center">
                        <span>{{ $item->product->name }} (x{{ $item->quantity }})</span>

                        <!-- Ganti form confirm bawaan dengan tombol pemicu modal -->
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

                {{-- 📝 Tambahkan catatan pesanan --}}
                <form action="{{ route('cart.checkout') }}" method="GET" class="mt-4">
                    <label for="note" class="block text-gray-700 font-semibold mb-2">Catatan Pesanan (opsional)</label>
                    <textarea name="note" id="note" rows="3" class="w-full border rounded p-2 mb-4" placeholder="Contoh: Tidak terlalu manis, bungkus terpisah, dll">{{ old('note') }}</textarea>

                    <button type="submit" class="w-full bg-green-600 text-white text-center py-2 rounded hover:bg-green-700">
                        Checkout
                    </button>
                </form>
            @else
                <p class="text-gray-500 text-center">Keranjang kosong</p>
            @endif
        </div>
    </div>

    <!-- Delete Confirmation Modal (Kitty) - matches admin dark/light styling -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="w-full max-w-md mx-4">
            <div class="rounded-lg overflow-hidden shadow-xl">
                <div class="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 p-5">
                    <h2 class="text-lg font-semibold mb-2">Apakah Anda yakin ingin menghapus item ini dari keranjang?</h2>
                    <p id="deleteModalItem" class="text-sm text-gray-600 dark:text-gray-300 mb-4"></p>

                    <form id="deleteFormModal" method="POST" class="flex justify-end gap-3">
                        @csrf
                        @method('DELETE')

                        <!-- tombol 'Tidak' : tulisan hitam, latar putih -->
                        <button type="button" onclick="closeDeleteModal()"
                                class="px-4 py-2 rounded border bg-white text-black">
                            Tidak
                        </button>

                        <!-- tombol 'Ya' : tulisan hitam, latar merah -->
                        <button type="submit" class="px-4 py-2 rounded bg-red-500 text-black">
                            Ya
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Dipakai oleh tombol Hapus: baca data-* lalu buka modal
        function openDeleteModalFromButton(btn) {
            var action = btn.getAttribute('data-action');
            var name = btn.getAttribute('data-name');
            openDeleteModal(action, name);
        }

        function openDeleteModal(actionUrl, itemName) {
            var modal = document.getElementById('deleteModal');
            var form = document.getElementById('deleteFormModal');
            var itemEl = document.getElementById('deleteModalItem');

            form.action = actionUrl;
            itemEl.textContent = itemName || '';

            modal.classList.remove('hidden');

            // fokus ke tombol 'Tidak' agar keyboard-friendly
            var cancelBtn = modal.querySelector('button[type="button"]');
            if (cancelBtn) cancelBtn.focus();
        }

        function closeDeleteModal() {
            var modal = document.getElementById('deleteModal');
            modal.classList.add('hidden');
        }

        // Close modal on ESC
        document.addEventListener('keydown', function(e){
            if (e.key === 'Escape') {
                var modal = document.getElementById('deleteModal');
                if (modal && !modal.classList.contains('hidden')) closeDeleteModal();
            }
        });

        // Close when clicking outside dialog content
        document.getElementById('deleteModal').addEventListener('click', function(e){
            if (e.target === this) closeDeleteModal();
        });
    </script>
</x-app-layout>
