function convertToValueWithCommas(e) {
    var t = e.toString().split(".");
    return t[0] = t[0].replace(/\B(?=(\d{3})+(?!\d))/g, ","), t.join(".")
}

function loadArticleLinkPreview(link, element, link_preview_date, articleTitle) {
    if (typeof (link) == 'undefined' || link == null || link == 'null') {
        return false;
    }

    // console.log(link_preview_date);

    var baseUrl = $('#hfBaseUrl').val();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },
        type: 'POST',
        url: baseUrl + '/generateLinkPreview',
        data: {
            link: link
        },
        success: function (result) {
            var json = $.parseJSON(result);
            // console.log(json);

            element.find('.loader').addClass('hide');

            if ('error' in json) {
                // element.prepend('' +
                //     '<div class="link_preview_container">\n' +
                //     '<div class="link_preview_details_container">\n' +
                //     '<p class="link_preview_name" title="' + articleTitle + '">' + articleTitle + '</p>\n' +
                //     '<p class="link_preview_date">' + link_preview_date + '</p>' +
                //     '<p class="link_preview_address"></p>\n' +
                //     '</div>\n' +
                //     '</div>\n'
                // );
                //element.find('.link_preview_address').append(' <a target="_blank" href="' + link + '">Read full article</a>');
            }
            else {
                element.find('.link_preview_container').remove();

                var title = json.title;
                var description = json.description;
                var image = json.image;

                if (image != '') {
                    var imageDiv = '' +
                        '<div class="link_preview_image_container">' +
                        '<img class="link_preview_img" src="' + image + '">' +
                        '</div>';
                }
                else {
                    var imageDiv = '';
                }

                element.prepend('' +
                    '<div class="link_preview_container">\n' +
                    imageDiv +
                    '<div class="link_preview_details_container">\n' +
                    '<p class="link_preview_name" title="' + title + '">' + title + '</p>\n' +
                    '<p class="link_preview_date">' + link_preview_date + '</p>' +
                    '<p class="link_preview_address">' + description + '</p>\n' +
                    '</div>\n' +
                    '</div>\n'
                );
                element.find('.link_preview_address').append(' <a target="_blank" href="' + link + '">Read full article</a>');
            }
        },
        error: function () {
            element.find('.loader').addClass('hide');
            // element.prepend('' +
            //     '<div class="link_preview_container">\n' +
            //     '<div class="link_preview_details_container">\n' +
            //     '<p class="link_preview_name" title="' + articleTitle + '">' + articleTitle + '</p>\n' +
            //     '<p class="link_preview_date">' + link_preview_date + '</p>' +
            //     '<p class="link_preview_address"></p>\n' +
            //     '</div>\n' +
            //     '</div>\n'
            // );
            //element.find('.link_preview_address').append(' <a target="_blank" href="' + link + '">Read full article</a>');
        }
    });

}

$(function() {

    $('#add_video_demo_btn').addClass('disabled').attr('disabled','disabled');
    $('span.add-video-btn-demo-disabled-tooltip').tooltip('destroy');
    setTimeout(function () {
        $("span.add-video-btn-demo-disabled-tooltip").tooltip({
            placement : 'top',
            title: "Uploading video will be available soon."
        });
    },200);

    $("#search_for").on("keyup", function(event) {
        // Cancel the default action, if needed
        event.preventDefault();
        // Number 13 is the "Enter" key on the keyboard
        if (event.keyCode === 13) {
            // Trigger the button element with a click
            $(".search-fetch").click();
        }
    });

    $('.selectpicker').selectpicker();

    $('#article_type').multiselect({
        includeSelectAllOption: true,
        selectAllText: 'SELECT ALL',
        allSelectedText: 'All Content',
        nonSelectedText: 'Content Type',
        selectAllNumber: false,
        buttonText: function(options, select) {
            return options.length == 5 ? 'All Content':'Content Type';
        }
    });

    // Content Research Search Form Changes //

    // $('#article_type').on('loaded.bs.select', function (e) {
    //     //if($('.article_type_group').find('.dropdown-toggle').attr('title') == '5 items selected') {
    //         $('.article_type_group').find('.filter-option').text('Content Type');
    //     //}
    // });
    // $('#article_type').on('changed.bs.select', function (e) {
    //     //if($('.article_type_group').find('.dropdown-toggle').attr('title') == '5 items selected') {
    //         $('.article_type_group').find('.filter-option').text('Content Type');
    //     //}
    // });
    // $('#article_type').on('rendered.bs.select', function (e) {
    //     //if($('.article_type_group').find('.dropdown-toggle').attr('title') == '5 items selected') {
    //         $('.article_type_group').find('.filter-option').text('Content Type');
    //     //}
    // });

    $('.search-fetch').click(function(e)
    {
        $('.alert.alert-danger').hide();

        var searchFor = $('#search_for').val();
        var articles = $('#article_type').val();
        var errorClass = $('.query-missing-error');
        var errorMessage = $('.error-message');
        var status = false;

        searchFor = searchFor.trim();

        if(searchFor === '')
        {
            status = false;
            errorClass.show();
            return status;
        }
        else
        {
            status = true;
            errorClass.hide();
        }

        if(!articles || articles.length == 0)
        {
            status = false;
            errorMessage.show();
            return status;
        }
        else
        {
            status = true;
            errorMessage.hide();
        }


        var baseUrl = $('#hfBaseUrl').val();

        $('.web-loader').css('display', 'table');
        //$('.custom-table tbody').hide();

        var articlesQuery = '';

        $.each(articles, function (index, value) {
            if(index >= 1) {
                articlesQuery += ',';
            }
            articlesQuery += value;
        });

        $('.content-research-results').empty();
        $('.total_records').addClass('hide');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            type: "POST",
            url: baseUrl + "/done-me",
            data: {
                'send': 'content-research',
                'article_type': articlesQuery,
                'num_days': $('#num_days').val(),
                'q': searchFor
            }
        }).done(function (result) {
            $('.icon-refresh').hide();
            // parse data into json
            var json = $.parseJSON(result);
            // console.log(json);

            // get data
            var statusCode = json.status_code;
            var statusMessage = json.status_message;

            $('.web-loader').hide();
            $('.alert.alert-danger').hide();
            var contentResearchResults = $('.content-research-results');

            if(statusCode === 200)
            {
                var data = json.data;
                var fbShares = 0;
                var lShares = 0;
                var tShares = 0;
                var ptShares = 0;
                var totalShares = 0;
                var article_url = '';
                var website='';
                var date='';

                var preview_title='';
                var preview_description = '';
                var preview_image='';

                // $.each(data, function (index, value) {
                //
                //     fbShares = (value.facebook_share) ? value.facebook_share : 0;
                //     lShares = (value.linkedin_share) ? value.linkedin_share : 0;
                //     tShares = (value.twitter_share) ? value.twitter_share : 0;
                //     ptShares = (value.pinterest_share) ? value.pinterest_share : 0;
                //
                //     totalShares = fbShares + lShares + tShares + ptShares;
                //
                //     html += '<tr sort-attribute="'+fbShares+'">';
                //
                //     html += '<td width="300">';
                //     html += '<div  style="width: 280px;" class="description_ellipsis row_ellipsis tooltip-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="' + value.title + '">' + value.title + '</div>';
                //     html += '<div class="text-muted">'+ value.date +'</div>';
                //     html += '<div class="website_url_ellipsis row_ellipsis" style="width: 160px;"> <a href="'+value.article_url+'" class="tooltip-info" target="_blank">'+value.article_url+'</a></div>';
                //     html += '</td>';
                //
                //     html += '<td>';
                //     html += '<h3>'+fbShares+'<br><span class="text-muted">Shares</span></h3>';
                //     html += '</td>';
                //
                //     html += '<td>';
                //     html += '<h3>'+lShares+'<br><span class="text-muted">Shares</span></h3>';
                //     html += '</td>';
                //
                //     html += '<td>';
                //     html += '<h3>'+tShares+'<br><span class="text-muted">Shares</span></h3>';
                //     html += '</td>';
                //
                //     html += '<td>';
                //     html += '<h3>'+ptShares+'<br><span class="text-muted">Shares</span></h3>';
                //     html += '</td>';
                //
                //     html += '<td>';
                //     html += '<h3>'+totalShares+'<br><span class="text-muted">Shares</span></h3>';
                //     html += '</td>';
                //
                //     html += '<td>';
                //     html += '<div class="action-column">';
                //     html += '<button type="button" class="btn btn-info btn-outline btn-circle tooltip-info share-me" data-toggle="tooltip" data-placement="top" data-href="'+value.article_url+'" title="Share on your <br> Facebook Page">';
                //     html += '<i class="mdi mdi-share-variant"></i>';
                //     html += '</button>';
                //     html += '</div>';
                //     html += '</td>';
                //
                //     html += '</tr>';
                // });

                $('.content-research-results').empty();

                $('.total_records').removeClass('hide');
                $('.total_records_count').text(data.length);

                $.each(data, function (index, value) {
                    fbShares = (value.facebook_share) ? value.facebook_share : 0;
                    lShares = (value.linkedin_share) ? value.linkedin_share : 0;
                    tShares = (value.twitter_share) ? value.twitter_share : 0;
                    //ptShares = (value.pinterest_share) ? value.pinterest_share : 0;

                    totalShares = fbShares + lShares + tShares + ptShares;

                    article_url=value.article_url;
                    website=value.website;
                    date=value.date;
                    var title=value.title;

                    preview_title=value.preview_title;
                    preview_description=value.preview_description;
                    preview_image=value.preview_image;

                    var articleURL='';
                    if(typeof(article_url)!='undefined'){
                        articleURL=' <a target="_blank" href="' + article_url + '">Read full article</a>';
                    }

                    if($.trim(preview_title)!=''){
                        title=preview_title;
                    }

                    var description = '';
                    if($.trim(preview_description)!=''){
                        description=preview_description;
                    }

                    var imageDiv = '';
                    if (preview_image != '') {
                        imageDiv = '' +
                            '<div class="link_preview_image_container">' +
                            '<img class="link_preview_img" onerror="onImageLoadError(this)" src="' + preview_image + '">' +
                            '</div>';
                    }

                    var websiteName='';
                    if(typeof(website)!='undefined'){
                        websiteName=website;
                    }

                    var articleDate='';
                    if(typeof(date)!='undefined'){
                        articleDate=' - ' + moment(date).format('LL');
                    }

                    var link_preview_date=websiteName+articleDate;
                    // console.log(link_preview_date);

                    var html = '<div class="result-item item_'+index+'">\n'+
                        '<div class="link_preview_container">\n' +

                        imageDiv+
                        '<div class="link_preview_details_container">\n' +
                        '<p class="link_preview_name" title="' + title + '">' + title + '</p>\n' +
                        '<p class="link_preview_date">' + link_preview_date + '</p>' +
                        '<p class="link_preview_address">'+ description + articleURL +'</p>\n' +
                        '</div>\n' +

                        '</div>\n'+

                        '<div class="post_content_footer">\n' +

                        '<div class="row">\n' +

                            '<div class="col-md-6">\n' +

                                '<div class="social-status">\n' +

                                    '<div class="total_shares s-stats">\n' +
                                    '<label>Total Shares</label>\n' +
                                    '<h3>'+convertToValueWithCommas(totalShares)+'</h3>\n' +
                                    '</div>\n' +

                                    '<div class="facebook_shares s-stats">\n' +
                                    '<img src="'+baseUrl+'/public/images/icons/facebook-widget.png">\n' +
                                    '<h3>'+convertToValueWithCommas(fbShares)+'</h3>\n' +
                                    '</div>\n' +

                                    '<div class="twitter_shares s-stats">\n' +
                                    '<img src="'+baseUrl+'/public/images/icons/twitter-widget.png">\n' +
                                    '<h3>'+convertToValueWithCommas(tShares)+'</h3>\n' +
                                    '</div>\n' +

                                // social-status
                                '</div>\n' +

                            // md-6
                            '</div>\n' +

                            '<div class="col-md-6">\n' +

                                '<div class="inline_btn">\n' +
                                    '<button class="share_as_post_btn">Share as a Post</button>\n' +
                                '</div>\n' +

                            // md-6
                            '</div>\n' +

                        '</div>\n' +

                        '</div>\n' +

                        '</div>';

                    contentResearchResults.append(html);

                    // var element=$('.content-research-results .result-item.item_'+index);
                    // loadArticleLinkPreview( article_url, element, link_preview_date, title);
                });
            }
            else
            {
                $('.alert.alert-danger').show();
                $('.alert.alert-danger').html('<p class="response-message m-t-10">'+statusMessage+'</p>');
            }

        });
    });
});

$(document.body).on('click', ".share-me", function () {
    var hrefToShare = $(this).attr('data-href');

    if(hrefToShare !== '')
    {
        FB.ui({
            method: 'share',
            display: 'popup',
            href: hrefToShare
        }, function (response) {
            if(response)
            {
                swal({
                    title: "Successful!",
                    text: 'Content has been posted.',
                    type: "success"
                }, function () {});
            }

        });
    }
});

$(document).on('click',".share_as_post_btn",function (e) {
    var baseUrl = $('#hfBaseUrl').val();

    if(socialMediaPostsData.length == 0){
        swal({
            title: "",
            // text: 'Unable to share content. You have no Social Media account connected. Connect your accounts now.',
            text: 'Unable to share content. Connect your social media accounts.',
            type: 'error',
            allowOutsideClick: false,
            html: true
        }, function (isConfirm) {
            swal.close();
            setTimeout(function () {
                showPreloader();

                location.href = baseUrl+'/social-posts';
            },100);
        });
        return false;
    }

    var yesterdayDate = new Date();
    yesterdayDate.setDate(yesterdayDate.getDate());

    // $('#scheduled_datepicker').data("DateTimePicker").destroy();
    // $('#scheduled_datepicker').datetimepicker({
    //     format: 'YYYY-MM-DD',
    //     minDate: yesterdayDate,
    //     inline: true,
    //     sideBySide: true
    // });

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

    $('.send_post_options li').removeClass('selected_post_option');
    $('#post_now_btn').text('Post Now').attr('rel','post_now');
    $('#post_now_btn').removeAttr('data-post-id');

    var article_url=$(this).closest('.result-item').find('.link_preview_address a').attr('href');
    // console.log(article_url);
    if(typeof(article_url)!='undefined'){
        $('#post_content_body').val(article_url);
        // generateLinkPreviewPaste();

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
    }

    $('#add_post_modal').modal('show');
});
