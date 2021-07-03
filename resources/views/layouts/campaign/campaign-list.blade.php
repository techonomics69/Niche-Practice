@extends('index')

@section('pageTitle', 'Campaign List')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid dashboarbgtitle">
            <div class="dashboard-wrapper campaign-list">
                <div class="page-head">
                    <div class="row">
                        <div class="col-sm-6 col-xs-12 text-xs-center ">
{{--                            <h4 class="page-title">Email Campaigns <a class="page-help" href="javascript:void(0)">--}}
{{--                                    <i class="fa fa-question-circle-o" style="color: #7d8080;/* transform: scaleX(-1); */margin-right: 5px;"></i>--}}
{{--                                    <img class="help-info-image" src="{{ asset('public/images/information.png') }}" />--}}
{{--                                </a></h4>--}}
                            <h4 class="page-title">Email Campaigns</h4>
                        </div>
                        {{--<div class="col-md-6">--}}
                            {{--<div class="page-instructions">--}}
                                {{--<label>Page Instructions</label><a href="javascript:void(0);"><i class="fa fa-question-circle-o"></i></a>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        <div class="col-sm-6 col-xs-12 text-xs-center ">
                            <a href="{{ route('email-templates') }}" class="btn btn-primary btn-review-site">Create a Campaign</a>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">

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
                                               style="width: 100%;" role="grid" aria-describedby="t-email-campaigns_info">

                                            <thead>
                                            <tr style="height: 60px;" role="row">
                                                <th class="select-checkbox" rowspan="1" colspan="1" style="width: 25px;"></th>
                                                <th tabindex="0" aria-controls="customers-list" rowspan="1" colspan="1" style="width: 450px;">
                                                    <span>Campaign</span>
                                                </th>
                                                <th tabindex="0" aria-controls="" rowspan="1" colspan="1" style="width: 300px;">
                                                    <span>Metrics</span>
                                                </th>
                                                <th tabindex="0" aria-controls="" rowspan="1" colspan="1" style="width: 146px;">
                                                    <span data-trigger="hover" data-container="body" data-toggle="popover" data-placement="auto right" data-content="This is the phone number of the customer."></span>
                                                </th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                                @foreach($campaignList as $campaign)
                                                    <?php
                                                        $uid =  base64_encode('syx') .  base64_encode($campaign['id']);
                                                    ?>
                                                    <tr role="row" class="odd" data-customer-id="{{ $campaign['id'] }}">
                                                        {{--<td class="select-checkbox"></td>--}}
                                                        <td></td>

                                                        <td class="text-verticle-align">
                                                            <div class="email-column">
                                                                <h3>
                                                                    @if( empty($campaign['subject']) && empty($campaign['title']) )
                                                                        No Subject / Title
                                                                    @elseif( !empty($campaign['subject']) )
                                                                        {{ $campaign['subject'] }}
                                                                    @else
                                                                        {{ $campaign['title'] }}
                                                                    @endif
                                                                </h3>
                                                                @if($campaign['status'] == 'published')
                                                                    <p>Sent on {{ Date('F d, Y', strtotime($campaign['updated_at'])) }}</p>
                                                                @elseif($campaign['status'] == 'schedule')
                                                                    @if(!empty($campaign['template_status']))
                                                                        <p>Scheduled Job sent on {{ Date('F d, Y', strtotime($campaign['schedule_at'])) }}</p>
                                                                    @else
                                                                        <p>Scheduled for {{ Date('F d, Y g:i a', strtotime($campaign['schedule_at'])) }}</p>
                                                                    @endif
                                                                @else
                                                                    <p>Drafts</p>
                                                                @endif
                                                            </div>
                                                        </td>

                                                        <td class="text-verticle-align">
                                                            <div class="metrics-column">
                                                                <div class="row">
                                                                    <div class="col-sm-4 col-xs-6">
                                                                        <h3>
                                                                            <?php
                                                                            echo (!empty($campaign['delivered'])) ? $campaign['delivered'] : 0;
                                                                            ?>
                                                                        </h3>
                                                                        <label>SENT</label>
                                                                    </div>
                                                                    <div class="col-sm-4 col-xs-6">
                                                                        <h3>
                                                                            <?php
                                                                            echo (!empty($campaign['open'])) ? $campaign['open'] : 0;
                                                                            ?>
                                                                        </h3>
                                                                        <label>OPENED</label>
                                                                    </div>
                                                                    <div class="col-sm-4 col-xs-6">
                                                                        <h3>
                                                                            <?php
                                                                            echo (!empty($campaign['click'])) ? $campaign['click'] : 0;
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
                                                                    <a href="{{ route('email-builder', $uid) }}">
                                                                        <i class="fa fa-pencil"></i>
                                                                        <span>EDIT</span>
                                                                    </a>
                                                                </div>

                                                                <div class="btn-contain" style="margin-left: 25px;">
{{--                                                                    <a href="{{ route('email-preview', $campaign['id']) }}">--}}
                                                                    <a data-campaign-id="{{ $campaign['id'] }}" class="preview-template" href="javascript:void(0)">
                                                                        <i class="fa fa-search"></i>
                                                                        <span>PREVIEW</span>
                                                                    </a>
                                                                </div>
                                                                @if($campaign['status'] != 'published')
                                                                    <div class="btn-contain" style="margin-left: 25px;">
                                                                        <a href="javascript:void(0)" class="remove-me" data-campaign-status="{{ $campaign['status'] }}" data-target-id="{{ $campaign['id'] }}">
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
                        @else
                            <div class="email-campaign-new">
                                <div class="campaign-content1">
                                    <div class="text-center">
                                        <img style="width: 130px;"
                                             src="{{ asset('public/images/icons/emailcard.png') }}"/>
                                    </div>

                                    <h3 class="text-center" style="font-weight: bold;">You do not have any
                                        campaigns </h3>
{{--                                    <p class="once text-center ">Start a new campaign by clicking on the "Create a--}}
{{--                                        campaign" button at the top right of the screen.</p>--}}
                                    <p class="once text-center ">Create your first message by choosing one of our pre-made <br> templates or start from scratch.</p>
{{--                                    <div class="ondiv">--}}
{{--                                        <p class="on">1. Almost all marketing campaigns / checklists include unique--}}
{{--                                            email campaigns in your monthly strategy.</p>--}}
{{--                                        <a href="https://nichepractice.com/nichepractice/use-a-template-or-follow-a-campaign-checklist/" style="text-decoration: underline;" target="_blank">--}}
{{--                                            <p class="on">Use a Template or Follow a Campaign Checklist?</p>--}}
{{--                                        </a>--}}
{{--                                    </div>--}}
                                    <div class="todiv">
{{--                                        <p class="to">2. If you choose to send additional emails, outside of your--}}
{{--                                            marketing checklist, click the Create a <br--}}
{{--                                                class="d-lg-inline-block  d-none"> Campaign button and select/edit any--}}
{{--                                            of the emails in our portfolio.</p>--}}
                                        <a href="https://nichepractice.com/nichepractice/guide-to-creating-and-sending-an-email-campaign/" style="text-decoration: underline;" target="_blank">
                                            <p class="to">Guide to Creating and Sending an Email Campaign</p>
                                        </a>
                                    </div>
{{--                                    <div class="campaigns-link ">--}}
{{--                                        --}}{{--                                        <button class="btn btn-primary cont"  style="font-weight: 600;" > Continue </button>--}}
{{--                                        <a href="#"><p>Learn more about sending emails and your marketing strategy.</p>--}}
{{--                                        </a>--}}

{{--                                    </div>--}}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="template-modal" class="modal fade in modal-manager show-app-interface" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" style="display: none;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div><div class="modal-body"><div id="app" class="create steps-section" style=" width: 100%; height: 100vh; display: block;"></div></div>

                <form class="wizard-container" method="POST" action="#" id="js-wizard-form">


                </form>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        .campaigns-link a p{
            color: #1c339d;
            text-decoration: underline;
            font-size: 16px;
        }
        .campaign-content1{
            width: 720px;
            margin: auto;
        }
        .once{

            /*margin-left: 15%;*/
            margin-top: 10px;
            margin-bottom: 15px;
            color: #7B7C7E;

            font-size: 18px;
            /*font-family: 'Myraid';*/
        }
        /*.ondiv{*/
        /*    !*margin-left: 15%;*!*/
        /*    !*margin-right: 15%;*!*/
        /*    background-color: #FFFFFF;*/
        /*    color: #7b7c7e;*/

        /*    padding-left:5px;*/
        /*    border-left: 2px solid #565D7F;*/
        /*    font-size: 16px;*/
        /*}*/
        .on{
            padding: 8px;
            /*font-family: 'Myraid';*/
        }
        /*.todiv{*/
        /*    !*margin-left: 15%;*!*/
        /*    !*margin-right: 15%;*!*/
        /*    padding-left:5px;*/
        /*    background-color: #FFFFFF;*/
        /*    color: #7b7c7e;*/
        /*    border-left: 2px solid #565D7F;*/
        /*    font-size: 16px;*/
        /*}*/
        .to{
            padding: 8px;
        }
        .cont{
            background-color: #1D33A1;
            margin-top: 20px;
        }
        /*.btn-primary:hover{*/
        /*    background-color:#1b339d !important;*/
        /*}*/
        /*.btn-primary:active{*/
        /*    background-color:#1b339d !important;*/
        /*}*/
        /*.btn-primary:focus{*/
        /*    background-color:#1b339d !important;*/
        /*}*/
        .todiv{
            /*margin-left: 15%;*/
            /*margin-right: 15%;*/
            padding-left:5px;
            /*background-color: #FFFFFF;*/
            color: #7b7c7e;
            /*border-left: 2px solid #565D7F;*/
            font-size: 17px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .todiv:before{
            content: '';
            height: 5px;
            width: 5px;
            background-color: #1D33A1;
            border-radius: 100%;
            margin-bottom: 8px;
        }
        .ondiv{
            /*margin-left: 15%;*/
            /*margin-right: 15%;*/
            padding-left:5px;
            /*background-color: #FFFFFF;*/
            color: #7b7c7e;
            /*border-left: 2px solid #565D7F;*/
            font-size: 16px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .ondiv:before{
            content: '';
            height: 5px;
            width: 5px;
            background-color: #1D33A1;
            border-radius: 100%;
            margin-bottom: 8px;
        }
        @media screen and (max-width: 800px){
            .campaign-content1{
                width: auto;
            }
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

                        html +='<div class="modal-body"><div class="interface-module" style=""><div class="alert" style="display: none;"></div><div class="remove-business-modal"><div class="remove-action-note"><img src="'+baseUrl+'/public/images/delete-listing.png"> <h3 style="font-size: 22px;margin-bottom: 25px;font-weight: 400;color: #000;">Are you sure you want to remove Scheduled Campaign?</h3>' +
                            '<p style="color: #000;font-size: 15px;">Deleting scheduled campaign, Emails will not be sent to recipients.</p></div></div></div></div>';
                        html +='<div class="modal-footer"><button type="button" class="btn btn-default close-modal" data-dismiss="modal">Cancel</button><button type="button" class="btn btn-danger deleting-processed">Delete</button></div>';

                    mainModel.modal('show');
                    $(".modal-header").after(html);

                    return false;
                }

                deleteCampaign(currentTarget);
            });
        });

        $(document.body).on('hidden.bs.modal', '#main-modal', function ()
        {
            $(".modal-body, .modal-footer").remove();
        });

        $(document.body).on('click', '.deleting-processed', function() {
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

                if(statusCode == 200)
                {
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

                        if($("tbody tr").length == 1)
                        {
                            currentTarget.closest('tr').remove();
                            showPreloader();
                            // console.log("inside");
                            location.reload();
                        }
                        else {
                            currentTarget.closest('tr').remove();
                        }
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
@endsection
