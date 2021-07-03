<?php
//$appModuleList = appModule();
//$abc = array_column($appModuleList, 'id');
////print_r($appModuleList);
//print_r($abc);
//exit;
?>

@extends('admin.layout')

@section('title', $title)

@section('content')
    <div class="row">
        <!-- THE ACTUAL CONTENT -->
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title m-t-10">
                        List
                    </h3>
                    <div id="datatable_button_stack" class="pull-right text-right">
                        <a href="{{ route('alert.create') }}" class="btn btn-primary ladda-button" data-style="zoom-in">
                            <span class="ladda-label"><i class="fa fa-plus"></i> Add Alert</span>
                        </a>
                    </div>
                </div>
                <div class="box-body">
                    <div id="crudTable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="taskTable" class="table table-bordered table-striped display dataTable" role="grid">
                                    <thead>
                                    <tr role="row">
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Type</th>
                                        <th>Widget</th>
                                        <th>Status</th>
                                        <th style="width: 120px;">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($records))
                                        @foreach($records as $record)
                                            <tr class="">
                                                <td>
                                                    {{ $record['id'] }}
                                                </td>
                                                <td>
                                                    {{ $record['title'] }}
                                                </td>

                                                <td>
                                                    Widget
{{--                                                    @if(!empty($record['category']))--}}
{{--                                                        {{ $record['category']['name'] }}--}}
{{--                                                    @endif--}}
                                                </td>
                                                <td>
                                                    @if(!empty($record['sys_type']))
                                                    {{ dashboardWidgets()[$record['sys_type']] }}
                                                    @endif
                                                </td>
                                                <td class="text-center status">
                                                    @if($record['sys_status'] == 0)
                                                        <span class="inactive change-status" data-target-id="{{ $record['id'] }}" data-status="1">Drafts</span>
                                                    @else
                                                        <span class="active change-status" data-target-id="{{ $record['id'] }}" data-status="0">Active</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('alert.edit', $record['id']) }}" class="btn btn-sm btn-link"><i class="fa fa-edit"></i> Edit</a>
                                                    <a href="javascript:void(0)" class="btn btn-sm btn-link remove-me" data-target-id="{{ $record['id'] }}"><i class="fa fa-trash"></i> Delete</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
@endsection

@section('after_styles')
    <link rel="stylesheet" href="{{ asset('public/admin/adminlte/plugins/datatables/dataTables.bootstrap.css') }}">
@endsection

@section('after_scripts')


    <script src="{{ asset('public/admin/adminlte/plugins/datatables/jquery.dataTables.js') }}"></script>

    <script src="{{ asset('public/admin/adminlte/plugins/datatables/dataTables.bootstrap.js') }}"></script>

    <script src="{{ asset('public/admin/adminlte/plugins/datatables/dataTables.initiate.js') }}"></script>

    <script type="text/javascript">
        var currentTarget;
        $(document.body).on('click', '.remove-me', function() {
            var target = $(this).attr('data-target-id');
            currentTarget = $(this);

            var action = $(this).attr("data-action");
            var baseUrl = $('#hfBaseUrl').val();

            var mainModel = $('#main-modal');
            $(".modal-body, .modal-footer, .validate-me", mainModel).remove();
            $(mainModel).removeClass('welcome-process');
            $(mainModel).addClass('modal-user-quit');

            var html = '';

            // console.log("currentTarget");
            // console.log(currentTarget);

            html +='<div class="modal-body"><div class="interface-module" style=""><div class="alert" style="display: none;"></div><div class="remove-business-modal"><div class="remove-action-note"><img src="'+baseUrl+'/public/images/delete-listing.png"> <h3 style="font-size: 22px;margin-bottom: 25px;font-weight: 400;color: #000;">Are you sure you want to remove this Alert?</h3>' +
                '<p style="color: #000;font-size: 15px;">Deleting Alert, this will be deleted from your account and also will removed from user panel.</p></div></div></div></div>';
            html +='<div class="modal-footer"><button type="button" class="btn btn-default close-modal" data-dismiss="modal">Cancel</button><button type="button" class="btn btn-danger deleting-processed">Delete</button></div>';

            mainModel.modal('show');
            $(".modal-header").after(html);

            return false;
        });

        $(document.body).on('click', '.change-status' ,function() {
            var siteUrl = $('#hfBaseUrl').val();
            var template = $(this).attr('data-target-id');
            var status = $(this).attr('data-status');
            var currentTarget = $(this);
            var parentSel = currentTarget.parent('.status');

            showPreloader();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                type: "POST",
                url: siteUrl + "/done-me",
                data: {
                    send: 'admin-alert-status',
                    id: template,
                    status: status,
                },
            }).done(function (result) {
                var json = $.parseJSON(result);
                var statusCode = json.status_code;
                var statusMessage = json.status_message;
                var data = json.data;

                if(status == 0)
                {
                    parentSel.html('<span class="inactive change-status" data-target-id="'+template+'" data-status="1">Drafts</span>');
                }
                else
                {
                    parentSel.html('<span class="active change-status" data-target-id="'+template+'" data-status="0">Active</span>');
                }


                hidePreloader();

                if(statusCode == 200)
                {
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

        $(document.body).on('click', '.deleting-processed', function() {
            deleteCampaign(window.currentTarget);
        });

        function deleteCampaign(currentTarget) {
            // console.log("currentTarget");
            // console.log(currentTarget);
            var siteUrl = $('#hfBaseUrl').val();
            var template = currentTarget.attr('data-target-id');

            // console.log(template);

            showPreloader();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                type: "POST",
                url: siteUrl + "/done-me",
                data: {
                    send: 'admin-alert-delete',
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
                    $(".close-modal").click();
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
        }
    </script>


@endsection
