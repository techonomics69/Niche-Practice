@extends('admin.layout')

@section('title', 'Category list')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            {{--            <form class="validate-me" method="POST" action="{{ route('task.store') }}" accept-charset="UTF-8">--}}
            <div class="box box-default">
                <div class="box-body">
                    <div class="col-sm-12 input-form">
                        <h3 class="box-title">
                            Edit Report
                        </h3>
                        @if(!empty($report))
                        <div class="input-field">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Title</label>
                                    <input type="text" class="form-control" id="name" value="{{ $report[0]['title'] }}">
                                    <span class="help-block hide-me campaign-name"><small></small></span>

                                    <div class="m-t-20 col-sm-12 no-padding">
                                        <label>Content</label>
                                        <textarea id="content" name="content"  class="form-control" rows="5"> {{ $report[0]['content'] }}</textarea>
                                        {{--                                        <div style="margin-top: 5px; display: flex;">--}}
                                        {{--                                            <input type="checkbox" id="show-rating" style="margin-right: 3px;/* padding-top: 8px; *//* float: left; *//* padding-right: 12px; */">--}}
                                        {{--                                            Show Campaign Rating--}}
                                        {{--                                        </div>--}}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 m-t-20">
                                    <label>Report For User</label>
                                    <select class="form-control select2" name="report-for-user" id="report-user">
                                        <option value="">Choose user</option>
                                        @foreach($usersList as $userRec)
                                            <option value="{{ $userRec['id'] }}"   {{ selectedChosenValue($userRec['id'], $report[0]['customer'] ) }}>{{ $userRec['email'] }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block"><small></small></span>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-sm-6 m-t-20">
                                    {{--                                    <form action="/action_page.php">--}}
{{--                                    <label for="myfile">Select a file:</label>--}}
{{--                                    <input type="file" id="myfile" name="myfile"><br><br>--}}
                                    {{--                                    </form>--}}
                                    <div class="upload-csv-section">
                                        <div id="drop-files" ondragover="return false">
                                            <img src="{{ asset('public/images/download-csv.png') }}">
                                            <div class="upload-link">
                                                <h3>Drag and drop to upload</h3>
                                                <label>or <span>browse<form id="fileUploadForm"><input type="file" name="file" id="uploadCustomersCSVFile" style="display: none;"></form></span> to choose a file</label>
                                                <div id="csvFileName">{{$report[0]['file_name']}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Status</label>
                                    <select class="form-control select2" name="campaign_for_user" id="report-status" data-selected-target="">
                                        <option value="0" {{ selectedChosenValue(0, $report[0]['status'] ) }}>Published</option>
                                        <option value="1" {{ selectedChosenValue(1, $report[0]['status'] ) }}>Unpublished</option>
                                    </select>
                                    <span class="help-block"><small></small></span>
                                </div>
                            </div>
                            <div class="box-footer">
                                <div id="saveActions" class="form-group">
                                    <div class="btn-group">
                                        <button type="submit" class="btn btn-success save-action" data-target-id="{{$report[0]['id']}}">
                                            <span class="fa fa-save" aria-hidden="true"></span> &nbsp;<span>Update</span>
                                        </button>
                                    </div>

                                    <a href="{{ route('admin.reports') }}" class="btn btn-default"><span class="fa fa-ban"></span> &nbspCancel</a>
                                </div>
                                <span class="help-block hide-me"><strong>Required fields must be filled.</strong></span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            {{--            </form>--}}
        </div>
    </div>
@endsection

@section('after_styles')
    <style>
        .info-container input.form-control
        {
            width: 270px;
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
        .upload-csv-section h3 {
            font-size: 16px;
            font-weight: normal;
            margin-top: 0;
            margin-bottom: 5px;
        }
        .upload-csv-section {
            background: #F9F9F9;
            text-align: center;
            border:1px solid #9d9d9d;
            border-style: dashed;
            /*padding: 30px 0;*/
            margin: 30px 0;
        }

        .upload-csv-section img {
            width: 12%;
        }
        .upload-link {
            margin-top: 15px;
        }
        .upload-link  form{
            display: inline-block;
        }
        .upload-link h3 {
            font-weight: 600;
            color: #000;
        }

        .upload-csv-section .upload-link span{
            color: #EF3F52;
            cursor: pointer;
        }
        .upload-csv-section #drop-files {
            padding: 15px 0;
        }
    </style>
@endsection
@section('js')
    <script src="{{ asset('public/plugins/bootstrap-multiselect/bootstrap-multiselect.js') }}"></script>
    <script>
        window.csvFileArray = [];
        $(function () {
            $(".save-action").click(function () {

                var title = $("#name").val().trim();
                var content = $("#content").val();
                var customer = $("#report-user option:selected").val();
                var status = $("#report-status").val();
                var id = $(this).attr("data-target-id");

                var errorSelector = $("span.help-block.campaign-name");



                // var errorSelectorNiche = $("span.help-block.niche-select");

                // $(".alert").hide();
                // $(".alert").removeClass('alert-success alert-danger');
                errorSelector.addClass('hide-me');
                errorSelector.removeClass('error text-success');

                // errorSelectorNiche.addClass('hide-me');
                // errorSelectorNiche.removeClass('error text-success');

                if(!title)
                {
                    errorSelector.removeClass('hide-me');
                    errorSelector.addClass('error');
                    $("small", errorSelector).html('Required Field');
                    return false;
                }

                // if (document.getElementById("uploadCustomersCSVFile").files.length == 0 && window.csvFileArray.length == 0) {
                //     swal({
                //         title: "",
                //         text: "File is required. Please upload CSV file.",
                //         type: 'error',
                //         allowOutsideClick: false,
                //         html: true,
                //         showCancelButton: false,
                //         confirmButtonColor: '#8CD4F5 ',
                //         cancelButtonColor: '#d33',
                //         confirmButtonText: 'OK',
                //         cancelButtonText: "Cancel",
                //         closeOnConfirm: true,
                //         closeOnCancel: true
                //     });
                //     return false;
                // }
                var file_data = document.getElementById('uploadCustomersCSVFile').files[0];
                // console.log('file_data');
                // console.log(file_data);
                if(typeof(file_data)=="undefined") {
                    // console.log('here');
                    // console.log(window.csvFileArray);

                    file_data=window.csvFileArray[0];
                }
                // console.log('file_data');
                // console.log(file_data);
                var formData = new FormData();
// return;
                formData.append('send', 'admin-report-update');
                formData.append('id', id);
                formData.append('title', title);
                formData.append('content', content);
                formData.append('customer', customer);
                formData.append('status', status);
                formData.append('file', file_data);

                var baseUrl = $("#hfBaseUrl").val();

                // var $this = showLoaderButton(".save-action", "Saving");

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    type: "POST",
                    url: baseUrl + "/done-me",
                    contentType: false,
                    cache: false,
                    processData: false,
                    data: formData,
                    // data: data,
                }).done(function (result) {
                    // parse data into json
                    var json = $.parseJSON(result);

                    // get data
                    var statusCode = json.status_code;
                    var statusMessage = json.status_message;
                    var data = json.data;


                    var html ='';
                    if( statusCode == 200 ) {

                        swal({
                            title: "Successful!",
                            text: statusMessage,
                            type: "success"
                        }, function() {
                            // window.location = baseUrl+"/admin/reports";
                        });

                    }
                    else
                    {
                        swal("Error", statusMessage, "error");
                    }
                });
            });
        });
    </script>
    <script>
        /*--------------*/
        // Makes sure the dataTransfer information is sent when we
        // Drop the item in the drop box.
        jQuery.event.props.push('dataTransfer');

        var z = -40;
        // The number of images to display
        var maxFiles = 5;
        var errMessage = 0;

        // Get all of the data URIs and put them in an array


        // Bind the drop event to the dropzone.
        $('#drop-files').bind('drop', function(e) {
            window.csvFileArray = [];
            var files = e.dataTransfer.files;
            // console.log(files);
            if(files.length>1){
                swal({
                    title: "",
                    text: "Only 1 File is allowed to Upload",
                    type: 'error',
                    allowOutsideClick: false,
                    html: true,
                    showCancelButton: false,
                    confirmButtonColor: '#8CD4F5 ',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'OK',
                    cancelButtonText: "Cancel",
                    closeOnConfirm: true,
                    closeOnCancel: true
                });
                return false;
            }

            // var csvfile=files[0];
            // var res = csvfile.name.match(/.csv/g);
            var csvfile=files[0];
            var filesName=files[0].name;
            var parts = filesName.split('.')
            var parts1 = parts[parts.length - 1];

            function isFile()  {
                // var ext = getExtension(files);

                switch (parts1.toLowerCase()) {
                    case 'pdf':
                    case 'csv':
                    case 'docx':
                    case 'doc':
                        return true;
                }
                return false;
            }
            // console.log(files);
            var fileCheck =  isFile();
            // console.log(abc);
            if(!fileCheck){
            // console.log(res);
            // if(res==null){
                swal({
                    title: "",
                    text: "Invalid Format, Please upload CSV, PDF, DOC or DOCX file.",
                    type: 'error',
                    allowOutsideClick: false,
                    html: true,
                    showCancelButton: false,
                    confirmButtonColor: '#8CD4F5 ',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'OK',
                    cancelButtonText: "Cancel",
                    closeOnConfirm: true,
                    closeOnCancel: true
                });
                return false;
            }

            $('#csvFileName').text(csvfile.name);

            window.csvFileArray.push(files[0]);
            // console.log(window.csvFileArray);

            $('#uploadCustomersCSVFile').val('');
            var $el = $('#fileUploadForm');
            $el.wrap('<form>').closest('form').get(0).reset();
            $el.unwrap();
        });

        // Just some styling for the drop file container.
        $('#drop-files').bind('dragenter', function() {
            $(this).css({'box-shadow' : 'inset 0px 0px 20px rgba(0, 0, 0, 0.1)', 'border' : '4px dashed #bb2b2b'});
            return false;
        });

        $('#drop-files').bind('drop', function() {
            $(this).css({'box-shadow' : 'none', 'border' : '4px dashed rgba(0,0,0,0.2)'});
            return false;
        });

        // For the file list
        /*-----------*/

        $(document).on('change', '#uploadCustomersCSVFile', function () {
            var input = $(this),
                numFiles = input.get(0).files ? input.get(0).files.length : 1,
                label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            input.trigger('fileselect', [numFiles, label]);

            if (input.get(0).files.length == 0) {
                $('#csvFileName').text('');
                input.val('');
                var $el = $('#fileUploadForm');
                $el.wrap('<form>').closest('form').get(0).reset();
                $el.unwrap();
            }
        });

        $('#uploadCustomersCSVFile').on('fileselect', function (event, numFiles, label) {
            var ext = $('#uploadCustomersCSVFile').val().split('.').pop().toLowerCase();
            var input = $(this).parents('.input-group').find(':text'),
                log = numFiles > 1 ? numFiles + ' files selected' : label;
            if (log) {
                if ($.inArray(ext, ['csv', 'pdf', 'doc', 'docx']) == -1) {
                    swal({
                        title: "",
                        text: "Invalid Format, Please upload CSV, PDF, DOC or DOCX file.",
                        type: 'error',
                        allowOutsideClick: false,
                        html: true,
                        showCancelButton: false,
                        confirmButtonColor: '#8CD4F5 ',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'OK',
                        cancelButtonText: "Cancel",
                        closeOnConfirm: true,
                        closeOnCancel: true
                    });

                    $('#csvFileName').text('');
                    input.val('');

                    var $el = $('#fileUploadForm');
                    $el.wrap('<form>').closest('form').get(0).reset();
                    $el.unwrap();
                } else {
                    var csvfile = document.getElementById('uploadCustomersCSVFile').files[0];
                    $('#csvFileName').text(csvfile.name);

                    window.csvFileArray = [];

                    if (input.length) {
                        input.val(log);
                    } else {
                        // if (log) alert(log);
                    }
                }
            }
        });

        // $(document).on("click", "#upload_csv", function (e) {
        //     var alreadyAddedCheck= $('#upload_csv').attr('data-already-added');
        //     if(alreadyAddedCheck=='true'){
        //         $('#addMultipleCustomerStep3').modal('hide');
        //         $('#addCustomerStep2').modal('show');
        //         return false;
        //     }
        //
        //     e.preventDefault();
        //     if (document.getElementById("uploadCustomersCSVFile").files.length == 0 && window.csvFileArray.length == 0) {
        //         swal({
        //             title: "",
        //             text: "File is required. Please upload CSV file.",
        //             type: 'error',
        //             allowOutsideClick: false,
        //             html: true,
        //             showCancelButton: false,
        //             confirmButtonColor: '#8CD4F5 ',
        //             cancelButtonColor: '#d33',
        //             confirmButtonText: 'OK',
        //             cancelButtonText: "Cancel",
        //             closeOnConfirm: true,
        //             closeOnCancel: true
        //         });
        //         return false;
        //     }
        //     // console.log(window.csvFileArray);
        //
        //     // var file_data = document.getElementById('uploadCustomersCSVFile').files[0];
        //     // // console.log(file_data);
        //     // if(typeof(file_data)=="undefined"){
        //     //     file_data=window.csvFileArray[0];
        //     // }
        //     // // console.log(file_data);
        //     // addCustomersCSV(file_data);
        // });
    </script>
    <script>

        $(function () {

            // getTemplate(52);

            $(".select2").select2();

            $('#plan').multiselect({
                includeSelectAllOption: true,
                selectAllText: 'SELECT ALL',
                allSelectedText: 'All Selected',
                // nonSelectedText: 'Choose Plan',
                selectAllNumber: false,
                buttonText: function(options, select) {
                    if(options.length === 0)
                    {
                        return '';
                    }
                    else if(options.length === 3)
                    {
                        return 'All Selected';
                    }else if(options.length >= 1)
                    {
                        return options.length + ' selected';
                    }
                    // else if(options.length > 1)
                    // {
                    //     return options;
                    // }
                    // return options.length == 3 ? 'All Selected':'Choose Plan';
                }
            });
        });

    </script>
@endsection
