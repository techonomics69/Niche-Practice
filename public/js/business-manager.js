
processStarted = false;
registerElement('business-profile', 'businessErrorFound');
registerElement('validate-social-profile', 'socialErrorFound');
registerElement('validate-user-password', 'passwordErrorFound');
$(document.body).on('submit', 'form.business-profile, form.validate-user-password, form.validate-social-profile', function(e)
{
    // console.log("clicked B");
    // console.log(e);
    // return false;
    // console.log($(this).attr("class"));

    var errorLocalStatus = errorFound;

    if($(this).hasClass('validate-social-profile') === true)
    {
        errorLocalStatus = socialErrorFound;
    }
    else if($(this).hasClass('business-profile') === true)
    {
        errorLocalStatus = businessErrorFound;
    }
    else if($(this).hasClass('validate-user-password') === true)
    {
        errorLocalStatus = passwordErrorFound;
    }


    if(!errorLocalStatus)
    {
        var that = $(this);
        var targetButton = $(".btn-save", $(this));
        var currentAction = $(".btn-save", $(this)).attr("data-send");

        var data = {};
        data['send'] = currentAction;

        $('input, textarea, select', $(this)).each(function() {
            var ID = $(this).attr('id'); // get id of current required field.
            var currentFieldvalue = $(this).val(); // get value of current field.

            // console.log("id is " + ID);
            if(ID && ID !== '')
            {
                data[ID] = currentFieldvalue;
            }
        });

        // console.log("data");
        // console.log(data);
        // console.log("len " + data.length);

        var baseUrl = $("#hfBaseUrl").val();

        var $this = showLoaderButton(targetButton, "Saving");

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            type: "POST",
            data: data,
            url: baseUrl + "/done-me"
        }).done(function (result) {
            // parse data into json
            var json = $.parseJSON(result);

            // get data
            var statusCode = json.status_code;
            var statusMessage = json.status_message;
            var data = json.data;

            if( statusCode == 200 ) {
                // console.log("class checking");
                // console.log(that.hasClass('business-profile'));
                if(that.hasClass('business-profile') === true)
                {
                    if(isEmptyValNormal($("#currentPage").val()) == false && $("#currentPage").val() == 'onboarding')
                    {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('input[name="_token"]').val()
                            },
                            type: "POST",
                            url: baseUrl + "/done-me",
                            data: {
                                send: 'status-generate',
                                status: 4
                            }
                        }).done(function (result) {
                            // parse data into json
                            location.reload();
                        });
                        return false;
                    }
                    else
                    {
                        resetLoaderButton($this);
                        if(data[0].isWebsiteChanged == true)
                        {
                            // now
                            // console.log(data[0].isWebsiteChanged);

                            var website = data[0].websiteChecker;

                            processStarted = true;

                            var source = $("#source").val();
                            $(".web-audit").html('<iframe src="' + source + '"><p>Your browser does not support iframes.</p></iframe>');
                            // console.log("source ");
                            // console.log(source);
                            setTimeout(function () {
                                source = source + '/domain/'+website;
                                // console.log("inner source ");
                                // console.log(source);
                                $(".web-audit").append('<iframe src="' + source + '"><p>Your browser does not support iframes.</p></iframe>');
                            }, 1000);

                            setTimeout(function () {
                                webProcess();
                            }, 2000);

                            var mainModel = $('#main-modal');
                            $(".modal-body, .modal-footer, .validate-me", mainModel).remove();

                            $(mainModel).removeClass('welcome-process');
                            $(mainModel).addClass('web-process-loading');

                            var html = '';
                            html +='<div class="modal-body"><p class="alert alert-success text-center" style="font-size: 18px">'+statusMessage+'</p><div class="loading-web-bar" style="display: none;">\n' +
                                '                                                    <span class="loading-text" style="font-size: 15px;font-weight: 700;display: block;">' +
                                // 'Website Report is loading ' +
                                'New SEO Report is Loading' +
                                '<span class="web-timer"></span>\n' +
                                '    </span>\n' +
                                '                                                    <img src="'+baseUrl+'/public/images/Loading-bar.gif">\n' +
                                '                                                </div></div>'
                            mainModel.modal('show');
                            $(".modal-header", mainModel).after(html);

                            $(".loading-web-bar").show();
                            // swal({
                            //     title: "Successful!",
                            //     text: statusMessage,
                            //     type: "success"
                            // }, function () {
                            //     showPreloader();
                            //     $(".loading-web-bar").show();
                            // });

                            return false;
                        }
                    }
                }

                resetLoaderButton($this);

                swal({
                    title: "Successful!",
                    text: statusMessage,
                    type: "success"
                }, function () {});
            }
            else
            {
                resetLoaderButton($this);
                swal("", statusMessage, "error");
            }
        });

    }
});

counter = 1;
checkFormStatus('validate-user-profile');

// checkFormStatus('validate-pass');

function checkFormStatus(formTarget)
{
    var orig = [];

    var businessForm = $('.'+formTarget +' input:text');


    /**
     * Saving form original data into array
     *  when page load
     */
    businessForm.each(function () {
        var name = $(this).attr('name');
        var type = $(this).attr('type');
        var ID = $(this).attr('id');
        var value = $(this).val();
        value = value.replace(/\s+/g, '');

        var tmp = {
            'type': type,
            'name': name,
            'value': value
        };

        //    console.log("tmp " + ID);
        orig[ID] = tmp;
    });
    // console.log("original");
    // console.log(orig);

    businessForm.bind('change keyup', function () {
        // console.log("change tracked");
        var disable = true;
        businessForm.each(function () {
            var name = $(this).attr('name');
            var type = $(this).attr('type');
            var id = $(this).attr('id');
            var value = $(this).val();
            value = value.replace(/\s+/g, '');

            // if equal this is "true" else "false"
            disable = (orig[id].value == value);

            // if this is false
            if (!disable) {
                return false; // break out of loop
            }
        });

        // if this is true.
        if (disable) {
            // then no changing at this form.
            // $('#isUpdatedDetail').val(0);
            $('.'+formTarget +' .btn-save').attr('data-form-status', 0);
            // console.log("not changed");
        }
        else {
            // $('#isUpdatedDetail').val(1);
            // yes I'm updated.
            $('.'+formTarget +' .btn-save').attr('data-form-status', 1);
            // console.log("changed");
        }
    });
}

registerElement('validate-user-profile', 'userErrorFound');

$(document.body).on('submit', 'form.validate-user-profile', function(e)
{
    // console.log("clicked B");
    // return false;

    // console.log("error status " + window.userErrorFound);
    // console.log("error status " + userErrorFound);
    var alert = $(".alert");

    if(!userErrorFound)
    {
        // console.log("inside user");
        var formStatus = $("form.validate-user-profile .btn-save").attr("data-form-status");
        alert.hide();
        alert.removeClass('error');

        // console.log("form status " + formStatus);

        if(formStatus == 1)
        {
            var baseUrl = $("#hfBaseUrl").val();

            var $this = showLoaderButton("form.validate-user-profile .btn-save", "Saving");

            var firstName = $("#first_name").val();
            var lastName = $("#last_name").val();
            var name = $(".username-title");

            // ready for sae.
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                type: "POST",
                url: baseUrl + "/done-me",
                data: {
                    send: 'user-profile',
                    first_name: firstName,
                    last_name: lastName,
                    phone: $("#phone-number").val()
                }
            }).done(function (result) {
                // parse data into json
                var json = $.parseJSON(result);

                // get data
                var statusCode = json.status_code;
                var statusMessage = json.status_message;
                var data = json.data;

                resetLoaderButton($this);

                if( statusCode == 200 ) {
                    $("form.validate-user-profile .btn-save").attr("data-form-status", '');
                    var fullName = firstName + ' ' + lastName;
                    if(fullName.length > 13)
                    {
                        name.html(firstName);
                    }
                    else
                    {
                        name.html(fullName);
                    }

                    $(".u-text").html(fullName);

                    swal({
                        title: "Successful!",
                        text: statusMessage,
                        type: "success"
                    }, function () {});
                }
                else
                {
                    swal("", statusMessage, "error");
                }
            });
        }
        else
        {
            alert.show();
            alert.addClass('error');
            alert.html('No change detected in fields. Please update any field to save.');
        }
    }
    else
    {
        alert.hide();
        alert.removeClass('error');
    }
});

function webProcess() {
    // console.log("processStarted");
    // console.log(processStarted);

    // console.log("counter");
    // console.log(counter);


    var time = 10000; // 10 seconds
    var source;

    // console.log("process ahead");

    var isIframeLoaded = $("iframe").length;
    var userAgent =  window.navigator.userAgent;

    // $(".web-audit").show();

    if(counter === 1 && processStarted === false && $("#source").length > 0)
    {
        // console.log("again star");
        source = $("#source").val();
        // console.log("source " + source);
        $(".web-audit").append('<iframe src="'+source+'"><p>Your browser does not support iframes.</p></iframe>');
    }
    else if(counter === 2)
    {
        time = 40000; // 40 seconds
    }
    else
    {
        time = 10000;
    }

    setTimeout(function () {
        var siteUrl = $('#hfBaseUrl').val();

        // console.log("web counter " + counter);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            type: "POST",
            url: siteUrl + "/done-me",
            data: {
                send: 'web-process',
                isIframeLoaded: isIframeLoaded,
                userAgent: userAgent,
                webProcessChecking: true,
                webSource: 'business-update'
            }
        }).done(function (result) {
            // parse data into json
            var json = $.parseJSON(result);


            // get data
            var statusCode = json.status_code;
            var statusMessage = json.status_message;
            var data = json.data;
            var errors = json.errors;

            // console.log("status code " + statusCode);
            // console.log("statusMessage " + statusMessage);
            var mainModel = $('#main-modal');

            if (statusCode == 200) {
                $(".loading-web-bar").hide();
                mainModel.modal('hide');

                hidePreloader();

                swal({
                    title: "Successful!",
                    text: "",
                    type: "success"
                }, function () {});
            }
            else
            {
                if(counter < 4)
                {
                    if(statusCode == 70)
                    {
                        hidePreloader();
                        $(".loading-web-bar").hide();
                        mainModel.modal('hide');

                        swal({
                            title: "Successful!",
                            // text: "Your process in queue. once data ready it will show in seo-audit page.",
                            text: "",
                            type: "success"
                        }, function () {});
                    }
                    else
                    {
                        counter++;
                        webProcess();
                    }
                }
                else if(counter >= 4)
                {
                    hidePreloader();
                    $(".loading-web-bar").hide();
                    mainModel.modal('hide');

                    swal({
                        title: "Successful!",
                        // text: "Website loading process completed.",
                        text: "",
                        type: "success"
                    }, function () {});
                }
                else
                {
                    hidePreloader();
                    $(".loading-web-bar").hide();
                    mainModel.modal('hide');

                    swal({
                        title: "Error!",
                        text: "Unable to load Website report. Please try again ",
                        type: "error"
                    }, function () {});
                }
            }
        });
    },time);
}

