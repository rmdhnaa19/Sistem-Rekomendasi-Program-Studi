<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Rekomendasi</title>
    <link rel="icon" href="{{ asset('storage/asset_web/logo-poliwangi.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            font-family: 'Poppins', sans-serif;
        }

        main {
            flex: 1;
            padding-top: 80px;
        }

        footer {
            background-color: #005FB1;
            color: white;
            text-align: center;
            padding: 15px 0;
        }

        .navbar-nav .nav-item {
            margin-right: 10px;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #FDA702 !important;
            font-weight: bold;
        }

        .btn-warning {
            font-size: 16px;
            font-weight: bold;
            padding: 12px 20px;
            border-radius: 8px;
        }

        .navbar-brand img {
            max-height: 50px;
            height: auto;
            width: auto;
        }

        @media (max-width: 767.98px) {
            .navbar-nav {
                text-align: center;
            }

            .navbar-nav .nav-item {
                margin-right: 0;
                margin-bottom: 10px;
            }

            .navbar-brand {
                flex-direction: column;
                align-items: start;
            }

            .navbar-brand img {
                max-height: 40px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top bg-white shadow-sm py-2">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                @if($profile && $profile->logo_kampus)
                    <img src="{{ asset('storage/' . $profile->logo_kampus) }}" alt="Logo Kampus" class="me-2">
                @else
                    <img src="/images/default-logo.png" alt="Default Logo" class="me-2">
                @endif

                @if($profile && $profile->logo_pmb)
                    <img src="{{ asset('storage/' . $profile->logo_pmb) }}" alt="Logo PMB">
                @endif
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pengguna.beranda') ? 'active' : '' }}" href="{{ route('pengguna.beranda') }}" style="color: #005FB1; font-size: 16px; font-weight: 500;">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pengguna.konsultasi.index') ? 'active' : '' }}" href="{{ route('pengguna.konsultasi.index') }}" style="color: #005FB1; font-size: 16px; font-weight: 500;">Konsultasi</a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a class="btn" href="{{ route('login.index') }}" style="background-color: #FDA702; color: white; font-size: 16px; font-weight: 500; border-radius: 10px; padding: 10px 15px;">Login Admin →</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @section('content')
        @show
    </main>

    <!-- Footer -->
    <footer>
        &copy; {{ date('Y') }} PMB Poliwangi. All Rights Reserved.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
