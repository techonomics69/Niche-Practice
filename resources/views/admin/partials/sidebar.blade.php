<aside class="main-sidebar">
      <section class="sidebar">
        <div class="user-panel">
          <div class="pull-left image">
{{--            <img src="https://placehold.it/160x160/00a65a/ffffff/&text=Name" class="img-circle" alt="User Image">--}}
            <img src="{{ asset('public/images/adminName.png') }}" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            @if(!empty($userData))
              <p>{{ $userData['first_name'] . ' ' . $userData['last_name'] }}</p>
            @endif
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
        </div>
          <form class="sidebar-form" id="lrmenuintellisearch">
              <input type="hidden" name="intellisearch" value="1">
              <input type="hidden" name="token" value="b4f4d6d03779fb0167981e876d3ee1a2db69a172">
              <div class="input-group">
                  <input type="text" id="intellisearchval" class="form-control" placeholder="Menu Search ..." onkeyup="searchData()">
                  <span class="input-group-btn">
                           <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                                <i id="isearch-icon" class="fa fa-search"> </i>
                            </button>
                        </span>
              </div>
          </form>
        <ul class="sidebar-menu" id="myList">

{{--         <li class="header show-promotion-admin show-reports-page">--}}
{{--             <form class="sidebar-form" id="lrmenuintellisearch">--}}
{{--                   <input type="hidden" name="intellisearch" value="1">--}}
{{--                   <input type="hidden" name="token" value="b4f4d6d03779fb0167981e876d3ee1a2db69a172">--}}
{{--                   <div class="input-group">--}}
{{--                       <input type="text" id="intellisearchval" class="form-control" placeholder="Menu Search ..." onkeyup="searchData()">--}}
{{--                       <span class="input-group-btn">--}}
{{--                           <button type="submit" name="search" id="search-btn" class="btn btn-flat">--}}
{{--                                <i id="isearch-icon" class="fa fa-search"> </i>--}}
{{--                            </button>--}}
{{--                        </span>--}}
{{--                   </div>--}}
{{--              </form>--}}
{{--          </li>--}}



    <li class="listItems" >
       <a href="javascript:void(0)" class="sub-menu">
           <i class="fa fa-users"></i>
           <span>Clients</span>
           <span class="pull-right-container">
               <i class="fa fa-angle-left dropdown "></i>
           </span>
       </a>

       <ul class="nav nav-second-level "  id="second-level-menu" aria-expanded="true" >
             <li class="">
                       <a href="{{route('admin.addClient')}}" class="waves-effect ">
                           <span>Add New Clients</span>
                       </a>
            </li>
           <li class="listItems" >
                      <a href="{{ route('adminDashboard') }}">
                         <span>Search/View Clients</span>
                      </a>
           </li>
       </ul>
   </li>
   <li class="listItems" >
          <a href="javascript:void(0)" class="sub-menu">
              <i class="fa fa-usd"></i>
              <span>Billing</span>
              <span class="pull-right-container">
                  <i class="fa fa-angle-left dropdown "></i>
              </span>
          </a>

          <ul class="nav nav-second-level "  id="second-level-menu" aria-expanded="true" >
                <li class="listItems">
                     <a href="javascript:void(0)" class="waves-effect ">
                           <span>Billing</span>
                     </a>
                </li>
                <li class="listItems">
                          <a href="javascript:void(0)" class="waves-effect ">
                              <span>Subscriptions</span>
                          </a>
               </li>
              <li class="listItems" >
                         <a href="javascript:void(0)">
                            <span>Campaigns</span>
                         </a>
              </li>
              <li class="listItems" >
                          <a href="javascript:void(0)">
                              <span>SMS</span>
                          </a>
              </li>
          </ul>
      </li>
  <li class="listItems" >
    <a href="javascript:void(0)" class="sub-menu"
    >
        <i class="fa fa-envelope"></i>
        <span>Email Templates</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left dropdown "></i>
        </span>
    </a>

    <ul class="nav nav-second-level "  id="second-level-menu" aria-expanded="true" >
          <li class="listItems">
                    <a href="{{ route('admin.templates.list') }}" class="waves-effect ">
                        <span>Templates</span>
                    </a>
         </li>
        <li class="listItems">
            <a href="{{ route("admin.email-builder") }}" class="waves-effect ">
                <span>Add Template</span>
            </a>
        </li>

        <li class="listItems">
            <a href="{{ route('admin.new-patient-emails') }}">
                <span>New Patient Emails</span>
            </a>
        </li>
        <li class="listItems">
            <a href="{{ route("admin.niches.list") }}" class="waves-effect ">
                <span>Niches List</span>
            </a>
        </li>

        <li class="listItems">
            <a href="{{ route("admin.templates.category") }}" class="waves-effect ">
                <span>Category Panel</span>
            </a>
        </li>

        <li class="listItems">
            <a href="{{ route("admin.templates.types") }}" class="waves-effect ">
                <span>Type Panel</span>
            </a>
        </li>
    </ul>
</li>
<li class="show-promotion-admin listItems">
    <a href="javascript:void(0)" class="sub-menu">
        <i class="fa fa-product-hunt"></i>
        <span>Promotion Templates</span>
         <span class="pull-right-container">
            <i class="fa fa-angle-left dropdown "></i>
          </span>
    </a>
    <ul class="nav nav-second-level" aria-expanded="true" >
         <li class="listItems">
                     <a href="{{ route('admin.promotions.list') }}" class="waves-effect ">
                         <span>View Promotion List</span>
                     </a>
        </li>
        <li class="listItems">
            <a href="{{ route("system.admin.promotions") }}" class="waves-effect ">
                <span>Guest Promotions List</span>
            </a>
        </li>
    </ul>
</li>
<li class="show-reports-page">
   <a href="javascript:void(0)" class="sub-menu">
      <i class="fa fa-file-text "></i>
      <span>Reports</span>
       <span class="pull-right-container">
          <i class="fa fa-angle-left dropdown "></i>
       </span>
   </a>
   <ul class="nav nav-second-level" aria-expanded="true">
       <li class="">
                  <a href="{{ route('admin.reports') }}" class="waves-effect ">
                      <span> View Reports</span>
                  </a>
        </li>
         <li class="listItems">
                <a href="{{ route("report.user") }}" class="waves-effect ">
                       <span>Reports Add Users</span>
                </a>
         </li>

   </ul>
</li>

<li class="listItems">
      <a href="javascript:void(0)" class="sub-menu">
          <i class="fa fa-tasks"></i>
          <span>Tasks</span>
           <span class="pull-right-container">
             <i class="fa fa-angle-left dropdown "></i>
            </span>
      </a>

      <ul class="nav nav-second-level" aria-expanded="true" >
         <li class="listItems">
             <a href="{{ route('task.list') }}" class="waves-effect ">
                  <span>Task List</span>
             </a>
         </li>
          <li class="listItems">
              <a href="{{ route("task.create") }}" class="waves-effect ">
                  <span>Add Task</span>
              </a>
          </li>
          <li class="listItems">
              <a href="{{ route("admin.category.list") }}" class="waves-effect ">
{{--                            <span>Category Panel</span>--}}
                  <span>Campaign Panel</span>
              </a>
          </li>
          <li class="listItems">
              <a href="{{ route("admin.campaign.association") }}" class="waves-effect ">
                  <span>Marketing Association</span>
              </a>
          </li>
          <li class="listItems">
              <a href="{{ route("admin.campaign.list") }}" class="waves-effect ">
                  <span>12-Month Plan</span>
              </a>
          </li>
      </ul>
  </li>

<li class="listItems">
      <a href="javascript:void(0)" class="sub-menu">
           <i class="fa fa-laptop"></i>
          <span>Marketing Pro Services</span>
           <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right dropdown "></i>
            </span>
      </a>

      <ul class="nav nav-second-level" aria-expanded="true" >
          <li class="listItems">
            <a href="{{ route('pro.list') }}" class="waves-effect ">
                  <span>Services</span>
            </a>
          </li>
          <li class="listItems">
              <a href="{{ route("pro.create") }}" class="waves-effect ">
                  <span>Add Service</span>
              </a>
          </li>
      </ul>
  </li>

<li class="listItems">
     <a href="javascript:void(0)" class="sub-menu">
            <i class="fa fa-tasks"></i>
            <span>Alert Controller</span>
             <span class="pull-right-container">
               <i class="fa fa-angle-left dropdown "></i>
              </span>
       </a>

   <ul class="nav nav-second-level" aria-expanded="true" >

      <li class="listItems">
          <a href="{{ route("alert.help.list") }}" class="waves-effect ">
              <span>Help List</span>
          </a>
      </li>
      <li class="listItems">
          <a href="{{ route("alert.list") }}" class="waves-effect ">
               <span>Widget List</span>
           </a>
       </li>
      <li class="listItems">
          <a href="{{ route("alert.create") }}" class="waves-effect ">
              <span>Add Widget Alert</span>
          </a>
      </li>



  </ul>
  </li>

            {{--<li><a href="{{ route('adminDashboard') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>--}}
{{--<li><a href="{{ route('task.index') }}"><i class="fa fa-dashboard"></i> <span>Task</span></a></li>--}}
{{--<li><a href="{{ route('admin.objectives.list') }}"><i class="fa fa-tasks"></i> <span>Objectives</span></a></li>--}}
{{--<li><a href="{{ route('admin.users.list') }}"><i class="fa fa-user"></i> <span>Administrators</span></a></li>--}}
{{--<li><a href="{{ route('issue.list') }}"><i class="fa fa-bug"></i> <span>Issues</span></a></li>--}}
{{--<li><a href="{{ route('admin.leads') }}"><i class="fa fa-user"></i> <span>Leads</span></a></li>--}}
{{--<li><a href="{{ route('admin.link-building') }}"><i class="fa fa-link"></i> <span>Link Building</span></a></li>--}}
</ul>

</section>
</aside>
{{--@section('after_styles')--}}
{{--    @if( !empty($userData['user_role'][0]['pivot']['role_id']) && $userData['user_role'][0]['pivot']['role_id'] == 3   )--}}
{{--        <style>--}}
{{--            .sidebar-menu li {--}}
{{--                display: none;--}}
{{--            }--}}
{{--            .show-promotion-admin{--}}
{{--                display: block!important;--}}
{{--            }--}}
{{--            .hide-side-bar{--}}
{{--                display: none !important;--}}
{{--            }--}}
{{--        </style>--}}
{{--    @endif--}}
{{--@endsection--}}

<!-- Styles -->
@yield('css_before')

<link rel="stylesheet" href="{{asset('public/css/sidebar.css')}}">

@yield('css_after')

@if( !empty($userData['user_role'][0]['pivot']['role_id']) && $userData['user_role'][0]['pivot']['role_id'] == 3   )
    <style>
        .sidebar-menu li {
            display: none;
        }
        /*.show-promotion-admin{*/
        /*    display: block !important;*/
        /*}*/

    </style>
@endif
@if( !empty($userData['user_role'][0]['pivot']['role_id']) && $userData['user_role'][0]['pivot']['role_id'] == 4   )
    <style>
        .sidebar-menu li {
            display: none;
        }
        /*.show-reports-page{*/
        /*    display: block !important;*/
        /*}*/
    </style>
@endif
