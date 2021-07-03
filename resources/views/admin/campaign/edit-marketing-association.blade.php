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
                               Edit Marketing Association
                            </h3>
                            <div class="input-field">
                                <div class="col-sm-6">
                                    <label>Name</label>
                                    <input type="text" class="form-control" id="name" value="{{ $association['name'] }}">
                                    <span class="help-block hide-me name"><small></small></span>

                                    <div class="m-t-20 col-sm-12 no-padding">
                                        <label>Marketing Association Description</label>
                                        <textarea id="content" name="content"  class="form-control" rows="5">{{ $association['description'] }}</textarea>
                                    </div>

                                    <div class="m-t-20  col-sm-12 no-padding">
                                        <label>Priority</label>
                                        <select class="form-control selectpicker" id="priority" name="priority">
                                            <option value=""></option>
                                            @for($i=1; $i<=10;$i++)
                                                <option value="{{ $i }}" {{ selectedChosenValue($association['priority'], $i) }}>{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
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
                                            @if(!empty($association['thumbnail']))
                                                <div class="attached_images_container p-l-image">
                                                    <div class="small-4 columns show-image"
                                                         data-attachment-id="logo1603070478.png">
                                                        <img data-name="0x.jpg" class="attached_image_ox"
                                                             src="{{ uploadImagePath($association['thumbnail']) }}">
                                                    </div>
                                                </div>
                                            @else
                                                <div class="attached_images_container p-l-image">
                                                    <img class="img-responsive no-image" src="{{ asset('public/images/no-image.png') }}">
                                                    <label>No Image</label>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="action-btn">
                                        <a href="{{ route('adminDashboard') }}" class="btn btn-default back-btn">Cancel</a>
                                        <button class="btn btn-primary save-action" data-target-id="{{ $association['id'] }}">Update</button>
                                    </div>
                                    <div class="alert action-alert">
                                    </div>
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

    </style>
@endsection

@section('js')
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
        $(document.body).on('click', '.save-action' ,function() {
            var id = $(this).attr("data-target-id");
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
                console.log('logo');
                console.log(logo);
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
            console.log(formData);

            formData.append('send', 'marketing-update-association');
            formData.append('id', id);
            formData.append('name', name);
            formData.append('description', description);
            formData.append('priority', priority);




            var siteUrl = $('#hfBaseUrl').val();

            if(id !== ''){

                showPreloader();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    type: "POST",
                    url: siteUrl + "/done-me",
                    contentType: false,
                    cache: false,
                    processData: false,
                    data: formData,
                    // data: {
                    //     send: 'marketing-update-association',
                    //     name: name,
                    //     priority: priority,
                    //     id: id
                    // }
                }).done(function (result) {
                    hidePreloader();
                    var json = $.parseJSON(result);
                    var statusCode = json.status_code;
                    var statusMessage = json.status_message;

                    // textAlert.show();
                    //
                    // tagLoader.hide();
                    // // contactInput.show();
                    // $(".cancel-this-action").click();

                    if(statusCode == 200)
                    {
                        swal({
                            title: "Successful!",
                            text: statusMessage,
                            type: "success"
                        });

                        // $(".name", currentParentSelector).html(name);
                        // $(".priorityName", currentParentSelector).html(priority);
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
    </script>
@endsection
