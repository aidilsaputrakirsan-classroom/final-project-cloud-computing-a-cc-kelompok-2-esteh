<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manajemen Metode Pembayaran</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold">Daftar Metode</h3>
                    <a href="{{ route('admin.payment-methods.create') }}" class="bg-blue-600 text-white px-3 py-1 rounded">Tambah Metode</a>
                </div>

                @if(session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
                @endif

                <table class="w-full text-sm table-auto">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="p-2 border">Nama</th>
                            <th class="p-2 border">Kode</th>
                            <th class="p-2 border">Aktif</th>
                            <th class="p-2 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($methods as $m)
                        <tr class="hover:bg-gray-50">
                            <td class="p-2 border">{{ $m->name }}</td>
                            <td class="p-2 border">{{ $m->code }}</td>
                            <td class="p-2 border">
                                @if($m->active)
                                    <span class="px-2 py-1 bg-green-600 text-white rounded text-xs">Aktif</span>
                                @else
                                    <span class="px-2 py-1 bg-gray-400 text-white rounded text-xs">Nonaktif</span>
                                @endif
                            </td>
                            <td class="p-2 border">
                                <a href="{{ route('admin.payment-methods.edit', $m->id) }}" class="text-sm text-blue-600 mr-2">Edit</a>

                                <form action="{{ route('admin.payment-methods.destroy', $m->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus metode ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-sm text-red-600">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-3 text-center text-gray-500">Belum ada metode pembayaran.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
