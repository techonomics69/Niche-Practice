@extends('admin.layout')

@section('title', 'Category Panel')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-default">
                <div class="box-body">
                    <div class="col-sm-12 input-form">
                        <h3 class="box-title">
                            Edit Category
                        </h3>

                        <div class="input-field">
                            <div class="col-sm-6">
                                <label>Campaign Name</label>
                                <input type="text" class="form-control" id="category-name"
                                       value="{{ $category['name'] }}">
                                <span class="help-block hide-me campaign-name"><small></small></span>

                                <div class="m-t-20 col-sm-12 no-padding">
                                    <label>Campaign Description</label>
                                    <textarea id="content" name="content" class="form-control"
                                              rows="5">{{ $category['content'] }}</textarea>
                                    {{--                                        <div style="margin-top: 5px; display: flex;">--}}
                                    {{--                                            <input type="checkbox" id="show-rating" style="margin-right: 3px;/* padding-top: 8px; *//* float: left; *//* padding-right: 12px; */" {{!empty($category['show_rating']) ? 'checked' : ''}}>--}}
                                    {{--                                            Show Campaign Rating--}}
                                    {{--                                        </div>--}}
                                </div>

                                <div class="m-t-20 col-sm-3 no-padding">
                                    <label>Credits</label>
                                    <input type="number" id="credits" name="credits" value="{{ $category['credits'] }}"
                                           class="form-control">
                                </div>


                                <div class="m-t-20 col-sm-12 no-padding plan-block">
                                    <label>Marketing Association</label>
                                    {{--                                        @if(!empty($category['has_many_associations']))--}}
                                    {{--                                            <p>--}}
                                    <?php

                                    //                                    echo $category['has_many_associations'];
                                    //                                    echo $category['has_many_associations'][0]['pivot']['association_id'];
                                    ?>
                                    {{--                                            @foreach($cat as $record)--}}
                                    {{--                                                <p> {{$record['pivot']['association_id']}} </p>--}}
                                    {{--                                                @endforeach--}}
                                    {{--                                                </p>--}}

                                    {{--                                                @endif--}}
                                    <select class="form-control selectpicker" id="association" name="association"
                                            multiple>
                                        {{--                                            <option value=""></option>--}}
                                        @if(!empty($association))
                                            <?php
                                            //                                                    $industryKey = 1;
                                            //                                                $cat = $category;
                                            ?>
                                            @foreach($association as $key => $record)
                                                <?php
                                                $association = $record['name'];

                                                ?>
                                                <option
                                                    value="{{$record['id']}}" {{ selectedChosenValue($category['association'], $record['id']) }}>{{$association}}</option>
                                                <?php
                                                //                                                        $industryKey++;
                                                ?>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>


                                <div class="col-sm-12 no-padding">
                                    {{--                                        <div class="m-t-20">--}}
                                    {{--                                            <label>Type</label>--}}
                                    {{--                                            <select class="form-control selectpicker" id="library-type" name="library_type">--}}
                                    {{--                                                <option value="1" {{ selectedChosenValue($category['library_type'], 1) }}>Practice Marketing</option>--}}
                                    {{--                                                <option value="2" {{ selectedChosenValue($category['library_type'], 2) }}>Equipment Marketing</option>--}}
                                    {{--                                            </select>--}}
                                    {{--                                        </div>--}}
                                    <div class="m-t-20">
                                        <label>Plan</label>
                                        <select class="form-control selectpicker" id="library-type" name="library_type">
                                            {{--                                                <option value="1" {{ selectedChosenValue($category['library_type'], 1) }}>Niche</option>--}}
                                            {{--                                                <option value="2" {{ selectedChosenValue($category['library_type'], 2) }}>Premium</option>--}}
                                            {{--                                                <option value="1"  {{ selectedChosenValue($category['library_type'], 1) }}>Marketing Packages</option>--}}
                                            <option value="2" {{ selectedChosenValue($category['library_type'], 2) }}>
                                                Individual Campaigns
                                            </option>
                                            <option value="1" {{ selectedChosenValue($category['library_type'], 1) }}>
                                                Digital Media
                                            </option>
                                            {{--                                                <option value="1">Individual Campaigns</option>--}}
                                            {{--                                                <option value="2">Digital Media</option>--}}
                                        </select>
                                    </div>


                                    {{--one--}}
                                    <div class="m-t-20">
                                        <label>Industry</label>
                                        <select class="form-control selectpicker" id="industry" name="industry">
                                            <option value=""></option>
                                            @if(!empty($records))
                                                <?php
                                                //                                                        $industryKey = 1;
                                                ?>
                                                @foreach($records as $record)
                                                    <?php
                                                    $industry = $record['name'];
                                                    ?>
                                                    <option
                                                        value="{{$record['id']}}" {{selectedChosenValue($category['industry'],$record['id'])}}>{{$industry}}</option>
                                                    <?php
                                                    //                                                            $industryKey++;
                                                    ?>
                                                @endforeach
                                            @endif
                                            {{--                                                <option value="">Practice Marketing</option>--}}
                                            {{--                                                <option value="">Practice Marketing</option>--}}
                                            {{--                                                <option value="">Default</option>--}}
                                        </select>

                                    </div>
                                    {{--two--}}
                                    <div class="m-t-20">
                                        <label>Niche</label>
                                        <select class="form-control select2" id="niche" name="niche"
                                                data-selected-target="{{ $category['niche'] }}">
                                        </select>
                                        <span class="help-block hide-me niche-select"><small></small></span>
                                    </div>
                                </div>

                                <div class="col-sm-12 no-padding">
                                    <div class="m-t-20">
                                        <label>Category Type</label>
                                        <select class="form-control selectpicker type-selection" id="type" name="type">
                                            <option
                                                value="non-marketing-campaign" {{ selectedChosenValue($category['type'], 'non-marketing-campaign') }}>
                                                Non-Marketing Campaign
                                            </option>
                                            <option
                                                value="marketing-campaign" {{ selectedChosenValue($category['type'], 'marketing-campaign') }}>
                                                Marketing Campaign
                                            </option>
                                            <option value="" {{ (empty($category['type'])) ? 'selected': '' }}>Default
                                            </option>
                                        </select>
                                        <div style="margin-top: 5px;">
                                            <input type="checkbox" id="show-to-paid-mark"
                                                   style="/* padding-top: 8px; *//* float: left; *//* padding-right: 12px; */" {{ (!empty($category['show_to_paid'])) ? 'checked': '' }}>
                                            Show this category to Paid User
                                        </div>
                                        <div style="margin-top: 5px; display: none;" id="mark-as-complete-outer">
                                            <input type="checkbox" id="mark-as-complete-checkbox"
                                                   style="margin-right: 3px;/* padding-top: 8px; *//* float: left; *//* padding-right: 12px; */" {{ (!empty($category['mark_as_complete_check'])) ? 'checked': '' }}>
                                            Show mark as complete and skip task
                                        </div>
                                    </div>

                                    <div class="m-t-20">
                                        <label>Priority</label>
                                        <select class="form-control selectpicker" id="category-priority"
                                                name="priority">
                                            <option value=""></option>
                                            @for($i=1; $i<=10;$i++)
                                                <option
                                                    value="{{ $i }}" {{ selectedChosenValue($category['priority'], $i) }}>{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>

                                    <div class="m-t-20">
                                        <label>Campaign Filter</label>
                                        <select class="form-control selectpicker type-selection" id="campaign_filter"
                                                name="campaign_filter">
                                            <option
                                                value="dummy1" {{ selectedChosenValue($category['campaign_filter'], 'dummy1') }}>
                                                Dummy 1
                                            </option>
                                            <option
                                                value="dummy2" {{ selectedChosenValue($category['campaign_filter'], 'dummy2') }}>
                                                Dummy 2
                                            </option>
                                            <option
                                                value="dummy3" {{ selectedChosenValue($category['campaign_filter'], 'dummy3') }}>
                                                Dummy 3
                                            </option>
                                            <option
                                                value="dummy4" {{ selectedChosenValue($category['campaign_filter'], 'dummy4') }}>
                                                Dummy 4
                                            </option>
                                            <option
                                                value="dummy5" {{ selectedChosenValue($category['campaign_filter'], 'dummy5') }}>
                                                Dummy 5
                                            </option>
                                            <option value="" {{ (empty($category['type'])) ? 'selected': '' }}>Default
                                            </option>
                                        </select>
                                    </div>

                                    <div class="m-t-20">
                                        <label>Campaign Filter Priority</label>
                                        <select class="form-control selectpicker" id="campaign_filter_priority"
                                                name="campaign_filter_priority">
                                            <option value=""></option>
                                            @for($i=1; $i<=10;$i++)
                                                <option value="{{ $i }}" {{ selectedChosenValue($category['campaign_filter_priority'], $i) }}>{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="profile-info">
                                    <div class="add-praticelogo logo-image-container" id="logo-image-container">
                                        <img src="{{ asset('public/images/icons/right-arrow.png') }}">
                                        <a id="logo" href="javascript:void(0);">
                                            <label>
                                                Add Upload Thumbnail
                                            </label>
                                        </a>

                                        <div class="attachment_container">
                                            <input type="file" id="add_logo_image" name="add_logo_image">
                                        </div>

                                        <div class="limit_exceeded_error_msg_container hide"
                                             style="margin-top:10px; margin-bottom: 15px;padding: 10px 5px 10px 10px ">
                                            <span class="remove_limit_exceeded_error"><i class="fa fa-times"
                                                                                         aria-hidden="true"></i></span>
                                            <span class="limit_exceeded_error_msg"></span>
                                        </div>

                                        @if(!empty($category['thumbnail']))
                                            <div class="attached_images_container p-l-image">
                                                <div class="small-4 columns show-image"
                                                     data-attachment-id="logo1603070478.png">
                                                    <img data-name="0x.jpg" class="attached_image_ox"
                                                         src="{{ uploadImagePath($category['thumbnail']) }}">
                                                </div>
                                            </div>
                                        @else
                                            <div class="attached_images_container p-l-image">
                                                <img class="img-responsive no-image"
                                                     src="{{ asset('public/images/no-image.png') }}">
                                                <label>No Image</label>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <?php
                                $description = 'description';
                                ?>
                                <div class="m-t-20 form-group {{ $errors->has($description) ? ' has-error' : '' }}">
                                    <label>Description</label>
                                    <textarea id="{{$description}}" name="{{$description}}"
                                              class="form-control summernote">{{ $category[$description]  }}</textarea>
                                    <small>{{ $errors->first($description) }}</small>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <?php
                                $sampleDescription = 'sample_description';
                                ?>
                                <div
                                    class="m-t-20 form-group {{ $errors->has($sampleDescription) ? ' has-error' : '' }}">
                                    <label>Sample Description</label>
                                    <textarea id="sampleDescription" name="{{$sampleDescription}}"
                                              class="form-control summernote">{{ $category[$sampleDescription]  }}</textarea>
                                    <small>{{ $errors->first($sampleDescription) }}</small>
                                </div>
                            </div>
                            <div class="form-group col-md-12 m-t-20">
                                <div class="col-sm-3 nopadding">
                                    <label>Settings</label>
                                    <select class="form-control selectpicker" id="settings_module"
                                            name="settings_module">
                                        <option value=""></option>
                                        <option
                                            value="full-width-cover" {{ selectedChosenValue($category['settings_module'], 'full-width-cover') }}>
                                            Full Width Cover
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <div class="col-md-3 nopadding">
                                    <label>Status</label>
                                    <select class="form-control" id="sys_status" name="sys_status">
                                        <option value="1" {{ selectedChosenValue($category['status'], 1) }}>Active
                                        </option>
                                        <option value="0" {{ selectedChosenValue($category['status'], 0) }}>Inactive
                                        </option>
                                        >
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="action-btn">
                                    <a href="{{ route('admin.category.list') }}"
                                       class="btn btn-default back-btn">Cancel</a>
                                    <button class="btn btn-primary save-name save-action"
                                            data-customer-id="{{ $category['id'] }}">Update
                                    </button>
                                </div>
                                <div class="alert action-alert">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="catId" name="catId" value="{{ $category['id'] }}">
@endsection

@section('after_styles')
    <link rel="stylesheet" href="{{ asset('public/plugins/summernote/summernote.css') }}"/>
    <link rel="stylesheet" href="{{ asset('public/admin/adminlte/plugins/datatables/dataTables.bootstrap.css') }}">
    <link type="text/css" rel="stylesheet"
          href="{{ asset('public/plugins/bootstrap-multiselect/bootstrap-multiselect.css?ver='.$appFileVersion) }}"/>
    <style>
        .info-container input.form-control {
            width: 270px;
        }

        .colored-button-icon {
            color: #1D32A0;
            cursor: pointer;
            padding: 10px;
            padding-top: 7px;
            background-color: #e8ebf6;
            padding-bottom: 7px;
            border-radius: 5px;
            margin-right: 10px;
        }

        .app-delete-button {
            color: #D01A1A;
            cursor: pointer;
            padding: 12px;
            padding-top: 7px;
            background-color: #fbe7e7;
            padding-bottom: 7px;
            border-radius: 5px;
            margin-right: 2px;
        }

        .box-title {
            margin-bottom: 50px;
        }

        .action-btn {
            margin-top: 25px;
        }

        .action-alert {
            width: 100%;
            float: left;
            margin-top: 20px;
        }

        .action-btn .back-btn {
            float: left;
            margin-left: 20px;
        }

        .save-action {
            background-color: #fff !important;
            padding-right: 25px;
            padding-left: 25px;
            color: #20a0ff !important;
            border-color: #20a0ff !important;
            margin-right: 20px;

            width: 120px;
            float: left;
            margin-left: 20px;
        }

        table.dataTable.niche-table thead .action:after {
            display: none;
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

        .logo-image-container div.show-image img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .profile-info .p-l-image {
            border: 1px solid #ddd;
            text-align: center;
            width: 200px;
            margin: 10px 0;
            height: 140px;
        }

        #add_logo_image {
            display: none;
        }

        .profile-info .p-l-image .no-image {
            padding: 22px 0;
        }

        .profile-info .p-l-image img {
            margin: auto;
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
            background-color: #f0f0f0;
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

        .plan-block .btn-group {
            width: 100%;
        }

        .plan-block .multiselect.dropdown-toggle {
            width: 100%;
            text-align: left;
            height: 38px;
            opacity: 1 !important;
            background: #ffffff;
        }

        .plan-block .multiselect.dropdown-toggle .caret {
            float: right;
            margin-top: 8px;
        }
    </style>
@endsection

@section('js')
    <script src="{{ asset('public/admin/adminlte/plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('public/plugins/summernote/summernote.js') }}"></script>
    <script src="{{ asset('public/admin/task/variable-feature.js?ver='.$appFileVersion) }}"></script>
    <script src="{{ asset('public/admin/adminlte/plugins/datatables/dataTables.bootstrap.js') }}"></script>
    <script src="{{ asset('public/admin/adminlte/plugins/datatables/dataTables.initiate.js') }}"></script>

    <script>
        window.attachedLogoArray = [];
        $(document.body).on('click', '.edit-me', function () {
            var siteUrl = $('#hfBaseUrl').val();
            var contactId = $(this).attr("data-target-id");
            var currentParentSelector = $(this).parent().closest('tr');

            var categoryName = $(".name", currentParentSelector).html();
            var priority = $(".priority", currentParentSelector).html();

            $(".name, .priority, .actions-container").show();
            $(".info-container, .type-container, .paid-status-container").remove();
            $(".action-container").remove();

            var html = '';
            var inputActionContainer = '';

            html += '<div class="info-container">\n' +
                '        <input value="' + categoryName + '" type="text" class="form-control" id="category-name" placeholder="Enter name">\n' +
                '    </div>';

            $(".name", currentParentSelector).after(html);
            $(".name", currentParentSelector).hide();

            html = '<div class="type-container"><select class="form-control selectpicker type-selection" name="type">\n' +
                '                                        <option value="">Default</option>\n' +
                '                                        <option value="non-marketing-campaign">Non-Marketing Campaign</option>\n' +
                '                                        <option value="marketing-campaign">Marketing Campaign</option>\n' +
                '                                    </select></div>';

            $(".type", currentParentSelector).after(html);
            $(".type", currentParentSelector).hide();

            $(".type-selection", currentParentSelector).val($(".type", currentParentSelector).attr('data-selected-value'));

            html = '<div class="paid-status-container">\n' +
                '                                        <input type="checkbox" id="show-to-paid-mark">\n' +
                '                                        Show this category to Paid User</div>';

            $(".paid-status", currentParentSelector).after(html);
            $(".paid-status", currentParentSelector).hide();

            console.log("statt " + $(".paid-status", currentParentSelector).attr('data-status'));
            $("#show-to-paid-mark", currentParentSelector).prop("checked", parseInt($(".paid-status", currentParentSelector).attr('data-status')));

            inputActionContainer += '<div class="action-container" style="padding-top: 10px;">\n ' +
                '<div class="act-tag-loading" style="display: none;float: left;margin-top: 0px;">\n' +
                '                                    <div class="decipher-tags-tag">\n' +
                '                                        <img class="tag-loading-img" src="' + siteUrl + '/public/images/recipients_loader.gif">\n' +
                '                                    </div>\n' +
                '                                </div>' +
                '        <a class="colored-button-icon save-name" data-customer-id="' + contactId + '"><i class="fa fa-check" aria-hidden="true"></i></a>\n' +
                '    <a class="app-delete-button cancel-this-action"><i class="fa fa-close" aria-hidden="true"></i></a>\n' +
                '    </div>';

            $(".actions-container", currentParentSelector).hide();
            $(".actions-container", currentParentSelector).after(inputActionContainer);

            var i;
            var selected;

            html = '<div class="info-container">';
            // html += '<input value="'+priority+'" type="text" class="form-control" id="priority" placeholder="Enter phone number">';
            html += '<select class="form-control selectpicker" id="category-priority">';
            for (i = 1; i <= 10; i++) {
                selected = (i == priority) ? 'selected' : '';

                html += '<option ' + selected + '>' + i + '</option>';
            }
            html += '</select>';
            html += '</div>';

            $(".priority", currentParentSelector).hide();
            $(".priority", currentParentSelector).after(html);
        });

        $(document.body).on('click', '.save-name', function () {
            var categoryName = $("#category-name").val();
            var priority = $("#category-priority").val();
            var type = $(".type-selection").val();
            var campaign_filter = $("#campaign_filter").val();
            var campaign_filter_priority = $("#campaign_filter_priority").val();
            var description = $("#description").val();
            var sampleDescription = $("#sampleDescription").val();
            var settings = $("#settings_module").val();
            var industry = $("#industry").val();
            var niche = $("#niche").val();
            var sys_status = $("#sys_status").val();
            var markAsCompleteCheck = $('#mark-as-complete-checkbox').is(':checked');
            // var showRatingCheck = $('#show-rating').is(':checked');
            // console.log(markAsComplete);
            var markAsComplete;
            if (markAsCompleteCheck) {
                markAsComplete = 1;
            } else {
                markAsComplete = 0;
            }
            // var showRating;
            // if(showRatingCheck) {
            //     showRating = 1;
            // }
            // else {
            //     showRating = 0;
            // }

            // var association = $("#association").val();
            var selected = $('#association option:selected');
            var associated = [];
            if (selected.length !== 0) {
                selected.each(function () {
                    associated.push($(this).val());
                });
            }
            var association = '';
            association = JSON.stringify(Object.assign({}, associated));


            var errorSelector = $("span.help-block.campaign-name");
            var errorSelectorNiche = $("span.help-block.niche-select");

            $(".alert").hide();
            $(".alert").removeClass('alert-success alert-danger');
            errorSelector.addClass('hide-me');
            errorSelector.removeClass('error text-success');

            errorSelectorNiche.addClass('hide-me');
            errorSelectorNiche.removeClass('error text-success');

            if (!categoryName) {
                errorSelector.removeClass('hide-me');
                errorSelector.addClass('error');
                $("small", errorSelector).html('Required Field');
                return false;
            }

            if (!niche) {
                errorSelectorNiche.removeClass('hide-me');
                errorSelectorNiche.addClass('error');
                $("small", errorSelectorNiche).html('Required Field');
                return false;
            }

            var credits = $("#credits").val();
            var content = $("#content").val();

            var typeHtml = $(".type-selection option:selected", currentParentSelector).html();

            if (credits < 0) {
                swal({
                    title: "Info!",
                    text: "Please Enter credits in positive number.",
                    type: "info"
                });

                return false;
            }

            // console.log("typeHtml");
            // console.log(typeHtml);

            var showToPaid = 0;
            var paidStatusMessage = '';

            var contactId = $(this).attr("data-customer-id");

            var currentParentSelector = $(this).parent().closest('tr');

            if ($("#show-to-paid-mark").is(":checked") === true) {
                showToPaid = 1;
            }


            // currentParentSelector.hide();

            // return false;

            if (contactId !== '') {

                showPreloader();

                // if(firstName === '')
                // {
                //     return false;
                // }

                var tagLoader = $(".info-container .tag-loading");
                var textAlert = $(".info-container .text-alert");
                var siteUrl = $('#hfBaseUrl').val();


                $(".action-container a").hide();
                $(".act-tag-loading").show();

                textAlert.hide();
                tagLoader.show();

                // name: categoryName,
                //     priority: priority,
                //     id: contactId,
                //     type: type,
                //     description: description,
                // show_to_paid: showToPaid

                var logo = [];
                if (window.attachedLogoArray.length != 0) {
                    logo = window.attachedLogoArray;
                    // formData.append('logo', logo);
                }

                var formData = new FormData();

                if (logo.length > 0) {
                    // console.log("logo in");
                    $.each(logo, function (i, obj) {
                        formData.append('attach_logo[' + i + ']', obj);
                    });
                }
                var libraryType = $("#library-type").val();


                formData.append('send', 'update-category');
                formData.append('name', categoryName);
                formData.append('id', contactId);
                formData.append('type', type);
                formData.append('campaign_filter', campaign_filter);
                formData.append('campaign_filter_priority', campaign_filter_priority);
                formData.append('priority', priority);
                formData.append('description', description);
                formData.append('sample_description', sampleDescription);
                formData.append('library_type', libraryType);
                formData.append('show_to_paid', showToPaid);
                formData.append('content', content);
                formData.append('credits', credits);
                formData.append('settings', settings);
                formData.append('industry', industry);
                formData.append('niche', niche);
                formData.append('status', sys_status);
                formData.append('association', association);
                formData.append('mark_as_complete_check', markAsComplete);
                // formData.append('show_rating', showRating);

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    type: "POST",
                    url: siteUrl + "/done-me",
                    contentType: false,
                    cache: false,
                    processData: false,
                    data: formData,
                }).done(function (result) {
                    var json = $.parseJSON(result);
                    var statusCode = json.status_code;
                    var statusMessage = json.status_message;
                    var data = json.data;

                    hidePreloader();

                    textAlert.show();
                    var html = '';

                    tagLoader.hide();
                    // contactInput.show();
                    $(".cancel-this-action").click();

                    if (statusCode == 200) {
                        swal({
                            title: "Successful!",
                            text: statusMessage,
                            type: "success"
                        });

                        // $(".name", currentParentSelector).html(categoryName);
                        // $(".priority", currentParentSelector).html(priority);
                        //
                        // $(".type", currentParentSelector).attr('data-selected-value', type);
                        // $(".type", currentParentSelector).html(typeHtml);
                        // $(".paid-status", currentParentSelector).attr('data-status', showToPaid);


                        // $("#contact-add").val('');
                        // textAlert.removeClass('text-danger');
                        // textAlert.addClass('text-success');
                        // textAlert.html(statusMessage);
                        //
                        // console.log(data.id);
                        // var contact = data.id;
                        //
                        // html += '<tr role="row" class="" data-customer-id="'+contact+'">\n' +
                        //     '                                <td class="text-verticle-align">\n' +
                        //     '                                    <div class="checkbox-area">\n' +
                        //     '                                        <span class="custom-checkbox" data-action="single">\n' +
                        //     '                                        <input style="display: none; outline: 0;" id="data-275640" type="checkbox">\n' +
                        //     '                                    </span>\n' +
                        //     '                                    </div>\n' +
                        //     '                                    <div class="add-r-contact-column">\n' +
                        //     '                                        <img src="https://static.parastorage.com/services/shoutout-static/1.2329.0/images/contacts/recipients-empty-contact.png">\n' +
                        //     '                                        <label></label>\n' +
                        //     '                                    </div>\n' +
                        //     '                                </td>\n' +
                        //     '\n' +
                        //     '                                <td class="text-verticle-align">\n' +
                        //     '                                    <div class="add-r-mail-column">\n' +
                        //     '                                        <h3>'+email+'</h3>\n' +
                        //     '                                    </div>\n' +
                        //     '                                </td>\n' +
                        //     '                                <td><div class="actions-container">\n' +
                        //     '   <a class="edit-button edit-contact" data-customer-id="'+contact+'"><i class="mdi mdi-pencil" aria-hidden="true"></i></a>\n' +
                        //     '   \n' +
                        //     ' </div></td>\n' +
                        //     '                            </tr>';
                        //
                        // $('.all-selection').after(html);
                        //
                        // setTimeout(function () {
                        //     textAlert.hide();
                        // }, 3000);
                    } else {
                        swal({
                            title: "Error!",
                            text: statusMessage,
                            type: "error"
                        });
                        // textAlert.removeClass('text-success');
                        // textAlert.addClass('text-danger');
                        // textAlert.html(statusMessage);
                    }
                });
            }
        });

        $(document.body).on('click', '.cancel-this-action', function () {
            $(".info-container, .type-container, .paid-status-container, .action-container").remove();
            $(".name, .type, .priority, .actions-container").show();
        });


        var currentTarget;
        $(document.body).on('click', '.remove-me', function () {
            var target = $(this).attr('data-target-id');
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

            html += '<div class="modal-body"><div class="interface-module" style=""><div class="alert" style="display: none;"></div><div class="remove-business-modal"><div class="remove-action-note"><img src="' + baseUrl + '/public/images/delete-listing.png"> <h3 style="font-size: 22px;margin-bottom: 25px;font-weight: 400;color: #000;">Are you sure you want to remove this Category?</h3>' +
                '<p style="color: #000;font-size: 15px;">Deleting Category will also delete all your linked tasks from admin panel and user panel.</p></div></div></div></div>';
            html += '<div class="modal-footer"><button type="button" class="btn btn-default close-modal" data-dismiss="modal">Cancel</button><button type="button" class="btn btn-danger deleting-processed">Delete</button></div>';

            mainModel.modal('show');
            $(".modal-header").after(html);

            return false;
        });

        $(document.body).on('click', '.change-status', function () {
            var siteUrl = $('#hfBaseUrl').val();
            var template = $(this).attr('data-target-id');
            var status = $(this).attr('data-status');
            var currentTarget = $(this);
            var parentSel = currentTarget.parent('.status');

            showPreloader();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                type: "POST",
                url: siteUrl + "/done-me",
                data: {
                    send: 'admin-task-status',
                    id: template,
                    status: status,
                    target: 'category',
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

                if (status == 0) {
                    parentSel.html('<span class="inactive change-status" data-target-id="' + template + '" data-status="1">Drafts</span>');
                } else {
                    parentSel.html('<span class="active change-status" data-target-id="' + template + '" data-status="0">Active</span>');
                }


                hidePreloader();

                if (statusCode == 200) {

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
                    send: 'admin-category-delete',
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
    </script>
    <script>
        $(document).on('click', "#logo", function (e) {
            $("#add_logo_image").click();
        });

        function setupReader(file, preview) {
            // console.log("file");
            // console.log(file);

            // console.log("preview");
            // console.log(preview);
            var reader = new FileReader();

            // console.log("reader");
            // console.log(reader.result);

            reader.onloadend = function () {
                preview.src = reader.result;

            };

            // console.log("preview src");
            // console.log(preview.src);

            if (file) {
                // console.log("file");
                // console.log(file);

                reader.readAsDataURL(file);
            } else {
                preview.src = "";
            }
        }

        $(document).on('change', "#add_logo_image", function (e) {
            // console.log("add_logo_image");
            var imagePicker = $("#add_logo_image");
            var attachedImages = $('.logo-image-container .attached_images_container .show-image');
            // console.log(attachedImages);

            var fileUploadStatus = false;
            var NumOfAttachedImages = attachedImages.length;

            var limitsArray = [];

            var files = document.querySelector("#add_logo_image").files;

            // console.log("add_logo_image > NumOfAttachedImages");
            // console.log(NumOfAttachedImages);

            // console.log("add files");
            // console.log(files);


            for (var y = 0; y < files.length; y++) {
                var file = files[y];
                var fileType = file.type;
                var fileSize = file.size;

                var validImageTypes = ['image/png', 'image/jpeg'];
                var checkFileType = $.inArray(fileType, validImageTypes);
                //var res = fileType.match(/image\.*/i);
                if (checkFileType == -1) {
                    $('.logo-image-container .limit_exceeded_error_msg').text("File format is invalid. Please upload valid image formats like <jpg,png>.");
                    $('.logo-image-container .limit_exceeded_error_msg_container').removeClass('hide');

                    //$('#add_post_modal .help-block small').text('').text("File format is invalid. Please upload valid image formats like <jpg,png>.");

                    imagePicker.val('');
                    return false;
                }

                if (fileSize > 10485760) {
                    $('.logo-image-container .limit_exceeded_error_msg').text("File size cannot be more than 10MB.");
                    $('.logo-image-container .limit_exceeded_error_msg_container').removeClass('hide');
                    imagePicker.val('');
                    return false;
                }

            }

            $('.logo-image-container .limit_exceeded_error_msg_container').addClass('hide');
            // var allowedImages = minLimit;

            var images = attachedImages;
            var imagesLength = images.length;
            var customImgId = '';

            if (images.length == 0) {
                customImgId = images.length + 1;
            } else {
                var lastImageEl = images[images.length - 1];
                var lastImageClass = $(lastImageEl).find('img').attr('class');
                var num = parseInt(lastImageClass.match(/\d+/));
                customImgId = num + 1;
            }

            for (var x = 0; x < files.length; x++) {
                var file = files[x];
                var fileType = file.type;
                var fileSize = file.size;

                var validImageTypes = ['image/png', 'image/jpeg'];
                var checkFileType = $.inArray(fileType, validImageTypes);
                //var res = fileType.match(/image\.*/i);
                if (checkFileType == -1) {
                    $('.logo-image-container .limit_exceeded_error_msg').text("File format is invalid. Please upload valid image formats like <jpg,png>.");
                    $('.logo-image-container .limit_exceeded_error_msg_container').removeClass('hide');

                    //$('#add_post_modal .help-block small').text('').text('Invalid Image');

                    imagePicker.val('');
                    return false;
                }

                if (fileSize > 10485760) {
                    $('.logo-image-container .limit_exceeded_error_msg').text("File size cannot be more than 10MB.");
                    $('.logo-image-container .limit_exceeded_error_msg_container').removeClass('hide');
                    imagePicker.val('');
                    return false;
                }

                var newCustomImgId = customImgId + x;
                var imageTemplate = '<div class="small-4 columns show-image"><img data-name="' + file.name + '" class="attached_image_' + newCustomImgId + '" src="">' +
                    '<span class="remove_image" style="display: none;">x</span> </div>';
                $('.logo-image-container .attached_images_container').html(imageTemplate);
                var preview = document.querySelector('.logo-image-container img.attached_image_' + newCustomImgId);

                // console.log("in");
                // console.log(preview);
                // return false;
                setupReader(file, preview);

                window.attachedLogoArray[0] = file;

                fileUploadStatus = true;
                // window.attachedLogoArray = file;
            }

            imagePicker.val('');

            if (fileUploadStatus === true) {
                // console.log("ready to logo Image save");
                // $("form.validate-image").submit();
            }
        });

        $(document).on('click', ".remove_image", function (e) {
            // console.log("called");
            if (typeof ($(this).closest('.show-image').attr('data-attachment-id')) != 'undefined') {
                // console.log("has " + $(this).closest('.form-group').attr('id'));
                var attachmentId = '';
                if ($(this).closest('.form-group').attr('id') === "logo-container") {
                    // console.log("inside logo");
                    // console.log(window.attachedLogoDeletedArray);
                    attachmentId = $(this).closest('.show-image').attr('data-attachment-id');
                    window.attachedLogoDeletedArray.push(attachmentId);

                    // console.log("Logo inside after att " + attachmentId);
                    // console.log(window.attachedLogoDeletedArray);
                } else {
                    // console.log("inside");
                    // console.log(window.attachedDeletedArray);
                    attachmentId = $(this).closest('.show-image').attr('data-attachment-id');
                    window.attachedDeletedArray.push(attachmentId);

                    // console.log("inside after att " + attachmentId);
                    // console.log(window.attachedDeletedArray);
                }
            }

            var imageName = $(this).closest('.show-image').find('img').attr('data-name');
            window.attachedImagesArray = $.grep(window.attachedImagesArray, function (item) {
                return item.name !== imageName;
            });

            window.attachedLogoArray = $.grep(window.attachedLogoArray, function (item) {
                return item.name !== imageName;
            });

            $(this).closest('.show-image').remove();
            var images = $('.attached_images_container .show-image');
            var imagesLength = images.length;

            if (imagesLength == 0) {
                $('#add_video_btn').removeClass('disabled').removeAttr('disabled');
                $('span.add-video-btn-disabled-tooltip').tooltip('destroy');
            } else if (imagesLength > 0) {
                $('#add_video_btn').addClass('disabled').attr('disabled', 'disabled');
            }
            if (imagesLength < 4) {
                $('.help-block small').text('');
            }
            $('#add_image_file').val('');

            /*-----------Images Limit Validation Code -------------------*/

            $('#post_now_btn,.send_post_options button').removeClass('disabled').removeAttr('disabled');
            $('span.posts-btn-disabled-tooltip').tooltip('destroy');

            $('#add_post_modal .limit_exceeded_error_msg').text('');
            $('.limit_exceeded_error_msg_container').addClass('hide');

            var facebook_images_limit = window.facebook_images_limit;
            var twitter_images_limit = window.twitter_images_limit;
            var instagram_images_limit = window.instagram_images_limit;
            var linkedin_images_limit = window.linkedin_images_limit;

            var attachedImages = $('#add_post_modal .attached_images_container .show-image');
            var NumOfAttachedImages = attachedImages.length;

            var remainingFacebookImages = facebook_images_limit - NumOfAttachedImages;
            var remainingTwitterImages = twitter_images_limit - NumOfAttachedImages;
            var remainingInstagramImages = instagram_images_limit - NumOfAttachedImages;
            var remainingLinkedinImages = linkedin_images_limit - NumOfAttachedImages;

            var checkImagesError = false;
            (!$('.facebook-social-media-button.selected-social-media').length == 0 && remainingFacebookImages < 0) ? checkImagesError = true : '';
            (!$('.twitter-social-media-button.selected-social-media').length == 0 && remainingTwitterImages < 0) ? checkImagesError = true : '';
            (!$('.instagram-social-media-button.selected-social-media').length == 0 && remainingInstagramImages < 0) ? checkImagesError = true : '';
            (!$('.linkedin-social-media-button.selected-social-media').length == 0 && remainingLinkedinImages < 0) ? checkImagesError = true : '';

            if (checkImagesError) {

                var limitsImagesArray = [], limitedImagesNetworks = [];
                var selectedNetworksImagesArr = $('.select-social-media-buttons-container button.selected-social-media');
                $(selectedNetworksImagesArr).each(function (a, b) {
                    var selectedNetwork = $(b);
                    if ($(b).hasClass('facebook-social-media-button') && remainingFacebookImages < 0) {
                        limitsImagesArray.push(facebook_images_limit);
                        limitedImagesNetworks.push('Facebook');
                    } else if ($(b).hasClass('twitter-social-media-button') && remainingTwitterImages < 0) {
                        limitsImagesArray.push(twitter_images_limit);
                        limitedImagesNetworks.push('Twitter');
                    } else if ($(b).hasClass('instagram-social-media-button') && remainingInstagramImages < 0) {
                        limitsImagesArray.push(instagram_images_limit);
                        limitedImagesNetworks.push('Instagram');
                    } else if ($(b).hasClass('linkedin-social-media-button') && remainingLinkedinImages < 0) {
                        limitsImagesArray.push(linkedin_images_limit);
                        limitedImagesNetworks.push('Linkedin');
                    }
                });

                var minImagesLimit = arrayMin(limitsImagesArray);

                if (limitedImagesNetworks.length > 1) {
                    var limitedImagesNetworksFirstHalf = limitedImagesNetworks.slice(0, limitedImagesNetworks.length - 1);
                    var limitedImagesNetworksFirstHalfStr = limitedImagesNetworksFirstHalf.join(", ");
                    var limitedImagesNetworksSecondHalf = limitedImagesNetworks.slice(limitedImagesNetworks.length - 1, limitedImagesNetworks.length);
                    var limitedImagesNetworksStr = limitedImagesNetworksFirstHalfStr + " and " + limitedImagesNetworksSecondHalf;
                    var strMsg = "Limit exceeded of images(s) for " + limitedImagesNetworksStr;
                } else {
                    var limitedImagesNetworksStr = limitedImagesNetworks.join(", ");

                    if (minImagesLimit == 0) {
                        var strMsg = 'We currently don\'t support publishing multimedia to ' + limitedImagesNetworksStr + '. Deselect ' + limitedImagesNetworksStr + ' if you want to publish a multimedia post to other social media pages.';
                    } else {
                        var strMsg = "Can’t upload more than " + minImagesLimit + " images(s) on " + limitedImagesNetworksStr;
                    }

                }

                $('#add_post_modal .limit_exceeded_error_msg').text('').text(strMsg);
                $('.limit_exceeded_error_msg_container').removeClass('hide');


                $('#post_now_btn,.send_post_options button').addClass('disabled').attr('disabled', 'disabled');
                $('span.posts-btn-disabled-tooltip').tooltip('destroy');
                setTimeout(function () {
                    $("span.posts-btn-disabled-tooltip").tooltip({
                        placement: 'top',
                        title: "Post cannot be made as image(s) limit exceeded."
                    });
                }, 200);
            }

        });


        $(document).on('click', ".remove_link", function (e) {
            $(this).parent().addClass('hide');
        });

        $(document).on('click', ".remove_limit_exceeded_error", function (e) {
            $(this).parent().addClass('hide');
        });
    </script>

    <script src="{{ asset('public/js/industry-niche.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('public/plugins/bootstrap-multiselect/bootstrap-multiselect.js') }}"></script>
    <script>

        $(function () {

            // getTemplate(52);

            $(".select2").select2();

            $('#association').multiselect({
                includeSelectAllOption: true,
                selectAllText: 'SELECT ALL',
                allSelectedText: 'All Selected',
                // nonSelectedText: 'Choose Plan',
                selectAllNumber: false,
                buttonText: function (options, select) {
                    // $(myDropdown).find("option").length
                    var totalSeleted = $('#association').find("option").length;
                    if (options.length === 0) {
                        // console.log(options.length);
                        // console.log(totalSeleted);
                        return '';
                    } else if (options.length === totalSeleted) {
                        // console.log(options.length);
                        // console.log(totalSeleted);
                        return 'All Selected';
                    } else if (options.length >= 1) {
                        // console.log(options.length);
                        // console.log(totalSeleted);
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
    <script>
        $(function () {

            var categoryId = $('#catId').val();

            var siteUrl = $('#hfBaseUrl').val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                type: "POST",
                url: siteUrl + "/done-me",
                data: {
                    send: 'get-linked-associations',
                    id: categoryId,
                }
            }).done(function (result) {
                var Json = $.parseJSON(result);
                var data = Json.data;
                var list = data.associationsList;

                if (list) {
                    var planVal = '';
                    $.each(list, function (index, value) {
                        planVal = value;
                        $("#association option[value='" + planVal + "']").attr("selected", true);
                        $("#association").multiselect("refresh");
                    });
                }

            });
        })
    </script>
    <script>
        $('#type').on('change', function () {
            var abc = this.value;
            if (abc === 'non-marketing-campaign') {
                $('#mark-as-complete-outer').show();
            } else {
                var checkbox = $('#mark-as-complete-checkbox').is(':checked');
                if (checkbox) {
                    $("#mark-as-complete-checkbox").prop('checked', false);
                }
                $('#mark-as-complete-outer').hide();

            }
            // console.log(abc)
        });
    </script>
    <script>
        $(document).ready(function () {
            var abc = $("#type").val();
            if (abc === 'non-marketing-campaign') {
                $('#mark-as-complete-outer').show();
            } else {
                $('#mark-as-complete-outer').hide();
            }
            // console.log(abc);
            $('.summernote').summernote({
                height: 250
            });
        });
    </script>
@endsection
