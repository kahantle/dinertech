<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8" content="{{route('customer.index')}}" id="base-url">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/customer/images/favicon.ico')}}" />
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>{{$title}}</title>
    @include('customer-layouts.head')
</head>

<body>
    @include('customer-layouts.header')
    @yield('content')
    @include('customer-layouts.script')
</body>
</html>