@extends('index')

@section('pageTitle', 'User Profile')

@section('content')


{{--    mycode--}}

<style>

</style>


<div id="page-wrapper">
    <div class="container-fluid dashboarbgtitle upgrade-plan-container">
        <div class="dashboard-wrapper" >
            <div class="page-head">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="page-title text-center">Upgrade Live Test Package
                        </h4>

                        <hr class="section-divider">
                    </div>
                </div>
            </div>

            <div class="upgrade-plan-wrapper">
                <div class="row">
                    <div class="col-md-6">
                        <div class="choose-plan">
                            <h3 class="c-p-heading">
{{--                                Choose your Plan--}}
                                Choose The Plan That's Right For Your Practice
                            </h3>
                            <div class="choose-plan-list">
                                <ul>
                                    <li class="checked">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <Div class="package-content">
                                                    <div class="package-title">DIY</div>
                                                    <div class="package-price">
                                                        $<span class="pack-price">1</span>
                                                        <span>/ month</span></div>
                                                </Div>
{{--                                                <p class="package-desc">Upgrade today and don't pay until your free trial ends.</p>--}}
                                                <p class="package-desc">
                                                    Learn more
                                                </p>
                                            </div>
                                            <div class="col-md-2">
                                                <button class="btn btn-package-select package-diy" data-package="diy_test">Select</button>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="upgrade-elite">

                            <h3 class="upgrade-title text-center">
                                Upgrade to
                                <span class="package-title"></span>
                            </h3>
                            <div class="testimonials-list">
                                <ul>
                                    <li>
                                        <div class="feedback-icon">
                                            <img src="{{ asset('public/images/feedback-icon.png') }}">
                                        </div>
                                        <div class="feedback-text">
                                            <h3>TWICE AS MANY CORRECTIONS</h3>
                                            <p>Pick a plan to continue using nichepractice. Your card won't be charged until after your trial ends in 14 days.
                                            </p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="feedback-icon">
                                            <img src="{{ asset('public/images/feedback-icon.png') }}">
                                        </div>
                                        <div class="feedback-text">
                                            <h3>TWICE AS MANY CORRECTIONS</h3>
                                            <p>Pick a plan to continue using nichepractice. Your card won't be charged until after your trial ends in 14 days.
                                            </p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="feedback-icon">
                                            <img src="{{ asset('public/images/feedback-icon.png') }}">
                                        </div>
                                        <div class="feedback-text">
                                            <h3>TWICE AS MANY CORRECTIONS</h3>
                                            <p>Pick a plan to continue using nichepractice. Your card won't be charged until after your trial ends in 14 days.
                                            </p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="upgrade-detail" style="display: none;">

                            <h3 class="upgrade-title text-center" style="display: none;">
                                Selected Plan <span class="package-title">DIY</span>
                            </h3>
                            <div class="testimonials-list">
                                <ul>
                                    <li>
                                        <div class="feedback-text">
                                            <img style="width: 300px;margin-left: 0px;" src="{{ asset('public/images/payment-successful.png') }}" />
                                            <h3 style="margin-top: 20px;    width: 100%;font-size: 22px;text-align: center;margin-left: 50px;">Payment successful</h3>
                                        </div>
{{--                                        <div class="feedback-text" style="padding-left: 10px;">--}}
{{--                                        </div>--}}
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="payment-section" style="display:none;">
                            <div class="example example2">
                                <form novalidate>
                                    <div class="pay-with-card">
                                        <h3 class="p-w-c-title">Pay with card <span class="action-plan"></span></h3>

                                        <div class="form-group" style="display: none;">
                                            <label for="">Email address:</label>
{{--                                            <input type="email" value="" class="form-control" id="email"/>--}}
                                            <input id="email" type="email" class="form-control" value="{{ $userData['email'] }}" readonly>
                                        </div>

                                        <div class="form-group m-b-0 cc-num">
                                            <label for="">Card Information:</label>
                                            <div id="credit_card_number" class="input empty"></div>
                                            <span class="brand"><i class="pf pf-credit-card" id="brand-icon"></i></span>
                                            <span id="credit_card_number_error"
                                                  class="help-block"><small></small></span>

                                            {{--                                        <input type="text" class="form-control cc-no" placeholder="1234 1234 1234 1234" id="">--}}
                                            {{--                                        <img class="cc-icons" src="{{ asset('public/images/cc-icons.png') }}">--}}
                                        </div>

                                        <div class="form-inline credit-card-details">
                                            <div class="form-group expiry-date">
                                                {{--                                            <input type="text" class="form-control" placeholder="MM/YY" id="">--}}
                                                <div id="credit-card-expiry-date" class="input empty"></div>
                                                <span id="credit_card_expiry_date_error"
                                                      class="help-block"><small></small></span>
                                            </div>
                                            <div class="form-group cvc-no">
                                                {{--                                            <input type="text" class="form-control" placeholder="CVC" id="">--}}
                                                {{--                                            <img class="credit-card-cvv" src="{{ asset('public/images/credit-card.png') }}">--}}
                                                <div id="credit-card-cvc" class="input empty"></div>
                                                <span id="credit_card_cvc_error" class="help-block"><small></small></span>
                                            </div>
                                        </div>

                                        <div class="form-group p-t-15">
                                            <label for="">Name on Card:</label>
                                            <input type="text" class="form-control" id="name_on_credit_card" placeholder="Name on Credit Card">
                                            <span class="help-block"><small></small></span>
                                        </div>

                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="ZIP" id="zip_code">
                                        </div>

                                        <div class="form-group p-t-20">
                                            <button type="submit" class="btn btn-buy-package btn-block">Pay $<span class="price"></span></button>
                                            <div class="error" role="alert">
                                                <i class="fa fa-exclamation-circle"
                                                   style="font-size: 17px; color:red; margin-right: 2px;display: none;"></i>
                                                <span class="message"></span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="security-logo">
                                <img src="{{ asset('public/images/security-logo1.png') }}">
                                <img src="{{ asset('public/images/security-logo2.png') }}">
                            </div>

                            <input type="hidden" id="selectedPackage" value="" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <input type="hidden" id="package-selected" value="<?php echo (!empty($subscribedPackageDetail)) ? $subscribedPackageDetail['name'] : '';  ?>" />
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('public/payment-checkout/css/stripe-base.css?ver='.$appFileVersion) }}">
    <link rel="stylesheet" href="{{ asset('public/payment-checkout/css/style.css?ver='.$appFileVersion) }}">
@endsection

@section('js')
    <script src="https://js.stripe.com/v3/"></script>
    <script type="text/javascript" src="{{ asset('public/payment-checkout/js/stripe-custom-form-elements.js?ver='.$appFileVersion) }}"></script>
    <script type="text/javascript" src="{{ asset('public/payment-checkout/js/stripe-custom-form.js?ver='.$appFileVersion) }}"></script>
    <script>
        localStorage.removeItem('card_details');

        $(function () {
            setTimeout(function () {
                $(".choose-plan-list li button").click();
            }, 1000);
            $(".choose-plan-list li, .choose-plan-list li button").click(function (e) {
                // console.log(e);
                // console.log("inside");
                e.stopPropagation();
                var packageSection = $(".upgrade-elite");
                var packageDetail = $(".upgrade-detail");
                var paymentSection = $(".payment-section");

                $(".choose-plan-list li").removeClass("active");

                // console.log($(this));

                packageDetail.hide();
                paymentSection.hide();
                packageSection.hide();

                if($(this).hasClass("btn-package-select"))
                {
                    var parentElement = $(this).closest('li');

                    parentElement.addClass('active');

                    $(".action-plan").html("of " + parentElement.find('.package-title').html() + " Plan");
                    $(".price").html(parentElement.find(".pack-price").html());

                    // console.log("action ");
                    packageSection.hide();
                    paymentSection.show();
                }
                else
                {
                    if($(this).hasClass("selected") || $(this).hasClass("current-package-selected"))
                    {
                        $(this).addClass('active');

                        // console.log($(this).find('.package-title').html());

                        // var currentPackageSelector = $(".choose-plan-list .package-"+selectedPackage);

                        $(".package-title", packageDetail).html($('.current-package-selected').find('.package-title').html());
                        packageDetail.show();
                        packageSection.hide();
                    }
                    else
                    {
                        // console.log("elll");
                        $(this).addClass('active');
                        $(".package-title", packageSection).html($(this).find('.package-title').html());
                        paymentSection.hide();
                        packageSection.show();
                    }
                }
            });


            var selectedPackage = $("#package-selected").val();

            if(selectedPackage !== '')
            {
                var currentPackageSelector = $(".choose-plan-list .package-"+selectedPackage);

                currentPackageSelector.html('Selected');
                currentPackageSelector.addClass('selected');
                currentPackageSelector.removeClass('btn-package-select');

                $("ul").find($(currentPackageSelector).closest('li')).addClass('current-package-selected');

                // var parentElement = $("ul " + $(currentPackageSelector).closest('li'));
                // var parentElement = $($(currentPackageSelector).closest('li'), "ul");
                // var parentElement = $($(currentPackageSelector).closest('li'));

                // $($(currentPackageSelector).closest('li')).closest('ul').show();


                var elementIndex = $("ul").find($(currentPackageSelector).closest('li')).index();
                elementIndex++;

                // console.log("elementIndex " + elementIndex);

                $( ".choose-plan-list ul li:nth-child("+elementIndex+")").click();
            }
            else
            {
                $(".choose-plan-list li:first").click();
            }
        });
        function detectIndex() {
            // console.log("h");
            var selectedPackage = $("#package-selected").val();
            var currentPackageSelector = $(".choose-plan-list .package-"+selectedPackage);

            currentPackageSelector.html('Selected');
            currentPackageSelector.addClass('selected');

            // var parentElement = $("ul " + $(currentPackageSelector).closest('li'));
            var parentElement = $($(currentPackageSelector).closest('li'), "ul");

            // $($(currentPackageSelector).closest('li')).closest('ul').show();

            var elementIndex = $("ul").find($(currentPackageSelector).closest('li')).index();

            $( ".choose-plan-list ul li:nth-child("+elementIndex+")").click();

            // $($(currentPackageSelector).closest('li')).closest('ul').show();

            parentElement.hide();

        }
    </script>
@endsection
