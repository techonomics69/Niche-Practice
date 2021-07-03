@extends('admin.layout')

@section('title', 'Category Panel')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-default">
                <div class="box-body">
                    <div class="col-sm-12 input-form">
                        <div class="col-sm-5">
                            <h3 class="box-title">
                                Marketing Association
                            </h3>
                            <div class="input-field">
                                <div class="col-sm-6">
                                    <label>Name</label>
                                    <input type="text" class="form-control" id="name" value="">
                                    <span class="help-block hide-me name"><small></small></span>

                                    <div class="m-t-20 col-sm-12 no-padding">
                                        <label>Marketing Association Description</label>
                                        <textarea id="content" name="content"  class="form-control" rows="5"></textarea>
                                    </div>

                                    <div class="m-t-20  col-sm-12 no-padding">
                                        <label>Priority</label>
                                        <select class="form-control selectpicker" id="priority" name="priority">
                                            <option value=""></option>
                                            @for($i=1; $i<=10;$i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
{{--                                    <div class="m-t-20 col-sm-12 no-padding">--}}
{{--                                        <label>Status</label>--}}
{{--                                        <select class="form-control selectpicker" id="sys_status" name="sys_status">--}}
{{--                                            <option value="1">Active</option>--}}
{{--                                            <option value="0">Inactive</option>--}}
{{--                                        </select>--}}
{{--                                    </div>--}}
                                </div>
                                <div class="col-sm-6">
                                    <div class="profile-info">
                                        <div class="add-praticelogo logo-image-container" id="logo-image-container">
                                            <img src="{{ asset('public/images/icons/right-arrow.png') }}">
                                            <a id="logo" href="javascript:void(0);">
                                                <label>
                                                    Upload Icon
                                                </label>
                                            </a>

                                            <div class="attachment_container">
                                                <input type="file" id="add_logo_image" name="add_logo_image">
                                            </div>

                                            <div class="limit_exceeded_error_msg_container hide" style="margin-top:10px; margin-bottom: 15px;padding: 10px 5px 10px 10px ">
                                                <span class="remove_limit_exceeded_error"><i class="fa fa-times" aria-hidden="true"></i></span>
                                                <span class="limit_exceeded_error_msg"></span>
                                            </div>
                                            <div class="attached_images_container p-l-image">
                                                <img class="img-responsive no-image" src="{{ asset('public/images/no-image.png') }}">
                                                <label>No Icon</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="action-btn">
                                        <a href="{{ route('adminDashboard') }}" class="btn btn-default back-btn">Cancel</a>
                                        <button class="btn btn-primary save-action">Save</button>
                                    </div>
                                    <div class="alert action-alert">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <h3 class="box-title">
                                Marketing Association List
                            </h3>
                            <table id="taskTable" class="table niche-table table-bordered table-striped display dataTable" role="grid">
                                <thead>
                                <tr role="row">
                                    <th>Priority</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th class="action" style="width: 120px;">Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($association as $associate)
                                    <tr>
                                        <td class="priority">
                                            <span class="priorityName">{{$associate['priority']}}</span>
                                        </td>
                                        <td class="inddustry-name name-panel">
                                            <span class="name">{{$associate['name']}}</span>
                                        </td>
                                        <td class="status">
                                            {{--                                                @if($row['status'] == 1)--}}
                                            {{--                                                    <span class="active change-status" data-target-id="{{ $row['id'] }}" data-status="drafts">Active</span>--}}
                                            {{--                                                @else--}}
                                            {{--                                                    <span class="inactive change-status" data-target-id="{{ $row['id'] }}" data-status="active">Drafts</span>--}}
                                            {{--                                                @endif--}}
                                            @if($associate['status'] == 0)
                                                <span class="inactive change-status" data-target-id="{{ $associate['id'] }}" data-status="1">Drafts</span>
                                            @else
                                                <span class="active change-status" data-target-id="{{ $associate['id'] }}" data-status="0">Active</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="actions-container">
                                                <a href="{{ route('admin.campaign.association.edit', $associate['id']) }}" class="btn btn-sm btn-link edit-me" data-target-id="{{ $associate['id'] }}"><i class="fa fa-edit"></i> Edit</a>
                                                <a href="javascript:void(0)" class="btn btn-sm btn-link remove-me" data-target-id="{{ $associate['id'] }}"><i class="fa fa-trash"></i> Delete</a>
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
@endsection
@section('after_styles')
    <link rel="stylesheet" href="{{ asset('public/admin/adminlte/plugins/datatables/dataTables.bootstrap.css') }}">
    <style>
        #add_logo_image {
            display: none;
        }
        #logo label {
            cursor: pointer;
            display: inline-block;
            max-width: 100%;
            margin-bottom: 5px;
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
        .logo-image-container div.show-image img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
        .profile-info .p-l-image .no-image {
            padding: 8px 0;
        }
        .profile-info .p-l-image img {
            margin: auto;
        }
        #logo label {
            cursor: pointer;
            display: inline-block;
            max-width: 100%;
            margin-bottom: 5px;
        }
        .logo-image-container div.show-image img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .profile-info .p-l-image {
            border: 1px solid #ddd;
            text-align: center;
            width: 140px;
            margin: 10px 0;
            height: 115px;
        }
        .show-image img{
            height: 110px;
            width: 110px;
        }
        .info-container input.form-control
        {
            width: 270px;
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
    </style>
@endsection

@section('js')

    <script src="{{ asset('public/admin/adminlte/plugins/datatables/jquery.dataTables.js') }}"></script>

    <script src="{{ asset('public/admin/adminlte/plugins/datatables/dataTables.bootstrap.js') }}"></script>

    <script src="{{ asset('public/admin/adminlte/plugins/datatables/dataTables.initiate.js') }}"></script>

    <script>
        window.attachedLogoArray = [];
        $(document).on('click',"#logo",function (e) {
            $("#add_logo_image").click();
        });

        function setupReader(file,preview) {
            // console.log("file");
            // console.log(file);

            // console.log("preview");
            // console.log(preview);
            var reader  = new FileReader();

            // console.log("reader");
            // console.log(reader.result);

            reader.onloadend = function () {
                preview.src = reader.result;

            };

            // console.log("preview src");
            // console.log(preview.src);

            if (file) {
                // console.log("file");
                // console.log(file);

                reader.readAsDataURL(file);
            } else {
                preview.src = "";
            }
        }

        $(document).on('change',"#add_logo_image",function (e){
            // console.log("add_logo_image");
            var imagePicker = $("#add_logo_image");
            var attachedImages= $('.logo-image-container .attached_images_container .show-image');
            // console.log(attachedImages);

            var fileUploadStatus = false;
            var NumOfAttachedImages = attachedImages.length;

            var limitsArray=[];

            var files  = document.querySelector("#add_logo_image").files;

            // console.log("add_logo_image > NumOfAttachedImages");
            // console.log(NumOfAttachedImages);

            // console.log("add files");
            // console.log(files);


            for (var y = 0; y < files.length; y++) {
                var file    = files[y];
                var fileType=file.type;
                var fileSize=file.size;

                var validImageTypes=['image/png','image/jpeg'];
                var checkFileType=$.inArray( fileType, validImageTypes ) ;
                //var res = fileType.match(/image\.*/i);
                if(checkFileType == -1){
                    $('.logo-image-container .limit_exceeded_error_msg').text("File format is invalid. Please upload valid image formats like <jpg,png>.");
                    $('.logo-image-container .limit_exceeded_error_msg_container').removeClass('hide');

                    //$('#add_post_modal .help-block small').text('').text("File format is invalid. Please upload valid image formats like <jpg,png>.");

                    imagePicker.val('');
                    return false;
                }

                if(fileSize>10485760){
                    $('.logo-image-container .limit_exceeded_error_msg').text("File size cannot be more than 10MB.");
                    $('.logo-image-container .limit_exceeded_error_msg_container').removeClass('hide');
                    imagePicker.val('');
                    return false;
                }

            }

            $('.logo-image-container .limit_exceeded_error_msg_container').addClass('hide');
            // var allowedImages = minLimit;

            var images = attachedImages;
            var imagesLength = images.length;
            var customImgId = '';

            if(images.length == 0){
                customImgId = images.length+1;
            }
            else{
                var lastImageEl=images[images.length-1];
                var lastImageClass=$(lastImageEl).find('img').attr('class');
                var num = parseInt(lastImageClass.match(/\d+/));
                customImgId=num+1;
            }

            for (var x = 0; x < files.length; x++) {
                var file    = files[x];
                var fileType=file.type;
                var fileSize=file.size;

                var validImageTypes=['image/png','image/jpeg'];
                var checkFileType=$.inArray( fileType, validImageTypes ) ;
                //var res = fileType.match(/image\.*/i);
                if(checkFileType == -1){
                    $('.logo-image-container .limit_exceeded_error_msg').text("File format is invalid. Please upload valid image formats like <jpg,png>.");
                    $('.logo-image-container .limit_exceeded_error_msg_container').removeClass('hide');

                    //$('#add_post_modal .help-block small').text('').text('Invalid Image');

                    imagePicker.val('');
                    return false;
                }

                if(fileSize>10485760){
                    $('.logo-image-container .limit_exceeded_error_msg').text("File size cannot be more than 10MB.");
                    $('.logo-image-container .limit_exceeded_error_msg_container').removeClass('hide');
                    imagePicker.val('');
                    return false;
                }

                var newCustomImgId = customImgId+x;
                var imageTemplate='<div class="small-4 columns show-image"><img data-name="'+file.name+'" class="attached_image_'+newCustomImgId+'" src="">' +
                    '<span class="remove_image" style="display: none;">x</span> </div>';
                $('.logo-image-container .attached_images_container').html(imageTemplate);
                var preview = document.querySelector('.logo-image-container img.attached_image_'+newCustomImgId);

                // console.log("in");
                // console.log(preview);
                // return false;
                setupReader(file,preview);

                window.attachedLogoArray[0] = file;

                fileUploadStatus = true;
                // window.attachedLogoArray = file;
            }

            imagePicker.val('');

            if(fileUploadStatus === true)
            {
                // console.log("ready to logo Image save");
                // $("form.validate-image").submit();
            }
        });

        $(function () {
            $(".save-action").click(function () {
                var name = $("#name").val().trim();
                var description = $("#content").val();
                var priority = $("#priority").val();
                // var status = $("#sys_status").val();


                var errorSelector = $("span.help-block.name");
                var errorSelectorNiche = $("span.help-block.niche-select");

                $(".alert").hide();
                $(".alert").removeClass('alert-success alert-danger');
                errorSelector.addClass('hide-me');
                errorSelector.removeClass('error text-success');

                errorSelectorNiche.addClass('hide-me');
                errorSelectorNiche.removeClass('error text-success');

                if(!name)
                {
                    errorSelector.removeClass('hide-me');
                    errorSelector.addClass('error');
                    $("small", errorSelector).html('Required Field');
                    return false;
                }

                var logo = [];
                if(window.attachedLogoArray.length !=0){
                    logo = window.attachedLogoArray;
                    // formData.append('logo', logo);
                }

                var formData = new FormData();

                if(logo.length > 0) {
                    console.log("logo in");
                    $.each(logo, function (i, obj) {
                        formData.append('attach_logo[' + i + ']', obj);
                    });
                }
                console.log("logo out");

                formData.append('send', 'save-association');
                formData.append('name', name);
                formData.append('description', description);
                formData.append('priority', priority);
                // formData.append('status', status);
                // console.log(formData);
                // console.table(Object.fromEntries(formData)) // another representation in table form

                var baseUrl = $("#hfBaseUrl").val();

                var $this = showLoaderButton(".save-action", "Saving");
// return;
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    type: "POST",
                    url: baseUrl + "/done-me",
                    contentType: false,
                    cache: false,
                    processData: false,
                    data: formData,
                }).done(function (result) {
                    // parse data into json
                    var json = $.parseJSON(result);

                    // get data
                    var statusCode = json.status_code;
                    var statusMessage = json.status_message;
                    var data = json.data;
                    console.log('data');
                    console.log(data);
                    // return;
                    $(".alert").show();
                    $(".alert").html(statusMessage);

                    resetLoaderButton($this);

                    var html ='';
                    if( statusCode == 200 ) {
                        var id = data.id;
                        $(".alert").addClass('alert-success');
                        $("#name").val("");
                        $("#content").val("");
                        $("#priority").val("");



                        // showPreloader();
                        // window.location.href = baseUrl + '/admin/task/category/list';
                        {{--<td class="priority">--}}
                        {{--    <span class="priorityName">{{$associate['priority']}}</span>--}}
                        {{--</td>--}}

                        html +='<tr>' +
                            '                                            <td class="priority">\n' +
                            '                                                <span class="priorityName">'+priority+'</span>\n' +
                            '                                            </td>\n' +
                            '                                            <td class="inddustry-name name-panel">\n' +
                            '                                                <span class="name">'+name+'</span>\n' +
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

        $(document.body).on('click', '.change-status' ,function() {
            var siteUrl = $('#hfBaseUrl').val();
            var id = $(this).attr('data-target-id');
            console.lo
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
                    send: 'change-assoc-status',
                    id: id,
                    status: status
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
                    parentSel.html('<span class="inactive change-status" data-target-id="'+id+'" data-status="1">Drafts</span>');
                }
                else
                {
                    parentSel.html('<span class="active change-status" data-target-id="'+id+'" data-status="0">Active</span>');
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

            html +='<div class="modal-body"><div class="interface-module" style="">' +
                '<div class="alert" style="display: none;"></div>' +
                '<div class="remove-business-modal">' +
                    '<div class="remove-action-note">' +
                        '<img src="'+baseUrl+'/public/images/delete-listing.png">' +
                '<h3 style="font-size: 22px;margin-bottom: 25px;font-weight: 400;color: #000;">Are you sure you want to remove this Marketing Association?</h3>' +
                '<p style="color: #000;font-size: 15px;">Deleting Marketing Association will unlink all your linked Campaigns from admin panel and user panel.' +
                '</p></div></div></div></div>';
            html +='<div class="modal-footer">' +
                        '<button type="button" class="btn btn-default close-modal" data-dismiss="modal">Cancel</button>' +
                        '<button type="button" class="btn btn-danger deleting-processed">Delete</button>' +
                    '</div>';

            mainModel.modal('show');
            $(".modal-header").after(html);

            return false;
        });
        $(document.body).on('click', '.deleting-processed', function() {
            deleteAssociation(window.currentTarget);
        });

        function deleteAssociation(currentTarget) {
            // console.log("currentTarget templat");
            // console.log(currentTarget);
            var siteUrl = $('#hfBaseUrl').val();
            var id = currentTarget.attr('data-target-id');

            // console.log(template);

            showPreloader();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                type: "POST",
                url: siteUrl + "/done-me",
                data: {
                    send: 'admin-marketing-association-delete',
                    id: id,
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

        // $(document.body).on('click', '.edit-me', function() {
        //     var siteUrl = $('#hfBaseUrl').val();
        //     var id = $(this).attr("data-target-id");
        //     var currentParentSelector = $(this).parent().closest('tr');
        //
        //     var name = $(".name", currentParentSelector).html();
        //     var priority = $(".priority .priorityName", currentParentSelector).html();
        //
        //     $(".name, .priority, .actions-container").show();
        //     $(".info-container").remove();
        //     $(".action-container").remove();
        //
        //     var html = '';
        //     var inputActionContainer = '';
        //
        //     html += '<div class="info-container">\n' +
        //         '        <input value="'+name+'" type="text" class="form-control" id="association-name" placeholder="Enter name">\n' +
        //         '    </div>';
        //
        //     $(".name", currentParentSelector).after(html);
        //     $(".name", currentParentSelector).hide();
        //
        //     inputActionContainer +='<div class="action-container" style="padding-top: 10px;">\n ' +
        //         '<div class="act-tag-loading" style="display: none;float: left;margin-top: 0px;">\n' +
        //         '                                    <div class="decipher-tags-tag">\n' +
        //         '                                        <img class="tag-loading-img" src="'+siteUrl+'/public/images/recipients_loader.gif">\n' +
        //         '                                    </div>\n' +
        //         '                                </div>' +
        //         '        <a class="colored-button-icon save-name" data-target-id="'+id+'"><i class="fa fa-check" aria-hidden="true"></i></a>\n' +
        //         '    <a class="app-delete-button cancel-this-action"><i class="fa fa-close" aria-hidden="true"></i></a>\n' +
        //         '    </div>';
        //
        //     $(".actions-container", currentParentSelector).hide();
        //     $(".actions-container", currentParentSelector).after(inputActionContainer);
        //
        //     var i;
        //     var selected;
        //
        //     html = '<div class="info-container">';
        //     // html += '<input value="'+priority+'" type="text" class="form-control" id="priority" placeholder="Enter phone number">';
        //     html += '<select class="form-control selectpicker" id="association-priority">';
        //     html += '<option></option>';
        //     for(i=1; i <=10; i++)
        //     {
        //         selected = (i == priority) ? 'selected' : '';
        //
        //         html += '<option '+selected+'>'+ i +'</option>';
        //     }
        //     html += '</select>';
        //     html += '</div>';
        //
        //     $(".priority .priorityName", currentParentSelector).hide();
        //     $(".priority .priorityName", currentParentSelector).after(html);
        // });



        $(document.body).on('click', '.save-name' ,function() {
            var name = $("#association-name").val();
            var priority = $("#association-priority").val();

            var id = $(this).attr("data-target-id");

            var currentParentSelector = $(this).parent().closest('tr');

            if(id !== ''){

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
                        send: 'marketing-update-association',
                        name: name,
                        priority: priority,
                        id: id
                    }
                }).done(function (result) {
                    var json = $.parseJSON(result);
                    var statusCode = json.status_code;
                    var statusMessage = json.status_message;

                    textAlert.show();

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

                        $(".name", currentParentSelector).html(name);
                        $(".priorityName", currentParentSelector).html(priority);
                    }
                    else
                    {
                        swal({
                            title: "Error!",
                            text: statusMessage,
                            type: "error"
                        });
                    }
                });
            }
        });

        $(document.body).on('click', '.cancel-this-action' ,function() {
            $(".info-container, .action-container").remove();
            $(".name, .priority, .priorityName, .actions-container").show();
        });

    </script>
@endsection

