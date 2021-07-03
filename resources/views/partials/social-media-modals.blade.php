<?php $dynamicAppName='NichePractice'; ?>

<div id="connect_website_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Select a page to add to your account.</h4>
            </div>
            <div class="modal-body">
                <div class="pages-container">
                    <div class="alert alert-danger" style="display: none;"></div>

                    <div class="page_container">
                        <div class="page_image_container">
                            <img src="{{ asset('public/images/img.png') }}">
                        </div>
                        <div class="page_details_container">
                            <p class="page_name" title="KFC">KFC</p>
                            <p class="page_address">1170 Broadway, Broadway and 28th Street, The NoMad Hotel, New York City, NY 10001-7507</p>
                            <p class="page_contact_number">(347) 472-5660</p>
                        </div>
                    </div>

                    <div class="page_container selected_page">
                        <div class="page_image_container">
                            <img src="{{ asset('public/images/h.png') }}">
                        </div>
                        <div class="page_details_container">
                            <p class="page_name" title="Pizza Hut">Pizza Hut</p>
                            <p class="page_address">1170 Broadway, Broadway and 28th Street, The NoMad Hotel, New York City, NY 10001-7507</p>
                            <p class="page_contact_number">(347) 472-5660</p>
                        </div>
                    </div>

                    <div class="page_container">
                        <div class="page_image_container">
                            <img src="{{ asset('public/images/img.png') }}">
                        </div>
                        <div class="page_details_container">
                            <p class="page_name" title="KFC">KFC</p>
                            <p class="page_address">1170 Broadway, Broadway and 28th Street, The NoMad Hotel, New York City, NY 10001-7507</p>
                            <p class="page_contact_number">No Phone Number</p>
                        </div>
                    </div>

                    <div class="page_container">
                        <div class="page_image_container">
                            <img src="{{ asset('public/images/img.png') }}">
                        </div>
                        <div class="page_details_container">
                            <p class="page_name" title="KFC">KFC</p>
                            <p class="page_address">No Address</p>
                            <p class="page_contact_number">(347) 472-5660</p>
                        </div>
                    </div>

                    <div class="page_container">
                        <div class="page_image_container">
                            <img src="{{ asset('public/images/img.png') }}">
                        </div>
                        <div class="page_details_container">
                            <p class="page_name" title="KFC">KFC</p>
                            <p class="page_address">1170 Broadway, Broadway and 28th Street, The NoMad Hotel, New York City, NY 10001-7507</p>
                            <p class="page_contact_number">(347) 472-5660</p>
                        </div>
                    </div>

                    <div class="page_container">
                        <div class="page_image_container">
                            <img src="{{ asset('public/images/img.png') }}">
                        </div>
                        <div class="page_details_container">
                            <p class="page_name" title="KFC">KFC</p>
                            <p class="page_address">1170 Broadway, Broadway and 28th Street, The NoMad Hotel, New York City, NY 10001-7507</p>
                            <p class="page_contact_number">(347) 472-5660</p>
                        </div>
                    </div>


                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info save-website">Continue</button>
            </div>
        </div>
    </div>
</div>

<div id="add_post_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <a type="button" class="close_add_post_modal"><span aria-hidden="true">&times;</span></a>
                <h4 class="modal-title">New Post</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" style="display: none;"></div>

                <div class="select-social-media-buttons-container">

                    @if(isset($socialMediaPostsData) && isset($socialMediaPostsData['Facebook']['status']) && strtolower($socialMediaPostsData['Facebook']['status'])=='connected')
                        <button type="button" data-type="Facebook" class="btn select-social-media-button facebook-social-media-button">
                            <i class="fa fa-facebook-official" aria-hidden="true"></i>
                            <span class="hide_tablet">
                                @if(isset($socialMediaPostsData['Facebook']['name']) &&  !empty($socialMediaPostsData['Facebook']['name']))
                                    <?php echo '@'.$socialMediaPostsData['Facebook']['name']; ?>
                                @else
                                    @{{$dynamicAppName}}
                                @endif
                            </span>
                        </button>
                    @endif

                    @if(isset($socialMediaPostsData) && isset($socialMediaPostsData['Twitter']['status']) && strtolower($socialMediaPostsData['Twitter']['status'])=='connected')
                        <button type="button" data-type="Twitter" class="btn select-social-media-button twitter-social-media-button">
                            <i class="fa fa-twitter" aria-hidden="true"></i>
                            <span class="hide_tablet">
                                @if(isset($socialMediaPostsData['Twitter']['name']) &&  !empty($socialMediaPostsData['Twitter']['name']))
                                    <?php echo '@'.$socialMediaPostsData['Twitter']['name']; ?>
                                @else
                                    @{{$dynamicAppName}}
                                @endif
                            </span>
                        </button>
                    @endif

                    {{--@if(isset($socialMediaPostsData) && isset($socialMediaPostsData['Instagram']['status']) && strtolower($socialMediaPostsData['Instagram']['status'])=='connected')--}}
                    {{--<button type="button" data-type="instagram" class="btn select-social-media-button instagram-social-media-button">--}}
                    {{--<i class="fa fa-instagram" aria-hidden="true"></i>--}}
                    {{--<span class="hide_tablet">--}}
                    {{--@{{$dynamicAppName}}--}}
                    {{--</span>--}}
                    {{--</button>--}}
                    {{--@endif--}}

                    {{--@if(isset($socialMediaPostsData) && isset($socialMediaPostsData['Linkedin']['status']) && strtolower($socialMediaPostsData['Linkedin']['status'])=='connected')--}}
                    {{--<button type="button" data-type="Linkedin" class="btn select-social-media-button linkedin-social-media-button">--}}
                    {{--<i class="fa fa-linkedin-square" aria-hidden="true"></i>--}}
                    {{--<span class="hide_tablet">--}}
                    {{--@{{$dynamicAppName}}--}}
                    {{--</span>--}}
                    {{--</button>--}}
                    {{--@endif--}}

                </div>

                <div class="content_container">

                    <div class="limit_exceeded_error_msg_container">
                        <span class="remove_limit_exceeded_error"><i class="fa fa-times" aria-hidden="true"></i></span>
                        <span class="limit_exceeded_error_msg"></span>
                    </div>

                    {{--<div class="summernote" id="post_content_body"></div>--}}
                    <textarea id="post_content_body" placeholder="Share something with the world."></textarea>

                    <div class="attached_images_container"></div>
                    <div class="attached_videos_container"></div>

                    <div class="link_preview_container hide">
                        <img class="loader hide" src="{{asset('public/images/transparent_loader.gif')}}">
                        <div class="link_preview_image_container">
                            <img class="link_preview_img" src="">
                        </div>
                        <div class="link_preview_details_container">
                            <p class="link_preview_name" title=""></p>
                            <p class="link_preview_address"></p>
                        </div>
                        <span class="remove_link">&times;</span>
                    </div>

                    <div class="attachment_container">
                        <span class="add-image-btn-disabled-tooltip"><button type="button" id="add_image_btn" class="btn"><img src="{{asset('public/images/insert_photo.png')}}"> <span class="hide_tablet">Add Image</span></button></span>
                        <input type="file" id="add_image_file" name="add_image_file" multiple/>

                        <span class="add-video-btn-demo-disabled-tooltip"><button type="button" id="add_video_demo_btn" class="btn"><img src="{{asset('public/images/add_video_post.png')}}"> <span class="hide_tablet">Add Video</span></button></span>
                        <input type="file" id="add_video_file_demo" name="add_video_file_demo" multiple/>
                    </div>

                    <div class="posts_char_count_container">
                        <div class="posts_char_count linkedin_posts_char_count"><i class="fa fa-linkedin-square" aria-hidden="true" style="color: #4875b4;"></i> <span class="linkedin_limit">2600</span></div>
                        <div class="posts_char_count instagram_posts_char_count"><i class="fa fa-instagram" aria-hidden="true" style="color: #e4405f;"></i> <span class="instagram_limit">2678</span></div>
                        <div class="posts_char_count twitter_posts_char_count"><i class="fa fa-twitter" aria-hidden="true" style="color: #00c4fe;"></i> <span class="twitter_limit">120</span></div>
                        <div class="posts_char_count facebook_posts_char_count"><i class="fa fa-facebook-official" aria-hidden="true" style="color: #1d32a0;"></i> <span class="facebook_limit">3500</span></div>
                    </div>

                    {{--<button type="button" id="add_link_btn" class="btn btn-info"><img src="{{asset('public/images/link_icon.png')}}"> <span class="hide_tablet">Add Link</span></button>--}}
                </div>

                <span class="help-block"><small></small></span>

            </div>
            <div class="modal-footer">

                <div class="post_date_container">
                    <span class="post_date_label">Post on</span>
                    <span class="post_date_desc">Today, 5:20 pm (EST)</span>
                </div>

                <span class="posts-btn-disabled-tooltip">
                    <div class="posts_btn_container">
                        <button id="post_now_btn" type="button" rel="post_now" class="btn post_btn">Post Now</button>

                        <div class="dropdown send_post_options">
                            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown"><i class="fa fa-angle-down" aria-hidden="true"></i></button>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">

                                <li role="presentation" rel="post_now" class="post_btn"> <!-- selected_post_option -->
                                    <a role="menuitem" tabindex="-1" href="#">
                                        <div class="icon_container post_now_image">
                                            <i class="fa fa-paper-plane" aria-hidden="true" style="color: #696969;font-size: 18px;"></i>
                                        </div>
                                        <div class="options_container">
                                            <p class="options_name">Post Now</p>
                                            <p class="options_description">Send this post to your social media feed now.</p>
                                        </div>
                                    </a>
                                </li>

                                <li role="presentation" rel="schedule_post" id="add_schedule_post">
                                    <a role="menuitem" tabindex="-1" href="#">
                                        <div class="icon_container schedule_for_later_image">
                                            <i class="fa fa-calendar-check-o" aria-hidden="true" style="color: #696969;font-size: 18px;"></i>
                                        </div>
                                        <div class="options_container">
                                            <p class="options_name">Schedule for Later</p>
                                            <p class="options_description">Send this post to your social media feed sometime later.</p>
                                        </div>
                                    </a>
                                </li>

{{--                                <li role="presentation" rel="post_draft" class="post_btn">--}}
{{--                                    <a role="menuitem" tabindex="-1" href="#">--}}
{{--                                        <div class="icon_container save_as_draft_image">--}}
{{--                                            <i class="fa fa-file" aria-hidden="true" style="color: #696969;font-size: 18px;"></i>--}}
{{--                                        </div>--}}
{{--                                        <div class="options_container">--}}
{{--                                            <p class="options_name">Save as Draft</p>--}}
{{--                                            <p class="options_description">Save as Draft and edit anytime later and send.</p>--}}
{{--                                        </div>--}}
{{--                                    </a>--}}
{{--                                </li>--}}

                            </ul>
                        </div>
                    </div>
                </span>

            </div>
        </div>
    </div>
</div>

<div id="add_link_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-md">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add Link</h4>
            </div>
            <div class="modal-body">
                <div class="">
                    <div class="alert alert-danger" style="display: none;"></div>
                    <div class="form-group">
                        <input id="post_link" type="text" class="form-control" placeholder="Enter link here" value="www.google.com"/>
                        <span class="remove_link">&times;</span>
                    </div>

                    <div class="link_preview_container">
                        <div class="link_preview_image_container">
                            <img src="{{ asset('public/images/link_preview_image.png') }}">
                        </div>
                        <div class="link_preview_details_container">
                            <p class="link_preview_name" title="Food stamps denied as part of">Food stamps denied as part of</p>
                            <p class="link_preview_address">Beatty was named Speaker Pro Temp this week by returning Speaker of the House Nancy Pelosi. Democrats tried to find a way to end th...</p>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info cancel_btn" data-dismiss="modal" aria-label="Close">Cancel</button>
                <button type="button" class="btn btn-info save_link">Save</button>
            </div>
        </div>
    </div>
</div>

<div id="scheduled_post_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-sm">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Date and Time</h4>
            </div>
            <div class="modal-body">
                <div class="">
                    <div class="alert alert-danger" style="display: none;"></div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="scheduled_datepicker"></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="custom_timepicker_container">
                                    <p class="custom_timepicker_container_label">Post On</p>
                                    <p class="custom_timepicker_container_date">January 4, 2019</p>
                                    <div class="custom_timepicker_time_selector">
                                        <div class="show-inline-block">
                                            <select id="custom_timepicker_hour_selector" class="form-control custom_timepicker_hour_selector">
                                                <option selected value="01">01</option>
                                                <option value="02">02</option>
                                                <option value="03">03</option>
                                                <option value="04">04</option>
                                                <option value="05">05</option>
                                                <option value="06">06</option>
                                                <option value="07">07</option>
                                                <option value="08">08</option>
                                                <option value="09">09</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                            </select>
                                        </div>
                                        <div class="show-inline-block">:</div>
                                        <div class="show-inline-block">
                                            <select id="custom_timepicker_minutes_selector" class="form-control custom_timepicker_minutes_selector">
                                                <option selected value="00">00</option>
                                                {{--<option>1</option>--}}
                                                {{--<option>2</option>--}}
                                                {{--<option>3</option>--}}
                                                {{--<option>4</option>--}}
                                                {{--<option>5</option>--}}
                                                {{--<option>6</option>--}}
                                                {{--<option>7</option>--}}
                                                {{--<option>8</option>--}}
                                                {{--<option>9</option>--}}
                                                <option value="10">10</option>
                                                {{--<option>11</option>--}}
                                                {{--<option>12</option>--}}
                                                {{--<option>13</option>--}}
                                                {{--<option>14</option>--}}
                                                {{--<option>15</option>--}}
                                                {{--<option>16</option>--}}
                                                {{--<option>17</option>--}}
                                                {{--<option>18</option>--}}
                                                {{--<option>19</option>--}}
                                                <option value="20">20</option>
                                                {{--<option>21</option>--}}
                                                {{--<option>22</option>--}}
                                                {{--<option>23</option>--}}
                                                {{--<option>24</option>--}}
                                                {{--<option>25</option>--}}
                                                {{--<option>26</option>--}}
                                                {{--<option>27</option>--}}
                                                {{--<option>28</option>--}}
                                                {{--<option>29</option>--}}
                                                <option value="30">30</option>
                                                {{--<option>31</option>--}}
                                                {{--<option>32</option>--}}
                                                {{--<option>33</option>--}}
                                                {{--<option>34</option>--}}
                                                {{--<option>35</option>--}}
                                                {{--<option>36</option>--}}
                                                {{--<option>37</option>--}}
                                                {{--<option>38</option>--}}
                                                {{--<option>39</option>--}}
                                                <option value="40">40</option>
                                                {{--<option>41</option>--}}
                                                {{--<option>42</option>--}}
                                                {{--<option>43</option>--}}
                                                {{--<option>44</option>--}}
                                                {{--<option>45</option>--}}
                                                {{--<option>46</option>--}}
                                                {{--<option>47</option>--}}
                                                {{--<option>48</option>--}}
                                                {{--<option>49</option>--}}
                                                <option value="50">50</option>
                                                {{--<option>51</option>--}}
                                                {{--<option>52</option>--}}
                                                {{--<option>53</option>--}}
                                                {{--<option>54</option>--}}
                                                {{--<option>55</option>--}}
                                                {{--<option>56</option>--}}
                                                {{--<option>57</option>--}}
                                                {{--<option>58</option>--}}
                                                {{--<option>59</option>--}}
                                            </select>
                                        </div>
                                        <div class="show-inline-block">
                                            <button class="custom_timepicker_interval active">AM</button>
                                            <button class="custom_timepicker_interval">PM</button>
                                        </div>
                                    </div>
                                    <p class="custom_timepicker_timezone">Time is in EST</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="save_schedule_post" class="btn save_schedule_post">Done</button>
            </div>
        </div>
    </div>
</div>

<div id="delete_post_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-md">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Delete Post</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" style="display: none;"></div>
                <div class="content_container">
                    <p class="delete_post_desc">Deleting this post on {{$dynamicAppName}} will also delete the post on your Social Media sites. <br> Are you sure you want to continue?</p>
                </div>
            </div>
            <div class="modal-footer">
                <button id="cancel_delete_post_btn" type="button" data-dismiss="modal" aria-label="Close" class="btn">Cancel</button>
                <button id="delete_post_btn" type="button" class="btn">Delete</button>
            </div>
        </div>
    </div>
</div>

<div id="discard_post_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-md">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Discard Post Without Saving?</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" style="display: none;"></div>
                <div class="content_container">
                    <p class="discard_post_desc">Are you sure you want to discard your post without saving?</p>
                </div>
            </div>
            <div class="modal-footer">
                <button id="discard_post_btn" type="button" class="btn">Discard</button>
                <button id="save_draft_post_btn" type="button" class="btn">Save as Draft</button>
            </div>
        </div>
    </div>
</div>

<div id="confirm_update_post_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-md">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Are you sure you want to proceed updating this post? </h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" style="display: none;"></div>
                <div class="content_container">
                    <p class="discard_post_desc">The changes you made here will be forwarded to the social media page.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button id="cancel_update_post_btn" data-dismiss="modal" aria-label="Close" class="close btn">Cancel</button>
                <button id="update_facebook_post" type="button" class="btn">Proceed</button>
            </div>
        </div>
    </div>
</div>


<style>
    .facebook-social-media-button img,
    .facebook-social-media-button.selected-social-media img,
    .twitter-social-media-button img,
    .twitter-social-media-button.selected-social-media img,
    .instagram-social-media-button img,
    .instagram-social-media-button.selected-social-media img,
    .linkedin-social-media-button img,
    .linkedin-social-media-button.selected-social-media img {
        display: inline-block;
        background: url('{{ asset('public/images/add-posts-social-media-icons.png') }}') no-repeat;
        overflow: hidden;
        text-indent: -9999px;
        text-align: left;
    }

    .facebook-social-media-button img {
        background-position: -0px -32px; width: 16px; height: 16px;
    }

    .facebook-social-media-button.selected-social-media img {
        background-position: -0px -16px; width: 16px; height: 16px !important;
    }

    .twitter-social-media-button img {
        background-position: -0px -96px; width: 16px; height: 16px;
    }

    .twitter-social-media-button.selected-social-media img {
        background-position: -0px -112px; width: 16px; height: 16px !important;
    }

    .instagram-social-media-button img {
        background-position: -0px -64px; width: 16px; height: 16px;
    }

    .instagram-social-media-button.selected-social-media img {
        background-position: -0px -48px; width: 16px; height: 16px !important;
    }

    .linkedin-social-media-button img {
        background-position: -0px -80px; width: 16px; height: 16px;
    }

    .linkedin-social-media-button.selected-social-media img {
        background-position: -0px -0px; width: 17px; height: 16px !important;
    }


    /*--------------------------------------------*/


    /*--------------------------------------------*/

    .facebook-social-media-button i.fa,
    .twitter-social-media-button i.fa,
    .instagram-social-media-button i.fa,
    .linkedin-social-media-button i.fa{
        font-size: 18px;
        margin-right: 2px;
        margin-top: -2px;
        vertical-align: middle;
    }

    .facebook-social-media-button i.fa{
        color: #1d32a0;
    }

    .twitter-social-media-button i.fa{
        color: #00c4fe;
    }

    .instagram-social-media-button i.fa{
        color: #e4405f;
    }

    .linkedin-social-media-button i.fa{
        color: #4875b4;
    }

    .facebook-social-media-button.selected-social-media i.fa,
    .twitter-social-media-button.selected-social-media i.fa,
    .instagram-social-media-button.selected-social-media i.fa,
    .linkedin-social-media-button.selected-social-media i.fa{
        color: #ffffff !important;
    }

    /*--------------------------------------------*/



    {{--.post_now_image img {--}}
    {{--content: url("{{ asset('public/images/send_post.png') }}");--}}
    {{--}--}}

    {{--.selected_post_option .post_now_image img {--}}
    {{--content: url("{{ asset('public/images/send_post_white.png') }}") !important;--}}
    {{--}--}}

    {{--.schedule_for_later_image img {--}}
    {{--content: url("{{ asset('public/images/schedule_later_image.png') }}");--}}
    {{--}--}}

    {{--.selected_post_option .schedule_for_later_image img {--}}
    {{--content: url("{{ asset('public/images/schedule_later_image_white.png') }}") !important;--}}
    {{--}--}}

    {{--.save_as_draft_image img {--}}
    {{--content: url("{{ asset('public/images/save_as_draft_image.png') }}");--}}
    {{--padding-left: 5px;--}}
    {{--}--}}

    {{--.selected_post_option .save_as_draft_image img {--}}
    {{--content: url("{{ asset('public/images/save_as_draft_image_white.png') }}") !important;--}}
    {{--}--}}
</style>
