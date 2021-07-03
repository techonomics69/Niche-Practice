@extends('index')

@section('pageTitle', 'Social Media Profiles')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid dashboarbgtitle">
            <div class="dashboard-wrapper website-content-page">
                <div class="page-head">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="page-title">Social Media Profiles</h4>
                        </div>
                        <div class="col-md-6">
                        </div>
                    </div>
                </div>
                <div class="new-site-wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="website-content-widget">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div style="display: flex">
                                            <img src="{{ asset('public/images/blog/facebook.png') }}" />
                                            <div>
                                                <a href="javascript:void(0);">
                                                    <h4 class="heading-box">
                                                        Facebook Profile
                                                    </h4></a>
                                                {{--<span class="heading-subtitle">sleep apnea</span>--}}
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-sm-4 text-center">
                                        <a href="javascript:void(0);" class="btn btn-primary">Read</a>
                                    </div>
                                    <div class="col-sm-12">
                                        <div style="width: 100%; overflow: hidden">
                                            <div style="width: 100%; border-bottom: 1px dashed rgba(130,130,130,0.61);transform: scaleX(4)"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="btn-group-box">
                                            <button class="btn btn-light-gray selected">Accept</button>
                                            <button class="btn btn-light-gray request-edit">Request Edits</button>
                                            <button class="btn btn-light-gray">Decline</button>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="website-content-widget">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div style="display: flex">
                                            <img src="{{ asset('public/images/blog/twitter.png') }}" />
                                            <div>
                                                <a href="javascript:void(0)"><h4 class="heading-box">Twitter Profile</h4></a>
                                                {{--<span class="heading-subtitle">sleep apnea</span>--}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 text-center">
                                        <a href="javascript:void(0);" class="btn btn-primary">Read</a>
                                    </div>

                                    <div class="col-sm-12">
                                        <div style="width: 100%; overflow: hidden">
                                            <div style="width: 100%; border-bottom: 1px dashed rgba(130,130,130,0.61);transform: scaleX(4)"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="btn-group-box">
                                            <button class="btn btn-light-gray selected">Accept</button>
                                            <button class="btn btn-light-gray request-edit">Request Edits</button>
                                            <button class="btn btn-light-gray">Decline</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="website-content-widget">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div style="display: flex">
                                            <img src="{{ asset('public/images/blog/linkedin.png') }}" />
                                            <div>
                                                <a href="javascript:void(0)"><h4 class="heading-box">LinkedIn Profile</h4></a>
                                                {{--<span class="heading-subtitle">sleep apnea</span>--}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 text-center">
                                        <a href="javascript:void(0);" class="btn btn-primary">Read</a>
                                    </div>

                                    <div class="col-sm-12">
                                        <div style="width: 100%; overflow: hidden">
                                            <div style="width: 100%; border-bottom: 1px dashed rgba(130,130,130,0.61);transform: scaleX(4)"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="btn-group-box">
                                            <button class="btn btn-light-gray selected">Accept</button>
                                            <button class="btn btn-light-gray request-edit">Request Edits</button>
                                            <button class="btn btn-light-gray">Decline</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
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
    <script type="text/javascript" src="{{ asset('public/js/expert-manager.js') }}"></script>
@endsection