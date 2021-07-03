@extends('admin.layout')

@section('title', 'Client info')

@section('content')
    <h1>Add New Client</h1>
    <div class="form">
        <form id="frmAddUser" method="post" action="">
            <input type="hidden" name="token" value="f683db270d6c846fce00f64f37690dc2667e8311">
            <div class="row">
                <div class="col-sm-12  col-md-6 col-lg-6 col-xl-6">
                    <table class="table-form" width="100%" border="0" cellpadding="3" cellspacing="2">
                        <tbody>
                        <tr>
                            <td width="15%" class="fieldlabel">First Name</td>
                            <td class="fieldarea">
                                <input type="text" class="form-control  input-250" name="firstname" value=""
                                       tabindex="1">
                            </td>
                        </tr>
                        <tr>
                            <td class="fieldlabel">Last Name</td>
                            <td class="fieldarea">
                                <input type="text" class="form-control input-250" name="lastname" value="" tabindex="2">
                            </td>
                        </tr>
                        <tr>
                            <td class="fieldlabel">Company Name</td>
                            <td class="fieldarea">
                                <input type="text" class="form-control  input-250 input-inline" name="companyname"
                                       value="" tabindex="3">
                            </td>
                        </tr>
                        <tr>
                            <td class="fieldlabel">Email Address</td>
                            <td class="fieldarea">
                                <input type="text" class="form-control  input-280" name="email" value="" tabindex="4">
                            </td>
                        </tr>
                        <tr>
                            <td class="fieldlabel">Password</td>
                            <td class="fieldarea">
                                <input type="text" class="form-control  input-150 input-inline" name="password"
                                       autocomplete="off" value=""
                                       onfocus="if(this.value=='Enter to Change')this.value=''" tabindex="5">
                            </td>
                        </tr>
                        <tr>
                            <td class="fieldlabel-1 form-field-hidden-on-respond" style="color:white"> empty</td>
                            <td class="fieldarea-1  form-field-hidden-on-respond">
                                <input type="text" class=" hidden-field" disabled value="" tabindex="4">
                            </td>
                        </tr>
                        <tr>
                            <td class="fieldlabel-1 form-field-hidden-on-respond" style="color:white"> empty</td>
                            <td class="fieldarea-1  form-field-hidden-on-respond">
                                <input type="text" class=" hidden-field" disabled value="" tabindex="4">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-12  col-md-6 col-lg-6 col-xl-6">
                    <table class="table-form" width="100%" border="0" cellpadding="3" cellspacing="2">
                        <tbody>
                        <tr>
                            <td class="fieldlabel" width="15%">Address 1</td>
                            <td class="fieldarea">
                                <input type="text" class="form-control  input-250" name="address1" value=""
                                       tabindex="8">
                            </td>
                        </tr>
                        <tr>
                            <td class="fieldlabel">Address 2</td>
                            <td class="fieldarea">
                                <input type="text" class="form-control  input-250 input-inline" name="address2" value=""
                                       tabindex="9">
                                <small style="color:#cccccc">(Optional)</small>
                        </tr>
                        <tr>
                            <td class="fieldlabel">City</td>
                            <td class="fieldarea">
                                <input type="text" class="form-control  input-250" name="city" value="" tabindex="10">
                            </td>
                        </tr>
                        <tr>
                            <td class="fieldlabel">State/Region</td>
                            <td class="fieldarea">
                                <input type="text" class="form-control  input-250" data-selectinlinedropdown="1"
                                       value="" tabindex="11" id="stateinput" style="display: none;">
                                <select name="state" class="form-control  select-inline input-200" id="stateselect"
                                        tabindex="11">
                                    <option value="">—</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="fieldlabel">Postcode</td>
                            <td class="fieldarea">
                                <input type="text" class="form-control  input-150" name="postcode" value=""
                                       tabindex="12">
                            </td>
                        </tr>
                        <tr>
                            <td class="fieldlabel">Country</td>
                            <td class="fieldarea">
                                <select name="country" class="form-control  select-inline-1 " tabindex="13">
                                    <option></option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="fieldlabel">Phone Number</td>
                            <td class="fieldarea">
                                <input type="text" class="form-control  input-200" name="phonenumber" value=""
                                       tabindex="14" autocomplete="off" id="phone">
                            </td>
                        </tr>
                        <tr>
                            <td class="fieldlabel">Payment Method</td>
                            <td class="fieldarea">
                                <select name="paymentmethod" class="form-control  select-inline input-200"
                                        tabindex="18">
                                    <option value="">Select to Change Default</option>
                                    <option value="paypal">PayPal</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="fieldlabel">Billing Contact</td>
                            <td class="fieldarea">
                                <select name="billingcid" class="form-control  select-inline input-130 " tabindex="19">
                                    <option value="0">Default</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="fieldlabel">Currency</td>
                            <td class="fieldarea">
                                <select name="currency" class="form-control  select-inline input-130  " tabindex="20">
                                    <option value="1" selected="">USD</option>
                                </select>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>

    </div>
    <div class="btn-container">
        <input type="submit" value="Add Client" class="btn btn-primary" tabindex="52">
    </div>
@endsection


@yield('css_before')

<link rel="stylesheet" href="{{asset('public/css/addClient.css')}}"/>
<link rel="stylesheet" href="{{ asset('public/admin/adminlte/plugins/build/css/intlTelInput.css') }}">
@yield('css_after')
@section('after_scripts')

    <script src="{{ asset('public/admin/adminlte/plugins/build/js/intlTelInput.js') }}"></script>

    <script src="{{ asset('public/admin/adminlte/plugins/build/js/intlTelInput-jquery.js') }}"></script>

    <script src="{{ asset('public/admin/adminlte/plugins/build/js/intlTelInput-jquery.min.js') }}"></script>
    <script src="{{ asset('public/admin/adminlte/plugins/build/js/utils.js') }}"></script>

    <script>


        var input = document.querySelector("#phone");
        window.intlTelInput(input, {
            utilsScript: "build/js/utils.js",
        });
    </script>

@endsection
