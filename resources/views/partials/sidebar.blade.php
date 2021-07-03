<?php
$requestedUrl = Request::url();
//echo "requestedUrl " . $requestedUrl;
?>

<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav" style="overflow: hidden; width: auto; height: 100%;">
        {{--<div class="sidebar-head"><h3><span class="fa-fw open-close"><i class="ti-close ti-menu"></i></span>--}}
                {{--<span class="hide-menu">Navigation</span></h3>--}}
        {{--</div>--}}
        {{--<div class="clearfix"></div>--}}
        <ul class="nav main-menu in" id="side-menu">
            <li class="{{ ( $requestedUrl == route('home') ) ? 'active-menu' : '' }}">
                <a href="{{ route('home') }}" class="waves-effect {{ ( $requestedUrl == route('home') ) ? 'active' : '' }}">
                    <img style="color: #989CA2; margin-right: 9px;  color: #989ca2; position: relative; font-size:18px; width: 21px; bottom: 1px; " src="{{ asset('public/images/icons/home.png') }}" />
                    <span class="hide-menu">Dashboard</span></a>
            </li>

<!--            --><?php
//            $parentActive = '';
//            $collapse = '';
//
//            if( $requestedUrl == route('task-list') )
//            {
//                $parentActive = 'active-menu';
//            }
//            ?>


{{--            <li class="{{ $parentActive }}">--}}
{{--                <a href="{{ route('task-list') }}" class="waves-effect {{ ( $requestedUrl == route('task-list') ) ? 'active' : '' }}">--}}
{{--                    <i class="fa fa-tasks" style="margin-right: 4px;color: #989ca2;top: 2px;position: relative; font-size:18px;"></i>--}}
{{--                    <span>My Campaigns</span>--}}
{{--                </a>--}}
{{--            </li>--}}


            <?php
            $parentActive = '';
            $collapse = '';

            if( $requestedUrl == route('task-list') || $requestedUrl == route('campaigns-library') || $requestedUrl == route('patients-list') )
            {
                $parentActive = 'active-menu';
                $collapse = 'in';
            }
            ?>

            <li class="{{ ( $requestedUrl == route('task-list') ) ? 'active-menu' : '' }}">
                <a href="{{ route('task-list') }}" class="waves-effect {{ ( $requestedUrl == route('task-list') ) ? 'active-menu' : '' }}">
                    <i class="fa fa-tasks marketing-icon" style=" color: #989CA2; margin-right: 12px;  color: #989ca2; position: relative; font-size:18px;"></i>
                    <span>My Campaigns</span>
                </a>
            </li>


            <li class="{{ ( $requestedUrl == route('campaigns-library') ) ? 'active-menu' : '' }}">
                <a href="{{ route('campaigns-library') }}" class="waves-effect {{ ( $requestedUrl == route('email') ) ? 'active' : '' }}">
                    <i class="fa fa-signal" style=" color: #989CA2; margin-right: 12px;  color: #989ca2; position: relative; font-size:17px;"></i>
{{--                    <span>CAMPAIGN LIBRARY</span>--}}
{{--                    <span>Marketing LIBRARY</span>--}}
                    <span>CAMPAIGN MARKETPLACE</span>
                    {{--                            <span>Campaigns Library</span>--}}
                </a>
            </li>

            <?php
            $parentActive = '';
            $collapse = '';

            if( $requestedUrl == route('reviews') )
            {
                $parentActive = 'active-menu';
            }
            ?>

            <li class="{{ $parentActive }}">
                <a href="{{ route('reviews') }}" class="waves-effect {{ ( $requestedUrl == route('reviews') ) ? 'active' : '' }}">
                    <i class="fa fa-star" style=" color: #989CA2; margin-right: 12px;  color: #989ca2; position: relative; font-size:17px;"></i>
                    Monitor Reviews
                </a>
            </li>

{{--            <li class="{{ ( $requestedUrl == route('library-list') ) ? 'active-menu' : '' }}">--}}
{{--                <a href="{{ route('library-list') }}" class="waves-effect {{ ( $requestedUrl == route('library-list') ) ? 'active' : '' }}">--}}
{{--                    <i class="fas fa-book-reader fa fa-signal"></i>--}}
{{--                    <i class="fa fa-book" style=" color: #989CA2; margin-right: 12px;  color: #989ca2; position: relative; font-size:18px;"></i>--}}
                    {{--                    <span>CAMPAIGN LIBRARY</span>--}}
{{--                    <span>Marketing Packages</span>--}}
                    {{--                            <span>Campaigns Library</span>--}}
{{--                </a>--}}
{{--            </li>--}}

            <li class="{{ ( $requestedUrl == route('patients-list') ) ? 'active-menu' : '' }}">
                <a href="{{ route('patients-list') }}" class="waves-effect {{ ( $requestedUrl == route('patients-list') ) ? 'active' : '' }}">
                    <i class="fa fa-user" style="color: #989CA2; margin-right: 17px;  color: #989ca2; position: relative; font-size:18px;"></i><span class="hide-menu">
                            PATIENT CONTACTS
                        </span>
                </a>
            </li>


            <?php
            $parentActive = '';
            $collapse = '';

            if( $requestedUrl == route('patients-list') )
            {
                $parentActive = 'active-menu';
            }
            ?>

{{--            <li class="{{ $parentActive }}">--}}
{{--                <a href="{{ route('patients-list') }}" class="waves-effect {{ ( $requestedUrl == route('patients-list') ) ? 'active' : '' }}">--}}
{{--                    <i class="fa fa-user" style="color: #989CA2; margin-right: 17px;  color: #989ca2; position: relative; font-size:18px;"></i><span class="hide-menu">--}}
{{--                            Patient Contacts--}}
{{--                        </span>--}}
{{--                </a>--}}
{{--            </li>--}}
            <?php
            $parentActive = '';
            $collapse = '';

            if( $requestedUrl == route('email') || $requestedUrl == route('front.new-patient-emails') )
            {
                $parentActive = 'active-menu';
                $collapse = 'in';
            }
            ?>

            <li class=" {{ $parentActive }}">

                <a href="javascript:void(0);" class="waves-effect {{ ( empty($userData['do_yourself'])) ?  : ''  }}">
{{--                    <img src="{{ asset('public/images/icons/letter.png') }}" style="margin-right: 6px " />--}}
                    <i class="fa fa-envelope" style="color: #989CA2; margin-right: 12px;  color: #989ca2; position: relative; font-size:18px;"></i>
                    <span class="hide-menu">EMAIL MARKETING
                        <span class="fa arrow"></span>
                        </span>
                </a>

                <ul class="nav nav-second-level collapse {{ $collapse }}" aria-expanded="true" style="">
                    <li class="{{ ( $requestedUrl == route('email') ) ? 'active-menu' : '' }}">
                        <a href="{{ route('email') }}" class="waves-effect {{ ( $requestedUrl == route('email') ) ? 'active' : '' }}">
                            <span>Email Campaigns</span>
                        </a>
                    </li>



                    <li class="{{ ( $requestedUrl == route('front.new-patient-emails') ) ? 'active-menu' : '' }}">
                        <a href="{{ route('front.new-patient-emails') }}" class="waves-effect {{ ( $requestedUrl == route('front.new-patient-emails') ) ? 'active' : '' }}">
{{--                            <span>Welcome New Patients</span>--}}
                            <span>New Patient Package</span>
                        </a>
                    </li>
                </ul>
            </li>

            <?php
            $parentActive = '';
            $collapse = '';

            if( $requestedUrl == route('social-posts') || $requestedUrl == route('share-content') )
            {
                $parentActive = 'active-menu';
                $collapse = 'in';
            }
            ?>

            <li class="  {{ $parentActive }}">

                <a href="javascript:void(0);" class="waves-effect {{ ( empty($userData['do_yourself'])) ?  : ''  }}">
{{--                    <img src="{{ asset('public/images/icons/letter.png') }}" style="margin-right: 6px" />--}}
                    <i class="fa fa-share-alt" style="color: #989CA2; margin-right: 14px;  color: #989ca2; position: relative; font-size:18px;"></i>
                    <span class="hide-menu">SOCIAL MEDIA
                        <span class="fa arrow"></span>
                        </span>
                </a>

                <ul class="nav nav-second-level collapse {{ $collapse }}" aria-expanded="true" style="">
                    <li class="{{ ( $requestedUrl == route('social-posts') ) ? 'active-menu' : '' }}">
                        <a href="{{ route('social-posts') }}" class="waves-effect {{ ( $requestedUrl == route('social-posts') ) ? 'active' : '' }}">
                            <span>Create a Post</span>
                        </a>
                    </li>


                    <li class="{{ ( $requestedUrl == route('share-content') ) ? 'active-menu' : '' }}">
                            <a href="{{ route('share-content') }}" class="waves-effect {{ ( $requestedUrl == route('share-content') ) ? 'active' : '' }}">
                            <span>Curated Content</span>
                        </a>
                    </li>
                </ul>
            </li>
            <?php
            $parentActive = '';
            $collapse = '';

            if( $requestedUrl == route('promotions-list') )
            {
                $parentActive = 'active-menu';
            }
            ?>

            <li class="{{ $parentActive }}">
                <a href="{{ route('promotions-list') }}" class="waves-effect {{ ( $requestedUrl == route('promotions-list') ) ? 'active' : '' }}">
{{--                    <i class="fa fa-bar-chart" aria-hidden="true" style="color:#6e7073;margin-right: 6px;"></i>--}}
                    <i class="fa fa-arrow-circle-up" style=" color: #989CA2; margin-right: 15px;  color: #989ca2; position: relative; font-size:18px;"></i>

                    promotions
                </a>
            </li>

            <?php
            $parentActive = '';
            $collapse = '';

            if( $requestedUrl == route('settings.keywords') || $requestedUrl == route('website-audit') || $requestedUrl == route('citation-listings') )
            {
                $parentActive = 'active-menu';
                $collapse = 'in';
            }
            ?>

            <li class=" {{ $parentActive }}">

                <a href="javascript:void(0);" class="waves-effect {{ ( empty($userData['do_yourself'])) ?  : ''  }}">
{{--                    <img src="{{ asset('public/images/icons/letter.png') }}" style="margin-right: 6px" />--}}
                    <i class="fa fa-search" style=" color: #989CA2; margin-right: 13px;  color: #989ca2; position: relative; font-size:18px;"></i>
                    <span class="hide-menu">SEO
                        <span class="fa arrow"></span>
                        </span>
                </a>

                <ul class="nav nav-second-level collapse {{ $collapse }}" aria-expanded="true" style="">
                    <li class="{{ ( $requestedUrl == route('settings.keywords') ) ? 'active-menu' : '' }}">
                        <a href="{{ route('settings.keywords') }}" class="waves-effect {{ ( $requestedUrl == route('settings.keywords') ) ? 'active' : '' }}">
                            <span>Keyword Research</span>
                        </a>
                    </li>

                    <li class="{{ ( $requestedUrl == route('website-audit') ) ? 'active-menu' : '' }}">
                        <a href="{{ route('website-audit') }}" class="waves-effect {{ ( $requestedUrl == route('website-audit') ) ? 'active' : '' }}">
                            <span>SEO Audit</span>
                        </a>
                    </li>

                    <li class="{{ ( $requestedUrl == route('citation-listings') ) ? 'active-menu' : '' }}">
                        <a href="{{ route('citation-listings') }}" class="waves-effect {{ ( $requestedUrl == route('citation-listings') ) ? 'active' : '' }}">
                            <span>Citation Listings</span>
                        </a>
                    </li>
                </ul>
            </li>

            <?php
            $parentActive = '';
            $collapse = '';

            if( $requestedUrl == route('reviews-recipients') )
            {
                $parentActive = 'active-menu';
            }
            ?>

            <li class="{{ $parentActive }}">
                <a href="{{ route('reviews-recipients') }}" class="waves-effect {{ ( $requestedUrl == route('reviews-recipients') ) ? 'active' : '' }}">
                    <i class="fa fa-bar-chart" aria-hidden="true" style="color:#6e7073;  margin-right: 10px;  color: #989ca2; position: relative; font-size:18px;"></i>
                    Reports
                </a>
            </li>


            <?php
            $parentActive = '';
            $collapse = '';

            if( $requestedUrl == route('user-assets') )
            {
                $parentActive = 'active-menu';
            }
            ?>

            <li class="{{ $parentActive }}">
                <a href="{{ route('user-assets') }}" class="waves-effect {{ ( $requestedUrl == route('user-assets') ) ? 'active' : '' }}">
                    <i class="fa fa-adjust" aria-hidden="true" style="color:#6e7073;  margin-right: 10px;  color: #989ca2; position: relative; font-size:18px;"></i>
                    Assets
                </a>
            </li>

            <?php
            $parentActive = '';
            $collapse = '';

            $marketingId = (!empty(Request::segment(2))) ? Request::segment(2) : '';

            if( $requestedUrl == route('marketingpro') || $requestedUrl == route('marketing-pro-details', $marketingId))
            {
            $parentActive = 'active-menu';
            }
            ?>

            <li class="{{ $parentActive }}" style="display: none;">
                <a href="{{ route('marketingpro') }}" class="waves-effect {{ ( $requestedUrl == route('marketingpro') ) ? 'active' : '' }}">
                    <i class="fa fa-briefcase" style=" color: #989CA2; margin-right: 12px;  color: #989ca2; position: relative; font-size:18px;   "></i>

                    MARKETING PRO
                </a>
            </li>

<!--            --><?php
//            $parentActive = '';
//            $collapse = '';
//            if($requestedUrl == route('crm-customers') )
//            {
//                $parentActive = 'active-menu';
//                $collapse = 'in';
//            }
//            ?>
{{--            <li class="{{ $parentActive }}">--}}
{{--                <a href="javascript:void(0);" class="waves-effect {{ ( $requestedUrl == route('reviews') ) ? 'active' : '' }}">--}}
{{--                    <img src="{{ asset('public/images/icons/boost.png') }}"/>--}}
{{--                    <span>Boost Reputation--}}
{{--                        <span class="fa arrow"></span>--}}
{{--                        </span>--}}
{{--                </a>--}}

{{--                <ul class="nav nav-second-level collapse {{ $collapse }}" aria-expanded="true" style="">--}}
{{--                    --}}{{--<li class="{{ ( $requestedUrl == route('connect-app') ) ? 'active-menu' : '' }}">--}}
{{--                    <li class="{{ ( $requestedUrl == route('add-patient') ) ? 'active-menu' : '' }}">--}}
{{--                        <a href="{{ route('add-patient') }}" class="waves-effect {{ ( $requestedUrl == route('add-patient') ) ? 'active' : '' }}">--}}
{{--                            --}}{{--<img src="{{ asset('public/images/icons/boost.png') }}"/>--}}
{{--                            <span>Get More Reviews</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}

{{--                    <li class="{{ ( $requestedUrl == route('reviews-recipients') ) ? 'active-menu' : '' }}">--}}
{{--                        <a href="{{ route('reviews-recipients') }}" class="waves-effect {{ ( $requestedUrl == route('reviews-recipients') ) ? 'active' : '' }}">--}}
{{--                            <span>Requests Sent</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}

{{--                    --}}{{--<li class="">--}}
{{--                    --}}{{--<a href="javascript:void(0);" class="waves-effect">--}}
{{--                    --}}{{--<span>Campaign Metrics</span>--}}
{{--                    --}}{{--</a>--}}
{{--                    --}}{{--</li>--}}
{{--                </ul>--}}
{{--            </li>--}}

<!--            --><?php
//            $parentActive = '';
//            $collapse = '';
//
//            if( $requestedUrl == route('promotions-list') || $requestedUrl == route('settings.keywords') || $requestedUrl == route('citation-listings') || $requestedUrl == route('website-audit')  || $requestedUrl == route('social-posts') || $requestedUrl == route('share-content') || $requestedUrl == route('email') )
//            {
//                $parentActive = 'active-menu';
//                $collapse = 'in';
//            }
//            ?>

{{--            <li class="do-it-yourself {{ $parentActive }}">--}}

{{--                <a href="javascript:void(0);" class="waves-effect {{ ( empty($userData['do_yourself'])) ? 'page-help' : ''  }}" data-module="do_it_yourself">--}}
{{--                    <img src="{{ asset('public/images/icons/letter.png') }}" style="margin-right: 6px" />--}}
{{--                    <span class="hide-menu">DO-IT-YOURSELF--}}
{{--                        <span class="fa arrow"></span>--}}
{{--                        </span>--}}
{{--                </a>--}}

{{--                <ul class="nav nav-second-level collapse {{ $collapse }}" aria-expanded="true" style="">--}}
{{--                    <li class="{{ ( $requestedUrl == route('campaigns-library') ) ? 'active-menu' : '' }}">--}}
{{--                        <a href="{{ route('campaigns-library') }}" class="waves-effect {{ ( $requestedUrl == route('campaigns-library') ) ? 'active' : '' }}">--}}
{{--                            <span>Campaigns Library</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}

{{--                    <li class="{{ ( $requestedUrl == route('email') ) ? 'active-menu' : '' }}">--}}
{{--                        <a href="{{ route('email') }}" class="waves-effect {{ ( $requestedUrl == route('email') ) ? 'active' : '' }}">--}}
{{--                            <span>Email Campaigns</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}

{{--                    --}}{{--<li class="">--}}
{{--                    --}}{{--<a href="javascript:void(0);" class="waves-effect">--}}
{{--                    --}}{{--<span>Contacts</span>--}}
{{--                    --}}{{--</a>--}}
{{--                    --}}{{--</li>--}}

{{--                    <li class="{{ ( $requestedUrl == route('social-posts') ) ? 'active-menu' : '' }}">--}}
{{--                        <a href="{{ route('social-posts') }}" class="waves-effect {{ ( $requestedUrl == route('social-posts') ) ? 'active' : '' }}">--}}
{{--                            <span>Social Posts</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}

{{--                    <li class="{{ ( $requestedUrl == route('front.new-patient-emails') ) ? 'active-menu' : '' }}">--}}
{{--                        <a href="{{ route('front.new-patient-emails') }}" class="waves-effect {{ ( $requestedUrl == route('front.new-patient-emails') ) ? 'active' : '' }}">--}}
{{--                            <span>New Patient Welcome</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}

{{--                    <li class="{{ ( $requestedUrl == route('share-content') ) ? 'active-menu' : '' }}">--}}
{{--                        <a href="{{ route('share-content') }}" class="waves-effect {{ ( $requestedUrl == route('share-content') ) ? 'active' : '' }}">--}}
{{--                            <span>--}}
{{--                                Curated content--}}
{{--                            </span>--}}
{{--                        </a>--}}
{{--                    </li>--}}

{{--                    <li class="{{ ( $requestedUrl == route('promotions-list') ) ? 'active-menu' : '' }}">--}}
{{--                        <a href="{{ route('promotions-list') }}" class="waves-effect {{ ( $requestedUrl == route('promotions-list') ) ? 'active' : '' }}">--}}
{{--                            <span>Promotions</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}

{{--                    <li class="{{ ( $requestedUrl == route('settings.keywords') ) ? 'active-menu' : '' }}">--}}
{{--                        <a href="{{ route('settings.keywords') }}" class="waves-effect {{ ( $requestedUrl == route('settings.keywords') ) ? 'active' : '' }}">--}}
{{--                            <span>Keyword Research</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}

{{--                    <li class="{{ ( $requestedUrl == route('website-audit') ) ? 'active-menu' : '' }}">--}}
{{--                        <a href="{{ route('website-audit') }}" class="waves-effect {{ ( $requestedUrl == route('website-audit') ) ? 'active' : '' }}">--}}
{{--                            <span>SEO Audit</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}

{{--                    <li class="{{ ( $requestedUrl == route('citation-listings') ) ? 'active-menu' : '' }}">--}}
{{--                        <a href="{{ route('citation-listings') }}" class="waves-effect {{ ( $requestedUrl == route('citation-listings') ) ? 'active' : '' }}">--}}
{{--                            <span>Citation Listings</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--            </li>            --}}
<?php
//            $parentActive = '';
//            $collapse = '';
//
//            if( $requestedUrl == route('promotions-list') || $requestedUrl == route('settings.keywords') || $requestedUrl == route('citation-listings') || $requestedUrl == route('website-audit')  || $requestedUrl == route('social-posts') || $requestedUrl == route('share-content') || $requestedUrl == route('email') )
//            {
//                $parentActive = 'active-menu';
//                $collapse = 'in';
//            }
//            ?>

{{--            <li class="do-it-yourself {{ $parentActive }}">--}}

{{--                <a href="javascript:void(0);" class="waves-effect {{ ( empty($userData['do_yourself'])) ? 'page-help' : ''  }}" data-module="do_it_yourself">--}}
{{--                    <img src="{{ asset('public/images/icons/letter.png') }}" style="margin-right: 6px" />--}}
{{--                    <span class="hide-menu">DO-IT-YOURSELF--}}
{{--                        <span class="fa arrow"></span>--}}
{{--                        </span>--}}
{{--                </a>--}}

{{--                <ul class="nav nav-second-level collapse {{ $collapse }}" aria-expanded="true" style="">--}}
{{--                    <li class="{{ ( $requestedUrl == route('campaigns-library') ) ? 'active-menu' : '' }}">--}}
{{--                        <a href="{{ route('campaigns-library') }}" class="waves-effect {{ ( $requestedUrl == route('campaigns-library') ) ? 'active' : '' }}">--}}
{{--                            <span>Campaigns Library</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}

{{--                    <li class="{{ ( $requestedUrl == route('email') ) ? 'active-menu' : '' }}">--}}
{{--                        <a href="{{ route('email') }}" class="waves-effect {{ ( $requestedUrl == route('email') ) ? 'active' : '' }}">--}}
{{--                            <span>Email Campaigns</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}

{{--                    --}}{{--<li class="">--}}
{{--                    --}}{{--<a href="javascript:void(0);" class="waves-effect">--}}
{{--                    --}}{{--<span>Contacts</span>--}}
{{--                    --}}{{--</a>--}}
{{--                    --}}{{--</li>--}}

{{--                    <li class="{{ ( $requestedUrl == route('social-posts') ) ? 'active-menu' : '' }}">--}}
{{--                        <a href="{{ route('social-posts') }}" class="waves-effect {{ ( $requestedUrl == route('social-posts') ) ? 'active' : '' }}">--}}
{{--                            <span>Social Posts</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}

{{--                    <li class="{{ ( $requestedUrl == route('front.new-patient-emails') ) ? 'active-menu' : '' }}">--}}
{{--                        <a href="{{ route('front.new-patient-emails') }}" class="waves-effect {{ ( $requestedUrl == route('front.new-patient-emails') ) ? 'active' : '' }}">--}}
{{--                            <span>New Patient Welcome</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}

{{--                    <li class="{{ ( $requestedUrl == route('share-content') ) ? 'active-menu' : '' }}">--}}
{{--                        <a href="{{ route('share-content') }}" class="waves-effect {{ ( $requestedUrl == route('share-content') ) ? 'active' : '' }}">--}}
{{--                            <span>--}}
{{--                                Curated content--}}
{{--                            </span>--}}
{{--                        </a>--}}
{{--                    </li>--}}

{{--                    <li class="{{ ( $requestedUrl == route('promotions-list') ) ? 'active-menu' : '' }}">--}}
{{--                        <a href="{{ route('promotions-list') }}" class="waves-effect {{ ( $requestedUrl == route('promotions-list') ) ? 'active' : '' }}">--}}
{{--                            <span>Promotions</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}

{{--                    <li class="{{ ( $requestedUrl == route('settings.keywords') ) ? 'active-menu' : '' }}">--}}
{{--                        <a href="{{ route('settings.keywords') }}" class="waves-effect {{ ( $requestedUrl == route('settings.keywords') ) ? 'active' : '' }}">--}}
{{--                            <span>Keyword Research</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}

{{--                    <li class="{{ ( $requestedUrl == route('website-audit') ) ? 'active-menu' : '' }}">--}}
{{--                        <a href="{{ route('website-audit') }}" class="waves-effect {{ ( $requestedUrl == route('website-audit') ) ? 'active' : '' }}">--}}
{{--                            <span>SEO Audit</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}

{{--                    <li class="{{ ( $requestedUrl == route('citation-listings') ) ? 'active-menu' : '' }}">--}}
{{--                        <a href="{{ route('citation-listings') }}" class="waves-effect {{ ( $requestedUrl == route('citation-listings') ) ? 'active' : '' }}">--}}
{{--                            <span>Citation Listings</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--            </li>--}}

            <?php
            $parentActive = '';
            $collapse = '';

            if( $requestedUrl == route('website-content') || $requestedUrl == route('social-media-profiles')|| $requestedUrl == route('blog-articles') || $requestedUrl == route('press-release') )
            {
                $parentActive = 'active-menu';
                $collapse = 'in';
            }
            ?>

{{--            <li class="{{ $parentActive }}">--}}
{{--                <a href="javascript:void(0);" class="waves-effect">--}}
{{--                    <i class="fa fa-line-chart fa-fw" style="color:#6e7073; margin-right: 4px;"></i>--}}
{{--                    <span class="hide-menu">Become an Expert--}}
{{--                        <span class="fa arrow"></span>--}}
{{--                        </span>--}}
{{--                </a>--}}

                <ul class="nav nav-second-level collapse {{ $collapse }}" aria-expanded="true" style="">
                    <li class="{{ ( $requestedUrl == route('website-content') ) ? 'active-menu' : '' }}">
                        <a href="{{ route('website-content') }}" class="waves-effect {{ ( $requestedUrl == route('website-content') ) ? 'active' : '' }}">
                            <span>Branded Content</span>
                        </a>
                    </li>

{{--                    <li class="{{ ( $requestedUrl == route('social-media-profiles') ) ? 'active-menu' : '' }}">--}}
{{--                        <a href="{{ route('social-media-profiles') }}" class="waves-effect {{ ( $requestedUrl == route('social-media-profiles') ) ? 'active' : '' }}">--}}
{{--                            <span>Social Media Profiles</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}

                    <li class="{{ ( $requestedUrl == route('blog-articles') ) ? 'active-menu' : '' }}">
                        <a href="{{ route('blog-articles') }}" class="waves-effect {{ ( $requestedUrl == route('blog-articles') ) ? 'active' : '' }}">
                            <span>Blog Articles</span>
                        </a>
                    </li>

                    <li class="{{ ( $requestedUrl == route('press-release') ) ? 'active-menu' : '' }}">
                        <a href="{{ route('press-release') }}" class="waves-effect {{ ( $requestedUrl == route('press-release') ) ? 'active' : '' }}">
                            <span>Press Releases</span>
                        </a>
                    </li>
                </ul>
            </li>

            <?php
            $parentActive = '';
            $collapse = '';

            if( $requestedUrl == route('website-audit') || $requestedUrl == route('settings.keywords') || $requestedUrl == route('citation-listings') || $requestedUrl == route('advanced-seo') || $requestedUrl == route('pay-per-page'))
            {
                $parentActive = 'active-menu';
                $collapse = 'in';
            }
            ?>

{{--            <li class="{{ $parentActive }}">--}}
{{--                <a href="javascript:void(0);" class="waves-effect">--}}
{{--                    <i class="fa fa-globe fa-fw" style="color:#6e7073; margin-right: 4px;"></i>--}}
{{--                    <span class="hide-menu">Generate Leads--}}
{{--                        <span class="fa arrow"></span>--}}
{{--                        </span>--}}
{{--                </a>--}}

{{--                <ul class="nav nav-second-level collapse {{ $collapse }}" aria-expanded="true" style="">--}}
{{--                    <li class="{{ ( $requestedUrl == route('settings.keywords') ) ? 'active-menu' : '' }}">--}}
{{--                        <a href="{{ route('settings.keywords') }}" class="waves-effect {{ ( $requestedUrl == route('settings.keywords') ) ? 'active' : '' }}">--}}
{{--                            <span>Keyword Research</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}

{{--                    <li class="{{ ( $requestedUrl == route('website-audit') ) ? 'active-menu' : '' }}">--}}
{{--                        <a href="{{ route('website-audit') }}" class="waves-effect {{ ( $requestedUrl == route('website-audit') ) ? 'active' : '' }}">--}}
{{--                            <span>SEO Audit</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}

{{--                    <li class="{{ ( $requestedUrl == route('citation-listings') ) ? 'active-menu' : '' }}">--}}
{{--                        <a href="{{ route('citation-listings') }}" class="waves-effect {{ ( $requestedUrl == route('citation-listings') ) ? 'active' : '' }}">--}}
{{--                            <span>Citation Listings</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}

{{--                </ul>--}}
{{--            </li>--}}
            {{-- <li class="{{ $parentActive }}">
                <a href="javascript:void(0);" class="waves-effect">
                    <i class="fa fa-globe fa-fw" style="color:#6e7073; margin-right: 4px;"></i>
                    <span class="hide-menu">EXPERT SERVICES
                        <span class="fa arrow"></span>
                        </span>
                </a>

                <ul class="nav nav-second-level collapse {{ $collapse }}" aria-expanded="true" style="">

                    <li class="{{ ( $requestedUrl == route('advanced-seo') ) ? 'active-menu' : '' }}">
                        <a href="{{ route('advanced-seo') }}" class="waves-effect {{ ( $requestedUrl == route('advanced-seo') ) ? 'active' : '' }}">
                            <span>Advanced SEO</span>
                        </a>
                    </li>

                    <li class="">
                        <a href="{{ route('pay-per-page') }}" class="waves-effect">
                            <span>Pay-Per-Click</span>
                        </a>
                    </li>
                    <li class="">
                        <a href="#" class="waves-effect">
                            <span>Ideal Audience</span>
                        </a>
                    </li>
                </ul>
            </li> --}}

            <?php
            $parentActive = '';
            $collapse = '';

            if($requestedUrl == route('automated-emails') || $requestedUrl == route('custom-social-posts') || $requestedUrl == route('pay-per-click') || $requestedUrl == route('landing-page'))
            {
                $parentActive = 'active-menu';
                $collapse = 'in';
            }
            ?>

            <li style="display:none;" class="{{ $parentActive }}">
                <a href="javascript:void(0);" class="waves-effect">
                    {{--<img src="{{ asset('public/images/icons/letter.png') }}" style="margin-right: 6px" />--}}
                    <img src="{{ asset('public/images/icons/megaphone.png') }}" style="margin-right: 3px" />
                    <span class="hide-menu">
                        Done-For-You
                        <span class="fa arrow"></span>
                    </span>
                </a>

                <ul class="nav nav-second-level collapse {{ $collapse }}" aria-expanded="true" style="">


                    <li class="{{ ( $requestedUrl == route('overview') ) ? 'active-menu' : '' }}">
                        <a style="color: #bababa !important;" href="{{ route('overview') }}" class="waves-effect {{ ( $requestedUrl == route('overview') ) ? 'active' : '' }}">
                            <span>Overview</span>
                        </a>
                    </li>

                    <li class="" style="display: none;">
                        <a href="javascript:void(0);" class="waves-effect">
                            <span>
                                 My Ideal Patient
                            </span>
                        </a>
                    </li>

                    <li class="{{ ( $requestedUrl == route('pay-per-click') ) ? 'active-menu' : '' }}">
{{--                        <a style="color: #bababa !important;"  href="{{ route('pay-per-click') }}" class="waves-effect {{ ( $requestedUrl == route('pay-per-click') ) ? 'active' : '' }}">--}}
{{--                        <a style="color: #bababa !important;"  href="{{ route('pay-per-click') }}" class="waves-effect {{ ( $requestedUrl == route('pay-per-click') ) ? 'active' : '' }}">--}}
                        <a style="color: #bababa !important;"  href="javascript:void(0);" class="waves-effect">
                            <span>
                                 Targeted Ads (PPC)
                            </span>
                        </a>
                    </li>

                    <li class="{{ ( $requestedUrl == route('landing-page') ) ? 'active-menu' : '' }}">
{{--                        <a style="color: #bababa !important;"  href="{{ route('landing-page') }}" class="waves-effect {{ ( $requestedUrl == route('landing-page') ) ? 'active' : '' }}">--}}
                        <a style="color: #bababa !important;"  href="javascript:void(0);" class="waves-effect">
                            <span>Landing Page</span>
                        </a>
                    </li>

                    <li class="{{ ( $requestedUrl == route('automated-emails') ) ? 'active-menu' : '' }}">
{{--                        <a style="color: #bababa !important;" href="{{ route('automated-emails') }}" class="waves-effect {{ ( $requestedUrl == route('automated-emails') ) ? 'active' : '' }}">--}}
                        <a style="color: #bababa !important;"  href="javascript:void(0);" class="waves-effect">
                            <span>Automated Emails</span>
                        </a>
                    </li>

                    <li class="{{ ( $requestedUrl == route('custom-social-posts') ) ? 'active-menu' : '' }}">
{{--                        <a style="color: #bababa !important;" href="{{ route('custom-social-posts') }}" class="waves-effect {{ ( $requestedUrl == route('custom-social-posts') ) ? 'active' : '' }}">--}}
                        <a style="color: #bababa !important;"  href="javascript:void(0);" class="waves-effect">
                            <span>Social Posts</span>
                        </a>
                    </li>


                    <li style="display: none;" class="{{ ( $requestedUrl == route('detailed-analytics') ) ? 'active-menu' : '' }}">
                        <a href="{{ route('detailed-analytics') }}" class="waves-effect {{ ( $requestedUrl == route('detailed-analytics') ) ? 'active' : '' }}">
{{--                        <a style="color: #bababa !important;"  href="javascript:void(0);" class="waves-effect">--}}
                            <span>Detailed Analytics
                            </span>
                        </a>
                    </li>
                </ul>
            </li>

            <?php
            $parentActive = '';
            $collapse = '';
            if($requestedUrl == route('email-campaign') || $requestedUrl == route('business-listings'))
            {
                $parentActive = 'active-menu';
                $collapse = 'in';
            }
            ?>

            {{--<li class="{{ $parentActive }}">--}}
            {{--<a href="javascript:void(0);" class="waves-effect">--}}
            {{--<img src="{{ asset('public/images/icons/megaphone.png') }}"/>--}}
            {{--<span class="hide-menu">Managed Services--}}
            {{--<span class="fa arrow"></span>--}}
            {{--</span>--}}
            {{--</a>--}}

            {{--<ul class="nav nav-second-level collapse {{ $collapse }}" aria-expanded="true" style="">--}}
            {{--<li class="{{ ( $requestedUrl == route('email-campaign') ) ? 'active-menu' : '' }}">--}}
            {{--<a href="{{ route('email-campaign') }}" class="waves-effect {{ ( $requestedUrl == route('email-campaign') ) ? 'active' : '' }}">--}}
            {{--<span>Email</span>--}}
            {{--</a>--}}
            {{--</li>--}}

            {{--<li class="">--}}
            {{--<a href="javascript:void(0);" class="waves-effect">--}}
            {{--<span>Social Media</span>--}}
            {{--</a>--}}
            {{--</li>--}}


            {{--<li class="">--}}
            {{--<a href="javascript:void(0);" class="waves-effect">--}}
            {{--<span>SEO</span>--}}
            {{--</a>--}}
            {{--</li>--}}

            {{--<li class="">--}}
            {{--<a href="javascript:void(0);" class="waves-effect">--}}
            {{--<span>Content Marketing</span>--}}
            {{--</a>--}}
            {{--</li>--}}

            {{--<li class="{{ ( $requestedUrl == route('business-listings') ) ? 'active-menu' : '' }}">--}}
            {{--<a href="{{ route('business-listings') }}" class="waves-effect {{ ( $requestedUrl == route('business-listings') ) ? 'active' : '' }}">--}}
            {{--<span>Citation Listings</span>--}}
            {{--</a>--}}
            {{--</li>--}}

            {{--<li class="">--}}
            {{--<a href="javascript:void(0);" class="waves-effect">--}}
            {{--<span>Pay-Per-Click</span>--}}
            {{--</a>--}}
            {{--</li>--}}
            {{--</ul>--}}
            {{--</li>--}}

            <?php
            //                $parentActive = '';
            //                $collapse = '';
            //                if($requestedUrl == route('business-profile') || $requestedUrl == route('billing-screen') || $requestedUrl == route('user-profile') || $requestedUrl == route('connect-app'))
            //                {
            //                    $parentActive = 'active-menu';
            //                    $collapse = 'in';
            //                }
            ?>

            {{--<li class="{{ $parentActive }}">--}}
            {{--<a href="javascript:void(0);" class="waves-effect">--}}
            {{--<img src="{{ asset('public/images/icons/settings.png') }}"/>--}}
            {{--<span class="hide-menu">Settings--}}
            {{--<span class="fa arrow"></span>--}}
            {{--</span>--}}
            {{--</a>--}}

            {{--<ul class="nav nav-second-level collapse {{ $collapse }}" aria-expanded="true" style="">--}}
            {{--<li class="{{ ( $requestedUrl == route('business-profile') ) ? 'active-menu' : '' }}">--}}
            {{--<a href="{{ route('business-profile') }}" class="waves-effect {{ ( $requestedUrl == route('business-profile') ) ? 'active' : '' }}">--}}
            {{--<span>Business Profile</span>--}}
            {{--</a>--}}
            {{--</li>--}}

            {{--<li class="{{ ( $requestedUrl == route('user-profile') ) ? 'active-menu' : '' }}">--}}
            {{--<a href="{{ route('user-profile') }}" class="waves-effect {{ ( $requestedUrl == route('user-profile') ) ? 'active' : '' }}">--}}
            {{--<span>User Profile</span>--}}
            {{--</a>--}}
            {{--</li>--}}

            {{--<li class="{{ ( $requestedUrl == route('billing-screen') ) ? 'active-menu' : '' }}">--}}
            {{--<a href="{{ route('billing-screen') }}" class="waves-effect {{ ( $requestedUrl == route('billing-screen') ) ? 'active' : '' }}">--}}
            {{--<span>Billing</span>--}}
            {{--</a>--}}
            {{--</li>--}}

            {{--<li class="{{ ( $requestedUrl == route('connect-app') ) ? 'active-menu' : '' }}">--}}
            {{--<a href="{{ route('connect-app') }}" class="waves-effect {{ ( $requestedUrl == route('connect-app') ) ? 'active' : '' }}">--}}
            {{--<img src="{{ asset('public/images/icons/boost.png') }}"/>--}}
            {{--<span>Review Sites</span></a>--}}
            {{--</li>--}}
            {{--</ul>--}}
            {{--</li>--}}
        </ul>

        <div class="sidebar-available-credits">
            <div class="d-flex justify-content-center " style="align-items: flex-end">
            <h1>{{ $userCredits }}</h1>
                <h3 class="credits-left-menu" >credits</h3>
            </div>
            <a href="{{ route('credits') }}" class="buy-credits-btn" >+ Buy Credits</a>
{{--            <a class="learnmore" href="{{ route('faq') }}" style="text-decoration: underline;">  Learn More</a>--}}

        </div>
    </div>
</div>

