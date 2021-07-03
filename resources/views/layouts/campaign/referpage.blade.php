@extends('index')

@section('pageTitle', 'Automated Emails')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid dashboarbgtitle">
            <div class="dashboard-wrapper campaign-list">
                <div class="page-head">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12 text-xs-center">
                            <h4 class="page-title text-center ">
{{--                                Love Nichepractice? Refer a Colleague and Earn Free Credits!--}}
                                Refer a Colleague and Earn Free Credits!
{{--                                refer-heading--}}
{{--                                <a class="page-help" href="javascript:void(0)"><i class="fa fa-question-circle-o" style="color: #7d8080;/* transform: scaleX(-1); */margin-right: 5px;"></i></a>--}}
                            </h4>
                        </div>
{{--                        <div class="col-sm-12 col-xs-12 text-xs-center">--}}
{{--                            <p class="page-title text-center refer-second-heading">Refer 5 colleagues to earn 10 credits-enough to download some of our most popular plans</p>--}}
{{--                        </div>--}}

                    </div>
                </div>


                <div class="row">
                    {{-- @if (!empty($referalemail)) --}}


                    {{-- @endif --}}
                    <div class="col-sm-12 text-center m-t-15 m-b-15 refer-frequently">
                        <h1>How it works</h1>
                    </div>
                    <div class="refer-box">
                        <div class="col-md-4 col-sm-12 col-xs-12 col-lg-offset-2 col-md-offset-2 ">
                            <div class="card refer-card" style="margin-bottom: 0px;">
                                <div class="card-body">
                                    <h5 class="card-title refer-card-title m-t-15">Free Trial Account</h5>
                                    <p class="card-text refer-card-des">Refer 5 colleagues to earn 10 credits-enough to downland some of our most popular pro-services. There's no limit to the number of doctors you refer.**</p>
                                </div>
                            </div>
                        </div>
                        <div class=" col-md-4 col-sm-12 col-xs-12 ">
                            <div class="card refer-card" style="margin-bottom: 0px;">
                                <div class="card-body">
                                    <h5 class="card-title refer-card-title ">Paid Subscribers</h5>
                                    <p class="card-text refer-card-des">For every doctor who subscribes to nichepractice for at least 30 days, you'll get 50 free credits to be applied to marketing pro services.</p>
                                </div>
                            </div>
                        </div>
                    </div>


                    </div>
                <div class="col-sm-12 col-xs-12 text-xs-center text-center  create-referral-btton ">
                    <button class="btn btn-primary  refer-btn" data-toggle="modal" data-target="#referalemailModal">Invite by email</button>
                    <!-- Button trigger modal -->


                    <!-- Modal -->
                    <form id="referalemailform">

                        <div class="modal fade" id="referalemailModal" tabindex="-1" role="dialog" aria-labelledby="referalemailModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="referalemailModalLabel">Create Referral</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <!-- <span aria-hidden="true">&times;</span> -->
                                            <!-- <i class="fa fa-times"></i> -->
                                            <svg class="bi bi-x" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M11.854 4.146a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708-.708l7-7a.5.5 0 0 1 .708 0z"/>
                                                <path fill-rule="evenodd" d="M4.146 4.146a.5.5 0 0 0 0 .708l7 7a.5.5 0 0 0 .708-.708l-7-7a.5.5 0 0 0-.708 0z"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <hr>
                                    <div class="modal-body">
                                        <p class="refer-popup-p">Enter the email address of the person you would like to refer.</p>
                                        <!-- <input type="email" name="referalemail" id="referalemail" class="form-control"> -->
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <!-- <span class="glyphicon glyphicon-envelope"></span> -->
                                                <i class="fa fa-envelope mail-popup "></i>
                                            </div>
                                            <input class="form-control" placeholder="Email Address" id="referalemail" name="email" type="email"/>
                                        </div>
                                    </div>

                                    <hr>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary popup-button ">Create</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
                <div class=" text-center col-md-8 col-lg-offset-2 col-md-offset-2  " style="padding: 0px; padding-bottom: 60px;" >
                    <p class="refer-box-bottom-p" style="color: #959597;">{{--**Referrals must use corporate email addresses (no free email address like gmail.com or yahoo.com) and be associated with a medical or dental practice.--}}</p>
                </div>
                    <div>
                        <div id="referals_table" style="display: block;">
                            <div>
                                <h3 class="m-l-20 col-md-12 refer-table-referrals">Referrals</h3>
                            </div>
                            <table id="referal_list" class="table table-bordered refer-table m-l-20" style="background-color: white">
                                <thead>
                                <tr>
                                    <th scope="col" class="text-center refer-table-heading">Joined</th>
                                    <th scope="col " class="refer-table-heading">Email</th>
                                    <th scope="col" class="refer-table-heading">Referred Date/Time</th>
                                    <th scope="col" class="text-center refer-table-heading">Send Email</th>
                                    <th scope="col" class="refer-table-heading">Referral Status</th>
                                </tr>
                                </thead>
                                <tbody>

                                    @forelse ($referalemail as $referalemailitem)
                                    <tr>
                                        <td>
                                            @if( $referalemailitem['onboarding_status'] == 1 )

                                                <div class="input-container text-center">
                                                    <input type="checkbox" value="1" name="" style="visibility: hidden" checked disabled/>
                                                    <label for="customCheckboxInput"></label>
                                                    <span style="margin-left: 5px">Joined</span>
                                                </div>
                                            @else
                                                <div class="checkbox text-center" style="margin-top: 0">
                                                    <label><input type="checkbox" value="1">Not Joined</label>
                                                </div>
                                                {{--                                                <div class="checkbox ">--}}
                                                {{--                                                    <label><input type="checkbox" value="0" checked>Not Joined</label>--}}
                                                {{--                                                </div>--}}
                                            @endif
                                        </td>
                                        <th scope="row">{{ $referalemailitem['email'] }}</th>

                                        <td>{{ date_format(date_create($referalemailitem['created_at']), "Y-m-d H:i") }}</td>
                                        <td class="text-center"><i class="fa fa-envelope" aria-hidden="true"></i></td>
                                        <td>
                                            @if( $referalemailitem['onboarding_status'] == 1 )
                                            <p>Referral Registered Successfully.</p>
                                            @else
                                            <p>Referral not Registered Yet.</p>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                        <tr id="empty-message-row">
                                            <td colspan="5" style="text-align: center;">
                                                You have not invited any of your friend till now.
                                            </td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>

            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>

        .input-container {
            margin-bottom: 10px;
            margin-top: -20px;
        }
        .input-container label {
            position: relative;
        }
        .input-container label::after {
            content: "";
            /*position: absolute;*/
            /*cover the default input */
            /*top: -32px;*/
            /*left: 20px;*/
            width: 20px;
            height: 20px;
            border-radius: 3px;
            background-color: #3D4B9E;
            border: 1px solid black;
            transform: rotate(0);
            pointer-events: none;
            text-align: center;
            color: #FFF;
            padding: 0 4px;
            /* easier to see in demo */
        }
        .input-container input[type=checkbox]:checked+label:after {
            content: "\2713";
        }

        @media screen and (max-width: 1463px){
            .refer-box-bottom-p{
                font-size: 12px;
            }
        }
        @media screen and (max-width: 1440px){
            .refer-box-bottom-p{
                font-size: 11px;
            }
        }
        @media screen and (max-width: 1280px){
            .refer-box-bottom-p{
                font-size: 10px;
            }
        }
        @media screen and (max-width: 1200px){
            .refer-box-bottom-p{
                font-size: 9px;
            }
        }
    </style>

@endsection

@section('js')
<script>
    $(document).ready(function () {
        $('#referalemailform').submit(function (event) {
            event.preventDefault();
            var referalemail = $('#referalemail').val();
            var token = $('input[name="_token"]').val();
            showPreloader();
            $.post("{{ route('referalemail.store') }}",{
                '_token': token,
                'email': referalemail,
            }).done(function (data) {
                console.log(data);
                hidePreloader();
                $('#referalemailModal').modal('hide');
                $('#referals_table').show();
                // $( "referalemailModal" ).removeClass( "in");
                $('#empty-message-row').hide();
                $('#referal_list').append(
                    '<tr>'+
                        '<td>'+
                            '<div class="checkbox text-center" style="margin-top: 0">'+
                                '<label><input type="checkbox" value="1">Not Joined</label>'+
                            '</div>'+
                        ' </td>'+
                        '<th scope="row">'+data.email+'</th>'+
                        '<td>'+data.created_at+'</td>'+
                        '<td class="text-center"><i class="fa fa-envelope" aria-hidden="true"></i></td>'+
                        '<td> Request Sent </td>'+
                        '</tr>'
                        );
                        $('#referalemail').val('');

                    swal({
                            title: "SUCCESS",
                            text: 'Referral invitation has been sent.',
                            type: 'success'
                        }, function () {
                        });

            }).fail(function (error) {
                // console.error(error);
                hidePreloader();
                // console.log(error.responseJSON.errors.email[0]);

                swal({
                        title: "OOPS !",
                        text: error.responseJSON.errors.email[0],
                        type: 'error'
                    }, function () {
                    });

            });
         });
    });
</script>
@endsection
