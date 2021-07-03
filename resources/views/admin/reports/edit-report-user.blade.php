@extends('admin.layout')

@section('title', 'Edit Report User')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-default">
                <div class="box-body">
                    <div class="col-sm-12 input-form">
                        <div class="col-sm-6">
                            <h3 class="box-title">
                                Edit Report User
                            </h3>
                            <div class="input-field">
                                <label>First Name</label>
                                <input type="text" class="form-control" id="fname" value="{{ $reportUser[0]['first_name'] }}">
                                <span class="help-block hide-me"><small></small></span>

                                <div class="m-t-20">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control" id="lname" value="{{ $reportUser[0]['last_name'] }}">
                                </div>

                                <div class="m-t-20">
                                    <label>Email Address</label>
                                    <input type="email" class="form-control" id="email" value="{{ $reportUser[0]['email'] }}">
                                    <span class="help-block hide-me"><small></small></span>
                                </div>

{{--                                <div class="m-t-20">--}}
{{--                                    <label>Password</label>--}}
{{--                                    <input type="password" class="form-control" id="password" value="{{ $reportUser[0]['password'] }}">--}}
{{--                                </div>--}}

                                <div class="action-btn m-t-20">
                                    <a href="{{ route('adminDashboard') }}" class="btn btn-default back-btn">Cancel</a>
                                    <button class="btn btn-primary save-action" data-target-id="{{$reportUser[0]['id']}}">Update</button>
                                </div>
                                <div class="alert action-alert">
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6">
{{--                            <h3 class="box-title">--}}
{{--                                Report User List--}}
{{--                            </h3>--}}
{{--                            <table id="taskTable" class="table niche-table table-bordered table-striped display dataTable" role="grid">--}}
{{--                                <thead>--}}
{{--                                <tr role="row">--}}
{{--                                    <th>Name</th>--}}
{{--                                    <th>Email Address</th>--}}
{{--                                    <th>Status</th>--}}
{{--                                    <th class="action" style="width: 120px;">Action</th>--}}
{{--                                </tr>--}}
{{--                                </thead>--}}
{{--                                <tbody>--}}
{{--                                @foreach($list as $row)--}}

{{--                                    @if(!empty($row['users_ref']))--}}
{{--                                        <tr>--}}
{{--                                            <td class="inddustry-name name-panel">--}}
{{--                                                <span class="name">{{ $row['users_ref']['first_name'] . ' ' . $row['users_ref']['last_name'] }}</span>--}}
{{--                                            </td>--}}
{{--                                            <td class="priority-panel">--}}
{{--                                                <span class="priority">{{ $row['users_ref']['email'] }}</span>--}}
{{--                                            </td>--}}
{{--                                            <td class="status">--}}
{{--                                                --}}{{--                                                @if($row['status'] == 1)--}}
{{--                                                --}}{{--                                                    <span class="active change-status" data-target-id="{{ $row['id'] }}" data-status="drafts">Active</span>--}}
{{--                                                --}}{{--                                                @else--}}
{{--                                                --}}{{--                                                    <span class="inactive change-status" data-target-id="{{ $row['id'] }}" data-status="active">Drafts</span>--}}
{{--                                                --}}{{--                                                @endif--}}
{{--                                                @if( $row['users_ref']['status'] == 0)--}}
{{--                                                    <span class="inactive change-status" data-target-id="{{ $row['users_ref']['id'] }}" data-status="1">Unactive</span>--}}
{{--                                                @else--}}
{{--                                                    <span class="active change-status" data-target-id="{{ $row['users_ref']['id'] }}" data-status="0">Active</span>--}}
{{--                                                @endif--}}
{{--                                            </td>--}}
{{--                                            <td>--}}
{{--                                                <div class="actions-container">--}}
{{--                                                    <a href="{{ route( 'edit.report.user', $row['users_ref']['id'] ) }}" class="btn btn-sm btn-link edit-me" data-target-id="{{ $row['users_ref']['id'] }}"><i class="fa fa-edit"></i> Edit</a>--}}
{{--                                                    <a href="javascript:void(0)" class="btn btn-sm btn-link remove-me" data-target-id="{{ $row['users_ref']['id'] }}"><i class="fa fa-trash"></i> Delete</a>--}}
{{--                                                </div>--}}
{{--                                            </td>--}}
{{--                                        </tr>--}}
{{--                                    @endif--}}
{{--                                @endforeach--}}
{{--                                </tbody>--}}
{{--                            </table>--}}
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
    </style>
@endsection
@section('js')
    <script>
        $(function () {
            $(".save-action").click(function () {

                var firstName = $("#fname").val();

                var lastName = $("#lname").val();

                var email = $("#email").val();

                var id = $(this).attr("data-target-id");

                var errorSelector = $("span.help-block.campaign-name");

                var errorSelector = $("span.help-block");

                $(".alert").hide();
                $(".alert").removeClass('alert-success alert-danger');
                errorSelector.addClass('hide-me');
                errorSelector.removeClass('error text-success');

                if(!firstName)
                {
                    errorSelector.removeClass('hide-me');
                    errorSelector.addClass('error');
                    $("small", errorSelector).html('Required Field');
                    return false;
                }
                if(!email)
                {
                    errorSelector.removeClass('hide-me');
                    errorSelector.addClass('error');
                    $("small", errorSelector).html('Required Field');
                    return false;
                }


                var baseUrl = $("#hfBaseUrl").val();

                var $this = showLoaderButton(".save-action", "Updating");


                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    type: "POST",
                    url: baseUrl + "/done-me",
                    data: {
                        send: 'update-report-user',
                        first_name: firstName,
                        last_name: lastName,
                        email: email,
                        id: id
                    }
                }).done(function (result) {
                    // parse data into json
                    var json = $.parseJSON(result);

                    // get data
                    var statusCode = json.status_code;
                    var statusMessage = json.status_message;
                    var data = json.data;
                    resetLoaderButton($this);

                    var html ='';
                    if( statusCode == 200 ) {

                        swal({
                            title: "Successful!",
                            text: statusMessage,
                            type: "success"
                        }, function() {
                            // window.location = baseUrl+"/admin/reports";
                        });

                    }
                    else
                    {
                        swal("Error", statusMessage, "error");
                    }
                });
            });
        });
    </script>
@endsection
