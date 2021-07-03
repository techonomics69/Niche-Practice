@extends('index')

@section('pageTitle', 'Credits Plans')

@section('content')
<div id="page-wrapper">
    <div class="container dashboarbgtitle upgrade-plan-container">
        <div class="">
            <div class="page-head" style="margin-top: 40px;">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="page-title text-center">Stock Up On Campaign Credits
{{--                            <a class="page-help" href="javascript:void(0)">--}}
{{--                                <i class="fa fa-question-circle-o" style="color: #7d8080;/* transform: scaleX(-1); */margin-right: 5px;"></i>--}}
{{--                                <img class="help-info-image" src="{{ asset('public/images/information.png') }}" />--}}
{{--                            </a>--}}
                        </h4>
                        <p class="page-subheading text-center stock-up-des" style="padding-top: 8px;" >The more you buy, the more you save! Use them as you go when you need the little extra help!
                        </p>
                        <hr class="section-divider">
                    </div>
                </div>
            </div>

            <div class="upgrade-plan-wrapper credits-wrapper upgrade-plan-boxs">
                <div class="row">
                    <div class="col-md-12">
                        <div class="choose-plan">
{{--                            <h3 class="c-p-heading">--}}
{{--                                Choose your Plan--}}
{{--                                Select a Credit package--}}
{{--                            </h3>--}}
                            <div class="col-md-12" style="padding-left: 0;margin-bottom: 20px">
                                {{--                                        @if(!empty($type))--}}
                                {{--                                            @foreach($type as $row)--}}
                                {{--                                                <a href="javascript:void(0)" class="btn template-link" data-id="{{ $row['id'] }}">{{ $row['name'] }}</a>--}}
                                {{--                                            @endforeach--}}
                                {{--                                        @endif--}}
                                {{--                                        <a href="javascript:void(0)" class="btn template-link" onMouseOver="this.style.color='#23527c'"--}}
                                {{--                                           onMouseOut="this.style.color='#23527c'"  data-toggle="tab"  data-id="1">Niche Campaigns</a>--}}
                                {{--                                        <a href="javascript:void(0)" class="btn template-link no-hov" onMouseOver="this.style.color='#23527c'"--}}
                                {{--                                           onMouseOut="this.style.color='#23527c'" data-toggle="tab" data-id="2">Premium Campaigns</a>--}}
                                <a href="javascript:void(0)" class="btn credit-link no-hov" data-toggle="tab" data-id="1">Campaign Marketplace</a>
                                <a href="javascript:void(0)" class="btn credit-link" data-toggle="tab" data-id="2">SMS</a>
                            </div>

                            <div class="credits-info" style="display: none;">
                                @if(!empty($creditPlan))
                                    @foreach($creditPlan as $index => $credit)
                                        <div class="col-md-4 p-l-0 m-b-15">
                                            <div class="text-center bg-white">

                                                @if($index == 3)
                                                    <p class="credit-card-recommended">Recommended</p>
                                                @elseif($index == 5)
                                                    <p class="credit-card-red">Best Value</p>
                                                @endif

                                                <h3 class="credit-number-title" style="" >{{ $credit['credits_of_this'] }} CREDITS</h3>
                                                <p style="font-size: 12px; font-weight: 700; color: #A5A7AA;" >${{ $credit['credit_rate'] }} PER CREDIT</p>
                                                <h3 style="color: #62B43C; font-weight: 600;">${{ $credit['price'] }}</h3>

                                                {{--                                            <button>Buy Credits</button>--}}

                                                <button data-package-purchase="{{ $credit['price_id'] }}" class="btn credit-btn-buy">
                                                    Buy Now
                                                </button>
                                            </div>
                                            {{--                                        <div class="text-center bg-white">--}}




                                            {{--                                            <h1 class="credit-h3-padding">${{ $credit['price'] }}</h1>--}}
                                            {{--                                            <p class="credit-p-size">{{ $credit['credits_of_this'] }} Credits</p>--}}
                                            {{--                                            <button data-package-purchase="{{ $credit['price_id'] }}" class="btn btn-primary credit-btn-buy">--}}
                                            {{--                                                Buy Now--}}
                                            {{--                                            </button>--}}
                                            {{--                                        </div>--}}
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="sms-info" style="display: none;">
                                @if(!empty($creditPlan))
                                    @foreach($creditPlan as $index => $credit)
                                        @if( $index >= 3 )
                                            <?php
                                            continue;
                                            ?>
                                        @endif
                                        <div class="col-md-4 p-l-0 m-b-15">
                                            <div class="text-center bg-white">

                                                @if($index == 3)
                                                    <p class="credit-card-recommended">Recommended</p>
                                                @elseif($index == 5)
                                                    <p class="credit-card-red">Best Value</p>
                                                @endif

                                                <h3 class="credit-number-title" style="" >{{ $credit['credits_of_this'] }} CREDITS</h3>
                                                <p style="font-size: 12px; font-weight: 700; color: #A5A7AA;" >${{ $credit['credit_rate'] }} PER CREDIT</p>
                                                <h3 style="color: #62B43C; font-weight: 600;">${{ $credit['price'] }}</h3>

                                                {{--                                            <button>Buy Credits</button>--}}

                                                <button data-package-purchase="{{ $credit['price_id'] }}" class="btn credit-btn-buy">
                                                    Buy Now
                                                </button>
                                            </div>
                                            {{--                                        <div class="text-center bg-white">--}}




                                            {{--                                            <h1 class="credit-h3-padding">${{ $credit['price'] }}</h1>--}}
                                            {{--                                            <p class="credit-p-size">{{ $credit['credits_of_this'] }} Credits</p>--}}
                                            {{--                                            <button data-package-purchase="{{ $credit['price_id'] }}" class="btn btn-primary credit-btn-buy">--}}
                                            {{--                                                Buy Now--}}
                                            {{--                                            </button>--}}
                                            {{--                                        </div>--}}
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                        </div>
                    </div>
                </div>

                <div class="">
                    <h1 class="contact-des" style="font-size: 26px !important;" >FAQs</h1>
                    <h3 class="faq-title-credit">How it works</h3>
                    <p class="faq-p-credit">The credits you purchase are immediately added to your account.
                        When you purchase a campaign,
{{--                        request a Marketing Pro service to--}}
{{--                        complete a specific task,--}}
                        the number of credits for that service is deducted from your account.
{{--                        The number of credits it costs to complete a task vary depending on the complexity and time required to complete the task.--}}
                    </p>
                    <h3 class="faq-title-credit">Can I get a refund for credits not used?</h3>
                    <p class="faq-p-credit">We do not offer refunds. Credits never expire. If you are unable to use your credits, your credits will remain in your account until you are ready to use them again.</p>
                    <h3 class="faq-title-credit">What can I use credits for?</h3>
                    <p class="faq-p-credit">Credits can be used for any campaigns or media from the campaign marketplace.</p>
{{--                    <p class="faq-p-credit">-Need a blog post written on your chosen niche?  Get an SEO Audit to find out how you can improve your ranking. Develop a promotion for the holiday season. </p>--}}
{{--                    <h3 class="faq-title-credit">Manage Your Expenses</h3>--}}
{{--                    <p class="faq-p-credit">With pre-purchased credits, you’ll always stay on budget, without having to constantly track your spending. Pay for what you want and need without the bloated services and costs found in most marketintg packages.  </p>--}}


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
    <style>
        .credit-link {
            background-color: #aaaaaa;
            color: white;
            font-weight: 800;
            font-size: 15px;
            width: 200px;
        }
        .credit-link:hover {
            color: white;
        }
    </style>

@endsection

@section('js')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        $(function () {
            if(decodeURIComponent($.urlParam('purchase')) === 'success_complete')
            {
                var credits = decodeURIComponent($.urlParam('credits'));
                var orderCredits = decodeURIComponent($.urlParam('order_credits'));

                // swal("", "Credits Purchased successfully.", "success");


                var mainModel = $('#main-modal');
                $(".modal-body, .modal-footer, .validate-me", mainModel).remove();
                $(mainModel).removeClass('welcome-process');
                $(mainModel).addClass('popup-successful');
                var html = '';
                var statusMessage = 'aad';
                var baseUrl = 'aad';
                html +=
                    '<div class="modal-body">\n' +
                    '    <h1 class="modal-order-title text-center">You purchase was successful!</h1>\n' +
                    '                                        <div class="row text-center">\n' +
                    '                                            <p>You have '+credits+' available credits to be used.</p>\n' +
                    '                                        </div>\n' +
                    '                                        <hr/>' +
                    ' <div class="row order-credit-action">\n' +
                    '                                            <div class="footer-box border ">\n' +
                    '                                                <p class="p-t-10 text-center">confirm order</p>\n' +
                    '                                                <table class="table">\n' +
                    '                                                    <thead>\n' +
                    '                                                    <tr>\n' +
                    '                                                        <th>item</th>\n' +
                    '                                                        <th style="text-align: right;padding-right: 40px;">no. of Units</th>\n' +
                    '\n' +
                    '                                                    </tr>\n' +
                    '                                                    </thead>\n' +
                    '                                                    <tbody>\n' +
                    '                                                    <tr>\n' +
                    '                                                        <td>Credits</td>\n' +
                    '                                                        <td style="text-align: right;padding-right: 40px;">'+orderCredits+' Credits</td>\n' +
                    '                                                    </tr>\n' +
                    '                                                    </tbody>\n' +
                    '                                                </table>\n' +
                    '                                            </div>\n' +
                    '\n' +
                    '                                            <button class="btn btn-confirm">Confirm and continue</button>\n' +
                    '\n' +
                    '                                        </div>' +
                    '                                </div>\n';

                $(".modal-title").remove();
                $('.modal-header').prepend('<i class="fa fa-check-circle "></i>');
                // $('.modal-body', mainModel).html(html);
                $(".modal-header", mainModel).after(html);

                mainModel.modal('show');



                var uri = window.location.toString();
                // console.log("uri");
                // console.log(uri);
                var clean_uri = uri.substring(0, uri.indexOf("credits"));
                clean_uri = clean_uri + 'credits';
                // console.log(clean_uri);
                window.history.replaceState({}, document.title, clean_uri);
            }
        });

        var stripeKey="<?php echo $stripeKey; ?>";

        $(".credit-btn-buy").click(function () {
            var siteUrl = $('#hfBaseUrl').val();

            var package = $(this).attr("data-package-purchase");
            showPreloader();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                type: "POST",
                url: siteUrl + "/done-me",
                data: {
                    send: 'billing-purchase-credits',
                    id: package,
                },
                // contentType: false,
                // cache: false,
                // processData: false,
                // data: formData,
            }).done(function (result) {
                var json = $.parseJSON(result);
                var statusCode = json.status_code;
                var statusMessage = json.status_message;
                var data = json.data;

                if(statusCode == 200)
                {
                    var id = data.id;

                    var stripe = Stripe(stripeKey);

                    stripe.redirectToCheckout({
                        // Make the id field from the Checkout Session creation API response
                        // available to this file, so you can provide it as parameter here
                        {{-- instead of the {{CHECKOUT_SESSION_ID}} placeholder.--}}
                        // sessionId: 'cs_test_US95eIGiMXJvvJSXYFjz7rc0Z8wHu8UBKN7JHFtp2MLOve5yaluG1Pjz'
                        sessionId: id
                    }).then(function (result) {
                        // console.log("stripe inner");

                        hidePreloader();
                        swal("", "Please try again", "error");
                        // If `redirectToCheckout` fails due to a browser or network
                        // error, display the localized error message to your customer
                        // using `result.error.message`.
                    });
                }
                else
                {
                    hidePreloader();
                    swal("", statusMessage, "error");
                }
            });
        });

        $(document.body).on('click',".btn-confirm",function () {
            var mainModel = $('#main-modal');
            mainModel.modal('hide');
        });
    </script>
    <script>

        // $(function () {
        //     $('.template-link').click();
        // });
        // toggle free and premium template
        $(document).ready(function () {
            $('.credit-link').click(function () {
                var id = $(this).attr('data-id');
                var baseUrl = $('#hfBaseUrl').val();
                $(".credit-link").removeClass('template-link-active');

                $(this).addClass('template-link-active');
                if( id == 1 ) {
                    $(".credits-info").show();
                    $(".sms-info").hide();
                }
                else {
                    $(".credits-info").hide();
                    $(".sms-info").show();
                }
            });
        });

    </script>
    <script>
        $(document).on('ready', function () {
            $('.credit-link[data-id=1]').click();
        });
    </script>
@endsection
