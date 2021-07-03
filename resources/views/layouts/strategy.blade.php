@extends('index')

@section('pageTitle', 'Automated Emails')

@section('content')

    <div class="container-fluid header-border">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 px-5">
                    <h1>Getting started</h1>
                    <p>Here are some tips and tasks to help you get started.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid body-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8  ">
                    <p style="font-weight: bold">DISCOVER WHAT YOUR TOOLS CAN DO</p>
                    <img class="img-responsive strategy-left-img " src="{{ asset('public/images/card-ribbon-left.svg') }}">
                    <img class="img-responsive strategy-right-img " src="{{ asset('public/images/card-ribbon-right.svg') }}">
                    <div class="bg-white border-shadow" style="padding: 40px;" >



                        <h3 style="font-weight: bold">Choose the Right Marketing Strategy For Your Practice</h3>

                        <p>Do things the right way from the very start</p>
                        <div class="row">
                            <div class="col-lg-4 text-center ">
                                <div class="right-div-title">
                                    <p style="font-weight: bold">FOLLOW OUR CHECKLIST</p>
                                </div>
                                <p>Follow a sustainable program, based on a proven marketing srategies.</p>
                                <button type="button" class="btn btn-sm connect-buttonn ">Connect your Inbox</button>
                            </div>
                            <div class="col-lg-4 text-center ">
                                <div class="right-div-title">
                                    <p style="font-weight: bold">DO-IT-YOURSELF MARKETING</p>
                                </div>
                                <p>Follow a sustainable program, based on a proven marketing srategies.</p>
                                <button type="button" class="btn btn-sm connect-buttonn ">Connect your Inbox</button>
                            </div>
                            <div class="col-lg-4 text-center">
                                <div class="right-div-title">
                                    <p style="font-weight: bold" >REQUEST A CHAT WITH A MARKETING PRO</p>
                                </div>
                                <p>Follow a sustainable program, based on a proven marketing srategies.</p>
                                <button type="button" class="btn btn-sm connect-buttonn ">Connect your Inbox</button>
                            </div>


                        </div>

                    </div>
                    <div style="margin-top: 5px;" class=" watch-video panel-group border-shadow" id="accordion1">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 style="padding-left: 41px;" class="panel-title">
                                    Watch This 2-Minute Video
                                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1" href="#collapseOne1" >

                                    </a>
                                </h4>
                                <p style="padding-left: 41px;">Watch this quick video to learn how nichepractice work.
{{--                                    It can help transform your practice by increasing productivity and revenue.--}}
                                </p>
                            </div>
                            <div id="collapseOne1" class="panel-collapse collapse in">
                                <div class="panel-body">
                                    <p>Try out your team's new email tools. <strong class="strong-color"> Learn more</strong></p>
                                    {{--                                    <button type="button" class="btn btn-sm connect-button ">Connect your Inbox</button><br><br>--}}
                                    {{--                                    <a href="#" class="skip-btn">Skip for now</a>--}}
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="d-flex justify-content-center">
                        <div class=" bg-white border-shadow click-here " >
                            <h5 style="font-weight: bold;  color: rgb(0, 145, 174);" class="text-center"  ><i class="fa fa-angle-down"></i> Click here to go to your reports dashboard. We won't show you this page again</h5>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <p style="font-weight: bold">DO THESE TASKS TO GET STARTED</p>
                    <div class="panel-group" id="accordion">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                        Filter your contacts
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse in">
                                <div class="panel-body">
                                    <p>Try out your team's new email tools. <strong class="strong-color"> Learn more</strong></p>
                                    <button type="button" class="btn btn-sm connect-button ">Connect your Inbox</button><br><br>
                                    <a href="#" class="skip-btn">Skip for now</a>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                                        Connect your inbox
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <p>Try out your team's new email tools. <strong class="strong-color"> Learn more</strong></p>
                                    <button type="button" class="btn btn-sm connect-button ">Connect your Inbox</button><br><br>
                                    <a href="#" class="skip-btn">Skip for now</a>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                                        Install the sales extension
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseThree" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <p>Try out your team's new email tools. <strong> Learn more</strong></p>
                                    <button type="button" class="btn btn-sm connect-button ">Connect your Inbox</button><br><br>
                                    <a href="#" class="skip-btn">Skip for now</a>
                                </div>
                            </div>
                        </div>
                        {{--                        <div class="panel panel-default">--}}
                        {{--                            <div class="panel-heading d-flex justify-content-between  align-items-center" >--}}
                        {{--                                <div>--}}
                        {{--                                    <p style="margin: 0px;" >Progress: 25%</p>--}}
                        {{--                                    <div class="progress">--}}
                        {{--                                        <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>--}}
                        {{--                                    </div>--}}
                        {{--                                </div>--}}
                        {{--                                <div>--}}
                        {{--                                    <a href="#" class="skip-btn">Hide previous tasks (5)</a>--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('css')
    <style>
        .header-border{
            border-bottom: 1px solid #CBD6E2;
            padding: 24px 48px;
        }
        .header-border h1{
            font-weight: 400;
            margin-top: 0;
            font-size: 28px;
            margin: 0;
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
            height: 8vh;
        }




        /*body*/
        .border-shadow{
            box-shadow: rgba(45, 62, 80, 0.12) 0px 1px 5px 0px;
            border-radius: 3px;
        }
        .body-bg{
            background-color: rgb(245, 248, 250);
            padding-top: 20px;

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
        }
        .connect-buttonn:hover{
            color: white;
            opacity: 0.9;
        }
        a.skip-btn {
            font-size: 14px;
            font-weight: bold;
            color: rgb(0, 145, 174);
        }
        a.skip-btn:hover{
            text-decoration: underline;
        }
        .strong-color{
            color: rgb(0, 145, 174);
        }
        strong:hover{
            text-decoration: underline;
        }
        .progress{

            margin-top: 0px;
            margin-bottom: 0px;
        }
        .progress-bar{
            background-color: rgb(0, 145, 174);
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
