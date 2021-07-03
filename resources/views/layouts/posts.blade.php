@extends('index')

@section('pageTitle', 'Social Posts')

@section('content')
    <div id="page-wrapper" style="min-height: 205px;">
        <div class="container-fluid dashboarbgtitle">
            <div class="dashboard-wrapper social-publish-scheduling">
                <div class="page-head">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="page-title"> Social Posts
                                {{--                                <a class="page-help" href="javascript:void(0)">
                                                                    <i class="fa fa-question-circle-o" style="color: #7d8080;/* transform: scaleX(-1); */margin-right: 5px;"></i>
                                                                    <img class="help-info-image" src="{{ asset('public/images/information.png') }}" />
                                                                </a>--}}
                            </h4>
                        </div>
                        <div class="col-md-6">
                            @if(!empty($socialMediaPostsData))
                                <div class="dropdown p-m-dropdow">
                                    <button class="btn btn-pw-dropdown dropdown-toggle" type="button"
                                            data-toggle="dropdown" aria-expanded="false">Post Message
                                        <span class="caret"></span></button>

                                    <ul class="dropdown-menu">
                                        <li><a href="javascript:void(0);" class="add_posts">Create from Scratch</a></li>
                                        <li><a href="{{ route('share-content') }}" class="my-search-hover">Search
                                                content to post</a></li>
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        @if(empty($socialMediaPostsData))
                            <div class="social-profile-wrapper">
                                <div class="social-head">
                                    <h3>Engage your customers through your social account.</h3>
                                    <p>Connect your social accounts to start posting and scheduling content for your
                                        users,
                                        so they <br> remain updated with your latest news. </p>
                                </div>

                                <div class="social-connects">
                                    <div class="facebook-connect">
                                        <img src="{{ asset('public/images/icons/facebook-widget.png') }}">
                                        <div>
                                            <a href="javascript:void(0)"
                                               class="btn btn-default btn-social-add connect-app" data-type="Facebook">Add
                                                Facebook</a>
                                        </div>
                                    </div>

                                    <div class="twitter-connect">
                                        <img src="{{ asset('public/images/icons/twitter-widget.png') }}">
                                        <div>
                                            <a href="javascript:void(0);"
                                               class="btn btn-default btn-social-add connect-app" data-type="Twitter">Add
                                                Twitter</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <?php
                            if (!empty($socialMediaPostsData['Facebook']['status']) && strtolower($socialMediaPostsData['Facebook']['status']) == 'connected') {
                                $fbStatus = 'connected';
                            } else {
                                $fbStatus = 'not_connected';
                            }

                            if (!empty($socialMediaPostsData['Twitter']['status']) && strtolower($socialMediaPostsData['Twitter']['status']) == 'connected') {
                                $tStatus = 'connected';
                            } else {
                                $tStatus = 'not_connected';
                            }
                            ?>
                            <div class="social-posts-wrapper">
                                <div class="row">
                                    <div class="col-md-8">

                                        <div class="post-tabs"
                                             style="display: {{ ($fbStatus == 'connected') ? 'block' : 'none'}}">
                                            <ul class="nav nav-tabs" role="tablist">
                                                <li role="presentation" class="active" id="PublishedViewTab">
                                                    <a href="#published" aria-controls="published" role="tab"
                                                       data-toggle="tab" aria-expanded="true">Posted</a>
                                                </li>
                                                <li id="ScheduledViewTab">
                                                    <a href="#ScheduledTab" role="tab" data-toggle="tab"
                                                       aria-expanded="true">Scheduled</a>
                                                </li>
                                            </ul>

                                            <!-- Tab panes -->
                                            <div class="tab-content">
                                                {{--Publised --}}
                                                <div role="tabpanel" class="tab-pane active" id="published">
                                                    <div class="scheduled-posts facebook-panel panel active"
                                                         id="PublishedFacebookTab">
                                                        <div class="empty-posts" style="display: none;">

                                                            <img class="social-posts-empty"
                                                                 src="{{ asset('public/images/social-posts-empty.png') }}"/>

                                                            <div class="e-create-post">
                                                                <h3>Nothing Here</h3>
                                                                <p>Create your first post and share your thoughts with
                                                                    the world.</p>
                                                                {{--                                                                    <p>Lets create your first post and share your thoughts with the world.</p>--}}
                                                                <div class="post-buttons">
                                                                    <a href="#"><label></label></a>
                                                                    <a href="{{ route('share-content') }}"
                                                                       class="btn btn-searchcontent">Search Content to
                                                                        Post</a>
                                                                    <a href="javascript:void(0);"
                                                                       class="btn btn-createpost add_posts">Create from
                                                                        Scratch</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="scheduled-posts twitter-panel panel"
                                                         id="PublishedTwitterTab">
                                                        <div class="empty-posts" style="display: none;">
                                                            <img class="social-posts-empty"
                                                                 src="{{ asset('public/images/social-posts-empty.png') }}"/>
                                                            <div class="e-create-post">
                                                                <h3>Nothing Here</h3>
                                                                <p>Create your first post and share your thoughts with
                                                                    the world.</p>
                                                                <div class="post-buttons">
                                                                    <a href="#"><label></label></a>
                                                                    <a href="{{ route('share-content') }}"
                                                                       class="btn btn-searchcontent">Search Content to
                                                                        Post</a>
                                                                    <a href="javascript:void(0);"
                                                                       class="btn btn-createpost add_posts">Create from
                                                                        Scratch</a>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div role="tabpanel" class="scheduled-posts tab-pane" id="ScheduledTab">
                                                    @if(isset($socialMediaPostsData) && isset($socialMediaPostsData['schedule']) && empty($socialMediaPostsData['schedule']))
                                                        <div class="add_posts_img_container">
                                                            <div class="add_posts_img">
                                                                <img
                                                                    src="{{asset('public/images/social-media-posts.png')}}">
                                                            </div>
                                                            <div class="add_posts_desc_container">
                                                                <p class="add_posts_desc">Nothing to share with the
                                                                    world.</p>
                                                                <button class="btn btn-info m-t-5 m-b-20 add_posts">Add
                                                                    New Post
                                                                </button>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="connect-facebook-img-container connect-container"
                                             style="display: {{ ($fbStatus == 'not_connected') ? 'block' : 'none'}}">
                                            <div class="connect_twitter_img">
                                                <img src="{{ asset('public/images/connect-facebook-login.png') }}">
                                            </div>
                                            <div class="connect_twitter_desc_container">
                                                <p class="connect_twitter_desc">Facebook not Connected</p>
                                                <button class="btn btn-info m-t-5 connect_twitter_btn connect-app"
                                                        data-type="Facebook">Connect Facebook
                                                </button>
                                            </div>
                                        </div>

                                        <div class="connect-twitter-img-container connect-container"
                                             style="display: none;">
                                            <div class="connect_twitter_img">
                                                <img src="{{ asset('public/images/connect-twitter-login.png') }}">
                                            </div>
                                            <div class="connect_twitter_desc_container">
                                                <p class="connect_twitter_desc">Twitter not Connected</p>
                                                <button class="btn btn-info m-t-5 connect_twitter_btn connect-app"
                                                        data-type="Twitter">Connect Twitter
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="profiles-widget">
                                            <h3 class="pw-heading">Profiles</h3>
                                            <ul class="social-profile-tab">
                                                <li id="PublishedFacebookImgTab" class="active" data-type="facebook"
                                                    data-status="{{ $fbStatus }}">
                                                    @if($fbStatus == 'connected' && !empty($socialMediaPostsData['Facebook']['profile_photo']))
                                                        <img class="profile-picture"
                                                             src="{{ $socialMediaPostsData['Facebook']['profile_photo'] }}"/>
                                                    @else
                                                        <img class="profile-picture"
                                                             src="{{ asset('public/images/facebook.png') }}"/>
                                                    @endif

                                                    <div class="content-right">
                                                        @if($fbStatus == 'connected')
                                                            <h3><?php echo $socialMediaPostsData['Facebook']['name']; ?></h3>
                                                            <label>Facebook</label>
                                                        @else
                                                            <h3>Connect Facebook</h3>
                                                            <label>Facebook</label>
                                                        @endif
                                                    </div>
                                                </li>

                                                <li id="PublishedTwitterTabImgTab" data-status="{{ $tStatus }}"
                                                    data-type="twitter">
                                                    @if($tStatus == 'connected' && !empty($socialMediaPostsData['Twitter']['profile_photo']))
                                                        <img class="profile-picture"
                                                             src="{{ $socialMediaPostsData['Twitter']['profile_photo'] }}"/>
                                                    @else
                                                        <img class="profile-picture"
                                                             src="{{ asset('public/images/twitter.png') }}"/>
                                                    @endif
                                                    <div class="content-right">
                                                        @if($tStatus == 'connected')
                                                            <h3><?php echo $socialMediaPostsData['Twitter']['name']; ?></h3>
                                                            <label>Twitter</label>
                                                        @else
                                                            <h3>Twitter</h3>
                                                            <label>Connect Twitter</label>
                                                        @endif
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @include('partials.social-media-modals')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="currentPage" value="posts"/>
    <input type="hidden" id="business_id" value="{{ $userData['business'][0]['business_id'] }}"/>

    @if($socialToken == 1 && $accessTokenType != '')
        <input type="hidden" id="accessToken" value="{{ $socialToken }}" data-type="{{ $accessTokenType }}"/>
    @endif

    @if(!empty($authResponse))
        <input type="hidden" id="auth-response" value="{{ $authResponse }}" data-code="{{ $authCode }}"
               data-message="{{ $authMessage }}" data-type="{{ $authType }}"/>
    @endif


    <?php
    if (isset($socialMediaPostsData['schedule'])) {
        $schedulePostsArr = $socialMediaPostsData['schedule'];
        $schedulePostsArrJson = json_encode($schedulePostsArr);
        echo '<script>var schedulePostsData=' . $schedulePostsArrJson . ';</script>';
    } else {
        echo '<script>var schedulePostsData=[]; </script>';
    }

    if (isset($socialMediaPostsData['published']['Facebook']['posts']) && !empty($socialMediaPostsData['published']['Facebook']['posts'])) {
        $publishedFacebookPostsArr = $socialMediaPostsData['published']['Facebook']['posts'];
        echo '<input type="hidden" id="paging-after" value="' . $publishedFacebookPostsArr['after'] . '" />';
        unset($publishedFacebookPostsArr['after']);
        $publishedFacebookPostsArrJson = json_encode($publishedFacebookPostsArr);
        echo '<script>var publishedFacebookPostsData=' . $publishedFacebookPostsArrJson . ';</script>';
    } else {
        echo '<script>var publishedFacebookPostsData=[]; </script>';
    }

    if (isset($socialMediaPostsData['published']['Twitter']['posts']) && !empty($socialMediaPostsData['published']['Twitter']['posts'])) {
        $publishedTwitterPostsArr = $socialMediaPostsData['published']['Twitter']['posts'];
        $publishedTwitterPostsArrJson = json_encode($publishedTwitterPostsArr);
        echo '<script>var publishedTwitterPostsData=' . $publishedTwitterPostsArrJson . ';</script>';
    } else {
        echo '<script>var publishedTwitterPostsData=[]; </script>';
    }

    if (isset($socialMediaPostsData['published']['Linkedin']['posts']) && !empty($socialMediaPostsData['published']['Linkedin']['posts'])) {
        $publishedLinkedInPostsArr = $socialMediaPostsData['published']['Linkedin']['posts'];
        $publishedLinkedInPostsArrJson = json_encode($publishedLinkedInPostsArr);
        echo '<script>var publishedLinkedInPostsData=' . $publishedLinkedInPostsArrJson . ';</script>';
    } else {
        echo '<script>var publishedLinkedInPostsData=[]; </script>';
    }

    ?>

@endsection

@section('css')
    <link type="text/css" rel="stylesheet" href="{{ asset('public/plugins/toastr/toastr.min.css') }}">
    <link type="text/css" rel="stylesheet"
          href="{{ asset('public/css/social-media-common.css?ver='.$appFileVersion) }}"/>
    <link type="text/css" href="{{ asset('public/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet"/>
    <link type="text/css" rel="stylesheet" href="{{ asset('public/plugins/lightbox/lightbox.css') }}"/>

    <style>
        .my-search-hover:hover {
            background: #00C4FE !important;

        }

        .loader {
            border: 3px solid #f3f3f3;
            border-radius: 50%;
            border-top: 3px solid #3498db;
            width: 16px;
            height: 16px;
            -webkit-animation: spin 2s linear infinite; /* Safari */
            animation: spin 2s linear infinite;
        }

        /* Safari */
        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
    </style>
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('public/plugins/toastr/toastr.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/bootstrap-datetimepicker.js') }}"></script>
    <script src="{{ asset('public/plugins/lightbox/lightbox.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/common-social-media.js?ver='.$appFileVersion) }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/posts.js?ver='.$appFileVersion) }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/connect-apps.js?ver='.$appFileVersion) }}"></script>
    <script src="{{ asset('public/js/auth-manager.js?ver='.$appFileVersion) }}"></script>
@endsection
