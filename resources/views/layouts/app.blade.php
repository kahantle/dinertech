<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="Bootstrap, Parallax, Template, Registration, Landing">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="author" content="Grayrids">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="base-url" content="{{ url('') }}" />
    <title>{{ config('app.name', 'Dinertech') }}</title>
    <link rel="stylesheet" href="{{ asset('/assets/css/bootstrap.min.css') }}">
    <link rel=icon type="image/x-icon" href="{{ asset('img/favicon.ico') }}" />

    <link rel="stylesheet" href="{{ asset('/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/fonts/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/font-awesome.min.css') }}">
    <link href="{{ asset('/assets/css/preloader.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/css/toastr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/css/print.min.css') }}" rel="stylesheet">

    <style> 
        .someBlock {
            background: #fff no-repeat 50% 50%;
            background-size: contain;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.19), 0 6px 6px rgba(0, 0, 0, 0.23);
            height: 50vh;
            margin: 5vh auto;
            position: relative;
        }

        .preloader {
            z-index: 100000000000;
        }

    </style>
    @yield('css')
</head>

<body>
    @yield('content')
    <script src="{{ asset('assets/js/jquery.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert2@10.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    {!! Toastr::message() !!}
    @yield('scripts')
    <script>
        var toastrSetting = @json(Config::get('constants.toster'));
    </script>
    <script src="{{ asset('/assets/js/jquery.preloader.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/print.min.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
</body>

</html>
