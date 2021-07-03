@extends('master')

@section('pageTitle', 'Register')

@section('content')
    <div class="new-login-box">
        <div class="login-logo">
            <img align="NichePractice" src="{{ asset('public/images/logo-register.png') }}" class="logo" />
            <div class="login-link text-right right"><a href="{{ route('login') }}">Log in</a></div>
        </div>
        <div class="login-heading">
            <h3 class="box-title m-b-0 m-t-10">Start your 14-day free trial. No credit card Required</h3>
        </div>

        <div class="col-sm-6 col-sm-offset-3 p-0">
            <div class="white-box m-t-0 m-b-0 p-b-0">
                <form class="form-horizontal validate-me new-lg-form" role="form" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    {{--<div class="form-group business-section" style="display: block !important;">--}}
                    <div class="form-group business-section" style="display: block !important;">
                    <div class="form-group business-section" style="display: block !important;">
                        <div class="row">
                            <div class="col-sm-12 practice-container">
                                <div class="putin">
{{--                                    <input type="text" class="input-field form-control" id="practice-name" name="practice_name" placeholder="" value="" data-required="true">--}}
                                    <input type="text" class="input-field form-control" id="practice-name" name="practice_name" placeholder="" value="" data-required="true" autocomplete="off">
                                    <label class="input-label" for="practice-name">
                                        <span class="label-text">Practice Name *</span>
                                    </label>
                                    <input type="hidden" id="business-address" name="address" placeholder="" value="">
                                    <input type="hidden" name="country" id="country" value="">
                                    <input type="hidden" name="state" id="state" value="">
                                    <input type="hidden" name="city" id="city" value="">
                                    <input type="hidden" name="postal_code" id="postal_code" value="">
                                    <span class="help-block hide-me"><small></small></span>
                                </div>
                            </div>

                            <div class="col-sm-12 business-selected-box" style="display: none;">
                                <div class="selected-business">
                                    <a href="javascript:void(0);" class="close-me">x</a>
                                    <span class="item-query"><span class="pac-matched"></span></span>
                                    <span class="address-detail"></span>
                                </div>
                            </div>


                            <div class="col-sm-12 manual-business-box" style="display: none;">
                                <div class="manual-add-business"><span class="item-query" style="display: inline-block;font-weight: 400;font-size: 14px;color: #7c889c !important;"><span class="pac-matched">Can't find your business?</span></span>
                                    Add your business manually </div>
                            </div>

                            {{--auto, manual--}}
                            <input type="hidden" class="business-discovery-status" name="practice_status" id="practice-status" value="manual" />
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="putin">
                                    <input type="text" class="input-field form-control register-form-res " id="first-name" name="first_name" value="" data-required="true" >
                                    <label class="input-label" for="first-name">
                                        <span class="label-text">First Name *</span>
                                    </label>
                                    <span class="help-block hide-me"><small></small></span>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="putin">
                                    <input type="text" class="input-field form-control" id="last-name" name="last_name" value="" data-required="true" />
                                    <label class="input-label" for="last-name">
                                        <span class="label-text">Last Name *</span>
                                    </label>
                                    <span class="help-block hide-me"><small></small></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group optional-section">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="putin">
                                    <input type="text" class="input-field form-control" id="website" name="website" value="">
                                    <label class="input-label" for="website">
                                        <span class="label-text">Website URL</span>
                                    </label>
                                    <span class="help-block hide-me"><small></small></span>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="putin">
                                    <input type="text" class="input-field form-control" id="phone" name="phone" value="" data-required="true">
                                    <label class="input-label" for="phone">
                                        <span class="label-text">Phone Number *</span>
                                    </label>
                                    <span class="help-block hide-me"><small></small></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="putin active">
                                    <input type="text" class="input-field form-control register-form-res " id="email" name="email" value="" data-required="true">
                                    <label class="input-label" for="email">
                                        <span class="label-text">Email Address *</span>
                                    </label>
                                    <span class="help-block hide-me"><small></small></span>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="putin active">
                                    <input type="password" class="input-field form-control" id="password" name="password" value="" data-required="true">
                                    <label class="input-label" for="password">
                                        <span class="label-text">Password *</span>
                                    </label>
                                    <span class="help-block hide-me"><small></small></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="heading-default">
                        <h3>Select a Practice Niche</h3>
                    </div>

                    <div class="form-group m-b-5">
                        <div class="row">
                            <div class="col-sm-6">
                                <select class="form-control select2 register-form-res" name="industry" id="industry" data-required="true">
                                    <option value="">Select an Industry</option>
                                    @foreach($industry as $row)
                                    @if (ucwords(strtolower($row['name'])) != 'Dentistry')
                                <option value="{{ $row['id'] }}" disabled>{{ ucwords(strtolower($row['name'])) }} (Coming soon)</option>

                                    @else
                                    <option value="{{ $row['id'] }}">{{ ucwords(strtolower($row['name'])) }}</option>

                                    @endif
                                    @endforeach
                                </select>
                                <span class="help-block"><small></small></span>
                            </div>

                            <div class="col-sm-6">
                                <select class="form-control select2" name="niche_id" id="niche" data-required="true" disabled="disabled">
                                    <option value="">Select a Niche</option>
                                </select>
                                <span class="help-block"><small></small></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group action-center text-center m-t-10">
                        <button class="btn submit full-btn" type="submit">CREATE MY ACCOUNT</button>
                        <span class="color_15">
                        By signing up, you agree to our &nbsp;
                        <span style="text-decoration:underline;">
                            <a href="https://nichepractice.com/terms-conditions" target="_blank">Terms &amp; conditions</a></span>
                        &nbsp;and&nbsp;
                        <span style="text-decoration:underline;">
                            <a href="https://nichepractice.com/privacy-policy" target="_blank">Privacy policy</a>
                        </span>
                    </span>
                    </div>
                    <div class="form-group m-b-0 response-message" style="display: none;">
                    </div>
                        <input type="hidden" id="custId" name="custId" value="<?php if(!empty($_GET['u_id'])){ echo base64_decode($_GET['u_id']); }  ?>">
                </form>
            </div>
        </div>

    </div>
@endsection

@section('css')
    <link type="text/css" href="{{ asset('public/plugins/custom-select/custom-select.css') }}" rel="stylesheet" />

    <style>

        .putin {
            position: relative;
            /*margin-top: 20px;*/
        }
        .putin .input-field {
            width: 100%;
            position: relative;
            -webkit-transition: all 300ms;
            transition: all 300ms;
            /*margin-bottom: 10px;*/
            border-radius: 3px;
            border: 1px solid #aaaaaa !important;
            height: 45px !important;
            box-shadow: none !important;
        }
        .putin.active .input-field{
            padding-top: 25px;
            /*box-shadow: 0 0 3px 2px rgba(1, 161, 254, 0.51);*/
            /*border-color: transparent;*/
        }
        /*.putin .input-field:focus,*/
        /*.putin .input-field:active{*/
        /*border-color: transparent !important;*/
        /*outline: none !important;*/
        /*}*/

        .putin .input-label {
            position: absolute;
            bottom: 0;
            left: 0;
            margin-bottom: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
        .putin .input-label .label-text {
            display: inline-block;
            position: absolute;
            left: 6px;
            top: 23px;
            -webkit-transform: translateY(-50%);
            transform: translateY(-50%);
            z-index: 100;
            -webkit-transition: all 300ms;
            transition: all 300ms;
            pointer-events: none;
            color: #323232;
            padding: 0.5em 0.3em;
        }

        .putin.active .input-label .label-text {
            top: 10px;
            font-size: 13px;
        }

        /*    select*/

        .new-login-box .white-box .form-control{

        }
        .new-login-box .white-box .form-control:focus{
            border-width: 1px;
            /*border-color: transparent !important;*/
            /*box-shadow: 0 0 3px 2px rgba(1, 161, 254, 0.51);*/
        }

    </style>
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('public/plugins/custom-select/custom-select.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/validator.js?ver='.$appFileVersion) }}"></script>

    @if($appEnvIs == 'production')
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCCuo6lEQ9qXyD15di5gEd6tHuWNfamC0A&libraries=places"></script>
{{--        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBmEuR0mYUyTCXEmhgOgw0euY6YW2pom2E&libraries=places"></script>--}}
{{--        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDIPbhytGCc5Oc6u41jD3n25AeVTfDXezM&libraries=places"></script>--}}
    @else
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCCuo6lEQ9qXyD15di5gEd6tHuWNfamC0A&libraries=places"></script>
{{--        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDIPbhytGCc5Oc6u41jD3n25AeVTfDXezM&libraries=places"></script>--}}
    @endif


    <script type="text/javascript" src="{{ asset('public/js/register.js?ver='.$appFileVersion) }}"></script>
    {{--<script async defer src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBKCSjuyFTSMyV71zvqyNLwhaPS9qzkSSM&callback=initMap" type="text/javascript"></script>--}}

    {{--<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>--}}


    <script>
        (function(){
            $('input.input-field').each(function(e){
                if( $(this).val() !== '' ) {
                    $(this).parent().addClass('active')
                }
                $(this).on('focus', focus);
                $(this).on('blur', blur);
            });
            function focus(e) {
                $(this).parent().addClass('active')
            }
            function blur(e) {
                if( e.target.value.trim() === '' ) {
                    $(this).parent().removeClass('active')
                }
            }
        })();

        /**
         * if value is empty then return true.
         * else not empty return false.
         * @param val
         * @returns {boolean}
         * 0 was considered as empty so I put restrict check.
         */
        function isEmptyValNormal(val) {
            if((!val))
            {
                // console.log("val ");
                // console.log(val);
                if(val === 0)
                {
                    // console.log("inner if");
                    return false;
                }

                return true;
            }

            return false;
            // return (!val) ? true : false;
        }
    </script>
@endsection
