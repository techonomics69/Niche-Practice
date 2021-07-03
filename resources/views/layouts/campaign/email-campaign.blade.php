@extends('index')

@section('pageTitle', 'Email Campaign')

@section('content')
    <div id="page-wrapper" style="position:relative;">
        <div class="banner-success text-center" style="display: none;"></div>

{{--        <div id="html-content-holder" style="background-color: #F0F0F1; color: #00cc65; width: 500px;padding-left: 25px; padding-top: 10px;">--}}
{{--            <strong>Codepedia.info</strong><hr/>--}}
{{--            <h3 style="color: #3e4b51;">--}}
{{--                Html to canvas, and canvas to proper image--}}
{{--            </h3>--}}
{{--            <p style="color: #3e4b51;">--}}
{{--                <b>Codepedia.info</b> is a programming blog. Tutorials focused on Programming ASP.Net,--}}
{{--                C#, jQuery, AngularJs, Gridview, MVC, Ajax, Javascript, XML, MS SQL-Server, NodeJs,--}}
{{--                Web Design, Software</p>--}}
{{--            <p style="color: #3e4b51;">--}}
{{--                <b>html2canvas</b> script allows you to take "screenshots" of webpages or parts--}}
{{--                of it, directly on the users browser. The screenshot is based on the DOM and as--}}
{{--                such may not be 100% accurate to the real representation.--}}
{{--            </p>--}}
{{--        </div>--}}
{{--        <input id="btn-Preview-Image" type="button" value="Preview"/>--}}
{{--        <a id="btn-Convert-Html2Image" href="#">Download</a>--}}
{{--        <br/>--}}
{{--        <h3>Preview :</h3>--}}
{{--        <div id="previewImage">--}}
{{--        </div>--}}

        <div class="container-fluid dashboarbgtitle">
            <div class="dashboard-wrapper campaign-builder-page">
                <div class="page-head">
                    <div class="row">
                        <div class="col-md-6">
{{--                            @if($_Get['type_source'])--}}
                            @if(!empty($_GET['type_source']) && $_GET['type_source'] == 'patient')
                                <h4 class="page-title">Patient Email Template</h4>
                            @else
                                <h4 class="page-title">Email Campaign</h4>
                            @endif
                        </div>
                    </div>
                </div>

                {{--<div style="border:red solid 2px; margin: 25px;">--}}
                    {{--<input type="text" id="datepicker" class="date-picker" width="210" readonly>--}}
                {{--</div>--}}

                <div class="col-md-12 steps-nav" style="display: none;">

                    <div class="col-md-1">
                        <a href="javascript:void(0)" class="btn btn-default back-action-btn" style="padding-left: 30px;padding-right: 30px;">Back</a>
                    </div>

                    <div class="col-md-8 text-center campaign-steps-container">
                        <div class="campaign-steps">
                                    <span>
                                        <a class="active" data-action="create">1. Create</a>
                                        <i class="fa fa-angle-right"></i>
                                    </span>

                            <span><a class="" data-action="add-recipients-container">2. Add Recipients</a><i class="fa fa-angle-right"></i></span>
                            <span><a href="javascript:void(0);" class="" data-action="publish-container">3. PUBLISH &amp; SEND</a></span>
                        </div>
                    </div>

                    <div class="col-md-3 action-center action-center-new" style="display: none;">
                        <button class="btn btn-primary import-action" id="upload_CSV_button">
                            <img src="{{ asset('public/images/import-arrow.png') }}" />
                            Import Contacts
                        </button>
                        <button class="btn btn-primary save-action">Continue</button>
                        <button class="btn btn-primary save-current-state">Save</button>
                    </div>
                </div>

                <div class="loading-bar" style="text-align: center;margin-top: 50px; display: block;">
                    <span class="loading-text" style="font-size: 15px;font-weight: 700;display: block;">Loading Template...</span>
                    <img src="{{ asset('public/images/Loading-bar.gif') }}">
                </div>

                <div class="row">
                    <div class="col-md-12" >
                        <div id="app" class="create steps-section" style=" width: 100%; height: 100vh; display: block;"></div>

                        @include('layouts.crm-customers.customers-list-selection')

                        <div class="steps-section publish-container col-md-12 col-md-offset-0" style="display: none;">
                            <div class="col-md-1"></div>

                            <div class="publish-section col-md-6" style="/* padding-right: 0; */padding-left: 0;margin-left: 60px;">
                                <div class="alert text-danger text-center" style="display: none;">
                                    You have not select any recipients. select recipients from previous tab to use below functionality
                                </div>


                                <div class="modal-head">
                                    <h3>Publish and Send</h3>
                                    <p>Add the final sending details and choose when to publish your campaign</p>
                                </div>

                                <div class="form-group">
                                    <label for="">Subject Line</label>
                                    {{--<span class="words-count" style="display: none;">20/211</span>--}}
                                    <div class="input-group">
                                        <input id="subject" type="text" class="form-control" placeholder="Write a Catchy Header Here!">
                                        {{--<span class="input-group-btn" style="display: none;"><button class="btn btn-default" type="button"><i class="fa fa-plus"></i>Add Dynamic Value</button></span>--}}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="">From Name</label>
                                    <input id="from" type="text" class="form-control" placeholder="Add a recognizable sender's name, like the name of your business.">
                                    <div class="note-message">
                                        If this will empty then your practice name will be use in email from name. <strong>{{ $userData['business'][0]['practice_name'] }}</strong>
                                    </div>
                                </div>
{{--                                <div class="form-group">--}}
{{--                                    <label for="">Reply-to Email</label>--}}
{{--                                    --}}{{--<a href=""><i class="mdi mdi-information-outline"></i></a>--}}
{{--                                    <input id="reply-email" type="text" class="form-control" placeholder="Choose the email address that people reply to your email.">--}}

{{--                                    <div class="note-message">--}}
{{--                                        Recipients will reply to this email address, but your campaign will be sent from <strong>support@nichepractice.com</strong>--}}
{{--                                        --}}{{--<a href="">Learn more</a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

                                <div class="form-group">
                                    <div class="note-message"><strong>Your campaign will be sent from <strong>support@nichepractice.com</strong></strong></div>
                                </div>

                                <div class="publish-footer">
                                    <button type="button" class="btn btn-schedule">Schedule</button>
                                    <button type="button" class="btn btn-sendnow">Send Now</button>
                                </div>

                                <div class="modal-terms-text">
                                    <p>By hitting 'Schedule' or 'Send Now', you agree to the <a href="javascript:void(0);">Terms</a></p>
                                </div>
                            </div>

                            <div class="stats col-md-4 pull-right">
                                <div class="stat-box" style="">
                                    <label>Total recipients:</label>

                                    <?php
                                    $maximum = 2000;
                                    $remaining = 2000;
                                    ?>
                                    @if(!empty($emailrequestlogs->maximum) && !empty($emailrequestlogs->remaining))
                                        <?php
                                        $maximum = $emailrequestlogs->maximum;
                                        $remaining = $maximum - $emailrequestlogs->used;
                                        ?>
                                    @endif


                                <h3 id="email-campaign-total-recipients"></h3>

                                    <div class="limit-progress">
                                        <div class="left">Sending limit</div><div class="total-email-limit right">{{ $maximum - $remaining }}/{{ $maximum }}</div>

                                        <div class="w-progress-section col-md-12">

                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:0%">
                                                    <span class="sr-only">70% Complete</span>
                                                </div>
                                            </div>
                                        </div>
                                        <p style="font-size: 14px;display: block;float: left;margin-top: 10px;color: #8ea6c1;">
                                            {{ $remaining }} sends remaining for this month. In order to get more emails sends you'll need to <a href="{{ route('upgrade') }}" style="color: #5ea8bf;">upgrade</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

{{--    <div style="display: block;" id="capture" class="frame-container">--}}
{{--    </div>--}}

    @include('layouts.crm-customers.crm-add-customers-modals')
    <input type="hidden" id="currentPage" value="email_campaign_builder" />
@endsection

@section('css')
    <link type="text/css" rel="stylesheet" href="{{ asset('public/plugins/bootstrap-select/bootstrap-select.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('public/plugins/datatables/jquery.dataTables.min.css') }}" />
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/select/1.2.1/css/select.dataTables.min.css" />

    <link type="text/css" rel="stylesheet" href="{{ asset('public/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('public/plugins/toastr/toastr.min.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('public/css/crm-customers/crm-customers.css?ver='.$appFileVersion) }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('public/css/crm-customers/crm_modals.css?ver='.$appFileVersion) }}" />
    <style>
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
        .connect-me
        {
            background: #3D4A9E !important;
            border: 1px solid #3D4A9E !important;
        }
        .table-condensed>tbody>tr>td, .table-condensed>tbody>tr>th, .table-condensed>tfoot>tr>td, .table-condensed>tfoot>tr>th, .table-condensed>thead>tr>td, .table-condensed>thead>tr>th
        {
            line-height: 0;
        }
        .datepicker .datepicker-switch, .datepicker .next, .datepicker .prev, .datepicker tfoot tr th {
            cursor: pointer;
            font-weight: bold;
            color: #000000;
        }

        .custom-checkbox:hover {
            background-color: #daeffe;
        }
        .custom-checkbox {
            position: relative;
            display: inline-block;
            width: 16px;
            height: 16px;
            cursor: pointer;
            border: 1px solid #c6e2f7;
            border-radius: 4px;
            background-color: #fff;
            transition: .2s ease background-color;
        }
        .custom-checkbox:after {
            position: absolute;
            top: 50%;
            right: 0;
            bottom: 0;
            left: 50%;
            margin: -3px 0 0 -4px;
            -webkit-transform: scale(0);
            transform: scale(0);
            transition: .2s ease -webkit-transform;
            transition: .2s ease transform;
            content: ' ';
            display: inline-block;
            vertical-align: middle;
            background: url('https://static.parastorage.com/services/shoutout-static/1.2316.0/images/icons/ic-checkbox-checked.png') center center;
            width: 8px;
            height: 6px;
        }
        .custom-checkbox--checked:after {
            -webkit-transform: scale(1);
            transform: scale(1);
        }
        .contact-input-container
        {
            margin-bottom: 36px;
        }
        .contacts-input {
            min-height: 54px;
            max-height: 96px;
            overflow: hidden;
            border: 1px solid #c1e4fe;
            border-radius: 7px;
            background-color: #fff;
        }
        .text-success {
            color: #3c763d !important;
            /*font-size: 16px;*/
        }
        .contacts-input__label {
            font-size: 16px;
            color: #20455e;
            font-weight: 400;
            float: left;
            margin: 17px 12px 0 16px;
        }
        .contacts-input__input-wrapper {
            padding-top: 10px;
            overflow: auto;
            max-height: 100px;
        }
        .decipher-tags {
            display: flex;
            -webkit-flex-wrap: wrap;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            overflow-y: auto;
            overflow-x: hidden;
            word-wrap: break-word;
        }
        .decipher-tags .tag-wrapper {
            -webkit-flex: 0 0 auto;
            -ms-flex: 0 0 auto;
            flex: 0 0 auto;
            max-height: 31px;
            margin-bottom: 10px;
            margin-right: 10px;
        }
        .decipher-tags .decipher-tags-tag {
            background-color: #f0f4f7;
            border-radius: 5px;
            overflow: hidden;
        }
        .decipher-tags .tag-wrapper--input {
            -webkit-flex: 1 0 360px;
            -ms-flex: 1 0 360px;
            flex: 1 0 360px;
            height: 30px;
            margin-bottom: 10px;
        }
        .contacts-input .decipher-tags-input {
            font-size: 16px;
            line-height: 24px;
            font-weight: 400;
        }
        .decipher-tags .decipher-tags-input {
            width: 100%;
            height: 100%;
            border: none;
            background-color: transparent;
            outline: 0;
        }
        .decipher-tags .decipher-tags-tag .tag-image {
            display: inline-block;
            width: 30px;
            height: 30px;
            margin-right: 8px;
            background: url('https://static.parastorage.com/services/shoutout-static/1.2316.0/images/contacts/recipients-tag-contact.png') 50% 50% no-repeat;
            vertical-align: middle;
        }
        .decipher-tags .decipher-tags-tag .tag-image img {
            width: 100%;
            height: auto;
        }
        .decipher-tags .decipher-tags-tag .tag-text {
            display: inline-block;
            max-width: 400px;
            font-family: "Helvetica Neue",Arial;
            font-size: 14px;
            color: #555;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            vertical-align: middle;
        }
        @media only screen and (max-width: 900px){
            .action-center-new{
        display: flex;
        margin-top: 10px;
        justify-content: center;
            }
        }

        /*@media only screen and (max-width: 600px){*/
        /*    .action-center-new{*/
        /*        margin-top: 10px;*/
        /*        background-color: white;*/
        /*        height: 68px;*/
        /*    }*/
        /*    }*/

    </style>
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('public/plugins/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/select/1.2.1/js/dataTables.select.min.js"></script>
{{--    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
    <script>
        $(document).ready(function(){

            // var getCanvas; // global variable
            //
            // $(document).on('click', '#btn-Preview-Image', function () {
            //     // var body = $("iframe").contents().find('body')[0];
            //     var element = $(".frame-container div").first();
            //     console.log("clicked");
            //     console.log(element);
            //
            //     // working
            //     html2canvas(element, {
            //             scale: 2,
            //             allowTaint: true,
            //             logging: true,
            //             taintTest: false,
            //             onrendered: function( canvas ) {
            //                 $("#previewImage").append(canvas);
            //                 getCanvas = canvas;
            //             },
            //         });
            //
            //     //     html2canvas(element, {
            //     //     onrendered: function (canvas) {
            //     //         $("#previewImage").append(canvas);
            //     //         getCanvas = canvas;
            //     //     }
            //     // });
            // });
            //
            $("#btn-Convert-Html2Image").on('click', function () {
                var imgageData = getCanvas.toDataURL("image/png");
                // Now browser starts downloading it instead of just showing it
                var newData = imgageData.replace(/^data:image\/png/, "data:application/octet-stream");
                $("#btn-Convert-Html2Image").attr("download", "your_pic_name.png").attr("href", newData);
            });
        });
    </script>

     <?php
     $userLOg = json_encode($userData);
     echo '<script> var userData = '. $userLOg .'; var userId = '. $userId .'; var templateId; var editorUserId; </script>'; ?>

     @if(!empty($templateId))
     <?php
            echo '<script> templateId = '. $templateId .'</script>';
     ?>
     @endif

    @if($appEnvIs == 'production')
        <?php
        $domain = explode('@',$userEmail)[1];

        if($domain == 'mailinator.com' || $domain == 'nichepractice.com')
        {
            echo '<script> editorUserId = 1 </script>';
        }
        else
        {
            echo '<script> editorUserId = '. $userId .'</script>';
        }
        ?>
    @else
    <?php
    echo '<script> editorUserId = 1 </script>';
    ?>
    @endif


    @if(!empty($_GET['save_type']) && $_GET['save_type'] == 'click')
        <script>
            $(function () {
                $('#app iframe').on("load", function() {
                    setTimeout(function () {
                        // console.log("Second iframe loaded > ");
                        $(".save-current-state").click();
                    }, 3000);
                });
            });
        </script>
    @endif

    <script type="text/javascript" src="{{ asset('public/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('public/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>

{{--    <script src="https://d5aoblv5p04cg.cloudfront.net/editor/loader/build.js" type="text/javascript"></script>--}}

    <script src="https://d5aoblv5p04cg.cloudfront.net/mjml4-editor/loader/build.js" type="text/javascript"></script>

     <script src="{{ asset('public/js/campaign-manager.js?ver='.$appFileVersion) }}"></script>
     <script type="text/javascript" src="{{ asset('public/js/crm-customers/crm-customers.js?ver='.$appFileVersion) }}"></script>
@endsection
