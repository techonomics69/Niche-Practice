@extends('index')

@section('pageTitle', 'Advanced SEO')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid dashboarbgtitle">
            <div class="dashboard-wrapper website-content-page">

                <div class="page-head">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="page-title">Advanced SEO</h4>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="custom-post-box">
                            <div class="row responsive-row">
                                <div class="col-sm-8">
                                    <h1 class="font-normal">Rank at the Top of Search Results</h1>
                                    <p class="m-b-15">
                                        Want the help of an SEO professional? Our team will implement an advanced SEO strategy to MAXIMIZE your rankings and traffic in a strategic way. Gain more new patients and become the top provider in your niche.
                                    </p>
                                    <button class="btn btn-primary">Upgrade Now</button>
                                    <button class="btn btn-default text-primary m-l-10">Learn More</button>
                                </div>
                                <div class="col-sm-4">
                                    <img src="{{ asset('public/images/advanced-seo.png') }}" alt="social" style="width: 100%;height: auto;">
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
