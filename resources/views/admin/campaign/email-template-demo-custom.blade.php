@extends('admin.layout')

@section('title', 'Email Template')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-default">
                <div class="box-body">
                    <div class="col-sm-12 input-form" style="display: none;">
                        <h3 class="box-title">Demo with custom buttons</h3>
                    </div>

                    <div class="col-sm-12 steps-nav" style="display: none;">

                        <div class="col-sm-1">
                            <a href="http://nichepractice.test/admin/templates/list" class="btn btn-default" style="padding-left: 30px;padding-right: 30px;">Back</a>
                        </div>

                        <div class="col-sm-8 text-center">
                            <div class="campaign-steps">
                    <span>
                    <a class="active" data-action="create">1. Create</a>
                    <i class="fa fa-angle-right"></i>
                    </span>

                                <span><a class="" data-action="add-recipients-container">2. Add Recipients</a><i class="fa fa-angle-right"></i></span>
                                <span><a href="javascript:void(0);" class="" data-action="publish-container">3. PUBLISH &amp; SEND</a></span>
                            </div>
                        </div>

                        <div class="col-sm-3 action-center" style="">

                            <button class="btn btn-primary save-action">Save</button>
                        </div>
                    </div>

                    <div class="loading-bar" style="text-align: center;margin-top: 50px; display: block;">
                        <span class="loading-text" style="font-size: 15px;font-weight: 700;display: block;">Loading Template...</span>
                        <img src="{{ asset('public/images/Loading-bar.gif') }}">
                    </div>

                    <div class="row">
                        <div class="col-sm-12" >
                            <div id="app" class="create steps-section" style=" width: 100%; height: 100vh; display: block;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('after_styles')
    <style>
        .plan-block .btn-group
        {
            width: 100%;
        }
        .plan-block .multiselect.dropdown-toggle {
            width: 100%;
            text-align: left;
            height: 38px;
            opacity: 1 !important;
            background: #ffffff;
        }
        .plan-block .multiselect.dropdown-toggle .caret
        {
            float: right;
            margin-top: 8px;
        }

        .box.box-default
        {
            border: none;
        }
        /*Select 2*/
        .select2-container .select2-choice {
            background-image: none !important;
            border: none !important;
            height: auto !important;
            padding: 0px !important;
            line-height: 22px !important;
            background-color: transparent !important;
            box-shadow: none !important;
        }
        .select2-container .select2-choice .select2-arrow {
            background-image: none !important;
            background: transparent;
            border: none;
            width: 14px;
            top: -2px;
        }
        .select2-container .select2-container-multi.form-control {
            height: auto;
        }
        .select2-results .select2-highlighted {
            color: #262626;
            background-color:#f0f0f0;
        }
        .select2-drop-active {
            border: 1px solid #e3e3e3 !important;
            padding-top: 5px;
        }
        .select2-search input {
            border: 1px solid rgba(120, 130, 140, 0.13);
        }
        .select2-container-multi {
            width: 100%;
        }
        .select2-container-multi .select2-choices {
            border: 1px solid !important;
            box-shadow: none !important;
            background-image: none !important;
            border-radius: 0px !important;
            min-height: 38px;
        }
        .select2-container-multi .select2-choices .select2-search-choice {
            padding: 4px 7px 4px 18px;
            margin: 5px 0 3px 5px;
            color: #555555;
            background: #f5f5f5;
            border-color: rgba(120, 130, 140, 0.13);
            -webkit-box-shadow: none;
            box-shadow: none;
        }
        .select2-container-multi .select2-choices .select2-search-field input {
            padding: 7px 7px 7px 10px;
            font-family: inherit;
        }
        .box {
            background: none !important;
        }
        .input-form
        {
            margin-bottom: 20px;
            background: #ffffff;
            padding-bottom: 10px;
        }
        .input-form .box-title
        {
            padding-left: 40px;
            padding-bottom: 20px;
        }
        .add-praticelogo {
            margin: 0;
        }
        #logo label {
            cursor: pointer;
            display: inline-block;
            max-width: 100%;
            margin-bottom: 5px;
        }

        .profile-info .p-l-image {
            border: 1px solid #ddd;
            text-align: center;
            width: 200px;
            margin: 10px 0;
            height: 140px;
        }
        .profile-info .p-l-image .no-image
        {
            padding: 22px 0;
        }
        .logo-image-container div.show-image {
            background: none;
            border-radius: 4px;
            overflow: hidden;
            max-width: 160px;
            max-height: 140px;
            margin-left: 0;
            position: relative;
            /* margin: 5px; */
            display: inline-block;
        }
        #add_video_file_demo, #add_image_file, #add_video_file, #add_logo, #add_logo_image {
            display: none;
        }
        .logo-image-container div.show-image img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
        .profile-info .p-l-image img {
            margin: auto;
        }
        div.show-image span.remove_image {
            top: 4px;
            right: 4px;
        }
        .attached_images_container .remove_image {
            display: none !important;
        }
        div.show-image span {
            position: absolute;
            display: none;
            float: right;
            border-radius: 81px;
            width: 16px;
            text-align: center;
            height: 16px;
            font-size: 13px;
            background: #FFFFFF;
            line-height: 1.2;
            cursor: pointer;
        }
        .campaign-steps
        {
            display: none;
            margin-top: 5px;
        }
        .campaign-steps span, .campaign-steps span a
        {
            /*color: #3899ec;*/
            font-size: 16px;
            margin-right: 20px;
            color: #B0D5ED;
        }
        .campaign-steps span a
        {
            cursor: pointer;
        }
        .campaign-steps span .active
        {
            cursor: default;
        }
        .campaign-steps span .active, .campaign-steps span a:hover
        {
            color: #03A9F4;
            /*color: #3D4A9E;*/
        }
        .steps-nav
        {
            margin-bottom: 20px;
            background: #fff;
            padding: 15px;
        }

        .next-action
        {
            color: #fff;
            background-color: #03A9F4 !important;
            border-color: #0697d9 !important;
            float: right;
            padding-right: 40px;
            padding-left: 40px;
        }

        .save-action
        {
            background-color: #fff !important;
            float: right;
            padding-right: 25px;
            padding-left: 25px;
            color: #20a0ff !important;
            border-color: #20a0ff !important;
            margin-right: 20px;
        }
    </style>
@endsection

@section('js')
    <?php
    echo '<script> var userId = '. $userId .'; var templateId; </script>'; ?>

    @if(!empty($templateId))
        <?php
        echo '<script> templateId = '. $templateId .'</script>';
        ?>
    @endif

    <script>
        $(function () {
            $(".content-wrapper").addClass('removeSidebar');

            $('#app iframe').on("load", function () {
                $(".loading-bar").hide();
                $(".steps-nav").show();
            });
        });

        var TOPOL_OPTIONS = {
            id: "#app",
            authorize: {
                apiKey: "Gp1QsJyfAZwRlizPdy1pZ0pnASId49umK6Y5ptc99OoycrumsNHmTRPwEXTw",
                userId: userId,
            },
            language: "en",
            light: true,
            removeTopBar: true,
            disableAlerts: false,
            title: "My template builder",
            callbacks: {
                onSaveAndClose: function(json, html) {
                    // console.log("onSaveAndClose");
                    // console.log(json);
                    // console.log(userId + ' > ' + templateId);
                    // saveTemplate(json, html, templateId);
                    // HTML of the email
                    // console.log(html);
                    // JSON object of the email
                },
                onSave: function(json, html) {
                    // console.log("onSave");
                    // console.log(json);
                    // console.log("html");
                    // console.log(html);
                    // saveTemplate(json, html, templateId);

                    // console.log("html");
                    // console.log(html);
                    // HTML of the email
                    // console.log(html);
                    // JSON object of the email
                    // console.log(json);
                },
            }
        };
    </script>

{{--    <script src="https://d5aoblv5p04cg.cloudfront.net/editor/loader/build.js" type="text/javascript"></script>--}}

    <script src="https://d5aoblv5p04cg.cloudfront.net/mjml4-editor/loader/build.js" type="text/javascript"></script>
    <script>
        TopolPlugin.init(TOPOL_OPTIONS);
        // console.log("yes");
        TopolPlugin.load(
            JSON.stringify(
                {
                    "tagName": "mj-global-style\"",
                    "children": [{
                        "tagName": "mj-body",
                        "attributes": {"background-color": "#E9E8E8", "containerWidth": 600},
                        "children": [{
                            "tagName": "mj-section",
                            "attributes": {
                                "full-width": false,
                                "padding": "5px 0px 5px 0px",
                                "background-color": "#D20005",
                                "background-url": null
                            },
                            "type": null,
                            "children": [{
                                "tagName": "mj-column",
                                "attributes": {"width": "50%", "vertical-align": "top"},
                                "children": [{
                                    "tagName": "mj-text",
                                    "attributes": {
                                        "align": "left",
                                        "font-size": "11px",
                                        "locked": "true",
                                        "editable": "true",
                                        "padding-bottom": "0",
                                        "padding-top": "0",
                                        "containerWidth": 600,
                                        "color": "#131212",
                                        "padding": "0px 0px 0px 10px",
                                        "font-family": "Lato, \"Tahoma\", sans-serif"
                                    },
                                    "content": "<p><span style=\"color:#ffffff;\">Write your preheader here<\/span><\/p>",
                                    "uid": "iS11MzSD4"
                                }],
                                "uid": "_qoy4D-qm"
                            }, {
                                "tagName": "mj-column",
                                "attributes": {"width": "50%", "vertical-align": "top"},
                                "children": [{
                                    "tagName": "mj-text",
                                    "attributes": {
                                        "align": "right",
                                        "font-size": "11px",
                                        "locked": "true",
                                        "editable": "false",
                                        "padding-bottom": "0",
                                        "padding-top": "0",
                                        "containerWidth": 600,
                                        "padding": "0px 10px 0px 0px",
                                        "font-family": "Lato, \"Tahoma\", sans-serif"
                                    },
                                    "content": "<p><a draggable=\"false\" href=\"*|WEBVERSION|*\" style=\"color: #808080;\">Online version<\/a><\/p>",
                                    "uid": "BLgQ51VTb"
                                }],
                                "uid": "XKU2mfGIam"
                            }],
                            "layout": 1,
                            "backgroundColor": "",
                            "backgroundImage": "",
                            "paddingTop": 0,
                            "paddingBottom": 0,
                            "paddingLeft": 0,
                            "paddingRight": 0,
                            "uid": "Cr8P8-2HW"
                        }, {
                            "tagName": "mj-section",
                            "attributes": {
                                "full-width": false,
                                "padding": "0px 0px 0px 0px",
                                "background-color": "#FFFFFF"
                            },
                            "type": null,
                            "children": [{
                                "tagName": "mj-column",
                                "attributes": {"width": "100%", "vertical-align": "top"},
                                "children": [{
                                    "tagName": "mj-image",
                                    "attributes": {
                                        "src": "https:\/\/storage.googleapis.com\/afuxova10642\/lista_cervena-1.jpg",
                                        "padding": "0px 0px 0px 0px",
                                        "alt": "",
                                        "href": "",
                                        "containerWidth": 600,
                                        "width": 600,
                                        "widthPercent": 100
                                    },
                                    "uid": "yPlynus30X"
                                }],
                                "uid": "S0-FHYBzO"
                            }],
                            "layout": 1,
                            "backgroundColor": "",
                            "backgroundImage": "",
                            "paddingTop": 0,
                            "paddingBottom": 0,
                            "paddingLeft": 0,
                            "paddingRight": 0,
                            "uid": "TCO5bsIup"
                        }, {
                            "tagName": "mj-section",
                            "attributes": {
                                "full-width": false,
                                "padding": "0px 0px 0px 0px",
                                "background-color": "#FFFFFF"
                            },
                            "type": null,
                            "children": [{
                                "tagName": "mj-column",
                                "attributes": {"width": "33.333333%", "vertical-align": "top"},
                                "children": [{
                                    "tagName": "mj-spacer",
                                    "attributes": {
                                        "height": "30px",
                                        "containerWidth": 200,
                                        "css-class": "hide_on_mobile"
                                    },
                                    "uid": "7gA4cd2_h"
                                }, {
                                    "tagName": "mj-image",
                                    "attributes": {
                                        "src": "https:\/\/storage.googleapis.com\/afuxova10642\/2020\/Jan\/Fri\/1578652677.png",
                                        "padding": "0px 0px 0px 0px",
                                        "alt": "",
                                        "href": "",
                                        "containerWidth": 200,
                                        "width": 192,
                                        "widthPercent": 96,
                                        "css-class": null
                                    },
                                    "uid": "_fHoKItdC"
                                }],
                                "uid": "XktASzGeq"
                            }, {
                                "tagName": "mj-column",
                                "attributes": {"width": "33.333333%", "vertical-align": "top"},
                                "children": [{
                                    "tagName": "mj-text",
                                    "attributes": {
                                        "align": "center",
                                        "font-size": "11px",
                                        "padding": "0px 0px 0px 0px",
                                        "line-height": 1.5,
                                        "containerWidth": 600
                                    },
                                    "uid": "W2WFp61De",
                                    "content": "<p><span style=\"font-size:54px;\"><strong><span style=\"color:#c0392b;\">SALES<\/span><\/strong><\/span><\/p>"
                                }],
                                "uid": "S7F5P_xAdN"
                            }, {
                                "tagName": "mj-column",
                                "attributes": {"width": "33.333333%", "vertical-align": "top"},
                                "children": [{
                                    "tagName": "mj-spacer",
                                    "attributes": {
                                        "height": "23px",
                                        "containerWidth": 200,
                                        "css-class": "hide_on_mobile"
                                    },
                                    "uid": "obroZMvtK"
                                }, {
                                    "tagName": "mj-image",
                                    "attributes": {
                                        "src": "https:\/\/storage.googleapis.com\/afuxova10642\/2020\/Jan\/Fri\/1578652858.png",
                                        "padding": "0px 0px 0px 0px",
                                        "alt": "",
                                        "href": "",
                                        "containerWidth": 200,
                                        "width": 200,
                                        "widthPercent": 100,
                                        "css-class": null
                                    },
                                    "uid": "5s3jn4IoO"
                                }],
                                "uid": "HrcsS24dCr"
                            }],
                            "layout": 1,
                            "backgroundColor": "",
                            "backgroundImage": "",
                            "paddingTop": 0,
                            "paddingBottom": 0,
                            "paddingLeft": 0,
                            "paddingRight": 0,
                            "uid": "NEbgdn2td"
                        }, {
                            "tagName": "mj-section",
                            "attributes": {
                                "full-width": false,
                                "padding": "0px 0px 0px 0px",
                                "background-color": "#FFFFFF"
                            },
                            "type": null,
                            "children": [{
                                "tagName": "mj-column",
                                "attributes": {"width": "100%", "vertical-align": "top"},
                                "children": [{
                                    "tagName": "mj-text",
                                    "attributes": {
                                        "align": "center",
                                        "font-size": "11px",
                                        "padding": "0px 0px 0px 0px",
                                        "line-height": 1.5,
                                        "containerWidth": 600
                                    },
                                    "uid": "xpm-cBcd6",
                                    "content": "<p><span style=\"color:#000000;\"><span style=\"font-size:36px;\"><strong>FOR YOUR LOVED ONES<\/strong><\/span><\/span><\/p>"
                                }, {
                                    "tagName": "mj-image",
                                    "attributes": {
                                        "src": "https:\/\/storage.googleapis.com\/afuxova10642\/SRDCE.png",
                                        "padding": "0px 0px 0px 0px",
                                        "alt": "",
                                        "href": "",
                                        "containerWidth": 600,
                                        "width": 492,
                                        "widthPercent": 82
                                    },
                                    "uid": "lAC4omOLU"
                                }],
                                "uid": "uZAy0dAC1"
                            }],
                            "layout": 1,
                            "backgroundColor": "",
                            "backgroundImage": "",
                            "paddingTop": 0,
                            "paddingBottom": 0,
                            "paddingLeft": 0,
                            "paddingRight": 0,
                            "uid": "GrpB0pNM1"
                        }, {
                            "tagName": "mj-section",
                            "attributes": {
                                "full-width": false,
                                "padding": "0px 0px 0px 0px",
                                "background-color": "#FFFFFF"
                            },
                            "type": null,
                            "children": [{
                                "tagName": "mj-column",
                                "attributes": {"width": "100%", "vertical-align": "top"},
                                "children": [{
                                    "tagName": "mj-spacer",
                                    "attributes": {
                                        "height": "10px",
                                        "containerWidth": 600,
                                        "css-class": "hide_on_mobile"
                                    },
                                    "uid": "JMxPe7PmJJ"
                                }],
                                "uid": "617hkFXpF"
                            }],
                            "layout": 1,
                            "backgroundColor": "",
                            "backgroundImage": "",
                            "paddingTop": 0,
                            "paddingBottom": 0,
                            "paddingLeft": 0,
                            "paddingRight": 0,
                            "uid": "YMwVICeom"
                        }, {
                            "tagName": "mj-section",
                            "attributes": {
                                "full-width": false,
                                "padding": "1px 0px 1px 0px",
                                "background-color": "#FFFFFF"
                            },
                            "type": null,
                            "children": [{
                                "tagName": "mj-column",
                                "attributes": {"width": "50%", "vertical-align": "top"},
                                "children": [{
                                    "tagName": "mj-button",
                                    "attributes": {
                                        "align": "center",
                                        "background-color": "#050100",
                                        "color": "#fff",
                                        "border-radius": "none",
                                        "font-size": "13px",
                                        "padding": "2px 10px 2px 11px",
                                        "inner-padding": "9px 26px",
                                        "href": "https:\/\/google.com",
                                        "font-family": "Ubuntu, Helvetica, Arial, sans-serif, Helvetica, Arial, sans-serif",
                                        "containerWidth": 300,
                                        "border": "0px solid #000",
                                        "width": "100%"
                                    },
                                    "content": "FOR WOMEN",
                                    "uid": "UFtyD-wr3j"
                                }],
                                "uid": "3z79SNYkb7"
                            }, {
                                "tagName": "mj-column",
                                "attributes": {"width": "50%", "vertical-align": "top"},
                                "children": [{
                                    "tagName": "mj-button",
                                    "attributes": {
                                        "align": "center",
                                        "background-color": "#000000",
                                        "color": "#fff",
                                        "border-radius": "none",
                                        "font-size": "13px",
                                        "padding": "2px 10px 2px 10px",
                                        "inner-padding": "9px 26px",
                                        "href": "https:\/\/google.com",
                                        "font-family": "Ubuntu, Helvetica, Arial, sans-serif, Helvetica, Arial, sans-serif",
                                        "containerWidth": 300,
                                        "border": "0px solid #000",
                                        "width": "100%"
                                    },
                                    "content": "FOR MEN",
                                    "uid": "K5UtZshb-t"
                                }],
                                "uid": "fdqmy278XS"
                            }],
                            "layout": 1,
                            "backgroundColor": "",
                            "backgroundImage": "",
                            "paddingTop": 0,
                            "paddingBottom": 0,
                            "paddingLeft": 0,
                            "paddingRight": 0,
                            "uid": "iLCRA_Pqf"
                        }, {
                            "tagName": "mj-section",
                            "attributes": {
                                "full-width": false,
                                "padding": "1px 0px 1px 0px",
                                "background-color": "#FFFFFF"
                            },
                            "type": null,
                            "children": [{
                                "tagName": "mj-column",
                                "attributes": {"width": "50%", "vertical-align": "top"},
                                "children": [{
                                    "tagName": "mj-button",
                                    "attributes": {
                                        "align": "center",
                                        "background-color": "#050100",
                                        "color": "#fff",
                                        "border-radius": "none",
                                        "font-size": "13px",
                                        "padding": "2px 10px 2px 9px",
                                        "inner-padding": "9px 26px",
                                        "href": "https:\/\/google.com",
                                        "font-family": "Ubuntu, Helvetica, Arial, sans-serif, Helvetica, Arial, sans-serif",
                                        "containerWidth": 300,
                                        "border": "0px solid #000",
                                        "width": "100%"
                                    },
                                    "content": "BESTSELLER",
                                    "uid": "8IrW4TQ-N"
                                }],
                                "uid": "QyQsiYnxI7"
                            }, {
                                "tagName": "mj-column",
                                "attributes": {"width": "50%", "vertical-align": "top"},
                                "children": [{
                                    "tagName": "mj-button",
                                    "attributes": {
                                        "align": "center",
                                        "background-color": "#000000",
                                        "color": "#fff",
                                        "border-radius": "none",
                                        "font-size": "13px",
                                        "padding": "2px 10px 2px 10px",
                                        "inner-padding": "9px 26px",
                                        "href": "https:\/\/google.com",
                                        "font-family": "Ubuntu, Helvetica, Arial, sans-serif, Helvetica, Arial, sans-serif",
                                        "containerWidth": 300,
                                        "border": "0px solid #000",
                                        "width": "100%"
                                    },
                                    "content": "NEW",
                                    "uid": "fR77FeyJy"
                                }],
                                "uid": "P-ELVn-GUx"
                            }],
                            "layout": 1,
                            "backgroundColor": "",
                            "backgroundImage": "",
                            "paddingTop": 0,
                            "paddingBottom": 0,
                            "paddingLeft": 0,
                            "paddingRight": 0,
                            "uid": "y7yMpWSij"
                        }, {
                            "tagName": "mj-section",
                            "attributes": {
                                "full-width": false,
                                "padding": "0px 0px 0px 0px",
                                "background-color": "#FFFFFF"
                            },
                            "type": null,
                            "children": [{
                                "tagName": "mj-column",
                                "attributes": {"width": "100%", "vertical-align": "top"},
                                "children": [{
                                    "tagName": "mj-spacer",
                                    "attributes": {
                                        "height": "10px",
                                        "containerWidth": 600,
                                        "css-class": "hide_on_mobile"
                                    },
                                    "uid": "mY0AkKcHg"
                                }],
                                "uid": "617hkFXpF"
                            }],
                            "layout": 1,
                            "backgroundColor": "",
                            "backgroundImage": "",
                            "paddingTop": 0,
                            "paddingBottom": 0,
                            "paddingLeft": 0,
                            "paddingRight": 0,
                            "uid": "wsX2bBvRp"
                        }, {
                            "tagName": "mj-section",
                            "attributes": {
                                "full-width": false,
                                "padding": "0px 0px 0px 0px",
                                "background-color": "#FFFFFF"
                            },
                            "type": null,
                            "children": [{
                                "tagName": "mj-column",
                                "attributes": {"width": "100%", "vertical-align": "top"},
                                "children": [{
                                    "tagName": "mj-image",
                                    "attributes": {
                                        "src": "https:\/\/storage.googleapis.com\/afuxova10642\/2020\/Jan\/Wed\/1578489556.png",
                                        "padding": "0px 0px 0px 0px",
                                        "alt": "",
                                        "href": "",
                                        "containerWidth": 600,
                                        "width": 600,
                                        "widthPercent": 100
                                    },
                                    "uid": "U9i-kVwYPP"
                                }],
                                "uid": "MNLN34cLjC"
                            }],
                            "layout": 1,
                            "backgroundColor": "",
                            "backgroundImage": "",
                            "paddingTop": 0,
                            "paddingBottom": 0,
                            "paddingLeft": 0,
                            "paddingRight": 0,
                            "uid": "het5d1wmU"
                        }, {
                            "tagName": "mj-section",
                            "attributes": {
                                "full-width": false,
                                "padding": "9px 0px 9px 0px",
                                "background-color": "#FFFFFF"
                            },
                            "type": null,
                            "children": [{
                                "tagName": "mj-column",
                                "attributes": {"width": "50%", "vertical-align": "top"},
                                "children": [{
                                    "tagName": "mj-image",
                                    "attributes": {
                                        "src": "https:\/\/storage.googleapis.com\/afuxova10642\/kisspng-perfume-oriflame-kosmetik-germany-eau-de-toilette-frasco-perfume-5b4024b76bcca8.0149129315309303594416.png",
                                        "padding": "0px 0px 0px 0px",
                                        "alt": "",
                                        "href": "",
                                        "containerWidth": 200,
                                        "width": 196,
                                        "widthPercent": 98
                                    },
                                    "uid": "82XkKokvQ"
                                }, {
                                    "tagName": "mj-text",
                                    "attributes": {
                                        "align": "center",
                                        "font-size": "11px",
                                        "padding": "0px 0px 0px 0px",
                                        "line-height": 1.5,
                                        "containerWidth": 200,
                                        "font-family": "Lato, \"Tahoma\", sans-serif"
                                    },
                                    "uid": "6WU1W9o0C",
                                    "content": "<p><span style=\"font-size:14px;\"><strong>WOMEN FRAGRANCE<\/strong><\/span><\/p>\n\n<p><span style=\"font-size:14px;\">Detailed description of the product<\/span><\/p>"
                                }, {
                                    "tagName": "mj-button",
                                    "attributes": {
                                        "align": "center",
                                        "background-color": "#000000",
                                        "color": "#fff",
                                        "border-radius": "none",
                                        "font-size": "12px",
                                        "padding": "0px 0px 5px 0px",
                                        "inner-padding": "8px 24px",
                                        "href": "https:\/\/google.com",
                                        "font-family": "Lato, \"Tahoma\", sans-serif",
                                        "containerWidth": 300,
                                        "border": "0px solid #000"
                                    },
                                    "content": "Buy now",
                                    "uid": "VnZ8ZYUU_"
                                }],
                                "uid": "VmObvtgeT"
                            }, {
                                "tagName": "mj-column",
                                "attributes": {"width": "50%", "vertical-align": "top"},
                                "children": [{
                                    "tagName": "mj-image",
                                    "attributes": {
                                        "src": "https:\/\/storage.googleapis.com\/afuxova10642\/kisspng-perfume-oriflame-kosmetik-germany-eau-de-toilette-frasco-perfume-5b4024b76bcca8.0149129315309303594416.png",
                                        "padding": "0px 0px 0px 0px",
                                        "alt": "",
                                        "href": "",
                                        "containerWidth": 200,
                                        "width": 196,
                                        "widthPercent": 98
                                    },
                                    "uid": "yBrNkLP5M"
                                }, {
                                    "tagName": "mj-text",
                                    "attributes": {
                                        "align": "center",
                                        "font-size": "11px",
                                        "padding": "0px 0px 0px 0px",
                                        "line-height": 1.5,
                                        "containerWidth": 200,
                                        "font-family": "Lato, \"Tahoma\", sans-serif"
                                    },
                                    "uid": "icX6V3Kyj",
                                    "content": "<p><span style=\"font-size:14px;\"><strong>WOMEN FRAGRANCE<\/strong><\/span><\/p>\n\n<p><span style=\"font-size:14px;\">Detailed description of the product<\/span><\/p>"
                                }, {
                                    "tagName": "mj-button",
                                    "attributes": {
                                        "align": "center",
                                        "background-color": "#000000",
                                        "color": "#fff",
                                        "border-radius": "none",
                                        "font-size": "12px",
                                        "padding": "0px 0px 5px 0px",
                                        "inner-padding": "8px 24px",
                                        "href": "https:\/\/google.com",
                                        "font-family": "Lato, \"Tahoma\", sans-serif",
                                        "containerWidth": 300,
                                        "border": "0px solid #000"
                                    },
                                    "content": "Buy now",
                                    "uid": "ESqSEv-4c"
                                }],
                                "uid": "tfdsrvTRBp"
                            }],
                            "layout": 1,
                            "backgroundColor": "",
                            "backgroundImage": "",
                            "paddingTop": 0,
                            "paddingBottom": 0,
                            "paddingLeft": 0,
                            "paddingRight": 0,
                            "uid": "zpnO-96Bb"
                        }, {
                            "tagName": "mj-section",
                            "attributes": {
                                "full-width": false,
                                "padding": "0px 0px 0px 0px",
                                "background-color": "#F0D5D5"
                            },
                            "type": null,
                            "children": [{
                                "tagName": "mj-column",
                                "attributes": {"width": "100%", "vertical-align": "top"},
                                "children": [{
                                    "tagName": "mj-image",
                                    "attributes": {
                                        "src": "https:\/\/storage.googleapis.com\/afuxova10642\/2020\/Jan\/Wed\/1578489556.png",
                                        "padding": "5px 0px 0px 0px",
                                        "alt": "",
                                        "href": "",
                                        "containerWidth": 600,
                                        "width": 600,
                                        "widthPercent": 100
                                    },
                                    "uid": "7qkMjmjVRT"
                                }],
                                "uid": "MNLN34cLjC"
                            }],
                            "layout": 1,
                            "backgroundColor": "",
                            "backgroundImage": "",
                            "paddingTop": 0,
                            "paddingBottom": 0,
                            "paddingLeft": 0,
                            "paddingRight": 0,
                            "uid": "3k7OHyRhH"
                        }, {
                            "tagName": "mj-section",
                            "attributes": {
                                "full-width": false,
                                "padding": "9px 0px 9px 0px",
                                "background-color": "#F0D5D5"
                            },
                            "type": null,
                            "children": [{
                                "tagName": "mj-column",
                                "attributes": {"width": "50%", "vertical-align": "top"},
                                "children": [{
                                    "tagName": "mj-image",
                                    "attributes": {
                                        "src": "https:\/\/storage.googleapis.com\/afuxova10642\/kisspng-perfume-oriflame-kosmetik-germany-eau-de-toilette-frasco-perfume-5b4024b76bcca8.0149129315309303594416.png",
                                        "padding": "0px 0px 0px 0px",
                                        "alt": "",
                                        "href": "",
                                        "containerWidth": 200,
                                        "width": 196,
                                        "widthPercent": 98
                                    },
                                    "uid": "P09L3IE5g"
                                }, {
                                    "tagName": "mj-text",
                                    "attributes": {
                                        "align": "center",
                                        "font-size": "11px",
                                        "padding": "0px 0px 0px 0px",
                                        "line-height": 1.5,
                                        "containerWidth": 200,
                                        "font-family": "Lato, \"Tahoma\", sans-serif"
                                    },
                                    "uid": "RAktcPtOc",
                                    "content": "<p><span style=\"font-size:14px;\"><strong>WOMEN FRAGRANCE<\/strong><\/span><\/p>\n\n<p><span style=\"font-size:14px;\">Detailed description of the product<\/span><\/p>"
                                }, {
                                    "tagName": "mj-button",
                                    "attributes": {
                                        "align": "center",
                                        "background-color": "#000000",
                                        "color": "#fff",
                                        "border-radius": "none",
                                        "font-size": "12px",
                                        "padding": "0px 0px 5px 0px",
                                        "inner-padding": "8px 24px",
                                        "href": "https:\/\/google.com",
                                        "font-family": "Lato, \"Tahoma\", sans-serif",
                                        "containerWidth": 300,
                                        "border": "0px solid #000"
                                    },
                                    "content": "Buy now",
                                    "uid": "ukUIwG8_a"
                                }],
                                "uid": "VmObvtgeT"
                            }, {
                                "tagName": "mj-column",
                                "attributes": {"width": "50%", "vertical-align": "top"},
                                "children": [{
                                    "tagName": "mj-image",
                                    "attributes": {
                                        "src": "https:\/\/storage.googleapis.com\/afuxova10642\/kisspng-perfume-oriflame-kosmetik-germany-eau-de-toilette-frasco-perfume-5b4024b76bcca8.0149129315309303594416.png",
                                        "padding": "0px 0px 0px 0px",
                                        "alt": "",
                                        "href": "",
                                        "containerWidth": 200,
                                        "width": 196,
                                        "widthPercent": 98
                                    },
                                    "uid": "q50sHFsL1"
                                }, {
                                    "tagName": "mj-text",
                                    "attributes": {
                                        "align": "center",
                                        "font-size": "11px",
                                        "padding": "0px 0px 0px 0px",
                                        "line-height": 1.5,
                                        "containerWidth": 200,
                                        "font-family": "Lato, \"Tahoma\", sans-serif"
                                    },
                                    "uid": "vpIOSuM76",
                                    "content": "<p><span style=\"font-size:14px;\"><strong>WOMEN FRAGRANCE<\/strong><\/span><\/p>\n\n<p><span style=\"font-size:14px;\">Detailed description of the product<\/span><\/p>"
                                }, {
                                    "tagName": "mj-button",
                                    "attributes": {
                                        "align": "center",
                                        "background-color": "#000000",
                                        "color": "#fff",
                                        "border-radius": "none",
                                        "font-size": "12px",
                                        "padding": "0px 0px 5px 0px",
                                        "inner-padding": "8px 24px",
                                        "href": "https:\/\/google.com",
                                        "font-family": "Lato, \"Tahoma\", sans-serif",
                                        "containerWidth": 300,
                                        "border": "0px solid #000"
                                    },
                                    "content": "Buy now",
                                    "uid": "LJq0QAJdZ"
                                }],
                                "uid": "tfdsrvTRBp"
                            }],
                            "layout": 1,
                            "backgroundColor": "",
                            "backgroundImage": "",
                            "paddingTop": 0,
                            "paddingBottom": 0,
                            "paddingLeft": 0,
                            "paddingRight": 0,
                            "uid": "z_gIV9YLF"
                        }, {
                            "tagName": "mj-section",
                            "attributes": {
                                "full-width": false,
                                "padding": "0px 0px 0px 0px",
                                "background-color": "#FFFFFF"
                            },
                            "type": null,
                            "children": [{
                                "tagName": "mj-column",
                                "attributes": {"width": "100%", "vertical-align": "top"},
                                "children": [{
                                    "tagName": "mj-image",
                                    "attributes": {
                                        "src": "https:\/\/storage.googleapis.com\/afuxova10642\/2020\/Jan\/Wed\/1578489556.png",
                                        "padding": "5px 0px 0px 0px",
                                        "alt": "",
                                        "href": "",
                                        "containerWidth": 600,
                                        "width": 600,
                                        "widthPercent": 100
                                    },
                                    "uid": "LoMlhY--vo"
                                }],
                                "uid": "MNLN34cLjC"
                            }],
                            "layout": 1,
                            "backgroundColor": "",
                            "backgroundImage": "",
                            "paddingTop": 0,
                            "paddingBottom": 0,
                            "paddingLeft": 0,
                            "paddingRight": 0,
                            "uid": "hfdsEv8tL"
                        }, {
                            "tagName": "mj-section",
                            "attributes": {
                                "full-width": false,
                                "padding": "9px 0px 9px 0px",
                                "background-color": "#FFFFFF"
                            },
                            "type": null,
                            "children": [{
                                "tagName": "mj-column",
                                "attributes": {"width": "50%", "vertical-align": "top"},
                                "children": [{
                                    "tagName": "mj-image",
                                    "attributes": {
                                        "src": "https:\/\/storage.googleapis.com\/afuxova10642\/2020\/Jan\/Fri\/1578660845.png",
                                        "padding": "0px 0px 0px 0px",
                                        "alt": "",
                                        "href": "",
                                        "containerWidth": 300,
                                        "width": 300,
                                        "widthPercent": 100
                                    },
                                    "uid": "H-b-BtyoR"
                                }],
                                "uid": "to_5Eej4p"
                            }, {
                                "tagName": "mj-column",
                                "attributes": {"width": "50%", "vertical-align": "top"},
                                "children": [{
                                    "tagName": "mj-text",
                                    "attributes": {
                                        "align": "center",
                                        "font-size": "11px",
                                        "padding": "0px 15px 0px 15px",
                                        "line-height": 1.5,
                                        "containerWidth": 300
                                    },
                                    "uid": "WOd0i6OLz",
                                    "content": "<p><em><strong><span style=\"font-size:46px;\">50 % SALE<\/span><\/strong><\/em><\/p>"
                                }, {
                                    "tagName": "mj-text",
                                    "attributes": {
                                        "align": "center",
                                        "font-size": "11px",
                                        "padding": "0px 0px 0px 0px",
                                        "line-height": 1.5,
                                        "containerWidth": 200,
                                        "font-family": "Lato, \"Tahoma\", sans-serif"
                                    },
                                    "uid": "eMjVBkWC_",
                                    "content": "<p><span style=\"font-size:14px;\"><strong>WOMEN FRAGRANCE<\/strong><\/span><\/p>"
                                }, {
                                    "tagName": "mj-image",
                                    "attributes": {
                                        "src": "https:\/\/storage.googleapis.com\/afuxova10642\/2020\/Jan\/Fri\/1578661085.png",
                                        "padding": "0px 0px 0px 0px",
                                        "alt": "",
                                        "href": "",
                                        "containerWidth": 200,
                                        "width": 196,
                                        "widthPercent": 98
                                    },
                                    "uid": "BlZuV8gY5"
                                }, {
                                    "tagName": "mj-button",
                                    "attributes": {
                                        "align": "center",
                                        "background-color": "#000000",
                                        "color": "#fff",
                                        "border-radius": "none",
                                        "font-size": "15px",
                                        "padding": "0px 0px 5px 0px",
                                        "inner-padding": "10px 30px",
                                        "href": "https:\/\/google.com",
                                        "font-family": "Lato, \"Tahoma\", sans-serif",
                                        "containerWidth": 300,
                                        "border": "0px solid #000"
                                    },
                                    "content": "ONLY FOR $20",
                                    "uid": "ldcI50mpU"
                                }],
                                "uid": "zkX3wgOncr"
                            }],
                            "layout": 1,
                            "backgroundColor": "",
                            "backgroundImage": "",
                            "paddingTop": 0,
                            "paddingBottom": 0,
                            "paddingLeft": 0,
                            "paddingRight": 0,
                            "uid": "hnuOymmL8"
                        }, {
                            "tagName": "mj-section",
                            "attributes": {
                                "full-width": false,
                                "padding": "9px 0px 9px 0px",
                                "background-color": "#D20005"
                            },
                            "type": null,
                            "children": [{
                                "tagName": "mj-column",
                                "attributes": {"width": "100%", "vertical-align": "top"},
                                "children": [{
                                    "tagName": "mj-text",
                                    "attributes": {
                                        "align": "center",
                                        "font-size": "11px",
                                        "padding": "0px 15px 0px 0px",
                                        "line-height": 1.5,
                                        "containerWidth": 600,
                                        "font-family": "Lato, \"Tahoma\", sans-serif"
                                    },
                                    "uid": "JBfEXpiEC",
                                    "content": "<p><span style=\"color:#ffffff;\"><strong><span style=\"font-size:14px;\">&nbsp;FOLLOW US<\/span><\/strong><\/span><\/p>"
                                }, {
                                    "tagName": "mj-social",
                                    "attributes": {
                                        "display": "facebook:url linkedin:url youtube:url instagram:url",
                                        "padding": "0px 7px 7px 7px",
                                        "text-mode": "false",
                                        "icon-size": "35px",
                                        "facebook-alt": "Sd\u00edlet",
                                        "twitter-href": "https:\/\/www.twitter.com\/PROFILE",
                                        "twitter-icon-color": "none",
                                        "twitter-alt": "",
                                        "google-href": "https:\/\/plus.google.com\/PROFILE",
                                        "google-icon-color": "none",
                                        "google-alt": "",
                                        "align": "center",
                                        "youtube-alt": "",
                                        "youtube-icon": "https:\/\/s3-eu-west-1.amazonaws.com\/ecomail-assets\/editor\/social-icos\/simplewhite\/youtube.png",
                                        "pinterest-icon-color": "none",
                                        "containerWidth": 600
                                    },
                                    "uid": "sp7BWfIgk",
                                    "children": [{
                                        "tagName": "mj-social-element",
                                        "attributes": {
                                            "name": "facebook",
                                            "href": "https:\/\/www.facebook.com\/PROFILE",
                                            "color": "none",
                                            "src": "https:\/\/s3-eu-west-1.amazonaws.com\/ecomail-assets\/editor\/social-icos\/simplewhite\/facebook.png",
                                            "background-color": "transparent"
                                        }
                                    }, {
                                        "tagName": "mj-social-element",
                                        "attributes": {
                                            "name": "linkedin",
                                            "color": "none",
                                            "src": "https:\/\/s3-eu-west-1.amazonaws.com\/ecomail-assets\/editor\/social-icos\/simplewhite\/linkedin.png",
                                            "background-color": "transparent"
                                        }
                                    }, {
                                        "tagName": "mj-social-element",
                                        "attributes": {
                                            "name": "youtube",
                                            "href": "https:\/\/www.youtube.com",
                                            "color": "none",
                                            "src": "https:\/\/s3-eu-west-1.amazonaws.com\/ecomail-assets\/editor\/social-icos\/simplewhite\/youtube.png",
                                            "background-color": "transparent"
                                        }
                                    }, {
                                        "tagName": "mj-social-element",
                                        "attributes": {
                                            "name": "instagram",
                                            "color": "none",
                                            "src": "https:\/\/s3-eu-west-1.amazonaws.com\/ecomail-assets\/editor\/social-icos\/simplewhite\/instagram.png",
                                            "background-color": "transparent"
                                        }
                                    }]
                                }],
                                "uid": "OrnwsRR6pm"
                            }],
                            "layout": 1,
                            "backgroundColor": "",
                            "backgroundImage": "",
                            "paddingTop": 0,
                            "paddingBottom": 0,
                            "paddingLeft": 0,
                            "paddingRight": 0,
                            "uid": "OiRz5m1F7"
                        }, {
                            "tagName": "mj-section",
                            "attributes": {
                                "full-width": false,
                                "padding": "0px 0px 0px 0px",
                                "background-color": "#FFFFFF"
                            },
                            "type": null,
                            "children": [{
                                "tagName": "mj-column",
                                "attributes": {"width": "100%", "vertical-align": "top"},
                                "children": [{
                                    "tagName": "mj-image",
                                    "attributes": {
                                        "src": "https:\/\/storage.googleapis.com\/afuxova10642\/lista_cervena-1.jpg",
                                        "padding": "0px 0px 0px 0px",
                                        "alt": "",
                                        "href": "",
                                        "containerWidth": 600,
                                        "width": 600,
                                        "widthPercent": 100
                                    },
                                    "uid": "dEWFcEHoF"
                                }],
                                "uid": "S0-FHYBzO"
                            }],
                            "layout": 1,
                            "backgroundColor": "",
                            "backgroundImage": "",
                            "paddingTop": 0,
                            "paddingBottom": 0,
                            "paddingLeft": 0,
                            "paddingRight": 0,
                            "uid": "UP2MwCr_g"
                        }, {
                            "tagName": "mj-section",
                            "attributes": {
                                "full-width": false,
                                "padding": "0px 0px 0px 0px",
                                "background-color": "#FFFFFF"
                            },
                            "type": null,
                            "children": [{
                                "tagName": "mj-column",
                                "attributes": {"width": "100%", "vertical-align": "top"},
                                "children": [{
                                    "tagName": "mj-image",
                                    "attributes": {
                                        "src": "https:\/\/storage.googleapis.com\/afuxova10642\/SPODEK.jpg",
                                        "padding": "0px 0px 0px 0px",
                                        "alt": "",
                                        "href": "",
                                        "containerWidth": 600,
                                        "width": 600,
                                        "widthPercent": 100
                                    },
                                    "uid": "yTa9eU9RJ"
                                }],
                                "uid": "HPvWtCmfY"
                            }],
                            "layout": 1,
                            "backgroundColor": "",
                            "backgroundImage": "",
                            "paddingTop": 0,
                            "paddingBottom": 0,
                            "paddingLeft": 0,
                            "paddingRight": 0,
                            "uid": "TWZCCdRdT"
                        }, {
                            "tagName": "mj-section",
                            "attributes": {
                                "full-width": false,
                                "padding": "0px 0px 0px 0px",
                                "background-color": "#D20005"
                            },
                            "type": null,
                            "children": [{
                                "tagName": "mj-column",
                                "attributes": {"width": "100%", "vertical-align": "top"},
                                "children": [{
                                    "tagName": "mj-text",
                                    "attributes": {
                                        "align": "center",
                                        "font-size": "11px",
                                        "padding": "0px 0px 0px 15px",
                                        "line-height": 1.5,
                                        "containerWidth": 600,
                                        "font-family": "Lato, \"Tahoma\", sans-serif"
                                    },
                                    "uid": "O2lFrgrhF",
                                    "content": "<p><span style=\"color:#ffffff;\">Please enter your address and contact me here.<\/span><\/p>\n\n<p><span style=\"color:#ffffff;\">Tell the recipient why they received the email and how they found it in your mailing list.<\/span><\/p>"
                                }],
                                "uid": "RDeGGyL6H_"
                            }],
                            "layout": 1,
                            "backgroundColor": "",
                            "backgroundImage": "",
                            "paddingTop": 0,
                            "paddingBottom": 0,
                            "paddingLeft": 0,
                            "paddingRight": 0,
                            "uid": "WmgJDuVIJ"
                        }, {
                            "tagName": "mj-section",
                            "attributes": {
                                "full-width": false,
                                "padding": "0px 0px 0px 0px",
                                "background-color": "#D20005"
                            },
                            "type": null,
                            "children": [{
                                "tagName": "mj-column",
                                "attributes": {"width": "100%", "vertical-align": "top"},
                                "children": [{
                                    "tagName": "mj-text",
                                    "attributes": {
                                        "align": "center",
                                        "font-size": "11px",
                                        "locked": "true",
                                        "editable": "true",
                                        "padding-bottom": "0",
                                        "padding-top": "0",
                                        "containerWidth": 600,
                                        "padding": "0px 4px 0px 0px",
                                        "font-family": "Lato, \"Tahoma\", sans-serif"
                                    },
                                    "content": "<p style=\"font-size: 11px;\"><span style=\"color:#ffffff;\">Don&#39;t want to subscribe to our emails anymore?&nbsp;&nbsp;<\/span><a href=\"*|UNSUB|*\" style=\"color: #000000;\">UNSUBSCRIBE<\/a><span style=\"color:#ffffff;\">.<\/span><\/p>",
                                    "uid": "VfwmIlO57"
                                }],
                                "uid": "9dM0_0TNDW"
                            }],
                            "layout": 1,
                            "backgroundColor": "",
                            "backgroundImage": "",
                            "paddingTop": 0,
                            "paddingBottom": 0,
                            "paddingLeft": 0,
                            "paddingRight": 0,
                            "uid": "JvKqlqs37"
                        }]
                    }],
                    "style": {
                        "h1": {"font-family": "Lato, \"Tahoma\", sans-serif"},
                        "h2": {"font-family": "Lato, \"Tahoma\", sans-serif"},
                        "h3": {"font-family": "Lato, \"Tahoma\", sans-serif"},
                        "p": {"font-family": "Lato, \"Tahoma\", sans-serif"}
                    },
                    "attributes": {
                        "mj-text": {"line-height": 1.5, "font-family": "Lato, \"Tahoma\", sans-serif"},
                        "mj-button": {"font-family": "Lato, \"Tahoma\", sans-serif"},
                        "mj-section": {"background-color": "#FFFFFF"}
                    },
                    "fonts": ["Lato, \"Tahoma\", sans-serif"]
                }
            )
        );
    </script>
@endsection
