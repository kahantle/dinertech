<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Dinertech</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/customer/images/favicon.ico')}}" />
    @include('admin.layouts.login_head')
</head>

<body>
    @yield('content')
    @include('admin.layouts.login_script')
</body>