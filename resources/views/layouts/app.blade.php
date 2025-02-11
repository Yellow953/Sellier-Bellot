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

    <link rel="shortcut icon" href="{{ asset('assets/images/logo.png') }}" type="image/x-icon">

    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Muli:300,300i,400,400i,600,600i,700,700i%7CComfortaa:300,400,700"
        rel="stylesheet">
    <link href="{{ asset('assets/css/line-awesome.min.css') }}" rel="stylesheet">

    <!-- Theme -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/app-lite.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/core/menu/menu-types/vertical-menu.css') }}">
</head>

<body class="vertical-layout vertical-menu 2-columns menu-expanded fixed-navbar">
    @include('layouts._header')

    @include('layouts._sidenav')

    <div class="app-content content main-content" id="main-content">
        <div class="content-wrapper">
            @include('layouts._breadcrumb')

            <div class="content-body">
                @include('layouts._flash')

                @yield('content')
            </div>
        </div>
    </div>

    @include('layouts._footer')

    <!-- Theme JS-->
    <script src="{{ asset('assets/vendors/js/vendors.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/core/app-menu-lite.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/core/app-lite.js') }}" type="text/javascript"></script>

    {{-- sweetalert --}}
    <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>

    {{-- custom --}}
    <script src="{{ asset('assets/js/custom.js') }}"></script>
</body>

</html>