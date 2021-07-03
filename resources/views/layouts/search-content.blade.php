@extends('index')

@section('pageTitle', 'Curated Content')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid dashboarbgtitle">
            <div class="dashboard-wrapper" >
                <div class="page-head">
                    {{--<div class="back-page">--}}
                        {{--<i class="fa fa-angle-left"></i><a href="{{ route('social-posts') }}">Social Media</a>--}}
                    {{--</div>--}}

                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="page-title">Search Content
{{--                                <a class="page-help" href="javascript:void(0)">
                                        <i class="fa fa-question-circle-o" style="color: #7d8080;/* transform: scaleX(-1); */margin-right: 5px;"></i>--}}
{{--                                </a> --}}
                            </h4>

                            <p class="page-subtitle">Search content to post on your social media feed.</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="search-contenthead">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group contentkeyword-search">
                                        <input id="search_for" type="text" class="form-control " placeholder="Enter keywords here">
                                    </div>
                                    <span class="query-missing-error error" style="margin-top: 5px;display: none;">Keyword is required to search.<span></span></span>
                                </div>

                                <div class="col-md-2">
                                    <label class="labelforsearch-contenthead my-posted-label">Content Category</label>
                                    <div class="form-group btn-custom-drop">
                                        <select id="article_type" multiple class="form-control">
                                            <option value="general_article" selected>Article</option>
                                            <option value="how_to_article">How-to Article</option>
                                            <option value="infographic">Infographics</option>
                                            <option value="list">List</option>
                                            <option value="video">Videos</option>
                                        </select>
                                        {{--<div class="dropdown">--}}
                                            {{--<button class="btn btn-s-f-content dropdown-toggle" type="button" id="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">--}}
                                                {{--All Content--}}
                                                {{--<span class="caret"></span>--}}
                                            {{--</button>--}}
                                            {{--<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">--}}
                                                {{--<li><a href="#">--}}
                                                        {{--<div class="checkbox checkbox-primary">--}}
                                                            {{--<input id="checkbox2" class="styled" type="checkbox">--}}
                                                            {{--<label for="checkbox2">--}}
                                                                {{--Select All--}}
                                                            {{--</label>--}}
                                                        {{--</div>--}}



                                                    {{--</a></li>--}}
                                                {{--<li role="separator" class="divider"></li>--}}
                                                {{--<li><a href="#">   <div class="checkbox checkbox-primary">--}}
                                                            {{--<input id="" class="styled" type="checkbox">--}}

                                                            {{--<label for="checkbox2">--}}
                                                                {{--Articles--}}
                                                            {{--</label>--}}
                                                        {{--</div></a></li>--}}
                                                {{--<li><a href="#">   <div class="checkbox checkbox-primary">--}}
                                                            {{--<input id="" class="styled" type="checkbox">--}}

                                                            {{--<label for="checkbox2">--}}
                                                                {{--How-to Articles--}}
                                                            {{--</label>--}}
                                                        {{--</div></a></li>--}}

                                                {{--<li><a href="#">   <div class="checkbox checkbox-primary">--}}
                                                            {{--<input id="" class="styled" type="checkbox">--}}

                                                            {{--<label for="checkbox2">--}}
                                                                {{--Infographics--}}
                                                            {{--</label>--}}
                                                        {{--</div></a></li>--}}
                                                {{--<li><a href="#">   <div class="checkbox checkbox-primary">--}}
                                                            {{--<input id="" class="styled" type="checkbox">--}}

                                                            {{--<label for="checkbox2">--}}
                                                                {{--Lists--}}
                                                            {{--</label>--}}
                                                        {{--</div></a></li>--}}


                                            {{--</ul>--}}
                                        {{--</div>--}}
                                    </div>
                                    <span class="error error-message m-t-10" style="display: none;float: left;">Required. One option must be selected from Categories.<span></span></span>
                                </div>

                                <div class="col-md-2">
                                    <label class="labelforsearch-contenthead my-posted-label">Posted in</label>
                                    <div class="form-group btn-custom-drop">
                                        <select id="num_days" class="selectpicker" data-width="100%" data-style="form-control">
                                            <option selected>Last 24 Hours</option>
                                            <option>Last Week</option>
                                            <option>Last Month</option>
                                            <option>Last 6 Months</option>
                                            <option>Last Year</option>
                                            <option>Last 2 Years</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <button type="button" class="search-fetch btn btn-searchsubmit">Search</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <img class="web-loader" src="{{ asset('public/images/transparent_loader.gif') }}" style="display: none;width:48px;margin: 0 auto;">
                        <div class="alert alert-danger" style="display: none;"></div>

                        <div class="seach-content content-research-results" id="contentResearch">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.social-media-modals')

    <?php
    if(isset($socialMediaPostsData)) {
        $socialMediaPostsJson = json_encode($socialMediaPostsData);
        echo '<script>var socialMediaPostsData = '.$socialMediaPostsJson.';</script>';
    }
    else{
        echo '<script>var socialMediaPostsData = []; </script>';
    }
    ?>
@endsection

@section('css')
    <link type="text/css" rel="stylesheet" href="{{ asset('public/plugins/bootstrap-select/bootstrap-select.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('public/plugins/bootstrap-multiselect/bootstrap-multiselect.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('public/css/social-media-common.css?ver='.$appFileVersion) }}" />
    <link type="text/css" href="{{ asset('public/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('public/css/new-style-content-research.css') }}">
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('public/plugins/bootstrap-select/bootstrap-select.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/plugins/bootstrap-multiselect/bootstrap-multiselect.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/bootstrap-datetimepicker.js') }}"></script>
    <script src="{{ asset('public/js/common-social-media.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/content-search.js') }}"></script>
@endsection
