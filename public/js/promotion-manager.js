$(function () {
    var siteUrl = $("#hfBaseUrl").val();

    $("body").addClass('hide-sidebar');
    $(".sidebar").hide();

    saveEditorProcess = false;

    window.templateImage = '';

    // var pixie = new Pixie({
    //     // state: state,
    //     // openImageDialog: true,
    //     baseUrl: siteUrl+'/public/plugins/pixie/',
    //     onLoad: function() {
    //         console.log('Pixie is ready');
    //     }
    // });

    var pixie = new Pixie({
        // image: state,
        state: state,
        // openImageDialog: {
        //     show: true,
        // },
        // ui: {
        openImageDialog: false,
        visible: true,
        // history: true,
        // allowZoom: false,
        // compact: false, // filter to left
        // showExportPanel: true, it will requrie some image before export
        // toolbar: {
        // hide: false,
        // hideOpenButton: false,
        // hideSaveButton: false,
        // openButtonAction: true,
        // },
        // },
        // watermarkText: 'Pixie Demo',
        // image: 'http://url-to-image.png',
        baseUrl: siteUrl + '/public/plugins/pixie/',
        onLoad: function () {

            // window.postMessage('pixieLoaded', '*');

            $(".open-button").before('<a href="' + siteUrl + '/promotions" class="btn btn-default back-button" style="padding-left: 30px;padding-right: 30px; margin-right: 16px;">Back</a>');

            $(".export-button").after('<button class="mat-button publish-button" mat-button=""><span class="mat-button-wrapper"><mat-icon class="mat-icon mat-icon-no-color" role="img" svgicon="file-download" aria-hidden="true" style="\n' +
                '    margin-right: 5px;\n' +
                '">' +
                '<img style="width: 28px;margin-top: 0px;padding-right: 3px;" src="' + siteUrl + '/public/images/icons/publish_icon.png" />' +
                '</mat-icon>' +
                '<span class="name" trans="">Publish</span></span><div class="mat-button-ripple mat-ripple" matripple=""></div><div class="mat-button-focus-overlay"></div></button>');

            // var state = pixie.getState();

            // console.log("siteUrl ");
            // console.log(siteUrl);
            //
            // // var state ;
            // console.log("state post");
            // console.log(state);


            // pixie.loadState(state).then(function() {
            //     //state has been loaded
            // });

            // console.log(state);
            // pixie.http().post('http://nichepractice.test/done-me', {state: state});

            // pixie.http().get(state).then(function() {
            //     console.log("state has been loaded ");
            // });

            // pixie.loadStateFromUrl('https://your-site.com/state.json').then(function() {
            //     //state has been loaded
            // });
        },
        onSave: function (data, name) {

            saveEditorProcess = true;
            // console.log("save called");
            // console.log(data);

            // console.log("saveEditorProcess");
            // console.log(saveEditorProcess);

            window.templateImage = data;
            // console.log(window.templateImage)
            // console.log("name");
            // console.log(name);

            // pixie.http().post(
            //     siteUrl + "/done-me",
            //     {
            //         response: state,
            //         send: 'save-promotion-template',
            //     }
            //     ).subscribe(function(response) {
            //     console.log(response);
            //     });

            var state = pixie.getState();
            // console.log(state);
            // console.log("templateId");
            // console.log(templateId);
            // console.log("state");
            // console.log(state);
            saveTemplate(state, "", templateId);

        }
    });
});

function saveTemplate(json, html, templateId) {
    // console.log('saveTemplate');
    // console.log('json');
    // console.log(json);
    // console.log('html');
    // console.log(html);
    // console.log('templateId');
    // console.log(templateId);
    var flag = $("#flag").val();
    var saveImage = $('#saveImage').val();
    // console.log("save called");
    // return true;
    var siteUrl = $('#hfBaseUrl').val();
    // Implement your own close callback
    // Data variable contains the response data of the save request

    var actionStatus = '';
    saveTemplateCall = 'progress';
    // console.log("before ajax " + saveTemplateCall);

    // console.log("window.actionStatus " + actionStatus);

    var dataItems = [];
    var data;
    var replyEmail;
    if (actionStatus === 'sendnow') {
        replyEmail = $("#reply-email").val();

        if (replyEmail === '') {
            // replyEmail = 'noreply@nichepractice.com';
        }

        data = {
            send: 'save-template',
            subject: $("#subject").val(),
            from: $("#from").val(),
            reply_email: replyEmail,
            status: 'published',
            id: templateId,
            response: json,
            template_preview: html
        };
    } else if (actionStatus === 'schedule') {
        replyEmail = $("#reply-email").val();

        if (replyEmail === '') {
            // replyEmail = 'noreply@nichepractice.com';
        }

        var scheduleAt = $("#datepicker").val() + ' ' + $("#custom_timepicker_hour_selector").val() + ':' + $("#custom_timepicker_minutes_selector").val() + ':00';

        data = {
            send: 'save-template',
            subject: $("#subject").val(),
            from: $("#from").val(),
            reply_email: replyEmail,
            schedule_at: scheduleAt,
            status: 'schedule',
            id: templateId,
            response: json,
            template_preview: html
        };
    } else {
        // if(window.templateImage !== '')
        // {
        //     var blob = dataURItoBlob(window.templateImage);
        //
        //     formData.append("attach_file[0]", blob);
        // }

        data = {
            send: 'save-promotion-template',
            id: templateId,
            response: json,
            template_preview: window.templateImage,
            flag: flag
            // template_preview: html
        };
    }

    dataItems.push(data);
    console.log('push');

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },
        type: "POST",
        url: siteUrl + "/done-me",
        data: data
    }).done(function (result) {
        saveEditorProcess = false;
        // console.log("res");
        // console.log(result);

        saveTemplateCall = 'done';
        // console.log("After ajax " + saveTemplateCall);

        var json = $.parseJSON(result);
        var statusCode = json.status_code;
        var statusMessage = json.status_message;
        var data = json.data;

        // console.log(json);
        // return false;

        if (data.id && data.id !== '') {
            var template = data.id;

            var response = data.response;

            // console.log("template > " + template + " ) > aa > " + templateId);

            if (template !== templateId) {
                var uri = window.location.toString();
                // console.log("uri");
                // console.log(uri);
                var clean_uri = uri.substring(0, uri.indexOf("create-promotion"));
                // console.log("clean");
                // console.log(clean_uri);

                clean_uri = clean_uri + 'create-promotion/' + window.btoa(template);
                // console.log("modified Clean URL");
                // console.log(clean_uri);
                window.history.replaceState({}, document.title, clean_uri);

                window.templateId = template;
            }
        }

        // console.log("tem window.actionStatus " + actionStatus);
        var pageStatus = getPageStatus();

        if (statusCode === 200) {
            $("#flag").val('');
            hidePreloader();
            if (flag === 'sharing') {
                if (pageStatus === 'connected') {
                    $(".add_posts").click();

                    setTimeout(function () {
                        $(".attached_images_container").html('<div class="columns show-image"><img src="' + window.templateImage + '" /></div>');
                        $("#add_post_modal .modal-title").html('Share Promotion');
                    }, 400);
                } else {
                    $(".connect-app").click();
                }
            } else if (flag === 'embed') {
                var imageUrl = data.image;
                // console.log('imageUrl');
                // console.log(imageUrl);
                $(".close").click();
                setTimeout(function () {
                    var action = $(this).attr("data-action");
                    var baseUrl = $('#hfBaseUrl').val();

                    var mainModel = $('#main-modal');

                    $(".modal-body, .modal-footer, .validate-me", mainModel).remove();
                    $(mainModel).removeClass('welcome-process');
                    $(mainModel).addClass('modal-embed');

                    var html = '';

                    var socialSelectedClass = 'share-promotion';

                    html += '<div class="modal-body">\n' +
                        '<div class="embed-view" style="display: flex;justify-content: center">' +
                        '<input id="embed-link-preview" class="form-control embed-link-view embed-input" type="text" value="' + imageUrl + '" readonly />' +
                        '<i class="fa fa-copy copy-me" data-clipboard-action="copy" data-clipboard-target="#embed-link-preview"></i>' +
                        '</div>' +
                        '            </div>';

                    mainModel.modal('show');
                    $(".modal-header", mainModel).prepend('<h4 class="modal-title" id="publishModalLabel">Share Embed Link</h4>');
                    $(".modal-header", mainModel).after(html);


                    $('.copy-me').tooltip({
                        trigger: 'click',
                        placement: 'top'
                    });

                    var clipboard = new ClipboardJS('.copy-me');

                    clipboard.on('success', function (e) {
                        // console.log(e);
                        setTooltip(e.trigger, 'Copied!');
                        hideTooltip(e.trigger);

                    });

                    clipboard.on('error', function (e) {
                        console.log(e);
                        console.log("errors");
                    });
                }, 400);


            } else {
                // console.log("actionStatus " + actionStatus);
                if (saveImage === '') {
                    swal({
                        title: "Successful!",
                        text: 'Changes Saved.',
                        type: "success"
                    }, function () {
                    });
                }

            }

            // $('#img-link')[0].click();
            // else if(flag === 'save-image'){

            // console.log(saveImage);
            setTimeout(function () {
                $("#img-link").attr("href", window.templateImage);
                // console.log('i am only clicked for save image');

                // console.log(flag);
                if (saveImage == 'save-image') {
                    // console.log('going to click');
                    // $('#img-link').click();
                    $('#saveImage').removeAttr('value');
                    $('#img-link')[0].click();
                }
                // $("#add_post_modal .modal-title").html('Share Promotion');
            }, 500);
            // }

            // if(actionStatus === 'sendnow' || actionStatus === 'schedule')
            // {
            //     templateCustomerLink(actionStatus);
            //
            //     // if(actionStatus === 'sendnow')
            //     // {
            //     //     // send emails to recipients
            //     //     sendPreview(templateId, userId);
            //     // }
            //     //
            //     // swal({
            //     //     title: "Successful!",
            //     //     text: (actionStatus === 'sendnow') ? "Email set in queue for sending." : "Email has been Scheduled for " + scheduleAt,
            //     //     type: "success"
            //     // }, function () {
            //     //     showPreloader();
            //     //     location.href = siteUrl+'/email-campaigns';
            //     // });
            // }

        } else {
            hidePreloader();
            console.log('aa');
            var mainModel = $('#main-modal');
            mainModel.modal('hide');

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

function setTooltip(btn, message) {
    // console.log("setTooltip called");
    $(btn).tooltip('hide')
        .attr('data-original-title', message)
        .tooltip('show');
}

function hideTooltip(btn) {
    // console.log("hideTooltip called");
    setTimeout(function () {
        $(btn).tooltip('hide');
    }, 2000);
}

function getPageStatus() {
    if (window.socialMediaPostsData.length == 0) {
        // show popup facebook
        return 'not_connected';
    } else if (window.socialMediaPostsData.Facebook.status === 'connected' || window.socialMediaPostsData.Twitter.status === 'connected') {
        return 'connected';
    }

    return 'not_connected';
}

$(document.body).on('click', '.social-media-selected', function (e) {

    // var facebookPageConnected = socialMediaPostsData.Facebook.status;
    //
    // if(isEmptyVal(facebookPageConnected))
    // {
    //
    // }
});

$(document.body).on('click', '.publish-button', function (e) {
    // console.log("click");
    var action = $(this).attr("data-action");
    var baseUrl = $('#hfBaseUrl').val();

    var mainModel = $('#main-modal');
    // mainModel.show();

    $(".modal-body, .modal-footer, .validate-me", mainModel).remove();
    $(mainModel).removeClass('welcome-process');
    $(mainModel).addClass('modal-publish');

    // var currentModel = $(".modal-publish");

    var html = '';

    // var socialSelectedClass = (getPageStatus() == 'connected') ? 'connected_posts' : 'connect-auth';
    // var socialSelectedClass = (getPageStatus() == 'connected') ? 'open-add-posts' : 'connect-app';
    var socialSelectedClass = 'share-promotion';
    var image = window.templateImage;
    html += '<div class="modal-body">\n' +
        '                <div class="jumbotron" style="border-radius: 0; display: flex; padding: 10px 20px; align-items: center; justify-content: space-between;">\n' +
        '                    <div>\n' +
        '                        <h3 class="m-0" style="font-weight: bold;">Social Media</h3>\n' +
        '                        <p class="m-0" style="font-size: 15px;">Apply to facebook pages or twitter accounts.</p>\n' +
        '                    </div>\n' +
        '                    <div>\n' +
        '                        <button data-type="Facebook" class="btn btn-primary share-promotion" style="border-radius: 0;padding: 10px 15px; font-size: 17px;">Select</button>\n' +
        '                    </div>\n' +
        '                </div>\n' +
        '\n' +
        '                <div class="jumbotron" style="border-radius: 0; display: flex; padding: 10px 20px; align-items: center; justify-content: space-between;">\n' +
        '                        <div>\n' +
        '                            <h3 class="m-0" style="font-weight: bold;">Embed Links</h3>\n' +
        '                            <p class="m-0" style="font-size: 15px;">Embed this design in your blog or website.</p>\n' +
        '                        </div>\n' +
        '                        <div>\n' +
        '                            <button class="btn btn-primary embed-link" style="border-radius: 0;padding: 10px 15px; font-size: 17px;">Select</button>\n' +
        '                        </div>\n' +
        '                    </div>\n' +
        '<div class="jumbotron" style="border-radius: 0; display: flex; padding: 10px 20px; align-items: center; justify-content: space-between;">\n' +
        '                        <div>\n' +
        '                            <h3 class="m-0" style="font-weight: bold;">Save As Image File</h3>\n' +
        // '                            <p class="m-0" style="font-size: 15px;">Embed this design in your blog or website.</p>\n' +
        '                        </div>\n' +
        '                        <div>\n' +
        '                            <a class="btn btn-primary save-Image" style="border-radius: 0;padding: 10px 15px; font-size: 17px;" download>Save</a>\n' +
        '                        </div>\n' +
        '                    </div>\n' +
        '            </div>';

    mainModel.modal('show');
    $(".modal-header", mainModel).prepend('<h4 class="modal-title" id="publishModalLabel">What Do you like to do with your promotion?</h4>');
    $(".modal-header", mainModel).after(html);
});

$(document.body).on('click', '.embed', function (e) {
    // console.log("click");
    var action = $(this).attr("data-action");
    var baseUrl = $('#hfBaseUrl').val();

    var mainModel = $('#main-modal');
    // mainModel.show();

    $(".modal-body, .modal-footer, .validate-me", mainModel).remove();
    $(mainModel).removeClass('welcome-process');
    $(mainModel).addClass('modal-publish');

    // var currentModel = $(".modal-publish");

    var html = '';

    // var socialSelectedClass = (getPageStatus() == 'connected') ? 'connected_posts' : 'connect-auth';
    // var socialSelectedClass = (getPageStatus() == 'connected') ? 'open-add-posts' : 'connect-app';
    var socialSelectedClass = 'share-promotion';

    html += '<div class="modal-body">\n' +
        '<div class="embed-view"><input class="form-control embed-link-view" type="text" value="" readonly /></div>' +
        '            </div>';

    mainModel.modal('show');
    $(".modal-header", mainModel).prepend('<h4 class="modal-title" id="publishModalLabel">What Do you like to do with your promotion?</h4>');
    $(".modal-header", mainModel).after(html);
});

$(document.body).on('click', '.connect-auth', function (e) {
    var action = $(this).attr("data-action");
    var baseUrl = $('#hfBaseUrl').val();

    var mainModel = $('#main-modal');

    $(".connect-auth .modal-title").remove();

    $(".modal-body, .modal-footer, .validate-me", mainModel).remove();

    // $(".connect-app").click();

    $(mainModel).removeClass('modal-publish');

    $(mainModel).addClass('welcome-process');
    $(mainModel).addClass('sharing-process');
    // $(mainModel).addClass('modal-publish');

    var html = '';


    html += '<div class="modal-body">\n' +
        '                    <div class="card card-1">\n' +
        '                        <div class="card-body">\n' +
        '                            <h4 class="modal-title" style="font-weight: bold;text-transform: uppercase;font-size: 16px;">Publish to Social Media</h4>\n' +
        '                            <hr style="width: 100%;" class="m-t-5">\n' +
        '\n' +
        '                            <div class="tab-content">\n' +
        '                                \n' +
        '\n' +
        '                                \n' +
        '                                \n' +
        '\n' +
        '                                <div class="tab-pane active" id="tab1">\n' +
        '                                    <h4 class="text-center" style="">Publish your design to Social Media</h4>\n' +
        '                                    <div class="row text-center">\n' +
        '                                        <div class="col-xs-6">\n' +
        '                                            <div class="welcome-model-box">\n' +
        '                                                <img src="' + baseUrl + '/public/images/modal1-1.jpg">\n' +
        '                                                <p>Earn positive reviews from your best patients.</p>\n' +
        '                                            </div>\n' +
        '                                        </div>\n' +
        '                                        <div class="col-xs-6">\n' +
        '                                            <div class="welcome-model-box">\n' +
        '                                                <img src="' + baseUrl + '/public/images/modal1-2.jpg">\n' +
        '                                                <p>Get compelling content designed to position you as an expert.</p>\n' +
        '                                            </div>\n' +
        '                                        </div>\n' +
        '                                    </div>\n' +
        '                                </div>\n' +
        '                                </div>\n' +
        '                            </div>\n' +
        '                        </div>\n' +
        '                    </div>\n' +
        '                </div>' +
        '<div class="modal-footer">' +
        '<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>' +
        '<button type="button" id="loginSocial" class="btn facebook-widget-btn"> Connect Facebook</button></div>';

    mainModel.modal('show');
    // $(".modal-header").prepend('<h4 class="modal-title" id="publishModalLabel">What Do you like to do with your promotion?</h4>');
    $(".modal-header", mainModel).after(html);
});

$(document).on('click', ".share-promotion", function (e) {
    $("#flag").val('sharing');
    showPreloader();
    $(".export-button").click();
    // $(".add_posts").click();
});

$(document).on('click', ".embed-link", function (e) {
    $("#flag").val('embed');
    showPreloader();

    $(".export-button").click();
    // $(".add_posts").click();
});

$(document).on('click', ".add_posts", function (e) {
    // console.log("first click");
    var mainModel = $('#main-modal');
    mainModel.modal('hide');
});


$('#main-modal').on('hidden.bs.modal', function () {
    // console.log("main modal hide");

    var mainModel = $('#main-modal');
    $(".modal-title", mainModel).remove();
});

// $('#add_post_modal').on('hidden.bs.modal', function () {
//     var mainModel = $('#main-modal');
//     $(".modal-title", mainModel).remove();
//     $(".modal-backdrop").hide();
// });


function dataURItoBlob(dataURI) {
    // convert base64/URLEncoded data component to raw binary data held in a string
    var byteString;
    if (dataURI.split(',')[0].indexOf('base64') >= 0)
        byteString = atob(dataURI.split(',')[1]);
    else
        byteString = unescape(dataURI.split(',')[1]);

    // separate out the mime component
    var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];

    // write the bytes of the string to a typed array
    var ia = new Uint8Array(byteString.length);
    for (var i = 0; i < byteString.length; i++) {
        ia[i] = byteString.charCodeAt(i);
    }

    return new Blob([ia], {type: mimeString});
}


$(document).on('click', ".save-Image", function (e) {

    $("#saveImage").val('save-image');
    showPreloader();
    $(".export-button").click();
});
