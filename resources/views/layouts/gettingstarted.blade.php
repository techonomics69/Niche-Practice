@extends('index')

@section('pageTitle', 'Getting Started')

@section('content')

    <div class="container-fluid header-border">
        <div class="container">
            <div class="row">
                <div class="d-flex justify-content-between  ">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 px-5">

{{--                            <img class="img-responsive mx-auto rounded-circle" style="margin: auto; border-radius: 50px;" src="{{ asset('public/images/f-page2.png') }}">--}}

                        @if(empty($userData['business'][0]['avatar']))
                            <img style="width: 50px;height: 50px;border-radius: 70px; margin: auto;" class="img-responsive"  src="{{ asset('public/images/icons/doc.jpg') }}" />
                        @else
                            <img style="width: 50px;height: 50px;border-radius: 70px; margin: auto; display: flex; text-align: center" src="{!! uploadImagePath($userData['business'][0]['avatar']) !!}" />
                        @endif

                            <h1 style="font-weight: bold" class="text-center">Welcome {{ $userData['first_name'] }}!</h1>
{{--                            <p class="text-center"><span>We want to get to know your business better. Here are 4 quick <br> questions that will help us support you in a serious way</span></p>--}}


                    </div>
{{--                    <div>--}}
{{--                        @if(!empty($_REQUEST['ref']) && $_REQUEST['ref'] == 'dashboard')--}}
{{--                            <a href="{{ route('home') }}" style="color: #000000;"><button type="button" class="btn btn-sm connect-button ">Close</button></a>--}}
{{--                        @else--}}
{{--                            <a href="{{ route('task-list') }}" style="color: #000000;"><button type="button" class="btn btn-sm connect-button ">Close</button></a>--}}
{{--                        @endif--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid body-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8  ">
                    <p style="font-weight: bold; margin: 0; color: #516f90; ">DISCOVER HOW NICHEPRACTICE CAN HELP YOU</p>
{{--                    <img class="img-responsive strategy-left-img " src="{{ asset('public/images/card-ribbon-left.svg') }}">--}}
{{--                    <img class="img-responsive strategy-right-img " src="{{ asset('public/images/card-ribbon-right.svg') }}">--}}
                    <div class="bg-white custom-border-1" style="padding: 20px 40px 40px 40px;" >



                        <h3 class="title-right-marketing" style="">Choose the Right Marketing Strategy For Your Practice</h3>


                        <div class="row">
                            <div class="col-lg-4 text-center ">
                                <img class="img-responsive marketing-strategy-img " src="{{ asset('public/images/list.png') }}">
                                <div class="right-div-title">
                                    <p style="font-weight: bold">START FROM SCRATCH</p>
                                </div>
                                <p>We provide you with a step-by-step, powerful marketing strategy that you can follow each month.</p>
{{--                                <button type="button" class="btn btn-sm connect-buttonn page-help">Learn More</button>--}}
                                <a class="btn btn-sm connect-buttonn page-help" href="javascript:void(0)" data-module="scratch">Learn More</a>
                            </div>
                            <div class="col-lg-4 text-center ">
                                <img class="img-responsive marketing-strategy-img " src="{{ asset('public/images/doctor.png') }}">
                                <div class="right-div-title">
                                    <p style="font-weight: bold">START WITH A CAMPAIGN</p>
                                </div>
                                <p>Choose your own campaigns and manage your own marketing using our platform.</p>
{{--                                <button type="button" class="btn btn-sm connect-buttonn " >Learn More</button>--}}
                                <a class="btn btn-sm connect-buttonn page-help" href="javascript:void(0)" data-module="campaign">Learn More</a>


                            </div>
                            <div class="col-lg-4 text-center">

                                <img class="img-responsive marketing-strategy-img " src="{{ asset('public/images/chatt.png') }}">

                                <div class="right-div-title">
                                    <p style="font-weight: bold" >WE DO IT ALL FOR YOU</p>
                                </div>
                                <p>We will analyze your present marketing and provide actionable steps for improvement.</p>
{{--                                <button type="button" class="btn btn-sm connect-buttonn " >Learn More</button>--}}
                                <a class="btn btn-sm connect-buttonn page-help" href="javascript:void(0)" data-module="for_you">Learn More</a>

                            </div>


                        </div>

                    </div>
                    <div class="text-center d-flex justify-content-center">
{{--                        <button class="btn btn-primary btn-block  marketing-strategy-close">Close</button>--}}


                            @if(!empty($_REQUEST['ref']) && $_REQUEST['ref'] == 'dashboard')
                                <a class="btn btn-primary btn-block  marketing-strategy-close" href="{{ route('home') }}">Close</a>
                            @else
                                <a class="btn btn-primary btn-block  marketing-strategy-close" href="{{ route('task-list') }}">Close</a>
                            @endif

                    </div>
                    {{--                    <div style="margin-top: 5px;" class="  panel-group custom-border-2" id="accordion1">--}}
{{--                        <div class="panel panel-default">--}}
{{--                            <div class="panel-heading">--}}
{{--                                <h4 class="panel-title">--}}

{{--                                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1" href="#collapseOne1" >--}}
{{--                                        Watch This 2-Minute Video--}}
{{--                                    </a>--}}
{{--                                </h4>--}}
{{--                                <p style="padding-left: 41px;">Watch this quick video to learn how nichepractice work. It can help transform your practice by increasing productivity and revenue.</p>--}}
{{--                            </div>--}}
{{--                            <div id="collapseOne1" class="panel-collapse collapse">--}}
{{--                                <div class="panel-body">--}}

{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                    </div>--}}
{{--                    <div class="d-flex justify-content-center">--}}
{{--                        <div class=" bg-white border-shadow click-here " >--}}
{{--                            <h5 style="font-weight: bold;  color: rgb(0, 145, 174);" class="text-center"  ><i class="fa fa-angle-down"></i> Click here to go to your reports dashboard. We won't show you this page again</h5>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>

                <div class="col-lg-4">
                    <p style="font-weight: bold; margin: 0;">DO THESE TASKS TO GET STARTED</p>
                    <div class="panel-group" id="accordion">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                        Watch This 2 Min Video
                                    </a>
                                </h4>

                            </div>
                            <div id="collapseOne" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <p>Watch this quick video to learn how nichepractice work.
{{--                                        It can help transform your practice by increasing productivity and revenue.--}}
                                    </p>
                                    <div class="text-center">
                                        <button type="button" id="watchOverviewVideo" class="btn btn-sm connect-button ">Play Video</button>
{{--                                        <div class="col-md-6">--}}
{{--                                            <p class="text-right" style="font-weight: bold; font-size: 16px;">Get Started With Nichepractice</p>--}}
{{--                                            <button id="watchOverviewVideo" class="btn" style="float: right; font-weight: 600; font-size: 15px; background-color: #DBECF6; color:#2B93F4;">--}}
{{--                                                <i class="fa fa-play-circle-o fa-lg" aria-hidden="true"></i>  Watch the 2 min video--}}
{{--                                            </button>--}}
{{--                                        </div>--}}
                                    </div>
{{--                                    <a href="#" class="skip-btn">Skip for now</a>--}}
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                                        Set up Your Account
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse">
                                <div class="panel-body ">
                                    <p class="hrf-style">1. The first thing visitors see on your marketing is your logo. <a href="<?php echo e(route('business-profile')); ?>">Upload</a> a high-quality version.</p>
                                    <p class="hrf-style">2. <a href="<?php echo e(route('social-posts')); ?>">Connect</a> your FaceBook account to get the most our of your nichepractice trial.</p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title marketing-todo ">
                                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                                        Start Marketing Now!
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseThree" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <p>Your free trial includes a revenue generating marketing campaign so you can experience how easy it is to use nichepractice and how it can help your practice become more successful.</p>
                                    <div class="text-center">
                                        <button type="button" class="btn btn-sm connect-button ">Start Now</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>







    <div id="main-modal" class="modal welcome-process fade in modal-manager create-your-account " tabindex="-1"
         role="dialog" data-backdrop="static" data-keyboard="false" style="display: none;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>

                <form class="wizard-container" method="POST" action="#" id="js-wizard-form">
                    <div class="modal-body">
                        <div class="text-center page-title">
                            <h2 class="popup-title">Plase wait while we create your account...</h2>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="progress-section">

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="progress" id="js-progress">
                                        <div class="progress-bar account-progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                             aria-valuemax="100" style="width: 40%;">
                                            <span class="progress-val">40%</span>
                                        </div>
                                    </div>
                                    <h5 class="progress-text account text-center" style="margin: 0px;">Setting Up Your Account</h5>
                                </div>
                                <div class="col-sm-4">
                                    <div class="progress" id="js-progress">
                                        <div class="progress-bar collect-data-progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                             aria-valuemax="100">
                                            <span class="progress-val">40%</span>
                                        </div>
                                    </div>
                                    <h5 class="progress-text">Gethering data from the Internet</h5>
                                    {{-- <img class="process-loader"
                                        src="{{ asset('public/images/blue-spinner.gif') }}"
                                        style="display: none;"> --}}
                                </div>
                                <div class="col-sm-4">
                                    <div class="progress" id="js-progress">
                                        <div class="progress-bar collect-reviews-progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                             aria-valuemax="100">
                                            <span class="progress-val">80%</span>
                                        </div>
                                    </div>
                                    <h5 class="progress-text collect-reviews">Getting all your reviews</h5>
                                    {{-- <img class="process-loader"
                                        src="{{ asset('public/images/blue-spinner.gif') }}"
                                        style="display: none;"> --}}
                                </div>


                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection


@section('css')
    <style>
        .login-page-bg{
            background-color: #F3F8FB;
        }
        .marketing-todo{
            color: red !important;
        }
        .marketing-todo:hover{
            color: red !important;
        }
        .marketing-strategy-img{
            margin: auto;
            width: 40px;
            margin-bottom: 10px;
        }
        .hrf-style a{
            text-decoration: underline;
            color: #474BC4;
        }
        .your-account-p{
            position: relative;
            left: 40px;
        }
        .header-border{
            border-bottom: 1px solid #CBD6E2;
            padding: 24px 48px;
            background-color: #F4F5F9;
        }
        .header-border h1{
            font-weight: 400;
            margin-top: 0;
            font-size: 28px;
            margin: 0;
        }
        .connect-buttonn:focus{
            color: white;
        }
        .header-border p{
            font-family: Avenir Next W02,Helvetica,Arial,sans-serif;
            font-weight: 400;
            font-size: 14px;
            color: #33475b;
            line-height: 24px;
            margin: 0;
        }
        /*Right div*/
        .right-div{
            background-color: white;
            padding: 40px;
        }
        .strategy-left-img{
            position: absolute;
        }
        .strategy-right-img{
            position: absolute;
            right: 15px;
        }
        .right-div-title{
            height: 4vh;
        }
        .right-div-title p{
            color: #516f90;
        }




        /*body*/
        .title-right-marketing{
            font-weight: bold;
            height: 7vh;
            margin: 0px;
        }
        .custom-border-1{
            border-top: 10px solid #33475B;
        }
        .custom-border-2{
            border-top: 5px solid #33475B;
        }
        .border-shadow{
            box-shadow: rgba(45, 62, 80, 0.12) 0px 1px 5px 0px;
            border-radius: 3px;
        }
        .body-bg{
            background-color: #F3F8FB;
            padding-top: 20px;
            height: 100%;

        }
        .panel-group .panel-heading{
            padding: 24px 24px 24px 24px;
        }
        .panel-heading .accordion-toggle:after {
            /* symbol for "opening" panels */
            font-family: 'Glyphicons Halflings';  /* essential for enabling glyphicon */
            content: "\e114";    /* adjust as needed, taken from bootstrap.css */
            float: left;        /* adjust as needed */
            color: grey;         /* adjust as needed */
            padding-right: 25px;
            color: rgb(0, 145, 174);
            font-weight: 100;
        }
        .panel.panel-default{
            margin-top: 0px !important;
        }
        .panel-heading .accordion-toggle.collapsed:after {
            /* symbol for "collapsed" panels */
            content: "\e080";    /* adjust as needed, taken from bootstrap.css */
            color: rgb(0, 145, 174);
            font-weight: 100;
        }

        .watch-video .panel-heading .accordion-toggle:after {
            /* symbol for "opening" panels */
            font-family: 'Glyphicons Halflings';  /* essential for enabling glyphicon */
            content: "\e114";    /* adjust as needed, taken from bootstrap.css */
            float: left;        /* adjust as needed */
            color: rgb(0, 145, 174);
            padding-right: 0px;
            font-weight: 100;
        }
        .watch-video .panel.panel-default{
            margin-top: 0px !important;
        }

        .watch-video .panel-heading .accordion-toggle.collapsed:after {
            /* symbol for "collapsed" panels */
            content: "\e080";    /* adjust as needed, taken from bootstrap.css */
            color: rgb(0, 145, 174);
            transform: rotate(-90deg);
            font-weight: 100;
        }
        .watch-video a.accordion-toggle{
            position: absolute;
            right: 45%;
            bottom: 55px;
            padding: 10px 35px 0px 35px;
            border-top: 1px solid rgb(223, 227, 235);
            border-right: 1px solid rgb(223, 227, 235);
            border-left: 1px solid rgb(223, 227, 235);
            border-image: initial;
            border-bottom: none;
            border-top-left-radius: 3px;
            cursor: pointer;
            background: rgb(255, 255, 255);
            z-index: 0;
            border-top-right-radius: 3px;
        }
        div#accordion{
            box-shadow: rgba(45, 62, 80, 0.12) 0px 1px 5px 0px;
            border-radius: 3px;
        }
        .click-here{
            width: 75%;
        }

        .panel-title{
            font-family: Avenir Next W02,Helvetica,Arial,sans-serif;
            font-weight: 600;
            -webkit-font-smoothing: antialiased;
            line-height: normal;
            text-transform: none;
            color: #33475b;
        }
        a.accordion-toggle.collapsed:hover{
            color: rgb(0, 145, 174);
        }
        .connect-button{
            background-color: #ff8f73;
            border: none;
            color: white;
            padding: 8px;
            font-size: 12px;
            line-height: 14px;
        }

        .connect-button:hover{
            color: white;
            opacity: 0.9;
        }
        .connect-buttonn{
            background-color: #516f90;
            border: none;
            color: white;
            padding: 8px;
            font-size: 12px;
            line-height: 14px;
            padding: 10px 20px 10px 20px;
        }
        .connect-buttonn:hover{
            color: white;
            opacity: 0.9;
        }
        .marketing-strategy-close{
            background-color: #8ba8c7;
            border: none;
            color: white;
            /*padding: 20px 50px 20px 50px;*/
            font-size: 20px;
            line-height: 14px;
            margin-top: 20px;
            margin-bottom: 20px;
            width: 50%;
            padding: 10px;
        }
        .marketing-strategy-close:hover{
            color: white !important;
            opacity: 0.9 !important;
            background-color: #8ba8c7 !important;
        }
        a.skip-btn {
            font-size: 14px;
            font-weight: bold;
            color: rgb(0, 145, 174);
        }
        a.skip-btn:hover{
            text-decoration: underline;
        }
        /*strong{*/
        /*    color: rgb(0, 145, 174);*/
        /*}*/
        /*strong:hover{*/
        /*    text-decoration: underline;*/
        /*}*/
        .progress{

            margin-top: 0px;
            margin-bottom: 0px;
        }
        .progress-bar{
            background-color: rgb(0, 145, 174);
        }
        @media screen and (max-width: 1024px){
            .marketing-strategy-img{
                margin-top: 10px;
            }
        }
        @media screen and (max-width: 425px){
            .watch-video a.accordion-toggle{
                right: 40%;
                bottom: 70px;
            }
            .click-here{
                width: 100%;
            }
        }
        @media screen and (max-width: 375px){
            .header-border {
                padding: 15px 0px;
            }
            .title-right-marketing{
                height: 12vh;
            }
            .custom-border-1{
                padding: 20px 10px 40px 10px !important;
            }
        }
        @media screen and (max-width: 320px){
            .watch-video a.accordion-toggle {
                right: 35%;
                bottom: 62px;
            }
            .click-here h5 {
                font-size: 10px;
            }
        }
    </style>
@endsection
@section('js')
    <script>
        module = $('#module').val();
        $(function()
        {

            $('#watchOverviewVideo').click(function () {

                // var welcome_video_seen = $('#welcome_video_seen').val();

                // console.log(welcome_video_seen);
                // if (welcome_video_seen == '0') {
                    // return false;

                    $('#loader').children().html('');
                    var mainModel = $('#main-modal');
                    // mainModel.css({'background-color': '#546576 !important', 'opacity': '.8'});
                    $(mainModel).removeClass('welcome-process');
                    $(mainModel).removeClass('create-your-account');
                    $(".modal-body, .modal-footer, .validate-me", mainModel).remove();
                    $(mainModel).addClass('welcome-task-video');

                    var mainModelContent = mainModel.find('.modal-content');

                    var modalBody =     '<div class="modal-body">'+
                                            '<iframe width="100%" height="315" src="https://www.youtube.com/embed/S2WYZvO6OFo?rel=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen  id="welcomeVideo"></iframe>'+
                                        '</div>';

                    var modalFooter =   '<div class="modal-footer ">'+
                                            '<h5 class="modal-title text-center" style=" margin:auto;"> <span style="font-weight:700"> Nichepractice explained in under 60 seconds</span></h5>'+
                                            '<div  class="video-font-size" >' +
                                            // 'Watch this quick video to learn how nichepractice works. ' +
                        // 'It can help transform your practice by increasing productivity and revenue.' +
                        '</div>'+
                                        '</div>';

                    // mainModelContent.html(modalHeader + modalBody + modalFooter);

                    $(".modal-header .close", mainModelContent).attr('id', 'closevideo');
                    $(".modal-header", mainModelContent).after(modalBody + modalFooter);

                    mainModel.modal('show');

                    $('#closevideo').click(function () {
                        // console.log('closevideo');
                        $("#welcomeVideo").attr('src','');
                        var baseUrl = $('#hfBaseUrl').val();
                        data = {
                            'seen': 1
                        }
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('input[name="_token"]').val()
                            },
                            type: "post",
                            url: baseUrl+"/videoSeen",
                            data: data
                        }).done(function (data) {
                            // console.log(data);
                         }).fail(function (error) {
                            // console.log(error);
                          });
                    });
                // }






                // var baseUrl = $('#hfBaseUrl').val();
                // location.href = baseUrl+'/getting-started?ref=dashboard';
                // return false;
                // var mainModel = $('#main-modal');
                // // mainModel.css({'background-color': '#546576 !important', 'opacity': '.8'});
                // $(".modal-body, .modal-footer, .validate-me", mainModel).remove();
                // $(mainModel).removeClass('welcome-process');
                // $(mainModel).addClass('welcome-task-video');
                // // $('#loader').children().html('');
                // var mainModelContent = mainModel.find('.modal-content');
                //
                // var modalBody =     '<div class="modal-body">'+
                //     '<iframe width="100%" height="315" src="https://www.youtube.com/embed/S2WYZvO6OFo?rel=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen  id="welcomeVideo"></iframe>'+
                //     '</div>';
                //
                // var modalFooter =   '<div class="modal-footer">'+
                //     '<h5 class="modal-title text-center" style=" margin:auto;"> <span style="font-weight:700"> Welcome to nichepractice</span></h5>'+
                //     '<div class="video-font-size">Watch this quick video to learn how nichepractice works. It can help transform your practice by increasing productivity and revenue.</div>'+
                //     '</div>';
                //
                // // id="closevideo"
                // $(".modal-header .close", mainModelContent).attr('id', 'closevideo');
                // $(".modal-header", mainModelContent).after(modalBody + modalFooter);
                // // mainModelContent.html();
                // mainModel.modal('show');
            });


            // Lean more1


            $('#leanmore1').click(function () {
                var siteUrl = $('#hfBaseUrl').val();
                var template = $(this).attr('data-target-id');
                var status = $(this).attr('data-status');
                var currentTarget = $(this);
                var parentSel = currentTarget.parent('.status');

                showPreloader();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    type: "POST",
                    url: siteUrl + "/done-me",
                    data: {
                        send: 'admin-alert-status',
                        id: template,
                        status: status,
                    },
                }).done(function (result) {
                    var json = $.parseJSON(result);
                    var statusCode = json.status_code;
                    var statusMessage = json.status_message;
                    var data = json.data;



                    hidePreloader();

                    if(statusCode == 200)
                    {
                        swal({
                            title: "Marketing From Scratch",
                            text: "Nichepractice  will guide you through the strategic marketing actions necessary in order to increase revenue and build a strong niche practice. Every month you get a new marketing ‘to-do’ list, with step-by-step instructions that will tell you exactly what you need to do.",
                            type: 'success'
                        }, function () {
                        });
                    }
                    else
                    {
                        swal({
                            title: "Error!",
                            text: statusMessage,
                            type: 'error'
                        }, function () {
                        });
                    }
                });

            });

            // Learm more 2

            $('#leanmore2').click(function () {
                var siteUrl = $('#hfBaseUrl').val();
                var template = $(this).attr('data-target-id');
                var status = $(this).attr('data-status');
                var currentTarget = $(this);
                var parentSel = currentTarget.parent('.status');

                showPreloader();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    type: "POST",
                    url: siteUrl + "/done-me",
                    data: {
                        send: 'admin-alert-status',
                        id: template,
                        status: status,
                    },
                }).done(function (result) {
                    var json = $.parseJSON(result);
                    var statusCode = json.status_code;
                    var statusMessage = json.status_message;
                    var data = json.data;



                    hidePreloader();

                    if(statusCode == 200)
                    {
                        swal({
                            title: "Start With a Campaign",
                            text: "If you are comfortable and confident knowing how to market yourself, our ready-to-use campaigns provide the outline and strategy for over 40 marketing strategies. you can do it yourself and make a significant impact!",
                            type: 'success'
                        }, function () {
                        });
                    }
                    else
                    {
                        swal({
                            title: "Error!",
                            text: statusMessage,
                            type: 'error'
                        }, function () {
                        });
                    }
                });

            });

            // Learm more 3

            $('#leanmore3').click(function () {
                var siteUrl = $('#hfBaseUrl').val();
                var template = $(this).attr('data-target-id');
                var status = $(this).attr('data-status');
                var currentTarget = $(this);
                var parentSel = currentTarget.parent('.status');

                showPreloader();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    type: "POST",
                    url: siteUrl + "/done-me",
                    data: {
                        send: 'admin-alert-status',
                        id: template,
                        status: status,
                    },
                }).done(function (result) {
                    var json = $.parseJSON(result);
                    var statusCode = json.status_code;
                    var statusMessage = json.status_message;
                    var data = json.data;



                    hidePreloader();

                    if(statusCode == 200)
                    {
                        swal({
                            title: "We-Do-It-All For-You",
                            text: "Our team of in-house experts will conduct the research, develop the strategy, target the customers you can serve most profitably, manage the schedule and budget, develop amazing custom creative content and ads and execute everything for you.",
                            type: 'success'
                        }, function () {
                        });
                    }
                    else
                    {
                        swal({
                            title: "Error!",
                            text: statusMessage,
                            type: 'error'
                        }, function () {
                        });
                    }
                });

            });













            var welcome_video_seen = $('#welcome_video_seen').val();

            // console.log(welcome_video_seen);
            // if (welcome_video_seen == '0') {
            //     // return false;
            //
            //     $('#loader').children().html('');
            //     var mainModel = $('#main-modal');
            //     // mainModel.css({'background-color': '#546576 !important', 'opacity': '.8'});
            //     $(mainModel).removeClass('welcome-process');
            //     $(mainModel).removeClass('create-your-account');
            //     $(".modal-body, .modal-footer, .validate-me", mainModel).remove();
            //     $(mainModel).addClass('welcome-task-video');
            //
            //     var mainModelContent = mainModel.find('.modal-content');
            //
            //     var modalBody =     '<div class="modal-body">'+
            //                             '<iframe width="100%" height="315" src="https://www.youtube.com/embed/S2WYZvO6OFo?rel=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen  id="welcomeVideo"></iframe>'+
            //                         '</div>';
            //
            //     var modalFooter =   '<div class="modal-footer ">'+
            //                             '<h5 class="modal-title text-center" style=" margin:auto;"> <span style="font-weight:700"> Welcome to nichepractice</span></h5>'+
            //                             '<div  class="video-font-size" >Watch this quick video to learn how nichepractice works. It can help transform your practice by increasing productivity and revenue.</div>'+
            //                         '</div>';
            //
            //     // mainModelContent.html(modalHeader + modalBody + modalFooter);
            //
            //     $(".modal-header .close", mainModelContent).attr('id', 'closevideo');
            //     $(".modal-header", mainModelContent).after(modalBody + modalFooter);
            //
            //     mainModel.modal('show');
            //
            //     $('#closevideo').click(function () {
            //         // console.log('closevideo');
            //         $("#welcomeVideo").attr('src','');
            //         var baseUrl = $('#hfBaseUrl').val();
            //         data = {
            //             'seen': 1
            //         }
            //         $.ajax({
            //             headers: {
            //                 'X-CSRF-TOKEN': $('input[name="_token"]').val()
            //             },
            //             type: "post",
            //             url: baseUrl+"/videoSeen",
            //             data: data
            //         }).done(function (data) {
            //             // console.log(data);
            //          }).fail(function (error) {
            //             // console.log(error);
            //           });
            //     });
            // }
            if(window.innerHeight > 720)
            {
                windowHeightDeduction =  parseInt((window.innerHeight/100)*41);
                windowHeight = window.innerHeight - windowHeightDeduction;
                // windowHeight = window.innerHeight - 400;
            }
            else
            {
                windowHeight = window.innerHeight - 150;
            }

            console.log("windowHeigh");
            console.log(windowHeight);

            $('.task-list-wrapper').slimScroll({
                height: windowHeight,
                size: '5px',
                alwaysVisible: true,
                allowPageScroll: true
            });

            if(window.innerHeight > 720)
            {
                boxHeight = window.innerHeight - 120;
                $('.white-box').height(boxHeight+'px');
            }
            else
            {
                boxHeight = window.innerHeight - 30;
                $('.white-box').height(boxHeight+'px');
            }

            /**
             * Comment as per story MAD-1387
             */

            // if (module === 'marketing_plan') {
            //     $('.task-list-wrapper').slimScroll({
            //         height: windowHeight - 170,
            //         size: 5
            //     });
            // }
            // else
            // {
            //     $('.task-list-wrapper').slimScroll({
            //         height: windowHeight,
            //         size: 5
            //     });
            // }

        });
    </script>


@endsection
