@extends('index')

@section('pageTitle', 'SEO Audit')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid dashboarbgtitle">
            <div class="dashboard-wrapper" >
                <div class="page-head">
                    <div class="row">
                        <div class="col-xs-6">
                            <h4 class="page-title"> SEO Audit
{{--                                <a class="page-help" href="javascript:void(0)">--}}
{{--                                    <i class="fa fa-question-circle-o" style="color: #7d8080;/* transform: scaleX(-1); */margin-right: 5px;"></i>--}}
{{--                                    <img class="help-info-image" src="{{ asset('public/images/information.png') }}" />--}}
{{--                                </a>--}}
                            </h4>
                        </div>
                        <div class="col-xs-6">
                        </div>
                    </div>
                </div>

                <div class="website-audit">
                    @if(!empty($webResult))
                        <div class="website-audit-head">

                            <div class="row">
                                <div class=" col-md-6 col-sm-12 col-xs-12 text-center hidden-sm hidden-xs   " style="display: none">
                                    <div id="screenshot">
{{--                                            <div id="screenshotData" style="display:none;">--}}
{{--                                                --}}{{--<div class="loader">--}}
{{--                                                    --}}{{--<img class="{{ asset('public/images/transparent_loader.gif') }}" />--}}
{{--                                                --}}{{--</div>--}}
{{--                                                <div class="loader">--}}
{{--                                                    <div class="side"></div>--}}
{{--                                                    <div class="side"></div>--}}
{{--                                                    <div class="side"></div>--}}
{{--                                                    <div class="side"></div>--}}
{{--                                                    <div class="side"></div>--}}
{{--                                                    <div class="side"></div>--}}
{{--                                                    <div class="side"></div>--}}
{{--                                                    <div class="side"></div>--}}
{{--                                                </div>--}}
{{--                                                <div class="loaderLabel">Loading...</div>--}}
{{--                                            </div>--}}
                                            <div class="computer"></div>
                                        </div>
                                </div>
                                <div class=" col-md-6 col-sm-6 col-xs-12 text-center seo-audit-progress-bar  ">
                                    <div class="waudithead-center">
                                        <?php
                                            $domain = $webResult['domain'];
                                        ?>
                                        <a href="http://{{ getUrlDomain($domain) }}" class="website-url" target="_blank">{{ getUrlDomain($webResult['domain']) }}</a>
                                        {{--<label class="url-date">July 5, 2019 03:45:28 PM</label>--}}
                                        <?php
                                        $score = $webResult['score'];
                                        $improveScore = $webResult['improveScore'];
                                        $errorScore = $webResult['errorScore'];
                                        ?>
                                        <div class="pro-passed">
                                            <label>Passed</label>
                                            <div class="progress">

                                                <div class="progress-bar" role="progressbar" aria-valuenow="{{ $score }}" aria-valuemin="0" aria-valuemax="100" style="width:{{ $score }}%">
                                                    <span class="sr-only">{{ $score }}% Complete</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pro-to-improve">
                                            <label>To Improve</label>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="{{ $improveScore }}" aria-valuemin="0" aria-valuemax="100" style="width:{{ $improveScore }}%">
                                                    <span class="sr-only">{{ $improveScore }}% Complete</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pro-errors">
                                            <label>Errors</label>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="{{ $errorScore }}" aria-valuemin="0" aria-valuemax="100" style="width:{{ $errorScore }}%">
                                                    <span class="sr-only">{{ $errorScore }}% Complete</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="buttons-waudit" style="display: none;">
                                            <a href="javascript:void(0);" class="btn btn-primary btn-waudit">Download Report</a>
                                            <a href="javascript:void(0);" class="btn btn-primary btn-waudit">Update</a>
                                            <a href="javascript:void(0);" class="btn btn-primary btn-waudit">Compare</a>
                                            <a href="javascript:void(0);" class="btn btn-primary btn-waudit">Share</a>

                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 text-center ">
                                    <div class="grid w-audit-graph">
                                        <section>
                                            <svg class="circle-chart" viewBox="0 0 33.83098862 33.83098862" width="200" height="200" xmlns="http://www.w3.org/2000/svg" style="border-radius: 100px;">
                                                <circle class="circle-chart__background" stroke="#D6D7DA" stroke-width="2.5" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431"></circle>
                                                <circle class="circle-chart__circle" stroke="#3D4A9E" stroke-width="2.5" stroke-dasharray="{{ $score }},100" stroke-linecap="square" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431"></circle>
                                                <g class="circle-chart__info">
                                                    <text class="circle-chart__percent" x="16.91549431" y="15.5" alignment-baseline="central" text-anchor="middle" font-size="8">
                                                        {{ $score }}
                                                    </text>
                                                    <text class="circle-chart__percent" x="16.91549431" y="19" alignment-baseline="text-before-edge" text-anchor="middle" font-size="3">Score</text>
                                                </g>
                                            </svg>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php
                        $metaTitle = getIndexedvalue($metaData, 0);
                        $metaDescription = getIndexedvalue($metaData, 1);
                        $metaKeywords = getIndexedvalue($metaData, 2);
                    ?>

                        <div class="website-audit-body" style="display: none;">
                            <h3 class="w-audit-heading">Search Engine Optimization</h3>
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingOne">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                Title Tag
                                            </a>
                                        </h4>
                                    </div>

                                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                        <div class="panel-body">
                                            @if(!empty($metaTitle))
                                                <?php
                                                $lenTitle = mb_strlen($metaTitle,'utf8');
                                                ?>
                                                @if($lenTitle < 10)
                                                    <img src="{{ asset('public/images/icons/info.png') }}"/>
                                                @elseif($lenTitle < 70)
                                                    <img src="{{ asset('public/images/icons/checkmark.png') }}"/>
                                                    {{--<i class="fa fa-check-square-o success-icon" aria-hidden="true"></i>--}}
                                                @else
                                                    <i class="fa fa-window-close error-icon" aria-hidden="true"></i>
                                                @endif
                                                <h5 class="panel-desc"> {{ $metaTitle }} </h5>
                                            @else
                                                <i class="fa fa-window-close error-icon" aria-hidden="true"></i>
                                                <h5 class="panel-desc">No Title</h5>
                                                {{--<p>Length: 54 character(s)</p>--}}
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingTwo">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                Meta Description
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
                                        <div class="panel-body">

                                            @if(!empty($metaDescription))
                                                <?php
                                                $lenDes = mb_strlen($metaDescription,'utf8');
                                                ?>
                                                @if($lenDes < 70)
                                                    <img src="{{ asset('public/images/icons/info.png') }}"/>
                                                @elseif($lenDes < 300)
                                                    <img src="{{ asset('public/images/icons/checkmark.png') }}"/>
                                                @else
                                                    <i class="fa fa-window-close error-icon" aria-hidden="true"></i>
                                                @endif
                                                <h5 class="panel-desc"> {{ $metaDescription }} </h5>
                                            @else
                                                <i class="fa fa-window-close error-icon" aria-hidden="true"></i>
                                                <h5 class="panel-desc">No Description</h5>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="heading3">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                                Meta Keywords
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapse3" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading3">
                                        <div class="panel-body">

                                            <img src="{{ asset('public/images/icons/low.png') }}" />

                                            @if(!empty($metaKeywords))
                                                <h5 class="panel-desc"> {{ $metaKeywords }} </h5>
                                            @else
                                                <h5 class="panel-desc">No Keywords</h5>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse">
                                                keywords Cloud
                                            </a>
                                        </h4>
                                    </div>
                                    <div class="panel-collapse collapse in" role="tabpanel">
                                        <div class="panel-body">
                                            <img src="{{ asset('public/images/icons/low.png') }}" />
                                            @if(!empty($keywordsCloud[1]))
                                                <ul class="keywordsTags">
                                                    @foreach($keywordsCloud[1] as $keywordsCloudRow)
                                                        <li>
                                                            <span class="keyword">{{ $keywordsCloudRow[0] }}</span>
                                                            <span class="number">{{ $keywordsCloudRow[1] }}</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <h5 class="panel-desc">No Keywords</h5>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <h3 class="w-audit-heading">Usability</h3>

                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse">
                                                URL
                                            </a>
                                        </h4>
                                    </div>
                                    <div class="panel-collapse collapse in" role="tabpanel">
                                        <div class="panel-body">
                                            <?php
                                            //URL Length & Favicon
                                            $urlLengthMsg = '';
                                            $hostWord = explode('.', $domain);

//                                            "http://".$domain .'<br>'.
                                            $urlLengthMsg = str_replace( '[count]', strlen($hostWord[0]), "<strong>Length</strong> [count] characters" );
                                            ?>

                                            @if(strlen($hostWord[0]) < 15)
                                                <img src="{{ asset('public/images/icons/checkmark.png') }}"/>
                                            @else
                                                <i class="fa fa-window-close error-icon" aria-hidden="true"></i>
                                            @endif

                                                <h5 class="panel-desc">{!! 'http://'.$domain !!}</h5>

                                                <span class="des-meta">{!! $urlLengthMsg !!}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse">
                                                Favicon
                                            </a>
                                        </h4>
                                    </div>
                                    <div class="panel-collapse collapse in" role="tabpanel">
                                        <div class="panel-body">
                                            <img src="{{ asset('public/images/icons/low.png') }}" />

                                            <img src="https://www.google.com/s2/favicons?domain=http://{{ $domain }}" alt="FavIcon">

                                            <h5 class="panel-desc">Great, your website has a favicon.</h5>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                $errorPageMsg = $errorPageClass = '';
                                $errorPageCheck = false;

                                if($pageSize < 1500){
                                    //Default Error Page
                                    $errorPageCheck = false;
                                    $errorPageClass = 'errorBox';
                                    $errorPageMsg = 'Bad, your website has no custom 404 error page.';
                                }else{
                                    //Custom Error Page
                                    $errorPageCheck = true;
                                    $errorPageClass = 'passedBox';
                                    $errorPageMsg = 'Great, your website has a custom 404 error page.';
                                }
                                ?>
                                <div class="panel panel-default {{ $errorPageClass }}">
                                    <div class="panel-heading" role="tab">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse">
                                                Custom 404 Page
                                            </a>
                                        </h4>
                                    </div>
                                    <div class="panel-collapse collapse in" role="tabpanel">
                                        <div class="panel-body">
                                            @if($pageSize < 1500){
                                                <i class="fa fa-window-close error-icon" aria-hidden="true"></i>
                                            @else
                                                <img src="{{ asset('public/images/icons/checkmark.png') }}"/>
                                            @endif
                                                <h5 class="panel-desc">{{ $errorPageMsg }}</h5>
                                                <div class="suggestionBox" style="display: block;">
                                                    When a visitor encounters a 404 File Not Found error on your site, you're on the verge of losing the visitor that you've worked so hard to obtain through the search engines and third party links. <br>
                                                    Creating your custom 404 error page allows you to minimize the number of visitors lost that way.<br>
                                                </div>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                //Page Size / Load Time / Language
                                $size_Msg = "Two of the main reasons for an increase in page size are images and JavaScript files.<br /> Page size affects the speed of your website; try to keep your page size below 2 Mb.<br /> Tip: Use images with a small size and optimize their download with gzip.<br />";
                                $load_Msg = "Site speed is an important factor for ranking high in Google search results and enriching the user experience.<br /> Resources: Check out Google's developer tutorials for tips on how to to make your website run faster. <br />";
                                $lang_Msg = " Make sure your declared language is the same as the language detected by Google<br /> Also, define the language of the content in each page's HTML code.<br />";

                                $sizeMsg = $loadMsg = $langMsg = '';
                                $langCode = null;

                                $timeTaken = $loadTime[0];
                                $dataSize = $loadTime[1];
                                $langCode = $loadTime[2];

                                $dataSize = size_as_kb($dataSize);

                                if($dataSize < 320){
                                    $sizeClass = 'passedBox';
                                }else{
                                    $sizeClass = 'errorBox';
                                }


                                $sizeMsg = str_replace('[size]',$dataSize, "[size] KB (World Wide Web average is 320 Kb)");

                                $timeTaken = round($timeTaken,2);

                                if($timeTaken < 1){
                                    $loadClass = 'passedBox';
                                }else{
                                    $loadClass = 'errorBox';
                                }
                                $loadMsg = str_replace('[time]',$timeTaken, '[time] second(s)');

                                if($langCode == null){
                                    //Error
                                    $langClass = 'errorBox';
                                    $langMsg.= "Oh no, you have not declared your language" . '<br>';
                                }else{
                                    //Passed
                                    $langClass = 'passedBox';
                                    $langMsg.= "Good, you have declared your language" . '<br>';
                                }
                                $langCode  = lang_code_to_lnag($langCode);
                                $langMsg.= str_replace('[language]',$langCode, 'Declared Language: [language]');
                                ?>
                                <div class="panel panel-default {{ $sizeClass }}">
                                    <div class="panel-heading" role="tab">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse">
                                                Page Size
                                            </a>
                                        </h4>
                                    </div>
                                    <div class="panel-collapse collapse in" role="tabpanel">
                                        <div class="panel-body">
                                            @if($sizeClass == 'errorBox'){
                                            <i class="fa fa-window-close error-icon" aria-hidden="true"></i>
                                            @else
                                                <img src="{{ asset('public/images/icons/checkmark.png') }}"/>
                                            @endif


                                            <h5 class="panel-desc">
                                                {{ $sizeMsg }}
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="website-audit-body">
                            <div class="loading-bar" style="text-align: center;margin-top: 50px; display: block;">
                                <span class="loading-text" style="font-size: 15px;font-weight: 700;display: block;">Loading Report...</span>
                                <img src="{{ asset('public/images/Loading-bar.gif') }}">
                            </div>
                            <div class="report-section" style="display: none;">
                                @if($appEnvIs == 'production')
                                    <iframe style="border:none; width: 100%;height: 550px" src="https://appreviewer.nichepractice.com/domain/{{ getUrlDomain($webResult['domain']) }}"><p>Unable to load report this time.</p></iframe>
                                @else
                                    <iframe style="border:none; width: 100%;height: 550px" src="https://reviewer.nichepractice.com/domain/{{ getUrlDomain($webResult['domain']) }}"><p>Unable to load report this time.</p></iframe>
                                @endif
                            </div>
                        </div>

                        <input type="hidden" id="my-web" value="{{ $domain }}" />
                    @elseif(!empty($businessResult['website']))
                        <div class="website-audit-head">

                            <div class="row">
                                <div class=" col-md-9 col-sm-12  col-xs-12 text-sm-center text-xs-center ">
                                    <div class="waudithead-left" style="font-size: 26px;margin: 0px auto;display: table;margin-top: 100px;">
                                        Gathering data... once your audit is complete, it will appear here

                                        <p style="font-size: 18px;">(if incomplete, please re-verify your URL in <a href="{{ route('business-profile') }}">settings</a>).</p>
                                    </div>
                                </div>

                                <div class=" col-md-3 col-sm-12 col-xs-12 text-sm-center text-xs-center " style="text-align: center">
                                    <div class="grid w-audit-graph" style="margin: 0;">
                                        <section>
                                            <svg class="circle-chart" viewBox="0 0 33.83098862 33.83098862" width="200"
                                                 height="200" xmlns="http://www.w3.org/2000/svg"
                                                 style="border-radius: 100px;">
                                                <circle class="circle-chart__background" stroke="#D6D7DA" stroke-width="2.5"
                                                        fill="none" cx="16.91549431" cy="16.91549431"
                                                        r="15.91549431"></circle>
                                                <circle class="circle-chart__circle" stroke="#3D4A9E" stroke-width="2.5"
                                                        stroke-dasharray="0,100" stroke-linecap="square" fill="none"
                                                        cx="16.91549431" cy="16.91549431" r="15.91549431"></circle>
                                                <g class="circle-chart__info">
                                                    <text class="circle-chart__percent" x="16.91549431" y="15.5"
                                                          alignment-baseline="central" text-anchor="middle" font-size="8">0
                                                    </text>
                                                    <text class="circle-chart__percent" x="16.91549431" y="19"
                                                          alignment-baseline="text-before-edge" text-anchor="middle"
                                                          font-size="3">Score
                                                    </text>
                                                </g>
                                            </svg>
                                        </section>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="website-audit-head">

                        <div class="row">
                            <div class="col-xs-12 col-12 col-md-9">
                                <div class="waudithead-left" style="font-size: 26px;margin: 0px auto;display: table;margin-top: 100px;">
                                    No website found

                                </div>
                            </div>

                            <div class="col-xs-12 col-12 col-md-3 text-center">
                                <div class="grid w-audit-graph" style="margin: 0;">
                                    <section>
                                        <svg class="circle-chart" viewBox="0 0 33.83098862 33.83098862" width="200"
                                             height="200" xmlns="http://www.w3.org/2000/svg"
                                             style="border-radius: 100px;">
                                            <circle class="circle-chart__background" stroke="#D6D7DA" stroke-width="2.5"
                                                    fill="none" cx="16.91549431" cy="16.91549431"
                                                    r="15.91549431"></circle>
                                            <circle class="circle-chart__circle" stroke="#3D4A9E" stroke-width="2.5"
                                                    stroke-dasharray="0,100" stroke-linecap="square" fill="none"
                                                    cx="16.91549431" cy="16.91549431" r="15.91549431"></circle>
                                            <g class="circle-chart__info">
                                                <text class="circle-chart__percent" x="16.91549431" y="15.5"
                                                      alignment-baseline="central" text-anchor="middle" font-size="8">0
                                                </text>
                                                <text class="circle-chart__percent" x="16.91549431" y="19"
                                                      alignment-baseline="text-before-edge" text-anchor="middle"
                                                      font-size="3">Score
                                                </text>
                                            </g>
                                        </svg>
                                    </section>

                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

            </div>

        </div>
    </div>
@endsection


@section('before_css')

@endsection

@section('js')
    <script>
        $(function () {
            $(".panel-title a").click(function () {
                return false;
            });
        });
    </script>

    @if(!empty($domain))
        <script>
        $(function () {
            $('.website-audit-body iframe').on("load", function() {
                // console.log("iframe loaded > ");
                $(".loading-bar").hide();
                $(".report-section").show();
            });

            var siteUrl = $('#hfBaseUrl').val();

            var webUrl = $('#my-web').val();

            // $.ajax({
            //     headers: {
            //         'X-CSRF-TOKEN': $('input[name="_token"]').val()
            //     },
            //     type: "POST",
            //     url: siteUrl + "/done-me",
            //     data: {
            //         send: 'web-report',
            //         'website': webUrl
            //         // 'website': 'stackoverflow.com'
            //     }
            // }).done(function (result) {
            //     console.log(result);
            //
            //     var json = $.parseJSON(result);
            //     var statusCode = json.status_code;
            //     var data = json.data;
            //
            //     if(statusCode == 200)
            //     {
            //         $("#screenshotData").html('<img src="data:image/jpeg;base64,'+data+'"/>');
            //     }
            //     else {
            //         $("#screenshotData").html('');
            //     }
            //
            // });

//             $(".dropdown-menu .dropdown-item").click(function()
//             {
//                 var targetAction = $(this).html(); // which we want to select
// //	var activeAction = $(".dropdown-toggle .dropdown-item").html();
//                 var activeAction = $(this).closest('.status-column').find('.dropdown-toggle').html();
//
//
//                 $(this).closest('.status-column').find('.dropdown-toggle').html(targetAction);
//                 $(this).html(activeAction);
//
//                 //var targetName = $(".action-name", targetAction).html();
//                 //var targetStatus = $(".action-name", targetAction).html();
//
//                 // console.log("activeAction " + activeAction);
//                 // console.log("targetAction " + targetAction);
//                 // console.log("activeAction 1 " + $(".action-name", targetAction).html());
//             });
        });
    </script>
    @endif
@endsection
