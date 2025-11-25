<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-green-700">Aktivitas Saya</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                <table class="min-w-full text-sm border">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-2 border">Waktu</th>
                            <th class="px-4 py-2 border">Aksi</th>
                            <th class="px-4 py-2 border">Deskripsi</th>
                            <th class="px-4 py-2 border">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                            <tr class="border-b">
                                <td class="px-4 py-2">{{ $log->created_at }}</td>
                                <td class="px-4 py-2">{{ $log->action }}</td>
                                <td class="px-4 py-2">{{ $log->description }}</td>
                                <td class="px-4 py-2">{{ $log->detail }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center px-4 py-2">Belum ada aktivitas</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
