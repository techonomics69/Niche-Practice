$(document).ready(function () {
    // alert("called");
    // window.history.pushState(null, "", window.location.href);
    //
    // setTimeout(function () {
    //     window.history.pushState(null, "", window.location.href);
    // },2000)
    // window.onpopstate = function() {
    //     // alert("inside function");
    //     window.history.pushState(null, "", window.location.href);
    // };

    $("#sidebar-opener").on("click",function(){
        $('.sidebar').toggleClass("sidebar-show");
    });
    // $(".select2").select2();
    $(function () {
        $(".preloader").fadeOut();
        $('#side-menu').metisMenu();
    });
    // Theme settings
    $(".open-close").click(function () {
        $("body").toggleClass("show-sidebar").toggleClass("hide-sidebar");
        $(".sidebar-head .open-close i").toggleClass("ti-menu");

    });
    //Open-Close-right sidebar
    $(".right-side-toggle").click(function () {
        $(".right-sidebar").slideDown(50);
        $(".right-sidebar").toggleClass("shw-rside");
        // Fix header
        $(".fxhdr").click(function () {
            $("body").toggleClass("fix-header");
        });
        // Fix sidebar
        $(".fxsdr").click(function () {
            $("body").toggleClass("fix-sidebar");
        });
        // Service panel js
        if ($("body").hasClass("fix-header")) {
            $('.fxhdr').attr('checked', true);
        }
        else {
            $('.fxhdr').attr('checked', false);
        }

    });
    //Loads the correct sidebar on window load,
    //collapses the sidebar on window resize.
    // Sets the min-height of #page-wrapper to window size
    $(function () {
        $(window).bind("load resize", function () {
            topOffset = 60;
            width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
            if (width < 768) {
                $('div.navbar-collapse').addClass('collapse');
                topOffset = 100; // 2-row-menu
            }
            else {
                $('div.navbar-collapse').removeClass('collapse');
            }
            height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
            height = height - topOffset;
            if (height < 1) height = 1;
            if (height > topOffset) {
                $("#page-wrapper").css("min-height", (height) + "px");
            }
        });
        var url = window.location;
        var element = $('ul.nav a').filter(function () {
            return this.href == url || url.href.indexOf(this.href) == 0;
        }).addClass('active').parent().parent().addClass('in').parent();
        if (element.is('li')) {
            element.addClass('active');
        }
    });
    // This is for resize window
    $(function () {
        $(window).bind("load resize", function () {
            width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
            if (width < 1170) {
                $('body').addClass('content-wrapper');
                $(".sidebar-nav, .slimScrollDiv").css("overflow-x", "visible").parent().css("overflow", "visible");

            }
            else {
                $('body').removeClass('content-wrapper');

            }
        });
    });

    // Collapse Panels
    (function ($, window, document) {
        var panelSelector = '[data-perform="panel-collapse"]';
        $(panelSelector).each(function () {
            var $this = $(this)
                , parent = $this.closest('.panel')
                , wrapper = parent.find('.panel-wrapper')
                , collapseOpts = {
                toggle: false
            };
            if (!wrapper.length) {
                wrapper = parent.children('.panel-heading').nextAll().wrapAll('<div/>').parent().addClass('panel-wrapper');
                collapseOpts = {};
            }
            wrapper.collapse(collapseOpts).on('hide.bs.collapse', function () {
                $this.children('i').removeClass('ti-minus').addClass('ti-plus');
            }).on('show.bs.collapse', function () {
                $this.children('i').removeClass('ti-plus').addClass('ti-minus');
            });
        });
        $(document).on('click', panelSelector, function (e) {
            e.preventDefault();
            var parent = $(this).closest('.panel');
            var wrapper = parent.find('.panel-wrapper');
            wrapper.collapse('toggle');
        });
    }(jQuery, window, document));
    // Remove Panels
    (function ($, window, document) {
        var panelSelector = '[data-perform="panel-dismiss"]';
        $(document).on('click', panelSelector, function (e) {
            e.preventDefault();
            var parent = $(this).closest('.panel');
            removeElement();

            function removeElement() {
                var col = parent.parent();
                parent.remove();
                col.filter(function () {
                    var el = $(this);
                    return (el.is('[class*="col-"]') && el.children('*').length === 0);
                }).remove();
            }
        });
    }(jQuery, window, document));
    //tooltip
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
    //Popover
    $(function () {
        $('[data-toggle="popover"]').popover()
    })
    // Task
    $(".list-task li label").click(function () {
        $(this).toggleClass("task-done");
    });
    $(".settings_box a").click(function () {
        $("ul.theme_color").toggleClass("theme_block");
    });
});

$.urlParam = function(name){
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results==null) {
        return null;
    }
    return decodeURI(results[1]) || 0;
}

function popupScroll(selector = '.description-notify', height = '250')
{
    // if($(".description-notify").innerHeight() < 250)
    // {
    //     return false;
    // }

    $(selector).slimScroll({
        height: height+'px',
        // railVisible: true,
        alwaysVisible: true,
        size: "8px"
    });
}

//Colepsible toggle
$(".collapseble").click(function () {
    $(".collapseblebox").fadeToggle(350);
});
// Sidebar
$('.slimscrollright').slimScroll({
    height: '100%'
    , position: 'right'
    , size: "5px"
    , color: '#dcdcdc'
    , });
$('.slimscrollsidebar').slimScroll({
    height: '100%'
    , position: 'right'
    , size: "6px"
    , color: 'rgba(0,0,0,0.3)'
    , });
$('.chat-list').slimScroll({
    height: '100%'
    , position: 'right'
    , size: "0px"
    , color: '#dcdcdc'
    , });
// Resize all elements
$("body").trigger("resize");
// visited ul li
$('.visited li a').click(function (e) {
    $('.visited li').removeClass('active');
    var $parent = $(this).parent();
    if (!$parent.hasClass('active')) {
        $parent.addClass('active');
    }
    e.preventDefault();
});
// Login and recover password
$('#to-recover').click(function () {
    $("#loginform").slideUp();
    $("#recoverform").fadeIn();
});
// Update 1.5
// this is for close icon when navigation open in mobile view
$(".navbar-toggle").click(function () {
    $(".navbar-toggle i").toggleClass("ti-menu");
    $(".navbar-toggle i").addClass("ti-close");
});
// Update 1.6

$(document.body).on('click', '.btn-continue', function(e)
{
    var action = $(this).attr("data-action");
    var target = $(this).attr("data-target");

    var siteUrl = $('#hfBaseUrl').val();

    var mainModel = $('#main-modal');

    $(".modal-body, .modal-footer, .validate-me", mainModel).remove();

    $(mainModel).removeClass('welcome-process');
    $(mainModel).addClass('modal-page-info');

    var item = $(this).closest(".item");

    var pageTitle = item.find('.subtext').html().trim();
    // var pageDescription = item.find('.sub-description').html().trim();

    showPreloader();

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },
        type: "POST",
        url: siteUrl + "/done-me",
        data: {
            send: 'show-description',
            id: target
        }
    }).done(function (result) {
        hidePreloader();
        // console.log("res");
        // console.log(result);

        var json = $.parseJSON(result);
        var statusCode = json.status_code;
        var statusMessage = json.status_message;
        var data = json.data;

        var html = '';

        var pageDescription = ( data.description && data.description !== '' ) ? data.description : '';

        // console.log("page");
        // console.log(pageTitle);

        if(!pageTitle)
        {
            pageTitle = 'NichePractice';
        }

        html += '<div class="modal-body">\n' +
            '                                <h3 class="modal-title p-b-10">'+pageTitle+'</h3>\n' +
            '                                <div class="row">\n' +
            '                                    <div class="col-md-12">\n' +
            '                                        <div class="text-center">\n' +
            // '<i class="fa fa-question-circle" aria-hidden="true" style="font-size: 56px;color: #5495d4;"></i>' +
            '                                            <div class="p-20">\n' +
            '                                            <div class="description-notify">\n' +
            pageDescription+'\n' +
            '                                            </div>\n' +
            '                                            </div>\n' +
            '                                        </div>\n' +
            '                                    </div>\n' +
            '\n' +
            '                                \n' +
            '\n' +
            '                                </div>\n' +
            '                            </div>';

        html += '<div class="modal-footer" style="display: table;margin: 0 auto;">';
        html += '<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>';
        html += '</div>';

        mainModel.modal('show');
        $(".modal-header", mainModel).after(html);
        // $(".modal-header").after(html);

        setTimeout(function () {
            popupScroll();
        },200);
    });

});





$(document.body).on('click', '.cont-btn5', function(e)
{
    // function giveMeSelectedIds(stepName){
    //     var targetIds = [];
    //     $('input[type=checkbox]:checked').each(function() {
    //         targetIds.push($(this).data('id'));
    //         return targetIds;
    //     });
    //     console.log(targetIds)
    //     console.log(stepName);
    // }
    // giveMeSelectedIds('#box1');


    var targetIds = [];
    $('input[type=checkbox]:checked').each(function() {
        targetIds.push($(this).data('id'));
        // return targetIds;
    });
    var selected = $('.form5 option:checked').val();
    targetIds.push(parseInt(selected));
//     console.log('targetIds')
//
//     console.log(targetIds)
// return;
    var action = $(this).attr("data-action");
    var target = $(this).attr("data-target");

    var siteUrl = $('#hfBaseUrl').val();

    showPreloader();

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },
        type: "POST",
        url: siteUrl + "/done-me",
        data: {
            send: 'done-me-onboard',
            id: targetIds
        }
    }).done(function (result) {
        // console.log("res");
        // console.log(result);

        var json = $.parseJSON(result);
        var statusCode = json.status_code;
        var statusMessage = json.status_message;
        var data = json.data;

        var html = '';

        if(statusCode == 200)
        {
            window.location.href = siteUrl + '/task-list';
        }
        else
        {
            hidePreloader();
            swal('', statusMessage, "error");
        }

        // console.log("page");
        // console.log(pageTitle);

        // if(!pageTitle)
        // {
        //     pageTitle = 'NichePractice';
        // }

        // html += '<div class="modal-body">\n' +
        //     '                                <h3 class="modal-title p-b-10">'+pageTitle+'</h3>\n' +
        //     '                                <div class="row">\n' +
        //     '                                    <div class="col-md-12">\n' +
        //     '                                        <div class="text-center">\n' +
        //     // '<i class="fa fa-question-circle" aria-hidden="true" style="font-size: 56px;color: #5495d4;"></i>' +
        //     '                                            <div class="p-20">\n' +
        //     '                                            <div class="description-notify">\n' +
        //     pageDescription+'\n' +
        //     '                                            </div>\n' +
        //     '                                            </div>\n' +
        //     '                                        </div>\n' +
        //     '                                    </div>\n' +
        //     '\n' +
        //     '                                \n' +
        //     '\n' +
        //     '                                </div>\n' +
        //     '                            </div>';
        //
        // html += '<div class="modal-footer" style="display: table;margin: 0 auto;">';
        // html += '<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>';
        // html += '</div>';

        // mainModel.modal('show');
        // $(".modal-header", mainModel).after(html);
        // $(".modal-header").after(html);
    });

});





















function showPreloader() {
    var preloader = $('.preloader');
    preloader.show();
    $("body").addClass('hide-overflow');
    preloader.addClass('preloader-opacity');
}


function hidePreloader() {
    var preloader = $('.preloader');
    preloader.removeClass('preloader-opacity');
    $("body").removeClass('hide-overflow');
    preloader.hide();
}

function resetLoaderButton($this) {
    $this.attr("disabled", false);
    $this.html($this.data('original-text'));
}

function showLoaderButton(target, message) {
    // console.log("showLoaderButton");
    var $this = $(target);
    $this.attr("disabled", true);
    var loadingText;

    if(message && message !== '')
    {
        loadingText = '<i class="fa fa-circle-o-notch fa-spin" style="margin-right: 5px;"></i>'+ message +' ...';
    }
    else
    {
        loadingText = '<i class="fa fa-circle-o-notch fa-spin"></i> Processing...';
    }

    if ($this.html() !== loadingText) {
        $this.data('original-text', $this.html());
        $this.html(loadingText);
    }
    return $this;
}

$(document.body).on('click', '.page-help', function (e) {
    var mainModel = $('#main-modal');
    $(".modal-body, .modal-footer, .validate-me", mainModel).remove();

    $(mainModel).removeClass('welcome-process');
    var pageTitle = $(".page-title").html();

    var action = $("#module-view").val();
    var dataModule = $(this).attr('data-module');
    if (dataModule) {
        if($("body").hasClass("modal-open") === true)
        {
            $(mainModel).addClass('modal-widget-info modal-multiple');
        }
        else
        {
            if($(this).parent('li').hasClass('do-it-yourself'))
            {
                console.log("yes checking");
                if($(".do-it-yourself").hasClass('active') == false)
                {
                    console.log("false");
                    return false;
                }
                $(mainModel).addClass('modal-widget-info');
            }
            else
            {
                $(mainModel).addClass('modal-page-info');
            }
        }
        action = dataModule;
        // console.log(action);
        // $( mainModel ).children().attr('style', 'max-width:700px !important; max-height:370px !important;');
        // $( mainModel ).find( ".slimScrollDiv" ).attr('style', 'height:0px !important');
        // $( mainModel ).find( ".description-notify-post" ).attr('style', 'height:0px !important');
        // $( mainModel ).find( ".slimScrollBar" ).attr('style', 'height:0px !important');
        // $( mainModel ).find( ".slimScrollRail" ).attr('style', 'height:0px !important');
        $( '#addCustomerStep2' ).children().children().css( "opacity", "0.4" );
    }
    else
    {
        // $(mainModel).children().css({"max-width": "700px", "max-height": "970px"});
        // $(mainModel).children().children().css({'border-radius':'0px'});
        $(mainModel).addClass('modal-page-info');
    }


    var siteUrl = $("#hfBaseUrl").val();

    showPreloader();

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },
        type: "POST",
        url: siteUrl + "/done-me",
        data: {
            send: 'need-help',
            module: action
        }
    }).done(function (result) {
        hidePreloader();
        // console.log("res");
        // console.log(result);

        var json = $.parseJSON(result);
        var statusCode = json.status_code;
        var statusMessage = json.status_message;
        var data = json.data;

        var html = '';
        var pageDescription = 'We are here for your help. This page instruction not found but you can contact us.';

        if (!pageTitle) {
            pageTitle = 'NichePractice';
        }
        var modalContentSettings = '';
        // console.log("daya");
        // console.log(data);
        if (data && data.length != 0) {
            // console.log("iff");
            pageTitle = (data.title && data.title !== '') ? data.title : pageTitle;

            modalContentSettings = (data.settings_module && data.settings_module !== '') ? data.settings_module : '';

            var pageDescription = (data.description && data.description !== '') ? data.description : 'We are here for your help. This page instruction not found but you can contact us.';

            // console.log("page ");
            // console.log(pageTitle);

            html += '<div class="modal-body" style="padding-top:0;">\n' +
                '                                <h3 class="modal-title p-b-10" style="display: none;">' + pageTitle + '</h3>\n' +
                '                                <div class="row">\n' +
                '                                    <div class="col-md-12">\n' +
                '                                        <div class="text-center1">\n' +
                '<i class="fa fa-question-circle" aria-hidden="true" style="font-size: 56px;color: #5495d4;display: none;"></i>' +
                '                                            <div class="p-0 description-notify-post">\n' +
                '                                                ' + pageDescription + '\n' +
                '                                            </div>\n' +
                '                                        </div>\n' +
                '                                    </div>\n' +
                '\n' +
                '                                \n' +
                '\n' +
                '                                </div>\n' +
                '                            </div>';

            console.log("action");
            console.log(action);
            if(action == 'do_it_yourself')
            {
                html += '<div class="modal-footer" style="padding-top: 0px; padding-bottom: 0px;">';
                html += '<div class="check" style="float: left;">\n' +
                    '    \n' +
                    '<input type="checkbox" id="close-do" style="width: 21px;">\n' +
                    '<label style="margin-top: 0px;">Never Show Again</label>    \n' +
                    '</div>';
                // html += '<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>';
                html += '</div>';

                $(".close", mainModel).addClass("never-shop-up-popup");
            }

            mainModel.modal('show');
            // $(".modal-header").after(html);


            $(".modal-header", mainModel).after(html);

            setTimeout(function () {
                mainModel.addClass(modalContentSettings);
            },200);

        } else {
            // console.log("else");
            html += '<div class="modal-body" style="padding-top:0;">\n' +
                '                                <h3 class="modal-title p-b-10" style="display: none;">' + pageTitle + '</h3>\n' +
                '                                <div class="row">\n' +
                '                                    <div class="col-md-12">\n' +
                '                                        <div class="text-center">\n' +
                '<i class="fa fa-question-circle" aria-hidden="true" style="font-size: 56px;color: #5495d4;display: none;"></i>' +
                '                                            <div class="p-0">\n' +
                '                                                <p>' + pageDescription + '</p>\n' +
                '                                            </div>\n' +
                '                                        </div>\n' +
                '                                    </div>\n' +
                '\n' +
                '                                \n' +
                '\n' +
                '                                </div>\n' +
                '                            </div>';

            html += '<div class="modal-footer" style="display: table;margin: 0 auto;">';
            // html += '<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>';
            html += '</div>';

            mainModel.modal('show');
            // $(".modal-header").after(html);
            $(".modal-header", mainModel).after(html);

        }

        setTimeout(function () {
            if(modalContentSettings === '')
            {
                if (dataModule) {
                    popupScroll(".description-notify-post");
                }
                else
                {
                    popupScroll(".description-notify-post", 450);
                }
            }
        },200);
    });
});

$(document).on('click', '.never-shop-up-popup', function () {
    if($("#close-do").is(':checked') == true) {
        var siteUrl = $("#hfBaseUrl").val();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            type: "post",
            url: siteUrl + "/done-me",
            data: {
                send: 'update-meta',
                do_yourself: 1
            }

        }).done(function (result) {

            var json = $.parseJSON(result);
            var statusCode = json.status_code;
            var statusMessage = json.status_message;
            var data = json.data;

            $(".do-it-yourself a").removeClass('page-help');
        });
    }
});

$(document.body).on('hidden.bs.modal', '.modal-multiple', function() {
    // console.log("trigered modal");
    if ($("body").hasClass("modal-open") === false) {
        $("body").addClass("modal-open")
    }
    $(".modal-multiple").removeClass('modal-multiple');
});
$(document.body).on('hidden.bs.modal', '#main-modal', function() {
    var mainModel = $('#main-modal');
    // console.log("hidden called");

    $(".modal-title", mainModel).remove();
    // do something...
    $( '#addCustomerStep2' ).children().children().css( "opacity", "1" );

    $('#main-modal').removeClass("full-width-cover modal-page-info modal-widget-info web-process-loading  modal-campaign-library2 google-analytics ");
    $(".modal-campaign-title", mainModel).remove();
    $(".OAuth-modal-body", mainModel).remove();
    $(".suggestion-container", mainModel).remove();
    $(mainModel).addClass('welcome-process');
    $(".modal-header .close", mainModel).attr('id', '');
    $('.modal-dialog', mainModel).removeClass('campaign-library-dialog');
});

// widget help starts
$(document).ready(function () {
    $('.widget-help-selector').click(function (e) {

        var mainModel = $('#main-modal');

        $(".modal-body, .modal-footer, .validate-me", mainModel).remove();

        $(mainModel).removeClass('welcome-process');
        $(mainModel).addClass('modal-widget-info');
        // $(mainModel).children().css({"max-width": "400px", "max-height": "970px"});
        // $(mainModel).children().children().css({'border-radius':'8px'});

        var pageTitle = $(".page-title").html();

        var widget_type = $(this).parent().parent().attr('data-widget-type');
        // console.log();
        var siteUrl = $("#hfBaseUrl").val();
        showPreloader();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            type: "post",
            url: siteUrl + "/done-me",
            data: {
                send: 'dasboard-widget-help',
                widget_type: widget_type
            }

        }).done(function (result) {
            hidePreloader();
            // console.log("res");
            // console.log(result);

            var json = $.parseJSON(result);
            var statusCode = json.status_code;
            var statusMessage = json.status_message;
            var data = json.data;

            var html = '';
            var pageDescription = 'We are here for your help. This page instruction not found but you can contact us.';

            if (!pageTitle) {
                pageTitle = 'NichePractice';
            }

            // console.log("daya");
            // console.log(data);
            if (data && data.length != 0) {
                // console.log("iff");
                pageTitle = (data.title && data.title !== '') ? data.title : pageTitle;
                var pageDescription = (data.description && data.description !== '') ? data.description : 'We are here for your help. This page instruction not found but you can contact us.';

                // console.log("page ");
                // console.log(pageTitle);

                html += '<div class="modal-body" style="padding-top:0;">\n' +
                    '                                <h3 class="modal-title p-b-10" style="display: none;">' + pageTitle + '</h3>\n' +
                    '                                <div class="row">\n' +
                    '                                    <div class="col-md-12">\n' +
                    '                                        <div class="text-center">\n' +
                    '<i class="fa fa-question-circle" aria-hidden="true" style="font-size: 56px;color: #5495d4;display: none;"></i>' +
                    '                                            <div class="p-0 description-notify">\n' +
                    '                                                <p>' + pageDescription + '</p>\n' +
                    '                                            </div>\n' +
                    '                                        </div>\n' +
                    '                                    </div>\n' +
                    '\n' +
                    '                                \n' +
                    '\n' +
                    '                                </div>\n' +
                    '                            </div>';

                html += '<div class="modal-footer" style="display: table;margin: 0 auto;">';
                // html += '<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>';
                html += '</div>';

                mainModel.modal('show');
                $("#main-modal .modal-header").after(html);
            } else {
                // console.log("else");
                html += '<div class="modal-body" style="padding-top:0;">\n' +
                    '                                <h3 class="modal-title p-b-10" style="display: none;">' + pageTitle + '</h3>\n' +
                    '                                <div class="row">\n' +
                    '                                    <div class="col-md-12">\n' +
                    '                                        <div class="text-center">\n' +
                    '<i class="fa fa-question-circle" aria-hidden="true" style="font-size: 56px;color: #5495d4;display: none;"></i>' +
                    '                                            <div class="p-0">\n' +
                    '                                                <p>' + pageDescription + '</p>\n' +
                    '                                            </div>\n' +
                    '                                        </div>\n' +
                    '                                    </div>\n' +
                    '\n' +
                    '                                \n' +
                    '\n' +
                    '                                </div>\n' +
                    '                            </div>';

                html += '<div class="modal-footer" style="display: table;margin: 0 auto;">';
                // html += '<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>';
                html += '</div>';

                mainModel.modal('show');
                $("#main-modal .modal-header").after(html);
            }
            setTimeout(function () {
                popupScroll();
            },200);

        }).fail(function (error) {
            hidePreloader();
        });
    });

});

// widget help ends


/**
 * if value is empty then return true.
 * @param val
 * @returns {boolean}
 */
function isEmptyVal(val) {
    return (!val) ? true : false;
    // return (!val) ? true : false;
}

/**
 * if value is empty then return true.
 * else not empty return false.
 * @param val
 * @returns {boolean}
 * 0 was considered as empty so I put restrict check.
 */
function isEmptyValNormal(val) {
    if((!val))
    {
        // console.log("val ");
        // console.log(val);
        if(val === 0)
        {
            // console.log("inner if");
            return false;
        }

        return true;
    }

    return false;
    // return (!val) ? true : false;
}

function isEmptyArray(val) {
    if(typeof val == "undefined")
    {
        return true
    }
    else
    {
        return false;
    }
}

// order template
$(document.body).on('click', '.template-order' ,function() {
    var siteUrl = $('#hfBaseUrl').val();
    var baseUrl = siteUrl;
    var moduleId = $(this).attr('data-target-id');
    var module = $(this).attr('data-module-credits-used');
    var currentTarget = $(this);

    var accountStatus = $('#isActivePaid').val();
    var purchasedText = '';

    var currentButton = $(this);

    showPreloader();
    if(module == 'marketing_pro_service')
    {
        purchasedText = $(this).attr("data-after-purchased");
        if (accountStatus != true) {
            setTimeout(function () {
                hidePreloader();
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
                    '<a href="' + baseUrl + '/upgrade" class="btn btn-login" style="margin: 0px auto;display: table;">Join Nichepractice</a>\n' +
                    '                                </div>\n' +
                    '                            </div>';

                mainModel.modal('show');
                $(".modal-upgrade-library .modal-header").prepend('<h3 class="modal-campaign-title">Subscription Required</h3>');
                $(".modal-upgrade-library .modal-header").after(html);

            }, 500);

            return false;
        }
    }

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },
        type: "POST",
        url: siteUrl + "/done-me",
        data: {
            send: 'purchase-order',
            module: module,
            moduleId: moduleId
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

        if(statusCode == 200)
        {
            if(module == 'marketing_pro_service')
            {
                $(currentButton).html(purchasedText);
                $(currentButton).removeClass('template-order');
                $(currentButton).addClass('btn-success');
            }
            else if(module == 'promotion_templates_pre_order')
            {
                var html = '<a href="'+siteUrl+'/create-promotion/'+window.btoa(moduleId)+'" class="btn btn-template-edit">\n' +
                    '                                                                        Edit\n' +
                    '                                                                    </a>';
                currentTarget.after(html);
                currentTarget.remove();
            }
            else
            {
                var html = '<a href="'+siteUrl+'/email/'+window.btoa(moduleId)+'" class="btn btn-template-edit">\n' +
                    '                                                                        Edit\n' +
                    '                                                                    </a>';
                currentTarget.after(html);
                currentTarget.remove();
            }

            if(isEmptyValNormal(data.creditsBalance) == false)
            {
                // console.log("inside check val");
                $(".sidebar-available-credits h1").html(data.creditsBalance);
            }

            hidePreloader();
            swal({
                title: "Success!",
                text: statusMessage,
                type: 'success'
            }, function () {
            });
        }
        else if(statusCode == 404)
        {
            var mainModel = $('#main-modal');
            // console.log("inss");
            mainModel.modal('hide');

            // ssdhs

            setTimeout(function () {
                $(".modal-body, .modal-footer, .validate-me", mainModel).remove();
                $(mainModel).removeClass('welcome-process');
                $(mainModel).addClass('modal-alert-credit');
                var html = '';

                html +=
                    '<div class="modal-body">\n' +
                    '                                        <h2 class="modal-order-title p-b-10 p-t-20">NOT ENOUGH CREDITS!</h2>\n' +
                    '                                        <div class="row">\n' +
                    '                                            <p>'+statusMessage+'</p>\n' +
                    '                                        </div>\n' +
                    '                                        <div class="row order-credit-actio p-t-15 p-b-10 text-center">\n' +
                    '                                            <a href="'+siteUrl+'/credits" class="btn add-credit-now p-r-5">Add More Credits</a>\n' +
                    '                                            <button class="btn order-credit-cancel">Cancel</button>\n' +
                    '\n' +
                    '\n' +
                    '                                        </div>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n';

                $(".modal-title").remove();
                $('.modal-header').prepend('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>');
                // $('.modal-body', mainModel).html(html);
                $(".modal-header", mainModel).after(html);
                hidePreloader();
                mainModel.modal('show');
            }, 1000);
        }
        else
        {
            hidePreloader();
            swal({
                title: "Error!",
                text: statusMessage,
                type: 'error'
            }, function () {
            });
        }
    });
});

function dateTimeFormat(requestedDateTime) {
    var d = new Date(Date.parse(requestedDateTime));

    var time = d.toLocaleTimeString().toLowerCase().replace(/([\d]+:[\d]+):[\d]+(\s\w+)/g, "$1$2");
    return (time);
}

$(document).ajaxComplete(function myErrorHandler(event, xhr, ajaxOptions, thrownError) {
    // alert("Ajax request completed with response code " + xhr.status);
    var currentPage = $('#currentPage').val();
    if (currentPage != 'not_found_page') {
        if(xhr.status == 419)
        {
            location.reload();
        }
    }
});


function notEnoughCredits(mainModel) {
    var baseUrl = $('#hfBaseUrl').val();
    mainModel.modal('hide');

    setTimeout(function () {
        $(".modal-body, .modal-footer, .validate-me", mainModel).remove();
        $(mainModel).removeClass('welcome-process');
        $(mainModel).addClass('modal-alert-credit');
        var html = '';

        html +=
            '<div class="modal-body">\n' +
            '                                        <h2 class="modal-order-title p-b-10 p-t-20">NOT ENOUGH CREDITS!</h2>\n' +
            '                                        <div class="row">\n' +
            '                                            <p>'+window.statusMessage+'</p>\n' +
            '                                        </div>\n' +
            '                                        <div class="row order-credit-actio p-t-15 p-b-10 text-center">\n' +
            '                                            <a href="'+baseUrl+'/credits" class="btn add-credit-now p-r-5">Add More Credits</a>\n' +
            '                                            <button class="btn order-credit-cancel">Cancel</button>\n' +
            '\n' +
            '\n' +
            '                                        </div>\n' +
            '                                    </div>\n' +
            '                                </div>\n';

        $(".modal-title").remove();
        $('.modal-header').prepend('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>');
        // $('.modal-body', mainModel).html(html);
        $(".modal-header", mainModel).after(html);
        hidePreloader();
        mainModel.modal('show');
    }, 1000);
}

$(document.body).on('click', '.order-credit-cancel', function () {
    var mainModel = $('.modal-alert-credit');
    $(".fa-exclamation-triangle", mainModel).remove();
    mainModel.modal('hide');
});

$(document.body).on('hidden.bs.modal','.modal-upgrade-library',function (e){
    var mainModel = $('#main-modal');
    // var mainModel = $('.modal-task-order');

    $(mainModel).removeClass('modal-task-order modal-alert-credit modal-campaign-library modal-upgrade-library');
    $(".modal-header i", mainModel).remove();
    $(".heading-credit", mainModel).remove();

    $(".modal-campaign-title", mainModel).remove();

    $(".modal-body, .modal-footer, .validate-me", mainModel).remove();
});
setInterval(function() {
    //your jQuery ajax code
    // alert('hi');
    var siteUrl = $("#hfBaseUrl").val();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },
        type: "POST",
        url: siteUrl + "/done-me",
        data: {
            send: 'update_db_online_time'
        }
    }).done(function (result) {
        // console.log('result');
        // console.log(result);
    });
}, 1000 * 60 );
// $(document).ready(function () {
//     var currentPage = $('#currentPage').val();
//     var siteUrl = $("#hfBaseUrl").val();
//     if (notfound != 'not_found_page') {
//         var scriptSrc = siteUrl +'/public/js/notification.js';
//         var script = document.createElement('script');
//         script.src = scriptSrc;
//         var head = document.getElementsByTagName('head')[0];
//         head.appendChild(script);
//     }
// });


