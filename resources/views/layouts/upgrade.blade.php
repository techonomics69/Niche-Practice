@extends('index')

@section('pageTitle', 'User Profile')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid dashboarbgtitle upgrade-plan-container">
        <div class="dashboard-wrapper" >
            <div class="page-head">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="page-title text-center" style="font-size: 40px;margin: 20px 0px 30px 0px;font-weight: 600;"> It's Time to Upgrade</h4>
                    </div>
                </div>
            </div>

            <?php
            $status = 'trial';
            if(!empty($userData['subscriptionStatus']['subscription_remaining_days']) && $userData['subscriptionStatus']['subscription_type'] == 'paid')
            {
                $status = 'paid';
            }
            ?>

            <div class="upgrade-plan-wrapper">
                <div class="row">
                    <div class="col-md-6 task-issues">
                        <div class="white-box full-page-view upgrade-page-bg " style="margin-bottom: 0px; min-height: 613px; padding-top: 0px; margin-top:0px !important;">
                            <div class="page-content">



                                <div class="clearfix"></div>
                                <div class="website-task-panel">

                                    <div class="row">
{{--                                        <div class="col-md-4 m-t-5">--}}

{{--                                        </div>--}}
                                        @if($status == 'trial')

{{--                                            old design--}}

{{--                                        <div class="upgrade-ok-img" >--}}
{{--                                            <div class=" col-md-12" style="border:  1px solid #DFE0E4; padding-bottom: 5px;">--}}
{{--                                                <h4 style="color: #3B4954; font-size: 20px; font-weight: bold;" class=" " >Select Your Plan:</h4>--}}
{{--                                                <section id="custom-radio-buttons">--}}
{{--                                                    <div class="radio-wrapper">--}}
{{--                                                        <input type="radio" id="radio1" class="tab-selector" name="custom-radio" data-target="myself-menu" checked />--}}
{{--                                                        <label for="radio1">--}}
{{--                                                            <span class="outer">--}}
{{--                                                                <span class="inner animated"></span>--}}
{{--                                                            </span>--}}
{{--                                                            Do-It-Myself--}}
{{--                                                        </label>--}}
{{--                                                    </div>--}}

{{--                                                    <div class="radio-wrapper" style="margin-left: 20px;">--}}
{{--                                                        <input type="radio" class="tab-selector" id="radio2" name="custom-radio" data-target="for-me" />--}}
{{--                                                        <label for="radio2">--}}
{{--                                                            <span class="outer">--}}
{{--                                                                <span class="inner animated" ></span>--}}
{{--                                                            </span>--}}
{{--                                                            Do-It-For-Me--}}
{{--                                                        </label>--}}
{{--                                                    </div>--}}
{{--                                                </section>--}}


{{--                                            </div>--}}
{{--                                        </div>--}}


{{--                                            <div class="upgrade-ok-img" style="margin-bottom: 40px;" >--}}
{{--                                                <div class=" col-md-12 select-box-border tab-selector myDiv active "  id="box1"  data-target="myself-menu" style="border:  1px solid #DFE0E4; padding-bottom: 5px;">--}}
{{--                                                    <div class="tick-box">--}}
{{--                                                        <div class="myself-heading">--}}
{{--                                                            <h2 class="select-box m-b-0 myDivv select-color select-box-h1  ">Do-It-Myself</h2>--}}
{{--                                                        </div>--}}
{{--                                                        <div class="myself-tick">--}}
{{--                                                            <img src="{{asset('public/images/greenTick.png')}}" alt="" class="img-fluid">--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                    <h2 class="select-box m-t-0">$15/Mo.</h2>--}}

{{--                                                    <p class="select-box-p">--}}
{{--                                                        Access tools and tips to simplify the mystery of marketing. Be your own expert with hands-on help from marketing pros when you need it.--}}
{{--                                                    </p>--}}
{{--                                                    <a href="https://nichepractice.com/pricing/" target="_blank" class="select-box-link">More</a>--}}

{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="upgrade-ok-img"  >--}}
{{--                                                <div class=" col-md-12 select-box-border tab-selector myDiv"  id="box2" data-target="for-me" style="border:  1px solid #DFE0E4; padding-bottom: 5px;">--}}
{{--                                                    <h2 class="select-box m-b-0 myDivv    " >Do-It-For-Me</h2>--}}
{{--                                                    <h2 class="select-box m-t-0 ">Contact Us</h2>--}}
{{--                                                    <p class="select-box-p">--}}
{{--                                                        Dominate your local market with customized and comprehensive professional marketing services. Get everything done at a price you can afford.--}}
{{--                                                    </p>--}}
{{--                                                    <a href="https://nichepractice.com/pricing/" target="_blank" class="select-box-link">More</a>--}}

{{--                                                </div>--}}
{{--                                            </div>--}}
                                            <div class="col-sm-12">
                                                <div class="card cardStyle" style="height: 100%">
    {{--                                                <img class="card-img-top" src="..." alt="Card image cap">--}}
                                                    <div class="card-body" style="text-align: left;height: 100%">
                                                        <h1 class="card-title" style="font-weight: 900;color: #000;">$199 / month</h1>
                                                        <h2 class="card-title freeCredits">200 free credits</h2>
                                                        <div class="" style="display: flex;align-items: center;">
                                                            <p style="margin-bottom: 0;display: flex;align-items: center">
                                                                <img src="{{asset('public/images/banner03.png')}}" alt="" style="height: 20px;width: 20px; margin-right:8px">
                                                                Monitor online reviews
                                                            </p>
                                                        </div>
                                                        <div class="" style="display: flex;align-items: center;">
                                                            <p style="margin-bottom: 0;display: flex;align-items: center">
                                                                <img src="{{asset('public/images/banner03.png')}}" alt="" style="height: 20px;width: 20px; margin-right:8px">
                                                                Directory Submissions
                                                            </p>
                                                        </div>
                                                        <div class="" style="display: flex;align-items: center;">
                                                            <p style="margin-bottom: 0;display: flex;align-items: center">
                                                                <img src="{{asset('public/images/banner03.png')}}" alt="" style="height: 20px;width: 20px; margin-right:8px">
                                                                Website / SEO audit
                                                            </p>
                                                        </div>
                                                        <div class="" style="display: flex;align-items: center;">
                                                            <p style="margin-bottom: 0;display: flex;align-items: center">
                                                                <img src="{{asset('public/images/banner03.png')}}" alt="" style="height: 20px;width: 20px; margin-right:8px">
                                                                Email marketing
                                                            </p>
                                                        </div>
                                                        <div class="" style="display: flex;align-items: center;">
                                                            <p style="margin-bottom: 0;display: flex;align-items: center">
                                                                <img src="{{asset('public/images/banner03.png')}}" alt="" style="height: 20px;width: 20px; margin-right:8px">
                                                                Social media posting
                                                            </p>
                                                        </div>
                                                        <div class="" style="display: flex;align-items: center;">
                                                            <p style="margin-bottom: 0;display: flex;align-items: center">
                                                                <img src="{{asset('public/images/banner03.png')}}" alt="" style="height: 20px;width: 20px; margin-right:8px">
                                                                Curated Social Content
                                                            </p>
                                                        </div>
                                                        <div class="" style="display: flex;align-items: center;">
                                                            <p style="margin-bottom: 0;display: flex;align-items: center">
                                                                <img src="{{asset('public/images/banner03.png')}}" alt="" style="height: 20px;width: 20px; margin-right:8px">
                                                                Special Offers / Promotions
                                                            </p>
                                                        </div>
                                                        <div class="" style="display: flex;align-items: center;">
                                                            <p style="margin-bottom: 0;display: flex;align-items: center">
                                                                <img src="{{asset('public/images/banner03.png')}}" alt="" style="height: 20px;width: 20px; margin-right:8px">
                                                                Campaign Marketplace
                                                            </p>
                                                        </div>
                                                        <div style="margin-right: 25px;">

                                                            <footer class="footer1">Credits can be used to purchase campaigns and digital media with your subscription.</footer>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="upgrade-ok-img" style="margin-bottom: 40px;" >
                                                <div class=" col-md-12 select-box-border tab-selector myDiv active"  id="box1"  data-target="myself-menu" style="border:  1px solid #DFE0E4; padding-bottom: 5px;">
                                                    <div class="tick-box">
                                                        <div class="myself-heading">
                                                            <h2 class="select-box m-b-0 myDivv select-color select-box-h1  ">Do-It-Myself</h2>
                                                        </div>
                                                        <div class="myself-tick">
                                                            <img src="{{asset('public/images/greenTick.png')}}" alt="" class="img-fluid">
                                                        </div>
                                                    </div>
                                                    <h2 class="select-box m-t-0">$15/Mo.</h2>

                                                    <p class="select-box-p">
                                                        Access tools and tips to simplify the mystery of marketing. Be your own expert with hands-on help from marketing pros when you need it.
                                                    </p>
                                                    <a href="https://nichepractice.com/pricing/" target="_blank" class="select-box-link">More</a>

                                                </div>
                                            </div>
{{--                                            <div class="upgrade-ok-img"  >--}}
{{--                                                <div class=" col-md-12 select-box-border tab-selector myDiv active"  id="box2" data-target="for-me" style="border:  1px solid #DFE0E4; padding-bottom: 5px;">--}}
{{--                                                    <h2 class="select-box m-b-0 myDivv    " >Do-It-For-Me</h2>--}}
{{--                                                    <h2 class="select-box m-t-0 ">Contact Us</h2>--}}
{{--                                                    <p class="select-box-p">--}}
{{--                                                        Dominate your local market with customized and comprehensive professional marketing services. Get everything done at a price you can afford.--}}
{{--                                                    </p>--}}
{{--                                                    <a href="https://nichepractice.com/pricing/" target="_blank" class="select-box-link">More</a>--}}

{{--                                                </div>--}}
{{--                                            </div>--}}
                                        @endif

                                        <div style="display: none;" class="col-md-12">
                                            <div class="btn-group m-b-20 website-page-tabs">
                                                <ul class="nav nav-tabs rounded-tabs upgrade-tabs" role="tablist">

                                                    @if($status == 'trial')
                                                    <li role="presentation" class="active myself-menu">
                                                        <a href="#now" role="tab">Do-It-Myself</a>
                                                    </li>

                                                    <li class="for-me" role="presentation"><a href="#later" role="tab">Do-It-For-Me</a></li>
                                                    @endif
                                                </ul>
                                            </div>

                                        </div>
                                    </div>

{{--                                    <div class="row">--}}
{{--                                        --}}{{--                                        <div class="col-md-4 m-t-5">--}}

{{--                                        --}}{{--                                        </div>--}}
{{--                                        @if($status == 'paid')--}}

{{--                                            --}}{{--                                            old design--}}

{{--                                            --}}{{--                                        <div class="upgrade-ok-img" >--}}
{{--                                            --}}{{--                                            <div class=" col-md-12" style="border:  1px solid #DFE0E4; padding-bottom: 5px;">--}}
{{--                                            --}}{{--                                                <h4 style="color: #3B4954; font-size: 20px; font-weight: bold;" class=" " >Select Your Plan:</h4>--}}
{{--                                            --}}{{--                                                <section id="custom-radio-buttons">--}}
{{--                                            --}}{{--                                                    <div class="radio-wrapper">--}}
{{--                                            --}}{{--                                                        <input type="radio" id="radio1" class="tab-selector" name="custom-radio" data-target="myself-menu" checked />--}}
{{--                                            --}}{{--                                                        <label for="radio1">--}}
{{--                                            --}}{{--                                                            <span class="outer">--}}
{{--                                            --}}{{--                                                                <span class="inner animated"></span>--}}
{{--                                            --}}{{--                                                            </span>--}}
{{--                                            --}}{{--                                                            Do-It-Myself--}}
{{--                                            --}}{{--                                                        </label>--}}
{{--                                            --}}{{--                                                    </div>--}}

{{--                                            --}}{{--                                                    <div class="radio-wrapper" style="margin-left: 20px;">--}}
{{--                                            --}}{{--                                                        <input type="radio" class="tab-selector" id="radio2" name="custom-radio" data-target="for-me" />--}}
{{--                                            --}}{{--                                                        <label for="radio2">--}}
{{--                                            --}}{{--                                                            <span class="outer">--}}
{{--                                            --}}{{--                                                                <span class="inner animated" ></span>--}}
{{--                                            --}}{{--                                                            </span>--}}
{{--                                            --}}{{--                                                            Do-It-For-Me--}}
{{--                                            --}}{{--                                                        </label>--}}
{{--                                            --}}{{--                                                    </div>--}}
{{--                                            --}}{{--                                                </section>--}}


{{--                                            --}}{{--                                            </div>--}}
{{--                                            --}}{{--                                        </div>--}}

{{--                                            <div class="upgrade-ok-img" style="margin-bottom: 40px;" >--}}
{{--                                                <div class=" col-md-12 select-box-border tab-selector myDiv active "  id="box1"  data-target="myself-menu" style="border:  1px solid #DFE0E4; padding-bottom: 5px;">--}}
{{--                                                    <h2 class="select-box m-b-0 myDivv select-color select-box-h1  ">Do-It-Myself</h2>--}}
{{--                                                    <h2 class="select-box m-t-0">$15/Mo.</h2>--}}

{{--                                                    <p class="select-box-p">--}}
{{--                                                        Access tools and tips to simplify the mystery of marketing. Be your own expert with hands-on help from marketing pros when you need it.--}}
{{--                                                    </p>--}}
{{--                                                    <a href="https://nichepractice.com/pricing/" target="_blank" class="select-box-link">More</a>--}}

{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="upgrade-ok-img"  >--}}
{{--                                                <div class=" col-md-12 select-box-border tab-selector myDiv"  id="box2" data-target="for-me" style="border:  1px solid #DFE0E4; padding-bottom: 5px;">--}}
{{--                                                    <h2 class="select-box m-b-0 myDivv    " >Do-It-For-Me</h2>--}}
{{--                                                    <h2 class="select-box m-t-0 ">Contact Us</h2>--}}
{{--                                                    <p class="select-box-p">--}}
{{--                                                        Dominate your local market with customized and comprehensive professional marketing services. Get everything done at a price you can afford.--}}
{{--                                                    </p>--}}
{{--                                                    <a href="https://nichepractice.com/pricing/" target="_blank" class="select-box-link">More</a>--}}

{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        @endif--}}

{{--                                        <div style="display: none;" class="col-md-12">--}}
{{--                                            <div class="btn-group m-b-20 website-page-tabs">--}}
{{--                                                <ul class="nav nav-tabs rounded-tabs upgrade-tabs" role="tablist">--}}

{{--                                                    @if($status == 'trial')--}}
{{--                                                        <li role="presentation" class="active myself-menu">--}}
{{--                                                            <a href="#now" role="tab">Do-It-Myself</a>--}}
{{--                                                        </li>--}}

{{--                                                        <li class="for-me" role="presentation"><a href="#later" role="tab">Do-It-For-Me</a></li>--}}
{{--                                                    @endif--}}
{{--                                                </ul>--}}
{{--                                            </div>--}}

{{--                                        </div>--}}
{{--                                    </div>--}}

                                    <div class="tab-content website-upgrade-list" style="display: none;">
                                        @if($status == 'trial')
                                        <div class="myself">
{{--                                            <h4 style="color: #5F6073; font-size: 24px;" class="page-title text-center" >Become Your Own Expert</h4>--}}
                                            <div class="upgrade-ok-img">
                                                <div cla class="ok-tick" ss="ok-tick">
                                                    <i style="" class="fa fa-check"></i>
                                                </div>
                                                <div class="upgrade-img-tick">
                                                    <p>Access to marketing pros*</p>
                                                </div>
                                            </div>
                                            <div class="upgrade-ok-img">
                                                <div class="ok-tick">
                                                <i style="" class="fa fa-check"></i>
                                                </div>
                                                <div class="upgrade-img-tick">
                                                    <p>Online review monitoring</p>
                                                </div>
                                            </div>
                                            <div class="upgrade-ok-img">
                                                <div class="ok-tick">
                                                <i style="" class="fa fa-check"></i>
                                                </div>
                                                <div class="upgrade-img-tick">
                                                    <p>Basic content library</p>
                                                </div>
                                            </div>
                                            <div class="upgrade-ok-img">
                                                <div class="ok-tick">
                                                <i style="" class="fa fa-check"></i>
                                                </div>
                                                <div class="upgrade-img-tick">
                                                    <p>Online citations assessment</p>
                                                </div>
                                            </div>
                                            <div class="upgrade-ok-img">
                                                <div class="ok-tick">
                                                <i style="" class="fa fa-check"></i>
                                                </div>
                                                <div class="upgrade-img-tick">
                                                    <p>Website SEO audit</p>
                                                </div>
                                            </div>
                                            <div class="upgrade-ok-img">
                                                <div class="ok-tick">
                                                <i style="" class="fa fa-check"></i>
                                                </div>
                                                <div class="upgrade-img-tick">
                                                    <p>Email marketing</p>
                                                </div>
                                            </div>
                                            <div class="upgrade-ok-img">
                                                <div class="ok-tick">
                                                <i style="" class="fa fa-check"></i>
                                                </div>
                                                <div class="upgrade-img-tick">
                                                    <p>Social media posting</p>
                                                </div>
                                            </div>
                                            <div class="upgrade-ok-img">
                                                <div class="ok-tick">
                                                <i style="" class="fa fa-check"></i>
                                                </div>
                                                <div class="upgrade-img-tick">
                                                    <p>Promotional Marketing</p>
                                                </div>
                                            </div>
                                            <div class="upgrade-ok-img">
                                                <div class="ok-tick">
                                                <i style=" visibility: hidden;" class="fa fa-check"  ></i>
                                                </div>
                                                <div class="upgrade-img-tick">
                                                    <p>Two Marketing Campaings each month</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        <div class="upgrade-contact" style="display: {{ ($status == 'paid') ? 'block' : 'none' }}">
{{--                                            <h4 style="color: #5F6073; font-size: 24px;" class="page-title text-center" >Become the Market Leader</h4>--}}
                                           {{--<h4 class="page-title" style="margin-bottom: 10px; font-size: 24px; text-align: center;">Become the market Leader</h4>--}}
{{--                                            <h3 style="color: #10b7fd;margin-bottom: 20px;" class="">Become the Market Leader</h3>--}}
<div class="upgrade-ok-img">
                                                <div class="ok-tick">
                                                <i style="" class="fa fa-check"></i>
                                                </div>
                                                <div class="upgrade-img-tick">
                                                    <p>Access to marketing pros*</p>
                                                </div>
                                            </div>
                                            <div class="upgrade-ok-img">
                                                <div class="ok-tick">
                                                <i style="" class="fa fa-check"></i>
                                                </div>
                                                <div class="upgrade-img-tick">
                                                    <p>Online review monitoring</p>
                                                </div>
                                            </div>
                                            <div class="upgrade-ok-img">
                                                <div class="ok-tick">
                                                <i style="" class="fa fa-check"></i>
                                                </div>
                                                <div class="upgrade-img-tick">
                                                    <p>Basic content library</p>
                                                </div>
                                            </div>
                                            <div class="upgrade-ok-img">
                                                <div class="ok-tick">
                                                <i style="" class="fa fa-check"></i>
                                                </div>
                                                <div class="upgrade-img-tick">
                                                    <p>Online citations assessment</p>
                                                </div>
                                            </div>
                                            <div class="upgrade-ok-img">
                                                <div class="ok-tick">
                                                <i style="" class="fa fa-check"></i>
                                                </div>
                                                <div class="upgrade-img-tick">
                                                    <p>Website SEO audit</p>
                                                </div>
                                            </div>
                                            <div class="upgrade-ok-img">
                                                <div class="ok-tick">
                                                <i style="" class="fa fa-check"></i>
                                                </div>
                                                <div class="upgrade-img-tick">
                                                    <p>Email marketing</p>
                                                </div>
                                            </div>
                                            <div class="upgrade-ok-img">
                                                <div class="ok-tick">
                                                <i style="" class="fa fa-check"></i>
                                                </div>
                                                <div class="upgrade-img-tick">
                                                    <p>Social media posting</p>
                                                </div>
                                            </div>
                                            <div class="upgrade-ok-img">
                                                <div class="ok-tick">
                                                <i style="" class="fa fa-check"></i>
                                                </div>
                                                <div class="upgrade-img-tick">
                                                    <p>Promotional Marketing</p>
                                                </div>
                                            </div>
                                            <div class="upgrade-ok-img">
                                                <div class="ok-tick">
                                                    <i style=" visibility: hidden;" class="fa fa-check"  ></i>
                                                </div>
                                                <div class="upgrade-img-tick">
                                                    <p>Two Marketing Campaings each month</p>
                                                </div>
                                            </div>
                                       {{-- <div class="upgrade-ok-img">
                                            <div>
                                                <i style="" class="fa fa-check"></i>

                                            </div>
                                            <div class="upgrade-img-tick">
                                                <p>4 Blog Article/mo.</p>
                                            </div>
                                        </div>
--}}
                                      {{--  <div class="upgrade-ok-img">
                                                <div>
                                                    <i style="" class="fa fa-check"></i>

                                                </div>
                                                <div class="upgrade-img-tick">
                                                    <p>A dedicated marketing professional for</p>
                                                </div>
                                            </div>
                                            --}}
                                        {{--    <div class="upgrade-ok-img">
                                                <div>
                                                    <i style="" class="fa fa-check"></i>

                                                </div>
                                                <div class="upgrade-img-tick">
                                                    <p>Ongoing support and communication</p>
                                                </div>
                                            </div>
                                            --}}
                                          {{--
                                            <div class="upgrade-ok-img">
                                                <div>
                                                    <i style="" class="fa fa-check"></i>

                                                </div>
                                                <div class="upgrade-img-tick">
                                                    <p>Monthly reporting</p>
                                                </div>
                                            </div>
                                            --}}
                                            {{--
                                            <div class="upgrade-ok-img">
                                                <div>
                                                    <i style="" class="fa fa-check"></i>

                                                </div>
                                                <div class="upgrade-img-tick">
                                                    <p>Customized marketing assessment</p>
                                                </div>
                                            </div>
                                            --}}
                                            {{--
                                            <div class="upgrade-ok-img">
                                                <div>
                                                    <i style="" class="fa fa-check"></i>

                                                </div>
                                                <div class="upgrade-img-tick">
                                                    <p>60-minute initial consult</p>
                                                </div>
                                            </div>
                                            --}}
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="upgrade-detail" style="display: none;">

                            <h3 class="upgrade-title text-center" style="display: none;">
                                Selected Plan <span class="package-title">DIY</span>
                            </h3>
                            <div class="testimonials-list">
                                <ul>
                                    <li>
                                        <div class="feedback-text">
                                            <img style="width: 300px;margin-left: 0px;" src="{{ asset('public/images/payment-successful.png') }}" />
                                            <h3 style="margin-top: 20px;    width: 100%;font-size: 22px;text-align: center;margin-left: 50px;">Payment successful</h3>
                                        </div>
{{--                                        <div class="feedback-text" style="padding-left: 10px;">--}}
{{--                                        </div>--}}
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="white-box full-page-view quote-section" style="display: {{ ($status == 'paid') ? 'block' : 'none' }} ; margin-bottom: 0px; min-height: 613px; margin-top:0px; background-color: white;">
                            <div class="page-content">
                                <div class="clearfix"></div>
                                <div class="website-task-panel">
                                    <div class="tab-content">
                                        <div class="upgrade-contact" style="">
                                            <h4 class="page-title text-center" style="margin-bottom: 10px;">Learn How Nichepractice Can Help Grow Your Business</h4>
                                            <div class="quote-description">
                                                <p>Book a no obligation quote to learn more about our fully managed marketing services to help transform your practice or existing niche. <a href="javascript:void(0)">Click here</a> to schedule a time that works for your schedule.</p>
{{--                                                <div class="calendly-booking-area" style="display: none; width: 360px; margin: 0px auto; margin-top: 30px;">--}}
{{--                                                    <div class="calendly-inline-widget" data-url="https://calendly.com/nichepractice/15min?hide_event_type_details=1" style="min-width:320px;height:600px;"></div>--}}
{{--                                                    <script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js"></script>--}}
{{--                                                </div>--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($status == 'trial')
                        <div class="payment-section" style="display:block;">
                            <div class="example example2">
                                <form novalidate>
                                    <div class="pay-with-card upgrade-page-card-bg " style="min-height: 613px; box-shadow: rgba(45, 62, 80, 0.12) 0px 1px 5px 0px;
    border-radius: 3px;">
                                        <h3 class="p-w-c-title">One Simple Low Cost <span class="action-plan"></span></h3>
                                        <div class="payment-title">
                                            <h1 style="color: #4c4545;    font-size: 30px;">Payment Details</h1>
                                            <div>
                                                <img src="{{ asset('public/images/paymentlock.png') }} " style="width: 25px; margin: 19px 0px 6px 18px;">
                                            </div>
                                        </div>

                                        <div class="form-group" style="display: none;">
                                            <label for="">Email address:</label>
{{--                                            <input type="email" value="" class="form-control" id="email"/>--}}
                                            <input id="email" type="email" class="form-control" value="{{ $userData['email'] }}" readonly>
                                        </div>

                                        <div class="form-group cc-num">
                                            <label for="">Card Information:</label>
                                            <div id="credit_card_number" class="input empty"></div>
                                            <span class="brand"><i class="pf pf-credit-card" id="brand-icon"></i></span>
                                            <span id="credit_card_number_error"
                                                  class="help-block"><small></small></span>

                                            {{--                                        <input type="text" class="form-control cc-no" placeholder="1234 1234 1234 1234" id="">--}}
                                            {{--                                        <img class="cc-icons" src="{{ asset('public/images/cc-icons.png') }}">--}}
                                        </div>

                                        <div class="form-inline credit-card-details">
                                            <div class="form-group expiry-date" style="padding-right: 10px;">
                                                {{--                                            <input type="text" class="form-control" placeholder="MM/YY" id="">--}}
                                                <div id="credit-card-expiry-date" class="input empty"></div>
                                                <span id="credit_card_expiry_date_error"
                                                      class="help-block"><small></small></span>
                                            </div>
                                            <div class="form-group cvc-no">
                                                {{--                                            <input type="text" class="form-control" placeholder="CVC" id="">--}}
                                                {{--                                            <img class="credit-card-cvv" src="{{ asset('public/images/credit-card.png') }}">--}}
                                                <div id="credit-card-cvc" class="input empty"></div>
                                                <span id="credit_card_cvc_error" class="help-block"><small></small></span>
                                            </div>
                                        </div>

                                        <div class="form-group p-t-15">
                                            <label for="">Name on Card:</label>
                                            <input type="text" class="form-control" id="name_on_credit_card" placeholder="Name on Credit Card">
                                            <span class="help-block"><small></small></span>
                                        </div>

                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="ZIP" id="zip_code">
                                        </div>
{{--                                        <p>Please Choose One:</p>--}}
{{--                                            <div class="radio">--}}
{{--                                                <label><input type="radio" name="optradio" checked>I want to follow the 12 month marketing strategy</label>--}}
{{--                                            </div>--}}
{{--                                            <div class="radio">--}}
{{--                                                <label><input type="radio" name="optradio">I want to choose my own marketing campaigns</label>--}}
{{--                                            </div>--}}

{{--                                        <div class="form-check">--}}
{{--                                            <label class="payment-radio-1"><input class="form-check-input payment-radio" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked><span>I want to follow the 12 month marketing strategy</span></label>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-check">--}}
{{--                                            <label class="payment-radio-1" > <input class="form-check-input payment-radio" type="radio" name="exampleRadios" id="exampleRadios2" value="option2"><span>I want to choose my own marketing campaigns</span></label>--}}
{{--                                        </div>--}}





                                        <div class="form-group p-t-20">
{{--                                            <button type="submit" class="btn btn-buy-package btn-block">Pay $<span class="price">600</span></button>--}}
                                            <button type="submit" class="btn btn-buy-package btn-block">Pay $<span class="price">1</span></button>
                                            <div class="error" role="alert">
                                                <i class="fa fa-exclamation-circle"
                                                   style="font-size: 17px; color:red; margin-right: 2px;display: none;"></i>
                                                <span class="message"></span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>


{{--                            <input type="hidden" id="selectedPackage" value="niche_registration" />--}}
{{--                            <input type="hidden" id="selectedPackage" value="test_diy" />--}}
                            <input type="hidden" id="selectedPackage" value="subscription_payment" />
                        </div>
                        @endif
                    </div>
                </div>
                <div class="container" style="display: none;">
                    <div class="row">
                        <div class="col-lg-1 col-md-1 "></div>
                        <div class="col-lg-8 col-md-8 ">
                            <div class=" ">
                                <h4 class="page-title text-left ">FAQs</h4>
                            </div>
                            <div class="">
                                <h1 class="contact-des" style="font-size: 35px !important;" >Credits</h1>
                                <p class="faq-p">We are a DIY marketing platform where you buy and use credits to have your practice marketing tasks completed by our team of marketing professionals.</p>
                                <h3 class="faq-title">How do Credits work?</h3>
                                <p class="faq-p">Credits are deducted from your account each time you purchase a service to complete a task. The number of credits it costs to complete a task vary depending on the complexity and time required to complete the task.</p>
                                <h3 class="faq-title">Buying credits</h3>
                                <p class="faq-p">Pay for your credits by credit card only. You will always be able to view your credit balance and the credits needed for each task. Credits never expire. If you are unable to use your credits, your credits will remain in your account until you are ready to use them again.</p>
                                <h3 class="faq-title">How much do credits cost?</h3>
                                <p class="faq-p">Each credit is $10. If you buy email credits in bulk you can get access to lower prices than our individual rates.</p>
                                <h3 class="faq-title">Do you offer refunds on credits?</h3>
                                <p class="faq-p">We do not offer refunds. They have no expiry date and can be used anytime.</p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<div id="calendly-modal" class="modal fade in modal-manager calendly-app-interface" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body modal-preview">
                <!-- Calendly inline widget begin -->
                <div class="calendly-inline-widget" data-url="https://calendly.com/nichepractice/15min?hide_event_type_details=1" style="min-width:320px;height:630px;"></div>
                <script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js"></script>
                <!-- Calendly inline widget end -->
            </div>
        </div>
    </div>
</div>

<div id="modal-campaign-package2" class="modal fade in modal-manager modal-upgrade-library" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document" style="width: 400px;">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-campaign-title">
                    Thank You For Joining Nichepractice
                </h3>
            </div>
            <div class="modal-body">
                <div class="description-order" style="margin-bottom: 35px;">
                    <p>As a subscriber, you will be eligible each month for a free
                        <br>marketing campaign from our library. You may also implement
                        additional marketing campaigns anytime by purchasing them separately.
                    </p>
                </div>
                <div class="row modal-order-action">
                    <a href="{{ route('campaigns-library') }}" class="btn btn-choose-campaign" style="margin: 0px auto;display: table; width: 85%; border-radius: 0px; font-weight: 600; ">CHOOSE A CAMPAIGN</a>
                </div>
            </div>

        </div>
    </div>
</div>

    <input type="hidden" id="package-selected" value="<?php echo (!empty($subscribedPackageDetail)) ? $subscribedPackageDetail['name'] : '';  ?>" />
@endsection

@section('css')
    <style>
        .btn-choose-campaign{
            border: 1px solid black;
            color: black;
            border-radius: 3px;
        }
        .tick-box{
            display: flex;
        }
        .myself-tick{
            padding-left: 25px;
            margin-top: 10px;
        }
        .myself-tick img{
            height: 50px;
            width: 50px;
        }
        .myDiv{
            cursor: pointer;
        }

        .select-box-p{
            font-size: 19px;
            color: #796F6F;
        }
        .select-box{
            font-weight: bold;
            color: #3C4A56;
            font-size: 28px;
        }
        .select-box-link{
            text-decoration: underline;
            color: #305DEF;
            font-size: 19px;
        }
        .select-box-link:hover{
            color: #305DEF;
            text-decoration: underline;
        }

        .payment-radio-1{
            display: flex !important;
        }
        input.payment-radio{
            width: auto !important;
            margin-right: 10px;
        }
        .ok-tick{
            display: flex;
            justify-content: end;
            align-items: center;
        }
        .radio-label-1{
            font-weight: 600;
            margin-right: -1px;
            font-size: 16px;
        }
        .radio-label-2{
            font-weight: 600;
            margin-right: -1px;
            font-size: 16px;
            margin-left: 20px;
        }
        .radio-input-1{
            transform: scale(1.5);
            position: absolute;
            right: 45px;
        }
        .radio-input-2{
            transform: scale(1.5);
            position: absolute;
            right: 45px;
        }






        #custom-radio-buttons .radio-wrapper {
            display: inline-block;

        }
        #custom-radio-buttons .radio-wrapper input[name="custom-radio"] {display: none;}
        #custom-radio-buttons .radio-wrapper input[name="custom-radio"] + label {
            color: #292321;
            font-size: 16px;
            font-weight: 600;
        }
        #custom-radio-buttons .radio-wrapper input[name="custom-radio"] + label > span.outer {
            display: inline-block;
            width: 16px;
            height: 16px;
            margin: -1px 4px 0 0;
            border: 1px solid #3A474F;
            vertical-align: middle;
            cursor: pointer;
            position: relative;
            -moz-border-radius: 50%;
            border-radius: 50%;
            background-color: #f8f8f8;
            transform: scale(1.5);
        }
        #custom-radio-buttons .radio-wrapper input[name="custom-radio"] + label span.inner {
            display: block;
            position: absolute;
            display: none;
            width: 10px;
            height: 10px;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            margin: auto;
            vertical-align: middle;
            cursor: pointer;
            -moz-border-radius: 50%;
            border-radius: 50%;
            background-color: grey;
        }
        #custom-radio-buttons .radio-wrapper input[name="custom-radio"]:checked + label span.inner {
            background-color: #3A474F;
            display: block;
        }

        .myDiv {
            border: 2px solid #DFE0E4 !important;
        }
        .select-box-border.active {
            border: 2px solid #68AFCF !important;
        }
        .active h2.myDivv{
            color: #2E81C4;
        }


        .freeCredits {
            font-weight: 700;
            font-size: 27px;
            color: #ff6347;
            margin-bottom: 20px;
        }
        .footer1{
            background-color: white;
        }
        @media screen and (max-width: 991px) {
            .cardStyle {
                width: 100%;
            }
        }
        @media screen and (min-width: 992px) {
            .cardStyle {
                width: 350px;
                float: right;
                margin-top: 50px;
                margin-right: 20px;
            }

        }
        .cardStyle {
            box-shadow: 0 0 10px #ccc;
            border-radius: 10px;
        }







    </style>
    <link rel="stylesheet" href="{{ asset('public/payment-checkout/css/stripe-base.css?ver='.$appFileVersion) }}">
    <link rel="stylesheet" href="{{ asset('public/payment-checkout/css/style.css?ver='.$appFileVersion) }}">
@endsection

@section('js')
    <script src="https://js.stripe.com/v3/"></script>
    <script type="text/javascript" src="{{ asset('public/payment-checkout/js/stripe-custom-form-elements.js?ver='.$appFileVersion) }}"></script>
    <script type="text/javascript" src="{{ asset('public/payment-checkout/js/stripe-custom-form.js?ver='.$appFileVersion) }}"></script>

      <script>


          $(function() {
              $('.myDiv').click(function() { // when a .myDiv is clicked
                  $('.myDiv').not(this).removeClass('active')
                  $(this).addClass('active')
                  $('.myDiv').not(this).removeClass('select-box-h1')
                  $(this).addClass('select-box-h1')
              })
          })
      </script>
    <script>
        $(document.body).on('click', '.quote-description a' ,function() {
            var mainModel = $("#calendly-modal");
            mainModel.modal('show');
            // $(".calendly-booking-area").show();
        });
    </script>

    <script>
        localStorage.removeItem('card_details');

        $(function () {
            $(".tab-selector").click(function()
            {
                var targetClass = $(this).attr("data-target");
                $("."+targetClass + " a").click();
            });

            $('.marketing-tabs').addClass('active');
            $('.marketing-tabs .nav-second-level').css('display', 'block');

            $('.website-page-tabs li a').click(function (e)
            {
                console.log("tab clicked ");
                e.preventDefault();
                console.log("tab clicked next");
                $(".website-page-tabs li").removeClass('active');
                $(this).parent().addClass('active');

                var called = this.hash.slice(1);

                if(called === 'now')
                {
                    $(".quote-section").hide();
                    $(".upgrade-contact").hide();

                    $(".payment-section").show();
                    $(".myself").show();
                }else
                {
                    $(".myself").hide();
                    $(".payment-section").hide();

                    $(".upgrade-contact").show();
                    $(".quote-section").show();
                }
            });

            $(".choose-plan-list li, .choose-plan-list li button").click(function (e) {
                // console.log(e);
                e.stopPropagation();
                var packageSection = $(".upgrade-elite");
                var packageDetail = $(".upgrade-detail");
                var paymentSection = $(".payment-section");

                $(".choose-plan-list li").removeClass("active");

                // console.log($(this));

                packageDetail.hide();
                paymentSection.hide();
                packageSection.hide();

                if($(this).hasClass("btn-package-select"))
                {
                    var parentElement = $(this).closest('li');

                    parentElement.addClass('active');

                    $(".action-plan").html("of " + parentElement.find('.package-title').html() + " Plan");
                    $(".price").html(parentElement.find(".pack-price").html());

                    // console.log("action ");
                    packageSection.hide();
                    paymentSection.show();
                }
                else
                {
                    if($(this).hasClass("selected") || $(this).hasClass("current-package-selected"))
                    {
                        $(this).addClass('active');

                        // console.log($(this).find('.package-title').html());

                        // var currentPackageSelector = $(".choose-plan-list .package-"+selectedPackage);

                        $(".package-title", packageDetail).html($('.current-package-selected').find('.package-title').html());
                        packageDetail.show();
                        packageSection.hide();
                    }
                    else
                    {
                        // console.log("elll");
                        $(this).addClass('active');
                        $(".package-title", packageSection).html($(this).find('.package-title').html());
                        paymentSection.hide();
                        packageSection.show();
                    }
                }
            });

            var selectedPackage = $("#package-selected").val();

            if(selectedPackage !== '')
            {
                var currentPackageSelector = $(".choose-plan-list .package-"+selectedPackage);

                currentPackageSelector.html('Selected');
                currentPackageSelector.addClass('selected');
                currentPackageSelector.removeClass('btn-package-select');

                $("ul").find($(currentPackageSelector).closest('li')).addClass('current-package-selected');

                // var parentElement = $("ul " + $(currentPackageSelector).closest('li'));
                // var parentElement = $($(currentPackageSelector).closest('li'), "ul");
                // var parentElement = $($(currentPackageSelector).closest('li'));

                // $($(currentPackageSelector).closest('li')).closest('ul').show();


                var elementIndex = $("ul").find($(currentPackageSelector).closest('li')).index();
                elementIndex++;

                // console.log("elementIndex " + elementIndex);

                $( ".choose-plan-list ul li:nth-child("+elementIndex+")").click();
            }
            else
            {
                $(".choose-plan-list li:first").click();
            }
        });
        function detectIndex() {
            // console.log("h");
            var selectedPackage = $("#package-selected").val();
            var currentPackageSelector = $(".choose-plan-list .package-"+selectedPackage);

            currentPackageSelector.html('Selected');
            currentPackageSelector.addClass('selected');

            // var parentElement = $("ul " + $(currentPackageSelector).closest('li'));
            var parentElement = $($(currentPackageSelector).closest('li'), "ul");

            // $($(currentPackageSelector).closest('li')).closest('ul').show();

            var elementIndex = $("ul").find($(currentPackageSelector).closest('li')).index();

            $( ".choose-plan-list ul li:nth-child("+elementIndex+")").click();

            // $($(currentPackageSelector).closest('li')).closest('ul').show();

            parentElement.hide();

        }
    </script>
@endsection
