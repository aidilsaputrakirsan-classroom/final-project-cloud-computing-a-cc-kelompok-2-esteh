<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lokalicious - Pesan Makanan & Minuman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f9fafb;
        }
        .hero {
            background: url('https://images.unsplash.com/photo-1600891964599-f61ba0e24092?auto=format&fit=crop&w=1200&q=80') no-repeat center center;
            background-size: cover;
            height: 70vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            text-shadow: 2px 2px 6px rgba(0,0,0,0.7);
        }
        .btn-custom {
            min-width: 150px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">Lokalicious</a>
            <div class="collapse navbar-collapse justify-content-end">
                <ul class="navbar-nav">
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item">
                                <a href="{{ url('/dashboard') }}" class="nav-link">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="btn btn-outline-danger btn-sm">Logout</button>
                                </form>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{ route('login') }}" class="btn btn-primary btn-sm btn-custom me-2">Login</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a href="{{ route('register') }}" class="btn btn-success btn-sm btn-custom">Register</a>
                                </li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero text-center">
        <div>
            <h1 class="display-4 fw-bold">Selamat Datang di Lokalicious!</h1>
            <p class="lead">Pesan makanan dan minuman favoritmu dengan mudah dan cepat.</p>
            <div class="mt-4">
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg me-2">Login</a>
                <a href="{{ route('register') }}" class="btn btn-success btn-lg">Register</a>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="container my-5">
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100 p-4">
                    <h5 class="card-title">Produk Lezat</h5>
                    <p class="card-text">Temukan beragam makanan dan minuman lokal yang menggugah selera.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100 p-4">
                    <h5 class="card-title">Pesan Mudah</h5>
                    <p class="card-text">Cukup klik, pilih, dan pesan, makanan siap diantarkan ke kamu.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100 p-4">
                    <h5 class="card-title">Monitoring Pesanan</h5>
                    <p class="card-text">Pantau pesananmu secara real-time dan tetap up-to-date.</p>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
