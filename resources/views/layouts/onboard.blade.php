@extends('index')

@section('pageTitle', 'OnBoard')

@section('content')
    <div class="container-fluid header-border">

    </div>
    <div class="container-fluid dashboarbgtitle reviews-panel">
        <div class="dashboard-wrapper">
            <div class="page-head" style="margin: 0px 0;">

                {{--         Zero--}}

                <div class="row " id="box0">

                    <div class="col-sm-12">
                        <div class=" border border-dark px-3 change-media card5 " id="card0">
                            <div class="card-body">
                                <img src="public/images/hand.png" alt="">
                                <h1 class="practice-heading0" id="lineheight">Welcome to Nichepractice!</h1>

                                <div class="main-after-ana">

                                    <p class="after-ana0">
                                        Just a few questions so that we can formulate your <br
                                            class="visible-lg visible-md visible-sm visibility-hidden">
                                        marketing strategy and make your experience even better.

                                    </p>


                                </div>

                                <div class="text-center ">

                                    <button class="btn btn-primary cont-btn0" id="hideBtn0">Get Started</button>
                                </div>


                            </div>
                        </div>
                    </div>


                </div>


                {{--                     First--}}

                <div class="row" style="display: none;" id="box1">
                    <div class="col-sm-12">
                        <p class="step-info">Step 1 of 5</p>
                    </div>
                    <div class="col-sm-12">
                        <div class="card border border-dark px-3 change-media">
                            <form class="form1">
                                <div class="card-body">
                                    <h1 class="practice-heading text-center">Which of these practice goals appeals to
                                        you?</h1>


                                    <div class="d-flex justify-content-center  okg ">
                                        <div class="main-xs main-xs-generate checkbg ">
                                            <div class="form-align  ">
                                                <div class="form-group m-0 fg">
                                                    <input type="checkbox" data-id="1" name="Generate-Revenue"
                                                           id="revenue">
                                                    <label for="revenue">Generate Revenue</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" main-xs main-xs-generate ">
                                            <div class="form-align">
                                                <div class="form-group m-0 fg">
                                                    <input type="checkbox" data-id="2" name="Attract-New-Patients"
                                                           id="attract">
                                                    <label for="attract">Attract New Patients</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" main-xs main-xs-generate ">
                                            <div class="form-align">
                                                <div class="form-group m-0 fg">
                                                    <input type="checkbox" data-id="3" name="Establish-Expertise"
                                                           id="establish">
                                                    <label for="establish">Establish Expertise</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" main-xs">
                                            <div class="form-align">
                                                <div class="form-group m-0 fg">
                                                    <input type="checkbox" data-id="4" name="Enhance-Online-Reputation"
                                                           id="reputation">
                                                    <label for="reputation">Enhance Online <br
                                                            class="hidden-md hidden-lg"> Reputation</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="d-flex justify-content-center  okg">

                                        <div class=" main-xs  ">
                                            <div class="form-align">
                                                <div class="form-group m-0 fg">
                                                    <input type="checkbox" data-id="5" id="brand">
                                                    <label for="brand">Brand Awareness</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" main-xs mar-right-left ">
                                            <div class="form-align ">
                                                <div class="form-group m-0 fg">
                                                    <input type="checkbox" data-id="6" id="Relationships">
                                                    <label for="Relationships">Build Relationships</label>
                                                </div>
                                            </div>
                                        </div>


                                        <div class=" main-xs ">
                                            <div class="form-align">
                                                <div class="form-group m-0 fg">
                                                    <input type="checkbox" data-id="7" id="Other">
                                                    <label for="Other">Other</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="">
                                        <span class="help-block hide-me"><small></small></span>
                                    </div>
                                    <div class="text-center main-btn">
                                        {{--                                    <button class="btn btn-light back-btn" id="backBtn1" style="margin-right: 5px;padding: 10px 30px;font-size: 14px;">Back</button>--}}
                                        <button type="submit" class="btn btn-primary cont-btn" id="hideBtn1"
                                                data-target-id="1">Continue
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>


                </div>


                {{--                    second--}}

                <div class="row" style="display: none;" id="box2">
                    <div class="col-sm-12">
                        <p class="step-info">Step 2 of 5</p>
                    </div>
                    <div class="col-sm-12">
                        <div class="card border border-dark px-3 change-media">
                            <form class="form2">
                                <div class="card-body">
                                    <h1 class="practice-heading text-center">How are you currently marketing your
                                        practice?</h1>
                                    <div class="d-flex justify-content-center  okg ">
                                        <div class="main-xs">
                                            <div class="form-align  ">
                                                <div class="form-group m-0 fg pad-step-two">
                                                    <input type="checkbox" data-id="8" id="revenue1">
                                                    <label for="revenue1">Direct Mail</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" main-xs">
                                            <div class="form-align">
                                                <div class="form-group m-0 fg pad-step-two">
                                                    <input type="checkbox" data-id="9" id="attract1">
                                                    <label for="attract1">Email Marketing</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" main-xs">
                                            <div class="form-align">
                                                <div class="form-group m-0 fg pad-step-two">
                                                    <input type="checkbox" data-id="10" id="establish1">
                                                    <label for="establish1">Pay-Per-Click</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" main-xs">
                                            <div class="form-align">
                                                <div class="form-group m-0 fg">
                                                    <input type="checkbox" data-id="11" id="reputation1">
                                                    <label for="reputation1">Search Engine <br
                                                            class="hidden-md hidden-lg"> Optimization</label>
                                                </div>
                                            </div>
                                        </div>


                                    </div>


                                    <div class="d-flex justify-content-center  okg">

                                        <div class=" main-xs">
                                            <div class="form-align">
                                                <div class="form-group m-0 fg pad-step-two">
                                                    <input type="checkbox" data-id="12" id="brand1">
                                                    <label for="brand1">Social Media</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" main-xs mar-right-left">
                                            <div class="form-align ">
                                                <div class="form-group m-0 fg pad-step-two">
                                                    <input type="checkbox" data-id="13" id="Relationships1">
                                                    <label for="Relationships1">Remarketing</label>
                                                </div>
                                            </div>
                                        </div>


                                        <div class=" main-xs">
                                            <div class="form-align">
                                                <div class="form-group m-0 fg">
                                                    <input type="checkbox" data-id="14" id="Other1">
                                                    {{--                                                <label for="Other1">Other</label>--}}
                                                    <label for="Other1">Not Marketing Now</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="">
                                        <span class="help-block hide-me"><small></small></span>
                                    </div>
                                    <div class="text-center main-btn">
                                        <button class="btn btn-light back-btn" id="backBtn2"
                                                style="margin-right: 5px;padding: 10px 30px;font-size: 14px;">Back
                                        </button>
                                        <button class="btn btn-primary cont-btn" id="hideBtn2" data-target-id="2">
                                            Continue
                                        </button>
                                    </div>
                                    <div class="text-center skips" style="display: none;">

                                        <p style="color: #f23434; cursor: pointer;" class="skip-this-step"
                                           id="skiphideBtn2">Skip this step</p>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>


                </div>

                {{--         third--}}

                <div class="row" style="display: none;" id="box3">
                    <div class="col-sm-12">
                        <p class="step-info">Step 3 of 5</p>
                    </div>
                    <div class="col-sm-12">
                        <div class="card1 border border-dark px-3 change-media">
                            <form class="form3">
                                <div class="card-body">
                                    <h1 class="practice-heading text-center">Which best describes your practice?</h1>
                                    <div class="d-flex justify-content-center  okg ">
                                        <div class="main-xs1" id="change3" style="display: block!important;">
                                            <div class="form-align">
                                                <div class="form-group m-0 fg1">
                                                    <input type="checkbox" data-id="15" id="okay">
                                                    <label for="okay" class="thirddo" id="change3">&nbsp;&nbsp;DOING
                                                        OKAY</label>
                                                </div>
                                                {{--                                            <p class="your"  id="change3"><label--}}
                                                {{--                                                    for="okay">Your practice is up and running <br>--}}
                                                {{--                                                    - and ready to growl You are <br>--}}
                                                {{--                                                    looking for a comprehensive <br>--}}
                                                {{--                                                    approach to marketing.--}}
                                                {{--                                                </label>--}}
                                                {{--                                            </p>--}}
                                                <p class="your" id="change3"><label
                                                        for="okay">Your practice is up and running <br>
                                                        and ready to grow. You are <br>
                                                        looking for a comprehensive <br>
                                                        approach to marketing.
                                                    </label>
                                                </p>
                                            </div>
                                        </div>
                                        <div class=" main-xs1" id="change4">
                                            <div class="form-align">
                                                <div class="form-group m-0 fg1">
                                                    <input type="checkbox" data-id="16" id="great">
                                                    <label for="great" class="thirddo" id="change4">&nbsp;&nbsp;DOING
                                                        GREAT</label>
                                                </div>
                                                <p class="your" id="change4"><label
                                                        for="great">Your practice is rocking and <br> rolling.
                                                        You need more <br> advanced
                                                        marketing solutions<br>
                                                        to support your growth.
                                                    </label>
                                                </p>
                                            </div>
                                        </div>
                                        <div class=" main-xs1" id="change5">
                                            <div class="form-align">
                                                <div class="form-group m-0 fg1">
                                                    <input type="checkbox" data-id="17" id="help">
                                                    <label for="help" class="thirddo" id="change5">&nbsp;&nbsp;NEED
                                                        HELP</label>
                                                </div>
                                                <p class="your" id="change5"><label
                                                        for="help">Your practice is not attracting
                                                        <br> many new patients. Revenue <br> has been dropping
                                                        over the <br> past year.
                                                    </label>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="">
                                        <span class="help-block hide-me"><small></small></span>
                                    </div>

                                    <div class="text-center main-btn">
                                        <button class="btn btn-light back-btn" id="backBtn3"
                                                style="margin-right: 5px;padding: 10px 30px;font-size: 14px;">Back
                                        </button>
                                        <button class="btn btn-primary cont-btn" id="hideBtn3" data-target-id="3">
                                            Continue
                                        </button>
                                    </div>
                                    <div class="text-center skips" style="display: none;">

                                        <p style="color: #F4312B; cursor: pointer; " class="skip-this-step"
                                           id="skiphideBtn3">Skip this step</p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>


                </div>


                {{--         Fourth--}}

                <div class="row " style="display: none;" id="box4">
                    <div class="col-sm-12">
                        <p class="step-info">Step 4 of 5</p>
                    </div>
                    <div class="col-sm-12">
                        <div class="card1 border border-dark px-3 change-media">
                            <form class="form4">
                                <div class="card-body">
                                    <h1 class="practice-heading text-center">How can nichepractice best assist you?</h1>
                                    <div class="d-flex justify-content-center  okg ">
                                        <div class="main-xs1" id="change2" style="display: block!important;">
                                            <div class="form-align  ">
                                                <div class="form-group m-0 fg1">
                                                    <input type="checkbox" data-id="18" id="doit">
                                                    <label for="doit" class="thirddo" id="change2">&nbsp;&nbsp;DO-IT-WITH-ME</label>
                                                </div>
                                                <p class="your" id="change2"><label
                                                        for="doit">Get a step-by-step, powerful <br>
                                                        marketing checklist that you<br>
                                                        can follow each month.
                                                    </label>
                                                </p>
                                            </div>
                                        </div>
                                        <div class=" main-xs1 c1" id="change1">
                                            <div class="form-align">
                                                <div class="form-group m-0 fg1">
                                                    <input type="checkbox" data-id="19" id="myself" class="mycheck">
                                                    <label for="myself" class="thirddo">&nbsp;&nbsp;DO-IT-MYSELF</label>
                                                </div>
                                                <p class="your">
                                                    <label for="myself">
                                                        Choose your own campaigns <br>
                                                        and manage your own <br>
                                                        marketing using our platform.
                                                    </label>
                                                </p>
                                            </div>
                                        </div>
                                        <div class=" main-xs1" id="change">
                                            <div class="form-align">
                                                <div class="form-group m-0 fg1">
                                                    <input type="checkbox" data-id="20" id="itall">
                                                    <label for="itall" id="change" class="thirddo" readonly="">&nbsp;&nbsp;WE-DO-IT-ALL
                                                        FOR YOU</label>
                                                </div>
                                                <p class="your" id="change"><label for="itall">Our team of experts will
                                                        <br>
                                                        manage and implement your <br>
                                                        entire marketing plan for you.</label>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="">
                                        <span class="help-block hide-me"><small></small></span>
                                    </div>
                                    <div class="text-center main-btn">
                                        <button class="btn btn-light back-btn" id="backBtn4"
                                                style="margin-right: 5px;padding: 10px 30px;font-size: 14px;">Back
                                        </button>
                                        <button class="btn btn-primary cont-btn" id="hideBtn4" data-target-id="4">
                                            Continue
                                        </button>
                                    </div>
                                    <div class="text-center skips" style="display: none;">

                                        <p style="color: #F4312B; cursor: pointer;" class="skip-this-step"
                                           id="skiphideBtn4">Skip this step</p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{--         New Fifth for dropdown--}}

                <div class="row " style="display: none;" id="box5">
                    <div class="col-sm-12">
                        <p class="step-info">Step 5 of 5</p>
                    </div>
                    <div class="col-sm-12">
                        <div class="card1 border border-dark px-3 change-media"
                             style="display: flex;/*align-items: center;*/justify-content: center;">
                            <form class="form5" style="width: 100%;">
                                <div class="card-body" style="width: 100%">
                                    <h1 class="practice-heading text-center">How did you hear about us?</h1>
                                    <div class="d-flex justify-content-center  okg ">
                                        <div class="main-xs1" id="selectBox" style="width: 100%">
                                            <div class="form-align " style="width: 100%">
                                                <div class="m-0 fg1">
                                                    {{--                                                    <label>How did you hear about us?</label>--}}
                                                    <select class="form-control selectpicker" id="priority"
                                                            name="priority">
                                                        <option value="">Select</option>
                                                        <option value="21">Search Engine</option>
                                                        <option value="22">Google Ads</option>
                                                        <option value="23">Facebook Ads</option>
                                                        <option value="24">Email</option>
                                                        <option value="25">Referral</option>
                                                        <option value="26">Other</option>
                                                        {{--                                                        @for($i=1; $i<=100;$i++)--}}
                                                        {{--                                                            <option value="{{ $i }}" {{ selectedChosenValueV2($records,'priority', $i) }}>{{ $i }}</option>--}}
                                                        {{--                                                        @endfor--}}
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="">
                                        <span class="help-block hide-me"><small></small></span>
                                    </div>
                                    <div class="text-center main-btn">
                                        <button class="btn btn-light back-btn" id="backBtn5"
                                                style="margin-right: 5px;padding: 10px 30px;font-size: 14px;">Back
                                        </button>
                                        <button class="btn btn-primary cont-btn" id="hideBtn5" data-target-id="5">
                                            Continue
                                        </button>
                                    </div>
                                    <div class="text-center skips" style="display: none;">

                                        <p style="color: #F4312B; cursor: pointer;" class="skip-this-step"
                                           id="skiphideBtn4">Skip this step</p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                {{--         Fifth--}}

                <div class="row " style="display: none;" id="box6">
                    <div class="col-sm-12">
                        <p class="step-info">Step 5 of 5</p>
                    </div>
                    <div class="col-sm-12">
                        <div class=" border border-dark px-3 change-media card5">
                            <div class="card-body">
                                <h1 class="practice-heading5 text-center">Great! We found a marketing strategy we think
                                    you’ll like</h1>
                                <div class="okg ">
                                    <div class="main-after-ana">

                                        <p class="after-ana">After analyzing your SEO audit, online reputation and these
                                            few questions, we have identified possible solutions that
                                            <br class="visible-lg">
                                            that can help you achieve your practice and professional goals. Included in
                                            your 14-day trial is a <b style="color: black;">FREE</b> revenue gen-
                                            <br class="visible-lg">
                                            erating marketing campaign so you can experience how easy it is to use
                                            nichepractice and how it can help your prac-
                                            <br class="visible-lg">
                                            tice become more successful.With your paid subscription, you can folow our
                                            One-Year marketing strategy or choose
                                            <br class="visible-lg">
                                            from over 40 strategies to promote your own practice. </p>

                                    </div>


                                </div>


                                <div class="text-center main-btn">

                                    <button class="btn btn-primary cont-btn5" id="hideBtn6">Start My Marketing Now!
                                    </button>
                                </div>


                            </div>
                        </div>
                    </div>


                </div>


            </div>
        </div>


    </div>
@endsection


@section('css')
    <style>


        /*thirdquery*/
        .card {
            border: 1px solid #356464 !important;
        }

        @media screen and (max-width: 840px) and (min-width: 571px) {
            .card1 {
                min-height: 600px !important;
            }

        }

        @media screen and (max-width: 623px) and (min-width: 571px) {
            .card1 {
                min-height: 760px !important;
            }

        }

        @media screen and (max-width: 570px) and (min-width: 348px) {
            .card1 {
                min-height: 770px !important;
            }

            .practice-heading {
                font-size: 26px !important;
                font-weight: 700;
                font-family: "Arial";
                color: #090909;

            }

            .practice-heading {
                line-height: 32px;
            }

        }

        @media screen and (max-width: 425px) and (min-width: 200px) {
            .main-xs {

                width: 70% !important;

            }
        }

        @media screen and (max-width: 347px) and (min-width: 281px) {
            .card1 {
                min-height: 903px !important;
            }

            .practice-heading {
                font-size: 16px !important;
                font-weight: 700;
                font-family: "Arial";
                color: #090909;
            }

            .practice-heading {
                line-height: 32px;
            }

        }

        @media screen and (max-width: 280px) and (min-width: 200px) {
            .card1 {
                min-height: 870px !important;
            }

            .practice-heading {
                font-size: 15px !important;
                font-weight: 700;
                font-family: "Arial";
                color: #090909;
            }

            .practice-heading {
                line-height: 22px;
            }

        }

        /*.............zero...........*/
        @media screen and (max-width: 600px) and (min-width: 500px) {
            #card0 {
                display: flex;
                flex-direction: column;
                justify-content: start !important;
                min-height: 345px !important;
            }


        }

        @media screen and (max-width: 499px) and (min-width: 200px) {
            #card0 {
                display: flex;
                flex-direction: column;
                justify-content: start !important;
                min-height: 390px !important;
            }

            #lineheight {
                line-height: 25px;
            }


        }

        /*......................*/
        @media screen and (max-width: 1169px) and (min-width: 1025px) {
            .card {
                min-height: 429px;
            }

            .card1 {

                min-height: 532px !important;

            }


        }

        @media screen and (max-width: 870px) and (min-width: 797px) {
            .card {
                min-height: 480px;
            }

        }

        @media screen and (max-width: 929px) and (min-width: 612px) {
            .card {
                min-height: 491px;
            }

        }

        @media screen and (max-width: 611px) and (min-width: 556px) {
            .card {
                min-height: 526px;
            }

        }

        @media screen and (max-width: 555px) and (min-width: 506px) {
            .card {
                min-height: 620px;
            }

        }

        @media screen and (max-width: 505px) and (min-width: 449px) {
            .card {
                min-height: 661px;
            }

        }

        @media screen and (max-width: 448px) and (min-width: 408px) {
            .card {
                min-height: 730px;
            }

        }

        @media screen and (max-width: 407px) and (min-width: 314px) {
            .card {
                min-height: 775px;
            }

        }

        @media screen and (max-width: 321px) and (min-width: 200px) {
            .card {
                min-height: 753px;

            }

            .cont-btn {
                padding-right: 40px !important;
                padding-left: 40px !important;
                background-color: #0681C2 !important;
                border-color: #0681C2 !important;
                padding-top: 6px;
                padding-bottom: 6px;
                font-size: 19px;
            }

            .form-group label {
                position: relative;
                cursor: pointer;
                font-size: 12px;
            }

        }


        @media screen and (max-width: 796px) and (min-width: 500px) {
            .practice-heading5 {
                font-size: 20px;
                font-weight: 800;
                font-family: "Arial";
                color: #090909;
                margin-bottom: 6px;
                text-align: center;
                padding-right: 15px;
                line-height: 29px !important;
            }

            .cont-btn5 {
                /* padding-right: 80px; */
                /* padding-left: 80px; */
                background-color: #1682c0 !important;
                border-color: #1682c0 !important;
                padding-top: 6px;
                padding-bottom: 6px;
                font-size: 19px;
                font-weight: bold;
                margin-top: 16px !important;
            }

        }

        @media screen and (max-width: 500px) and (min-width: 515px) {
            .card5 {
                background: #FFFFFF;
                border: 1px solid #356464;
                box-sizing: border-box;
                min-width: 275px;
                min-height: 405px !important;
                position: relative;
                padding: 20px 30px;
                margin-bottom: 40px;
                overflow: hidden;
            }

        }

        @media screen and (max-width: 499px) and (min-width: 360px) {

            .card5 {
                background: #FFFFFF;
                border: 1px solid #356464;
                box-sizing: border-box;
                min-width: 275px;
                min-height: 520px !important;
                position: relative;
                padding: 20px 30px;
                margin-bottom: 40px;
                overflow: hidden;
            }

            .practice-heading5 {
                font-size: 20px;
                font-weight: 800;
                font-family: "Arial";
                color: #090909;
                margin-bottom: 6px;
                text-align: center;
                padding-right: 15px;
                line-height: 25px !important;
            }

            .cont-btn5 {
                /* padding-right: 80px; */
                /* padding-left: 80px; */
                background-color: #1682c0 !important;
                border-color: #1682c0 !important;
                padding-top: 6px;
                padding-bottom: 6px;
                font-size: 19px;
                font-weight: bold;
                margin-top: 20px !important;
            }
        }

        @media screen and (max-width: 359px) and (min-width: 280px) {


            .card5 {
                background: #FFFFFF;
                border: 1px solid #356464;
                box-sizing: border-box;
                min-width: 275px;
                min-height: 550px !important;
                position: relative;
                padding: 20px 30px;
                margin-bottom: 40px;
                overflow: hidden;
            }

            .practice-heading5 {
                font-size: 20px;
                font-weight: 800;
                font-family: "Arial";
                color: #090909;
                margin-bottom: 6px;
                text-align: center;
                padding-right: 15px;
                line-height: 23px !important;
            }

            .cont-btn5 {
                padding-right: 3px !important;
                padding-left: 3px !important;
                background-color: #1682c0 !important;
                border-color: #1682c0 !important;
                padding-top: 6px;
                padding-bottom: 6px;
                font-size: 15px !important;
                font-weight: bold;
                margin-top: 11px !important;
            }


        }

        .card5 {
            background: #FFFFFF;
            border: 1px solid #356464;
            box-sizing: border-box;
            min-width: 275px;
            min-height: 367px;
            position: relative;
            padding: 20px 30px;
            margin-bottom: 40px;
            overflow: hidden;
        }


        .cont-btn5 {
            /* padding-right: 80px; */
            /* padding-left: 80px; */
            background-color: #1682c0 !important;
            border-color: #1682c0 !important;
            padding-top: 6px;
            padding-bottom: 6px;
            font-size: 19px;
            font-weight: bold;
            margin-top: 55px;
        }


        .practice-heading5 {
            font-size: 20px;
            font-weight: 800;
            font-family: "Arial";
            color: #090909;
            margin-bottom: 6px;
            text-align: center;
            padding-right: 39px;
        }

        .main-after-ana {
            display: flex;
            justify-content: center;
            width: 100%;
            color: #8d8a8a;
        }

        .cont-btn0 {
            padding-right: 30px;
            padding-left: 30px;
            background-color: #1682c0 !important;
            border-color: #1682c0 !important;
            padding-top: 6px;
            padding-bottom: 6px;
            font-size: 19px;
            font-weight: bold;
            margin-top: 15px;
        }

        .after-ana0 {

            font-size: 17px;
            font-weight: 400;
            margin-left: 15px;
            color: #727375;
        }

        #card0 {
            display: flex;
            flex-direction: column;
            justify-content: start;
        }

        .after-ana {

            font-size: 13px;
            font-weight: bold;
            margin-left: 15px;
        }

        .skip-this-step {
            font-weight: 600;
            font-size: 17px;
        }

        .after-ana {
            text-align: left;
        }

        .pad-step-two {
            padding-right: 30px;
        }

        #box0 {
            padding-top: 70px;
            margin: auto;
            max-width: 870px;
        }

        #box1 {
            padding-top: 70px;
            margin: auto;
            max-width: 870px;
        }

        #box2 {
            padding-top: 70px;
            margin: auto;
            max-width: 870px;
        }

        #box3 {
            padding-top: 70px;
            margin: auto;
            max-width: 800px;
        }

        #box4 {
            padding-top: 70px;
            margin: auto;
            max-width: 800px;
        }

        #box5 {
            padding-top: 70px;
            margin: auto;
            max-width: 870px;
        }

        #box6 {
            padding-top: 70px;
            margin: auto;
            max-width: 870px;
        }

        .form-group label {
            position: relative;
            cursor: pointer;
            color: #8D8A8A;
        }

        .form-group label.thirddo {
            position: relative;
            cursor: pointer;
            color: black;
            font-weight: 800;
        }


        .fg1 {
            text-align: left;
        }

        .your {
            text-align: left;
            color: #8D8A8A;
            font-weight: 600;
            margin-top: 7px;
        }

        .skips {
            margin-top: 10px;
        }

        .step-info {
            margin-left: 5px;
        }

        .okg {
            display: flex;
            flex-wrap: wrap;
        }


        .form-align {
            align-items: center;
        }

        div.mar-right-left {


            margin-right: 10px;
            margin-left: 10px;
        }

        .card1 {
            background: #FFFFFF;
            border: 1px solid #356464;
            box-sizing: border-box;

            min-width: 275px;
            min-height: 400px;
            position: relative;
            padding: 20px 30px;
            /*margin-bottom: 40px;*/
            overflow: hidden;
        }

        .main-xs1 {
            border: 1px solid #969f9f;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 4px;
            border-radius: 7px;


            padding-right: 8px;
            padding-left: 8px;
            padding-top: 11px;
            padding-bottom: 10px;
            margin-right: 13px;
            margin-left: 13px;

        }

        .main-xs {
            border: 1px solid #1aa4bb;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 4px;
            border-radius: 4px;


            padding-right: 16px;
            padding-left: 16px;
            padding-top: 11px;
            padding-bottom: 10px;
            margin-bottom: 8px;

        }


        .fg {
            align-items: center;
        }

        .main-btn {
            margin-top: 20px;
        }

        .cont-btn {
            padding-right: 80px;
            padding-left: 80px;
            background-color: #1682c0 !important;
            border-color: #1682c0 !important;
            padding-top: 6px;
            padding-bottom: 6px;
            font-size: 19px;
            font-weight: bold;
        }


        .step-info {
            font-size: 17px;
            font-weight: 400;
            font-family: "Arial";
            color: #34485a;
            font-weight: bold;
        }

        .practice-heading0 {
            font-size: 22px;
            font-weight: 800;
            font-family: "Arial";
            color: #090909;
            margin-bottom: 10px;
        }

        .practice-heading {
            font-size: 25px;
            font-weight: 800;
            font-family: "Arial";
            color: #090909;
            margin-bottom: 25px;
        }


        .form-group {
            display: block;
            margin-bottom: 15px;
        }

        .form-group input {
            padding: 0;
            height: initial;
            width: initial;
            margin-bottom: 0;
            display: none;
            cursor: pointer;
        }

        .form-group label {
            position: relative;
            cursor: pointer;
        }

        .form-group label:before {
            content: '';
            -webkit-appearance: none;
            background-color: transparent;
            border: 2px solid #E5EBF0;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05), inset 0px -15px 10px -12px rgba(0, 0, 0, 0.05);
            padding: 6px;
            display: inline-block;
            position: relative;
            vertical-align: middle;
            cursor: pointer;
            margin-right: 5px;
        }


        .form-group input:checked + label:after {
            content: '';
            display: block;
            position: absolute;
            top: 2px;
            left: 9px;
            width: 6px;
            height: 14px;
            border: solid #01A4BD;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);

        }

        .highlight {
            background-color: rgb(229, 245, 248);
            border-color: rgb(108, 198, 214);
            border-width: 2px;
        }


    </style>
@endsection

@section('js')
    <script>
        // $(":checkbox").on("change", function() {
        //     var that = this;
        //     $(this).parent().css("background-color", function() {
        //         return that.checked ? "#ff0000" : "";
        //     });
        // });
        $("input:checkbox").click(function () {
            var actualTime = "";
            $(this).parent().parent().parent().toggleClass("highlight");
        });

    </script>


    <script>
        function submitButtonStyle(_this) {

            _this.style.backgroundColor = "#E5F5F8";

            _this.style.borderColor = "#6CC6D6";
            _this.style.borderWidth = "2px";
        }

    </script>

    <script>
        var count = 0;

        function myfunction(x) {

            var x;
            if (x == 1) {
                count = count + 1;
            }

            if (count == 1) {

                document.getElementById("change").style.background = "#E5F5F8";
                document.getElementById("change").style.borderColor = "#57797A";
                document.getElementById("change").style.borderWidth = "3px";
            } else if (count == 2) {
                document.getElementById("change").style.background = "#FFFFFF";
                document.getElementById("change").style.borderColor = "#969F9F";
                document.getElementById("change").style.borderWidth = "1px";
                count = 0;
            }

        }

    </script>

    <script>
        var count = 0;

        function myfunction1(x) {

            var x;
            if (x == 1) {
                count = count + 1;
            }

            if (count == 1) {

                document.getElementById("change1").style.background = "#E5F5F8";
                document.getElementById("change1").style.borderColor = "#57797A";
                document.getElementById("change1").style.borderWidth = "3px";
            } else if (count == 2) {
                document.getElementById("change1").style.background = "#FFFFFF";
                document.getElementById("change1").style.borderColor = "#969F9F";
                document.getElementById("change1").style.borderWidth = "1px";
                count = 0;
            }

        }

    </script>

    <script>
        var count = 0;

        function myfunction2(x) {

            var x;
            if (x == 1) {
                count = count + 1;
            }

            if (count == 1) {

                document.getElementById("change2").style.background = "#E5F5F8";
                document.getElementById("change2").style.borderColor = "#57797A";
                document.getElementById("change2").style.borderWidth = "3px";
            } else if (count == 2) {
                document.getElementById("change2").style.background = "#FFFFFF";
                document.getElementById("change2").style.borderColor = "#969F9F";
                document.getElementById("change2").style.borderWidth = "1px";
                count = 0;
            }

        }

    </script>

    <script>
        var count = 0;

        function myfunction3(x) {

            var x;
            if (x == 1) {
                count = count + 1;
            }

            if (count == 1) {

                document.getElementById("change3").style.background = "#E5F5F8";
                document.getElementById("change3").style.borderColor = "#57797A";
                document.getElementById("change3").style.borderWidth = "3px";
            } else if (count == 2) {
                document.getElementById("change3").style.background = "#FFFFFF";
                document.getElementById("change3").style.borderColor = "#969F9F";
                document.getElementById("change3").style.borderWidth = "1px";
                count = 0;
            }

        }

    </script>

    <script>
        var count = 0;

        function myfunction4(x) {

            var x;
            if (x == 1) {
                count = count + 1;
            }

            if (count == 1) {

                document.getElementById("change4").style.background = "#E5F5F8";
                document.getElementById("change4").style.borderColor = "#57797A";
                document.getElementById("change4").style.borderWidth = "3px";
            } else if (count == 2) {
                document.getElementById("change4").style.background = "#FFFFFF";
                document.getElementById("change4").style.borderColor = "#969F9F";
                document.getElementById("change4").style.borderWidth = "1px";
                count = 0;
            }

        }

    </script>

    <script>
        var count = 0;

        function myfunction5(x) {

            var x;
            if (x == 1) {
                count = count + 1;
            }

            if (count == 1) {

                document.getElementById("change5").style.background = "#E5F5F8";
                document.getElementById("change5").style.borderColor = "#57797A";
                document.getElementById("change5").style.borderWidth = "3px";
            } else if (count == 2) {
                document.getElementById("change5").style.background = "#FFFFFF";
                document.getElementById("change5").style.borderColor = "black";
                document.getElementById("change5").style.borderWidth = "1px";
                count = 0;
            }

        }

    </script>






    <script>
        $(document).ready(function () {
            $('#hideBtn0').click(function () {
                $('#box0').hide();
                $('#box1').show();
            });


            // $('#hideBtn1').click(function(){
            //
            //     $('#box1').hide();
            //     $('#box2').show();
            //
            //
            //
            // });
            // $('#backBtn1').click(function(){
            //     $('#box0').show();
            //     $('#box1').hide();
            // });

            // $('#hideBtn2').click(function(){
            //     $('#box2').hide();
            //     $('#box3').show();
            //
            //
            //
            // });
            $('#backBtn2').click(function (e) {
                e.preventDefault();
                $('#box1').show();
                $('#box2').hide();
            });

            $('#skiphideBtn2').click(function (e) {
                e.preventDefault();
                $('#box2').hide();
                $('#box3').show();


            });
            // $('#hideBtn3').click(function(){
            //     $('#box3').hide();
            //     $('#box4').show();
            //
            //
            //
            // });
            $('#backBtn3').click(function (e) {
                e.preventDefault();
                $('#box2').show();
                $('#box3').hide();
            });

            $('#skiphideBtn3').click(function (e) {
                e.preventDefault();
                $('#box3').hide();
                $('#box4').show();


            });

            // $('#hideBtn4').click(function(){
            //     $('#box4').hide();
            //     $('#box5').show();
            //
            //
            //
            // });
            $('#backBtn4').click(function (e) {
                e.preventDefault();
                $('#box3').show();
                $('#box4').hide();
            });

            $('#skiphideBtn4').click(function (e) {
                e.preventDefault();
                $('#box4').hide();
                $('#box5').show();


            });
            $('#backBtn5').click(function (e) {
                e.preventDefault();
                $('#box4').show();
                $('#box5').hide();
            });


        });
    </script>
    {{-- <script>--}}
    {{--        function checkedfunction() {--}}
    {{--            var checkBox = document.getElementsByClassName("mycheck");--}}
    {{--            var text = document.getElementById("change1");--}}
    {{--            if (checkBox.checked == true){--}}
    {{--                text.style.backgroundColor = "red";--}}
    {{--            } else {--}}
    {{--                text.style.backgroundColor = "orange";--}}
    {{--            }--}}
    {{--        }--}}
    {{--    </script>--}}


    {{--    <script>--}}
    {{--        function isChecked(){--}}

    {{--            var chk = document.getElementsByClassName("termsChkbx");--}}
    {{--            if(chk.checked){--}}
    {{--                document.getElementById("bgs").style.background="#E5F5F8";--}}
    {{--                document.getElementById("bgs").style.borderColor="#57797A";--}}
    {{--                document.getElementById("bgs").style.borderWidth="2px";--}}
    {{--            }--}}
    {{--            else{--}}
    {{--                document.getElementById("bgs").style.background="#FFFFFF";--}}
    {{--                document.getElementById("bgs").style.borderColor="#969f9f";--}}
    {{--            }--}}
    {{--        }--}}

    {{--    </script>--}}

    <script>
        function isChecked() {

            var chk = document.getElementById("revenue");
            var text = document.getElementsByClassName("yes1");
            if (chk.checked) {
                text.style.backgroundColor = "red";
            } else {
                text.style.backgroundColor = "yellow";
            }
        }
    </script>
    <script>
        // var targetIds = [];
        // var targetIds1 = [];
        // var targetIds2 = [];
        // var targetIds3 = [];
        // var targetIds4 = [];
        $(document).on('click', '#hideBtn1, #hideBtn2, #hideBtn3, #hideBtn4, #hideBtn5', function (e) {
            e.preventDefault();
            // console.log('clicked');
            // console.log(targetIds1);
            // console.log(targetIds2);
            // console.log(targetIds3);
            // console.log(targetIds4);
            var currentTarget = $(this).attr('data-target-id');
            // console.log(currentTarget);
            // if() {
            //
            // }


            var totalCheckboxes1 = $('.form1 input:checkbox:checked').length;
            var totalCheckboxes2 = $('.form2 input:checkbox:checked').length;
            var totalCheckboxes3 = $('.form3 input:checkbox:checked').length;
            var totalCheckboxes4 = $('.form4 input:checkbox:checked').length;
            var totalSelected5 = $('.form5 option:checked').val();

            if (currentTarget == 1) {
                if (totalCheckboxes1 < 1) {
                    $('span.help-block').removeClass('hide-me');
                    $('span.help-block').addClass('error');
                    $('span.help-block').html('Please select a goal.');
                    return;
                } else {
                    $('span.help-block').removeClass('error');
                    $('span.help-block').addClass('hide-me');
                    $('#box1').hide();
                    $('#box2').show();
                }
            }
            if (currentTarget == 2) {
                if (totalCheckboxes2 < 1) {
                    $('span.help-block').removeClass('hide-me');
                    $('span.help-block').addClass('error');
                    $('span.help-block').html('Please select a goal.');
                    return;
                } else {
                    $('span.help-block').removeClass('error');
                    $('span.help-block').addClass('hide-me');
                    $('#box2').hide();
                    $('#box3').show();
                }
            }
            if (currentTarget == 3) {
                if (totalCheckboxes3 < 1) {
                    $('span.help-block').removeClass('hide-me');
                    $('span.help-block').addClass('error');
                    $('span.help-block').html('Please select a goal.');
                    return;
                } else {
                    $('span.help-block').removeClass('error');
                    $('span.help-block').addClass('hide-me');
                    $('#box3').hide();
                    $('#box4').show();
                }
            }
            if (currentTarget == 4) {
                if (totalCheckboxes4 < 1) {
                    $('span.help-block').removeClass('hide-me');
                    $('span.help-block').addClass('error');
                    $('span.help-block').html('Please select a goal.');
                    return;
                } else {
                    $('span.help-block').removeClass('error');
                    $('span.help-block').addClass('hide-me');
                    $('#box4').hide();
                    $('#box5').show();
                }
            }
            if (currentTarget == 5) {
                console.log(totalSelected5);
                // return;
                if (totalSelected5 == '' || totalSelected5 == null || totalSelected5 == undefined) {
                    $('span.help-block').removeClass('hide-me');
                    $('span.help-block').addClass('error');
                    $('span.help-block').html('Please select a goal.');
                    return;
                } else {
                    $('span.help-block').removeClass('error');
                    $('span.help-block').addClass('hide-me');
                    $('#box5').hide();
                    $('#box6').show();
                }
            }
            // if(totalCheckboxes2 < 1) {
            //     $( 'span.help-block').removeClass('hide-me');
            //     $( 'span.help-block').addClass('error');
            //     $( 'span.help-block').html('Choose atleast one option.');
            //     return;
            // }else {
            //     $( 'span.help-block').removeClass('error');
            //     $( 'span.help-block').addClass('hide-me');
            //     $('#box2').hide();
            //     $('#box3').show();
            // }
            // console.log(totalCheckboxes1);
            // console.log(totalCheckboxes2);
            // console.log(totalCheckboxes3);
            // console.log(totalCheckboxes4);
            // $('input[type=checkbox]:checked').each(function() {
            //     targetIds.push($(this).data('id'));
            //     // return targetIds;
            // });
            //
            // if(targetIds == '' || targetIds == null || targetIds == undefined) {
            //     console.log(targetIds)
            //     $( 'span.help-block').removeClass('hide-me');
            //     $( 'span.help-block').addClass('error');
            //     $( 'span.help-block').html('Choose atleast one option.');
            //     return;
            // }
            //
            // else {
            //     $( 'span.help-block').removeClass('error');
            //     $( 'span.help-block').addClass('hide-me');
            // }
            // console.log(targetIds)
            //  if( currentTarget == 1 ) {
            //
            //      $('input[type=checkbox]:checked').each(function() {
            //          targetIds1.push($(this).data('id'));
            //          // return targetIds;
            //      });
            //      if(targetIds1 == '' || targetIds1 == null || targetIds1 == undefined) {
            //
            //          console.log('here 1');
            //          console.log(targetIds1)
            //          $( 'span.help-block').removeClass('hide-me');
            //          $( 'span.help-block').addClass('error');
            //          $( 'span.help-block').html('Choose atleast one option.');
            //          return;
            //      }
            //      else{
            //
            //          $('#box1').hide();
            //          $('#box2').show();
            //      }
            //
            //
            //  }
            //  if( currentTarget == 2 ) {
            //      console.log('here 2');
            //      $('input[type=checkbox]:checked').each(function() {
            //          targetIds2.push($(this).data('id'));
            //          // return targetIds;
            //      });
            //      if(targetIds2 == '' || targetIds2 == null || targetIds2 == undefined) {
            //
            //
            //          console.log('targetIds2');
            //          console.log(targetIds2);
            //
            //          $( 'span.help-block').removeClass('hide-me');
            //          $( 'span.help-block').addClass('error');
            //          $( 'span.help-block').html('Choose atleast one option.');
            //          return;
            //      }
            //      else {
            //          console.log(' y  targetIds2');
            //          console.log(targetIds2);
            //          $('#box2').hide();
            //          $('#box3').show();
            //      }
            //
            //  }
            // if( currentTarget == 3 ) {
            //      console.log('here 3');
            //      $('input[type=checkbox]:checked').each(function() {
            //          targetIds3.push($(this).data('id'));
            //          // return targetIds;
            //      });
            //      if(targetIds3 == '' || targetIds3 == null || targetIds3 == undefined) {
            //          console.log('targetIds3');
            //          console.log(targetIds3)
            //          $( 'span.help-block').removeClass('hide-me');
            //          $( 'span.help-block').addClass('error');
            //          $( 'span.help-block').html('Choose atleast one option.');
            //          return;
            //      }
            //      else {
            //          $('#box3').hide();
            //          $('#box4').show();
            //      }
            //  }
            //  if( currentTarget == 4 ) {
            //
            //      console.log('here 4');
            //      $('input[type=checkbox]:checked').each(function() {
            //          targetIds4.push($(this).data('id'));
            //          // return targetIds;
            //      });
            //      if(targetIds4 == '' || targetIds4 == null || targetIds4 == undefined) {
            //          console.log('targetIds4')
            //          console.log(targetIds4)
            //          $( 'span.help-block').removeClass('hide-me');
            //          $( 'span.help-block').addClass('error');
            //          $( 'span.help-block').html('Choose atleast one option.');
            //          return;
            //      }
            //      else {
            //          $('#box4').hide();
            //          $('#box5').show();
            //      }
            //  }
            // console.log(targetIds1)
            // console.log(targetIds2)
            // console.log(targetIds3)
            // console.log(targetIds4)

        });
    </script>

@endsection
