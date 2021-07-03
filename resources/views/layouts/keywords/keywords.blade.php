@extends('index')

@section('pageTitle', 'Keywords')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid dashboarbgtitle">
            <div class="dashboard-wrapper keywords-wrapper">
                <div class="page-head">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="page-title">Keywords
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
                    <div class="white-box full-page-view">
                        <div class="page-content keyword-setting-page">
                            <div class="page-header" style="border:none; margin-bottom: 0;">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="heading">
                                            <h2>Keywords</h2>
                                            {{--<h4 class="text-muted">Add up to 5 keywords your customers might be using to find business like yours online.</h4>--}}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if(session('message') || ($foundError == true) && $message !== '')
                            <?php
                            $messageCode = session('messageCode');

                            if(!empty($message))
                            {

                            }
                            $message = session('message');
                            ?>
                            <div class="form-group">
                                <div class="alert {{ ($messageCode != 200) ? 'alert-danger' : 'alert-success' }}">
                                    {{ $message }}
                                </div>
                            </div>
                            @endif

                            @if(empty($foundError))
                                <div class="row">
                                <div class="col-md-12">
                                    <div class="content-header">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="keywords-holder primary-keyword left" style="width: 100%;">
                                                    <div class="selected-keywords div-table left" style="display:{{ ($keywords == '') ? 'none' : 'block' }}">
                                                        <h4>Your Selected Keywords (<span class="keyword-counter">5</span> Left)</h4>
                                                        <div class="selected-keywords-data">
                                                            <input type="hidden" id="selected_keywords" value="{{ ($keywords != '') ? json_encode($keywords) : '' }}" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="keyword-search">
                                            <label>Add more keywords using our keyword suggestion tool. Start by describing your business below.</label>
                                            <div class="row">
                                                <form id="search-form">
                                                    <div class="form-group col-md-8 col-sm-6 col-xs-6">
                                                        <input id="search" class="form-control" type="text" placeholder="For example: Plumber New York or Personal Trainer New York" />
                                                        <span class="error-span left hide-me m-t-10">Field is required.</span>
                                                    </div>
                                                    <div class="form-group col-md-4 col-sm-6 col-xs-6">
                                                        <button type="submit" data-type="related" class="btn btn-search"><i class="fa fa-search"></i>Related</button>
                                                        <button type="submit" data-type="broad" class="btn btn-search"><i class="fa fa-search"></i>Broad  <span class="mobile-hide">Match</span></button>
                                                        {{--<button type="submit" class="btn btn-block btn-search">Show Keyword Suggestion</button>--}}
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="keywords-holder left" style="width: 100%;">
                                                    <div class="suggested-keywords div-table" style="display:none;">
                                                        <h4>Suggested Keywords</h4>
                                                        <div class="alert alert-danger" style="display:none;"></div>
                                                        <div class="suggested-keywords-data">
                                                        </div>
                                                    </div>
                                                </div>

                                                {{--<div class="keywords-empty-state" style="display: {{ ($keywords == '') ? 'block' : 'none' }}">--}}
                                                <div class="keywords-empty-state">
                                                    <img src="{{ asset('public/images/keyword-search.png') }}">
                                                    <h4 class="m-t-35">Describe your business and search to see suggested keywords to choose from.</h4>
                                                </div>

                                                <div style="text-align: center;">
                                                    <img class="img-loader"
                                                         src="{{ asset('public/images/loader.gif') }}"
                                                         style="display: none;">
                                                </div>

                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div style="margin-top: 50px; text-align: center;">
{{--                                                    <a href="javascript:void(0);" class="btn add-keyword-btn m-t-40" style="display:{{ ($keywords == '') ? 'none' : 'block' }}">--}}
                                                    <a href="javascript:void(0);" class="btn add-keyword-btn m-t-40">
                                                        Add Keyword Yourself
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 m-t-40" style="text-align: center;">
                                    <div class="action-btn-footer no-border">
                                        <div class="save-setting-btn">
                                            @if($keywords == '')
                                                <a href="javascript:void(0);" class="btn btn-info next-btn disabled"
                                                   data-href="#" data-trigger="hover"
                                                   data-container="body" data-toggle="popover" data-placement-sm="top"
                                                   data-content="Please select keywords to proceed."
                                                   data-original-title="">
                                                    Save Keywords</a>
                                            @else
                                                <a href="javascript:void(0);" data-href="#"
                                                   class="btn btn-info next-btn"> Save Keywords</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                        <input type="hidden" id="business_id" value="{{ $userBusiness['business_id'] }}" />
                        <input type="hidden" id="business_status" value="completed" />
                        <input type="hidden" id="user_allow" value="yes" />
                        <input type="hidden" id="currentPage" value="settings_keywords" />
                    </div>
                </div>
            </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <?php
    $version=11;
    echo "<script>var keywords_screen='true';</script>";
    ?>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('public/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
    <link rel="stylesheet" href="{{ asset('public/css/scan-keyword.css') }}">


@endsection

@section('js')
    <script src="{{ asset('public/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{ asset('public/js/keywords-manager.js') }}"></script>
@endsection
