@extends('admin.layout')

@section('title', $pageTitle)

@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1 task-page">
            <form class="validate-me" method="POST" action="{{ $action }}" accept-charset="UTF-8" enctype="multipart/form-data">

                @if(!empty($task_id))
                    <input type="hidden" name="id" value="{{ $task_id }}">
{{--                    {{ method_field('PUT') }}--}}
                @endif

                {{ csrf_field() }}
                <?php
                    $title = 'title';
                    $creditsDescription = 'credits_description';
                    $description = 'description';
                ?>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Service</h3>
                    </div>
                    <div class="box-body row">
                        <div class="form-group">
                            <div class="col-md-12">
                                @if (session('message'))
                                    <div class="alert {{ (session('messageCode') != 200) ? 'alert-danger' : 'alert-success' }}">
                                        {{ session('message') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group col-sm-12 m-b-30">

                            <div class="col-sm-6 {{ $errors->has($title) ? ' has-error' : '' }}">
                                <label>Title</label>
                                <input type="text" id="{{$title}}" name="{{$title}}" value="{{ editFieldValueV2($records, $title) }}" class="form-control" data-required="true">
                                <span class="help-block {{ $errors->has($title) ? ' error' : '' }}">
                                    <small>{{ $errors->first($title) }}</small>
                                </span>
                            </div>


                            <div class="col-sm-6">
                                <div class="profile-info">
                                    <div class="add-praticelogo logo-image-container" id="logo-image-container">
                                        <img src="{{ asset('public/images/icons/right-arrow.png') }}">
                                        <a id="logo" href="javascript:void(0);">
                                            <label>
                                                Add Icon
                                            </label>
                                        </a>

                                        <div class="attachment_container">
                                            <input type="file" id="add_logo_image" name="add_logo_image">
                                        </div>

                                        <div class="limit_exceeded_error_msg_container hide" style="margin-top:10px; margin-bottom: 15px;padding: 10px 5px 10px 10px ">
                                            <span class="remove_limit_exceeded_error"><i class="fa fa-times" aria-hidden="true"></i></span>
                                            <span class="limit_exceeded_error_msg"></span>
                                        </div>

                                        @if(!empty($records['thumbnail']))
                                            <div class="attached_images_container p-l-image">
                                                <div class="small-4 columns show-image"
                                                     data-attachment-id="logo1603070478.png">
                                                    <img data-name="0x.jpg" class="attached_image_ox"
                                                         src="{{ uploadImagePath('public/'.$records['thumbnail']) }}">
                                                </div>
                                            </div>
                                        @else
                                            <div class="attached_images_container p-l-image">
                                                <img class="img-responsive no-image" src="{{ asset('public/images/no-image.png') }}">
                                                <label>No Icon</label>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-12 {{ $errors->has($description) ? ' has-error' : '' }}">
                            <label>Description</label>
                            <textarea id="{{$description}}" name="{{$description}}" class="form-control customize-editor">{{ $taskTitle = editFieldValueV2($records, $description) }}</textarea>
                            <span class="help-block {{ $errors->has($description) ? ' error' : '' }}">
                                <small>{{ $errors->first($description) }}</small>
                            </span>
                        </div>

                        @if(!empty($records['service_credits']))
                            @foreach($records['service_credits'] as $index => $credits)
                                <div class="form-group col-sm-12 credits-section">
                                    <div class="col-sm-3">
                                        <label>Title</label>
                                        <input type="text" class="form-control credit_title" name="credit_title[{{ $credits['id'] }}]"
                                               value="{{ $credits['title'] }}" />
                                        <span class="help-block ">
                                <small></small>
                                </span>
                                    </div>
                                    <div class="col-sm-4">
                                        <label>Credits</label>
                                        <input type="number" name="credits[{{ $credits['id'] }}]" value="{{ $credits['credits'] }}" class="form-control credits">

                                        <span class="help-block "><small></small></span>
                                    </div>

                                    @if($index != 0)
                                    <span class="close-credit"><i class="fa fa-close"></i></span>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div class="form-group col-sm-12 credits-section">
                                <div class="col-sm-3">
                                    <label>Title</label>
                                    <input type="text" class="form-control credit_title" name="credit_title[]" value="" />
                                    <span class="help-block ">
                                <small></small>
                                </span>
                                </div>
                                <div class="col-sm-4">
                                    <label>Credits</label>
                                    <input type="number" name="credits[]" value="" class="form-control credits">

                                    <span class="help-block ">
                                <small></small>
                                </span>
                                </div>
                            </div>
                        @endif

                        <div class="form-group col-sm-8 add-credit-option">
                            <button type="button" class="btn btn-xs btn-add-icon add-credit pull-right"> <i class="fa fa-plus"></i> </button>
                        </div>


                        <div class="form-group col-md-12">
                            <div class="col-md-4 nopadding">
                                <label>Priority</label>
                                <select class="form-control selectpicker" id="priority" name="priority">
                                    <option value=""></option>
                                    @for($i=1; $i<=100;$i++)
                                        <option value="{{ $i }}" {{ selectedChosenValueV2($records,'priority', $i) }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <div class="col-md-4 nopadding">
                                <label>Status</label>
                                <select class="form-control" id="sys_status" name="sys_status">
                                    <option value="1" {{ selectedChosenValueV2($records, 'sys_status', 1) }}>Active</option>
                                    <option value="0" {{ selectedChosenValueV2($records, 'sys_status', 0) }}>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="box-footer">
                        <div id="saveActions" class="form-group">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-success">
                                    <span class="fa fa-save" aria-hidden="true"></span> &nbsp;<span>Save</span>
                                </button>
                            </div>

                            <a href="{{ route('pro.list') }}" class="btn btn-default"><span class="fa fa-ban"></span> &nbspCancel</a>
                        </div>
                        <span class="help-block hide-me"><strong>Required fields must be filled.</strong></span>
                    </div><!-- /.box-footer-->
                </div><!-- /.box -->
            </form>
        </div>
    </div>
@endsection

@section('after_styles')
{{--    <link rel="stylesheet" href="{{ asset('public/css/mad-validation.css') }}" />--}}
    <link rel="stylesheet" href="{{ asset('public/plugins/summernote/summernote.css') }}" />

    <link rel="stylesheet" href="{{ asset('public/plugins/bootstrap-select/bootstrap-select.css') }}" />
    <style>

    .add-praticelogo {
        margin: 0;
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
        width: 200px;
        margin: 10px 0;
        height: 140px;
    }
    #add_logo_image {
        display: none;
    }
    .profile-info .p-l-image .no-image {
        padding: 22px 0;
    }
    .profile-info .p-l-image img {
        margin: auto;
    }
</style>
@endsection

@section('after_scripts')
    <script src="{{ asset('public/plugins/bower_components/jquery-duplicate/jquery.duplicate.js') }}"></script>

    <script src="{{ asset('public/admin/task/custom-validation.js') }}"></script>
    <script src="{{ asset('public/plugins/summernote/summernote.js') }}"></script>
    <script src="{{ asset('public/admin/task/variable-feature.js?ver='.$appFileVersion) }}"></script>

    <script src="{{ asset('public/plugins/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('public/admin/base.js') }}"></script>
    <script>
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

        $(document).on('click',".remove_image",function (e) {
            // console.log("called");
            if(typeof($(this).closest('.show-image').attr('data-attachment-id'))!='undefined'){
                // console.log("has " + $(this).closest('.form-group').attr('id'));
                var attachmentId = '';
                if($(this).closest('.form-group').attr('id') === "logo-container")
                {
                    // console.log("inside logo");
                    // console.log(window.attachedLogoDeletedArray);
                    attachmentId = $(this).closest('.show-image').attr('data-attachment-id');
                    window.attachedLogoDeletedArray.push(attachmentId);

                    // console.log("Logo inside after att " + attachmentId);
                    // console.log(window.attachedLogoDeletedArray);
                }
                else
                {
                    // console.log("inside");
                    // console.log(window.attachedDeletedArray);
                    attachmentId = $(this).closest('.show-image').attr('data-attachment-id');
                    window.attachedDeletedArray.push(attachmentId);

                    // console.log("inside after att " + attachmentId);
                    // console.log(window.attachedDeletedArray);
                }
            }

            var imageName=$(this).closest('.show-image').find('img').attr('data-name');
            window.attachedImagesArray = $.grep(window.attachedImagesArray, function(item) {
                return item.name !== imageName;
            });

            window.attachedLogoArray = $.grep(window.attachedLogoArray, function(item) {
                return item.name !== imageName;
            });

            $(this).closest('.show-image').remove();
            var images=$('.attached_images_container .show-image');
            var imagesLength=images.length;

            if(imagesLength==0){
                $('#add_video_btn').removeClass('disabled').removeAttr('disabled');
                $('span.add-video-btn-disabled-tooltip').tooltip('destroy');
            }
            else if(imagesLength>0){
                $('#add_video_btn').addClass('disabled').attr('disabled','disabled');
            }
            if(imagesLength<4){
                $('.help-block small').text('');
            }
            $('#add_image_file').val('');

            /*-----------Images Limit Validation Code -------------------*/

            $('#post_now_btn,.send_post_options button').removeClass('disabled').removeAttr('disabled');
            $('span.posts-btn-disabled-tooltip').tooltip('destroy');

            $('#add_post_modal .limit_exceeded_error_msg').text('');
            $('.limit_exceeded_error_msg_container').addClass('hide');

            var facebook_images_limit=window.facebook_images_limit;
            var twitter_images_limit=window.twitter_images_limit;
            var instagram_images_limit=window.instagram_images_limit;
            var linkedin_images_limit=window.linkedin_images_limit;

            var attachedImages=$('#add_post_modal .attached_images_container .show-image');
            var NumOfAttachedImages=attachedImages.length;

            var remainingFacebookImages=facebook_images_limit-NumOfAttachedImages;
            var remainingTwitterImages=twitter_images_limit-NumOfAttachedImages;
            var remainingInstagramImages=instagram_images_limit-NumOfAttachedImages;
            var remainingLinkedinImages=linkedin_images_limit-NumOfAttachedImages;

            var checkImagesError=false;
            (!$('.facebook-social-media-button.selected-social-media').length==0 && remainingFacebookImages<0) ? checkImagesError=true : '';
            (!$('.twitter-social-media-button.selected-social-media').length==0 && remainingTwitterImages<0) ? checkImagesError=true : '';
            (!$('.instagram-social-media-button.selected-social-media').length==0 && remainingInstagramImages<0) ? checkImagesError=true : '';
            (!$('.linkedin-social-media-button.selected-social-media').length==0 && remainingLinkedinImages<0) ? checkImagesError=true : '';

            if(checkImagesError){

                var limitsImagesArray=[],limitedImagesNetworks=[];
                var selectedNetworksImagesArr=$('.select-social-media-buttons-container button.selected-social-media');
                $(selectedNetworksImagesArr).each(function (a,b) {
                    var selectedNetwork=$(b);
                    if($(b).hasClass('facebook-social-media-button') && remainingFacebookImages<0){
                        limitsImagesArray.push(facebook_images_limit);
                        limitedImagesNetworks.push('Facebook');
                    }
                    else if($(b).hasClass('twitter-social-media-button') && remainingTwitterImages<0){
                        limitsImagesArray.push(twitter_images_limit);
                        limitedImagesNetworks.push('Twitter');
                    }
                    else if($(b).hasClass('instagram-social-media-button') && remainingInstagramImages<0){
                        limitsImagesArray.push(instagram_images_limit);
                        limitedImagesNetworks.push('Instagram');
                    }
                    else if($(b).hasClass('linkedin-social-media-button') && remainingLinkedinImages<0){
                        limitsImagesArray.push(linkedin_images_limit);
                        limitedImagesNetworks.push('Linkedin');
                    }
                });

                var minImagesLimit=arrayMin(limitsImagesArray);

                if(limitedImagesNetworks.length>1){
                    var limitedImagesNetworksFirstHalf = limitedImagesNetworks.slice(0, limitedImagesNetworks.length-1);
                    var limitedImagesNetworksFirstHalfStr=limitedImagesNetworksFirstHalf.join(", ");
                    var limitedImagesNetworksSecondHalf = limitedImagesNetworks.slice(limitedImagesNetworks.length-1, limitedImagesNetworks.length);
                    var limitedImagesNetworksStr=limitedImagesNetworksFirstHalfStr+" and "+limitedImagesNetworksSecondHalf;
                    var strMsg="Limit exceeded of images(s) for " + limitedImagesNetworksStr;
                }
                else{
                    var limitedImagesNetworksStr=limitedImagesNetworks.join(", ");

                    if(minImagesLimit==0){
                        var strMsg='We currently don\'t support publishing multimedia to ' + limitedImagesNetworksStr + '. Deselect ' + limitedImagesNetworksStr + ' if you want to publish a multimedia post to other social media pages.';
                    }
                    else{
                        var strMsg="Can’t upload more than " + minImagesLimit + " images(s) on " + limitedImagesNetworksStr ;
                    }

                }

                $('#add_post_modal .limit_exceeded_error_msg').text('').text(strMsg);
                $('.limit_exceeded_error_msg_container').removeClass('hide');


                $('#post_now_btn,.send_post_options button').addClass('disabled').attr('disabled','disabled');
                $('span.posts-btn-disabled-tooltip').tooltip('destroy');
                setTimeout(function () {
                    $("span.posts-btn-disabled-tooltip").tooltip({
                        placement : 'top',
                        title: "Post cannot be made as image(s) limit exceeded."
                    });
                },200);
            }

        });

        $(document).on('click',".remove_link",function (e) {
            $(this).parent().addClass('hide');
        });

        $(document).on('click',".remove_limit_exceeded_error",function (e) {
            $(this).parent().addClass('hide');
        });

        $(".add-credit").click(function () {
            var html = '<div class="form-group col-sm-12 credits-section">\n' +
                '                            <div class="col-sm-3">\n' +
                '                                <label>Title</label>\n' +
                '                                <input type="text" class="form-control credit_title" name="credit_title[]" value="">\n' +
                '                                <span class="help-block ">\n' +
                '                                <small></small>\n' +
                '                                </span>\n' +
                '                            </div>\n' +
                '                            <div class="col-sm-4">\n' +
                '                                <label>Credits</label>\n' +
                '                                <input type="number" name="credits[]" value="" class="form-control credits">\n' +
                '\n' +
                '                                <span class="help-block ">\n' +
                '                                <small></small>\n' +
                '                                </span>\n' +
                '                            </div>\n' +
                '<span class="close-credit"><i class="fa fa-close"></i></span>\n' +
                '                        </div>';

            $(".add-credit-option").before(html);
        });

        $(document).on('click', '.close-credit', function (e) {
            $(this).closest('.credits-section').remove();
        });
    </script>
@endsection
