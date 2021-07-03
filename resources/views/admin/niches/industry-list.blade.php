@extends('admin.layout')

@section('title', $title)

@section('content')
    <div class="row">
        <!-- THE ACTUAL CONTENT -->
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title m-t-10">
                        Industries
                    </h3>
                    <div id="datatable_button_stack" class="pull-right text-right">
                        <a href="{{ route('admin.email-builder') }}" class="btn btn-primary ladda-button" data-style="zoom-in">
                            <span class="ladda-label"><i class="fa fa-plus"></i> Create Campaign</span>
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
                                        <th>Industry</th>
                                        <th>Niche</th>
                                        <th>Plan</th>
                                        <th>Subject Line</th>
                                        <th>Status</th>
                                        <th style="width: 120px;">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($records))
                                        @foreach($records as $record)
                                            <tr class="">
                                                <td>{{ $record['industry'] }}</td>
                                                <td>{{ $record['niche'] }}</td>
                                                <td>{{ $record['plan'] }}</td>
                                                <td>{{ $record['subject'] }}</td>
                                                <td class="text-center status"><span class="active">Active</span></td>
                                                <td>
                                                    <a href="{{ route('admin.email-builder', $record['id']) }}" class="btn btn-sm btn-link"><i class="fa fa-edit"></i> Edit</a>
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
                        send: 'admin-delete-template',
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
