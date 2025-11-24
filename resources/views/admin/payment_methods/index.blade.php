<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-green-700 dark:text-green-300">
                Manajemen Metode Pembayaran
            </h2>

            <a href="{{ route('dashboard') }}"
                class="bg-gray-600 dark:bg-gray-700 text-white px-3 py-1.5 rounded hover:bg-gray-700 dark:hover:bg-gray-600 text-sm">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            {{-- ALERT --}}
            @if(session('success'))
                <div class="bg-green-100 dark:bg-green-900 border border-green-300 dark:border-green-700 
                            text-green-800 dark:text-green-200 px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <a href="{{ route('admin.payment-methods.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mb-5 inline-block">
                + Tambah Metode Pembayaran
            </a>

            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">

                @if($methods->isEmpty())
                    <p class="text-gray-500 dark:text-gray-300 text-center text-lg py-10">
                        Belum ada metode pembayaran.
                    </p>
                @else

                    @foreach($methods as $method)
                        <div class="border rounded-lg p-4 mb-4 
                                    bg-gray-50 dark:bg-gray-700 
                                    border-gray-300 dark:border-gray-600 
                                    shadow-sm">

                            <div class="flex justify-between items-center">
                                <div>
                                    <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100">
                                        {{ $method->name }}
                                    </h3>

                                    <p class="text-gray-600 dark:text-gray-300 text-sm">
                                        Kode: {{ $method->code }}
                                    </p>
                                </div>

                                <div class="flex gap-3 items-center">
                                    <a href="{{ route('admin.payment-methods.edit', $method->id) }}"
                                        class="text-blue-600 dark:text-blue-400 hover:underline">
                                        Edit
                                    </a>

                                    <!-- Perbaikan: gunakan data-attributes untuk action & name (menghindari escaping issues) -->
                                    <button type="button"
                                            data-action="{{ route('admin.payment-methods.destroy', $method->id) }}"
                                            data-name="{{ $method->name }}"
                                            onclick="openDeleteModalFromButton(this)"
                                            class="text-red-600 dark:text-red-400 hover:underline">
                                        Hapus
                                    </button>
                                </div>
                            </div>

                        </div>
                    @endforeach

                @endif
            </div>

        </div>
    </div>

    <!-- Delete Confirmation Modal (Kitty) - Dark themed to fit admin UI -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center hidden z-50">
        <div class="w-full max-w-md mx-4">
            <div class="rounded-lg overflow-hidden shadow-xl">
                <div class="bg-gray-800 text-gray-100 p-5">
                    <h2 class="text-lg font-semibold mb-2">Apakah Anda yakin ingin menghapus item ini?</h2>
                    <p id="deleteModalItem" class="text-sm text-gray-300 mb-4"></p>

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
        /**
         * openDeleteModalFromButton(btn)
         * - btn: tombol yang memiliki data-action & data-name
         */
        function openDeleteModalFromButton(btn) {
            var action = btn.getAttribute('data-action');
            var name = btn.getAttribute('data-name');

            openDeleteModal(action, name);
        }

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

        // Close when clicking outside dialog content
        document.getElementById('deleteModal').addEventListener('click', function(e){
            if (e.target === this) closeDeleteModal();
        });
    </script>

</x-app-layout>
