@extends('index')

@section('pageTitle', 'Get More Reviews')

@section('content')
    <?php $dynamicAppName = 'NichePractice'; ?>
    <div id="page-wrapper" class="customers-list add-customer-page">
        <div class="container-fluid dashboarbgtitle">
            <div class="dashboard-wrapper" >
                <div class="page-head">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="page-title">Get More Reviews <a class="page-help" href="javascript:void(0)"><i class="fa fa-question-circle-o" style="color: #7d8080;/* transform: scaleX(-1); */margin-right: 5px;"></i></a></h4>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <div class="get-more-reviews-container">
                            <div class="g-m-r-buttons">
                                <div class="col-md-10 col-md-offset-1">
                                    <h3 class="gmr-heading text-center">Get your practice more five star customer reviews and control your online reputation.</h3>
                                    <p class="g-m-r-desc">
                                        Simply add your patient email addresses or phone numbers into our platform and it will automatically send a review request each patient via email or text message.
                                    </p>


                                        {{-- <div id="upload_customer_file" class="patient-box">
                                            <div class="gmr-icons">
                                                <img src="{{ asset('public/images/gmr-customize.gif') }}" />
                                            </div>

                                            <label>
                                                Customized Invitations
                                            </label>
                                        </div> --}}


                                        <div id="add_contact_button" class="patient-box">
                                            <div class="gmr-icons">
                                                <img src="{{ asset('public/images/gmr-single.gif') }}" />
                                            </div>
                                                <label>
                                                    Send a Single Invite
                                                </label>
                                        </div>


                                        <div id="upload_CSV_button" class="patient-box">
                                            <div class="gmr-icons">
                                                <img src="{{ asset('public/images/gmr-multiple.png') }}" />
                                            </div>
                                                <label>
                                                    Send Multiple Invites
                                                </label>
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

    <input type="hidden" id="currentPage" value="get_more_reviews" />
    <input type="hidden" id="viewedSendReviewInviteSettings" value="{{ $viewedSendReviewInviteSettings }}" />
@endsection

@section('css')
    <link type="text/css" rel="stylesheet" href="{{ asset('public/plugins/bootstrap-select/bootstrap-select.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('public/plugins/datatables/jquery.dataTables.min.css') }}" />
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/select/1.2.1/css/select.dataTables.min.css" />
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/scroller/2.0.0/css/scroller.dataTables.min.css" />
    <link type="text/css" rel="stylesheet" href="{{ asset('public/plugins/toastr/toastr.min.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('public/css/crm-customers/crm-customers.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('public/css/crm-customers/crm_modals.css?ver='.$appFileVersion) }}" />
    <style>
        /*#countryCodesList{*/
            /*opacity: 1;*/
        /*}*/
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
        #main-modal .slimScrollBar{
            height: 0% !important;
        }
        #main-modal .slimScrollRail{
            height: 100% !important;
        }
        #main-modal .slimScrollDiv{
            height: 100% !important;
        }
        #main-modal .description-notify{
            height: 100% !important;
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
    <script type="text/javascript" src="{{ asset('public/plugins/bootstrap-select/bootstrap-select.js') }}"></script>
    {{--<script src="{{ asset('public/js/plugins/datatables/jquery.dataTables.min.js?ver='.$version) }}"></script>--}}
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/select/1.2.1/js/dataTables.select.min.js"></script>

    <script src=" https://cdn.datatables.net/scroller/2.0.0/js/dataTables.scroller.min.js"></script>

    <script type="text/javascript" src="{{ asset('public/plugins/toastr/toastr.min.js') }}"></script>

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
@endsection
