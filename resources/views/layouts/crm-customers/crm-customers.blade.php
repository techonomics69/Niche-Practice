@extends('index')

@section('pageTitle', 'Patients List')

@section('content')
    <?php $dynamicAppName = 'NichePractice'; ?>
    <div id="page-wrapper" class="customers-list">
        <div class="container-fluid dashboarbgtitle">
            <div class="dashboard-wrapper" >
                <div class="page-head page-header">

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="heading customers-heading">
                                <h2 class="customers-header page-title">Patients List
{{--                                    <a class="page-help" href="javascript:void(0)">--}}
{{--                                        <i class="fa fa-question-circle-o" style="color: #7d8080;/* transform: scaleX(-1); */margin-right: 5px;"></i>--}}
{{--                                        <img class="help-info-image" src="{{ asset('public/images/information.png') }}" />--}}

{{--                                    </a>--}}
                                </h2>
                                    <span style="color: #000000; margin-left: 15px;font-weight: 600;">
                                        <span id="total_customers">0</span> <span id="total_customers_text"> Total customers</span></span>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="header-right" style="padding-top: 0px;">
                                {{--<a href="{{ route('reviews-recipients') }}" class="btn btn-default header-info-btn"><i class="fa mdi mdi-star" aria-hidden="true" style="font-size: 14px;"></i> Review Requests History</a>--}}

                                <div class="form-group">
                                    <div class="user-search">
                                        <span class="search-user"><i class="search-user mdi mdi-magnify" aria-hidden="true"></i></span>
                                        <input id="searchRecords" type="text" class="search-user form-control" placeholder="Search for Name, Email, Phone">
                                        <span class="closeSearch hide"><i class="fa fa-times" aria-hidden="true"></i></span>
                                    </div>
                                </div>

                                <div class="form-inline">
                                    <div class="form-group hide">
                                        <button id="delete_customers_button" class="btn btn-default header-info-btn hide">
                                            <i class="fa fa-trash-o" aria-hidden="true" style="font-size: 14px;"></i>
                                            {{--Selected (<span id="num_selected_records"></span>)--}}
                                        </button>
                                    </div>

                                    <div class="form-group">
                                        <button id="upload_CSV_button" class="btn btn-default header-primary-btn">Import File
{{--                                            <i class="mdi  mdi-upload" aria-hidden="true"></i>--}}
                                        </button>
                                    </div>

                                    <div class="form-group">
                                        <button id="add_contact_button" class="btn btn-info header-primary-btn">
{{--                                            <i class="mdi  mdi-plus"></i>--}}
                                            Add Contact</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-8"></div>
                    </div>


                    {{--<div class="row">--}}
                        {{--<div class="col-md-6">--}}
                            {{--<h4 class="page-title">Customer List</h4>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="page-content box1">
                            <div class="section">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-content">
                                            <div class="table-body">
                                                <div class="table-responsive">
                                                    <div class="overflow-x">
                                                      <table id="customers-list" class="table custom-table"
                                                           style="border: none;">
                                                        <thead>
                                                        <tr style="height: 60px;background: #EDEFF1;">
                                                            <th></th>
                                                            <th>
                                                                <span>Name</span>
                                                            </th>
                                                            <th style="display: none;">
                                                                    <span data-trigger="hover" data-container="body"
                                                                          data-toggle="popover"
                                                                          data-placement="auto right"
                                                                          data-content="This is the last name of the customer.">Last Name</span>
                                                            </th>

                                                            <th>
                                                                <span>Email Address</span>
                                                            </th>
                                                            <th>
                                                                <span>Phone Number</span>
                                                            </th>
                                                            <th>
                                                                <span>Created</span>
                                                            </th>
                                                            {{--<th>--}}
                                                            {{--<span id="info_cont"></span>--}}
                                                            {{--<span id="pagination_cont"></span>--}}
                                                            {{--</th>--}}
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
                        <div class="page-content box2">

                            <div class="email-campaign-new">
                                {{--                            mycode--}}
                                <div class="campaign-content1">
                                    <div class="text-center">
                                        <img style="width: 130px;" src="{{ asset('public/images/icons/add-contact.png') }}" />
                                    </div>

                                    {{--                            mycode--}}


{{--                                    <h3 class="text-center" style="font-weight: bold;" >You do not have any campaigns</h3>--}}
                                    <h3 class="text-center" style="font-weight: bold;" >You do not have any contacts </h3>
{{--                                    <p class="once text-center ">Start a new campaign by clicking on the "Create a campaign" button at the top right of the screen.</p>--}}
                                    <p class="once text-center ">Start adding your contacts by uploading a file or add them one at a time.</p>
{{--                                    <div class="ondiv">--}}
{{--                                        <p class="on">1. Almost all marketing campaigns / checklists include unique email campaigns in your monthly strategy.</p></div>--}}
{{--                                        <a href="https://nichepractice.com/nichepractice/what-you-can-do-with-your-patient-data/" target="_blank" style="text-decoration: underline;">--}}
{{--                                            <p class="on">What You Can Do With Your Patient Data</p>--}}
{{--                                        </a>--}}
{{--                                    </div>--}}
                                    <div class="todiv">
{{--                                        <p class="to" >2. If you choose to send additional emails, outside of your marketing checklist, click the Create a <br class="d-lg-inline-block  d-none">  Campaign button and select/edit any of the emails in our portfolio.</p></div>--}}
                                        <a href="https://nichepractice.com/nichepractice/how-to-export-your-patient-list-from-your-current-software/" target="_blank" style="text-decoration: underline;">
                                            <p class="to" >How to Export Your Patient List From Your Current Software</p>
                                        </a>
                                    </div>
{{--                                    <div class="campaigns-link text-center ">--}}
{{--                                           <button class="btn btn-primary cont"  style="font-weight: 600;" > Continue </button>--}}
{{--                                        <a href="#" ><p>Learn more about sending emails and your marketing strategy.</p></a>--}}

{{--                                    </div>--}}
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

    <input type="hidden" id="currentPage" value="patient_list" />
    {{ csrf_field() }}
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
        .box1{
            display: none;
        }
        .box2{
            display: none;
        }

        .campaigns-link a p{
            color: #1c339d;
            text-decoration: underline;
            font-size: 16px;
        }
        .campaign-content1{
            width: 720px;
            margin: auto;
        }
        .once{

            /*margin-left: 15%;*/
            margin-top: 10px;
            margin-bottom: 7px;
            color: #7B7C7E;

            font-size: 18px;
            /*font-family: 'Myraid';*/
        }
        .ondiv{
            /*margin-left: 15%;*/
            /*margin-right: 15%;*/
            background-color: #FFFFFF;
            color: #7b7c7e;

            padding-left:5px;
            border-left: 2px solid #565D7F;
            font-size: 16px;
        }
        .on{
            padding: 8px;
            /*font-family: 'Myraid';*/
        }
        .todiv{
            /*margin-left: 15%;*/
            /*margin-right: 15%;*/
            padding-left:5px;
            /*background-color: #FFFFFF;*/
            color: #7b7c7e;
            /*border-left: 2px solid #565D7F;*/
            font-size: 17px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .todiv:before{
            content: '';
            height: 5px;
            width: 5px;
            background-color: #1D33A1;
            border-radius: 100%;
            margin-bottom: 8px;
        }
        .to{
            padding: 8px;
        }
        .cont{
            background-color: #1D33A1;
            margin-top: 20px;
        }
        .cont:hover{
            background-color:#1b339d !important;
        }
        .cont:active{
            background-color:#1b339d !important;
        }
        .cont:focus{
            background-color:#1b339d !important;
        }
        /*.btn-primary:hover{*/
        /*    background-color:#1b339d !important;*/
        /*}*/
        /*.btn-primary:active{*/
        /*    background-color:#1b339d !important;*/
        /*}*/
        /*.btn-primary:focus{*/
        /*    background-color:#1b339d !important;*/
        /*}*/
        @media screen and (max-width: 800px){
            .campaign-content1{
                width: auto;
            }
        }
        @media only screen and (max-width:786px){
            .overflow-x{
                overflow-x:scroll;
            }
            .overflow-x::-webkit-scrollbar{
                width:5px;
                height:6px;
            }
            .overflow-x::-webkit-scrollbar-thumb{
                background-color: #888;
            }
            .overflow-x::-webkit-scrollbar-track{
                background-color: #f1f1f1;
            }
        }
    </style>
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('public/plugins/bootstrap-select/bootstrap-select.js') }}"></script>
    {{--<script src="{{ asset('public/js/plugins/datatables/jquery.dataTables.min.js?ver='.$version) }}"></script>--}}
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/select/1.2.1/js/dataTables.select.min.js"></script>

{{--    <script src=" https://cdn.datatables.net/scroller/2.0.0/js/dataTables.scroller.min.js"></script>--}}

    <script type="text/javascript" src="{{ asset('public/plugins/toastr/toastr.min.js') }}"></script>
{{--    <script>--}}
{{--        // A $( document ).ready() block.--}}
{{--        $( document ).ready(function() {--}}

{{--            var  abc  = $('span#total_customers').html();--}}
{{--            console.log(abc);--}}

{{--            if ( abc   > 1){--}}
{{--                $('.box2').css("display","block");--}}
{{--            }else{--}}
{{--                $('.box1').css("display","block");--}}
{{--            }--}}


{{--        });--}}

{{--    </script>--}}



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
