@extends('admin.layout')

@section('title', 'Category list')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title m-t-10">Reports List</h3>

                    <div id="datatable_button_stack" class="pull-right text-right">
                        <a href="{{ route('admin.addReports') }}" class="btn btn-primary ladda-button" data-style="zoom-in">
                            <span class="ladda-label"><i class="fa fa-plus"></i> Add Report</span>
                        </a>
                    </div>
                </div>
                <div class="box-body">
                    <div class="col-md-12">
                        <table id="taskTable" class="table niche-table table-bordered table-striped display dataTable" role="grid">
                            <thead>
                            <tr role="row">
                                <th>ID</th>
                                <th>Title</th>
                                <th>Content</th>
                                <th>File Name</th>
                                <th>User Linked</th>
                                <th>Status</th>
                                <th class="action" style="width: 120px;">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($records as $key => $row)
                                <tr>
                                    <td>
                                        <?php
                                        $row_id =  $row['id'];

                                        echo $row_id;
                                        ?>
                                    </td>
                                    <td class="inddustry-name name-panel">
                                        <span class="name">
                                            @if(!empty($row['title']))
                                                {{ $row['title'] }}
                                            @endif
                                        </span>
                                    </td>
                                    <td class="inddustry-name name-panel">
                                        <span class="customer">
                                            @if(!empty($row['content']))
                                                {{ $row['content'] }}
                                            @endif
                                        </span>
                                    </td>
                                    <td class="inddustry-name name-panel">
                                        <span class="customer">
                                            @if(!empty($row['file_name']))
                                                {{ $row['file_name'] }}
                                            @endif
                                        </span>
                                    </td>
                                    <td class="inddustry-name name-panel">
                                        <span class="user-email">
                                            @if(!empty($row['related_user']['email']))
                                                {{ $row['related_user']['email'] }}
                                            @endif
                                        </span>
                                    </td>
                                    <td class="status">
                                        @if($row['status'] == 1)
                                            <span class="inactive change-status" data-target-id="{{ $row['id'] }}" data-status="1">Unpublished</span>
                                        @else
                                            <span class="active change-status" data-target-id="{{ $row['id'] }}" data-status="0">Published</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="actions-container">

{{--                                            <a href="javascript:void(0)" class="btn btn-sm btn-link copy-me" style="padding: 0 !important;" data-target-id="{{ $row['id'] }}"><i class="fa fa-clone" aria-hidden="true"></i> Copy</a>--}}
                                            {{--
                                                                                        <a href="javascript:void(0)" class="btn btn-sm btn-link " style="font-size: 12px;padding: 3px 0px;" data-target-id=""><i class="fa fa-copy"></i> Copy</a>--}}
                                            <a href="{{ route('report.edit', $row['id']) }}" class="btn btn-sm btn-link edit-me1" style="font-size: 12px;padding: 3px 0px;" data-target-id="{{ $row['id'] }}"><i class="fa fa-edit"></i> Edit</a>
                                            <a href="javascript:void(0)" class="btn btn-sm btn-link remove-me" style="font-size: 12px;padding: 3px 0px;" data-target-id="{{ $row['id'] }}"><i class="fa fa-trash"></i> Delete</a>


                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('after_styles')
    <link rel="stylesheet" href="{{ asset('public/admin/adminlte/plugins/datatables/dataTables.bootstrap.css') }}">
    <style>
        .info-container input.form-control
        {
            width: 270px;
        }
        .colored-button-icon {
            color: #1D32A0;
            cursor: pointer;
            padding: 10px;
            padding-top: 7px;
            background-color: #e8ebf6;
            padding-bottom: 7px;
            border-radius: 5px;
            margin-right: 10px;
        }

        .app-delete-button {
            color: #D01A1A;
            cursor: pointer;
            padding: 12px;
            padding-top: 7px;
            background-color: #fbe7e7;
            padding-bottom: 7px;
            border-radius: 5px;
            margin-right: 2px;
        }

        .box-title
        {
            margin-bottom: 50px;
        }
        .action-btn
        {
            margin-top: 25px;
        }
        .action-alert
        {
            width: 100%;
            float: left;
            margin-top: 20px;
        }
        .action-btn .back-btn
        {
            float: left;
            margin-left: 20px;
        }
        .save-action {
            background-color: #fff !important;
            padding-right: 25px;
            padding-left: 25px;
            color: #20a0ff !important;
            border-color: #20a0ff !important;
            margin-right: 20px;

            width: 120px;
            float: left;
            margin-left: 20px;
        }
        table.dataTable.niche-table thead .action:after
        {
            display: none;
        }
    </style>
@endsection
@section('js')
    <script src="{{ asset('public/admin/adminlte/plugins/datatables/jquery.dataTables.js') }}"></script>

    <script src="{{ asset('public/admin/adminlte/plugins/datatables/dataTables.bootstrap.js') }}"></script>

    <script src="{{ asset('public/admin/adminlte/plugins/datatables/dataTables.initiate.js') }}"></script>
    <script>
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

            html +='<div class="modal-body"><div class="interface-module" style=""><div class="alert" style="display: none;"></div><div class="remove-business-modal"><div class="remove-action-note"><img src="'+baseUrl+'/public/images/delete-listing.png"> <h3 style="font-size: 22px;margin-bottom: 25px;font-weight: 400;color: #000;">Are you sure you want to remove this Report?</h3>' +
                // '<p style="color: #000;font-size: 15px;">Deleting Category will also delete all your linked tasks from admin panel and user panel.</p>' +
                '</div></div></div></div>';
            html +='<div class="modal-footer"><button type="button" class="btn btn-default close-modal" data-dismiss="modal">Cancel</button><button type="button" class="btn btn-danger deleting-processed">Delete</button></div>';

            mainModel.modal('show');
            $(".modal-header").after(html);

            return false;
        });
    </script>
    <script>
        $(document.body).on('click', '.deleting-processed', function() {
            deleteCampaign(window.currentTarget);
        });

        function deleteCampaign(currentTarget) {
            // console.log("currentTarget");
            // console.log(currentTarget);
            // return;
            var siteUrl = $('#hfBaseUrl').val();
            var report = currentTarget.attr('data-target-id');

            // console.log(template);

            showPreloader();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                type: "POST",
                url: siteUrl + "/done-me",
                data: {
                    send: 'admin-report-delete',
                    id: report,
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
    <script>
        $(document.body).on('click', '.change-status' ,function() {
            var siteUrl = $('#hfBaseUrl').val();
            var id = $(this).attr('data-target-id');
            var status = $(this).attr('data-status');
            // console.log(status);
            var currentTarget = $(this);
            var parentSel = currentTarget.parent('.status');
            if(status == 0 ){
                status = 1;
            }else {
                status = 0;
            }
            // console.log(status);

            showPreloader();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                type: "POST",
                url: siteUrl + "/done-me",
                data: {
                    send: 'admin-report-status',
                    id: id,
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

                if(status == 1)
                {
                    parentSel.html('<span class="inactive change-status" data-target-id="'+id+'" data-status="1">Unpublished</span>');
                }
                else
                {
                    parentSel.html('<span class="active change-status" data-target-id="'+id+'" data-status="0">Published</span>');
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
    </script>
@endsection
