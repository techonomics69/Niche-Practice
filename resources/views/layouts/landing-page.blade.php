@extends('index')

@section('pageTitle', 'Landing Page')

@section('content')
    <div id="page-wrapper" style="min-height: 231px;">
        <div class="container-fluid dashboarbgtitle reviews-panel">
            <div class="dashboard-wrapper">
                <div class="page-head">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="page-title"> Landing Page </h4>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">

                        <div class="d-table">











                            <div class="table-responsive">
                                <div id="t-email-campaigns_wrapper" class="dataTables_wrapper no-footer">
                                    <table id="t-email-campaigns" class="email-campaign dataTable no-footer" style="width: 100%;" role="grid" aria-describedby="t-email-campaigns_info">

                                        <thead>
                                        <tr style="height: 60px;" role="row">
                                            <th class="select-checkbox" rowspan="1" colspan="1" style="width: 25px;"></th>
                                            <th tabindex="0" aria-controls="customers-list" rowspan="1" colspan="1" style="width: 450px;">
                                                <span>Campaign</span>
                                            </th>
                                            <th tabindex="0" aria-controls="" rowspan="1" colspan="1" style="width: 300px;">
                                                <span>Metrics</span>
                                            </th>
                                            <th tabindex="0" aria-controls="" rowspan="1" colspan="1" style="width: 146px;">
                                                <span data-trigger="hover" data-container="body" data-toggle="popover" data-placement="auto right" data-content="This is the phone number of the customer." data-original-title="" title=""></span>
                                            </th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        <tr role="row">

                                            <td></td>

                                            <td class="text-verticle-align">
                                                <div class="email-column">
                                                    <h3>Niche Landing</h3>
                                                </div>
                                            </td>

                                            <td class="text-verticle-align">
                                                <div class="metrics-column">
                                                    <div class="row">
                                                        <div class="col-sm-4 col-xs-6">
                                                            <h3>0</h3>
                                                            <label>SENT</label>
                                                        </div>
                                                        <div class="col-sm-4 col-xs-6">
                                                            <h3>0</h3>
                                                            <label>OPENED</label>
                                                        </div>
                                                        <div class="col-sm-4 col-xs-6">
                                                            <h3>0</h3>
                                                            <label>CLICKED</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="text-verticle-align" style="width: 0px;">
                                                <div class="action-buttons" style="float: none;">
                                                    <div class="btn-contain">
                                                        <a href="javascript:void(0)">
                                                            <i class="fa fa-search"></i>
                                                            <span>PREVIEW</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>



                                        <tr role="row">

                                            <td></td>

                                            <td class="text-verticle-align">
                                                <div class="email-column">
                                                    <h3>Thank You Page</h3>
                                                </div>
                                            </td>

                                            <td class="text-verticle-align">
                                                <div class="metrics-column">
                                                    <div class="row">
                                                        <div class="col-sm-4 col-xs-6">
                                                            <h3>0</h3>
                                                            <label>SENT</label>
                                                        </div>
                                                        <div class="col-sm-4 col-xs-6">
                                                            <h3>0</h3>
                                                            <label>OPENED</label>
                                                        </div>
                                                        <div class="col-sm-4 col-xs-6">
                                                            <h3>0</h3>
                                                            <label>CLICKED</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="text-verticle-align" style="width: 0px;">
                                                <div class="action-buttons" style="float: none;">
                                                    <div class="btn-contain">
                                                        <a href="javascript:void(0)">
                                                            <i class="fa fa-search"></i>
                                                            <span>PREVIEW</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>







                            <div class="shadow-landing-box">
                                <div class="row">
                                    <div class="col-sm-7">
                                        <h4 class="font-bold">Landing Page URL</h4>
                                        <a href="https://1drewpbdre-e74b@nichepractice.com" style="color: #000;">https://1drewpbdre-e74b@nichepractice.com</a>
                                        <br><br>
                                        <h4 class="font-bold">Assign your own domain</h4>
                                        <p>There are two ways to assign your domain to your Landing Page: <a href="#.">Change DNS settings</a> or <a href="#.">Add a CNAME</a> entry to your subdomain.</p>
                                    </div>
                                    <div class="col-sm-5">
                                        <h4 class="font-bold">Google Ads conversion tracking</h4>
                                        <form>
                                            <p class="m-0">Conversion ID</p>
                                            <input type="text" class="form-control">
                                            <p class="m-0">Conversion Label</p>
                                            <input type="text" class="form-control">
                                        </form>
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

@endsection

@section('js')

@endsection
