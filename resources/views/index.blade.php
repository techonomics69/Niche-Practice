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

    <!-- Font special for pages-->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    @yield('before_css')
    <link type="text/css" rel="stylesheet" href="{{ asset('public/plugins/sweetalert/sweetalert.css?ver='.$appFileVersion) }}">

    <link type="text/css" href="{{ asset('public/plugins/custom-select/custom-select.css') }}" rel="stylesheet" />

    <link type="text/css" href="{{ asset('public/css/app/style.css?ver='.$appFileVersion) }}" rel="stylesheet" />
    <link type="text/css" href="{{ asset('public/css/app/colors/default.css?ver='.$appFileVersion) }}" rel="stylesheet" />


    <link type="text/css" href="{{ asset('public/plugins/sidebar-nav/dist/sidebar-nav.min.css') }}" rel="stylesheet" />

@yield('css')

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

{{--<body class="fix-header bg-img-1">--}}
<body class="sidebar-hide {{ (empty($hidePartials)) ? 'fix-header' : 'login-page-bg' }}">

    <?php
        $countries = getCountries();

        $countryCodes = $countries['countryCodes'];

    ?>

{{-- <div id="loader">--}}
{{--     <div class="loader-inner">--}}
{{--    </div>--}}
{{--</div>--}}
{{--<div class="page-wrapper bg-img-1 p-t-275 p-b-100">--}}

<div class="preloader">
    <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
    </svg>
</div>

<div id="wrapper" class="page-wrapper">

    @if(empty($hidePartials))
        @include('partials.header')

        @include('partials.sidebar')
    @elseif(!empty($showHeader))
            @include('partials.header')
    @endif

        @if (session('message'))
            <div class="global-error-message a-message alert {{ (session('messageCode') != 200) ? 'alert-danger' : 'alert-success' }}">
                {{ session('message') }}
            </div>
        @endif

    @yield('content')

@include('partials.popup-manager')


    @if(empty($hidePartials))
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <?php

                        ?>
                        <div class="col-sm-4" style="color: #0897f5;font-size: 15px; <?php echo (Request::url() == route('home')) ? 'visibility:hidden;' : 'visibility:hidden;'; ?>">
                            <i class="fa fa-question-circle-o" style="color: #7d8080;/* transform: scaleX(-1); */margin-right: 5px;"></i>
                            <a style="color: #0897f5;" class="page-help" href="javascript:void(0)">Get help for this page</a>
                        </div>

                        <div class="col-sm-6 text-center" style="color: #7d8080;">
                            Copyright © 2020 NichePractice All rights reserved.
                        </div>
                        <div class="col-sm-2 text-right" style="color: #0897f5; display: none;">
                            <i class="fa fa-comments" aria-hidden="true" style="
    color: #7d8080;
    margin-right: 5px;
"></i>
                            Contact Support
                        </div>
                    </div>
                </div>
            </footer>
    @endif
</div>

<input type="hidden" id="hfBaseUrl" value="{{ URL('/') }}" />
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<input type="hidden" id="userUpgradeStatus" value="{{ ( !empty($userData['subscriptionStatus']['subscription_remaining_days'])) ? $userData['subscriptionStatus']['subscription_type'] : 'trial'  }}">
<input type="hidden" id="isActivePaid" value="{{ isActivePaid()  }}">
<input type="hidden" id="appName" value="Nichepractice">

{{--<script src="{{ asset('public/js/jquery.min.js') }}"></script>--}}
<script src="{{ asset('public/js/jquery-2.1.4.min.js') }}"></script>
<script src="{{ asset('public/admin/adminlte/plugins/jQueryUI/jquery-ui.js') }}"></script>
{{--<script src="https://unpkg.com/vue"></script>--}}

    <script src="{{ asset('public/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('public/plugins/sidebar-nav/dist/sidebar-nav.min.js') }}"></script>
<script src="{{ asset('public/plugins/sweetalert/sweetalert.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('public/plugins/slimScroll/jquery.slimscroll.js') }}"></script>

<script type="text/javascript" src="{{ asset('public/js/moment.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/js/transition.js') }}"></script>

<script src="{{ asset('public/plugins/custom-select/custom-select.min.js') }}"></script>

<script src="{{ asset('public/js/custom.js?ver='.$appFileVersion) }}"></script>

<script type="text/javascript" src="{{ asset('public/js/validator.js?ver='.$appFileVersion) }}"></script>

<script type="text/javascript" src="{{ asset('public/js/notification.js?ver='.$appFileVersion) }}"></script>

<script>
    var stripeKey="<?php echo $stripeKey; ?>";
    // var stripeKey = 'pk_test_7g2B5KnqbEwVUO6hVmsBmORE00V3s4jnvx';
</script>


@yield('js')
<input type="hidden" id="module-view" value="{{ ( !(empty($moduleView)) ) ? $moduleView : '' }}" />

@if(empty($hidePartials))
<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/5ec17563967ae56c521a9ff8/default';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
    })();
</script>
<!--End of Tawk.to Script-->
@endif

<script>
    $(".global-error-message").clone().prependTo("#page-wrapper .container-fluid");
    $(".global-error-message:first").remove();
</script>

</body>
</html>
