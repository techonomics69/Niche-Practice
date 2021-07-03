@extends('admin.layout')

@section('title', $title)


@section('content')
    @if (session('message'))
        <div class="global-error-message a-message alert {{ (session('messageCode') != 200) ? 'alert-danger' : 'alert-success' }}">
            {{ session('message') }}
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title m-t-10">
{{--                        Promotion Templates--}}
                        {{$title}}
                    </h3>
                    <div id="datatable_button_stack" class="pull-right text-right">
{{--                        <button class="btn btn-primary ladda-button import-template">--}}
{{--                            <span class="ladda-label"><i class="fa fa-upload"></i> Import Template</span>--}}
{{--                        </button>--}}
                        @if($title == 'Promotions List')
                            <a href="{{ route('admin.promotion-builder') }}" class="btn btn-primary ladda-button" data-style="zoom-in">
                                <span class="ladda-label"><i class="fa fa-plus"></i> Create Promotion</span>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="box-body">
                    <div id="crudTable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="overflow-x">
                                  <table id="taskTable" class="table table-bordered table-striped display dataTable" role="grid">
                                    <thead>
                                    <tr role="row">
                                        <th>Industry</th>
                                        <th>Niche</th>
                                        <th>Plan</th>
                                        <th>Title</th>
                                        <th>Status</th>
                                        <th style="width: 190px;">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($records))
                                        @foreach($records as $record)
                                            <tr class="">
                                                <td>
                                                    @if(!empty($record['industry']))
                                                        {{ $record['industry']['name'] }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty($record['niche']))
                                                        {{ $record['niche']['niche'] }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty($record['template_plans']))
                                                        <?php
                                                        $templatePlans = $record['template_plans'];
                                                        ?>
                                                        @foreach($templatePlans as $index => $plan)
                                                            <?php
                                                            $count = count($templatePlans);
                                                            ?>
{{--                                                             {{ $count }}--}}
{{--                                                             {{ $plan['plan'] }}--}}
                                                             {{ $plan['plan']  }}{{ ($count == $index+1) ? '' : ',' }}
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td>{{ $record['title'] }}</td>
                                                <td class="text-center status">
                                                    @if($record['status'] == 'drafts')
                                                        <span class="inactive change-status" data-target-id="{{ $record['id'] }}" data-status="active">Drafts</span>
                                                    @else
                                                        <span class="active change-status" data-target-id="{{ $record['id'] }}" data-status="drafts">Active</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($title == 'Promotions List')
                                                        <a href="javascript:void(0)" class="btn btn-sm btn-link copy-me" style="padding: 0 !important;" data-target-id="{{ $record['id'] }}"><i class="fa fa-clone" aria-hidden="true"></i> Copy</a>
                                                        <a href="{{ route('admin.promotion-builder', $record['id']) }}" class="btn btn-sm btn-link"><i class="fa fa-edit"></i> Edit</a>
                                                        <a href="javascript:void(0)" class="btn btn-sm btn-link remove-me" data-target-id="{{ $record['id'] }}"><i class="fa fa-trash"></i> Delete</a>
                                                    @else
                                                        <a href="{{ route('admin.promotion-builder', $record['id']) }}" class="btn btn-sm btn-link"><i class="fa fa-eye"></i> View</a>
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
@endsection

@section('after_styles')
    <link rel="stylesheet" href="{{ asset('public/admin/adminlte/plugins/datatables/dataTables.bootstrap.css') }}">

    <style>
        @media only screen and (max-width:500px){
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

@section('after_scripts')


    <script src="{{ asset('public/admin/adminlte/plugins/datatables/jquery.dataTables.js') }}"></script>

    <script src="{{ asset('public/admin/adminlte/plugins/datatables/dataTables.bootstrap.js') }}"></script>

    <script src="{{ asset('public/admin/adminlte/plugins/datatables/dataTables.initiate.js') }}"></script>

    <script type="text/javascript">
        $(function () {
            $(".remove-me").click(function () {
                var siteUrl = $('#hfBaseUrl').val();
                var template = $(this).attr('data-target-id');
                var currentTarget = $(this);

                showPreloader();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    type: "POST",
                    url: siteUrl + "/done-me",
                    data: {
                        send: 'admin-delete-promotion',
                        id: template,
                    },
                    // contentType: false,
                    // cache: false,
                    // processData: false,
                    // data: formData,
                }).done(function (result) {
                    var json = $.parseJSON(result);
                    var statusCode = json.status_code;
                    var statusMessage = json.status_message;
                    var data = json.data;

                    hidePreloader();

                    if(statusCode == 200)
                    {
                        // if($("tbody tr").length != 1)
                        // {
                        //     currentTarget.closest('tr').remove();
                        // }

                        // console.log("length ");
                        // console.log($("tbody tr").length);
                        swal({
                            title: "Success!",
                            text: statusMessage,
                            type: 'success'
                        }, function () {
                            if($("tbody tr").length == 1)
                            {
                                currentTarget.closest('tr').remove();
                                showPreloader();
                                // console.log("inside");
                                location.reload();
                            }
                            else {
                                currentTarget.closest('tr').remove();
                            }
                        });
                    }
                    else
                    {
                        swal({
                            title: "Error!",
                            text: statusMessage,
                            type: 'error'
                        }, function () {
                        });
                    }
                });
            });

            $(document.body).on('click', '.change-status' ,function() {
                var siteUrl = $('#hfBaseUrl').val();
                var template = $(this).attr('data-target-id');
                var status = $(this).attr('data-status');
                var currentTarget = $(this);
                var parentSel = currentTarget.parent('.status');

                // console.log("hi retu");
                // return false;

                showPreloader();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    type: "POST",
                    url: siteUrl + "/done-me",
                    data: {
                        send: 'admin-promotion-status',
                        id: template,
                        status: status,
                    },
                    // contentType: false,
                    // cache: false,
                    // processData: false,
                    // data: formData,
                }).done(function (result) {
                    var json = $.parseJSON(result);
                    var statusCode = json.status_code;
                    var statusMessage = json.status_message;
                    var data = json.data;

                    if(status == 'drafts')
                    {
                        parentSel.html('<span class="inactive change-status" data-target-id="'+template+'" data-status="active">Drafts</span>');
                    }
                    else
                    {
                        parentSel.html('<span class="active change-status" data-target-id="'+template+'" data-status="drafts">Active</span>');
                    }


                    hidePreloader();

                    if(statusCode == 200)
                    {

                        // if($("tbody tr").length != 1)
                        // {
                        //     currentTarget.closest('tr').remove();
                        // }

                        // console.log("length ");
                        // console.log($("tbody tr").length);
                        swal({
                            title: "Success!",
                            text: statusMessage,
                            type: 'success'
                        }, function () {
                        });
                    }
                    else
                    {
                        swal({
                            title: "Error!",
                            text: statusMessage,
                            type: 'error'
                        }, function () {
                        });
                    }
                });
            });

            $(".import-template").click(function () {
                var mainModel = $('#main-modal');
                $(".modal-body, .modal-footer, .validate-me", mainModel).remove();
                $(mainModel).removeClass('welcome-process');
                $(mainModel).addClass('modal-import-template');

                var html = '';

                html += '<div class="modal-body" style="padding-top: 0px !important;">\n' +
                    '                                <h3 style="color: #3c8dbc;font-weight: bold;text-align: center;" class="modal-title p-b-10">IMPORT TEMPLATE WITH JSON</h3>\n' +

                    '                                <div class="row">\n' +
                    '                                    <div class="col-md-12">\n' +
                    '                                        <div class="user-text-content">\n' +
                    '                                            <div class="p-20">\n' +
                    '                                                <textarea id="json"></textarea>\n' +
                    '                                                <span class="help-block"></span>\n' +
                    '                                            </div>\n' +
                    '                                        </div>\n' +
                    '                                    </div>\n' +

                    '                                </div>\n' +
                    '                            </div>';

                    html +='<div class="modal-footer">';
                html +='<button type="button" class="btn btn-primary update-import">Import</button>';
                    html +='<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
                    html +='</div>';

                    mainModel.modal('show');
                    $(".modal-header").after(html);
            });
        });

        $(document.body).on('click', '.update-import', function(e)
        {
            var response = $("#json").val().trim();

            var errorHandler = $("span.help-block");

            if(response === '')
            {
                errorHandler.removeClass('hide-me');
                errorHandler.addClass('error');
                errorHandler.html('Please paste your json code.');

                return false;
            }
            else if(response.length < 100)
            {
                errorHandler.removeClass('hide-me');
                errorHandler.addClass('error');
                errorHandler.html('Please paste your json code.');
                return false;
            }
            else
            {
                errorHandler.removeClass('error');
                errorHandler.addClass('hide-me');
            }

            var siteUrl = $('#hfBaseUrl').val();
            var currentTarget = $(this);

            showPreloader();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                type: "POST",
                url: siteUrl + "/done-me",
                data: {
                    send: 'admin-save-template',
                    response: response,
                    title: "Import Template",
                    subject: "Import Template",
                    type: 'import'
                },
            }).done(function (result) {
                var json = $.parseJSON(result);
                var statusCode = json.status_code;
                var statusMessage = json.status_message;
                var data = json.data;

                if(statusCode == 200)
                {
                    location.href = siteUrl+'/admin/templates/email-template/'+data.id;
                }
                else
                {
                    hidePreloader();
                    swal({
                        title: "Error!",
                        text: statusMessage,
                        type: 'error'
                    }, function () {
                    });
                }
            });
        });

        $('.copy-me').click(function () {
            var siteUrl = $('#hfBaseUrl').val();
            var promotion = $(this).attr('data-target-id');
            var currentTarget = $(this);

            showPreloader();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                type: "POST",
                url: siteUrl + "/done-me",
                data: {
                    send: 'admin-copy-promotion',
                    id: promotion,
                }
            }).done(function (result) {
                var json = $.parseJSON(result);
                var statusCode = json.status_code;
                var statusMessage = json.status_message;
                var data = json.data;
                // console.log(data);
                hidePreloader();

                if(statusCode == 200)
                {
                    swal({
                        title: "Success!",
                        text: statusMessage,
                        type: 'success'
                    }, function() {
                        window.location.reload(true);
                    });

                }
                else
                {
                    swal({
                        title: "Error!",
                        text: statusMessage,
                        type: 'error'
                    }, function () {
                    });
                }


            });
        });
        // jQuery(document).ready(function($) {
        //     var table = $("#taskTable");
        //     table.on('click', 'tbody tr', function () {
        //         var target = $(this).attr('data-task');
        //         if(target) {
        //             var baseUrl = $('#adminBaseUrl').val();
        //             window.location.href = baseUrl + '/templates/email-template/' + target;
        //         }
        //     });
        // });
    </script>


@endsection
