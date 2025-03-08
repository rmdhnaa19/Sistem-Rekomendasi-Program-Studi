<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Rekomendasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-nav .nav-item {
            margin-right: 15px;
        }

        .nav-link:hover, .nav-link.active {
            color: #e3a33b !important;
            font-weight: bold;
        }

        .btn-warning {
            font-size: 18px;
            font-weight: bold;
            padding: 12px 20px;
            border-radius: 8px;
        }
        
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        main {
            flex: 1;
            padding-top: 80px; 
        }

        footer {
            background-color: #0a0f54;
            color: white;
            text-align: center;
            padding: 15px 0;
            width: 100%;
            margin-top: 0 !important;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top" style="background-color: white; padding: 10px 0; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="{{ $profile && $profile->logo ? asset('storage/' . $profile->logo) : '/images/default-logo.png' }}" alt="Logo" height="50" class="me-2"> 
                <span style="font-weight: bold; font-size: 22px; color: #2d6cdf;">
                    PMB <span style="color: #0a2756;">Poliwangi</span>
                </span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pengguna.beranda') ? 'active' : '' }}" href="{{ route('pengguna.beranda') }}" style="color: #0a2756; font-size: 20px; font-weight: 500;">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pengguna.konsultasi.index') ? 'active' : '' }}" href="{{ route('pengguna.konsultasi.index') }}" style="color: #0a2756; font-size: 20px; font-weight: 500;">Konsultasi</a>
                    </li>
                    <li class="nav-item ms-2">
                        <a class="btn" href="{{ route('login.index') }}" style="background-color: #e3a33b; color: white; font-size: 18px; font-weight: 500; border-radius: 10px; padding: 10px 15px;">Login Admin →</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->

    <main>
        @section('content')
        @show
    </main>

    <!-- Footer -->
    <footer>
        &copy; {{ date('Y') }} PMB Poliwangi. All Rights Reserved.
    </footer>
    <!-- End Footer -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
