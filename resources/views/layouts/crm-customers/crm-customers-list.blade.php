@extends('master')

@section('pageTitle', 'Customers List')

@section('content')
    <?php $dynamicAppName=getDynamicAppName(); ?>
    <div id="page-wrapper" class="customers-list crm-customers-list">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="white-box full-page-view customers-list-crm">
                        <div class="page-content">
                            <div class="section">
                                <div class="page-header no-border">
                                    <div class="row">
                                        <div class="col-sm-7">
                                            <div class="heading customers-heading">
                                                <h2 class="e-customers-header">Select Recipients from Existing Customers</h2>
                                                {{--<h5 class="e-customers-tagline">Take note some of these customer in your list may have already received review requests in the past. to know which customers, checkout the Review Request colum in the table below.</h5>--}}
                                            </div>
                                        </div>
                                        <div class="col-sm-5">
                                            <div class="form-inline" style="float: right;">
                                                <div class="form-group">
                                                    <div class="user-search crr-btn">
                                                        <span class="search-user"><i class="search-user fa fa-search" aria-hidden="true"></i></span>
                                                        <input id="searchRecords" type="text" class="search-user form-control hide" placeholder="Search for Name, Email, Phone">
                                                        <span class="closeSearch hide"><i class="fa fa-times" aria-hidden="true"></i></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="crr-btn">
                                                        <a href="#"><button id="customizeReviewRequest" class="btn btn-customize-rr">Customize Review Request</button></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php echo helpTextManager('customers_list', 'Take note some of these customers in your list may have already received review requests in the past. To know which customers, checkout the Review Request column in the table below.', 'Help Guide', 'm-b-5 m-t-10 full-width'); ?>

                                    {{--@if (!empty($message))--}}
                                    {{--<div class="m-b-0 col-md-12 p-l-0 p-r-0">--}}
                                    {{--<div class="alert alert-danger">{{ $message }}</div>--}}
                                    {{--</div>--}}
                                    {{--@endif--}}
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-content">
                                            <div class="table-body">
                                                <div class="table-responsive">
                                                    <table id="customers-list" class="table custom-table" style="border: none;">
                                                        <thead>
                                                        <tr style="height: 60px;background: #EDEFF1;">
                                                            <th></th>
                                                            <th>
                                                                <span data-trigger="hover" data-container="body" data-toggle="popover" data-placement="auto right"
                                                                      data-content="This is the name of the customer.">Name</span>
                                                            </th>
                                                            <th style="display: none;">
                                                                <span data-trigger="hover" data-container="body" data-toggle="popover" data-placement="auto right"
                                                                      data-content="This is the last name of the customer.">Last Name</span>
                                                            </th>
                                                            <th>
                                                                <span data-trigger="hover" data-container="body" data-toggle="popover" data-placement="auto right"
                                                                      data-content="This is the email address of the customer.">Email Address</span>
                                                            </th>
                                                            <th>
                                                                <span data-trigger="hover" data-container="body" data-toggle="popover" data-placement="auto right"
                                                                      data-content="This is the phone number of the customer.">Phone Number</span>
                                                            </th>
                                                            <th>
                                                                <span data-trigger="hover" data-container="body" data-toggle="popover" data-placement="auto right"
                                                                      data-content="This is the created date of the customer.">Created Date</span>
                                                            </th>
                                                            <th>
                                                                <span id="info_cont"></span>
                                                                {{--<span id="pagination_cont"></span>--}}
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
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
        <!-- /.container-fluid -->
    </div>

    <!-- Modal -->
    @include('layouts.crm-customers.crm-add-customers-modals')

    <input type="hidden" id="hfBaseUrl" value="{{ URL('/') }}" />
    {{ csrf_field() }}
@endsection

@section('css')
    <?php $version=57; ?>
    <link type="text/css" rel="stylesheet" href="{{ asset('public/js/plugins/bootstrap-select/bootstrap-select.min.css?ver='.$version) }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('public/js/plugins/datatables/jquery.dataTables.min.css?ver='.$version) }}" />
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/select/1.2.1/css/select.dataTables.min.css" />
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/scroller/2.0.0/css/scroller.dataTables.min.css" />
    <link type="text/css" rel="stylesheet" href="{{ asset('public/plugins/toastr/toastr.min.css?ver='.$version) }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('public/css/crm-customers/crm-customers.css?ver='.$version) }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('public/css/crm-customers/crm_modals.css?ver='.$version) }}" />
    <style>
        /*#countryCodesList{*/
            /*opacity: 1;*/
        /*}*/

        .help-box {
            border: 1px solid #ddd !important;
        }
        .bootstrap-select.btn-group.disabled,
        .bootstrap-select.btn-group>.disabled {
            cursor: default;
        }
        .bootstrap-select.disabled button.disabled{
            background-color: #ffffff;
            cursor: default;
        }
        .bootstrap-select .filter-option{
            font-weight: 600;
        }
        .bootstrap-select.disabled .filter-option{
            font-weight: 700;
        }
        /*.btn-default:hover,*/
        /*.btn-default.disabled:hover,*/
        /*.btn-default:focus,*/
        /*.btn-default.disabled:focus,*/
        /*.btn-default.focus,*/
        /*.btn-default.disabled.focus {*/
            /*opacity: 1;*/
            /*border: 1px solid #e4e7ea;*/
            /*background: #ffffff;*/
        /*}*/
    </style>
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('public/js/plugins/bootstrap-select/bootstrap-select.min.js?ver='.$version) }}"></script>
    {{--<script src="{{ asset('public/js/plugins/datatables/jquery.dataTables.min.js?ver='.$version) }}"></script>--}}
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/select/1.2.1/js/dataTables.select.min.js"></script>

    <script src=" https://cdn.datatables.net/scroller/2.0.0/js/dataTables.scroller.min.js"></script>

    <script type="text/javascript" src="{{ asset('public/plugins/toastr/toastr.min.js?ver='.$version) }}"></script>

    <?php
    $noOfRecords=!empty($records) ? count($records) : 0;

    $HowtoSendReviewRequestsTooltip=getDynamicHowtoSendReviewRequestsTooltip();
    $smartRoutingTooltip=getDynamicSmartRoutingTooltip();

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

        var businessName= "<?php  echo  $businessList[0]['name']; ?>";
        // console.log(businessName);

        var HowtoSendReviewRequestsTooltip= "<?php  echo  $HowtoSendReviewRequestsTooltip; ?>";
        // console.log(HowtoSendReviewRequestsTooltip);
        var smartRoutingTooltip= "<?php  echo $smartRoutingTooltip; ?>";
        // console.log(smartRoutingTooltip);

    </script>

    <script type="text/javascript" src="{{ asset('public/js/crm-customers/crm-customers.js?ver='.$appFileVersion) }}"></script>
    {{--<script type="text/javascript" src="{{ asset('public/js/crm-customers/crm-customers-list.js?ver='.$version) }}"></script>--}}
@endsection