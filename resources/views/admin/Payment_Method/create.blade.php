<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Metode Pembayaran</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <form action="{{ route('admin.payment-methods.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Nama</label>
                        <input type="text" name="name" class="w-full border rounded px-3 py-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Kode (unik, tanpa spasi)</label>
                        <input type="text" name="code" class="w-full border rounded px-3 py-2" required>
                        <p class="text-xs text-gray-500 mt-1">Contoh: dana, bank, ovo</p>
                    </div>

                    <div class="mb-4">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="active" checked class="form-checkbox">
                            <span class="ml-2">Aktif</span>
                        </label>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Config (opsional) — JSON atau teks</label>
                        <textarea name="config" class="w-full border rounded px-3 py-2" rows="4"></textarea>
                        <p class="text-xs text-gray-500 mt-1">Bisa berisi nomor VA, instruksi, dsb. (boleh JSON)</p>
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('admin.payment-methods.index') }}" class="px-3 py-2 bg-gray-300 rounded">Batal</a>
                        <button class="px-3 py-2 bg-blue-600 text-white rounded">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
