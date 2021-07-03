@extends('index')

@section('pageTitle', 'Library List')

@section('content')
    <div id="page-wrapper" style="min-height: 281px;">
        <div class="container-fluid dashboarbgtitle">
            <div class="dashboard-wrapper promotion-template-chosen">
                <div class="page-head">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="page-title">Campaign Library</h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="margin-top: 20px">
                        <div class="d-table" style="min-height: 250px; padding: 0; /*padding-top: 50px; */">
                            <div class="email-templates-filters" style="background-color: #ffffff!important;margin-top: -20px">
                                <div class="row" style="padding: 50px 10px 10px;">
                                    <ul class="nav nav-pills mb-3 marketing-associations-list" id="pills-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link btn template-link no-hov" id="pills-profile-tab" data-toggle="pill"  href="#pills-profile"  role="tab" aria-controls="pills-profile" aria-selected="false">INDIVIDUAL CAMPAIGNS</a>
{{--                                            <a href="{{ route('campaigns-library') }}" class="nav-link btn template-link no-hov" id="pills-profile-tab">INDIVIDUAL CAMPAIGNS</a>--}}
{{--                                            <a href="javascript:void(0);" class="nav-link btn template-link no-hov" id="pills-profile-tab">INDIVIDUAL CAMPAIGNS</a>--}}
                                        </li>
                                        <li class="nav-item">
                                            <a class="btn template-link1 template-link" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">MARKETING ROADMAPS</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link btn template-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">DIGITAL MEDIA</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content marketing-association-outer" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                            <div class="row display-flex association-list" style="padding-bottom: 20px;">
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"></div>
                                        <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">...</div>
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
    <style>
        .close-btn{
            width: 100%;
            margin-top: 17px;
            padding: 12px;
        }
        .order-credit-action{
            margin-top: 0;
            padding: 15px;
            background-color: #EEF1F5;
        }
        .modal-content{
            padding: 8px 0px 0px 0px;
        }
        .modal-body{
            padding-bottom: 0px;
        }
        /* .template-link:hover{*/
        /*    background-color: #aaaaaa!important;*/
        /*}*/
        .template-link{
            background-color: #aaaaaa;

        }
        .template-link-active{
            background-color: #5e9ad6!important;
        }
        .module-info__image {
        margin-bottom: 15px;
        width: 60px!important;
        height: 60px;
        }
        .nav-pills > li > a {
            color: #ffffff;
            border-radius: 4px!important;
            padding: 6px 12px;
        }
        .heading-title {
            font-weight: 500;
            font-size: 1.8rem!important;
            line-height: 2.8rem;
            letter-spacing: 0;
            color: #3c4043;
            margin-bottom: 6px;
        }
        .subtitle {
            font-size: 1.4rem;
            color: #3c4043;
            margin-bottom: 20px;
            font-style: normal;
            font-stretch: normal;
            letter-spacing: normal;
            font-family: Roboto,Arial,sans-serif;
            font-weight: 300;
            line-height: 1.29;
        }
        .links{
            padding-top: 15px;
        }
        .links a{
            color: #1a73e8;
        }
        /*.card{*/
        /*    height: 100%;*/
        /*}*/
        .row.display-flex {
            display: flex;
            flex-wrap: wrap;
        }
        .card {
            height: 100%;
        }
        .template-link:hover{
            background-color: #aaaaaa!important;
        }
        .template-link.template-link-active:hover{
            background-color: #5e9ad6!important;
        }
        .marketing-associations-list{
            margin: 0 5px 20px;
            background: #f4f5f8;
            padding: 10px 10px 40px;
        }
        .page-heading {
            margin: 30px 0 10px;
            border: none;
        }
        .marketing-association-outer {
            margin-left: 5px;
            margin-right: 5px;
        }
        </style>
@endsection

@section('js')
    <script>
        window.currentPageSource = 'static_page';
        // $(function () {
        //     loadPosts('open');
        // });
    </script>
{{--    <script src="{{ asset('public/js/task/tabs-task.js?ver='.$appFileVersion) }}"></script>--}}
    <script>
        $(function () {
            $(document).ready(function () {
                $('.template-link1').click();
            });
        });
        // toggle free and premium template
        $(document).ready(function () {
            $('.template-link').click(function () {
                var id = $(this).attr('data-id');
                $(".template-link").removeClass('template-link-active');

                $(this).addClass('template-link-active');
                // $(".template-box-container-col-sm-3").hide();
                // $(".list-"+id).show();
            });
        });

        // not enough credit cancel


        $(function () {
            $(document).ready(function () {

                var baseUrl = $('#hfBaseUrl').val();

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    type: "POST",
                    url: baseUrl + "/done-me",
                    data:{
                        send: 'retrieve-library-list'
                    }

                }).done(function (result) {

                    // parse data into json
                    var json = $.parseJSON(result);

                    // get data
                    var statusCode = json.status_code;
                    var statusMessage = json.status_message;
                    // console.log('json');
                    // console.log(json);
                    // console.log('statusCode');
                    // console.log(statusCode);
                    // console.log('statusMessage');
                    // console.log(statusMessage);

                    var data = '';
                    data = json.data;
                    // console.log('data');
                    // console.log(data);
                    // console.log(data.association);
                    var totalTasks = json.data.length;
                    var thumbnail = '';
                    var campaignCount = 0;
                    var campaignCredit = 0;
                    var html = '';
                    $.each(data.association, function (index, value){
                        campaignCount = 0;
                        campaignCredit = 0;
                        if(value.has_many_campaigns != '') {
                            $.each(value.has_many_campaigns, function (index, value){
                                campaignCount++;
                                campaignCredit += value.credits;
                            });
                        }
                        var description = value.description;
                        if(description) {
                            description = value.description;
                        }
                        else{
                            description = '';
                        }
                        if (value.thumbnail != null){
                            thumbnail = '/storage/app/' +value.thumbnail;
                        }
                        else{
                            thumbnail =  '/public/images/clickFeature.png';
                        }

                        html +=
                            '<div class="col-sm-3" style="margin-bottom: 20px">'+
                                '<div class="card" style="min-width: 100%">'+
                                    '<div class="card-header" style="border-bottom: 1px solid #e8eaed;padding-bottom: 15px;">'+
                                        '<a href="javascript:void(0);">'+
                                            '<img class="module-info__image" src="'+baseUrl+''+thumbnail+'" alt="The online opportunity">'+
                                                // '<h4 class="heading-title">New to Marketing?</h4>'+
                                                '<h4 class="heading-title">'+value.name+'</h4>'+
                                        '</a>'+
                                        '<span class="subtitle">'+campaignCount+ ' Campaign\'s / '+campaignCredit+' Credits</span>'+
                                        '<p class="subtitle-desc" style="margin-top: 5px;justify-content: flex-start!important; font-weight: 400; font-size: 14px;">'+description+'</p>'+
                                    '</div>'+
                                    '<div class="links">';
                                        if(value.has_many_campaigns != '') {
                                            $.each(value.has_many_campaigns, function (index, value){
                                                html +=  '<div style="padding: 2px 0">'+
                                                    '<a class="link" href="javascript:void(0);">'+value['name']+' <i  class="fa fa-question-circle btn-campaign"  data-credits="'+value['credits']+'" data-campaign-target="'+value['id']+'"></i></a>'+
                                                    '</div>';
                                            });
                                        } else {
                                            html +=  '<div style="padding: 10px 0">'+
                                                '<p class="link">No Campaign Found</p>'+
                                                '</div>';
                                        }

                        html +=       '</div>'+
                                '</div>'+
                            '</div>';

                    });
                    $( ".association-list" ).append( html );

                });
            });
        });

    </script>
    <script src="{{ asset('public/js/task/tabs-task.js?ver='.$appFileVersion) }}"></script>
@endsection
