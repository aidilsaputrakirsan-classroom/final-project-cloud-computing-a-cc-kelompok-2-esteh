<x-app-layout>

    {{-- Header form edit user --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">

            {{-- Judul halaman --}}
            <h2 class="font-semibold text-xl text-green-700 dark:text-green-300">
                Edit User
            </h2>

            {{-- Tombol kembali --}}
            <a href="{{ route('admin.users.index') }}"
                class="bg-gray-600 dark:bg-gray-700 text-white px-3 py-1.5 rounded hover:bg-gray-700 dark:hover:bg-gray-600 text-sm">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            {{-- Container form --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- Judul form --}}
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">
                    Form Edit User
                </h3>

                {{-- Form update user --}}
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @csrf  {{-- Token keamanan --}}
                    @method('PUT') {{-- Mengubah method menjadi PUT sesuai standar REST --}}

                    <!-- NAMA -->
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 mb-1">Nama</label>

                        {{-- Input nama dengan value bawaan dari database --}}
                        <input type="text" name="name"
                               class="w-full border-gray-300 dark:bg-gray-700 dark:text-white rounded-lg"
                               value="{{ old('name', $user->name) }}" required>
                    </div>

                    <!-- EMAIL -->
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 mb-1">Email</label>

                        {{-- Input email dengan value bawaan --}}
                        <input type="email" name="email"
                               class="w-full border-gray-300 dark:bg-gray-700 dark:text-white rounded-lg"
                               value="{{ old('email', $user->email) }}" required>
                    </div>

                    <!-- ROLE -->
                    {{-- Dropdown memilih role user --}}
                    <select name="role" class="w-full border rounded p-2">
                        <option value="user"  {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>

                    <!-- BUTTON -->
                    <div class="flex justify-end gap-2 mt-4">

                        {{-- Tombol update --}}
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Update User
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>
