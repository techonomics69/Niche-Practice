<?php
$hidePartials = true;
?>
@extends('index')

@section('pageTitle', 'OnBoarding')

@section('content')

    <div class="contacts-list  Onboarding-body">
        <div class="container">
            <div class="center-logo">
                <a href="{{ route('home') }}">   <img class="logo" src="{{ asset('public/images/logo-new.png') }}"/></a>
            </div>
            <div class="card align-items-center" style="width: 90%; margin: auto">

                <div class="row">
                    <div class="col-lg-6 notfont-section-left">
                        <h1 >Oops!</h1>
                        <h2>We couldn’t find the page you were looking for.</h2>
{{--                        <p>Error code: 404</p>--}}
                        <p class="m-b-0">Here are some helpful links instead:</p>
                        <ul>
                            <li><a href="{{ route('home') }}">Dashboard</a></li>
                            <li><a href="{{ route('reviews') }}">Monitor Reviews</a></li>
                            <li><a href="{{ route('front.new-patient-emails') }}">Email Marketing</a></li>
                            <li><a href="{{ route('social-posts') }}">Social Media</a></li>
                            <li><a href="{{ route('promotions-list') }}">Promotions</a></li>
                            <li><a href="{{ route('marketingpro') }}">Marketing Pro</a></li>







                        </ul>
                    </div>
                    <div class="col-lg-6">
                        <img class="notfont-img" src="{{ asset('public/images/notfontimg.png') }}"/>
                    </div>

                </div>

                {{--                <div class="card-block text-center">--}}
                {{--                    <h4 class="card-title">--}}
                {{--                        --}}{{--  Please verify your niche selection and Google account information. --}}
                {{--                        Please verify your account information.--}}
                {{--                    </h4>--}}
                {{--                    <p class="niche-head-text">Nichepractice uses this information to analyse your online presence and provide you with a summary of your patient reviews (google, yelp and facebook),--}}
                {{--                        SEO audit of your website, business directory listings and more. </p>--}}
                {{--                    <p class="card-text text-left">--}}
                {{--                        --}}{{--                        Google returned this location information for your business. Please confirm that we have the correct details below.--}}
                {{--                    </p>--}}
                {{--                </div>--}}

            </div>

        </div>
    </div>
{{--    <input type="hidden" id="not_found_page" value="not_found_page" />--}}
    <input type="hidden" id="currentPage" value="not_found_page" />
@endsection

@section('css')
    <style>
        html
        {
            /*background: linear-gradient(-45deg,#547bba 0%,#1d2b3b 100%) !important;*/
            background-color: #33485B !important;
        }
        ul {
            list-style-type: none;
            padding: 0px;
        }
        li a{
            font-weight: bold;
            color: #6298be;
        }
        .notfont-section-left{
            padding: 100px 0px 30px 90px;
            color: #424141;
        }
        .notfont-section-left h1{
            font-weight: 600    ;
            font-size: 55px;
            margin-bottom: 30px;
        }
        .notfont-section-left h2{
            font-weight: 400;
            font-size: 35px;
            margin-bottom: 25px;
        }
        .notfont-section-left p{
            font-weight: bold;
            color: #424141;
        }

        .notfont-img{
            width: 100%;
            margin-top: 70px;

        }
        .center-logo{
            justify-content: left;
            text-align: left;
            padding: 20px 0px 30px 55px !important;
        }
        .form-row
        {
            margin-left: 20px;
            margin-right: 20px;
        }
        .logo1{
            padding: 15px;
        }
        .Onboarding-body {
            /*background: linear-gradient(-45deg,#547bba 0%,#1d2b3b 100%);*/
            background-color: #33485B !important;
            background-attachment: fixed;
        }
        .card{
            padding: 20px 0px;
            border-radius: 40px;
        }
        .card-title{
            Font-size: 22px;
            Font-weight: 700;
            Line-height: 26px;
            color: rgb(74, 74, 74);
            font-family: "source sans pro", "helvetica neue", Helvetica, Roboto, Arial, sans-serif;
            padding: 0px 0px 15px 0px;
        }
        .card-text{
            padding: .73333rem .73333rem .73333rem 1.3rem;
            border-top: .06667rem solid #e1e1e1;
        }
        .input-padding1{
            margin: 0px 0px 0px 7px;
        }
        .prevButton{
            border: none;
            background: none;
            font-size: 15px;
            margin-top: 15px;
            Font-size: 15px;

            Line-height: normal;
            color: rgb(130, 130, 130)
        }
        .nextbutton{
            Font-size: 15px;
            Font-weight: 700;
            Line-height: normal;
            color: rgb(63, 99, 156);
            border: none;
            background: none;
            font-size: 15px;
            margin-top: 15px;
        }
        .fa-chevron-left{
            font-size: 12px;
            padding: 0px 8px 0px 0px;
        }
        .fa-chevron-right{
            font-size: 12px;
            padding: 0px 0px 0px 8px;
        }
        input.form-control {
            border: .06667rem solid #c3c3c3;
        }
        select.form-control{
            border: .06667rem solid #c3c3c3;
        }
        .putin.active .input-field{
            padding-top: 18px;
        }
        .putin .input-label .label-text{
            left: 35px;
        }
        .putin.active .input-label .label-text{
            left: 5px;
        }

        @media(min-width:900px) and (max-width:1500px) {
            .center-logo {
                padding: 70px 0px 70px 0px;
            }
        }
        @media screen and (max-width: 425px){
            .notfont-section-left{
                padding: 10px 0px 0px 20px;
            }
        }
    </style>
@endsection

@section('js')

@endsection


