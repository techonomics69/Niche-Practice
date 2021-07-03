@extends('index')

@section('pageTitle', 'User Profile')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid dashboarbgtitle">
            <div class="dashboard-wrapper user-profile-wrapper">
                <div class="page-head">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="page-title">User Profile</h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="business-p-wrapper">
                            <div class="your-profile">
                                <div class="row">

                                    <div class="col-md-3">
                                        <h3 class="b-p-title">Your Profile</h3>
                                        <p class="b-p-desc">Manage your account settings here.</p>

                                    </div>

                                    <div class="col-md-9">
                                        <form class="validate-me">
                                            <div class="data-fields">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>First Name</label>
                                                        <input type="text" class="form-control" id="first_name" value="{{ $userData['first_name'] }}" data-required="true">
                                                        <span class="help-block hide-me"><small></small></span>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label>Last Name</label>
                                                        <input type="text" class="form-control" id="last_name" value="{{ $userData['last_name'] }}" data-required="true">
                                                        <span class="help-block hide-me"><small></small></span>
                                                    </div>
                                                </div>
                                                <div class="row m-t-20">
                                                    <div class="col-md-6">
                                                        <label>Email Address</label>
                                                        <input type="text" class="form-control" value="{{ $userData['email'] }}" disabled>

                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Phone Number</label>
                                                        <input type="text" class="form-control" id="phone" value="{{ $userData['business'][0]['phone'] }}" data-required="true">
                                                        <span class="help-block hide-me"><small></small></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="fields-footer">
                                                <button type="submit" class="btn btn-save" data-type="user_save" data-form-status="">Save</button>
                                                <span class="alert m-t-10" style="display: none;"></span>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            {{--<hr class="separator">--}}
                            {{--<form class="validate-pass">--}}
                            {{--<div class="change-password">--}}
                            {{--<div class="row">--}}
                            {{--<div class="col-md-3">--}}
                            {{--<h3 class="b-p-title">Change Password</h3>--}}
                            {{--<p class="b-p-desc">Chnage your Password often to keep your account secure.</p>--}}
                            {{--</div>--}}
                            {{--<div class="col-md-9">--}}
                            {{--<div class="data-fields">--}}
                            {{--<div class="row">--}}

                            {{--<div class="col-md-6">--}}
                            {{--<label>Current Password</label>--}}
                            {{--<input type="text" id="cu" value="current" class="form-control"  placeholder="">--}}

                            {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="row">--}}
                            {{--<div class="col-md-6">--}}
                            {{--<label>New Password</label>--}}
                            {{--<input type="text" id="ab" value="New" class="form-control"  placeholder="">--}}
                            {{--<input type="text" class="form-control" placeholder="">--}}

                            {{--</div>--}}
                            {{--<div class="col-md-6">--}}

                            {{--</div>--}}

                            {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="fields-footer">--}}
                            {{--<a href="#">--}}
                            {{--<button type="submit" class="btn btn-save" data-form-status="">Save</button>--}}
                            {{--</a>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</form>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
@endsection

@section('js')
    <script>

        checkFormStatus('validate-me');

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

//                console.log("tmp " + ID);
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

        // $("form.validate-me").submit(function(e)
        $(document.body).on('submit', 'form.validate-me', function(e)
        {
            // console.log("clicked B");
            // return false;

            if(!errorFound)
            {
                var formStatus = $("form.validate-me .btn-save").attr("data-form-status");
                var alert = $(".alert");
                alert.hide();
                alert.removeClass('error');


                if(formStatus == 1)
                {
                    var baseUrl = $("#hfBaseUrl").val();

                    var $this = showLoaderButton("form.validate-me .btn-save", "Saving");
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
                            phone: $("#phone").val()
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
                            $("form.validate-me .btn-save").attr("data-form-status", '');
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
        });
    </script>
@endsection
