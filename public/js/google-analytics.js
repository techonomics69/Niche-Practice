// $(window).load(function(){
$(document).ready(function(){
    console.log('caaling');
    setTimeout(function () {
        console.log('caaling');
        runAuthAction();
    }, 400);
});

$(document.body).on('click', '.connect-analytics' ,function() {
    var id = 'google-analytics-oauth';
    var baseUrl = $('#hfBaseUrl').val();
    window.appName = $('#appName').val();
    // console.log(window.appName);
    var mainModel = $('#main-modal');
    $(".modal-body, .modal-footer, .validate-me", mainModel).remove();
    $(mainModel).removeClass('welcome-process');
    $(mainModel).addClass('google-analytics');
    var html = '';

    html += '<div class="modal-body">'
    html += '<div class="OAuth-modal-body">';
    html += '<div class="auth-logo"><img src="'+baseUrl+'/public/images/gogleanalytics.png" alt=""></div>';
    html += '<h3 style="color:#fb8c00;">Sign In to Google Analytics</h3>';
    html += '<div> <h4> Sign in to your Google Analytics account to authorize '+window.appName+'. <br> Once authorized, you will be able to: </h4> <ul> <li>View Google Analytics data related to your website on the '+window.appName+' app.</li> </ul> </div>';
    html += '<div class="form-group"> <button type="button" id="loginGoogleAnalytics" class="btn btn-google-analytics"><i class="fa fa-google" aria-hidden="true"></i>  Sign In to Google Analytics </button> </div>';
    html += '</div>';
    html += '</div>';

    // loadModal(id);
    // $('.modal-body', '#'+id).html(html);
    $(mainModel).modal('show');
    $(mainModel).find('.modal-header').after(html);
    // enableAuthLogin();
});
$(document.body).on('click', '#loginGoogleAnalytics' ,function() {
// $('#loginGoogleAnalytics').click(function () {
    var baseUrl = $('#hfBaseUrl').val();

    var actionApiUrl = $('#actionApiUrl').val();
    showPreloader();

    location.href = baseUrl + '/google-analytics/get-login';
});
// function enableAuthLogin() {
//     /**
//      * oauth process begin to login with google account.
//      */
//     $('#loginGoogleAnalytics').click(function () {
//         var baseUrl = $('#hfBaseUrl').val();
//
//         var actionApiUrl = $('#actionApiUrl').val();
//         showPreloader();
//
//         location.href = baseUrl + '/google-analytics/get-login';
//     });
// }

function runAuthAction()
{
    var accessToken = $('#accessToken').val();
    var accessing = $('#accessToken').attr("data-type");
    var mainModel = $('#main-modal');
    if(accessToken == 1 && accessing == 'googleanalytics')
    {
        var baseUrl = $('#hfBaseUrl').val();
        var actionType = 'facebook';
        var id = 'analytics-account-selector';

        $(".modal-body, .modal-footer, .validate-me", mainModel).remove();
        $(mainModel).removeClass('welcome-process');
        $(mainModel).addClass('google-analytics');

        $('#actionRequest').val(actionType);

        var html = '';
        html += '<div class="suggestion-container">';
        html += '<div class="alert" style="display: none;"></div>';
        html += '<div class="page-content" style="min-height: 250px;">';
        html += '<h3 class="suggestion-title"></h3>';
        html += '<h4 class="alert-content" style="font-size: 16px; display: none;"></h4>';

        html += '<div class="suggest-list"></div>';

        html += '</div>';

        html += '</div>';

        // loadModal(id);
        $(mainModel).modal('show');
        $(".modal-header").after(html);

        // $('.modal-body', '#'+id).html(html);

        var analyticsBody = $('.suggestion-container');

        analyticsBody.prepend('<h3 class="processing-message">Retrieving Google Analytics Accounts.</h3>');

        var formData = false;
        if (window.FormData) formData = new FormData();

        formData.append('accessToken', accessToken);
        formData.append('send', 'analytics-views');

        analyticsConnector(formData);
        // analyticsConnector(accessToken);
    }
}

function analyticsConnector(formData, accountStep)
{
    console.log('formData');
    console.log(formData);
    showPreloader();

    var baseUrl = $('#hfBaseUrl').val();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },
        type: "POST",
        // url: baseUrl + "/google-analytics/analytics-views",
        url: baseUrl + "/done-me",
        contentType: false,
        cache: false,
        processData: false,
        data: formData
        // data:
        //     {
        //         accessToken: formData
        //     }
    }).done(function (result) {
        // parse data into json
        // console.log('i m done');
        var json = $.parseJSON(result);
        // console.log('json');
        // console.log(json);

        // get data
        var statusCode = json.status_code;
        var statusMessage = json.status_message;
        var data = json.data;

        var count = json.totalCount;
        var websiteGoogleAnalytics = data.websiteGoogleAnalytics;
        var insightStatus = '';
        if(data.insightStatus){
            insightStatus = data.insightStatus;
        }
        var abc = '';
        if(data.insightTitle){
            abc = data.insightTitle;
        }
        var insightTitle = '';
        if(abc){
            insightTitle = abc.replace(/(<|&lt;)br\s*\/*(>|&gt;)/g,' ');
        }

        var notificationClass = '';
        if(insightStatus === 'down')
        {
            notificationClass = 'danger';
        }
        else if(insightStatus === 'average')
        {
            notificationClass = 'warning';
            $('.review-status').html(insightTitle);
        }
        else if(insightStatus)
        {
            notificationClass = 'success';
        }
        // console.log('data data data');
        // console.log(data);
        // console.log(websiteGoogleAnalytics);

        // $('.processing-message').remove();

        var modelAlert = $('.modal-body .alert');

        var responseClass = (statusCode === 200) ? 'alert-success' : 'alert-danger';

        setTimeout(function () {
            hidePreloader();
        }, 1200);

        $(".processing-message").remove();
        var callPageViews = true;

        // last step
        if(accountStep === 'view')
        {
            // $('#analytics-account-selector').modal('hide');
            $('#main-modal').modal('hide');

            swal({
                title: "",
                text: statusMessage,
                type: "error"
            }, function (callPageViews) {
                showPreloader();
                location.reload();
            });
            if(statusCode == 200) {
                swal({
                    title: "Successful!",
                    text: "Page views successfully added.",
                    type: "success"
                }, function (callPageViews) {
                    // $('html, body').animate({ scrollTop: 0 }, 'fast');
                    var pageViewsWidget = $(".website-page-views");
                    var pageViewsSource = pageViewsWidget.find(".card-source");
                    // var pageToggler = pageViewsWidget.find(".headingGoogleOuter");
                    // var pageViewsHeading = pageViewsWidget.find(".websiteAnalytics .card-head .header-subtext");
                    // var pageViewsHeading = pageViewsWidget.find(".websiteAnalytics .card-body");

                    var html = '';
                    html += '<div class="card-body website-page-views" style="display: flex;align-items: center;justify-content: center;">' +
                        '<div class="grid">'+
                        '<div class="card-source">'+count+'</div>'+
                        '<p  class="page-views" style="font-size: 16px;font-weight: 600;">Page Views</p>'+
                        '<div class="notifaction-alert insight-alert '+notificationClass+'">'+
                        '<span class="dashboard-popover" data-container="body" data-toggle="popover" data-placement="right" data-content="" style="" data-original-title="" title="">'+
                        '<i class="fa fa-info"></i>'+
                        '</span>'+
                        '<span class="review-status">'+insightTitle+'</span>'+
                        '</div>'+
                        '</div>'+
                        '</div>';
                    // +
                    //     '<div class="notifaction-alert insight-alert ' + notificationClass + '">'+
                    // '<span class="dashboard-popover" data-container="body" data-toggle="popover" data-placement="right" data-content="" style="" data-original-title="" title="">'+
                    // '<i class="fa fa-info"></i>'+
                    // '</span>'+
                    // '<span class="review-status">+insightTitle+</span>'+
                    // '</div>';

                    var toggler = '';

                    toggler += '<div class="dropdown  pull-right" style="margin-left: auto">'+
                        '<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">'+
                        '<span class="caret"></span></button>'+
                        '<ul class="dropdown-menu">'+
                        '<li><a class="googlePageViews" href="javascript:void(0);" data-filter-value="day">Today</a></li>'+
                        '<li><a class="googlePageViews" href="javascript:void(0);" data-filter-value="week">Last 7 Days</a></li>'+
                        '<li><a class="googlePageViews" href="javascript:void(0);" data-filter-value="all">Last 30 Days</a></li>'+
                        '</ul>'+
                        '</div>';
                    // var pageViewsAverage = '';
                    // pageViewsAverage +=

                    $('.headingGoogleOuter').append(toggler);

                    // $('<p>abc</p>').insertBefore(pageViewsHeading);
                    // $(html).insertAfter(pageViewsWidget);
                    $(pageViewsWidget).append(html);
                    $('.websiteAnalytics .card-head .header-subtext').text(websiteGoogleAnalytics);
                    // foreach(data as Data){
                    //
                    // }
                    // $.each(data as count){
                    // $.each(data, function (index, value) {
                    //     console.log('value[index].count');
                    //     console.log(value[index].count);
                    // });
                    // $(".filter-dropdown ul li a.active", pageViewsWidget).click();

                    pageViewsWidget.attr('data-widget-source', 'page_views');
                    pageViewsWidget.attr('data-widget-type', 'google-analytics');

                    // pageViewsSource.html("");
                    console.log('count');
                    console.log(count);
                    pageViewsSource.html(count);

                    pageViewsSource.attr('data-widget-source=page_views  data-widget-type=google-analytics');
                    $(".card-success-alert", pageViewsWidget).remove();
                    // pageViewsSource.addClass("card-counts");
                    // pageViewsWidget.find(".notifaction-alert").removeClass("hide");
                    // pageViewsWidget.find(".card-button").remove();
                    pageViewsWidget.find(".card-button").css('display', 'none');


                    // location.reload();
                    // pageViewsWidget.find(".graph-body").html('<div class="sparkline" data-toggle="modal"></div>');


                    // $(".filter-dropdown ul li a.active", pageViewsWidget).click();
                });
            }
        }

        if(statusCode == 200)
        {
            modelAlert.show();
            modelAlert.addClass(responseClass);
            // modelAlert.html("Your Google Analytics account listing.");
            modelAlert.html(statusMessage);

            if(accountStep === 'property')
            {
                $(".alert-content").show();
                $(".alert-content").html("Select website to see page views.");
            }

            $(".suggestion-title").html(statusMessage);

            var html = '';
            var checkedBusiness;
            var accountType = '';

            $.each(data, function (index, value) {
                checkedBusiness = (index === 0) ? 'checked' : '';
                var id = '';
                accountType = 'accounts';

                if(value.id)
                {
                    // property listing
                    id = value.id;
                    accountType = 'property';
                }
                else if(value.view_id)
                {
                    // views listing
                    id = value.view_id;
                    accountType = 'view';
                }

                html += '<div class="form-group m-b-0">';

                html +=   '<input id="'+id+'" type="radio" name="account_name" '+checkedBusiness+'>';
                html +=  '<label for="'+id+'">';
                html +=     '<div class="media">';
                html +=         '<div class="media-left" style="display: none;">';
                html +=         '</div>';
                html +=         '<div class="media-body" data-account-name="'+value.name+'">';
                html +=             '<h4 class="media-heading">'+value.name+'</h4>';
                if(value.website) {
                    html += '<span class="meta-web" data-website="'+value.website+'">';
                    html += 'Website: ' + value.website;
                    html += '<br>';
                    html += '</span>';
                }
                html +=             'id: '+ id;
                html +=         '</div>';
                html +=    '</div>';
                html +=   '</label>';

                html += '</div>';
            });

            if(html) {
                var form = '';
                form = '<form class="validate-me" accept-charset="UTF-8">';
                form +=     html;
                form +=     '<div class="modal-footer">';
                form +=         '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
                form +=         '<button type="submit" class="btn btn-info">Select</button>';
                form +=     '</div>';
                form +=     '<input type="hidden" id="current-analytics-step" value="'+accountType+'" />';
                form +=  '</form>';

                $('.suggest-list').html(form);
                // $(mainModel).modal('show');
                // $(".modal-header").after(form);
            }

            setTimeout(function () {
                modelAlert.hide();
            }, 3000);
        }
        else if(statusCode == 404) {
            // break the operation when error occured
            // $('#analytics-account-selector').modal('hide');
            $('#main-modal').modal('hide');
            swal("", statusMessage, "error");
            // send a request to remove access token
        }
        else  {
            // unexpected issue occured
            // $('#analytics-account-selector').modal('hide');
            $('#main-modal').modal('hide');

            if(statusCode == 403)
            {
                swal({
                    title: "",
                    text: statusMessage,
                    type: "error"
                }, function (callPageViews) {
                    showPreloader();
                    location.reload();
                });
            }
            else
            {
                swal(
                    { title: "",
                        type: 'error',
                        html: true,
                        text: 'Unable to process your request this time. <br> Please Try again later.',
                        showCloseButton: true
                    }
                );
            }
        }
    });
}

$(document.body).on('submit', 'form.validate-me', function (e)
{
    // alert('i am clicked');
    e.preventDefault();
    var requestType = $("#current-analytics-step").val();

    if(requestType === 'property' || requestType === 'view')
    {
        var formData = false;
        if (window.FormData) formData = new FormData();
        var accessToken = $('#accessToken').val();

        formData.append('accessToken', accessToken);
        var analyticsBody = $(this).find('.suggestion-container');
        var selectedItem = $(this).find('input[name=account_name]:checked');
        var selectedContainer = selectedItem.parent();
        // console.log('analyticsBody');
        // console.log(analyticsBody);
        // console.log('selectedItem');
        // console.log(selectedItem);
        // console.log('selectedContainer');
        // console.log(selectedContainer);
        // return;
        if(requestType === 'property')
        {
            // fetch property against account
            var id = selectedItem.attr('id');

            formData.append('send', 'analytics-views');
            formData.append('id', id);

            analyticsBody.prepend('<h3 class="processing-message">Retrieving Google Analytics account website.</h3>');
            console.log('goin for props')
            analyticsConnector(formData, 'property');
        }
        else if(requestType === 'view')
        {
            // fetch website page views against property

            var viewId = selectedItem.attr('id');
            var name = selectedContainer.find(".media-body").attr("data-account-name");
            var website = selectedContainer.find(".meta-web").attr("data-website");


            formData.append('send', 'analytics-views');
            formData.append('view_id', viewId);
            formData.append('name', name);
            formData.append('website', website);

            analyticsBody.prepend('<h3 class="processing-message">Retrieving Website page views.</h3>');
            console.log('goin for view')
            analyticsConnector(formData, "view");
        }
    }
});

$(document.body).on('hidden.bs.modal', '#main-modal.google-analytics', function () {
    if( $('#accessToken').val() == 1 )
    {
        var baseUrl = $('#hfBaseUrl').val();
        // clear the access token
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            type: "POST",
            // url: baseUrl + '/remove-access-token',
            url: baseUrl + '/done-me',
            data: {
                send: 'remove-access-token',
                googleAnalytics: 'googleAnalytics'
            }
        }).done(function (result) {
        });
    }
});

$(document.body).ready(function(){
    var siteUrl = $('#hfBaseUrl').val();
    $(this).on('click','.googlePageViews',function(){
        $('.dashboard-card-loader').show();
        $('.loader-img').show();
        var type = $(this).attr('data-filter-value');
        // alert(type);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            type: 'POST',
            url: siteUrl + '/done-me',
            data: {
                send: 'google-analytics-view-type',
                category_type: 'PV',
                type: 'google-analytics',
                is_type: type
            }
        }).done(function(result){
            $('.dashboard-card-loader').hide();
            $('.loader-img').hide();
            // var json = result;
            var json = $.parseJSON(result);
            // console.log(json);
            // return;
            var records = json.records;

            var count = records[0].count;

            // console.log(count);
            var insightStatus = records[0].insightStatus;
            // console.log(insightStatus);
            var abc = records[0].insightTitle
            var insightTitle = abc.replace(/(<|&lt;)br\s*\/*(>|&gt;)/g,' ');

            // console.log(insightTitle);
            var thisObj = $(this);
            $('.card-source').text(count);

            if(insightStatus === 'down')
            {
                // found
                $('.notifaction-alert').removeClass('success');
                $('.notifaction-alert').removeClass('warning');
                $('.notifaction-alert').addClass('danger');
                // thisObj.find('.notifaction-alert .review-status').text(insightTitle);
                $('.review-status').html(insightTitle);
            }

            else if(insightStatus === 'average')
            {
                // found
                $('.notifaction-alert').removeClass('success');
                $('.notifaction-alert').removeClass('danger');
                $('.notifaction-alert').addClass('warning');
                // thisObj.find('.notifaction-alert .review-status').text(insightTitle);
                $('.review-status').html(insightTitle);
            }
            else
            {
                $('.notifaction-alert').removeClass('danger');
                $('.notifaction-alert').removeClass('warning');
                $('.notifaction-alert').addClass('success');
                $('.review-status').html(insightTitle);
            }
        });
    });
});
$(document.body).on('click', '.btn-website-connect' ,function() {
    // var id = 'google-analytics-oauth';
    var baseUrl = $('#hfBaseUrl').val();
    window.appName = $('#appName').val();
    // console.log(window.appName);
    var mainModel = $('#main-modal');
    $(".modal-body, .modal-footer, .validate-me", mainModel).remove();
    $(mainModel).removeClass('welcome-process');
    $(mainModel).addClass('google-analytics');
    var html = '';

    html += '<div class="modal-body">'
    html += '<div class="OAuth-modal-body">';
    // html += '<div class="auth-logo"><img src="'+baseUrl+'/public/images/google-analytics.jpg" alt=""></div>';
    html += '<h3 style="color: #3D4A9E;" >Add Your Website Here.</h3>';
    html += '<form>';
    // html += '<div> <h4> Sign in to your Google Analytics account to authorize '+window.appName+'. <br> Once authorized, you will be able to: </h4> <ul> <li>View Google Analytics data related to your website on the '+window.appName+' app.</li> </ul> </div>';
    // html += '<div class="form-group"> <button type="button" id="loginGoogleAnalytics" class="btn btn-google-analytics"><i class="fa fa-google" aria-hidden="true"></i>  Sign In to Google Analytics </button> </div>';
    html += '<div style="padding-top: 15px;"><input type="text" id="add-url" class="form-control" placeholder="abc@example.com" style="width: 80%;margin-left: auto;margin-right: auto;" required>' +
        // '<div class="invalid-feedback">Please Enter Email.</div>'+
        '</div>';
    html += '<div style="padding-top: 40px;"><button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-default" >Cancel</button>\n' +
        '    <button id="website-connection" class="btn btn-primary">Connect Website</button></div>';
    html += '</div>';
    html += '</div>';
    html += '</form>';
    // loadModal(id);
    // $('.modal-body', '#'+id).html(html);
    $(mainModel).modal('show');
    $(mainModel).find('.modal-header').after(html);
    // enableAuthLogin();
});

// $(document.body).on('click', '#website-connection' ,function() {
$(document.body).on('click', '#website-connection' ,function() {
    var website =  $('#add-url').val();
    // console.log(email);
    var siteUrl = $('#hfBaseUrl').val();
    if(website){
        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            type: 'POST',
            url: siteUrl + '/done-me',
            data: {
                send: 'add-website',
                website: website
            }
        }).done(function(result){
            var json = $.parseJSON(result);
            var statusCode = json.status_code;
            var statusMessage = json.status_message;
            console.log(statusCode);
            if (statusCode == 200){
                $('#main-modal').modal('hide');
                swal({
                    title: "Success",
                    text: statusMessage,
                    type: 'success'
                },function(){
                });
            }
            else{
                swal({
                    title: "Error!",
                    text: statusMessage,
                    type: 'error'
                },function () {
                });
            }
            location.reload();
        });
    }
});

