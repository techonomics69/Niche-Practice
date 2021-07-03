@extends('index')

@section('pageTitle', 'Customize Invitation')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid dashboarbgtitle reviews-panel">
            <div class="dashboard-wrapper">
                <div class="page-head">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="page-title"> Get More Reviews </h4>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="custom-post-box">
                            <div class="row" style="display: flex; align-items: center;">
                                <div class="col-sm-8">
                                    <h1 class="font-normal">Need a Custom Review Template?</h1>
                                    <p class="m-b-15">If you need custom designed and developed review invitation  templates that match your brand’s look and feel, our team can help.</p>
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <div class="get-more-review-item">
                                                <div class="icons">
                                                    <a href="javascript:void(0)"><i class="fa fa-desktop text-primary" aria-hidden="true"></i></a>
                                                    <a href="javascript:void(0)"><i class="fa fa-star" aria-hidden="true"></i></a>
                                                    <a href="javascript:void(0)"><i class="fa fa-arrow-circle-right text-primary" aria-hidden="true"></i></a>
                                                </div>
                                                <img src="{{ asset('public/images/getmore-item-1.jpg') }}" alt="">
                                                <h6>this is title</h6>
                                            </div>
                                        </div>
                                        <div class="col-xs-3">
                                            <div class="get-more-review-item">
                                                <div class="icons">
                                                    <a href="javascript:void(0)"><i class="fa fa-desktop text-primary" aria-hidden="true"></i></a>
                                                    <a href="javascript:void(0)"><i class="fa fa-star" aria-hidden="true"></i></a>
                                                    <a href="javascript:void(0)"><i class="fa fa-arrow-circle-right text-primary" aria-hidden="true"></i></a>
                                                </div>
                                                <img src="{{ asset('public/images/getmore-item-2.jpg') }}" alt="" />
                                                <h6>this is title</h6>
                                            </div>
                                        </div>
                                        <div class="col-xs-3">
                                            <div class="get-more-review-item">
                                                <div class="icons">
                                                    <a href="javascript:void(0)"><i class="fa fa-desktop text-primary" aria-hidden="true"></i></a>
                                                    <a href="javascript:void(0)"><i class="fa fa-star" aria-hidden="true"></i></a>
                                                    <a href="javascript:void(0)"><i class="fa fa-arrow-circle-right text-primary" aria-hidden="true"></i></a>
                                                </div>
                                                <img src="{{ asset('public/images/getmore-item-3.jpg') }}" alt="" />
                                                <h6>this is title</h6>
                                            </div>
                                        </div>
                                        <div class="col-xs-3">
                                            <div class="get-more-review-item">
                                                <div class="icons">
                                                    <a href="javascript:void(0)"><i class="fa fa-desktop text-primary" aria-hidden="true"></i></a>
                                                    <a href="javascript:void(0)"><i class="fa fa-star" aria-hidden="true"></i></a>
                                                    <a href="javascript:void(0)"><i class="fa fa-arrow-circle-right text-primary" aria-hidden="true"></i></a>
                                                </div>
                                                <img src="{{ asset('public/images/getmore-item-4.jpg') }}" alt="" />
                                                <h6>this is title</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="text-center">
                                        <button class="btn btn-primary">Upgrade Now</button><br>
                                        <button class="btn btn-default text-primary m-t-10">Learn More</button>
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


@section('before_css')

@endsection

@section('js')
@endsection
