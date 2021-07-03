@extends('index')

@section('pageTitle', 'Business Profile')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid dashboarbgtitle">
            <div class="dashboard-wrapper business-profile-wrapper">
                <div class="page-head">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="page-title">Business Profile
{{--                                <a class="page-help" href="javascript:void(0)">--}}
{{--                                    <i class="fa fa-question-circle-o" style="color: #7d8080;/* transform: scaleX(-1); */margin-right: 5px;"></i>--}}
{{--                                    <img class="help-info-image" src="{{ asset('public/images/information.png') }}" />--}}
{{--                                </a>--}}
                            </h4>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="billing-wrapper">
                            <div class="your-profile">
                                <div class="row">

                                    <div class="col-md-3">
                                        <h3 class="b-p-title">Your Profile</h3>
                                        <p class="b-p-desc">Manage your account settings here.</p>

                                    </div>

                                    <div class="col-md-9">
                                        <form class="validate-user-profile">
                                            <div class="data-fields">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>First Name</label>
                                                        <input type="text" class="form-control" id="first_name" value="{{ $userData['first_name'] }}" data-required="true">
                                                        <span class="help-block hide-me"><small></small></span>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label>Last Name</label>
                                                        <input type="text" class="form-control" id="last_name" value="{{ $userData['last_name'] }}" data-required="true">
                                                        <span class="help-block hide-me"><small></small></span>
                                                    </div>
                                                </div>
                                                <div class="row m-t-20">
                                                    <div class="col-md-6">
                                                        <label>Email Address  <img class="business-profile-icon " data-toggle="tooltip" data-placement="top" data-html="true" title="Email"  src="{{ asset('public/images/information.png') }}" /></label>
                                                        <input type="text" class="form-control" value="{{ $userData['email'] }}" disabled>

                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Phone Number</label>
                                                        <input type="text" class="form-control" id="phone-number" value="{{ $userData['business'][0]['phone'] }}" data-required="true">
                                                        <span class="help-block hide-me"><small></small></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="fields-footer">
                                                <button type="submit" class="btn btn-save" data-type="user_save" data-form-status="">Save</button>
                                                <span class="alert m-t-10" style="display: none;"></span>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>



                            <div class="business-details">
                                <div class="row">

                                    <div class="col-md-3">
                                        <h3 class="b-p-title">Business Details</h3>
                                        <p class="b-p-desc">Manage your business information here.</p>
                                    </div>

                                    <form class="business-profile">
                                        <div class="col-md-9">
                                            <div class="data-fields">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="input-field">
                                                            <label>Practice Name <img class="business-profile-icon " data-toggle="tooltip" data-placement="top" data-html="true" title="<span> Please contact support@nichepractice.com</span><br><span> in prder to change these fields</span>"  src="{{ asset('public/images/information.png') }}" /></label>
                                                            <input type="text"
                                                                   value="{{ $userBusiness['practice_name'] }}"
                                                                   class="form-control" disabled/>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="input-field">
                                                            <label>Industry <img class="business-profile-icon " data-toggle="tooltip" data-placement="top" data-html="true" title="Industry"  src="{{ asset('public/images/information.png') }}" /></label>
                                                            <input type="text" class="form-control"
                                                                   value="{{ $userBusiness['niche']['industry']['name'] }}"
                                                                    disabled="disabled" />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="input-field">
                                                            <label>Niche <img class="business-profile-icon " data-toggle="tooltip" data-placement="top" data-html="true" title="Niche"  src="{{ asset('public/images/information.png') }}" /></label>
                                                            <input type="text" class="form-control"
                                                                   value="{{ $userBusiness['niche']['niche'] }}"
                                                                   disabled="disabled" />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="input-field">
                                                            <label>Website</label>
                                                            <input type="text" class="form-control" id="website"
                                                                   value="{{ $userBusiness['website'] }}"/>
                                                        </div>
                                                    </div>
                                                    {{--<div class="col-md-6">--}}
                                                        {{--<div class="input-field">--}}
                                                            {{--<label>Phone Number</label>--}}
                                                            {{--<input type="text" class="form-control" id="phone"--}}
                                                                   {{--value="{{ $userBusiness['phone'] }}"/>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}

                                                    <div class="col-md-6">
                                                        <div class="input-field">
                                                            <label>Address</label>
                                                            <input type="text" class="form-control" id="address"
                                                                   value="{{ $userBusiness['address'] }}"
                                                                   data-required="true" />
                                                            <span class="help-block hide-me"><small></small></span>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="input-field">
                                                            <label>Country</label>
                                                            <select class="form-control" id="country_id">
                                                                <option value="">Choose Country</option>

                                                                @foreach($countries as $country)
                                                                    <option value="{{ $country['id'] }}" {{ selectedChosenValue($userBusiness['country_id'], $country['id']) }}>{{ $country['name'] }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="input-field">
                                                            <label>State / Province</label>
                                                            <input type="text" class="form-control" id="state"
                                                                   value="{{ !empty($userBusiness['state']) ? $userBusiness['state'] : '' }}"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-field">
                                                            <label>City</label>
                                                            <input type="text" class="form-control" id="city"
                                                                   value="{{ !empty($userBusiness['city']) ? $userBusiness['city'] : '' }}"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-field">
                                                            <label>Zip Code</label>
                                                            <input type="text" class="form-control" id="zip_code"
                                                                   value="{{ !empty($userBusiness['zip_code']) ? $userBusiness['zip_code'] : '' }}"/>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="input-field">
                                                            <label>Email Address </label>
                                                            <input type="text" class="form-control" id="email"
                                                                   value="{{ !empty($userBusiness['email']) ? $userBusiness['email'] : '' }}" data-required="true" />
                                                            <span class="help-block hide-me"><small></small></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="fields-footer" style="position: relative;">
{{--                                                <div class="loading-web-bar" style="display: none; text-align: center;position: absolute;z-index: 99999;top: 0%;left: 10%;">--}}
{{--                                                    <span class="loading-text" style="font-size: 15px;font-weight: 700;display: block;">Website Report is loading <span class="web-timer"></span>--}}
{{--    </span>--}}
{{--                                                    <img src="{{ asset('public/images/Loading-bar.gif') }}">--}}
{{--                                                </div>--}}
                                                <button type="submit" class="btn btn-save" data-send="update-business-profile">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="business-details">
                                <div class="row">
                                    <div class="col-md-3">
                                        <h3 class="b-p-title">Practice Branding</h3>
                                        <p class="b-p-desc">
                                            {{-- Your connected social profiles help your customers to search you on social media. --}}
                                            Set up your branding so that your emails and landing pages look great.
                                        </p>
                                    </div>
                                    <div class="col-md-9">
                                        <form class="validate-image">

                                            <div class="data-fields">
                                                <div class="row">
                                                    <div class="profile-info">
                                                        <div class="add-praticelogo logo-image-container col-md-6 col-sm-12 text-center " id="logo-image-container">
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
                                                                        <img data-name="0x.jpg" class="attached_image_ox" src="{{ uploadImagePath($userBusiness['logo']) }}" />
                                                                        <span class="remove_image">x</span>
                                                                    </div>
                                                                @else
                                                                    <img class="img-responsive" src="{{ asset('public/images/no-image.png') }}">
                                                                    <label>No Image</label>
                                                                @endif
                                                            </div>
                                                        </div>

{{--                                                        <div class="add-praticephoto logo-container col-md-6 text-center " id="logo-container">--}}
{{--                                                            <img src="{{ asset('public/images/icons/right-arrow.png') }}">--}}
{{--                                                            <a id="avatar" href="javascript:void(0);"><label>Add Photo . (140x160px)</label></a>--}}
{{--                                                            <div class="attachment_container">--}}
{{--                                                                    --}}{{--<span class="add-image-btn-disabled-tooltip" style="display: none;">--}}
{{--                                                                        --}}{{--<button type="button" id="logo" class="btn btn-info" style="float: right;padding: 8px 25px;margin-right: 0;color: #fff;"><span class="hide_tablet" style="float: right;">Browse</span>--}}
{{--                                                                        --}}{{--</button>--}}
{{--                                                                    --}}{{--</span>--}}

{{--                                                                <input type="file" id="add_logo" name="add_logo">--}}
{{--                                                            </div>--}}

{{--                                                            <div class="limit_exceeded_error_msg_container hide" style="margin-top:10px; margin-bottom: 15px;padding: 10px 5px 10px 10px ">--}}
{{--                                                                <span class="remove_limit_exceeded_error"><i class="fa fa-times" aria-hidden="true"></i></span>--}}
{{--                                                                <span class="limit_exceeded_error_msg"></span>--}}
{{--                                                            </div>--}}
{{--                                                            <div class="attached_images_container p-p-image">--}}
{{--                                                                @if(!empty($userBusiness['avatar']))--}}
{{--                                                                    <div class="small-4 columns show-image" data-attachment-id="{{ $userBusiness['avatar'] }}">--}}
{{--                                                                        --}}{{--<img data-name="0x.jpg" class="attached_image_ox" src="{{ storage_path('app/'.$userBusiness['avatar']) }}">--}}
{{--                                                                        <img data-name="0x.jpg" class="attached_image_ox" src="{{ uploadImagePath($userBusiness['avatar']) }}">--}}
{{--                                                                        <span class="remove_image">x</span>--}}
{{--                                                                    </div>--}}
{{--                                                                @else--}}
{{--                                                                    <div class="no-avatar">--}}
{{--                                                                        <img src="{{ asset('public/images/practice-profile.png') }}">--}}
{{--                                                                    </div>--}}
{{--                                                                @endif--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="fields-footer" style="display: none;">
                                                <button type="submit" class="btn btn-save">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

{{--                            notifications--}}

                            <div class="business-details">
                                <div class="row">
                                    <div class="col-md-3">
                                        <h3 class="b-p-title">Online Review Notifications</h3>
                                        <p class="b-p-desc">
                                             You can send Email notifications for all reviews.
                                        </p>
                                    </div>
                                    <div class="col-md-9">
                                        <form class="notifications">
                                            <div class="data-fields">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="d-flex justify-content-between">
                                                            <div class="col-md-6" >
                                                        <label for="google">Send notifications to this email address</label>

                                                            </div>
                                                            <div class="col-md-6 text-right">
                                                               <span> Enable / Disable</span>
                                                            <label class="switch">
                                                            <input type="checkbox" id="checkboxCheck">
                                                            <span class="slider round"></span>
                                                        </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                    <input type="email" class="form-control" id="notification-email" value="" placeholder="Enter Email Address">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="fields-footer">
                                                <button  id="saveNotification" class="btn save">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

{{--                            <div class="business-details">--}}
{{--                                <div class="row">--}}
{{--                                    <div class="col-md-3">--}}
{{--                                        <h3 class="b-p-title">Notifications</h3>--}}
{{--                                        <p class="b-p-desc">--}}
{{--                                             You can send Email notifications for all reviews.--}}
{{--                                        </p>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-md-9">--}}
{{--                                        <form class="validate-image">--}}

{{--                                            <div class="data-fields">--}}
{{--                                                <div class="row">--}}

{{--                                                    <div class="col-12">--}}
{{--                                                        <div class="d-flex">--}}
{{--                                                            <div class="col-md-6">--}}
{{--                                                        <label for="google">Enable Sending Email for all reviews</label>--}}
{{--                                                            </div>--}}
{{--                                                            <div class="col-md-6 text-right">--}}
{{--                                                            <label class="switch">--}}
{{--                                                            <input type="checkbox">--}}
{{--                                                            <span class="slider round"></span>--}}
{{--                                                        </label>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                        <input type="text" class="form-control" id="" value="" placeholder="Enter Email Address">--}}

{{--                                                    </div>--}}

{{--                                                </div>--}}
{{--                                            </div>--}}

{{--                                            <div class="fields-footer" style="display: none;">--}}
{{--                                                <button type="submit" class="btn btn-save">Save</button>--}}
{{--                                            </div>--}}
{{--                                        </form>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}









                            <div class="business-details">
                                <div class="row">
                                    <div class="col-md-3">
                                        <h3 class="b-p-title">Social Accounts</h3>
                                        <p class="b-p-desc">
                                            Manage your social media by connecting your accounts.
                                        </p>
                                    </div>
                                    <div class="col-md-9" style="padding-left: 10px;">
                                        <div class="social-post-widgets business-social-widget">
                                            <div class="col-xs-3 social-widget">
                                            @if(!empty($socialMediaPostsData['Facebook']) && $socialMediaPostsData['Facebook']['status'] == 'connected')
                                                <div class="connected-label">Connected</div>

                                                <img src="{{asset('public/images/icons/facebook-widget.png')}}">

                                                @if(!empty($socialMediaPostsData['Facebook']['name']))
                                                    <h4>{{ '@'.$socialMediaPostsData['Facebook']['name'] }}</h4>
                                                @else
                                                    <h4>Facebook</h4>
                                                @endif
                                                <?php
                                                $connectedAT = $socialMediaPostsData['Facebook']['updated_at'];
                                                $dt = new \DateTime($connectedAT);
                                                $connectedAT = $dt->format('d-M-Y');
                                                ?>
                                                <label class="connected-date">{{ $connectedAT }}</label>


                                                <button type="button" class="btn remove-button unlink-app" data-type="Facebook">
                                                    Remove
                                                </button>
                                            @else
                                                <img src="{{asset('public/images/icons/facebook-widget.png')}}">
                                                <h4>Facebook</h4>
                                                <button type="button" class="btn facebook-widget-btn connect-app" data-type="facebook">
                                                    Connect
                                                </button>
                                            @endif


                                        </div>
                                            <div class="col-xs-3 social-widget">
                                                @if(!empty($socialMediaPostsData['Twitter']) && $socialMediaPostsData['Twitter']['status'] == 'connected')
                                                    <div class="connected-label">Connected</div>

                                                    <img src="{{asset('public/images/icons/twitter-widget.png')}}">

                                                    @if(!empty($socialMediaPostsData['Twitter']['name']))
                                                        <h4>{{ '@'.$socialMediaPostsData['Twitter']['name'] }}</h4>
                                                    @else
                                                        <h4>Twitter</h4>
                                                    @endif
                                                    <?php
                                                    $connectedAT = $socialMediaPostsData['Twitter']['created_at'];
                                                    $dt = new \DateTime($connectedAT);
                                                    $connectedAT = $dt->format('d-M-Y');
                                                    ?>
                                                    <label class="connected-date">{{ $connectedAT }}</label>


                                                    <button type="button" class="btn remove-button unlink-app" data-type="Twitter">
                                                        Remove
                                                    </button>
                                                @else
                                                    <img src="{{asset('public/images/icons/twitter-widget.png')}}">
                                                    <h4>Twitter</h4>
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn twitter-widget-btn connect-app" data-type="twitter">
                                                        Connect
                                                    </button>
                                                @endif
                                            </div>

                                            <div class="col-xs-3 social-widget">
                                                <img src="{{asset('public/images/social-coming-soon.png')}}">
                                                <label>Launching Soon!</label>
                                                <div class="coming-soon-widget">
                                                    <img class="comingsoon-icon" src="{{asset('public/images/instagram-comingsoon.png')}}">
                                                    <h3>Instagram</h3>
                                                </div>
                                                <!-- Button trigger modal -->
                                            </div>

                                            <div class="col-xs-3 social-widget">
                                                <img src="{{asset('public/images/social-coming-soon.png')}}">
                                                <label>Launching Soon!</label>

                                                <div class="coming-soon-widget">
                                                    <img class="comingsoon-icon" src="{{asset('public/images/linkedin-comingsoon.png')}}">
                                                    <h3>LinkedIn</h3>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="social-profiles">
                                <div class="row">
                                    <div class="col-md-3">
                                        <h3 class="b-p-title">Social Links for Email Footer</h3>
                                        <p class="b-p-desc">
                                            Only the ones you fill in will appear in your email footer.
                                        </p>
                                    </div>
                                    <div class="col-md-9">
                                        <form class="validate-social-profile">
                                        <div class="data-fields">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="google">Google</label>
                                                    <input type="text" class="form-control" id="google" value="{{ getIndexedvalue($social, 'google') }}">

                                                </div>
                                                <div class="col-md-6">
                                                    <label for="linkedin">LinkedIn</label>
                                                    <input type="text" class="form-control" id="linkedin" value="{{ getIndexedvalue($social, 'linkedin') }}" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Facebook</label>
                                                    <input type="text" class="form-control" id="facebook" value="{{ getIndexedvalue($social, 'facebook') }}">

                                                </div>
                                                <div class="col-md-6">
                                                    <label>Youtube</label>
                                                    <input type="text" class="form-control" id="youtube" value="{{ getIndexedvalue($social, 'youtube') }}">

                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Twitter</label>
                                                    <input type="text" class="form-control" id="twitter" value="{{ getIndexedvalue($social, 'twitter') }}">

                                                </div>
                                                <div class="col-md-6">
                                                    <label>Instagram</label>
                                                    <input type="text" class="form-control" id="instagram" value="{{ getIndexedvalue($social, 'instagram') }}">

                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Pinterest</label>
                                                    <input type="text" class="form-control" id="pinterest" value="{{ getIndexedvalue($social, 'pinterest') }}">
                                                </div>

                                            </div>
                                        </div>
                                        <div class="fields-footer">
                                            <button type="submit" class="btn btn-save" data-send="social-profile">Save</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="your-profile m-t-20">
                                <div class="row">

                                    <div class="col-md-3">
                                        <h3 class="b-p-title">Change Password</h3>
                                        <p class="b-p-desc"></p>

                                    </div>

                                    <div class="col-md-9">
                                        <form class="validate-user-password">
                                            <div class="data-fields">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>Old Password</label>
                                                        <input type="password" class="form-control" id="current_password" value="" data-required="true">
                                                        <span class="help-block hide-me"><small></small></span>
                                                        <p style="font-weight: 600;font-size: 14px;">Your password must be at least 8 characters, include a number, an uppercase letter, and a lowercase letter.</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>New Password</label>
                                                        <input type="password" class="form-control" id="password" value="" data-required="true">
                                                        <span class="help-block hide-me"><small></small></span>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12 col-xs-12 pull-right m-t-20">
                                                        <label>Confirm Password</label>
                                                        <input type="password" class="form-control" id="password-confirm" value="" data-required="true">
                                                        <span class="help-block hide-me"><small></small></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="fields-footer">
                                                <button type="submit" class="btn btn-save" data-send="update-user-password">Save</button>
                                                <span class="alert m-t-10" style="display: none;"></span>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="web-audit" style="display:none;">
                        @if($appEnvIs == 'production')
                            <iframe src="https://appreviewer.nichepractice.com"><p>Your browser does not support iframes.</p></iframe>
                        @else
                            <iframe src="https://reviewer.nichepractice.com"><p>Your browser does not support iframes.</p></iframe>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="business_id" value="{{ $userData['business'][0]['business_id'] }}" />
    <input type="hidden" id="currentPage" value="social_post_settings" />

    @if($socialToken == 1 && $accessTokenType != '')
        <input type="hidden" id="accessToken" value="{{ $socialToken }}" data-type="{{ $accessTokenType }}" />
    @endif

    @if(!empty($authResponse))
        <input type="hidden" id="auth-response" value="{{ $authResponse }}" data-code="{{ $authCode }}" data-message="{{ $authMessage }}" data-type="{{ $authType }}" />
    @endif

    @if($appEnvIs == 'production')
        <input type="hidden" id="source" value="https://appreviewer.nichepractice.com" />
    @else
        <input type="hidden" id="source" value="https://reviewer.nichepractice.com" />
    @endif

@endsection

@section('css')
    <link type="text/css" rel="stylesheet" href="{{ asset('public/css/image-manager.css?ver='.$appFileVersion) }}" />

    <link type="text/css" rel="stylesheet" href="{{ asset('public/plugins/toastr/toastr.min.css?ver='.$appFileVersion) }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('public/css/social-media/posts.css?ver='.$appFileVersion) }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('public/css/social-media-common.css?ver='.$appFileVersion) }}" />
    <style>
        .tooltip{
            background-color: #D8D8DA !important;
            color: black !important;

        }
        .tooltip-inner{
            background-color: #D8D8DA !important;
            color: black !important;
            max-width: 260px !important;
            text-align: center;
        }
        .tooltip-arrow{
            display: none;
        }

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

         .switch {
             position: relative;
             display: inline-block;
             width: 60px;
             height: 34px;
         }


        .slider {
            position: absolute;
            cursor: pointer;
            height: 26px;
            width: 51px;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }


    </style>
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('public/plugins/toastr/toastr.min.js?ver='.$appFileVersion) }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/connect-apps.js?ver='.$appFileVersion) }}"></script>
    <script src="{{ asset('public/js/auth-manager.js?ver='.$appFileVersion) }}"></script>
    <script src="{{ asset('public/js/business-manager.js?ver='.$appFileVersion) }}"></script>
    <script type="text/javascript" src="{{ asset("public/js/image-branding.js?ver=$appFileVersion") }}"></script>


@endsection
