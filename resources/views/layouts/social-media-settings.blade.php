@extends('index')

<?php $dynamicAppName=getDynamicAppName(); ?>

@section('pageTitle', 'Connect Your Social Media Pages')

@section('content')
    <div id="page-wrapper" class="weekly-reports">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="white-box full-page-view">
                        <div class="page-content">
                            <div class="section">
                                </div>
                                <div class="posts-body">
                                    @include('layouts.social-media.social-media-landing-page-state')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->

    <input type="hidden" id="currentBusiness" value="" />
    <input type="hidden" id="business_id" value="{{ $userData['business'][0]['business_id'] }}" />

    <input type="hidden" id="currentPage" value="social_post_settings" />

    @if($socialToken == 1 && $accessTokenType != '')
        <input type="hidden" id="accessToken" value="{{ $socialToken }}" data-type="{{ $accessTokenType }}" />
    @endif

    @if(!empty($authResponse))
        <input type="hidden" id="auth-response" value="{{ $authResponse }}" data-code="{{ $authCode }}" data-message="{{ $authMessage }}" data-type="{{ $authType }}" />
    @endif

    {{ csrf_field() }}
@endsection

@section('css')
    <link type="text/css" rel="stylesheet" href="{{ asset('public/plugins/toastr/toastr.min.css?ver='.$appFileVersion) }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('public/css/social-media/posts.css?ver='.$appFileVersion) }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('public/css/social-media-common.css?ver='.$appFileVersion) }}" />

    <style>

        .facebook-social-media-button img {
            content: url("{{ asset('public/images/social-media-facebook.png') }}");
        }

        .facebook-social-media-button.selected-social-media img{
            content: url("{{ asset('public/images/social-media-facebook-white.png') }}") !important;
        }

        .twitter-social-media-button img{
            content: url("{{ asset('public/images/social-media-twitter.png') }}");
        }

        .twitter-social-media-button.selected-social-media img{
            content: url("{{ asset('public/images/social-media-twitter-white.png') }}") !important;
        }

        .instagram-social-media-button img{
            content: url("{{ asset('public/images/social-media-instagram.png') }}");
        }

        .instagram-social-media-button.selected-social-media img{
            content: url("{{ asset('public/images/social-media-instagram-white.png') }}") !important;
        }

        .linkedin-social-media-button img{
            content: url("{{ asset('public/images/social-media-linkedin.png') }}");
        }

        .linkedin-social-media-button.selected-social-media img{
            content: url("{{ asset('public/images/social-media-linkedin-white.png') }}") !important;
        }

        .post_now_image img{
            content: url("{{ asset('public/images/send_post.png') }}");
        }

        .selected_post_option .post_now_image img{
            content: url("{{ asset('public/images/send_post_white.png') }}") !important;
        }

        .schedule_for_later_image img{
            content: url("{{ asset('public/images/schedule_later_image.png') }}");
        }

        .selected_post_option .schedule_for_later_image img{
            content: url("{{ asset('public/images/schedule_later_image_white.png') }}") !important;
        }

        .save_as_draft_image img{
            content: url("{{ asset('public/images/save_as_draft_image.png') }}");
            padding-left: 5px;
        }

        .selected_post_option .save_as_draft_image img{
            content: url("{{ asset('public/images/save_as_draft_image_white.png') }}") !important;
        }

    </style>
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('public/plugins/toastr/toastr.min.js?ver='.$appFileVersion) }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/connect-apps.js?ver='.$appFileVersion) }}"></script>
    <script src="{{ asset('public/js/auth-manager.js?ver='.$appFileVersion) }}"></script>
@endsection
