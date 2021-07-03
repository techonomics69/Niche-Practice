@extends('index')

@section('pageTitle', 'Promotion List')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid dashboarbgtitle">
            <div class="dashboard-wrapper campaign-list">
                <div class="page-head">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 text-xs-center">
                            <h4 class="page-title">Promotions
{{--                                <a class="page-help" href="javascript:void(0)">--}}
{{--                                    <i class="fa fa-question-circle-o" style="color: #7d8080;/* transform: scaleX(-1); */margin-right: 5px;"></i>--}}
{{--                                    <img class="help-info-image" src="{{ asset('public/images/information.png') }}" />--}}
{{--                                </a>--}}
                            </h4>
                        </div>
                        <div class="col-md-6 col-sm-6 text-xs-center">
                        <a href="{{ route('promotion-templates') }}" class="btn btn-primary btn-review-site">Create a Promotion</a>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">

                        @if(!empty($campaignList))
                            <div class="d-table">
                                <div class="table-responsive">
                                    <div id="t-email-campaigns_wrapper" class="dataTables_wrapper no-footer">
                                        <table id="t-email-campaigns" class="email-campaign dataTable no-footer"
                                               style="width: 100%;" role="grid" aria-describedby="t-email-campaigns_info">

                                            <thead>
                                            <tr style="height: 60px;" role="row">
                                                <th class="select-checkbox" rowspan="1" colspan="1" style="width: 25px;"></th>
                                                <th tabindex="0" aria-controls="customers-list" rowspan="1" colspan="1" style="width: 450px;">
                                                    <span>Name</span>
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
                                                                    <p>Published in queue</p>
                                                                @elseif($campaign['status'] == 'schedule')
                                                                    <p>Scheduled for {{ $campaign['schedule_at'] }}</p>
                                                                @else
{{--                                                                    <p>Drafts</p>--}}
                                                                @endif
                                                            </div>
                                                        </td>

                                                        <td class="text-verticle-align">
                                                            <div class="metrics-column">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <h3>0</h3>
                                                                        <label>SENT</label>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <h3>0</h3>
                                                                        <label>OPENED</label>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <h3>0</h3>
                                                                        <label>CLICKED</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>

                                                        <td class="text-verticle-align" style="width: 0px;">
                                                            <div class="action-buttons">
                                                                {{--<a href=""><img class="icon-view" src="assets/images/icons/pen.png"> </a>--}}
                                                                <div class="btn-contain">
                                                                    <a href="{{ route('image-builder', $uid) }}">
                                                                        <i class="fa fa-pencil"></i>
                                                                        <span>EDIT</span>
                                                                    </a>
                                                                </div>
                                                                <div class="btn-contain" style="margin-left: 25px;">
                                                                    <a href="javascript:void(0)" class="remove-me" data-target-id="{{ $campaign['id'] }}">
                                                                        <i class="fa fa-trash"></i>
                                                                        <span>Delete</span>
                                                                    </a>
                                                                </div>


{{--                                                                <div class="btn-contain" style="margin-left: 25px;">--}}
{{--                                                                    <a href="{{ route('email-preview', $campaign['id']) }}">--}}
{{--                                                                        <i class="fa fa-search"></i>--}}
{{--                                                                        <span>PREVIEW</span>--}}
{{--                                                                    </a>--}}
{{--                                                                </div>--}}
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
                            <div class="campaign-content">
                                <img src="{{ asset('public/images/promo.png') }}" style="width: 160px;">
                                <h3 style="font-weight: bold;"> You do not have any promotions</h3>
                                <p class="once text-center">Start a new promotion by clicking on the "Create a Promotion" button at the top right of the screen.</p>
                                  <div class="todiv">
                                      <a href="#" onclick="return false;" style="text-decoration: underline;" target="_blank">
                                        <p class="to">Why use promotions or special offers? </p>
                                      </a>
                                  </div>
                            </div>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
  <style>

    .once
      {
         margin-top:10px;
         margin-bottom:7px;
         color: #787C7E;
         font-size:18px;

      }
       .todiv
       {

          padding-left:5px;
          color: #7b7c7e;
          font-size: 17px;
          display: flex;
          justify-content: center;
          align-items: center;
       }
       .todiv:before
       {
        content: '';
        height: 5px;
         width: 5px;
         background-color: #1D33A1;
         border-radius: 100%;
         margin-bottom: 8px;
       }
       .to
       {
          padding: 8px;
       }
  </style>
@endsection

@section('js')
    <script type="text/javascript">
        var currentTarget;
        $(function () {
            $(".remove-me").click(function () {
                var status = $(this).attr("data-campaign-status");
                currentTarget = $(this);

                    var action = $(this).attr("data-action");
                    var baseUrl = $('#hfBaseUrl').val();

                    var mainModel = $('#main-modal');
                    $(".modal-body, .modal-footer, .validate-me", mainModel).remove();
                    $(mainModel).removeClass('welcome-process');
                    $(mainModel).addClass('modal-user-quit');

                    var html = '';

                    // console.log("currentTarget");
                    // console.log(currentTarget);

                    html +='<div class="modal-body"><div class="interface-module" style=""><div class="alert" style="display: none;"></div><div class="remove-business-modal"><div class="remove-action-note"><img src="'+baseUrl+'/public/images/delete-listing.png"> <h3 style="font-size: 22px;margin-bottom: 25px;font-weight: 400;color: #000;">Are you sure you want to remove this Promotion?</h3>' +
                        '<p style="color: #000;font-size: 15px;">Deleting promotion, this will be deleted from your account.</p></div></div></div></div>';
                    html +='<div class="modal-footer"><button type="button" class="btn btn-default close-modal" data-dismiss="modal">Cancel</button><button type="button" class="btn btn-danger deleting-processed">Delete</button></div>';

                    mainModel.modal('show');
                    $(".modal-header").after(html);

                    return false;


                // deleteCampaign(currentTarget);
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
                    send: 'delete-promotion',
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
    </script>
@endsection
