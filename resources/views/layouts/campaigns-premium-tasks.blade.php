@extends('index')

@section('pageTitle', 'Campaigns Library')

@section('content')
    <div id="page-wrapper" style="min-height: 281px;">
        <div class="container-fluid dashboarbgtitle">
            <div class="dashboard-wrapper promotion-template-chosen">
                <div class="page-head">
                    <div class="row">
                        <div class="col-md-6">
                            {{--                            <h4 class="page-title">Campaign Library</h4>--}}
                            <h4 class="page-title">Campaign Library
                                {{--                                <i class="fa fa-question-circle-o" style="color: #7d8080;/* transform: scaleX(-1); */margin-right: 5px;"></i>--}}
                                {{--                                    <img class="help-info-image page-help" src="{{ asset('public/images/information.png') }}" />--}}

                            </h4>
                        </div>
                        <div class="col-md-6 text-center">
                            <a href="https://nichepractice.com/nichepractise/learn-how-to-use-the-library/"
                               onMouseOver="this.style.color='white'"
                               onMouseOut="this.style.color='white'" class="btn btn-padding" target="_blank">
                                <span style="padding-right: 10px"><i class="fa fa-question-circle"></i></span> LEARN HOW
                                TO USE THE LIBRARY
                            </a>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="d-table" style="min-height: 250px; padding-top: 50px; ">
                            <div class="email-templates-filters">
                                <div class="row" style="padding: 10px;">
                                    <div class="col-md-12">
{{--                                        @if(!empty($type))--}}
{{--                                            @foreach($type as $row)--}}
{{--                                                <a href="javascript:void(0)" class="btn template-link" data-id="{{ $row['id'] }}">{{ $row['name'] }}</a>--}}
{{--                                            @endforeach--}}
{{--                                        @endif--}}
{{--                                        <a href="javascript:void(0)" class="btn template-link" onMouseOver="this.style.color='#23527c'"--}}
{{--                                           onMouseOut="this.style.color='#23527c'"  data-toggle="tab"  data-id="1">Niche Campaigns</a>--}}
{{--                                        <a href="javascript:void(0)" class="btn template-link no-hov" onMouseOver="this.style.color='#23527c'"--}}
{{--                                           onMouseOut="this.style.color='#23527c'" data-toggle="tab" data-id="2">Premium Campaigns</a>--}}
{{--                                        <a href="javascript:void(0)" class="btn template-link no-hov" data-toggle="tab" data-id="2">INDIVIDUAL CAMPAIGNS</a>--}}
                                        <a href="javascript:void(0)" class="btn template-link no-hov" data-toggle="tab" data-id="2">A LA CARTE CAMPAIGNS</a>
{{--                                        <a href="javascript:void(0)" class="btn template-link" data-toggle="tab" data-id="3">MARKETING ROADMAPS</a>--}}
                                        <a href="javascript:void(0)" class="btn template-link" data-toggle="tab" data-id="3">INTEGRATED DIGITAL MARKETING PACKAGES</a>
{{--                                        <a href="{{ route('library-list') }}" class="btn template-link">MARKETING ROADMAPS</a>--}}
                                        <a href="javascript:void(0)" class="btn template-link" data-toggle="tab" data-id="1">DIGITAL MEDIA</a>

{{--                                        <a href="javascript:void(0)" class="btn template-link" data-toggle="tab"  data-id="1">Do-It-With-Me</a>--}}
{{--                                        <a href="javascript:void(0)" class="btn template-link no-hov" data-toggle="tab" data-id="2">Do-It-For-Me</a>--}}
{{--                                        <a href="javascript:void(0)" class="btn template-link" data-toggle="tab">Templates</a>--}}
{{--                                        <br>--}}
                                        <br>
                                        <p class="textForCampaignHeading" id="textFor" style="font-size: 14px;font-weight: 600;"></p>
                                    </div>
                                    <div class="col-md-2" style="display: none"></div>
                                    <div class="col-md-10" style="display: none">
                                        <div class="right-filters">
                                            <div class="form-group type-filter">
                                                <label>Type</label>
                                                <select class="btn btn-default type-filter-dropdown">
                                                    <option value="">ALL</option>
                                                    @if(!empty($type))
                                                        @foreach($type as $row)
                                                            <option value="{{ $row['id'] }}">{{ $row['name'] }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>

                                                {{--                                                <div class="dropdown">--}}
                                                {{--                                                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">--}}
                                                {{--                                                        All--}}
                                                {{--                                                        <span class="caret"></span>--}}
                                                {{--                                                    </button>--}}
                                                {{--                                                    <ul class="dropdown-menu">--}}
                                                {{--                                                        <li><a href="javascript:void(0)">Action</a></li>--}}
                                                {{--                                                    </ul>--}}
                                                {{--                                                </div>--}}
                                            </div>
                                            <div class="form-group category-filter">
                                                <div class="dropdown">
                                                    <label>Category</label>
                                                    <select class="btn btn-default category-filter-dropdown">
                                                        <option value="">ALL</option>

                                                        @if(!empty($category))
                                                            @foreach($category as $row)
                                                                <option
                                                                    value="{{ $row['id'] }}">{{ $row['name'] }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>

                                                    {{--                                                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">--}}
                                                    {{--                                                        All--}}
                                                    {{--                                                        <span class="caret"></span>--}}
                                                    {{--                                                    </button>--}}
                                                    {{--                                                    <ul class="dropdown-menu">--}}
                                                    {{--                                                        <li><a href="#">Action</a></li>--}}
                                                    {{--                                                        <li><a href="#">Another action</a></li>--}}
                                                    {{--                                                        <li><a href="#">Something else here</a></li>--}}
                                                    {{--                                                    </ul>--}}
                                                </div>
                                            </div>

                                            <div class="search-template">
                                                <a href="#"><i class="fa fa-search"></i></a>
                                                <input type="text" class="form-control" placeholder="Search templates">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
{{--                             <div class="template-data" >--}}
{{--                                <h2>Dummy 1 </h2>--}}
{{--                                 <h2>Dummy 2 </h2>--}}
{{--                                 <h2>Dummy 3 </h2>--}}
{{--                                 <h2>Dummy 4 </h2>--}}
{{--                                 <h2>Dummy 5 </h2>--}}
{{--                              </div>--}}

                            <div class="email-templates-container">
                                <div class="templates-box-container">
                                    <div class="row promotion-row campaign-library-row">
                                        <img class="web-loader web-campaign-loader"
                                             src="{{ asset('public/images/spinner.gif') }}"
                                             style="display:table; width:40px;margin: 0px auto;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--    <div id="campaigns-unlock-quota-completed" class="modal fade in modal-manager modal-upgrade-library" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">--}}
    {{--        <div class="modal-dialog" role="document" style="width: 400px;">--}}
    {{--            <div class="modal-content">--}}
    {{--                <div class="modal-header">--}}
    {{--                    <h3 class="modal-campaign-title">--}}
    {{--                        Loyalty Building Using Promotions--}}
    {{--                    </h3>--}}
    {{--                </div>--}}
    {{--                <div class="modal-body">--}}
    {{--                    <div class="description-order" style="margin-bottom: 35px;">--}}
    {{--                        <p>Paid subscribers of nichepractice can unlock 2 marketing--}}
    {{--                            <br>campaigns each month for free or you can purchase the campaigns. All active campaigns will appear in your To-Do-List page--}}
    {{--                        </p>--}}
    {{--                    </div>--}}
    {{--                    <div class="row modal-order-action">--}}
    {{--                        <a href="{{ route('campaigns-library') }}" class="btn btn-choose-campaign" style="margin: 0px auto;display: table; width: 85%; border-radius: 0px; font-weight: 600; ">CHOOSE A CAMPAIGN</a>--}}
    {{--                    </div>--}}
    {{--                </div>--}}

    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
    <input type="hidden" id="planSelected" name="Plan" value="{{(!empty($selectedPlan)) ? $selectedPlan : 0 }}">

    {{--<div class="modal" id="descriptionModal" role="dialog" aria-labelledby="descriptionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <span data-dismiss="modal" class="pull-right" aria-label="Close"><i class="fa fa-close"></i></span>
                </div>
                <div id="orderDetails" class="modal-body">
                </div>
            </div>
        </div>
    </div>--}}
@endsection

@section('css')
    <style>
        .close-btn {
            width: 100%;
            margin-top: 17px;
            padding: 12px;
        }

        .order-credit-action {
            margin-top: 0;
            padding: 15px;
            background-color: #EEF1F5;
        }

        .modal-content {
            padding: 8px 0px 0px 0px;
        }

        .modal-body {
            padding-bottom: 0px;
        }
        .template-data
        {
               background: #f4f5f8;
        }
        .template-data h2
        {
//            font-size:22px;
           font-weight:600;
           margin-left:15px;
           margin-bottom:10px;
           display:flex;
        }
        /*.btn.active, .btn:active {*/
        /*    font-weight: 800;*/
        /*    font-size: 15px;*/


        /*    background-image: none;*/
        /*    outline: 0!important;*/
        /*    -webkit-box-shadow: none!important;*/
        /*    box-shadow: none!important;*/
        /*}*/
        /*.btn.active.focus, .btn.active:focus, .btn.focus, .btn:active.focus, .btn:active:focus, .btn:focus {*/
        /*    outline: 5px auto -webkit-focus-ring-color;*/
        /*    outline-offset: -2px;*/
        /*    color:#165683!important;*/
        /*    font-weight: bold;*/
        /*    font-size: 15px;*/
        /*}*/
        /*.btn:hover{*/
        /*    color: #165683!important;*/
        /*}*/


        /*    /////////////////////Marketing Associations/////////////////////////////*/

        .module-info__image {
            margin-bottom: 15px;
            width: 60px !important;
            height: 60px;
        }

        .nav-pills > li > a {
            color: #ffffff;
            border-radius: 4px !important;
            padding: 6px 12px;
        }

        .heading-title {
            font-weight: 500;
            font-size: 1.8rem !important;
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
            font-family: Roboto, Arial, sans-serif;
            font-weight: 300;
            line-height: 1.29;
        }

        .links {
            padding-top: 15px;
        }

        .links a {
            color: #1a73e8;
        }

        /*.card{*/
        /*    height: 100%;*/
        /*}*/
        /*.row.display-flex {*/
        /*    display: flex;*/
        /*    flex-wrap: wrap;*/
        /*}*/

        .display-flex {
            display: flex;
            flex-wrap: wrap;
            width: 100%;
        }

        .card {
            height: 100%;
        }

        .template-link:hover {
            background-color: #aaaaaa !important;
        }

        .template-link.template-link-active:hover {
            background-color: #5e9ad6 !important;
        }

        .marketing-associations-list {
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

        .card-label-credits {
            background-color: #f9a602;
            padding: 0px;
            border-radius: 5px;
            position: absolute;
            /*top: 3%;*/
            /*bottom: 20%;*/
            bottom: 20px;
            z-index: 1;
            left: 6%;
        }

        .card-label-credits p {
            padding: 2px 13px;
            margin-bottom: 0;
            font-size: 13px;
            font-weight: 500;
        }

        .unlocked-campaign .card-label-credits {
            display: none !important;
        }

        .btn-padding {
            float: right;
            font-weight: 600;
            font-size: 15px;
            background-color: #64cda4;
            color: white;
            padding-left: 40px;
            padding-right: 40px;
        }

        .template-name {
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }

        .textForCampaignHeading
        {
            margin:5px 0 0 !important;
        }

        @media screen and (max-width: 567px) {
            .btn-padding {
                float: none;
                font-weight: 600;
                font-size: 15px;
                background-color: #64cda4;
                color: white;
                padding-left: 40px;
                padding-right: 40px;
            }


        }

        .t-image-overlay .text {
            display: flex;
            justify-content: center;
            align-items: center;
        }

    </style>

@endsection

@section('js')
    <script>
        window.currentPageSource = 'campaign_library';
        $(function () {
            loadPosts('open');
        });
    </script>
    <script src="{{ asset('public/js/task/tabs-task.js?ver='.$appFileVersion) }}"></script>
    <script>

        // toggle free and premium template
        $(document).ready(function () {
            $('.template-link').click(function () {
                var id = $(this).attr('data-id');
                var baseUrl = $('#hfBaseUrl').val();
                $(".template-link").removeClass('template-link-active');

                $(this).addClass('template-link-active');
                $(".template-box-container-col-sm-3").hide();
           //             $(".list-"+id).show();
           //             console.log(id);
          //     });
          // });
                if(id == 1 || id == 2) {
                    // $('.textForCampaignHeading').html('Instantly implement monthly marketing ' +
                    //     'campaigns to boost your practice and help maintain and grow your patient base.');
                    $('.textForCampaignHeading').html('View All | Grow Your Reputation | Website Traffic |');
//                     $(document.body).on('click',".no-hov",function()
//                     {
//                         var mainClass = document.getElementById("#textFor")
//                         $(mainClass).style.display="none";
//                     })
                }
                if (id == 3) {

                     $('.textForCampaignHeading').html('For many doctors, marketing agencies' +
                        ' are prohibitively expensive. The Digital marketing Roadmap aims to provide affordable and' +
                        ' accessible marketing solutions for doctors ready to set out on a marketing journey.');

                    // console.log(id);
                    //  console.log('if');
                    //  showPreloader();
                    //  $('.web-loader').show();
                    //  $(".web-campaign-loader").show();
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('input[name="_token"]').val()
                        },
                        type: "POST",
                        url: baseUrl + "/done-me",
                        data: {
                            send: 'retrieve-library-list'
                        }

                    }).done(function (result) {
                        // hidePreloader();
                        // $('.web-loader').hide();
                        // $(".web-campaign-loader").hide();
                        // parse data into json
                        var json = $.parseJSON(result);

                        // get data
                        var statusCode = json.status_code;
                        var statusMessage = json.status_message;

                        var data = '';
                        data = json.data;
                        var totalTasks = json.data.length;
                        var thumbnail = '';
                        var campaignCount = 0;
                        var campaignCredit = 0;
                        var html = '';
                        html += '<div class="marketing-assoc-list-outer display-flex">';
                        // '<div class="col-sm-12">';
                        $.each(data.association, function (index, value) {
                            campaignCount = 0;
                            campaignCredit = 0;
                            if (value.has_many_campaigns != '') {
                                $.each(value.has_many_campaigns, function (index, value) {
                                    campaignCount++;
                                    campaignCredit += value.credits;
                                });
                            }
                            var description = value.description;
                            if (description) {
                                description = value.description;
                            } else {
                                description = '';
                            }
                            if (value.thumbnail != null) {
                                thumbnail = '/storage/app/' + value.thumbnail;
                            } else {
                                thumbnail = '/public/images/clickFeature.png';
                            }
                            // html += '<img class="web-loader" src="'+baseUrl+'/public/images/spinner.gif" style="display:none; width:40px;">';
                            html +=
                                '<div class="col-sm-3" style="margin-bottom: 20px">' +
                                '<div class="card" style="min-width: 100%">' +
                                '<div class="card-header" style="border-bottom: 1px solid #e8eaed;padding-bottom: 15px;">' +
                                '<a href="javascript:void(0);">' +
                                '<img class="module-info__image" src="' + baseUrl + '' + thumbnail + '" alt="The online opportunity">' +
                                // '<h4 class="heading-title">New to Marketing?</h4>'+
                                '<h4 class="heading-title">' + value.name + '</h4>' +
                                '</a>' +
                                '<span class="subtitle">' + campaignCount + ' Campaign\'s / ' + campaignCredit + ' Credits</span>' +
                                '<p class="subtitle-desc"  data-description="' + description + '" style="margin-top: 5px;justify-content: flex-start!important; cursor: pointer; font-weight: 400; font-size: 14px;"> Learn More </p>' +
                                '</div>' +
                                '<div class="links">';
                            if (value.has_many_campaigns != '') {
                                $.each(value.has_many_campaigns, function (index, value) {
                                    html += '<div style="padding: 2px 0">' +
                                        '<a class="link" href="javascript:void(0);">' + value['name'] + ' <i  class="fa fa-question-circle btn-campaign"  data-credits="' + value['credits'] + '" data-campaign-target="' + value['id'] + '"></i></a>' +
                                        '</div>';
                                });
                            } else {
                                html += '<div style="padding: 10px 0">' +
                                    '<p class="link">No Campaign Found</p>' +
                                    '</div>';
                            }

                            html += '</div>' +
                                '</div>' +
                                '</div>';
                        });
                        html +=
                            // '</div>'+
                            '</div>';
                        $(".campaign-library-row").append(html);
                        $('.marketing-assoc-list-outer').show();
                    });
                } else {
                    // console.log(id);
                    // console.log('else');
                    $(".list-" + id).show();
                    $('.marketing-assoc-list-outer').remove();
                }
            });
        });
        // });

        // not enough credit cancel
        $(document.body).on('click', '.order-credit-cancel', function () {
            var mainModel = $('.modal-alert-credit');
            $(".fa-exclamation-triangle", mainModel).remove();
            mainModel.modal('hide');
        });

        // $(function () {
        //     $(document).ready(function () {
        //         $('.template-link').click(function () {
        //             var id = $(this).attr('data-id');
        //             var baseUrl = $('#hfBaseUrl').val();
        //             if(id === 3) {
        // $.ajax({
        //     headers: {
        //         'X-CSRF-TOKEN': $('input[name="_token"]').val()
        //     },
        //     type: "POST",
        //     url: baseUrl + "/done-me",
        //     data:{
        //         send: 'retrieve-library-list'
        //     }
        //
        // }).done(function (result) {
        //
        //     // parse data into json
        //     var json = $.parseJSON(result);
        //
        //     // get data
        //     var statusCode = json.status_code;
        //     var statusMessage = json.status_message;
        //
        //
        //     var data = '';
        //     data = json.data;
        //     var totalTasks = json.data.length;
        //     var thumbnail = '';
        //     var campaignCount = 0;
        //     var campaignCredit = 0;
        //     var html = '';
        //     $.each(data.association, function (index, value){
        //         campaignCount = 0;
        //         campaignCredit = 0;
        //         if(value.has_many_campaigns != '') {
        //             $.each(value.has_many_campaigns, function (index, value){
        //                 campaignCount++;
        //                 campaignCredit += value.credits;
        //             });
        //         }
        //         var description = value.description;
        //         if(description) {
        //             description = value.description;
        //         }
        //         else{
        //             description = '';
        //         }
        //         if (value.thumbnail != null){
        //             thumbnail = '/storage/app/' +value.thumbnail;
        //         }
        //         else{
        //             thumbnail =  '/public/images/clickFeature.png';
        //         }
        //
        //         html +=
        //             '<div class="col-sm-3" style="margin-bottom: 20px">'+
        //             '<div class="card" style="min-width: 100%">'+
        //             '<div class="card-header" style="border-bottom: 1px solid #e8eaed;padding-bottom: 15px;">'+
        //             '<a href="javascript:void(0);">'+
        //             '<img class="module-info__image" src="'+baseUrl+''+thumbnail+'" alt="The online opportunity">'+
        //             // '<h4 class="heading-title">New to Marketing?</h4>'+
        //             '<h4 class="heading-title">'+value.name+'</h4>'+
        //             '</a>'+
        //             '<span class="subtitle">'+campaignCount+ ' Campaign\'s / '+campaignCredit+' Credits</span>'+
        //             '<p class="subtitle-desc" style="margin-top: 5px">'+description+'</p>'+
        //             '</div>'+
        //             '<div class="links">';
        //         if(value.has_many_campaigns != '') {
        //             $.each(value.has_many_campaigns, function (index, value){
        //                 html +=  '<div style="padding: 2px 0">'+
        //                     '<a class="link" href="javascript:void(0);">'+value['name']+' <i  class="fa fa-question-circle btn-campaign"  data-credits="'+value['credits']+'" data-campaign-target="'+value['id']+'"></i></a>'+
        //                     '</div>';
        //             });
        //         } else {
        //             html +=  '<div style="padding: 10px 0">'+
        //                 '<p class="link">No Campaign Found</p>'+
        //                 '</div>';
        //         }
        //
        //         html +=       '</div>'+
        //             '</div>'+
        //             '</div>';
        //
        //     });
        //     $( ".campaign-library-row" ).append( html );
        //
        // });
        //             }
        //         });
        //     });
        // });

        $(document.body).on('click', '.subtitle-desc', function () {
            var mainModel = $('#main-modal');

            $(".modal-body, .modal-footer, .validate-me", mainModel).remove();
            $(mainModel).removeClass('welcome-process');

            var description = $(this).attr('data-description');

            var html = '<div class="modal-body" style="padding-bottom: 35px;">\n' +
                '           <div class="description-order">\n' +
                '               <h3 class="text-center">' + description + '</h3>' +
                '           </div>\n' +
                '       </div>';
            mainModel.modal('show');
            $(".modal-header").after(html);
        });
        // var mainClass = document.getElementsByClassName(".textForCampaignHeading")
        // $(document.body).on('click',".no-hov",function()
        // {
        //     var mainClass = document.getElementById("#textFor")
        //     $(mainClass).style.display="none";
        // })
    </script>
@endsection
