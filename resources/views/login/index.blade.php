<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in Sirekom</title>
    <link rel="stylesheet" href="{{ asset('voler-master/dist/assets/css/bootstrap.css') }}">
    <link rel="shortcut icon" href="{{ asset('storage/asset_web/logo-poliwangi.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('voler-master/dist/assets/css/app.css') }}">
</head>

<body>
    @include('sweetalert::alert')
    <div id="auth">
        <div class="container">
            <div class="row">
                <div class="col-md-5 col-sm-12 mx-auto">
                    <div class="card pt-4">
                        <div class="card-body">
                            <div class="text-center mb-5">
                                <img src="{{ asset('storage/asset_web/pmb-poliwangi.png') }}" height="50" class='mb-4'>
                                <h3>Sign In</h3>
                                <p>Sign In untuk Mengakses Sirekom</p>
                            </div>
                            @if (session()->has('loginError'))
                                <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                                    {{ session('loginError') }}
                                </div>
                            @endif
                            <form action="/login" method="post">
                                @csrf
                                <div class="form-group position-relative has-icon-left">
                                    <label for="username">Username</label>
                                    <div class="position-relative">
                                        <input type="text"
                                            class="form-control @error('username') is-invalid @enderror" id="username"
                                            name="username" value="{{ old('username') }}" autofocus required>
                                        <div class="form-control-icon">
                                            <i data-feather="user"></i>
                                        </div>
                                    </div>
                                    @if ($errors->has('username'))
                                        <span class="text-danger">{{ $errors->first('username') }}</span>
                                    @endif
                                </div>
                                <div class="form-group position-relative has-icon-left">
                                    <div class="clearfix">
                                        <label for="password">Password</label>
                                        {{-- <a href="#" class='float-right'>
                                            <small>Forgot password?</small>
                                        </a> --}}
                                    </div>
                                    <div class="position-relative">
                                        <input type="password"
                                            class="form-control @error('password') is-invalid @enderror" id="password"
                                            name="password" required>
                                        <div class="form-control-icon">
                                            <i data-feather="lock"></i>
                                        </div>
                                    </div>
                                    @if ($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>

                                <div class='form-check clearfix my-4'>
                                    <div class="checkbox float-left">
                                        <input type="checkbox" id="checkbox1" class='form-check-input' name="remember"
                                            id="remember">
                                        <label for="checkbox1">Remember me</label>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary col-12">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script src="{{ asset('voler-master/dist/assets/js/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('voler-master/src/assets/js/app.js') }}"></script>
    <script src="{{ asset('voler-master/src/assets/js/main.js') }}"></script>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>

</html>
