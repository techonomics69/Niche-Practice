<nav class="navbar navbar-default navbar-static-top m-b-0">
    <div class="navbar-header">
        <div class="row">

            <div class="col-md-3 col-xs-6">
                <div class="top-left-part show-side-opner">
                    <a id="sidebar-opener">
                        <div>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </a>

                    <!-- Logo -->
                    <h3 class="web-title my-web-title">
                        <a href="{{ route('home') }}">
                        <img src="{{ asset('public/images/logo-new.png') }}"/></a>
                      {{--   <a href="{{ route('home') }}">
                        Niche Practice
                        </a>--}}
                    </h3>
                </div>

                <!-- Search input and Toggle icon -->
                <ul class="nav navbar-top-links navbar-left in" style="display: none;">
                    <li style="">
                        <a href="javascript:void(0)" class="open-close waves-effect waves-light"><i class="ti-menu"></i></a>
                    </li>
                </ul>
            </div>

            <div class="col-md-5 hidden-sm hidden-xs header-button-hide ">
                <div class="header-center">
                    @if(!empty($userData['subscriptionStatus']['subscription_remaining_days']) && $userData['subscriptionStatus']['subscription_type'] == 'paid')
{{--                        <h3><strong>{{ $userData['subscriptionStatus']['subscription_remaining_days'] }} Days Remaining in Trial</strong></h3>--}}
                        <h3 style="display: none;"><strong>Next Invoice after {{ $userData['subscriptionStatus']['subscription_remaining_days'] }} Days</strong></h3>
                        <a style="display: none;" href="{{ route('upgrade') }}" class="btn btn-primary btn-subscription">UPGRADE</a>
{{--                        <h3><strong>Paid Member</strong></h3>--}}
                    @elseif(!empty($userData['subscriptionStatus']['subscription_remaining_days']) && $userData['subscriptionStatus']['subscription_type'] == 'trial')
                        <h3><strong><?php echo !empty($userData['subscriptionStatus']['subscription_remaining_days']) ? $userData['subscriptionStatus']['subscription_remaining_days'] : '0' ?> </strong>Days Remaining in Trial</h3>
                        <a href="{{ route('upgrade') }}" class="btn btn-primary btn-subscription">UPGRADE</a>
                    @else
                        <h3><strong>Your {{ !empty($userData['subscriptionStatus']['subscription_type']) ? $userData['subscriptionStatus']['subscription_type'] : '' }} account has expired.</strong>
                        <a href="{{ route('upgrade') }}" class="btn btn-primary btn-subscription">UPGRADE</a>
                    @endif


{{--                    <a href="{{ route('credits') }}" class="btn btn-primary btn-subscription credits-btn" style="margin-left: 0px;">CREDITS</a>--}}

                </div>


            </div>

            <div class="col-md-4 col-xs-6">
                <ul class="nav navbar-top-links navbar-right pull-right">

                    <li><a href="https://nichepractice.com/support/" target="_blank" > <button type="button" class="btn btn-link btn-lg p-r-15 my-help-pad"style="text-decoration: none;" {{--style="color: white; text-decoration: none; margin-right: 15px; margin-top: 5px; font-size: 15px;"--}}> <i class="fa fa-question-circle"></i> Help</button></a></li>


                    <li class="dropdown notifaction_li marg-rght" >
                        <a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown"
                           href="javascript:void(0)" aria-expanded="false">
{{--                            <i class="mdi mdi-message-text-outline menu-icon"></i>--}}
                            <i class="mdi mdi-bell menu-icon"></i>
                            <div class="notify" style="">
                                <span class="label label-danger">0</span>
                            </div>
                        </a>
                        <div class="dropdown-menu animated bounceInDown in dropdown-mobile not-lft">
                            <div class="drop-title">
                                Notifications
                                <p class="pull-right read-all-notification" id="read-all-notification" style="cursor: pointer;">Read All</p>
                            </div>
                            <ul class="notificationsbox" style="overflow: hidden; width: auto; height: 320px;">
                            </ul>
                            <div class="row-table" style="display: table;margin: 0px auto;">
                                <img class="mini-loader" src="{{ asset('public/images/spinner.gif') }}" style="margin-top: 8px; display: none;"/>
                            </div>

                            <input type="hidden" id="chatPage" value="1">
                        </div>


                    </li>



                    <li class="user-avatar">
                        <div class="avatar-icon">
{{--                            @if(empty($userData['business'][0]['avatar']))--}}
                            @if(empty($userData['business'][0]['logo']))
                                <img style="width: 35px;height: 35px;border-radius: 35px;" src="{{ asset('public/images/icons/doc.jpg') }}" />
                            @else
{{--                                <img class="has-avatar"  style="width: 35px;height: 35px;border-radius: 35px;" src="{!! uploadImagePath($userData['business'][0]['avatar']) !!}" />--}}
                                <img class="has-avatar"  style="width: 35px;height: 35px;border-radius: 35px;" src="{!! uploadImagePath($userData['business'][0]['logo']) !!}" />
                            @endif
                        </div>
                        <b class="hidden-xs user-profession">
                            {{ $userData['business'][0]['practice_name'] ?? ''  }}
                            <br>
                        </b>
                        {{--<span class="user-profession">--}}
                                {{----}}
                            {{--</span>--}}
                    </li>

                    <li class="dropdown user-profile-dropdown">
                        <a class="dropdown-toggle profile-pic my-profile-pic" data-toggle="dropdown" href="javascript:void(0);" aria-expanded="true">
                            <i class="fa fa-gear"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user animated flipInY">
                            <?php
                            if(empty($requestedUrl))
                            {
                                $requestedUrl = '';
                            }
                            ?>
                            <li>
                            <li class="{{ ( $requestedUrl == route('business-profile') ) ? 'active-menu' : '' }}">
                                <a href="{{ route('business-profile') }}" class="waves-effect {{ ( $requestedUrl == route('business-profile') ) ? 'active' : '' }}">
                                    Business Profile
                                </a>
                            </li>
                            {{--<li class="{{ ( $requestedUrl == route('user-profile') ) ? 'active-menu' : '' }}">--}}
                                {{--<a href="{{ route('user-profile') }}" class="waves-effect {{ ( $requestedUrl == route('user-profile') ) ? 'active' : '' }}">--}}
                                    {{--User Profile--}}
                                {{--</a>--}}
                            {{--</li>--}}
                            <li class="{{ ( $requestedUrl == route('billing-screen') ) ? 'active-menu' : '' }}">
                                <a href="{{ route('billing-screen') }}" class="waves-effect {{ ( $requestedUrl == route('billing-screen') ) ? 'active' : '' }}">
                                    Billing and Plans
                                </a>
                            </li>

{{--                            <li class="{{ ( $requestedUrl == route('connect-app') ) ? 'active-menu' : '' }}">--}}
{{--                                <a href="{{ route('connect-app') }}" class="waves-effect {{ ( $requestedUrl == route('connect-app') ) ? 'active' : '' }}">--}}
{{--                                    --}}{{--<img src="{{ asset('public/images/icons/boost.png') }}"/>--}}
{{--                                    Review Sites--}}
{{--                                </a>--}}
{{--                            </li>--}}

{{--                            <li class="{{ ( $requestedUrl == route('social-media') ) ? 'active-menu' : '' }}">--}}
{{--                                <a href="{{ route('social-media') }}" class="waves-effect {{ ( $requestedUrl == route('social-media') ) ? 'active' : '' }}">--}}
{{--                                    --}}{{--<img src="{{ asset('public/images/icons/boost.png') }}"/>--}}
{{--                                    Social Media--}}
{{--                                </a>--}}
{{--                            </li>--}}

                            <li class="{{ ( $requestedUrl == route('credits') ) ? 'active-menu' : '' }}">
                                <a href="{{ route('credits') }}" class="waves-effect {{ ( $requestedUrl == route('credits') ) ? 'active' : '' }}">
                                    {{--<img src="{{ asset('public/images/icons/boost.png') }}"/>--}}
                                    Purchase Credits
                                </a>
                            </li>

                                <li class="{{ ( $requestedUrl == route('contactus') ) ? 'active-menu' : '' }}">
                                    <a href="{{ route('contactus') }}" class="waves-effect {{ ( $requestedUrl == route('contactus') ) ? 'active' : '' }}">
                                        {{--<img src="{{ asset('public/images/icons/boost.png') }}"/>--}}
                                        Contact Us
                                    </a>
                                </li>
{{--                                <li class="{{ ( $requestedUrl == route('faq') ) ? 'active-menu' : '' }}">--}}
{{--                                    <a href="{{ route('faq') }}" class="waves-effect {{ ( $requestedUrl == route('faq') ) ? 'active' : '' }}">--}}
{{--                                        --}}{{--<img src="{{ asset('public/images/icons/boost.png') }}"/>--}}
{{--                                        FAQ--}}
{{--                                    </a>--}}
{{--                                </li>--}}

                            <li><a href="{{ route('user.logout') }}" class=""> Logout</a></li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>

                    {{--<li class="dropdown user-profile-dropdown" title="User Profile">--}}
                        {{--<a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#">--}}
                            {{--<div class="avatar-icon">--}}
                                {{--<img src="{{ asset('public/images/icons/user.png') }}"/>--}}
                            {{--</div>--}}
                            {{--<b class="hidden-xs username-title">--}}
                                {{--@if(strlen($userData['first_name'] . ' ' . $userData['last_name']) > 13)--}}
                                    {{--{{ $userData['first_name'] }}--}}
                                {{--@else--}}
                                    {{--{{ $userData['first_name'] . ' ' . $userData['last_name'] }}--}}
                                {{--@endif--}}
                                    {{--<br>--}}
                            {{--</b>--}}
                            {{--<span class="caret"></span>--}}
                            {{--<span class="user-profession">--}}
                                {{--{{ $userData['business'][0]['practice_name']  }}--}}
                            {{--</span>--}}
                        {{--</a>--}}
                        {{--<ul class="dropdown-menu dropdown-user animated flipInY">--}}
                            {{--<li>--}}
                                {{--<div class="dw-user-box">--}}
                                    {{--<div class="u-img" style="display: none;"><span class="avatar">WA</span></div>--}}
                                    {{--<div class="u-text">--}}
                                        {{--<h4>--}}
                                            {{--@if(strlen($userData['first_name'] . ' ' . $userData['last_name']) > 25)--}}
                                                {{--{{ $userData['first_name'] }}--}}
                                            {{--@else--}}
                                                {{--{{ $userData['first_name'] . ' ' . $userData['last_name'] }}--}}
                                            {{--@endif--}}
                                        {{--</h4>--}}
                                        {{--<p class="text-muted">{{ $userData['email'] }}</p>--}}


                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</li>--}}
                            {{--<li role="separator" class="divider"></li>--}}


                            {{--<li><a href="{{ route('user.logout') }}" class=""> Logout</a></li>--}}
                        {{--</ul>--}}
                        {{--<!-- /.dropdown-user -->--}}
                    {{--</li>--}}


                    {{--<li>--}}
                        {{--<div class="user-section">--}}
                        {{--<div class="avatar-icon-wrapper">--}}
                            {{--<div class="avatar-icon">--}}
                                {{--<img src="{{ asset('public/images/icons/user.png') }}"/>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="user-right">--}}

                                {{--<div class="username">--}}
                                    {{--@if(strlen($userData['first_name'] . ' ' . $userData['last_name']) > 13)--}}
                                        {{--{{ $userData['first_name'] }}--}}
                                    {{--@else--}}
                                    {{--{{ $userData['first_name'] . ' ' . $userData['last_name'] }}--}}
                                   {{--@endif--}}
                                {{--</div>--}}

                                {{--<div class="user-profession">--}}
                                {{--{{ $userData['business'][0]['practice_name']  }}--}}
                                {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--</li>--}}

<!-- /.dropdown -->
</ul>

</div>


</div>


</div>
<!-- /.navbar-header -->
<!-- /.navbar-top-links -->
<!-- /.navbar-static-side -->
</nav>
