@extends('index')

@section('pageTitle', 'Billing')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid dashboarbgtitle">
            <div class="dashboard-wrapper billing-screen">
                <div class="page-head">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="page-title">Billing
{{--                                <a class="page-help" href="javascript:void(0)">--}}
{{--                                    <i class="fa fa-question-circle-o" style="color: #7d8080;/* transform: scaleX(-1); */margin-right: 5px;"></i>--}}
{{--                                    <img class="help-info-image" src="{{ asset('public/images/information.png') }}" />--}}
{{--                                </a>--}}
                            </h4>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="billing-wrapper">
                            <div class="account-status">
                                <div class="row">
                                    <div class="col-md-3">
                                        <h3 class="b-p-title">Current Plan</h3>
                                    </div>
                                    <div class="col-md-9 table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th style="width: 30%;">Subscription</th>
                                                <th>Partner Since</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                @if(!empty($userData['subscriptionStatus']['subscription_remaining_days']) && $userData['subscriptionStatus']['subscription_type'] == 'paid')
                                                    <th>Paid</th>
                                                @else
                                                    <th>Free Trial</th>
                                                @endif
                                                {{--                                                    <th>{{ date('m/d/Y', strtotime($userData['created_at'])) }}</th>--}}
                                                <th>{{ appDateFormat($userData['created_at']) }}</th>

                                                <th class="text-right">
                                                    @if(!empty($userData['subscriptionStatus']['subscription_remaining_days']) && $userData['subscriptionStatus']['subscription_type'] == 'paid')

                                                    @else
                                                        <a href="{{ route('upgrade') }}" class="btn btn-primary">Upgrade Now</a>
                                                    @endif
                                                    <a href="javascript:void(0)" class="action-btn cancel-account" data-action="cancel_account">Cancel Account</a>
                                                </th>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <div class="inovice-history">
                                <div class="row">

                                    <div class="col-md-3">
                                        <h3 class="b-p-title">Invoice History</h3>
                                        <p class="b-p-desc">Your all invoices are here and updated regularly.</p>

                                    </div>

                                    <div class="col-md-9">
                                        <div class="invoice-table">

                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th>Plan</th>
                                                        <th>Price</th>
                                                        <th>Date Started</th>
                                                        <th>Next Bill</th>
                                                        <th>Status</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (isset($invoices))
                                                        @forelse ($invoices as $invoice)
                                                        <tr>
{{--                                                            <td>{{ $invoice->asStripeInvoice()->lines->data[0]->description }}</td>--}}
                                                            <td>Monthly Subscription</td>
                                                            <td>{{ $invoice->total() }}</td>
                                                            <td>{{ date("F d, Y", $invoice->asStripeInvoice()->lines->data[0]->period->start) }}</td>
                                                            <td>{{ date("F d, Y", $invoice->asStripeInvoice()->lines->data[0]->period->end) }}</td>
                                                            <td>
                                                                @if ($invoice->asStripeInvoice()->status == 'paid')
                                                                    <span class="badge badge-success" style="padding-left: 1rem; padding-right: 1rem;">{{ $invoice->asStripeInvoice()->status}}</span>

                                                                @else
                                                                    <span class="badge badge-danger" style="padding-left: 1rem; padding-right: 1rem;">{{ $invoice->asStripeInvoice()->status}}</span>

                                                                @endif

                                                            </td>
                                                        </tr>
                                                        @empty

                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td style="text-align: left;">
                                                                    No Data Yet.
                                                                </td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                        @endforelse

                                                        @else
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td style="text-align: left;">
                                                                No Data Yet.
                                                            </td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <div class="inovice-history">
                                <div class="row">

                                    <div class="col-md-3">
                                        <h3 class="b-p-title">Email & SMS Limit</h3>

                                    </div>

                                    <div class="col-md-9">
                                        <div class="invoice-table">

                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th>Email Limit</th>
                                                        <th>Email remaining</th>
                                                        <th>SMS Limit</th>
                                                        <th>SMS remaining</th>
                                                        <th style="width: 80px;"></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                            @if(!empty($emailLimit))
                                                                <?php

                                                                echo $maximum = getIndexedvalue($emailLimit[0], 'maximum', 0);
                                                                ?>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(!empty($emailLimit))
                                                                <?php
                                                                $remaining =  getIndexedvalue($emailLimit[0], 'used', 0);
                                                                echo $maximum - $remaining;
                                                                ?>
                                                            @endif
                                                        </td>

                                                        <td>
                                                            @if(!empty($smsLimit))
                                                                <?php
                                                                echo $maximum = getIndexedvalue($smsLimit[0], 'maximum', 0);
                                                                ?>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(!empty($smsLimit))
                                                                <?php
                                                                $remaining =  getIndexedvalue($smsLimit[0], 'used', 0);
                                                                echo $maximum - $remaining;
                                                                ?>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a style="border-radius: 6px;" href="./sms"  class="btn btn-primary">+ Buy SMS</a>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <div class="account-status">
                                <div class="row">
                                    <div class="col-md-3">
{{--                                        <h3 class="b-p-title">Marketing Pro Services</h3>--}}
                                        <h3 class="b-p-title">Service Purchased</h3>
                                    </div>
                                    <div class="col-md-9 table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th style="width: 30%;">Credits Used</th>
                                                <th>Date Purchased</th>
                                                <th>Description</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @if(!empty($creditsHistory))
                                                    @foreach($creditsHistory as $creditRow)
                                                        <tr>
                                                            <th style="width: 30%;">
                                                                {{ $creditRow['credits'] }}
                                                            </th>
                                                            <th>
                                                                {{ Date('F d, Y', strtotime($creditRow['created_at'])) }}
                                                            </th>
                                                            <th>
                                                                @if(!empty($creditRow['module_task_name']) )
                                                                    {{$creditRow['module_task_name']}}
                                                                @else
                                                                    {{ creditText($creditRow['module_used_credits']) }}
                                                                @endif
                                                            </th>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                    <td colspan="3" style="text-align: center;">No Data Yet.</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <div class="payment-information">
                                <div class="row">

                                    <div class="col-md-3">
                                        <h3 class="b-p-title">Payment Information</h3>
                                        <p class="b-p-desc">Your card for paying your subscription bills lives here.</p>

                                    </div>
                                    <div class="col-md-9">


                                            @if( !empty($userData['card_last_four']) )
                                                <div class="cc-section">
                                                    <div class="card-outer">
                                                        <div class="card-inner">
                                                            <div style="height: 100%; position: relative">
                                                                <img class="img-fluid" style="height: 100%;padding-top: 0" src="{{ asset('public/images/bankIcon.png') }}">
                                                                <p class="cardPara">****{{ $userData['card_last_four'] }}</p>
                                                            </div>

                                                        </div>

                                                    </div>

                                                    <h5>{{ $userData['first_name'] }}  {{ $userData['last_name'] }} checking ****{{ $userData['card_last_four'] }}</h5>
                                                </div>
                                            @else
                                                <div class="cc-section">
                                                    <img src="{{ asset('public/images/cc-image.png') }}">
                                                    <h5>No card added yet.</h5>
                                                    <a style="display: none;" href="javascript:void(0)" class="btn btn-primary btn-add-cc">Add New Card</a>
                                                </div>
                                            @endif


                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        .card-outer {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card-inner {
            height: 300px;
            width: 400px;
            background-color: #ccc;
            border-radius: 10px;
            padding-bottom: 20px;
        }
        .cardPara {
            position: absolute;
            bottom: -23px;
            left: 15px;
            font-weight: 600;
            font-size: 18px;
        }
    </style>
@endsection

@section('js')

    <script type="text/javascript" src="{{ asset('public/js/billing/billing-manager.js') }}"></script>
@endsection
