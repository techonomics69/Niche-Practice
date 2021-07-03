@extends('master')

@section('pageTitle', 'Account Delete')

@section('content')
    <section style="height: 100vh; overflow: hidden">
        <div class="new-login-box">

            <div class="login-link text-right p-t-20"><a href="{{ route('login') }}">Log in</a></div>

            <div class="login-logo">
                <img align="NichePractice" src="{{ asset('public/images/logo-register.png') }}" class="logo" />
            </div>
            <div class="login-heading">
                <h2 class="box-title m-b-0 m-t-30">Your account has been closed.</h2>
                <h4 class="m-b-30 m-t-20">Thank your for using NichePractice. You are welcome back anytime!</h4>
            </div>
        </div>

        <img src="{{ asset('public/images/delete-footer.png') }}" class="footer-image" />
    </section>
@endsection

@section('css')
    <style>
        .box-title{
            font-size: 4rem;
            font-weight: bold;
        }
        .footer-image{
            position: fixed;
            width: 100%;
            min-width: 1300px;
            bottom: -150px;
            left: 50%;
            transform: translateX(-50%);
            z-index: -1;
        }
        @media screen and (max-width: 1080px){
            .footer-image{
                bottom: 0;
                min-width: 900px;
            }
        }
    </style>
@endsection

@section('js')

@endsection
