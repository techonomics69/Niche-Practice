@extends('index')

@section('pageTitle', 'Contact Us')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid dashboarbgtitle">
            <div class="dashboard-wrapper campaign-list">
                <div class="page-head">
                    <form id="contactusform">
                        <div class="row col-xs-12 col-sm-8">
                            <div class=" ">
                                <h4 class="page-title">Contact Us</h4>
                            </div>
                        </div>
                        <div class="row col-xs-12 col-sm-8 col-sm-offset-2">
{{--                            <div class=" ">--}}
{{--                                <h4 class="page-title">Contact Us</h4>--}}
{{--                            </div>--}}
                            <div class="">
                               {{-- <h3 class="contact-des"><i class="fa fa-tasks" aria-hidden="true"></i>Description</h3> --}}
                               {{-- <p class="des-p">At nichepractice, we are constantly working to advance our tools and develop new features for doctors. We'd be very pleased if you could take the time to give us some feedback. </p> --}}
                               <p class="contact-des">Whether you have a question about features, trials, pricing, need a demo, or anything else, our team is ready to answer all your questions. </p>
                               <h3 class="contact-des"><i class="fa fa-tasks" aria-hidden="true" style="padding: 5px;"></i>How can we help you?</h3>
                               <div class="selectdiv m-l-30">
                                  <div  id="exampleFormControlSelect3">
                                    <select class="form-control selectpicker select-option" name="content" required>
                                         <option value="">Select</option>
                                         <option value="Give us feedback">Give us feedback</option>
                                         <option value="Billing Question">Billing Question</option>
                                         <option value="Marketing Platform Question">Marketing Platform Question</option>
                                         <option value="Other">Other</option>
                                    </select>
                                  </div>
                               </div>
                            </div>
                            {{-- <div class="">
                                <h3 class="contact-des"><i class="fa fa-paperclip"></i>Attachments</h3>
                                    <form>
                                        <input id="contactattachment" type="file" style="display:none;"/>
                                    </form>
                                <button type="button" class="btn btn-primary btn-outline nohover m-l-30 btn-attatchment " id="contactattachmentbutton">Attachment</button>
                                    <span id="selected_filename"></span>
                            </div> --}}
                            <div class="comments-box">
                                <h3 class="contact-des"><i class="fa fa-comment"></i>Comments</h3>
                                    <div class="form-group">
                                        <textarea class="form-control m-l-30 content-comment" placeholder="Enter your comment" id="contactcomment" rows="3"></textarea>
                                    </div>
                                    <div class="" style="float:right;">
                                        <p id="contactattachmentbutton" class="attach-link"><i class="fa fa-paperclip"></i>Add Attachment</p>
                                        <form>
                                           <input id="contactattachment" type="file" style="display:none;"/>
                                        </form>
                                        <button style="display:none;" type="button" class="btn btn-primary btn-outline nohover m-l-30 btn-attatchment ">Attachment</button>
                                        <span class="selected-file-name" id="selected_filename"></span>
                                    </div>
                               {{--<button type="submit" id="contactusbutton" class="btn btn-primary nohover btn-longer btn-outline m-l-30 btn-attatchment">Send Now</button> --}}
                            </div>
                            <div class="send-form-btn-outer">
                                <button type="submit" id="contactusbutton" class="btn btn-primary nohover btn-longer btn-outline m-l-30 btn-attatchment">Send Now</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')

@endsection

@section('js')
    <script>
        // contactusform
        // attachment
        // comment
        function post(formid, ...inputids) {
            $('#'+formid).submit(function (event) {
                event.preventDefault();
                // console.log(formid);

                for (let index = 0; index < inputids.length; index++) {
                    var element = inputids[index];
                    // console.log($('#'+element).localName);
                    var element = $('#'+element).val();
                    // console.log(element);

                }
                // var attachment = $('#'+).val();
                // var comment = $('#'+).val();

                // console.log(attachment);
                // console.log(comment);

             });
         }
        $(document).ready( function() {
            $('#contactattachmentbutton').click(function(){
                $("#contactattachment").click();
            });
            // contactusform

            // attachment
            // comment

            $('#contactusform').submit(function (event) {
                event.preventDefault();
                var token = $('input[name="_token"]').val();
                var attachment = $('#contactattachment')[0].files[0];
                var comment = $('#contactcomment').val();
                var feedbackOption = $('.select-option').val();

                // console.log(token);
                // console.log(attachment);
                // console.log(comment);

                var formData = new FormData();
                formData.append('_token', token);
                formData.append('attachment', attachment);
                formData.append('comment', comment);
                formData.append('feedback_option', feedbackOption);

                showPreloader();

                $.ajax({
                    type: "post",
                    url: "{{ route('contact.store') }}",
                    data: formData,
                    processData: false,
                    contentType: false
                }).done(function () {
                    hidePreloader();
                    $("form")[0].reset();
                    $("#selected_filename").html('');
                    swal({
                            title: "SUCCESS",
                            text: 'Your feedback has been sent',
                            type: 'success'
                        }, function () {
                        });
                }).fail(function (error) {
                    hidePreloader();
                    // console.log(error);
                        swal({
                            title: "OOPS !",
                            text: error.statusText,
                            type: 'error'
                        }, function () {
                        });

                });
             });
        });
        $('#contactattachment').change(function() {
            $('#selected_filename').text($('#contactattachment')[0].files[0].name);
        });

    </script>
@endsection
