@extends('index')

@section('pageTitle', 'OnBoarding')

@section('content')
    {{--    <div class="container-fluid Onboarding-body  ">--}}
    {{--        <div class="row">--}}
    {{--            <div class="col-12 logo1">--}}
    {{--                <img class="logo" src="{{ asset('public/images/logo-new.png') }}"/>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}

    <div class="contacts-list  Onboarding-body">
        <div class="container">
            <div class=" form-center onboarding-reg-page page-size-small ">
                <div class="center-logo1 text-center ">
                    <img class="logo" src="{{ asset('public/images/logo-new.png') }}"/>
                </div>

                <div class="card align-items-center" style=" margin: auto">
                    <div class="card-block text-center">
                        <h4 class="card-title">
                            {{--  Please verify your niche selection and Google account information. --}}
                            Please verify your account information / street address
                        </h4>
                        <p class="niche-head-text">Nichepractice uses this information to analyse your online presence
                            and provide you with a summary of your patient reviews (google, yelp and facebook),
                            SEO audit of your website, business directory listings and more. </p>
                        <p class="card-text text-left">
                            {{--                        Google returned this location information for your business. Please confirm that we have the correct details below.--}}
                        </p>
                    </div>
                    <form class="business-profile">
                        <div class="row" style="padding:0px 7px 0px 7px;">
                            <div class="form-row">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="putin active">
                                                <input type="text" class="input-field form-control input-field-one"
                                                       value="{{ $userBusiness['practice_name'] }}" disabled/>
                                                <label class="input-label" for="name">
                                                    <span class="label-text">Business Name *</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="putin">
                                                <input type="text" class="input-field form-control input-field-one"
                                                       value="{{ $userBusiness['niche']['industry']['name'] }}"
                                                       disabled="disabled"/>

                                                <label class="input-label" for="industry">
                                                    <span class="label-text">Industry</span>
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
                                                <select id="niche_id"
                                                        class="form-control input-field form-control register-form-res input-field-one "
                                                        name="niche_id" data-required="true">
                                                    @foreach($nichesList as $nicheRow)
                                                        <option
                                                            value="{{ $nicheRow['id'] }}" {{ selectedChosenValue($userBusiness['niche_id'], $nicheRow['id']) }}>{{ $nicheRow['niche'] }}</option>
                                                    @endforeach
                                                </select>
                                                <label class="input-label " for="password">
                                                    <span class="label-text">Niche *</span>
                                                </label>
                                                <span class="help-block hide-me"><small></small></span>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="putin active">
                                                <?php
                                                $disabled = false;
                                                foreach ($countries as $country) {
                                                    if (($userBusiness['country_id'] != 39 && $userBusiness['country_id'] != 233)
                                                        &&
                                                        (selectedChosenValue($userBusiness['country_id'], $country['id']) == 'selected')
                                                    ) {
                                                        $disabled = true;
                                                    }
                                                }
                                                ?>
                                                <select id="country_id"
                                                        class="form-control input-field form-control register-form-res input-field-one"
                                                        name="country_id"
                                                        data-required="true" {{ (!empty($disabled)) ? 'disabled' : ''  }}>
                                                    <option value="">Choose Country</option>
                                                    @if($userBusiness['practice_status'] == 'auto')
                                                        @foreach($countries as $country)
                                                            @if(($country['id'] == 39 || $country['id'] == 233 ))
                                                                <option
                                                                    value="{{ $country['id'] }}" {{ selectedChosenValue($userBusiness['country_id'], $country['id']) }}>{{ $country['name'] }}</option>
                                                            @elseif(selectedChosenValue($userBusiness['country_id'], $country['id']) == 'selected')
                                                                <option value="{{ $country['id'] }}"
                                                                        {{ selectedChosenValue($userBusiness['country_id'], $country['id']) }} disabled>{{ $country['name'] }}</option>
                                                            @else
                                                                <?php
                                                                continue;
                                                                ?>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        @foreach($countries as $country)
                                                            <option
                                                                value="{{ $country['id'] }}" {{ selectedChosenValue($userBusiness['country_id'], $country['id']) }}>{{ $country['name'] }}</option>
                                                        @endforeach
                                                    @endif

                                                </select>
                                                <label class="input-label " for="password">
                                                    <span class="label-text">Country *</span>
                                                </label>
                                                <span style="font-size: 12px">
                                                @foreach($countries as $country)
                                                        @if(!empty($userBusiness['country_id']) && ($userBusiness['country_id'] != 39 && $userBusiness['country_id'] != 233) && $country['id'] == $userBusiness['country_id'] )
                                                            *This Country is out of USA & CANADA You Cannot Change this.
                                                        @endif
                                                    @endforeach
                                            </span>
                                                <span class="help-block hide-me"><small></small></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="putin">
                                                <input type="text" class="input-field form-control input-field-one"
                                                       id="address"
                                                       value="{{ $userBusiness['address'] }}" data-required="true"/>
                                                <label class="input-label" for="address">
                                                    <span class="label-text">Address *</span>
                                                </label>
                                                <span class="help-block hide-me"><small></small></span>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="putin">
                                                <input type="text" class="input-field form-control input-field-one"
                                                       id="state"
                                                       value="{{ !empty($userBusiness['state']) ? $userBusiness['state'] : '' }}"
                                                       data-required="true"/>
                                                <label class="input-label" for="state">
                                                    <span class="label-text">State/ County / Region... *</span>
                                                </label>
                                                <span class="help-block hide-me"><small></small></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="putin">
                                                <input type="text" class="input-field form-control input-field-one"
                                                       id="city"
                                                       value="{{ !empty($userBusiness['city']) ? $userBusiness['city'] : '' }}"
                                                       data-required="true"/>
                                                <label class="input-label" for="city">
                                                    <span class="label-text">Town / City *</span>
                                                </label>
                                                <span class="help-block hide-me"><small></small></span>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="putin">
                                                <input type="text" class="input-field form-control input-field-one"
                                                       id="zip_code"
                                                       value="{{ !empty($userBusiness['zip_code']) ? $userBusiness['zip_code'] : '' }}"
                                                       data-required="true"/>
                                                <label class="input-label" for="zip_code">
                                                    <span class="label-text">Zipcode / Postal Code *</span>
                                                </label>
                                                <span class="help-block hide-me"><small></small></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="putin">
                                                <input type="text" class="input-field form-control input-field-one"
                                                       id="phone"
                                                       value="{{ !empty($userBusiness['phone']) ? $userBusiness['phone'] : '' }}"
                                                       data-required="true"/>
                                                <label class="input-label" for="phone">
                                                    <span class="label-text">Phone *</span>
                                                </label>
                                                <span class="help-block hide-me"><small></small></span>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="putin">
                                                <input type="text" class="input-field form-control input-field-one"
                                                       id="website"
                                                       value="{{ $userBusiness['website'] }}"/>
                                                <label class="input-label" for="website">
                                                    <span class="label-text">Website</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="" style="border-top: .06667rem solid #e1e1e1; margin-top: 20px;">
                            <div class="col-xs-12 pull-right" style="text-align: right">
                                <button type="submit" class="nextbutton btn-save" data-send="update-business-profile">
                                    Continue<i class="fa fa-chevron-right"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <input type="hidden" id="currentPage" value="onboarding"/>
@endsection

@section('css')
    <style>
        html {
            /*background: linear-gradient(-45deg,#547bba 0%,#1d2b3b 100%) !important;*/
            background-color: #33485B !important;
        }

        .form-center {
            /*width: 70%;*/
            width: 800px;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);

        }

        .center-logo1 {
            justify-content: center;
            text-align: center;
            /*padding: 30px 0px 30px 0px;*/
        }

        .form-row {
            margin-left: 20px;
            margin-right: 20px;
        }

        .logo1 {
            padding: 15px;
        }

        .Onboarding-body {
            /*background: linear-gradient(-45deg,#547bba 0%,#1d2b3b 100%);*/
            background-color: #33485B !important;
            background-attachment: fixed;
        }

        .card {
            padding: 20px 0px;
        }

        .card-title {
            Font-size: 22px;
            Font-weight: 700;
            Line-height: 26px;
            color: rgb(74, 74, 74);
            font-family: "source sans pro", "helvetica neue", Helvetica, Roboto, Arial, sans-serif;
            padding: 0px 0px 15px 0px;
        }

        .card-text {
            padding: .73333rem .73333rem .73333rem 1.3rem;
            border-top: .06667rem solid #e1e1e1;
        }

        .input-padding1 {
            margin: 0px 0px 0px 7px;
        }

        .prevButton {
            border: none;
            Email Campaigns
            background: none;
            font-size: 15px;
            margin-top: 15px;
            Font-size: 15px;

            Line-height: normal;
            color: rgb(130, 130, 130)
        }

        .nextbutton {
            Font-size: 15px;
            Font-weight: 700;
            Line-height: normal;
            color: rgb(63, 99, 156);
            border: none;
            background: none;
            font-size: 15px;
            margin-top: 15px;
        }

        .fa-chevron-left {
            font-size: 12px;
            padding: 0px 8px 0px 0px;
        }

        .fa-chevron-right {
            font-size: 12px;
            padding: 0px 0px 0px 8px;
        }

        input.form-control {
            border: .06667rem solid #c3c3c3;
        }

        select.form-control {
            border: .06667rem solid #c3c3c3;
        }

        .putin.active .input-field {
            padding-top: 18px;
        }

        .putin .input-label .label-text {
            left: 35px;
        }

        .putin.active .input-label .label-text {
            left: 5px;
        }

        /*@media screen and (max-width: 1463px) {*/
        /*    .center-logo1 {*/
        /*        padding: 30px 0px 30px 0px;*/
        /*    }*/
        /*}*/
        /*    @media screen and (max-width: 1366px) {*/
        /*        .center-logo1{*/
        /*            padding: 5px 0px 5px 0px;*/
        /*        }*/
        /*}*/
        /*@media screen and (max-width: 1280px) {*/
        /*    .center-logo1{*/
        /*        padding: 20px 0px 20px 0px;*/
        /*    }*/
        /*}*/
        @media screen and (max-width: 768px) {
            .form-center {
                width: 700px;
            }

        }

        @media screen and (max-width: 767px) {
            .form-group .col-sm-6:first-child {
                margin-bottom: 20px !important;
            }

            .onboarding-reg-page {
                margin-bottom: 30px;
            }

            /*.form-center{*/
            /*    margin-bottom: 20px;*/
            /*    */
            /*}*/

        }

        /*@media(min-width:900px) and (max-width:1500px) {*/
        /*    .center-logo {*/
        /*        padding: 70px 0px 70px 0px;*/
        /*    }*/
        /*}*/
        @media screen and (max-width: 700px) {
            .page-size-small {
                width: 100%;
                height: 100%;
                overflow: scroll;
                padding: 10px;

            }

        }

        .putin .input-field-one:focus {
            border: 3px solid #436AAE !important;
        }

        #address {
            border: 2px solid #33475B !important;
        }
    </style>
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('public/plugins/custom-select/custom-select.min.js') }}"></script>

    <script src="{{ asset('public/js/business-manager.js?ver='.$appFileVersion) }}"></script>
    <script>
        $(window).resize(function () {
            if (window.innerWidth < 740) {
                $('.onboarding-reg-page').removeClass('form-center');
            } else {
                $('.onboarding-reg-page').addClass('form-center');
            }
        });
    </script>

    <script>
        (function () {
            setTimeout(function () {
                $('input.input-field').each(function (e) {
                    if ($(this).val() !== '') {
                        $(this).parent().addClass('active')
                    }
                    $(this).on('focus', focus);
                    $(this).on('blur', blur);
                });
            }, 500)


            $('input.input-field').blur(function (e) {
                if ($(this).val() !== '') {
                    $(this).parent().addClass('active')
                }
                $(this).on('focus', focus);
                $(this).on('blur', blur);
            });

            function focus(e) {
                $(this).parent().addClass('active')
            }

            function blur(e) {
                if (e.target.value.trim() === '') {
                    $(this).parent().removeClass('active')
                }
            }
        })();
    </script>
@endsection


