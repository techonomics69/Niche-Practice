$('.modal').modal({
    backdrop: 'static',
    keyboard: false,
    show: false
});

$('#scheduled_datepicker').datetimepicker({
    format: 'YYYY-MM-DD',
    inline: true,
    sideBySide: true
});

$('#scheduled_datepicker').on('dp.change', function(e){
    $('.custom_timepicker_container_date').text(e.date.format('LL'));
});

window.attachedImagesArray=[];
window.attachedVideosArray=[];
window.attachedDeletedArray=[];
window.deleteButtonElement='';
window.editPost=false;

window.facebook_images_limit=10;
window.twitter_images_limit=4;
window.instagram_images_limit=10;
window.linkedin_images_limit=0;

window.facebook_videos_limit=1;
window.twitter_videos_limit=1;
window.instagram_videos_limit=1;
window.linkedin_videos_limit=0;

function get24hTime(str){
    str = String(str).toLowerCase().replace(/\s/g, '');
    var has_am = str.indexOf('am') >= 0;
    var has_pm = str.indexOf('pm') >= 0;
    // first strip off the am/pm, leave it either hour or hour:minute
    str = str.replace('am', '').replace('pm', '');
    // if hour, convert to hour:00
    if (str.indexOf(':') < 0) str = str + ':00';
    // now it's hour:minute
    // we add am/pm back if striped out before
    if (has_am) str += ' am';
    if (has_pm) str += ' pm';
    // now its either hour:minute, or hour:minute am/pm
    // put it in a date object, it will convert to 24 hours format for us
    var d = new Date("1/1/2011 " + str);
    // make hours and minutes double digits
    var doubleDigits = function(n){
        return (parseInt(n) < 10) ? "0" + n : String(n);
    };
    return doubleDigits(d.getHours()) + ':' + doubleDigits(d.getMinutes());
}

// /([^\S]|^)(((https?\:\/\/)|(www\.))(\S+))/gi,
// /[\n\r\s](((https?\:\/\/)|(www\.)?)(\S+)\.[^\s]{2,}[\n\r\s])/ig,
function createTextLinks(text) {
    return (text || "").replace(
        /([^\S]|^)(((https?\:\/\/)|(www\.))(\S+)|([a-zA-Z0-9]+\.[^\s]{2,}))/gi,
        function(match, space, url){
            var hyperlink = url;
            // console.log(hyperlink);
            if (!hyperlink.match('^https?:\/\/')) {
                hyperlink = 'http://' + hyperlink;
            }
            return space + '<a target="_blank" href="' + hyperlink + '">' + url + '</a>';
        }
    );
}

function onImageLoadError(img){
    $(img).closest('.link_preview_image_container').hide();
}

function loadPostLinkPreview(plainText,link_preview_container_element,post_image_attached_container_element){
    var expression = /(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]+\.[^\s]{2,}|www\.[a-zA-Z0-9]+\.[^\s]{2,} |[a-zA-Z0-9]+\.[^\s]{2,})/i;
    var urlRegex = new RegExp(expression);
    var urlsArray = plainText.match(urlRegex);
    // console.log(urlsArray);

    var urlsArrayCheck = Array.isArray(urlsArray);
    if (urlsArrayCheck && urlsArray.length != 0) {
        var aHref = urlsArray[0];
        var l = aHref.length - 1;
        if (aHref.lastIndexOf('/') === l) {
            aHref = aHref.substring(0, l);
        }
        // console.log(aHref);
        var baseUrl = $('#hfBaseUrl').val();
        var element = link_preview_container_element;
        var element2 = post_image_attached_container_element;
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            type: 'POST',
            url: baseUrl + '/generateLinkPreview',
            data: {
                link: aHref
            },
            success: function (result) {
                var json = $.parseJSON(result);
                //console.log(json);

                if ('error' in json) {
                    element.addClass('hide');
                    element2.removeClass('hide');
                } else {
                    var title = json.title;
                    var description = json.description;
                    var image = json.image;

                    if (image != '') {
                        var imageDiv = '' +
                            '<div class="link_preview_image_container">' +
                            '<img class="link_preview_img" onerror="onImageLoadError(this)" src="' + image + '">' +
                            '</div>';
                    } else {
                        var imageDiv = '';
                    }

                    var newLinkURL='';
                    var checkLinkExpression = /([^\S]|^)(((https?\:\/\/)|(http?\:\/\/))(\S+))/gi;
                    var checkLinkRegex = new RegExp(checkLinkExpression);
                    var checkUrlsArray = aHref.match(checkLinkRegex);
                    newLinkURL = (checkUrlsArray==null) ? 'http://'+aHref : aHref;

                    element.removeClass('hide');
                    element2.addClass('hide');
                    element.html('' +
                        '<a style="display: flex;" target="_blank" href="'+newLinkURL+'">'+
                        imageDiv +
                        '<div class="link_preview_details_container">\n' +
                        '  <p class="link_preview_name" title="' + title + '">' + title + '</p>\n' +
                        '  <p class="link_preview_address">' + description + '</p>\n' +
                        '</div>\n' +
                        '</a>'
                    );
                }
            },
            error: function () {
                element.addClass('hide');
                element2.removeClass('hide');
            }
        });
    }
}

var typingTimer; //timer identifier
var doneTypingInterval = 500;

function generateLinkPreviewKeyUp(){
    var images=$('#add_post_modal .attached_images_container .show-image');
    var imagesLength=images.length;
    var videos=$('#add_post_modal .attached_videos_container video');
    var videosLength=videos.length;

    clearTimeout(typingTimer);
    typingTimer = setTimeout(function(){
        var plainText = $('#post_content_body').val();

        var expressionForURL=/(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]+\.[^\s]{2,}|www\.[a-zA-Z0-9]+\.[^\s]{2,}|[a-zA-Z0-9]+\.[^\s]{2,})/i;
        var urlRegex2 = new RegExp(expressionForURL);
        var urlsArray2 = plainText.match(urlRegex2);
        if(urlsArray2==null){
            $('#add_post_modal .link_preview_name').attr('title','').text('');
            $('#add_post_modal .link_preview_address').text('');
            $('#add_post_modal .link_preview_img').attr('src','');
            $('#add_post_modal .link_preview_container').addClass('hide');
        }

        var expression=/(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}[\n\r\s]|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}[\n\r\s]|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]+\.[^\s]{2,}[\n\r\s]|www\.[a-zA-Z0-9]+\.[^\s]{2,}[\n\r\s]|[a-zA-Z0-9]+\.[^\s]{2,}[\n\r\s])/i;
        var urlRegex = new RegExp(expression);
        var urlsArray = plainText.match(urlRegex);
        var urlsArrayCheck=Array.isArray(urlsArray);
        if(urlsArrayCheck){
            var aHref = urlsArray[0];
            var l = aHref.length - 1;
            if (aHref.lastIndexOf('/') === l) {
                aHref = aHref.substring(0, l);
            }

            window.lastaHref=$.trim(window.lastaHref);
            aHref=$.trim(aHref);

            window.lastaHref != aHref ? window.allowGeneratePreview = true : window.allowGeneratePreview = false;

            var baseUrl = $('#hfBaseUrl').val();
            window.lastaHref = aHref;

            if (window.allowGeneratePreview == true && imagesLength == 0 && videosLength == 0) {
                window.allowGeneratePreview = false;

                $('#add_post_modal .link_preview_image_container, #add_post_modal .link_preview_details_container, #add_post_modal .remove_link').addClass('hide');
                $('#add_post_modal .link_preview_container, #add_post_modal .link_preview_container .loader').removeClass('hide');

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    type: 'POST',
                    url: baseUrl + '/generateLinkPreview',
                    data: {
                        link: aHref
                    },
                    success: function (result) {
                        $('#add_post_modal .link_preview_container .loader').addClass('hide');

                        var json = $.parseJSON(result);
                        // console.log(json);

                        if ('error' in json) {
                            $('#add_post_modal .link_preview_name').text('');
                            $('#add_post_modal .link_preview_address').text('');
                            $('#add_post_modal .link_preview_img').attr('src', '');
                            $('#add_post_modal .link_preview_container').addClass('hide');
                        } else {
                            var title = json.title;
                            var description = json.description;
                            var image = json.image;
                            $('#add_post_modal .link_preview_name').text(title);
                            $('#add_post_modal .link_preview_address').text(description);

                            if(image!=''){
                                $('#add_post_modal .link_preview_img').attr('src', image);
                                $('#add_post_modal .link_preview_image_container').removeClass('hide');
                            }
                            else{
                                $('#add_post_modal .link_preview_img').attr('src', '');
                                $('#add_post_modal .link_preview_image_container').addClass('hide');
                            }

                            $('#add_post_modal .link_preview_container, #add_post_modal .link_preview_details_container, #add_post_modal .remove_link').removeClass('hide');
                        }
                    },
                    error: function () {
                        $('#add_post_modal .link_preview_name').text('');
                        $('#add_post_modal .link_preview_address').text('');
                        $('#add_post_modal .link_preview_img').attr('src', '');
                        $('#add_post_modal .link_preview_container .loader').addClass('hide');
                        $('#add_post_modal .link_preview_container').addClass('hide');
                    }
                });
            }
        }
    }, doneTypingInterval);
}

function generateLinkPreviewPaste(){
    var images=$('#add_post_modal .attached_images_container .show-image');
    var imagesLength=images.length;
    var videos=$('#add_post_modal .attached_videos_container video');
    var videosLength=videos.length;

    setTimeout(function(){
        var plainText = $('#post_content_body').val();

        var expressionForURL=/(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]+\.[^\s]{2,}|www\.[a-zA-Z0-9]+\.[^\s]{2,}|[a-zA-Z0-9]+\.[^\s]{2,})/i;
        var urlRegex2 = new RegExp(expressionForURL);
        var urlsArray2 = plainText.match(urlRegex2);
        if(urlsArray2==null){
            $('#add_post_modal .link_preview_name').attr('title','').text('');
            $('#add_post_modal .link_preview_address').text('');
            $('#add_post_modal .link_preview_img').attr('src','');
            $('#add_post_modal .link_preview_container').addClass('hide');
        }

        var expression=/(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]+\.[^\s]{2,}|www\.[a-zA-Z0-9]+\.[^\s]{2,}|[a-zA-Z0-9]+\.[^\s]{2,})/i;
        var urlRegex = new RegExp(expression);
        var urlsArray = plainText.match(urlRegex);
        var urlsArrayCheck=Array.isArray(urlsArray);
        if(urlsArrayCheck){
            var aHref = urlsArray[0];
            var l = aHref.length - 1;
            if (aHref.lastIndexOf('/') === l) {
                aHref = aHref.substring(0, l);
            }

            window.lastaHref=$.trim(window.lastaHref);
            aHref=$.trim(aHref);

            window.lastaHref != aHref ? window.allowGeneratePreview = true : window.allowGeneratePreview = false;

            var baseUrl = $('#hfBaseUrl').val();
            window.lastaHref = aHref;

            if (window.allowGeneratePreview == true && imagesLength == 0 && videosLength == 0) {
                window.allowGeneratePreview = false;

                $('#add_post_modal .link_preview_image_container, #add_post_modal .link_preview_details_container, #add_post_modal .remove_link').addClass('hide');
                $('#add_post_modal .link_preview_container, #add_post_modal .link_preview_container .loader').removeClass('hide');

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    type: 'POST',
                    url: baseUrl + '/generateLinkPreview',
                    data: {
                        link: aHref
                    },
                    success: function (result) {
                        $('#add_post_modal .link_preview_container .loader').addClass('hide');

                        var json = $.parseJSON(result);
                        // console.log(json);

                        if ('error' in json) {
                            $('#add_post_modal .link_preview_name').text('');
                            $('#add_post_modal .link_preview_address').text('');
                            $('#add_post_modal .link_preview_img').attr('src', '');
                            $('#add_post_modal .link_preview_container').addClass('hide');
                        } else {
                            var title = json.title;
                            var description = json.description;
                            var image = json.image;
                            $('#add_post_modal .link_preview_name').text(title);
                            $('#add_post_modal .link_preview_address').text(description);

                            if(image!=''){
                                $('#add_post_modal .link_preview_img').attr('src', image);
                                $('#add_post_modal .link_preview_image_container').removeClass('hide');
                            }
                            else{
                                $('#add_post_modal .link_preview_img').attr('src', '');
                                $('#add_post_modal .link_preview_image_container').addClass('hide');
                            }

                            $('#add_post_modal .link_preview_container, #add_post_modal .link_preview_details_container, #add_post_modal .remove_link').removeClass('hide');
                        }
                    },
                    error: function () {
                        $('#add_post_modal .link_preview_name').text('');
                        $('#add_post_modal .link_preview_address').text('');
                        $('#add_post_modal .link_preview_img').attr('src', '');
                        $('#add_post_modal .link_preview_container .loader').addClass('hide');
                        $('#add_post_modal .link_preview_container').addClass('hide');
                    }
                });
            }
        }
    }, 200);
}

$(document).on('click',"#showPagesModal",function (e) {
    $('#connect_website_modal').modal('show');
});

$(document).on('click',"#add_schedule_post",function (e) {
    $("#scheduled_post_modal").modal('show');
});

$(document).on('click',".discard_post",function (e) {
    $("#discard_post_modal").modal('show');
});

$('.pages-container').slimScroll({
    height: '500px',
    alwaysVisible: true,
    opacity: 1,
    color: '#C4C4C4',
    size: '6px',
    borderRadius : '5px'
});

$(document).on('click',".page_container",function (e) {
    $('.page_container').removeClass('selected_page');
    $(this).addClass('selected_page');
});

$(document).on('click',".add_posts",function (e) {
// console.log("add posts click");
    var yesterdayDate = new Date();
    yesterdayDate.setDate(yesterdayDate.getDate());

    $('#scheduled_datepicker').data("DateTimePicker").destroy();
    $('#scheduled_datepicker').datetimepicker({
        format: 'YYYY-MM-DD',
        minDate: yesterdayDate,
        inline: true,
        sideBySide: true
    });

    window.allowGeneratePreview=true;
    window.lastaHref='';
    window.editPost=false;
    window.getMessagePost='';

    window.attachedImagesArray=[];
    window.attachedVideosArray=[];
    window.attachedDeletedArray=[];

    $('#add_post_modal .help-block small, #add_post_modal .limit_exceeded_error_msg').text('');
    $('.limit_exceeded_error_msg_container').addClass('hide');

    $('#add_post_modal .modal-title').remove();
    $('#add_post_modal .modal-header').append('<h4 class="modal-title">Add New Post</h4>');

    $('.select-social-media-buttons-container button').removeClass('selected-social-media').removeClass('hide');
    $('.select-social-media-buttons-container button:eq(0)').addClass('selected-social-media');

    //$('#post_content_body').next().find('.note-editable').html('');
    $('#post_content_body').val('');
    // $('#post_content_body').next().find('.note-placeholder').css({
    //     'display': 'block'
    // });

    $('.attachment_container, .send_post_options button').removeClass('hide');

    $('.attached_images_container').empty();
    $('.attached_videos_container').empty();
    $('#add_image_file').val('');
    $('#add_video_file').val('');

    $('#add_post_modal .link_preview_name').attr('title','').text('');
    $('#add_post_modal .link_preview_address').text('');
    $('#add_post_modal .link_preview_img').attr('src','');
    $('#add_post_modal .link_preview_container').addClass('hide');

    $('#add_post_modal .link_preview_image_container, #add_post_modal .link_preview_details_container, #add_post_modal .remove_link').removeClass('hide');
    $('#add_post_modal .link_preview_container .loader').addClass('hide');

    $('.post_date_container').addClass('hide');
    $('.post_date_desc').text('').attr('data-datetime','');

    $('#custom_timepicker_hour_selector').val('01');
    $('#custom_timepicker_minutes_selector').val('00');
    $('.custom_timepicker_interval').removeClass('active ');
    $('.custom_timepicker_interval:eq(0)').addClass('active ');

    $('#add_image_btn, #add_video_btn, #post_now_btn, .send_post_options button').removeClass('disabled').removeAttr('disabled');
    $('#post_now_btn').removeClass('update_facebook_post').addClass('post_btn');

    $('span.add-video-btn-disabled-tooltip').tooltip('destroy');
    $('span.add-image-btn-disabled-tooltip').tooltip('destroy');
    $('span.posts-btn-disabled-tooltip').tooltip('destroy');

    $(".facebook_limit").text('3500');
    $(".twitter_limit").text('280');
    $(".instagram_limit").text('2678');
    $(".linkedin_limit").text('2600');

    window.facebook_limit = $.trim($(".facebook_limit").text());
    window.twitter_limit = $.trim($(".twitter_limit").text());
    window.instagram_limit = $.trim($(".instagram_limit").text());
    window.linkedin_limit = $.trim($(".linkedin_limit").text());

    $('.posts_char_count').addClass('hide');
    $('.posts_char_count span') .removeClass('posts_char_count_exceed');

    $('.facebook-social-media-button.selected-social-media').length==0 ?  $('.facebook_posts_char_count').addClass('hide') : $('.facebook_posts_char_count').removeClass('hide');
    $('.twitter-social-media-button.selected-social-media').length==0 ?  $('.twitter_posts_char_count').addClass('hide') : $('.twitter_posts_char_count').removeClass('hide');
    $('.instagram-social-media-button.selected-social-media').length==0 ?  $('.instagram_posts_char_count').addClass('hide') : $('.instagram_posts_char_count').removeClass('hide');
    $('.linkedin-social-media-button.selected-social-media').length==0 ?  $('.linkedin_posts_char_count').addClass('hide') : $('.linkedin_posts_char_count').removeClass('hide');

    /*
    var minImagesLimit='',minVideosLimit='';

    var facebook_images_limit=window.facebook_images_limit;
    var twitter_images_limit=window.twitter_images_limit;
    var instagram_images_limit=window.instagram_images_limit;
    var linkedin_images_limit=window.linkedin_images_limit;

    var facebook_videos_limit=window.facebook_videos_limit;
    var twitter_videos_limit=window.twitter_videos_limit;
    var instagram_videos_limit=window.instagram_videos_limit;
    var linkedin_videos_limit=window.linkedin_videos_limit;

    if($('.facebook-social-media-button.selected-social-media').length==0){
        minImagesLimit = facebook_images_limit;
        minVideosLimit = facebook_videos_limit;
    }

    if($('.twitter-social-media-button.selected-social-media').length==0){
        minImagesLimit = facebook_images_limit;
        minVideosLimit = facebook_videos_limit;
    }

    if($('.instagram-social-media-button.selected-social-media').length==0){
        minImagesLimit = facebook_images_limit;
        minVideosLimit = facebook_videos_limit;
    }

    if($('.linkedin-social-media-button.selected-social-media').length==0){
        minImagesLimit = facebook_images_limit;
        minVideosLimit = facebook_videos_limit;
    }

    setTimeout(function () {
        $("span.add-image-btn-disabled-tooltip").tooltip({
            placement : 'top',
            title: "You can only upload "+minImagesLimit+" image(s)."
        });
        $("span.add-video-btn-disabled-tooltip").tooltip({
            placement : 'top',
            title: "You can only upload "+minVideosLimit+" video."
        });
    },200);

    */

    $('.send_post_options li').removeClass('selected_post_option');
    $('#post_now_btn').text('Post Now').attr('rel','post_now');
    $('#post_now_btn').removeAttr('data-post-id');

    $('#add_post_modal').modal('show');
});

function addSocialMediaPost(formData,postStatus){
    var baseUrl = $('#hfBaseUrl').val();
    var url= '';

    console.log("post status " + postStatus);

    if( postStatus == 'promotions')
    {
        url = baseUrl + "/share-this-promotion";
    }
    else if( postStatus =='update_facebook_post')
    {
        url = baseUrl + "/updateFacebookPost";
    }
    else
    {
        url = baseUrl + "/addSocialMediaPost";
    }

    showPreloader();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },
        type: "POST",
        contentType: false,
        cache: false,
        processData: false,
        data: formData,
        url:  url,
        success: function (response, status) {
            // console.log(response);
            if(response==''){
                swal({
                    title: "",
                    text: "OOPs! Something went wrong...",
                    type: 'error',
                    allowOutsideClick: false,
                    html: true,
                    showCancelButton: false,
                    confirmButtonColor: '#8CD4F5 ',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'OK',
                    cancelButtonText: "Cancel",
                    closeOnConfirm: true,
                    closeOnCancel: true
                });
                hidePreloader();
                return false;
            }
            var statusCode = response._metadata.outcomeCode;
            var statusMessage = response._metadata.outcome;
            var message = response._metadata.message;
            var errors = response.errors;
            var records = response.records;

            if(statusCode==200){
                if(postStatus=='update_facebook_post'){
                    postStatus='published';
                }

                // console.log("postStatus " + postStatus);
                localStorage.removeItem("activeTab");
                window.localStorage.setItem("activeTab", postStatus);

                $('#add_post_modal').modal('hide');
                $('#confirm_update_post_modal').modal('hide');

                swal({
                    title: "",
                    text: message,
                    type: 'success',
                    allowOutsideClick: false,
                    html: true,
                    showCancelButton: false,
                    confirmButtonColor: '#8CD4F5',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'OK',
                    cancelButtonText: "Cancel",
                    closeOnConfirm: true,
                    closeOnCancel: true
                },function(){

                    if(postStatus === 'promotions')
                    {
                        return false;
                    }

                    if($('#contentResearch').length==1 && postStatus!='draft'){
                        showPreloader();
                        location.href = baseUrl+'/social-posts';
                        return false;
                    }

                    if($('#contentResearch').length==1 && postStatus=='draft'){
                        showPreloader();
                        location.href = baseUrl+'/drafts';
                        return false;
                    }

                    if( ($('#draftsTab').length==1 && window.editPost == false && postStatus=='draft') ||
                        ($('#draftsTab').length==1 && window.editPost == true && postStatus=='draft') ||
                        ($('#draftsTab').length!=1 && window.editPost == false && postStatus!='draft') ||
                        ($('#draftsTab').length!=1 && window.editPost == true && postStatus!='draft') ||
                        ($('#draftsTab').length!=1 &&  window.editPost == true && postStatus=='draft'))
                    {
                        showPreloader();
                        window.location.reload();
                    }

                    if( ($('#draftsTab').length==1 && window.editPost == false && postStatus!='draft') ||   // Add New Draft Post on Drafts Screen
                        ($('#draftsTab').length==1 && window.editPost == true && postStatus!='draft'))  // Edit Draft Post on Drafts Screen
                    {
                        location.href = baseUrl+'/social-posts';
                    }

                    if($('#draftsTab').length!=1 &&  window.editPost == false && postStatus=='draft'){ // Add New Draft Post on Posts Screen
                        swal.close();
                    }
                });
            }
            else{
                if(errors.length!=0) {
                    $.each(errors, function (index, value) {
                        toastr.error(value.message);
                    })
                }
                else{
                    swal({
                        title: "",
                        text: message,
                        type: 'error',
                        allowOutsideClick: false,
                        html: true,
                        showCancelButton: false,
                        confirmButtonColor: '#8CD4F5 ',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'OK',
                        cancelButtonText: "Cancel",
                        closeOnConfirm: true,
                        closeOnCancel: true
                    });
                }
            }
            hidePreloader();
        },
        error: function (data, status) {
            swal({
                title: "",
                text: "OOPs! Something went wrong...",
                type: 'error',
                allowOutsideClick: false,
                html: true,
                showCancelButton: false,
                confirmButtonColor: '#8CD4F5',
                cancelButtonColor: '#d33',
                confirmButtonText: 'OK',
                cancelButtonText: "Cancel",
                closeOnConfirm: true,
                closeOnCancel: true
            });
            hidePreloader();
        }
    })
}

function checkUpdatePostButtonStatus(){
    var post_content_body = $.trim($("#post_content_body").val());
    if(window.getMessagePost==post_content_body){
        if($('#post_now_btn').attr('rel')=='update_facebook_post'){
            $('.update_facebook_post').addClass('disabled').attr('disabled','disabled');
            $('span.posts-btn-disabled-tooltip').tooltip('destroy');
            setTimeout(function () {
                $("span.posts-btn-disabled-tooltip").tooltip({
                    placement : 'top',
                    title: "There are no changes to update."
                });
            },200);
        }
    }
    else{
        if($('#post_now_btn').attr('rel')=='update_facebook_post'){
            setTimeout(function () {
                $('span.posts-btn-disabled-tooltip').tooltip('destroy');
            },200);
            $('.update_facebook_post').removeClass('disabled').removeAttr('disabled');
        }
    }
}

function getPostDetail(post_id, getDetailType){
    var baseUrl = $('#hfBaseUrl').val();
    var url= (typeof(getDetailType)!='undefined') ? baseUrl + "/getFacebookPostDetail" : baseUrl + "/getPostDetail";

    showPreloader();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },
        type: "GET",
        url:  url,
        data: {
            post_id: post_id
        },
        success: function (response, status) {
            // console.log(response);
            if(response==''){
                swal({
                    title: "",
                    text: "OOPs! Something went wrong...",
                    type: 'error',
                    allowOutsideClick: false,
                    html: true,
                    showCancelButton: false,
                    confirmButtonColor: '#8CD4F5 ',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'OK',
                    cancelButtonText: "Cancel",
                    closeOnConfirm: true,
                    closeOnCancel: true
                });
                hidePreloader();
                return false;
            }
            var statusCode = response._metadata.outcomeCode;
            var statusMessage = response._metadata.outcome;
            var message = response._metadata.message;
            var errors = response.errors;
            var records = response.records;

            if(statusCode==200){
                $('#post_now_btn').attr('data-post-id',records.id);

                if(getDetailType=='facebook'){
                    $('#post_content_body').val(records.message);
                    generateLinkPreviewPaste();

                    $('.facebook-social-media-button, .facebook_posts_char_count').removeClass('hide');
                    $('.facebook-social-media-button').addClass('selected-social-media');

                    $('.twitter-social-media-button, .twitter_posts_char_count').addClass('hide');
                    $('.twitter-social-media-button').removeClass('selected-social-media');

                    $('.instagram-social-media-button, .instagram_posts_char_count').addClass('hide');
                    $('.instagram-social-media-button').removeClass('selected-social-media');

                    $('.linkedin-social-media-button, .linkedin_posts_char_count').addClass('hide');
                    $('.linkedin-social-media-button').removeClass('selected-social-media');

                    $('#post_now_btn').text('Update Post').attr('rel','update_facebook_post');
                    $('#post_now_btn').removeClass('post_btn').addClass('update_facebook_post');
                    $('#update_facebook_post').attr('data-post-id', records.id);

                    $('.post_date_container').addClass('hide');
                    $('.post_date_desc').text('').attr('data-datetime','');

                    $('.posts_char_count_container').css({
                        'display': 'block',
                        'height': '37px'
                    });
                    $('.attachment_container, .send_post_options button').addClass('hide');

                    $('.attached_images_container').empty();
                    $('.attached_videos_container').empty();

                    var plainText = $('#post_content_body').val();

                    plainText=$.trim(plainText);
                    var postContentLength=plainText.length;

                    var remainingFacebookCharCount=window.facebook_limit-postContentLength;
                    var remainingTwitterCharCount=window.twitter_limit-postContentLength;
                    var remainingInstagramCharCount=window.instagram_limit-postContentLength;
                    var remainingLinkedinCharCount=window.linkedin_limit-postContentLength;

                    $('.facebook_limit').text(remainingFacebookCharCount);
                    $('.twitter_limit').text(remainingTwitterCharCount);
                    $('.instagram_limit').text(remainingInstagramCharCount);
                    $('.linkedin_limit').text(remainingLinkedinCharCount);

                    window.getMessagePost=records.message;
                    checkUpdatePostButtonStatus();
                }
                else{

                    $('#post_now_btn').removeClass('update_facebook_post').addClass('post_btn');

                    var post_master_social_media=records.post_master_social_media;
                    var post_master_social_media_arr=[];
                    $.each( post_master_social_media, function( i, value ) {
                        post_master_social_media_arr.push(value.social_media_type.toLowerCase());
                    });

                    var checkFacebook=$.inArray( "facebook", post_master_social_media_arr );
                    if(checkFacebook==-1){
                        $('.facebook_posts_char_count').addClass('hide');
                        $('.facebook-social-media-button').removeClass('selected-social-media');
                        $('.facebook-social-media-button').removeClass('hide');
                    }
                    else{
                        $('.facebook-social-media-button, .facebook_posts_char_count').removeClass('hide');
                        $('.facebook-social-media-button').addClass('selected-social-media');
                    }

                    var checkTwitter=$.inArray( "twitter", post_master_social_media_arr );
                    if(checkTwitter==-1){
                        $('.twitter_posts_char_count').addClass('hide');
                        $('.twitter-social-media-button').removeClass('selected-social-media');
                        $('.twitter-social-media-button').removeClass('hide');
                    }
                    else{
                        $('.twitter-social-media-button, .twitter_posts_char_count').removeClass('hide');
                        $('.twitter-social-media-button').addClass('selected-social-media');
                    }

                    var checkInstagram=$.inArray( "instagram", post_master_social_media_arr );
                    if(checkInstagram==-1){
                        $('.instagram_posts_char_count').addClass('hide');
                        $('.instagram-social-media-button').removeClass('selected-social-media');
                        $('.instagram-social-media-button').removeClass('hide');
                    }
                    else{
                        $('.instagram-social-media-button, .instagram_posts_char_count').removeClass('hide');
                        $('.instagram-social-media-button').addClass('selected-social-media');
                    }

                    var checkLinkedin=$.inArray( "linkedin", post_master_social_media_arr );
                    if(checkLinkedin==-1){
                        $('.linkedin_posts_char_count').addClass('hide');
                        $('.linkedin-social-media-button').removeClass('selected-social-media');
                        $('.linkedin-social-media-button').removeClass('hide');
                    }
                    else{
                        $('.linkedin-social-media-button, .linkedin_posts_char_count').removeClass('hide');
                        $('.linkedin-social-media-button').addClass('selected-social-media');
                    }

                    if(records.status.toLowerCase()=='published'){
                        $('#post_now_btn').text('Update').attr('rel','update_post');

                        $('.post_date_container').addClass('hide');
                        $('.post_date_desc').text('').attr('data-datetime','');

                        $('.posts_char_count_container').css({
                            'display': 'block',
                            'height': '37px'
                        });
                        $('.attachment_container, .send_post_options button').addClass('hide');
                    }
                    else if(records.status.toLowerCase()=='draft'){

                        $('.attachment_container').removeClass('hide');

                        //$('.facebook-social-media-button, .twitter-social-media-button, .instagram-social-media-button, .linkedin-social-media-button').removeClass('hide');

                        $('#post_now_btn').text('Post Now').attr('rel','post_now');
                        $('.post_date_container').addClass('hide');
                        $('.post_date_desc').text('').attr('data-datetime','');
                    }
                    else if(records.status.toLowerCase()=='schedule'){

                        $('.attachment_container').removeClass('hide');

                        //$('.facebook-social-media-button, .twitter-social-media-button, .instagram-social-media-button, .linkedin-social-media-button').removeClass('hide');

                        $('#post_now_btn').text('Schedule').attr('rel','schedule_post');
                        $('.post_date_container').removeClass('hide');
                        //$('.post_date_desc').text(records.schedule).attr('data-datetime',records.schedule);

                        if(typeof(records.schedule)!='undefined'){
                            var schedule_date_arr = records.schedule.split(' ');
                            var scheduleDate=schedule_date_arr[0];
                            var scheduleTime=schedule_date_arr[1];

                            $('.custom_timepicker_interval').removeClass('active ');

                            var schedule_time_arr = scheduleTime.split(':');
                            var scheduleHour=schedule_time_arr[0];
                            var scheduleMin=schedule_time_arr[1];

                            if(scheduleHour>12){
                                scheduleHour=scheduleHour-12;
                                scheduleHour= scheduleHour < 10 ? "0" + scheduleHour : scheduleHour;

                                $('.custom_timepicker_interval:eq(1)').addClass('active ');
                                var custom_timepicker_interval_edit='PM';
                            }
                            else{
                                $('.custom_timepicker_interval:eq(0)').addClass('active ');
                                var custom_timepicker_interval_edit='AM';
                            }

                            $('#custom_timepicker_hour_selector').val(scheduleHour);
                            $('#custom_timepicker_minutes_selector').val(scheduleMin);

                            var formated_schedule_post_date_edit =moment(records.schedule).format('LL');
                            var post_on_date_edit = formated_schedule_post_date_edit+' '+scheduleHour+':'+scheduleMin+' '+custom_timepicker_interval_edit+' (EST)';
                            $('.post_date_desc').text(post_on_date_edit).attr('data-datetime',records.schedule);

                            $('#scheduled_datepicker').data("DateTimePicker").date(records.schedule)
                        }

                    }

                    $('#post_content_body').val(records.message);
                    generateLinkPreviewPaste();
                    //$('#post_content_body').next().find('.note-editable').html(records.message);
                    //$('.note-placeholder').css('display','none');
                    // $('#post_content_body').next().find('.note-placeholder').css({
                    //     'display': 'none'
                    // });

                    // var contents = $('#post_content_body').summernote('code');
                    // var plainText = $("<p>" + contents+ "</p>").text();


                    var plainText = $('#post_content_body').val();

                    plainText=$.trim(plainText);
                    var postContentLength=plainText.length;

                    var remainingFacebookCharCount=window.facebook_limit-postContentLength;
                    var remainingTwitterCharCount=window.twitter_limit-postContentLength;
                    var remainingInstagramCharCount=window.instagram_limit-postContentLength;
                    var remainingLinkedinCharCount=window.linkedin_limit-postContentLength;

                    $('.facebook_limit').text(remainingFacebookCharCount);
                    $('.twitter_limit').text(remainingTwitterCharCount);
                    $('.instagram_limit').text(remainingInstagramCharCount);
                    $('.linkedin_limit').text(remainingLinkedinCharCount);

                    if(records.status.toLowerCase()!='published'){
                        if(records.attachment.length!=0){
                            var checkAttachmentType= (records.attachment[0].type=='image') ? 'image' : 'video';
                            if(checkAttachmentType=='image'){
                                $.each( records.attachment, function( i, value ) {
                                    var media_url=value.media_url;
                                    var customImgId=i;
                                    var imageTemplate='<div class="small-4 columns show-image" data-attachment-id="'+value.media_url+'"><img data-name="" class="attached_image_'+customImgId+'" src=""><span class="remove_image">x</span> </div>';
                                    $('#add_post_modal .attached_images_container').append(imageTemplate);
                                    var preview = document.querySelector('img.attached_image_'+customImgId);
                                    preview.src=media_url;
                                });

                                $('#add_video_btn').addClass('disabled').attr('disabled','disabled');
                                $('span.add-video-btn-disabled-tooltip').tooltip('destroy');
                                setTimeout(function () {
                                    $("span.add-video-btn-disabled-tooltip").tooltip({
                                        placement : 'top',
                                        title: "You cannot upload videos and images in one post."
                                    });
                                },200);
                            }
                            else{
                                $.each( records.attachment, function( i, value ) {
                                    var media_url=value.media_url;
                                    var customVideoId=i;
                                    var videoTemplate='<div class="video_container" data-name="" data-attachment-id="'+value.media_url+'"><video width="400" controls>\n' +
                                        '                  <source src="" class="attached_video_'+customVideoId+'">\n' +
                                        '                       Your browser does not support HTML5 video.\n' +
                                        '               </video>' +
                                        '               <span class="remove_video">x</span>' +
                                        '</div>';
                                    $('#add_post_modal .attached_videos_container').append(videoTemplate);

                                    var $source = $('.attached_video_'+customVideoId);
                                    $source[0].src = media_url;
                                    $source.parent()[0].load();
                                });

                                $('#add_image_btn').addClass('disabled').attr('disabled','disabled');
                                $('span.add-image-btn-disabled-tooltip').tooltip('destroy');
                                setTimeout(function () {
                                    $("span.add-image-btn-disabled-tooltip").tooltip({
                                        placement : 'top',
                                        title: "You cannot upload videos and images in one post."
                                    });
                                },200);
                            }
                        }
                        else{
                            $('.attached_images_container').empty();
                            $('.attached_videos_container').empty();
                        }
                    }
                    else{
                        $('.attached_images_container').empty();
                        $('.attached_videos_container').empty();
                    }

                }

                $('#add_post_modal').modal('show');
            }
            else{
                if(errors.length!=0) {
                    $.each(errors, function (index, value) {
                        toastr.error(value.message);
                    })
                }
                else{
                    swal({
                        title: "",
                        text: message,
                        type: 'error',
                        allowOutsideClick: false,
                        html: true,
                        showCancelButton: false,
                        confirmButtonColor: '#8CD4F5 ',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'OK',
                        cancelButtonText: "Cancel",
                        closeOnConfirm: true,
                        closeOnCancel: true
                    });
                }
            }
            hidePreloader();
        },
        error: function (data, status) {
            swal({
                title: "",
                text: "OOPs! Something went wrong...",
                type: 'error',
                allowOutsideClick: false,
                html: true,
                showCancelButton: false,
                confirmButtonColor: '#8CD4F5 ',
                cancelButtonColor: '#d33',
                confirmButtonText: 'OK',
                cancelButtonText: "Cancel",
                closeOnConfirm: true,
                closeOnCancel: true
            });
            hidePreloader();
        }
    })
}

function deletePost(post_id, element, getDetailType){
    var baseUrl = $('#hfBaseUrl').val();
    var url= (typeof(getDetailType)!='undefined') ? baseUrl + "/deleteFacebookPost" : baseUrl + "/deletePost";

    showPreloader();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },
        type: "GET",
        data: {
            post_id: post_id
        },
        url: url,
        success: function (response, status) {
            // console.log(response);
            if(response==''){
                swal({
                    title: "",
                    text: "OOPs! Something went wrong...",
                    type: 'error',
                    allowOutsideClick: false,
                    html: true,
                    showCancelButton: false,
                    confirmButtonColor: '#8CD4F5 ',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'OK',
                    cancelButtonText: "Cancel",
                    closeOnConfirm: true,
                    closeOnCancel: true
                });
                hidePreloader();
                return false;
            }
            var statusCode = response._metadata.outcomeCode;
            var statusMessage = response._metadata.outcome;
            var message = response._metadata.message;
            var errors = response.errors;
            var records = response.records;

            if(statusCode == 200){

                var activeTabId = $('.nav-tabs li.active').attr('id');
                var activeTab = '';

                if(activeTabId === 'ScheduledViewTab'){
                    activeTab = 'schedule';
                }
                else if(activeTabId === 'PublishedViewTab'){
                    activeTab = 'published';
                }

                localStorage.removeItem("activeTab");
                window.localStorage.setItem("activeTab", activeTab);

                $('#delete_post_modal').modal('hide');

                swal({
                    title: "",
                    text: message,
                    type: 'success',
                    allowOutsideClick: false,
                    html: true,
                    showCancelButton: false,
                    confirmButtonColor: '#8CD4F5',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'OK',
                    cancelButtonText: "Cancel",
                    closeOnConfirm: true,
                    closeOnCancel: true
                },function(){
                    if($(element).closest('.post_item').next().hasClass('post_item')==false
                        &&
                        $(element).closest('.post_item').prev().hasClass('post_item')==false)
                    {
                        if($(element).closest('.post_item').prev().hasClass('post_time_header')){
                            $(element).closest('.post_item').prev().remove();
                        }
                    }

                    if($('#draftsTab').length != 0){
                        if($('#draftsTab .post_item').length == 1){
                            showPreloader();
                            window.location.reload();
                        }
                        else{
                            $(element).closest('.post_item').remove();
                        }
                    }

                    if(activeTab == 'schedule'){
                        if($('#ScheduledTab .post_item').length==1){
                            showPreloader();
                            window.location.reload();
                        }
                        else{
                            $(element).closest('.post_item').remove();
                        }
                    }


                    // console.log("activeTab " + activeTab);

                    if(activeTab === 'published') {

                        if($('#PublishedFacebookTab').hasClass('active')) {
                            if($('#PublishedFacebookTab .post_item').length == 1){
                                showPreloader();
                                window.location.reload();
                            }
                            else{
                                // console.log("ese");
                                $(element).closest('.post_item').remove();
                            }
                        }

                        if($('#PublishedTwitterTab').hasClass('active')){
                            if($('#PublishedTwitterTab .post_item').length==1){
                                showPreloader();
                                window.location.reload();
                            }
                            else{
                                $(element).closest('.post_item').remove();
                            }
                        }

                        if($('#PublishedInstagramTab').hasClass('active')){
                            if($('#PublishedInstagramTab .post_item').length==1){
                                showPreloader();
                                window.location.reload();
                            }
                            else{
                                $(element).closest('.post_item').remove();
                            }
                        }

                        if($('#PublishedLinkedInTab').hasClass('active')){
                            if($('#PublishedLinkedInTab .post_item').length==1){
                                showPreloader();
                                window.location.reload();
                            }
                            else{
                                $(element).closest('.post_item').remove();
                            }
                        }
                    }
                    window.deleteButtonElement='';
                });
            }
            else{
                if(errors.length != 0) {
                    $.each(errors, function (index, value) {
                        toastr.error(value.message);
                    })
                }
                else{
                    swal({
                        title: "",
                        text: message,
                        type: 'error',
                        allowOutsideClick: false,
                        html: true,
                        showCancelButton: false,
                        confirmButtonColor: '#8CD4F5 ',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'OK',
                        cancelButtonText: "Cancel",
                        closeOnConfirm: true,
                        closeOnCancel: true
                    });
                }

                $('#delete_post_modal').modal('hide');
            }
            hidePreloader();
        },
        error: function (data, status) {
            swal({
                title: "",
                text: "OOPs! Something went wrong...",
                type: 'error',
                allowOutsideClick: false,
                html: true,
                showCancelButton: false,
                confirmButtonColor: '#8CD4F5 ',
                cancelButtonColor: '#d33',
                confirmButtonText: 'OK',
                cancelButtonText: "Cancel",
                closeOnConfirm: true,
                closeOnCancel: true
            });
            hidePreloader();
        }
    })
}

$(document).on('click',".post_btn",function (e) {
    $('#add_post_modal .help-block small').text('');

    var currentPage = ($("#currentPage").length > 0) ? $("#currentPage").val() : '';

    $('#add_post_modal .limit_exceeded_error_msg').text('');
    $('.limit_exceeded_error_msg_container').addClass('hide');

    $('#post_now_btn,.send_post_options button').removeClass('disabled').removeAttr('disabled');
    $('span.posts-btn-disabled-tooltip').tooltip('destroy');

    var selectedNetworkTypesArr=[];
    var selectedNetworksArr=$('.select-social-media-buttons-container button.selected-social-media');

    $(selectedNetworksArr).each(function (a,b) {
        var selectedNetwork=$(b);
        var selectedNetworkType=$(b).attr('data-type');
        selectedNetworkTypesArr.push(selectedNetworkType);
    });

    if(selectedNetworkTypesArr.length == 0){
        $('#add_post_modal .limit_exceeded_error_msg').text('').text('Please select atleast one social media to make post.');
        $('.limit_exceeded_error_msg_container').removeClass('hide');

        //$('#add_post_modal .help-block small').text('Please select atleast one social media to make post.');
        return false;
    }

    var types=selectedNetworkTypesArr;

    var x,type='',obj={},details=[];
    for(x in types){
        type=types[x];
        details.push(type);
    }

    //var message = $('#post_content_body').summernote('code');
    var message = $('#post_content_body').val();
    message=$.trim(message);

    //var contents = $('#post_content_body').summernote('code');
    //var plainText = $("<p>" + contents+ "</p>").text();

    var plainText = $('#post_content_body').val();
    plainText=$.trim(plainText);

    var attachedImages = $('#add_post_modal .attached_images_container .show-image');
    var NumOfAttachedImages = attachedImages.length;

    var attachedVideos = $('#add_post_modal .attached_videos_container video');
    var NumOfAttachedVideos = attachedVideos.length;

    var checkEmptyTextError=false;
    checkEmptyTextError= (plainText.length==0 && NumOfAttachedImages==0 && NumOfAttachedVideos==0) ? checkEmptyTextError=true : checkEmptyTextError=false;
    if(checkEmptyTextError){
        $('#add_post_modal .limit_exceeded_error_msg').text('').text('Please  enter   text');
        $('.limit_exceeded_error_msg_container').removeClass('hide');

        //$('#add_post_modal .help-block small').text('Please enter the text to make post.');
        return false;
    }


    var files=[];
    if(window.attachedImagesArray.length!=0){
        files=window.attachedImagesArray;
    }
    else if(window.attachedVideosArray.length!=0){
        files=window.attachedVideosArray;
    }

    var formData = new FormData();
    $.each(files, function(i, obj) {
        formData.append('attach_file['+i+']' , obj);
    });

    formData.append('message', plainText);

    $.each(details, function(i, obj) {
        formData.append('details['+i+']' , obj);
    });


    var deleted_files=[];
    if(window.attachedDeletedArray.length!=0){
        deleted_files=window.attachedDeletedArray;
    }

    $.each(deleted_files, function(i, obj) {
        formData.append('deleted_files['+i+']' , obj);
    });

    var postSelectedOption=$(this).attr('rel'); //Post Now, Scheduled, Draft

    var status='';
    if(postSelectedOption=='post_now'){
        status='published';
    }
    else if(postSelectedOption=='schedule_post'){
        status='schedule';
        var dateTime=$('.post_date_desc').attr('data-dateTime');
        formData.append('schedule_date', dateTime);
    }
    else if(postSelectedOption=='post_draft'){
        status='draft';
    }
    else if(postSelectedOption=='update_facebook_post'){
        status='update_facebook_post';
    }


    formData.append('status', status);

    if(typeof($('#post_now_btn').attr('data-post-id'))!='undefined'){
        formData.append('post_id', $('#post_now_btn').attr('data-post-id'));
    }

    var check=validateAddPostModal();
    if(check==false){
        return false;
    }
    else{
        // console.log("addd");
        // return false;

        if(currentPage === 'promotions')
        {
            // formData.append('status', 'share-this-promotion');

            var blob = dataURItoBlob(window.templateImage);

            formData.append("attach_file[0]", blob);
            formData.append('status', 'published');
            formData.append('postType', 'promotions');

            formData.append('blob', true);

            status = currentPage;
        }

        addSocialMediaPost(formData,status);
    }
});

$(document).on('click',".custom_timepicker_interval",function (e) {
    $('.custom_timepicker_interval').removeClass('active');
    $(this).hasClass('active')? $(this).removeClass('active') : $(this).addClass('active');
});

$(document).on('click',".update_facebook_post",function (e) {
    $('#confirm_update_post_modal').modal('show');
});

$(document).on('click',"#update_facebook_post",function (e) {
    $('#add_post_modal .help-block small').text('');
    $('#add_post_modal .limit_exceeded_error_msg').text('');
    $('.limit_exceeded_error_msg_container').addClass('hide');

    var dataPostId=$(this).attr('data-post-id');

    var plainText = $('#post_content_body').val();
    plainText=$.trim(plainText);
    if(plainText.length==0){
        $('#add_post_modal .limit_exceeded_error_msg').text('').text('Please enter the text to make post.');
        $('.limit_exceeded_error_msg_container').removeClass('hide');
        return false;
    }
    var formData = new FormData();
    formData.append('message', plainText);
    formData.append('post_id', dataPostId);

    addSocialMediaPost(formData,'update_facebook_post');
});

$(document).on('click',".post_edit_btn",function (e) {

    var post_id=$(this).attr('data-post-id');

    var getDetailType=$(this).attr('data-type');

    // $('#scheduled_datepicker').data("DateTimePicker").destroy();
    // $('#scheduled_datepicker').datetimepicker({
    //     format: 'YYYY-MM-DD',
    //     inline: true,
    //     sideBySide: true
    // });

    window.allowGeneratePreview=true;
    window.lastaHref='';
    window.editPost=true;
    window.getMessagePost='';

    window.attachedImagesArray=[];
    window.attachedVideosArray=[];
    window.attachedDeletedArray=[];

    $('#add_post_modal .modal-title').remove();
    $('#add_post_modal .modal-header').append('<h4 class="modal-title">Edit Post</h4>');

    $('#add_post_modal .help-block small, #add_post_modal .limit_exceeded_error_msg').text('');
    $('.limit_exceeded_error_msg_container').addClass('hide');

    //$('#post_content_body').next().find('.note-editable').html('');

    $('#post_content_body').val('');

    $('.attachment_container, .send_post_options button').removeClass('hide');

    $('.attached_images_container').empty();
    $('.attached_videos_container').empty();
    $('#add_image_file').val('');
    $('#add_video_file').val('');

    $('#add_post_modal .link_preview_name').attr('title','').text('');
    $('#add_post_modal .link_preview_address').text('');
    $('#add_post_modal .link_preview_img').attr('src','');
    $('#add_post_modal .link_preview_container').addClass('hide');

    $('#add_post_modal .link_preview_image_container, #add_post_modal .link_preview_details_container, #add_post_modal .remove_link').removeClass('hide');
    $('#add_post_modal .link_preview_container .loader').addClass('hide');

    $('.post_date_container').addClass('hide');
    $('.post_date_desc').text('').attr('data-datetime','');

    $('#add_image_btn, #add_video_btn, #post_now_btn, .send_post_options button').removeClass('disabled').removeAttr('disabled');
    $('#post_now_btn').removeClass('update_facebook_post').addClass('post_btn');
    $('#post_now_btn').removeAttr('data-post-id');

    $('span.add-video-btn-disabled-tooltip').tooltip('destroy');
    $('span.add-image-btn-disabled-tooltip').tooltip('destroy');
    $('span.posts-btn-disabled-tooltip').tooltip('destroy');

    $(".facebook_limit").text('3500');
    $(".twitter_limit").text('280');
    $(".instagram_limit").text('2678');
    $(".linkedin_limit").text('2600');

    window.facebook_limit = $.trim($(".facebook_limit").text());
    window.twitter_limit = $.trim($(".twitter_limit").text());
    window.instagram_limit = $.trim($(".instagram_limit").text());
    window.linkedin_limit = $.trim($(".linkedin_limit").text());

    $('.posts_char_count').addClass('hide');
    $('.posts_char_count span') .removeClass('posts_char_count_exceed');

    $('.send_post_options li').removeClass('selected_post_option');

    getPostDetail(post_id,getDetailType);
});

$(document.body).on('click', '.post_delete_btn', function (e) {
    // console.log("click");
    window.deleteButtonElement=$(this);
    var post_id = $(this).attr('data-post-id');
    var getDetailType = $(this).attr('data-type');
    $('#delete_post_btn').attr('data-post-id', post_id);
    $('#delete_post_btn').attr('data-type', getDetailType);
    $('#delete_post_modal').modal('show');
});

$(document).on('click',"#delete_post_btn",function (e) {
    var post_id = $(this).attr('data-post-id');
    var getDetailType = $(this).attr('data-type');
    deletePost(post_id, window.deleteButtonElement, getDetailType);
});

$('#delete_post_modal').on('hidden.bs.modal', function () {
    $('#delete_post_btn').removeAttr('data-post-id');
});

$(document).on('click',".select-social-media-button",function (e) {
    if($(this).hasClass('selected-social-media')){
        $(this).removeClass('selected-social-media');
    }
    else{
        $(this).addClass('selected-social-media');
    }
    //$('.select-social-media-button').removeClass('selected-social-media');
});

$(document).on('click',"#add_image_btn",function (e) {
    document.getElementById("add_image_file").click();
    //$("span.add-image-btn-disabled-tooltip").tooltip('hide');
});

function setupReader(file,preview) {
    var reader  = new FileReader();
    reader.onloadend = function () {
        preview.src = reader.result;
    };

    if (file) {
        reader.readAsDataURL(file);
    } else {
        preview.src = "";
    }
}

$(document).on('change',"#add_image_file",function (e){
    $('#add_post_modal .help-block small').text('');

    //$("span.add-image-btn-disabled-tooltip").tooltip('hide');

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

    var limitsArray=[];
    var selectedNetworksArr=$('.select-social-media-buttons-container button.selected-social-media');
    $(selectedNetworksArr).each(function (a,b) {
        var selectedNetwork=$(b);
        if($(b).hasClass('facebook-social-media-button')){
            limitsArray.push(facebook_images_limit);
        }
        else if($(b).hasClass('twitter-social-media-button')){
            limitsArray.push(twitter_images_limit);
        }
        else if($(b).hasClass('instagram-social-media-button')){
            limitsArray.push(instagram_images_limit);
        }
        else if($(b).hasClass('linkedin-social-media-button')){
            limitsArray.push(linkedin_images_limit);
        }
    });

    var minLimit=arrayMin(limitsArray);

    var limitedNetworks=[];
    var selectedNetworksArr=$('.select-social-media-buttons-container button.selected-social-media');
    $(selectedNetworksArr).each(function (a,b) {
        var selectedNetwork=$(b);
        if($(b).hasClass('facebook-social-media-button') && remainingFacebookImages<=minLimit){
            limitedNetworks.push('Facebook');
        }
        else if($(b).hasClass('twitter-social-media-button') && remainingTwitterImages<=minLimit){
            limitedNetworks.push('Twitter');
        }
        else if($(b).hasClass('instagram-social-media-button') && remainingInstagramImages<=minLimit){
            limitedNetworks.push('Instagram');
        }
        else if($(b).hasClass('linkedin-social-media-button') && remainingLinkedinImages<=minLimit){
            limitedNetworks.push('Linkedin');
        }
    });

    var files    = document.querySelector('#add_image_file').files;
    for (var y = 0; y < files.length; y++) {
        var file    = files[y];
        var fileType=file.type;
        var fileSize=file.size;

        var validImageTypes=['image/png','image/jpeg'];
        var checkFileType=$.inArray( fileType, validImageTypes ) ;
        //var res = fileType.match(/image\.*/i);
        if(checkFileType==-1){
            $('#add_post_modal .limit_exceeded_error_msg').text('').text("File format is invalid. Please upload valid image formats like <jpg,png>.");
            $('.limit_exceeded_error_msg_container').removeClass('hide');

            //$('#add_post_modal .help-block small').text('').text("File format is invalid. Please upload valid image formats like <jpg,png>.");

            $('#add_image_file').val('');
            return false;
        }

        if(fileSize>10485760){
            $('#add_post_modal .limit_exceeded_error_msg').text('').text("File size cannot be more than 10MB.");
            $('.limit_exceeded_error_msg_container').removeClass('hide');
            $('#add_image_file').val('');
            return false;
        }

    }

    var allowedImages=minLimit;

    var images=$('#add_post_modal .attached_images_container .show-image');
    var imagesLength=images.length;
    if(imagesLength>=allowedImages){

        if (limitedNetworks.length > 1) {
            var limitedNetworksFirstHalf = limitedNetworks.slice(0, limitedNetworks.length - 1);
            var limitedNetworksFirstHalfStr = limitedNetworksFirstHalf.join(", ");
            var limitedNetworksSecondHalf = limitedNetworks.slice(limitedNetworks.length - 1, limitedNetworks.length);
            var limitedNetworksStr = limitedNetworksFirstHalfStr + " and " + limitedNetworksSecondHalf;
        }
        else {
            var limitedNetworksStr = limitedNetworks.join(", ");
        }

        if(minLimit==0){
            $('#add_post_modal .limit_exceeded_error_msg').text('').text('We currently don\'t support publishing multimedia to ' + limitedNetworksStr + '. Deselect ' + limitedNetworksStr + ' if you want to publish a multimedia post to other social media pages.');
        }
        else{
            $('#add_post_modal .limit_exceeded_error_msg').text('').text('Can’t upload more than ' + minLimit + ' image(s) on ' + limitedNetworksStr + '.');
        }


        $('.limit_exceeded_error_msg_container').removeClass('hide');

        //$('#add_post_modal .help-block small').text('').text('Maximum '+minLimit+' images are allowed to attach.');

        $('#add_image_file').val('');
        return false;
    }
    if(images.length==0){
        var customImgId=images.length+1;
    }
    else{
        var lastImageEl=images[images.length-1];
        var lastImageClass=$(lastImageEl).find('img').attr('class');
        var num = parseInt(lastImageClass.match(/\d+/));
        var customImgId=num+1;
    }

    if(imagesLength+files.length>allowedImages){

        var limitedNetworks=[];
        var selectedNetworksArr=$('.select-social-media-buttons-container button.selected-social-media');
        $(selectedNetworksArr).each(function (a,b) {
            var selectedNetwork=$(b);
            if($(b).hasClass('facebook-social-media-button') && remainingFacebookImages<=minLimit){
                limitedNetworks.push('Facebook');
            }
            else if($(b).hasClass('twitter-social-media-button') && remainingTwitterImages<=minLimit){
                limitedNetworks.push('Twitter');
            }
            else if($(b).hasClass('instagram-social-media-button') && remainingInstagramImages<=minLimit){
                limitedNetworks.push('Instagram');
            }
            else if($(b).hasClass('linkedin-social-media-button') && remainingLinkedinImages<=minLimit){
                limitedNetworks.push('Linkedin');
            }
        });

        if (limitedNetworks.length > 1) {
            var limitedNetworksFirstHalf = limitedNetworks.slice(0, limitedNetworks.length - 1);
            var limitedNetworksFirstHalfStr = limitedNetworksFirstHalf.join(", ");
            var limitedNetworksSecondHalf = limitedNetworks.slice(limitedNetworks.length - 1, limitedNetworks.length);
            var limitedNetworksStr = limitedNetworksFirstHalfStr + " and " + limitedNetworksSecondHalf;
        }
        else {
            var limitedNetworksStr = limitedNetworks.join(", ");
        }

        if(minLimit==0){
            $('#add_post_modal .limit_exceeded_error_msg').text('').text('We currently don\'t support publishing multimedia to ' + limitedNetworksStr + '. Deselect ' + limitedNetworksStr + ' if you want to publish a multimedia post to other social media pages.');
        }
        else{
            $('#add_post_modal .limit_exceeded_error_msg').text('').text('Can’t upload more than ' + minLimit + ' image(s) on ' + limitedNetworksStr + '.');
        }

        $('.limit_exceeded_error_msg_container').removeClass('hide');

        //$('#add_post_modal .help-block small').text('').text('Maximum '+minLimit+' images are allowed to attach. Please select upto '+minLimit+' images.');

        $('#add_image_file').val('');
        return false;
    }

    for (var x = 0; x < files.length; x++) {
        var file    = files[x];
        var fileType=file.type;
        var fileSize=file.size;

        var validImageTypes=['image/png','image/jpeg'];
        var checkFileType=$.inArray( fileType, validImageTypes ) ;
        //var res = fileType.match(/image\.*/i);
        if(checkFileType==-1){
            $('#add_post_modal .limit_exceeded_error_msg').text('').text("File format is invalid. Please upload valid image formats like <jpg,png>.");
            $('.limit_exceeded_error_msg_container').removeClass('hide');

            //$('#add_post_modal .help-block small').text('').text('Invalid Image');

            $('#add_image_file').val('');
            return false;
        }

        if(fileSize>10485760){
            $('#add_post_modal .limit_exceeded_error_msg').text('').text("File size cannot be more than 10MB.");
            $('.limit_exceeded_error_msg_container').removeClass('hide');
            $('#add_image_file').val('');
            return false;
        }

        var newCustomImgId=customImgId+x;
        var imageTemplate='<div class="small-4 columns show-image"><img data-name="'+file.name+'" class="attached_image_'+newCustomImgId+'" src=""><span class="remove_image">x</span> </div>';
        $('#add_post_modal .attached_images_container').append(imageTemplate);
        var preview = document.querySelector('img.attached_image_'+newCustomImgId);
        setupReader(file,preview);

        window.attachedImagesArray.push(file);
    }
    $('#add_image_file').val('');

    if(!$('#add_post_modal .link_preview_container').hasClass('hide')){
        $('#add_post_modal .link_preview_container').addClass('hide')
    }

    $('#add_video_btn').addClass('disabled').attr('disabled','disabled');
    $('span.add-video-btn-disabled-tooltip').tooltip('destroy');
    setTimeout(function () {
        $("span.add-video-btn-disabled-tooltip").tooltip({
            placement : 'top',
            title: "You cannot upload videos and images in one post."
        });
    },200);
});

$(document).on('click',".remove_image",function (e) {
    if(typeof($(this).closest('.show-image').attr('data-attachment-id'))!='undefined'){
        var attachmentId=$(this).closest('.show-image').attr('data-attachment-id');
        window.attachedDeletedArray.push(attachmentId);
    }

    var imageName=$(this).closest('.show-image').find('img').attr('data-name');
    window.attachedImagesArray = $.grep(window.attachedImagesArray, function(item) {
        return item.name !== imageName;
    });

    $(this).closest('.show-image').remove();
    var images=$('#add_post_modal .attached_images_container .show-image');
    var imagesLength=images.length;
    if(imagesLength==0){
        $('#add_video_btn').removeClass('disabled').removeAttr('disabled');
        $('span.add-video-btn-disabled-tooltip').tooltip('destroy');
    }
    else if(imagesLength>0){
        $('#add_video_btn').addClass('disabled').attr('disabled','disabled');
    }
    if(imagesLength<4){
        $('#add_post_modal .help-block small').text('');
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

$(document).on('click',"#add_video_btn",function (e) {
    document.getElementById("add_video_file").click();
    //$("span.add-video-btn-disabled-tooltip").tooltip('hide');
});

$(document).on('change',"#add_video_file",function (e){
    $('#add_post_modal .help-block small').text('');
    //$("span.add-video-btn-disabled-tooltip").tooltip('hide');

    $('#add_post_modal .limit_exceeded_error_msg').text('');
    $('.limit_exceeded_error_msg_container').addClass('hide');

    var facebook_videos_limit= window.facebook_videos_limit;
    var twitter_videos_limit= window.twitter_videos_limit;
    var instagram_videos_limit= window.instagram_videos_limit;
    var linkedin_videos_limit= window.linkedin_videos_limit;

    var attachedVideos=$('#add_post_modal .attached_videos_container video');
    var NumOfAttachedVideos=attachedVideos.length;

    var remainingFacebookVideos=facebook_videos_limit-NumOfAttachedVideos;
    var remainingTwitterVideos=twitter_videos_limit-NumOfAttachedVideos;
    var remainingInstagramVideos=instagram_videos_limit-NumOfAttachedVideos;
    var remainingLinkedinVideos=linkedin_videos_limit-NumOfAttachedVideos;

    var limitsArray=[];
    var selectedNetworksArr=$('.select-social-media-buttons-container button.selected-social-media');
    $(selectedNetworksArr).each(function (a,b) {
        var selectedNetwork=$(b);
        if($(b).hasClass('facebook-social-media-button')){
            limitsArray.push(facebook_videos_limit);
        }
        else if($(b).hasClass('twitter-social-media-button')){
            limitsArray.push(twitter_videos_limit);
        }
        else if($(b).hasClass('instagram-social-media-button')){
            limitsArray.push(instagram_videos_limit);
        }
        else if($(b).hasClass('linkedin-social-media-button')){
            limitsArray.push(linkedin_videos_limit);
        }
    });

    var minLimit=arrayMin(limitsArray);

    var limitedNetworks=[];
    var selectedNetworksArr=$('.select-social-media-buttons-container button.selected-social-media');
    $(selectedNetworksArr).each(function (a,b) {
        var selectedNetwork=$(b);
        if($(b).hasClass('facebook-social-media-button') && remainingFacebookVideos<=minLimit){
            limitedNetworks.push('Facebook');
        }
        else if($(b).hasClass('twitter-social-media-button') && remainingTwitterVideos<=minLimit){
            limitedNetworks.push('Twitter');
        }
        else if($(b).hasClass('instagram-social-media-button') && remainingInstagramVideos<=minLimit){
            limitedNetworks.push('Instagram');
        }
        else if($(b).hasClass('linkedin-social-media-button') && remainingLinkedinVideos<=minLimit){
            limitedNetworks.push('Linkedin');
        }
    });

    var files    = document.querySelector('#add_video_file').files;
    for (var y = 0; y < files.length; y++) {
        var file    = files[y];
        var fileType=file.type;
        var fileSize=file.size;
        var validVideoTypes=['video/mp4'];
        var checkFileType=$.inArray( fileType, validVideoTypes ) ;
        //var res = fileType.match(/video\.*/i);

        if(checkFileType==-1){

            $('#add_post_modal .limit_exceeded_error_msg').text('').text("File format is invalid. Please upload valid video formats like <.mp4>.");
            $('.limit_exceeded_error_msg_container').removeClass('hide');

            //$('#add_post_modal .help-block small').text('').text("File format is invalid. Please upload valid video formats like <.mp4>.");

            $('#add_video_file').val('');
            return false;
        }

        // if(fileSize>10485760){
        //     $('#add_post_modal .limit_exceeded_error_msg').text('').text("File size cannot be more than 10MB.");
        //     $('.limit_exceeded_error_msg_container').removeClass('hide');
        //     $('#add_video_file').val('');
        //     return false;
        // }

    }

    var allowedVideos=minLimit;

    var videos=$('#add_post_modal .attached_videos_container video');
    var videosLength=videos.length;
    if(videosLength>=allowedVideos){
        if (limitedNetworks.length > 1) {
            var limitedNetworksFirstHalf = limitedNetworks.slice(0, limitedNetworks.length - 1);
            var limitedNetworksFirstHalfStr = limitedNetworksFirstHalf.join(", ");
            var limitedNetworksSecondHalf = limitedNetworks.slice(limitedNetworks.length - 1, limitedNetworks.length);
            var limitedNetworksStr = limitedNetworksFirstHalfStr + " and " + limitedNetworksSecondHalf;
        }
        else {
            var limitedNetworksStr = limitedNetworks.join(", ");
        }

        if(minLimit==0){
            $('#add_post_modal .limit_exceeded_error_msg').text('').text('We currently don\'t support publishing multimedia to ' + limitedNetworksStr + '. Deselect ' + limitedNetworksStr + ' if you want to publish a multimedia post to other social media pages.');
        }
        else{
            $('#add_post_modal .limit_exceeded_error_msg').text('').text('Can’t upload more than ' + minLimit + ' video(s) on ' + limitedNetworksStr + '.');
        }

        $('.limit_exceeded_error_msg_container').removeClass('hide');

        //$('#add_post_modal .help-block small').text('').text('Only one video is allowed to attach.');

        $('#add_video_file').val('');
        return false;
    }

    if(videos.length==0){
        var customImgId=videos.length+1;
    }
    else{
        var lastVideoEl=videos[videos.length-1];
        var lastImageClass=$(lastVideoEl).find('source').attr('class');
        var num = parseInt(lastImageClass.match(/\d+/));
        var customImgId=num+1;
    }



    if(videosLength+files.length>allowedVideos){

        var limitedNetworks=[];
        var selectedNetworksArr=$('.select-social-media-buttons-container button.selected-social-media');
        $(selectedNetworksArr).each(function (a,b) {
            var selectedNetwork=$(b);
            if($(b).hasClass('facebook-social-media-button') && remainingFacebookVideos<=minLimit){
                limitedNetworks.push('Facebook');
            }
            else if($(b).hasClass('twitter-social-media-button') && remainingTwitterVideos<=minLimit){
                limitedNetworks.push('Twitter');
            }
            else if($(b).hasClass('instagram-social-media-button') && remainingInstagramVideos<=minLimit){
                limitedNetworks.push('Instagram');
            }
            else if($(b).hasClass('linkedin-social-media-button') && remainingLinkedinVideos<=minLimit){
                limitedNetworks.push('Linkedin');
            }
        });

        if (limitedNetworks.length > 1) {
            var limitedNetworksFirstHalf = limitedNetworks.slice(0, limitedNetworks.length - 1);
            var limitedNetworksFirstHalfStr = limitedNetworksFirstHalf.join(", ");
            var limitedNetworksSecondHalf = limitedNetworks.slice(limitedNetworks.length - 1, limitedNetworks.length);
            var limitedNetworksStr = limitedNetworksFirstHalfStr + " and " + limitedNetworksSecondHalf;
        }
        else {
            var limitedNetworksStr = limitedNetworks.join(", ");
        }

        if(minLimit==0){
            $('#add_post_modal .limit_exceeded_error_msg').text('').text('We currently don\'t support publishing multimedia to ' + limitedNetworksStr + '. Deselect ' + limitedNetworksStr + ' if you want to publish a multimedia post to other social media pages.');
        }
        else{
            $('#add_post_modal .limit_exceeded_error_msg').text('').text('Can’t upload more than ' + minLimit + ' video(s) on ' + limitedNetworksStr + '.');
        }

        $('.limit_exceeded_error_msg_container').removeClass('hide');

        //$('#add_post_modal .help-block small').text('').text('Only one video is allowed to attach.');

        $('#add_video_file').val('');
        return false;
    }

    for (var x = 0; x < files.length; x++) {
        var file    = files[x];
        var fileType=file.type;
        var res = fileType.match(/video\.*/i);
        var fileSize=file.size;

        var validVideoTypes=['video/mp4'];
        var checkFileType=$.inArray( fileType, validVideoTypes ) ;
        //var res = fileType.match(/video\.*/i);

        if(checkFileType==-1){

            $('#add_post_modal .limit_exceeded_error_msg').text('').text("File format is invalid. Please upload valid video formats like <.mp4>.");
            $('.limit_exceeded_error_msg_container').removeClass('hide');

            //$('#add_post_modal .help-block small').text('').text("File format is invalid. Please upload valid video formats like <.mp4>.");

            $('#add_video_file').val('');
            return false;
        }

        if(fileSize>10485760){
            $('#add_post_modal .limit_exceeded_error_msg').text('').text("File size cannot be more than 10MB.");
            $('.limit_exceeded_error_msg_container').removeClass('hide');
            $('#add_video_file').val('');
            return false;
        }

        var newCustomVideoId=customImgId+x;
        var videoTemplate='<div class="video_container" data-name="'+file.name+'"><video width="400" controls>\n' +
            '                  <source src="" class="attached_video_'+newCustomVideoId+'">\n' +
            '                       Your browser does not support HTML5 video.\n' +
            '               </video>' +
            '               <span class="remove_video">x</span>' +
            '</div>';
        $('#add_post_modal .attached_videos_container').append(videoTemplate);

        var $source = $('.attached_video_'+newCustomVideoId);
        $source[0].src = URL.createObjectURL(file);
        $source.parent()[0].load();

        window.attachedVideosArray.push(file);
    }

    if(!$('#add_post_modal .link_preview_container').hasClass('hide')){
        $('#add_post_modal .link_preview_container').addClass('hide')
    }

    $('#add_image_btn').addClass('disabled').attr('disabled','disabled');
    $('span.add-image-btn-disabled-tooltip').tooltip('destroy');
    setTimeout(function () {
        $("span.add-image-btn-disabled-tooltip").tooltip({
            placement : 'top',
            title: "You cannot upload videos and images in one post."
        });
    },200);
});

$(document).on('click',".remove_video",function (e) {

    if(typeof($(this).closest('.video_container').attr('data-attachment-id'))!='undefined'){
        var attachmentId=$(this).closest('.video_container').attr('data-attachment-id');
        window.attachedDeletedArray.push(attachmentId);
    }

    var videoName=$(this).closest('.video_container').attr('data-name');
    window.attachedVideosArray = $.grep(window.attachedVideosArray, function(item) {
        return item.name !== videoName;
    });

    $(this).closest('.video_container').remove();
    var videos=$('#add_post_modal .video_container video');
    var videosLength=videos.length;
    if(videosLength==0){
        $('#add_image_btn').removeClass('disabled').removeAttr('disabled');
        $('span.add-image-btn-disabled-tooltip').tooltip('destroy');
    }
    else if(videosLength>0){
        $('#add_image_btn').addClass('disabled').attr('disabled','disabled');
    }
    if(videosLength<2){
        $('#add_post_modal .help-block small').text('');
    }
    $('#add_video_file').val('');

    /*-----------Images Videos Validation Code -------------------*/

    $('#post_now_btn,.send_post_options button').removeClass('disabled').removeAttr('disabled');
    $('span.posts-btn-disabled-tooltip').tooltip('destroy');

    $('#add_post_modal .limit_exceeded_error_msg').text('');
    $('.limit_exceeded_error_msg_container').addClass('hide');

    var facebook_videos_limit= window.facebook_videos_limit;
    var twitter_videos_limit= window.twitter_videos_limit;
    var instagram_videos_limit= window.instagram_videos_limit;
    var linkedin_videos_limit= window.linkedin_videos_limit;

    var attachedVideos=$('#add_post_modal .attached_videos_container video');
    var NumOfAttachedVideos=attachedVideos.length;

    var remainingFacebookVideos=facebook_videos_limit-NumOfAttachedVideos;
    var remainingTwitterVideos=twitter_videos_limit-NumOfAttachedVideos;
    var remainingInstagramVideos=instagram_videos_limit-NumOfAttachedVideos;
    var remainingLinkedinVideos=linkedin_videos_limit-NumOfAttachedVideos;

    var checkVideosError=false;
    (!$('.facebook-social-media-button.selected-social-media').length==0 && remainingFacebookVideos<0) ? checkVideosError=true : '';
    (!$('.twitter-social-media-button.selected-social-media').length==0 && remainingTwitterVideos<0) ? checkVideosError=true : '';
    (!$('.instagram-social-media-button.selected-social-media').length==0 && remainingInstagramVideos<0) ? checkVideosError=true : '';
    (!$('.linkedin-social-media-button.selected-social-media').length==0 && remainingLinkedinVideos<0) ? checkVideosError=true : '';

    if(checkVideosError){

        var limitsVideosArray=[],limitedVideosNetworks=[];
        var selectedNetworksVideosArr=$('.select-social-media-buttons-container button.selected-social-media');
        $(selectedNetworksVideosArr).each(function (a,b) {
            var selectedNetwork=$(b);
            if($(b).hasClass('facebook-social-media-button') && remainingFacebookVideos<0){
                limitsVideosArray.push(facebook_videos_limit);
                limitedVideosNetworks.push('Facebook');
            }
            else if($(b).hasClass('twitter-social-media-button') && remainingTwitterVideos<0){
                limitsVideosArray.push(twitter_videos_limit);
                limitedVideosNetworks.push('Twitter');
            }
            else if($(b).hasClass('instagram-social-media-button') && remainingInstagramVideos<0){
                limitsVideosArray.push(instagram_videos_limit);
                limitedVideosNetworks.push('Instagram');
            }
            else if($(b).hasClass('linkedin-social-media-button') && remainingLinkedinVideos<0){
                limitsVideosArray.push(linkedin_videos_limit);
                limitedVideosNetworks.push('Linkedin');
            }
        });

        var minVideosLimit=arrayMin(limitsVideosArray);

        if(limitedVideosNetworks.length>1){
            var limitedVideosNetworksFirstHalf = limitedVideosNetworks.slice(0, limitedVideosNetworks.length-1);
            var limitedVideosNetworksFirstHalfStr=limitedVideosNetworksFirstHalf.join(", ");
            var limitedVideosNetworksSecondHalf = limitedVideosNetworks.slice(limitedVideosNetworks.length-1, limitedVideosNetworks.length);
            var limitedVideosNetworksStr=limitedVideosNetworksFirstHalfStr+" and "+limitedVideosNetworksSecondHalf;
            var strMsg="Limit exceeded of video(s) for " + limitedVideosNetworksStr;

        }
        else{
            var limitedVideosNetworksStr=limitedVideosNetworks.join(", ");

            if(minVideosLimit==0){
                var strMsg='We currently don\'t support publishing multimedia to ' + limitedVideosNetworksStr + '. Deselect ' + limitedVideosNetworksStr + ' if you want to publish a multimedia post to other social media pages.';
            }
            else
            {
                var strMsg="Can’t upload more than " + minVideosLimit + " video(s) on " + limitedVideosNetworksStr ;
            }


        }

        $('#add_post_modal .limit_exceeded_error_msg').text('').text(strMsg);
        $('.limit_exceeded_error_msg_container').removeClass('hide');


        $('#post_now_btn,.send_post_options button').addClass('disabled').attr('disabled','disabled');
        $('span.posts-btn-disabled-tooltip').tooltip('destroy');
        setTimeout(function () {
            $("span.posts-btn-disabled-tooltip").tooltip({
                placement : 'top',
                title: "Post cannot be made as videos(s) limit exceeded."
            });
        },200);
    }

});

$(document).on('click',"#add_link_btn",function (e) {
    $("#add_link_modal").modal('show');
});

$(document).on('click',".post_date_desc",function (e) {
    $("#scheduled_post_modal").modal('show');
});

$(document).on('click',".remove_link",function (e) {
    $(this).parent().addClass('hide');
});

$(document).on('click',".remove_limit_exceeded_error",function (e) {
    $(this).parent().addClass('hide');
});

function arrayMin(arr) {
    var len = arr.length, min = Infinity;
    while (len--) {
        if (Number(arr[len]) < min) {
            min = Number(arr[len]);
        }
    }
    return min;
}

function validateAddPostModal(element){
    $('#add_post_modal .limit_exceeded_error_msg').text('');
    $('.limit_exceeded_error_msg_container').addClass('hide');

    $('#post_now_btn,.send_post_options button').removeClass('disabled').removeAttr('disabled');
    $('span.posts-btn-disabled-tooltip').tooltip('destroy');

    if(typeof(element)!='undefined'){
        if(element.hasClass('facebook-social-media-button')){
            $('.facebook-social-media-button.selected-social-media').length==0 ?  $('.facebook_posts_char_count').addClass('hide') : $('.facebook_posts_char_count').removeClass('hide');
        }
        else if(element.hasClass('twitter-social-media-button')){
            $('.twitter-social-media-button.selected-social-media').length==0 ?  $('.twitter_posts_char_count').addClass('hide') : $('.twitter_posts_char_count').removeClass('hide');
        }
        else if(element.hasClass('instagram-social-media-button')){
            $('.instagram-social-media-button.selected-social-media').length==0 ?  $('.instagram_posts_char_count').addClass('hide') : $('.instagram_posts_char_count').removeClass('hide');
        }
        else if(element.hasClass('linkedin-social-media-button')){
            $('.linkedin-social-media-button.selected-social-media').length==0 ?  $('.linkedin_posts_char_count').addClass('hide') : $('.linkedin_posts_char_count').removeClass('hide');
        }
    }
    /*-----------Characters Limit Validation Code -------------------*/

    //var contents = $('#post_content_body').summernote('code');
    //var plainText = $("<p>" + contents+ "</p>").text();
    var plainText = $('#post_content_body').val();
    plainText=$.trim(plainText);
    var postContentLength=plainText.length;

    var remainingFacebookCharCount=window.facebook_limit-postContentLength;
    var remainingTwitterCharCount=window.twitter_limit-postContentLength;
    var remainingInstagramCharCount=window.instagram_limit-postContentLength;
    var remainingLinkedinCharCount=window.linkedin_limit-postContentLength;

    var checkError=false;
    (!$('.facebook-social-media-button.selected-social-media').length==0 && remainingFacebookCharCount<0) ? checkError=true : '';
    (!$('.twitter-social-media-button.selected-social-media').length==0 && remainingTwitterCharCount<0) ? checkError=true : '';
    (!$('.instagram-social-media-button.selected-social-media').length==0 && remainingInstagramCharCount<0) ? checkError=true : '';
    (!$('.linkedin-social-media-button.selected-social-media').length==0 && remainingLinkedinCharCount<0) ? checkError=true : '';

    var limitsArray=[],limitedNetworks=[];
    var selectedNetworksArr=$('.select-social-media-buttons-container button.selected-social-media');
    $(selectedNetworksArr).each(function (a,b) {
        var selectedNetwork=$(b);
        if($(b).hasClass('facebook-social-media-button') && remainingFacebookCharCount<0){
            limitsArray.push(window.facebook_limit);
            limitedNetworks.push('Facebook');
        }
        else if($(b).hasClass('twitter-social-media-button') && remainingTwitterCharCount<0){
            limitsArray.push(window.twitter_limit);
            limitedNetworks.push('Twitter');
        }
        else if($(b).hasClass('instagram-social-media-button') && remainingInstagramCharCount<0){
            limitsArray.push(window.instagram_limit);
            limitedNetworks.push('Instagram');
        }
        else if($(b).hasClass('linkedin-social-media-button') && remainingLinkedinCharCount<0){
            limitsArray.push(window.linkedin_limit);
            limitedNetworks.push('Linkedin');
        }
    });
    var minLimit=arrayMin(limitsArray);

    if(checkError){
        if(limitedNetworks.length>1){
            var limitedNetworksFirstHalf = limitedNetworks.slice(0, limitedNetworks.length-1);
            var limitedNetworksFirstHalfStr=limitedNetworksFirstHalf.join(", ");
            var limitedNetworksSecondHalf = limitedNetworks.slice(limitedNetworks.length-1, limitedNetworks.length);
            var limitedNetworksStr=limitedNetworksFirstHalfStr+" and "+limitedNetworksSecondHalf;
        }
        else{
            var limitedNetworksStr=limitedNetworks.join(", ");
        }

        $('#add_post_modal .limit_exceeded_error_msg').text('').text('Characters limit exceeded. Can’t be posted on '+limitedNetworksStr+'.');
        $('.limit_exceeded_error_msg_container').removeClass('hide');


        $('#post_now_btn,.send_post_options button').addClass('disabled').attr('disabled','disabled');
        $('span.posts-btn-disabled-tooltip').tooltip('destroy');
        setTimeout(function () {
            $("span.posts-btn-disabled-tooltip").tooltip({
                placement : 'top',
                title: "Post cannot be made as characters limit exceeded"
            });
        },200);
    }

    /*-----------Images Limit Validation Code -------------------*/
    var facebook_images_limit = window.facebook_images_limit;
    var twitter_images_limit=window.twitter_images_limit;
    var instagram_images_limit=window.instagram_images_limit;
    var linkedin_images_limit=window.linkedin_images_limit;

    var attachedImages=$('#add_post_modal .attached_images_container .show-image');
    var NumOfAttachedImages=attachedImages.length;

    var remainingFacebookImages = facebook_images_limit - NumOfAttachedImages;
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
            else
            {
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

    /*-----------Images Videos Validation Code -------------------*/
    var facebook_videos_limit= window.facebook_videos_limit;
    var twitter_videos_limit= window.twitter_videos_limit;
    var instagram_videos_limit= window.instagram_videos_limit;
    var linkedin_videos_limit= window.linkedin_videos_limit;

    var attachedVideos=$('#add_post_modal .attached_videos_container video');
    var NumOfAttachedVideos=attachedVideos.length;

    var remainingFacebookVideos=facebook_videos_limit-NumOfAttachedVideos;
    var remainingTwitterVideos=twitter_videos_limit-NumOfAttachedVideos;
    var remainingInstagramVideos=instagram_videos_limit-NumOfAttachedVideos;
    var remainingLinkedinVideos=linkedin_videos_limit-NumOfAttachedVideos;

    var checkVideosError=false;
    (!$('.facebook-social-media-button.selected-social-media').length==0 && remainingFacebookVideos<0) ? checkVideosError=true : '';
    (!$('.twitter-social-media-button.selected-social-media').length==0 && remainingTwitterVideos<0) ? checkVideosError=true : '';
    (!$('.instagram-social-media-button.selected-social-media').length==0 && remainingInstagramVideos<0) ? checkVideosError=true : '';
    (!$('.linkedin-social-media-button.selected-social-media').length==0 && remainingLinkedinVideos<0) ? checkVideosError=true : '';

    if(checkVideosError){

        var limitsVideosArray=[],limitedVideosNetworks=[];
        var selectedNetworksVideosArr=$('.select-social-media-buttons-container button.selected-social-media');
        $(selectedNetworksVideosArr).each(function (a,b) {
            var selectedNetwork=$(b);
            if($(b).hasClass('facebook-social-media-button') && remainingFacebookVideos<0){
                limitsVideosArray.push(facebook_videos_limit);
                limitedVideosNetworks.push('Facebook');
            }
            else if($(b).hasClass('twitter-social-media-button') && remainingTwitterVideos<0){
                limitsVideosArray.push(twitter_videos_limit);
                limitedVideosNetworks.push('Twitter');
            }
            else if($(b).hasClass('instagram-social-media-button') && remainingInstagramVideos<0){
                limitsVideosArray.push(instagram_videos_limit);
                limitedVideosNetworks.push('Instagram');
            }
            else if($(b).hasClass('linkedin-social-media-button') && remainingLinkedinVideos<0){
                limitsVideosArray.push(linkedin_videos_limit);
                limitedVideosNetworks.push('Linkedin');
            }
        });

        var minVideosLimit=arrayMin(limitsVideosArray);

        if(limitedVideosNetworks.length>1){
            var limitedVideosNetworksFirstHalf = limitedVideosNetworks.slice(0, limitedVideosNetworks.length-1);
            var limitedVideosNetworksFirstHalfStr=limitedVideosNetworksFirstHalf.join(", ");
            var limitedVideosNetworksSecondHalf = limitedVideosNetworks.slice(limitedVideosNetworks.length-1, limitedVideosNetworks.length);
            var limitedVideosNetworksStr=limitedVideosNetworksFirstHalfStr+" and "+limitedVideosNetworksSecondHalf;
            var strMsg="Limit exceeded of video(s) for " + limitedVideosNetworksStr;
        }
        else{
            var limitedVideosNetworksStr=limitedVideosNetworks.join(", ");

            if(minVideosLimit==0){
                var strMsg='We currently don\'t support publishing multimedia to ' + limitedVideosNetworksStr + '. Deselect ' + limitedVideosNetworksStr + ' if you want to publish a multimedia post to other social media pages.';
            }
            else
            {
                var strMsg="Can’t upload more than " + minVideosLimit + " video(s) on " + limitedVideosNetworksStr ;
            }


        }

        $('#add_post_modal .limit_exceeded_error_msg').text('').text(strMsg);
        $('.limit_exceeded_error_msg_container').removeClass('hide');


        $('#post_now_btn,.send_post_options button').addClass('disabled').attr('disabled','disabled');
        $('span.posts-btn-disabled-tooltip').tooltip('destroy');
        setTimeout(function () {
            $("span.posts-btn-disabled-tooltip").tooltip({
                placement : 'top',
                title: "Post cannot be made as videos(s) limit exceeded."
            });
        },200);
    }

    if(checkError || checkImagesError || checkVideosError){
        return false;
    }
}

$(document).on('click',".select-social-media-button",function (e) {
    var element=$(this);
    validateAddPostModal(element);
});

$(document).on('change keydown keyup',"#post_content_body",function (e) {
    var images=$('#add_post_modal .attached_images_container .show-image');
    var imagesLength=images.length;
    var videos=$('#add_post_modal .attached_videos_container video');
    var videosLength=videos.length;

    generateLinkPreviewKeyUp();

    var plainText = $('#post_content_body').val();
    plainText=$.trim(plainText);
    var postContentLength=plainText.length;
    postContentLength.length!=0 ? $('#add_post_modal .help-block small').text('') : '';

    var remainingFacebookCharCount=window.facebook_limit-postContentLength;
    var remainingTwitterCharCount=window.twitter_limit-postContentLength;
    var remainingInstagramCharCount=window.instagram_limit-postContentLength;
    var remainingLinkedinCharCount=window.linkedin_limit-postContentLength;

    $('.facebook_limit').text(remainingFacebookCharCount);
    $('.twitter_limit').text(remainingTwitterCharCount);
    $('.instagram_limit').text(remainingInstagramCharCount);
    $('.linkedin_limit').text(remainingLinkedinCharCount);

    remainingFacebookCharCount<0 ?  $('.facebook_limit').addClass('posts_char_count_exceed') : $('.facebook_limit').removeClass('posts_char_count_exceed');
    remainingTwitterCharCount<0 ?  $('.twitter_limit').addClass('posts_char_count_exceed') : $('.twitter_limit').removeClass('posts_char_count_exceed');
    remainingInstagramCharCount<0 ?  $('.instagram_limit').addClass('posts_char_count_exceed') : $('.instagram_limit').removeClass('posts_char_count_exceed');
    remainingLinkedinCharCount<0 ?  $('.linkedin_limit').addClass('posts_char_count_exceed') : $('.linkedin_limit').removeClass('posts_char_count_exceed');

    $('.facebook-social-media-button.selected-social-media').length==0 ?  $('.facebook_posts_char_count').addClass('hide') : $('.facebook_posts_char_count').removeClass('hide');
    $('.twitter-social-media-button.selected-social-media').length==0 ?  $('.twitter_posts_char_count').addClass('hide') : $('.twitter_posts_char_count').removeClass('hide');
    $('.instagram-social-media-button.selected-social-media').length==0 ?  $('.instagram_posts_char_count').addClass('hide') : $('.instagram_posts_char_count').removeClass('hide');
    $('.linkedin-social-media-button.selected-social-media').length==0 ?  $('.linkedin_posts_char_count').addClass('hide') : $('.linkedin_posts_char_count').removeClass('hide');

    var checkError=false;
    (!$('.facebook-social-media-button.selected-social-media').length==0 && remainingFacebookCharCount<0) ? checkError=true : '';
    (!$('.twitter-social-media-button.selected-social-media').length==0 && remainingTwitterCharCount<0) ? checkError=true : '';
    (!$('.instagram-social-media-button.selected-social-media').length==0 && remainingInstagramCharCount<0) ? checkError=true : '';
    (!$('.linkedin-social-media-button.selected-social-media').length==0 && remainingLinkedinCharCount<0) ? checkError=true : '';

    var limitsArray=[],limitedNetworks=[];
    var selectedNetworksArr=$('.select-social-media-buttons-container button.selected-social-media');
    $(selectedNetworksArr).each(function (a,b) {
        var selectedNetwork=$(b);
        if($(b).hasClass('facebook-social-media-button') && remainingFacebookCharCount<0){
            limitsArray.push(window.facebook_limit);
            limitedNetworks.push('Facebook');
        }
        else if($(b).hasClass('twitter-social-media-button') && remainingTwitterCharCount<0){
            limitsArray.push(window.twitter_limit);
            limitedNetworks.push('Twitter');
        }
        else if($(b).hasClass('instagram-social-media-button') && remainingInstagramCharCount<0){
            limitsArray.push(window.instagram_limit);
            limitedNetworks.push('Instagram');
        }
        else if($(b).hasClass('linkedin-social-media-button') && remainingLinkedinCharCount<0){
            limitsArray.push(window.linkedin_limit);
            limitedNetworks.push('Linkedin');
        }
    });

    var minLimit=arrayMin(limitsArray);

    if(checkError){
        if(limitedNetworks.length>1){
            var limitedNetworksFirstHalf = limitedNetworks.slice(0, limitedNetworks.length-1);
            var limitedNetworksFirstHalfStr=limitedNetworksFirstHalf.join(", ");
            var limitedNetworksSecondHalf = limitedNetworks.slice(limitedNetworks.length-1, limitedNetworks.length);
            var limitedNetworksStr=limitedNetworksFirstHalfStr+" and "+limitedNetworksSecondHalf;
        }
        else{
            var limitedNetworksStr=limitedNetworks.join(", ");
        }

        $('#add_post_modal .limit_exceeded_error_msg').text('').text('Characters limit exceeded. Can’t be posted on '+limitedNetworksStr+'.');
        $('.limit_exceeded_error_msg_container').removeClass('hide');

        $('#post_now_btn,.send_post_options button').addClass('disabled').attr('disabled','disabled');
        $('span.posts-btn-disabled-tooltip').tooltip('destroy');
        setTimeout(function () {
            $("span.posts-btn-disabled-tooltip").tooltip({
                placement : 'top',
                title: "Post cannot be made as characters limit exceeded"
            });
        },200);
    }
    else{
        $('#post_now_btn,.send_post_options button').removeClass('disabled').removeAttr('disabled');
        $('span.posts-btn-disabled-tooltip').tooltip('destroy');

        $('#add_post_modal .limit_exceeded_error_msg').text('');
        $('.limit_exceeded_error_msg_container').addClass('hide');
    }

    if(window.editPost==true){
        checkUpdatePostButtonStatus();
    }
});

$(document).on('paste',"#post_content_body",function (e) {
    generateLinkPreviewPaste();
});

$(document).on('click',"#save_schedule_post",function (e) {
    var schedule_post_datepicker=$('#scheduled_datepicker').data("DateTimePicker").date();
    var schedule_post_date=schedule_post_datepicker.format('YYYY-MM-DD');
    var formated_schedule_post_date=moment(schedule_post_date).format('LL');

    var custom_timepicker_hour=$('#custom_timepicker_hour_selector').val();
    var custom_timepicker_minutes=$('#custom_timepicker_minutes_selector').val();
    var custom_timepicker_interval=$('.custom_timepicker_interval.active').text();

    $('.post_date_container').removeClass('hide');

    var post_on_date = formated_schedule_post_date+' '+custom_timepicker_hour+':'+custom_timepicker_minutes+' '+custom_timepicker_interval+' (EST)';

    var post_on_time = custom_timepicker_hour+':'+custom_timepicker_minutes+' '+custom_timepicker_interval;

    var time24HourFormat=get24hTime(post_on_time)+':00';
    var time24HourFormatDateTime=schedule_post_date+' '+time24HourFormat;

    $('.post_date_desc').text(post_on_date).attr('data-dateTime', time24HourFormatDateTime);

    $('#post_now_btn').text('Schedule').attr('rel','schedule_post');

    $('#scheduled_post_modal').modal('hide');
});

$(document).on('click',".close_add_post_modal",function (e) {
    $('#add_post_modal').modal('hide');
    // if (window.editPost == false) {  //For New Add Post
    //     var post_content_body = $('#post_content_body').val();
    //     post_content_body = $.trim(post_content_body);
    //
    //     var attachedImages = $('#add_post_modal .attached_images_container .show-image');
    //     var NumOfAttachedImages = attachedImages.length;
    //
    //     var attachedVideos = $('#add_post_modal .attached_videos_container video');
    //     var NumOfAttachedVideos = attachedVideos.length;
    //
    //     if (post_content_body != '' || NumOfAttachedImages != 0 || NumOfAttachedVideos != 0) {
    //         $('#discard_post_modal').modal('show');
    //     }
    //     else {
    //         $('#add_post_modal').modal('hide');
    //     }
    // }
    // else{  //For Edit Post
    //     $('#add_post_modal').modal('hide');
    // }
});

$(document).on('click',"#discard_post_btn",function (e) {
    $('#discard_post_modal').modal('hide');
    $('#add_post_modal').modal('hide');
});

$(document).on('click',"#save_draft_post_btn",function (e) {
    $('.send_post_options ul li:eq(2)').click();
    $('#discard_post_modal').modal('hide');
});

function showMoreLessPlugin(element){
    var showChar = 1000;  // How many characters are shown by default
    var ellipsestext = "...";
    var moretext = "see more";
    var lesstext = "see less";

    $(element+' .more').each(function() {
        var content = $(this).html();
        if(content.length > showChar) {
            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);
            var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';
            $(this).html(html);
        }
    });

    $(element+" .morelink").click(function(){
        if($(this).hasClass("less")) {
            $(this).removeClass("less");
            $(this).html(moretext);
        }
        else {
            $(this).addClass("less");
            $(this).html(lesstext);
        }
        $(this).parent().prev().toggle();
        $(this).prev().toggle();
        return false;
    });
}
