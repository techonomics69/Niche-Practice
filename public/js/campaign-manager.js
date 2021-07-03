// saveTemplateCall = progress, done
saveTemplateCall = 'done';
actionStatus = '';

templatePhoto = '';
templateLogo = '';
webUrl = '';
window.templateOwner = '';

$(function () {
    // console.log("userData");

    $("body").addClass('hide-sidebar');
    $(".sidebar").hide();

    // $(".steps-nav").show();
    // $(".loading-bar").hide();

    $(document.body).on('click', '.custom-checkbox' ,function() {
        var action = $(this).attr("data-action");
        var checkBox = $(".custom-checkbox");
        var currentType = ($(this).hasClass("custom-checkbox--checked") === true) ? 'selected' : '';

        if(action === 'all')
        {
            if(currentType === 'selected')
            {
                checkBox.removeClass('custom-checkbox--checked');
            }
            else
            {
                checkBox.addClass('custom-checkbox--checked');
            }
        }
        else
        {
            if(currentType === 'selected')
            {
                $(this).removeClass('custom-checkbox--checked');
            }
            else
            {
                $(this).addClass('custom-checkbox--checked');
            }
        }
    });

    $('#app iframe').on("load", function() {
        // console.log("iframe loaded > " + userId);
        getTemplate(templateId);
    });

    $(".campaign-steps span a").click(function () {
        var action = $(this).attr("data-action");
        // console.log("action " + action);
        // console.log("this ");
        // console.log($(this));

        $(".save-action").show();
        $(".save-current-state").show();

        if(action === 'add-recipients-container')
        {
            $(".import-action").show();
            $(".save-current-state").hide();
        }
        else
        {
            $(".import-action").hide();
        }

        if( action !== '' && !($(this).hasClass('active')) )
        {
            // console.log("Hi Inside");
            $(".campaign-steps span a").removeClass('active');
            $(this).addClass('active');

            // hide all the steps section
            $('.steps-section').hide();

            if(action === 'publish-container')
            {
                $(".save-action").hide();
                $(".save-current-state").hide();

                // check recipients are selected
                var recipients = [];
                recipients = getRecipients();

                // console.log('ac recipients');
                // console.log(recipients.length);
                $('#email-campaign-total-recipients').text(recipients.length);

                if(recipients.length === 0)
                {
                    // console.log('insid');
                    $(".publish-footer .btn").attr("disabled", true);
                    $("."+action + ' .alert').show();
                    // return false;
                }
                else
                {
                    // console.log('ELSE');
                    $(".publish-footer .btn").attr("disabled", false);
                    $("."+action + ' .alert').hide();
                }
            }

            // console.log("Go Next");
            $('.'+action).show();
        }
    });

    $(".save-action, .save-current-state").click(function () {
        // showPreloader();
        // console.log("clicked save-current-state");
        TopolPlugin.save();
    });

    // $(".next-action").click(function () {
    //
    // });

    $("#contact-add").on("keyup", function(event) {
        // Cancel the default action, if needed
        event.preventDefault();
        // Number 13 is the "Enter" key on the keyboard
        // console.log("yes 1");
        var textAlert =$(".text-alert");

        if (event.keyCode === 13) {

            // console.log("yes 2");
            textAlert.hide();
            var contactInput = $("#contact-add");
            var email = contactInput.val();

            var emailRegEx = /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i;

            // if email not verified on global rule.
            if(!emailRegEx.test(email))
            {
                // console.log("yes no");
                return false;
            }

            var tagLoader = $(".tag-loading");


            var siteUrl = $('#hfBaseUrl').val();

            textAlert.hide();

            tagLoader.show();
            contactInput.hide();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                type: "POST",
                url: siteUrl + "/done-me",
                data: {
                    'send': 'add-patient-customer',
                    'email': email
                }
            }).done(function (result) {
                var json = $.parseJSON(result);
                var statusCode = json.status_code;
                var statusMessage = json.status_message;
                var data = json.data;

                textAlert.show();
                var html = '';

                tagLoader.hide();
                contactInput.show();

                if(statusCode == 200)
                {
                    $("#contact-add").val('');
                    textAlert.removeClass('text-danger');
                    textAlert.addClass('text-success');
                    textAlert.html(statusMessage);

                    // console.log(data.id);
                    var contact = data.id;

                    html += '<tr role="row" class="" data-customer-id="'+contact+'">\n' +
                        '                                <td class="text-verticle-align">\n' +
                        '                                    <div class="checkbox-area">\n' +
                        '                                        <span class="custom-checkbox" data-action="single">\n' +
                        '                                        <input style="display: none; outline: 0;" id="data-'+contact+'" type="checkbox">\n' +
                        '                                    </span>\n' +
                        '                                    </div>\n' +
                        '                                    <div class="add-r-contact-column">\n' +
                        '                                        <img src="'+siteUrl+'/public/images/recipients-empty-contact.png" />\n' +
                        '                                        <label><span class="first-name-val"></span>' +
                        ' <span class="last-name-val"></span></label>\n' +
                        '                                    </div>\n' +
                        '                                </td>\n' +
                        '\n' +
                        '                                <td class="text-verticle-align">\n' +
                        '                                    <div class="add-r-mail-column">\n' +
                        '                                        <h3>'+email+'</h3>\n' +
                        '                                    </div>\n' +
                        '                                </td>\n' +
                        '<td class="text-verticle-align">\n' +
                        '                                    <h3 class="phone-number-val"></h3>\n' +
                        '                                </td>\n' +
                        '                                <td><div class="actions-container">\n' +
                        '   <a class="colored-button-icon edit-contact" data-customer-id="'+contact+'"><i class="mdi mdi-pencil" aria-hidden="true"></i></a>\n' +
                        '   \n' +
                        ' </div></td>\n' +
                        '                            </tr>';

                    $('.all-selection').after(html);

                    setTimeout(function () {
                        textAlert.hide();
                    }, 3000);
                }
                else
                {
                    textAlert.removeClass('text-success');
                    textAlert.addClass('text-danger');
                    textAlert.html(statusMessage);
                }
            });
        }
        else if($(this).val() === '')
        {
            textAlert.hide();
        }
    });

    $(".back-action-btn").click(function () {
        var currentActiveStep = $(".campaign-steps span a.active").parent('span').index();
        var siteUrl = $('#hfBaseUrl').val();

        // console.log("currentActiveStep " + currentActiveStep);
        if(currentActiveStep === 0)
        {
            // console.log(window.template_source_var);
            if(window.template_source_var === 'patient_campaign')
            {
                location.href = siteUrl+'/new-patient-emails';
            }
            else
            {
                if(isEmptyValNormal(window.templateOwner) == false && window.templateOwner != 1)
                {
                    location.href = siteUrl+'/email-campaigns';
                }
                else
                {
                    location.href = siteUrl+'/email-templates';
                }

                // var pathName = window.location.pathname;
                // function checkEmail(path) {
                //     return path == 'email';
                // }
                //
                // var pathNameArray = pathName.split('/');
                // var emailPathIndex = pathNameArray.findIndex(checkEmail);
                // var userIdPathIndex = emailPathIndex +2;
                // var userId = pathNameArray[userIdPathIndex];

                // if (userId == 1) {
                //     location.href = siteUrl+'/email-templates';
                //
                // } else {
                //     location.href = siteUrl+'/email-campaigns';
                // }
            }
        }
        else
        {
            // currentActiveStep--;
            $('.steps-nav .campaign-steps span:nth-child('+currentActiveStep+') a').click();
        }
    });

    $(".save-action").click(function () {
        var currentActiveStep = $(".campaign-steps span a.active").parent('span').index();
        var siteUrl = $('#hfBaseUrl').val();

        // console.log("currentActiveStep " + currentActiveStep);

        currentActiveStep = currentActiveStep + 2;
        $('.steps-nav .campaign-steps span:nth-child('+currentActiveStep+') a').click();
    });
});

$(document.body).on('click', '.edit-contact', function() {
    var siteUrl = $('#hfBaseUrl').val();
    var contactId = $(this).attr("data-customer-id");
    var currentParentSelector = $(this).parent().closest('tr');
    var userFirstName = $(".add-r-contact-column .first-name-val", currentParentSelector).html();
    var userLastName = $(".add-r-contact-column .last-name-val", currentParentSelector).html();
    var userPhone = $(".phone-number-val", currentParentSelector).html();

    // currentParentSelector.hide();

    $(".add-r-contact-column").show();
    $(".info-container").remove();
    $(".action-container").remove();

    var html = '';
    var inputActionContainer = '';

    html += '<div class="info-container">\n' +
        '        <input value="'+userFirstName+'" type="text" class="form-control" id="first_name" placeholder="Enter first name">\n' +
        '        <input value="'+userLastName+'" type="text" class="form-control" id="last_name" placeholder="Enter last name">\n' +
        '    </div>';

    $(".add-r-contact-column", currentParentSelector).after(html);
    $(".add-r-contact-column", currentParentSelector).hide();

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

    html = '<div class="info-container">\n' +
        '        <input value="'+userPhone+'" type="text" class="form-control" id="phone_number" placeholder="Enter phone number">\n' +
        '    </div>';

    $(".phone-number-val", currentParentSelector).hide();
    $(".phone-number-val", currentParentSelector).after(html);
});


$(document.body).on('click', '.cancel-this-action' ,function() {
    $(".info-container, .action-container").remove();
    $(".add-r-contact-column, .actions-container, .phone-number-val").show();
});

$(document.body).on('click', '.save-name' ,function() {
    var firstName = $("#first_name").val();
    var lastName = $("#last_name").val();
    var phoneNumber = $("#phone_number").val();
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
                'send': 'edit-patient-customer',
                'first_name': firstName,
                'last_name': lastName,
                'phone_number': phoneNumber,
                'id': contactId
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

            if(statusCode == 200)
            {
                $(".add-r-contact-column .first-name-val", currentParentSelector).html(firstName);
                $(".add-r-contact-column .last-name-val", currentParentSelector).html(lastName);
                $(".phone-number-val", currentParentSelector).html(phoneNumber);

                $(".cancel-this-action").click();

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
                // textAlert.removeClass('text-success');
                // textAlert.addClass('text-danger');
                // textAlert.html(statusMessage);
            }
        });
    }
});

$(document.body).on('click', '.btn-schedule' ,function() {
    // $('.remove-business-body, .social-module, .local-module, .select-business-body').hide();

    // $(".")
    var mainModel = $('#main-modal');
    $(".modal-body, .modal-footer, .validate-me", mainModel).remove();
    // $(".welcome-process", mainModel).remove();
    $(mainModel).removeClass('welcome-process');
    $(mainModel).addClass('scheduled-interface');


    var html = '';

    html += '<div class="modal-body">';

    html += '<div class="schedule-radio-btns">\n' +
        '\n' +
        '                    <label class="customradio"><span class="radiotextsty">Send it Now</span>\n' +
        '                        <input type="radio" checked="checked" name="radio" value="sendnow">\n' +
        '                        <span class="checkmark"></span>\n' +
        '                    <p class="radiodesc">Send your campaign now</p>\n' +
        '                    </label>\n' +
        '                    &nbsp; &nbsp; &nbsp;\n' +
        '                    <label class="customradio"><span class="radiotextsty">Schedule for a specific time</span>\n' +
        '                        <input type="radio" name="radio" value="schedule" />\n' +
        '                        <span class="checkmark"></span>\n' +
        '                        <p class="radiodesc">Schedule your to be sent in the future</p>\n' +
        '                    </label>\n' +
        '\n' +
        '                </div>';

    html += '<div class="datetime">\n' +
        '    <form class="form-inline">\n' +
        '        <div class="form-group">\n' +
        '            <label>Date</label>\n' +
        '            <input type="text" id="datepicker" class="date-picker" width="210" disabled />\n' +
        '        </div>\n' +
        '\n' +
        '        <div class="form-group">\n' +
        // '            <label>  Time (Europe/Paris GMT +01:00)</label>\n' +
        '            <label>  Time</label>\n' +
        '            <div class="custom_timepicker_container">\n' +
        '                <div class="custom_timepicker_time_selector">\n' +
        '                    <div class="show-inline-block">\n' +
        '                        <select id="custom_timepicker_hour_selector" class="form-control custom_timepicker_hour_selector" disabled>\n' +
        '                            <option selected="selected" value="00">00</option>\n';

    for(var i=1; i<=23; i++) {
        html += '<option value="'+i+'">'+i+'</option>';
    }

    html += '                        </select>\n' +
        '                    </div>\n' +
        '                    <div class="show-inline-block">:</div>\n' +
        '                    <div class="show-inline-block">\n' +
        '                        <select id="custom_timepicker_minutes_selector" class="form-control custom_timepicker_minutes_selector" disabled>\n' +
        '                            <option selected="" value="00">00</option>\n' +
        '                            <option value="10">10</option>\n' +
        '                            <option value="20">20</option>\n' +
        '                            <option value="30">30</option>\n' +
        '                            <option value="40">40</option>\n' +
        '                            <option value="50">50</option>\n' +
        '                        </select>\n' +
        '                    </div>\n' +
        '                </div>\n' +
        '            </div>\n' +
        '\n' +
        '        </div>\n' +
        '\n' +
        '    </form>\n' +
        '</div>';

    html += '</div>';

    html += '<div class="modal-footer">';
    html += '<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>';
    html += '<button type="submit" class="btn btn-primary connect-me">Save Change</button>';
    html += '</div>';

    mainModel.modal('show');
    $("#main-modal .modal-header").append('<div class="modal-heading text-center schedule-heading"> <h3>Schedule Campaign</h3> <p>Send your campaign now or schedule it in advance</p> </div>');
    $("#main-modal .modal-header").after(html);

    initiateDatePicker();
});

$('#main-modal').on('hidden.bs.modal', function () {
    var mainModel = $('#main-modal');
    $(mainModel).removeClass('scheduled-interface modal-page-info')
    $(".modal-body, .modal-footer, .validate-me, .schedule-heading", mainModel).remove();
});


$(".btn-sendnow").click(function () {
    showPreloader();
    window.actionStatus = 'sendnow';
    $(".save-action").click();
});

$(document).on('click', '.schedule-radio-btns input' ,function(e) {
    var selectedOption = $(this).val();

    var dateSelector = $("#datepicker");
    var hourSelector = $("#custom_timepicker_hour_selector");
    var minutesSelector =  $("#custom_timepicker_minutes_selector");

    if(selectedOption == 'schedule')
    {
        dateSelector.attr('disabled', false);
        hourSelector.attr('disabled', false);
        minutesSelector.attr('disabled', false);
    }
    else
    {
        dateSelector.val('');
        dateSelector.attr('disabled', true);
        hourSelector.attr('disabled', true);
        minutesSelector.attr('disabled', true);
    }
});

$(document.body).on('click', '.connect-me' ,function() {
    var userSelection = $(".scheduled-interface input[name='radio']:checked").val();

    if(userSelection === 'sendnow')
    {
        $(".btn-sendnow").click();
    }
    else if(userSelection === 'schedule')
    {
        showPreloader();
        window.actionStatus = 'schedule';
        $(".save-action").click();
    }

});
window.respo = '';

// Plugin Settings

// fsd.ark11@gmail.com

//api key created at 28-dec
//api key created again at 10-jan-2019


var userBusinessData = userData.business[0];
var TOPOL_OPTIONS = {
    id: "#app",
    authorize: {
        apiKey: "Gp1QsJyfAZwRlizPdy1pZ0pnASId49umK6Y5ptc99OoycrumsNHmTRPwEXTw",
        userId: editorUserId,
    },
    language: "en",
    light: true,
    premadeBlocks: false,
    savedBlocks: [],
    topBarOptions: [
        // 'saveButtons',
        "undoRedo",
        "changePreview",
        "previewSize",
        "previewTestMail"
    ], // Displays given elements in top bar
    // topBarOptions: [],
    // removeTopBar: false,
    disableAlerts: true,
    // changePreview: true,
    // templateId: 1,
    mergeTags: [
        { name: 'Merge tags', // Group name
            items: [
                // {
                //     value: "<img data-token-name='Doctor_Logo' src=\"%%Doctor_Logo%%\">",
                //     text: "Test Image",
                // },
                // {
                //     value: "<a href=\"*|UNSUBSCRIBE_LINK|*\">Unsubscribe</a>",
                //     text: "Unsubscribe",
                //     label: "Unsubscribe link"
                // },
                // { value: "<span class='token-data' data-token-name='UNSUBSCRIBE_LINK' data-target=\"*|UNSUBSCRIBE_LINK|*\">Unsubscribe</span>",
                //     text: "SUBc",
                //     label: "Unsubscribe link"
                // },
                {
                    value: userData.first_name, // Text to be inserted
                    text: "First name", // Shown text in the menu
                    label: "Your first name" // Shown description title in the menu
                },
                {
                    value: userData.last_name,
                    text: "Last name",
                    label: "Your last name"
                },{
                    value: userData.email,
                    text: "Email",
                    label: "Your Email Address"
                },
                {
                    value: userBusinessData.phone,
                    text: "Phone number.",
                    label: "Your Phone Number"
                },
                {
                    value: userBusinessData.website,
                    text: "Website",
                    label: "Your Website"
                },
                {
                    value: userBusinessData.address,
                    text: "Address",
                    label: "Your Address"
                },
                {
                    value: userBusinessData.city,
                    text: "City",
                    label: "Your City"
                },
                {
                    value: userBusinessData.state,
                    text: "State",
                    label: "Your State"
                },
                {
                    value: userBusinessData.zip_code,
                    text: "Zip",
                    label: "Your Xip Code"
                }
            ]
        }
    ],
    title: "My template builder",
    callbacks: {
        onSaveAndClose: function(json, html) {
            // console.log("onSaveAndClose");
            // console.log(json);
            // console.log(userId + ' > ' + templateId);
            saveTemplate(JSON.stringify(json), html, templateId);
            // HTML of the email
            // console.log(html);
            // JSON object of the email
        },
        onSave: function(json, html) {
            // console.log("onSave");
            window.respo = json;

            saveTemplate(JSON.stringify(json), html, templateId);

            // console.log("html");
            // console.log(html);
            // console.log("html 2");
            // $(".frame-container").html(html);

            // console.log("html");
            // console.log(html);
            // HTML of the email
            // console.log(html);
            // JSON object of the email
            // console.log(json);
        },
        onTestSend: function(email, json, html) {
            // console.log("onTestSend");

            sendTestMail(email, html);
        }
    }
};

TopolPlugin.init(TOPOL_OPTIONS);


function initiateDatePicker() {
    /*--FOR DATE----*/
    var date = new Date();
    var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
    $('#datepicker').datepicker({
        // format: 'dd-mm-yyyy',
        format: 'yyyy-mm-dd',
        container:'#main-modal',
        todayHighlight: true,
        startDate: today,
        endDate:0
    });
}

function reloadSavedBlock() {
    var siteUrl = $('#hfBaseUrl').val();

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },
        type: "POST",
        url: siteUrl + "/done-me",
        data: {
            send: 'admin-get-saved-block-list'
        }
    }).done(function (result) {
        // console.log("res");
        // console.log(result);

        var json = $.parseJSON(result);
        var data = json.data;

        var dataItems = [];
        var templateData;

        $.each(data, function (index,value) {
            templateData = {
                id: value.id,
                name: value.name,
                definition: [JSON.parse(value.definition)]
            };

            dataItems.push(templateData);
        });

        TopolPlugin.setSavedBlocks(dataItems);
    });
}

function sendTestMail(email, html) {

    var siteUrl = $('#hfBaseUrl').val();

    var dataItems = [];
    var data;

    showPreloader();

    data = {
        send: 'test-email',
        email: email,
        template_preview: html,
    };

    dataItems.push(data);

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },
        type: "POST",
        url: siteUrl + "/done-me",
        data: data
    }).done(function (result) {
        // console.log("res");
        // console.log(result);
        hidePreloader();

        var json = $.parseJSON(result);
        var statusCode = json.status_code;
        var statusMessage = json.status_message;
        var data = json.data;

        if(statusCode == 200)
        {
            // hidePreloader();
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
    // console.log("After call " + saveTemplateCall);
}

function saveTemplate(json, html, templateId) {
    // return true;
    var siteUrl = $('#hfBaseUrl').val();
    // Implement your own close callback
    // Data variable contains the response data of the save request

    saveTemplateCall = 'progress';
    // console.log("before ajax " + saveTemplateCall);

    // console.log("window.actionStatus " + actionStatus);

    var dataItems = [];
    var data;
    var replyEmail;

    if(actionStatus === 'sendnow')
    {
        replyEmail = $("#reply-email").val();

        if(replyEmail === '')
        {
            // replyEmail = 'noreply@nichepractice.com';
        }

        data = {
            send: 'save-template',
            subject: $("#subject").val(),
            from: $("#from").val(),
            templatePhoto: templatePhoto,
            templateLogo: templateLogo,
            reply_email: replyEmail,
            status: 'published',
            id: templateId,
            response: json,
            template_preview: html
        };
    }
    else if(actionStatus === 'schedule')
    {
        replyEmail = $("#reply-email").val();

        if(replyEmail === '')
        {
            // replyEmail = 'noreply@nichepractice.com';
        }

        var scheduleAt = $("#datepicker").val() + ' ' + $("#custom_timepicker_hour_selector").val() + ':' + $("#custom_timepicker_minutes_selector").val() + ':00';

        var date = new Date();
        var timeZoneNumber = date.getTimezoneOffset()/60;
        timeZoneNumber = timeZoneNumber *-1;
        var timeZone = 'GMT ' + timeZoneNumber;

        data = {
            send: 'save-template',
            templatePhoto: templatePhoto,
            templateLogo: templateLogo,
            subject: $("#subject").val(),
            from: $("#from").val(),
            reply_email: replyEmail,
            schedule_at: scheduleAt,
            timezone_offset: timeZone,
            status: 'schedule',
            id: templateId,
            response: json,
            template_preview: html
        };
    }
    else
    {
        data = {
            send: 'save-template',
            id: templateId,
            templatePhoto: templatePhoto,
            templateLogo: templateLogo,
            webUrl: webUrl,
            response: json,
            template_preview: html
        };
    }

    dataItems.push(data);

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },
        type: "POST",
        url: siteUrl + "/done-me",
        data: data
    }).done(function (result) {
        // console.log("res");
        // console.log(result);

        saveTemplateCall = 'done';
        // console.log("After ajax " + saveTemplateCall);

        var json = $.parseJSON(result);
        var statusCode = json.status_code;
        var statusMessage = json.status_message;
        var data = json.data;

        if(data.id && data.id !== '')
        {
            var template = data.id;
            var response = data.response;

            // console.log("template > " + template + " ) > aa > " + templateId);

            if(template !== templateId)
            {
                var uri = window.location.toString();
                // console.log("uri");
                // console.log(uri);
                var type_source = getParameterByName('type_source');
                // console.log("type_source");
                // console.log(type_source);
                var patientEmail = ''
                if(type_source == 'patient') {
                    patientEmail = '?type_source=patient'
                }
                var clean_uri = uri.substring(0, uri.indexOf("email"));
                // console.log("clean");
                // console.log(clean_uri);
                clean_uri = clean_uri + 'email/'+window.btoa(template)+patientEmail;
                // console.log("modified Clean URL");
                // console.log(clean_uri);
                window.history.replaceState({}, document.title, clean_uri);

                window.templateId = template;
            }
        }

        // console.log("tem window.actionStatus " + actionStatus);

        if(statusCode === 200)
        {
            // console.log("actionStatus " + actionStatus);

            if(actionStatus === 'sendnow' || actionStatus === 'schedule')
            {
                // hidePreloader();

                templateCustomerLink(actionStatus);

                // if(actionStatus === 'sendnow')
                // {
                //     // send emails to recipients
                //     sendPreview(templateId, userId);
                // }
                //
                // swal({
                //     title: "Successful!",
                //     text: (actionStatus === 'sendnow') ? "Email set in queue for sending." : "Email has been Scheduled for " + scheduleAt,
                //     type: "success"
                // }, function () {
                //     showPreloader();
                //     location.href = siteUrl+'/email-campaigns';
                // });
            }
            else if( actionStatus === 'import')
            {
                templateCustomerLink(actionStatus);
            }
            else {
                hidePreloader();
            }
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

        // TopolPlugin.load("{\"tagName\":\"mj-global-style\",\"children\":[{\"tagName\":\"mj-container\",\"attributes\":{\"background-color\":\"#FFFFFF\",\"containerWidth\":600},\"children\":[{\"tagName\":\"mj-section\",\"attributes\":{\"full-width\":\"full-width\",\"padding\":\"9px 0px 9px 0px\",\"background-color\":\"#F0C9D2\",\"background-url\":null},\"type\":null,\"children\":[{\"tagName\":\"mj-column\",\"attributes\":{\"width\":\"50%\",\"vertical-align\":\"top\"},\"children\":[{\"tagName\":\"mj-text\",\"attributes\":{\"align\":\"left\",\"font-size\":\"11\",\"locked\":\"true\",\"editable\":\"true\",\"padding-bottom\":\"0\",\"padding-top\":\"0\",\"containerWidth\":600,\"color\":\"#131212\",\"padding\":\"0px 0px 0px 0px\"},\"content\":\"<p>E-mail preheader</p>\\n\",\"uid\":\"iS11MzSD4\"}],\"uid\":\"_qoy4D-qm\"},{\"tagName\":\"mj-column\",\"attributes\":{\"width\":\"50%\",\"vertical-align\":\"top\"},\"children\":[{\"tagName\":\"mj-text\",\"attributes\":{\"align\":\"right\",\"font-size\":\"11\",\"locked\":\"true\",\"editable\":\"false\",\"padding-bottom\":\"0\",\"padding-top\":\"0\",\"containerWidth\":600,\"padding\":\"0px 0px 0px 0px\"},\"content\":\"<p><a draggable=\\\"false\\\" href=\\\"*|WEBVERSION|*\\\" style=\\\"color: #808080;\\\">Web version</a></p>\\n\",\"uid\":\"BLgQ51VTb\"}],\"uid\":\"XKU2mfGIam\"}],\"layout\":1,\"backgroundColor\":\"\",\"backgroundImage\":\"\",\"paddingTop\":0,\"paddingBottom\":0,\"paddingLeft\":0,\"paddingRight\":0,\"uid\":\"Cr8P8-2HW\"},{\"tagName\":\"mj-section\",\"attributes\":{\"full-width\":\"full-width\",\"padding\":\"0px 0px 0px 0px\",\"background-color\":\"#FFFFFF\"},\"type\":null,\"children\":[{\"tagName\":\"mj-column\",\"attributes\":{\"width\":\"100%\",\"vertical-align\":\"top\"},\"children\":[{\"tagName\":\"mj-spacer\",\"attributes\":{\"height\":11,\"containerWidth\":600},\"uid\":\"7PUZ2FYlvo\"}],\"uid\":\"8E1XEl4Gw3\"}],\"layout\":1,\"backgroundColor\":\"\",\"backgroundImage\":\"\",\"paddingTop\":0,\"paddingBottom\":0,\"paddingLeft\":0,\"paddingRight\":0,\"uid\":\"vzay56h_k\"},{\"tagName\":\"mj-section\",\"attributes\":{\"padding\":\"0px 0px 0px 0px\",\"background-color\":\"#FFFFFF\",\"background-url\":\"https://storage.googleapis.com/afuxova10642/5a2b21eb054845.4677968115127761710216.png\",\"full-width\":\"full-width\"},\"type\":null,\"children\":[{\"tagName\":\"mj-column\",\"attributes\":{\"width\":\"100%\",\"vertical-align\":\"top\"},\"children\":[{\"tagName\":\"mj-image\",\"attributes\":{\"src\":\"https://storage.googleapis.com/afuxova10642/logo-2.png\",\"padding\":\"13px 13px 13px 13px\",\"alt\":\"\",\"href\":\"\",\"containerWidth\":150,\"width\":150,\"widthPercent\":100},\"uid\":\"H5Yi56k6X\"}],\"uid\":\"B13SjbN1E\"}],\"layout\":1,\"backgroundColor\":\"\",\"backgroundImage\":\"\",\"paddingTop\":0,\"paddingBottom\":0,\"paddingLeft\":0,\"paddingRight\":0,\"uid\":\"Hk-_8ZN1V\"},{\"tagName\":\"mj-section\",\"attributes\":{\"full-width\":\"full-width\",\"padding\":\"0px 0px 0px 0px\",\"background-color\":\"#FFFFFF\"},\"type\":null,\"children\":[{\"tagName\":\"mj-column\",\"attributes\":{\"width\":\"100%\",\"vertical-align\":\"top\"},\"children\":[{\"tagName\":\"mj-spacer\",\"attributes\":{\"height\":11,\"containerWidth\":600},\"uid\":\"kbYc75QEdi\"}],\"uid\":\"KOjijFltLh\"}],\"layout\":1,\"backgroundColor\":\"\",\"backgroundImage\":\"\",\"paddingTop\":0,\"paddingBottom\":0,\"paddingLeft\":0,\"paddingRight\":0,\"uid\":\"E2Oj0ukto\"},{\"tagName\":\"mj-section\",\"attributes\":{\"full-width\":\"full-width\",\"padding\":\"9px 0px 9px 0px\",\"background-color\":\"#F0C9D2\"},\"type\":null,\"children\":[{\"tagName\":\"mj-column\",\"attributes\":{\"width\":\"100%\",\"vertical-align\":\"top\"},\"children\":[{\"tagName\":\"mj-text\",\"attributes\":{\"align\":\"center\",\"font-size\":\"11\",\"locked\":\"true\",\"editable\":\"false\",\"padding-bottom\":\"0\",\"padding-top\":\"0\",\"containerWidth\":600,\"padding\":\"0px 0px 0px 0px\"},\"content\":\"<p style=\\\"font-size: 11px;\\\"><span style=\\\"font-size:22px;\\\">Smartphones</span></p>\\n\\n<p style=\\\"font-size: 11px;\\\">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Pellentesque pretium lectus id turpis. Mauris tincidunt sem sed arcu. Nulla est. Donec vitae arcu. Duis bibendum, lectus ut viverra rhoncus, dolor nunc faucibus libero, eget facilisis enim ipsum id lacus. Fusce dui leo, imperdiet in</p>\\n\",\"uid\":\"VM_r3CEd4\"},{\"tagName\":\"mj-button\",\"attributes\":{\"align\":\"center\",\"background-color\":\"#6E9DE7\",\"color\":\"#fff\",\"border-radius\":\"24px\",\"font-size\":13,\"padding\":\"20px 20px 20px 20px\",\"inner-padding\":\"9px 26px\",\"href\":\"https://google.com\",\"font-family\":\"Ubuntu, Helvetica, Arial, sans-serif, Helvetica, Arial, sans-serif\",\"containerWidth\":600,\"border\":\"0px solid #000\"},\"content\":\"Discover more\",\"uid\":\"T6rNEjGaWF\"}],\"uid\":\"49VuRDdGAZ\"}],\"layout\":1,\"backgroundColor\":\"\",\"backgroundImage\":\"\",\"paddingTop\":0,\"paddingBottom\":0,\"paddingLeft\":0,\"paddingRight\":0,\"uid\":\"JFgczWEh6\"},{\"tagName\":\"mj-section\",\"attributes\":{\"full-width\":\"full-width\",\"padding\":\"0px 0px 0px 0px\",\"background-color\":\"#FFFFFF\"},\"type\":null,\"children\":[{\"tagName\":\"mj-column\",\"attributes\":{\"width\":\"100%\",\"vertical-align\":\"top\"},\"children\":[{\"tagName\":\"mj-spacer\",\"attributes\":{\"height\":11,\"containerWidth\":600},\"uid\":\"FnDnKo6tk6\"}],\"uid\":\"KOjijFltLh\"}],\"layout\":1,\"backgroundColor\":\"\",\"backgroundImage\":\"\",\"paddingTop\":0,\"paddingBottom\":0,\"paddingLeft\":0,\"paddingRight\":0,\"uid\":\"fw_PFqgPv\"},{\"tagName\":\"mj-section\",\"attributes\":{\"full-width\":\"full-width\",\"padding\":\"9px 0px 9px 0px\",\"background-color\":\"#EEE9E9\"},\"type\":null,\"children\":[{\"tagName\":\"mj-column\",\"attributes\":{\"width\":\"33.333333%\",\"vertical-align\":\"top\"},\"children\":[{\"tagName\":\"mj-image\",\"attributes\":{\"src\":\"https://storage.googleapis.com/afuxova10642/kisspng-telegram-computer-icons-apple-icon-image-format-telegram-icon-enkel-iconset-froyoshark-5ab08446a53055.4844118815215176386766.png\",\"padding\":\"0px 0px 0px 0px\",\"alt\":\"\",\"href\":\"\",\"containerWidth\":200,\"width\":90,\"widthPercent\":45},\"uid\":\"Fka2JLAsRB\"},{\"tagName\":\"mj-text\",\"attributes\":{\"align\":\"center\",\"font-size\":\"11\",\"padding\":\"0px 0px 0px 0px\",\"line-height\":1.5,\"containerWidth\":200},\"uid\":\"3Uvc77Km7\",\"content\":\"<p><strong>CLOUD</strong></p>\\n\"},{\"tagName\":\"mj-text\",\"attributes\":{\"align\":\"center\",\"font-size\":\"11\",\"padding\":\"1px 1px 1px 1px\",\"line-height\":1.5,\"containerWidth\":200},\"uid\":\"9slQPSH12\",\"content\":\"<p>Nulla est. Donec vitae arcu. Duis bibendum</p>\\n\"}],\"uid\":\"P8a9SJGo9Z\"},{\"tagName\":\"mj-column\",\"attributes\":{\"width\":\"33.333333%\",\"vertical-align\":\"top\"},\"children\":[{\"tagName\":\"mj-image\",\"attributes\":{\"src\":\"https://storage.googleapis.com/afuxova10642/kisspng-telegram-computer-icons-apple-icon-image-format-telegram-icon-enkel-iconset-froyoshark-5ab08446a53055.4844118815215176386766.png\",\"padding\":\"0px 0px 0px 0px\",\"alt\":\"\",\"href\":\"\",\"containerWidth\":200,\"width\":90,\"widthPercent\":45},\"uid\":\"Z1lAj3nxk\"},{\"tagName\":\"mj-text\",\"attributes\":{\"align\":\"center\",\"font-size\":\"11\",\"padding\":\"0px 0px 0px 0px\",\"line-height\":1.5,\"containerWidth\":200},\"uid\":\"mOXsNQEVG\",\"content\":\"<p><b>INTERNET</b></p>\\n\"},{\"tagName\":\"mj-text\",\"attributes\":{\"align\":\"center\",\"font-size\":\"11\",\"padding\":\"1px 1px 1px 1px\",\"line-height\":1.5,\"containerWidth\":200},\"uid\":\"U9TOgYtTn\",\"content\":\"<p>Nulla est. Donec vitae arcu. Duis bibendum</p>\\n\"}],\"uid\":\"gSAkKrXsPY\"},{\"tagName\":\"mj-column\",\"attributes\":{\"width\":\"33.333333%\",\"vertical-align\":\"top\"},\"children\":[{\"tagName\":\"mj-image\",\"attributes\":{\"src\":\"https://storage.googleapis.com/afuxova10642/kisspng-telegram-computer-icons-apple-icon-image-format-telegram-icon-enkel-iconset-froyoshark-5ab08446a53055.4844118815215176386766.png\",\"padding\":\"0px 0px 0px 0px\",\"alt\":\"\",\"href\":\"\",\"containerWidth\":200,\"width\":90,\"widthPercent\":45},\"uid\":\"qYFFLHlYQ\"},{\"tagName\":\"mj-text\",\"attributes\":{\"align\":\"center\",\"font-size\":\"11\",\"padding\":\"0px 0px 0px 0px\",\"line-height\":1.5,\"containerWidth\":200},\"uid\":\"0OYDcwxMf\",\"content\":\"<p><strong>APPS</strong></p>\\n\"},{\"tagName\":\"mj-text\",\"attributes\":{\"align\":\"center\",\"font-size\":\"11\",\"padding\":\"1px 1px 1px 1px\",\"line-height\":1.5,\"containerWidth\":200},\"uid\":\"Mr0nB3c8_\",\"content\":\"<p>Nulla est. Donec vitae arcu. Duis bibendum</p>\\n\"}],\"uid\":\"KoDnmLsJQC\"}],\"layout\":1,\"backgroundColor\":\"\",\"backgroundImage\":\"\",\"paddingTop\":0,\"paddingBottom\":0,\"paddingLeft\":0,\"paddingRight\":0,\"uid\":\"zdIAE2Ctp\"},{\"tagName\":\"mj-section\",\"attributes\":{\"full-width\":\"full-width\",\"padding\":\"0px 0px 0px 0px\",\"background-color\":\"#FFFFFF\"},\"type\":null,\"children\":[{\"tagName\":\"mj-column\",\"attributes\":{\"width\":\"100%\",\"vertical-align\":\"top\"},\"children\":[{\"tagName\":\"mj-spacer\",\"attributes\":{\"height\":11,\"containerWidth\":600},\"uid\":\"lhVergt8k\"}],\"uid\":\"8E1XEl4Gw3\"}],\"layout\":1,\"backgroundColor\":\"\",\"backgroundImage\":\"\",\"paddingTop\":0,\"paddingBottom\":0,\"paddingLeft\":0,\"paddingRight\":0,\"uid\":\"G1VKUAZas\"},{\"tagName\":\"mj-section\",\"attributes\":{\"full-width\":\"full-width\",\"padding\":\"9px 0px 9px 0px\",\"background-color\":\"#F0C9D2\"},\"type\":null,\"children\":[{\"tagName\":\"mj-column\",\"attributes\":{\"width\":\"60%\",\"vertical-align\":\"top\"},\"children\":[{\"tagName\":\"mj-image\",\"attributes\":{\"src\":\"https://storage.googleapis.com/afuxova10642/kisspng-mobile-app-development-infographic-mobile-device-vector-phone-app-5aa8c45ba73be3.064688941521009755685.png\",\"padding\":\"0px 0px 0px 0px\",\"alt\":\"\",\"href\":\"\",\"containerWidth\":300,\"width\":300,\"widthPercent\":100},\"uid\":\"o7NXhRUX6\"}],\"uid\":\"g-Grf7aLX\"},{\"tagName\":\"mj-column\",\"attributes\":{\"width\":\"40%\",\"vertical-align\":\"top\"},\"children\":[{\"tagName\":\"mj-text\",\"attributes\":{\"align\":\"left\",\"font-size\":\"11\",\"padding\":\"5px 5px 5px 5px\",\"line-height\":1.5,\"containerWidth\":300},\"uid\":\"o6nDKFpdv\",\"content\":\"<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Pellentesque pretium</p>\\n\"},{\"tagName\":\"mj-text\",\"attributes\":{\"align\":\"left\",\"font-size\":\"11\",\"padding\":\"5px 0px 5px 15px\",\"line-height\":1.5,\"containerWidth\":300},\"uid\":\"gPFW27gCu\",\"content\":\"<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Pellentesque pretium lectus id turpis.</p>\\n\"},{\"tagName\":\"mj-text\",\"attributes\":{\"align\":\"left\",\"font-size\":\"11\",\"padding\":\"5px 5px 5px 5px\",\"line-height\":1.5,\"containerWidth\":300},\"uid\":\"nW-n40KBk\",\"content\":\"<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Pellentesque pretium</p>\\n\"}],\"uid\":\"xTvKhTYdTK\"}],\"layout\":1,\"backgroundColor\":\"\",\"backgroundImage\":\"\",\"paddingTop\":0,\"paddingBottom\":0,\"paddingLeft\":0,\"paddingRight\":0,\"uid\":\"zdix1J84_\"},{\"tagName\":\"mj-section\",\"attributes\":{\"full-width\":\"full-width\",\"padding\":\"0px 0px 0px 0px\",\"background-color\":\"#FFFFFF\"},\"type\":null,\"children\":[{\"tagName\":\"mj-column\",\"attributes\":{\"width\":\"100%\",\"vertical-align\":\"top\"},\"children\":[{\"tagName\":\"mj-spacer\",\"attributes\":{\"height\":11,\"containerWidth\":600},\"uid\":\"yXtby-V9h2\"}],\"uid\":\"q9ZBP_aJDV\"}],\"layout\":1,\"backgroundColor\":\"\",\"backgroundImage\":\"\",\"paddingTop\":0,\"paddingBottom\":0,\"paddingLeft\":0,\"paddingRight\":0,\"uid\":\"QjHhIg5da\"},{\"tagName\":\"mj-section\",\"attributes\":{\"full-width\":\"full-width\",\"padding\":\"9px 0px 9px 0px\",\"background-color\":\"#FFFFFF\",\"background-url\":\"https://storage.googleapis.com/afuxova10642/5a2b21eb054845.4677968115127761710216-1.png\"},\"type\":null,\"children\":[{\"tagName\":\"mj-column\",\"attributes\":{\"width\":\"100%\",\"vertical-align\":\"top\"},\"children\":[{\"tagName\":\"mj-text\",\"attributes\":{\"align\":\"center\",\"font-size\":\"11\",\"padding\":\"15px 15px 15px 15px\",\"line-height\":1.5,\"containerWidth\":600},\"uid\":\"AcvebToUz\",\"content\":\"<p>Contact address</p>\\n\\n<p>Why You get this newsletter?</p>\\n\"},{\"tagName\":\"mj-text\",\"attributes\":{\"align\":\"center\",\"font-size\":\"11\",\"locked\":\"true\",\"editable\":\"true\",\"padding-bottom\":\"0\",\"padding-top\":\"0\",\"containerWidth\":600,\"padding\":\"0px 0px 0px 0px\"},\"content\":\"<p style=\\\"font-size: 11px;\\\">No more offers? <strong><span style=\\\"color: rgb(0, 0, 0);\\\"><a href=\\\"*|UNSUB|*\\\" style=\\\"color: #000000;\\\">Unsubscribe</a>.</span></strong></p>\\n\",\"uid\":\"Lt7pq5THM\"}],\"uid\":\"Rz7zv2CJTn\"}],\"layout\":1,\"backgroundColor\":\"\",\"backgroundImage\":\"\",\"paddingTop\":0,\"paddingBottom\":0,\"paddingLeft\":0,\"paddingRight\":0,\"uid\":\"1xXLEbUPm\"}]}],\"style\":[],\"attributes\":{\"mj-text\":{\"line-height\":1.5},\"mj-button\":[],\"mj-section\":{\"background-color\":\"#FFFFFF\"}},\"fonts\":[]}");
        // TopolPlugin.load(data);
    });

    // console.log("After call " + saveTemplateCall);
}
function getParameterByName(name, url = window.location.href) {
    name = name.replace(/[\[\]]/g, '\\$&');
    var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}

function sendPreview(templateId) {
    var siteUrl = $('#hfBaseUrl').val();
    // Implement your own close callback
    // Data variable contains the response data of the save request

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },
        type: "POST",
        url: siteUrl + "/done-me",
        data: {
            send: 'send-template-preview',
            template_id: templateId
        }
    }).done(function (result) {
        // console.log("res");
        // console.log(result);

        var json = $.parseJSON(result);
        var data = json.data;

        var statusCode = json.status_code;

        // console.log("sendPreview > " + statusCode);

        swal({
            title: "Successful!",
            text: "Email set in queue for sending.",
            type: "success"
        }, function () {
            showPreloader();
            location.href = siteUrl+'/email-campaigns';
        });

        // if(statusCode == 200)
        // {
        //
        // }

    });
}


function getTemplate(templateId) {
    if(templateId && templateId !== '')
    {
        // console.log("id");
        var siteUrl = $('#hfBaseUrl').val();
        // Implement your own close callback
        // Data variable contains the response data of the save request

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            type: "POST",
            url: siteUrl + "/done-me",
            data: {
                send: 'get-template',
                id: templateId,
                // user_id: userId,
                // response: json
            }
        }).done(function (result) {
            // console.log("res");
            // console.log(result);

            var json = $.parseJSON(result);
            var data = json.data;
            // console.log(data);

            window.template_source_var = '';

            if(data.template_source && data.template_source === "patient_campaign")
            {
                window.template_source_var = data.template_source;
                // console.log("iff");
                $(".steps-nav").show();
                $(".loading-bar").hide();
                $(".action-center").show();
                $(".campaign-steps").hide();
                $(".save-action").hide();
            }
            else
            {
                $(".steps-nav").show();
                $(".loading-bar").hide();
                $(".action-center").show();
            }

            if(data.id && data.id !== '') {
                window.templateOwner = data.user_id;
                if(data.user_id == 1)
                {
                    // var mainModel = $('#main-modal');
                    //
                    // $(".modal-body, .modal-footer, .validate-me", mainModel).remove();
                    //
                    // $(mainModel).removeClass('welcome-process');
                    // $(mainModel).addClass('modal-page-info');
                    // var html = '';
                    // html += '<div class="modal-body">\n' +
                    //     '                                <h3 class="modal-title p-b-10">Customize the Email Campaign</h3>\n' +
                    //     '                                <div class="row">\n' +
                    //     '                                    <div class="col-md-12">\n' +
                    //     '                                        <div class="text-center">\n' +
                    //     '                                            <div class="p-20">\n' +
                    //     '                                            <div class="description-notify">You can change the text type, size, color, alignment, and add links. You can even delete a text block entirely if you don’t need it by clicking the Trash Can icon.  When you’re finished editing your email, it’s time to schedule it to send to your contacts!' +
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
                    //
                    // mainModel.modal('show');
                    // $(".modal-header").after(html);
                }

                var title = data.title;
                var subject = data.subject;
                var status = data.status;
                var template_status = data.template_status;

                $("#subject").val(subject);
                $("#from").val(data.from);
                $("#reply-email").val(data.reply_email);
                // $("#from").val(title);
            }

            if(status == 'published' || (status == 'schedule' && isEmptyValNormal(template_status) == false))
            {
                var pubishedDate = data.updated_at;

                // console.log(my_date_format(pubishedDate));
                $(".action-center").remove();
                $(".publish-section .publish-footer").remove();

                var bannerAlert = $(".banner-success");
                bannerAlert.show();
                $(".dashboard-wrapper").addClass('m-t-60');

                if(status == 'schedule' && isEmptyValNormal(template_status) == false)
                {
                    pubishedDate = data.schedule_at;
                    // bannerAlert.html("Schedule Template Sent On "+ $.datepicker.formatDate('MM dd, yy', new Date(pubishedDate)) + " " + dateTimeFormat(pubishedDate));
                    bannerAlert.html("Schedule Template sent on "+ $.datepicker.formatDate('MM dd, yy', new Date(pubishedDate)));
                }
                else {
                    bannerAlert.html("Template sent on "+ $.datepicker.formatDate('MM dd, yy', new Date(pubishedDate)));
                }

            }

            var response = data.response;

            templatePhoto = data.userPhoto;
            templateLogo = data.userLogo;
            // webUrl = 'http://abc.com';
            webUrl = data.Doctor_Website_Url;

            // console.log("loaded respone");
            // console.log(templateLogo);

            // data-mce-href

            TopolPlugin.load(response);

            setTimeout(function () {
                reloadSavedBlock();
            },500);
        });
    }
    else
    {
        $(".steps-nav").show();
        $(".loading-bar").hide();
        $(".action-center").show();

        // console.log("yes");
        TopolPlugin.load(
            JSON.stringify(
                {
                    "tagName": "mj-global-style",
                    "attributes": {
                        "h1:color": "#000",
                        "h1:font-family": "Helvetica, sans-serif",
                        "h2:color": "#000",
                        "h2:font-family": "Ubuntu, Helvetica, Arial, sans-serif",
                        "h3:color": "#000",
                        "h3:font-family": "Ubuntu, Helvetica, Arial, sans-serif",
                        ":color": "#000",
                        ":font-family": "Ubuntu, Helvetica, Arial, sans-serif",
                        ":line-height": "1.5",
                        "a:color": "#24bfbc",
                        "button:background-color": "#e85034",
                        "containerWidth": 600,
                        "fonts": "Helvetica,sans-serif,Ubuntu,Arial",
                        "mj-text": {
                            "line-height": 1.5,
                            "font-size": 15
                        },
                        "mj-button": []
                    },
                    "children": [
                        {
                            "tagName": "mj-container",
                            "attributes": {
                                "background-color": "#FFFFFF",
                                "containerWidth": 600
                            },
                            "children": [
                                {
                                    "tagName": "mj-section",
                                    "attributes": {
                                        "full-width": false,
                                        "padding": "9px 0px 9px 0px"
                                    },
                                    "children": [
                                        {
                                            "tagName": "mj-column",
                                            "attributes": {
                                                "width": "100%"
                                            },
                                            "children": [],
                                            "uid": "HJQ8ytZzW"
                                        }
                                    ],
                                    "layout": 1,
                                    "backgroundColor": null,
                                    "backgroundImage": null,
                                    "paddingTop": 0,
                                    "paddingBottom": 0,
                                    "paddingLeft": 0,
                                    "paddingRight": 0,
                                    "uid": "Byggju-zb"
                                }
                            ]
                        }
                    ],
                    "style": {
                        "h1": {
                            "font-family": "\"Cabin\", sans-serif"
                        }
                    },
                    "fonts": [
                        "\"Cabin\", sans-serif"
                    ]
                }
            )
        );

        setTimeout(function () {
            reloadSavedBlock();
        },500);
    }
}

function getLinkedTemplateUsers(templateId)
{
    var siteUrl = $('#hfBaseUrl').val();
    // Implement your own close callback
    // Data variable contains the response data of the save request

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },
        type: "POST",
        url: siteUrl + "/done-me",
        data: {
            send: 'get-template-users-link',
            id: templateId
        }
    }).done(function (result) {
        // console.log("res");
        // console.log(result);

        var json = $.parseJSON(result);
        var dataObject = json.data;

        hidePreloader();

        var html = '';
        html += '<tr class="all-selection">\n' +
            '                            <td class="text-verticle-align">\n' +
            '                                <div class="checkbox-area">\n' +
            '                                                            <span class="custom-checkbox" data-action="all">\n' +
            '                                                                    <input style="display: none; outline: 0;" id="all" type="checkbox" checked="checked">\n' +
            '                                                                </span>\n' +
            '                                </div>\n' +
            '                                <div class="add-r-contact-column">\n' +
            '                                    <label>All</label>\n' +
            '                                </div>\n' +
            '                            </td>\n' +
            '                            <td></td>\n' +
            '                            <td></td>\n' +
            '                            <td></td>\n' +
            '                        </tr>';
        $.each(dataObject, function (index, data) {
            var contact = data.id;
            var email = data.email;
            var recipientLinked = data.recipient_id;
            var firstName = data.first_name;
            var lastName = data.last_name;
            var phoneNumber = data.phone_number;

            if(!firstName)
            {
                firstName = '';
            }

            if(!lastName)
            {
                lastName = '';
            }
            if(!phoneNumber)
            {
                phoneNumber = '';
            }
            if(!recipientLinked)
            {
                recipientLinked = '';
            }

            html += '<tr role="row" class="" data-customer-id="' + contact + '">\n' +
                '                                <td class="text-verticle-align">\n' +
                '                                    <div class="checkbox-area">\n';

            if (recipientLinked === '') {
                html += '                                        <span class="custom-checkbox" data-action="single">\n' +
                    '                                        <input style="display: none; outline: 0;" id="data-' + contact + '" type="checkbox">\n' +
                    '                                    </span>\n';
            } else {
                html += '                                        <span class="custom-checkbox custom-checkbox--checked" data-action="single">\n' +
                    '                                        <input style="display: none; outline: 0;" id="data-' + contact + '" type="checkbox">\n' +
                    '                                    </span>\n';
            }

                html +='                                    </div>\n' +
                '                                    <div class="add-r-contact-column">\n' +
                '                                        <img src="' + siteUrl + '/public/images/recipients-empty-contact.png" />\n' +
                '                                        <label>\n' +
                    '<span class="first-name-val">'+firstName+'</span>\n'+
                    '<span class="last-name-val">'+lastName+'</span>\n'+
                '</label></div>\n' +
                '                                </td>\n' +
                '                                <td class="text-verticle-align">\n' +
                '                                    <div class="add-r-mail-column">\n' +
                '                                        <h3>' + email + '</h3>\n' +
                '                                    </div>\n' +
                '                                </td>\n' +
                '<td class="text-verticle-align">\n' +
                '                                    <h3 class="phone-number-val">'+phoneNumber+'</h3>\n' +
                '                                </td>\n' +
                '                                <td><div class="actions-container">\n' +
                '   <a class="colored-button-icon edit-contact" data-customer-id="' + contact + '"><i class="mdi mdi-pencil" aria-hidden="true"></i></a>\n' +
                '   \n' +
                ' </div></td>\n' +
                    '                            </tr>';
        });

        $(".campaign-builder-page tbody").html(html);
    });
}

function templateCustomerLink(actionCommand = '') {
    var siteUrl = $('#hfBaseUrl').val();

    var recipients = [];
    recipients = getRecipients();

    // console.log("templateId");
    // console.log(templateId);
    // console.log("recipients");
    // console.log(recipients);

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },
        type: "POST",
        url: siteUrl + "/done-me",
        data: {
            send: 'template-users-link',
            template_id: templateId,
            recipients: recipients,
            actionCommand: actionCommand
        }
    }).done(function (result) {
        // console.log("res");
        // console.log(result);

        var json = $.parseJSON(result);
        var statusCode = json.status_code;
        var statusMessage = json.status_message;
        var data = json.data;


        // console.log("templateId");
        // console.log(templateId);

        if(statusCode == 200 || statusCode == 4)
        {
            // console.log("template saving " + actionCommand);
            if(actionCommand === 'sendnow')
            {
                // send emails to recipients
                sendPreview(window.templateId);
            }
            else if(actionCommand === 'schedule')
            {
                hidePreloader();
                $(".scheduled-interface .modal-footer .btn-default").click();
                var scheduleAt = $("#datepicker").val() + ' ' + $("#custom_timepicker_hour_selector").val() + ':' + $("#custom_timepicker_minutes_selector").val() + ':00';
                swal({
                    title: "Successful!",
                    text: "Email has been Scheduled for " + scheduleAt,
                    type: "success"
                }, function () {
                    showPreloader();
                    location.href = siteUrl+'/email-campaigns';
                });
            }
            else if(actionCommand === 'import')
            {
                // showPreloader();
                // getLinkedTemplateUsers(window.templateId);
            }

        }
        else
        {
            hidePreloader();
        }
    });
}

function getRecipients() {
    var recipients = [];
    $("#add-recipients-table tr").each(function()
    {
        var recipient = $(this).find('.custom-checkbox--checked').closest('tr').attr("data-customer-id");

        if(recipient && recipient !== '')
        {
            // console.log("inside " + recipient);
            recipients.push(recipient);
        }
    });

    return recipients;
}

function actionButtonStatus(accessType) {

    if(accessType && accessType === 'revoke')
    {
        $(".publish-footer .btn, .save-action").attr("disabled", true);
    }
    else
    {
        $(".publish-footer .btn, .save-action").attr("disabled", false);
    }
}

// {
//     "tagName"
// :
//     "mj-global-style", "children"
// :
//     [{
//         "tagName": "mj-body", "attributes":
//             {"background-color": "#f0f0f0", "containerWidth": "600"}, "children":
//             [
//                 {
//             "tagName": "mj-section",
//             "attributes": {
//                 "locked": "true",
//                 "full-width": "full-width",
//                 "containerWidth": "600",
//                 "background-color": "#f0f0f0",
//                 "padding": "3px 0px 3px 0px"
//             },
//             "children":
//                 [
//                 {
//                 "tagName": "mj-column",
//                 "attributes": {"width": "66.66666666666666%", "vertical-align": "middle", "containerWidth": "400"},
//                 "children": [{
//                     "tagName": "mj-text",
//                     "attributes": {
//                         "align": "left",
//                         "font-size": "11px",
//                         "locked": "true",
//                         "editable": "true",
//                         "padding-bottom": "0",
//                         "padding-top": "0",
//                         "containerWidth": "396",
//                         "color": "#7a7a7a",
//                         "font-family": "Cabin, sans-serif",
//                         "padding": "0px 0px 0px 0px"
//                     },
//                     "content": "<p><span style=\"font-size: 11px;\">Preheader<\/span><\/p>",
//                     "uid": "BJZTmSlqh7"
//                 }],
//                 "uid": "BJxa7Hl9hQ"
//             }, {
//                 "tagName": "mj-column",
//                 "attributes": {"width": "33.33333333333333%", "vertical-align": "middle", "containerWidth": "134"},
//                 "children": [{
//                     "tagName": "mj-text",
//                     "attributes": {
//                         "align": "right",
//                         "font-size": "11px",
//                         "locked": "true",
//                         "editable": "false",
//                         "padding-bottom": "0",
//                         "padding-top": "0",
//                         "containerWidth": "198",
//                         "font-family": "Cabin, sans-serif",
//                         "padding": "0px 0px 0px 0px",
//                         "color": "#511423"
//                     },
//                     "content": "<p><span style=\"color: rgb(81, 20, 35);\"><a href=\"*|WEBVERSION|*\" style=\"color: #511423;\">Web version<\/a><\/span><\/p>",
//                     "uid": "rk76mHgchm"
//                 }],
//                 "uid": "r1fTQBlc3m"
//             }],
//             "uid": "r1pQrlc2Q"
//         }, {
//             "tagName": "mj-section",
//             "attributes": {"padding": "17px 0px 17px 0px", "background-color": "#FFFFFF", "containerWidth": "600"},
//             "type": null,
//             "children": [{
//                 "tagName": "mj-column",
//                 "attributes": {"width": "60%", "vertical-align": "top"},
//                 "children": [{
//                     "tagName": "mj-image",
//                     "attributes": {
//                         "src": "https:\/\/storage.googleapis.com\/topolio14345\/plugin-assets\/6320\/14345\/doctor-logo%20copy.jpg",
//                         "padding": "0px 0px 0px 0px",
//                         "alt": null,
//                         "href": null,
//                         "containerWidth": "360",
//                         "width": "252",
//                         "widthPercent": "70"
//                     },
//                     "uid": "UytJ11UX7"
//                 }],
//                 "uid": "bX0oJ0hG_"
//             }, {
//                 "tagName": "mj-column",
//                 "attributes": {"width": "40%", "vertical-align": "top"},
//                 "children": [{
//                     "tagName": "mj-text",
//                     "attributes": {
//                         "align": "right",
//                         "font-size": "11px",
//                         "padding": "15px 15px 15px 15px",
//                         "line-height": "1.5",
//                         "containerWidth": "240"
//                     },
//                     "uid": "78AJdrFGH",
//                     "content": "<p><span style=\"font-size: 18px;\">CALL: 456-456-7894<\/span><\/p>"
//                 }],
//                 "uid": "xxwjfAITBM"
//             }],
//             "layout": "1",
//             "backgroundColor": null,
//             "backgroundImage": null,
//             "paddingTop": "0",
//             "paddingBottom": "0",
//             "paddingLeft": "0",
//             "paddingRight": "0",
//             "uid": "aLLCAZDcC"
//         }, {
//             "tagName": "mj-section",
//             "attributes": {
//                 "full-width": "false",
//                 "padding": "9px 0px 9px 0px",
//                 "background-color": "#e0c5b6",
//                 "background-url": "https:\/\/storage.googleapis.com\/topolio14345\/plugin-assets\/6320\/14345\/cov.jpg",
//                 "containerWidth": "600"
//             },
//             "type": null,
//             "children": [{
//                 "tagName": "mj-column",
//                 "attributes": {"width": "40%", "vertical-align": "top"},
//                 "children": [{
//                     "tagName": "mj-spacer",
//                     "attributes": {"height": "50px", "containerWidth": "240"},
//                     "uid": "Hp5EvxFas"
//                 }],
//                 "uid": "f0QZ9Ozhn"
//             }, {
//                 "tagName": "mj-column",
//                 "attributes": {"width": "60%", "padding": "2px 2px 2px 2px", "vertical-align": "top"},
//                 "children": [{
//                     "tagName": "mj-spacer",
//                     "attributes": {"height": "15px", "containerWidth": "360"},
//                     "uid": "9t5m5qUk6"
//                 }, {
//                     "tagName": "mj-text",
//                     "attributes": {
//                         "align": "left",
//                         "font-size": "11px",
//                         "padding": "31px 31px 31px 31px",
//                         "line-height": "1.5",
//                         "color": "#181414",
//                         "containerWidth": "360"
//                     },
//                     "uid": "ll--zhFYG",
//                     "content": "<p>&nbsp;<\/p>\n<p><span style=\"font-size: 24px; background-color: #7e8c8d; color: #ffffff;\">I'm Dr. Ted Jones<\/span><\/p>\n<p><span style=\"font-size: 24px; background-color: #7e8c8d; color: #ffffff;\">I enpower people to Look Good, Feel Good, adn Love their smail!<\/span><\/p>\n<p>&nbsp;<\/p>\n<p>&nbsp;<\/p>\n<p>&nbsp;<\/p>"
//                 }],
//                 "uid": "6tzCwnD2Wg"
//             }],
//             "layout": "1",
//             "backgroundColor": null,
//             "backgroundImage": null,
//             "paddingTop": "0",
//             "paddingBottom": "0",
//             "paddingLeft": "0",
//             "paddingRight": "0",
//             "uid": "Sh-t4K46F"
//         }, {
//             "tagName": "mj-section",
//             "attributes": {"padding": "9px 0px 9px 0px", "background-color": "#FFF", "containerWidth": "600"},
//             "type": null,
//             "children": [{
//                 "tagName": "mj-column",
//                 "attributes": {"width": "100%", "border": "0px #000000 solid", "vertical-align": "top"},
//                 "children":
//                     [
//                         {
//                     "tagName": "mj-text",
//                     "attributes": {
//                         "align": "left",
//                         "font-size": "11px",
//                         "padding": "15px 15px 15px 15px",
//                         "line-height": "1.5",
//                         "containerWidth": "600"
//                     },
//                     "uid": "WKg1mUMTpU",
//                     "content": "<p style=\"text-align: center;\"><span style=\"font-size: 24px;\">" +
//                         "WELCOME TO MY NEWSLETTER<\/span>" +
//                         "<\/p>\n<p style=\"text-align: center;\"><span style=\"font-size: 24px;\">My Practice is Health Sciences Centre Winnipeg<\/span><\/p>\n<p style=\"text-align: center;\">" +
//                         "<span style=\"font-size: 24px;\">Abdul khalid<\/span>" +
//                         "<\/p>\n<p style=\"text-align: center;\"><span style=\"font-size: 24px;\">my last name is<\/span><\/p>\n<p style=\"text-align: center;\"><span style=\"font-size: 24px;\">khalid<\/span><\/p>"
//                 }],
//                 "uid": "HdGZHqZAlS"
//             }],
//             "layout": "1",
//             "backgroundColor": null,
//             "backgroundImage": null,
//             "paddingTop": "0",
//             "paddingBottom": "0",
//             "paddingLeft": "0",
//             "paddingRight": "0",
//             "uid": "UfwZ799eK"
//         }, {
//             "tagName": "mj-section",
//             "attributes": {"padding": "9px 0px 9px 0px", "background-color": "#FFFFFF", "containerWidth": "600"},
//             "type": null,
//             "children": [{
//                 "tagName": "mj-column",
//                 "attributes": {"width": "100%", "vertical-align": "top"},
//                 "children": [{
//                     "tagName": "mj-text",
//                     "attributes": {
//                         "align": "left",
//                         "font-size": "11px",
//                         "padding": "15px 15px 2px 15px",
//                         "line-height": "1.8",
//                         "containerWidth": "600"
//                     },
//                     "uid": "1y-m5CG-un",
//                     "content": "<p><span style=\"font-size: 14px;\">I realized that many of our patients have exhausted their efforts in trying to find an affordable solution for their tooth pain and cosmetic problems. &nbsp;We usually see patients who are at the &ldquo;end of their ropes&rdquo; and take extreme pride in being able to solve their issues.&nbsp;<\/span><\/p>"
//                 }],
//                 "uid": "Ij10vPtjJV"
//             }],
//             "layout": "1",
//             "backgroundColor": null,
//             "backgroundImage": null,
//             "paddingTop": "0",
//             "paddingBottom": "0",
//             "paddingLeft": "0",
//             "paddingRight": "0",
//             "uid": "sR4vSqK-u"
//         }, {
//             "tagName": "mj-section",
//             "attributes": {"padding": "9px 0px 9px 0px", "background-color": "#FFFFFF", "containerWidth": "600"},
//             "type": null,
//             "children": [{
//                 "tagName": "mj-column",
//                 "attributes": {
//                     "width": "50%",
//                     "background-color": "#EFECEC",
//                     "padding": "1px 1px 1px 4px",
//                     "border": "1px #000000 solid",
//                     "vertical-align": "top"
//                 },
//                 "children": [{
//                     "tagName": "mj-text",
//                     "attributes": {
//                         "align": "left",
//                         "font-size": "11px",
//                         "padding": "15px 15px 15px 15px",
//                         "line-height": "1.5",
//                         "containerWidth": "300"
//                     },
//                     "uid": "VuZf5_W9h",
//                     "content": "<p style=\"text-align: center;\"><span style=\"font-size: 18px;\">----ONE WEEK ONLY ---<\/span><\/p>\n<p style=\"text-align: center;\"><span style=\"font-size: 36px;\">TAKE 10% OFF<\/span><\/p>\n<p style=\"text-align: center;\"><span style=\"font-size: 36px;\">YOUR VISIT<\/span><\/p>\n<p style=\"text-align: center;\"><span style=\"font-size: 24px;\">_________________<\/span><\/p>"
//                 }, {
//                     "tagName": "mj-button",
//                     "attributes": {
//                         "align": "center",
//                         "background-color": "#e85034",
//                         "color": "#fff",
//                         "border-radius": "24px",
//                         "font-size": "13px",
//                         "padding": "20px 20px 20px 20px",
//                         "inner-padding": "9px 26px 9px 26px",
//                         "href": "https:\/\/google.com",
//                         "font-family": "Ubuntu, Helvetica, Arial, sans-serif, Helvetica, Arial, sans-serif",
//                         "containerWidth": "300",
//                         "border": "0px solid #000"
//                     },
//                     "content": "<div>CALL TO SCHEDULE<\/div>",
//                     "uid": "nBk4O-zb7"
//                 }],
//                 "uid": "FCFs-A3LUp"
//             }, {
//                 "tagName": "mj-column",
//                 "attributes": {"width": "50%", "vertical-align": "top"},
//                 "children": [{
//                     "tagName": "mj-text",
//                     "attributes": {
//                         "align": "left",
//                         "font-size": "11px",
//                         "padding": "15px 15px 15px 15px",
//                         "line-height": "1.5",
//                         "containerWidth": "300"
//                     },
//                     "uid": "HjprzFMoU",
//                     "content": "<p><span style=\"font-size: 14px;\">We don&rsquo;t want to be &ldquo;another dentist&rdquo; or &ldquo;another office&rdquo; that you go to. We want to be the practice that treats your concerns with a high degree of success.&nbsp;<\/span><\/p>\n<p>&nbsp;<\/p>\n<p><span style=\"font-size: 14px;\">As a show of appreciation for your loyalty and confidence in our team, please take 10% off on your next dental procedure. Simply print this email and present it to us at your office visit.&nbsp;<\/span><\/p>"
//                 }],
//                 "uid": "mH4kbdcCo8"
//             }],
//             "layout": "1",
//             "backgroundColor": null,
//             "backgroundImage": null,
//             "paddingTop": "0",
//             "paddingBottom": "0",
//             "paddingLeft": "0",
//             "paddingRight": "0",
//             "uid": "bnqkm4SyJ"
//         }, {
//             "tagName": "mj-section",
//             "attributes": {"padding": "9px 0px 9px 0px", "background-color": "#FFFFFF", "containerWidth": "600"},
//             "type": null,
//             "children": [{
//                 "tagName": "mj-column",
//                 "attributes": {"width": "100%", "vertical-align": "top"},
//                 "children": [{
//                     "tagName": "mj-text",
//                     "attributes": {
//                         "align": "left",
//                         "font-size": "11px",
//                         "padding": "15px 15px 2px 15px",
//                         "line-height": "1.8",
//                         "containerWidth": "600"
//                     },
//                     "uid": "SDOlX6R_XD",
//                     "content": "<p><span style=\"font-size: 14px;\">&nbsp;Also, twice a month, I'll share email information on the latest dental procedures, special promotions and personalized content just for your needs. If you have any questions or need our help to improve your dental health, please don&rsquo;t hesitate to reach out to me personally or to my staff.<\/span><\/p>"
//                 }],
//                 "uid": "Ij10vPtjJV"
//             }],
//             "layout": "1",
//             "backgroundColor": null,
//             "backgroundImage": null,
//             "paddingTop": "0",
//             "paddingBottom": "0",
//             "paddingLeft": "0",
//             "paddingRight": "0",
//             "uid": "q0WCfjQgw"
//         }, {
//             "tagName": "mj-section",
//             "attributes": {
//                 "full-width": "false",
//                 "padding": "9px 0px 9px 0px",
//                 "background-color": "#FFFFFF",
//                 "containerWidth": "600"
//             },
//             "type": null,
//             "children": [{
//                 "tagName": "mj-column",
//                 "attributes": {"width": "100%", "vertical-align": "top"},
//                 "children": [{
//                     "tagName": "mj-social",
//                     "attributes": {
//                         "padding": "10px 10px 10px 10px",
//                         "text-mode": "false",
//                         "icon-size": "35px",
//                         "align": "center",
//                         "containerWidth": "600"
//                     },
//                     "children": [{
//                         "tagName": "mj-social-element",
//                         "attributes": {
//                             "src": "https:\/\/s3-eu-west-1.amazonaws.com\/ecomail-assets\/editor\/social-icos\/rounded\/facebook.png",
//                             "name": "Facebook",
//                             "href": "https:\/\/www.facebook.com\/PROFILE",
//                             "background-color": "transparent"
//                         }
//                     }, {
//                         "tagName": "mj-social-element",
//                         "attributes": {
//                             "src": "https:\/\/s3-eu-west-1.amazonaws.com\/ecomail-assets\/editor\/social-icos\/rounded\/twitter.png",
//                             "name": "Twitter",
//                             "href": "https:\/\/www.twitter.com\/PROFILE",
//                             "background-color": "transparent"
//                         }
//                     }, {
//                         "tagName": "mj-social-element",
//                         "attributes": {
//                             "src": "https:\/\/s3-eu-west-1.amazonaws.com\/ecomail-assets\/editor\/social-icos\/rounded\/linkedin.png",
//                             "name": "LinkedIn",
//                             "href": "https:\/\/www.linkedin.com\/PROFILE",
//                             "background-color": "transparent"
//                         }
//                     }],
//                     "uid": "IJXEJqk6b",
//                     "style": "rounded"
//                 }],
//                 "uid": "D2Zy88lpW9"
//             }],
//             "layout": "1",
//             "backgroundColor": null,
//             "backgroundImage": null,
//             "paddingTop": "0",
//             "paddingBottom": "0",
//             "paddingLeft": "0",
//             "paddingRight": "0",
//             "uid": "N1hqL6fZV"
//         }, {
//             "tagName": "mj-section",
//             "attributes": {
//                 "full-width": "false",
//                 "padding": "0px 0px 0px 0px",
//                 "background-color": "#FFFFFF",
//                 "containerWidth": "600"
//             },
//             "type": null,
//             "children": [{
//                 "tagName": "mj-column",
//                 "attributes": {"width": "100%", "vertical-align": "top"},
//                 "children": [{
//                     "tagName": "mj-text",
//                     "attributes": {
//                         "align": "center",
//                         "font-size": "11px",
//                         "padding": "0px 35px 10px 35px",
//                         "color": "#511423",
//                         "containerWidth": "600"
//                     },
//                     "uid": "CguxnAL6VB",
//                     "content": "<p><span style=\"font-size: 12px; color: #34495e;\">You Received this email as a registered subscriber of Dr Jones<\/span><\/p>"
//                 }],
//                 "uid": "S1W4Vg4gQ"
//             }],
//             "layout": "1",
//             "backgroundColor": null,
//             "backgroundImage": null,
//             "paddingTop": "0",
//             "paddingBottom": "0",
//             "paddingLeft": "0",
//             "paddingRight": "0",
//             "uid": "BvGk5Bmv2"
//         }, {
//             "tagName": "mj-section",
//             "attributes": {
//                 "full-width": "false",
//                 "padding": "0px 0px 0px 0px",
//                 "background-color": "#FFFFFF",
//                 "containerWidth": "600"
//             },
//             "type": null,
//             "children": [{
//                 "tagName": "mj-column",
//                 "attributes": {"width": "100%", "vertical-align": "top"},
//                 "children": [{
//                     "tagName": "mj-text",
//                     "attributes": {
//                         "align": "center",
//                         "font-size": "11px",
//                         "padding": "0px 35px 10px 35px",
//                         "color": "#511423",
//                         "containerWidth": "600"
//                     },
//                     "uid": "SkQnfvW52m",
//                     "content": "<p><span style=\"font-size: 12px;\"><a style=\"color: #511423;\" href=\"*|UNSUB|*\"><span style=\"color: #660000;\">Unsubscribe<\/span><\/a><\/span><\/p>"
//                 }],
//                 "uid": "S1W4Vg4gQ"
//             }],
//             "layout": "1",
//             "backgroundColor": null,
//             "backgroundImage": null,
//             "paddingTop": "0",
//             "paddingBottom": "0",
//             "paddingLeft": "0",
//             "paddingRight": "0",
//             "uid": "S1VhzDZqhX"
//         }, {
//             "tagName": "mj-section",
//             "attributes": {
//                 "full-width": "false",
//                 "padding": "9px 0px 9px 0px",
//                 "background-color": "#f1f1f1",
//                 "containerWidth": "600"
//             },
//             "type": null,
//             "children": [{
//                 "tagName": "mj-column",
//                 "attributes": {"width": "100%", "vertical-align": "top"},
//                 "children": [{
//                     "tagName": "mj-spacer",
//                     "attributes": {"height": "25px", "containerWidth": "600"},
//                     "uid": "z5P3tBvFx"
//                 }, {
//                     "tagName": "mj-text",
//                     "attributes": {
//                         "align": "left",
//                         "font-size": "11px",
//                         "padding": "15px 15px 15px 15px",
//                         "line-height": "1.5",
//                         "containerWidth": "600"
//                     },
//                     "uid": "bqU0v-6-6",
//                     "content": "<p style=\"text-align: center;\">Restrictions apply. Cannot be combined with other offers. Call for details. Expires in 30 days.<\/p>"
//                 }],
//                 "uid": "vW4OdJANKn"
//             }],
//             "layout": "1",
//             "backgroundColor": null,
//             "backgroundImage": null,
//             "paddingTop": "0",
//             "paddingBottom": "0",
//             "paddingLeft": "0",
//             "paddingRight": "0",
//             "uid": "54ZMc4LAy"
//         }, {
//             "tagName": "mj-section",
//             "attributes": {
//                 "full-width": "false",
//                 "padding": "9px 0px 9px 0px",
//                 "background-color": "#7b2e00",
//                 "containerWidth": "600"
//             },
//             "type": null,
//             "children": [{
//                 "tagName": "mj-column",
//                 "attributes": {"width": "100%", "vertical-align": "top"},
//                 "children": [{
//                     "tagName": "mj-text",
//                     "attributes": {
//                         "align": "left",
//                         "font-size": "11px",
//                         "padding": "15px 15px 15px 15px",
//                         "line-height": "1.8",
//                         "containerWidth": "600"
//                     },
//                     "uid": "WPlfRplrA",
//                     "content": "<p style=\"text-align: center;\"><span style=\"color: #ffffff;\">%%Dcompany%%<\/span><br \/><span style=\"color: #ffffff;\">Sherbrook Street, Winnipeg, MB | New York | NK | 333<\/span><br \/><span style=\"color: #ffffff;\">Ph. 85560503 | Visit Our Website | Email Us | Unsubscribe | %%Doctor_practice%%<\/span><\/p>"
//                 }],
//                 "uid": "t2tNzwKszS"
//             }],
//             "layout": "1",
//             "backgroundColor": null,
//             "backgroundImage": null,
//             "paddingTop": "0",
//             "paddingBottom": "0",
//             "paddingLeft": "0",
//             "paddingRight": "0",
//             "uid": "Yg2D7KYpJ"
//         }]
//     }], "style"
// :
//     {
//         "h1"
//     :
//         {
//             "font-family"
//         :
//             "PT Serif, Georgia, serif"
//         }
//     ,
//         "p"
//     :
//         {
//             "font-family"
//         :
//             "Cabin, sans-serif"
//         }
//     ,
//         "h2"
//     :
//         {
//             "font-family"
//         :
//             "PT Serif, Georgia, serif"
//         }
//     ,
//         "h3"
//     :
//         {
//             "font-family"
//         :
//             "Cabin, sans-serif"
//         }
//     }
// ,
//     "attributes"
// :
//     {
//         "mj-text"
//     :
//         {
//             "line-height"
//         :
//             "1.5", "font-family"
//         :
//             "Cabin, sans-serif"
//         }
//     ,
//         "mj-button"
//     :
//         {
//             "font-family"
//         :
//             "Cabin, sans-serif"
//         }
//     ,
//         "containerWidth"
//     :
//         "600"
//     }
// ,
//     "fonts"
// :
//     ["Cabin, sans-serif", "PT Serif, Georgia, serif"]
// }

// {"tagName":"mj-global-style","children":[{"tagName":"mj-body","attributes":{"background-color":"#f0f0f0","containerWidth":"600"},"children":[{"tagName":"mj-section","attributes":{"locked":"true","full-width":"full-width","containerWidth":"600","background-color":"#f0f0f0","padding":"3px 0px 3px 0px"},"children":[{"tagName":"mj-column","attributes":{"width":"66.66666666666666%","vertical-align":"middle","containerWidth":"400"},"children":[{"tagName":"mj-text","attributes":{"align":"left","font-size":"11px","locked":"true","editable":"true","padding-bottom":"0","padding-top":"0","containerWidth":"396","color":"#7a7a7a","font-family":"Cabin, sans-serif","padding":"0px 0px 0px 0px"},"content":"<p><span style=\"font-size: 11px;\">Preheader<\/span><\/p>","uid":"BJZTmSlqh7"}],"uid":"BJxa7Hl9hQ"},{"tagName":"mj-column","attributes":{"width":"33.33333333333333%","vertical-align":"middle","containerWidth":"134"},"children":[{"tagName":"mj-text","attributes":{"align":"right","font-size":"11px","locked":"true","editable":"false","padding-bottom":"0","padding-top":"0","containerWidth":"198","font-family":"Cabin, sans-serif","padding":"0px 0px 0px 0px","color":"#511423"},"content":"<p><span style=\"color: rgb(81, 20, 35);\"><a href=\"*|WEBVERSION|*\" style=\"color: #511423;\">Web version<\/a><\/span><\/p>","uid":"rk76mHgchm"}],"uid":"r1fTQBlc3m"}],"uid":"r1pQrlc2Q"},{"tagName":"mj-section","attributes":{"padding":"17px 0px 17px 0px","background-color":"#FFFFFF","containerWidth":"600"},"type":null,"children":[{"tagName":"mj-column","attributes":{"width":"60%","vertical-align":"top"},"children":[{"tagName":"mj-image","attributes":{"src":"https:\/\/storage.googleapis.com\/topolio14345\/plugin-assets\/6320\/14345\/doctor-logo%20copy.jpg","padding":"0px 0px 0px 0px","alt":null,"href":null,"containerWidth":"360","width":"252","widthPercent":"70"},"uid":"UytJ11UX7"}],"uid":"bX0oJ0hG_"},{"tagName":"mj-column","attributes":{"width":"40%","vertical-align":"top"},"children":[{"tagName":"mj-text","attributes":{"align":"right","font-size":"11px","padding":"15px 15px 15px 15px","line-height":"1.5","containerWidth":"240"},"uid":"78AJdrFGH","content":"<p><span style=\"font-size: 18px;\">CALL: 456-456-7894<\/span><\/p>"}],"uid":"xxwjfAITBM"}],"layout":"1","backgroundColor":null,"backgroundImage":null,"paddingTop":"0","paddingBottom":"0","paddingLeft":"0","paddingRight":"0","uid":"aLLCAZDcC"},{"tagName":"mj-section","attributes":{"padding":"9px 0px 9px 0px","background-color":"#FFF"},"type":null,"children":[{"tagName":"mj-column","attributes":{"width":"100%","vertical-align":"top"},"children":[{"tagName":"mj-image","attributes":{"src":"https:\/\/storage.googleapis.com\/topolio14345\/plugin-assets\/6320\/14345\/Screen%20Shot%202020-04-11%20at%2012.51.55%20PM.png","padding":"0px 0px 0px 0px","alt":null,"href":null,"containerWidth":"600","width":"0","widthPercent":"0"},"uid":"Xd7rcjMzC"}],"uid":"ADYi2qH0-"}],"layout":"1","backgroundColor":null,"backgroundImage":null,"paddingTop":"0","paddingBottom":"0","paddingLeft":"0","paddingRight":"0","uid":"UCc98oTXI"},{"tagName":"mj-section","attributes":{"padding":"9px 0px 9px 0px","background-color":"#FFF","containerWidth":"600"},"type":null,"children":[{"tagName":"mj-column","attributes":{"width":"100%","border":"0px #000000 solid","vertical-align":"top"},"children":[{"tagName":"mj-text","attributes":{"align":"left","font-size":"11px","padding":"15px 15px 15px 15px","line-height":"1.5","containerWidth":"600"},"uid":"WKg1mUMTpU","content":"<p style=\"text-align: center;\"><span style=\"font-size: 24px;\">WELCOME TO MY NEWSLETTER<\/span><\/p>"}],"uid":"HdGZHqZAlS"}],"layout":"1","backgroundColor":null,"backgroundImage":null,"paddingTop":"0","paddingBottom":"0","paddingLeft":"0","paddingRight":"0","uid":"UfwZ799eK"},{"tagName":"mj-section","attributes":{"padding":"9px 0px 9px 0px","background-color":"#FFFFFF","containerWidth":"600"},"type":null,"children":[{"tagName":"mj-column","attributes":{"width":"100%","vertical-align":"top"},"children":[{"tagName":"mj-text","attributes":{"align":"left","font-size":"11px","padding":"15px 15px 2px 15px","line-height":"1.8","containerWidth":"600"},"uid":"1y-m5CG-un","content":"<p>&nbsp;<\/p>\n<p><span style=\"font-size: 14px;\"><img class=\"template-token-tag\" src=\"%%Doctor_Logo%%\" data-token-name=\"Doctor_Logo\" \/><\/span><\/p>\n<p>&nbsp;<\/p>\n<p><span style=\"font-size: 14px;\"><img class=\"template-token-tag\" src=\"https:\/\/nichepractice.test\/storage\/app\/template-doc-photo.jpg\" data-token-name=\"Doctor_Photo\" \/><\/span><\/p>\n<p>&nbsp;<\/p>\n<p><span style=\"font-size: 14px;\">I realized that many of our patients have exhausted their efforts in trying to find an affordable solution for their tooth pain and cosmetic problems. &nbsp;We usually see patients who are at the &ldquo;end of their ropes&rdquo; and take extreme pride in being able to solve their issues.&nbsp;<\/span><\/p>"}],"uid":"Ij10vPtjJV"}],"layout":"1","backgroundColor":null,"backgroundImage":null,"paddingTop":"0","paddingBottom":"0","paddingLeft":"0","paddingRight":"0","uid":"sR4vSqK-u"},{"tagName":"mj-section","attributes":{"padding":"9px 0px 9px 0px","background-color":"#FFFFFF","containerWidth":"600"},"type":null,"children":[{"tagName":"mj-column","attributes":{"width":"50%","background-color":"#EFECEC","padding":"1px 1px 1px 4px","border":"1px #000000 solid","vertical-align":"top"},"children":[{"tagName":"mj-text","attributes":{"align":"left","font-size":"11px","padding":"15px 15px 15px 15px","line-height":"1.5","containerWidth":"300"},"uid":"VuZf5_W9h","content":"<p style=\"text-align: center;\"><span style=\"font-size: 18px;\">----ONE WEEK ONLY ---<\/span><\/p>\n<p style=\"text-align: center;\"><span style=\"font-size: 36px;\">TAKE 10% OFF<\/span><\/p>\n<p style=\"text-align: center;\"><span style=\"font-size: 36px;\">YOUR VISIT<\/span><\/p>\n<p style=\"text-align: center;\"><span style=\"font-size: 24px;\">_________________<\/span><\/p>"},{"tagName":"mj-button","attributes":{"align":"center","background-color":"#e85034","color":"#fff","border-radius":"24px","font-size":"13px","padding":"20px 20px 20px 20px","inner-padding":"9px 26px 9px 26px","href":"https:\/\/google.com","font-family":"Ubuntu, Helvetica, Arial, sans-serif, Helvetica, Arial, sans-serif","containerWidth":"300","border":"0px solid #000"},"content":"<div>CALL TO SCHEDULE<\/div>","uid":"nBk4O-zb7"}],"uid":"kiMwwwok4l"},{"tagName":"mj-column","attributes":{"width":"50%","vertical-align":"top"},"children":[{"tagName":"mj-text","attributes":{"align":"left","font-size":"11px","padding":"15px 15px 15px 15px","line-height":"1.5","containerWidth":"300"},"uid":"HjprzFMoU","content":"<p><span style=\"font-size: 14px;\">We don&rsquo;t want to be &ldquo;another dentist&rdquo; or &ldquo;another office&rdquo; that you go to. We want to be the practice that treats your concerns with a high degree of success.&nbsp;<\/span><\/p>\n<p>&nbsp;<\/p>\n<p><span style=\"font-size: 14px;\">As a show of appreciation for your loyalty and confidence in our team, please take 10% off on your next dental procedure. Simply print this email and present it to us at your office visit.&nbsp;<\/span><\/p>"}],"uid":"HTjA3FAAiB"}],"layout":"1","backgroundColor":null,"backgroundImage":null,"paddingTop":"0","paddingBottom":"0","paddingLeft":"0","paddingRight":"0","uid":"bnqkm4SyJ"},{"tagName":"mj-section","attributes":{"padding":"9px 0px 9px 0px","background-color":"#FFFFFF","containerWidth":"600"},"type":null,"children":[{"tagName":"mj-column","attributes":{"width":"100%","vertical-align":"top"},"children":[{"tagName":"mj-text","attributes":{"align":"left","font-size":"11px","padding":"15px 15px 2px 15px","line-height":"1.8","containerWidth":"600"},"uid":"SDOlX6R_XD","content":"<p><span style=\"font-size: 14px;\">&nbsp;Also, twice a month, I'll share email information on the latest dental procedures, special promotions and personalized content just for your needs. If you have any questions or need our help to improve your dental health, please don&rsquo;t hesitate to reach out to me personally or to my staff.<\/span><\/p>"}],"uid":"Ij10vPtjJV"}],"layout":"1","backgroundColor":null,"backgroundImage":null,"paddingTop":"0","paddingBottom":"0","paddingLeft":"0","paddingRight":"0","uid":"q0WCfjQgw"},{"tagName":"mj-section","attributes":{"full-width":"false","padding":"9px 0px 9px 0px","background-color":"#FFFFFF","containerWidth":"600"},"type":null,"children":[{"tagName":"mj-column","attributes":{"width":"100%","vertical-align":"top"},"children":[{"tagName":"mj-social","attributes":{"padding":"10px 10px 10px 10px","text-mode":"false","icon-size":"35px","align":"center","containerWidth":"600"},"children":[{"tagName":"mj-social-element","attributes":{"src":"https:\/\/s3-eu-west-1.amazonaws.com\/ecomail-assets\/editor\/social-icos\/rounded\/facebook.png","name":"Facebook","href":"https:\/\/www.facebook.com\/PROFILE","background-color":"transparent"}},{"tagName":"mj-social-element","attributes":{"src":"https:\/\/s3-eu-west-1.amazonaws.com\/ecomail-assets\/editor\/social-icos\/rounded\/twitter.png","name":"Twitter","href":"https:\/\/www.twitter.com\/PROFILE","background-color":"transparent"}},{"tagName":"mj-social-element","attributes":{"src":"https:\/\/s3-eu-west-1.amazonaws.com\/ecomail-assets\/editor\/social-icos\/rounded\/linkedin.png","name":"LinkedIn","href":"https:\/\/www.linkedin.com\/PROFILE","background-color":"transparent"}}],"uid":"IJXEJqk6b","style":"rounded"}],"uid":"D2Zy88lpW9"}],"layout":"1","backgroundColor":null,"backgroundImage":null,"paddingTop":"0","paddingBottom":"0","paddingLeft":"0","paddingRight":"0","uid":"N1hqL6fZV"},{"tagName":"mj-section","attributes":{"full-width":"false","padding":"0px 0px 0px 0px","background-color":"#FFFFFF","containerWidth":"600"},"type":null,"children":[{"tagName":"mj-column","attributes":{"width":"100%","vertical-align":"top"},"children":[{"tagName":"mj-text","attributes":{"align":"center","font-size":"11px","padding":"0px 35px 10px 35px","color":"#511423","containerWidth":"600"},"uid":"CguxnAL6VB","content":"<p><span style=\"font-size: 12px; color: #34495e;\">You Received this email as a registered subscriber of Dr Jones<\/span><\/p>"}],"uid":"S1W4Vg4gQ"}],"layout":"1","backgroundColor":null,"backgroundImage":null,"paddingTop":"0","paddingBottom":"0","paddingLeft":"0","paddingRight":"0","uid":"BvGk5Bmv2"},{"tagName":"mj-section","attributes":{"full-width":"false","padding":"0px 0px 0px 0px","background-color":"#FFFFFF","containerWidth":"600"},"type":null,"children":[{"tagName":"mj-column","attributes":{"width":"100%","vertical-align":"top"},"children":[{"tagName":"mj-text","attributes":{"align":"center","font-size":"11px","padding":"0px 35px 10px 35px","color":"#511423","containerWidth":"600"},"uid":"SkQnfvW52m","content":"<p><span style=\"font-size: 12px;\"><a style=\"color: #511423;\" href=\"*|UNSUB|*\"><span style=\"color: #660000;\">Unsubscribe<\/span><\/a><\/span><\/p>"}],"uid":"S1W4Vg4gQ"}],"layout":"1","backgroundColor":null,"backgroundImage":null,"paddingTop":"0","paddingBottom":"0","paddingLeft":"0","paddingRight":"0","uid":"S1VhzDZqhX"},{"tagName":"mj-section","attributes":{"full-width":"false","padding":"9px 0px 9px 0px","background-color":"#f1f1f1","containerWidth":"600"},"type":null,"children":[{"tagName":"mj-column","attributes":{"width":"100%","vertical-align":"top"},"children":[{"tagName":"mj-spacer","attributes":{"height":"25px","containerWidth":"600"},"uid":"z5P3tBvFx"},{"tagName":"mj-text","attributes":{"align":"left","font-size":"11px","padding":"15px 15px 15px 15px","line-height":"1.5","containerWidth":"600"},"uid":"bqU0v-6-6","content":"<p style=\"text-align: center;\">Restrictions apply. Cannot be combined with other offers. Call for details. Expires in 30 days.<\/p>"}],"uid":"vW4OdJANKn"}],"layout":"1","backgroundColor":null,"backgroundImage":null,"paddingTop":"0","paddingBottom":"0","paddingLeft":"0","paddingRight":"0","uid":"54ZMc4LAy"},{"tagName":"mj-section","attributes":{"full-width":"false","padding":"9px 0px 9px 0px","background-color":"#7b2e00","containerWidth":"600"},"type":null,"children":[{"tagName":"mj-column","attributes":{"width":"100%","vertical-align":"top"},"children":[{"tagName":"mj-text","attributes":{"align":"left","font-size":"11px","padding":"15px 15px 15px 15px","line-height":"1.8","containerWidth":"600"},"uid":"WPlfRplrA","content":"<p style=\"text-align: center;\"><span style=\"color: #ffffff;\">%%Dcompany%%<\/span><br \/><span style=\"color: #ffffff;\">%%Doctor_Address%% | %%Doctor_City%% | %%Doctor_State%% | %%Doctor_Zip%%<\/span><br \/><span style=\"color: #ffffff;\">Ph. %%Doctor_Phone%% | Visit Our Website | Email Us | Unsubscribe<\/span><\/p>"}],"uid":"t2tNzwKszS"}],"layout":"1","backgroundColor":null,"backgroundImage":null,"paddingTop":"0","paddingBottom":"0","paddingLeft":"0","paddingRight":"0","uid":"Yg2D7KYpJ"}]}],"style":{"h1":{"font-family":"PT Serif, Georgia, serif"},"p":{"font-family":"Cabin, sans-serif"},"h2":{"font-family":"PT Serif, Georgia, serif"},"h3":{"font-family":"Cabin, sans-serif"}},"attributes":{"mj-text":{"line-height":"1.5","font-family":"Cabin, sans-serif"},"mj-button":{"font-family":"Cabin, sans-serif"},"containerWidth":"600"},"fonts":["Cabin, sans-serif","PT Serif, Georgia, serif"]}
