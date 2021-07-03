@extends('index')

@section('pageTitle', 'Email Preview')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid dashboarbgtitle">
            <div class="dashboard-wrapper campaign-builder-page">
                <div class="page-head">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="page-title">Email Preview</h4>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="back-page" style="margin-top: 20px;">
                            <i class="fa fa-angle-left"></i>
                            @if(!empty($_GET['type']) && $_GET['type'] == 'patient_emails')
                                <a href="{{ route('front.new-patient-emails') }}">New Patient Emails List</a>
                            @else
                                <a href="{{ route('email') }}">Email Campaign List</a>
                            @endif
                        </div>
                    </div>
                </div>


                <div class="loading-bar" style="text-align: center;margin-top: 50px; display: block;">
                    <span class="loading-text" style="font-size: 15px;font-weight: 700;display: block;">Loading Preview...</span>
                    <img src="{{ asset('public/images/Loading-bar.gif') }}">
                </div>

                <div class="row">
                    <div class="col-md-12" >
                        <div id="app" class="create steps-section" style=" width: 100%; height: 100vh; display: block;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/select/1.2.1/css/select.dataTables.min.css" />
    <link type="text/css" rel="stylesheet" href="{{ asset('public/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('public/css/crm-customers/crm-customers.css') }}" />
    <style>
        .connect-me
        {
            background: #3D4A9E !important;
            border: 1px solid #3D4A9E !important;
        }
        .table-condensed>tbody>tr>td, .table-condensed>tbody>tr>th, .table-condensed>tfoot>tr>td, .table-condensed>tfoot>tr>th, .table-condensed>thead>tr>td, .table-condensed>thead>tr>th
        {
            line-height: 0;
        }
        .datepicker .datepicker-switch, .datepicker .next, .datepicker .prev, .datepicker tfoot tr th {
            cursor: pointer;
            font-weight: bold;
            color: #000000;
        }

        .custom-checkbox:hover {
            background-color: #daeffe;
        }
        .custom-checkbox {
            position: relative;
            display: inline-block;
            width: 16px;
            height: 16px;
            cursor: pointer;
            border: 1px solid #c6e2f7;
            border-radius: 4px;
            background-color: #fff;
            transition: .2s ease background-color;
        }
        .custom-checkbox:after {
            position: absolute;
            top: 50%;
            right: 0;
            bottom: 0;
            left: 50%;
            margin: -3px 0 0 -4px;
            -webkit-transform: scale(0);
            transform: scale(0);
            transition: .2s ease -webkit-transform;
            transition: .2s ease transform;
            content: ' ';
            display: inline-block;
            vertical-align: middle;
            background: url('https://static.parastorage.com/services/shoutout-static/1.2316.0/images/icons/ic-checkbox-checked.png') center center;
            width: 8px;
            height: 6px;
        }
        .custom-checkbox--checked:after {
            -webkit-transform: scale(1);
            transform: scale(1);
        }
        .contacts-input {
            margin-bottom: 36px;
            min-height: 54px;
            max-height: 96px;
            overflow: hidden;
            border: 1px solid #c1e4fe;
            border-radius: 7px;
            background-color: #fff;
        }
        .contacts-input__label {
            font-size: 16px;
            color: #20455e;
            font-weight: 400;
            float: left;
            margin: 17px 12px 0 16px;
        }
        .contacts-input__input-wrapper {
            padding-top: 10px;
            overflow: auto;
            max-height: 100px;
        }
        .decipher-tags {
            display: flex;
            -webkit-flex-wrap: wrap;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            overflow-y: auto;
            overflow-x: hidden;
            word-wrap: break-word;
        }
        .decipher-tags .tag-wrapper {
            -webkit-flex: 0 0 auto;
            -ms-flex: 0 0 auto;
            flex: 0 0 auto;
            max-height: 31px;
            margin-bottom: 10px;
            margin-right: 10px;
        }
        .decipher-tags .decipher-tags-tag {
            background-color: #f0f4f7;
            border-radius: 5px;
            overflow: hidden;
        }
        .decipher-tags .tag-wrapper--input {
            -webkit-flex: 1 0 360px;
            -ms-flex: 1 0 360px;
            flex: 1 0 360px;
            height: 30px;
            margin-bottom: 10px;
        }
        .contacts-input .decipher-tags-input {
            font-size: 16px;
            line-height: 24px;
            font-weight: 400;
        }
        .decipher-tags .decipher-tags-input {
            width: 100%;
            height: 100%;
            border: none;
            background-color: transparent;
            outline: 0;
        }
        .decipher-tags .decipher-tags-tag .tag-image {
            display: inline-block;
            width: 30px;
            height: 30px;
            margin-right: 8px;
            background: url('https://static.parastorage.com/services/shoutout-static/1.2316.0/images/contacts/recipients-tag-contact.png') 50% 50% no-repeat;
            vertical-align: middle;
        }
        .decipher-tags .decipher-tags-tag .tag-image img {
            width: 100%;
            height: auto;
        }
        .decipher-tags .decipher-tags-tag .tag-text {
            display: inline-block;
            max-width: 400px;
            font-family: "Helvetica Neue",Arial;
            font-size: 14px;
            color: #555;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            vertical-align: middle;
        }
    </style>
@endsection

@section('js')
     <?php echo '<script> var userId = '. $userId .'; var templateId; var editorUserId; </script>'; ?>

     @if($templateId)
     <?php
            echo '<script> templateId = '. $templateId .'</script>';
     ?>
     @endif

     @if($appEnvIs == 'production')
         <?php
         $domain = explode('@',$userEmail)[1];

         if($domain == 'mailinator.com' || $domain == 'nichepractice.com')
         {
             echo '<script> editorUserId = 1 </script>';
         }
         else
         {
             echo '<script> editorUserId = '. $userId .'</script>';
         }
         ?>
     @else
         <?php
         echo '<script> editorUserId = 1 </script>';
         ?>
     @endif

    <script src="{{ asset('public/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
{{--    <script src="https://d5aoblv5p04cg.cloudfront.net/editor/loader/build.js" type="text/javascript"></script>--}}
     <script src="https://d5aoblv5p04cg.cloudfront.net/mjml4-editor/loader/build.js" type="text/javascript"></script>
    <script>

        // saveTemplateCall = progress, done
        saveTemplateCall = 'done';
        actionStatus = '';

        $(function () {
            $("body").addClass('hide-sidebar');
            $(".sidebar").hide();

            $('#app iframe').on("load", function() {
                // console.log("iframe loaded > " + userId);
                getTemplate(templateId);
            });

            $(".save-action").click(function () {
                TopolPlugin.save(); // To force the save -> the onSave callback will be called with the JSON and HTML of the template
            });
        });

        var TOPOL_OPTIONS = {
            id: "#app",
            authorize: {
                apiKey: "Gp1QsJyfAZwRlizPdy1pZ0pnASId49umK6Y5ptc99OoycrumsNHmTRPwEXTw",
                userId: editorUserId,
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

         // TopolPlugin.togglePreview(); // Toggles the mode of Preview


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

                    if(data.id && data.id !== '') {
                        var title = data.title;

                        $("#subject").val(title);
                        $("#from").val(data.from);
                        $("#reply-email").val(data.reply_email);
                        // $("#from").val(title);
                    }

                    var response = data.response;

                    $(".steps-nav").show();
                    $(".loading-bar").hide();
                    $(".action-center").show();

                    TopolPlugin.load(response);

                    setTimeout(function () {
                        TopolPlugin.togglePreview();
                    },1000);
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
     </script>
@endsection
