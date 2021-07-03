@extends('index')

@section('pageTitle', 'Get Started')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid dashboarbgtitle">
            <div class="dashboard-wrapper get-started-page">
                <div class="page-head">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="page-title">Let's set up your practice profile</h4>
                            <p class="page-subheading">We will use the information below to search the internet to find everywhere your business is listed and where reviews are posted. Please take a moment to ensure your contact information is accurate. Please complete the steps with the red arrow:
                            </p>
                        </div>
                    </div>
                </div>

                <div class="practice-profile-wrapper">
                    <div class="row profile-top">
                            <h3 style="font-weight: bold;">Review and Complete Profile</h3>
                            <div class="col-md-4">
                                <form class="validate-image">
                                    <div class="profile-info">
                                        <div class="add-praticephoto logo-container" id="logo-container">
                                            <img src="{{ asset('public/images/icons/right-arrow.png') }}">
                                            <a id="avatar" href="javascript:void(0);"><label>Add Photo . (140x160px)</label></a>
                                            <div class="attachment_container">
                                                    {{--<span class="add-image-btn-disabled-tooltip" style="display: none;">--}}
                                                        {{--<button type="button" id="logo" class="btn btn-info" style="float: right;padding: 8px 25px;margin-right: 0;color: #fff;"><span class="hide_tablet" style="float: right;">Browse</span>--}}
                                                        {{--</button>--}}
                                                    {{--</span>--}}

                                                <input type="file" id="add_logo" name="add_logo">
                                            </div>

                                            <div class="limit_exceeded_error_msg_container hide" style="margin-top:10px; margin-bottom: 15px;padding: 10px 5px 10px 10px ">
                                                <span class="remove_limit_exceeded_error"><i class="fa fa-times" aria-hidden="true"></i></span>
                                                <span class="limit_exceeded_error_msg"></span>
                                            </div>
                                            <div class="attached_images_container p-p-image">
                                                @if(!empty($userBusiness['avatar']))
                                                    <div class="small-4 columns show-image" data-attachment-id="{{ $userBusiness['avatar'] }}">
                                                        {{--<img data-name="0x.jpg" class="attached_image_ox" src="{{ storage_path('app/'.$userBusiness['avatar']) }}">--}}
                                                        <img data-name="0x.jpg" class="attached_image_ox" src="{{ uploadImagePath($userBusiness['avatar']) }}">

                                                        <span class="remove_image">x</span>
                                                    </div>
                                                @else
                                                    <div class="no-avatar">
                                                        <img src="{{ asset('public/images/practice-profile.png') }}">
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="add-praticelogo logo-image-container" id="logo-image-container">
                                            <img src="{{ asset('public/images/icons/right-arrow.png') }}">
                                            <a id="logo" href="javascript:void(0);"><label>Add Practice Logo . (300x60px)</label></a>

                                            <div class="attachment_container">
                                                    {{--<span class="add-image-btn-disabled-tooltip" style="display: none;">--}}
                                                        {{--<button type="button" id="logo" class="btn btn-info" style="float: right;padding: 8px 25px;margin-right: 0;color: #fff;"><span class="hide_tablet" style="float: right;">Browse</span>--}}
                                                        {{--</button>--}}
                                                    {{--</span>--}}

                                                <input type="file" id="add_logo_image" name="add_logo_image">
                                            </div>

                                            <div class="limit_exceeded_error_msg_container hide" style="margin-top:10px; margin-bottom: 15px;padding: 10px 5px 10px 10px ">
                                                <span class="remove_limit_exceeded_error"><i class="fa fa-times" aria-hidden="true"></i></span>
                                                <span class="limit_exceeded_error_msg"></span>
                                            </div>
                                            <div class="attached_images_container p-l-image">
                                                @if(!empty($userBusiness['logo']))
                                                    <div class="small-4 columns show-image" data-attachment-id="{{ $userBusiness['logo'] }}">
                                                        {{--<img data-name="0x.jpg" class="attached_image_ox" src="{{ storage_path('app/'.$userBusiness['avatar']) }}">--}}
                                                        <img data-name="0x.jpg" class="attached_image_ox" src="{{ uploadImagePath($userBusiness['logo']) }}">
                                                        <span class="remove_image">x</span>
                                                    </div>
                                                @else
                                                    <img class="img-responsive" src="{{ asset('public/images/no-image.png') }}">
                                                    <label>No Image</label>
                                                @endif
                                            </div>
                                        </div>
                                </div>
                                </form>
                            </div>

                            <div class="col-md-8">
                                <form class="validate-business">
                                    <div class="user-profile-data">
                                        <div class="u-p-d-head">
                                            <h3 class="profile-data-title">Texas Dental Center</h3>
                                            <a href="javascript:void(0);"><i class="mdi mdi-pencil"></i></a>
                                        </div>

                                        <div class="form-group">
                                            <i class="fa fa-envelope"></i>
                                            <input type="text" class="form-control" value="{{ getIndexedvalue($userData, 'email') }}" disabled="disabled">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" value="{{ getIndexedvalue($userData['business'][0], 'address') }}" id="address" data-required="true" />
                                            <span class="help-block hide-me"><small></small></span>
                                        </div>
                                        <div class="form-group">
                                            <i class="fa fa-phone"></i>
                                            <input type="text" class="form-control" value="{{ getIndexedvalue($userData['business'][0], 'phone') }}" id="phone" data-required="true" />
                                            <span class="help-block hide-me"><small></small></span>

                                        </div>
                                        <div class="form-group">
                                            <i class="fa fa-globe"></i>
                                            <input type="text" placeholder="Enter Your Website" class="form-control" id="web-url" value="{{ getIndexedvalue($userData['business'][0], 'website') }}" />
                                            <span class="help-block hide-me"><small></small></span>
                                        </div>
                                    </div>
                                    <div class="fields-footer">
                                        <button type="submit" class="btn btn-save" data-type="user_save" data-form-status="">Save</button>
                                        <span class="alert m-t-10" style="display: none; "></span>
                                    </div>
                                </form>
                            </div>

                    </div>
                    <div class="row">
                        <h3 style="font-weight: 700;margin-top: 0;margin-bottom: 40px;">Setup Integrations with Fb/Tw/Google</h3>
                        <div class="col-md-12">
                            <div class="connect-social-profiles">
                                @foreach($appRecord as $index => $app)
                                    <?php
                                    $appIndex = strtolower($index);
                                    $appType = $app['type'];
                                    $appSource = strtolower(str_replace(" ", "", $appType));
                                    $appStatus = $app['status'];
                                    ?>
                                    <div class="col-xs-5ths {{$appSource}}">
                                        <img class="connect-icon" src="{{ asset('public/images/'.$appIndex.'-64.png') }}">

                                        <h4 class="website-title">{{ $index }}</h4>
                                        <div class="connect-button">
                                            <img src="{{ asset('public/images/icons/right-arrow.png') }}">
                                            @if($appStatus == 'connected')
                                                <a href="javascript:void(0);" class="btn btn-connected-social" data-type="{{ $appType }}">
                                                    Connected
                                                </a>
                                            @else
                                                <a href="javascript:void(0);" class="btn btn-connect-social connect-app" data-type="{{ $appType }}">Connect</a>
                                            @endif
                                        </div>
                                        @if($appIndex == 'twitter')
                                            <div class="arrow-image1">
                                                <img src="{{ asset('public/images/arrow1.png') }}">
                                            </div>
                                       @elseif($appIndex == 'google')
                                            <div class="arrow-image2">
                                                <img src="{{ asset('public/images/arrow2.png') }}">
                                            </div>
                                        @endif



                                    </div>

                                    <span class="separator"></span>
                                @endforeach

                                <div class="col-xs-5ths">

                                    <img class="connect-icon" src="{{ asset('public/images/linkedin.png') }}">
                                    <h4 class="website-title">Linkedin</h4>
                                    <div class="connect-button">
                                        <h3 class="coming-soon-label">Coming Soon</h3>
                                    </div>

                                </div>

                                <span class="separator"></span>

                                <div class="col-xs-5ths">
                                    <img class="connect-icon" src="{{ asset('public/images/instagram.png') }}">
                                    <h4 class="website-title">Instagram</h4>
                                    <div class="connect-button">
                                        <h3 class="coming-soon-label">Coming Soon</h3>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>


            </div>
        </div>
    </div>
    @if($socialToken == 1 && $accessTokenType != '')
        <input type="hidden" id="accessToken" value="{{ $socialToken }}" data-type="{{ $accessTokenType }}" />
    @endif

    @if(!empty($authResponse))
        <input type="hidden" id="auth-response" value="{{ $authResponse }}" data-code="{{ $authCode }}" data-message="{{ $authMessage }}" data-type="{{ $authType }}" />
    @endif

    <input type="hidden" id="currentPage" value="get_started" />
    <input type="hidden" id="business_id" value="{{ $userData['business'][0]['business_id'] }}" />
@endsection

@section('css')
    <link type="text/css" rel="stylesheet" href="{{ asset('public/css/image-manager.css?ver='.$appFileVersion) }}" />
@endsection

@section('js')
    <script>
        registerElement('validate-business', 'businessErrorFound');
    </script>
<script type="text/javascript" src="{{ asset("public/js/image-manager.js?ver=$appFileVersion") }}"></script>

<script type="text/javascript" src="{{ asset("public/js/image-branding.js?ver=$appFileVersion") }}"></script>

<script type="text/javascript" src="{{ asset('public/js/connect-apps.js?ver='.$appFileVersion) }}"></script>
<script src="{{ asset('public/js/auth-manager.js') }}"></script>
@endsection
