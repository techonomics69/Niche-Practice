@extends('admin.layout')

@section('title', 'Add Niche')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-default">
                <div class="box-body">
                    <div class="col-sm-12 input-form">
                        <div class="col-sm-6">
                            <h3 class="box-title">
                                Add a Niche
                            </h3>
                            <div class="input-field">
                                <label>Niche Name</label>
                                <input type="text" class="form-control" id="niche" value="">
                                <span class="help-block hide-me"><small></small></span>

                                <label style="margin-top: 10px">Link With Industry</label>
{{--                                <input type="text" class="form-control" id="industry" value="">--}}
                                <select class="form-control" name="industry" id="industry">
                                    <option value="" selected></option>
                                    <?php
                                    $recurringIndustry = \Modules\Business\Models\Industry::orderBy('id')->get()->toArray();
//    print_r($recurringIndustry);
//    exit();
                                    foreach($recurringIndustry as $index => $weekRow) {
                                    ?>

                                    <option value="{{ $weekRow['id'] }}" {{ selectedChosenValue(old('name'), $weekRow['id']) }}>{{ $weekRow['name'] }}</option>
                                <?php
                                    }
                                    ?>
                                </select>
                                <span class="help-block hide-me"><small></small></span>

                                <div class="action-btn">
                                    <a href="{{ route('admin.niches.list') }}" class="btn btn-default back-btn">Cancel</a>
                                    <button class="btn btn-primary save-action">Save</button>
                                </div>

                                <div class="alert action-alert">

                                </div>
                            </div>
                        </div>
                        <div class="col-md-8" style="display: none;">
                            <h3 class="box-title">
                                Niche List
                            </h3>
                            <table id="taskTable" class="table niche-table table-bordered table-striped display dataTable" role="grid">
                                <thead>
                                <tr role="row">
                                    <th>Niche</th>
{{--                                    <th>Niches Count</th>--}}
                                    <th>Status</th>
                                    <th class="action" style="width: 120px;">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($industry as $row)
                                    <tr>
                                        <td class="inddustry-name">{{ $row['niche'] }}</td>
{{--                                        <td>--}}
{{--                                            @if(!empty($row['niches']))--}}
{{--                                                {!! count($row['niches']) !!}--}}
{{--                                            @else--}}
{{--                                                0--}}
{{--                                            @endif--}}
{{--                                        </td>--}}
                                        <td>Active</td>
                                        <td>
                                            {{--                                                <a href="javascript:void(0)" class="btn btn-sm btn-link"><i class="fa fa-edit"></i> Edit</a>--}}
                                            <a href="javascript:void(0)" class="btn btn-sm btn-link"><i class="fa fa-trash"></i> Delete</a>
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
    </div>
@endsection

@section('after_styles')
    <link rel="stylesheet" href="{{ asset('public/admin/adminlte/plugins/datatables/dataTables.bootstrap.css') }}">
    <style>
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
        $(function () {
            $(".save-action").click(function () {
                var nicheName = $("#niche").val().trim();
                var industryId = $("#industry").val();
                var errorSelector = $("span.help-block");

                $(".alert").hide();
                $(".alert").removeClass('alert-success alert-danger');
                errorSelector.addClass('hide-me');
                errorSelector.removeClass('error text-success');

                if(!nicheName)
                {
                    errorSelector.removeClass('hide-me');
                    errorSelector.addClass('error');
                    $("small", errorSelector).html('Required Field');
                    return false;
                }
                if(!industryId)
                {
                    errorSelector.removeClass('hide-me');
                    errorSelector.addClass('error');
                    $("small", errorSelector).html('Required Field');
                    return false;
                }

                var baseUrl = $("#hfBaseUrl").val();

                var $this = showLoaderButton(".save-action", "Saving");

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    type: "POST",
                    url: baseUrl + "/done-me",
                    data: {
                        send: 'save-niche',
                        name: nicheName,
                        id: industryId
                    }
                }).done(function (result) {
                    // parse data into json
                    var json = $.parseJSON(result);

                    // get data
                    var statusCode = json.status_code;
                    var statusMessage = json.status_message;
                    var data = json.data;

                    $(".alert").show();
                    $(".alert").html(statusMessage);

                    resetLoaderButton($this);


                    var html ='';
                    if( statusCode == 200 ) {
                        $(".alert").addClass('alert-success');
                        $("#name").val("");

                        html += '<tr role="row" class="odd">\n' +
                            '                                            <td>'+nicheName+'</td>\n' +
                            '                                            <td>Active</td>\n' +
                            '                                            <td>\n' +
                            // '                                                <a href="javascript:void(0)" class="btn btn-sm btn-link edit-button"><i class="fa fa-edit"></i> Edit</a>\n' +
                            '                                                <a href="javascript:void(0)" class="btn btn-sm btn-link remove-me"><i class="fa fa-trash"></i> Delete</a>\n' +
                            '                                            </td>\n' +
                            '                                        </tr>';

                        $("tbody").prepend(html);
                        // refresh industry panel?
                    }
                    else
                    {
                        $(".alert").addClass('alert-danger');
                    }
                    var siteUrl = $('#hfBaseUrl').val();
                    location.href = siteUrl+'/admin/niches';
                });

            });
        });
    </script>
@endsection

