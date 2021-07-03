@extends('index')

@section('pageTitle', 'Create Promotion')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid dashboarbgtitle">
            <div class="dashboard-wrapper image-editor-wrapper">
                <div class="row">
                    <button style="display: none;" class="add_posts">add posts</button>
                    <button style="display: none;" class="connect-app" data-type="Facebook">Connect</button>
                    {{-- <button style="display: none;" type="button" id="loginSocial" class="btn facebook-widget-btn"> Connect Facebook</button>--}}
                    {{-- <button class="add_posts">login</button>--}}
                    <div class="col-md-12">
                        <pixie-editor onload="setZoom()"></pixie-editor>
                    </div>
                </div>
                @include('partials.social-media-modals')
            </div>
        </div>
    </div>

    <a href="" id="img-link" style="display: none;" download>download</a>
    <input type="hidden" id="flag" value=""/>
    <input type="hidden" id="saveImage" value=""/>

    <input type="hidden" id="currentPage" value="promotions"/>
    <input type="hidden" id="business_id" value="{{ $userData['business'][0]['business_id'] }}"/>

    @if($socialToken == 1 && $accessTokenType != '')
        <input type="hidden" id="accessToken" value="{{ $socialToken }}" data-type="{{ $accessTokenType }}"/>
    @endif

    @if(!empty($authResponse))
        <input type="hidden" id="auth-response" value="{{ $authResponse }}" data-code="{{ $authCode }}"
               data-message="{{ $authMessage }}" data-type="{{ $authType }}"/>
    @endif
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/plugins/pixie/styles.min.css') }}"/>
    <link type="text/css" rel="stylesheet" href="{{ asset('public/plugins/toastr/toastr.min.css') }}">
    <link type="text/css" rel="stylesheet"
          href="{{ asset('public/css/social-media-common.css?ver='.$appFileVersion) }}"/>
    <link type="text/css" href="{{ asset('public/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet"/>
    <link type="text/css" rel="stylesheet" href="{{ asset('public/plugins/lightbox/lightbox.css') }}"/>

    <style>
        .limit_exceeded_error_msg_container {
            margin-bottom: 10px;
        }

        .image-editor-wrapper #post_content_body {
            width: 70%;
            box-shadow: 0px 0px 4px rgba(0, 0, 0, 0.25);
            border-radius: 4px;
            padding-left: 10px;
            padding-top: 10px;
            position: relative;
            resize: none;
        }

        .image-editor-wrapper #add_post_modal .content_container {
            box-shadow: none;
            position: relative;
        }

        .image-editor-wrapper #add_post_modal .attached_images_container {
            float: right;
            width: 25%;
            padding-left: 0px;
        }

        .image-editor-wrapper .posts_char_count_container {
            position: absolute;
            width: 70%;
            /* top: 0px; */
            /* height: 150px; */
            bottom: 20px;
            left: 0px;
            /* left: 0px; */
        }

        .attachment_container {
            display: none;

        }

        .sharing-process.welcome-process .modal-header {
            display: block;
        }

        .sharing-process.welcome-process .modal-header .modal-title {
            display: none;
        }

        .sharing-process .modal-header .close {
            position: absolute;
            right: 15px;
            top: 10px;
        }

        .sharing-process .modal-body {
            padding-top: 0px;
        }

        .sharing-process.welcome-process .modal-footer {
            background: no-repeat;
            padding: 15px;
            text-align: center;
        }

        div.show-image {
            margin: 0px;
            width: 100%;
            height: 100%;
            background: none;
        }

        div.show-image img {
            width: 100%;
            height: 100%;
        }

        .modal-embed .modal-dialog {
            width: 500px;
        }

        .embed-input {
            width: 90%;
            display: inline;
        }

        .copy-me {
            font-size: 22px;
            background-color: #e3e2e2;
            padding: 10px;
            cursor: pointer;
        }

        /*.image-editor-wrapper .send_post_options {
            display: none !important;
        }*/

    </style>
@endsection

@section('js')
    <?php
    $userLOg = json_encode($userData);

    $stateResponse = (!empty($promotionData['response'])) ? $promotionData['response'] : "";

    echo '<script> var state; var userData = ' . $userLOg . '; var userId = ' . 1 . '; var templateId; </script>';
    //    echo '<script> var userData = '. $userLOg .'; var userId = '. 1 .'; var templateId; </script>';
    ?>

    @if(!empty($templateId))
        <?php
        echo '<script> templateId = ' . $templateId . '</script>';
        ?>
    @endif

    <?php
    if (isset($socialMediaPostsData)) {
        $socialMediaPostsJson = json_encode($socialMediaPostsData);
        echo '<script> window.socialMediaPostsData = ' . $socialMediaPostsJson . ';</script>';
    } else {
        echo '<script> window.socialMediaPostsData = []; </script>';
    }
    ?>

    @if(!empty($stateResponse))
        <?php
        echo '<script> state = ' . $stateResponse . '</script>';
        ?>
    @endif

    <script type="text/javascript" src="{{ asset('public/plugins/toastr/toastr.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/bootstrap-datetimepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/promotion-manager.js?ver='.$appFileVersion)}}"></script>
    <script src="{{ asset('public/js/common-social-media.js?ver='.$appFileVersion) }}"></script>
    <script src="{{ asset('public/js/auth-manager.js?ver='.$appFileVersion) }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/connect-apps.js?ver='.$appFileVersion) }}"></script>
    {{--<script type="text/javascript" src="{{ asset('public/plugins/pixie/pixie-scripts.js')}}"></script>--}}
    <script type="text/javascript" src="{{ asset('public/plugins/pixie/scripts.min.js')}}"></script>

    <script type="text/javascript" src="{{ asset('public/plugins/clipboard/clipboard.min.js')}}"></script>
    {{--<script type="text/javascript" src="{{ asset('public/plugins/new-pixie/scripts.min.js')}}"></script>--}}

    <script>
        function setZoom(params) {
            setTimeout(function () {
                var currentZoom = $('.current').children('.value').text().slice(0, -1);
                // console.log(currentZoom);
                while (currentZoom >= 105 || currentZoom <= 95) {
                    if (currentZoom >= 105) {
                        $("mat-icon[svgicon=remove]").click();
                    } else if (currentZoom <= 95) {
                        $("mat-icon[svgicon=add]").click();
                    }
                    currentZoom = $('.current').children('.value').text().slice(0, -1);
                    // console.log(currentZoom);
                }
            }, 1000);
        }
        setZoom();
    </script>
@endsection
