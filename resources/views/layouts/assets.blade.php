@extends('index')

@section('pageTitle', $title)

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid dashboarbgtitle">
            <div class="dashboard-wrapper asset-screen" style="">
                <div class="page-head">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="page-title">Assets
                                {{--                                <a class="page-help" href="javascript:void(0)">--}}
                                {{--                                    <i class="fa fa-question-circle-o" style="color: #7d8080;/* transform: scaleX(-1); */margin-right: 5px;"></i>--}}
                                {{--                                    <img class="help-info-image" src="{{ asset('public/images/information.png') }}" />--}}
                                {{--                                </a>--}}
                            </h4>
                        </div>
                        <div class="col-md-12">
                            <div class="table-content">
                                <div class="table-body">
                                    <div class="table-responsive">
                                        <div class="recipient-stats" style="display:none; min-width: 40px !important; padding-left: 0px; padding-right: 10px !important; display: flex; float: right; justify-content: flex-end;">
                                            <span id="info_cont"></span>
                                            <span id="pagination_cont"></span>
                                        </div>
                                        <table id="recipient-list" class="table custom-table" style="border: none;">
                                            <thead>
                                            <tr style="background: #f9f9f9;">
                                                <th>
                                                    <span>Title</span>
                                                </th>
                                                <th>
                                                    <span>Content</span>
                                                </th>
                                                <th>
                                                    <span>File Name</span>
                                                </th>
                                                <th>
                                                    <span>Created at</span>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(!empty($records))
                                                @foreach($records as $record)
                                                    <tr>
                                                        <td style="min-width: 60px !important;">
                                                            @if(!empty($record['title']))
                                                              {{$record['title']}}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(!empty($record['content']))
                                                                {{$record['content']}}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(!empty($record['file_name']))
                                                                {{$record['file_name'] . ' ' }}
                                                                <a href="{{asset('storage/app/'.$record['file_name'].'') }}" style="color: #0d65e0;text-decoration: underline" download> Download</a>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(!empty($record['created_at']))
                                                                {{$record['created_at']}}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
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
        </div>
    </div>
    <input type="hidden" id="currentPage" value="user_assets" />
@endsection

@section('css')
    <link type="text/css" rel="stylesheet" href="{{ asset('public/plugins/datatables/jquery.dataTables.min.css') }}" />
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/select/1.2.1/css/select.dataTables.min.css" />
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/scroller/2.0.0/css/scroller.dataTables.min.css" />
    <style>

        #recipient-list_wrapper thead th {
            border-bottom: none;
            text-transform: capitalize;
            font-weight: 600;
            font-size: 16px;
            line-height: 2.5;
            color: #000;
        }
        .bootstrap-select.btn-group.disabled,
        .bootstrap-select.btn-group>.disabled {
            cursor: default;
        }
        .bootstrap-select.disabled button.disabled{
            background-color: #ffffff;
            cursor: default;
        }
        .bootstrap-select .filter-option{
            font-weight: 600;
        }
        .bootstrap-select.disabled .filter-option{
            font-weight: 700;
        }
        .paginate_button{
            display: none;
        }
        #customers-list_info{
            display: none !important;
        }
        @media (max-width: 1440px) {
            .asset-screen {
                padding: 0 30px !important;
            }
        }

    </style>
@endsection


@section('js')
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/select/1.2.1/js/dataTables.select.min.js"></script>
    <script type="text/javascript" src="{{ asset('public/js/tableHeadFixer.js?ver='.$appFileVersion) }}"></script>
{{--    <script type="text/javascript" src="{{ asset('public/js/crm-customers/crm-customers.js?ver='.$appFileVersion) }}"></script>--}}
    <script>
        $('#recipient-list').DataTable(
            {
                pageLength: 20,
                lengthChange: false,
                searching: false,
                ordering: false,
                info: true,
                language: {
                    emptyTable: "Assets not found.",
                    paginate: {
                        first: "First",
                        previous: "<i class='fa fa-caret-left'></i>",
                        next: "<i class='fa fa-caret-right'></i>",
                        last:  "Last"
                    },
                    "lengthMenu": "_MENU_ ",
                    "info": "_START_ to _END_ of _TOTAL_",
                    "infoEmpty": "0 of 0"
                }
            });
    </script>
@endsection
