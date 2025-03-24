<!doctype html>
<html lang="en">

<head>
    <title>{{$title}} - Dinertech</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8" content="{{route('customer.index')}}" id="base-url">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Js for date  --}}<!-- jQuery (Required) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- jQuery UI (Required for datepicker) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/customer/images/favicon.ico')}}" />
    <style>
        button.owl-prev{
            border: none;
            background: transparent;
            position: absolute;
            left: -19px;
            top: 30%;
        }
        button.owl-next {
            border: none;
            background: transparent;
            position: absolute;
            right: -19px;
            top: 30%;
        }
        .header-container {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            width: 100%;
            padding: 10px;
        }

        .logo-img-ar {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }

        .right-icon {
            position: absolute;
            right: 20px;
            font-size: 24px;
            cursor: pointer;
        }

    </style>
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    @include('customer-layouts.head')
</head>

<body>
    <main class="wd-ar-main">
        @include('customer-layouts.header')
        @yield('content')
    </main>
    @include('customer-layouts.script')
</body>
<script>
    feather.replace(); // Ensures Feather icons load properly
</script>
</html>
