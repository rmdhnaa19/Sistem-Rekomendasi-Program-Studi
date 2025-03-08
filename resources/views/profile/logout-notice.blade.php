<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRISM | Harap Login Kembali</title>
    <link rel="stylesheet" href="{{ asset('voler-master/dist/assets/css/bootstrap.css') }}">
    <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('voler-master/dist/assets/css/app.css') }}">
</head>

<body>
    <div id="auth">
        <div class="container">
            <div class="row">
                <div class="col-md-5 col-sm-12 mx-auto">
                    <div class="card py-4">
                        <div class="card-body">
                            <div class="text-center mb-5">
                                {{-- <img src="{{ asset('storage/asset_web/Logo Fluks w Text.png') }}" height="48"
                                    class='mb-4'> --}}
                                <h3>Harap Login Kembali</h3>
                                <p>Profil pengguna berhasil diperbarui</p>
                            </div>
                            <form action="{{ route('login.logout') }}" method="POST"
                                class="d-flex justify-content-center">
                                @csrf
                                <button type="submit" class="btn btn-lg btn-primary">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('voler-master/dist/assets/js/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('voler-master/src/assets/js/app.js') }}"></script>

    <script src="{{ asset('voler-master/dist/assets/js/main.js') }}"></script>
</body>

</html>
