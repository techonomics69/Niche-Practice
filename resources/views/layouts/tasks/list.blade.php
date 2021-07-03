@extends('index')

@section('pageTitle', 'Marketing Tasks')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid dashboarbgtitle">
            <div class="dashboard-wrapper blog-page marketing-wrapper">
                <div class="page-head">
                    <div class="row " >
                        <div class="col-md-6">
                            <h4 class="page-title">My Campaigns
{{--                                <a class="page-help" href="javascript:void(0)">--}}
{{--                                    <i class="fa fa-question-circle-o" style="color: #7d8080;/* transform: scaleX(-1); */margin-right: 5px;"></i>--}}
{{--                                    <img class="help-info-image" data-toggle="tooltip" data-html="true" data-placement="bottom" title="<a id='someID' class='to-do-tooltip-close'> <i class='fa fa-times '></i></a> <span> Have questions about this</span> <br> <span>  page? Click the icon or go</span><br> to our <a href='#' class='toto-hover-link page-help'> Help Center.</a>" src="{{ asset('public/images/information.png') }}" />--}}

{{--                                    <img class="help-info-image" src="{{ asset('public/images/information.png') }}" />--}}

{{--                                    <button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="bottom" title="Tooltip on bottom">--}}
{{--                                        Tooltip on bottom--}}
{{--                                    </button>--}}
{{--                                </a>--}}
                            </h4>
                            <ul class="month-selection">
                                <li style="background: #33475B;">Month 1</li>
                                <li>Month 2</li>
                                <li>Month 3</li>
                                <li>Month 4</li>
                                <li>Month 5</li>
                            </ul>
                        </div>
                        <div class="col-md-6 text-center">
                            <a href="https://nichepractice.com/nichepractise/learn-how-to-use-the-task-list/"  onMouseOver="this.style.color='white'"
                               onMouseOut="this.style.color='white'" class="btn btn-padding" target="_blank" >
                                <span style="padding-right: 10px"><i class="fa fa-question-circle"></i></span> LEARN HOW TO USE THE TASK LIST
{{--                                View All Marketing Campaigns--}}
                            </a>
                        </div>
{{--                        <div class="col-md-6">--}}
{{--                            <p class="text-right" style="font-weight: bold; font-size: 16px;">Get Started With Nichepractice</p>--}}
{{--                            <button id="watchOverviewVideo" class="btn" style="float: right; font-weight: 600; font-size: 15px; background-color: #DBECF6; color:#2B93F4;">--}}
{{--                              <i class="fa fa-play-circle-o fa-lg" aria-hidden="true"></i>  Watch the 2 min video--}}
{{--                            </button>--}}
{{--                        </div>--}}
                    </div>
                </div>
                <div class="row tooltip-bottom-section">
                    <div class="col-md-6 task-issues">
                        <div class="white-box full-page-view box-height-res" style="margin-bottom: 0px; min-height: 613px;">
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
{{--                                        <div class="col-md-3 m-t-5">--}}
{{--                                            <span class="text-muted task-length" data-total-tasks="7">Tasks 7 Found</span>--}}
{{--                                        </div>--}}
                                        <div class="col-sm-12">
                                            <div class="col-md-12 text-right" style="margin-bottom: 15px">
                                                <a href="javascript:void(0);"  onMouseOver="this.style.color='white'"
                                                   onMouseOut="this.style.color='white'" class="btn btn-padding" id="showHiddenCampaigns" style="display: none;">
{{--                                                    <span style="padding-right: 10px"><i class="fa fa-question-circle"></i></span>--}}
                                                    Show Hidden Campaigns
                                                </a>
                                            </div>
                                            <div class="btn-group m-b-20">
<!--                                                class for float right : website-page-tabs -->
{{--                                                <ul class="nav nav-tabs rounded-tabs task-tabs my-tabs" role="tablist">--}}

{{--                                                    <li role="presentation" class="">--}}
{{--                                                        <a href="#open" role="tab">To Do (<span class="open-count">{{$business_task_open}}</span>)</a>--}}
{{--                                                    </li>--}}

{{--                                                    <li role="presentation"><a href="#skipped" role="tab">Skipped (<span class="skipped-count">{{$business_task_skipped}}</span>)</a></li>--}}
{{--                                                    <li role="presentation"><a href="#paid" role="tab">Marketing pro</a></li>--}}
{{--                                                    <li role="presentation"><a href="#done" role="tab">Completed (<span class="done-count">{{$business_task_done}}</span>)</a></li>--}}

{{--                                                    <li role="presentation" class="active">--}}
{{--                                                        <a href="#open" role="tab">1: To Do</a>--}}
{{--                                                    </li>--}}

{{--                                                    <li role="presentation"><a href="#skipped" role="tab">2: Skipped</a></li>--}}
{{--                                                    <li role="presentation"><a href="#paid" role="tab">3: Marketing pro</a></li>--}}
{{--                                                    <li role="presentation"><a href="#done" role="tab">4: Completed</a></li>--}}


{{--                                                    <li role="presentation" class="">--}}
{{--                                                        <a href="#all" role="tab">All</a>--}}
{{--                                                    </li>--}}
{{--                                                </ul>--}}
                                                <ul class="nav nav-tabs rounded-tabs task-tabs my-tabs" role="tablist">
                                                    <li class="active todo" id="todolist">
                                                        <a href="#open" >To Do (<span class="open-count">{{$business_task_open}}</span>)</a>
                                                    </li>
                                                    <li class="tab" id="completed">
                                                        <a href="#done" >Completed (<span class="done-count">{{$business_task_done}}</span>)</a>
                                                    </li>
                                                </ul>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="tab-content website-task-list">
                                        <div id="open" class="tab-pane active task-data-list">
                                            <img class="loader" src="{{ asset('public/images/loader.gif') }}" />
                                            <div id="accordion" class="task-list-wrapper panel-group">
                                                <ul>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if(empty($suggessionManager['task_suggesstion_hide']))
                                <div class="action-plan-suggestion" style="background-color: rgb(247 299 17 / 15%); padding:12px; margin-top:120px; display:none;">
                                    <h5 style="font-weight: 700;">SUGGESTION:</h5>
                                    <i class="fa fa-close close-suggession-box"></i>
                                    <p>Try to complete 3-5 tasks/day. Don't worry if you haven't completed enough tasks. Towards the end of the month, we will email you a tracking form that keeps an eye on your progress. Whatever you cannot complete, our team of marketing pro's will get you caught up immediately, allowing you to start the next month on track!</p>
                                </div>
                               @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 task-description-area">
                        <div class="white-box full-page-view loader-container" style=" min-height: 613px;">
                            <img class="loader" src="{{ asset('public/images/loader.gif') }}" />
                        </div>
                        <div class="white-box full-page-view task-description" style="display:none; min-height: 613px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="modal-campaign-package1" class="modal fade in modal-manager modal-upgrade-library" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" style="">
        <div class="modal-dialog" role="document" style="width: 400px;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close close_btn" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h3 class="modal-campaign-title">
                        Thank You For Joining Nichepractice
                    </h3>
                    <div class="description-order" style="margin-bottom: 35px;">
                        <p>Your campaign is now available and ready to be used. Each
                            <br>additional month you will receive a marketing campaign added
                            to your campaign page.
                        </p>
                    </div>
                    <div class="row modal-order-action">
                        <a class="btn close_btn" style="margin: 0px auto;display: table; width: 70%; border-radius: 4px; font-weight: 600; border: 1px solid #000000; color: #000; padding: 12px" data-dismiss="modal">CLOSE</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
<input id="welcome_video_seen" type="hidden" name="welcome_video_seen" value="{{$welcome_video_seen}}">
@endsection

@section('css')
    <style>
        .btn-padding{
            float: right; font-weight: 600; font-size: 15px; background-color: #64cda4; color:white;padding-left: 30px;
            padding-right: 30px;
        }
        @media screen and (max-width: 567px) {
            .btn-padding{
                float: none; font-weight: 600; font-size: 15px; background-color: #64cda4; color:white;padding-left: 30px;
                padding-right: 30px;
            }


        }
        /* Rating Star Widgets Style */
        .rating-stars ul {
            list-style-type:none;
            padding:0;

            -moz-user-select:none;
            -webkit-user-select:none;
        }
        .rating-stars ul > li.star {
            display:inline-block;
            margin-right: -2px;
        }

        /* Idle State of the stars */
        .rating-stars ul > li.star > i.fa {
            font-size:1.8em; /* Change the size of the stars */
            color:#ccc; /* Color on idle state */
            width: 30px !important;
        }

        /* Hover state of the stars */
        .rating-stars ul > li.star.hover > i.fa {
            color:#FFCC36;
        }

        /* Selected state of the stars */
        .rating-stars ul > li.star.selected > i.fa {
            /*color:#FF912C;*/
            color:#FFCC36;
        }
        .star{
            cursor: pointer;
        }
        .card-inner-rating {
            width: 100% !important;
            height: 100% !important;
            min-width: 100% !important;
            min-height: 100% !important;
            padding-top: 15px !important;
            padding-bottom: 55px !important;
        }
        #comment {
            border: 1px solid #ccc !important;
            margin-bottom: 20px;
            border-radius: 4px !important;
            padding: 7px 10px !important;
            height: auto !important;
            border-radius: 4px;
        }
        #comment:focus, #comment:hover {
            border: 1px solid #ccc !important;
        }
        .submitFeedBack {
            color: #fff;
            background-color: #286090;
            border-color: #204d74;
        }
        .submitFeedBack:hover, .submitFeedBack:focus  {
            color: #fff;
            background-color: #286090;
            border-color: #204d74;
        }
        .panel-done .submitFeedBack{
            display: none !important;
        }
        .rating {
            background-color: transparent;
            background-image: url(../../../../public/images/rating.png);
            background-position: 80px top;
            display: inline-block;
            height: 15px;
            line-height: 15px;
            margin-top: 3px;
            overflow: hidden;
            /*width: 80px;*/
            text-align: left;
            cursor: pointer;
        }
        .rating .rating-value {
            background-color: transparent;
            background-image: url(../../../../public/images/rating.png);
            background-position: 0 top;
            display: inline-block;
            height: 15px;
            line-height: 15px;
            overflow: hidden;
            /*width: 80px;*/
        }
        @media (min-width: 1170px) and (max-width: 1366px) {
            .dashboard-wrapper .card {
                padding: 15px 24px 55px ! important;
            }
        }
    </style>
{{--    .tooltip-inner{--}}
{{--        background-color: #011249 !important;--}}
{{--        text-align: left;--}}
{{--    }--}}


{{--    .tooltip{--}}
{{--        background-color: #011249 !important;--}}
{{--    }--}}

@endsection

@section('js')
    <script>
        var baseUrl = $('#hfBaseUrl').val();
        function getParameterByName(name, url = window.location.href) {
            name = name.replace(/[\[\]]/g, '\\$&');
            var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, ' '));
        }
        var subcribed = getParameterByName('user');
        if(subcribed == 'subcribed'){
            var uri = window.location.toString();
            var clean_uri = uri.substring(0, uri.indexOf("?"));
            window.history.replaceState({}, document.title, clean_uri);
            $('#modal-campaign-package1').modal('show');
        }

    </script>

    <script>
        window.currentPageSource = 'task_list';
    </script>
    <script src="{{ asset('public/js/task/tabs-task.js?ver='.$appFileVersion) }}"></script>
    <script>
        $(window).load(function(){
            $('.marketing-tabs').addClass('active');
            $('.marketing-tabs .nav-second-level').css('display', 'block');
        });

        $('#myTooltip').on('hidden.bs.tooltip', function () {
            // do something…
            html:true
        })
        $(document).ready(function(){
            $('img').tooltip().mouseover();
            setTimeout(function(){ $('img').tooltip('hide'); }, 3000000);
        });
        $(document).ready(function(){
        $('#someID').on('click', function() {
            $('.tooltip').css('display', 'none');
        });
            $("a img").hover(function(){
                $("[data-toggle='tooltip']").tooltip('destroy');
            });
        });
        // var todo = document.getElementById('todolist');
        $(document).on('click' ,'.tab',function()
        {
            $("#todolist").removeClass('active');
        });

        $(document).on('click' ,'.todo',function()
        {
            $("#completed").removeClass('active');
        })

    </script>
@endsection
