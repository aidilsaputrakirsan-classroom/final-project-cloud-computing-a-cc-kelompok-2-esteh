<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
           <h2 class="font-semibold text-xl text-green-700">
                Manajemen Kelola Produk
            </h2>

            <a href="{{ route('dashboard') }}"
                class="bg-gray-600 text-white px-3 py-1.5 rounded hover:bg-gray-700 text-sm">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <a href="{{ route('admin.products.create') }}" class="bg-green-500 text-white px-4 py-2 rounded mb-2 inline-block">
                Tambah Produk
            </a>

            @if(session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 dark:text-gray-200 p-6 rounded shadow">

                <table class="w-full table-auto dark:text-gray-200">
                    <thead>
                        <tr>
                            <th class="border dark:border-gray-600 px-4 py-2">Nama</th>
                            <th class="border dark:border-gray-600 px-4 py-2">Harga</th>
                            <th class="border dark:border-gray-600 px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td class="border dark:border-gray-600 px-4 py-2">{{ $product->name }}</td>
                            <td class="border dark:border-gray-600 px-4 py-2">{{ number_format($product->price,0,',','.') }}</td>
                            <td class="border dark:border-gray-600 px-4 py-2">
                                <div class="flex flex-wrap gap-2 justify-center">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="bg-blue-500 text-white px-2 py-1 rounded text-sm">Edit</a>

                                    <!-- Tombol pemicu modal (ganti form confirm bawaan) -->
                                    <button type="button"
                                            onclick="openDeleteModal('{{ route('admin.products.destroy', $product->id) }}','{{ addslashes($product->name) }}')"
                                            class="bg-red-500 text-white px-2 py-1 rounded text-sm">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal (Kitty) -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-lg">
            <h2 class="text-lg font-semibold mb-3">Apakah Anda yakin ingin menghapus item ini?</h2>
            <p id="deleteModalItem" class="text-sm text-gray-600 mb-4"></p>

            <form id="deleteFormModal" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-end gap-3">
                    <!-- tombol 'Tidak' : tulisan hitam, latar putih -->
                    <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 border rounded bg-white text-black">
                        Tidak
                    </button>
                    <!-- tombol 'Ya' : tulisan hitam, latar merah -->
                    <button type="submit" class="px-4 py-2 rounded bg-red-500 text-black">
                        Ya
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        /**
         * openDeleteModal(actionUrl, itemName)
         * - actionUrl: URL endpoint DELETE (route('admin.products.destroy', $product->id))
         * - itemName: teks yang ditampilkan di modal (produk name)
         */
        function openDeleteModal(actionUrl, itemName) {
            var modal = document.getElementById('deleteModal');
            var form = document.getElementById('deleteFormModal');
            var itemEl = document.getElementById('deleteModalItem');

            // Set form action to the delete route
            form.action = actionUrl;
            itemEl.textContent = itemName || '';

            // show modal
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

        // close modal when clicking outside content
        document.getElementById('deleteModal').addEventListener('click', function(e){
            if (e.target === this) {
                closeDeleteModal();
            }
        });
    </script>
</x-app-layout>