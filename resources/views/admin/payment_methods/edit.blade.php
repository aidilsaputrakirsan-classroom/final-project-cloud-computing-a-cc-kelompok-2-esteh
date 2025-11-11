<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Edit Metode Pembayaran
        </h2>
    </x-slot>

    <div class="py-8 max-w-md mx-auto">

        <form method="POST" action="{{ route('admin.payment-methods.update', $method->id) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="font-semibold">Nama Metode</label>
                <input type="text" name="name"
                       value="{{ $method->name }}"
                       class="w-full border p-2 rounded" required>
            </div>

            <div>
                <label class="font-semibold">Kode</label>
                <input type="text" name="code"
                       value="{{ $method->code }}"
                       class="w-full border p-2 rounded" required>
            </div>

            <div>
                <label class="font-semibold">Status</label>
                <select name="active" class="w-full border p-2 rounded">
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
