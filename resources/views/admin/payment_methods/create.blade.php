<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-green-700 dark:text-green-300">
                Tambah Metode Pembayaran
            </h2>

            <a href="{{ route('admin.payment-methods.index') }}"
                class="bg-gray-600 dark:bg-gray-700 text-white px-3 py-1.5 rounded hover:bg-gray-700 dark:hover:bg-gray-600 text-sm">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8 max-w-md mx-auto">

        <form method="POST" action="{{ route('admin.payment-methods.store') }}" 
              class="space-y-5 bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
            @csrf

            <div>
                <label class="font-semibold text-gray-700 dark:text-gray-300">Nama Metode</label>
                <input type="text" name="name" 
                    class="w-full border border-gray-300 dark:border-gray-600 
                           bg-white dark:bg-gray-700 
                           text-gray-900 dark:text-gray-200 
                           p-2 rounded focus:ring-green-500 focus:border-green-500" 
                    required>
            </div>

            <div>
                <label class="font-semibold text-gray-700 dark:text-gray-300">
                    Kode (misal: bank, dana, ovo)
                </label>
                <input type="text" name="code" 
                    class="w-full border border-gray-300 dark:border-gray-600 
                           bg-white dark:bg-gray-700 
                           text-gray-900 dark:text-gray-200  
                           p-2 rounded focus:ring-green-500 focus:border-green-500" 
                    required>
            </div>

            <div>
                <label class="font-semibold text-gray-700 dark:text-gray-300">Status</label>
                <select name="active" 
                    class="w-full border border-gray-300 dark:border-gray-600 
                           bg-white dark:bg-gray-700 
                           text-gray-900 dark:text-gray-200 
                           p-2 rounded focus:ring-green-500 focus:border-green-500">
                    <option value="1">Aktif</option>
                    <option value="0">Nonaktif</option>
                </select>
            </div>

            <button 
                class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded">
                Simpan
            </button>

        </form>

    </div>
</x-app-layout>
