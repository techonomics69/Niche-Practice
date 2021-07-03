<?php $dynamicAppName = 'NichePractice'; ?>
<div class="add-recipients-container steps-section" style="display: none;">
    <div class="contact-input-container">
        <div class="contacts-input">
            <div class="contacts-input__label">To:</div>
            <div class="contacts-input__input-wrapper">
                <div>
                    <div>
                        <div class="decipher-tags">
                            <div style="display: none;" class="tag-wrapper">
                                <div class="decipher-tags-tag contact-class">
                                                            <span class="tag-image"><img
                                                                        src="http://gravatar.com/avatar/03f346b3c9615a0ae57bbff127e27a42?d=blank&amp;s=46"></span>
                                    <span class="tag-text">fewf</span><i
                                            class="recipients-remove-tag tags-tag-close"></i></div>
                            </div>

                            <div class="tag-wrapper tag-wrapper--input">
                                <input id="contact-add" placeholder="Add Email Addresses"
                                       class="decipher-tags-input ng-valid ng-touched ng-dirty ng-valid-parse ng-empty"
                                       style="top: -59px; left: 50px;" />

                                <div class="tag-loading" style="display:none; float: left;margin-top: 10px;">
                                    <div class="decipher-tags-tag">
                                        <img class="tag-loading-img" src="{{ asset('public/images/recipients_loader.gif') }}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-alert" style="display:none; margin-bottom: 20px;"></div>
    </div>

    <div class="row" style="margin-bottom: 20px; display: none;">
        <div class="col-md-12">
            <div class="add-recipients-input">
                <div class="bootstrap-tagsinput">
                    <input type="text" placeholder="Add Contact Names, Email Addresses, or Labels" />
                </div>
                <input type="text" value="" data-role="tagsinput" placeholder="Add Contact Names, Email Addresses, or Labels" style="display: none;" />
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="add-recipients-table-container">
                <div class="table-responsive">
                    <table id="add-recipients-table" class="add-recipients-table dataTable" style="width:100%">
                        <tbody>
                        <tr class="all-selection">
                            <td class="text-verticle-align">
                                <div class="checkbox-area">
                                                            <span class="custom-checkbox" data-action="all">
                                                                    <input style="display: none; outline: 0;" id="all"
                                                                           type="checkbox" checked="checked"/>
                                                                </span>
                                </div>
                                <div class="add-r-contact-column">
                                    <label>All</label>
                                </div>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>

                        @foreach($records as $record)
                            <tr role="row" class="" data-customer-id="{{ $record['id'] }}">
                                <td class="text-verticle-align">
                                    <div class="checkbox-area">

                                        <span class="custom-checkbox {{ (!empty($record['recipient_id'])) ? 'custom-checkbox--checked' : '' }}" data-action="single">
{{--                                        <input style="display: none; outline: 0;" id="data-{{ $record['id'] }}" type="checkbox" checked="checked" />--}}
                                        <input style="display: none; outline: 0;" id="data-{{ $record['id'] }}" type="checkbox" />
                                    </span>
                                    </div>
                                    <div class="add-r-contact-column">
                                        <img src="{{ asset('public/images/recipients-empty-contact.png') }}" />
                                        <label>
                                            <span class="first-name-val">{{ $record['first_name'] }}</span>
                                            <span class="last-name-val">{{ $record['last_name'] }}</span>
                                        </label>
                                    </div>
                                </td>

                                <td class="text-verticle-align">
                                    <div class="add-r-mail-column">
                                        <h3>{{ $record['email'] }}</h3>
                                    </div>
                                </td>
                                <td class="text-verticle-align">
                                    <h3 class="phone-number-val">{{ $record['phone_number'] }}</h3>
                                </td>
                                <td>
                                    <div class="actions-container">
                                        <a class="colored-button-icon edit-contact" data-customer-id="{{ $record['id'] }}"><i class="mdi mdi-pencil" aria-hidden="true"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

