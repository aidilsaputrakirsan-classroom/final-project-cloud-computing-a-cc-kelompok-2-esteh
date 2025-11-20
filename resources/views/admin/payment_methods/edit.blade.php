<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
            Edit Metode Pembayaran
        </h2>
    </x-slot>

    <div class="py-8 max-w-md mx-auto">

        <form method="POST" 
              action="{{ route('admin.payment-methods.update', $method->id) }}" 
              class="space-y-5 bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
            @csrf
            @method('PUT')

            <div>
                <label class="font-semibold text-gray-700 dark:text-gray-300">
                    Nama Metode
                </label>
                <input type="text" name="name"
                       value="{{ $method->name }}"
                       class="w-full border border-gray-300 dark:border-gray-600
                              bg-white dark:bg-gray-700
                              text-gray-900 dark:text-gray-200
                              p-2 rounded focus:ring-green-500 focus:border-green-500"
                       required>
            </div>

            <div>
                <label class="font-semibold text-gray-700 dark:text-gray-300">
                    Kode
                </label>
                <input type="text" name="code"
                       value="{{ $method->code }}"
                       class="w-full border border-gray-300 dark:border-gray-600
                              bg-white dark:bg-gray-700
                              text-gray-900 dark:text-gray-200
                              p-2 rounded focus:ring-green-500 focus:border-green-500"
                       required>
            </div>

            <div>
                <label class="font-semibold text-gray-700 dark:text-gray-300">
                    Status
                </label>
                <select name="active"
                        class="w-full border border-gray-300 dark:border-gray-600
                               bg-white dark:bg-gray-700
                               text-gray-900 dark:text-gray-200
                               p-2 rounded focus:ring-green-500 focus:border-green-500">
                    <option value="1" @if($method->active) selected @endif>Aktif</option>
                    <option value="0" @if(!$method->active) selected @endif>Nonaktif</option>
                </select>
            </div>

            <button class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">
                Perbarui
            </button>

        </form>

    </div>
</x-app-layout>
