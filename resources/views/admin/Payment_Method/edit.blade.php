<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Metode Pembayaran</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <form action="{{ route('admin.payment-methods.update', $method->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Nama</label>
                        <input type="text" name="name" class="w-full border rounded px-3 py-2" value="{{ old('name', $method->name) }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Kode</label>
                        <input type="text" name="code" class="w-full border rounded px-3 py-2" value="{{ old('code', $method->code) }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="active" class="form-checkbox" {{ $method->active ? 'checked' : '' }}>
                            <span class="ml-2">Aktif</span>
                        </label>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Config (JSON atau teks)</label>
                        <textarea name="config" class="w-full border rounded px-3 py-2" rows="4">{{ old('config', json_encode($method->config, JSON_PRETTY_PRINT) ?? '') }}</textarea>
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
