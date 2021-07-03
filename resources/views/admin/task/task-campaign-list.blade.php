@extends('admin.layout')

@section('title', 'Category list')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title m-t-10">12-Month Task Campaign Category List</h3>

                    <div id="datatable_button_stack" class="pull-right text-right">
                        <a href="{{ route('admin.add-campaign') }}" class="btn btn-primary ladda-button" data-style="zoom-in">
                            <span class="ladda-label"><i class="fa fa-plus"></i> Add Campaign</span>
                        </a>
                    </div>
                </div>
                <div class="box-body">
                    <div class="col-md-12">
                        <table id="taskTable" class="table niche-table table-bordered table-striped display dataTable" role="grid">
                            <thead>
                            <tr role="row">
                                <th>Name</th>
{{--                                <th>Category Type</th>--}}
{{--                                <th>Category Status</th>--}}
                                <th>Month</th>
                                <th>Status</th>
                                <th class="action" style="width: 120px;">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($list as $row)
                                <tr>
                                    <td class="inddustry-name name-panel">
                                        <span class="name">{{ $row['name'] }}</span>
                                        <div>

                                            <?php
                                            $row_id =  $row['id'];
                                            ?>
{{--                                            <a href="{{ route('task.list', ['category'=>$row_id]) }}" class="btn btn-sm btn-link" style="text-transform:capitalize; padding-left: 0"> <i class="fa fa-file"></i> Task List</a>--}}
                                        </div>
                                    </td>
{{--                                    <td class="task-type type-panel">--}}
                                        <?php
//                                        $data['non-marketing-campaign'] = 'Non-Marketing Campaign';
//                                        $data['marketing-campaign'] = 'Marketing Campaign';
//                                        $typeSelection = (!empty($row['type'])) ? $row['type'] : '';
                                        ?>
{{--                                        <span class="type" data-selected-value="{{ $row['type'] }}">--}}
{{--                                            @if(!empty($typeSelection))--}}
{{--                                                {{ $data[$typeSelection] }}--}}
{{--                                            @else--}}
{{--                                            @endif--}}
{{--                                        </span>--}}
{{--                                    </td>--}}
{{--                                    <td class="paid-type paid-panel">--}}
{{--                                        <span class="paid-status" data-status="{{ $row['show_to_paid'] }}">--}}
{{--                                            @if(!empty($row['show_to_paid']))--}}
{{--                                                Paid User Only--}}
{{--                                            @else--}}
{{--                                            @endif--}}
{{--                                        </span>--}}
{{--                                    </td>--}}
                                    <td class="priority-panel">
                                        <span class="priority">{{ $row['priority'] }}</span>
                                    </td>
                                    <td class="status">
                                        {{--                                                @if($row['status'] == 1)--}}
                                        {{--                                                    <span class="active change-status" data-target-id="{{ $row['id'] }}" data-status="drafts">Active</span>--}}
                                        {{--                                          background-color      @else--}}
                                        {{--                                                    <span class="inactive change-status" data-target-id="{{ $row['id'] }}" data-status="active">Drafts</span>--}}
                                        {{--                                                @endif--}}
                                        @if($row['status'] == 0)
                                            <span class="inactive change-status" data-target-id="{{ $row['id'] }}" data-status="1">Drafts</span>
                                        @else
                                            <span class="active change-status" data-target-id="{{ $row['id'] }}" data-status="0">Active</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="actions-container">
                                            <a href="{{ route('task.edit.campaign', $row['id']) }}" class="btn btn-sm btn-link edit-me1" data-target-id="{{ $row['id'] }}"><i class="fa fa-edit"></i> Edit</a>
                                            <a href="javascript:void(0)" class="btn btn-sm btn-link remove-me" data-target-id="{{ $row['id'] }}"><i class="fa fa-trash"></i> Delete</a>
                                            <?php
                                            //                                            $row_id =  $row['id'];?>
                                            {{--                                            <a href="{{ route('task.list', ['category'=>$row_id]) }}" class="btn btn-sm btn-link not-clickable" data-target-id="{{ $row['id'] }}"> <i class="fa fa-file"></i> More Details</a>--}}

                                        </div>
                                    </td>
                                    {{--                                    <input type="hidden" id="cat{{$row['id']}}" value="{{$row['id']}}">--}}
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
        $(function () {
            $(".save-action").click(function () {
                var name = $("#name").val().trim();
                var type = $("#type").val();
                var showToPaid = 0;
                var paidStatusMessage = '';

                if ($("#show-to-paid").is(":checked") === true) {
                    showToPaid = 1;
                    paidStatusMessage = 'Paid User Only';
                }

                var selectedTypeName = $("#type option:selected").html();
                var priority = $("#priority").val();
                var errorSelector = $("span.help-block");

                $(".alert").hide();
                $(".alert").removeClass('alert-success alert-danger');
                errorSelector.addClass('hide-me');
                errorSelector.removeClass('error text-success');

                if(!name)
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
                        send: 'save-category',
                        name: name,
                        type: type,
                        priority: priority,
                        show_to_paid: showToPaid
                    }
                }).done(function (result) {
                    $("#show-to-paid").prop("checked", false);
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
                        var id = data.id;
                        $(".alert").addClass('alert-success');
                        $("#name").val("");
                        html +='<tr role="row">\n' +
                            '                                            <td class="inddustry-name name-panel">\n' +
                            '                                                <span class="name">'+name+'</span>\n' +
                            '                                            </td>\n' +
                            // '                                            <td class="task-type type-panel">\n' +
                            // '                                                <span class="type" data-selected-value="'+type+'">'+selectedTypeName+'</span>\n' +
                            // '                                            </td>\n' +
                            // '                                            <td class="paid-type paid-panel">\n' +
                            // '                                                <span class="paid-status">'+paidStatusMessage+'</span>\n' +
                            // '                                            </td>\n' +
                            '                                            <td class="priority-panel">\n' +
                            '                                                <span class="priority">'+priority+'</span>\n' +
                            '                                            </td>\n' +
                            '                                            <td class="status">\n' +
                            '<span class="active change-status" data-target-id="'+id+'" data-status="0">Active</span>\n' +
                            '                                                                                                </td>\n' +
                            '                                            <td>\n' +
                            '                                                <div class="actions-container">\n' +
                            '                                                <a href="javascript:void(0)" class="btn btn-sm btn-link edit-button edit-me" data-target-id="'+id+'"><i class="fa fa-edit"></i> Edit</a>\n' +
                            '                                                <a href="javascript:void(0)" class="btn btn-sm btn-link remove-me" data-target-id="'+id+'"><i class="fa fa-trash"></i> Delete</a>\n' +
                            '                                                </div>\n' +
                            '                                            </td>\n' +
                            '                                        </tr>';

                        $("tbody").prepend(html);
                    }
                    else
                    {
                        $(".alert").addClass('alert-danger');
                    }
                });
            });
        });

        $(document.body).on('click', '.edit-me', function() {
            var siteUrl = $('#hfBaseUrl').val();
            var contactId = $(this).attr("data-target-id");
            var currentParentSelector = $(this).parent().closest('tr');

            var categoryName = $(".name", currentParentSelector).html();
            var priority = $(".priority", currentParentSelector).html();

            $(".name, .priority, .actions-container").show();
            $(".info-container, .type-container, .paid-status-container").remove();
            $(".action-container").remove();

            var html = '';
            var inputActionContainer = '';

            html += '<div class="info-container">\n' +
                '        <input value="'+categoryName+'" type="text" class="form-control" id="category-name" placeholder="Enter name">\n' +
                '    </div>';

            $(".name", currentParentSelector).after(html);
            $(".name", currentParentSelector).hide();

            html = '<div class="type-container"><select class="form-control selectpicker type-selection" name="type">\n' +
                '                                        <option value="">Default</option>\n' +
                '                                        <option value="non-marketing-campaign">Non-Marketing Campaign</option>\n' +
                '                                        <option value="marketing-campaign">Marketing Campaign</option>\n' +
                '                                    </select></div>';

            $(".type", currentParentSelector).after(html);
            $(".type", currentParentSelector).hide();

            $(".type-selection", currentParentSelector).val($(".type", currentParentSelector).attr('data-selected-value'));

            html = '<div class="paid-status-container">\n' +
                '                                        <input type="checkbox" id="show-to-paid-mark">\n' +
                '                                        Show this category to Paid User</div>';

            $(".paid-status", currentParentSelector).after(html);
            $(".paid-status", currentParentSelector).hide();

            console.log("statt " + $(".paid-status", currentParentSelector).attr('data-status'));
            $("#show-to-paid-mark", currentParentSelector).prop("checked", parseInt($(".paid-status", currentParentSelector).attr('data-status')));

            inputActionContainer +='<div class="action-container" style="padding-top: 10px;">\n ' +
                '<div class="act-tag-loading" style="display: none;float: left;margin-top: 0px;">\n' +
                '                                    <div class="decipher-tags-tag">\n' +
                '                                        <img class="tag-loading-img" src="'+siteUrl+'/public/images/recipients_loader.gif">\n' +
                '                                    </div>\n' +
                '                                </div>' +
                '        <a class="colored-button-icon save-name" data-customer-id="'+contactId+'"><i class="fa fa-check" aria-hidden="true"></i></a>\n' +
                '    <a class="app-delete-button cancel-this-action"><i class="fa fa-close" aria-hidden="true"></i></a>\n' +
                '    </div>';

            $(".actions-container", currentParentSelector).hide();
            $(".actions-container", currentParentSelector).after(inputActionContainer);

            var i;
            var selected;

            html = '<div class="info-container">';
            // html += '<input value="'+priority+'" type="text" class="form-control" id="priority" placeholder="Enter phone number">';
            html += '<select class="form-control selectpicker" id="category-priority">';
            for(i=1; i <=10; i++)
            {
                selected = (i == priority) ? 'selected' : '';

                html += '<option '+selected+'>'+ i +'</option>';
            }
            html += '</select>';
            html += '</div>';

            $(".priority", currentParentSelector).hide();
            $(".priority", currentParentSelector).after(html);
        });

        $(document.body).on('click', '.save-name' ,function() {
            var categoryName = $("#category-name").val();
            var priority = $("#category-priority").val();
            var type = $(".type-selection").val();
            var typeHtml = $(".type-selection option:selected", currentParentSelector).html();

            console.log("typeHtml");
            console.log(typeHtml);

            var showToPaid = 0;
            var paidStatusMessage = '';

            var contactId = $(this).attr("data-customer-id");

            var currentParentSelector = $(this).parent().closest('tr');

            if ($("#show-to-paid-mark").is(":checked") === true) {
                showToPaid = 1;
            }


            // currentParentSelector.hide();

            // return false;

            if(contactId !== ''){

                // if(firstName === '')
                // {
                //     return false;
                // }

                var tagLoader = $(".info-container .tag-loading");
                var textAlert =$(".info-container .text-alert");
                var siteUrl = $('#hfBaseUrl').val();


                $(".action-container a").hide();
                $(".act-tag-loading").show();

                textAlert.hide();
                tagLoader.show();

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    type: "POST",
                    url: siteUrl + "/done-me",
                    data: {
                        send: 'update-category',
                        name: categoryName,
                        priority: priority,
                        id: contactId,
                        type: type,
                        show_to_paid: showToPaid
                    }
                }).done(function (result) {
                    var json = $.parseJSON(result);
                    var statusCode = json.status_code;
                    var statusMessage = json.status_message;
                    var data = json.data;

                    textAlert.show();
                    var html = '';

                    tagLoader.hide();
                    // contactInput.show();
                    $(".cancel-this-action").click();

                    if(statusCode == 200)
                    {
                        swal({
                            title: "Successful!",
                            text: statusMessage,
                            type: "success"
                        });

                        $(".name", currentParentSelector).html(categoryName);
                        $(".priority", currentParentSelector).html(priority);

                        $(".type", currentParentSelector).attr('data-selected-value', type);
                        $(".type", currentParentSelector).html(typeHtml);
                        $(".paid-status", currentParentSelector).attr('data-status', showToPaid);


                        // $("#contact-add").val('');
                        // textAlert.removeClass('text-danger');
                        // textAlert.addClass('text-success');
                        // textAlert.html(statusMessage);
                        //
                        // console.log(data.id);
                        // var contact = data.id;
                        //
                        // html += '<tr role="row" class="" data-customer-id="'+contact+'">\n' +
                        //     '                                <td class="text-verticle-align">\n' +
                        //     '                                    <div class="checkbox-area">\n' +
                        //     '                                        <span class="custom-checkbox" data-action="single">\n' +
                        //     '                                        <input style="display: none; outline: 0;" id="data-275640" type="checkbox">\n' +
                        //     '                                    </span>\n' +
                        //     '                                    </div>\n' +
                        //     '                                    <div class="add-r-contact-column">\n' +
                        //     '                                        <img src="https://static.parastorage.com/services/shoutout-static/1.2329.0/images/contacts/recipients-empty-contact.png">\n' +
                        //     '                                        <label></label>\n' +
                        //     '                                    </div>\n' +
                        //     '                                </td>\n' +
                        //     '\n' +
                        //     '                                <td class="text-verticle-align">\n' +
                        //     '                                    <div class="add-r-mail-column">\n' +
                        //     '                                        <h3>'+email+'</h3>\n' +
                        //     '                                    </div>\n' +
                        //     '                                </td>\n' +
                        //     '                                <td><div class="actions-container">\n' +
                        //     '   <a class="edit-button edit-contact" data-customer-id="'+contact+'"><i class="mdi mdi-pencil" aria-hidden="true"></i></a>\n' +
                        //     '   \n' +
                        //     ' </div></td>\n' +
                        //     '                            </tr>';
                        //
                        // $('.all-selection').after(html);
                        //
                        // setTimeout(function () {
                        //     textAlert.hide();
                        // }, 3000);
                    }
                    else
                    {
                        swal({
                            title: "Error!",
                            text: statusMessage,
                            type: "error"
                        });
                        // textAlert.removeClass('text-success');
                        // textAlert.addClass('text-danger');
                        // textAlert.html(statusMessage);
                    }
                });
            }
        });

        $(document.body).on('click', '.cancel-this-action' ,function() {
            $(".info-container, .type-container, .paid-status-container, .action-container").remove();
            $(".name, .type, .priority, .actions-container").show();
        });


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

            html +='<div class="modal-body"><div class="interface-module" style=""><div class="alert" style="display: none;"></div><div class="remove-business-modal"><div class="remove-action-note"><img src="'+baseUrl+'/public/images/delete-listing.png"> <h3 style="font-size: 22px;margin-bottom: 25px;font-weight: 400;color: #000;">Are you sure you want to remove this Campaign?</h3>' +
                '<p style="color: #000;font-size: 15px;">Deleting Campaign will also delete all your linked tasks from admin panel and user panel.</p></div></div></div></div>';
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
                    target: 'category',
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
                    send: 'admin-category-delete',
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

