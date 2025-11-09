<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Tambah Metode Pembayaran
        </h2>
    </x-slot>

    <div class="py-8 max-w-md mx-auto">

        <form method="POST" action="{{ route('admin.payment-methods.store') }}" class="space-y-5">
            @csrf

            <div>
                <label class="font-semibold">Nama Metode</label>
                <input type="text" name="name" class="w-full border p-2 rounded" required>
            </div>

            <div>
                <label class="font-semibold">Kode (misal: bank, dana, ovo)</label>
                <input type="text" name="code" class="w-full border p-2 rounded" required>
            </div>

            <div>
                <label class="font-semibold">Status</label>
                <select name="active" class="w-full border p-2 rounded">
                    <option value="1">Aktif</option>
                    <option value="0">Nonaktif</option>
                </select>
            </div>

            <div>
                <label class="font-semibold">Config (opsional)</label>
                <textarea name="config" class="w-full border p-2 rounded" placeholder='{"bank":"BCA", "rekening":"1234"}'></textarea>
            </div>

            <button class="bg-green-600 text-white px-5 py-2 rounded hover:bg-green-700">
                Simpan
            </button>

        </form>

    </div>
</x-app-layout>
