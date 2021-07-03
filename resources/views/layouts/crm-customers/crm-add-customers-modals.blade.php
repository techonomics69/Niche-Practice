<?php
    $HowtoSendReviewRequestsTooltip = '';
    $smartRoutingTooltip = '';

$requestedUrl = Request::url();
?>

@if(!($requestedUrl == route('home')))
<div class="modal fade add-contact-step1" id="addCustomerStep1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="st-1-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="heading">Add Contact Details</h3>
                    </div>
                    <div class="col-sm-6">
                        <div class="steps-nav-right <?php echo  strtolower($enable_get_reviews)=='enabled'? '': 'hide';?>" >
                            <ul>
                                <li class="completed">
                                    <div class="stip active"></div>
                                    <h4>1: Contact Details</h4>
                                </li>

                                <li class="">
                                    <div class="stip"></div>
                                    <h4>2: Review Request</h4>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tip-label <?php echo  strtolower($enable_get_reviews)=='enabled'? 'hide': '';?>">
                    {{--<i class="fa fa-lightbulb-o"></i><label>Tip: Increase your Reviews and Rating by sending review requests. <a href="{{ route('crm-customers-settings') }}">Click here to enable</a></label>--}}
                    {{-- <i class="fa fa-lightbulb-o"></i><label>Tip: Increase your Reviews and Rating by sending review requests.</label> --}}
                </div>
            </div>

            <div class="modal-body">
                <div class="" id="">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputName2">First Name</label>
                                <input type="text" class="form-control" id="first_name" autocomplete="new-first-name" placeholder="Enter First Name Here">
                                <span class="help-block hide-me"><small></small></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputName2">Last Name</label>
                                <input type="text" class="form-control" id="last_name" autocomplete="new-last-name" placeholder="Enter Last Name Here">
                                <span class="help-block hide-me"><small></small></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail2">Email</label>
                                <input type="email" class="form-control" id="email" autocomplete="new-email" placeholder="Enter Email Here">
                                <span class="help-block hide-me"><small></small></span>
                            </div>
                        </div>
                        {{-- <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputName2">Country</label>

                                <select id="countryList" autocomplete="new-country" title="Select Country"
                                    class="form-control" data-style="btn btn-white">
                                    @if(isset($countryCodes))
                                    @foreach($countryCodes as $countryCode)
                                    <option data-dial-code="{{ str_replace("+","",$countryCode['phonecode']) }}">
                                        {{$countryCode['name']}}
                                    </option>
                                    @endforeach
                                    @endif
                                </select>

                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group country-code">
                                <label for="exampleInputName2">Code</label>
                                <select id="countryCodesList" title=" " class="form-control" disabled
                                    data-style="btn btn-white">
                                    @if(isset($countryCodes))
                                    @foreach($countryCodes as $countryCode)
                                    <option>
                                        {{ str_replace("+","",$countryCode['phonecode']) }}
                                    </option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div> --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Phone Number</label>
                                <input type="text" class="form-control" id="phone_number" autocomplete="new-phone-number" placeholder="Enter Phone Number Here">
                                <span class="help-block hide-me"><small></small></span>
                            </div>
                        </div>
                    </div>
                </div>

                <span class="error_Msg help-block hide-me"><small></small></span>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-xs-6">
                        <button type="button" class="btn btn-cancel closeAddSingleCustomerStep1" >Cancel</button>

                    </div>
                    <div class="col-xs-6">
                        <button id="add-single-customer-next-step" type="button" class="btn btn-save"><?php echo  strtolower($enable_get_reviews)=='enabled'? 'Next Step': 'Save';?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<div class="modal fade add-contact-step1" id="addCustomerStep2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div id="smsSettingModalHeading" class="smsSettingModalHeading ">
                    <h2>Confirm Your Invite Message</h2>
                </div>
                <button type="button" class="close closeAddCustomerStep2">&times;</button>
            </div>
            <div class="st-1-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="heading">Customize Review Requests</h3>
                    </div>
                    <div class="col-sm-6">
                        <div class="steps-nav-right">
                            <ul>
                                <li class="completed">
                                    <div class="stip"></div>
                                    <h4>1: Contact Details</h4>
                                </li>

                                <li class="">
                                    <div class="stip active"></div>
                                    <h4>2: Review Request</h4>
                                </li>

                            </ul>
                        </div>
                    </div>

                </div>
            </div>
            <div class="st-2-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="heading">Customize Review Requests</h3>
                    </div>
                    <div class="col-sm-6">
                        <div class="steps-nav-right">
                            <ul>
                                <li class="completed">
                                    <div class="stip"></div>
                                    <h4>1: Download</h4>
                                </li>

                                <li class="">
                                    <div class="stip"></div>
                                    <h4>2: Contacts</h4>
                                </li>
                                <li class="">
                                    <div class="stip "></div>
                                    <h4>3: Upload</h4>
                                </li>
                                <li class="review-nav-step">
                                    <div class="stip active"></div>
                                    <h4>4: Review</h4>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
            <div class="st-3-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="heading">Customize Review Requests</h3>
                    </div>
                    <div class="col-sm-6">

                    </div>

                </div>
            </div>

            <div class="modal-body">
                <div class="">

                    <div style="display: none;" class="row">
                        <div style="display: none;" class="col-md-6">
                            <div id="enable_get_reviews_panel" class="form-group crm-customers-settings-panel">
                                <label for="">Send Review Requests</label>
                                <a class="page-help" href="javascript:void(0)"><i class="fa fa-question-circle-o" style="color: #7d8080;/* transform: scaleX(-1); */margin-right: 5px;"></i></a>
                                {{-- <span class="send_review_requests_tooltip crm_tooltip hide"><i class="crm_tooltip mdi mdi-information-outline"></i></span> --}}
                                <select class="form-control selectpicker" id="enable_get_reviews" data-width="100%" data-style="form-control">
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div id="sending_option_panel" class="form-group crm-customers-settings-panel hide">
                                <label for="">How to Send Review Requests</label>
                                <a class="page-help" href="javascript:void(0)" data-module="how_to_send_review_requests"><i class="fa fa-question-circle-o" style="color: #7d8080;/* transform: scaleX(-1); */margin-right: 5px;"></i></a>
                                {{--  --}}
                                <select class="form-control selectpicker" id="sending_option" data-width="100%" data-style="form-control">
                                    <option value="1">Email Only</option>
                                    <option value="2">SMS Only</option>
                                    {{-- <option value="3">Email Only</option>
                                    <option value="4">SMS Only</option> --}}
                                    <option value="5">Email & SMS</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div style="display: none;" class="row">
                        <div class="col-md-6">
                            <div id="smart_routing_panel" class="form-group crm-customers-settings-panel hide">
                                <label for="">Smart Routing </label>
                                <a class="page-help" href="javascript:void(0)" data-module="smart_routing"><i class="fa fa-question-circle-o" style="color: #7d8080;/* transform: scaleX(-1); */margin-right: 5px;"></i></a>
                                <select id="smart_routing" class="form-control selectpicker" data-style="form-control" >
                                    <option>Enable</option>
                                    <option>Disable</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div id="send_reminder_panel" class="form-group crm-customers-settings-panel hide">
                                <label for="">Send Reminder</label>
                                <a class="page-help" href="javascript:void(0)" data-module="send_reminder"><i class="fa fa-question-circle-o" style="color: #7d8080;/* transform: scaleX(-1); */margin-right: 5px;"></i></a>
                                <span class="send_reminder_tooltip crm_tooltip hide"><i class="crm_tooltip mdi mdi-information-outline"></i></span>
                                <select id="send_reminder" class="form-control selectpicker" data-style="form-control" >
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div id="review_site_panel" class="form-group crm-customers-settings-panel hide">
                                <label for="">Review Site</label><span class="review_site_tooltip crm_tooltip hide"><i class="crm_tooltip mdi mdi-information-outline"></i></span>
                                <select id="review_site" class="form-control selectpicker" data-style="form-control" >
                                    @if(!empty($thirdPartiesList))
                                    @foreach($third_parties_list as $third_party)
                                    <option value="{{$third_party['type']}}">{{$third_party['type']}}</option>
                                    @endforeach
                                   @endif
                                </select>
                            </div>
                        </div>
                    </div>

                    <div id="preview_panel" class="crm-customers-settings-panel hide">


                        <div id="email-preview-wrap" class="email-preview-wrap editor-content col-sm-6">

                            <a href="javascript:;" class="reset-default-preview" id="reset-email-default-preview"><label class="reset-label">Reset to Default</label></a>
                            <label class="editor-label">Edit Email Content</label>
                            <a class="showCustomizeEmailModal" href="javascript:;"><span class="mdi mdi-pencil"></span></a>

                            <div class="inner-screen-preview" style="background-image:url({{ asset('public/images/penlaptop.png') }}); height: 320px;     margin-top: 10px;      margin-left: -23px;
                         ">

                                <div class="laptop-logo">
                                    @if(!empty(uploadImagePath($userData['business'][0]['logo'])))
                                    <img style="max-height: 50px;" src="{{ uploadImagePath($userData['business'][0]['logo']) }}" alt="" />
                                    @else
                                        {{ $userData['business'][0]['practice_name'] }}
                                    @endif
                                </div>
                                <div class="laptop-text">
                                    <p style="font-weight: bold;margin-left: 20px;margin-bottom: 0; font-size: 16px; ">We'd love your feedback</p>
                                    <p style="padding: 0px 20px 0px !important;margin: 0px;"><?php echo 'Hi {{name}}!'; ?></p>
{{--                                    <div class="content-body" data-default="false"><p class="email-content" id="email-content">yjfghjfghj<br><a class="demoLink" href="javascript:;">Add a Quick Review</a></p><a id="showCustomizeEmailModal" href="javascript:;"><span class="mdi mdi-pencil"></span></a></div>--}}
                                    <div class="content-body" data-default="true"></div>
                                </div>
                                <div class="thumbnail-up-down">
                                    <div>
                                        <img src="{{ asset('public/images/feedback-review/like.png') }}" alt="">
                                    </div>
                                    <div>
                                        <img src="{{ asset('public/images/feedback-review/dislike.png') }}" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="sms-preview-wrap" class="editor-content col-sm-6">
                            <label class="editor-label editor-label-phone">Edit SMS Content</label>
                            <a class="showCustomizeSMSModal" href="javascript:;"><span class="mdi mdi-pencil"></span></a>
                            <a href="javascript:;" class="reset-default-preview" id="reset-sms-default-preview"><label class="reset-label">Reset to Default</label></a>

                            <div class="inner-screen-preview" style="background-image:url({{ asset('public/images/peniphone.png') }}); height: 320px; width: 290px;     margin-top: 10px;  margin-left: 45px;
                                 ">
                                <div class="iphone-title">
                                    <p style="font-weight: bold;margin-left: 45px;margin-bottom: 0; font-size: 16px; ">We'd love your feedback</p>
                                    <p style="padding-left: 44px;margin: 0px;"><?php echo 'Hi {{name}}!'; ?></p>
                                </div>
                            <div class="content-body" data-default="true"></div>
                            </div>
                        </div>
                    </div>

                    <span class="error_Msg help-block hide-me"><small></small></span>
                </div>
            </div>
            <div class="modal-footer step2">
                <div class="row">
                    @if(($requestedUrl == route('home')))
                    <div class="col-md-6">
                        <button type="button" class="btn btn-cancel" data-dismiss="modal">Cancel</button>
                    </div>
                    <div class="col-md-6">
                            <button id="save_settings" type="button" class="btn btn-save btn-upload">Save Settings</button>
                    </div>
                    @else
                        <div class="col-md-6">
                            <button id="add-single-customer-back-step" type="button" class="btn btn-cancel">Back</button>
                        </div>
                        <div class="col-md-6">
                            <button id="customizeReviewRequestsBtn" type="button" class="btn btn-save btn-upload">Add Contact and Send Review Request</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@if(!($requestedUrl == route('home')))
<div class="modal fade add-contact-step1" id="addMultipleCustomerStep1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="st-2-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="heading">Download CSV Template</h3>
                    </div>
                    <div class="col-sm-6">
                        <div class="steps-nav-right">
                            <ul>
                                <li class="completed">
                                    <div class="stip active"></div>
                                    <h4>1: Download</h4>
                                </li>

                                <li class="">
                                    <div class="stip"></div>
                                    <h4>2: Contacts</h4>
                                </li>
                                <li class="">
                                    <div class="stip"></div>
                                    <h4>3: Upload</h4>
                                </li>
                                <li class="review-nav-step">
                                    <div class="stip"></div>
                                    <h4>4: Review</h4>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>

            <div class="modal-body">
                <div class="" id="">
                    <div class="step-body">
                        <h3>

                            The patient fields supported are: Email Address, First Name, Last Name, and Phone.<br>
                            Please download our template to make sure your patient information is imported correctly.

                        </h3>
                        <div class="download-csv-section">

                            <img src="{{ asset('public/images/download-csv.png') }}">
                            <div class="download-link">
                                <a href="{{ asset('public/files/patient_import_template.csv') }}" download="">Download CSV Template</a>
                            </div>
                        </div>

                    </div>


                </div>
            </div>
            <div class="modal-footer step3">
                <div class="row">
                    <div class="col-xs-6">
                        <button type="button" class="btn btn-cancel" data-dismiss="modal">Cancel</button>

                    </div>
                    <div class="col-xs-6">
                        <button id="showAddMultipleCustomerStep2Modal" type="button" class="btn btn-save btn-upload">Next Step</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade add-contact-step1" id="addMultipleCustomerStep2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close closeAddMultipleCustomerStep2">&times;</button>
            </div>
            <div class="st-2-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="heading">Paste Contacts to CSV</h3>
                    </div>
                    <div class="col-sm-6">
                        <div class="steps-nav-right">
                            <ul>
                                <li class="completed">
                                    <div class="stip "></div>
                                    <h4>1: Download</h4>
                                </li>

                                <li class="">
                                    <div class="stip active"></div>
                                    <h4>2: Contacts</h4>
                                </li>
                                <li class="">
                                    <div class="stip"></div>
                                    <h4>3: Upload</h4>
                                </li>
                                <li class="review-nav-step">
                                    <div class="stip"></div>
                                    <h4>4: Review</h4>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>

            <div class="modal-body">
                <div>
                    <div class="step-body">
                        <h3>
                            Add your contacts to the CSV file you downloaded. Follow the format shown in the CSV. <br> When you’re done adding the contacts, save the file as a CSV file
                        </h3>
                        <div class="table-contacts">
                            <div class="table-responsive">
                                <span class="label label-preview-csv">Preview</span>
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Email_Address</th>
                                        <th>First_Name</th>
                                        <th>Last_Name</th>
                                        <th>Phone_Number</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>calvinbarry@gmail.com</td>
                                        <td>Calvin</td>
                                        <td>Barry</td>
{{--                                        <td>+1 305 456 7891</td>--}}
                                        <td>305 456 7891</td>

                                    </tr>
                                    <tr>
                                        <td>danieldanny@gmail.com</td>
                                        <td>Daniel</td>
                                        <td>Danny</td>
{{--                                        <td>+1 675 245 8894</td>--}}
                                        <td>675 245 8894</td>

                                    </tr>
                                    <tr>
                                        <td>haroldfelix@gmail.com</td>
                                        <td>Harold</td>
                                        <td>Felix</td>
{{--                                        <td>+1 702 985 6475</td>--}}
                                        <td>702 985 6475</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div><p style="text-align: center;color: #000;font-size: 15px;">Having difficulty?  Send us your original file and we will import your patients for you. <a href="javascript:void(0);" class="sendFileOnly" style="color: red;">Learn More</a></p></div>


                </div>
            </div>
            <div class="modal-footer step3">
                <div class="row">
                    <div class="col-xs-6">
                        <button type="button" id="backToAddMultipleCustomerStep1Modal" class="btn btn-cancel">Back</button>
                    </div>
                    <div class="col-xs-6">
                        <button id="showAddMultipleCustomerStep3Modal" type="button" class="btn btn-save btn-next">Next Step</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade add-contact-step1" id="addMultipleCustomerStep3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close closeAddMultipleCustomerStep3">&times;</button>
            </div>
            <div class="st-2-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="heading">Uploads a CSV of Your Patients</h3>
                    </div>
                    <div class="col-sm-6">
                        <div class="steps-nav-right">
                            <ul>
                                <li class="completed">
                                    <div class="stip"></div>
                                    <h4>1: Download</h4>
                                </li>

                                <li class="">
                                    <div class="stip"></div>
                                    <h4>2: Contacts</h4>
                                </li>
                                <li class="">
                                    <div class="stip active"></div>
                                    <h4>3: Upload</h4>
                                </li>
                                <li class="review-nav-step">
                                    <div class="stip"></div>
                                    <h4>4: Review</h4>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>

            <div class="modal-body">
                <div class="" id="">
                    <div class="step-body">
                        <h3>
                            After adding all of your contacts to the CSV file, you can upload the file here using drag <br> and drop or by clicking on the Browse button and selecting the CSV file.Questions? <a href="#" style="text-decoration: underline;">Learn More.</a>
                        </h3>
                        <div class="upload-csv-section">
                            <div id="drop-files" ondragover="return false">
                                <img src="{{ asset('public/images/download-csv.png') }}">
                                <div class="upload-link">
                                    <h3>Drag and drop to upload</h3>
                                    <label>or <span>browse<form id="fileUploadForm"><input type="file" name="file" id="uploadCustomersCSVFile" style="display: none;"></form></span> to choose a file</label>
                                    <div id="csvFileName"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer step3">
                <div class="row">
                    <div class="col-xs-6">
                        <button type="button" id="backToAddMultipleCustomerStep2Modal" class="btn btn-cancel">Back</button>

                    </div>
                    <div class="col-xs-6">
                        @if(!empty($actionStatus) && $actionStatus == 'only_save')
                            <button id="upload_csv" type="button" class="btn btn-save btn-upload">Upload</button>
                        @else
                            <button id="upload_csv" type="button" class="btn btn-save btn-upload">Next Step</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade add-contact-step1" id="customerInfoModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog user-info-modal user-info-web" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="st-2-header">
                        <div class="row">
                            <div class="col-sm-12">
                                <h3 class="heading">Customer Info</h3>
                                <input type="hidden" class="edit-customer-id">
                                <div class="user-details">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="inputContainer-name">
                                                <div class="bg-divider"></div>
                                                <input type="text" placeholder="First Name" class="form-control customerFirstName" name="email" value="">
                                                <span class="help-block hide-me">
                                                    <strong></strong>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="inputContainer-name">
                                                <div class="bg-divider"></div>
                                                <input type="text" placeholder="Last Name" class="form-control customerLastName" name="email" value="">
                                                <span class="help-block hide-me">
                                                    <strong></strong>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="inputContainer-mail">
                                                <div class="bg-divider"></div>
                                                <input type="email" class="form-control customerInfoEmail" placeholder="Enter email">
                                                <span class="help-block hide-me">
                                                    <strong></strong>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="inputContainer-phone">
                                                <div class="bg-divider"></div>
                                                <input type="text" class="form-control customerInfoPhone" placeholder="Email phone number">
                                                <span class="help-block hide-me">
                                                    <strong></strong>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <button class="btn btn-customer-update btn-block btn-customerupdate" id="update-contact" data-title="There are no changes to update.">Update</button>
                                        </div>
                                    </div>

                                    {{--<div class="row">--}}
                                        {{--<div class="col-md-5">--}}
                                            {{--<div class="user-email">--}}
                                                {{--<i class="mdi mdi-email"></i>--}}
                                                {{--<input type="text" class="form-control customerInfoEmail" placeholder="Enter email">--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="col-md-5">--}}
                                            {{--<div class="user-phone">--}}
                                                {{--<i class="mdi mdi-phone-in-talk"></i>--}}
                                                {{--<input type="email" class="form-control customerInfoPhone" placeholder="Email phone number">--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="col-md-2">--}}
                                            {{--<button class="btn btn-customerupdate" id="update-contact" data-title="There are no changes to update.">Update</button>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="" id="">
                            <div class="step-body">
                                <h3>Review Requests</h3>
                                <div class="table-contacts" id="customerInfoReviewRequestsTableContainer">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="customerInfoReviewRequestsTable">
                                            <thead>
                                                <tr>
                                                    <th>Date Sent</th>
                                                    <th>Type</th>
                                                    <th>Smart Routing</th>
                                                    <th>Site Reviewed</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</div>

<div class="modal fade" id="addCustomerFIle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" >&times;</button>
            </div>

            <div class="modal-body" style="padding-top: 0;">
                <div class="" id="">
                    <div class="step-body">
                        <h3 style="color: #000;font-weight: 600;margin-bottom: 20px;font-size: 24px;">Want nichepractice to import your practice data for free?</h3>
                        <p style="font-size: 15px;">
                            If your patient data file is not compatible with our file format, send us your file and nichepractice will import your data (patient name, email and phone number) for free. Your data will be placed in your account within 24 hours and you will receive an email confirmation once completed.
                        </p>
                        <div class="upload-csv-section">
                            <div id="drop-files-section" ondragover="return false">
                                <img src="{{ asset('public/images/download-csv.png') }}">
                                <div class="upload-link">
                                    <h3>Drag and drop to upload</h3>
                                    <label>or <span>browse<form id="fileUploadInterfaceForm"><input type="file" name="file" id="uploadCustomersFile" style="display: none;"></form></span> to choose a file</label>
                                    <div id="uploadFileName"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-xs-6 col-xs-offset-3">
                        <button id="upload_csv_file" type="button" class="btn btn-save btn-upload">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
<style>
    .smsSettingModalHeading {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .smsSettingModalHeading h2{
        font-size: 30px !important;
        font-weight: 600 !important;
    }
    .step-body h3{
       font-weight:500!important;
    }
</style>
