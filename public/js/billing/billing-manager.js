$(document.body).on('click', '.action-btn', function(e)
{
    var action = $(this).attr("data-action");
    var baseUrl = $('#hfBaseUrl').val();

    var mainModel = $('#main-modal');
    $(".modal-body, .modal-footer, .validate-me", mainModel).remove();
    $(mainModel).removeClass('welcome-process');
    $(mainModel).addClass('modal-user-quit');

    var html = '';
    if(action === 'cancel_account')
    {
        html += '<div class="modal-body">\n' +
            '                                <h3 class="modal-title p-b-10">Are you sure you want to leave?</h3>\n' +
            '                                <div class="row">\n' +
            '                                    <div class="col-md-6">\n' +
            '                                        <div class="user-quit-content">\n' +
            '                                            <img src="'+baseUrl+'/public/images/cancel-account-help.png">\n' +
            '                                            <div class="p-20">\n' +
            '                                                <label class="p-b-10">Struggling with something?</label>\n' +
            '                                                <p>Our friendly Customer Support <br> team here to help.</p>\n' +
            '                                            </div>\n' +
            '                                        <a href="./contact" class="btn btn-user-quit">Contact us for help</a>\n' +
            '                                        </div>\n' +
            '                                    </div>\n' +
            '\n' +
            '                                <div class="col-md-6">\n' +
            '                                    <div class="user-quit-content">\n' +
            '                                        <img src="'+baseUrl+'/public/images/cancel-account-quit.png">\n' +
            '                                        <div class="p-20">\n' +
            '                                        <label class="p-b-10">If you really must go</label>\n' +
            '                                        <p>We thank you being an <br> amazing customer.</p>\n' +
            '                                        </div>\n' +
            '                                        <a href="javascript:void(0);" class="btn btn-user-quit action-btn" data-action="cancel_account_confirmed">Say goodbye</a>\n' +
            '                                    </div>\n' +
            '                                </div>\n' +
            '\n' +
            '                                </div>\n' +
            '                            </div>';

        mainModel.modal('show');
        $(".modal-header").after(html);
    }
    else if(action === 'cancel_account_confirmed')
    {
        html += '<div class="modal-body">\n' +
            '                                <h3 class="modal-title p-b-10">Before you go, can you <br> tell us why you\'re leaving?</h3>\n' +
            '                             <p>This helps us continue to make FreshBooks even better</p>\n' +
            '\n' +
            '                                <div class="leaving-form">\n' +
            '                                    <div class="btn-group">\n' +
            '                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">\n' +
            '                                            Why are you leaving? <span class="caret"></span>\n' +
            '                                        </button>\n' +
            '<span class="help-block title-error hide-me left"><small>Required. Please choose an option.</small></span>' +
            '                                        <ul class="dropdown-menu">\n' +
            '                                            <li><a href="#">Using a different service</a></li>\n' +
            '                                            <li><a href="#">It\'s missing something that i must have</a></li>\n' +
            '                                            <li><a href="#">Too expensive</a></li>\n' +
            '                                            <li><a href="#">Taking a break, I\'ll be back</a></li>\n' +
            '                                            <li><a href="#">Other</a></li>\n' +
            '                                        </ul>\n' +
            '                                    </div>\n' +
            '                                    <div class="form-group p-t-15">\n' +
            '                                        <textarea class="form-control" rows="5" id="" placeholder="Tell us how we can do better"></textarea>\n<!--<span class="help-block note-error hide-me left"><small>Required. Please tell us reason.</small></span>-->' +
            '                                    </div>\n' +
            '                                </div>\n' +
            '                                <button class="btn btn-user-quit btn-cancel-account">Cancel my Account</button>\n' +
            '                            </div>';

        mainModel.modal('show');
        $(".modal-header").after(html);
    }
});

$(document.body).on('click', '.modal-user-quit .dropdown-toggle', function(e)
{
    $(".title-error").removeClass('error');
    $(".title-error").addClass('hide-me');
});

$(document.body).on('click', '.modal-user-quit .dropdown-menu a', function(e)
{
    e.preventDefault();

    var chosenOption = $(this).html().trim();

    var leavingSelector = $(".leaving-form .dropdown-toggle");

    leavingSelector.attr("data-chosen-value", chosenOption);
    leavingSelector.html(chosenOption + ' ' + '<span class="caret"></span>');
    // $(".leaving-form")
});

$(document.body).on('click', '.btn-cancel-account', function(e)
{
    // console.log("quit button");
    var leavingNote = $(".leaving-form textarea.form-control").val().trim();

    var leavingSelector = $(".leaving-form .dropdown-toggle");

    var leavingTitle = leavingSelector.attr("data-chosen-value");

    if(!leavingTitle)
    {
        $(".title-error").addClass('error');
        $(".title-error").removeClass('hide-me');
    }
    else
    {
        $(".title-error").removeClass('error');
        $(".title-error").addClass('hide-me');
    }

    // if(!leavingNote)
    // {
    //     $(".note-error").addClass('error');
    //     $(".note-error").removeClass('hide-me');
    // }
    // else
    // {
    //     $(".note-error").removeClass('error');
    //     $(".note-error").addClass('hide-me');
    // }

    if(leavingTitle /*&& leavingNote*/)
    {
        var siteUrl = $('#hfBaseUrl').val();

        showPreloader();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            type: "POST",
            url: siteUrl + "/done-me",
            data: {
                send: 'deactivate-account',
                leavingTitle: leavingTitle,
                leavingNote: leavingNote
            }
        }).done(function (result) {
            // parse data into json
            var json = $.parseJSON(result);

            // get data
            var statusCode = json.status_code;
            var statusMessage = json.status_message;
            var data = json.data;
            var errors = json.errors;

            if (statusCode == 200) {
                // should be 5
                // updateStatus(5);
                // $("#status").val();
                // startBusinessProcess();
                showPreloader();
                location.href = siteUrl+'/account-delete';
            }
            else
            {
                hidePreloader();
            }

            // console.log("status code " + statusCode);
            // console.log("statusMessage " + statusMessage);
        });
    }
});
