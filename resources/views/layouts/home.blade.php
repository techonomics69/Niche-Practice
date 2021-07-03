@extends('index')

@section('pageTitle', 'Home')


@section('content')
    <?php $dynamicAppName = 'nichepractice'; ?>


    <div class="center-logo business-process-logo" style="display: none;">
        <img class="logo" src="{{ asset('public/images/logo-new.png') }}" alt="">
    </div>

    <div id="page-wrapper" class="home">
        <div class="container-fluid dashboarbgtitle">
            <div class="dashboard-wrapper home-view">
                <div class="page-head">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <h4 class="page-title"><i class=""></i> Dashboard <a class="page-help" href="javascript:void(0)">
                                    {{--                                    <i class="fa fa-question-circle-o" style="color: #7d8080;/* transform: scaleX(-1); */margin-right: 5px;"></i>--}}
                                    {{--                                    <img class="help-info-image" src="{{ asset('public/images/information.png') }}" />--}}
                                </a> </h4>

                        </div>
                        {{--                        <div class="col-md-6 col-sm-6 started-home-btn ">--}}
                        {{--                            <p class="text-right" style="font-weight: bold; font-size: 16px;">Get Started With Nichepractice</p>--}}
                        {{--                            <button id="watchOverviewVideo" class="btn" style="float: right; font-weight: 600; font-size: 15px; background-color: #DBECF6; color:#2B93F4;">--}}
                        {{--                                <i class="fa fa-play-circle-o fa-lg" aria-hidden="true"></i>  Get Started With Nichepractice--}}
                        {{--                            </button>--}}
                        {{--                        </div>--}}
                    </div>
                </div>

                {{--                <h4 class="page-title"><i class=""></i> Dashboard <a class="page-help" href="javascript:void(0)"><i class="fa fa-question-circle-o" style="color: #7d8080;/* transform: scaleX(-1); */margin-right: 5px;"></i></a> </h4>--}}
                <div class="welcome-container" style="display: none">
                    <div class="row" style="align-items: center;display: flex;flex-wrap: wrap;">General Citations
                        <div class="col-lg-8 col-sm-12 col-dashboard-top">
                            <div class="row dash-stats">
                                <div class="col-sm-4">
                                    <h4 class="main-card-heading">Task Manager</h4>
                                    <div class="dash-card-top">
                                        <img src="{{ asset('public/images/complete.png') }}" alt="">
                                        <div>
                                            <h3>31</h3>
                                            <p>Completed Tasks</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="dash-card-top">
                                        <img src="{{ asset('public/images/pending.png') }}" alt="">
                                        <div>
                                            <h3>7</h3>
                                            <p>Pending Tasks</p>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-sm-4">
                                    <div class="dash-card-top">
                                        <img src="{{ asset('public/images/overdue.png') }}" alt="">
                                        <div>
                                            <h3>0</h3>
                                            <p>Overdue Tasks</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-12 col-dashboard-top">
                            <h4 style="font-size: 18px;font-weight: 600;display: inline-block;color: #010318;margin-bottom: 10px;margin-top: 0;">Need help completing your tasks?</h4>
                            <div class="d-flex justify-content-between flex-direction-767">
                                <div style="margin-bottom: 5px;margin-right: 5px;">Have our team at nichepractice complete all your tasks for you</div>
                                <div>
                                    {{--                                        <a href="{{ route('task-list') }}" class="btn btn-primary btn-view">--}}
                                    <a href="javascript:void(0)" class="btn btn-primary btn-view page-help">
                                        I'm interested
                                    </a>
                                </div>
                            </div>
                        </div>
                        {{--                            <div class="col-sm-2 hidden-md hidden-sm hidden-xs">--}}
                        {{--                                <div class="w-left">--}}
                        {{--                                    <img style="max-width: 180px;" class="img-responsive" src="{{ asset('public/images/dashboard-header.jpg') }}"/>--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                        {{--                            <div class="col-lg-12">--}}
                        {{--                                <div class="w-right">--}}
                        {{--                                    <div class="d-flex justify-content-center col-720">--}}
                        {{--                                        <div class="col-sm d-flex col-720">--}}
                        {{--                                            <div class="w-right-body">--}}
                        {{--                                                <div class="text-welcome-container">--}}
                        {{--                                                    <h3 class="dash-title pull-left">Hey {{ $userData['first_name'] }}, Welcome to Nichepractice</h3>--}}
                        {{--                                                    <label>--}}
                        {{--                                                        Let's begin by getting some basic information about your practice--}}
                        {{--                                                    </label>--}}
                        {{--                                                    <div>--}}
                        {{--                                                        <a href="{{ route('practice-profile') }}" class="btn btn-primary btn-get-started">Get Started</a>--}}
                        {{--                                                    </div>--}}
                        {{--                                                </div>--}}

                        {{--                                            </div>--}}
                        {{--                                            <div class="grid welcome-graph-column text-center" style="border-right: 1px solid #ddd;margin: 5px 0;padding: 0 30px 0 0;max-width: 240px;">--}}
                        {{--                                                <section>--}}
                        {{--                                                    <svg class="circle-chart welcome-container-graph" viewBox="0 0 33.83098862 33.83098862" width="100" height="100" xmlns="http://www.w3.org/2000/svg" style="border-radius: 100px;">--}}
                        {{--                                                        <circle class="circle-chart__background" stroke="#E5E5E5" stroke-width="2.5" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431"></circle>--}}
                        {{--                                                        <circle class="circle-chart__circle" stroke="#3685D2" stroke-width="2.5" stroke-dasharray="80,100" stroke-linecap="round" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431"></circle>--}}
                        {{--                                                        <g class="circle-chart__info">--}}

                        {{--                                                            <text class="circle-chart__percent" x="16.91549431" y="13" alignment-baseline="central" text-anchor="middle" font-size="8">80%--}}
                        {{--                                                            </text><text class="circle-chart__percent" x="16.91549431" y="20" alignment-baseline="central" text-anchor="middle" font-size="5" font-weight="bold">COMPLETE</text>--}}
                        {{--                                                        </g>--}}
                        {{--                                                    </svg>--}}
                        {{--                                                </section>--}}

                        {{--                                            </div>--}}
                        {{--                                        </div>--}}
                        {{--                                        <div class="col-sm">--}}
                        {{--                                            <img src="{{ asset('public/images/roadmap.jpg') }}" />--}}
                        {{--                                        </div>--}}
                        {{--                                        <div class="col-sm roadmap-container" style="">--}}
                        {{--                                            <div class="roadmap-text">--}}
                        {{--                                                <span>--}}
                        {{--                                                    Your Marketing Roadmap--}}
                        {{--                                                </span>--}}
                        {{--                                                <a href="{{ route('task-list') }}" class="btn btn-primary btn-view">--}}
                        {{--                                                    Get Started--}}
                        {{--                                                </a>--}}
                        {{--                                            </div>--}}
                        {{--                                            <img src="{{ asset('public/images/roadmap.jpg') }}">--}}
                        {{--                                        </div>--}}


                        {{--                                      --}}{{----}}{{--  <div class="col-md-2">--}}
                        {{--                                            <div class="w-progress-section">--}}
                        {{--                                                <a href="#" class="dash-subtitle">Do it Later</a>--}}


                        {{--                                              --}}{{----}}{{----}}{{----}}{{--  <div class="progress">--}}
                        {{--                                                    <div class="progress-bar" role="progressbar" aria-valuenow="70"--}}
                        {{--                                                         aria-valuemin="0" aria-valuemax="100" style="width:70%">--}}
                        {{--                                                        <span class="sr-only">70% Complete</span>--}}
                        {{--                                                    </div>--}}
                        {{--                                                </div>--}}{{----}}{{----}}{{----}}{{----}}

                        {{--                                            </div>--}}



                        {{--                                        </div>--}}
                        {{--                                    </div>--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                    </div>
                </div>

                @if(!empty($campaignId))
                    <div style="display: none;">
                        <iframe src="{{ route('email-builder', $campaignId) . '?type_source=patient&save_type=click' }}"><p>Your browser does not support iframes.</p></iframe>
                    </div>
                @endif

                @if(!empty($userData['business'][0]['website']) && $userData['discovery_status'] != 1)
                    <div class="web-audit" style="display:none;">
                        @if($appEnvIs == 'production')
                            <iframe src="https://appreviewer.nichepractice.com"><p>Your browser does not support iframes.</p></iframe>
                        @else
                            <iframe src="https://reviewer.nichepractice.com"><p>Your browser does not support iframes.</p></iframe>
                        @endif
                    </div>
                @else
                    <div class="web-audit" style="display:none;"></div>
                @endif

                <div class="cards-row">
                    <div class="row">

                        {{--                        mycode--}}
                        <?php
                        $p1 = 25;
                        ?>
                        <?php
//                        if( ( !empty($reviewsResult) ) || ( !empty($negativeReviews) ) ){
                         ?>
{{--                            <p>abcbcbcbcbcb</p>--}}
                            <?php
//                            $p2 = 20;
//                            echo $p2;
//                            } else {
    ?>
                            <?php
//                            $p2 = 0;
//                            echo $p2;
//                             }
                             ?>
{{--                        @endif--}}
                        @if (!empty($webResult['domain']))


                            <?php
                            $p3 = 25;
                            ?>



                        @else
                            <?php
                            $p3 = 0;
                            ?>
                        @endif

                        @if(!empty($userBusiness['logo']))
                            <?php
                            $p4 = 25;
                            ?>

                        @else
                            <?php
                            $p4 = 0;
                            ?>
                        @endif
                        <?php
                        if  ( (!empty($socialMediaPostsData['Facebook']) && $socialMediaPostsData['Facebook']['status'] == 'connected') || ( !empty($socialMediaPostsData['Twitter']) && $socialMediaPostsData['Twitter']['status'] == 'connected' ) ) {
                            $p5 = 25;
                            ?>

                                                    <?php
                        }else{
                            $p5 = 0;
                            ?>

                                                    <?php

                        }
                        ?>
                        <?php
                        $total = $p1 + $p3 +$p4 + $p5;

                        ?>

                        <div  class="col-sm-6 col-lg-4 invite-card complete" style="display: none;">
                            <div style="" class="card card-1 owl-card-carasol">
                                <div class="own-card-content">
                                    <div class="card-head text-left">
                                        {{--                                            <h3 class="owl-item-main-heading">What do you want to do Today?</h3>--}}
                                        {{--                                            <h3 class="owl-item-main-heading">NOT SURE WHERE TO START?</h3>--}}
                                        <h3 class="owl-item-main-heading">Discover</h3>
                                    </div>

                                    <?php
                                    $items = [
                                        'Get over 50 new patient leads each month' => 'val',
                                        'Leverage social media to drive engagement',
                                        'Generate 25% more web traffic',
                                        'Schedule 5 new niche procedures',
                                        'Become the go-to expert in your industry',
                                        'Generate more patient reviews',
                                        'Get Found on Google Search',
                                        'Earn instant revenue with a new promotion'
                                    ];
                                    ?>
                                    <div class="card-body" style="margin-top: 0;padding-top: 5px;padding-right: 0;padding-left: 0;">
                                        <div class="owl-carousel owl-theme">
                                            @if(!empty($widgetItems))
                                                @foreach($widgetItems as $item)
                                                    <div class="item">
                                                        <div class="c1-t1">
                                                            <p class="subtext text-center" style="font-size: 18px;">
                                                                {{ $item['title'] }}
                                                            </p>
                                                            {{--                                                                <duv style="display: block;" class="sub-description">{{ $item['description'] }}</duv>--}}
                                                            <div>
                                                                <a href="javascript:void(0);" data-target="{{ $item['id'] }}" class="btn btn-primary btn-continue">Continue</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if($total == 100 || $closeWidget == 1)

                            <div  class="col-sm-6 col-lg-4 invite-card complete">
                                <div style="" class="card card-1 owl-card-carasol">
                                    <div class="own-card-content">
                                        <div class="card-head text-left">
{{--                                            <h3 class="owl-item-main-heading">What do you want to do Today?</h3>--}}
{{--                                            <h3 class="owl-item-main-heading">NOT SURE WHERE TO START?</h3>--}}
                                            <h3 class="owl-item-main-heading">Discover</h3>
                                        </div>

                                        <?php
                                        $items = [
                                            'Get over 50 new patient leads each month' => 'val',
                                            'Leverage social media to drive engagement',
                                            'Generate 25% more web traffic',
                                            'Schedule 5 new niche procedures',
                                            'Become the go-to expert in your industry',
                                            'Generate more patient reviews',
                                            'Get Found on Google Search',
                                            'Earn instant revenue with a new promotion'
                                        ];
                                        ?>
                                        <div class="card-body" style="margin-top: 0;padding-top: 5px;padding-right: 0;padding-left: 0;">
                                            <div class="owl-carousel owl-theme">
                                                @if(!empty($widgetItems))
                                                    @foreach($widgetItems as $item)
                                                        <div class="item">
                                                            <div class="c1-t1">
                                                                <p class="subtext text-center" style="font-size: 18px;">
                                                                    {{ $item['title'] }}
                                                                </p>
                                                                {{--                                                                <duv style="display: block;" class="sub-description">{{ $item['description'] }}</duv>--}}
                                                                <div>
                                                                    <a href="javascript:void(0);" data-target="{{ $item['id'] }}" class="btn btn-primary btn-continue">Continue</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{--                            /////////--}}
                            <div  class="col-sm-6 col-lg-4 invite-card" style="display: none">
                                <div class="card card-1 owl-card-carasol">
                                    <div class="own-card-content">
                                        <div class="card-head text-center">
                                            <h3 class="owl-item-main-heading widget-type" data-widget-type="new_patient_emails">What do you want to do Today?</h3>
                                        </div>
                                        <div class="card-head text-center pat-leads">
                                            <div class="c1-t1">
                                                <p class="subtext">
                                                    Get over 50 new patient leads each month
                                                </p>
                                            </div>
                                        </div>
                                        <div class="card-head text-center pat-leads">
                                            <h3 class="font-normal widget-type fin" data-widget-type="new_patient_emails" style="margin: 0 0 20px 0 !important;">
                                                <span>
                                                    <a href="javascript:void(0)" class="widget-help-selector" style="display: block!important;">
                                                        <span class="btn btn-primary btn-continue">
                                                            Continue
                                                        </span>
                                                    </a>
                                                </span>
                                            </h3>
                                        </div>
                                        {{--                                        <div class="card-head text-center cont-btn" style="display: flex;align-items: center;justify-content: center;" data-widget-type="new_patient_emails">--}}
                                        {{--                                            <a href="javascript:void(0);" class="widget-help-selector" style="display: block!important;">--}}
                                        {{--                                                <button class="font-normal widget-type fin btn btn-primary btn-continue">--}}
                                        {{--                                                   <span>Continue</span>--}}
                                        {{--                                                </button>--}}
                                        {{--                                            </a>--}}
                                        {{--                                        </div>--}}
                                    </div>
                                </div>
                            </div>




                        @else
                            <div  class="col-sm-6 col-lg-4 invite-card notComplete">
                                <div class="card card-3">
                                    <div class="dashboard-card-loader1" style="display: none; !important;background: rgba(255,255,255,0.77)!important;"></div>
                                    <div class="bg-white" style="padding: 5px 10px;">
                                        <div class="d-flex justify-content-between card-head">
                                            <h3 class="font-normal widget-type fin" data-widget-type="new_patient_emails" style="margin: 0 0 20px 0 !important;color:#964A3E!important;">Finish setting up account
                                                <span><a href="javascript:void(0)" class="widget-help-selector">
    {{--                                                    <i class="fa fa-question-circle-o email-icon"></i>--}}
                                                    </a>
                                                </span>
                                            </h3>
                                            <button type="button" class="closeWidget"><span aria-hidden="true">×</span></button>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div id="addCustomerStep1 m-t-5" class="row star-box-size">
                                                    {{--                                            <div class="col-md-12">--}}
                                                    {{--                                                <img class="dashboa-email" src="{{ asset('public/images/Layer18.png') }}" />--}}
                                                    {{--                                            </div>--}}
                                                    <div class="col-sm-12">

                                                        <div>
                                                            <p style="color: #626262;"><i class="fa fa-check tick " ></i> <del>Practice Information</del></p>
                                                        </div>
                                                        <?php
//                                                        if ( ( !empty($reviewsResult) ) || ( !empty($negativeReviews) ) ) {
                                                            ?>
{{--                                                        <div>--}}
{{--                                                            <p style="color: #626262;"><i class="fa fa-check tick"></i> <del>Online Patient Reviews</del></p>--}}
{{--                                                        </div>--}}
                                                        <?php
//                                                        }else{
                                                        ?>
{{--                                                        <div style="margin-bottom: 10px">--}}
{{--                                                            --}}{{--                                                                <p  style="color: #626262;"><i class="fa fa-check grey-tick"></i> Online Patient Reviews</p>--}}
{{--                                                            <a href="{{ route('citation-listings') }}" style="text-decoration: underline;color: #800080;">--}}
{{--                                                                <i class="fa fa-check grey-tick"></i> Online Patient Reviews--}}
{{--                                                            </a>--}}
{{--                                                        </div>--}}
                                                        <?php
//                                                        }
                                                        ?>
                                                        <?php
                                                        if (!empty($webResult['domain'])){
                                                        ?>
                                                        <div>
                                                            {{--                                                                    <p  style="color: #626262;"><i class="fa fa-check tick"></i><del>Website SEO Audit</del></p>--}}
                                                            <p  style="color: #626262;"><i class="fa fa-check tick"></i><del>Add Website URL (SEO Audit)</del></p>
                                                        </div>
                                                        <?php
                                                        }else{
                                                        ?>
                                                        <div style="margin-bottom: 10px">
                                                            {{--                                                                    <p  style="color: #626262;"><i class="fa fa-check grey-tick"></i> Website SEO Audit</p>--}}
                                                            {{--                                                                    <a href="{{ route('website-audit') }}" style="text-decoration: underline;color: #800080;">--}}
                                                            <a href="{{ route('business-profile') }}" style="text-decoration: underline;color: #800080;">
                                                                <i class="fa fa-check grey-tick"></i>Add Website URL (SEO Audit)
                                                            </a>
                                                        </div>
                                                        <?php
                                                        }
                                                        ?>
                                                        {{--                                                    <div>--}}
                                                        {{--                                                        <p  style="color: #626262;"><i class="fa fa-check grey-tick"></i> Website SEO Audit</p>--}}
                                                        {{--                                                    </div>--}}
                                                        <?php
                                                        if (!empty($userBusiness['logo'])){
                                                        ?>
                                                        <div>
                                                            <p  style="color: #626262;"><i class="fa fa-check tick"></i><del> Add Practice Logo</del></p>
                                                        </div>
                                                        <?php
                                                        }else{
                                                        ?>
                                                        <div style="margin-bottom: 10px">
                                                            {{--                                                                <p  style="color: #626262;"><i class="fa fa-check grey-tick"></i> Add Practice Logo</p>--}}
                                                            <a href="{{ route('business-profile') }}" style="text-decoration: underline;color: #800080;">
                                                                <i class="fa fa-check grey-tick"></i> Add Practice Logo
                                                            </a>
                                                        </div>
                                                        <?php

                                                        }
                                                        ?>
                                                        <?php
                                                        if ( (!empty($socialMediaPostsData['Facebook']) && $socialMediaPostsData['Facebook']['status'] == 'connected') || ( !empty($socialMediaPostsData['Twitter']) && $socialMediaPostsData['Twitter']['status'] == 'connected' ) ) {
                                                        ?>
                                                        <div>
                                                            <p  style="color: #626262;"><i class="fa fa-check tick"></i><del> Connect Social Media</del></p>
                                                        </div>
                                                        <?php
                                                        }else{
                                                        ?>
                                                        <div style="margin-bottom: 10px">
                                                            {{--                                                                    <p  style="color: #626262;"><i class="fa fa-check grey-tick"></i> Connect Social Media</p>--}}
                                                            <a href="{{ route('business-profile') }}" style="text-decoration: underline;color: #800080;">
                                                                <i class="fa fa-check grey-tick"></i> Connect Social Media
                                                            </a>
                                                        </div>
                                                        <?php

                                                        }
                                                        ?>
                                                        <hr  style="border-top:1px solid #837d7e;margin-top: 10px;margin-bottom: 4px;">
                                                            <h3 class="font-normal learnNiche widget-type fin" data-widget-type="new_patient_emails" style="font-size: 16px;font-weight: 600;color:#964A3E!important;">Learn To Use Nichepractice
                                                                <span>
                                                                    <a href="javascript:void(0)" class="widget-help-selector"></a>
                                                                </span>
                                                            </h3>

                                                        <a href="https://nichepractice.com/nichepractise/welcome-to-nichepractice/" target="_blank" style="text-decoration: underline">
                                                            <div class="d-flex" id="startHere"  style="cursor: pointer;">
                                                                <div>
                                                                    <i class="fa fa-file-text-o" aria-hidden="true"  style="font-size: 21px;color: #030104;padding-right: 11px;padding-left: 3px"></i>
{{--                                                                    <i class="fa fa-play-circle-o" style="font-size: 25px;color: #030104;padding-right: 10px;"></i>--}}
                                                                </div>
                                                                <div>
                                                                    <p style="margin-bottom: 7px; color: #444444;">Start Here!</p>
                                                                </div>
                                                            </div>
                                                        </a>
                                                        <div class="d-flex" id="watchOverviewVideo"  style="cursor: pointer;">
                                                            <div>
                                                                <i class="fa fa-play-circle-o" style="font-size: 25px;color: #030104;padding-right: 10px;"></i>
                                                            </div>
                                                            <div>
                                                                <p style="margin-bottom: 2px;text-decoration: underline">See how nichepractice works</p>
                                                            </div>
                                                        </div>



                                                    </div>




                                                </div>

                                            </div>

                                        </div>





                                    </div>

                                </div>
                            </div>
                        @endif






                        <div  class="col-sm-6 col-lg-4 task-widget invite-card pnwclass">
                            <div class="card card-3">
                                <div class="bg-white" style="padding: 5px 10px;">
                                    <div class="card-head">
                                        <h3 class="widget-type" data-widget-type="to_do_list_status">{{--My Campaigns--}}Campaigns Checklist<span><a href="javascript:void(0)" class="widget-help-selector">
{{--                                                    <i class="fa fa-question-circle-o" style="margin-left: 3px;"></i>--}}
                                                </a></span></h3>
                                        <a href="{{ route('task-list') }}"><label class="">View To-Do List</label></a>
                                    </div>
                                    <div id="addCustomerStep1" class="row">
                                        <div class="border-bottom-todo">
                                            <div class="col-sm-12 col-xs-12">
                                                <div class="text-center p-t-10 p-b-10 ">
                                                    <img src="{{ asset('public/images/banner1.png') }}" alt="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 text-center m-t-15 "  style="position: relative;">
                                            <div class="col-sm-4 col-xs-4">
                                                <div class="widgets-1">
                                                    <img src="{{ asset('public/images/banner01.png') }}" alt="">
                                                </div>
                                                <div class="m-t-10" >
                                                    <h3 class="widgets1-h3 open-count">{{$business_task_open}}</h3>
                                                </div>
                                                <div class="m-t-5">
                                                    <p class="widgets1-p">To-Do</p>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 col-xs-4">
                                                <div class="banner-1">
                                                    <img src="{{ asset('public/images/banner02.png') }}" alt="">
                                                </div>
                                                <div class="m-t-10">
                                                    <h3 class="widgets1-h3 skipped-count">{{$business_task_skipped}}</h3>
                                                </div>
                                                <div class="m-t-5">
                                                    <p class="widgets1-p">Skipped</p>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 col-xs-4">
                                                <div class="banner-1">
                                                    <img src="{{ asset('public/images/banner03.png') }}" alt="">
                                                </div>
                                                <div class="m-t-10">
                                                    <h3 class="widgets1-h3 done-count" >{{$business_task_done}}</h3>
                                                </div>
                                                <div class="m-t-5">
                                                    {{--                                                    <p class="widgets1-p" >Done</p>--}}
                                                    <p class="widgets1-p" >Completed</p>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>





                        <div class="col-lg-4 col-sm-6 col-xs-12 ">
                            <div class="card card-2">

                                <div class="card-head">
                                    <h3 class="widget-type" data-widget-type="recent_top_reviews">Recent Top Reviews
                                        {{--                                        <span><a href="javascript:void(0)" class="widget-help-selector"><i class="fa fa-question-circle-o"></i></a></span>--}}
                                    </h3>
                                    <a href="{{ route('reviews') }}"><label class="">Read All Reviews</label></a>
                                </div>
                                <div class="card-body">

                                    @if(!empty($scanResult))
                                        <?php foreach($scanResult as $scanBusiness) {
                                        if(strtolower($scanBusiness['type']) == 'healthgrades' || strtolower($scanBusiness['type']) == 'ratemd' || strtolower($scanBusiness['type']) == 'zocdoc' || strtolower($scanBusiness['type']) == 'yelp')
                                        {
                                            continue;
                                        }

                                        $type = str_replace(' Places', '', $scanBusiness['type']);
                                        $lowerType = strtolower($type);
                                        ?>

                                        <div class="{{$lowerType}}">
                                            <div class="row">
                                                <div class="col-xs-4">
                                                    <img src="{{ asset('public/images/icons/'.$lowerType.'.png') }}"/>
                                                    <label>{{ $type }}</label>
                                                </div>

                                                @if(!empty($scanBusiness['name']))
                                                    <div class="col-xs-4" style="padding-left: 0">
                                                        <div class="review-text">
                                                            @if($scanBusiness['type'] == 'Facebook')
                                                                {{ !empty($scanBusiness['page_reviews_count']) ? $scanBusiness['page_reviews_count']: 0 }} Reviews
                                                            @else
                                                                {{ !empty($scanBusiness['review_count']) ? $scanBusiness['review_count']: 0 }} Reviews
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-4 star-responsive">
                                                        <div class="g-rating-stars">
                                                                <span class="rating">
                                                                    <?php
                                                                    //                                                                    $socialResult
                                                                    if($scanBusiness['type'] == 'Facebook')
                                                                    {
                                                                        $count = !empty($socialResult['average_rating']) ? $socialResult['average_rating']: 0;
                                                                        $starRating = $count * 20;
                                                                    }
                                                                    else
                                                                    {
                                                                        $count = !empty($scanBusiness['average_rating']) ? $scanBusiness['average_rating']: 0;
                                                                        $starRating = $count * 20;
                                                                    }
                                                                    ?>
                                                                    <span class="rating-value" style="width:{{ $starRating.'%' }}">
                                                                    </span>
                                                                </span>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="col-xs-8">
                                                        <div class="review-text text-danger">
                                                            Not Listed
                                                        </div>
                                                    </div>
                                                @endif

                                            </div>
                                        </div>
                                        <?php } ?>
                                    @else
                                        <div class="google">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <img src="{{ asset('public/images/icons/google.png') }}"/>
                                                    <label>Google</label>
                                                </div>

                                                <div class="col-sm-8">
                                                    <div class="review-text text-danger">
                                                        Not Listed
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="facebook">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <img src="{{ asset('public/images/icons/facebook.png') }}"/>
                                                    <label>Facebook</label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class="review-text text-danger">
                                                        Not Listed
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    @endif
                                    {{--<p class="chart-here">chart here</p>--}}

                                    <hr class="divider" style="margin-bottom: 0;margin-top: 0;">
                                    <figure class="highcharts-figure">
                                        <div id="reviews-graph"></div>
                                    </figure>
                                </div>
                            </div>


                        </div>




                        <div  class="col-sm-6 col-lg-4 invite-card sumair">
                            <div class="card card-3">
                                <div class="bg-white" style="padding: 5px 10px;">
                                    <div class="d-flex justify-content-between card-head box-star-padding">
                                        <h3 class="font-normal widget-type" data-widget-type="send_review_invite" style="margin: 0 0 20px 0 !important;">Send Review Invite <span><a href="javascript:void(0)" class="widget-help-selector">
{{--                                                    <i class="fa fa-question-circle-o"></i>--}}
                                                </a></span></h3>
                                        <a id="send_review_invite_view_report_link" href="javascript:void(0)"><label class="">View Settings</label></a>

                                        {{--                                            <a href="javascript:void(0)"><label class="">View Report</label></a>--}}
                                    </div>
                                    <div class="col-md-12 review-star">
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>

                                    </div>

                                    <div id="addCustomerStep1" class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input type="text" id="first_name" class="form-control dashboard-input" placeholder="First Name">
                                                <span class="help-block hide-me"><small></small></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input type="text" id="last_name" class="form-control dashboard-input" placeholder="Last Name">
                                                <span class="help-block hide-me"><small></small></span>
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <input type="email" id="email" class="form-control dashboard-input m-0" placeholder="Patient Email">
                                                <span style="position: absolute;" class="help-block hide-me"><small></small></span>
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <input type="number" id="phone_number" class="form-control dashboard-input m-t-20 m-b-0" placeholder="Patient Phone">
                                                <span style="position: absolute;" class="help-block {{--hide-me--}}"><small style="color: #607ee3; font-weight: bold; font-size:10px; padding-left: 16px;">Free trial includes 10 SMS text messages</small></span>

                                            </div>

                                        </div>

                                        {{--                                            <div class="col-sm-12">--}}
                                        {{--                                                <div class="form-group">--}}
                                        {{--                                                <div class="d-flex">--}}
                                        {{--                                                        <div>--}}
                                        {{--                                                            <select name="" id="" class="dashboard-select-phone">--}}
                                        {{--                                                                <option value="">US +1</option>--}}
                                        {{--                                                            </select>--}}
                                        {{--                                                        </div>--}}
                                        {{--                                                        <input type="number" id="phone_number" class="form-control dashboard-input m-0" placeholder="Customer Phone">--}}
                                        {{--                                                        <span class="help-block hide-me"><small></small></span>--}}
                                        {{--                                                    </div>--}}
                                        {{--                                                </div>--}}
                                        {{--                                            </div>--}}

                                        {{--                                            <div style="display:none !important;" id="preview_panel" class="crm-customers-settings-panel">--}}

                                        {{--                                                <div id="email-preview-wrap" class="email-preview-wrap editor-content">--}}
                                        {{--                                                    <a href="javascript:void(0)" class="reset-default-preview" id="reset-email-default-preview">--}}
                                        {{--                                                        <label class="reset-label">Reset to Default</label></a>--}}
                                        {{--                                                    <label class="editor-label">Email Content</label>--}}
                                        {{--                                                    <div class="content-body" data-default="true"></div>--}}
                                        {{--                                                </div>--}}

                                        {{--                                                <div id="sms-preview-wrap" class="editor-content">--}}
                                        {{--                                                    <label class="editor-label">Text Content</label>--}}
                                        {{--                                                    <a href="javascript:;" class="reset-default-preview" id="reset-sms-default-preview"><label class="reset-label">Reset to Default</label></a>--}}
                                        {{--                                                    <div class="content-body" data-default="true"></div>--}}
                                        {{--                                                </div>--}}
                                        {{--                                            </div>--}}

                                        <div class="col-sm-12 text-right" style="margin-top: 20px">
                                            <div style="padding-left: 15px; padding-right:15px;">
                                                <div class="row">
                                                    <div class="col-sm-8" style="padding:0px">
                                                        <div id="send-review-invite-error-block" style="padding-left: 15px; padding-right:15px; display:none; position: absolute; ">
                                                            <div class="row text-left text-danger error-text my-error-issue">
                                                                <div class="col-sm-1" style="padding:0px">
                                                                    <span><i class="fa fa-exclamation-triangle fa-lg" aria-hidden="true"></i></span>
                                                                </div>
                                                                <div class="col-sm-11" style="padding: 1px 4px 0px 13px;">
                                                                    <small id="send-review-invite-error-message"></small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="" style="padding:0px">
                                                        <button id="add-single-customer-next-step" class="btn btn-primary">Send Invite</button>
                                                        <button id="customizeReviewRequestsBtn" class="btn btn-primary" style="display: none;">Send Invite Finish</button>

                                                    </div>
                                                </div>
                                            </div>



                                            {{--                                                <input type="hidden" id="enable_get_reviews" value="" />--}}
                                            {{--                                                <input type="hidden" id="sending_option" value="" />--}}
                                            {{--                                                <input type="hidden" id="smart_routing" value="" />--}}
                                            {{--                                                <input type="hidden" id="review_site" value="" />--}}
                                            {{--                                                <input type="hidden" id="send_reminder" value="" />--}}
                                        </div>

                                    </div>
                                </div>

                            </div></div>

                        <div class="col-lg-4 col-sm-6" style="display: none !important;">
                            <div class="card card-1 owl-card">
                                <div class="own-card-content">
                                    <div class="card-head text-center">
                                        <h3 class="owl-item-main-heading">What do you want to do Today?</h3>
                                    </div>
                                    <div class="card-body" style="margin-top: 0;padding-top: 5px;padding-right: 0;padding-left: 0;">
                                        <p class="subtext"> Use these tools to drive traffic to your site,
                                            generate revenue and build your reputation</p>
                                        <a href="javascript:void(0);" class="btn btn-primary btn-begin">Begin</a>
                                    </div>
                                </div>
                            </div>

                            <div style="display:none;" class="card card-1 owl-card-carasol">
                                <div class="own-card-content">
                                    <div class="card-head text-center">
                                        <h3 class="owl-item-main-heading">What do you want to do Today?</h3>
                                    </div>

                                    <?php
                                    $items = [
                                        'Get over 50 new patient leads each month' => 'val',
                                        'Leverage social media to drive engagement',
                                        'Generate 25% more web traffic',
                                        'Schedule 5 new niche procedures',
                                        'Become the go-to expert in your industry',
                                        'Generate more patient reviews',
                                        'Get Found on Google Search',
                                        'Earn instant revenue with a new promotion'
                                    ];
                                    ?>
                                    <div class="card-body" style="margin-top: 0;padding-top: 5px;padding-right: 0;padding-left: 0;">
                                        <div class="owl-carousel owl-theme">
                                            @if(!empty($widgetItems))
                                                @foreach($widgetItems as $item)
                                                    <div class="item">
                                                        <div class="c1-t1">
                                                            <p class="subtext">
                                                                {{ $item['title'] }}
                                                            </p>
                                                            {{--                                                                <duv style="display: block;" class="sub-description">{{ $item['description'] }}</duv>--}}
                                                            <div>
                                                                <a href="javascript:void(0);" data-target="{{ $item['id'] }}" class="btn btn-primary btn-continue">Continue</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                        {{--                        <div class="col-sm-6 col-lg-4">
                                                    <div class="card card-4">

                                                        <div class="card-head">
                                                            <h3 class="widget-type" data-widget-type="social_media">Social Media Stats <span><a href="javascript:void(0)" class="widget-help-selector">
                        --}}{{--                                                <i class="fa fa-question-circle-o" style="margin-left: 3px;"></i>--}}{{--
                                                                    </a></span></h3>
                                                            <a href="javascript:void(0);" style="display: none"><label class="">View Report</label></a>

                                                            --}}{{-- <p class="header-subtext">Stats from your social media accounts.</p> --}}{{--
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row social-score">
                                                                <div class="col-xs-6">
                                                                    <div class="facebook-widget">
                                                                        <span class="percentage"><i class="mdi mdi-arrow-up"></i>7.6%</span>
                                                                        <h3 class="likes">
                                                                            {{ !empty($socialResult['page_likes_count']) ? $socialResult['page_likes_count'] : 0 }}
                                                                        </h3>
                                                                        <label>New Likes</label>
                                                                        --}}{{--     <div class="social-icon">
                                                                                 <img src="{{ asset('public/images/icons/facebook-widget.png') }}"/>
                                                                                 <label>Facebook</label>
                                                                             </div>--}}{{--
                                                                    </div>
                                                                    <div class="instagram-widget">
                                                                        <span class="percentage"><i class="mdi mdi-arrow-up"></i>6.6%</span>

                                                                        <h3 class="likes">
                                                                            {{ !empty($socialResult['page_reviews_count']) ? $socialResult['page_reviews_count'] : 0 }}
                                                                        </h3>
                                                                        <label>New Engagement</label>
                                                                        --}}{{-- <div class="social-icon">
                                                                             <img src="{{ asset('public/images/icons/facebook-widget.png') }}"/>
                                                                             <label>Facebook</label>
                                                                         </div>--}}{{--

                                                                    </div>

                                                                </div>
                                                                <div class="col-xs-6">

                                                                    <div class="twitter-widget">
                                                                        <span class="percentage"><i class="mdi mdi-arrow-up"></i>9.6%</span>

                                                                        <h3 class="likes">
                                                                            {{ !empty($twitterResult['followers']) ? $twitterResult['followers'] : 0 }}
                                                                        </h3>
                                                                        <label>New Followers</label>
                                                                        --}}{{--   <div class="social-icon">
                                                                               <img src="{{ asset('public/images/icons/twitter-widget.png') }}"/>
                                                                               <label>Twitter</label>
                                                                           </div>--}}{{--

                                                                    </div>
                                                                    <div class="foursquare-widget">
                                                                        <span class="percentage"><i class="mdi mdi-arrow-up"></i>5.6%</span>

                                                                        <h3 class="likes">
                                                                            {{ !empty($twitterResult['page_likes_count']) ? $twitterResult['page_likes_count'] : 0 }}
                                                                        </h3>
                                                                        <label>New Engagement</label>
                                                                        --}}{{-- <div class="social-icon">
                                                                             <img src="{{ asset('public/images/icons/twitter-widget.png') }}"/>
                                                                             <label>Twitter</label>
                                                                         </div>--}}{{--

                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>

                                                </div>--}}


                        {{--                        mycode--}}

                        <div  class="col-sm-6 col-lg-4 invite-card">
                            <div class="card card-3">
                                <div class="bg-white" style="padding: 5px 10px;">
                                    <div class="d-flex justify-content-between card-head">
                                        <h3 class="font-normal widget-type" data-widget-type="new_patient_emails" style="margin: 0 0 20px 0 !important;">
{{--                                            Welcome to the Practice--}}
                                            New Patient Package
                                            <span>
                                                <a href="javascript:void(0)" class="widget-help-selector">
{{--                                                    <i class="fa fa-question-circle-o email-icon"></i>--}}
                                                </a>
                                            </span>
                                        </h3>
                                        <a href="{{ route('front.new-patient-emails') }}"><label class="">View Emails</label></a>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-8">
                                            <div id="addCustomerStep1 m-t-5" class="row star-box-size">
                                                {{--                                            <div class="col-md-12">--}}
                                                {{--                                                <img class="dashboa-email" src="{{ asset('public/images/Layer18.png') }}" />--}}
                                                {{--                                            </div>--}}
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <input type="text" id="patient-first-name" class="form-control dashboard-input" placeholder="Patient Name">
                                                        <span class="help-block hide-me"><small></small></span>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <input type="email" id="patient-email" class="form-control dashboard-input m-0" placeholder="Patient Email">
                                                    </div>
                                                </div>

                                                <div class="col-sm-12 text-left p-t-15" style="margin-top: 15px">
                                                    <button class="btn btn-primary send-patient-email">Send Invite</button>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-sm-4 text-right widgets5-leadyimg ">
                                            <img src="{{ asset('public/images/leadyimg.png') }}" alt="">

                                        </div>
                                    </div>





                                </div>

                            </div>
                        </div>



                        <div class="col-sm-6 col-lg-4" style="">
{{--                            <div class="card local-listing-status">--}}
                            <div class="card websiteAnalytics">
                                <div class="dashboard-card-loader" style="display: none; !important;background: rgba(255,255,255,0.77)!important;"></div>
                                <div class="card-head">
                                    <div class="headingGoogleOuter" style="display: flex">
                                        <div class="headingGoogle">
                                            <h3 class="">Google Analytics</h3>
{{--                                            {{$website}}--}}
                                        </div>

                                        @if(!empty($googleAnalyticsWebsite) && !empty($userBusiness['website']))
                                            <div class="dropdown  pull-right" style="margin-left: auto">
                                                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                                                    <span class="caret"></span></button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="googlePageViews" href="javascript:void(0);" data-filter-value="day">Today</a></li>
                                                    <li><a class="googlePageViews" href="javascript:void(0);" data-filter-value="week">Last 7 Days</a></li>
                                                    <li><a class="googlePageViews" href="javascript:void(0);" data-filter-value="all">Last 30 Days</a></li>
                                                </ul>
                                            </div>
                                        @endif
                                    </div>

                                    <?php
                                    //                                    $website = '';
                                    //                                    if(!empty($webResult['domain']))
                                    //                                    {
                                    //                                        $website = $webResult['domain'];
                                    //                                    }
                                    ?>

                                    <p class="header-subtext">
                                        @if(!empty($googleAnalyticsWebsite) && !empty($userBusiness['website']))
                                            {{$googleAnalyticsWebsite}}
                                        @else
                                            {{ !empty($userBusiness['website']) ? $userBusiness['website'] : 'No website found' }}
                                        @endif
                                    </p>
                                    {{--                                     <p class="header-subtext">--}}
                                    {{--                                            @if(!empty($userData['business'][0]['website']))--}}
                                    {{--                                                {{$userData['business'][0]['website']}}--}}
                                    {{--                                            @else--}}
                                    {{--                                                <p>No website found</p>--}}
                                    {{--                                            @endif--}}
                                    {{--                                     </p>--}}
                                </div>
                                <div class="card-body website-page-views" style="display: flex;align-items: center;justify-content: center;">
                                    <div class="loader-img" style="display: none!important;position: absolute;">
                                        <img src="{{ asset('public/images/blue-spinner.gif') }}">
                                    </div>
                                    <div class="grid">
                                        @if(!empty($googleAnalytics) && $googleAnalytics == 'installed' && !empty($statTractingCount))
                                            {{--                                            @if(!empty($googleAnalyticsViewsCount))--}}
                                            {{--                                                <p class="countBefore"></p>--}}
                                            <div class="card-source">{{(!empty($statTractingCount)) ?  $statTractingCount : ''}}</div>
                                            <p class="page-views" style="font-size: 16px;font-weight: 600;">Page Views</p>
                                            <div class="notifaction-alert insight-alert @if(!empty($insightStatus) && $insightStatus == 'down')danger @elseif(!empty($insightStatus) && $insightStatus == 'average') average @else success @endif">
                                                <span class="dashboard-popover" data-container="body" data-toggle="popover" data-placement="right" data-content="" style="" data-original-title="" title="">
                                                    <i class="fa fa-info"></i>
                                                </span>
                                                <span class="review-status">{{ strip_tags($insightTitle, 'br') }}</span>
                                            </div>
                                            {{--                                                <p class="card-success-alert" style="font-size: 16px;font-weight: 600;color: #3D4A9E; margin-top: 0">Google Analytics Detected</p>--}}
                                            {{--                                                <div class="card-button">--}}
                                            {{--                                                    <button class="btn btn-primary connect-analytics" style="color: white">Google Analytics</button>--}}
                                            {{--                                                </div>--}}
                                        @elseif((!empty($googleAnalytics) && $googleAnalytics == 'installed' ) && empty($statTractingCount))
{{--                                            <p class="page-views" style="font-size: 16px;font-weight: 600;">Page Views</p>--}}
                                            <p class="card-success-alert" style="font-size: 16px;font-weight: 600;color: #3D4A9E; margin-top: 0">Google Analytics Detected</p>
                                            <div class="card-button">
                                                <button class="btn btn-primary connect-analytics" style="color: white">Add Google Analytics</button>
                                            </div>
                                            {{--                                            @endif--}}
                                        @else
{{--                                            <p style="font-size: 16px;font-weight: 600;">Page Views</p>--}}
                                            @if(empty($userBusiness['website']))
                                                <div style="display: flex;align-items: center;justify-content: center;padding: 0 30px;">
                                                    <a href="javascript:void(0);" class="btn btn-primary btn-website-connect" style="width: 100%;">Connect Website</a>
                                                </div>
                                            @else
                                                <p class="" style="font-size: 16px;font-weight: 600;color: #3D4A9E;">Google Analytics Not Found</p>
                                            @endif
                                        @endif
                                        {{--                                        @elseif(empty($userData['business'][0]['website']))--}}
                                        {{--                                            <p style="font-size: 16px;font-weight: 600;">Page Views</p>--}}
                                        {{--                                            <p style="font-size: 16px;font-weight: 600;color: #3D4A9E;">No Website Added.</p>--}}
                                        {{--                                            <button class="btn btn-primary add-business" data-toggle="modal" data-target="#add-website">Add Website</button>--}}

                                    </div>
                                </div>
                            </div>
                        </div>

                        {{--                        <div  class="col-sm-6 col-lg-4">--}}
                        {{--                            <div class="card email-marketing">--}}
                        {{--                                <div class="card-head">--}}
                        {{--                                    <h3 class="widget-type" data-widget-type="email_marketing_stats">--}}{{--Email Marketing--}}{{--Quick Stats  <span><a href="javascript:void(0)" class="widget-help-selector">--}}
                        {{--                                                <i class="fa fa-question-circle-o"></i>--}}
                        {{--                                            </a></span></h3>--}}
                        {{--                                    <a href="{{ route('reviews-recipients') }}"><label class="">View Report</label></a>--}}
                        {{--                                    --}}{{--<p class="header-subtext">Realtime tracking statistics.</p>--}}
                        {{--                                </div>--}}
                        {{--                                <div class="card-body">--}}
                        {{--                                    --}}{{--                                        <img class="email-m-header-img" src="{{ asset('public/images/email-marketing.png') }}">--}}
                        {{--                                    --}}{{--<hr class="div-separator">--}}
                        {{--                                    <div class="marketing-stats">--}}
                        {{--                                        <div class="row">--}}
                        {{--                                            <div class="sent-delivered">--}}
                        {{--                                                <div class="col-xs-6">--}}
                        {{--                                                    <div class="sent m-b-5 ">--}}
                        {{--                                                        @if(!empty($campaignStatsCount['sent']))--}}
                        {{--                                                            <h3>{{ $campaignStatsCount['sent'] }}</h3>--}}
                        {{--                                                        @else--}}
                        {{--                                                            <h3>0 </h3>--}}
                        {{--                                                        @endif--}}
                        {{--                                                        <div><label># of Subscribers</label></div>--}}
                        {{--                                                    </div>--}}
                        {{--                                                </div>--}}
                        {{--                                                <div class="col-xs-6">--}}
                        {{--                                                    <div class="opened m-b-5">--}}
                        {{--                                                        @if(!empty($campaignStatsCount['open']))--}}
                        {{--                                                            <h3>{{ $campaignStatsCount['open'] }}</h3>--}}
                        {{--                                                            <h3 class="">&#37;</h3>--}}
                        {{--                                                        @else--}}
                        {{--                                                            <h3>0</h3>--}}
                        {{--                                                            <h3 class="">&#37;</h3>--}}
                        {{--                                                        @endif--}}
                        {{--                                                        <div>  <label>Open Rate</label></div>--}}
                        {{--                                                    </div>--}}
                        {{--                                                </div>--}}
                        {{--                                            </div>--}}
                        {{--                                        </div>--}}

                        {{--                                        <hr class="divider">--}}
                        {{--                                        <div class="row">--}}
                        {{--                                            <div class="opened-clicked">--}}
                        {{--                                                <div class="col-xs-6">--}}
                        {{--                                                    <div class="sent">--}}
                        {{--                                                        @if(!empty($campaignStatsCount['unsub']))--}}
                        {{--                                                            <h3>{{ $campaignStatsCount['unsub'] }}</h3>--}}
                        {{--                                                        @else--}}
                        {{--                                                            <h3>0</h3>--}}

                        {{--                                                        @endif--}}
                        {{--                                                        <div><label># of Unsubscribes</label></div>--}}
                        {{--                                                    </div>--}}
                        {{--                                                </div>--}}

                        {{--                                                <div class="col-xs-6">--}}
                        {{--                                                    <div class="opened">--}}
                        {{--                                                        @if(!empty($campaignStatsCount['click']))--}}
                        {{--                                                            <h3>{{ $campaignStatsCount['click'] }}</h3>--}}
                        {{--                                                            <h3 class="" >&#37;</h3>--}}
                        {{--                                                        @else--}}
                        {{--                                                            <h3>0</h3>--}}
                        {{--                                                            <h3 class="" >&#37;</h3>--}}
                        {{--                                                        @endif--}}
                        {{--                                                        <div>  <label>Click-Through Rate</label></div>--}}
                        {{--                                                    </div>--}}

                        {{--                                                </div>--}}
                        {{--                                            </div>--}}
                        {{--                                        </div>--}}
                        {{--                                    </div>--}}
                        {{--                                --}}{{--                                        <div class="marketing-stats-footer">--}}
                        {{--                                --}}{{--                                            <label>Bounced<span>0</span></label>--}}
                        {{--                                --}}{{--                                            <label>Unsubscribed<span>0</span></label>--}}
                        {{--                                --}}{{--                                        </div>--}}
                        {{--                                <!-- <div class="emailmarketing-list">--}}
                        {{--                                         <ul>--}}
                        {{--                                             <li>--}}
                        {{--                                                 <div class="list-item">--}}
                        {{--                                                     <span>Forwards</span>--}}
                        {{--                                                 </div>--}}
                        {{--                                                 <span>2</span>--}}
                        {{--                                             </li>--}}
                        {{--                                             <li>--}}
                        {{--                                                 <div class="list-item">--}}
                        {{--                                                     <span>Bounces</span>--}}
                        {{--                                                 </div>--}}
                        {{--                                                 <span>2</span>--}}
                        {{--                                             </li>--}}
                        {{--                                             <li>--}}
                        {{--                                                 <div class="list-item">--}}
                        {{--                                                     <span>Spam Reports</span>--}}
                        {{--                                                 </div>--}}
                        {{--                                                 <span>2</span>--}}
                        {{--                                             </li>--}}
                        {{--                                             <li>--}}
                        {{--                                                 <div class="list-item">--}}
                        {{--                                                     <span>Unsubscribers</span>--}}
                        {{--                                                 </div>--}}
                        {{--                                                 <span>2</span>--}}
                        {{--                                             </li>--}}
                        {{--                                             <li>--}}
                        {{--                                                 <div class="list-item">--}}
                        {{--                                                     <span>Did Not Open</span>--}}
                        {{--                                                 </div>--}}
                        {{--                                                 <span>2</span>--}}
                        {{--                                             </li>--}}


                        {{--                                         </ul>--}}
                        {{--                                         </div>-->--}}
                        {{--                                </div>--}}


                        {{--                            </div>--}}

                        {{--                        </div>--}}

                        {{--                            <div class="col-sm-6 col-lg-4">--}}
                        {{--                                <div class="card card-3">--}}

                        {{--                                    <div class="card-head">--}}
                        {{--                                        <h3 class="">Reputation Manager</h3>--}}
                        {{--                                        <a href="{{ route('reviews-recipients') }}"><label class="">View Report</label></a>--}}
                        {{--                                        <p class="header-subtext">Track emails and text invitations.</p>--}}
                        {{--                                    </div>--}}
                        {{--                                    <div class="card-body">--}}
                        {{--                                        <div class="row">--}}
                        {{--                                            <div class="col-xs-6">--}}
                        {{--                                                <div class="email-section">--}}
                        {{--                                                    <img src="{{ asset('public/images/icons/envelope.png') }}"/>--}}
                        {{--                                                    <div class="sent">--}}
                        {{--                                                        @if(!empty($requestDelivered))--}}
                        {{--                                                            <h3>{{ $requestDelivered }}</h3>--}}
                        {{--                                                        @else--}}
                        {{--                                                            <h3>0</h3>--}}
                        {{--                                                        @endif--}}
                        {{--                                                        <div><label>Emails Sent</label></div>--}}

                        {{--                                                    </div>--}}
                        {{--                                                    <div class="opened">--}}
                        {{--                                                        @if(!empty($requestOpen))--}}
                        {{--                                                            <h3>{{ $requestOpen }}</h3>--}}
                        {{--                                                        @else--}}
                        {{--                                                            <h3>0</h3>--}}
                        {{--                                                        @endif--}}
                        {{--                                                        <div><label>Opened</label></div>--}}
                        {{--                                                    </div>--}}
                        {{--                                                </div>--}}

                        {{--                                            </div>--}}

                        {{--                                            <div class="col-xs-6">--}}
                        {{--                                                <div class="chat-section">--}}
                        {{--                                                    <img src="{{ asset('public/images/icons/speech-bubble.png') }}"/>--}}
                        {{--                                                    <div class="sent">--}}
                        {{--                                                        <h3>0</h3>--}}
                        {{--                                                        <div><label>Text Msgs Sent</label></div>--}}

                        {{--                                                    </div>--}}
                        {{--                                                    <div class="opened">--}}

                        {{--                                                        <h3>0</h3>--}}
                        {{--                                                        <div><label>Opened</label></div>--}}
                        {{--                                                    </div>--}}
                        {{--                                                </div>--}}

                        {{--                                            </div>--}}

                        {{--                                        </div>--}}
                        {{--                                    </div>--}}


                        {{--                                </div>--}}

                        {{--                            </div>--}}

                        <div class="col-sm-6 col-lg-4">
                            <div class="card local-listing-status">

                                <div class="card-head">
                                    <h3  class="widget-type" data-widget-type="citation_listings">Citation Listings <span><a href="javascript:void(0)" class="widget-help-selector">
{{--                                                <i class="fa fa-question-circle-o"></i>--}}
                                            </a></span></h3>
                                    {{--                                    <a href="{{ route('citation-listings') }}"><label class="">View Report</label></a>--}}
                                    <a href="{{ route('citation-listings') }}"><label class="">View Listings</label></a>

                                </div>
                                <div class="card-body citation-widgets7 " style="margin-top: 27px; display: block;flex-direction: column;justify-content: center;">

                                    <div class="row" style="display: flex; justify-content: center;">
                                        <div class="col-4" style="width: 33.33333333%;">
                                            <div class="citation-box complete">
                                                <h3>
                                                    @isset($completeListing)
                                                        @if($completeListing)
                                                            {{ $completeListing }}
                                                        @else
                                                            0
                                                        @endif
                                                    @endisset

                                                </h3>
                                                <p>Complete</p>
                                                <span class="icon">
                                                        <i class="fa fa-check" aria-hidden="true"></i>
                                                    </span>
                                            </div>
                                        </div>

                                        <div class="col-4" style="width: 33.33333333%;">
                                            <div class="citation-box incomplete">
                                                <h3>
                                                    @isset($incompleteListing)
                                                        @if($incompleteListing)
                                                            {{ $incompleteListing }}
                                                        @else
                                                            0
                                                        @endif
                                                    @endisset

                                                </h3>
                                                <p>Incomplete</p>
                                                <span class="icon">
                                                        <i class="fa fa-info" aria-hidden="true"></i>
                                                    </span>
                                            </div>
                                        </div>

                                        {{--                                        <div class="col-4" style="width: 33.33333333%;">--}}
                                        {{--                                            <div class="citation-box missing">--}}
                                        {{--                                                <h3>0</h3>--}}
                                        {{--                                                <p>Missing</p>--}}
                                        {{--                                                <span class="icon">--}}
                                        {{--                                                        <i class="fa fa-minus" aria-hidden="true"></i>--}}
                                        {{--                                                    </span>--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </div>--}}
                                    </div>
                                    @if(!empty($sources))
                                        <div class="row-main" style="margin-top: 20px;">
                                            @foreach($sources as $source)
                                                <?php
                                                $reviewType = str_replace(" ", "", strtolower($source['name']));
                                                if(strtolower($reviewType) == 'yelp' || strtolower($reviewType) == 'healthgrades' || strtolower($reviewType) == 'zocdoc')
                                                {
                                                $originalName = $source['name'];
                                                $name = $originalName;

                                                if($name == 'Google Places')
                                                {
                                                    $name = 'Google';
                                                }

                                                $data = ( !empty($source['data']) ) ? $source['data'] : '';
                                                ?>

                                                <div class="row" style="margin-bottom: 8px;">
                                                    <div class="col-xs-6">
                                                        <img style="float: left; margin-right: 5px;"  src="{{ asset('public/images/icons/'.$reviewType.'.png') }}"/>
                                                        <label style="float: left;">{{ $name }}</label>
                                                    </div>

                                                    <div class="col-xs-6">
                                                        @if(!empty($data) && $source['status'])
                                                            <div style="color: #50B242;" class="review-text text-success">
                                                                Listed
                                                            </div>
                                                        @else
                                                            <div class="review-text text-danger">
                                                                Not Listed
                                                            </div>
                                                        @endif
                                                    </div>

                                                </div>


                                                <?php
                                                } ?>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-4">
                            @if(!empty($webResult['domain']))
                                <div class="card website-audit">
                                    <div class="card-head">
                                        <h3 class="widget-type" data-widget-type="seo_audit_report">SEO Audit Report
                                            {{--                                            <span><a href="javascript:void(0)" class="widget-help-selector"><i class="fa fa-question-circle-o"></i></a></span>--}}
                                        </h3>

                                        <?php
                                        $website = '';
                                        if(!empty($webResult['domain']))
                                        {
                                            $website = $webResult['domain'];
                                        }
                                        ?>

                                        @if(!empty($website))
                                            <a href="{{ route('website-audit') }}"><label class="">View Report</label></a>
                                        @endif

                                        <p class="header-subtext">
                                            {{ !empty($website) ? $website : 'No website found' }}
                                        </p>

                                    </div>
                                    <div class="card-body">
                                        <div class="grid">
                                            <section>
                                                <?php
                                                $pageScore = !empty($webResult['score']) ? $webResult['score'] : 0;
                                                ?>
                                                <svg class="circle-chart" viewBox="0 0 33.83098862 33.83098862" width="120" height="120" xmlns="http://www.w3.org/2000/svg" style="border-radius: 100px;">
                                                    <circle class="circle-chart__background" stroke="#E5E5E5" stroke-width="2.5" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431" style="/* display: none; */"></circle>
                                                    <circle class="circle-chart__circle" stroke="#3D4A9E" stroke-width="2.5"
                                                            stroke-dasharray="{{ $pageScore }},100" stroke-linecap="round" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431"></circle>

                                                    <g class="circle-chart__info">
                                                        <text class="circle-chart__percent" x="16.91549431" y="15.5" alignment-baseline="central" text-anchor="middle" font-size="8">{{ $pageScore }}
                                                        </text>
                                                    </g>
                                                </svg>
                                            </section>

                                        </div>
                                        <div class="audit-list">
                                            <ul>
                                                <li>
                                                    <div class="list-item">
                                                        <span class="w-green"></span>
                                                        <span class="w-status">Passed</span>
                                                    </div>
                                                    <span>{{ $pageScore }}</span>
                                                </li>
                                                <li>
                                                    <div class="list-item">
                                                        <span class="w-red"></span>
                                                        <span class="w-status">Errors</span>
                                                    </div>
                                                    <span>{{ getIndexedvalue($webResult, 'errorScore', 0) }}</span>
                                                </li>
                                                <li>
                                                    <div class="list-item">
                                                        <span class="w-orange"></span>
                                                        <span class="w-status">To Improve</span>
                                                    </div>
                                                    <span>{{ getIndexedvalue($webResult, 'improveScore', 0) }}</span>
                                                </li>
                                                {{--<li>--}}
                                                {{--<div class="list-item">--}}
                                                {{--<span class="w-grey"></span>--}}
                                                {{--<span class="w-status">Healthy Links</span>--}}
                                                {{--</div>--}}
                                                {{--<span>{{ getIndexedvalue($webResult, 'in_page_links', 0) }}</span>--}}
                                                {{--</li>--}}
                                                {{--<li>--}}
                                                {{--<div class="list-item">--}}
                                                {{--<span class="w-black"></span>--}}
                                                {{--<span class="w-status">Broken Links</span>--}}
                                                {{--</div>--}}
                                                {{--<span>{{ getIndexedvalue($webResult, 'broken_links', 0) }}</span>--}}
                                                {{--</li>--}}
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @elseif(!empty($businessResult['website']))
                                <div class="card website-audit">
                                    <div class="card-head">
                                        <h3 class="widget-type" data-widget-type="website_audit">SEO Audit Report
                                            {{--                                            <span><a href="javascript:void(0)" class="widget-help-selector">--}}
                                            {{--                                                    <i class="fa fa-question-circle-o" ></i>--}}
                                            {{--                                                </a></span>--}}
                                        </h3>
                                        <a href="{{ route('website-audit') }}"><label class="">View Audit Report</label></a>
                                        {{-- <p class="header-subtext">
                                            Gathering data. once data ready it will show here
                                        </p> --}}

                                    </div>
                                    <div class="card-body">
                                        <div class="grid">
                                            <section>
                                                <?php
                                                $pageScore = 0;
                                                ?>
                                                <svg class="circle-chart" viewBox="0 0 33.83098862 33.83098862" width="120" height="120" xmlns="http://www.w3.org/2000/svg" style="border-radius: 100px;">
                                                    <circle class="circle-chart__background" stroke="#E5E5E5" stroke-width="2.5" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431" style="/* display: none; */"></circle>
                                                    <circle class="circle-chart__circle" stroke="#3D4A9E" stroke-width="2.5"
                                                            stroke-dasharray="{{ $pageScore }},100" stroke-linecap="round" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431"></circle>

                                                    <g class="circle-chart__info">
                                                        <text class="circle-chart__percent" x="16.91549431" y="15.5" alignment-baseline="central" text-anchor="middle" font-size="8">{{ $pageScore }}
                                                        </text>
                                                    </g>
                                                </svg>
                                            </section>

                                        </div>
                                        <div class="audit-list">
                                            <ul>
                                                <li>
                                                    <div class="list-item">
                                                        <span class="w-green"></span>
                                                        <span class="w-status">Passed</span>
                                                    </div>
                                                    <span>0</span>
                                                </li>
                                                <li>
                                                    <div class="list-item">
                                                        <span class="w-red"></span>
                                                        <span class="w-status">Errors</span>
                                                    </div>
                                                    <span>0</span>
                                                </li>
                                                <li>
                                                    <div class="list-item">
                                                        <span class="w-orange"></span>
                                                        <span class="w-status">To Improve</span>
                                                    </div>
                                                    <span>0</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @else
                                {{--{{ $businessResult['website'] }}--}}
                                <div class="card website-audit">
                                    <div class="card-head">
                                        <h3  class="widget-type" data-widget-type="website_audit">Website Audit <span><a href="javascript:void(0)" class="widget-help-selector"><i class="fa fa-question-circle-o"></i></a></span></h3>
                                        <a href="{{ route('website-audit') }}"><label class="">View Audit Report</label></a>
                                        {{-- <p class="header-subtext">
                                            No website found
                                        </p> --}}

                                    </div>
                                    <div class="card-body">
                                        <div class="grid">
                                            <section>
                                                <?php
                                                $pageScore = 0;
                                                ?>
                                                <svg class="circle-chart" viewBox="0 0 33.83098862 33.83098862" width="120" height="120" xmlns="http://www.w3.org/2000/svg" style="border-radius: 100px;">
                                                    <circle class="circle-chart__background" stroke="#E5E5E5" stroke-width="2.5" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431" style="/* display: none; */"></circle>
                                                    <circle class="circle-chart__circle" stroke="#3D4A9E" stroke-width="2.5"
                                                            stroke-dasharray="{{ $pageScore }},100" stroke-linecap="round" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431"></circle>

                                                    <g class="circle-chart__info">
                                                        <text class="circle-chart__percent" x="16.91549431" y="15.5" alignment-baseline="central" text-anchor="middle" font-size="8">{{ $pageScore }}
                                                        </text>
                                                    </g>
                                                </svg>
                                            </section>

                                        </div>
                                        <div class="audit-list">
                                            <ul>
                                                <li>
                                                    <div class="list-item">
                                                        <span class="w-green"></span>
                                                        <span class="w-status">Passed</span>
                                                    </div>
                                                    <span>0</span>
                                                </li>
                                                <li>
                                                    <div class="list-item">
                                                        <span class="w-red"></span>
                                                        <span class="w-status">Errors</span>
                                                    </div>
                                                    <span>0</span>
                                                </li>
                                                <li>
                                                    <div class="list-item">
                                                        <span class="w-orange"></span>
                                                        <span class="w-status">To Improve</span>
                                                    </div>
                                                    <span>0</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{--                            Refer a colleagu--}}
                        <div  class="col-sm-6 col-lg-4 invite-card">
                            <div class="card card-3">
                                <div class="d-flex justify-content-between card-head" >
                                    <h3 class="font-normal widget-type" data-widget-type="get_rewarded" style="margin: 0 0 20px 0 !important;">
                                        Get Free Credits!
                                        {{-- <span><a href="javascript:void(0)" class="widget-help-selector"><i class="fa fa-question-circle-o"></i></a></span> --}}
                                    </h3>
                                </div>
                                <div id="addCustomerStep1 m-t-5" class="row">
                                    <div class="col-sm-8  m-t-20">
                                        <p style="max-width: 210px; color: #7a7671; ">Refer your colleagues and earn credits to order some of our most popular pro-services - Free!</p>
                                        {{--                                            <div class="col-md-4 col-sm-12 text-center p-l-0">--}}
                                        {{--                                                <img class="" src="{{ asset('public/images/Layer20.png') }}" />--}}
                                        {{--                                            </div>--}}
                                        {{--                                            <div class="col-md-8 col-sm-12 text-sm-center m-t-20">--}}
                                        {{--                                                <div class="refer-rewarded">--}}
                                        {{--                                                    <h3>GET REWARDED</h3>--}}
                                        {{--                                                </div>--}}
                                        {{--                                                <div>--}}
                                        {{--                                                    <p>Earn <span style="color: #76A119 !important; font-weight: bold;" >$150</span> when your colleague joins nichepractice</p>--}}
                                        {{--                                                </div>--}}
                                        {{--                                            </div>--}}
                                        <div class="text-right p-l-0 p-t-20" style="margin-top: 35px; text-align: left">
                                            {{--                                            <button class="btn btn-primary" style="width: 60%;">Refer a Colleague Now</button>--}}
                                            <a href="{{ route('referpage') }}" class="btn btn-primary" style="width: 100%;">Refer a Colleague Now</a>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 text-right widgets9-leady ">
                                        <img src="{{ asset('public/images/leady.png') }}" alt="">

                                    </div>


                                </div>
                            </div>

                        </div>




                        <div class="col-sm-6 col-lg-4" style="display: none">
                            <div class="card local-listing-status">

                                <div class="card-head">
                                    <h3 class="">Google Rank</h3>
                                    <a href="{{ route('settings.keywords') }}">
                                        <label class="">View Report</label>
                                    </a>

                                    @if(empty($userData['business'][0]['website']) && !empty($keywords))
                                        <p class="header-subtext">To Get keyword rank <a href="{{ route('business-profile') }}">Add Website</a></p>
                                    @endif
                                </div>


                                @if(!empty($keywords))
                                    <div class="card-body">
                                        <div class="counter-list">
                                            <ul>
                                                @foreach($keywords as $row)
                                                    <li>
                                                        <div class="keyword-item">
                                                            <span>{{ $row['keyword'] }}</span>
                                                        </div>
                                                        <?php
                                                        $rank = ($row['rank_status'] == 'complete' && $row['rank'] == null) ? 'Not in Top 100' : ($row['rank_status'] == 'progress' && $row['rank'] == null ? 'Gathering Data' : $row['rank']);
                                                        ?>
                                                        <span class="rank-des">{{ $rank }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @else
                                    <div class="card-body">
                                        <a href="{{ route('settings.keywords') }}" class="btn btn-primary btn-keywords" style="margin-top: 25%;background: #695f5f !important;border: #695f5f !important;padding-left: 40px;padding-right: 40px;">Add / Update Keywords</a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{--                        <div class="col-sm-6 col-lg-4" style="">--}}
                        {{--                            <div class="card local-listing-status">--}}
                        {{--                                <div class="card-head">--}}
                        {{--                                    <h3 class="">Google Analytics</h3>--}}
                        <?php
                        //                                    $website = '';
                        //                                    if(!empty($webResult['domain']))
                        //                                    {
                        //                                        $website = $webResult['domain'];
                        //                                    }
                        ?>

                        {{--                                    <p class="header-subtext">--}}
                        {{--                                        {{ !empty($userData['business'][0]['website']) ? $userData['business'][0]['website'] : 'No website found' }}--}}
                        {{--                                    </p>--}}
                        {{--                                     <p class="header-subtext">--}}
                        {{--                                            @if(!empty($userData['business'][0]['website']))--}}
                        {{--                                                {{$userData['business'][0]['website']}}--}}
                        {{--                                            @else--}}
                        {{--                                                <p>No website found</p>--}}
                        {{--                                            @endif--}}
                        {{--                                     </p>--}}
                        {{--                                </div>--}}
                        {{--                                <div class="card-body website-page-views">--}}
                        {{--                                    <div class="grid">--}}
                        {{--                                        @if(!empty($googleAnalytics) && $googleAnalytics == 'installed' && !empty($statTractingCount))--}}
                        {{--                                            @if(!empty($googleAnalyticsViewsCount))--}}
                        {{--                                                <p class="countBefore"></p>--}}
                        {{--                                                <div class="card-source">{{(!empty($statTractingCount)) ?  $statTractingCount : ''}}</div>--}}
                        {{--                                                <p class="page-views" style="font-size: 16px;font-weight: 600;">Page Views</p>--}}
                        {{--                                                <p class="card-success-alert" style="font-size: 16px;font-weight: 600;color: #3D4A9E; margin-top: 0">Google Analytics Detected</p>--}}
                        {{--                                                <div class="card-button">--}}
                        {{--                                                    <button class="btn btn-primary connect-analytics" style="color: white">Google Analytics</button>--}}
                        {{--                                                </div>--}}
                        {{--                                        @elseif((!empty($googleAnalytics) && $googleAnalytics == 'installed' ) && empty($statTractingCount))--}}
                        {{--                                                <p class="page-views" style="font-size: 16px;font-weight: 600;">Page Views</p>--}}
                        {{--                                                <p class="card-success-alert" style="font-size: 16px;font-weight: 600;color: #3D4A9E; margin-top: 0">Google Analytics Detected</p>--}}
                        {{--                                                <div class="card-button">--}}
                        {{--                                                    <button class="btn btn-primary connect-analytics" style="color: white">Google Analytics</button>--}}
                        {{--                                                </div>--}}
                        {{--                                            @endif--}}
                        {{--                                        @else--}}
                        {{--                                            <p style="font-size: 16px;font-weight: 600;">Page Views</p>--}}
                        {{--                                            <p class="" style="font-size: 16px;font-weight: 600;color: #3D4A9E;">Google Analytics Not Found</p>--}}
                        {{--                                        @endif--}}
                        {{--                                        @elseif(empty($userData['business'][0]['website']))--}}
                        {{--                                            <p style="font-size: 16px;font-weight: 600;">Page Views</p>--}}
                        {{--                                            <p style="font-size: 16px;font-weight: 600;color: #3D4A9E;">No Website Added.</p>--}}
                        {{--                                            <button class="btn btn-primary add-business" data-toggle="modal" data-target="#add-website">Add Website</button>--}}

                        {{--                                    </div>--}}
                        {{--                                </div>--}}

                        {{--                            </div>--}}
                        {{--                        </div>--}}

                    <!-- Modal -->
                        {{--                        <div id="add-website" class="modal fade" role="dialog">--}}
                        {{--                            <div class="modal-dialog">--}}

                        {{--                                <!-- Modal content-->--}}
                        {{--                                <div class="modal-content">--}}
                        {{--                                    <div class="modal-header">--}}
                        {{--                                        <button type="button" class="close" data-dismiss="modal">&times;</button>--}}
                        {{--                                        <h4 class="modal-title">Add Business Website.</h4>--}}
                        {{--                                    </div>--}}
                        {{--                                    <form class="business-profile">--}}
                        {{--                                        <div class="modal-body">--}}
                        {{--    --}}{{--                                            <div class="col-md-9">--}}
                        {{--    --}}{{--                                                <div class="data-fields">--}}
                        {{--                                                        <div class="row">--}}
                        {{--                                                            <div class="col-md-8">--}}
                        {{--                                                                <div class="input-field">--}}
                        {{--                                                                    <label>Website</label>--}}
                        {{--                                                                    <input type="text" class="form-control" id="website"--}}
                        {{--                                                                           value="{{ $userData['business'][0]['website'] }}"/>--}}
                        {{--                                                                </div>--}}
                        {{--                                                            </div>--}}
                        {{--                                                        </div>--}}
                        {{--    --}}{{--                                                </div>--}}
                        {{--    --}}{{--                                            </div>--}}
                        {{--    --}}{{--                                        <p>Some text in the modal.</p>--}}
                        {{--                                        </div>--}}
                        {{--                                        <div class="modal-footer">--}}
                        {{--                                            <div class="fields-footer" style="position: relative;">--}}
                        {{--                                                <button type="submit" class="btn btn-save" data-send="update-business-profile">Save</button>--}}
                        {{--                                            </div>--}}
                        {{--                                        </div>--}}
                        {{--                                    </form>--}}
                        {{--                                    <div class="modal-footer">--}}
                        {{--                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--}}
                        {{--                                    </div>--}}
                        {{--                                </div>--}}

                        {{--                            </div>--}}



                        {{--                            <div class="col-sm-6 col-lg-4">--}}
                        {{--                                <div class="landing-status">--}}
                        {{--                                    <div class="bg-white" style="padding: 5px 10px;">--}}
                        {{--                                        <div class="d-flex justify-content-between card-head">--}}
                        {{--                                            <h3 class="font-normal">--}}
                        {{--                                                Pay Per Click Ads--}}
                        {{--                                            </h3>--}}
                        {{--                                            <a href="javascript:void(0)"><label class="">View Report</label></a>--}}
                        {{--                                        </div>--}}
                        {{--                                        <div class="row d-flex text-center">--}}
                        {{--                                            <div class="col-xs-6">--}}
                        {{--                                                <img class="widget-ppc-image" src="{{ asset('public/images/google-image.png') }}" />--}}
                        {{--                                            </div>--}}
                        {{--                                            <div class="col-xs-6 landing-box-col ppc-widget-box">--}}
                        {{--                                                <div>--}}
                        {{--                                                    <label>Cost Per Conversion</label>--}}
                        {{--                                                    <span>0</span>--}}
                        {{--                                                </div>--}}
                        {{--                                                <div>--}}
                        {{--                                                    <label>Impressions</label>--}}
                        {{--                                                    <span>0</span>--}}
                        {{--                                                </div>--}}
                        {{--                                                <div>--}}
                        {{--                                                    <label>Clicks</label>--}}
                        {{--                                                    <span>0</span>--}}
                        {{--                                                </div>--}}
                        {{--                                                <div>--}}
                        {{--                                                    <label>Ctr</label>--}}
                        {{--                                                    <span>0</span>--}}
                        {{--                                                </div>--}}
                        {{--                                            </div>--}}
                        {{--                                        </div>--}}
                        {{--                                    </div>--}}

                        {{--                                </div></div>--}}




                        {{--                            <div class="col-sm-6 col-lg-4">--}}
                        {{--                                <div class="landing-status">--}}
                        {{--                                    <div class="bg-white" style="padding: 5px 10px;">--}}
                        {{--                                        <div class="d-flex justify-content-between card-head">--}}
                        {{--                                            <h3 class="font-normal">Landing Page</h3>--}}
                        {{--                                            <a href="javascript:void(0)"><label class="">View Report</label></a>--}}
                        {{--                                        </div>--}}
                        {{--                                        <div class="row d-flex align-items-center text-center">--}}
                        {{--                                            <div class="col-xs-6">--}}
                        {{--                                                <img src="{{ asset('public/images/landing-box.jpg') }}" alt="" style="width: 100%;height: auto;margin-top: 10px;">--}}
                        {{--                                            </div>--}}
                        {{--                                            <div class="col-xs-6 landing-box-col">--}}
                        {{--                                                <div>--}}
                        {{--                                                    <span>0</span>--}}
                        {{--                                                    <h4 class="m-0 font-normal">New Contacts</h4>--}}
                        {{--                                                    <hr style="width: 80%; margin: 5px auto;">--}}
                        {{--                                                </div>--}}
                        {{--                                                <div>--}}
                        {{--                                                    <span>0</span>--}}
                        {{--                                                    <h4 class="m-0 font-normal">New Visitors</h4>--}}
                        {{--                                                    <hr style="width: 80%; margin: 5px auto;">--}}
                        {{--                                                </div>--}}
                        {{--                                                <div>--}}
                        {{--                                                    <span>0</span>--}}
                        {{--                                                    <h4 class="m-0 font-normal">Sing-Up Rate</h4>--}}
                        {{--                                                    <hr style="width: 80%; margin: 5px auto;">--}}
                        {{--                                                </div>--}}
                        {{--                                                <div>--}}
                        {{--                                                    <span>0</span>--}}
                        {{--                                                    <h4 class="m-0 font-normal">Page Views</h4>--}}
                        {{--                                                </div>--}}
                        {{--                                            </div>--}}
                        {{--                                        </div>--}}
                        {{--                                    </div>--}}

                        {{--                                </div></div>--}}

                        {{--                            <div class="col-sm-6 col-lg-4">--}}
                        {{--                                <div class="card ppc-ads">--}}

                        {{--                                    <div class="card-head">--}}
                        {{--                                        <h3 class="">Pay Per Click Ads</h3>--}}
                        {{--                                        <a href="javascript:void(0);"><label class="view-report">View Report</label></a>--}}
                        {{--                                        <p class="header-subtext">Direct calls coming to your practice from digital--}}
                        {{--                                            ads..</p>--}}

                        {{--                                    </div>--}}
                        {{--                                    <div class="card-body">--}}
                        {{--                                        <div class="row">--}}
                        {{--                                            <div class="t-calls">--}}
                        {{--                                                <div class="col-xs-6">--}}

                        {{--                                                    <h3>0</h3>--}}
                        {{--                                                    --}}{{--<span class="percentage"><i class="mdi mdi-arrow-up"></i>7.6%</span>--}}
                        {{--                                                    <label>Today's Calls</label>--}}
                        {{--                                                </div>--}}

                        {{--                                                <div class="col-xs-6">--}}

                        {{--                                                    <h3>0</h3>--}}
                        {{--                                                    <label>Total Calls</label>--}}

                        {{--                                                </div>--}}
                        {{--                                            </div>--}}

                        {{--                                        </div>--}}

                        {{--                                        --}}{{--<figure class="highcharts-figure">--}}
                        {{--                                            --}}{{--<div id="reviews-graph"></div>--}}
                        {{--                                        --}}{{--</figure>--}}
                        {{--                                    </div>--}}


                        {{--                                </div>--}}

                        {{--                            </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($userData['discovery_status'] == 1 || $userData['discovery_status'] == 6)
        <!-- Modal -->
        @include('layouts.crm-customers.crm-add-customers-modals')
    @endif

    <input type="hidden" id="status" value="{{ $userData['discovery_status'] }}" />
    <input type="hidden" id="first-name" value="{{ $userData['first_name'] }}" />
    <input type="hidden" id="currentPage" value="home" />
    <input type="hidden" id="viewedSendReviewInviteSettings" value="{{ $viewedSendReviewInviteSettings }}" />
    @if(!empty($userData['business'][0]['website']))
        @if($appEnvIs == 'production')
            <input type="hidden" id="source" value="https://appreviewer.nichepractice.com/domain/{{ getUrlDomain($userData['business'][0]['website']) }}" />
        @else
            <input type="hidden" id="source" value="https://reviewer.nichepractice.com/domain/{{ getUrlDomain($userData['business'][0]['website']) }}" />
        @endif
    @endif
    @if((!empty($socialToken) && $socialToken == 1) && (!empty($accessTokenType)))
        <input type="hidden" id="accessToken" value="{{ $socialToken }}" data-type="{{ $accessTokenType }}" />
    @endif

@endsection


@section('css')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .pat-leads{
            margin-top: 25px;
        }
        .cont-btn{
            margin-top: 20px;
        }
        #main-modal .slimScrollBar{
            /*height: 0% !important;*/
        }
        #main-modal .slimScrollRail{
            /*height: 100% !important;*/
        }
        #main-modal .slimScrollDiv{
            /*height: 100% !important;*/
        }
        #main-modal .description-notify{
            height: 100% !important;
        }
        #main-modal .description-notify p{
            text-align: justify;
        }

        .create-your-account .modal-content{
            background: none;
            border: none;
        }
        .create-your-account .progress{
            height: 30px;
            border-radius: 0px;
        }
        .create-your-account .col-sm-4{
            padding: 1px;
        }
        .create-your-account .progress-bar{
            background-color: #6c9cd2;
            border-radius: 0px;
        }
        .create-your-account .modal-footer {
            background: none;
        }
        .create-your-account .popup-title{
            font-size: 28px;
            font-weight: 400;
            color: white;
        }
        .create-your-account h5{
            color: white;
        }
        .tick{
            color: #039a00;
            font-size: 18px;
            padding-right: 10px;

        }
        .grey-tick{
            color: #d2d0d0;
            font-size: 18px;
            padding-right: 10px;

        }
        h3.fin{
            color: #3963de!important;
        }
        @media screen and (max-width: 567px){
            .my-error-issue{
                display: flex;
                margin-top: 34px;
                align-items: baseline;
            }
        }
        #startHere {
            cursor: pointer;
            margin-top: 9px;
        }
        .closeWidget {
            display: flex;
            align-items: flex-start;
            justify-content: flex-start;
            color: black;
            font-size: 30px;
            background: transparent;
            border: none;
        }
    </style>

    <link type="text/css" href="{{ asset('public/css/plugins/owl.carousel.min.css') }}" rel="stylesheet" />
    <link type="text/css" href="{{ asset('public/css/plugins/owl.theme.default.min.css') }}" rel="stylesheet" />
    <link type="text/css" rel="stylesheet" href="{{ asset('public/plugins/bootstrap-select/bootstrap-select.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('public/plugins/toastr/toastr.min.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('public/css/crm-customers/crm-customers.css?ver='.$appFileVersion) }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('public/css/crm-customers/crm_modals.css?ver='.$appFileVersion) }}" />
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('public/plugins/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('public/plugins/js/owl.carousel.min.js?ver=1.1') }}"></script>

    <script src="{{ asset('public/js/task/tabs-task.js?ver='.$appFileVersion) }}"></script>
    {{--    <script src="{{ asset('public/js/business-manager.js?ver='.$appFileVersion) }}"></script>--}}


    <script>

        $(document).load( function() {
            var $this = $(this),
                target = $($this.data('target')),
                method = $this.data('method') || 'hide';
            target[method]();
        });




        $(window).load(function(){
            $('.marketing-tabs').addClass('active');
            $('.marketing-tabs .nav-second-level').css('display', 'block');
        });
    </script>

    @if(!empty($discoveryComplete) && $discoveryComplete == 'yes')
        <?php
        $noOfRecords=!empty($records) ? count($records) : 0;

        $HowtoSendReviewRequestsTooltip = '';
        $smartRoutingTooltip= '';

        if(isset($reviewRequestSettings)){
            $reviewRequestSettingsData=json_encode($reviewRequestSettings);
            echo '<script>var reviewRequestSettingsData='.$reviewRequestSettingsData.';</script>';
        }
        else{
            echo '<script>var reviewRequestSettingsData={}; </script>';
        }
        ?>
        <script>
            var dynamicAppName= "<?php  echo $dynamicAppName; ?>";
            var noOfRecords= "<?php  echo $noOfRecords; ?>";
            var enable_get_reviews= "<?php  echo $enable_get_reviews; ?>";

            var internationalCallingCountryCodes = '<?php echo json_encode(internationalCallingCountryCodes()); ?>';
            internationalCallingCountryCodes=JSON.parse(internationalCallingCountryCodes);

            var businessName= "<?php  echo $userData['business'][0]['practice_name']; ?>";
            // console.log(businessName);

            var HowtoSendReviewRequestsTooltip= "<?php  echo  $HowtoSendReviewRequestsTooltip; ?>";
            // console.log(HowtoSendReviewRequestsTooltip);
            var smartRoutingTooltip= "<?php  echo $smartRoutingTooltip; ?>";
            // console.log(smartRoutingTooltip);

        </script>
        <script type="text/javascript" src="{{ asset('public/js/tableHeadFixer.js?ver='.$appFileVersion) }}"></script>

        <script type="text/javascript" src="{{ asset('public/js/crm-customers/crm-customers.js?ver='.$appFileVersion) }}"></script>
    @endif

    <script src="{{ asset('public/js/home.js?ver='.$appFileVersion) }}"></script>
    <script src="{{ asset('public/js/google-analytics.js?ver='.$appFileVersion) }}"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script type="text/javascript" src="{{ asset('public/plugins/toastr/toastr.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('public/plugins/datatables/1.10.19/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/plugins/datatables/1.10.19/dataTables.select.min.js') }}"></script>
    <script>
        // $(document).ready(function(){
        //     // $(".owl-carousel").owlCarousel();
        //
        //     $('.owl-carousel').owlCarousel({
        //         margin:10,
        //         loop:true,
        //         autoWidth:true,
        //         items:4
        //     });
        // });


        // $('.notificationsbox').slimScroll({
        //     height: '320px'
        // });

        $('.input-group [data-toggle="tooltip"]').tooltip({
            container: 'body'
        });


        var siteUrl = $('#hfBaseUrl').val();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            type: "POST",
            url: siteUrl + "/done-me",
            data: {
                send: 'monthly-rating-data',
            },
        }).done(function (result) {
            var json = $.parseJSON(result);
            var statusCode = json.status_code;
            var statusMessage = json.status_message;
            var data = json.data;

            // console.log("status");
            // console.log(data['status']);

            var yAxisData = [];
            var xAxisData = [];
            if(data)
            {
                // console.log("yes found data");

                // console.log("data");
                // console.log(data);
                // if(data.graph_data !== '')
                // {
                //     data = data.graph_data;
                // var yAxisData = [];
                var dateAr;
                $.each(data, function (index, value) {
                    // console.log("index " + index);
                    // xAxisData[index] = newDate;
                    // console.log(value.activity_date.split('-'));
                    dateAr = value.activity_date.split(' ');
                    // dateAr = value.activity_date;
                    // console.log("dateA");
                    // console.log(dateAr);

                    xAxisData.push(dateAr[0]);
                    yAxisData.push(value.count);
                    // xAxisData[index] = dateAr;
                    // xAxisData[index] = value.count;
                    // yAxisData[index] = value.count;
                });
            }

            // }

            // console.log("xAxisData");
            // console.log(xAxisData);
            //
            // console.log("yAxisData");
            // console.log(yAxisData);

            Highcharts.chart('reviews-graph', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Reviews By Month'
                },
                xAxis: {
                    // categories: ['Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                    categories: xAxisData
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: ''
                    },
                    stackLabels: {
                        enabled: false,
                        style: {
                            fontWeight: 'bold',
                            color: ( // theme
                                Highcharts.defaultOptions.title.style &&
                                Highcharts.defaultOptions.title.style.color
                            ) || 'gray'
                        }
                    }
                },
                legend: {
                    enabled: false,
                    align: 'right',
                    x: -30,
                    verticalAlign: 'top',
                    y: 25,
                    floating: true,
                    backgroundColor:
                        Highcharts.defaultOptions.legend.backgroundColor || 'white',
                    borderColor: '#CCC',
                    borderWidth: 1,
                    shadow: false
                },
                // tooltip: false,
                plotOptions: {
                    column: {
                        stacking: 'normal',
                        dataLabels: {
                            enabled: false
                        }
                    }
                },
                series: [{
                    name: '',
                    // data: [2, 4, 4, 4, "4", 4]
                    // data: [0, 0, 0, 0, 0, 0]
                    data: yAxisData
                }]
            });
        });
    </script>
    <script>
        (function loadTaskCount() {
            var baseUrl = $('#hfBaseUrl').val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                type: "POST",
                url: baseUrl + "/done-me",
                data: {
                    'send': 'task-count'
                }
            }).done(function (result) {
                // console.log();
                var json = $.parseJSON(result);

                var statusCode = json.status_code;
                var data = json.data;

                if(statusCode == 200)
                {
                    $(".open-count").html(data.open);
                    $(".skipped-count").html(data.skipped);
                    $(".done-count").html(data.done);
                }
            });
        })();
    </script>
    <script>

        $(document.body).on('click','.closeWidget',function () {
            // console.log('abc');
            var baseUrl = $('#hfBaseUrl').val();
            // $('.dashboard-card-loader1').show();
            // $('.loader-img').show();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                type: "POST",
                url: baseUrl + "/done-me",
                data: {
                    'send': 'close-widget'
                }
            }).done(function (result) {
                console.log(result);
                var json = $.parseJSON(result);

                var statusCode = json.status_code;
                var statusMessage = json.status_message;
                // var data = json.data;

                if(statusCode == 200)
                {
                    // console.log(statusCode);
                    $('.notComplete').hide('fast');
                    $('.complete').show('fast');
                }
                else {
                    swal('Error', statusMessage, 'error');
                }
            });
        });
    </script>
@endsection


