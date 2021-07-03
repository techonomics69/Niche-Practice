@extends('index')

@section('pageTitle', 'Review Requests History')

@section('content')
    <?php $dynamicAppName = 'NichePractice'; ?>
    <div id="page-wrapper" class="recipient-list">
        <div class="container-fluid dashboarbgtitle">
            <h1 class="dashboard-wrapper rep-margin-bot" style="color: black;font-weight: 600;" >Reports</h1>

            <ul class="nav nav-tabs nav-justified navmargintop dashboard-wrapper " >
                <li class="active newtabbutton"><a href="#review" data-toggle="tab" style="margin-left: 0px;color:#6d6d6d;font-weight: bold;">Review Invitations</a></li>
                <li ><a href="#one" data-toggle="tab" style="color:#6d6d6d;font-weight: bold;" class="tabbutton">Email Marketing</a></li>
                <li ><a href="#two" data-toggle="tab" style="color:#6d6d6d;font-weight: bold;" class="tabbutton">Social Media</a></li>
{{--                <li > <a href="#three"  data-toggle="tab" style="color:white;" class="tabbutton"># </a></li>--}}
{{--                <li><a href="#four"  data-toggle="tab" style="color:white;margin-right: 0px;"class="tabbutton" > #</a></li>--}}
            </ul>

<div class="tab-content dashboard-wrapper">
            <div class="dashboard-wrapper review-request-page  tab-pane fade in active" id="review"  style="background-color: white;margin-top: -13px;">
                <div class="page-head mypagehead">
                    <div class="row">
                        <div class="col-md-12" style="width: 93.5%!important;">
                            <h4 class="page-title" style="padding-top: 20px;color: #393939;
                             border-bottom: 1px solid #dedede;  margin-left: 40px;"> Review Invitations<a class="page-help" href="javascript:void(0)">
{{--                                    <i class="fa fa-question-circle-o" style="color: #7d8080;/* transform: scaleX(-1); */margin-right: 5px;"></i>--}}
{{--                                    <img class="help-info-image" src="{{ asset('public/images/information.png') }}" />--}}
                                </a></h4>
                        </div>
                    </div>


                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <div class="review-requests-subheader" style="border: none;">
                            <div class="row">
                                <div class="col-xs-6">
                                    <p style="color:#000000;padding-left: 40px;">Total Requests Sent {{ $delivered }}</p>
                                </div>
{{--                                <div class="col-xs-6">--}}
{{--                                    <h4 class="text-right">Feedback Rate: 0.0%</h4>--}}
{{--                                </div>--}}
                            </div>
                        </div>

                        <div class="row request-send-box" style="padding-left: 40px;">
                            <div class="col-xs-5 col-md-2 col-sm-2 review-status-box" style="padding-left: 15px;">
                                <div class="listing-box" style="border: 3px solid black;">
                                        <label>Delivered</label>
                                        <h3>{{ $delivered }}</h3>
                                    </div>
                            </div>
                            <div class="col-xs-1 no-padding">
                                <div class="p-box">
                                    <div class="box-arrow-img">0%</div>
                                </div>

                            </div>

                            <div class="col-xs-5 col-md-2 col-sm-2 review-status-box">
                                <div class="listing-box" style="border: 3px solid black;">
                                    <label>Opened</label>
                                    <h3>{{ $open }}</h3>
                                </div>
                            </div>

                            <div class="col-xs-1 no-padding">
                                <div class="p-box">
                                    <div class="box-arrow-img">0%</div>
                                </div>

                            </div>
                            <div class="col-xs-5 col-md-2 col-sm-2 review-status-box click-box box-bottom-two">
                                <div class="listing-box" style="border: 3px solid black;">
                                    <label>Click</label>
                                    <h3>{{ $click }}</h3>
                                </div>
                            </div>
                            <div class="col-xs-1 no-padding">
                                <div class="p-box">
                                    <div class="box-arrow-img">0%</div>
                                </div>

                            </div>
                            <div class="col-xs-5 col-md-2 col-sm-2 review-status-box box-bottom-two">
                                <div class="review-status-box">
                                    <div class="listing-box"style="border: 3px solid black;">
                                        <label>Negative Feedback</label>
                                        <h3>{{ $negativeFeedback }}</h3>
                                    </div>
                                </div>

                            </div>








                            <!--<div class="business-listing-stats">
                                <div class="col-md-3">
                                    <div class="listing-box">
                                        <h5>Listed</h5>
                    <h3 class="listed">120</h3>
                    <label>Across 155 possible directories.</label>

                                    </div>


                                </div>
                                <div class="col-md-3">
                                    <div class="listing-box">
                                        <h5>Incorrect</h5>
                                        <h3 class="incorrect-listing">4</h3>
                                        <label>Update with correct info.</label>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="listing-box">
                                        <h5>Not Listed</h5>
                                        <h3 class="not-listed">25</h3>
                                        <label>Can be created.</label>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="listing-box">
                                        <h5>Duplicate</h5>
                                        <h3 class="duplicate-listing">2</h3>
                                        <label>Directories have duplicate entries.</label>

                                    </div>
                                </div>

                            </div>-->



                        </div>

                        <div class="white-box full-page-view" style="background-color: white">
                            <div class="page-content">
                                <div class="section">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-content">
                                                <div class="table-body">
                                                    <div class="table-responsive">
                                                        <div class="recipient-stats" style="display:none; min-width: 40px !important; padding-left: 0px; padding-right: 10px !important; display: flex; float: right; justify-content: flex-end;">
                                                            <span id="info_cont"></span>
                                                            <span id="pagination_cont"></span>
                                                        </div>
                                                        <table id="recipient-list" class="table custom-table" style="border: none;">
                                                            <thead>
                                                            <tr style="background: #f9f9f9;">
                                                                <th>
                                                            <span>Date Sent</span>
                                                                </th>
                                                                <th>
                                                            <span>Type</span>
                                                                </th>
                                                                <th>
                                                            <span>Contact Info</span>
                                                                </th>
                                                                <th>
                                                            <span>Name</span>
                                                                </th>
                                                                <th>
                                                            <span data-trigger="hover" data-container="body" data-toggle="popover" data-placement="auto right"
                                                                  data-content="This shows if Smart Routing was enabled for this recipient. If enabled, {{$dynamicAppName}} automatically routes the recipient to the review site that needs more reviews and higher rating.">Smart Routing
                                                            <i class="mdi mdi-information-outline" style="font-size: 18px;margin-left: 3px;"></i>
                                                            </span>
                                                                </th>
                                                                <th>
                                                                <span>Site Reviewed</span>
                                                                </th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @if(!empty($records))
                                                                @foreach($records as $record)
                                                                    <tr>
                                                                        <td style="min-width: 100px !important;">{{ $record['date_sent'] }}</td>
                                                                        <td style="min-width: 60px !important;">
                                                                            @if(empty($record['type']))
                                                                                N/A
                                                                            @else
                                                                                @if($record['type']=='email')
                                                                                    Email
                                                                                @elseif($record['type']=='sms')
                                                                                    SMS
                                                                                @endif
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if($record['type']=='email')
                                                                                <span>{{ $record['email'] }} <!-- text-info --></span>
                                                                            @elseif($record['type']=='sms')
                                                                                <span>{{ $record['phone_number'] }}</span>
                                                                            @else
                                                                                N/A
                                                                            @endif
                                                                        </td>
                                                                        <td>{{ $record['first_name'] }} {{ $record['last_name'] }}</td>
                                                                        <td style="min-width: 115px !important;">
                                                                            @if($record['smart_routing'] == 'enable')
                                                                                <span class="label label-success">YES</span>
                                                                            @else
                                                                                <span class="label label-default">No</span>
                                                                            @endif
                                                                        </td>
                                                                        <td style="">
                                                                            @if(!empty($record['site']))
                                                                                <div class="site-label">
                                                                                    <?php
                                                                                    $site = getThirdPartyTypeShortToLongForm($record['site']);
                                                                                    $reviewType = str_replace(" ", "", strtolower($site));

                                                                                    if($site == 'Google Places')
                                                                                    {
                                                                                        $site = 'Google';
                                                                                    }
                                                                                    ?>
                                                                                        <img src="{{ asset('public/images/icons/'.$reviewType.'-large.png') }}"/>

                                                                                    {{ $site }}
                                                                                </div>
                                                                            @else
                                                                                <div class="site-label awaiting">
                                                                                    <i class="mdi mdi-clock"></i>  Awaiting Response
                                                                                </div>
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    <div class="tab-pane fade" id="one" style="position: relative;top: -13px;">
{{--        <div style="background-color: white">--}}
{{--            <h1 class="text-center">Email Marketing</h1>--}}
{{--        </div>--}}

{{--        <div class="row email-spacing-top-bot " style="margin-top: 30px;margin-bottom: 40px; " >--}}
{{--            <div class="col-sm-6 col-xs-8 text-xs-center">--}}
{{--                <h4 class="page-title page-title1">Email Performance</h4>--}}
{{--            </div>--}}
{{--        </div>--}}

        <div {{--class="d-table"--}} style="background-color: white;margin-top: 20px;margin-bottom: 20px; " >
            <h4 class="page-title page-title1" style="color: #393939;
    border-bottom: 1px solid #dedede;
    margin-left: 40px!important;padding-top: 20px; margin-right: 40px!important;">Email Marketing</h4>
            <div class="table-responsive" style="padding-left: 40px;padding-right: 40px;">
                <div id="t-new-email-campaigns-logs_wrapper" class="dataTables_wrapper no-footer" >
                    <table id="t-email-campaigns" class="email-campaign dataTable no-footer"
                           style="width: 100%;border-top: 1px solid white;border-right:none;border-left: none;" role="grid" aria-describedby="t-email-campaigns_info">

                        <thead>
                        <tr style="height: 60px;" role="row">
                            <th tabindex="0" aria-controls="customers-list" rowspan="1" colspan="1" style="width: 250px;">
                                <span>Name</span>
                            </th>
                            <th tabindex="0" aria-controls="customers-list" rowspan="1" colspan="1" style="width: 450px;">
                                <span>Email</span>
                            </th>
                            <th tabindex="0" aria-controls="" rowspan="1" colspan="1" style="width: 300px;">
                                <span>Email sent at</span>
                            </th>
                        </tr>
                        </thead>

                        <tbody>
                        @if(!empty($templateLogs))
                            @foreach($templateLogs as $campaign)
                                <?php
                                $toName = $campaign['name'];
                                $toEmail = $campaign['email'];
                                $sendCreated = $campaign['created_at'];
                                ?>
                                <tr role="row" class="odd">
                                    <td>
                                        {{ $toName }}
                                    </td>

                                    <td class="text-verticle-align">
                                        <div class="email-column">
                                            {{ $toEmail }}
                                        </div>
                                    </td>

                                    <td>
                                        {{ $sendCreated }}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <td colspan="3" style="text-align: center;">No email sent record found.</td>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>
    <div class="tab-pane fade" id="two" style="position: relative;top: -13px;">
        <div style="background-color: white;">
            <h4 class="page-title page-title1" style="color: #393939;
    border-bottom: 1px solid #dedede;
    margin-left: 40px!important;padding-top: 20px; margin-right: 40px!important;margin-bottom: 20px;">Social Media</h4>
        </div>

    </div>
{{--    <div class="tab-pane fade" id="three">--}}


{{--    </div>--}}
{{--    <div class="tab-pane fade" id="four">--}}


{{--    </div>--}}

</div>

{{--            <div class="row dashboard-wrapper tabcontent email-spacing-top-bot " >--}}
{{--                <div class="col-sm-6 col-xs-8 text-xs-center">--}}
{{--                    <h4 class="page-title page-title1">Email Performance</h4>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="col-sm-12 dashboard-wrapper tabcontent">--}}
{{--                <div --}}{{--class="d-table"--}}{{-- STYLE="background-color: white;" >--}}
{{--                    <div class="table-responsive">--}}
{{--                        <div id="t-new-email-campaigns-logs_wrapper" class="dataTables_wrapper no-footer" >--}}
{{--                            <table id="t-email-campaigns" class="email-campaign dataTable no-footer"--}}
{{--                                   style="width: 100%;border-top: 1px solid white;border-right:none;border-left: none;" role="grid" aria-describedby="t-email-campaigns_info">--}}

{{--                                <thead>--}}
{{--                                <tr style="height: 60px;" role="row">--}}
{{--                                    <th tabindex="0" aria-controls="customers-list" rowspan="1" colspan="1" style="width: 250px;">--}}
{{--                                        <span>Name</span>--}}
{{--                                    </th>--}}
{{--                                    <th tabindex="0" aria-controls="customers-list" rowspan="1" colspan="1" style="width: 450px;">--}}
{{--                                        <span>Email</span>--}}
{{--                                    </th>--}}
{{--                                    <th tabindex="0" aria-controls="" rowspan="1" colspan="1" style="width: 300px;">--}}
{{--                                        <span>Email sent at</span>--}}
{{--                                    </th>--}}
{{--                                </tr>--}}
{{--                                </thead>--}}

{{--                                <tbody>--}}
{{--                                @if(!empty($templateLogs))--}}
{{--                                    @foreach($templateLogs as $campaign)--}}
                                        <?php
//                                        $toName = $campaign['name'];
//                                        $toEmail = $campaign['email'];
//                                        $sendCreated = $campaign['created_at'];
                                        ?>
{{--                                        <tr role="row" class="odd">--}}
{{--                                            <td>--}}
{{--                                                {{ $toName }}--}}
{{--                                            </td>--}}

{{--                                            <td class="text-verticle-align">--}}
{{--                                                <div class="email-column">--}}
{{--                                                    {{ $toEmail }}--}}
{{--                                                </div>--}}
{{--                                            </td>--}}

{{--                                            <td>--}}
{{--                                                {{ $sendCreated }}--}}
{{--                                            </td>--}}
{{--                                        </tr>--}}
{{--                                    @endforeach--}}
{{--                                @else--}}
{{--                                    <td colspan="3" style="text-align: center;">No email sent record found.</td>--}}
{{--                                @endif--}}
{{--                                </tbody>--}}
{{--                            </table>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

        </div>
    </div>

    @include('layouts.crm-customers.crm-add-customers-modals')

@endsection

@section('css')
    <link type="text/css" rel="stylesheet" href="{{ asset('public/plugins/bootstrap-select/bootstrap-select.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('public/plugins/datatables/jquery.dataTables.min.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('public/css/reviews-recipient/reviews-recipient.css?ver='.$appFileVersion) }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('public/css/crm-customers/crm_modals.css?ver='.$appFileVersion) }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('public/plugins/toastr/toastr.min.css?ver='.$appFileVersion) }}">
    <style>
        .rep-margin-bot{
            margin-bottom: 70px!important;
        }
        .page-title1{
            margin: 0px 0!important;
        }
        .mypagehead{
            margin: 0px 0!important;
        }
        #dw{
            margin: 0 0!important;
        }
        @media screen and (max-width:600px){
            .rep-margin-bot {
                margin-bottom: 15px!important;
            }
            .email-spacing-top-bot{
                margin-bottom: 20px !important;
            }
        }

        .navmargintop{
            margin-top: 15px;
        }
        .nav-tabs.nav-justified>.active>a, .nav-tabs.nav-justified>.active>a:focus, .nav-tabs.nav-justified>.active>a:hover {
            border-bottom-color: #fff;
            background: #e8e6e7;
            color:#6d6d6d!important;
        }
        li.bgcolor{
            background-color: white;
        }
        .nav-tabs.nav-justified>li>a {
            border-bottom: 1px solid #ddd;
            border-radius: 4px 4px 0 0;
            /* margin: 10px; */
            margin-right: 4px;
            margin-left: 4px;
            background: white;
        }
        .nav-tabs li.active a {
            /* color: #000000 !important; */
            border: none !important;
            border-bottom: none!important;
            background: none;
        }

    </style>
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('public/plugins/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('public/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/plugins/toastr/toastr.min.js?ver='.$appFileVersion) }}"></script>
    <script>
        $('.tabbutton').click(function(){
            $('.tabcontent').hide();




        });
        $('.newtabbutton').click(function(){
            $('.tabcontent').show();




        });

    </script>

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
        // console.log(enable_get_reviews);

        var internationalCallingCountryCodes = '<?php echo json_encode(internationalCallingCountryCodes()); ?>';
        internationalCallingCountryCodes=JSON.parse(internationalCallingCountryCodes);

        var businessName= "<?php  echo $userData['business'][0]['practice_name']; ?>";
        // console.log(businessName);

        var HowtoSendReviewRequestsTooltip= "<?php  echo  $HowtoSendReviewRequestsTooltip; ?>";
        // console.log(HowtoSendReviewRequestsTooltip);
        var smartRoutingTooltip= "<?php  echo $smartRoutingTooltip; ?>";
        // console.log(smartRoutingTooltip);
    </script>

    <script type="text/javascript" src="{{ asset('public/js/crm-customers/crm-customers.js?ver='.$appFileVersion) }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/recipient/reviews-recipient.js?ver='.$appFileVersion) }}"></script>
@endsection
