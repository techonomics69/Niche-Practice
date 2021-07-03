@extends('admin.layout')

@section('title', 'Client info')

@section('content')
<section class="content-header">
  <h1>Client Profile:Doctor Name</h1>
</section>
<form action="" method="post">
   <input type="hidden" name="token" value="" >
     <div class="row client-dropdown-container">
        <div class="col-sm-9 col-md-5">
            <select id="selectUserid" class="form-control selectize selectize-client-search selectized"
           data-value-field="id" data-active-label="Active" data-inactive-label="Inactive" placeholder="Start Typing to Search Clients" tabindex="-1" >
                 <option value="1" selected="selected"> Alex Dave-#1</option>
            </select>

        </div>
      </div>
 </form>
{{--<div class="row">--}}
{{--      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">--}}
           <ul class="nav nav-tabs client-tabs" role="tablist">
            <li class="active">
               <a href="{{ route('admin.clientInfo') }}" >Summary</a>
             </li>
             <li class="tab">
               <a href="{{ route('admin.addInvoice') }}">Invoices</a>
             </li>
             <li class="tab">
               <a href="{{ route('admin.NotesInfo') }}">Notes(0)</a>
             </li>
           </ul>
          <div class = "tab-content client-tabs">
              <div class="tab-pane active" role="tabpanel">
                 <div id="clientsummarycontainer">
                 <div class="client-summary-name">
                      #<span id="userId">1</span> - Alex Dave
                   </div>
                   <div class="row client-summary-panels">
                          <div class="col-lg-3 col-sm-6 col-md-6">
                                  <div class="clientsSummaryBox">
                                     <div class="title">
                                         Clients Information
                                     </div>
                                     <table class="clientsSummaryStats" cellspacing="0" cellpadding="2">
                                        <tbody>
                                           <tr>
                                               <td width="110">First Name</td>
                                               <td>Alex</td>
                                           </tr>
                                           <tr class="altrow">
                                               <td>Last Name</td>
                                               <td>Dave</td>
                                           </tr>
                                           <tr>
                                               <td>Company Name</td>
                                               <td></td>
                                           </tr>
                                           <tr class="altrow">
                                               <td>Email Address</td>
                                               <td>albert@domain.com</td>
                                           </tr>
                                           <tr>
                                               <td>Address 1</td>
                                               <td>102 nowhere st.</td>
                                           </tr>
                                           <tr class="altrow">
                                               <td>Address 2</td>
                                               <td></td>
                                           </tr>
                                           <tr>
                                               <td>City</td>
                                               <td>Miami</td>
                                           </tr>
                                           <tr class="altrow">
                                               <td>State/Region</td>
                                               <td>Florida</td>
                                           </tr>
                                           <tr>
                                               <td>PostCode</td>
                                               <td>25485</td>
                                           </tr>
                                           <tr class="altrow">
                                               <td>Country</td>
                                               <td>US-United States</td>
                                           </tr>
                                           <tr>
                                               <td>Phone Number</td>
                                               <td>+1.235482145</td>
                                           </tr>
                                        </tbody>

                                     </table>
                                     <ul>
                                         <li>
                                             <a id="summary-login-as-owner" href="#">
                                                 <img src="{{ asset('public/images/icons/login.png') }}">
                                                 Login
                                             </a>
                                         </li>
                                     </ul>
                                  </div>
                                  <div class="clientsSummaryBox">
                                          <div class="title">
                                              Pay Methods
                                          </div>
                                          <table class="clientsSummaryStats" cellspacing="0" cellpadding="2">
                                              <tbody>
                                              <tr>
                                                  <td align="center">no pay Methods</td>
                                              </tr>
                                              </tbody>

                                          </table>
                                          <ul>
                                              <li>
                                                  <a id="summary-login-as-owner" href="#">
                                                      <img src="{{ asset('public/images/icons/add.png') }}">
                                                      Add Credit Card
                                                  </a>
                                              </li>
                                          </ul>
                                  </div>
                          </div>
                          <div class="col-lg-3 col-sm-6 col-md-6">
                               <div class="clientsSummaryBox">
                                      <div class="title">
                                        Invoices/Billing
                                      </div>
                                       <table class="clientsSummaryStats" cellspacing="0" cellpadding="2">
                                            <tbody>
                                                       <tr>
                                                           <td width="110">Total Paid</td>
                                                           <td>68($5185.00 USD)</td>
                                                       </tr>
                                                        <tr>
                                                           <td>Due</td>
                                                           <td>1 ($10.00 USD)</td>
                                                       </tr>
                                                       <tr class="altrow">
                                                           <td>Cancelled</td>
                                                           <td>0 ($0.00 USD)</td>
                                                       </tr>
                                                       <tr>
                                                           <td>Refunded</td>
                                                           <td>0 ($0.00 USD)</td>
                                                       </tr>
                                                       <tr class="altrow">
                                                           <td>Collection</td>
                                                           <td>0 ($0.00 USD)</td>
                                                       </tr>

                                            </tbody>

                                      </table>
                               </div>
                               <div class="clientsSummaryBox">
                                   <div class="title">
                                      Other Information
                                   </div>
                                   <table class="clientsSummaryStats" cellspacing="0" cellpadding="2">
                                          <tbody>
                                                   <tr>
                                                        <td width="110">Status</td>
                                                         <td>Active</td>
                                                   </tr>
                                                   <tr>
                                                               <td>Signup Date</td>
                                                               <td>29/08/2015</td>
                                                   </tr>
                                                   <tr class="altrow">
                                                               <td>Client For</td>
                                                               <td>67 Months</td>
                                                   </tr>
                                                   <tr>
                                                               <td>Last Login</td>
                                                               <td>No Login Logged</td>
                                                   </tr>
                                          </tbody>
                                   </table>
                               </div>
                          </div>
                          <div class="col-lg-3 col-sm-6 col-md-6">
                               <div class="clientsSummaryBox">
                                   <div class="title">
                                       Products/Services
                                   </div>
                                   <table class="clientsSummaryStats" cellspacing="0" cellpadding="2">
                                             <tbody>
                                                           <tr>
                                                               <td width="140">Individual Campaigns</td>
                                                               <td>17 (17 Total)</td>
                                                           </tr>
                                                           <tr class="altrow">
                                                               <td>Integrated Campaigns</td>
                                                               <td>0(0 Total)</td>
                                                           </tr>
                                                           <tr>
                                                               <td>SMS Credits</td>
                                                               <td>21 (22 Total)</td>
                                                           </tr>
                                                           <tr class="altrow">
                                                               <td>#Credits Remaining </td>
                                                               <td>0 (0 Total)</td>
                                                           </tr>
                                                           <tr>
                                                               <td>Total Emails Sent</td>
                                                               <td>1(2 Total)</td>
                                                           </tr>
                                                           <tr>
                                                               <td>Total Credits Purchased</td>
                                                               <td>1(2 Total)</td>
                                                           </tr>
                                               </tbody>

                                   </table>
                                   <ul>
                                                      <li>
                                                          <a  href="#">
                                                              <img src="{{asset('public/images/icons/orders.png')}}">
                                                              Add Campaign
                                                          </a>
                                                      </li>
                                                      <li>
                                                          <a  href="#">
                                                              <img src="{{asset('public/images/icons/ordersadd.png')}}">
                                                               Add SMS
                                                          </a>
                                                      </li>

                                   </ul>
                               </div>
                               <div class="clientsSummaryBox">
                                              <div class="title">
                                                CSV Files
                                              </div>
                                              <table class="clientsSummaryStats" cellspacing="0" cellpadding="2">
                                                  <tbody>
                                                  <tr>
                                                      <td align="center">No Files uploaded</td>
                                                  </tr>
                                                  </tbody>

                                              </table>
                                              <ul>
                                                  <li>
                                                      <a id="summary-login-as-owner" href="#">
                                                      <img src="{{asset('public/images/icons/add.png')}}">
                                                          Add Files
                                                      </a>
                                                  </li>
                                              </ul>
                               </div>

                          </div>
                          <div class="col-lg-3 col-sm-6 col-md-6">
                                     <div class="clientsSummaryBox">
                                         <div class="title">
                                             Other Actions
                                         </div>
                                         <ul>
                                             <li>
                                                 <a  href="#"  onclick = "closeClient()" style="color: #000000" data-target="main-modal">
                                                     <img src="{{asset('public/images/icons/delete.png')}}">
                                                     Deactivate Clients Account
                                                 </a>
                                             </li>
                                             <li>
                                                 <a  href="#" onclick="deleteClient()" style="color:#CC0000">
                                                     <img src="{{asset('public/images/icons/delete.png')}}">
                                                     Delete Clients Account
                                                 </a>
                                             </li>
                                         </ul>
                                     </div>
                                     <div class="clientsSummaryBox">
                                         <div class="title">
                                            Send Email
                                         </div>
                                         <form action="" method="post">
                                             <input type="hidden" name="token" value="">
                                             <input type="hidden" name="id" value="2">
                                             <div align="center">
                                                <select name="messageID" class="form-control select-inline">
                                                    <option value="0">New Message</option>
                                                    <option value="9">Client Signup Email</option>
                                                    <option value="32">Credit Card Expiring Soon</option>
                                                    <option value="16">Order Confirmation</option>
                                                    <option value="54">Quote Accepted</option>
                                                    <option value="36">Quote Delivery with PDF</option>
                                                    <option value="59">Unsubscribe Confirmation</option>
                                                </select>
                                                <button type="submit"  class="button btn btn-default"> Go </button>
                                             </div>
                                         </form>
                                     </div>
                                     <div class="clientsSummaryBox">
                                         <div class="title">
                                            Admin Notes
                                         </div>
                                         <form action="" method="post">
                                           <input type="hidden" name="token" value="">
                                           <div align="center">
                                               <textarea name="adminnotes"  rows="5" class="form-control bottom-margin"></textarea>
                                               <button type="submit"  class="button btn btn-default"> Submit</button>
                                           </div>
                                         </form>
                                     </div>
                          </div>
                    </div>
                             <div class="row">
                                            <!-- THE ACTUAL CONTENT -->
                                            <div class="col-md-12">
                                                <div class="box">
                                                    <div class="box-header with-border" style="text-align:center;">
                                                        <h3 class="box-title m-t-10 " >
                                                            <strong>Product/Service</strong>
                                                        </h3>
                                                    </div>
                                                    <div class="box-body">
                                                        <div id="crudTable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <table id="taskTable" class="table table-bordered table-striped display dataTable " role="grid">
                                                                        <thead>
                                                                        <tr role="row">
                                                                            <th width="20">
                                                                             <input type="checkbox" id="prodsall">
                                                                            </th>
                                                                            <th>Data Purchase</th>
                                                                            <th>Description</th>
                                                                            <th># of credits </th>
                                                                            <th>Payment Amount ($)</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                             <tr class=" ">
                                                                                <td> </td>
                                                                                <td> </td>
                                                                                <td> </td>
                                                                                <td> </td>
                                                                                 <td>  </td>
                                                                              </tr>


                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div><!-- /.box-body -->
                                                </div><!-- /.box -->
                                            </div>
                             </div>
                </div>

             </div>
          </div>
{{--     </div>--}}

</div>

@endsection

@yield('css_before')

<link rel="stylesheet" href="{{asset('public/css/clients-info.css')}}" />

<style>
ul.client-tabs>li.active>a {
    font-weight: 700;
}
.client-tabs>li>a {
    padding: 4px 10px 3px !important;
}
ul.client-tabs>li>a {
    margin-left: 5px;
    padding: 4px 10px 3px;
    font-size: .9em;
    background-color: #efefef;
    border: 1px solid #ccc;
    text-decoration: none;
    color: #202f60;
}
 div.client-tabs >.active {
    padding: 10px;
    border: 1px solid #ddd;
    border-top: 0;
}
.client-summary-name {
    margin-bottom: 20px;
    font-size: 20px;
}
</style>
@yield('css_after')

<script>
    function closeClient()
        {
      if (confirm("Are you sure you want to close this client?  This will set all packages and unpaid invoices to Cancelled.")) {
      window.location='?userid=1&action=closeclient&token=1fd74c6a4e0d8fe7dd64e2ac1c7497d063fe1975';
      }
    }
     function deleteClient()
       {
         if (confirm("Are you sure you want to delete this client? This will delete all history and cannot be undone."))
          {
         window.location='?userid=1&action=deleteclient&token=1fd74c6a4e0d8fe7dd64e2ac1c7497d063fe1975';
         }
       }
</script>

