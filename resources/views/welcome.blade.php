<!DOCTYPE html>
<html lang="id" class="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lokalicious - Pesan Makanan & Minuman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f5f9f6;
            font-family: 'Poppins', sans-serif;
            transition: background 0.3s, color 0.3s;
        }

        /* 🌙 Mode gelap */
        .dark-mode {
            background-color: #121212 !important;
            color: #e2e2e2 !important;
        }

        .dark-mode .navbar {
            background: #1f1f1f !important;
            border-bottom: 1px solid #333 !important;
        }

        .dark-mode .navbar-brand span {
            color: #90ee90 !important;
        }

        .dark-mode .card {
            background: #1f1f1f !important;
            color: #e2e2e2 !important;
            border: 1px solid #333 !important;
        }

        .dark-mode footer {
            background: linear-gradient(90deg, #0a3d0f, #062e0b) !important;
        }

        /* tombol dark mode */
        .toggle-dark {
            border: none;
            background: #2E7D32;
            color: white;
            padding: 6px 10px;
            border-radius: 50%;
            font-size: 18px;
            cursor: pointer;
            transition: 0.3s;
        }

        .toggle-dark:hover {
            background: #1B5E20;
        }

        /* Existing styles bawah ini tetap */
        .navbar {
            background: #ffffff !important;
            border-bottom: 1px solid #e0e0e0;
        }
        .navbar-brand img {
            width: 80px;
            transition: transform 0.3s ease;
        }
        .navbar-brand img:hover {
            transform: scale(1.1);
        }
        .navbar-brand span {
            color: #2E7D32;
            font-weight: 600;
        }
        .navbar .btn {
            border-radius: 20px;
        }
        .btn-outline-light {
            border: 1px solid #2E7D32 !important;
            color: #2E7D32 !important;
        }
        .btn-outline-light:hover {
            background: #2E7D32 !important;
            color: white !important;
        }
        .btn-success {
            background: #2E7D32 !important;
        }

        .hero {
            background: url('https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=1200&q=80') no-repeat center center;
            background-size: cover;
            height: 75vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            position: relative;
        }
        .hero::after {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(46, 125, 50, 0.55);
        }
        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            animation: fadeInUp 1.2s ease-out;
        }
        .hero h1 {
            font-size: 3rem;
            font-weight: 700;
        }

        .card {
            border: none;
            border-radius: 15px;
            transition: all 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(76, 175, 80, 0.2);
        }
        .card-title {
            color: #2E7D32;
            font-weight: 600;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        footer {
            background: linear-gradient(90deg, #388E3C, #1B5E20);
            color: white;
            padding: 15px 0;
            text-align: center;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-light shadow-sm">
        <div class="container">

            <a class="navbar-brand fw-bold d-flex align-items-center" href="#">
                <img src="{{ asset('img/logo.png') }}" alt="Lokalicious">
                <span class="ms-2">Lokalicious</span>
            </a>

            <!-- tombol hamburger -->
            <button class="navbar-toggler" type="button" onclick="toggleMenu()">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- 🌙 tombol dark mode versi mobile -->
            <button class="toggle-dark d-lg-none ms-2" onclick="toggleDarkMode()">🌙</button>

            <div class="collapse navbar-collapse justify-content-end" id="mainMenu">
                <ul class="navbar-nav me-3">
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item">
                                <a href="{{ url('/dashboard') }}" class="btn btn-outline-light btn-sm me-2">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="btn btn-outline-light btn-sm">Logout</button>
                                </form>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm me-2">Login</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a href="{{ route('register') }}" class="btn btn-success btn-sm">Register</a>
                                </li>
                            @endif
                        @endauth
                    @endif
                </ul>

                <!-- 🌙 tombol dark mode desktop -->
                <button class="toggle-dark d-none d-lg-inline" onclick="toggleDarkMode()">🌙</button>
            </div>
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero">
        <div class="hero-content">
            <h1>Selamat Datang di <span style="color:#C8E6C9;">Lokalicious!</span></h1>
            <p>Pesan makanan & minuman lokal favoritmu dengan mudah, cepat, dan lezat.</p>
            <div class="mt-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-light btn-lg shadow-sm">Masuk ke Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg me-2">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-success btn-lg shadow">Register</a>
                @endauth
            </div>
        </div>
    </section>

    <!-- FEATURES -->
    <section class="container my-5">
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="card p-4 shadow-sm">
                    <img src="https://cdn-icons-png.flaticon.com/512/2921/2921822.png" width="70" class="mx-auto mb-3">
                    <h5 class="card-title">Produk Lezat</h5>
                    <p class="card-text">Temukan aneka kuliner lokal yang menggugah selera dan 100% halal.</p>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card p-4 shadow-sm">
                    <img src="https://cdn-icons-png.flaticon.com/512/1046/1046784.png" width="70" class="mx-auto mb-3">
                    <h5 class="card-title">Pesan Mudah</h5>
                    <p class="card-text">Pilih menu favoritmu dan pesan hanya dengan beberapa klik saja!</p>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card p-4 shadow-sm">
                    <img src="https://cdn-icons-png.flaticon.com/512/3649/3649468.png" width="70" class="mx-auto mb-3">
                    <h5 class="card-title">Pantau Pesanan</h5>
                    <p class="card-text">Lacak status pesananmu secara real-time dan nikmati kemudahan digital.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <p>© 2025 Lokalicious. Dibuat dengan ❤️ oleh Tim Pengembang.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function toggleMenu() {
            document.getElementById('mainMenu').classList.toggle('show');
        }

        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
        }
    </script>

</body>
</html>
