<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Stockly | ERetailer</title>
    <meta name="author" content="Kepha Okello">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="images/logo.png">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="header-and-nav">

    </div>
    <div class="body-content-div">
        @yield('content')
    </div>
</body>
<footer>
    <div class="pull-right">Order Tracker, Powered by <a href="https://www.dtockly.com" target="_blank">Stockly</a> &copy; {{date('Y')}} - <a href="https://github.com/donksly" target="_blank"><i class="fa fa-github"></i></a></div>
</footer>
<script src="{{asset('js/app.js')}}"></script>
</html>