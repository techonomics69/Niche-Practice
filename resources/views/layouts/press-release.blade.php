@extends('index')

@section('pageTitle', 'Press Release')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid dashboarbgtitle">
            <div class="dashboard-wrapper press-release-wrapper">

                <div class="page-head">
                    <div class="row">

                        <div class="col-md-6">
                            <h4 class="page-title"> Press Releases </h4>
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
                                            <img src="{{ asset('public/images/blog/blog.gif') }}" />
                                            <div>
                                                <a href="javascript:void(0)"><h4 class="heading-box">How It Works</h4></a>
                                                <span class="heading-subtitle">In the content marketing and SEO world content is king. Original, high-quality, authoritative blog posts are the best way to show your readers and search engines what your business does and knows best. Within a week you’ll have a draft to review. You can accept it immediately or request a round of edits.</span>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-sm-4 text-center">
                                        <a href="javascript:void(0);" class="btn btn-primary">Order</a>
                                        <a href="javascript:void(0);" class="btn btn-primary btn-keywords" style="background: #695f5f !important;border: #695f5f !important;margin-right: 20px;">View Sample</a>
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
