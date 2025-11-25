<x-app-layout>

    {{-- BAGIAN HEADER PAGE --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            {{-- Judul halaman --}}
            <h2 class="font-semibold text-xl text-green-700 dark:text-green-300">
                Edit User
            </h2>
        </div>
    </x-slot>

    {{-- BAGIAN KONTEN UTAMA --}}
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- WRAPPER KARTU FORM --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                
                {{-- FORM PEMBUATAN USER BARU --}}
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf {{-- Token keamanan wajib agar form tidak bisa dipalsukan --}}

                    <!-- INPUT NAMA -->
                    <div class="mb-4">
                        {{-- Label untuk input nama --}}
                        <label class="block text-gray-700 dark:text-gray-200 text-sm font-semibold mb-1">
                            Nama Lengkap
                        </label>

                        {{-- Kolom input nama --}}
                        <input type="text" name="name"
                               class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white"
                               required> {{-- required = wajib diisi --}}
                    </div>

                    <!-- INPUT EMAIL -->
                    <div class="mb-4">
                        {{-- Label email --}}
                        <label class="block text-gray-700 dark:text-gray-200 text-sm font-semibold mb-1">
                            Email
                        </label>

                        {{-- Kolom input email --}}
                        <input type="email" name="email"
                               class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white"
                               required>
                    </div>

                    <!-- INPUT PASSWORD -->
                    <div class="mb-4">
                        {{-- Label password --}}
                        <label class="block text-gray-700 dark:text-gray-200 text-sm font-semibold mb-1">
                            Password
                        </label>

                        {{-- Kolom input password --}}
                        <input type="password" name="password"
                               class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white"
                               required>
                    </div>

                    <!-- SELECT ROLE -->
                    <div class="mb-4">
                        {{-- Label role --}}
                        <label class="block text-gray-700 dark:text-gray-200 text-sm font-semibold mb-1">
                            Role
                        </label>

                        {{-- Dropdown memilih role user --}}
                        <select name="role" class="w-full border rounded p-2">

                            {{-- old() digunakan agar kalau input gagal, value sebelumnya tetap tampil --}}
                            <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>

                        </select>
                    </div>

                    <!-- TOMBOL AKSI -->
                    <div class="flex justify-end gap-2">

                        {{-- Tombol batal kembali ke daftar users --}}
                        <a href="{{ route('admin.users.index') }}"
                           class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                            Batal
                        </a>

                        {{-- Tombol submit untuk menyimpan user baru --}}
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Simpan User
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>
</x-app-layout>
