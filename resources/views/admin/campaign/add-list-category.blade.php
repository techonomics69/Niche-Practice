@extends('admin.layout')

@section('title', 'Category Panel')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-default">
                <div class="box-body">
                    <div class="col-sm-12 input-form">
                        <div class="col-sm-4">
                            <h3 class="box-title">
                                Add Category
                            </h3>
                            <div class="input-field">
                                <label>Category Name</label>
                                <input type="text" class="form-control" id="name" value="">
                                <span class="help-block hide-me"><small></small></span>

                                <div class="m-t-20">
                                    <label>Priority</label>
                                    <select class="form-control selectpicker" id="priority" name="priority">
                                        <option value=""></option>
                                        @for($i=1; $i<=10;$i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="action-btn">
                                    <a href="{{ route('adminDashboard') }}" class="btn btn-default back-btn">Cancel</a>
                                    <button class="btn btn-primary save-action">Save</button>
                                </div>
                                <div class="alert action-alert">
                                </div>
                            </div>

                        </div>
                        <div class="col-md-8">
                            <h3 class="box-title">
                                Category List
                            </h3>
                            <div class="overflow-x">
                              <table id="taskTable" class="table niche-table table-bordered table-striped display dataTable" role="grid">
                                <thead>
                                <tr role="row">
                                    <th>Name</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th class="action" style="width: 120px;">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($list as $row)
                                        <tr>
                                            <td class="inddustry-name name-panel">
                                                <span class="name">{{ $row['name'] }}</span>
                                            </td>
                                            <td class="priority-panel">
                                                <span class="priority">{{ $row['priority'] }}</span>
                                            </td>
                                            <td class="status">
{{--                                                @if($row['status'] == 1)--}}
{{--                                                    <span class="active change-status" data-target-id="{{ $row['id'] }}" data-status="drafts">Active</span>--}}
{{--                                                @else--}}
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
                                                    <a href="javascript:void(0)" class="btn btn-sm btn-link edit-me" data-target-id="{{ $row['id'] }}"><i class="fa fa-edit"></i> Edit</a>
                                                    <a href="javascript:void(0)" class="btn btn-sm btn-link remove-me" data-target-id="{{ $row['id'] }}"><i class="fa fa-trash"></i> Delete</a>
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

        @media only screen and (max-width:405px){
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
    <script src="{{ asset('public/admin/adminlte/plugins/datatables/jquery.dataTables.js') }}"></script>

    <script src="{{ asset('public/admin/adminlte/plugins/datatables/dataTables.bootstrap.js') }}"></script>

    <script src="{{ asset('public/admin/adminlte/plugins/datatables/dataTables.initiate.js') }}"></script>

    <script>
        $(function () {
            $(".save-action").click(function () {
                var name = $("#name").val().trim();
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
                        send: 'save-template-category',
                        name: name,
                        priority: priority,
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
                        var id = data.id;
                        $(".alert").addClass('alert-success');
                        $("#name").val("");
                        $("#priority").val("");

                        html +='<tr role="row">\n' +
                            '                                            <td class="inddustry-name name-panel">\n' +
                            '                                                <span class="name">'+name+'</span>\n' +
                            '                                            </td>\n' +
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
            $(".info-container").remove();
            $(".action-container").remove();

            var html = '';
            var inputActionContainer = '';

            html += '<div class="info-container">\n' +
                '        <input value="'+categoryName+'" type="text" class="form-control" id="category-name" placeholder="Enter name">\n' +
                '    </div>';

            $(".name", currentParentSelector).after(html);
            $(".name", currentParentSelector).hide();

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

            var contactId = $(this).attr("data-customer-id");

            var currentParentSelector = $(this).parent().closest('tr');
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
                        send: 'template-update-category',
                        name: categoryName,
                        priority: priority,
                        id: contactId
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
            $(".info-container, .action-container").remove();
            $(".name, .priority, .actions-container").show();
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

            html +='<div class="modal-body"><div class="interface-module" style=""><div class="alert" style="display: none;"></div><div class="remove-business-modal"><div class="remove-action-note"><img src="'+baseUrl+'/public/images/delete-listing.png"> <h3 style="font-size: 22px;margin-bottom: 25px;font-weight: 400;color: #000;">Are you sure you want to remove this Category?</h3>' +
                '<p style="color: #000;font-size: 15px;">Deleting Category will unlink all your linked templates from admin panel and user panel. Your default templates will be assigned to All.</p></div></div></div></div>';
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
                    send: 'admin-cat-type-status',
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
            // console.log("currentTarget templat");
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
                    send: 'admin-template-category-delete',
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
