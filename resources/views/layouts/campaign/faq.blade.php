@extends('index')

@section('pageTitle', 'Automated Emails')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid dashboarbgtitle">
            <div class="dashboard-wrapper campaign-list">
                <div class="page-head">
                        <div id="faq" class="row col-xs-12 col-sm-12 ">
                            <div class=" ">
                                <h4 class="page-title text-left ">FAQs</h4>
                            </div>
                            <div class="">
                                <h1 class="contact-des" style="font-size: 35px !important;" >Credits</h1>
                                <p class="faq-p">We are a DIY marketing platform where you buy and use credits to have your practice marketing tasks completed by our team of marketing professionals.</p>
                                <h3 class="faq-title">How do Credits work?</h3>
                                <p class="faq-p">Credits are deducted from your account each time you purchase a service to complete a task. The number of credits it costs to complete a task vary depending on the complexity and time required to complete the task.</p>
                                <h3 class="faq-title">Buying credits</h3>
                                <p class="faq-p">Pay for your credits by credit card only. You will always be able to view your credit balance and the credits needed for each task. Credits never expire. If you are unable to use your credits, your credits will remain in your account until you are ready to use them again.</p>
                                <h3 class="faq-title">How much do credits cost?</h3>
                                <p class="faq-p">Each credit is $10. If you buy email credits in bulk you can get access to lower prices than our individual rates.</p>
                                <h3 class="faq-title">Do you offer refunds on credits?</h3>
                                <p class="faq-p">We do not offer refunds. They have no expiry date and can be used anytime.</p>


                            </div>
{{--                            <h3 class="contact-des">Why use email credits?</h3>--}}
{{--                            <div class="" style="margin-left: 30px;">--}}
{{--                                    <h2 class="faq-title">How much do credits cost?</h2>--}}
{{--                                    <p class="faq-p">Our price is $10/credit.</p>--}}
{{--                                    <h2 class="faq-title">Do my credits expire?</h2>--}}
{{--                                    <p class="faq-p">No, credits do not expire. Use your credits at your own pace.</p>--}}
{{--                                    <h2 class="faq-title">What happens when I run out of credits?</h2>--}}
{{--                                    <p class="faq-p">Any time you attempt to complete a task with your credits, the website will prompt you to get more. You can always buy more credits.</p>--}}
{{--                                    <h2 class="faq-title">Do you offer refunds on credit packs?</h2>--}}
{{--                                    <p class="faq-p">We do not offer refunds on credit pack purchases.</p>--}}

{{--                            </div>--}}
{{--                            <h3 class="contact-des">FAQ</h3>--}}
{{--                            <div class="" style="margin-left: 30px; margin-bottom: 50px;    ">--}}
{{--                                <h2 class="faq-title">Reduce transactions</h2>--}}
{{--                                <p class="faq-p">If you find it inconvenient to make lots of small credit card transactions to cover account usage, you can instead buy credits. This way only one credit card transaction is made and there may be enough credits to last a few months or more.</p>--}}
{{--                                <h3 class="faq-title">Save money</h3>--}}
{{--                                <p class="faq-p">If you buy email credits in bulk you can get access to lower prices than our base rates.</p>--}}

{{--                            </div>--}}
                        </div>


                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
<style>
    .faq-title{
        font-weight: 600 !important;
        font-size: 22px !important;
    }
    .faq-p{
        font-size: 18px !important;
    }
</style>
@endsection

@section('js')

@endsection

{{--@extends('index')--}}

{{--@section('pageTitle', 'Advanced SEO')--}}

{{--@section('content')--}}
{{--    <div id="page-wrapper">--}}
{{--        <div class="container-fluid dashboarbgtitle">--}}
{{--            <div class="dashboard-wrapper website-content-page">--}}

{{--                <div class="page-head">--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-sm-12">--}}
{{--                            <h4 class="page-title">FAQ</h4>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="row">--}}
{{--                    <div class="col-md-12">--}}
{{--                        <div class="faq">--}}
{{--                            <h1 class="contact-des"style="font-size: 35px !important;" >Credits</h1>--}}
{{--                            <p class="faq-p">We are a DIY marketing platform where you buy and use credits to have your practice marketing tasks completed by our team of marketing professionals.</p>--}}
{{--                            <h3 class="faq-title">How do Credits work?</h3>--}}
{{--                            <p class="faq-p">Credits are deducted from your account each time you purchase a service to complete a task. The number of credits it costs to complete a task vary depending on the complexity and time required to complete the task.</p>--}}
{{--                            <h3 class="faq-title">Buying credits</h3>--}}
{{--                            <p class="faq-p">Pay for your credits by credit card only. You will always be able to view your credit balance and the credits needed for each task. Credits never expire. If you are unable to use your credits, your credits will remain in your account until you are ready to use them again.</p>--}}
{{--                            <h3 class="faq-title">How much do credits cost?</h3>--}}
{{--                            <p class="faq-p">Each credit is $10. If you buy email credits in bulk you can get access to lower prices than our individual rates.</p>--}}
{{--                            <h3 class="faq-title">Do you offer refunds on credits?</h3>--}}
{{--                            <p class="faq-p">We do not offer refunds. They have no expiry date and can be used anytime.</p>--}}


{{--                        </div>--}}
{{--                        <div class="custom-post-box">--}}
{{--                            --}}
{{--                            <div class="row responsive-row">--}}
{{--                                <div class="col-sm-8">--}}
{{--                                    <h1 class="font-normal">Rank at the Top of Search Results</h1>--}}
{{--                                    <p class="m-b-15">--}}
{{--                                        Want the help of an SEO professional? Our team will implement an advanced SEO strategy to MAXIMIZE your rankings and traffic in a strategic way. Gain more new patients and become the top provider in your niche.--}}
{{--                                    </p>--}}
{{--                                    <button class="btn btn-primary">Upgrade Now</button>--}}
{{--                                    <button class="btn btn-default text-primary m-l-10">Learn More</button>--}}
{{--                                </div>--}}
{{--                                <div class="col-sm-4">--}}
{{--                                    <img src="{{ asset('public/images/advanced-seo.png') }}" alt="social" style="width: 100%;height: auto;">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}


{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endsection--}}

{{--@section('css')--}}

{{--@endsection--}}

{{--@section('js')--}}
{{--    <script type="text/javascript" src="{{ asset('public/js/expert-manager.js') }}"></script>--}}
{{--@endsection--}}
