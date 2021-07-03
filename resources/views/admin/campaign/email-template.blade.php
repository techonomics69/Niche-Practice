@extends('admin.layout')

@section('title', 'Email Template')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-default">
                <div class="box-body">
                    <div class="col-sm-12 input-form" style="display: none;">
                        <h3 class="box-title">
                            @if(empty($templateId))
                                Create Email Template
                            @else
                                Edit Email Template
                            @endif
                        </h3>
                        <div class="col-sm-12">
                            <div class="col-sm-8">
                                <div class="col-sm-6 input-field">
                                    <label>Campaign Name</label>
                                    <input type="text" class="form-control" id="title" value="">
                                    <div style="margin-top: 5px;display: flex;">
                                        <input type="checkbox" id="show-in-dashboard" style="margin-right: 5px;/* padding-top: 8px; *//* float: left; *//* padding-right: 12px; */">
                                        Donot Show in Dashboard Email Campaign
                                    </div>
                                    <span class="help-block hide-me"><small></small></span>
                                </div>

                                <div class="col-sm-12 m-t-20" style="padding-left: 0px;">
                                    <div class="col-sm-4 col-md-4 col-lg-4">
                                        <label>Categories</label>
                                        <select class="form-control select2" name="category" id="category" data-selected-target="">
                                            <option value="">Select Category</option>
                                            @if(!empty($categories))
                                                @foreach($categories as $row)
                                                    <option value="{{ $row['id'] }}">{{ $row['name'] }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <span class="help-block hide-me"><small></small></span>
                                    </div>

                                    <div class="col-sm-4 col-md-4 col-lg-4">
                                        <label>Types</label>
                                        <select class="form-control select2" name="type" id="type" data-selected-target="">
                                            <option value="">Select Type</option>
                                            @if(!empty($types))
                                                @foreach($types as $row)
                                                    <option value="{{ $row['id'] }}">{{ $row['name'] }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <span class="help-block hide-me"><small></small></span>
                                    </div>

                                    <div class="col-sm-4 col-md-4 col-lg-4">
                                        <label>Campaign For User</label>
                                        <select class="form-control select2" name="campaign_for_user" id="campaign-user" data-selected-target="">
                                            <option value="">Choose user</option>
                                            @foreach($usersList as $userRec)
                                            <option value="{{ $userRec['id'] }}">{{ $userRec['email'] }}</option>
                                            @endforeach
                                        </select>
                                        <span class="help-block"><small></small></span>
                                    </div>
                                </div>

                                <div class="col-sm-12 m-t-10 p-l-0" style="padding-left: 0px;">

                                    <div class="col-sm-4 col-md-4 col-lg-4">
                                        <label>Industry</label>
                                        <select class="form-control select2" name="industry" id="industry" data-selected-target="">
                                            <option value="">Select Industry</option>
                                            @foreach($industry as $row)
                                                <option value="{{ $row['id'] }}">{{ $row['name'] }}</option>
                                            @endforeach
                                        </select>
                                        <span class="help-block hide-me"><small></small></span>
                                    </div>

                                    <div class="col-sm-4 col-md-4 col-lg-4">
                                        <label>Niche</label>
                                        <select class="form-control select2" name="niche_id" id="niche" data-selected-target="">
                                        </select>
                                        <span class="help-block"><small></small></span>
                                    </div>

                                    <div class="col-sm-4 col-md-4 col-lg-3 plan-block">
                                        <label style="display: block;">Plan</label>
                                        <select class="form-control" name="plan" id="plan" multiple>
{{--                                            <option value="">Choose Plan</option>--}}
                                            <option value="1">Plan 1 - Premium</option>
                                            <option value="2">Plan 2 - Platinum</option>
                                            <option value="3">Plan 3 - Basic</option>
                                        </select>
                                        <span class="help-block hide-me"><small></small></span>
                                    </div>

                                    <div class="col-sm-6 input-field">
                                        <label>Subject Line</label>
                                        <input id="subject" type="text" class="form-control" placeholder="Write a Catchy Header Here!">
                                        <span class="help-block hide-me"><small></small></span>
                                    </div>

                                    <div class="col-sm-3 input-field">
                                        <label>Credits</label>
                                        <input id="credits" type="number" class="form-control">
                                        <span class="help-block hide-me"><small></small></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="profile-info">
                                    <div class="add-praticelogo logo-image-container" id="logo-image-container">
                                        <img src="{{ asset('public/images/icons/right-arrow.png') }}">
                                        <a id="logo" href="javascript:void(0);">
                                            <label>
                                                Add Upload Thumbnail
                                            </label>
                                        </a>

                                        <div class="attachment_container">
                                            <input type="file" id="add_logo_image" name="add_logo_image">
                                        </div>

                                        <div class="limit_exceeded_error_msg_container hide" style="margin-top:10px; margin-bottom: 15px;padding: 10px 5px 10px 10px ">
                                            <span class="remove_limit_exceeded_error"><i class="fa fa-times" aria-hidden="true"></i></span>
                                            <span class="limit_exceeded_error_msg"></span>
                                        </div>
                                        <div class="attached_images_container p-l-image">
                                            <img class="img-responsive no-image" src="{{ asset('public/images/no-image.png') }}">
                                            <label>No Image</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="template-screenshot" style="display: none;"></div>

                                <div id="previewImage" style="display: none;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 steps-nav" style="display: none;">

                        <div class="col-sm-1">
                            <a href="{{ route('admin.templates.list') }}" class="btn btn-default" style="padding-left: 30px;padding-right: 30px;">Back</a>
                        </div>

                        <div class="col-sm-8 text-center">
                            <div class="campaign-steps">
                                <span>
                                <a class="active" data-action="create">1. Create</a>
                                <i class="fa fa-angle-right"></i>
                                </span>
                                <span><a class="" data-action="add-recipients-container">2. Add Recipients</a><i
                                            class="fa fa-angle-right"></i></span>
                                <span><a href="javascript:void(0);" class="" data-action="publish-container">3. PUBLISH &amp; SEND</a></span>
                            </div>
                        </div>

                        <div class="col-sm-3 action-center" style="display: none;">
                            <button class="btn btn-primary" id="btn-Preview-Image">Take Screenshot</button>
                            {{--<a href="javascript:void(0);" class="btn btn-primary next-action">Next</a>--}}
                            <button class="btn btn-primary save-action">Save</button>
                        </div>
                    </div>
                    <div class="loading-bar" style="text-align: center;margin-top: 50px; display: block;">
                        <span class="loading-text" style="font-size: 15px;font-weight: 700;display: block;">Loading Template...</span>
                        <img src="{{ asset('public/images/Loading-bar.gif') }}">
                    </div>

                    <div class="row">
                        <div class="col-sm-12" >
                            <div id="app" class="create steps-section" style=" width: 100%; height: 100vh; display: block;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="display: block;" id="capture" class="frame-container">
    </div>
    <input type="hidden" id="template-source" value="email_campaign" />
    <input type="hidden" id="storage-path" value="{{ url('storage/app/') }}" />
@endsection

@section('after_styles')
    <style>
        .plan-block .btn-group
        {
            width: 100%;
        }
        .plan-block .multiselect.dropdown-toggle {
            width: 100%;
            text-align: left;
            height: 38px;
            opacity: 1 !important;
            background: #ffffff;
        }
        .plan-block .multiselect.dropdown-toggle .caret
        {
            float: right;
            margin-top: 8px;
        }

        .box.box-default
        {
            border: none;
        }
        /*Select 2*/
        .select2-container .select2-choice {
            background-image: none !important;
            border: none !important;
            height: auto !important;
            padding: 0px !important;
            line-height: 22px !important;
            background-color: transparent !important;
            box-shadow: none !important;
        }
        .select2-container .select2-choice .select2-arrow {
            background-image: none !important;
            background: transparent;
            border: none;
            width: 14px;
            top: -2px;
        }
        .select2-container .select2-container-multi.form-control {
            height: auto;
        }
        .select2-results .select2-highlighted {
            color: #262626;
            background-color:#f0f0f0;
        }
        .select2-drop-active {
            border: 1px solid #e3e3e3 !important;
            padding-top: 5px;
        }
        .select2-search input {
            border: 1px solid rgba(120, 130, 140, 0.13);
        }
        .select2-container-multi {
            width: 100%;
        }
        .select2-container-multi .select2-choices {
            border: 1px solid !important;
            box-shadow: none !important;
            background-image: none !important;
            border-radius: 0px !important;
            min-height: 38px;
        }
        .select2-container-multi .select2-choices .select2-search-choice {
            padding: 4px 7px 4px 18px;
            margin: 5px 0 3px 5px;
            color: #555555;
            background: #f5f5f5;
            border-color: rgba(120, 130, 140, 0.13);
            -webkit-box-shadow: none;
            box-shadow: none;
        }
        .select2-container-multi .select2-choices .select2-search-field input {
            padding: 7px 7px 7px 10px;
            font-family: inherit;
        }
        .box {
            background: none !important;
        }
        .input-form
        {
            margin-bottom: 20px;
            background: #ffffff;
            padding-bottom: 10px;
        }
        .input-form .box-title
        {
            padding-left: 40px;
            padding-bottom: 20px;
        }
        .add-praticelogo {
            margin: 0;
        }
        #logo label {
            cursor: pointer;
            display: inline-block;
            max-width: 100%;
            margin-bottom: 5px;
        }

        .profile-info .p-l-image {
            border: 1px solid #ddd;
            text-align: center;
            width: 200px;
            margin: 10px 0;
            height: 140px;
        }
        .profile-info .p-l-image .no-image
        {
            padding: 22px 0;
        }
        .logo-image-container div.show-image {
            background: none;
            border-radius: 4px;
            overflow: hidden;
            max-width: 160px;
            max-height: 140px;
            margin-left: 0;
            position: relative;
            /* margin: 5px; */
            display: inline-block;
        }
        #add_video_file_demo, #add_image_file, #add_video_file, #add_logo, #add_logo_image {
            display: none;
        }
        .logo-image-container div.show-image img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
        .profile-info .p-l-image img {
            margin: auto;
        }
        div.show-image span.remove_image {
            top: 4px;
            right: 4px;
        }
        .attached_images_container .remove_image {
            display: none !important;
        }
        div.show-image span {
            position: absolute;
            display: none;
            float: right;
            border-radius: 81px;
            width: 16px;
            text-align: center;
            height: 16px;
            font-size: 13px;
            background: #FFFFFF;
            line-height: 1.2;
            cursor: pointer;
        }
        .campaign-steps
        {
            display: none;
            margin-top: 5px;
        }
        .campaign-steps span, .campaign-steps span a
        {
            /*color: #3899ec;*/
            font-size: 16px;
            margin-right: 20px;
            color: #B0D5ED;
        }
        .campaign-steps span a
        {
            cursor: pointer;
        }
        .campaign-steps span .active
        {
            cursor: default;
        }
        .campaign-steps span .active, .campaign-steps span a:hover
        {
            color: #03A9F4;
            /*color: #3D4A9E;*/
        }
        .steps-nav
        {
            margin-bottom: 20px;
            background: #fff;
            padding: 15px;
        }

        .next-action
        {
            color: #fff;
            background-color: #03A9F4 !important;
            border-color: #0697d9 !important;
            float: right;
            padding-right: 40px;
            padding-left: 40px;
        }

        .save-action
        {
            background-color: #fff !important;
            float: right;
            padding-right: 25px;
            padding-left: 25px;
            color: #20a0ff !important;
            border-color: #20a0ff !important;
            margin-right: 20px;
        }
    </style>

    <link type="text/css" rel="stylesheet" href="{{ asset('public/plugins/bootstrap-multiselect/bootstrap-multiselect.css?ver='.$appFileVersion) }}" />
@endsection

@section('js')
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>--}}
{{--    <script src="https://gist.githubusercontent.com/CrandellWS/6bc2078aced496004d7a045e6360f19b/raw/9ae761864bbc67bc7298814bff703a4a6baaf709/html2canvas.js"></script>--}}
    <script src="{{ asset('public/js/html2canvas.js') }}"></script>

<script>
    ActionTarget = '';
    $(document).ready(function(){

    var getCanvas; // global variable

    $(document).on('click', '#btn-Preview-Image', function () {

        ActionTarget = 'screenshot';

        $(".save-action").click();

        // html2canvas(element).then(canvas => {
        //     // document.body.appendChild(canvas);
        //     document.body.appendChild(canvas);
        //     saveImage();     //or whatever you want to execute
        // });

        // working
        // html2canvas(element, {
        //         scale: 2,
        //         // allowTaint: true,
        //         // logging: true,
        //         // taintTest: false,
        //     allowTaint : false,
        //     useCORS: true,
        //         onrendered: function( canvas ) {
        //             $("#previewImage").html(canvas);
        //             console.log('canvas.toDataURL');
        //             console.log(canvas.toDataURL());
        //             getCanvas = canvas;
        //         },
        //     });

        //     html2canvas(element, {
        //     onrendered: function (canvas) {
        //         $("#previewImage").append(canvas);
        //         getCanvas = canvas;
        //     }
        // });
    });

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
    echo '<script> var userData = '. $userLOg .'; var userId = '. $userId .'; var templateId; </script>'; ?>

    @if(!empty($templateId))
        <?php
        echo '<script> templateId = '. $templateId .'</script>';
        ?>
    @endif

    <script src="{{ asset('public/plugins/bootstrap-multiselect/bootstrap-multiselect.js') }}"></script>

    <script>
        // $(".loading-bar, .steps-nav, .input-form, .action-center").hide();
        // var TOPOL_OPTIONS = {
        //     id: "#app",
        //     authorize: {
        //         apiKey: "Gp1QsJyfAZwRlizPdy1pZ0pnASId49umK6Y5ptc99OoycrumsNHmTRPwEXTw",
        //         userId: userId,
        //     },
        //     language: "en",
        //     light: true,
        //     // topBarOptions: [
        //     //     "undoRedo",
        //     //     "changePreview",
        //     //     "previewSize",
        //     //     "previewTestMail"
        //     // ], // Displays given elements in top bar
        //     removeTopBar: false,
        //     disableAlerts: true,
        //     // changePreview: true,
        //     // templateId: 1,
        //     // mergeTags: [
        //     //     { name: 'Merge tags', // Group name
        //     //         items: [
        //     //             {
        //     //                 value: userData.first_name, // Text to be inserted
        //     //                 text: "First name", // Shown text in the menu
        //     //                 label: "Your first name" // Shown description title in the menu
        //     //             },
        //     //             {
        //     //                 value: userData.last_name,
        //     //                 text: "Last name",
        //     //                 label: "Your last name"
        //     //             },{
        //     //                 value: userData.email,
        //     //                 text: "Email",
        //     //                 label: "Your Email Address"
        //     //             },
        //     //             {
        //     //                 value: userBusinessData.phone,
        //     //                 text: "Phone number.",
        //     //                 label: "Your Phone Number"
        //     //             },
        //     //             {
        //     //                 value: userBusinessData.website,
        //     //                 text: "Website",
        //     //                 label: "Your Website"
        //     //             },
        //     //             {
        //     //                 value: userBusinessData.address,
        //     //                 text: "Address",
        //     //                 label: "Your Address"
        //     //             },
        //     //             {
        //     //                 value: userBusinessData.city,
        //     //                 text: "City",
        //     //                 label: "Your City"
        //     //             },
        //     //             {
        //     //                 value: userBusinessData.state,
        //     //                 text: "State",
        //     //                 label: "Your State"
        //     //             },
        //     //             {
        //     //                 value: userBusinessData.zip_code,
        //     //                 text: "Zip",
        //     //                 label: "Your Xip Code"
        //     //             }
        //     //         ]
        //     //     }
        //     // ],
        //     title: "My template builder",
        //     callbacks: {
        //         onSaveAndClose: function(json, html) {
        //             // console.log("onSaveAndClose");
        //             // console.log(json);
        //             // console.log(userId + ' > ' + templateId);
        //             // saveTemplate(json, html, templateId);
        //             // HTML of the email
        //             // console.log(html);
        //             // JSON object of the email
        //         },
        //         onSave: function(json, html) {
        //             // console.log("onSave");
        //             saveTemplate(json, html, templateId);
        //
        //             // console.log("html");
        //             // console.log(html);
        //             // HTML of the email
        //             // console.log(html);
        //             // JSON object of the email
        //             // console.log(json);
        //         },
        //     }
        // };
    </script>

    <script src="{{ asset('public/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
{{--    <script src="https://d5aoblv5p04cg.cloudfront.net/editor/loader/build.js" type="text/javascript"></script>--}}

    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    <script src="https://d5aoblv5p04cg.cloudfront.net/mjml4-editor/loader/build.js" type="text/javascript"></script>

    <script src="{{ asset('public/js/admin/template-manager.js?ver='.$appFileVersion) }}"></script>
@endsection
