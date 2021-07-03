@extends('index')

@section('pageTitle', 'Monitor Reviews')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid dashboarbgtitle reviews-panel">
            <div class="dashboard-wrapper">
                <div class="page-head">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="page-title"> Monitor Reviews
{{--                                <a class="page-help" href="javascript:void(0)">--}}
{{--                                    <i class="fa fa-question-circle-o" style="color: #7d8080;/* transform: scaleX(-1); */margin-right: 5px;"></i>--}}
{{--                                    <img class="help-info-image" src="{{ asset('public/images/information.png') }}" />--}}
{{--                                </a>--}}
                            </h4>
                        </div>
                        <div class="col-md-6 text-center">
                            <a href="{{ route('citation-listings') }}" class="btn btn-primary btn-review-site">Add Review Site</a>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="d-table table-responsive">
                            <div class="d-table-head">
                                <div class="row col-sm-12">
                                    <div class="col-sm-4 col-md-5">
                                        <div class="form-group head-search-review">
                                            <input id="search-table" type="text" class="form-control" placeholder="Search a Review" />
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-2 text-center">
                                        <div class="form-group sources-list">
                                            <div class="dropdown">
                                                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" data-text="All Sources">
                                                    <span class="filter-label">All Sources</span>
                                                    <span class="caret"></span>
                                                </button>

                                                <ul data-filter-type="sources-list" data-filter="4" class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                    {{--<li>--}}
                                                        {{--<a href="javascript:void(0);">--}}
                                                            {{--<div class="checkbox checkbox-primary">--}}
                                                                {{--<input id="checkbox2" class="styled" type="checkbox">--}}
                                                                {{--<label for="checkbox2">--}}
                                                                    {{--Select All--}}
                                                                {{--</label>--}}
                                                            {{--</div>--}}
                                                        {{--</a>--}}
                                                    {{--</li>--}}

                                                    <li role="separator" class="divider"></li>

                                                    <li class="source-row" data-source="nichepractice">
                                                        <a href="javascript:void(0);">
                                                            <div class="checkbox checkbox-primary"><input id="" class="styled" type="checkbox">
                                                                <label for="checkbox2">
                                                                    <img src="{{ asset('public/images/favicon.png') }}" />
                                                                    Nichepractice
                                                                </label>
                                                            </div>
                                                        </a>
                                                    </li>

                                                    <?php
                                                    //                                                    $sources = ['Zocdoc', 'Google', 'Facebook', 'Yelp', 'Foursquare'];
                                                    $sources = thirdPartySources();
                                                    foreach($sources as $source)
                                                    {
                                                    $reviewType = trim(str_replace("places", "", strtolower($source)));
                                                    $sourceType = ucFirst($reviewType);
                                                    ?>
                                                    <li class="source-row" data-source="{{ $reviewType }}">
                                                        <a href="javascript:void(0);">
                                                            <div class="checkbox checkbox-primary"><input id="" class="styled" type="checkbox">
                                                                <label for="checkbox2">
                                                                    <img src="{{ asset('public/images/icons/'.$reviewType.'-large.png') }}"/>
                                                                    {{ $sourceType }}
                                                                </label>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <?php } ?>
                                                </ul>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-2 text-center">
                                        <div class="form-group ratings-list">
                                            <div class="dropdown">
                                                <button class="btn btn-default dropdown-toggle" type="button"
                                                        id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="true" data-text="All Ratings">
                                                    <span class="filter-label">All Ratings</span>
                                                    <span class="caret"></span>
                                                </button>

                                                <ul data-filter-type="ratings-list" data-filter="1" class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                    @for($i = 5; $i>=1; $i--)
                                                    <li class="source-row" data-source="{{ $i }}">
                                                        <a href="javascript:void(0);">
                                                            <div class="checkbox checkbox-primary">
                                                                <input id="{{ $i }}" class="styled" type="checkbox">
                                                                <label for="{{ $i }}">
                                                                    <div class="g-rating-stars">
                                                                        <span><i class="active fa fa-star"></i></span>
                                                                        @if($i == 1)
                                                                            {{ $i }} Star
                                                                        @else
                                                                        {{ $i }} Stars
                                                                        @endif
                                                                    </div>
                                                                </label>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    @endfor
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-2 text-center">
                                        <div class="form-group">
                                            <div class="dropdown">
                                                <button class="btn btn-default dropdown-toggle date-ordering" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                    All Time
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu ordering-date" aria-labelledby="dropdownMenu1">
                                                    <li><a href="javascript:void(0);" data-action="newest">Newest</a></li>
                                                    <li><a href="javascript:void(0);" data-action="oldest">Oldest</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

{{--                                    <div class="col-sm-2 col-md-2">--}}
{{--                                        <div class="form-group status-list">--}}
{{--                                            <div class="dropdown" style="margin-left: 0;">--}}
{{--                                                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" data-text="All Status">--}}
{{--                                                    <span class="filter-label">All Status</span>--}}
{{--                                                    <span class="caret"></span>--}}
{{--                                                </button>--}}

{{--                                                <ul data-filter-type="status-list" data-filter="5" class="dropdown-menu" aria-labelledby="dropdownMenu1">--}}
{{--                                                    <li class="source-row" data-source="In Progress">--}}
{{--                                                        <a href="javascript:void(0);">--}}
{{--                                                            <div class="checkbox checkbox-primary">--}}
{{--                                                                <input id="inprogress" class="styled" type="checkbox">--}}
{{--                                                                <label for="inprogress">--}}
{{--                                                                    <span style="margin-left: 0;margin-right: 6px;" class="inprogress"></span> In Progress--}}
{{--                                                                </label>--}}
{{--                                                            </div>--}}
{{--                                                        </a>--}}
{{--                                                    </li>--}}

{{--                                                    <li class="source-row" data-source="Do Not Respond">--}}
{{--                                                        <a href="javascript:void(0);">--}}
{{--                                                            <div class="checkbox checkbox-primary">--}}
{{--                                                                <input id="notrespond" class="styled" type="checkbox">--}}
{{--                                                                <label for="notrespond">--}}
{{--                                                                    <span style="margin-left: 0;margin-right: 6px;" class="notrespond"></span> Do Not Respond--}}
{{--                                                                </label>--}}
{{--                                                            </div>--}}
{{--                                                        </a>--}}
{{--                                                    </li>--}}

{{--                                                    <li class="source-row" data-source="Responded">--}}
{{--                                                        <a href="javascript:void(0);">--}}
{{--                                                            <div class="checkbox checkbox-primary">--}}
{{--                                                                <input id="responded" class="styled" type="checkbox">--}}
{{--                                                                <label for="responded">--}}
{{--                                                                    <span style="margin-left: 0;margin-right: 6px;" class="responded"></span> Responded--}}
{{--                                                                </label>--}}
{{--                                                            </div>--}}
{{--                                                        </a>--}}
{{--                                                    </li>--}}
{{--                                                </ul>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                </div>
                            </div>
                            <div class="overflow-x">
                              <table id="t-email-campaigns" class="table-responsive email-campaign dataTable no-footer" style="" role="grid" aria-describedby="t-email-campaigns_info">
                                <thead>
                                <tr style="height: 60px;background: #f9f9f9;" role="row">
                                    <th class="select-checkbox"></th>

                                    <th>
                                        <span>Rating</span>
                                    </th>

                                    <th>
                                        <span>Review</span>
                                    </th>

                                    <th>
                                        <span>Date</span>
                                    </th>

                                    <th>
                                        Source
                                    </th>

                                    <th>
                                        Reply
                                    </th>
                                </tr>
                                </thead>

                                <tbody>
                                @if(!empty($negativeReviews))
                                    @foreach($negativeReviews as $review)
                                        <?php
                                        $reviewRequest = $review['review_request'][0];
                                        $message = $reviewRequest['message'];
                                        $date = $reviewRequest['date_sent'];
                                        ?>
                                        <tr role="row" class="odd">
                                            <td class="select-checkbox"></td>

                                            <?php
//                                            $count = !empty($row['rating']) ? $row['rating']: 0;
                                            $count = 1;
                                            $starRating = $count * 20;
                                            ?>

                                            <td class="text-verticle-align" data-order="<?php echo intval($count); ?>" data-search="<?php echo intval($count); ?>">
                                                <div class="rating-column">
                                                    <div class="g-rating-stars">
                                                            <span class="rating">
                                                                <span class="rating-value" style="width:20%"></span>
                                                            </span>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="text-verticle-align" width="50%">
                                                <div class="review-column">
                                                    <p>{{ $message }}</p>
                                                </div>

                                            </td>

                                            <td class="text-verticle-align">

                                                <div class="date-column">
                                                    <p>{{ $date }}</p>
                                                </div>
                                            </td>

                                            <?php
                                            $reviewType = 'favicon';
                                            $originalType = 'NichePractice';
                                            ?>
                                            <td class="text-verticle-align" width="15%">
                                                <div class="source-column">
                                                    <div class="healthgrades {{ $reviewType }}">
                                                        <img style="height: 18px;" src="{{ asset('public/images/'.$reviewType.'.png') }}" />
                                                        <label>{{ $originalType }}</label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td></td>
{{--                                            <td>--}}
{{--                                                <div class="status-column">--}}
{{--                                                    <a class="dropdown-item" href="javascript:void(0)">--}}
{{--                                                        <span class="responded"></span>--}}
{{--                                                        <span class="action-name">Respond</span>--}}
{{--                                                    </a>--}}
{{--                                                </div>--}}
{{--                                            </td>--}}
                                        </tr>
                                    @endforeach
                                @endif


                                @if(!empty($reviewsResult['records']))
                                    @foreach($reviewsResult['records'] as $index => $businessReviews)
                                        @foreach($businessReviews as $row)
                                            <tr role="row" class="odd">
                                                <td class="select-checkbox"></td>

                                                <?php
                                                $count = !empty($row['rating']) ? $row['rating']: 0;
                                                $starRating = $count * 20;
                                                ?>

                                                <td class="text-verticle-align" data-order="<?php echo intval($count); ?>" data-search="<?php echo intval($count); ?>">
                                                    <div class="rating-column">
                                                        <div class="g-rating-stars">
                                                                <span class="rating">
                                                                    <span class="rating-value" style="width:{{ $starRating.'%' }}">
                                                                    </span>
                                                                </span>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td class="text-verticle-align" width="50%">
                                                    <div class="review-column">
                                                        <p>{!! $row['message'] !!}</p>
                                                    </div>


                                                </td>

                                                <td class="text-verticle-align">

                                                    <div class="date-column">
                                                        <p>{{ $row['review_date'] }}</p>
                                                    </div>
                                                </td>

                                                <?php
                                                $reviewType = str_replace(" ", "", strtolower($row['type']));
                                                if ($reviewType == 'googleplaces') {
                                                    $originalType = 'Google';
                                                } else {
                                                    $originalType = ucfirst($reviewType);
                                                }

                                                ?>
                                                <td class="text-verticle-align" width="15%">
                                                    <div class="source-column">
                                                        <div class="{{ $reviewType }}">
                                                            <img src="{{ asset('public/images/icons/'.$reviewType.'.png') }}"/>
                                                            <label>{{ $originalType }}</label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="status-column">
                                                        <?php
                                                        $reviewTypeCheck = str_replace(" ", "", strtolower($row['type']));

                                                        ?>
{{--                                                        if ($reviewTypeCheck == 'googleplaces') {--}}
                                                        @if(!empty($row['review_url']) && $reviewTypeCheck == 'googleplaces')
                                                        <a class="dropdown-item" href="{{ $row['review_url'] }}" target="_blank">
                                                            <span class="responded"></span>
                                                            <span class="action-name">Reply</span>
                                                        </a>
{{--                                                        @else--}}
{{--                                                            <a class="dropdown-item" href="javascript:void(0)">--}}
{{--                                                                <span class="responded"></span>--}}
{{--                                                                <span class="action-name">Respond</span>--}}
{{--                                                            </a>--}}
                                                        @endif
                                                    </div>
                                                </td>
                                                @if($index == 0)
{{--                                                <td class="text-verticle-align review-requests-col" data-search="Do Not Respond">--}}
{{--                                                    <div class="status-column">--}}
{{--                                                            <div class="dropdown">--}}
{{--                                                                <button class="btn btn-secondary dropdown-toggle" type="button"--}}
{{--                                                                        id="dropdownMenuButton" data-toggle="dropdown"--}}
{{--                                                                        aria-haspopup="true" aria-expanded="false">--}}
{{--                                                                    <a class="dropdown-item" href="javascript:void(0);">--}}
{{--                                                                        <span class="notrespond"></span>--}}
{{--                                                                        <span class="action-name">Do Not Respond</span>--}}
{{--                                                                    </a>--}}
{{--                                                                </button>--}}

{{--                                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="display: none;">--}}

{{--                                                                    <a class="dropdown-item" href="javascript:void(0);">--}}
{{--                                                                        <span class="inprogress"></span>--}}
{{--                                                                        <span class="action-name">In Progress</span>--}}
{{--                                                                    </a>--}}
{{--                                                                    <a class="dropdown-item"href="javascript:void(0);"> <span--}}
{{--                                                                                class="responded"></span>--}}
{{--                                                                        <span class="action-name">Responded</span>--}}
{{--                                                                    </a>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                </td>--}}
                                                @elseif($index == 1)
{{--                                                    <td class="text-verticle-align review-requests-col" data-search="Responded">--}}
{{--                                                        <div class="status-column">--}}
{{--                                                        <div class="dropdown">--}}
{{--                                                            <button class="btn btn-secondary dropdown-toggle" type="button"--}}
{{--                                                                    id="dropdownMenuButton" data-toggle="dropdown"--}}
{{--                                                                    aria-haspopup="true" aria-expanded="false">--}}
{{--                                                                <a class="dropdown-item"href="javascript:void(0);"> <span--}}
{{--                                                                            class="responded"></span>--}}
{{--                                                                    <span class="action-name">Responded</span>--}}
{{--                                                                </a>--}}
{{--                                                            </button>--}}

{{--                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="display: none;">--}}

{{--                                                                <a class="dropdown-item" href="javascript:void(0);">--}}
{{--                                                                    <span class="notrespond"></span>--}}
{{--                                                                    <span class="action-name">Do Not Respond</span>--}}
{{--                                                                </a>--}}
{{--                                                                <a class="dropdown-item" href="javascript:void(0);">--}}
{{--                                                                    <span class="inprogress"></span>--}}
{{--                                                                    <span class="action-name">In Progress</span>--}}
{{--                                                                </a>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}


{{--                                                    </div>--}}
{{--                                                    </td>--}}
                                                @else
{{--                                                    <td class="text-verticle-align review-requests-col" data-search="In Progress">--}}
{{--                                                        <div class="status-column">--}}
{{--                                                        <div class="dropdown">--}}
{{--                                                            <button class="btn btn-secondary dropdown-toggle" type="button"--}}
{{--                                                                    id="dropdownMenuButton" data-toggle="dropdown"--}}
{{--                                                                    aria-haspopup="true" aria-expanded="false">--}}
{{--                                                                <a class="dropdown-item" href="javascript:void(0);">--}}
{{--                                                                    <span class="inprogress"></span>--}}
{{--                                                                    <span class="action-name">In Progress</span>--}}
{{--                                                                </a>--}}
{{--                                                            </button>--}}

{{--                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="display: none;">--}}

{{--                                                                <a class="dropdown-item" href="javascript:void(0);">--}}
{{--                                                                    <span class="notrespond"></span>--}}
{{--                                                                    <span class="action-name">Do Not Respond</span>--}}
{{--                                                                </a>--}}
{{--                                                                <a class="dropdown-item"href="javascript:void(0);"> <span--}}
{{--                                                                            class="responded"></span>--}}
{{--                                                                    <span class="action-name">Responded</span>--}}
{{--                                                                </a>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}


{{--                                                    </div>--}}
{{--                                                    </td>--}}
                                                @endif
                                            </tr>
                                        @endforeach
                                    @endforeach
                                @else
                                    {{--{{ $reviewsResult['_metadata']['message'] }}--}}
                                @endif
                                </tbody>
                              </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('before_css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/sl-1.3.0/datatables.min.css"/>
    <style>
        .select-checkbox {
            display: none;
        }

        @media only screen and (max-width:390px){
            .overflow-x{
                overflow-x:scroll;
            }
            .overflow-x::-webkit-scrollbar{
                width:5px;
                height:6px;
            }
            .overflow-x::-webkit-scrollbar-thumb{
                background-color: #888;
            }
            .overflow-x::-webkit-scrollbar-track{
                background-color: #f1f1f1;
            }
        }
    </style>
@endsection

@section('js')
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/sl-1.3.0/datatables.min.js"></script>
    <script type="text/javascript" src="{{ asset('public/plugins/multi-text/fewlines.js') }}"></script>

    <script>
        // review-column
        $('.review-column p').fewlines(
            {
                lines : 4,
                openMark : ' See More',
                closeMark : ' See Less',
                newLine: false,
            }
        );
        function filterColumn ( colummn, data ) {
            console.log("filter column ");
            $('#t-email-campaigns').DataTable().column( colummn ).search(
                // "Healthgrades|ratemd", true,
                data, true, false
                // $('#col'+i+'_filter').val(), true,
                // $('#col'+i+'_smart').prop('checked')
            ).draw();
        }

        function serializeData(selector, column, push)
        {
            push = (push && push !== '') ? 'push' : '';

            var count = 0;
            var selectedData = '';

            $(".source-row", selector).each(function (index) {
                var source = $(this).attr('data-source');
                var checked = ($(this).find('.checkbox > input').is(':checked') === true) ? 1 : 0;

                // console.log(" source > " + source);
                // console.log(" checked > " + checked);

                if(checked === 1)
                {
                    if(selectedData === '')
                    {
                        selectedData = source;
                    }
                    else
                    {
                        selectedData += '|'+source;
                    }
                }
            });
            // console.log("selectedData");
            // console.log(selectedData);

            // console.log("column");
            // console.log(column);

            filterColumn(column, selectedData);

            var dropdownSelector = $(".dropdown-toggle", selector);

            if(selectedData === '')
            {
                // console.log("empty in " + dropdownSelector.attr("data-text"));
                if(dropdownSelector.attr("data-text") && dropdownSelector.attr("data-text") !== '')
                {
                    $(".filter-label", dropdownSelector).html(dropdownSelector.attr("data-text"));
                }
            }
            else
            {
                // dropdownSelector.attr("data-text", $(".filter-label", dropdownSelector).html());
                $(".filter-label", dropdownSelector).html('Filtered');
            }
        }

        $(function () {
            var table = $('#t-email-campaigns').DataTable(
                {
                    // select: false,
                    ordering: true,
                    // Sortable: true
                    // paging: true,
                    // "dom": '<"top"i>rt<"bottom"><"clear">'
                    // searching: false,
                    // lengthMenu: [ 15, 20, 50 ],
                    pageLength: 100
                } );


            /**
             * All time filter
             */
            $(".ordering-date a").click(function () {
                var action = $(this).attr("data-action");

                $(".date-ordering").html($(this).html() + ' <span class="caret"></span>');

                // $(this).remove();

                if(action === 'newest')
                {
                    $('#t-email-campaigns').DataTable().order([3, 'desc']).draw();
                }
                else
                {
                    $('#t-email-campaigns').DataTable().order([3, 'asc']).draw();
                }

            });

                // table.fnSort([ [3,'desc']] );


            // var table = $('#example').DataTable({
            //     "dom": '<"top"i>rt<"bottom"><"clear">'
            // });

            // Event listener to the two range filtering inputs to redraw on input
            // $('#min, #max').keyup( function() {
            //     table.draw();
            // } );

            $('#search-table').on( 'keyup', function () {
                table.search($('#search-table').val()).draw();
            } );


            // $('input.column_filter').on( 'keyup click', function () {
            // filterColumn( $(this).parents('tr').attr('data-column') );
            // } );

            $(document.body).on('click', '.dropdown-menu .checkbox input', function () {
                var column = $(this).closest('ul').attr("data-filter");
                var source = $(this).closest('ul').attr("data-filter-type");
                // var column = 4;
                // console.log("column " + column);

                serializeData('.'+source, column);
            });


            // $(document.body).on('click', '.dropdown-menu .dropdown-item', function() {
            //     var targetAction = $(this).html(); // which we want to select
            //     var activeAction = $(this).closest('.status-column').find('.dropdown-toggle').html();
            //
            //
            //     $(this).closest('.status-column').find('.dropdown-toggle').html(targetAction);
            //     $(this).html(activeAction);
            // });

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
                // console.log("activeAction " + activeAction);
//                 // console.log("targetAction " + targetAction);
//                 // console.log("activeAction 1 " + $(".action-name", targetAction).html());
//             });
        });
    </script>
@endsection
