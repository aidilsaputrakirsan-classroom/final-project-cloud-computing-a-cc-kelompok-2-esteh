<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-green-700">
                Manajemen Metode Pembayaran
            </h2>

            <a href="{{ route('dashboard') }}"
                class="bg-gray-600 text-white px-3 py-1.5 rounded hover:bg-gray-700 text-sm">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            {{-- ALERT --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <a href="{{ route('admin.payment-methods.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mb-5 inline-block">
                + Tambah Metode Pembayaran
            </a>

            <div class="bg-white shadow-md rounded-lg p-6">

                @if($methods->isEmpty())
                    <p class="text-gray-500 text-center text-lg py-10">
                        Belum ada metode pembayaran.
                    </p>
                @else

                    @foreach($methods as $method)
                        <div class="border rounded-lg p-4 mb-4 bg-gray-50 shadow-sm">

                            <div class="flex justify-between items-center">
                                <div>
                                    <h3 class="font-bold text-lg">{{ $method->name }}</h3>
                                    <p class="text-gray-600 text-sm">Kode: {{ $method->code }}</p>
                                </div>

                                <div class="flex gap-3">
                                    <a href="{{ route('admin.payment-methods.edit', $method->id) }}"
                                        class="text-blue-600 hover:underline">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.payment-methods.destroy', $method->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus metode ini?')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600 hover:underline">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    @endforeach

                @endif
            </div>

        </div>
    </div>
</x-app-layout>
