@extends('index')

@section('pageTitle', 'Automated Emails')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid dashboarbgtitle">
            <div class="dashboard-wrapper campaign-list">
                <div class="page-head">
                    <div class="row">
                        <div class="col-sm-6 col-xs-8 text-xs-center">
{{--                            <h4 class="page-title">Automated Emails</h4>--}}
                            <h4 class="page-title">Overview</h4>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="custom-post-box">
                            <div class="row responsive-row">
                                <div class="col-sm-8">
                                    <h1 class="font-normal">Give Clients a Sense of Both Your Expertise and Personality</h1>
                                    <p class="m-b-15">Our automated campaigns take it a step further than just sending email blasts. A series of 10 sequential niche and industry related email messages will be used to build trust and credibility and play a significant role in converting prospects into new patients.</p>
                                    <button class="btn btn-primary">Upgrade Now</button>
                                    <button class="btn btn-default text-primary m-l-10">Learn More</button>
                                </div>
                                <div class="col-sm-4">
                                    <img src="{{ asset('public/images/social-post-1.png') }}" alt="social" style="width: 100%;height: auto;">
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

@endsection
