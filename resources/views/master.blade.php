<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('public/images/favicon.png') }}" />

{{--    <title>NichePractice - @yield('pageTitle')</title>--}}
    <title>nichepractice - @yield('pageTitle')</title>

    <!-- Bootstrap Core CSS -->
    <link type="text/css" href="{{ asset('public/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link type="text/css" href="{{ asset('public/font-awesome/4.7.0/css/font-awesome.min.css') }}" rel="stylesheet" />

    <link type="text/css" href="{{ asset('public/css/style.css?ver='.$appFileVersion) }}" rel="stylesheet" />

@yield('css')

</head>
<body>

<?php
$requestedUrl = Request::url();
?>

@if($requestedUrl == route('register'))
    <img align="" src="{{ asset('public/images/footer-register.png') }}" class="register-bg" />
@endif


    <div class="container">
        @yield('content')
    </div>


<script src="{{ asset('public/js/jquery-2.1.4.min.js') }}"></script>
<script src="{{ asset('public/js/bootstrap.min.js') }}"></script>

<script>
    $(document).ready(function () {
        // alert("called");
        window.history.pushState(null, "", window.location.href);

        setTimeout(function () {
            window.history.pushState(null, "", window.location.href);
        }, 2000)
        window.onpopstate = function () {
            // alert("inside function");
            window.history.pushState(null, "", window.location.href);
        };
    });
</script>
@yield('js')
<input type="hidden" id="hfBaseUrl" value="{{ URL('/') }}" />
</body>
</html>
