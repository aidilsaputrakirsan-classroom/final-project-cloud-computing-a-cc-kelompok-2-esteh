<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-green-700">
                Makanan dan Minuman
            </h2>

            <a href="{{ route('dashboard') }}"
                class="bg-gray-600 text-white px-3 py-1.5 rounded hover:bg-gray-700 text-sm">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
           <div class="bg-gray-100 dark:bg-gray-800 dark:text-gray-200 overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if($products->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($products as $product)
                            <div class="border border-gray-300 dark:border-gray-700 rounded shadow hover:shadow-lg transition p-4 flex flex-col bg-gray-50 dark:bg-gray-700 dark:text-gray-200">

                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                         class="w-full h-40 object-cover rounded mb-4">
                                @endif

                                <h3 class="font-bold text-lg mb-1">{{ $product->name }}</h3>
                                <p class="text-gray-600 mb-2">{{ $product->description }}</p>
                                <p class="mt-auto font-semibold text-gray-800">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </p>

                                <!-- Form dengan Quantity -->
                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-3 add-to-cart-form">
                                    @csrf

                                    <div class="flex items-center gap-2">
                                        <input type="number" name="quantity" value="1" min="1"
                                            class="w-20 border rounded p-2 focus:ring-green-500 focus:border-green-500" required>
                                        
                                        <button type="submit"
                                            class="flex-1 text-center px-3 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                            Tambah
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endforeach
                    </div>

                @else
                    <p class="text-center text-gray-500">Belum ada menu tersedia.</p>
                @endif

            </div>
        </div>
    </div>
    @push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Tangkap semua form dengan class "add-to-cart-form"
    document.querySelectorAll('.add-to-cart-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // cegah reload halaman

            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': form.querySelector('input[name=_token]').value,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('✅ ' + data.message);
                } else {
                    showToast('⚠️ ' + (data.message || 'Terjadi kesalahan.'));
                }
            })
            .catch(() => {
                showToast('❌ Gagal menambahkan ke keranjang.');
            });
        });
    });

    // Fungsi toast sederhana
    function showToast(message) {
        const toast = document.createElement('div');
        toast.textContent = message;
        toast.className = 'fixed bottom-5 right-5 bg-green-600 text-white px-4 py-2 rounded shadow-lg animate-fade-in';
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.remove();
        }, 2500);
    }
});
</script>

<style>
@keyframes fade-in { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
.animate-fade-in { animation: fade-in 0.3s ease-out; }
</style>
@endpush

</x-app-layout>
