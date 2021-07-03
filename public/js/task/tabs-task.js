window.firstTimeLoad=true;
window.get_num_post = 5;
window.status = '';
window.button_clicked = '';
window.taskType = '';
window.add_to_do_clicked = '';
window.countCampaignWithoutTask = 0;
window.currentActiveTab = '';
/**
 * Created by Abdul Rehman on 5/31/2017.
 */



module = $('#module').val();
$(function()
{

    $('#watchOverviewVideo').click(function () {
        // var baseUrl = $('#hfBaseUrl').val();
        // location.href = baseUrl+'/getting-started?ref=dashboard';
        // return false;
        var mainModel = $('#main-modal');
        // mainModel.css({'background-color': '#546576 !important', 'opacity': '.8'});
        $(".modal-body, .modal-footer, .validate-me", mainModel).remove();
        $(mainModel).removeClass('welcome-process');
        $(mainModel).addClass('welcome-task-video');
        // $('#loader').children().html('');
        var mainModelContent = mainModel.find('.modal-content');

        var modalBody =     '<div class="modal-body">'+
            '<iframe width="100%" height="315" src="https://www.youtube.com/embed/S2WYZvO6OFo?rel=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen  id="welcomeVideo"></iframe>'+
            '</div>';

        var modalFooter =   '<div class="modal-footer">'+
            // '<h5 class="modal-title text-center" style=" margin:auto;"> <span style="font-weight:700"> Welcome to nichepractice</span></h5>'+
            '<h5 class="modal-title text-center" style=" margin:auto;"> <span style="font-weight:700"> Nichepractice explained in under 60 seconds</span></h5>'+
            '<div class="video-font-size">' +
            // 'Watch this quick video to learn how nichepractice works. ' +
            // 'It can help transform your practice by increasing productivity and revenue.' +
            '</div>'+
            '</div>';

        // id="closevideo"
        $(".modal-header .close", mainModelContent).attr('id', 'closevideo');
        $(".modal-header", mainModelContent).after(modalBody + modalFooter);
        // mainModelContent.html();
        mainModel.modal('show');
    });

    var welcome_video_seen = $('#welcome_video_seen').val();

    if (welcome_video_seen == '0') {
        // return false;

        $('#loader').children().html('');
        var mainModel = $('#main-modal');
        // mainModel.css({'background-color': '#546576 !important', 'opacity': '.8'});
        $(mainModel).removeClass('welcome-process');
        $(mainModel).removeClass('create-your-account');
        $(".modal-body, .modal-footer, .validate-me", mainModel).remove();
        $(mainModel).addClass('welcome-task-video');

        var mainModelContent = mainModel.find('.modal-content');

        var modalBody =     '<div class="modal-body">'+
            '<iframe width="100%" height="315" src="https://www.youtube.com/embed/S2WYZvO6OFo?rel=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen  id="welcomeVideo"></iframe>'+
            '</div>';

        var modalFooter =   '<div class="modal-footer ">'+
            // '<h5 class="modal-title text-center" style=" margin:auto;"> <span style="font-weight:700"> Welcome to nichepractice</span></h5>'+
            '<h5 class="modal-title text-center" style=" margin:auto;"> <span style="font-weight:700"> Nichepractice explained in under 60 seconds</span></h5>'+
            '<div  class="video-font-size" >' +
            // 'Watch this quick video to learn how nichepractice works. ' +
            // 'It can help transform your practice by increasing productivity and revenue.' +
            '</div>'+
            '</div>';

        // mainModelContent.html(modalHeader + modalBody + modalFooter);

        $(".modal-header .close", mainModelContent).attr('id', 'closevideo');
        $(".modal-header", mainModelContent).after(modalBody + modalFooter);

        mainModel.modal('show');

        $('#closevideo').click(function () {
            // console.log('closevideo');
            $("#welcomeVideo").attr('src','');
            var baseUrl = $('#hfBaseUrl').val();
            data = {
                'seen': 1
            }
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                type: "post",
                url: baseUrl+"/videoSeen",
                data: data
            }).done(function (data) {
                // console.log(data);
            }).fail(function (error) {
                // console.log(error);
            });
        });
    }
    if(window.innerHeight > 720)
    {
        windowHeightDeduction =  parseInt((window.innerHeight/100)*41);
        windowHeight = window.innerHeight - windowHeightDeduction;
        // windowHeight = window.innerHeight - 400;
    }
    else
    {
        windowHeight = window.innerHeight - 150;
    }

    // $('.task-list-wrapper').slimScroll({
    //     height: windowHeight,
    //     size: '5px',
    //     alwaysVisible: true,
    //     allowPageScroll: true
    // });
    if(window.innerHeight > 720)
    {
        boxHeight = window.innerHeight - 120;
        $('.white-box').height(boxHeight+'px');
    }
    else
    {
        boxHeight = window.innerHeight - 30;
        $('.white-box').height(boxHeight+'px');
    }
    /**
     * Comment as per story MAD-1387
     */

    // if (module === 'marketing_plan') {
    //     $('.task-list-wrapper').slimScroll({
    //         height: windowHeight - 170,
    //         size: 5
    //     });
    // }
    // else
    // {
    //     $('.task-list-wrapper').slimScroll({
    //         height: windowHeight,
    //         size: 5
    //     });
    // }

});

// function ignoreError()
// {
//     return true
// }
//
// window.onerror=ignoreError();

var totalTaskContainer = $('.task-length');

// taking window height to apply dynamic height properly.
// var windowHeight = $(window).height();
// var windowWidth = $(window).width();

/**
 * navbar Height this height is taking for
 * to get actual result of page container
 * @type {jQuery}
 */
var navBarHeight = $('.navbar-static-top').height();

function taskScreenDimensionManager()
{
    // console.log("dynamic height function called");
    // console.log("window w" + windowWidth);
    // if(windowWidth >= 1024) {
    //     var pageHeight = windowHeight - navBarHeight;
    //     console.log("page height " + pageHeight);
    //     console.log("window height " + windowHeight);
    //
    //     var bottomPadding = 30;
    //
    //     // if(windowWidth >= 1200 && windowWidth < 1300) {
    //     //     bottomPadding = 20;
    //     // }
    //     // else if(windowWidth >= 1024)
    //     // {
    //     //     bottomPadding = 0;
    //     // }
    //
    //     // console.log(" " + pageHeight);
    //     // $('.task-list .white-box').innerHeight(pageHeight+'px');
    //
    //     var taskList = $('.task-issues .page-content').height();
    //     var tabDescriptionArea = $('.task-contain').height();
    //
    //     console.log("tabs left height " + taskList);
    //     console.log("tab DescriptionArea right height " + tabDescriptionArea);
    //     // var modifyHeight = 0;
    //
    //     // apply window height
    //     if ( ( taskList < pageHeight ) && ( tabDescriptionArea < taskList ) ) {
    //         // pageHeight = pageHeight - bottomPadding;
    //         // last moment solution
    //
    //         console.log("if " + pageHeight);
    //         $('.task-list .white-box').innerHeight(pageHeight + 'px');
    //         // $('.task-list .white-box').height(pageHeight + 'px');
    //     }
    //     else if (( taskList >= pageHeight ) || ( tabDescriptionArea >= pageHeight ) || ( tabDescriptionArea >= taskList )) {
    //         var tabAreaHeight = (taskList >= tabDescriptionArea ) ? taskList : tabDescriptionArea;
    //
    //         if(tabAreaHeight > pageHeight)
    //         {
    //             console.log("tab before Height " + tabAreaHeight);
    //             // tabAreaHeight = tabAreaHeight + bottomPadding;
    //             tabAreaHeight = tabAreaHeight + 60;
    //
    //             console.log("tab Height apply " + tabAreaHeight);
    //             // $('.task-list .white-box').height(tabAreaHeight + 'px');
    //             $('.task-list .white-box').height(tabAreaHeight + 'px');
    //         }
    //         else {
    //                 pageHeight = pageHeight + 60;
    //                 console.log("if inside else if " + pageHeight);
    //                 $('.task-list .white-box').innerHeight(pageHeight + 'px');
    //             }
    //     }
    //     else {
    //         console.log("else");
    //         pageHeight = pageHeight - bottomPadding;
    //         // $('.task-list .white-box').height(pageHeight + 'px');
    //         $('.task-list .white-box').innerHeight(pageHeight + 'px');
    //     }
    //
    //     console.log("-------------------------------------------");
    // }
}

function loadTaskMessage(message)
{
    if (!$(".web-report")[0]){
        $('.tab-pane').prepend('<div class="alert alert-warning p-10 web-report">Website Report is generating. Please wait.</div>');
    }
}

$(window).load(function () {
    var height=$('body').height()/2-140;
    $('.website-task-list .loader').css('margin-top', parseInt(height)+"px");
    $('.task-description-area .loader-container img').css('margin-top', parseInt(height+94)+"px");

    if (module === 'marketing_plan') {
        loadObjectiveFilters();
    }
    else {
        /**
         * target to first element of tabs when page load.
         */
        $('.task-tabs li a:first').click();
    }
});

$('select.objective-filters').on('change', function() {
    if ($(".web-report")[0]){
        $('.web-report').remove();
        $('.task-length').show();
    }
    $('.task-tabs li.active a').click();
});

function loadObjectiveFilters()
{
    var baseUrl = $('#hfBaseUrl').val();

    $('.icon-refresh').show();

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },
        type: "GET",
        url: baseUrl + "/task/objective-filters-list"
    }).done(function (result) {
        $('.icon-refresh').hide();
        // parse data into json
        var json = $.parseJSON(result);

        // get data
        var statusCode = json.status_code;
        var statusMessage = json.status_message;

        var data = json.data;
        $('.task-description-area .loader-container').hide();

        if (statusCode === 200) {
            var html = '';
            var matched = false;
            var objectiveCall = $('#objective-call').val();


            if(data !== '') {
                $.each(data, function (index, value) {
                    if(objectiveCall !== '' && objectiveCall == value.objective)
                    {
                        matched = true;
                        objectiveCall = value.id;
                    }

                    // console.log("f " + objectiveCall);
                    // console.log("s " + value.objective);
                    if($('#objective-call').val() == value.objective && $('#task-call').val() === '')
                    {
                        $(".objective-filter-selection").show();
                        $(".objective-filter-selection .filter-label").html(value.title);
                    }

                    html += '<option value="'+value.id+'">';
                    html +=  value.title;
                    html += '</option>';
                });
            }

            // post objectives list after first option
            $('select.objective-filters option:first').after(html);

            $('.task-length').show();

            /**
             * target to first element of tabs when page load.
             */
            // $('.website-task-list li label:first').click();
        }

        /**
         * Logic here to get specific objective posts or default
         * marketing screen functionality added
         *
         */
        if(matched === true)
        {
            $('.tab-pane .loader').hide();
            // yes found objective in objective list so call the specific objective.
            $('select.objective-filters').val(objectiveCall).change();
        }
        else if(matched === false && objectiveCall !== '') {
            $('.tab-pane .loader').hide();

            // show message to user not found any objective of given id.
            if (!$(".web-report")[0]){
                $('.task-length').hide();
                $('.tab-pane').prepend('<div class="alert alert-danger p-10 web-report">Requested data not available yet. Well, You can explore other filter from top filters list.</div>');
            }

            var descriptionArea = $('.task-description');

            descriptionArea.show();
            descriptionArea.html('<div class="page-content" style="font-size: 18px; text-align: center;">Content not available.</div>');
            taskScreenDimensionManager();
        }
        else
        {
            // run prgram as previously working
            // because matched is false and objective id is empty
            $('.task-tabs li a:first').click();
        }

    });
}

var page = 1; // What page we are on.
var ppp = 10; // Post per page

/**
 * Assign the flag here to handle multiple ajax request at same time
 * @type {boolean}
 */
var tabsAjaxReady = true;

/**
 * code start working to get posts of requested tab.
 */

$('.task-tabs li a').click(function (e)
{
    onPageCollapse = '';
    e.preventDefault();
    window.firstTimeLoad=true;

    if(module === 'website') {
        loadTaskMessage();
    }

    var tabsPostList = $('.website-task-list .tab-pane'); // posts holder area

    /**
     * Taking ID of current active tab.
     */
    var calledID = tabsPostList.attr('id');

    totalTaskContainer.html('Task Counting...');

    /**
     * slicing the requsted tab to get plain string.
     * e.g #open > open.
     */
    var called = this.hash.slice(1);
    window.currentActiveTab = called;
    // console.log('called');
    // console.log(called);

    // console.log("called " + called);
    if (called == 'open') {
        $('.action-plan-suggestion').show();
        $(".action-plan-suggestion").animate({marginTop: '0px'}, 3000);

    } else {
        $(".action-plan-suggestion").css({'margin-top': '120px'});
        $('.action-plan-suggestion').hide();
    }
    // $(".tab-content").hide();
    // $('ul', tabsPostList).html('');

    $('.task-list-wrapper', tabsPostList).html('');

    $(".website-page-tabs li").removeClass('active');
    $(this).parent().addClass('active');

    /*
     * Pagination reset to show posts from start when any
     * tab is request of posts.
     */
    page = 1;  // page is local variable and value is 0
    ppp = 10;  // ppp is local variable and value is 3

    $('.task-description-area .loader-container').show();
    $('.task-description').hide();

    $('.task-description').removeClass('panel-open panel-done panel-all');

    // console.log("called panel");
    // console.log(called);
    $('.task-description').removeClass('panel-open panel-paid panel-skipped panel-done');
    $('.task-description').addClass('panel-'+called)

    $('.website-task-list .loader').show();

    // loading requesting tabs posts
    loadPosts(called);

    if(called == 'open')
    {
        // setTimeout(function () {
        //     loadRecurringPosts(called);
        // },1000);
    }
});

/**
 * Logic here to get requested id posts
 * @param requestedTabPost
 */
function loadPosts( requestedTabPost ) {

    if (tabsAjaxReady === false) return;

    var formData = false;
    if (window.FormData) formData = new FormData();

    var baseUrl = $('#hfBaseUrl').val();
    tabsAjaxReady = false;

    var module = $('#module').val();

    data = {
        'send': 'retrieve-tabs-task',
        'status': requestedTabPost,
        'get_num_post':get_num_post,
        'add_to_do_clicked': add_to_do_clicked
    };

    if (isEmptyValNormal(window.currentPageSource) == false) {
        data['currentPageSource'] = window.currentPageSource;
    }

    window.get_num_post = 5;

    if (module === 'marketing_plan') {
        data['objective'] = $('select.objective-filters option:selected').val();

        var task = $('#task-call').val();
        var objectiveCall = $('#objective-call').val();

        if(task !== '' && objectiveCall !== '')
        {
            // console.log("task > " + task + "obj > " + objectiveCall);
            data['task'] = task;
        }
    }

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },
        type: "POST",
        url: baseUrl + "/done-me",
        data: data
    }).done(function (result) {
        if(module === 'website')
        {
            $('.web-report').remove();
        }

        // parse data into json
        var json = $.parseJSON(result);

        // get data
        var statusCode = json.status_code;
        var statusMessage = json.status_message;

        var called = requestedTabPost;

        if(requestedTabPost != 'paid' && requestedTabPost != 'skipped')
        {
            // call this when daily posts are loaded. so make sure it will populate after daily tasks.
            loadRecurringPosts(called);
        }

        var tabsPostList = $('.website-task-list .tab-pane'); // posts holder area

        var calledID = tabsPostList.attr('id');
        tabsPostList.attr('id', called);

        $('.website-task-list .loader').hide();
        $('.task-description-area .loader-container').hide();

        var data = '';
        var totalTasks = '';

        var marketingCampaignTasks = '';
        var totalCampaignTasks = '';

        if(requestedTabPost == 'open')
        {
            data = json.data.non_marketing_tasks;
            totalTasks = json.data.non_marketing_tasks.length;

            marketingCampaignTasks = json.data.marketing_tasks;
            totalCampaignTasks = json.data.marketing_tasks.length;
        }
        else
        {
            data = json.data;
            totalTasks = json.data.length;
        }

        if(isEmptyValNormal(window.currentPageSource) == false && window.currentPageSource == 'task_list')
        {
            $("body").addClass('sidebar-scroll-position');
        }

        if (statusCode === 200) {
            page++;
            var html = '';
            var marketingCampaignHtml = '';
            var user = $('#hfCurrent').val();

            var accordianClass= '';

            if(data !== '') {
                // if(requestedTabPost == 'open1')
                // {
                //     // console.log(data);
                //         html += '<div class="task-panel panel-body">';
                //         html += '<h3  style="font-weight: 700;margin-top:0;">Action Plan</h3>';
                //         html += '<ul>';
                //
                //         $.each(data, function (index, value) {
                //
                //             var taskId = value.id;
                //             var title = value.title;
                //             var estimatedTime = value.estimated_time;
                //
                //             // var isChecked = ( (value.user_id == user) && (value.status === 'done' && requestedTabPost !== 'open') ) ? "checked" : "";
                //             var isChecked = '';
                //
                //             if(value.marketing_tasks && value.marketing_tasks.length !== 0)
                //             {
                //                 isChecked = (value.marketing_tasks[0]['status'] === 'done') ? "checked" : '';
                //             }
                //             else
                //             {
                //                 isChecked = (requestedTabPost === 'done') ? "checked" : '';
                //             }
                //
                //             // console.log("isChecked");
                //             // console.log(isChecked);
                //             // if task is not checked then show title  Click when done.
                //             var tooltipTitle = (isChecked === '') ? 'Click when done.' : 'Click to reopen.';
                //
                //
                //             html += '<li data-task-id="' + taskId + '">';
                //             html += '<div class="checkbox checkbox-info lg-checkbox checkbox-circle">';
                //             // html += '<input id="checkbox-' + taskId + '" type="checkbox" data-toggle="tooltip" data-placement="top" data-selector="true" title="'+tooltipTitle+'" '+ isChecked +'>';
                //             html += '<input id="checkbox-' + taskId + '" type="checkbox" data-toggle="tooltip" data-placement="top" data-selector="true">';
                //             html += '<label>';
                //             html += '<span>' + title + '</span>';
                //             html += '</label>';
                //             html += '</div>';
                //             // html += '<i class="mdi mdi-chevron-right pull-right"></i>';
                //
                //             if(estimatedTime)
                //             {
                //                 html += '<div class="read-time">\n' +
                //                     '<i class="fa fa-clock-o" aria-hidden="true"></i>\n' +
                //                     estimatedTime+' mins\n' +
                //                     '</div>';
                //             }
                //
                //             html += '</li>';
                //
                //         });
                //
                //         html += '</ul>';
                //         html += '</div>';
                // }
                if(requestedTabPost == 'open')
                {
                    $('.email-templates-filters .template-link:first').click();
                    html = getCategoryData(data, requestedTabPost, 'non_marketing_task');
                    var noCampaignMsg = '<p>No Task found in this list.</p>';
                    if(isEmptyValNormal(window.currentPageSource) == false && window.currentPageSource != 'campaign_library')
                    {
                        noCampaignMsg = '<p>No Marketing Campaign found. Campaigns will show here once listed.</p>';
                        marketingCampaignHtml = '<div style="display: none; background-color: #125680;padding-left: 10px;padding-top: 5px;padding-bottom: 5px;margin-top: 20px; margin-bottom: 20px;position: relative;">\n' +
                            '    <h3 style="width: 80%;color: #fff;font-weight: 600;margin: 0;">Marketing Campaigns</h3><a href="'+baseUrl+'/campaigns-library" style="color: #ffffff;position: absolute;right: 19px;top: 10px;">View All</a>\n' +
                            '</div>';
                    }

                    var marketingCampaignTask = getCategoryData(marketingCampaignTasks, requestedTabPost, 'marketing');


                    if(marketingCampaignTask !== '')
                    {
                        marketingCampaignHtml += marketingCampaignTask;
                    }
                    else
                    {
                        marketingCampaignHtml += noCampaignMsg
                    }
                }
                else if(requestedTabPost == 'paid' || requestedTabPost == 'skipped')
                {
                    html += '<div class="task-panel panel-body">';

                    if(requestedTabPost == 'paid')
                    {
                        html += '<h3  style="font-weight: 700;margin-top:0;">Paid Tasks</h3>';
                    }
                    else
                    {
                        html += '<h3  style="font-weight: 700;margin-top:0;">Skipped Tasks</h3>';
                    }

                    html += '<ul>';

                    $.each(data, function (index, value) {

                        var taskId = value.id;
                        var title = value.title;
                        var estimatedTime = value.estimated_time;
                        // console.log('yayayyayayyaya');
                        // var isChecked = ( (value.user_id == user) && (value.status === 'done' && requestedTabPost !== 'open') ) ? "checked" : "";
                        var isChecked = '';

                        if(value.marketing_tasks && value.marketing_tasks.length !== 0)
                        {
                            isChecked = (value.marketing_tasks[0]['status'] === 'done') ? "checked" : '';
                        }
                        else
                        {
                            isChecked = (requestedTabPost === 'done') ? "checked" : '';
                        }

                        // console.log("isChecked");
                        // console.log(isChecked);

                        // if task is not checked then show title  Click when done.
                        var tooltipTitle = (isChecked === '') ? 'Click when done.' : 'Click to reopen.';

                        html += '<li data-task-id="' + taskId + '">';
                        html += '<div class="checkbox checkbox-info lg-checkbox checkbox-circle">';
                        // html += '<input id="checkbox-' + taskId + '" type="checkbox" data-toggle="tooltip" data-placement="top" data-selector="true" title="'+tooltipTitle+'" '+ isChecked +'>';
                        html += '<input id="checkbox-' + taskId + '" type="checkbox" data-toggle="tooltip" data-placement="top" data-selector="true">';
                        html += '<label>';
                        html += '<span style="width: 70%;white-space: normal;">' + title + '</span>';
                        html += '</label>';
                        html += '</div>';
                        // html += '<i class="mdi mdi-chevron-right pull-right"></i>';

                        if(estimatedTime)
                        {
                            html += '<div class="read-time">\n' +
                                '<i class="fa fa-clock-o" aria-hidden="true"></i>\n' +
                                estimatedTime+' mins\n' +
                                '</div>';
                        }

                        html += '</li>';

                    });

                    html += '</ul>';
                    html += '</div>';
                }
                else
                {
                    html = getCategoryData(data, requestedTabPost, 'marketing');
                }
            }

            if (calledID !== '' && calledID === called) {
                $('.task-list-wrapper', tabsPostList).fadeIn('slow', function () {
                    $('.task-list-wrapper', tabsPostList).append(html);

                    $('.task-list-wrapper', tabsPostList).append(marketingCampaignHtml);
                });
            }
            else {
                if(isEmptyValNormal(window.currentPageSource) == false && window.currentPageSource === 'campaign_library')
                {
                    $(".web-campaign-loader").hide();
                    $(".campaign-library-row").html(marketingCampaignHtml);

                    setTimeout(function () {
                        $('.template-link:first-child').click();
                    }, 100);
                }
                else
                {
                    $('.task-list-wrapper', tabsPostList).html('');
                    $('.task-list-wrapper', tabsPostList).html(html);

                    $('.task-list-wrapper', tabsPostList).append(marketingCampaignHtml);
                }
            }

            taskActions();

            $('.website-task-list li label:first').click();
            // $(".task-description").show();
        }
        else
        {
            var descriptionArea = $('.task-description');

            descriptionArea.show();

            if(isEmptyValNormal(window.currentPageSource) == false && window.currentPageSource == 'campaign_library')
            {
                descriptionArea.html('<div class="page-content" style="font-size: 18px; text-align: center;">No Marketing Campaign Selected.</div>');
                $('.task-list-wrapper').append('<p style="text-align: center;">No Marketing Campaign Found.</p>');
            }
            else
            {
                descriptionArea.html('<div class="page-content" style="font-size: 18px; text-align: center;">No Task Selected.</div>');
                $('.task-list-wrapper').append('<p style="text-align: center;">No Task Found.</p>');
            }
        }

        var taskListCount = $("#open .task-panel.panel-body li").length;

        if (taskListCount == 5) {
            $(".add-more-task").remove();
        }

        if($(".add-more-task").length < 1 && taskListCount < 2)
        {
            if (data.length != 1) {
                $("#open .task-panel.panel-body").append('<div class="add-more-task"><span class="plus-sign">+</span><span class="add-task-text">Add a To DO Task</span></div>');
            }
        }

        updateTotalTaskCounting(totalTasks);

        tabsAjaxReady = true;
        taskScreenDimensionManager();

        if(window.innerHeight > 720)
        {
            boxHeight = window.innerHeight - 120;
            $('.white-box').height(boxHeight+'px');
        }
        else
        {
            boxHeight = window.innerHeight - 30;
            $('.white-box').height(boxHeight+'px');
        }
        $(".week1").each(function(){
            // Test if the div element is empty
            $(this).first().nextAll('.week1').css('display', 'none');
        });
        $(".week2").each(function(){
            // Test if the div element is empty
            $(this).first().nextAll('.week2').css('display', 'none');
        });
        $(".week3").each(function(){
            // Test if the div element is empty
            $(this).first().nextAll('.week3').css('display', 'none');
        });
        $(".week4").each(function(){
            // Test if the div element is empty
            $(this).first().nextAll('.week4').css('display', 'none');
        });
        $(".week5").each(function(){
            // Test if the div element is empty
            $(this).first().nextAll('.week5').css('display', 'none');
        });
        $(".week6").each(function(){
            // Test if the div element is empty
            $(this).first().nextAll('.week6').css('display', 'none');
        });
        $(".week7").each(function(){
            // Test if the div element is empty
            $(this).first().nextAll('.week7').css('display', 'none');
        });

        $(".week8").each(function(){
            // Test if the div element is empty
            $(this).first().nextAll('.week8').css('display', 'none');
        });

        $(".week9").each(function(){
            // Test if the div element is empty
            $(this).first().nextAll('.week9').css('display', 'none');
        });
        $(".week10").each(function(){
            // Test if the div element is empty
            $(this).first().nextAll('.week10').css('display', 'none');
        });


        $(".week0").each(function(){
            // Test if the div element is empty
            $(this).first().nextAll('.week0').css('display', 'none');
        });
        // $(".no-week").each(function(){
        //     // Test if the div element is empty
        //     $(this).css('padding-left', '25px');
        // });

        // $(".week").each(function(){
        //     // Test if the div element is empty
        //     $(this).css('padding-left', '25px');
        // });
        // $( '.week1' ).first().nextAll('.week1').css('display', 'none');

        loadTaskCount();
        $('#showHiddenCampaigns').text('Show Hidden Campaign');
        // console.log('window.countCampaignWithoutTask');
        // console.log(window.countCampaignWithoutTask);
        if(window.countCampaignWithoutTask > 0) {
            $('#showHiddenCampaigns').show();
        }
        else{
            $('#showHiddenCampaigns').hide();
        }
        window.countCampaignWithoutTask = 0;
    });
    return false;
}

function loadTaskCount() {
    var baseUrl = $('#hfBaseUrl').val();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },
        type: "POST",
        url: baseUrl + "/done-me",
        data: {
            'send': 'task-count'
        }
    }).done(function (result) {
        var json = $.parseJSON(result);

        var statusCode = json.status_code;
        var data = json.data;

        if(statusCode == 200)
        {
            $(".open-count").html(data.open);
            $(".skipped-count").html(data.skipped);
            $(".done-count").html(data.done);
        }
    });
}

var onPageCollapse = '';
function getCategoryData(data, requestedTabPost, source = 'task') {
    var baseUrl = $('#hfBaseUrl').val();

    var html = '';
    var accordianClass = '';
    var indexCategoryRef = '';
    var dataListClass = '';
    var userAccountStatus = $("#userUpgradeStatus").val();
    var packageCredits = '';

    $.each(data, function (indexCategory, valueObject) {
        // console.log("valueobject");
        // console.log(valueObject);
        // console.log('data');
        // console.log(indexCategory);

        indexCategoryRef = indexCategory + '-'+ source;

        // if(source == 'marketing' && userAccountStatus == 'trial' && valueObject.show_to_paid == 1)
        if(source == 'marketing' && valueObject.show_to_paid == 1)
        {
            if(valueObject.user_category.length >=1)
            {
                if(valueObject.user_category[0].is_unlocked == 1 && valueObject.user_category[0].category_id == valueObject.id)
                {
                    dataListClass = '';
                    // console.log(valueObject.tasks[0].is_unlocked);
                }
                else
                {
                    dataListClass = 'no-access';
                }
            }
            else
            {
                dataListClass = 'no-access';
            }
        }
        else
        {
            dataListClass = '';
        }

        if(isEmptyValNormal(window.currentPageSource) == false && window.currentPageSource == 'campaign_library')
        {
            if(source == 'marketing' && valueObject.show_to_paid == 1)
            {
                var campaignId = valueObject.id;
                var campaignLibraryType = 'list-'+valueObject.library_type;
                var isCampaignUnlocked = false;
                var campaignClass = '';
                var thumbnailBox = valueObject.thumbnail;
                var thumbnail;
                var sampleDescription = valueObject.sample_description;
                // console.log(sampleDescription)

                if(isEmptyValNormal(thumbnailBox) == false)
                {
                    thumbnail = baseUrl + '/storage/app/'+thumbnailBox;
                }
                else
                {
                    thumbnail = 'https://app.nichepractice.com/storage/app/logo1596388249.png';
                }

                if(valueObject.user_category.length >=1) {
                    if (valueObject.user_category[0].is_unlocked == 1 && valueObject.user_category[0].category_id == valueObject.id) {
                        isCampaignUnlocked = true;
                        campaignClass = 'unlocked-campaign';
                    }
                }

                if(isEmptyValNormal(valueObject.credits) == false)
                {
                    packageCredits = valueObject.credits;
                }
                else{
                    packageCredits = '';
                }
                var sampleLink = '';
                if( sampleDescription ) {
                    // console.log(sampleDescription);
                    sampleLink =
                        '<div class="text1">'+
                        '<a href="javascript:void(0)" class="btn btn-show-sample" data-credits="'+packageCredits+'" data-campaign-target="'+campaignId+'">\n'
                        +'See Sample\n' +
                        '</a></div>';

                }
                // console.log(sampleLink);

                html += '<div style="position: relative;" class="col-sm-4 marketing-campaign-'+campaignId+' template-box-container-col-sm-3 list-marketing-campaign '+campaignClass+' '+campaignLibraryType+'">';

                html +='<div class="" style=" position: relative;height: 100%;box-shadow: 0 0 10px #ccc;">';

                html += '<div class="card-label-status" style="display: none;">Unlocked</div>';

                html += '<div class="card-label-credits" style="display: block"> <p>'+packageCredits+' Credits</p> </div>';

                html +='                                             <div class="template-box" style="">\n' +
                    '                                                    <div class="t-image-container">\n' +

                    ' <img src="'+thumbnail+'" alt="Avatar" class="image">\n' +
                    '<div class="t-image-overlay">\n' +
                    ' <div class="text">\n' +
                    '\n' +
                    '<a href="javascript:void(0)" class="btn btn-template-edit" data-credits="'+packageCredits+'" data-campaign-target="'+campaignId+'">\n' +
                    // 'Unlock\n' +
                    'Select\n' +
                    '</a>\n' +
                    '<a href="javascript:void(0)" class="btn btn-campaign-info" data-credits="'+packageCredits+'" data-campaign-target="'+campaignId+'">\n' +
                    'Learn More\n' +
                    '</a>\n' +
                    '\n' +
                    '\n' +
                    '                                                            </div>\n' +
                    sampleLink+
                    '                                                        </div>\n' +
                    '                                                    </div>\n' +
                    '                                                </div>\n' +
                    '                                                <label class="template-name " style="">\n' +valueObject.name + '</label>\n';

                if(isEmptyValNormal(valueObject.content) == false)
                {
                    // html +='<div class="template-description">\n' +valueObject.content + '</div>';
                    html +='';
                }
                html +='                                            </div>';
                html +='                                            </div>';
            }
        }
        else
        {
            var show = '';
            var dontShowClass = '';
            if(valueObject.tasks.length == 0 && dataListClass == ''){
                show = 'display:none';
                dontShowClass = 'dontshow';
                window.countCampaignWithoutTask++;
            }
            html +='<div style="'+show+'" class="data-list panel panel-default '+dataListClass+' '+dontShowClass+'" data-source="category" data-id="'+valueObject.id+'">';
            html +='<div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#collapse'+indexCategoryRef+'" aria-expanded="false">';
            html +='<h3 style="font-weight: 700;">'+ valueObject.name + '</h3>';
            // html +='<i class="fa fa-chevron-down" aria-hidden="true"></i>';

            if(dataListClass == 'no-access')
            {
                html +='<img src="'+baseUrl+'/public/images/chaveron-lock2.png" class="chevron-down" />';
            }
            else
            {
                // if(requestedTabPost == 'open' && valueObject.tasks.length == 0)
                // {
                //     html +='<img src="'+baseUrl+'/public/images/chev.png" class="chevron-down" />';
                // }
                // else {
                //     html +='<img src="'+baseUrl+'/public/images/chaveron-arrow.png" class="chevron-down" />';
                // }
                if(requestedTabPost == 'open') {
                    html +='<img src="'+baseUrl+'/public/images/chaveron-arrow.png" class="chevron-down" />';
                }
            }

            html +='</div>';

            // if(source == 'non_marketing_task')
            // {
            //     // by default show first category is open
            //     accordianClass = (indexCategory === 0) ? 'in' : '';
            // }
            // else
            // {
            //     // by default no category will be shown.
            //     accordianClass = '';
            // }

            if(onPageCollapse != 'in')
            {
                accordianClass = (indexCategory === 0) ? 'in' : '';

                if(accordianClass == 'in')
                {
                    onPageCollapse = 'in';
                }
            }
            else
            {
                accordianClass = '';
            }

            if(dataListClass === 'no-access')
            {
                indexCategoryRef = '';
            }

            if(valueObject.tasks.length != 0)
            {
                // console.log("inside");
                // console.log(valueObject.tasks);

                html += '<div id="collapse'+indexCategoryRef+'" class="panel-collapse collapse '+accordianClass+'" aria-expanded="false">';
                html += '<div class="task-panel panel-body">';
                html += '<ul class="week-task-list">';

                $.each(valueObject.tasks, function (index, value) {

                    var taskId = value.id;
                    var title = value.title;
                    var inner = value.type;
                    // console.log(inner);
                    var estimatedTime = value.estimated_time;
                    ////////////////////
                    //////Task Week/////
                    ////////////////////
                    var taskWeek = value.priority;

                    // var isChecked = ( (value.user_id == user) && (value.status === 'done' && requestedTabPost !== 'open') ) ? "checked" : "";
                    var isChecked = '';

                    if(value.marketing_tasks && value.marketing_tasks.length !== 0)
                    {
                        isChecked = (value.marketing_tasks[0]['status'] === 'done') ? "checked" : '';
                    }
                    else
                    {
                        isChecked = (requestedTabPost === 'done') ? "checked" : '';
                    }

                    // console.log("isChecked");
                    // console.log(isChecked);
                    // if task is not checked then show title  Click when done.
                    var tooltipTitle = (isChecked === '') ? 'Click when done.' : 'Click to reopen.';
                    var liClass = 'no-week';

                    if(taskWeek != null ) {
                        html += '<h3 class=' + 'week' + taskWeek + ' style="padding-left: 15px; font-weight:600; padding-top:15px">'+value.name+'</h3>';

                        liClass = 'week';
                    }

                    // if(taskWeek != null ){
                    //     if( taskWeek == 0 ){
                    //         html += '<h3 class=' + 'week'+taskWeek+ ' style="padding-left: 15px; font-weight:600; padding-top:15px">Introduction</h3>';
                    //     }
                    //     if((taskWeek == 1) || (taskWeek == 2) || (taskWeek == 3) || (taskWeek == 4)){
                    //         html += '<h3 class=' + 'week'+taskWeek+ ' style="padding-left: 15px; font-weight:600; padding-top:15px">' + 'Week ' + taskWeek  + '</h3>';
                    //     }
                    //     if( taskWeek == 5 ){
                    //         html += '<h3 class=' + 'week'+taskWeek+ ' style="padding-left: 15px; font-weight:600; padding-top:15px">Optional</h3>';
                    //     }
                    //     if( taskWeek == 6 ){
                    //         html += '<h3 class=' + 'week'+taskWeek+ ' style="padding-left: 15px; font-weight:600; padding-top:15px">Campaign Completed</h3>';
                    //     }
                    //     if( taskWeek == 7 ){
                    //         html += '<h3 class=' + 'week'+taskWeek+ ' style="padding-left: 15px; font-weight:600; padding-top:15px">Resources</h3>';
                    //     } if( taskWeek == 8 ){
                    //         html += '<h3 class=' + 'week'+taskWeek+ ' style="padding-left: 15px; font-weight:600; padding-top:15px">Tips / Guide</h3>';
                    //     }if( taskWeek == 9 ){
                    //         html += '<h3 class=' + 'week'+taskWeek+ ' style="padding-left: 15px; font-weight:600; padding-top:15px">Marketing Tasks</h3>';
                    //     }
                    //     liClass = 'week';
                    // }

                    if(inner == 'inner') {
                        html += '<lh>' +
                                '<h3 style="margin-top: 15px;margin-bottom: 5px; font-weight: 600;font-size: 14px; padding-left: 15px">Campaign Completed</h3>' +
                                '</lh>';
                    }
                    html += '<li class="'+liClass+'" data-task-id="' + taskId + '">';

                    html += '<div class="checkbox checkbox-info lg-checkbox checkbox-circle" id="taskOuter'+taskId+'">';
                    html += '<input id="checkbox-' + taskId + '" type="checkbox" data-toggle="tooltip" data-placement="top" data-selector="true" title="'+tooltipTitle+'" '+ isChecked +'>';
                    html += '<label>';
                    html += '<span style="width: 70%;white-space: normal;">' + title + '</span>';
                    html += '</label>';
                    html += '</div>';

                    // html += '<i class="mdi mdi-chevron-right pull-right"></i>';

                    if(estimatedTime)
                    {
                        html += '<div class="read-time">\n' +
                            '<i class="fa fa-clock-o" aria-hidden="true"></i>\n' +
                            estimatedTime+' mins\n' +
                            '</div>';
                    }

                    html += '</li>';

                });

                html += '</ul>';
                html += '</div>';
                html += '</div>';
            }
            else
            {
                html += '<div id="collapse'+indexCategoryRef+'" class="panel-collapse collapse '+accordianClass+'" aria-expanded="false">';
                html += '<div class="task-panel panel-body">';
                html += '<p style="margin-left: 15px;">No Task Found in this section.</p>';
                html += '</div>';
                html += '</div>';

            }

            html +='</div>';
        }
    });
    return html;
}

function loadRecurringPosts( requestedTabPost ) {
    return false;
    var formData = false;
    if (window.FormData) formData = new FormData();

    var baseUrl = $('#hfBaseUrl').val();

    data = {
        'send': 'retrieve-recurring-tasks',
        'status': requestedTabPost
    };

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },
        type: "POST",
        url: baseUrl + "/done-me",
        data: data
    }).done(function (result) {
        // console.log("loaded recurring tasks");
        // parse data into json
        var json = $.parseJSON(result);

        // get data
        var statusCode = json.status_code;
        var statusMessage = json.status_message;

        var called = requestedTabPost;

        var tabsPostList = $('.website-task-list .tab-pane'); // posts holder area

        var calledID = tabsPostList.attr('id');
        tabsPostList.attr('id', called);

        $('.website-task-list .loader').hide();
        $('.task-description-area .loader-container').hide();

        var data = json.data;
        var totalTasks = json.data.length;

        // console.log("recurring data");
        // console.log(data);
        if (statusCode === 200) {
            var html = '';
            var user = $('#hfCurrent').val();

            var accordianClass= '';

            html += '<div class="recurring-list panel panel-default">';
            html += '<div class="recurring-panel panel-body">';

            if(requestedTabPost === 'done')
            {
                html += '<h3 style="font-weight: 700;margin-top: 0px;font-size: 20px;text-transform: capitalize;border-top: 1px solid #ddd;padding-top: 30px;">Recurring Tasks</h3>';
            }
            else
            {
                html += '<h3 style="font-weight: 700;margin-top:0;font-size: 20px;text-transform: capitalize;">Recurring Tasks</h3>';
            }

            if(data.length != 0) {
                html += '<ul>';

                $.each(data, function (index, value) {

                    var taskId = value.id;
                    var businessTaskId = value.business_task_id;
                    var title = value.title;
                    var estimatedTime = value.estimated_time;
                    var availableTime = value.available_clickable_at;
                    var readyForDone = value.readyForDone;

                    // var isChecked = ( (value.user_id == user) && (value.status === 'done' && requestedTabPost !== 'open') ) ? "checked" : "";
                    var isChecked = '';

                    if(value.marketing_tasks && value.marketing_tasks.length !== 0)
                    {
                        // console.log("special in ");
                        isChecked = (value.marketing_tasks[0]['status'] === 'done') ? "checked" : '';
                    }
                    else
                    {
                        // console.log("special in else ");
                        isChecked = (requestedTabPost === 'done') ? "checked" : '';
                    }

                    // console.log("isChecked");
                    // console.log(isChecked);
                    // if task is not checked then show title  Click when done.
                    var tooltipTitle = (isChecked === '') ? 'Click when done.' : 'Click to reopen.';

                    html += '<li data-ready-for-done="'+readyForDone+'" data-available-at="'+availableTime+'" data-business-task-id="' + businessTaskId + '" data-task-id="' + taskId + '">';
                    html += '<div class="checkbox checkbox-info lg-checkbox checkbox-circle">';
                    html += '<input id="checkbox-' + taskId + '" type="checkbox" data-toggle="tooltip" data-placement="top" data-selector="true" title="'+tooltipTitle+'" '+ isChecked +'>';
                    html += '<label>';
                    html += '<span style="width: 70%;white-space: normal;">' + title + '</span>';
                    html += '</label>';
                    html += '</div>';
                    // html += '<i class="mdi mdi-chevron-right pull-right"></i>';

                    if(availableTime)
                    {
                        availableTime = $.datepicker.formatDate('DD, MM yy', new Date(availableTime));
                        html += '<div class="read-time">\n' +
                            availableTime +
                            '</div>';
                    }

                    html += '</li>';

                });

                html += '</ul>';

                // if(requestedTabPost == 'open')
                // {
                //         html += '<div class="recurring-list panel panel-default">';
                //         html += '<div class="recurring-panel panel-body">';
                //         html += '<h3  style="font-weight: 700;margin-top:0;">Recurring Tasks</h3>';
                //         html += '<ul>';
                //
                //         $.each(data, function (index, value) {
                //
                //             var taskId = value.id;
                //             var title = value.title;
                //             var estimatedTime = value.estimated_time;
                //
                //             // var isChecked = ( (value.user_id == user) && (value.status === 'done' && requestedTabPost !== 'open') ) ? "checked" : "";
                //             var isChecked = '';
                //
                //             if(value.marketing_tasks && value.marketing_tasks.length !== 0)
                //             {
                //                 isChecked = (value.marketing_tasks[0]['status'] === 'done') ? "checked" : '';
                //             }
                //             else
                //             {
                //                 isChecked = (requestedTabPost === 'done') ? "checked" : '';
                //             }
                //
                //             console.log("isChecked");
                //             console.log(isChecked);
                //             // if task is not checked then show title  Click when done.
                //             var tooltipTitle = (isChecked === '') ? 'Click when done.' : 'Click to reopen.';
                //
                //
                //             html += '<li data-task-id="' + taskId + '">';
                //             html += '<div class="checkbox checkbox-info lg-checkbox checkbox-circle">';
                //             html += '<input id="checkbox-' + taskId + '" type="checkbox" data-toggle="tooltip" data-placement="top" data-selector="true" title="'+tooltipTitle+'" '+ isChecked +'>';
                //             html += '<label>';
                //             html += '<span>' + title + '</span>';
                //             html += '</label>';
                //             html += '</div>';
                //             // html += '<i class="mdi mdi-chevron-right pull-right"></i>';
                //
                //             if(estimatedTime)
                //             {
                //                 html += '<div class="read-time">\n' +
                //                     '<i class="fa fa-clock-o" aria-hidden="true"></i>\n' +
                //                     estimatedTime+' mins\n' +
                //                     '</div>';
                //             }
                //
                //             html += '</li>';
                //
                //         });
                //
                //         html += '</ul>';
                //         html += '</div>';
                //         html += '</div>';
                // }
                // else
                // {
                //     $.each(data, function (indexCategory, valueObject) {
                //
                //         html +='<div class="data-list panel panel-default">';
                //         html +='<div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#collapse'+indexCategory+'" aria-expanded="true">';
                //         html +='<h3 style="font-weight: 700;">'+ valueObject.name +'</h3>';
                //         // html +='<i class="fa fa-chevron-down" aria-hidden="true"></i>';
                //         html +='<img src="'+baseUrl+'/public/images/chaveron-arrow.png" class="chevron-down" />';
                //         html +='</div>';
                //
                //         accordianClass = (indexCategory === 0) ? 'in' : '';
                //
                //         if(valueObject.tasks.length != 0)
                //         {
                //             console.log("inside");
                //             console.log(valueObject.tasks);
                //
                //             html += '<div id="collapse'+indexCategory+'" class="panel-collapse collapse '+accordianClass+'" aria-expanded="false">';
                //             html += '<div class="recurring-panel panel-body">';
                //             html += '<ul>';
                //
                //             $.each(valueObject.tasks, function (index, value) {
                //
                //                 var taskId = value.id;
                //                 var title = value.title;
                //                 var estimatedTime = value.estimated_time;
                //
                //                 // var isChecked = ( (value.user_id == user) && (value.status === 'done' && requestedTabPost !== 'open') ) ? "checked" : "";
                //                 var isChecked = '';
                //
                //                 if(value.marketing_tasks && value.marketing_tasks.length !== 0)
                //                 {
                //                     isChecked = (value.marketing_tasks[0]['status'] === 'done') ? "checked" : '';
                //                 }
                //                 else
                //                 {
                //                     isChecked = (requestedTabPost === 'done') ? "checked" : '';
                //                 }
                //
                //                 console.log("isChecked");
                //                 console.log(isChecked);
                //                 // if task is not checked then show title  Click when done.
                //                 var tooltipTitle = (isChecked === '') ? 'Click when done.' : 'Click to reopen.';
                //
                //
                //                 html += '<li data-task-id="' + taskId + '">';
                //                 html += '<div class="checkbox checkbox-info lg-checkbox checkbox-circle">';
                //                 html += '<input id="checkbox-' + taskId + '" type="checkbox" data-toggle="tooltip" data-placement="top" data-selector="true" title="'+tooltipTitle+'" '+ isChecked +'>';
                //                 html += '<label>';
                //                 html += '<span>' + title + '</span>';
                //                 html += '</label>';
                //                 html += '</div>';
                //
                //                 // html += '<i class="mdi mdi-chevron-right pull-right"></i>';
                //
                //                 if(estimatedTime)
                //                 {
                //                     html += '<div class="read-time">\n' +
                //                         '<i class="fa fa-clock-o" aria-hidden="true"></i>\n' +
                //                         estimatedTime+' mins\n' +
                //                         '</div>';
                //                 }
                //
                //                 html += '</li>';
                //
                //             });
                //
                //             html += '</ul>';
                //             html += '</div>';
                //             html += '</div>';
                //         }
                //         else
                //         {
                //             html += '<div id="collapse'+indexCategory+'" class="panel-collapse collapse '+accordianClass+'" aria-expanded="false">';
                //             html += '<div class="recurring-panel panel-body">';
                //             html += '<p>No Task Found in this section.</p>';
                //             html += '</div>';
                //             html += '</div>';
                //         }
                //
                //         html +='</div>';
                //     });
                // }
            }
            else
            {
                html += '<p>No Task Found</p>';
            }

            html += '</div>';
            html += '</div>';

            // console.log("recurring tabsPostList");
            // console.log(tabsPostList);

            if (calledID !== '' && calledID === called) {
                $(".recurring-list").remove();
                $(".task-list-wrapper").append(html);
                // $('.task-list-wrapper', tabsPostList).fadeIn('slow', function () {
                //     $('.task-list-wrapper', tabsPostList).after(html);
                // });
            }
            else {
                $('.task-list-wrapper', tabsPostList).html('');
                $('.task-list-wrapper', tabsPostList).html(html);
            }

            taskActions();

            /**
             * target to first element of tabs when page load.
             * make sure first task will be clickable of recurrin panel if daily task panel no task exist.
             * because first daily task loaded and then immidiately loaded first task detail. so here
             * I check If already loaded the first task from first panel then don't need to call again.
             */
            if($('.website-task-list .task-panel li label:first').length == 0)
            {
                // console.log("inside of click 1");
                /**
                 * target to first element of tabs when page load.
                 */
                $('.website-task-list li label:first').click();
                // $(".task-description").show();
            }
        }
        else
        {
            var descriptionArea = $('.task-description');

            descriptionArea.show();
            descriptionArea.html('<div class="page-content" style="font-size: 18px; text-align: center;">No Task Selected.</div>');

            // $('ul', tabsPostList).append('No Task Found.');
        }

        taskScreenDimensionManager();
    });
    return false;
}

/**
 * 1-
 * load task content by task id
 * 2-
 * change task status against required action
 * status: open <-> done
 */
function taskActions()
{
    initiateTooltip();

    if($('.website-task-list li label:first').length === 0)
    {
        setTimeout(function () {
            $(".task-description").show();
            $(".task-description").height($(".full-page-view").height());
            $(".task-description").html('<div class="page-content" style="font-size: 18px; text-align: center;">No Task Selected.</div>');
        }, 100);
    }
}
var currentDataListItemSelected ;
// get Task Detail by id
$(document.body).on('click','.website-task-list li label, .website-task-list li i, .data-list.no-access',function ()
{
    // console.log('jj')
    currentDataListItemSelected = $(this);
    // if (window.innerHeight > 720)
    // {
    //     boxHeight = window.innerHeight - 350;
    //     console.log('on same tab change');
    //     console.log(boxHeight);
    //     $('.white-box').height(boxHeight+'px');
    // }
    // else
    // {
    //     boxHeight = window.innerHeight - 30;
    //     $('.white-box').height(boxHeight+'px');
    // }

    var baseUrl = $('#hfBaseUrl').val();

    var callSource = '';
    var taskId = '';

    if(isEmptyValNormal($(this).attr("data-source")) == false)
    {
        callSource = $(this).attr("data-source");
        taskId = $(this).attr('data-id');
    }
    else
    {
        taskId = $(this).closest('li').attr('data-task-id');
    }

    if(window.firstTimeLoad !=true){
        // setTimeout(function () {
        // $('html,body').animate({ scrollTop: 9999 }, 'slow');
        // },100);
    }
    window.firstTimeLoad=false;

    $('.task-description-area .loader-container').show();
    var taskDes = $('.task-description');
    taskDes.hide();

    var businessTaskId = $(this).closest('li').attr('data-business-task-id');
    var taskAvailableAt = $(this).closest('li').attr('data-available-at');
    var taskAvailableForDone = $(this).closest('li').attr('data-ready-for-done');

    $('.website-task-list ul li').removeClass('active');
    $(this).closest('li').addClass('active');

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },
        type: "POST",
        url: baseUrl + "/done-me",
        data: {
            'send': 'task-detail',
            'id': taskId,
            'businessTaskId': businessTaskId,
            'source': callSource
        }
    }).done(function (result) {
        // parse data into json
        //     if(window.innerHeight > 720)
        //     {
        //         boxHeight = $(document).innerHeight() - 120;
        //         console.log('boxHeight to paply');
        //         console.log(boxHeight);
        //         $('.white-box').height(boxHeight+'px');
        //     }
        //     else
        //     {
        //         boxHeight = $(document).innerHeight() - 30;
        //         $('.white-box').height(boxHeight+'px');
        //     }

        var json = $.parseJSON(result);

        // get data
        var statusCode = json.status_code;
        var statusMessage = json.status_message;

        var data = json.data;
        // console.log('data');
        var feed = data.campaign_feedback;
        var comment = '';
        var starRating = '';
        if(feed.length > 0) {
            // console.log(feed);
            // console.log(feed[0].id);
            comment = (isEmptyValNormal(feed[0].comment) == false) ? feed[0].comment : '';
            starRating = feed[0].star_rating;

        }
        // console.log(comment);
        // console.log(starRating);
        $('.task-description .loader').hide();
        $('.task-description-area .loader-container').hide();
        var taskDes = $('.task-description');
        taskDes.show();
        var taskType = data.type;
        // console.log('taskType');
        // console.log(taskType);
        var doneStatus = window.currentActiveTab;
        var disableField = '';
        if (statusCode === 200) {
            // if($('li[data-task-id="'+taskId+'"]').attr('class') != 'active' && callSource == "")
            if($('li[data-task-id="'+taskId+'"]').hasClass('active')  === false && callSource == "")
            {
                $('.task-description .task-contain[data-task-id="'+taskId+'"]').remove();
                var descriptionArea = $('.task-description');

                descriptionArea.show();
                descriptionArea.html('<div class="page-content" style="font-size: 18px; text-align: center;">No Task Selected.</div>');
            }
            else
            {
                var html = '';

                if(data !== '')
                {
                    var user = $('#hfCurrent').val();
                    // var isChecked = ( (data.user_id == user) && (data.status === 'done') ) ? "checked" : "";
                    var isChecked = '';

                    // if task is not checked then show title  Click when done.
                    var tooltipTitle = (isChecked === '') ? 'Click when done.' : 'Click to reopen.';
                    var taskClass = (data.issue == 37 || data.issue == 38) ? 'col-sm-9' : 'col-sm-12';

                    // data.task_id
                    // html += '<div class="task-contain" data-task-content="'+data.business_task_id+'">';

                    var credits = '';
                    if(isEmptyVal(data.credits) === false)
                    {
                        credits = data.credits;
                    }

                    var category_type = data.category_type;
                    var mark_as_complete_check = data.mark_as_complete_check;

                    // console.log('taskType');
                    // console.log(taskType);
                    if(isEmptyValNormal(businessTaskId) == true)
                    {
                        businessTaskId = '';
                    }

                    html += '<div class="task-contain '+callSource+'" data-task-credits="'+credits +'" data-task-business-content="'+businessTaskId+'" data-task-content="'+taskId+'">';

                    html +=     '<div class="row">';

                    html +=     '<div class="'+taskClass+'">';

                    //html +=     '<div class="checkbox checkbox-info lg-checkbox checkbox-circle">';
                    //html +=         '<input type="checkbox" ' + isChecked + ' data-toggle="tooltip" data-selector="true" data-placement="top" title="'+tooltipTitle+'">';
                    //html +=         '<label for="checkbox"></label>';
                    //html +=     '</div>';
                    var showCompleteButton = true;

                    if(isChecked=='checked'){
                        html += '<button class="btn btn-success mark_as_complete"  data-loading-text="<i class=\'fa fa-spinner fa-spin \'></i> Please wait..."><i class="mdi mdi-check"></i> Completed</button>';
                    }
                    else{
                        if(taskAvailableAt && taskAvailableAt != 'null')
                        {
                            // task available and matched with today date then show complete button else hide
                            if(taskAvailableForDone == true || taskAvailableForDone == "true")
                            {
                                showCompleteButton = true;
                            }
                            else
                            {
                                showCompleteButton = false;
                            }
                        }

                        // console.log("button status of showCompleteButton >>" + showCompleteButton)
                        if(showCompleteButton === true)
                        {
                            if(category_type != 'non-marketing-campaign' || mark_as_complete_check === 1 || taskType == 'inner')
                            {
                                // console.log("bbbb inside");
                                html += '<button class="btn btn-default mark_as_complete"  data-loading-text="<i class=\'fa fa-spinner fa-spin \'></i> Please wait..."><i class="mdi mdi-check"></i> Mark as Complete</button>';
                            }

                        }
                    }

                    if(businessTaskId)
                    {

                    }
                    else
                    {
                        if(category_type != 'non-marketing-campaign' || mark_as_complete_check === 1  || taskType == 'inner')
                        {
                            // html += '<button class="btn btn-default mark_as_skip" data-loading-text="<i class=\'fa fa-spinner fa-spin \'></i> Please wait..."><i class="mdi mdi-cross">X</i> Skip This Task</button>';
                            html += '';
                        }
                    }

                    if (callSource == 'category') {
                        html += '<button class="btn unlock-campaign" style="float: right;background: #125680;color: #ffffff;">UNLOCK CAMPAIGN</button>';
                    }

                    html +=     '</div>';

                    if(data.issue == 37 || data.issue == 38) {
                        html +=     '<div class="col-sm-3">';
                        html +=      '<button class="btn btn-default send-task pull-right" data-original-task="'+data.task_id+'"><i class="fa fa-paper-plane" aria-hidden="true"></i> Email Task</button>';
                        html +=     '</div>';
                    }

                    html +=     '<div class="skip-task-container">';

                    if(data.status === "skipped") {
                        html += '<button class="skip-task btn btn-info right btn-outline btn-sm" data-target-status="open" data-loading-text=" <i class=\'fa fa-spinner fa-spin\'></i> Restoring">';
                        html += '<i class="mdi mdi-backup-restore"></i> Restore</button>';
                    }
                    else if(data.status === "open")
                    {
                        // html += '<button class="skip-task btn btn-info right btn-outline btn-sm" data-target-status="skipped" data-loading-text=" <i class=\'fa fa-spinner fa-spin\'></i> Skipping">';
                        // html += '<i class="mdi mdi-close"></i> Skip</button>';
                    }

                    html +=     '</div>';

                    html +=     '</div>';

                    html +=     '<hr style="margin-bottom: 13px;">';
                    html +=     '<div class="text-muted task-des-title" style="color: #313131; font-size: 21px; font-weight: 300; line-height: 30px; margin-top: 0;">'+data.title+'</div>';

                    html +=     '<div class="m-t-20" style="display:none;"><h3>'+data.title+'</h3></div>';
                    // html +=     '<div class="meta-title-tags"><span>Basketball sneakers</span><span>Basketball Gear</span></div>';
                    html +=     '<hr style="margin-top: 10px;">';

                    html +=     '<div class="page-content" style="padding-right: 10px;">';

                    if(data.module === 'website' && data.textFormatType === 'speed')
                    {
                        html +=     '<div class="web-speed-wrapper">';
                        var speedStatus = '';
                        var speedColor = '';
                        var speedScore = '';

                        if(data.score) {
                            speedScore = data.score;
                            if (speedScore <= 69) {
                                speedStatus = 'Poor';
                                speedColor = '#ff0000';
                            }
                            else if (speedScore >= 70 && speedScore <= 84) {
                                speedStatus = 'Average';
                                speedColor = '#fda100';
                            }
                            else {
                                speedStatus = 'Good';
                                speedColor = '#008000';
                            }
                        }
                        // speed header
                        html +=         '<div class="web-speed-header">';

                        html +=             '<div class="status-matter">';
                        html +=             '<div class="GaugeMeter" id="GaugeMeter_1" data-text= "'+speedStatus+'" data-size= "150" data-color="'+speedColor+'"  data-width="10" data-percent="'+speedScore+'"> </div>';
                        html +=             '</div>';

                        html +=                  '<div class="status-caption">';

                        if(data.issue == 37) {
                            html += '<h3>Mobile-Friendly Optimization Score</h3>';
                        }
                        else if(data.issue == 38) {
                            html += '<h3>Page Speed Optimization Score</h3>';
                        }

                        if(speedStatus) {
                            html +=                      '<h4><span>' + speedScore + '</span> / 100 </h4>';
                        }
                        else
                        {
                            html +=                       '<h4><span>Not found</span></h4>';
                        }
                        html +=                       '<h4><span style="font-size: 17px; font-weight: 400;"> URL: '+ data.website +'</span></h4>';
                        html +=                 '</div>';
                        html +=             '<div class="clearfix"></div>';

                        html +=            '<div class="m-t-20">';

                        if(isEmptyValNormal(data.description) == false) {
                            html += data.description;
                        }

                        html +=             '</div>';
                        html +=         '<hr>';
                        html +=         '</div>'; // speed header

                        html +=         '<div class="web-speed-body">';

                        html += '<h3 class="severity"><span class="status-alert warning"><i class="mdi mdi-exclamation"></i></span>Possible Optimizations</h3>';

                        if(data.possibleOptimization && data.possibleOptimization != '') {
                            html += localizedFormattedData(data.possibleOptimization, 'possible-optimization');
                        }
                        else if( (data.possibleOptimization && data.possibleOptimization == '') && speedStatus != '')
                        {
                            html += 'Good work! Your website is fully optimized. There\'s nothing to do here.';
                        }


                        html += '<h3 class="severity"><span class="status-alert success"><i class="mdi mdi-check"></i></span>Optimizations Found</h3>';
                        html += localizedFormattedData(data.optimizationFound, 'optimization-found');

                        html +=     '</div>'; // speed body

                        html +=     '</div>'; // speed wrapper
                    }
                    else
                    {
                        if(data.description) {
                            // console.log('here 1');
                            html += (isEmptyValNormal(data.description) == false) ? data.description : '';

                            // if(data.review_url && data.review_url !== '') {
                            //     html += '<a href="'+data.review_url+'" target="_blank">';
                            //     html += data.review_url;
                            //     html += '</a>';
                            // }

                            if(data.issue === 1)
                            {
                                html += '<div class="action-footer">';
                                html += '<div class="row">';
                                html += '<div class="col-md-12 text-center">';
                                html += '<a href="javascript:void(0)" data-toggle="modal" data-id="website-Order-Confirm" class="btn btn-info confirm-web">Send an Inquiry</a>';
                                html += '<img class="web-loader" src="'+baseUrl+'/public/images/spinner.gif" style="display:none; width:40px;">';
                                html += '</div>';
                                html += '</div>';
                                html += '</div>';
                            }

                            if(data.objective == 18)
                            {
                                var disabledMe = (data.business_listed == 1) ? 'disabled' : '';
                                html += '<div class="action-footer" style="margin-top: 30px;">';
                                html += '<div class="row">';
                                html += '<div class="col-md-12 text-center">';

                                if(disabledMe !== '')
                                {
                                    html += '<button data-toggle="modal" class="btn btn-info list-now" disabled="'+disabledMe+'">Click Here</button>';
                                    html += '<p class="response-message m-t-10">Your request has been sent. Our support team will contact you via email.</p>';
                                }
                                else {
                                    html += '<button data-toggle="modal" class="btn btn-info list-now">Click Here</button>';
                                }

                                html += '<img class="web-loader" src="'+baseUrl+'/public/images/spinner.gif" style="display:none; width:40px;">';
                                html += '</div>';
                                html += '</div>';
                                html += '</div>';
                            }
                        }

                        if(isEmptyValNormal(data.credits_description) == false)
                        {
                            // console.log('here 2');
                            html += '<div style="display: none;" class="task-learn-more-des">';
                            html += data.credits_description;
                            html += '</div>';
                        }

                        if(credits)
                        {
                            // console.log('here 3');

                            html += '<div class="order-preview-panel row bg-white box-width-task-list " style="border: #DDE3EE 1px solid; width: 370px; margin-left: 1px;padding: 0px;padding-top: 12px;box-shadow: 3px 3px 0.5rem 0rem rgba(0,0,0,0.75)!important;">\n' +
                                '    <div class="top-intro-panel" style="\n' +
                                '">\n' +
                                '    <div class="row">\n' +
                                '    <div class="col-xs-2" style="padding-right:8px;">\n' +
                                '       <img src="'+baseUrl+'/public/images/order-marketing-avatar-new.png" style="float:right; height:40px !important">\n' +
                                '    </div>\n' +
                                '    <div class="col-xs-10" style="padding-left:8px;">\n' +
                                '       <h4 style="font-weight:600; margin:0px; font-size: 16px;">I need a <span style="font-weight:700; color:#4167B1;">Marketing pro</span> to Help Me</h4>\n' +
                                '       <p style="margin:0px; font-size: 12px; padding-top: 2px; ">Have an expert from our team complete this task for you</p>\n' +
                                '    </div>\n' +
                                '    </div>\n' +
                                '\n' +
                                '\n' +
                                '    <div class="order-btns" style="background-color: #F4F5F8;padding-bottom: 8px;">\n' +
                                '    <h4 style="color:#4167B1;">'+credits+' Credits</h4><button class="btn btn-learn-more">Learn More</button>\n' +
                                '<input type="hidden" id="task-credits" value="'+credits+'" />'+
                                '</div>\n' +
                                '    </div>\n' +
                                '    \n' +
                                '</div>';
                        }

                        var starRatingValue = '';
                        // console.log('out st')
                        // console.log(starRating)
                        starRatingValue +=  '<ul id="stars">'+
                            '<li class="star" data-value="1">'+
                            '<i class="fa fa-star fa-fw"> </i>'+
                            '</li>'+
                            '<li class="star" data-value="2">'+
                            '<i class="fa fa-star fa-fw"></i>'+
                            '</li>'+
                            '<li class="star" data-value="3">'+
                            '<i class="fa fa-star fa-fw"></i>'+
                            '</li>'+
                            '<li class="star" data-value="4">'+
                            '<i class="fa fa-star fa-fw"></i>'+
                            '</li>'+
                            '<li class="star" data-value="5">'+
                            '<i class="fa fa-star fa-fw"></i>'+
                            '</li>'+
                            '</ul>';
                        if(starRating != '') {
                            // console.log('in st')
                            // console.log(starRating)
                            // var rate = starRating * 20;
                            // starRatingValue += '<span class="rating">'+
                            // '<span class="rating-value" style="width:'+rate+'%">'+
                            // '</span>'+
                            // '</span>';
                            // starRatingValue +=  '<ul id="stars">'+
                            //     '<li class="star" data-value="1">'+
                            //     '<i class="fa fa-star fa-fw"> </i>'+
                            //     '</li>'+
                            //     '<li class="star" data-value="2">'+
                            //     '<i class="fa fa-star fa-fw"></i>'+
                            //     '</li>'+
                            //     '<li class="star" data-value="3">'+
                            //     '<i class="fa fa-star fa-fw"></i>'+
                            //     '</li>'+
                            //     '<li class="star" data-value="4">'+
                            //     '<i class="fa fa-star fa-fw"></i>'+
                            //     '</li>'+
                            //     '<li class="star" data-value="5">'+
                            //     '<i class="fa fa-star fa-fw"></i>'+
                            //     '</li>'+
                            //     '</ul>';
                            setTimeout( function(){
                            for (var i = 1; i <= starRating; i++) {
                                // console.log('here')
                                // console.log($( '#stars li:nth-child('+i+')' ))

                                    // $( '#stars li:nth-child('+i+')' ).css("background-color", "yellow");


                                $( '#stars li:nth-child('+i+')' ).addClass('selected');
                                // $(stars[i]).addClass('selected');
                            }
                            },400)

                            // starRatingValue +=  '<ul id="stars">'+
                            //     '<li class="star" data-value="1">'+
                            //     '<i class="fa fa-star fa-fw"> </i>'+
                            //     '</li>'+
                            //     '<li class="star" data-value="2">'+
                            //     '<i class="fa fa-star fa-fw"></i>'+
                            //     '</li>'+
                            //     '<li class="star" data-value="3">'+
                            //     '<i class="fa fa-star fa-fw"></i>'+
                            //     '</li>'+
                            //     '<li class="star" data-value="4">'+
                            //     '<i class="fa fa-star fa-fw"></i>'+
                            //     '</li>'+
                            //     '<li class="star" data-value="5">'+
                            //     '<i class="fa fa-star fa-fw"></i>'+
                            //     '</li>'+
                            //     '</ul>';

                            // var stars = $('#stars').parent().children('li.star');
                            // // var stars = $(this).parent().children('li.star');
                            // for (var i = 0; i < starRating; i++) {
                            //     $(stars[i]).addClass('selected');
                            // }
                        }

                        if (taskType == 'inner') {
                            if(doneStatus == 'done') {
                                disableField = 'disabled';
                            }
                            // console.log('here 4');
                            html +='<form>'+
                                '<input type="hidden" class="form-control" id="category_id" style="display: none" value="'+data.category+'">'+
                                '<input type="hidden" class="form-control" id="task_id" style="display: none" value="'+data.id+'">'+
                                '<div class="card card-inner-rating" style="background: #5b7ea8;">'+
                                '<div class="card-body" style="padding: 20px;">'+
                                '<div style="text-align: center">'+
                                '<p class="card-title" style="color: white; font-size: 16px; font-weight: 500;">We hope this campaign was a tremendous  <br /> success for your practice.</p>'+
                                '<p class="card-text" style="color: white; font-size: 16px; font-weight: 500;">How likely are you to recommend this <br /> campaign to someone else?</p>'+


                                '<div class="rating-stars text-center" style="">'+
                                // '<ul id="stars">'+
                                starRatingValue+
                                // '<li class="star" data-value="1">'+
                                //     '<i class="fa fa-star fa-fw"> </i>'+
                                // '</li>'+
                                // '<li class="star" data-value="2">'+
                                // '<i class="fa fa-star fa-fw"></i>'+
                                // '</li>'+
                                // '<li class="star" data-value="3">'+
                                // '<i class="fa fa-star fa-fw"></i>'+
                                // '</li>'+
                                // '<li class="star" data-value="4">'+
                                // '<i class="fa fa-star fa-fw"></i>'+
                                // '</li>'+
                                // '<li class="star" data-value="5">'+
                                // '<i class="fa fa-star fa-fw"></i>'+
                                // '</li>'+
                                // '</ul>'+
                                '<span class="help-block"></span>'+
                                '</div>'+
                                '</div>'+
                                '</div>'+
                                '</div>'+

                                '<div class="form-group">'+
                                '<label for="comment">Comments: (optional)</label>'+
                                '<input type="text" class="form-control" id="comment" value="'+comment+'" '+disableField+'>'+
                                '</div>'+
                                '<div class="form-group">'+
                                '<button type="submit" class="btn btn-primary submitFeedBack">Submit</button>'+
                                '</div>'+
                                '<form>';

                        }
                        // if(starRating != '') {
                        //     console.log('in star')
                        //     // checkSelectedStar(currentDataListItemSelected);
                        //     var stars = $('#stars').children('li.star');
                        //     console.log('in star found')
                        //     console.log(stars)
                        //     for (var i = 0; i < starRating; i++) {
                        //         $(stars[i]).addClass('selected');
                        //     }
                        // }

                    }


                    html +=     '</div>';

                    html += '</div>';

                    taskDes.html('');
                    // ignoreError();
                    taskDes.html(html);
                    // ignoreError();
                    // iniateGuageMeter();
                }
                // else if(data !== '' && taskType === 'inner') {
                //     taskDes.html('');
                //     // ignoreError();
                //     taskDes.html('axx');
                // }
            }
        }
        else
        {
            taskDes.html('');
        }

        initiateTooltip();

        taskScreenDimensionManager();

        var taskIframe = $(".task-contain img, .task-contain iframe");
        // var taskIframe = $(".task-contain img");
        // console.log("iframe");
        // console.log(taskIframe);

        var noOfIframe = taskIframe.length;
        var noLoaded = 0;
        taskIframe.on('load', function() {
            noLoaded++;
            // console.log("collected" + noLoaded);
            if(noOfIframe === noLoaded) {
                // console.log("load");
                // and I need to call two functions on loaded element
                // hoverImg() need the loaded image to calculate the height
                taskScreenDimensionManager();
            }
        });

        taskIframe.on('error', function() {
            // console.log("error found number > "+noLoaded);
            noLoaded++;
            if(noOfIframe === noLoaded) {
                // console.log("load");
                // and I need to call two functions on loaded element
                // hoverImg() need the loaded image to calculate the height
                taskScreenDimensionManager();
            }
        });

        $('.task-contain .page-content').css({
            // 'height': windowHeight - 11,
            '-webkit-overflow-scrolling':'touch'
        });
        // $('.task-contain .page-content').slimScroll({
        //     height: windowHeight - 11,
        //     size: '5px',
        //     alwaysVisible: true,
        //     allowPageScroll: false
        // });

        var len=$(".collapse").length-1;
        $(".collapse:eq("+len+")").on('show.bs.collapse', function(){
            setTimeout(function () {
                //$('.task-contain .page-content').slimScroll({ scrollTo: '999999px' });
                $('.task-contain .page-content').animate({ scrollTop: 9999 }, 'slow');
                $('html,body').animate({ scrollTop: 9999 }, 'slow');
            },100);
        });
        setTimeout(function(){
            if(window.innerHeight > 720)
            {
                boxHeight = $(document).innerHeight() - 120;

                $('.white-box').height(boxHeight+'px');
            }
            else
            {
                boxHeight = $(document).innerHeight() - 30;
                $('.white-box').height(boxHeight+'px');
            }
        },1000);



        // setTimeout(function() {
        //     taskScreenDimensionManager();
        // }, 2000);

        // $(window).on("load", taskDes, function() {
        //     console.log("sssssssssssssssssssssssssssssssssssssssssssssssssssssssss");
        //     // weave your magic here.
        //     taskScreenDimensionManager();
        // });

    });
});
var currentCampaignforPaidUser;
var creditsforPaidUser;
var currentTargetCampaign;
$(document.body).on('click','.campaign-library-row .btn-template-edit',function (){
    currentCampaignforPaidUser  = $(this).attr("data-campaign-target");
    creditsforPaidUser = $(this).attr("data-credits");
    currentTargetCampaign = $(this);
});
$(document.body).on('click','.unlock-campaign',function (){

    var accountStatus = $('#isActivePaid').val();
    var baseUrl = $('#hfBaseUrl').val();

    // var currentCampaignTargeted = window.currentTargetCampaign;
    //
    // var parent = currentCampaignTargeted.closest('.list-marketing-campaign');
    //
    // var templateNameDiv = parent.find('.template-name');
    //
    // var templateName = templateNameDiv.text();
    // console.log(parent);
    // console.log(templateNameDiv);
    // console.log(templateName);
    // return;
    if(accountStatus == true)
    {
        showPreloader();

        // getting campaign title
        var currentCampaignTargeted = window.currentTargetCampaign;

        var parent = currentCampaignTargeted.closest('.list-marketing-campaign');

        var templateNameDiv = parent.find('.template-name');

        var templateName = templateNameDiv.text();


        // unlock campaign
        var taskId = $(this).closest('.task-contain').attr('data-task-content');


        var purchase = '';
        if(isEmptyValNormal(window.currentPageSource) == false && window.currentPageSource == 'campaign_library')
        {
            taskId = $(this).attr("data-target");
            purchase = $(this).attr("data-purchase");
        }

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            type: "POST",
            url: baseUrl + "/done-me",
            data: {
                'send': 'unlock-campaign',
                'campaign': taskId,
                purchase: purchase,
                'campaignTitle': templateName
            }
        }).done(function (result) {
            hidePreloader();
            // parse data into json
            var json = $.parseJSON(result);

            // get data
            var statusCode = json.status_code;
            var statusMessage = json.status_message;
            var data = json.data;

            if(statusCode == 200)
            {
                // swal({
                //     title: "",
                //     text: statusMessage,
                //     type: "success"
                // });

                if(isEmptyValNormal(window.currentPageSource) == false && window.currentPageSource == 'campaign_library')
                {
                    $(".modal-campaign-library .close").click();
                    $(".modal-task-order .close").click();

                    $(".marketing-campaign-"+taskId).addClass('unlocked-campaign');

                    if(isEmptyValNormal(data.creditsBalance) == false)
                    {
                        // console.log("inside check val");
                        $(".sidebar-available-credits h1").html(data.creditsBalance);
                    }
                }
                else
                {
                    $('.task-tabs li a:first').click();
                }
                swal({
                    title: "",
                    text: statusMessage,
                    type: "success"
                }, function(){
                    window.location = baseUrl+"/task-list";
                });
            }
            else if(statusCode == 404)
            {
                var mainModel = $('#main-modal');
                window.statusMessage = statusMessage;

                notEnoughCredits(mainModel);
            }
            else
            {
                if( statusCode == 3) {


                    $('#main-modal').modal('hide');

                    swal({
                        title: "",
                        text: statusMessage,
                        type: "error"
                    });

                    // console.log('here');
                    // // setTimeout(function () {
                    //     // $('#main-modal').modal('hide');
                    // // $(".close-btn").click();
                    // var planSelected = $('#planSelected').val();
                    // var campaignName = $(".template-name", ".marketing-campaign-"+currentCampaignforPaidUser).html();
                    // if(planSelected == 1){
                    //     console.log('here 1');
                    //     setTimeout(function () {
                    //
                    //
                    //         var mainModel = $('#main-modal');
                    //         $(".modal-body, .modal-footer, .validate-me", mainModel).remove();
                    //         $(mainModel).removeClass('welcome-process');
                    //         $(mainModel).addClass('modal-campaign-library2');
                    //
                    //         var campaignOverloaded = '<p>Paid subscribers of nichepractice can unlock 2 marketing campaigns' +
                    //             ' each month for free or you can purchase the campaigns. All active ' +
                    //             'campaigns will appear in your To-Do-List page</p>';
                    //
                    //         var html = '<div class="modal-body">\n' +
                    //             '                                <div class="description-order" style="margin-bottom: 35px;">\n' +
                    //             campaignOverloaded +
                    //             '\n' +
                    //             '                                </div>\n' +
                    //             '                                <div class="row modal-order-action">\n' +
                    //             // '<button class="btn btn-campaign unlock-campaign" data-target="' + currentCampaign + '">YES</button>\n' +
                    //             '<button class="btn get-campaign unlock-campaign" style="border: 1px solid #000000" data-target="'+currentCampaignforPaidUser+'" data-purchase="1">GET THIS CAMPAIGN FOR Credits '+creditsforPaidUser+'</button>\n' +
                    //             // '<button class="btn close-btn" data-dismiss="modal">NO</button>\n' +
                    //             '                                </div>\n' +
                    //             '                            </div>';
                    //
                    //         mainModel.modal('show');
                    //         $(".modal-campaign-library2 .modal-header").prepend('<h3 class="modal-campaign-title">'+campaignName+'</h3>');
                    //         $(".modal-campaign-library2 .modal-header").after(html);
                    //
                    //     }, 500);
                    // }
                    // else if(planSelected == 2){
                    //     console.log('here 2');
                    //     setTimeout(function () {
                    //
                    //
                    //         var mainModel = $('#main-modal');
                    //         $(".modal-body, .modal-footer, .validate-me", mainModel).remove();
                    //         $(mainModel).removeClass('welcome-process');
                    //         $(mainModel).addClass('modal-campaign-library2');
                    //
                    //         var campaignOverloaded = '<p>Paid subscribers of nichepractice can unlock 2 marketing campaigns' +
                    //             ' each month for free or you can purchase the campaigns. All active ' +
                    //             'campaigns will appear in your To-Do-List page</p>';
                    //
                    //         var html = '<div class="modal-body">\n' +
                    //             '                                <div class="description-order" style="margin-bottom: 35px;">\n' +
                    //             campaignOverloaded +
                    //             '\n' +
                    //             '                                </div>\n' +
                    //             '                                <div class="row modal-order-action">\n' +
                    //             // '<button class="btn btn-campaign unlock-campaign" data-target="' + currentCampaign + '">YES</button>\n' +
                    //             '<button class="btn get-campaign unlock-campaign" style="border: 1px solid #000000" data-target="'+currentCampaignforPaidUser+'" data-purchase="1">GET THIS CAMPAIGN FOR Credits '+creditsforPaidUser+'</button>\n' +
                    //             // '<button class="btn close-btn" data-dismiss="modal">NO</button>\n' +
                    //             '                                </div>\n' +
                    //             '                            </div>';
                    //
                    //         mainModel.modal('show');
                    //         $(".modal-campaign-library2 .modal-header").prepend('<h3 class="modal-campaign-title">Loyalty Building Using Promotions</h3>');
                    //         $(".modal-campaign-library2 .modal-header").after(html);
                    //
                    //     }, 500);
                    // }

                }
                else {
                    swal({
                        title: "",
                        text: statusMessage,
                        type: "error"
                    });
                }
            }
        });
    }
    else
    {
        $(".modal-task-order .close").click();

        setTimeout(function () {

            var mainModel = $('#main-modal');
            $(".modal-body, .modal-footer, .validate-me", mainModel).remove();
            $(mainModel).removeClass('welcome-process');
            $(mainModel).addClass('modal-upgrade-library');

            var orderDes = '<p>In order to unlock this campaign, please sign up for a monthly subscription. We’re excited to have you join our family!</p>';

            var html = '<div class="modal-body">\n' +
                '                                <div class="description-order" style="margin-bottom: 35px;">\n' +
                orderDes +
                '\n' +
                '                                </div>\n' +
                '                                <div class="row modal-order-action">\n' +
                '<a href="'+baseUrl+'/upgrade" class="btn btn-login" style="margin: 0px auto;display: table;">Join Nichepractice</a>\n'+
                '                                </div>\n' +
                '                            </div>';

            mainModel.modal('show');
            $(".modal-upgrade-library .modal-header").prepend('<h3 class="modal-campaign-title">Subscription Required</h3>');
            $(".modal-upgrade-library .modal-header").after(html);

        },500);
        // swal({
        //     title: "",
        //     html: true,
        //     text: "To select this campaign, <a href='"+baseUrl+"/upgrade' style='border-bottom: 1px solid;'>click here</a> to upgrade your account",
        //     type: "info"
        // });
        // showPreloader();
        // location.href = baseUrl+'/upgrade';
    }
});

$(document.body).on('click','.campaign-library-row .btn-template-edit',function (){
    var accountStatus = $('#isActivePaid').val();
    var baseUrl = $('#hfBaseUrl').val();
    var planSelected = $('#planSelected').val();

    if(accountStatus == true)
    {
        var currentCampaign = $(this).attr("data-campaign-target");
        var credits = $(this).attr("data-credits");

        var campaignName = $(".template-name", ".marketing-campaign-"+currentCampaign).html();

        var mainModel = $('#main-modal');
        $(".modal-body, .modal-footer, .validate-me", mainModel).remove();
        $(mainModel).removeClass('welcome-process');
        $(mainModel).addClass('modal-campaign-library');

        // var orderDesp = '<p>All active campaigns will appear in your To-Do-List page.</p>';
        var orderDesp = '';

        var html = '<div class="modal-body">\n' +
            '                                <div class="description-order" style="margin-bottom: 35px;">\n' +
            orderDesp +
            '\n' +
            '                                </div>\n' +
            '                                <div class="row modal-order-action">\n' +
            // '<button class="btn btn-campaign unlock-campaign" data-target="'+currentCampaign+'">YES</button>\n' +
            '<button class="btn get-campaign unlock-campaign" style="border: 1px solid #000000" data-target="'+currentCampaign+'" data-purchase="1">GET THIS CAMPAIGN FOR Credits '+credits+'</button>\n' +
            // '<button class="btn close-btn" data-dismiss="modal">NO</button>\n'+
            '                                </div>\n' +
            '                            </div>';

        mainModel.modal('show');
        // $(".modal-campaign-library .modal-header").prepend('<h3 class="modal-campaign-title">+campaignName+</h3>');
        $(".modal-campaign-library .modal-header").prepend('<h3 class="modal-campaign-title">'+campaignName+'</h3>');
        $(".modal-campaign-library .modal-header").after(html);

        // if(planSelected == 1){
        //     // var orderDesp = '<p>Paid subscribers of nichepractice can unlock 2 marketing campaigns' +
        //     //     ' each month for free or you can purchase the campaigns. All active ' +
        //     //     'campaigns will appear in your To-Do-List page</p>';
        //
        //     // var orderDesp = '<p>All active campaigns will appear in your To-Do-List page.</p>';
        //     //
        //     // var html = '<div class="modal-body">\n' +
        //     //     '                                <div class="description-order" style="margin-bottom: 35px;">\n' +
        //     //     orderDesp +
        //     //     '\n' +
        //     //     '                                </div>\n' +
        //     //     '                                <div class="row modal-order-action">\n' +
        //     //     // '<button class="btn btn-campaign unlock-campaign" data-target="'+currentCampaign+'">YES</button>\n' +
        //     //     '<button class="btn get-campaign unlock-campaign" style="border: 1px solid #000000" data-target="'+currentCampaign+'" data-purchase="1">GET THIS CAMPAIGN FOR Credits '+credits+'</button>\n' +
        //     //     // '<button class="btn close-btn" data-dismiss="modal">NO</button>\n'+
        //     //     '                                </div>\n' +
        //     //     '                            </div>';
        //     //
        //     // mainModel.modal('show');
        //     // // $(".modal-campaign-library .modal-header").prepend('<h3 class="modal-campaign-title">+campaignName+</h3>');
        //     // $(".modal-campaign-library .modal-header").prepend('<h3 class="modal-campaign-title">'+campaignName+'</h3>');
        //     // $(".modal-campaign-library .modal-header").after(html);
        // }
        // if(planSelected == 2){
        //
        //     var orderDesp = '<p>Are you sure you want to choose this campaign?</p>';
        //
        //     var html = '<div class="modal-body">\n' +
        //         '                                <div class="description-order" style="margin-bottom: 35px;">\n' +
        //         orderDesp +
        //         '\n' +
        //         '                                </div>\n' +
        //         '                                <div class="row modal-order-action">\n' +
        //         '<button class="btn btn-campaign unlock-campaign" data-target="'+currentCampaign+'">YES</button>\n' +
        //         '<button class="btn close-btn" data-dismiss="modal">NO</button>\n'+
        //         '                                </div>\n' +
        //         '                            </div>';
        //
        //     mainModel.modal('show');
        //     $(".modal-campaign-library .modal-header").prepend('<h3 class="modal-campaign-title">Confirmation</h3>');
        //     $(".modal-campaign-library .modal-header").after(html);
        // }

        // else{
        //     var orderDes = '<p>Paid subscribers of nichepractice can unlock 2 marketing campaigns each month for free or you can purchase the campaigns. All active campaigns will appear in your To-Do-List page</p>';
        //
        //     var html = '<div class="modal-body">\n' +
        //         '                                <div class="description-order" style="margin-bottom: 35px;">\n' +
        //         orderDes +
        //         '\n' +
        //         '                                </div>\n' +
        //         '                                <div class="row modal-order-action">\n' +
        //         '<button class="btn get-campaign unlock-campaign" data-target="'+currentCampaign+'" data-purchase="1">GET THIS CAMPAIGN FOR Credits '+credits+'</button>\n' +
        //         '<button class="btn btn-campaign unlock-campaign" data-target="'+currentCampaign+'">UNLOCK CAMPAIGN</button>\n'+
        //         '                                </div>\n' +
        //         '                            </div>';
        //
        //     mainModel.modal('show');
        //     $(".modal-campaign-library .modal-header").prepend('<h3 class="modal-campaign-title">'+campaignName+'</h3>');
        //     $(".modal-campaign-library .modal-header").after(html);
        // }
    }
    else
    {
        var mainModel = $('#main-modal');

        $(".modal-body, .modal-footer, .validate-me", mainModel).remove();
        $(mainModel).removeClass('welcome-process');
        $(mainModel).addClass('modal-upgrade-library');

        var orderDes = '<p>You need to be a subscriber of nichepractice in order to unlock a marketing campaign\n' + '<br> <br>' +
            'You can upgrade your account by clicking the link below</p>';

        var html = '<div class="modal-body">\n' +
            '                                <div class="description-order" style="margin-bottom: 35px;">\n' +
            orderDes +
            '\n' +
            '                                </div>\n' +
            '                                <div class="row modal-order-action">\n' +
            '<a href="'+baseUrl+'/upgrade" class="btn btn-login" style="margin: 0px auto;display: table; width: 85%; border-radius: 0px; font-weight: 600; ">UPGRADE NOW!</a>\n'+
            '                                </div>\n' +
            '                            </div>';

        mainModel.modal('show');
        $(".modal-upgrade-library .modal-header").prepend(' <h3 class="modal-campaign-title"> <img class="mini-loader" src="'+baseUrl+'/public/images/alert.png" style="width: auto; height: auto;" /> Upgrade Required</h3>');
        $(".modal-upgrade-library .modal-header").after(html);


        // swal({
        //     title: "",
        //     html: true,
        //     text: "You must be a subscriber to access this campaign. Please <a href='"+baseUrl+"/upgrade' style='border-bottom: 1px solid;'>upgrade</a>",
        //     type: "info"
        // });
    }
});

$(document.body).on('click','.btn-learn-more',function (){
    var taskId = $(this).closest('.task-contain').attr('data-task-content');

    var mainModel = $('#main-modal');
    $(".modal-body, .modal-footer, .validate-me", mainModel).remove();
    $(mainModel).removeClass('welcome-process');
    $(mainModel).addClass('modal-task-order');

    var baseUrl = $('#hfBaseUrl').val();
    var credits = $('#task-credits').val();
    var taskTitle = $('.task-des-title').html();
    var orderDes = $('.task-learn-more-des').html();

    if(isEmptyValNormal(orderDes) == true)
    {
        orderDes = '';
    }

    // console.log("credits of learn");
    // console.log(credits);

    var html = '<div class="modal-body">\n' +
        '                                <h3 class="modal-order-title p-b-10">'+taskTitle+'</h3>\n' +
        '                                <div class="col-md-12">\n' +
        orderDes +
        '\n' +
        '                                </div>\n' +
        '                                <div class="row order-credit-action">\n' +
        '<button data-task-target="'+taskId+'" class="btn order-credit-now">Order Now - '+credits+' Credits</button>\n'+
        '\n' +
        '                                </div>\n' +
        '                            </div>';

    mainModel.modal('show');
    $(".modal-task-order .modal-header").prepend('<span class="heading-credit">'+credits+' Credits</span>');
    $(".modal-task-order .modal-header").after(html);
});

$(document.body).on('click','.btn-campaign-info, .btn-campaign',function (){
    var campaign = $(this).attr('data-campaign-target');
    var credits = $(this).attr('data-credits');
    var baseUrl = $('#hfBaseUrl').val();

    var mainModel = $('#main-modal');
    $(".modal-body, .modal-footer, .validate-me", mainModel).remove();
    $(mainModel).removeClass('welcome-process');
    $(mainModel).addClass('modal-task-order');
    $(mainModel).addClass('modal-credits-order');
    $('.modal-dialog', mainModel).addClass('campaign-library-dialog');

    var taskTitle = $('.template-name', '.marketing-campaign-'+campaign).html();
    var orderDes = '';

    showPreloader();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },
        type: "POST",
        url: baseUrl + "/done-me",
        data: {
            'send': 'task-detail',
            'id': campaign,
            'source': 'category',
        }
    }).done(function (result) {
        // console.log('entering task-detail 2');
        // if(window.innerHeight > 720)
        // {
        //     boxHeight = $(document).innerHeight() - 120;
        //     console.log('boxHeight');
        //     console.log(boxHeight);
        //     $('.white-box').height(boxHeight+'px');
        // }
        // else
        // {
        //     boxHeight = $(document).innerHeight() - 30;
        //     $('.white-box').height(boxHeight+'px');
        // }
        // console.log('entering task-detail 3');

        var json = $.parseJSON(result);

        // get data
        var statusCode = json.status_code;
        var statusMessage = json.status_message;
        var data = json.data;

        hidePreloader();

        if(statusCode == 200)
        {
            if(isEmptyValNormal(data.description) == false)
            {
                orderDes = data.description;
            }

            var html = '<div class="modal-body">\n' +
                '                                <h3 class="modal-order-title p-b-10">'+taskTitle+'</h3>\n' +
                '                                <div class="row imageSize">\n' +
                orderDes +
                '\n' +
                '                                </div>\n' +
                '                                <div class="row order-credit-action">\n' +
                '<button data-task-target="'+campaign+'" class="btn unlock-campaign" data-target="'+campaign+'" data-purchase="1">Order Now - '+credits+' Credits</button>\n'+
                '\n' +
                '                                </div>\n' +
                '                            </div>';

            if(isEmptyValNormal(data.settings_module) == false)
            {
                $(mainModel).addClass('full-width-credits');
            }
            mainModel.modal('show');
            // $(".modal-credits-order .modal-header").prepend('<span class="heading-credit">'+credits+' Credits</span>');
            $(".modal-credits-order .modal-header").prepend('');
            $(".modal-credits-order .modal-header").after(html);
        }
        else
        {

        }
        // console.log("credits of learn");
        // console.log(credits);
    });
});

$(document.body).on('hidden.bs.modal','.modal-task-order, .modal-alert-credit, .modal-campaign-library, .modal-upgrade-library, .modal-show-sample',function (e){
    var mainModel = $('#main-modal');
    // var mainModel = $('.modal-task-order');

    $(mainModel).removeClass('modal-task-order modal-alert-credit modal-campaign-library modal-upgrade-library modal-show-sample');
    $(".modal-header i", mainModel).remove();
    $(".heading-credit", mainModel).remove();

    $(".modal-campaign-title", mainModel).remove();

        $(".modal-body, .modal-footer, .validate-me", mainModel).remove();
});

$(document.body).on('click', '.order-credit-cancel', function () {
    var mainModel = $('.modal-alert-credit');
    mainModel.modal('hide');
});

$(document.body).on('click', '.close-suggession-box', function () {
    var baseUrl = $('#hfBaseUrl').val();

    $('.action-plan-suggestion').hide();

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },
        type: "POST",
        url: baseUrl + "/done-me",
        data: {
            'send': 'close-task-suggession',
            'task_suggesstion_hide': 1
        }
    }).done(function (result) {
        // parse data into json
        var json = $.parseJSON(result);

        // get data
        var statusCode = json.status_code;
        var statusMessage = json.status_message;
        var data = json.data;

        if(statusCode != 200)
        {
            $('.action-plan-suggestion').show();
            swal({
                title: "",
                text: statusMessage,
                type: "error"
            });
        }

    });
});

/**
 *  Change status of task
 */

$(document.body).on('click','.website-task-list .checkbox-circle input[type="checkbox"]',function ()
{
    // console.log("status change clicked " + window.button_clicked);
    // console.log("status change 3223 " + $(this).prop( "checked" ));

    // console.log($(this).prop( "checked" ) === true);

    // make sure this call be clickable from buttons of skip and mark_as ocmplete button.

    /**
     * if this is done task clicked to go back to open then return from here.
     *
     * Do not open task to existing done task.
     */
    if($(this).prop( "checked" ) === false || window.button_clicked === '')
    {
        // console.log("inside");
        return false;
    }

    window.button_clicked = '';

    var imageLoader = '';

    var status = '';
    if(window.status === '')
    {
        status = ( $(this).prop( "checked" ) === true ) ? 'done': 'open';
    }
    else
    {
        status = window.status;
    }

    // console.log("status changing to");
    // console.log(status);

    var taskId = $(this).closest('li').attr('data-task-id');
    var businessTaskId = $(this).closest('li').attr('data-business-task-id');

    if(taskId !== '' && status !== '')
    {
        /**
         * If requested task matched with open content area
         * then also do some operation on description area.
         */

        var descriptionTaskId = $('.task-description .task-contain').attr('data-task-content');

        // console.log("descriptionTaskId > " + descriptionTaskId);

        if(descriptionTaskId == taskId) {
            var descriptionTaskInput = '';

            if(status === 'paid')
            {
                showPreloader();
            }
            if(status === 'skipped')
            {
                descriptionTaskInput = $('.task-description .task-contain[data-task-content="'+descriptionTaskId+'"] button.mark_as_skip');
                $(descriptionTaskInput).button('loading');
            }
            else
            {
                descriptionTaskInput = $('.task-description .task-contain[data-task-content="'+descriptionTaskId+'"] button.mark_as_complete');

                // console.log("wow");
                // console.log(descriptionTaskInput);
                $(descriptionTaskInput).button('loading');
            }
        }

        var baseUrl = $('#hfBaseUrl').val();

        if(status !== 'paid')
        {
            imageLoader = '<div class="mini-loader-container">';
            imageLoader += '<img class="mini-loader" src="'+baseUrl+'/public/images/spinner.gif" />';
            imageLoader += '</div>';

            $(this).attr('disabled', true);
            $(this).closest('li').prepend(imageLoader);
        }

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            type: "POST",
            url: baseUrl + "/done-me",
            data: {
                'send': 'update-task-status',
                taskId: taskId,
                status: status,
                businessTaskId: businessTaskId
            }
        }).done(function (result) {
            window.status = '';

            // parse data into json
            var json = $.parseJSON(result);

            // get data
            var statusCode = json.status_code;
            var statusMessage = json.status_message;
            var data = json.data;

            var descriptionTaskId = $('.task-description .task-contain').attr('data-task-content');
            if(descriptionTaskId == taskId) {
                //var descriptionTaskInput = $('.task-description .task-contain[data-task-content="'+descriptionTaskId+'"] input');

                var descriptionTaskInput = $('.task-description .task-contain[data-task-content="'+descriptionTaskId+'"] button.mark_as_complete');

                if(status !== 'paid')
                {
                    if(status === 'done')
                    {
                        //descriptionTaskInput.prop( "checked", true );
                        $(descriptionTaskInput).html('<i class="mdi mdi-check"></i> Completed');
                        $(descriptionTaskInput).addClass('btn-success').removeClass('btn-default');
                        // location.reload();
                    }
                    else if(status === 'skipped')
                    {
                        descriptionTaskInput = $('.task-description .task-contain[data-task-content="'+descriptionTaskId+'"] button.mark_as_skip');

                        //descriptionTaskInput.prop( "checked", true );
                        $(descriptionTaskInput).html('Skipped');
                    }
                    else
                    {
                        //descriptionTaskInput.prop( "checked", false );
                        $(descriptionTaskInput).html('<i class="mdi mdi-check"></i> Mark as Complete');
                        $(descriptionTaskInput).addClass('btn-default').removeClass('btn-success');
                    }

                    $(descriptionTaskInput).attr('disabled', false).removeClass('disabled');
                }

                // $(".mark_as_complete").attr('disabled', false);
                // $(".mark_as_skip").attr('disabled', false);
            }

            if(statusCode === 200)
            {
                loadTaskCount();
                hidePreloader();

                $('.mini-loader-container', 'li[data-task-id="'+taskId+'"]').remove();

                var currentTab = $('.website-page-tabs ul li.active a').attr('href');

                var tooltipTitle = (status === 'open') ? 'Click when done.' : 'Click to reopen.';

                var listTask = $('li[data-task-id="'+taskId+'"]');
                var selectedDom = '';

                // console.log("currentTab");
                // console.log(currentTab);

                if(currentTab !== '#all')
                {
                    listTask.fadeOut(300, function()
                    {
                        $(this).parent().find('.tooltip').remove();

                        // console.log("this");
                        // console.log($(this));
                        // console.log("this parent");
                        // console.log($(this).parent());
                        // console.log("this parent new");
                        // console.log($(this).closest('.data-list'));

                        selectedDom = $(this).closest('.data-list');
                        // selectedDom.hide();

                        isActiveTask = $(this).hasClass("active");

                        // if current changing task is active
                        if(isActiveTask === true)
                        {
                            if(descriptionTaskId == taskId)
                            {
                                // console.log("delete content");
                                // $('.task-description .task-contain').remove();
                                $('.task-description .task-contain[data-task-id="'+taskId+'"]').remove();
                                var descriptionArea = $('.task-description');

                                descriptionArea.show();
                                descriptionArea.html('<div class="page-content" style="font-size: 18px; text-align: center;">No Task Selected.</div>');
                            }
                            var targetTaskId = '';
                            if($(this).nextUntil('li').next('li').attr("data-task-id"))
                            {
                                targetTaskId =$(this).nextUntil('li').next('li').attr("data-task-id");
                                $("li[data-task-id="+ targetTaskId +"]").find('label:first').click();
                            }
                            else if($(this).next('li').attr("data-task-id"))
                            {
                                $(this).next('li').find('label:first').click();
                            }
                            else if($(this).prevUntil('li').prev('li').attr("data-task-id"))
                            {
                                targetTaskId =$(this).prevUntil('li').prev('li').attr("data-task-id");
                                $("li[data-task-id="+ targetTaskId +"]").find('label:first').click();
                            }
                            else if($(this).prev('li').attr("data-task-id"))
                            {
                                $(this).prev('li').find('label:first').click();
                            }
                            else {
                                // for last task
                                if(descriptionTaskId == taskId)
                                {
                                    // console.log("delete content");
                                    // $('.task-description .task-contain').remove();
                                    $('.task-description .task-contain[data-task-id="'+taskId+'"]').remove();
                                    var descriptionArea = $('.task-description');

                                    descriptionArea.show();
                                    descriptionArea.html('<div class="page-content" style="font-size: 18px; text-align: center;">No Task Selected.</div>');
                                }
                            }
                        }

                        $(this).remove();

                        if(currentTab === '#open')
                        {
                            var taskListCount = $("#open .task-panel.panel-body li").length;

                            // if(taskListCount == 5)
                            // {
                            //
                            // }
                            // console.log('data.length');
                            // console.log(data.length);
                            if($(".add-more-task").length < 1 && taskListCount < 2)
                            {
                                $("#open .task-panel.panel-body").append('<div class="add-more-task"><span class="plus-sign">+</span><span class="add-task-text">Add a To DO Task</span></div>');
                            }

                            // if (taskListCount > 2) {

                            //     $(".add-more-task").remove();
                            // }
                            // <div class="add-more-task"><span class="plus-sign">+</span><span class="add-task-text">Add a To DO Task</span></div>

                            // window.get_num_post = 5;
                            // $('.task-tabs li a:first').click();




                            // remove description container on match task id
                            // if(descriptionTaskId == taskId)
                            // {
                            //     console.log("delete content");
                            //     // $('.task-description .task-contain').remove();
                            //     $('.task-description .task-contain[data-task-id="'+taskId+'"]').remove();
                            //     var descriptionArea = $('.task-description');
                            //
                            //     descriptionArea.show();
                            //     descriptionArea.html('<div class="page-content" style="font-size: 18px; text-align: center;">No Task Selected.</div>');
                            // }
                        }
                        else
                        {
                            if($(".panel-body ul", selectedDom).html().trim() === '')
                            {
                                $(".panel-body ul", selectedDom).after("<p>No Task Found in this section.</p>");
                            }
                        }
                        // remove description container on match task id
                        // if(descriptionTaskId == taskId)
                        // {
                        //     console.log("delete content");
                        //     // $('.task-description .task-contain').remove();
                        //     $('.task-description .task-contain[data-task-id="'+taskId+'"]').remove();
                        //     var descriptionArea = $('.task-description');
                        //
                        //     descriptionArea.show();
                        //     descriptionArea.html('<div class="page-content" style="font-size: 18px; text-align: center;">No Task Selected.</div>');
                        // }

                        if(status === 'paid')
                        {
                            var mainModel = $('#main-modal');
                            mainModel.modal('hide');

                            // console.log("data.creditsBalance");
                            // console.log(data.creditsBalance);

                            if(isEmptyValNormal(data.creditsBalance) == false)
                            {
                                // console.log("inside check val");
                                $(".sidebar-available-credits h1").html(data.creditsBalance);
                            }
                            // console.log("Not go inside check val");

                            swal({
                                title: "",
                                text: "Task has been moved in Paid tab.",
                                type: "success"
                            });
                        }
                    });

                    // setTimeout(function() {
                    //     // show a notice
                    //     $(".data-list ul")
                    //     <p>No Task Found in this section.</p>
                    // }, 300);
                }
                else
                {
                    listTask.attr('data-original-title', tooltipTitle).parent().find('.tooltip-inner').html(tooltipTitle);

                    $('[data-task-id="'+taskId+'"] input').attr('disabled', false);

                    if(descriptionTaskId == taskId)
                    {
                        // if task is not checked & not done then show title  Click when done.
                        //$('.task-description .task-contain[data-task-content="'+descriptionTaskId+'"] .checkbox-circle').attr('data-original-title', tooltipTitle).parent().find('.tooltip-inner').html(tooltipTitle);

                        // $('[data-task-id="'+taskId+'"]').attr('data-original-title', 'Click when done.');
                        // status
                        //$('.task-description .task-contain[data-task-content="'+descriptionTaskId+'"] input').attr('disabled', false);
                        $('.task-description .task-contain[data-task-content="'+descriptionTaskId+'"] button.mark_as_complete').attr('disabled', false);

                        var skipTask = $(".skip-task");
                        if(status === "open") {
                            skipTask.remove();
                            var skipButton = '';
                            skipButton += '<button class="skip-task btn btn-danger right btn-outline btn-sm" data-target-status="skipped" data-loading-text=" <i class=\'fa fa-spinner fa-spin\'></i> Skipping">';
                            skipButton += '<i class="mdi mdi-close"></i> Skip</button>';
                            $(".skip-task-container").html(skipButton);
                        }
                        else
                        {
                            skipTask.remove();
                        }
                    }
                }

                var totalTasks = totalTaskContainer.attr('data-total-tasks');
                if(currentTab !== '#all')
                {
                    totalTasks--;
                    updateTotalTaskCounting(totalTasks);
                }

                var module = $('#module').val();
                var moduleContainer = $("li.marketing-tabs [data-module='"+module+"']");
                var moduleTaskContainer = moduleContainer.find('.total-task');
                var totalMenuTask = moduleTaskContainer.html();

                // task changed from open to done
                if(status === 'done')
                {
                    totalMenuTask--;
                    moduleTaskContainer.html(totalMenuTask);
                }
                else
                {
                    // moduleContainer.find('.total-task').html(value.count);
                    // task changed from done to open
                    totalMenuTask++;
                    moduleTaskContainer.html(totalMenuTask);
                }

                // html = '<p style="background-color: green;color: #fff;text-align: center;">'+statusMessage+'</p>';
                // $('li[data-task-id="'+taskId+'"]').html(html);
                // $('li[data-task-id="'+taskId+'"]').remove();

                if(window.taskType == 'recurring' && status === 'done')
                {
                    $('.task-tabs li a:first').click();
                }
            }
            else {
                var mainModel = $('#main-modal');
                // console.log("else " + status);

                $('[data-task-id="'+taskId+'"] input[type="checkbox"]').prop( "checked", false );

                if(status == 'paid' && statusCode == 404)
                {
                    window.statusMessage = statusMessage;
                    notEnoughCredits(mainModel);
                }
                else
                {
                    mainModel.modal('hide');

                    swal({
                        title: "",
                        text: statusMessage,
                        type: "error"
                    });
                }
            }
        });
    }
});

$(document.body).on('click',".task-description .mark_as_complete",function () {
    var taskId = '';
    var businessTaskId = $(this).closest('div.task-contain').attr('data-task-business-content');

    window.taskType = '';
    window.button_clicked = 'completed';
    $(this).attr('disabled', true);

    if(isEmptyValNormal(businessTaskId) == false)
    {
        window.taskType = '';
        $('[data-business-task-id="'+businessTaskId+'"] input[type="checkbox"]').click();
    }
    else
    {
        taskId = $(this).closest('div.task-contain').attr('data-task-content');
        $('[data-task-id="'+taskId+'"] input[type="checkbox"]').click();
    }
    // console.log('taskId')
    // console.log(taskId)
    // console.log('businessTaskId')
    // console.log(businessTaskId)

    // if(taskAvailableForDone == true || taskAvailableForDone == "true")


    // $(".mark_as_skip").attr('disabled', true);


});

$(document.body).on('click',".task-description .mark_as_skip",function () {
    var taskId = $(this).closest('div.task-contain').attr('data-task-content');
    // console.log("taskId " + taskId);
    $(this).attr('disabled', true);
    // $(".mark_as_complete").attr('disabled', true);

    window.button_clicked = 'skipped';

    window.status = 'skipped';
    $('[data-task-id="'+taskId+'"] input[type="checkbox"]').click();
});

$(document.body).on('click',".order-credit-now",function () {
    var taskId = $(this).attr('data-task-target');

    $(this).attr('disabled', true);
    // $(".mark_as_complete").attr('disabled', true);

    // showPreloader();

    window.button_clicked = 'paid';

    window.status = 'paid';
    $('[data-task-id="'+taskId+'"] input[type="checkbox"]').click();
});

function initiateTooltip()
{
    return false;
    // initiate tooltip
    $('[data-toggle="tooltip"]').tooltip();
}


function updateTotalTaskCounting(totalTasks)
{
    var totalTaskContainer = $('.task-length');

    totalTaskContainer.html('Task Counting...');

    if(totalTasks  > 1)
    {
        totalTaskContainer.html('Tasks '+ totalTasks +' Found');
    }
    else
    {
        totalTaskContainer.html('Task '+ totalTasks +' Found');
    }
    totalTaskContainer.attr('data-total-tasks', totalTasks);
    if(totalTasks == 0)
    {
        if($("#module-view").val() === 'task_list')
        {
            var openTabRef =  $('.task-tabs .active a').attr('href');
            var openTab = openTabRef.substring(1, openTabRef.length);
        }

        // $('ul', '#'+openTab).append('No Task Found.');
    }
}

function localizedFormattedData(data, referece)
{
    var html = '';
    if(data) {
        html += '<div class="panel-group" id="'+referece+'" role="tablist" aria-multiselectable="true">';
        $.each(data, function (index, value) {
            html += '<div class="panel">';
            var datatoggleType;
            var dataToggleClass = '';

            if(value.formats != '') {
                datatoggleType = 'collapse';
            }
            else
            {
                datatoggleType = '';
                dataToggleClass = 'pointer-default';
            }

            html += '<div class="panel-heading" role="tab">';
            html += '<h4 class="panel-title">';
            html += '<a class="collapsed '+dataToggleClass+'" role="button" data-toggle="'+datatoggleType+'" data-parent="#'+referece+'" href="#'+referece+'-'+index+'">';
            html += value.localizedRuleName;
            html +=     '</a>';
            html +=     '</h4>';
            html +=     '</div>';

            if(value.formats != '') {
                html +=     '<div id="'+referece+'-'+index+'" class="panel-collapse collapse" role="tabpanel">';
                html += '<div class="panel-body">';
                $.each(value.formats.header, function (headerIndex, headerValue) {
                    if (headerValue.arguments && headerValue.arguments != '') {
                        html += '<p>';
                        if (headerValue.arguments.type === 'HYPERLINK') {
                            html += '<a href="' + headerValue.arguments.value + '">';
                            html += headerValue.format;
                            html += '</a>';
                        }
                        html += '</p>';
                    }
                    else {
                        html += '<p>' + headerValue.format + '</p>';
                    }
                });

                if (value.formats.urls && value.formats.urls != '') {
                    html += '<div class="result-url">';

                    html += '<ul>';
                    $.each(value.formats.urls, function (urlIndex, urlValue) {
                        html += '<li>' + urlValue.value;

                        if (urlValue.durationValue) {
                            html += ' (' + urlValue.durationValue + ')</li>';
                        }
                        html += '</li>';
                    });

                    html += '</div>';
                    html += '</ul>';
                }

                html += '</div>';

                html += '</div>';
            }
            html +=     '</div>';
        });
        html +=     '</div>';
    }

    return html;
}

$(document.body).on('click',".add-more-task",function () {

    // get the task count so I can increment one more to load task
    var taskListCount = $("#open .panel-body li").length;

    window.get_num_post = taskListCount+1;
    var check_todo = $('.task-tabs li a:first').text();
    // console.log(check_todo);
    if (check_todo == 'To Do') {
        window.get_num_post = 5;
        window.add_to_do_clicked = 1;
    }
    $('.task-tabs li a:first').click();
});
$(document.body).on('click',".send-task",function () {
    var id = 'send-task';

    var html = '';
    html += '<div class="send-task-modal">';
    html += '<div class="input-group input-group-lg  m-b-5">';
    html += '<input name="email" type="text" class="form-control email" placeholder="Enter email address you want to assign this task to">';
    html += '<span class="input-group-btn"><button class="btn btn-info send-task-confirmed" type="button">Send</button> </span>';
    html += '</div>';
    html += '<span class="help-block hide-me"></span>';

    html +='</div>';

    loadModal(id);

    $(".modal-title").remove();
    $('.modal-header').append('<h4 class="modal-title">Email this Task</h4> <h5 class="modal-description">If you need somebody\'s help to complete this task, enter that person\'s email address below. You may change the status of this task after that person completes this task.</h5>');
    $('.modal-body', '#'+id).html(html);
});


$(document.body).on('hidden.bs.modal', '#send-task', function () {
    $(".modal-header .modal-title, .modal-header .modal-description").remove();
});


$(document.body).on('click',".send-task-confirmed",function () {
    var sendTaskModal = (".send-task-modal");
    var email = $.trim($(".email", sendTaskModal).val());
    var taskErrorHandler = $(".help-block", sendTaskModal);

    // send-task-modal help-block

    if(email === '')
    {
        taskErrorHandler.removeClass('hide-me');
        taskErrorHandler.addClass('error');
        taskErrorHandler.html('Email is required');

        return false;
    }
    else if (email !== '')
    {
        // check email.
        var emailRegEx = /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i;

        // if email not verified on global rule.
        if(!emailRegEx.test(email))
        {
            taskErrorHandler.removeClass('hide-me');
            taskErrorHandler.addClass('error');
            taskErrorHandler.html('Email is invalid');
            return false;
        }
        else{
            taskErrorHandler.removeClass('error');
            taskErrorHandler.addClass('hide-me');
        }

    }
    else
    {
        taskErrorHandler.removeClass('error');
        taskErrorHandler.addClass('hide-me');
    }

    var taskId = $(".send-task").attr("data-original-task");

    var baseUrl = $('#hfBaseUrl').val();
    showPreloader();

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },
        type: "POST",
        url: baseUrl + "/task/send-task",
        data: {
            taskId: taskId,
            email: email
        }
    }).done(function (result) {
        // parse data into json
        var json = $.parseJSON(result);

        // get data
        var statusCode = json.status_code;
        var statusMessage = json.status_message;

        hidePreloader();

        if(statusCode == 200)
        {
            $(".close").click();

            $(".email", sendTaskModal).val('');
            swal({
                title: "Successful!",
                text: statusMessage,
                type: "success"
            });
        }
        else
        {
            taskErrorHandler.removeClass("hide-me");
            taskErrorHandler.addClass("error");
        }

        taskErrorHandler.html(statusMessage);
    });

});


/**
 * send requerst to admin that user want to make a
 * beautiful & SEO friendly website
 */
$(document.body).on('click',".confirm-web",function () {
    var id = $(this).attr('data-id');

    var html = '';
    html += '<div class="remove-business-modal">';
    html += '<h3>Website Order Confirmed</h3>';

    html +='<div class="confirmation-modal-content">';
    html +='Somebody from our team will contact you within 24 hours to discuss the details of your website - e.g. domain, design, logos, costing, etc. We will contact you using the email address you provided during sign up.';
    html +='</div>';

    html +='<div class="confirmation-modal-footer">';
    html +='<button type="button" class="btn btn-info confirmed-web">Okay</button>';
    html +='</div>';

    html +='</div>';

    loadModal(id);

    $('.modal-body', '#'+id).html(html);
});

$(document.body).on('click',".confirmed-web, .list-now",function () {

    var popupManager = $('.modal-manager');
    popupManager.modal('hide');

    var baseUrl = $('#hfBaseUrl').val();

    var data = {};
    var currentAction = '';

    // console.log("now");
    // console.log($(this));

    var parent = $(this);

    if($(this).attr('class').indexOf("list-now") >=0)
    {
        $(this).attr('disabled', true);

        currentAction = 'list-now';
        data['send'] = 'business-listed';
        data['task'] = $('.task-description .task-contain').attr('data-task-content');
    }
    else
    {
        currentAction = 'confirm-web';
        data['send'] = 'website-inquiry';
    }

    $('.'+currentAction).next('.response-message').remove();
    $('.web-loader').show();

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },
        type: "POST",
        url: baseUrl + "/done-me",
        // data: data
        data: data
    }).done(function (result) {
        $('.icon-refresh').hide();
        // parse data into json
        var json = $.parseJSON(result);

        // get data
        var statusCode = json.status_code;
        var statusMessage = json.status_message;

        $('.web-loader').hide();

        if(statusCode === 200)
        {
            if(currentAction !== 'list-now') {
                setTimeout(function () {
                    $('.response-message').remove();
                }, 3000);
            }
            $('.'+currentAction).after('<p class="response-message m-t-10">'+statusMessage+'</p>');
        }
        else
        {
            parent.attr('disabled', false);

            $('.'+currentAction).after('<p class="response-message m-t-10">Email not sent. please try again.</p>');

            setTimeout(function () {
                $('.response-message').remove();
            }, 3000);
        }
    });
});
$(document).ready(function() {
    $(this).on('click','.checkbox',function () {
        $('body, html').animate({scrollTop: 0}, 'slow');
    });
});

$(document).on('click','.data-list',function () {
    calculateHeight();
});
function calculateHeight() {
    var taskHeight;
    var detailHeight;
    var boxHeight;
    // console.log('here');
    setTimeout(function () {
        taskHeight = $('.page-content').height();
        detailHeight = $('.task-contain').height();
        if(taskHeight > detailHeight || taskHeight == detailHeight){
            boxHeight = taskHeight + 150;
            $('.white-box').height(boxHeight+'px');
        }
        if(taskHeight < detailHeight){
            boxHeight = detailHeight + 150;
            $('.white-box').height(boxHeight+'px');
        }
    },300);
}
$(document).ready(function() {
    $('.mark_as_complete').click(function() {
        location.reload();
    });
});
$(document).ready(function() {
    $('#showHiddenCampaigns').click(function() {
        calculateHeight();
        $(".dontshow").each(function(){
            $(this).toggle();
        });
        $('#showHiddenCampaigns').toggleClass("showOn");
        var showClass = $('#showHiddenCampaigns').hasClass('showOn');

        if(showClass){
            $('#showHiddenCampaigns').text('Hide Hidden Campaign');
        }
        else {
            $('#showHiddenCampaigns').text('Show Hidden Campaign');
        }
    });
});

// $(document).ready(function(){
//     $(document).on('mouseover','#stars li',function () {
//     /* 1. Visualizing things on Hover - See next part for action on click */
//     // $('#stars li').on('mouseover', function() {
//         var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on
//
//         // Now highlight all the stars that's not after the current hovered star
//         $(this).parent().children('li.star').each(function(e){
//             if (e < onStar) {
//                 $(this).addClass('hover');
//             }
//             else {
//                 $(this).removeClass('hover');
//             }
//         });
//
//     }).on('mouseout', function(){
//         $(this).parent().children('li.star').each(function(e){
//             $(this).removeClass('hover');
//         });
//     // });
// });
// $(document).ready(function(){
/* 2. Action to perform on click */
window.star = 0;
$(document).on('click','#stars li',function () {
    // $('').click( function(){
    //     console.log('hereee');
    if(window.currentActiveTab != 'done') {
        var onStar = parseInt($(this).data('value'), 10); // The star currently selected
        // console.log('onStar');
        // console.log(onStar);
        window.star = onStar;
        var stars = $(this).parent().children('li.star');

        for (var i = 0; i < stars.length; i++) {
            $(stars[i]).removeClass('selected');
        }

        for (var i = 0; i < onStar; i++) {
            $(stars[i]).addClass('selected');
        }
    }
});
// });
// function checkSelectedStar(current) {
//     var ul = current.find('#stars');
//     console.log('ul')
//     console.log(ul)
//     var stars = $(this).parent().children('li.star');
//     $( "ul.level-2" ).children().css( "background-color", "red" );
//     for (var i = 0; i < 4; i++) {
//         $(stars[i]).addClass('selected');
//     }
// }
$(document).on('click','.submitFeedBack',function (e) {
    console.log('aaaa')
    e.preventDefault();

    var onStar = parseInt($('#stars li').data('value'), 10);
    // console.log('onStar');
    // console.log(window.star);
    var comment = $('#comment').val();
    var star = window.star;
    console.log(star)
    var taskErrorHandler = $(".help-block");
    if(star < 1) {
        // console.log('star less')
        // console.log(star)
        taskErrorHandler.removeClass('hide-me');
        taskErrorHandler.addClass('error colorYellow');
        taskErrorHandler.html('Star rating is required.');
        return;
    }
    // console.log('star')
    // console.log(star)
    // return;
    showPreloader();
    var categoryId = $('#category_id').val();
    var taskId = $('#task_id').val();
    // var category_id = $(this).closest('#category_id');
    // console.log(comment);
    // console.log(star);
    // console.log(category_id);
    var data = {};
    data['send'] = 'campaign_feedback';
    data['star'] = star;
    data['comment'] = comment;
    data['category_id'] = categoryId;
    data['task_id'] = taskId;
    // console.log('data');
    // console.log(data);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },
        type: "POST",
        url: baseUrl + "/done-me",
        data: data
    }).done(function (result) {
        // console.log('result');
        // console.log(result);
        hidePreloader();
        window.star = 0;
        var json = $.parseJSON(result);
        var statusCode = json.status_code;
        var statusMessage = json.status_message;
        if(statusCode == 200) {


            swal({
                title: "Successful!",
                text: statusMessage,
                type: "success"
            }, function () {
                $('.mark_as_complete').click();
                // location.reload();
            });

        } else{
            swal({
                title: "Error!",
                text: statusMessage,
                type: "error"
            }, function () {

            });
        }

    });
});
// $(document).on('click','.btn-show-sample',function (e) {
//     console.log('aaaa')
// })
$(document.body).on('click','.btn-show-sample',function (){
    var campaign = $(this).attr('data-campaign-target');
    // var credits = $(this).attr('data-credits');
    var baseUrl = $('#hfBaseUrl').val();

    var mainModel = $('#main-modal');
    $(".modal-body, .modal-footer, .validate-me", mainModel).remove();
    $(mainModel).removeClass('welcome-process');
    $(mainModel).addClass('modal-show-sample');

    var taskTitle = $('.template-name', '.marketing-campaign-'+campaign).html();

    showPreloader();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },
        type: "POST",
        url: baseUrl + "/done-me",
        data: {
            'send': 'sample-detail',
            'id': campaign
        }
    }).done(function (result) {

        var json = $.parseJSON(result);

        // get data
        var statusCode = json.status_code;
        var statusMessage = json.status_message;
        var data = json.data;

        hidePreloader();

        if(statusCode == 200)
        {
            orderDes = data.description;

            var html = '<div class="modal-body">\n' +
                '                                <h3 class="modal-sample-title p-b-10">'+taskTitle+'</h3>\n' +
                '                                <div class="row">\n' +
                '<div class="sampleDes">' +
                '<h3 class="sampleDesHeading">'+orderDes+'</h3>' +
                '</div>'+
                '\n' +
                '                                </div>\n' +
                '                            </div>';
            mainModel.modal('show');
            $(".modal-show-sample .modal-header").prepend('');
            $(".modal-show-sample .modal-header").after(html);
        }
        else
        {
            swal('Error',statusMessage,'error');
        }
    });
});
