@extends('index')

@section('pageTitle', 'Campaign List')

@section('content')
    <div id="page-wrapper" class="page-welcome-box" style="min-height: 281px;">
        <div class="container-fluid dashboarbgtitle">
            <div class="dashboard-wrapper email-template-choosen">
                <div class="page-head">
                    <div class="row">
                        <div class="col-md-6">
                            {{--                            <h4 class="page-title"> Welcome new patients <a class="page-help" href="javascript:void(0)"><i class="fa fa-question-circle-o" style="color: #7d8080;/* transform: scaleX(-1); */margin-right: 5px;"></i></a>  </h4>--}}
                            <h4 class="page-title"> New Patient Package
                                {{--                                <a class="page-help" href="javascript:void(0)"><i class="fa fa-question-circle-o" style="color: #7d8080;/* transform: scaleX(-1); */margin-right: 5px;"></i></a> --}}
                            </h4>
                        </div>
{{--                        <div class="col-sm-6 col-xs-12 text-xs-center ">--}}
{{--                            <a href="{{ route('email-templates') }}" class="btn btn-primary btn-review-site">Create a--}}
{{--                                Campaign</a>--}}
{{--                        </div>--}}
                        {{--<div class="col-md-6">--}}
                        {{--<div class="page-instructions">--}}
                        {{--<label>Page Instructions</label><a href="javascript:void(0);"><i class="fa fa-question-circle-o"></i></a>--}}
                        {{--</div>--}}

                        {{--</div>--}}
                    </div>
                </div>

                <div class="email-campaign-new" style="display: block;">
                    <div class="campaign-content1">
                        <div class="text-center">
                            <img style="width: 130px;" src="{{ asset('public/images/icons/packages.png') }}"/>
                        </div>
                        <h3 class="text-center" style="font-weight: bold;"> You do not have any campaigns </h3>
                        <p class="once text-center ">Create your first message by choosing one of our pre-made <br>
                            templates or start from scratch.</p>
                        <div class="todiv">
                            <a href="#" onclick="return false;" style="text-decoration: underline;" target="_blank">
                                <p class="to">Guide to Creating and Sending an Email Campaign</p>
                            </a>
                        </div>

                        {{--                        <p class="once text-center">Once you get off the phone after scheduling a new patient appointment,instantly send them a beautifully <br class="d-lg-inline-block d-none">designed Welcome Package.</p>--}}

                        {{--            <p class="once text-center">once you get off the phone after scheduling a new patient appointment,instantly send them a beautifully <br class="d-lg-inline-block d-none">designed Welcome Package.</p>--}}

                        {{--                        <p class="once text-center">Once you get off the phone after scheduling a new patient appointment,instantly send them a beautifully. <br class="d-lg-inline-block d-none">designed Welcome Package.</p>--}}


                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="page-wrapper" class="page-after-page" style="display: none;">
        <div class="container-fluid dashboarbgtitle">
            <div class="dashboard-wrapper campaign-list">
                <div class="page-head">
                    <div class="row">
                        <div class="col-sm-6 col-xs-12 text-xs-center">
                            {{--                            <h4 class="page-title">Welcome New Patients <a class="page-help" href="javascript:void(0)">--}}
                            <h4 class="page-title">New Patient Package
                                {{--                                <a class="page-help" href="javascript:void(0)">--}}
                                {{--                                    --}}{{--                                    <i class="fa fa-question-circle-o" style="color: #7d8080;/* transform: scaleX(-1); */margin-right: 5px;"></i>--}}
                                {{--                                    <img class="help-info-image" src="{{ asset('public/images/information.png') }}" />--}}
                                {{--                                </a>--}}
                            </h4>
                        </div>
                        {{--<div class="col-md-6">--}}
                        {{--<div class="page-instructions">--}}
                        {{--<label>Page Instructions</label><a href="javascript:void(0);"><i class="fa fa-question-circle-o"></i></a>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        <div class="col-sm-6 col-xs-12 text-xs-center">
                            <div class="row">
                                {{--                                <div class="col-md-12 d-flex" style="justify-content: flex-end;align-items: center;">--}}
                                {{--                                    <div style="margin-right: 15px;">--}}
                                {{--                                        <a href="javascript:void(0)" class="btn-custom-campaign btn btn-primary btn-review-site">Custom Campaigns</a>--}}
                                {{--                                    </div>--}}
                                {{--                                    <div>--}}
                                {{--                                        <span class="text-right" style="font-size: 15px;font-weight: 700;margin-top: 7px;">5 Credits</span>--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}
                                {{--  <div class="col-md-3">
                                     <p class="text-right" style="font-size: 15px;font-weight: 700;margin-top: 7px;">5 Credits</p>
                                 </div> --}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">

                        <?php
                        $campaignEntity = New \Modules\Business\Entities\CampaignEntity();
                        $userId = $userData['id'];

                        if (strtolower($appEnvIs) == 'production') {
                            $category = 'patient_template_production';
                        } else {
                            $category = 'patient_template_staging';
                        }
                        ?>

                        @if(!empty($campaignList))
                            <div class="d-table">
                                {{--<div class="d-table-head">--}}
                                {{--<div class="row">--}}
                                {{--<div class="col-md-12">--}}
                                {{--<div class="form-group head-search-review">--}}
                                {{--<input type="text" class="form-control" placeholder="Search an Email Campaign">--}}
                                {{--</div>--}}
                                {{--</div>--}}

                                {{--</div>--}}
                                {{--</div>--}}

                                <div class="table-responsive">
                                    <div id="t-email-campaigns_wrapper" class="dataTables_wrapper no-footer">
                                        <table id="t-email-campaigns" class="email-campaign dataTable no-footer"
                                               style="width: 100%;border-top: 1px solid white;" role="grid"
                                               aria-describedby="t-email-campaigns_info">

                                            <thead>
                                            <tr style="height: 60px;" role="row">
                                                <th class="select-checkbox" rowspan="1" colspan="1"
                                                    style="width: 25px;"></th>
                                                <th tabindex="0" aria-controls="customers-list" rowspan="1" colspan="1"
                                                    style="width: 100px;">
                                                    <span>Sent</span>
                                                </th>
                                                <th tabindex="0" aria-controls="customers-list" rowspan="1" colspan="1"
                                                    style="width: 450px;">
                                                    <span>Campaign</span>
                                                </th>
                                                <th tabindex="0" aria-controls="" rowspan="1" colspan="1"
                                                    style="width: 300px;">
                                                    <span>Metrics</span>
                                                </th>
                                                <th tabindex="0" aria-controls="" rowspan="1" colspan="1"
                                                    style="width: 146px;">
                                                    <span data-trigger="hover" data-container="body"
                                                          data-toggle="popover" data-placement="auto right"
                                                          data-content="This is the phone number of the customer."></span>
                                                </th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @foreach($campaignList as $campaign)
                                                <?php
                                                //                                                        print_r($campaign);
                                                //                                                        exit;
                                                if (!empty($template_source) && $template_source == 'patient_email') {
//                                                            print_r($campaign->id);
//                                                            exit;

                                                    $campaignId = (!empty($campaign['id'])) ? $campaign['id'] : $campaign['parent_id'];
                                                    $campaignStatus = (!empty($campaign['status'])) ? $campaign['status'] : $campaign['child_status'];
                                                } else {
                                                    $campaignId = $campaign['id'];
                                                }

                                                $campaignEncryptId = base64_encode('syx') . base64_encode($campaignId);


                                                $tiedWIth = 'doctor' . $userId . 'patient_template' . $campaignId;
                                                $obj = \Modules\Business\Models\SendgridEventLogs::where(['tied_up_with' => $tiedWIth, 'category' => $category]);

                                                $obj1 = clone $obj;
                                                $obj2 = clone $obj;

                                                $open = $obj->where('event', 'open')->count();
                                                $delivered = $obj1->where('event', 'delivered')->count();
                                                $clicked = $obj2->where('event', 'click')->count();
                                                ?>
                                                <tr role="row" class="odd" data-customer-id="{{ $campaignId }}">
                                                    {{--<td class="select-checkbox"></td>--}}
                                                    <td></td>

                                                    <td>
                                                        @if(isset($campaign['date']) && $campaign['date'] == 0)
                                                            Immediately
                                                        @elseif(!empty($campaign['date']))
                                                            {{ $campaign['date'] }}
                                                        @endif

                                                        {{--                                                            @if( !empty($campaign['id']) )--}}
                                                        {{--                                                                @if($campaign['child_date'] == 0)--}}
                                                        {{--                                                                    Immediately--}}
                                                        {{--                                                                @else--}}
                                                        {{--                                                                    Day {{ $campaign['child_date'] }}--}}
                                                        {{--                                                                @endif--}}
                                                        {{--                                                            @else--}}
                                                        {{--                                                                @if($campaign['date'] == 0)--}}
                                                        {{--                                                                    Immediately--}}
                                                        {{--                                                                @else--}}
                                                        {{--                                                                    Day {{ $campaign['date'] }}--}}
                                                        {{--                                                                @endif--}}
                                                        {{--                                                            @endif--}}
                                                    </td>

                                                    <td class="text-verticle-align">
                                                        <div class="email-column">
                                                            <h3>
                                                                @if( empty($campaign['subject']) && empty($campaign['title']) )
                                                                    No Subject / Title
                                                                @elseif( !empty($campaign['subject']) )
                                                                    {{--                        {{ $campaign['subject'] }}--}}
                                                                    <?php
                                                                    echo $campaignEntity->extractTokenToValue($campaign['subject'], $businessRecord);
                                                                    ?>
                                                                @else
                                                                    {{ $campaign['title'] }}
                                                                @endif
                                                            </h3>
                                                            {{--                                                                @if($campaignStatus == 'published')--}}
                                                            {{--                                                                    <p>Published in queue</p>--}}
                                                            {{--                                                                @elseif($campaignStatus == 'schedule')--}}
                                                            {{--                                                                    <p>Scheduled for {{ $campaign['schedule_at'] }}</p>--}}
                                                            {{--                                                                @else--}}
                                                            {{--                                                                    <p>Drafts</p>--}}
                                                            {{--                                                                @endif--}}
                                                        </div>
                                                    </td>

                                                    <td class="text-verticle-align">
                                                        <div class="metrics-column">
                                                            <div class="row">
                                                                <div class="col-sm-4 col-xs-6">
                                                                    <h3>
                                                                        <?php
                                                                        echo (!empty($delivered)) ? $delivered : 0;
                                                                        ?>
                                                                    </h3>
                                                                    <label>SENT</label>
                                                                </div>
                                                                <div class="col-sm-4 col-xs-6">
                                                                    <h3>
                                                                        <?php
                                                                        echo (!empty($open)) ? $open : 0;
                                                                        ?>
                                                                    </h3>
                                                                    <label>OPENED</label>
                                                                </div>
                                                                <div class="col-sm-4 col-xs-6">
                                                                    <h3>
                                                                        <?php
                                                                        echo (!empty($click)) ? $click : 0;
                                                                        ?>
                                                                    </h3>
                                                                    <label>CLICKED</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td class="text-verticle-align" style="width: 0px;">
                                                        <div class="action-buttons">
                                                            {{--<a href=""><img class="icon-view" src="assets/images/icons/pen.png"> </a>--}}
                                                            <div class="btn-contain">
                                                                {{--                                                                <a href="{{ route('email-builder', $campaignId) . '?type_source=patient' }}">--}}
                                                                <a href="{{ route('email-builder', $campaignEncryptId) . '?type_source=patient' }}">
                                                                    <i class="fa fa-pencil"></i>
                                                                    <span>EDIT</span>
                                                                </a>
                                                            </div>

                                                            <div class="btn-contain" style="margin-left: 25px;">
                                                                {{--                    <a href="{{ route('email-preview', $campaignId) .'?type=patient_emails' }}">--}}
                                                                <a href="javascript:void(0)" class="preview-template"
                                                                   data-campaign-id="{{ $campaignId }}">
                                                                    <i class="fa fa-search"></i>
                                                                    <span>PREVIEW</span>
                                                                </a>
                                                            </div>
                                                            @if($campaign['status'] != 'published')
                                                                <div style="display: none;" class="btn-contain"
                                                                     style="margin-left: 25px;">
                                                                    <a href="javascript:void(0)" class="remove-me"
                                                                       data-campaign-status="{{ $campaign['status'] }}"
                                                                       data-target-id="{{ $campaignId }}">
                                                                        <i class="fa fa-trash"></i>
                                                                        <span>Delete</span>
                                                                    </a>
                                                                </div>
                                                            @endif

                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div style="display: none;">
                                <div class="row">
                                    <div class="col-sm-6 col-xs-8 text-xs-center">
                                        <h4 class="page-title">Email Performance</h4>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="d-table">
                                        <div class="table-responsive">
                                            <div id="t-new-email-campaigns-logs_wrapper"
                                                 class="dataTables_wrapper no-footer">
                                                <table id="t-email-campaigns" class="email-campaign dataTable no-footer"
                                                       style="width: 100%;" role="grid"
                                                       aria-describedby="t-email-campaigns_info">

                                                    <thead>
                                                    <tr style="height: 60px;" role="row">
                                                        <th tabindex="0" aria-controls="customers-list" rowspan="1"
                                                            colspan="1" style="width: 250px;">
                                                            <span>Name</span>
                                                        </th>
                                                        <th tabindex="0" aria-controls="customers-list" rowspan="1"
                                                            colspan="1" style="width: 450px;">
                                                            <span>Email</span>
                                                        </th>
                                                        <th tabindex="0" aria-controls="" rowspan="1" colspan="1"
                                                            style="width: 300px;">
                                                            <span>Email sent at</span>
                                                        </th>
                                                    </tr>
                                                    </thead>

                                                    <tbody>
                                                    @if(!empty($templateLogs))
                                                        @foreach($templateLogs as $campaign)
                                                            <?php
                                                            $toName = $campaign['name'];
                                                            $toEmail = $campaign['email'];
                                                            $sendCreated = $campaign['created_at'];
                                                            ?>
                                                            <tr role="row" class="odd">
                                                                <td>
                                                                    {{ $toName }}
                                                                </td>

                                                                <td class="text-verticle-align">
                                                                    <div class="email-column">
                                                                        {{ $toEmail }}
                                                                    </div>
                                                                </td>

                                                                <td>
                                                                    {{ $sendCreated }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <td colspan="3" style="text-align: center;">No email sent record
                                                            found.
                                                        </td>
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="email-campaign-new">
                                <div class="campaign-content1">
                                    <div class="text-center">
                                        <img style="width: 130px;" src="{{ asset('public/images/image1.png') }}"/>
                                    </div>

                                    <p class="once">Once you get off the phone after scheduling a new patient
                                        appointment, send them a Welcome
                                        Package <br class="d-lg-inline-block d-none">that provides a practice overview,
                                        the doctor’s bio, and the latest practice news.</p>
                                    <div class="ondiv">
                                        <p class="on">1.&nbsp;On the Dashboard, enter the patient’s name and email
                                            address then click “Send”</p></div>
                                    {--
                                    <div class="todiv"> --}
                                        {-- <p class="to">2.&nbsp; To edit or change your email content, click the
                                            “Continue” button below to be taken to your <br
                                                class="d-lg-inline-block  d-none"> email list. Select an email to edit
                                            then click Save.</p></div>
                                    --}
                                    {--
                                    <div class="text-center mt-3"> --}
                                        {--
                                        <button class="btn btn-primary cont" style="font-weight: 600;"> Continue
                                        </button>
                                        --}

                                        {--
                                    </div>
                                    --}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>


            </div>
        </div>
    </div>

    <div id="template-modal" class="modal fade in modal-manager show-app-interface" tabindex="-1" role="dialog"
         data-backdrop="static" data-keyboard="false" style="display: none;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div id="app" class="create steps-section"
                         style=" width: 100%; height: 100vh; display: block;"></div>
                </div>

                <form class="wizard-container" method="POST" action="#" id="js-wizard-form">


                </form>
            </div>
        </div>
    </div>

    {{--    mycode--}}

@endsection

@section('css')
    <style>
        .table-change-pad {
            padding: 0px 0 !important;
        }

        .campaign-content1 {
            width: 690px;
            margin: auto;
        }

        .once {
            /* margin-left: 15%; */
            margin-top: 10px;
            margin-bottom: 15px;
            color: #7B7C7E;
            font-size: 18px;
            /* font-family: 'Myraid'; */
        }

        .ondiv {
            /*margin-left: 15%;*/
            /*margin-right: 15%;*/
            background-color: #FFFFFF;
            color: #7b7c7e;

            padding-left: 5px;
            border-left: 2px solid #565D7F;
            font-size: 16px;
        }

        .on {
            padding: 8px;
            /*font-family: 'Myraid';*/
        }

        /
        /
        .todiv {
        / / /*margin-left: 15%;*/
        / / /*margin-right: 15%;*/
        / / padding-left: 5 px;
        / / background-color: #FFFFFF;
        / / color: #7b7c7e;
        / / / / border-left: 2 px solid #565D7F;
        / / font-size: 16 px;
        / /
        }

        .todiv {
            /*margin-left: 15%;*/
            /*margin-right: 15%;*/
            padding-left: 5px;
            /*background-color: #FFFFFF;*/
            color: #7b7c7e;
            /*border-left: 2px solid #565D7F;*/
            font-size: 17px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .todiv:before {
            content: '';
            height: 5px;
            width: 5px;
            background-color: #1D33A1;
            border-radius: 100%;
            margin-bottom: 8px;
        }

        .to {
            padding: 8px;
            /*font-family: 'Myraid';*/
        }

        .cont {
            background-color: #1D33A1;
            margin-top: 20px;
            /*font-family: 'Myraid';*/
        }

        .cont:hover {
            background-color: #1b339d !important;
        }

        .cont:active {
            background-color: #1b339d !important;
        }

        .cont:focus {
            background-color: #1b339d !important;
        }

        @media screen and (max-width: 800px) {
            .campaign-content1 {
                width: auto;
            }
        }

        .how-it-works {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .how-it-works:before {
            content: '';
            width: 5px;
            height: 5px;
            border-radius: 100%;
            background-color: #1b339d !important;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 3px;
            margin-right: 5px;
        }

    </style>
@endsection

@section('js')
    <script src="https://d5aoblv5p04cg.cloudfront.net/mjml4-editor/loader/build.js" type="text/javascript"></script>
    <script src="{{ asset('public/js/topol-manager.js?ver='.$appFileVersion) }}"></script>
    <script type="text/javascript">
        var currentTarget;
        $(function () {
            $(".remove-me").click(function () {
                var status = $(this).attr("data-campaign-status");
                currentTarget = $(this);

                if (status === 'schedule') {
                    var action = $(this).attr("data-action");
                    var baseUrl = $('#hfBaseUrl').val();

                    var mainModel = $('#main-modal');
                    $(".modal-body, .modal-footer, .validate-me", mainModel).remove();
                    $(mainModel).removeClass('welcome-process');
                    $(mainModel).addClass('modal-user-quit');

                    var html = '';

                    // console.log("currentTarget");
                    // console.log(currentTarget);

                    html += '<div class="modal-body"><div class="interface-module" style=""><div class="alert" style="display: none;"></div><div class="remove-business-modal"><div class="remove-action-note"><img src="' + baseUrl + '/public/images/delete-listing.png"> <h3 style="font-size: 22px;margin-bottom: 25px;font-weight: 400;color: #000;">Are you sure you want to remove Scheduled Campaign?</h3>' +
                        '<p style="color: #000;font-size: 15px;">Deleting scheduled campaign, Emails will not be sent to recipients.</p></div></div></div></div>';
                    html += '<div class="modal-footer"><button type="button" class="btn btn-default close-modal" data-dismiss="modal">Cancel</button><button type="button" class="btn btn-danger deleting-processed">Delete</button></div>';

                    mainModel.modal('show');
                    $(".modal-header").after(html);

                    return false;
                }

                deleteCampaign(currentTarget);
            });
        });

        $(document.body).on('hidden.bs.modal', '#main-modal', function () {
            $(".modal-body, .modal-footer").remove();
        });

        $(document.body).on('click', '.deleting-processed', function () {
            deleteCampaign(window.currentTarget);
        });

        function deleteCampaign(currentTarget) {
            // console.log("currentTarget");
            // console.log(currentTarget);
            var siteUrl = $('#hfBaseUrl').val();
            var template = currentTarget.attr('data-target-id');

            // console.log(template);

            showPreloader();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                type: "POST",
                url: siteUrl + "/done-me",
                data: {
                    send: 'delete-template',
                    id: template,
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

                hidePreloader();

                if (statusCode == 200) {
                    $(".close-modal").click();
                    // if($("tbody tr").length != 1)
                    // {
                    //     currentTarget.closest('tr').remove();
                    // }

                    // console.log("length ");
                    // console.log($("tbody tr").length);
                    swal({
                        title: "Success!",
                        text: statusMessage,
                        type: 'success'
                    }, function () {

                        if ($("tbody tr").length == 1) {
                            currentTarget.closest('tr').remove();
                            showPreloader();
                            // console.log("inside");
                            location.reload();
                        } else {
                            currentTarget.closest('tr').remove();
                        }
                    });
                } else {
                    swal({
                        title: "Error!",
                        text: statusMessage,
                        type: 'error'
                    }, function () {
                    });
                }
            });
        }

        // jQuery(document).ready(function($) {
        //     var table = $("#taskTable");
        //     table.on('click', 'tbody tr', function () {
        //         var target = $(this).attr('data-task');
        //         if(target) {
        //             var baseUrl = $('#adminBaseUrl').val();
        //             window.location.href = baseUrl + '/templates/email-template/' + target;
        //         }
        //     });
        // });
    </script>
    {{-- <script src="{{ asset('public/js/task/tabs-task.js?ver='.$appFileVersion) }}"></script> --}}
    <script>

        $(document.body).on('click', '.btn-custom-campaign', function () {
            var taskId = $(this).closest('.task-contain').attr('data-task-content');

            var mainModel = $('#main-modal');
            $(".modal-body, .modal-footer, .validate-me", mainModel).remove();
            $(mainModel).removeClass('welcome-process');
            $(mainModel).addClass('modal-task-order');

            var baseUrl = $('#hfBaseUrl').val();
            var credits = $('#task-credits').val();
            var taskTitle = $('.task-des-title').html();
            var orderDes = $('.task-learn-more-des').html();

            // console.log("credits of learn");
            // console.log(credits);

            var html = '<div class="modal-body">\n' +
                '                                <h3 class="modal-order-title p-b-10">' + 'DESIGN SERVICE' + '</h3>\n' +
                '                                <div>\n' +
                '                                   <div>' +
                '                                       <h4 style="font-weight: 500;">We will create an eye-catching and effective email newsletter consistent with your website and brand image.</h4>' +
                '                                       <ul>' +
                '                                           <li>2 Creative Design Concepts</li>' +
                '                                           <li>Unlimited Revisions of the Chosen Concept</li>' +
                '                                           <li>Design Revisions in 1 Business Day</li>' +
                '                                           <li>Creative Team of 4 Designers</li>' +
                '                                           <li>100% Original Design. No Copy-Cat</li>' +
                '                                       </ul>' +
                '                                   </div>' +
                '                                </div>\n' +
                '                                <div class="row order-credit-action">\n' +
                '                                   <button data-task-target="' + taskId + '" class="btn order-credit-now">Order Now - ' + 5 + ' Credits</button>\n' +
                '\n' +
                '                                </div>\n' +
                '                            </div>';

            mainModel.modal('show');

            $(".modal-task-order .modal-header").html('<span class="heading-credit">5 Credits</span><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>');
            $(".modal-task-order .modal-header").after(html);
        });


        $(document.body).on('click', '.order-credit-now', function () {
            var siteUrl = $('#hfBaseUrl').val();
            // var moduleId = $(this).attr('data-target-id');
            // var module = $(this).attr('data-module-credits-used');
            var module = 'new-patient-emails'
            var currentTarget = $(this);

            showPreloader();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                type: "POST",
                url: siteUrl + "/done-me",
                data: {
                    send: 'purchase-order',
                    module: module,
                    credits: 5
                    // moduleId: moduleId
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


                if (statusCode == 200) {
                    // var html = '<a href="'+siteUrl+'/email/'+moduleId+'" class="btn btn-template-edit">\n' +
                    //     '                                                                        Edit\n' +
                    //     '                                                                    </a>';
                    // currentTarget.after(html);
                    // currentTarget.remove();

                    // if(isEmptyValNormal(data.creditsBalance) == false)
                    // {
                    // console.log("inside check val");
                    //     $(".sidebar-available-credits h1").html(data.creditsBalance);
                    // }
                    var mainModel = $('#main-modal');
                    mainModel.modal('hide');
                    hidePreloader();
                    swal({
                        title: "Success!",
                        text: statusMessage,
                        type: 'success'
                    }, function () {
                    });
                } else if (statusCode == 404) {
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
                            '                                            <p>' + statusMessage + '</p>\n' +
                            '                                        </div>\n' +
                            '                                        <div class="row order-credit-actio p-t-15 p-b-10 text-center">\n' +
                            '                                            <a href="' + siteUrl + '/credits" class="btn add-credit-now p-r-5">Add More Credits</a>\n' +
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
                        $('.heading-credit').hide();
                        hidePreloader();
                        mainModel.modal('show');
                    }, 1000);
                } else {
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
        $(document.body).on('hidden.bs.modal', '.modal-task-order, .modal-alert-credit', function () {
            // console.log("hide");
            var mainModel = $('#main-modal');
            // var mainModel = $('.modal-task-order');

            $(mainModel).removeClass('modal-task-order modal-alert-credit');
            $(".modal-header i", mainModel).remove();
            $(".heading-credit", mainModel).remove();
            $(".modal-body, .modal-footer, .validate-me", mainModel).remove();
        });

        $(document.body).on('click', '.order-credit-cancel', function () {
            var mainModel = $('.modal-alert-credit');
            mainModel.modal('hide');
            html = '';
        });
        $(document).ready(function () {
            $('#continueBtn').click(function () {
                $('.page-welcome-box').hide();
                $('.page-after-page').show();
            });
        });
    </script>
@endsection

