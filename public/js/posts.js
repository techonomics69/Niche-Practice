$(document).ready(function(){
    $(".social-profile-tab li").click(function()
    {
        var status = $(this).attr("data-status");
        var type = $(this).attr("data-type");

        $(".social-profile-tab li").removeClass('active');
        $(this).addClass('active');

        $(".panel").removeClass('active');
        $("."+type+"-panel").addClass('active');

        if(status === 'connected')
        {
            $(".post-tabs").show();

            // post tabs will be show else hide
            // connect-container must be hide else will be show
            $(".connect-container").hide();

            if($(".post_item").length == 0)
            {
                $(".empty-posts").show();
            }
        }
        else
        {
            $(".post-tabs").hide();
            $('.connect-'+type+'-img-container').show();
        }
    });


    $('#add_video_demo_btn').addClass('disabled').attr('disabled','disabled');
    $('span.add-video-btn-demo-disabled-tooltip').tooltip('destroy');
    setTimeout(function () {
        $("span.add-video-btn-demo-disabled-tooltip").tooltip({
            placement : 'top',
            title: "Uploading video will be available soon."
        });
    },200);

    // delegate calls to data-toggle="lightbox"
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        return $(this).ekkoLightbox({
            alwaysShowClose: true,
            wrapping: false,
            showArrows: true,
            // maxWidth : 500,
            //maxHeight : 500,
            onShown: function() {
                if (window.console) {
                    //return console.log('Checking our the events huh?');
                }
            },
            onNavigate: function(direction, itemIndex) {
                if (window.console) {
                    //return console.log('Navigating '+direction+'. Current item: '+itemIndex);
                }
            }
        });
    });

    var activeTab=window.localStorage.getItem("activeTab");
    // console.log("get posts > activeTab " + activeTab)

    if(activeTab!=null){
        var getActiveTab=window.localStorage.getItem("activeTab");
        if(getActiveTab=='published'){
            // $('#ScheduledViewTab,#ScheduledTab').removeClass('active');
            // $('#PublishedViewTab,#PublishedTab').addClass('active');

            setTimeout(function () {
                $("#PublishedViewTab a").click();
            }, 500);
        }
        else if(getActiveTab=='schedule'){
            // $('#PublishedViewTab,#PublishedTab').removeClass('active');
            // $('#ScheduledViewTab,#ScheduledTab').addClass('active');

            setTimeout(function () {
                $("#ScheduledViewTab a").click();
            }, 500);
        }
        localStorage.removeItem("activeTab");
    }

    // console.log(schedulePostsData);

    var schedulePostsDataArrCheck=Array.isArray(schedulePostsData);

    if(!schedulePostsDataArrCheck){
        var index = 0;
        Object.keys(schedulePostsData).forEach(function (key) {
            //var d = new Date(key);
            var d = key;
            var postDate=moment(d).format('YYYY-MM-DD');
            var currentDate=moment().format('YYYY-MM-DD');
            var yesterdayDate = moment().subtract(1, 'days').format('YYYY-MM-DD');
            var tommorowDate = moment().add(1, 'days').format('YYYY-MM-DD');
            var formated_schedule_post_date;
            if(postDate==currentDate){
                formated_schedule_post_date='Today';
            }
            else if(postDate==yesterdayDate){
                formated_schedule_post_date='Yesterday';
            }
            else if(postDate==tommorowDate){
                formated_schedule_post_date='Tommorow';
            }
            else{
                formated_schedule_post_date=moment(d).format('LL');
            }
            // console.log("scheduled " + formated_schedule_post_date);
            // $('#ScheduledTab').append('<div class="post_time_header">'+formated_schedule_post_date+'</div>');

            var schedulePostsArr=schedulePostsData[key];
            $.each( schedulePostsArr, function( i, value ) {

                // var updated_at = new Date(value.updated_at);
                var updated_at = moment(value.updated_at);
                var formated_updated_at=moment(updated_at).format('hh:mm a')+' (EST)';

                // $('#ScheduledTab').append('' +
                //     '<div class="post_item">\n' +
                //     '<div class="post_item_time_container">\n' +
                //     '<div class="post_item_time">' + formated_updated_at +
                //     '<div class="dropdown posts_options_dropdown">\n' +
                //     '<button type="button" class="btn dropdown-toggle" data-toggle="dropdown">\n' +
                //     '<i class="fa fa-angle-down" aria-hidden="true"></i>\n' +
                //     '</button>\n' +
                //     '<ul class="dropdown-menu" role="menu" aria-labelledby="menu1">\n' +
                //     '<li data-post-id="'+value.id+'" class="post_edit_btn" role="presentation">\n' +
                //     '<a role="menuitem" tabindex="-1" href="#">Edit</a>\n' +
                //     '</li>\n' +
                //     '<li data-post-id="'+value.id+'" class="post_delete_btn" role="presentation">\n' +
                //     '<a role="menuitem" tabindex="-1" href="#">Delete</a>\n' +
                //     '</li>\n' +
                //     '</ul>\n' +
                //     '</div>\n' +
                //     '</div>\n' +
                //     '</div>\n' +
                //     '<div class="post_content_container post_' + index + '">\n' +
                //     '<div class="post_content_body"><span class="more"></span></div>\n' +
                //     '<div class="post_image_attached_container"><div class="row no-gutter"></div></div>' +
                //     '<div class="link_preview_container hide"></div>'+
                //     '<div class="post_content_footer">\n' +
                //     '<div class="posted_on_social_media"></div>\n' +
                //     '<div class="buttons-right posts_options_btn_container">\n' +
                //     '<button type="button" data-post-id="'+value.id+'" class="btn post_edit_btn p-edit_btn">Edit</button>\n' +
                //     '<button type="button" data-post-id="'+value.id+'" class="btn post_delete_btn p-delete_btn">Delete</button>\n' +
                //     '</div>\n' +
                //     '</div>\n' +
                //     '</div>\n' +
                //     '</div>');


                $('#ScheduledTab').append('' +
                    '<div class="post_item">\n' +

                    '<div class="post_content_container post_' + index + '">\n' +

                    '<div class="post_time_header">' +formated_schedule_post_date + ' ' + formated_updated_at + '</div>'+

                    '<div class="post_content_container1 post_' + index + '">\n' +
                    '<div class="post_content_body"><span class="more"></span></div>\n' +
                    '<div class="post_image_attached_container"><div class="row no-gutter"></div></div>' +
                    '<div class="link_preview_container hide"></div>'+
                    '<div class="post_content_footer">\n' +
                    '<div class="posted_on_social_media"></div>\n' +
                    '<div class="buttons-right posts_options_btn_container">\n' +
                    '<button type="button" data-post-id="'+value.id+'" class="btn post_edit_btn p-edit_btn">Edit</button>\n' +
                    '<button type="button" data-post-id="'+value.id+'" class="btn post_delete_btn p-delete_btn">Delete</button>\n' +
                    '</div>\n' +
                    '</div>\n' +
                    '</div>\n' +
                    '</div>');

                if(typeof(value.post_master_social_media)!='undefined'){
                    if(value.post_master_social_media.length==0){
                        $('#ScheduledTab .post_'+index+' .posted_on_social_media').html('<span class="no_network_selected_text">No Network Selected</span>');
                    }
                    else{
                        $('#ScheduledTab .post_'+index+' .posted_on_social_media').append('<span class="posted_on_social_media_label">Post on</span>\n');
                        var y;
                        for (y in value.post_master_social_media) {
                            var social_media_type=value.post_master_social_media[y].social_media_type;
                            social_media_type=social_media_type.toLowerCase();
                            if(social_media_type=='facebook'){
                                var imgName='facebook.png';
                                //$('.post_'+index+' .posts_options_btn_container').prepend('<button type="button" data-post-id="'+value.id+'" class="btn post_edit_btn">Edit</button>');
                            }
                            else if(social_media_type=='twitter'){
                                var imgName='twitter.png';
                            }
                            else if(social_media_type=='instagram'){
                                var imgName='instagram.png';
                            }
                            else if(social_media_type=='linkedin'){
                                var imgName='social-media-linkedin.png';
                            }
                            $('.post_'+index+' .posted_on_social_media').append('<div class="social_media_item"><img src="public/images/'+imgName+'"></div>');
                        }
                    }
                }

                if(typeof(value.message)!='undefined'){
                    $('#ScheduledTab .post_'+index+' .post_content_body .more').html(createTextLinks(value.message));
                    showMoreLessPlugin('#ScheduledTab .post_'+index+' .post_content_body');
                }

                if(typeof(value.attachment)!='undefined'){

                    if(value.attachment.length==0){
                        var link_preview_container_element = $('#ScheduledTab .post_' + index + ' .link_preview_container');
                        var post_image_attached_container_element = $('#ScheduledTab .post_' + index + ' .post_image_attached_container');
                        loadPostLinkPreview(value.message,link_preview_container_element,post_image_attached_container_element);
                    }

                    var attachmentLength=value.attachment.length;
                    var OneImageClass='';
                    if(attachmentLength==1){
                        var divNo='12';
                        OneImageClass='oneImage';
                    }
                    else if(attachmentLength==2){
                        var divNo='6';
                        OneImageClass='';
                    }
                    else if(attachmentLength==3){
                        var divNo='4';
                        OneImageClass='';
                    }
                    else if(attachmentLength==4){
                        var divNo='3';
                        OneImageClass='';
                    }
                    else if(attachmentLength>4){
                        var divNo='4';
                        OneImageClass='';
                    }
                    var three_plus_attachments_counter_text='';
                    if(attachmentLength>6){
                        var three_plus_attachments_counter=parseInt(attachmentLength)-6;
                        three_plus_attachments_counter_text='<div class="three_plus_attachments_counter">+'+three_plus_attachments_counter+'</div>';
                    }

                    if(attachmentLength!=0) {
                        var x1;
                        for (x1 in value.attachment) {
                            var hideImgClass=(x1>5) ?  'hide' : '';
                            var checkAttachmentType = (value.attachment[x1].type == 'image') ? 'image' : 'video';
                            if(checkAttachmentType=='image'){
                                var media_url=value.attachment[x1].media_url;
                                $('#ScheduledTab .post_'+index+' .post_image_attached_container .row').append( '' +
                                    '<div class="'+hideImgClass+' image-show col-md-'+divNo+'">' +
                                    '<a href="'+media_url+'" data-gallery="schedule_gallery_'+value.id+'" data-toggle="lightbox" >' +
                                    '<img class="img-responsive '+OneImageClass+'" src="'+media_url+'">' +
                                    '</a>' +
                                    '</div>'
                                );
                            }
                            else{
                                var media_url=value.attachment[x1].media_url;
                                var media_url_img='public/images/video_preview.jpg';
                                $('#ScheduledTab .post_'+index+' .post_image_attached_container .row').append( '' +
                                    '<div class="'+hideImgClass+' image-show col-md-'+divNo+'">' +

                                    // '<a href="'+media_url+'" data-gallery="gallery_'+value.id+'" data-toggle="lightbox" >' +
                                    // '<img class="img-responsive '+OneImageClass+'" src="'+media_url_img+'">' +
                                    // '</a>' +

                                    '<video controls>\n' +
                                    '<source src="'+media_url+'" class="schedule_show_video_' + value.id + '">\n' +
                                    'Your browser does not support HTML5 video.\n' +
                                    '</video>' +

                                    '</div>'
                                );
                            }
                        }
                        if(attachmentLength>6){
                            $('#ScheduledTab .post_'+index+' .image-show:eq(5) a').append(three_plus_attachments_counter_text);
                            $('#ScheduledTab .post_'+index+' .image-show:eq(5) a img').css('opacity','0.5');
                        }

                        /*
                        var checkAttachmentType = (value.attachment[0].type == 'image') ? 'image' : 'video';
                        console.log(checkAttachmentType);
                        if(checkAttachmentType=='image'){
                            console.log(value.attachment);
                            var x1;
                            for (x1 in value.attachment) {
                                var hideImgClass=(x1>5) ?  'hide' : '';

                                console.log(index);
                                var media_url=value.attachment[x1].media_url;
                                $('#ScheduledTab .post_'+index+' .post_image_attached_container .row').append( '' +
                                    '<div class="'+hideImgClass+' image-show col-md-'+divNo+'">' +
                                        '<a href="'+media_url+'" data-gallery="example-gallery_'+value.id+'" data-toggle="lightbox" >' +
                                            '<img class="img-responsive '+OneImageClass+'" src="'+media_url+'">' +
                                        '</a>' +
                                    '</div>'
                                );
                            }
                            $('#ScheduledTab .post_'+index+' .image-show:last-child').prev().append(three_plus_attachments_counter_text);
                        }
                        else{
                            console.log(value.attachment);
                            var x1;
                            for (x1 in value.attachment) {
                                var hideImgClass=(x1>5) ?  'hide' : '';

                                console.log(index);
                                var media_url=value.attachment[x1].media_url;
                                var media_url_img='public/images/video_preview.jpg';
                                $('#ScheduledTab .post_'+index+' .post_image_attached_container .row').append( '' +
                                    '<div class="'+hideImgClass+' image-show col-md-'+divNo+'">' +
                                        '<a href="'+media_url+'" data-gallery="youtubevideos_'+value.id+'" data-toggle="lightbox" >' +
                                           '<img class="img-responsive '+OneImageClass+'" src="'+media_url_img+'">' +
                                        '</a>' +
                                    '</div>'
                                );
                            }
                            $('#ScheduledTab .post_'+index+' .image-show:last-child').prev().append(three_plus_attachments_counter_text);
                        }
                        */

                    }
                    // else{
                    //     $('#ScheduledTab .post_'+index+' .post_image_attached_container .row').empty();
                    // }
                }

                index++;
            });

        });

        //$('#post_content_body').autoResize();
    }
    // var index1 = 0;
    publishFBData(publishedFacebookPostsData, index1 = 0);
    function publishFBData(publishedFacebookPostsData) {
        // console.log("publishedFacebookPostsData");
        // console.log(publishedFacebookPostsData);

        var publishedFacebookPostsDataArrCheck=Array.isArray(publishedFacebookPostsData);

        if(!publishedFacebookPostsDataArrCheck){

            Object.keys(publishedFacebookPostsData).forEach(function (key) {
                //var d = new Date(key);
                // console.log(key);
                var d = key;
                var postDate=moment(d).format('YYYY-MM-DD');
                var currentDate=moment().format('YYYY-MM-DD');
                var yesterdayDate = moment().subtract(1, 'days').format('YYYY-MM-DD');
                var tommorowDate = moment().add(1, 'days').format('YYYY-MM-DD');
                var formated_published_post_date;
                if(postDate==currentDate){
                    formated_published_post_date='Today';
                }
                else if(postDate==yesterdayDate){
                    formated_published_post_date='Yesterday';
                }
                else if(postDate==tommorowDate){
                    formated_published_post_date='Tommorow';
                }
                else{
                    formated_published_post_date=moment(d).format('LL');
                }
                // console.log("publised " + formated_published_post_date);

                // $('#PublishedFacebookTab').append('<div class="post_time_header">'+formated_published_post_date+'</div>');

                var publishedPostsArr=publishedFacebookPostsData[key];
                $.each( publishedPostsArr, function( i, value ) {
                    // var updated_at = new Date(value.updated_at);
                    var post_time = moment(value.post_time);
                    // var formated_post_time=moment(post_time).format('hh:mm a')+' (EST)';
                    var formated_post_time=moment(post_time).format('hh:mm a')+' (EST)';

                    $('#PublishedFacebookTab').append('' +
                        '<div class="post_item">\n' +

                        '<div class="post_content_container post_' + index1 + '">' +

                        '<div class="post_time_header">Posted at '+formated_published_post_date + ' ' + formated_post_time +' </div>' +

                        '<div class="post_content_body"><p class="more"></p></div>' +

                        '<div class="post_image_attached_container"><div class="row no-gutter"></div></div>' +

                        '<div class="post_content_footer">\n' +

                        '<div class="row">\n' +

                        '<div class="col-md-6">\n' +

                        '<div class="social-status">'+
                        '<div class="s-stats post_likes"><h3 class="post_likes_count">0</h3><label>Likes</label></div>'+
                        '<div class="s-stats post_comments"><h3 class="post_comments_count">0</h3><label>Comments</label></div>'+
                        '</div>'+

                        '</div>\n' +

                        '<div class="col-md-6">\n' +
                            '<div class="buttons-right posts_options_btn_container">'+
                            '<button type="button" data-post-id="'+value.post_id+'" data-type="facebook" class="btn post_edit_btn p-edit_btn">Edit</button>\n' +
                            '<button type="button" data-post-id="'+value.post_id+'" data-type="facebook" class="btn post_delete_btn p-delete_btn">Delete</button>\n' +
                            '<a target="_blank" class="btn view_on_site_btn view-site">View on Site</a>'+
                            '</div>'+
                        '</div>\n' +

                        '</div>\n' + // row

                        '</div>\n' +  // footer

                        '</div>\n' +

                        '</div>');

                    if(typeof(value.post_message)!='undefined'){
                        $('#PublishedFacebookTab .post_'+index1+' .post_content_body .more').html(createTextLinks(value.post_message));
                        showMoreLessPlugin('#PublishedFacebookTab .post_'+index1+' .post_content_body');
                    }


                    if(typeof(value.post_image)!='undefined'){
                        var post_image_media_url = value.post_image;

                        if(post_image_media_url !== '')
                        {
                            $('#PublishedFacebookTab .post_'+index1+' .post_image_attached_container .row').append( '' +
                                '<div class="image-show col-md-12">' +
                                '<a href="'+post_image_media_url+'" data-gallery="facebook_gallery_'+value.post_id+'" data-toggle="lightbox">' +
                                '<img class="img-responsive oneImage" src="'+post_image_media_url+'">' +
                                '</a>' +
                                '</div>'
                            );
                        }
                    }

                    if(typeof(value.post_video)!='undefined'){
                        var post_video_media_url=value.post_video;
                        if(post_video_media_url !== ''){
                            $('#PublishedFacebookTab .post_' + index1 + ' .post_image_attached_container .row').append('' +
                                '<div class="image-show col-md-12">' +
                                '<video controls>\n' +
                                '<source src="'+post_video_media_url+'" class="facebook_show_video_' + value.post_id + '">\n' +
                                'Your browser does not support HTML5 video.\n' +
                                '</video>' +
                                '</div>'
                            );
                        }
                    }

                    if(typeof(value.post_multiple_images) !='undefined'){
                        var divNo = '12';
                        var post_multiple_images = value.post_multiple_images;

                        if(post_multiple_images !=='') {
                            var attachmentLength = post_multiple_images.length;
                            var OneImageClass = '';
                            if (attachmentLength == 1) {
                                divNo = '12';
                                OneImageClass = 'oneImage';
                            }
                            else if (attachmentLength == 2) {
                                divNo = '6';
                                OneImageClass = '';
                            }
                            else if (attachmentLength == 3) {
                                divNo = '4';
                                OneImageClass = '';
                            }
                            else if (attachmentLength == 4) {
                                divNo = '3';
                                OneImageClass = '';
                            }
                            else if (attachmentLength > 4) {
                                divNo = '4';
                                OneImageClass = '';
                            }

                            var three_plus_attachments_counter_text = '';

                            if (attachmentLength > 6) {
                                var three_plus_attachments_counter = parseInt(attachmentLength) - 6;
                                three_plus_attachments_counter_text = '<div class="three_plus_attachments_counter">+' + three_plus_attachments_counter + '</div>';
                            }

                            if (attachmentLength != 0) {
                                var x1;
                                for (x1 in value.post_multiple_images) {

                                    var hideImgClass = (x1 > 5) ? 'hide' : '';

                                    var checkAttachmentType = (post_multiple_images[x1].type == 'photo') ? 'image' : 'video';

                                    if (checkAttachmentType == 'image'){
                                        var media_url=value.post_multiple_images[x1].media.image.src;
                                        //var media_url = 'https://picsum.photos/1200/768.jpg?image=251';
                                        $('#PublishedFacebookTab .post_' + index1 + ' .post_image_attached_container .row').append('' +
                                            '<div class="' + hideImgClass + ' image-show col-md-' + divNo + '">' +
                                            '<a href="' + media_url + '" data-gallery="facebook_gallery_'+value.post_id+'" data-toggle="lightbox">' +
                                            '<img class="img-responsive ' + OneImageClass + '" src="' + media_url + '">' +
                                            '</a>' +
                                            '</div>'
                                        );
                                    }
                                    else{

                                        var media_url=value.post_multiple_images[x1].media.image.src;
                                        var media_url_img = 'public/images/video_preview.jpg';
                                        $('#PublishedFacebookTab .post_' + index1 + ' .post_image_attached_container .row').append('' +
                                            '<div class="' + hideImgClass + ' image-show col-md-' + divNo + '">' +

                                            // '<a href="' + media_url + '" data-gallery="youtubevideos_'+value.post_id+'" data-toggle="lightbox" >' +
                                            // '<img class="img-responsive ' + OneImageClass + '" src="' + media_url_img + '">' +
                                            // '</a>' +

                                            '<video controls>\n' +
                                            '<source src="'+media_url+'" class="facebook_show_video_' + value.post_id + '">\n' +
                                            'Your browser does not support HTML5 video.\n' +
                                            '</video>' +

                                            '</div>'
                                        );

                                    }
                                }

                                if(attachmentLength>6){
                                    $('#PublishedFacebookTab .post_' + index1 + ' .image-show:eq(5) a').append(three_plus_attachments_counter_text);
                                    $('#PublishedFacebookTab .post_' + index1 + ' .image-show:eq(5) a img').css('opacity','0.5');
                                }

                                /*
                                var checkAttachmentType = (post_multiple_images[0].type == 'photo') ? 'image' : 'video';
                                console.log(checkAttachmentType);
                                if (checkAttachmentType == 'image') {
                                    var x1;
                                    for (x1 in value.post_multiple_images) {
                                        var hideImgClass = (x1 > 5) ? 'hide' : '';

                                        console.log(index1);
                                        var media_url=value.post_multiple_images[x1].media.image.src;
                                        //var media_url = 'https://picsum.photos/1200/768.jpg?image=251';
                                        $('#PublishedFacebookTab .post_' + index1 + ' .post_image_attached_container .row').append('' +
                                            '<div class="' + hideImgClass + ' image-show col-md-' + divNo + '">' +
                                            '<a href="' + media_url + '" data-gallery="example-gallery_'+value.post_id+'" data-toggle="lightbox" >' +
                                            '<img class="img-responsive ' + OneImageClass + '" src="' + media_url + '">' +
                                            '</a>' +
                                            '</div>'
                                        );
                                    }
                                    $('#PublishedFacebookTab .post_' + index1 + ' .image-show:last-child').prev().append(three_plus_attachments_counter_text);
                                }
                                else {
                                    var x1;
                                    for (x1 in value.post_multiple_images) {
                                        var hideImgClass = (x1 > 5) ? 'hide' : '';

                                        console.log(index1);
                                        var media_url=value.post_multiple_images[x1].media.image.src;
                                        //var media_url = 'http://techslides.com/demos/sample-videos/small.mp4';
                                        var media_url_img = 'public/images/video_preview.jpg';
                                        $('#PublishedFacebookTab .post_' + index1 + ' .post_image_attached_container .row').append('' +
                                            '<div class="' + hideImgClass + ' image-show col-md-' + divNo + '">' +
                                            '<a href="' + media_url + '" data-gallery="youtubevideos_'+value.post_id+'" data-toggle="lightbox" >' +
                                            '<img class="img-responsive ' + OneImageClass + '" src="' + media_url_img + '">' +
                                            '</a>' +
                                            '</div>'
                                        );
                                    }
                                    $('#PublishedFacebookTab .post_' + index1 + ' .image-show:last-child').prev().append(three_plus_attachments_counter_text);
                                }

                                */
                            }
                            // else {
                            //      $('#PublishedFacebookTab .post_' + index1 + ' .post_image_attached_container .row').empty();
                            // }

                        }
                    }

                    if(typeof(value.post_image)!='undefined' && typeof(value.post_video)!='undefined' && typeof(value.post_multiple_images)!='undefined'){
                        if(value.post_multiple_images.length==0 && value.post_image.length==0 && value.post_video.length==0){
                            var link_preview_container_element = $('#PublishedFacebookTab .post_' + index1 + ' .link_preview_container');
                            var post_image_attached_container_element = $('#PublishedFacebookTab .post_' + index1 + ' .post_image_attached_container');
                            loadPostLinkPreview(value.post_message,link_preview_container_element,post_image_attached_container_element);
                        }
                    }

                    if(typeof(value.post_url)!='undefined'){
                        if(value.post_url!=''){
                            $('#PublishedFacebookTab .post_'+index1+' .view_on_site_btn').removeClass('hide');
                            $('#PublishedFacebookTab .post_'+index1+' .view_on_site_btn').attr('href', value.post_url);
                        }
                        else{
                            // $('#PublishedFacebookTab .post_'+index1+' .view_on_site_btn').addClass('hide');
                            $('#PublishedFacebookTab .post_'+index1+' .view_on_site_btn').attr('href', 'https://facebook.com');
                        }
                    }
                    else{
                        $('#PublishedFacebookTab .post_'+index1+' .view_on_site_btn').attr('href', 'https://facebook.com');
                    }

                    if(typeof(value.post_likes)!='undefined'){
                        if(value.post_likes !=''){
                            $('#PublishedFacebookTab .post_'+index1+' .post_likes').removeClass('hide');
                            $('#PublishedFacebookTab .post_'+index1+' .post_likes_count').text(value.post_likes);
                        }
                    }

                    if(typeof(value.post_comments)!='undefined'){
                        if(value.post_comments!=''){
                            $('#PublishedFacebookTab .post_'+index1+' .post_comments').removeClass('hide');
                            $('#PublishedFacebookTab .post_'+index1+' .post_comments_count').text(value.post_comments);
                        }
                    }

                    index1++;
                });

            });
        }
        else
        {
            $("#PublishedFacebookTab .empty-posts").show();
        }
    }

    $(document).ready(function () {
        var baseUrl = $('#hfBaseUrl').val();

        var postsexist = $( "#PublishedFacebookTab .post_item" ).length;
        var FbTabIsActive = $('#PublishedFacebookImgTab').hasClass('active');

        // console.log(postsexist );
        if (postsexist > 0 && FbTabIsActive) {
            $('#PublishedFacebookTab').after('<button id="load-more" class="btn" style="display: block;margin: auto;margin-bottom:16px; color:white; background-color: #0B77C5;">Load More</button>');
        }
        $('#PublishedTwitterTabImgTab').click(function (e) {
            var TwitterTabIsActive = $('#PublishedTwitterTabImgTab').hasClass('active');
            if (TwitterTabIsActive) {
                $('#load-more').hide();
            }
        });
        $('#PublishedFacebookImgTab').click(function (e) {
            var FbTabIsActive = $('#PublishedFacebookImgTab').hasClass('active');
            if (FbTabIsActive) {
                $('#load-more').show();
            }
        });
        $('#load-more').click(function (e) {
            // e.preventDefault();
            $(this).html('<div class="loader"></div>');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                type: "post",
                url: baseUrl + "/next-social-posts",
                data: {
                    'limit': 3,
                    'after': $('#paging-after').val()
                }
            }).done(function (data) {
                $('#load-more').html('Load More');
                // console.log(data);
                if (data.socialMediaPostsData.published.Facebook.posts.after) {
                    var morePostsExist = 1;
                } else {
                    var morePostsExist = 0;
                }
                // console.log(data.socialMediaPostsData.published.Facebook.posts.after);
                if (data.socialMediaPostsData.published.Facebook.posts.after) {
                    $('#paging-after').val(data.socialMediaPostsData.published.Facebook.posts.after);
                }
                delete(data.socialMediaPostsData.published.Facebook.posts.after);
                // console.log('after-delete-after');
                // console.log(data.socialMediaPostsData.published.Facebook.posts);
                //  #PublishedFacebookTab find last .post_item first child class like post_ get number and assign to var index1 = number;
                var index1 = $( "#PublishedFacebookTab .post_item:last-child" ).children().attr("class").split(' ')[1].split('_')[1];
                $('html, body').animate({
                    scrollTop: $(".post_"+index1).offset().top
                }, 500);
                // console.log($(".post_"+index1).offset().top);
                publishFBData(data.socialMediaPostsData.published.Facebook.posts, index1);
                if (morePostsExist == 1) {
                    $('#load-more').show();
                } else if (morePostsExist == 0) {
                    $('#load-more').hide();
                    $('.empty-posts').hide();
                }
            }).fail(function (error) {
                // console.error(error);
            });
        });

    });


    // console.log(publishedTwitterPostsData);
    var publishedTwitterPostsDataArrCheck=Array.isArray(publishedTwitterPostsData);

    if(!publishedTwitterPostsDataArrCheck){
        var index2 = 0;
        Object.keys(publishedTwitterPostsData).forEach(function (key) {
            //var d = new Date(key);
            var d = key;
            var postDate=moment(d).format('YYYY-MM-DD');
            var currentDate=moment().format('YYYY-MM-DD');
            var yesterdayDate = moment().subtract(1, 'days').format('YYYY-MM-DD');
            var tommorowDate = moment().add(1, 'days').format('YYYY-MM-DD');
            var formated_published_post_date = '';

            if(postDate == currentDate){
                 formated_published_post_date='Today';
            }
            else if(postDate == yesterdayDate){
                 formated_published_post_date='Yesterday';
            }
            else if(postDate == tommorowDate){
                 formated_published_post_date='Tommorow';
            }
            else{
                 formated_published_post_date=moment(d).format('LL');
            }

            // $('#PublishedTwitterTab').append('<div class="post_time_header">'+formated_published_post_date+'</div>');

            var publishedPostsArr=publishedTwitterPostsData[key];
            $.each( publishedPostsArr, function( i, value ) {
                // var updated_at = new Date(value.updated_at);
                var post_time = moment(value.post_time);
                var formated_post_time=moment(post_time).format('hh:mm a')+' (EST)';

                $('#PublishedTwitterTab').append('' +
                    '<div class="post_item">\n' +
                    // '<div class="post_item_time_container">\n' +
                    // '<div class="post_item_time">' + formated_post_time +
                    // '<div class="dropdown posts_options_dropdown">\n' +
                    // '<button type="button" class="btn dropdown-toggle" data-toggle="dropdown">\n' +
                    // '<i class="fa fa-angle-down" aria-hidden="true"></i>\n' +
                    // '</button>\n' +
                    // '<ul class="dropdown-menu" role="menu" aria-labelledby="menu1">\n' +
                    // '<li data-post-id="'+value.post_id+'" data-type="facebook" role="presentation">\n' +
                    // '<a role="menuitem" tabindex="-1" class="view_on_site_btn">View on Site</a>\n' +
                    // '</li>\n' +
                    // '<li data-post-id="'+value.post_id+'" data-type="facebook" class="post_edit_btn" role="presentation">\n' +
                    // '<a role="menuitem" tabindex="-1" href="#">Edit</a>\n' +
                    // '</li>\n' +
                    // '<li data-post-id="'+value.post_id+'" data-type="facebook" class="post_delete_btn" role="presentation">\n' +
                    // '<a role="menuitem" tabindex="-1" href="#">Delete</a>\n' +
                    // '</li>\n' +
                    // '</ul>\n' +
                    // '</div>\n' +
                    // '</div>\n' +
                    // '</div>\n' +
                    '<div class="post_content_container post_' + index2 + '">\n' +

                    '<div class="post_time_header">Posted at '+formated_published_post_date + ' ' + formated_post_time +' </div>' +

                    '<div class="post_content_body"><span class="more"></span></div>\n' +

                    '<div class="post_image_attached_container"><div class="row no-gutter"></div></div>'+

                    '<div class="link_preview_container hide"></div>'+

                    '<div class="post_content_footer">\n' +

                    // '<div class="posts_likes_comments_container">'+
                    // '<div class="post_likes"><img src="public/images/like_post.png"> <span class="post_likes_count">0</span></div>'+
                    // '<div class="post_comments"><img src="public/images/comment_post.png"> <span class="post_comments_count">0</span></div>'+
                    // '</div>'+
                    '<div class="posts_options_btn_container">'+
                    // '<a type="button" target="_blank" class="btn view_on_site_btn">View on Site</a>'+
                    // '<button type="button" data-post-id="'+value.post_id+'" data-type="facebook" class="btn post_edit_btn">Edit</button>\n' +
                    // '<button type="button" data-post-id="'+value.post_id+'" data-type="facebook" class="btn post_delete_btn">Delete</button>\n' +
                    '</div>'+

                    '</div>\n' +
                    '</div>\n' +
                    '</div>');

                if(typeof(value.post_message)!='undefined'){
                    $('#PublishedTwitterTab .post_'+index2+' .post_content_body .more').html(createTextLinks(value.post_message));
                    showMoreLessPlugin('#PublishedTwitterTab .post_'+index2+' .post_content_body');
                }

                // if(typeof(value.post_image)!='undefined'){
                //     var post_image_arr=value.post_image;
                //     var checkArr=Array.isArray(post_image_arr);
                //     if(checkArr){
                //         var x1;
                //         for (x1 in checkArr) {
                //             var media_url=checkArr[x1];
                //             $('#PublishedTwitterTab .post_'+index2+' .post_image_attached_container .row').append( '' +
                //                 '<div class="image-show col-md-12">' +
                //                 '<a href="'+media_url+'" data-gallery="twitter_gallery_'+value.post_id+'" data-toggle="lightbox" >' +
                //                 '<img class="img-responsive oneImage" src="'+media_url+'">' +
                //                 '</a>' +
                //                 '</div>'
                //             );
                //         }
                //     }
                // }

                if(typeof(value.post_video)!='undefined'){
                    var post_video_media_url=value.post_video;
                    if(post_video_media_url!=''){
                        $('#PublishedTwitterTab .post_' + index2 + ' .post_image_attached_container .row').append('' +
                            '<div class="image-show col-md-12">' +
                            '<video controls>\n' +
                            '<source src="'+post_video_media_url+'" class="twitter_show_video_' + value.post_id + '">\n' +
                            'Your browser does not support HTML5 video.\n' +
                            '</video>' +
                            '</div>'
                        );
                    }
                }

                if(typeof(value.post_image)!='undefined') {
                    var post_multiple_images=value.post_image;
                    var checkArr=Array.isArray(post_multiple_images);
                    if(checkArr){
                        var attachmentLength = post_multiple_images.length;
                        var OneImageClass = '';
                        if (attachmentLength == 1) {
                            var divNo = '12';
                            OneImageClass = 'oneImage';
                        }
                        else if (attachmentLength == 2) {
                            var divNo = '6';
                            OneImageClass = '';
                        }
                        else if (attachmentLength == 3) {
                            var divNo = '4';
                            OneImageClass = '';
                        }
                        else if (attachmentLength == 4) {
                            var divNo = '3';
                            OneImageClass = '';
                        }
                        else if (attachmentLength > 4) {
                            var divNo = '4';
                            OneImageClass = '';
                        }

                        if (attachmentLength > 6) {
                            var three_plus_attachments_counter = parseInt(attachmentLength) - 6;
                            var three_plus_attachments_counter_text = '<div class="three_plus_attachments_counter">+' + three_plus_attachments_counter + '</div>';
                        }
                        else {
                            var three_plus_attachments_counter_text = '';
                        }

                        if (attachmentLength != 0) {
                            var x1;
                            for (x1 in value.post_image) {

                                var hideImgClass = (x1 > 5) ? 'hide' : '';
                                var media_url = value.post_image[x1];
                                $('#PublishedTwitterTab .post_' + index2 + ' .post_image_attached_container .row').append('' +
                                    '<div class="' + hideImgClass + ' image-show col-md-' + divNo + '">' +
                                    '<a href="' + media_url + '" data-gallery="twitter_gallery_' + value.post_id + '" data-toggle="lightbox" >' +
                                    '<img class="img-responsive ' + OneImageClass + '" src="' + media_url + '">' +
                                    '</a>' +
                                    '</div>'
                                );


                            }
                            if (attachmentLength > 6) {
                                $('#PublishedTwitterTab .post_' + index2 + ' .image-show:eq(5) a').append(three_plus_attachments_counter_text);
                                $('#PublishedTwitterTab .post_' + index2 + ' .image-show:eq(5) a img').css('opacity','0.5');
                            }
                        }
                        // else {
                        //     $('#PublishedTwitterTab .post_' + index2 + ' .post_image_attached_container .row').empty();
                        // }
                    }
                }

                if(typeof(value.post_image)!='undefined' && typeof(value.post_video)!='undefined'){
                    if(value.post_image.length==0 && value.post_video.length==0){
                        var link_preview_container_element = $('#PublishedTwitterTab .post_' + index2 + ' .link_preview_container');
                        var post_image_attached_container_element = $('#PublishedTwitterTab .post_' + index2 + ' .post_image_attached_container');
                        loadPostLinkPreview(value.post_message,link_preview_container_element,post_image_attached_container_element);
                    }
                }

                // if(typeof(value.post_url)!='undefined'){
                //     if(value.post_url!=''){
                //         $('#PublishedTwitterTab .post_'+index2+' .view_on_site_btn').removeClass('hide');
                //         $('#PublishedTwitterTab .post_'+index2+' .view_on_site_btn').attr('href', value.post_url);
                //     }
                //     else{
                //         $('#PublishedTwitterTab .post_'+index2+' .view_on_site_btn').addClass('hide');
                //         $('#PublishedTwitterTab .post_'+index2+' .view_on_site_btn').attr('href', '');
                //     }
                // }
                // else{
                //     $('#PublishedTwitterTab .post_'+index2+' .view_on_site_btn').addClass('hide');
                //     $('#PublishedTwitterTab .post_'+index2+' .view_on_site_btn').attr('href', '');
                // }

                //
                // if(value.post_likes!=''){
                //     $('#PublishedTwitterTab .post_'+index2+' .post_likes').removeClass('hide');
                //     $('#PublishedTwitterTab .post_'+index2+' .post_likes_count').text(value.post_likes);
                // }
                // else{
                //     $('#PublishedTwitterTab .post_'+index2+' .post_likes').addClass('hide');
                //     $('#PublishedTwitterTab .post_'+index2+' .post_likes_count').text('');
                // }
                //
                // if(value.post_comments!=''){
                //     $('#PublishedTwitterTab .post_'+index2+' .post_comments').removeClass('hide');
                //     $('#PublishedTwitterTab .post_'+index2+' .post_comments_count').text(value.post_comments);
                // }
                // else{
                //     $('#PublishedTwitterTab .post_'+index2+' .post_comments').addClass('hide');
                //     $('#PublishedTwitterTab .post_'+index2+' .post_comments_count').text('');
                // }

                index2++;
            });

        });
    }


    // console.log(publishedLinkedInPostsData);
    var publishedLinkedInPostsDataArrCheck=Array.isArray(publishedLinkedInPostsData);

    if(!publishedLinkedInPostsDataArrCheck){
        var index3 = 0;
        Object.keys(publishedLinkedInPostsData).forEach(function (key) {
            //var d = new Date(key);
            var d = key;
            var postDate=moment(d).format('YYYY-MM-DD');
            var currentDate=moment().format('YYYY-MM-DD');
            var yesterdayDate = moment().subtract(1, 'days').format('YYYY-MM-DD');
            var tommorowDate = moment().add(1, 'days').format('YYYY-MM-DD');

            if(postDate==currentDate){
                var formated_published_post_date='Today';
            }
            else if(postDate==yesterdayDate){
                var formated_published_post_date='Yesterday';
            }
            else if(postDate==tommorowDate){
                var formated_published_post_date='Tommorow';
            }
            else{
                var formated_published_post_date=moment(d).format('LL');
            }

            $('#PublishedLinkedInTab').append('<div class="post_time_header">'+formated_published_post_date+'</div>');

            var publishedPostsArr=publishedLinkedInPostsData[key];
            $.each( publishedPostsArr, function( i, value ) {
                // var updated_at = new Date(value.updated_at);
                var post_time = moment(value.post_time);
                var formated_post_time=moment(post_time).format('hh:mm a')+' (EST)';

                $('#PublishedLinkedInTab').append('' +
                    '<div class="post_item">\n' +
                    '<div class="post_item_time_container">\n' +
                    '<div class="post_item_time">' + formated_post_time +
                    // '<div class="dropdown posts_options_dropdown">\n' +
                    // '<button type="button" class="btn dropdown-toggle" data-toggle="dropdown">\n' +
                    // '<i class="fa fa-angle-down" aria-hidden="true"></i>\n' +
                    // '</button>\n' +
                    // '<ul class="dropdown-menu" role="menu" aria-labelledby="menu1">\n' +
                    // '<li data-post-id="'+value.post_id+'" data-type="facebook" role="presentation">\n' +
                    // '<a role="menuitem" tabindex="-1" class="view_on_site_btn">View on Site</a>\n' +
                    // '</li>\n' +
                    // '<li data-post-id="'+value.post_id+'" data-type="facebook" class="post_edit_btn" role="presentation">\n' +
                    // '<a role="menuitem" tabindex="-1" href="#">Edit</a>\n' +
                    // '</li>\n' +
                    // '<li data-post-id="'+value.post_id+'" data-type="facebook" class="post_delete_btn" role="presentation">\n' +
                    // '<a role="menuitem" tabindex="-1" href="#">Delete</a>\n' +
                    // '</li>\n' +
                    // '</ul>\n' +
                    // '</div>\n' +
                    '</div>\n' +
                    '</div>\n' +
                    '<div class="post_content_container post_' + index3 + '">\n' +
                    '<div class="post_content_body"><span class="more"></span></div>\n' +
                    '<div class="post_image_attached_container"><div class="row no-gutter"></div></div>'+
                    '<div class="post_content_footer">\n' +

                    // '<div class="posts_likes_comments_container">'+
                    // '<div class="post_likes"><img src="public/images/like_post.png"> <span class="post_likes_count">0</span></div>'+
                    // '<div class="post_comments"><img src="public/images/comment_post.png"> <span class="post_comments_count">0</span></div>'+
                    // '</div>'+
                    '<div class="posts_options_btn_container">'+
                    // '<a type="button" target="_blank" class="btn view_on_site_btn">View on Site</a>'+
                    // '<button type="button" data-post-id="'+value.post_id+'" data-type="facebook" class="btn post_edit_btn">Edit</button>\n' +
                    // '<button type="button" data-post-id="'+value.post_id+'" data-type="facebook" class="btn post_delete_btn">Delete</button>\n' +
                    '</div>'+

                    '</div>\n' +
                    '</div>\n' +
                    '</div>');

                if(typeof(value.post_message)!='undefined'){
                    $('#PublishedLinkedInTab .post_'+index3+' .post_content_body .more').html(createTextLinks(value.post_message));
                    showMoreLessPlugin('#PublishedLinkedInTab .post_'+index3+' .post_content_body');
                }

                // if(typeof(value.post_image)!='undefined'){
                //     var post_image_arr=value.post_image;
                //     var checkArr=Array.isArray(post_image_arr);
                //     if(checkArr){
                //         var x1;
                //         for (x1 in checkArr) {
                //             var media_url=checkArr[x1];
                //             $('#PublishedLinkedInTab .post_'+index3+' .post_image_attached_container .row').append( '' +
                //                 '<div class="image-show col-md-12">' +
                //                 '<a href="'+media_url+'" data-gallery="gallery_'+value.post_id+'" data-toggle="lightbox" >' +
                //                 '<img class="img-responsive oneImage" src="'+media_url+'">' +
                //                 '</a>' +
                //                 '</div>'
                //             );
                //         }
                //     }
                // }

                // if(typeof(value.post_video)!='undefined'){
                //     var post_video_media_url=value.post_video;
                //     if(post_video_media_url!=''){
                //         $('#PublishedLinkedInTab .post_' + index3 + ' .post_image_attached_container .row').append('' +
                //             '<div class="image-show col-md-12">' +
                //             '<video controls>\n' +
                //             '<source src="'+post_video_media_url+'" class="show_video_' + value.post_id + '">\n' +
                //             'Your browser does not support HTML5 video.\n' +
                //             '</video>' +
                //             '</div>'
                //         );
                //     }
                // }
                //
                //
                // if(typeof(value.post_image)!='undefined') {
                //     var post_multiple_images=value.post_image;
                //     var checkArr=Array.isArray(post_multiple_images);
                //     if(checkArr){
                //         var attachmentLength = post_multiple_images.length;
                //         var OneImageClass = '';
                //         if (attachmentLength == 1) {
                //             var divNo = '12';
                //             OneImageClass = 'oneImage';
                //         }
                //         else if (attachmentLength == 2) {
                //             var divNo = '6';
                //             OneImageClass = '';
                //         }
                //         else if (attachmentLength == 3) {
                //             var divNo = '4';
                //             OneImageClass = '';
                //         }
                //         else if (attachmentLength == 4) {
                //             var divNo = '3';
                //             OneImageClass = '';
                //         }
                //         else if (attachmentLength > 4) {
                //             var divNo = '4';
                //             OneImageClass = '';
                //         }
                //
                //         if (attachmentLength > 6) {
                //             var three_plus_attachments_counter = parseInt(attachmentLength) - 6;
                //             var three_plus_attachments_counter_text = '<div class="three_plus_attachments_counter">+' + three_plus_attachments_counter + '</div>';
                //         }
                //         else {
                //             var three_plus_attachments_counter_text = '';
                //         }
                //
                //         if (attachmentLength != 0) {
                //             var x1;
                //             for (x1 in value.post_image) {
                //
                //                 var hideImgClass = (x1 > 5) ? 'hide' : '';
                //                 console.log(index3);
                //
                //                 var media_url = value.post_image[x1];
                //                 $('#PublishedLinkedInTab .post_' + index3 + ' .post_image_attached_container .row').append('' +
                //                     '<div class="' + hideImgClass + ' image-show col-md-' + divNo + '">' +
                //                     '<a href="' + media_url + '" data-gallery="gallery_' + value.post_id + '" data-toggle="lightbox" >' +
                //                     '<img class="img-responsive ' + OneImageClass + '" src="' + media_url + '">' +
                //                     '</a>' +
                //                     '</div>'
                //                 );
                //
                //
                //             }
                //             $('#PublishedLinkedInTab .post_' + index3 + ' .image-show:last-child').prev().append(three_plus_attachments_counter_text);
                //         }
                //     }
                // }
                //
                // if(typeof(value.post_url)!='undefined'){
                //     if(value.post_url!=''){
                //         $('#PublishedLinkedInTab .post_'+index3+' .view_on_site_btn').removeClass('hide');
                //         $('#PublishedLinkedInTab .post_'+index3+' .view_on_site_btn').attr('href', value.post_url);
                //     }
                //     else{
                //         $('#PublishedLinkedInTab .post_'+index3+' .view_on_site_btn').addClass('hide');
                //         $('#PublishedLinkedInTab .post_'+index3+' .view_on_site_btn').attr('href', '');
                //     }
                // }
                // else{
                //     $('#PublishedLinkedInTab .post_'+index3+' .view_on_site_btn').addClass('hide');
                //     $('#PublishedLinkedInTab .post_'+index3+' .view_on_site_btn').attr('href', '');
                // }

                //
                // if(value.post_likes!=''){
                //     $('#PublishedLinkedInTab .post_'+index3+' .post_likes').removeClass('hide');
                //     $('#PublishedLinkedInTab .post_'+index3+' .post_likes_count').text(value.post_likes);
                // }
                // else{
                //     $('#PublishedLinkedInTab .post_'+index3+' .post_likes').addClass('hide');
                //     $('#PublishedLinkedInTab .post_'+index3+' .post_likes_count').text('');
                // }
                //
                // if(value.post_comments!=''){
                //     $('#PublishedLinkedInTab .post_'+index3+' .post_comments').removeClass('hide');
                //     $('#PublishedLinkedInTab .post_'+index3+' .post_comments_count').text(value.post_comments);
                // }
                // else{
                //     $('#PublishedLinkedInTab .post_'+index3+' .post_comments').addClass('hide');
                //     $('#PublishedLinkedInTab .post_'+index3+' .post_comments_count').text('');
                // }

                index3++;
            });

        });
    }
});

