$(document.body).on('click', '.preview-template' ,function() {
    // console.log("connect-app");
    // $('.remove-business-body, .social-module, .local-module, .select-business-body').hide();

    // $(".")
    var mainModel = $('#template-modal');


    if(isEmptyValNormal(window.CurrentSourceTarget) == false && window.CurrentSourceTarget == 'email-templates')
    {
        showPreloader();
    }
    else
    {
        mainModel.modal('show');
    }
    initiateTopol($(this).attr("data-campaign-id"));
});

TOPOL_OPTIONS = {
    id: "#app",
    authorize: {
        apiKey: "Gp1QsJyfAZwRlizPdy1pZ0pnASId49umK6Y5ptc99OoycrumsNHmTRPwEXTw",
        userId: 1,
    },
    language: "en",
    light: true,
    // topBarOptions: [
    //     "undoRedo",
    //     "changePreview",
    //     "previewSize",
    //     "previewTestMail"
    // ], // Displays given elements in top bar
    removeTopBar: true,
    disableAlerts: true,
    // changePreview: true,

    // templateId: 1,
    title: "My template builder",
    callbacks: {
        onSaveAndClose: function(json, html) {
            // console.log("onSaveAndClose");
            // console.log(json);
            // console.log(userId + ' > ' + templateId);
            saveTemplate(json, templateId);
            // HTML of the email
            // console.log(html);
            // JSON object of the email
        },
        onSave: function(json, html) {
            // console.log("onSave");
            saveTemplate(json, templateId);
            // HTML of the email
            // console.log(html);
            // JSON object of the email
            // console.log(json);
        },
    }
};
TopolPlugin.init(TOPOL_OPTIONS);

loadFirstTime = 1;
function initiateTopol(campaignId) {

    // TopolPlugin.destroy();
    if(loadFirstTime == 1)
    {
        getTemplate(campaignId);
        // getTemplate(4);
        // $('#app iframe').on("load", function() {
        //     // console.log("iframe loaded > " + userId);
        //     getTemplate(4);
        // });
    } else {
        getTemplate(campaignId);
    }

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
                target: (isEmptyValNormal(window.CurrentSourceTarget) == false) ? window.CurrentSourceTarget : '',
                id: templateId

                // user_id: userId,
                // response: json
            }
        }).done(function (result) {
            // console.log("res");
            // console.log(result);

            var json = $.parseJSON(result);
            var data = json.data;
            // console.log(data);

            if(data.id && data.id !== '') {
                var title = data.title;

                $("#subject").val(title);
                $("#from").val(data.from);
                $("#reply-email").val(data.reply_email);
                // $("#from").val(title);
            }

            var response = data.response;
            var screenshot = data.screenshot;

            $(".steps-nav").show();
            $(".loading-bar").hide();
            $(".action-center").show();

            if(isEmptyValNormal(window.CurrentSourceTarget) == false && window.CurrentSourceTarget == 'email-templates')
            {
                hidePreloader();
                if(isEmptyValNormal(screenshot) == false)
                {
                    var mainModel = $('#template-modal');
                    mainModel.modal('show');

                    var screenshotUrl = siteUrl+'/storage/app/'+screenshot;

                    $(".modal-body", mainModel).html('<img src="'+screenshotUrl+'" />');
                }
                else
                {
                    swal({
                        title: "Error!",
                        // text: "No preview found. Please take screenshot of template from admin panel.",
                        text: "No preview found.",
                        type: 'error'
                    }, function () {
                    });
                }
            }else
            {
                TopolPlugin.load(response);
            }

            setTimeout(function () {
                console.log("inside");
                if(loadFirstTime == 1) {
                    loadFirstTime = 2;
                    console.log("innser ready")
                    TopolPlugin.togglePreview();
                }
            },2000);
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
    }
}
