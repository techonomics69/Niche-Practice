<?php use \Modules\Business\Http\Controllers\HomeController;?>
@extends('admin.layout')

@section('title', $pageTitle)

@section('header')
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="{{ route('adminDashboard') }}">{{ appName() }}</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <!-- THE ACTUAL CONTENT -->
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title m-t-10">
                        Dashboard
                    </h3>
                </div>

                <div class="box-body">
                    <div class="row" style="margin-bottom: 40px;">
{{--                        <div class="col-xs-2 review-status-box" style="padding-left: 15px;">--}}
{{--                            <div class="listing-box">--}}
{{--                                <h3>0</h3>--}}
{{--                                <label>Free Trials</label>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="col-xs-6 col-sm-4 col-md-2 review-status-box review-status-box-1" style="padding-left: 15px;">
                            <div class="listing-box1">

                                <h3>{{$freeTrials}}</h3>
                                <label>Free Trials</label>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4 col-md-2 review-status-box" style="padding-left: 15px;">
                            <div class="listing-box1">

                                <h3>{{$subscriptionCount}}</h3>
                                <label>Subscribers</label>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4 col-md-2 review-status-box review-status-box-1" style="padding-left: 15px;">
                            <div class="listing-box2">

                                <h3>{{$creditsSum}}</h3>
                                <label>Credits Purchased</label>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4 col-md-2 review-status-box" style="padding-left: 15px;">
                            <div class="listing-box3">

                                <h3>{{$totalCampaignPurchased}}</h3>
                                <label>Campaigns Purchased</label>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4 col-md-2 review-status-box review-status-box-1" style="padding-left: 15px;">
                            <div class="listing-box4">

                                <h3>{{$BillingToday}}</h3>
                                <label>Billing Today</label>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4 col-md-2 review-status-box" style="padding-left: 15px;">
                            <div class="listing-box5">

                                <h3>{{$subscriptionCount}}</h3>
                                <label>billing Total</label>
                            </div>
                        </div>

                    </div>

                    <div id="crudTable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="d-table-head">
                                    <div class="row">
                                        <div class="col-sm-4 col-md-5">
                                            <div class="form-group head-search-review">
                                                <input id="search-table" type="text" class="form-control"
                                                       placeholder="Search a user/practice name/email/phone"/>
                                            </div>
                                        </div>

                                        <div class="col-sm-3 col-md-3">
                                            <div class="form-group sources-list" style="width: 100%;">
                                                <select
                                                    style="height: 38px;width: 100%;padding-left: 10px;padding-right: 15px;">
                                                    <option>Select Status</option>
                                                    <option>Free Trial</option>
                                                    <option>Paid</option>
                                                </select>
                                            </div>
                                        </div>

                                        {{--                                    <div class="col-sm-2 col-md-2">--}}
                                        {{--                                        <div class="form-group status-list">--}}
                                        {{--                                            <div class="dropdown" style="margin-left: 0;">--}}
                                        {{--                                                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" data-text="All Status">--}}
                                        {{--                                                    <span class="filter-label">All Status</span>--}}
                                        {{--                                                    <span class="caret"></span>--}}
                                        {{--                                                </button>--}}

                                        {{--                                                <ul data-filter-type="status-list" data-filter="5" class="dropdown-menu" aria-labelledby="dropdownMenu1">--}}
                                        {{--                                                    <li class="source-row" data-source="In Progress">--}}
                                        {{--                                                        <a href="javascript:void(0);">--}}
                                        {{--                                                            <div class="checkbox checkbox-primary">--}}
                                        {{--                                                                <input id="inprogress" class="styled" type="checkbox">--}}
                                        {{--                                                                <label for="inprogress">--}}
                                        {{--                                                                    <span style="margin-left: 0;margin-right: 6px;" class="inprogress"></span> In Progress--}}
                                        {{--                                                                </label>--}}
                                        {{--                                                            </div>--}}
                                        {{--                                                        </a>--}}
                                        {{--                                                    </li>--}}

                                        {{--                                                    <li class="source-row" data-source="Do Not Respond">--}}
                                        {{--                                                        <a href="javascript:void(0);">--}}
                                        {{--                                                            <div class="checkbox checkbox-primary">--}}
                                        {{--                                                                <input id="notrespond" class="styled" type="checkbox">--}}
                                        {{--                                                                <label for="notrespond">--}}
                                        {{--                                                                    <span style="margin-left: 0;margin-right: 6px;" class="notrespond"></span> Do Not Respond--}}
                                        {{--                                                                </label>--}}
                                        {{--                                                            </div>--}}
                                        {{--                                                        </a>--}}
                                        {{--                                                    </li>--}}

                                        {{--                                                    <li class="source-row" data-source="Responded">--}}
                                        {{--                                                        <a href="javascript:void(0);">--}}
                                        {{--                                                            <div class="checkbox checkbox-primary">--}}
                                        {{--                                                                <input id="responded" class="styled" type="checkbox">--}}
                                        {{--                                                                <label for="responded">--}}
                                        {{--                                                                    <span style="margin-left: 0;margin-right: 6px;" class="responded"></span> Responded--}}
                                        {{--                                                                </label>--}}
                                        {{--                                                            </div>--}}
                                        {{--                                                        </a>--}}
                                        {{--                                                    </li>--}}
                                        {{--                                                </ul>--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </div>--}}
                                        {{--                                    </div>--}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-12 col-xl-12">
                                <div class="overflow-x">
                                  <table    id="taskTable" class="table table-bordered table-striped display dataTable"
                                       role="grid">
                                     <thead>
                                    <tr role="row">
                                        {{--                                        <th>ID</th>--}}
                                        <th>Online Status</th>
                                        <th>Name</th>
                                        <th>Practice Name</th>
                                        <th>Email Address</th>
{{--                                        <th>Phone</th>--}}
                                        <th>Niche</th>
                                        <th>Created</th>
                                        <th>Status</th>
                                        <th>Subscription</th>
                                        <th>Account Status</th>
                                        <th>Completion Status</th>
                                        {{--                                        <th style="width: 120px;">Action</th>--}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($records))
                                        <?php
                                        $incre = 0;
                                        ?>
                                        @foreach($records as $key => $record)
                                            <tr class="selected">
                                                <td>
                                                    <div class="text-center">
                                                        @if($online[$key] == 'active')
                                                            <i class="fa fa-circle text-success"></i>
                                                        @else
                                                            <i class="fa fa-circle" style="color: #ffc107"></i>
                                                        @endif
                                                    </div>
                                                </td>
                                                {{--                                            <td>--}}
                                                {{--                                                {{ $record['id'] }}--}}
                                                {{--                                            </td>--}}
                                                <td>
                                                    <a href="{{route('admin.clientInfo')}}">{{ $record['first_name'] . ' ' . $record['last_name'] }}</a>

{{--                                                    @if(!empty($record['login_status']) && $record['login_status'] == 1)--}}
{{--                                                        <i class="fa fa-circle text-success"></i>--}}
{{--                                                     @else--}}
{{--                                                        <i class="fa fa-circle" style="color: #ffc107"></i>--}}
{{--                                                    @endif--}}
                                                </td>

                                                <td>
                                                    {{ getIndexedvalue(@$record['business'][0], 'practice_name') }}
                                                </td>

                                                <td class="status">
                                                    <span class="user-email">{{ $record['email'] }}</span>
                                                    <br />
                                                    <a data-user-email="{{ $record['email'] }}" style="color: #3c8dbc;" href="javascript:void(0)" class="btn btn-sm btn-link show-user-profile"><i class="fa fa-user"></i> Log in</a>
{{--                                                    <a data-user-email="{{ $record['email'] }}" style="color: #3c8dbc;" href="javascript:void(0)" class="btn btn-sm btn-link show-user-profile" data-target-id="9"><i class="fa fa-user"></i> Delete</a>--}}
                                                    <a style="padding-left: 0px;" data-user-email="{{ $record['email'] }}" href="javascript:void(0)" class="btn btn-sm btn-link remove-me" data-target-id="{{ $record['id'] }}"><i class="fa fa-trash"></i> Delete</a>

                                                    <a style="padding-left: 0px;" data-user-email="{{ $record['email'] }}" href="javascript:void(0)" class="btn btn-sm btn-link edit-me" data-target-id="{{ $record['id'] }}"><i class="fa fa-edit"></i> Edit</a>

{{--                                                    <a class="inactive change-status" data-target-id="4" data-status="1">Drafts</a>--}}
                                                </td>

{{--                                                <td>--}}
{{--                                                    {{ getIndexedvalue(@$record['business'][0], 'phone') }}--}}
{{--                                                </td>--}}

                                                <td>
                                                    @if( !empty ( getIndexedvalue(@$record['business'][0]['niche'], 'niche') ) )
                                                        <div class="nicheName" id="nicheName" data-niche-id="{{$record['business'][0]['niche_id']}}">
                                                            {{ getIndexedvalue(@$record['business'][0]['niche'], 'niche') }}
                                                        </div>
                                                    @endif
                                                </td>

                                                <td>
                                                    {{ $record['created_at'] }}
                                                </td>

                                                <td>
                                                    @if ($record['subscriptions'])
                                                        Paid <br />
                                                    @else
                                                        Free Trial <br />
                                                    @endif
                                                </td>

                                                <?php
                                                $incre++;
                                                $statusDaysNumber = 0;
                                                if ($record['subscriptions']){
                                                    $statusDaysA = nextInvoice($record['subscriptions'][0]['created_at']);
                                                    $statusDays = $statusDaysA['status'];
                                                    $statusDaysNumber = $statusDaysA['days'];
//                                                    print_r("abc " . nextInvoice($record['subscriptions']));
//                                                    exit;
//                                                    $statusDaysNumber = nextInvoice($record['subscriptions'][0])['days'];
                                                }
                                                else
                                                {
                                                    $statusDays = trailEnds($record['trial_ends_at'])['status'];
                                                    $statusDaysNumber = trailEnds($record['trial_ends_at'])['days'];
                                                }
                                                ?>
                                                <td data-order="<?php echo intval($statusDaysNumber); ?>">
                                                    {{ $statusDays }}
                                                </td>

                                                <td class="status">
                                                    @if($record['account_status'] == 'deleted' && $record['delete_by'] == 1)
                                                        <span data-user-email="{{ $record['email'] }}" class="inactive change-status" data-target-id="{{ $record['id'] }}" data-status="">Drafts</span>
                                                    @elseif($record['account_status'] == 'deleted')
                                                        <span data-user-email="{{ $record['email'] }}" class="inactive change-status" data-target-id="{{ $record['id'] }}" data-status="">Inactive</span>
                                                    @else
                                                        <span data-user-email="{{ $record['email'] }}" class="active change-status" data-target-id="{{ $record['id'] }}" data-status="deleted">Active</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
{{--                                                    <div>--}}
{{--                                                        <p style="color: #626262;"><i class="fa fa-check tick " ></i> <del>Practice Information</del></p>--}}
{{--                                                    </div>--}}
{{--                                                          {{ getIndexedvalue(@$record['business'][0], 'business_id') }}--}}
                                                            <?php
                                                                $p1 = 25;
                                                            ?>
{{--                                                          {{ $record['id'] }}--}}
{{--                                                          {{ getIndexedvalue(@$reviews['records'][0], 'reviewer') }}--}}


                                                    <?php

//                                                    echo $record['moduleView'];

                                                    ?>
{{--                                                    @if(!empty($reviews))--}}
{{--                                                            @if(!empty($reviews[$key]['records']) || !empty($negativeReviews[$key] ) )--}}
                                                                <?php
//                                                        $p2 = 20;
//                                                                    print_r($reviews[$key]['records']) ;

//                                                                print_r ($reviews[$key]['records'][0] );
                                                        ?>
{{--                                                                <p>abc</p>--}}

{{--                                                                <div>--}}
{{--                                                                    <p  style="color: #626262;"><i class="fa fa-check tick"></i> <del>Online Patient Reviews</del></p>--}}
{{--                                                                </div>--}}
{{--                                                            @else--}}
                                                                <?php
//                                                                    $p2 = 0;
                                                                ?>
{{--                                                                <div>--}}
{{--                                                                    <p  style="color: #626262;"><i class="fa fa-check grey-tick"></i> Online Patient Reviews</p>--}}
{{--                                                                </div>--}}
{{--                                                            @endif--}}
                                                            <?php
                                                                if (!empty($webDomain[$key]['domain'])) {
//
                                                            ?>
                                                    <?php
                                                    $p3 = 25;
                                                    ?>
{{--                                                                    <div>--}}
{{--                                                                        <p  style="color: #626262;"><i class="fa fa-check tick"></i><del>Website SEO Audit</del></p>--}}
{{--                                                                    </div>--}}
                                                            <?php
                                                               }
//}
                                                            else{
                                                    $p3 = 0;
                                                            ?>
{{--                                                                    <div>--}}
{{--                                                                        <p  style="color: #626262;"><i class="fa fa-check grey-tick"></i> Website SEO Audit</p>--}}
{{--                                                                    </div>--}}
                                                            <?php
                                                            }
                                                            ?>
                                                    @if(!empty( $businessLogo[$key]['records']['logo'] ) )
                                                    <?php
                                                        $p4 = 25;
                                                        ?>
{{--                                                        <div>--}}
{{--                                                            <p  style="color: #626262;"><i class="fa fa-check tick"></i><del>Add Practice Logo</del></p>--}}
{{--                                                        </div>--}}
                                                    @else
                                                        <?php
                                                        $p4 = 0;
                                                        ?>
{{--                                                        {{ $businessLogo[$key]['records']['logo'] }}--}}
{{--                                                        <div>--}}
{{--                                                            <p  style="color: #626262;"><i class="fa fa-check grey-tick"></i>Add Practice Logo</p>--}}
{{--                                                        </div>--}}
{{--                                                    @endif--}}
                                                    @endif
                                                    <?php
                                                    if ( (!empty($socialMedia[$key]['Facebook']) && $socialMedia[$key]['Facebook']['status'] == 'connected') || ( !empty($socialMedia[$key]['Twitter']) && $socialMedia[$key]['Twitter']['status'] == 'connected' ) ) {
                                                    $p5 = 25;
                                                        ?>
{{--                                                    <div>--}}
{{--                                                        <p  style="color: #626262;"><i class="fa fa-check tick"></i><del> Connect Social Media</del></p>--}}
{{--                                                    </div>--}}
                                                    <?php
                                                    }else{
                                                    $p5 = 0;
                                                    ?>
{{--                                                    <div>--}}
{{--                                                        <p  style="color: #626262;"><i class="fa fa-check grey-tick"></i> Connect Social Media</p>--}}
{{--                                                    </div>--}}
                                                    <?php

                                                    }
                                                    ?>
                                                  <h4 class="tip" style="cursor: pointer" data-tip="tip-a{{$key}}"><span>{{ $p1 + $p3 + $p4 + $p5 }}% </span> </h4>



                                                    <!-- Tips content -->
                                                    <div id="tip-a{{$key}}" class="tip-content hidden">
                                                        <div>
                                                            <p style="color: #ffffff;"><i class="fa fa-check tick " ></i> <del>Practice Information</del></p>
                                                        </div>
{{--                                                        @if(!empty($reviews[$key]['records']) || !empty($negativeReviews[$key]) )--}}
{{--                                                            <div>--}}
{{--                                                                <p  style="color: #ffffff;"><i class="fa fa-check tick"></i> <del>Online Patient Reviews</del></p>--}}
{{--                                                            </div>--}}
{{--                                                        @else--}}
{{--                                                            <div>--}}
{{--                                                                <p  style="color: #ffffff;"><i class="fa fa-check grey-tick"></i> Online Patient Reviews</p>--}}
{{--                                                            </div>--}}
{{--                                                        @endif--}}
                                                        <?php
                                                        if (!empty($webDomain[$key]['domain'])) {
                                                        ?>
                                                        <div>
                                                            <p  style="color: #ffffff;"><i class="fa fa-check tick"></i><del>Add Website URL (SEO Audit)</del></p>
                                                        </div>
                                                        <?php
                                                        }
                                                        else{
                                                        ?>
                                                        <div>
                                                            <p  style="color: #ffffff;"><i class="fa fa-check grey-tick"></i>Add Website URL (SEO Audit)</p>
                                                        </div>
                                                        <?php
                                                        }
                                                        ?>
                                                        @if(!empty( $businessLogo[$key]['records']['logo'] ) )

                                                            <div>
                                                                <p  style="color: #ffffff;"><i class="fa fa-check tick"></i><del>Add Practice Logo</del></p>
                                                            </div>
                                                        @else
                                                            <div>
                                                                <p  style="color: #ffffff;"><i class="fa fa-check grey-tick"></i>Add Practice Logo</p>
                                                            </div>
                                                        @endif
                                                        <?php
                                                        if ( (!empty($socialMedia[$key]['Facebook']) && $socialMedia[$key]['Facebook']['status'] == 'connected') || ( !empty($socialMedia[$key]['Twitter']) && $socialMedia[$key]['Twitter']['status'] == 'connected' ) ) {
                                                        ?>
                                                            <div>
                                                                <p  style="color: #ffffff;"><i class="fa fa-check tick"></i><del> Connect Social Media</del></p>
                                                            </div>
                                                        <?php
                                                            }
                                                            else {
                                                        ?>
                                                            <div>
                                                                <p  style="color: #ffffff;"><i class="fa fa-check grey-tick"></i> Connect Social Media</p>
                                                            </div>
                                                        <?php
                                                            }
                                                        ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                  </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div><!-- /.box -->
        </div>
    </div>
    <input type="hidden" name="totalTrial" id="totalTrial" value="0" >
@endsection

@section('after_styles')
    <link rel="stylesheet" href="{{ asset('public/admin/adminlte/plugins/datatables/dataTables.bootstrap.css') }}">
    <style>
        /* tooltip link */



        .dataTables_paginate
        {
            display: none;
        }
        .dataTables_filter
        {
            display: none;
        }
        .d-table-head {
            padding: 0 25px;
            margin-bottom: 20px;
        }
        .d-table-head .dropdown {
            margin: 0 20px;
        }
        .reviews-panel .d-table-head .dropdown {
            margin: 0 15px;
        }
        .d-table-head .btn-default:active:focus {
            background: #fafafa;
        }
        .d-table-head .btn-default.active, .btn-default:active, .open>.dropdown-toggle.btn-default {
            background: #fafafa;
        }
        .d-table-head .head-search-review .form-control {
            border: 1px solid #a6a7af;
            border-radius: 3px;
            width: 100%;
            display: block;
            height: 38px;
        }
        .form-group.head-search-review {
            position: relative;
            display: block;
            width: 100% !important;

        }
        .head-search-review:before {
            font-family: FontAwesome;
            content: "\f002";
            color: #CFCFD3;
            position: absolute;
            font-size: 16px;
            width: 20px;
            height: 20px;
            top: 10px;
            right: 10px;
            z-index: 1;
        }
        /*.form-control {*/
        /*    position: relative;*/
        /*    font-size: 16px;*/
        /*    height: auto;*/
        /*    padding: 10px;*/
        /*}*/
        /*.form-control {*/
        /*    background-color: #ffffff;*/
        /*    border: 1px solid #e4e7ea;*/
        /*    box-shadow: none;*/
        /*    border-radius: 0px;*/
        /*    color: #565656;*/
        /*    height: 38px;*/
        /*    max-width: 100%;*/
        /*    padding: 7px 12px;*/
        /*    transition: all 300ms linear 0s;*/
        /*}*/
        .review-status-box {
            text-align: center;
            padding-right: 0;
            padding-left: 0;
        }
        .listing-box {
            /* background: #FFFFFF; */
            border: 1px solid #E5E5E5;
            box-sizing: border-box;
            border-radius: 4px;
            padding: 0px 10px;
            height: 90px;
            width: 150px;
            position: relative;
        }
        .listing-box1 {
            /* background: #FFFFFF; */
            border: 1px solid #E5E5E5;
            box-sizing: border-box;
            border-radius: 4px;
            padding: 0px 10px;
            height: 90px;
            width: 150px;
            position: relative;
        }
        .listing-box2 {
            /* background: #FFFFFF; */
            border: 1px solid #E5E5E5;
            box-sizing: border-box;
            border-radius: 4px;
            padding: 0px 10px;
            height: 90px;
            width: 150px;
            position: relative;
        }
        .listing-box3 {
            /* background: #FFFFFF; */
            border: 1px solid #E5E5E5;
            box-sizing: border-box;
            border-radius: 4px;
            padding: 0px 10px;
            height: 90px;
            width: 150px;
            position: relative;
        }
        .listing-box4 {
            /* background: #FFFFFF; */
            border: 1px solid #E5E5E5;
            box-sizing: border-box;
            border-radius: 4px;
            padding: 0px 10px;
            height: 90px;
            width: 150px;
            position: relative;
        }
        .listing-box5 {
            /* background: #FFFFFF; */
            border: 1px solid #E5E5E5;
            box-sizing: border-box;
            border-radius: 4px;
            padding: 0px 10px;
            height: 90px;
            width: 150px;
            position: relative;
        }
        .review-status-box label {
            color: #000;
            font-weight: 600;
        }
        .review-status-box h3 {
            color: #000;
            font-size: 42px;
            font-weight: 600;
            margin: 0px;
            text-align: left;
        }
        .review-status-box label {
            color: #000;
            font-weight: 600;
            /* text-align: right; */
            display: block;
            position: absolute;
            right: 10px;
            bottom: 0;
        }
        .tick{
            color: #039a00;
            font-size: 18px;
            padding-right: 10px;

        }
        .grey-tick{
            color: #d2d0d0;
            font-size: 18px;
            padding-right: 10px;

        }
        .remove-me{
            color: red;
        }
        .remove-me:hover{
            color: red;
        }
        .edit-me{
            color: #3c8dbc;
        }
        .edit-me:hover{
            color: #3c8dbc;
        }
        table .dataTable >th
        {
        font-size:8px;
        }

        @media only screen and (max-width:1200px){
            .overflow-x{
                overflow-x:scroll;
            }
            .overflow-x::-webkit-scrollbar{
                width:5px;
                height:6px;
            }
            .overflow-x::-webkit-scrollbar-thumb{
                background-color: #888;
            }
            .overflow-x::-webkit-scrollbar-track{
                background-color: #f1f1f1;
            }
        }

        @media (min-width:280px) and (max-width:365px)
        {
            .listing-box1, .listing-box2,.listing-box4 ,.listing-box3, .listing-box5{
                /* background: #FFFFFF; */
                /*border: 1px solid #E5E5E5;*/
                /*box-sizing: border-box;*/
                /*border-radius: 4px;*/
                /*padding: 0px 10px;*/
                /*height: 90px;*/
                width: 120px;
            /*    position: relative;*/
            }
            .review-status-box
            {
                padding-left: 8px !important;
            }
        }
        @media (min-width:470px) and (max-width:767px)
        {
            .review-status-box-1
            {
                padding-left: 50px !important;
            }
        }
    </style>
@endsection

@section('after_scripts')
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/sl-1.3.0/datatables.min.js"></script>
    <script type="text/javascript" src="{{ asset('public/js/validator.js?ver='.$appFileVersion) }}"></script>
{{--<script src="{{ asset('public/admin/adminlte/plugins/datatables/jquery.dataTables.js') }}"></script>--}}

{{--<script src="{{ asset('public/admin/adminlte/plugins/datatables/dataTables.bootstrap.js') }}"></script>--}}

{{--<script src="{{ asset('public/admin/adminlte/plugins/datatables/dataTables.initiate.js') }}"></script>--}}


{{--    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>--}}
{{--    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.24/themes/smoothness/jquery-ui.css" />--}}
{{--    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.24/jquery-ui.min.js"></script>--}}
{{--    <script type="text/javascript">$(function () {--}}
{{--            $("#taskTable").sortable({--}}
{{--                items: 'tr:not(tr:first-child)',--}}
{{--                cursor: 'pointer',--}}
{{--                axis: 'y',--}}
{{--                dropOnEmpty: false,--}}
{{--                start: function (e, ui) {--}}
{{--                    ui.item.addClass("selected");--}}
{{--                },--}}
{{--                stop: function (e, ui) {--}}
{{--                    ui.item.removeClass("selected");--}}
{{--                    $(this).find("tr").each(function (index) {--}}
{{--                        if (index > 0) {--}}
{{--                            $(this).find("td").eq(2).html(index);--}}
{{--                        }--}}
{{--                    });--}}
{{--                }--}}
{{--            });});</script>--}}






    <script>
        $(function () {
            var table = $('#taskTable').DataTable(
                {
                    // select: false,
                    responsive: true,
                    ordering: true,
                    order: [5, 'desc'],
                    // Sortable: true
                    // paging: false,
                    // "dom": '<"top"i>rt<"bottom"><"clear">'
                    // searching: false,
                    // lengthMenu: [ 25, 50, 100, 'All' ],
                    lengthMenu: [ [100, 200, -1], ['100','200', 'All'] ],
                    "language": {
                        "emptyTable": "No data available",
                        "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                        "infoEmpty": "Showing 0 to 0 of 0 entries",
                        "infoFiltered": "(filtered from _MAX_ total entries)",
                        "infoPostFix": "",
                        "thousands": ",",
                        "lengthMenu": "_MENU_ records per page",
                        "loadingRecords": "Loading...",
                        "processing": "Processing...",
                        "search": "Search: ",
                        "zeroRecords": "No matching records found",
                        "paginate": {
                            "first": "First",
                            "last": "Last",
                            "next": "Next",
                            "previous": "Previous"
                        },
                        "aria": {
                            "sortAscending": ": activate to sort column ascending",
                            "sortDescending": ": activate to sort column descending"
                        }
                    },
                } );

            $(".ordering-date a").click(function () {
                var action = $(this).attr("data-action");

                $(".date-ordering").html($(this).html() + ' <span class="caret"></span>');

                // $(this).remove();

                if(action === 'newest')
                {
                    $('#t-email-campaigns').DataTable().order([3, 'desc']).draw();
                }
                else
                {
                    $('#t-email-campaigns').DataTable().order([3, 'asc']).draw();
                }

            });


            // table.fnSort([ [3,'desc']] );


            // var table = $('#example').DataTable({
            //     "dom": '<"top"i>rt<"bottom"><"clear">'
            // });

            // Event listener to the two range filtering inputs to redraw on input
            // $('#min, #max').keyup( function() {
            //     table.draw();
            // } );

            $('#search-table').on( 'keyup', function () {
                table.search($('#search-table').val()).draw();
            } );


            // $('input.column_filter').on( 'keyup click', function () {
            // filterColumn( $(this).parents('tr').attr('data-column') );
            // } );

            $(document.body).on('click', '.dropdown-menu .checkbox input', function () {
                var column = $(this).closest('ul').attr("data-filter");
                var source = $(this).closest('ul').attr("data-filter-type");
                // var column = 4;
                // console.log("column " + column);

                serializeData('.'+source, column);
            });


            // $(document.body).on('click', '.dropdown-menu .dropdown-item', function() {
            //     var targetAction = $(this).html(); // which we want to select
            //     var activeAction = $(this).closest('.status-column').find('.dropdown-toggle').html();
            //
            //
            //     $(this).closest('.status-column').find('.dropdown-toggle').html(targetAction);
            //     $(this).html(activeAction);
            // });

//             $(".dropdown-menu .dropdown-item").click(function()
//             {
//                 var targetAction = $(this).html(); // which we want to select
// //	var activeAction = $(".dropdown-toggle .dropdown-item").html();
//                 var activeAction = $(this).closest('.status-column').find('.dropdown-toggle').html();
//
//
//                 $(this).closest('.status-column').find('.dropdown-toggle').html(targetAction);
//                 $(this).html(activeAction);
//
//                 //var targetName = $(".action-name", targetAction).html();
//                 //var targetStatus = $(".action-name", targetAction).html();
//
//                 // console.log("activeAction " + activeAction);
//                 // console.log("targetAction " + targetAction);
//                 // console.log("activeAction 1 " + $(".action-name", targetAction).html());
//             });

            $(".listing-box h3").html(table.rows().count());
            $("#totalTrial").val(table.rows().count());
        });

        $(document).on('click', '.show-user-profile', function () {
            var siteUrl = $('#hfBaseUrl').val();
            var user = $(this).attr("data-user-email");
            var currentTarget = $(this);

            showPreloader();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                type: "POST",
                url: siteUrl + "/done-me",
                data: {
                    send: 'super-login',
                    email: user,
                },
            }).done(function (result) {
                var json = $.parseJSON(result);
                var statusCode = json.status_code;
                var statusMessage = json.status_message;
                var data = json.data;

                hidePreloader();

                if(statusCode == 200)
                {
                    window.open(siteUrl, '_blank');

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
        });

        var currentTarget;
        $(document.body).on('click', '.remove-me', function() {
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

            html +='<div class="modal-body"><div class="interface-module" style=""><div class="alert" style="display: none;"></div><div class="remove-business-modal"><div class="remove-action-note"><img src="'+baseUrl+'/public/images/delete-listing.png"> <h3 style="font-size: 22px;margin-bottom: 25px;font-weight: 400;color: #000;">Are you sure you want to remove this Account?</h3>' +
                '<p style="color: #000;font-size: 15px;">Deleting user will not be show in admin panel and user can not access this account.</p></div></div></div></div>';
            html +='<div class="modal-footer"><button type="button" class="btn btn-default close-modal" data-dismiss="modal">Cancel</button><button type="button" class="btn btn-danger deleting-processed">Delete</button></div>';

            mainModel.modal('show');
            $(".modal-header").after(html);

            return false;
        });

        $(document.body).on('click', '.change-status' ,function() {
            var siteUrl = $('#hfBaseUrl').val();
            var template = $(this).attr('data-target-id');
            var status = $(this).attr('data-status');
            var currentTarget = $(this);
            var parentSel = currentTarget.parent('.status');

            var user = $(this).attr("data-user-email");

            showPreloader();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                type: "POST",
                url: siteUrl + "/done-me",
                data: {
                    send: 'admin-change-user-account-status',
                    id: template,
                    status: status,
                    email: user
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

                if(status == 'deleted')
                {
                    parentSel.html('<span data-user-email="'+user+'" class="inactive change-status" data-target-id="'+template+'" data-status="">Drafts</span>');
                }
                else
                {
                    parentSel.html('<span data-user-email="'+user+'" class="active change-status" data-target-id="'+template+'" data-status="deleted">Active</span>');
                }


                hidePreloader();

                if(statusCode == 200)
                {

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
        });

        $(document.body).on('click', '.deleting-processed', function() {
            deleteCampaign(window.currentTarget);
        });

        function deleteCampaign(currentTarget) {
            // console.log("currentTarget templat");
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
                    send: 'delete-account',
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
                    if($("tbody tr").length != 1)
                    {
                        currentTarget.closest('tr').remove();

                        var count = $("#totalTrial").val();

                        var remaining = count - 1;

                        $("#totalTrial").val(remaining);

                        // console.log(remaining);

                        $(".listing-box h3").html(remaining);

                    }


                    // console.log("length ");
                    // console.log($("tbody tr").length);
                    // swal({
                    //     title: "Success!",
                    //     text: statusMessage,
                    //     type: 'success'
                    // }, function () {
                    //     showPreloader();
                    //     location.reload();
                    // });
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


        // Tooltips
        $('.tip').each(function () {
            var i = 1;
            // console.log($(this));
            $(this).tooltip(
                {
                    html: true,
                    title: $('#' + $(this).data('tip')).html()
                });
            i++;
        });
    </script>
    <script>
        var currentTarget;

        $(document.body).on('click', '.edit-me', function() {
            currentTarget = $(this);
            var target = $(this).attr('data-target-id');

            var parent = currentTarget.closest('tr');

            var nicheId = parent.find('#nicheName').attr('data-niche-id');

            var selected = '';

//             console.log(parent);
//             console.log(nicheId);
// return;
            var baseUrl = $('#hfBaseUrl').val();


            var mainModel = $('#main-modal');
            $(".modal-body, .modal-footer, .validate-me", mainModel).remove();
            $(mainModel).removeClass('welcome-process');
            $(mainModel).addClass('modal-user-edit');
            var html = '';

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                type: "POST",
                url: baseUrl + "/done-me",
                data: {
                    send: 'get-niches'
                },
            }).done(function(result){

                var json = $.parseJSON(result);
                // console.log(json);

                var statusCode = json.status_code;
                var statusMessage = json.status_message;
                var data = json.data;

                if(statusCode == 200){
                    html +=
                        '<form class="validate-user-data validate-me" role="form" method="POST">'+
                        '<div class="modal-body">' +
                        '<div class="interface-module" style="">' +
                        '<div class="alert" style="display: none;">' +
                        '</div>' +
                        '<div class="edit-business-modal">' +
                        '<div class="edit-action-note">' +
                        // '<img src="'+baseUrl+'/public/images/delete-listing.png">' +

                        '<div class="data-fields">'+
                        '<div class="row">'+
                        '<div class="col-md-12">'+
                        '<label class="pull-left">Password</label>'+
                        '<input type="password" class="form-control" id="password" value="" data-required="true">'+
                        '<span class="help-block hide-me"><small></small></span>'+
                        '</div>'+
                        '</div>'+
                        '</div>'+
                        '<div class="data-fields" style="margin-top: 10px">'+
                        '<div class="row">'+
                        '<div class="col-md-12">'+
                        '<div  id="exampleFormControlSelect">'+
                        '<label class="pull-left">Niche</label>'+
                        '<select class="form-control selectpicker select-option" name="changeNiche" id="changeNiche">';
                        // '<option value=""></option>';
                    $.each(data, function (index , value) {
                        if( value.id == nicheId ) {
                            // console.log(value.id);
                            // console.log(nicheId);
                            selected = 'selected';
                        }
                        else {
                            selected = '';
                        }
                        html += '<option value='+value.id+' '+selected+'>'+value.niche+'</option>';
                    });

                    html +=
                        '</select>'+
                        '</div>'+
                        '</div>'+
                        // '<label class="pull-left">Niche</label>'+
                        // '<input type="text" class="form-control" id="changeNiche" value="" placeholder="Enter New Niche.">'+
                        '</div>'+
                        '</div>'+
                        // '</div>'+

                        // '<input type="password" placeholder="Optional" id="newPassword">' +
                        // '<p style="color: #000;font-size: 15px;">Deleting user will not be show in admin panel and user can not access this account.</p>' +
                        '</div>' +
                        '</div> ' +
                        // '</div>' +
                        '</div>'+
                        '</div>';

                    // console.log("currentTarget");
                    // console.log(currentTarget);
                    html +='<div class="modal-footer">' +
                        '<button type="button" class="btn btn-default close-modal" data-dismiss="modal">Cancel</button>' +
                        '<button type="submit" class="btn btn-primary editing-processed">Save</button>' +
                        '</div>' +
                        '</form>';

                    mainModel.modal('show');
                    $(".modal-header").after(html);
                }
                else{
                    swal('Error', statusMessage, 'error');
                }
            });
        });

        // $(document.body).on('click', '.editing-processed', function() {
            // var userId = $(this).attr('data-target-id');
            // var userId = $(this).attr('data-target-id');
            // console.log(window.currentTarget)
        //     editUserData(window.currentTarget);
        // });

        $(document.body).on('submit', 'form.validate-me.validate-user-data', function(e) {
            e.preventDefault();
            if (!errorFound) {
                editUserData(window.currentTarget);
            }
        });
        function editUserData(currentTarget) {
            // console.log('currentTarget')
            // console.log(currentTarget)
            var parent = currentTarget.closest('tr');
            // console.log(parent);
            var parentNiche = parent.find('#nicheName');
            // console.log(parentNiche);
            // return;

            var siteUrl = $('#hfBaseUrl').val();

            var userId = currentTarget.attr('data-target-id');

            var password = $('#password').val();


            var niche = $("#changeNiche option:selected").val();

            // console.log('userId');
            // console.log(userId);
            // console.log('password');
            // console.log(password);
            // console.log('niche');
            // console.log(niche);

            showPreloader();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                type: "POST",
                url: siteUrl + "/done-me",
                data: {
                    send: 'update-user-info',
                    id: userId,
                    password: password,
                    niche: niche
                },
            }).done(function (result) {
                var json = $.parseJSON(result);
                var statusCode = json.status_code;
                var statusMessage = json.status_message;
                var data = json.data;
                var nicheData = data.niche;
                // console.log(json);
                // console.log(nicheData);
                // console.log(nicheData.niche);
                hidePreloader();

                if(statusCode == 200) {
                    $(".close-modal").click();
                    // var target = currentTarget.find('#nicheName');
                    // console.log(target);
                    parentNiche.html(nicheData.niche);
                    // $(currentTarget).('#nicheName').html(nicheData.niche);
                    swal({
                        title: 'Success',
                        text: statusMessage,
                        type: 'success'
                    },function (){
                        // location.reload();
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
