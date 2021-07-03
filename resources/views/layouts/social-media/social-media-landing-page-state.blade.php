<?php $dynamicAppName=getDynamicAppName(); ?>

<div id="no_social_media_connected">
    <div class="content-header">
        <div class="social-posts-heading">
            <h3>Connect Your Social Media Pages to {{$dynamicAppName}}</h3>
            <h4>If you have a Facebook, Twitter, Instagram and Linkedin, connect them to your {{$dynamicAppName}} account and you can manage all your social media postings on your {{$dynamicAppName}} account.</h4>
            <h4>Click the 'Connect' buttons below to start connecting your accounts.</h4>
        </div>
        <div class="row">
            <div class="social-post-widgets">

                <div class="col-xs-2 social-widget">
                    @if(!empty($socialMediaPostsData['Facebook']) && $socialMediaPostsData['Facebook']['status'] == 'connected')
                        <div class="connected-label">Connected</div>

                        <img src="{{asset('public/images/icons/facebook-widget.png')}}">

                        @if(!empty($socialMediaPostsData['Facebook']['name']))
                        <h4>{{ '@'.$socialMediaPostsData['Facebook']['name'] }}</h4>
                        @else
                            <h4>Facebook</h4>
                        @endif
                        <?php
                        $connectedAT = $socialMediaPostsData['Facebook']['created_at'];
                        $dt = new \DateTime($connectedAT);
                        $connectedAT = $dt->format('d-M-Y');
                        ?>
                        <label class="connected-date">{{ $connectedAT }}</label>


                        <button type="button" class="btn remove-button unlink-app" data-type="Facebook">
                            Remove
                        </button>
                    @else
                        <img src="{{asset('public/images/icons/facebook-widget.png')}}">
                        <h4>Facebook</h4>
                        <button type="button" class="btn facebook-widget-btn connect-app" data-type="facebook">
                            Connect
                        </button>
                    @endif


                </div>

                {{--@if(preg_match('/NetBlaze/i', getDynamicAppName()))--}}
                    <div class="col-xs-2 social-widget">
                        @if(!empty($socialMediaPostsData['Twitter']) && $socialMediaPostsData['Twitter']['status'] == 'connected')
                            <div class="connected-label">Connected</div>

                            <img src="{{asset('public/images/icons/twitter-widget.png')}}">

                            @if(!empty($socialMediaPostsData['Twitter']['name']))
                                <h4>{{ '@'.$socialMediaPostsData['Twitter']['name'] }}</h4>
                            @else
                                <h4>Twitter</h4>
                            @endif
                            <?php
                            $connectedAT = $socialMediaPostsData['Twitter']['created_at'];
                            $dt = new \DateTime($connectedAT);
                            $connectedAT = $dt->format('d-M-Y');
                            ?>
                            <label class="connected-date">{{ $connectedAT }}</label>


                            <button type="button" class="btn remove-button unlink-app" data-type="Twitter">
                                Remove
                            </button>
                        @else
                            <img src="{{asset('public/images/icons/twitter-widget.png')}}">
                            <h4>Twitter</h4>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn twitter-widget-btn connect-app" data-type="twitter">
                                Connect
                            </button>
                        @endif
                    </div>
                {{--@else--}}
                    {{--<div class="col-xs-2 social-widget">--}}
                        {{--<img src="{{asset('public/images/social-coming-soon.png')}}">--}}
                        {{--<label>Launching Soon!</label>--}}
                        {{--<div class="coming-soon-widget">--}}
                            {{--<img class="comingsoon-icon" src="{{asset('public/images/instagram-comingsoon.png')}}">--}}
                            {{--<i class="fa fa-twitter" aria-hidden="true" style="font-size: 23px;color: #ADADAD;margin-top: 9px;position: absolute;margin-left: -20px;"></i>--}}
                            {{--<h3>Twitter</h3>--}}
                        {{--</div>--}}
                        {{--<!-- Button trigger modal -->--}}
                    {{--</div>--}}
                {{--@endif--}}

                <div class="col-xs-2 social-widget">
                    <img src="{{asset('public/images/social-coming-soon.png')}}">
                    <label>Launching Soon!</label>
                    <div class="coming-soon-widget">
                        <img class="comingsoon-icon" src="{{asset('public/images/instagram-comingsoon.png')}}">
                        <h3>Instagram</h3>
                    </div>
                    <!-- Button trigger modal -->
                </div>

                <div class="col-xs-2 social-widget">
                    <img src="{{asset('public/images/social-coming-soon.png')}}">
                    <label>Launching Soon!</label>

                    <div class="coming-soon-widget">
                        <img class="comingsoon-icon" src="{{asset('public/images/linkedin-comingsoon.png')}}">
                        <h3>LinkedIn</h3>
                    </div>

                </div>


                <div class="col-xs-2"></div>
                <div class="col-xs-2"></div>





            </div>
        </div>
    </div>
</div>
