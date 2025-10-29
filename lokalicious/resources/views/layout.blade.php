<!DOCTYPE html>
<html>
<head>
    <title>Lokalicious</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h1>Lokalicious</h1>
    <nav class="mb-3">
        <a href="{{ route('home') }}">Beranda</a> |
        @auth
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('products.index') }}">Produk</a> |
                <a href="{{ route('orders.monitoring') }}">Monitoring Pesanan</a> |
            @else
                <a href="{{ route('orders.index') }}">Pesanan Saya</a> |
                <a href="{{ route('orders.create') }}">Buat Pesanan</a> |
            @endif
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button class="btn btn-sm btn-danger">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}">Login</a>
        @endauth
    </nav>

    @yield('content')
</div>
</body>
</html>
