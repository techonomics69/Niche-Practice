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
                        <a href="{{ route('task.create') }}" class="btn btn-primary ladda-button" data-style="zoom-in">
                            <span class="ladda-label"><i class="fa fa-plus"></i> Add Task</span>
                        </a>
                    </div>
                </div>
                <div class="box-header with-border">
                    <div class="col-md-4 nopadding">
                        <label>Select Campaign Category</label>
                        <label class="pull-right"><a id="clearRoute" href="javascript:void(0)">Clear Campaign Category Selection</a></label>
                        <?php
                        $catTypeArray = [];
                        ?>
                        <select id="category" name="category" class="form-control group-search">
                            <option value=""></option>
                            @if(!empty($categories))
                                @foreach($categories as $objectiveRow)
                                    <?php
                                    $catType = !empty($objectiveRow['type']) ? $objectiveRow['type'] : 'Default';
                                    ?>
                                    @if(in_array($catType, $catTypeArray) === false)
                                        <?php
                                        $catTypeArray[] = $catType;
                                        ?>
                                        <optgroup label="{{ ucfirst($catType) }}">
                                            @endif
                                            <option value="{{ $objectiveRow['id'] }}" {{ selectedChosenValue($objectiveRow['id'], old('category') ) }}>{{ $objectiveRow['id'] . ' - ' . $objectiveRow['name'] }}</option>
                                            @if(in_array($catType, $catTypeArray) === false)
                                        </optgroup>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                    </div>
                    {{--                    <div class="col-md-4 pull-right text-right">--}}
                    {{--                        <div>--}}
                    {{--                            <a id="clearRoute" href="javascript:void(0)">Clear Category Selection</a>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}
                </div>
                <div class="box-body">
                    <div id="crudTable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="taskTable" class="table table-bordered table-striped display dataTable" role="grid">
                                    <thead>
                                    <tr role="row">
                                        <th>Priority</th>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Type</th>
                                        <th>Credits</th>
                                        <th>Status</th>
                                        <th style="width: 120px;">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($records))
                                        @foreach($records as $key => $record)
                                            {{--                                            {{$key}}--}}
                                            @if(!empty($_GET['category']))
                                                @if(!empty($record['category']['id']) && ($record['category']['id'] == $_GET['category']))
                                                    <tr class="">
                                                        <td>
                                                            {{ $record['impact'] }}
                                                        </td>
                                                        <td>
                                                            {{ $record['title'] }}
                                                        </td>

                                                        <td>
                                                            @if(!empty($record['category']))
                                                                {{ $record['category']['name'] }}
                                                            @endif
                                                        </td>

                                                        <td>
                                                            {{ @$record['category']['type'] }}
                                                        </td>

                                                        <td>
                                                            @if(!empty($record['credits']))
                                                                {{ $record['credits'] }}
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
                                                            <a href="{{ route('task.edit', $record['id']) }}" class="btn btn-sm btn-link"><i class="fa fa-edit"></i> Edit</a>
                                                            <a href="javascript:void(0)" class="btn btn-sm btn-link remove-me" data-target-id="{{ $record['id'] }}"><i class="fa fa-trash"></i> Delete</a>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @else
                                                <tr class="">
                                                    <td>
                                                        {{ $record['impact'] }}
                                                    </td>
                                                    <td>
                                                        {{ $record['title'] }}
                                                    </td>

                                                    <td>
                                                        @if(!empty($record['category']))
                                                            {{ $record['category']['name'] }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(!empty($record['category']['type']))
                                                            {{ $record['category']['type'] }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(!empty($record['credits']))
                                                            {{ $record['credits'] }}
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
                                                        <a href="{{ route('task.edit', $record['id']) }}" class="btn btn-sm btn-link"><i class="fa fa-edit"></i> Edit</a>
                                                        <a href="javascript:void(0)" class="btn btn-sm btn-link remove-me" data-target-id="{{ $record['id'] }}"><i class="fa fa-trash"></i> Delete</a>
                                                    </td>
                                                </tr>
                                            @endif
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

    <script src="{{ asset('public/admin/adminlte/plugins/datatables/dataTables.initiate.js?ver='.$appFileVersion) }}"></script>

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

            html +='<div class="modal-body"><div class="interface-module" style=""><div class="alert" style="display: none;"></div><div class="remove-business-modal"><div class="remove-action-note"><img src="'+baseUrl+'/public/images/delete-listing.png"> <h3 style="font-size: 22px;margin-bottom: 25px;font-weight: 400;color: #000;">Are you sure you want to remove this Task?</h3>' +
                '<p style="color: #000;font-size: 15px;">Deleting Task, this will be deleted from your account and user account even if user task has been done.</p></div></div></div></div>';
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
                    send: 'admin-task-status',
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
                    send: 'admin-task-delete',
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
    <script>
        $( document ).ready(function() {
            $('#category').on('change',function () {
                var value = $('#category').val();
                var urlValue = getPathFromUrl(window.location.href);
                window.location.href = urlValue + '?category='+ value;
            });
        });
        function getPathFromUrl(url) {
            return url.split("?")[0];
        }
        $( document ).ready(function() {
            $('#clearRoute').on('click',function () {
                var urlValue1 = getPathFromUrl(window.location.href);
                const queryString = window.location.search;
                if(queryString){
                    window.location.href = urlValue1;
                }
            });
        });
        function getUrlVars()
        {
            var vars = [], hash;
            var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
            for(var i = 0; i < hashes.length; i++)
            {
                hash = hashes[i].split('=');
                vars.push(hash[0]);
                vars[hash[0]] = hash[1];
            }
            return vars;
        }
        $( document ).ready(function() {
            var vars = getUrlVars();
            var val = vars['category'];
            if(val){
                $('#category').find('option[value="' + val + '"]').attr("selected", "selected");
            }
        });
    </script>

@endsection
