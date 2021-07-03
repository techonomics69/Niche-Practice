@extends('index')

@section('pageTitle', 'Marketing Tasks')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid dashboarbgtitle">
            <div class="dashboard-wrapper blog-page marketing-wrapper">
                <div class="page-head">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="page-title text-center" style="font-size: 45px; margin: 20px 0px 30px 0px;"> Upgrade to Make Your Practice Goals a Reality
                            </h4>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 task-issues">
                        <div class="white-box full-page-view" style="margin-bottom: 0px; min-height: 613px;">
                            <div class="page-content">
                                {{--                                <h3 class="box-title">--}}
                                {{--                                    To Do List--}}
                                {{--                                </h3>--}}
                                <div class="clearfix"></div>
                                <div class="website-task-panel">
                                    <div class="objective-filter-row" style="display: none;">
                                        <div class="row m-t-15">
                                            <div class="col-md-4">
                                                <div class="form-group m-t-10">
                                                    <label style="font-weight: 700">Select an Objective</label>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <div class="select2-container objective-filters select-picker form-control" id="s2id_autogen3"><a href="javascript:void(0)" class="select2-choice" tabindex="-1">   <span class="select2-chosen" id="select2-chosen-4">Today's High  Priority Task</span><abbr class="select2-search-choice-close"></abbr>   <span class="select2-arrow" role="presentation"><b role="presentation"></b></span></a><label for="s2id_autogen4" class="select2-offscreen"></label><input class="select2-focusser select2-offscreen" type="text" aria-haspopup="true" role="button" aria-labelledby="select2-chosen-4" id="s2id_autogen4"><div class="select2-drop select2-display-none select2-with-searchbox">   <div class="select2-search">       <label for="s2id_autogen4_search" class="select2-offscreen"></label>       <input type="text" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" class="select2-input" role="combobox" aria-expanded="true" aria-autocomplete="list" aria-owns="select2-results-4" id="s2id_autogen4_search" placeholder="">   </div>   <ul class="select2-results" role="listbox" id="select2-results-4">   </ul></div></div><select class="objective-filters select-picker form-control" tabindex="-1" title="" style="display: none;">
                                                        <option value="">Today's High  Priority Task</option><option value="15294">Increase Facebook Likes</option><option value="15295">Increase Facebook Reviews</option><option value="19152">Improve Facebook Rating</option><option value="15296">Increase Google Place Reviews</option><option value="17582">Improve Google Place Rating</option><option value="18189">Increase Foursquare Reviews</option><option value="15297">Increase Yelp Reviews</option><option value="19278">Improve Yelp Rating</option><option value="15298">Increase Tripadvisor Reviews</option><option value="17768">Improve Tripadvisor Rating</option><option value="15299">Increase Website Traffic</option><option value="15300">Improve Website SEO Ranking</option><option value="19153">Optimize Facebook Page</option><option value="15306">Optimize Tripadvisor Listing</option><option value="19333">Optimize Foursquare Listing</option><option value="17583">Optimize Google Place Listing</option><option value="15301">Citation Building</option>
                                                    </select>
                                                    <i class="icon-refresh fa fa-spinner fa-spin" style="display: none;"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 m-t-5">
                                            {{--                                            <span class="text-muted task-length" data-total-tasks="7">Tasks 7 Found</span>--}}
                                        </div>
                                        <div class="col-md-8">
                                            <div class="btn-group m-b-20 website-page-tabs">
                                                <ul class="nav nav-tabs rounded-tabs task-tabs" role="tablist">

                                                    <li role="presentation" class="active">
                                                        <a href="#open" role="tab">Do-It-Myself</a>
                                                    </li>

                                                    <li role="presentation"><a href="#skipped" role="tab">Do-It-For-Me</a></li>
                                                    {{--                                                    <li role="presentation" class="">--}}
                                                    {{--                                                        <a href="#all" role="tab">All</a>--}}
                                                    {{--                                                    </li>--}}
                                                </ul>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="tab-content website-task-list">
                                        <h4 class="page-title">Become Your Own Expert</h4>
                                        <div class="upgrade-ok-img">
                                            <div >
                                                <img src="{{ asset('public/images/ok.png') }} " style="width: 25px;">
                                            </div>
                                            <div class="upgrade-img-tick">
                                                <p>Access to marketing pros*</p>
                                            </div>
                                        </div>
                                        <div class="upgrade-ok-img">
                                            <div >
                                                <img src="{{ asset('public/images/ok.png') }} " style="width: 25px;">
                                            </div>
                                            <div class="upgrade-img-tick">
                                                <p>Online review monitoring</p>
                                            </div>
                                        </div>
                                        <div class="upgrade-ok-img">
                                            <div >
                                                <img src="{{ asset('public/images/ok.png') }} " style="width: 25px;">
                                            </div>
                                            <div class="upgrade-img-tick">
                                                <p>Basic content library</p>
                                            </div>
                                        </div>
                                        <div class="upgrade-ok-img">
                                            <div >
                                                <img src="{{ asset('public/images/ok.png') }} " style="width: 25px;">
                                            </div>
                                            <div class="upgrade-img-tick">
                                                <p>Online citations assessment</p>
                                            </div>
                                        </div>
                                        <div class="upgrade-ok-img">
                                            <div >
                                                <img src="{{ asset('public/images/ok.png') }} " style="width: 25px;">
                                            </div>
                                            <div class="upgrade-img-tick">
                                                <p>Website SEO audit</p>
                                            </div>
                                        </div>
                                        <div class="upgrade-ok-img">
                                            <div >
                                                <img src="{{ asset('public/images/ok.png') }} " style="width: 25px;">
                                            </div>
                                            <div class="upgrade-img-tick">
                                                <p>Email marketing</p>
                                            </div>
                                        </div>
                                        <div class="upgrade-ok-img">
                                            <div >
                                                <img src="{{ asset('public/images/ok.png') }} " style="width: 25px;">
                                            </div>
                                            <div class="upgrade-img-tick">
                                                <p>Social media posting & ready-made content</p>
                                            </div>
                                        </div>
                                        <div class="upgrade-ok-img">
                                            <div >
                                                <img src="{{ asset('public/images/ok.png') }} " style="width: 25px;">
                                            </div>
                                            <div class="upgrade-img-tick">
                                                <p>Customizable, out-of-the-boz promotional offers</p>
                                            </div>
                                        </div>
{{--                                        <div id="open" class="tab-pane active task-data-list">--}}
{{--                                            <img class="loader" src="{{ asset('public/images/loader.gif') }}" />--}}
{{--                                            <div id="accordion" class="task-list-wrapper panel-group">--}}
{{--                                                <ul>--}}
{{--                                                </ul>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 m-t-15">
                        <div class="upgrade-elite" style="display: none;">

                            <h3 class="upgrade-title text-center">
                                Upgrade to
                                <span class="package-title">DIY</span>
                            </h3>
                            <div class="testimonials-list">
                                <ul>
                                    <li>
                                        <div class="feedback-icon">
                                            <img src="https://localhost/nichepractice/public/images/feedback-icon.png">
                                        </div>
                                        <div class="feedback-text">
                                            <h3>TWICE AS MANY CORRECTIONS</h3>
                                            <p>Pick a plan to continue using nichepractice. Your card won't be charged until after your trial ends in 14 days.
                                            </p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="feedback-icon">
                                            <img src="https://localhost/nichepractice/public/images/feedback-icon.png">
                                        </div>
                                        <div class="feedback-text">
                                            <h3>TWICE AS MANY CORRECTIONS</h3>
                                            <p>Pick a plan to continue using nichepractice. Your card won't be charged until after your trial ends in 14 days.
                                            </p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="feedback-icon">
                                            <img src="https://localhost/nichepractice/public/images/feedback-icon.png">
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
                                            <img style="width: 300px;margin-left: 0px;" src="https://localhost/nichepractice/public/images/payment-successful.png">
                                            <h3 style="margin-top: 20px;    width: 100%;font-size: 22px;text-align: center;margin-left: 50px;">Payment successful</h3>
                                        </div>


                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="payment-section" style="">
                            <div class="example example2">
                                <form novalidate="">
                                    <div class="pay-with-card">

                                            <h3 class="page-title text-center" style="margin-top: 15px; font-size: 40px; font-weight: bold;">One Simple Low Cost</h3>
                                        <div class="payment-title">
                                            <h1 style="">Payment Details</h1>
                                            <div>
                                                <img src="{{ asset('public/images/payment lock.png') }} " style="width: 25px; margin: 19px 0px 6px 18px;">
                                            </div>
                                        </div>

                                        <div class="form-group m-b-0 cc-num">
                                            <label for="">Card Information:</label>
                                            <div id="credit_card_number" class="input empty"></div>
                                            <span class="brand"><i class="pf pf-credit-card" id="brand-icon"></i></span>
                                            <span id="credit_card_number_error" class="help-block"><small></small></span>



                                        </div>

                                        <div class="form-inline credit-card-details">
                                            <div class="form-group expiry-date">

                                                <div id="credit-card-expiry-date" class="input empty"></div>
                                                <span id="credit_card_expiry_date_error" class="help-block"><small></small></span>
                                            </div>
                                            <div class="form-group cvc-no">


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
                                            <button type="submit" class="btn btn-buy-package btn-block">Pay $<span class="price">499</span></button>
                                            <div class="error" role="alert">
                                                <i class="fa fa-exclamation-circle" style="font-size: 17px; color:red; margin-right: 2px;display: none;"></i>
                                                <span class="message"></span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>



                            <input type="hidden" id="selectedPackage" value="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('css')

@endsection

@section('js')
    <script src="{{ asset('public/js/task/tabs-task.js?ver='.$appFileVersion) }}"></script>
    <script>
        $(window).load(function(){
            $('.marketing-tabs').addClass('active');
            $('.marketing-tabs .nav-second-level').css('display', 'block');
        });
    </script>
@endsection
