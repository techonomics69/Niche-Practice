@extends('admin.layout')

@section('title', 'Promotion Template')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-default image-editor-wrapper">
                <div class="box-body">
{{--                    <div class="col-sm-12 steps-nav" style="display: block;">--}}

{{--                        <div class="col-sm-1">--}}
{{--                            <a href="{{ route('admin.templates.list') }}" class="btn btn-default" style="padding-left: 30px;padding-right: 30px;">Back</a>--}}
{{--                        </div>--}}

{{--                        <div class="col-sm-8 text-center">--}}
{{--                            <div class="campaign-steps">--}}
{{--                    <span>--}}
{{--                    <a class="active" data-action="create">1. Create</a>--}}
{{--                    <i class="fa fa-angle-right"></i>--}}
{{--                    </span>--}}

{{--                                <span><a class="" data-action="add-recipients-container">2. Add Recipients</a><i--}}
{{--                                            class="fa fa-angle-right"></i></span>--}}
{{--                                <span><a href="javascript:void(0);" class="" data-action="publish-container">3. PUBLISH &amp; SEND</a></span>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="col-sm-3 action-center" style="display: none;">--}}
{{--                            <a href="javascript:void(0);" class="btn btn-primary next-action">Next</a>--}}
{{--                            <button class="btn btn-primary save-action">Save</button>--}}
{{--                        </div>--}}
{{--                    </div>--}}

                    <div class="loading-bar" style="text-align: center;margin-top: 50px; display: none;">
                        <span class="loading-text" style="font-size: 15px;font-weight: 700;display: block;">Loading Template...</span>
                        <img src="{{ asset('public/images/Loading-bar.gif') }}">
                    </div>

                    <div class="row">
                        <div class="col-sm-12 input-form" style="display: none;">
                            <div style="display: flex">
                                <div>
                                    <h3 class="box-title">
                                        @if(empty($templateId))
                                            Create Promotion Template
                                        @else
                                            Edit Promotion Template
                                        @endif
                                    </h3>
                                </div>
                                <div class="box-title pull-right">
{{--                                    <button id="saveJson" style="display: none;">Save Json Template</button>--}}
                                    <a download="json.txt" id="downloadlink" style="display: none;">
                                        <button id="saveJson2">Json</button>
                                    </a>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="col-sm-8">
                                    <div class="col-sm-6 input-field">
                                        <label>Promotion Name</label>
                                        <input type="text" class="form-control" id="title" value="">
                                        <div style="margin-top: 5px;display: flex;">
                                            <input type="checkbox" id="show-in-dashboard" style="margin-right: 5px;/* padding-top: 8px; *//* float: left; *//* padding-right: 12px; */">
                                            Donot Show in Dashboard Promotions
                                        </div>
                                        <span class="help-block hide-me"><small></small></span>
                                    </div>
                                    <div class="col-sm-12 m-t-10 p-l-0" style="padding-left: 0px;">

                                        <div class="col-sm-4 col-md-4 col-lg-4">
                                            <label>Industry</label>
                                            <select class="form-control select2" name="industry" id="industry" data-selected-target="">
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
                                    </div>

                                    <div class="col-sm-12 m-t-10 p-l-0" style="padding-left: 0px;">
                                        <div class="col-sm-4 col-md-4 col-lg-4">
                                            <label>Type</label>
                                            <select class="form-control select2" name="template_type" id="template_type" data-selected-target="">
                                                {{-- @foreach($types as $row) --}}
                                                @if ($promotionData)
                                                <option value="1" {{ $promotionData['template_type'] == 1 ? 'selected' : '' }}>Free Templates</option>
                                                <option value="2"{{ $promotionData['template_type'] == 2 ? 'selected' : '' }}>Premium Templates</option>
                                                <option value="3"{{ $promotionData['template_type'] == 3 ? 'selected' : '' }}>Private Templates</option>
                                                @else
                                                <option value="1">Free Templates</option>
                                                <option value="2">Premium Templates</option>
                                                <option value="3">Private Templates</option>
                                                @endif

                                                {{-- @endforeach --}}
                                            </select>
                                            <span class="help-block hide-me"><small></small></span>
                                        </div>
                                        <div class="col-sm-4 col-md-4 col-lg-4">
                                            <label>Credits</label>
                                            <input type="number" class="form-control" id="credits" value="{{ $promotionData['credits'] ?? '' }}">
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
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <pixie-editor></pixie-editor>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('after_styles')
    <style>
        .box-title{
            display: flex;
            margin-left: auto;
            padding: 15px 10px;
        }
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
        pixie-editor .tool-panel-container .content {
            display: flex;
            align-items: center;
            height: 100%;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            position: relative;
            min-height: auto;
            padding: unset;
            margin: unset;
        }
    </style>

    @if( ( !empty($promotionData['user_id']) && !empty($userId) ) && $promotionData['user_id'] != $userId)
        <style>
            .export-button
            {
                display: none !important;
            }
            .open-button
            {
                display: none !important;
            }
        </style>
    @endif

    <link type="text/css" rel="stylesheet" href="{{ asset('public/plugins/bootstrap-multiselect/bootstrap-multiselect.css?ver='.$appFileVersion) }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('public/plugins/pixie/styles.min.css') }}" />
@endsection

@section('js')
    <?php
    $userLOg = json_encode($userData);

    $stateResponse = (!empty($promotionData['response'])) ? $promotionData['response'] : "";

    echo '<script> var state; var userData = '. $userLOg .'; var userId = '. $userId .'; var templateId, promotionDataUserId; </script>';
    ?>

    @if(!empty($templateId))
        <?php
        echo '<script> templateId = '. $templateId .'</script>';
        ?>
    @endif


    @if(!empty($promotionData))
        <?php
        echo '<script> promotionDataUserId = '. $promotionData['user_id'] .'</script>';
        ?>
    @endif

    @if(!empty($stateResponse))
        <?php
        echo '<script> state = '. $stateResponse .'</script>';
        ?>
    @endif

    <script src="{{ asset('public/plugins/bootstrap-multiselect/bootstrap-multiselect.js') }}"></script>
    <script src="{{ asset('public/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
{{--    <script src="https://d5aoblv5p04cg.cloudfront.net/editor/loader/build.js" type="text/javascript"></script>--}}
{{--    <script src="{{ asset('public/js/admin/template-manager.js?ver='.$appFileVersion) }}"></script> --}}
    <script type="text/javascript" src="{{ asset('public/plugins/pixie/scripts.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('public/js/admin/admin-promotion-manager.js?ver='.$appFileVersion)}}"></script>
@endsection
