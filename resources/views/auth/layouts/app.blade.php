<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sellier & Bellot</title>

    <link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('auth/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('auth/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('auth/css/login.css') }}">
</head>

<body>
    <main class="d-flex align-items-center min-vh-100 py-3 py-md-0">
        <div class="container">
            <div class="card login-card">
                <div class="row no-gutters">
                    <div class="col-md-5">
                        <img src="{{ asset('auth/images/guns.png') }}" alt="login" class="login-card-img">
                    </div>
                    <div class="col-md-7">
                        <div class="card-body">
                            <div class="brand-wrapper d-flex align-items-center">
                                <img src="{{ asset('assets/images/logo.png') }}" alt="logo" class="logo" width="75"
                                    height="75">
                                <h1 class="px-3">Sellier & Bellot</h1>
                            </div>
                            <p class="login-card-description">Sign into your account</p>
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>
