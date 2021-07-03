@extends('index')

@section('pageTitle', 'Get More Reviews')

@section('content')
    <div id="page-wrapper" style="min-height: 271px;">
        <div class="container-fluid dashboarbgtitle">
            <div class="dashboard-wrapper">

                <div class="page-head">
                    {{--<div class="back-page">--}}
                        {{--<i class="fa fa-angle-left"></i><a href="{{ route('reviews') }}">Monitor Your Online Reviews</a>--}}
                    {{--</div>--}}
                    <div class="row">

                        <div class="col-md-6">
                            <h4 class="page-title"> Add Review Sites  <a class="page-help" href="javascript:void(0)"><i class="fa fa-question-circle-o" style="color: #7d8080;/* transform: scaleX(-1); */margin-right: 5px;"></i></a></h4>
                            <p class="page-tagline">Connect one of these sites to track your reviews.</p>
                        </div>
                        <div class="col-md-6">

                        </div>

                    </div>


                </div>


                <div class="new-site-wrapper">
                    <div class="row">
                        @foreach($sources as $source)
                            <div class="col-md-6">
                                <?php
                                $reviewType = str_replace(" ", "", strtolower($source['name']));
                                $originalName = $source['name'];
                                $name = $originalName;

                                if($name == 'Google Places')
                                {
                                    $name = 'Google';
                                }
                                ?>
                            <div class="new-site-widget {{ $reviewType }}-widget">
                                <img src="{{ asset('public/images/icons/'.$reviewType.'-large.png') }}"/>

                                <label>{{ $name }}</label>

                                @if($source['status'] === 'connected')
                                    <a href="javascript:void(0);" class="btn btn-primary btn-site-disconnect unlink-app" data-type="{{ $originalName }}">
                                        Disconnect
                                    </a>
                                @else
                                    <a href="javascript:void(0);" class="btn btn-primary btn-new-site connect-app" data-type="{{ $originalName }}">Add {{ $name }}</a>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>

        </div>
    </div>
    @if($socialToken == 1 && $accessTokenType != '')
        <input type="hidden" id="accessToken" value="{{ $socialToken }}" data-type="{{ $accessTokenType }}" />
    @endif
    <input type="hidden" id="currentPage" value="connect_apps" />
    <input type="hidden" id="business_id" value="{{ $userData['business'][0]['business_id'] }}" />
@endsection


@section('before_css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/sl-1.3.0/datatables.min.css"/>
@endsection

@section('js')
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/sl-1.3.0/datatables.min.js"></script>
    <script type="text/javascript" src="{{ asset('public/js/connect-apps.js?ver='.$appFileVersion) }}"></script>
    {{--<script type="text/javascript" src="{{ asset('public/js/connect-apps.js') }}"></script>--}}

    <img src="{{ asset('public/images/icons/'.$reviewType.'-large.png') }}"/>

    <script>
        $(function () {
            $('#t-email-campaigns').DataTable(
                {
                select: false,
                ordering: false,
                paging: true,
                searching: false,
                // lengthMenu: [ 15, 20, 50 ],
                //     pageLength: 20
            } );

            $(document.body).on('click', '.dropdown-menu .dropdown-item', function() {
                var targetAction = $(this).html(); // which we want to select
                var activeAction = $(this).closest('.status-column').find('.dropdown-toggle').html();


                $(this).closest('.status-column').find('.dropdown-toggle').html(targetAction);
                $(this).html(activeAction);
            });

//             $(".dropdown-menu .dropdown-item").click(function()
//             {
//                 var targetAction = $(this).html(); // which we want to select
// //	var activeAction = $(".dropdown-toggle .dropdown-item").html();
//                 var activeAction = $(this).closest('.status-column').find('.dropdown-toggle').html();
//
//
//                 $(this).closest('.status-column').find('.dropdown-toggle').html(targetAction);
//                 $(this).html(activeAction);
//
//                 //var targetName = $(".action-name", targetAction).html();
//                 //var targetStatus = $(".action-name", targetAction).html();
//
//                 // console.log("activeAction " + activeAction);
//                 // console.log("targetAction " + targetAction);
//                 // console.log("activeAction 1 " + $(".action-name", targetAction).html());
//             });
        });
    </script>
@endsection
