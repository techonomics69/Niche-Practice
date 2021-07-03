@extends('index')

@section('pageTitle', 'Business Listings')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid dashboarbgtitle">
            <div class="dashboard-wrapper" >
                <div class="page-head">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="page-title"> Healthcare Citations
{{--                                <a class="page-help" href="javascript:void(0)">--}}
{{--                                    <i class="fa fa-question-circle-o" style="color: #7d8080;/* transform: scaleX(-1); */margin-right: 5px; padding-left: 3px;"></i>--}}
{{--                                    <img class="help-info-image" src="{{ asset('public/images/information.png') }}" />--}}
{{--                                </a>--}}
                            </h4>
                        </div>

{{--                        <div class="col-md-6">--}}
{{--                            <div class=" order-preview-panel row bg-white box-width-task-list " style="border: #DDE3EE 1px solid; width: 370px; margin-left: 1px;padding: 0px;padding-top: 12px; padding-bottom: 12px; float: right; margin-right: 3px; border: 2px solid #68ABE0;">--}}
{{--                                <div class="top-intro-panel" style="--}}
{{--">--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-xs-2" style="padding-right:4px;">--}}
{{--                                            <img src="{{ asset('public/images/order-marketing-avatar-new.png') }}" style="float:right; height:40px !important">--}}
{{--                                        </div>--}}
{{--                                        <div class="col-xs-10" style="padding-left:8px;">--}}
{{--                                            <h4 style="font-weight:600; margin:0px; font-size: 16px;">I need a <span style="font-weight:700; color:#4167B1;">Marketing pro</span> to Help Me</h4>--}}
{{--                                            <p style="margin:0px; font-size: 12px; padding-top: 2px; ">Have an expert from our team complete this task for you</p>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="order-btns" style="background-color: #F4F5F8;padding-bottom: 8px;">--}}
{{--                                        <h4 style="color:#4167B1;">1 Credits</h4><button class="btn btn-learn-more">Learn More</button>--}}
{{--                                        <input type="hidden" id="task-credits" value="1"></div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <div class="social-posts-wrapper">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="listing-tabs">
                                        <ul style="display: none;" class="nav nav-tabs" role="tablist">
                                            <li role="presentation" class=""><a href="#all" aria-controls="home" role="tab" data-toggle="tab">All</a></li>
                                            <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Listed - 5</a></li>
                                            <li role="presentation" class=""><a href="#incorrect" aria-controls="home" role="tab" data-toggle="tab">Incorrect - 25</a></li>
                                            <li role="presentation" class=""><a href="#notlisted" aria-controls="home" role="tab" data-toggle="tab">Not Listed - 15</a></li>

                                        </ul>

                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane" id="all">...</div>
                                            <div role="tabpanel" class="tab-pane active" id="home">
                                                <table id="" class="table-responsive" style="width:100%">
                                                    <thead>
                                                    <tr style="height: 60px;background: #f9f9f9;" role="row"><th class="select-checkbox sorting_disabled" rowspan="1" colspan="1" style="width: 25px;" aria-label=""></th><th class="sorting_asc" tabindex="0" aria-controls="customers-list" rowspan="1" colspan="1" style="width: 120px;" aria-sort="ascending">
                                                            <span>DIRECTORY</span>
                                                        </th>
                                                        <th class="sorting_disabled" tabindex="0" aria-controls="customers-list" rowspan="1" colspan="1" style="width: 170px;" aria-label="
                                                                                        Email Address
                                                                                    : activate to sort column ascending">
                                                            <span>NAME</span>
                                                        </th>
                                                        <th class="sorting_disabled" tabindex="0" aria-controls="customers-list" rowspan="1" colspan="1" style="width: 220px;">
                                                            <span>ADDRESS</span>
                                                        </th><th class="sorting_disabled" tabindex="0" aria-controls="customers-list" rowspan="1" colspan="1" style="width: 139px;">
                                                            <span>PHONE NO.</span>
                                                        </th>
                                                        <th class="sorting_disabled" tabindex="0" aria-controls="customers-list" rowspan="1" colspan="1" style="width: 150px !important;display: none;">
                                                            <span>STATUS</span>
                                                        </th>
                                                        <th class="sorting_disabled" tabindex="0" aria-controls="customers-list" rowspan="1" colspan="1" style="width: 100px !important;">
                                                            <span>GET LISTED</span>
                                                        </th>
                                                        <th class="sorting_disabled" tabindex="0" aria-controls="customers-list" rowspan="1" colspan="1" style="width: 140px !important;">
                                                            <span>MONITOR</span>
                                                        </th>
                                                        <th class="sorting_disabled" tabindex="0" aria-controls="customers-list" rowspan="1" colspan="1" style="display: none; width: 120px !important;">
                                                            <span>ACTIONS</span>
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($sources as $source)
                                                        <?php
                                                        $reviewType = str_replace(" ", "", strtolower($source['name']));
                                                        $originalName = $source['name'];
                                                        $name = $originalName;

                                                        if($name == 'Google Places')
                                                        {
                                                            $name = 'Google';
                                                        }

                                                        $data = ( !empty($source['data']) ) ? $source['data'] : '';
                                                        ?>
                                                        <tr role="row" class="odd">
                                                        <td class=" select-checkbox"></td>

                                                        <td class="text-verticle-align">
                                                            <div class="listing-business-logo">
                                                                <img src="{{ asset('public/images/icons/'.$reviewType.'-large.png') }}"/>

                                                                <label>{{ $name }}</label>
                                                            </div>
                                                        </td>

                                                        <td class="text-verticle-align">
                                                            <div class="listing-name">
                                                                @if(!empty($data))
                                                                <label>{{ $data['name'] }}</label>
                                                                @endif
                                                            </div>
                                                        </td>

                                                        <td class="text-verticle-align">

                                                            @if(!empty($data))
                                                            <div class="listing-address">
                                                                <p>{{ $data['street'] }}</p>
                                                            </div>
                                                            @endif
                                                        </td>

                                                        <td class="text-verticle-align">

                                                            @if(!empty($data))
                                                                <div class="listing-phone">
                                                                    <h5>
                                                                        {{ $data['phone'] }}
                                                                    </h5>
                                                                </div>
                                                            @endif

                                                        </td>

                                                        <td class="text-verticle-align review-requests-col" style="display: none;">

                                                            <div class="lisitng-status">

                                                                @if(!empty($data) && $source['status'])
                                                                    <div class="listed-badge">
                                                                        <label class="listed-label"><span class="listed-notification"></span>Listed</label>
                                                                    </div>
                                                                @else
                                                                    <div class="incorrect-badge">
                                                                        <label class="incorrect-label"><span class="incorrect-notification"></span>Not Listed</label>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </td>
                                                            <td class="text-verticle-align review-requests-col">
                                                                <div class="add-img">

                                                                    <img data-toggle="tooltip" title="Get Citation" src="{{ asset('public/images/add.jpg') }}" style="width: 25px;">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                @if(!empty($data) && $source['status'])
                                                                    <div class="star checkbox-info checkbox p-o">
                                                                        <input class="form-check-input" type="checkbox" checked style="width: 16px;height: 16px;" />
                                                                        <label for="checkbox-signup"></label>
                                                                    </div>
                                                                @else
                                                                    <div class="star">
                                                                        <a href="{{ route('connect-app') }}">
{{--                                                                            <img src="{{ asset('public/images/star.png') }}" style="width: 25px;">--}}
                                                                            <i class="fa fa-eye" aria-hidden="true" style="color: #7ca9e4;font-size: 19px;"></i>
                                                                        </a>
                                                                    </div>
                                                                @endif
                                                            </td>

                                                        <td class="text-verticle-align" style="width: 0px; display: none;">
                                                            <div class="respond-column">
                                                                <a href="" class="edit">Edit</a>
                                                            </div>
                                                        </td>

                                                    </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="incorrect">...</div>
                                            <div role="tabpanel" class="tab-pane" id="notlisted">...</div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Add Listing-->
       <!--  <div class="container-fluid dashboarbgtitle">
            <div class="dashboard-wrapper" >
                <div class="page-head">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="page-title"> Add Listing </h4>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="listing-tabs">
                        <div class="table-responsive">
                                <table id="add-listing" class="table-responsive" style="width:100%; font-family: 'Source Sans Pro', sans-serif;">
                                    <thead>
                                        <tr style="height: 60px; background: #f9f9f9;">
                                            <th style="text-align:center"><span>SITE</span></th>
                                            <th style="text-align:center"><span>STEPS</span></th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-weight: normal; color: #1A1A1A; background: white; font-size: 14px;">
                                        <tr>
                                        <td><img src="{{ asset('public/images/icons/default-logo.png') }}" alt="logo"><a href="#">Acxiom</a></td>
                                            <td>As of January 2020, <a href="#">Acxiom will no longer be acting as a data aggregator.</a></td>
                                        </tr>
                                        <tr>
                                            <td><img src="{{ asset('public/images/citations/angieslist.jpg') }}" alt="Angie’s List"><a href="#">Angie’s List</a></td>
                                            <td><u><a href="#">https://business.angieslist.com/Registration/SimpleRegistration.aspx</a></u><br> If you don’t find your business, click “Add company”.</td>
                                        </tr>
                                        <tr>
                                            <td><img src="{{ asset('public/images/icons/default-logo.png') }}" alt="logo"><a href="#">Apple Maps</a></td>
                                            <td><u><a href="#">https://mapsconnect.apple.com/</a></u><br>If you don’t find the business, click “Add new business”.</td>
                                        </tr>
                                        <tr>
                                            <td><img src="{{ asset('public/images/citations/bbb.jpg') }}" alt="Angie’s List"><a href="#">BBB</a></td>
                                            <td>Go to <u><a href="#">https://bbb.org/bbb-locator</a></u>and find your local BBB. Once found, on the menu click “For business” then click “Register business”. This will take you to this page like this: <u><a href="#">https://westflorida.app.bbb.org/registercompany/</a></u>Once
                                                there, select “No please add/update my information only to add a free listing”. Note: The subdomain will change depending on the name of your local BBB.
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <img src="{{ asset('public/images/icons/default-logo.png') }}" alt="logo"><a href="#">Best of The Web</a>
                                            </td>
                                            <td>
                                                Free listing: <u><a href="#">https://secure.botw.org/secure/Signup.aspx?type=jumpstart&directory=local</a></u><br> Paid listing: <u><a href="#">https://local.botw.org/helpcenter/premiumproduct.aspx</a></u>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <img src="{{ asset('public/images/citations/bing.jpg') }}" alt="Angie’s List"><a href="#">Bing Places</a>
                                            </td>
                                            <td>
                                                <u><a href="#">https://bingplaces.com/</a></u>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <img src="{{ asset('public/images/citations/brownbook.jpg') }}" alt="Angie’s List"><a href="#">Brown Book</a>
                                            </td>
                                            <td>
                                                <u><a href="#"> https://brownbook.net/business/add/</a></u>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <img src="{{ asset('public/images/citations/citysearch.jpg') }}" alt="Angie’s List"><a href="#">CitySearch</a>
                                            </td>
                                            <td>
                                                You are really supposed to go to <u><a href="#">https://expressupdate.com/</a></u>to add your listing but you can email myaccount@citygridmedia.com and ask them to add a listing for you. <br> Reference: <u><a href="#">https://localvisibilitysystem.com/2012/07/25/how-to-add-a-free-citysearch-business-listing-temporary-solution/</a></u>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <img src="{{ asset('public/images/citations/citysquare.jpg') }}" alt="Angie’s List"><a href="#">CitySquares</a>
                                            </td>
                                            <td>
                                                <u><a href="#">https://citysquares.com/add_business</a></u>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <img src="{{ asset('public/images/icons/default-logo.png') }}" alt="logo"><a href="#">Cylex USA</a>
                                            </td>
                                            <td>
                                                <u><a href="#">https://admin.cylex-usa.com/firma_default.aspx?step=0&d=cylex-usa.com</a></u>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <img src="{{ asset('public/images/icons/default-logo.png') }}" alt="logo"><a href="#">Dex Knows</a>
                                            </td>
                                            <td>
                                                <u><a href="#">https://dexknows.com/info/contactUs</a></u><br>Fill out form and choose “Add or remove listing”.
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <img src="{{ asset('public/images/citations/ezlocal.jpg') }}" alt="Angie’s List"><a href="#">EZ Local</a>
                                            </td>
                                            <td>
                                                <u><a href="#"> https://secure.ezlocal.com/newbusiness/default.aspx</a></u>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <img src="{{ asset('public/images/icons/default-logo.png') }}" alt="logo"><a href="#">Facebook</a>
                                            </td>
                                            <td>
                                                <u><a href="#">https://facebook.com/pages/create.</a></u> Or to convert a personal page into a business page go here: <br><u><a href="#">https://facebook.com/help/116067818477568#</a></u>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <img src="{{ asset('public/images/citations/factual.jpg') }}" alt="Angie’s List"><a href="#">Factual</a>
                                            </td>
                                            <td>
                                                Must go through a 3rd-party: <u><a href="#">https://www.factual.com/updatelisting/#update_add_business</a></u>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <img src="{{ asset('public/images/citations/foursquare.jpg') }}" alt="Angie’s List"><a href="#">Foursquare</a>
                                            </td>
                                            <td>
                                                Create an account then go to: <u><a href="#">https://foursquare.com/add-place.</a></u><br>Reference: <u><a href="#">https://support.foursquare.com/hc/en-us/articles/201065050-How-do-I-add-create-a-place-</a></u>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <img src="{{ asset('public/images/icons/default-logo.png') }}" alt="logo"><a href="#">Google My Business</a>
                                            </td>
                                            <td>
                                                <u><a href="#">https://google.com/business/</a></u><br>Reference: <u><a href="#">https://www.pigzilla.co/articles/how-to-setup-a-google-my-business-listing/</a></u>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <img src="{{ asset('public/images/citations/hofrog.jpg') }}" alt="Angie’s List"><a href="#">Hotfrog</a>
                                            </td>
                                            <td>
                                                <u><a href="#">https://admin.hotfrog.com/add/index-card</a></u>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <img src="{{ asset('public/images/icons/default-logo.png') }}" alt="logo"><a href="#">iBegin</a>
                                            </td>
                                            <td>
                                                <u><a href="#">https://ibegin.com/business-center/submit/</a></u>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <img src="{{ asset('public/images/icons/default-logo.png') }}" alt="logo"><a href="#">Infogroup (Express Update)</a>
                                            </td>
                                            <td>
                                                <u><a href="#"> https://expressupdate.com/place_submissions/new</a></u>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <img src="{{ asset('public/images/icons/default-logo.png') }}" alt="logo"><a href="#">InsiderPages</a>
                                            </td>
                                            <td>
                                                Have to create through <u><a href="#">https://expressupdate.com/search</a></u><br>Reference: <u><a href="#">https://insiderpages.com/faq</a></u>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <img src="{{ asset('public/images/icons/default-logo.png') }}" alt="logo"><a href="#">Kudzu</a>
                                            </td>
                                            <td>
                                                <u><a href="#">https://register.kudzu.com/packageSelect.do</a></u>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <img src="{{ asset('public/images/icons/default-logo.png') }}" alt="logo"><a href="#">Localeze</a>
                                            </td>
                                            <td>
                                                <u><a href="#">https://neustarlocaleze.biz/manage/cart/add</a></u>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <img src="{{ asset('public/images/icons/default-logo.png') }}" alt="logo"><a href="#">Manta</a>
                                            </td>
                                            <td>
                                                <u><a href="#"> https://manta.com/add-your-company</a>u</u><br>Reference: <u><a href="#">https://manta.com/resources/faq/</a></u>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <img src="{{ asset('public/images/citations/merchantcircle.jpg') }}" alt="Angie’s List"><a href="#">MerchantCircle</a>
                                            </td>
                                            <td>
                                                <u><a href="#">https://merchantcircle.com/signup</a></u>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <img src="{{ asset('public/images/icons/default-logo.png') }}" alt="logo"><a href="#">Show Me Local</a>
                                            </td>
                                            <td>
                                                <u><a href="#">https://showmelocal.com/register.aspx?ReturnURL=/business-registration.aspx</a></u>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <img src="{{ asset('public/images/citations/superpages.jpg') }}" alt="Angie’s List"><a href="#">Super Pages</a>
                                            </td>
                                            <td>
                                                <u><a href="#">https://claimlisting.superpages.com/spportal/quickbpflow.do</a></u>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <img src="{{ asset('public/images/icons/default-logo.png') }}" alt="logo"><a href="#">Thumbtack</a>
                                            </td>
                                            <td>
                                                <u><a href="#">https://thumbtack.com/pro</a></u>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <img src="{{ asset('public/images/citations/yahoo.jpg') }}" alt="Angie’s List"><a href="#">Yahoo Local</a>
                                            </td>
                                            <td>
                                                <u><a href="#">https://yext.com/pl/yahoo-claims/free-claim-checkout.html</a></u>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <img src="{{ asset('public/images/icons/default-logo.png') }}" alt="logo"><a href="#">Yasabe</a>
                                            </td>
                                            <td>
                                                <u><a href="#">https://yasabe.com/en/business-editor/</a></u>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <img src="{{ asset('public/images/icons/default-logo.png') }}" alt="logo"><a href="#">Yellow Book</a>
                                            </td>
                                            <td>
                                                <a href="#">https://yellowbook.com/add-update-listing/</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <img src="{{ asset('public/images/icons/default-logo.png') }}" alt="logo"><a href="#">YellowBot</a>
                                            </td>
                                            <td>
                                                <u><a href="#">https://yellowbot.com/submit/newbusiness</a></u><br>Note: This site no longer appears to be maintained.
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <img src="{{ asset('public/images/citations/yellowpages.jpg') }}" alt="Yellow Pages"><a href="#">Yellow Pages</a>
                                            </td>
                                            <td>
                                                First create an account here: <u><a href="#">https://accounts.yellowpages.com/register.</a></u> Then go through the process here: <u><a href="#">https://adsolutions.yp.com/listings/basic</a></u>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <img src="{{ asset('public/images/icons/yelp-large.png') }}" alt="Yelp"><a href="#">Yelp</a>
                                            </td>
                                            <td>
                                                Search for your business here: <u><a href="#">https://biz.yelp.com/,</a></u> then click “Add your business to Yelp”. <br>Reference: <u><a href="#">https://yelp-support.com/article/How-do-I-add-a-business-to-Yelp?l=en_US</a></u>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div> -->













          <!--Add Listing-->
        <div class="container-fluid dashboarbgtitle">
            <div class="dashboard-wrapper" >
                <div class="page-head">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="page-title">General Citations
{{--                                <a class="page-help" href="javascript:void(0)" data-module="more_local_citation_listings">--}}
{{--                                    <i class="fa fa-question-circle-o" style="color: #7d8080;"></i>--}}
{{--                                    <img class="help-info-image" src="{{ asset('public/images/information.png') }}" />--}}

{{--                                </a>--}}
                            </h4>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="listing-tabs">
                        <div class="table-responsive">
                            <div class="overflow-x">
                                <table id="add-listing" class="table-responsive" style="width:100%; font-family: 'Source Sans Pro', sans-serif;">
                                    <thead>
                                      <!--   <tr style="height: 60px; background: #f9f9f9;">
                                            <th  style="text-align:center"><span>SITE</span></th>
                                            <th  style="text-align:center"><span>STEPS</span></th>
                                        </tr> -->
                                        <!-- <div class="add-list-main-border">

                                            <p class="col-xs-6 text-center border" >SITE</p>
                                            <p class="col-xs-6 text-center border">STEPS</p>
                                        </div> -->
                                    </thead>
                                    <div class="" style="font-weight: normal; color: #1A1A1A; background: white; font-size: 14px;">
                                        <div class="add-list-main-box">
                                            @foreach($citationList as $citation)
                                                <div class="col-md-3 add-list-img">
                                                    <div class="add-list-img">
                                                        <img src="{{ asset('public/images/citations/'.$citation['image']) }}"
                                                             alt="logo">

                                                        <a href="{{ $citation['link'] }}" target="_blank"><img data-toggle="tooltip" title="Get Citation" src="{{ asset('public/images/add.jpg') }}" style="width: 25px; "></a>
                                                    </div>
                                                    <div class="add-list-title m-t-15">
                                                        <p>Get Listed on {{ $citation['name'] }}</p>
                                                    </div>

                                                    <?php
                                                    $citationId = $citation['id'];
                                                    ?>

                                                    <div class="form-check form-check-inline add-list-checkbox">
                                                        @if(!empty($citation['citation_record']))
                                                        <input value="{{ $citationId }}" class="form-check-input" type="checkbox" id="citation-Checkbox-{{$citationId}}" style="width: 13px;" checked>
                                                        @else
                                                            <input value="{{ $citationId }}" class="form-check-input" type="checkbox" id="citation-Checkbox-{{$citationId}}" style="width: 13px;">
                                                        @endif
                                                        <label class="form-check-label" for="citation-Checkbox-{{$citationId}}">completed</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </table>
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
    #add-listing tbody tr td:first-child img {
        width: 28px;
        margin-right: 8px;
    }
    #add-listing tbody tr td:first-child {
        width: 260px;
        padding-left: 50px;
    }
    @media screen and (max-width: 1305px){
        .add-list-title p{
            height: 60px;
        }
    }

</style>

@endsection

@section('js')
<script>
    $('#element').tooltip('show')
$(function () {
    $(".star .form-check-input").click(function (e) {
        e.preventDefault();
    });

$(".add-list-checkbox input").click(function () {
    var siteUrl = $('#hfBaseUrl').val();
    console.log($(this).val());
    console.log($(this).is(':checked'))

    var state  = ($(this).is(':checked') == true) ? 1 : 0;

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },
        type: "POST",
        url: siteUrl + "/done-me",
        data: {
            send: 'save-citation',
            id: $(this).val(),
            state: state,
        },
        // contentType: false,
        // cache: false,
        // processData: false,
        // data: formData,
    }).done(function (result) {
        var json = $.parseJSON(result);
        var statusCode = json.status_code;
        var statusMessage = json.status_message;
        var data = json.data;

        if(statusCode != 200)
        {
            swal("Error", statusMessage, "error");
        }
    });
});
});
</script>


@endsection
