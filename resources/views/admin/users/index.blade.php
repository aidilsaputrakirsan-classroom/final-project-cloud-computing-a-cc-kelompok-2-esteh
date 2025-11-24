<x-app-layout>

   {{-- HEADER --}}
   <x-slot name="header">
        <div class="flex justify-between items-center">

            {{-- TITLE --}}
            <h2 class="font-semibold text-xl text-green-700 dark:text-green-300">
                Kelola User
            </h2>

            {{-- TOMBOL KEMBALI --}}
            <a href="{{ route('dashboard') }}"
                class="bg-gray-600 dark:bg-gray-700 text-white px-3 py-1.5 rounded hover:bg-gray-700 dark:hover:bg-gray-600 text-sm">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- CARD UTAMA --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- TITLE & BUTTON TAMBAH --}}
                <div class="flex justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                        Daftar User
                    </h3>

                    {{-- TOMBOL KE HALAMAN CREATE --}}
                    <a href="{{ route('admin.users.create') }}"
                       class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
                        + Tambah User
                    </a>
                </div>

                {{-- TABLE USER --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full w-full border border-gray-300 dark:border-gray-700 text-sm">

                        {{-- HEADER TABEL --}}
                        <thead class="bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            <tr>
                                <th class="px-4 py-3 border w-20">ID</th>
                                <th class="px-4 py-3 border w-1/4">Nama</th>
                                <th class="px-4 py-3 border w-1/3">Email</th>
                                <th class="px-4 py-3 border w-32">Role</th>
                                <th class="px-4 py-3 border w-40 text-center">Aksi</th>
                            </tr>
                        </thead>

                        {{-- DATA USER --}}
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="border-b dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700">

                                    {{-- ID --}}
                                    <td class="px-4 py-2 border text-center">
                                        {{ $user->id }}
                                    </td>

                                    {{-- NAMA --}}
                                    <td class="px-4 py-2 border">
                                        {{ $user->name }}
                                    </td>

                                    {{-- EMAIL --}}
                                    <td class="px-4 py-2 border">
                                        {{ $user->email }}
                                    </td>

                                    {{-- ROLE --}}
                                    <td class="px-4 py-2 border text-center">
                                        {{ $user->role ?? 'user' }}
                                    </td>

                                    {{-- AKSI --}}
                                    <td class="px-4 py-2 border text-center">
                                        <div class="flex justify-center gap-2">

                                            {{-- BUTTON EDIT --}}
                                            <a href="{{ route('admin.users.edit', $user->id) }}"
                                               class="px-3 py-1 bg-yellow-500 text-white rounded text-xs hover:bg-yellow-600">
                                                Edit
                                            </a>

                                            {{-- BUTTON HAPUS (BUKA MODAL) --}}
                                            <button type="button"
                                                onclick="openDeleteModal('{{ route('admin.users.destroy', $user->id) }}', '{{ $user->name }}')"
                                                class="px-3 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700">
                                                Hapus
                                            </button>

                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

            </div>
        </div>
    </div>

    {{-- MODAL KONFIRMASI HAPUS --}}
    <div id="deleteModal"
         class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">

        {{-- BOX MODAL --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-md shadow-lg">

            <h2 class="text-lg font-semibold mb-2 text-gray-800 dark:text-gray-100">
                Yakin ingin menghapus user ini?
            </h2>

            {{-- TEMPAT MENAMPILKAN NAMA USER --}}
            <p id="deleteModalUser" class="text-sm text-gray-600 dark:text-gray-300 mb-4"></p>

            {{-- FORM HAPUS --}}
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')

                <div class="flex justify-end gap-3">

                    {{-- BATAL --}}
                    <button type="button" 
                            onclick="closeDeleteModal()"
                            class="px-4 py-2 border rounded bg-white dark:bg-gray-700 text-black dark:text-white">
                        Tidak
                    </button>

                    {{-- YA, HAPUS --}}
                    <button type="submit"
                            class="px-4 py-2 rounded bg-red-500 text-white hover:bg-red-600">
                        Ya
                    </button>

                </div>
            </form>

        </div>
    </div>

    {{-- SCRIPT MODAL --}}
    <script>
        // BUKA MODAL
        function openDeleteModal(actionUrl, userName) {
            document.getElementById('deleteForm').action = actionUrl;
            document.getElementById('deleteModalUser').textContent = "User: " + userName;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        // TUTUP MODAL
        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        // ESC UNTUK TUTUP
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeDeleteModal();
        });
    </script>

</x-app-layout>
