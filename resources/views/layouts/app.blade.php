<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        {{-- ============================= --}}
        {{-- ✅ SweetAlert2 Notifikasi Popup --}}
        {{-- ============================= --}}

        <!-- SweetAlert2 CDN -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        {{-- Success / Error popup from session --}}
        @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses 🎉',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 2500,
                    timerProgressBar: true,
                });
            });
        </script>
        @endif

        @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: '{{ session('error') }}',
                    confirmButtonText: 'OK',
                });
            });
        </script>
        @endif

        {{-- ====================================== --}}
        {{-- ✅ JavaScript Notifikasi (bell + dropdown) --}}
        {{-- ====================================== --}}
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Elements (must match IDs in navigation.blade.php)
            const btnToggle = document.getElementById('notif-toggle');
            const dropdown = document.getElementById('notif-dropdown');
            const notifList = document.getElementById('notif-list');
            const notifCount = document.getElementById('notif-count');
            const markAllBtn = document.getElementById('mark-all-read');

            // Fallback: if elements not present, stop
            if (!btnToggle || !dropdown || !notifList || !notifCount) {
                return;
            }

            let isOpen = false;

            async function fetchNotifs() {
                try {
                    const res = await fetch('{{ route("notifications.index") }}', {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' },
                        credentials: 'same-origin'
                    });

                    if (!res.ok) throw new Error('Gagal load notifikasi');

                    const data = await res.json();

                    // update count
                    if (data.unread_count && data.unread_count > 0) {
                        notifCount.style.display = 'inline-flex';
                        notifCount.textContent = data.unread_count;
                    } else {
                        notifCount.style.display = 'none';
                    }

                    // render list (unread first)
                    notifList.innerHTML = '';

                    const renderItem = (n, isUnread = true) => {
                        const created = new Date(n.created_at).toLocaleString();
                        // safe access message and extras
                        const message = (n.data && n.data.message) ? n.data.message : 'Notifikasi';
                        const orderId = (n.data && n.data.order_id) ? n.data.order_id : '';
                        const tx = (n.data && n.data.transaction_id) ? n.data.transaction_id : '';

                        return `
                        <div class="p-3 border-b ${isUnread ? 'bg-gray-50' : ''}" data-id="${n.id}">
                            <div class="flex justify-between items-start gap-2">
                                <div>
                                    <div class="text-sm text-gray-800">${message}</div>
                                    <div class="text-xs text-gray-500 mt-1">Order #${orderId}${tx ? ' • TX: ' + tx : ''}</div>
                                </div>
                                <div class="text-xs">
                                    <button class="mark-read text-blue-600">Tandai</button>
                                </div>
                            </div>
                            <div class="text-xs text-gray-400 mt-2">${created}</div>
                        </div>`;
                    };

                    if (data.unread && data.unread.length) {
                        data.unread.forEach(n => {
                            notifList.innerHTML += renderItem(n, true);
                        });
                    } else {
                        // if no unread, show small hint
                        if ((!data.read || data.read.length === 0)) {
                            notifList.innerHTML = '<div class="p-3 text-sm text-gray-500">Belum ada notifikasi.</div>';
                        }
                    }

                    if (data.read && data.read.length) {
                        data.read.forEach(n => {
                            notifList.innerHTML += renderItem(n, false);
                        });
                    }

                    // attach listeners to mark-read buttons
                    document.querySelectorAll('#notif-list .mark-read').forEach(btn => {
                        btn.addEventListener('click', async function (e) {
                            const parent = e.target.closest('[data-id]');
                            const id = parent.getAttribute('data-id');
                            await markAsRead(id);
                            parent.remove();
                            // refresh count
                            fetchNotifs();
                        });
                    });

                } catch (err) {
                    notifList.innerHTML = '<div class="p-3 text-sm text-red-500">Gagal memuat notifikasi.</div>';
                    console.error(err);
                }
            }

            async function markAsRead(id) {
                try {
                    await fetch(`/notifications/${id}/read`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        credentials: 'same-origin',
                    });
                } catch (err) {
                    console.error('Mark as read failed', err);
                }
            }

            async function markAllRead() {
                try {
                    await fetch(`/notifications/mark-all-read`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        credentials: 'same-origin',
                    });
                    fetchNotifs();
                } catch (err) {
                    console.error('Mark all read failed', err);
                }
            }

            // Toggle dropdown
            btnToggle.addEventListener('click', async function (e) {
                e.stopPropagation();
                isOpen = !isOpen;
                dropdown.classList.toggle('hidden', !isOpen);
                if (isOpen) {
                    // load notifications on open
                    fetchNotifs();
                }
            });

            // mark all read
            if (markAllBtn) {
                markAllBtn.addEventListener('click', async function(e) {
                    e.preventDefault();
                    await markAllRead();
                });
            }

            // close dropdown when click outside
            document.addEventListener('click', function() {
                if (isOpen) {
                    isOpen = false;
                    dropdown.classList.add('hidden');
                }
            });

            // polling: update count periodically (every 15s)
            setInterval(fetchNotifs, 15000);

            // initial fetch to update badge on page load
            fetchNotifs();
        });
        </script>

    </body>
</html>
