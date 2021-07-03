<?php

namespace Modules\ThirdParty\Entities;

use App\Entities\AbstractEntity;
use App\Traits\UserAccess;
use Modules\ThirdParty\Models\PostAttachment;
use Modules\ThirdParty\Models\PostMaster;
use Modules\ThirdParty\Models\SmediaAttachment;
use Modules\ThirdParty\Models\SmediaPost;
use Modules\ThirdParty\Models\SocialMediaMaster;
use Request;
use DB;
use Config;
use Log;
use Exception;
use Redirect;
use GuzzleHttp;
use TwitterAPIExchange;
use Modules\Business\Entities\BusinessEntity;
use Storage;
use File;
use Illuminate\Support\Facades\Session;
use Modules\ThirdParty\Models\PostMasterSocialMedia;

class TwitterEntity extends AbstractEntity
{
    use UserAccess;


    public function __construct()
    {
    }

    public function Callback($request, $id, $referType = '', $promotion = '')
    {
        try {
            if (!empty($request->token) && !empty($request->tokenSecret)) {
                $urls = [];
                $webAppDomain = getDomain();;
                $record = SocialMediaMaster::where('type', 'Twitter')
                    ->where('business_id', $id)
                    ->where('access_token', '!=', '')
                    ->first();

                Log::info("twitter record of $promotion");
//                Log::info($record);

                if (empty($record)) {
                    SocialMediaMaster::create(
                        [
                            'access_token' => $request->token,
                            'page_access_token' => $request->tokenSecret,
                            'type' => 'Twitter',
                            'business_id' => $id,
                            'name' => $request->name,
                            'page_likes_count' => !empty($request->user['favourites_count']) ? $request->user['favourites_count'] : 0,
                            'followers' => !empty($request->user['followers_count']) ? $request->user['followers_count'] : 0,
                        ]
                    );

                    if(!empty($referType) && $referType == 'get_started')
                    {
                        $url = $webAppDomain . '/practice-profile';
                    }
                    else if(!empty($referType) && $referType == 'promotions')
                    {
                        $url = $webAppDomain . '/create-promotion/'.$promotion;
                    }
                    else if(!empty($referType))
                    {
                        $url = $webAppDomain . '/business-profile';
                    }
                    else
                    {
                        $url = $webAppDomain . '/social-posts';
                    }

                    $url .= '?accessToken=success&type=Twitter';
                    $urls = [
                        'url' => $url,
                    ];
                    return $this->helpReturn("Get Twitter Response Successfully..", $urls);

                } else {
                    if(!empty($referType) && $referType == 'get_started')
                    {
                        $url = $webAppDomain . '/practice-profile';
                    }
                    else if(!empty($referType) && $referType == 'promotions')
                    {
                        $url = $webAppDomain . '/create-promotion/'.$promotion;
                    }
                    else if(!empty($referType))
                    {
                        $url = $webAppDomain . '/social-media';
                    }
                    else
                    {
                        $url = $webAppDomain . '/social-posts';
                    }

                    $url .= '?accessToken=error&code=4&type=Twitter&message=You are already authenticated';
                    $urls = [
                        'url' => $url,
                    ];
                    return $this->helpError(4,"You are already authenticated.", $urls);
                }
            }
        } catch (Exception $exception) {
            Log::info("twitter callback exception -> " . $exception->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function directPublishedPost($request)
    {
        try {
            $businessId = $request['business_id'];
            Log::info("two " . $businessId);
            \Codebird\Codebird::setConsumerKey('ihtbOOA7fG1uRjoJVBRWbhHja', '91kkimB2q7t7zJVBIeDlBt6IfTEPzXDdeNOej1yBKgtsC2rvVe'); // static, see README
            $cb = \Codebird\Codebird::getInstance();
            $socialMedia = SocialMediaMaster::where('business_id', $businessId)
                ->where('type', 'Twitter')->first();
            $cb->setToken($socialMedia->access_token, $socialMedia->page_access_token);

            if ($request->status == 'published' && !isset($request->post_id)) {
                /**
                 * Direct Post To Twitter
                 */
                $media_ids = [];
                $media_id = '';
                if ($request->hasFile('attach_file')) {
                    $attachedFile = $request->attach_file;
                    foreach ($attachedFile as $file) {
                        Log::info('Direct published without post id');
                        $extension = $file->getClientOriginalExtension();
                        if (empty($extension) && $request->has('blob')) {
                            $extension = 'png';
                        }
                        if ($extension == 'jpeg' || $extension == 'jpg' || $extension == 'JPEG' || $extension == 'png' || $extension == 'PNG') {
                            Log::info('in image section');
                            $request->request->add(['media_type' => 'image']);
                            $reply = $cb->media_upload([
                                'media' => $file
                            ]);

//                            lo

                            // and collect their IDs
//                            $media_ids[] = !empty($reply->media_id_string) ? $reply->media_id_string : '';
                            $media_ids[] = $reply->media_id_string;

                        } else if ($extension == 'mp4' || $extension == 'MP4') {
                            Log::info('inside mp4 section');
                            $request->request->add(['media_type' => 'video']);
                            /**Video Upload ******/
                            $size_bytes = filesize($file);
                            $fp = fopen($file, 'r');
                            // INIT the upload
                            $reply = $cb->media_upload([
                                'command' => 'INIT',
                                'media_type' => 'video/mp4',
                                //'media_category' => 'amplify_video',
                                'total_bytes' => $size_bytes
                            ]);
                            $media_id = $reply->media_id_string;
                            Log::info('check media id');
//                            Log::info($media_id);
                            // APPEND data to the upload
                            $segment_id = 0;
                            while (!feof($fp)) {
                                $chunk = fread($fp, 1048576); // 1MB per chunk for this sample
                                $reply = $cb->media_upload([
                                    'command' => 'APPEND',
                                    'media_id' => $media_id,
                                    'segment_index' => $segment_id,
                                    'media' => $chunk
                                ]);
                                $segment_id++;
                            }
                            fclose($fp);
                            Log::info('get chuk size response');
                            // FINALIZE the upload
                            $reply = $cb->media_upload([
                                'command' => 'FINALIZE',
                                'media_id' => $media_id
                            ]);
                            $array = json_decode(json_encode($reply), True);
                            Log::info('check array values');
//                            Log::info($array);
                            if ($reply->httpstatus < 200 || $reply->httpstatus > 299) {

                                die();
                            }
                            /**Video Upload ******/
                        }
                    }
                }
                Log::info("media_ids");
//                Log::info($media_ids);

                $media_ids = (!empty($request->media_type) && $request->media_type == 'image') ? implode(',', $media_ids) : $media_id;
                // send Tweet with these medias
                //empty($media_ids) ? $postfields = array('status' => $request->message) : $postfields = array('status' => $request->message, 'media_ids' => $media_ids);
//               ( !empty($media_ids) && !empty($request->message) ) ? $postfields = array('status' => $request->message, 'media_ids' => $media_ids) : (empty($request->message)) ? $postfields = array('media_ids' => $media_ids) : $postfields = array('status' => $request->message);

                Log::info("insidee " . $request->message);
               if( !empty($media_ids) && !empty($request->message) )
               {
                   $postfields = array('status' => $request->message, 'media_ids' => $media_ids);
               }
               elseif(empty($request->message))
               {
                   $postfields = array('media_ids' => $media_ids);
               }
               else
               {
                   $postfields = array('status' => $request->message);
               }

                $reply = $cb->statuses_update($postfields);
                $array2 = json_decode(json_encode($reply), true);
                Log::info('check array2 values');
//                Log::info($array2);
                $post = PostMaster::create(['business_id' => $businessId, 'post_id' => $reply->id_str, 'social_media_id' => $socialMedia->id, 'social_media_type' => 'Twitter', 'status' => $request->status]);

                return $this->helpReturn("Post Shared Successfully on Twitter.");
            }

        } catch (Exception $exception) {
            Log::info("Twitter directPublishedPost > " . $exception->getMessage() . ' > line > ' . $exception->getLine());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function indirectPublishedPost($request)
    {
    try{
        $businessId = $request['business_id'];
        \Codebird\Codebird::setConsumerKey('ihtbOOA7fG1uRjoJVBRWbhHja', '91kkimB2q7t7zJVBIeDlBt6IfTEPzXDdeNOej1yBKgtsC2rvVe'); // static, see README

//        \Codebird\Codebird::setConsumerKey(config::get('services.TWITTER_CLIENT_ID'), config::get('services.TWITTER_CLIENT_SECRET')); // static, see README

        $cb = \Codebird\Codebird::getInstance();
        $socialMedia = SocialMediaMaster::where('business_id', $businessId)->where('type', 'Twitter')->first();
        $cb->setToken($socialMedia->access_token, $socialMedia->page_access_token);
        $mediaType = '';
        $media_id = '';
        $record = [];

        if ($request->status == 'published' && isset($request->post_id)) {
            Log::info('post with published and post id');
            $postMastersRecord = PostMasterSocialMedia::where('post_master_id', $request->post_id)->get()->toArray();

            $attachment = $request['urls'];
            if (!empty($attachment)) {

                foreach ($attachment as $file) {

                    $mediaType = $file['type'];
                    if(isset($mediaType) && $mediaType == 'image'){
                        $request->request->add(['media_type' => 'image']);

                        $reply = $cb->media_upload([
                            'media' => $file['media_url']
                        ]);
                        // and collect their IDs
                        $media_ids[] = $reply->media_id_string;

                    }else if(isset($mediaType) && $mediaType == 'video'){

                        $size_bytes = filesize($file['media_url']);
                        $fp = fopen($file['media_url'], 'r');

                        // INIT the upload

                        $reply = $cb->media_upload([
                            'command' => 'INIT',
                            'media_type' => 'video/mp4',
                            'total_bytes' => $size_bytes
                        ]);

                        $media_id = $reply->media_id_string;

                        // APPEND data to the upload

                        $segment_id = 0;

                        while (!feof($fp)) {
                            $chunk = fread($fp, 1048576); // 1MB per chunk for this sample

                            $reply = $cb->media_upload([
                                'command' => 'APPEND',
                                'media_id' => $media_id,
                                'segment_index' => $segment_id,
                                'media' => $chunk
                            ]);

                            $segment_id++;
                        }

                        fclose($fp);

                        // FINALIZE the upload

                        $reply = $cb->media_upload([
                            'command' => 'FINALIZE',
                            'media_id' => $media_id
                        ]);

                        if ($reply->httpstatus < 200 || $reply->httpstatus > 299) {

                            die();
                        }
                        /**Video Upload ******/
                    }

                }
            }


            $media_ids = !empty($mediaType) && $mediaType == 'image' ? implode(',', $media_ids) : $media_id;

            !empty($media_ids) && !empty($request->message) ? $postfields = array('status' => $request->message, 'media_ids' => $media_ids) :
                (empty($request->message) ? $postfields = array('media_ids' => $media_ids) :
                    $postfields = array('status' => $request->message));

                $reply = $cb->statuses_update($postfields);
                $record = ['business_id' => $businessId, 'post_id' => $reply->id_str, 'social_media_type' => 'Twitter', 'status' => $request->status];

        }

        return $this->helpReturn("Post Successfully Added.",$record);
//        return $this->helpReturn("Post Successfully Added." );

        }
        catch (Exception $exception)
        {
            Log::info($exception->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }

    }


    public function getPosts($request)
    {
        try {
            $businessObj = new BusinessEntity();
            $checkPoint = $this->setCurrentUser($request->get('token'))->userAllow();
            // user is not found.
            if ($checkPoint['_metadata']['outcomeCode'] != 200) {
                return $checkPoint;
            }
            $user = $checkPoint['records'];
            $businessResult = $businessObj->userSelectedBusiness($user);
            if ($businessResult['_metadata']['outcomeCode'] != 200) {
                return $this->helpError(1, 'Problem in selection of user busienss.');
            }
            $businessId = $businessResult['records']['business_id'];
            $socialMedia = SocialMediaMaster::where('business_id', $businessId)->where('type', $request->third_party)->first();
            if($request->post_type == 'draft'){
                $postMaster = PostMaster::where('social_media_id',$socialMedia->id)->where(function($q){
                    $q->orWhere('');
                })->where('social_media_type',$request->third_party)->get()->toArray();

            }

            return $this->helpReturn("Post Successfully Added.",$postMaster);
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }

    }

    public function getAllPublishedPost($data)
    {
//        log::info('$data');
//        log::info($data);
        try {
            $businessId = $data['businessId'];

            $postresult=[];
            \Codebird\Codebird::setConsumerKey('ihtbOOA7fG1uRjoJVBRWbhHja', '91kkimB2q7t7zJVBIeDlBt6IfTEPzXDdeNOej1yBKgtsC2rvVe'); // static, see README

            $cb = \Codebird\Codebird::getInstance();
            $socialMedia = SocialMediaMaster::where('business_id', $businessId)
                ->where('type', 'Twitter')->first();
//            log::info('$socialMedia');
//            log::info($socialMedia);
            $cb->setToken($socialMedia->access_token, $socialMedia->page_access_token);

            $weekly_array = [];
            $i = 1;
            $postresult = [];
            $currentDate = '';
            $time = '';
            $postMedia = '';
            $params = [
                'tweet_mode' => 'extended'
            ];
            $response = (array) $cb->statuses_userTimeline($params);
          //  return $this->helpReturn("All Published Posts",$response);
//            log::info('tweet entity $response');

            $res = array_column($response, 'id');

//            if(!empty($response)){
//                log::info('exit condition');
//                $res = array_column($response, 'id');
//                log::info($res);
////                exit;
//            }

            if(empty($res)){
                return $this->helpReturn("All Published Posts");
            }

            $appendImageArray = [];
             $appendArticleArray = [];
            $articleResult = '';

            $appendIndicesArray='';
            $count = 0;

//            log::info('response length');
//            log::info(count($response->created_at));
//            log::info(count(array_keys($response, "created_at")));
//            $counts = array_count_values(
//
//            );
//            log::info(count($counts));

            foreach($response as $postDetail) {
                if(empty($postDetail->id))
                {
                    continue;
                }

//                log::info('response inside loop');
//                log::info($response);
//                log::info('$count');
//                log::info($count);
//                $count++;
////                if (!empty($postDetail->created_at)) {
                    !empty($postDetail->created_at) ? $postDate = $postDetail->created_at : $postDate = '';

//                    log::info('tweet entity $postDate');
//                    log::info($postDate);
                    if (!empty($postDate)) {

                        $carbon = new \Carbon\Carbon();
                        $date = $carbon->createFromTimestamp(strtotime($postDate), 'EST');
                        $currentDate = $date->format('Y-m-d');
                        $time = $date->format('Y-m-d h:i:s');
                    }

                    $result['post_id'] = !empty($postDetail->id) ? $postDetail->id : '';
                    $result['post_time'] = !empty($time) ? $time : '';

                    $result['post_url'] = !empty($postDetail->entities->urls[0]->url) ? $postDetail->entities->urls[0]->url : '';
//                    log::info('ressss');
//                    log::info($result['post_id']);
//                    log::info($result['post_time']);
//                    log::info($result['post_url']);
                    $articleUrl = !empty($postDetail->entities->urls[0]) ? $postDetail->entities->urls : '';

                    if (!empty($articleUrl)) {
                        foreach ($articleUrl as $row) {

                            $appendArticleArray[] = !empty($row->expanded_url) ? $row->expanded_url : '';

                        }
                    }

                    foreach ($appendArticleArray as $iterateArticle) {

                        $articleResult = !empty($iterateArticle) ? $iterateArticle : '';

                    }
//                    log::info('$articleResult');
//                    log::info($articleResult);

                    $TextUrl = !empty($postDetail->full_text) ? $postDetail->full_text : '';
//                    log::info('$TextUrl');
//                    log::info($TextUrl);
                    $urlRegex = '~(?i)\b((?:[a-z][\w-]+:(?:/{1,3}|[a-z0-9%])|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:\'".,<>?«»“”‘’]))~';
//                    log::info('$urlRegex');
//                    log::info($urlRegex);
                    $removeUrl = preg_replace($urlRegex, '', $TextUrl); // remove urls
//                    log::info('$removeUrl');
//                    log::info($removeUrl);
                    $articleIndices = !empty($postDetail->entities->urls[0]) ? $postDetail->entities->urls : '';
//                    log::info('$articleIndices');
//                    log::info($articleIndices);
                    if (!empty($articleIndices)) {
                        foreach ($articleIndices as $row) {

                            $appendIndices = !empty($row->indices) ? $row->indices : '';

                            $appendIndicesArray = !empty($appendIndices[0]) ? $appendIndices[0] : '';
                        }
                    }

                    $mergeString = !empty(substr_replace($removeUrl, $articleResult, $appendIndicesArray, $appendIndicesArray)) ? substr_replace($removeUrl, $articleResult, $appendIndicesArray, $appendIndicesArray) : ' ';
//                    log::info('$mergeString');
//                    log::info($mergeString);
                    $removeBlackSlash = json_encode($mergeString, JSON_UNESCAPED_SLASHES);
//                    log::info('$removeBlackSlash');
//                    log::info($removeBlackSlash);
                    $Finaltext = trim($removeBlackSlash, '"');
//                    log::info('$Finaltext');
//                    log::info($Finaltext);
                    $result['post_message'] = $Finaltext;
//                    log::info('$result[\'post_message\']');
//                    log::info($result['post_message']);
                    $postMedia = !empty($postDetail->extended_entities->media[0]) ? $postDetail->extended_entities->media : '';
//                    log::info('$postMedia');
//                    log::info($postMedia);
                    $result['post_image'] = '';
                    if (!empty($postMedia)) {
                        foreach ($postMedia as $row) {
                            if ($row->type == 'photo') {
                                $appendImageArray[] = !empty($row->media_url) ? $row->media_url : '';
                            }
                        }
                    }

                    $result['post_image'] = $appendImageArray;
//                    log::info('$result[\'post_image\']');
//                    log::info($result['post_image']);
                    $appendImageArray = [];
                    $result['post_video'] = !empty($postDetail->extended_entities->media[0]->video_info->variants[0]->url) ? $postDetail->extended_entities->media[0]->video_info->variants[1]->url : '';
//                    log::info('$result[\'post_video\']');
//                    log::info($result['post_video']);
                    if (isset($data['screen']) && $data['screen'] == 'mobile') {
                        $postresult[] = $result;
//                        log::info('into if');
                    } else {
//                        log::info('into else');
                        if (in_array($currentDate, $weekly_array)) {
                            $postresult[$currentDate][] = $result;
//                            log::info('into if 02');
                        } else {
                            $postresult[$currentDate][0] = $result;
//                            log::info('into else 02');
                        }

                        array_push($weekly_array, $currentDate);
                        $result = [];
                    }

                }
//                log::info('$postresult');
//                log::info($postresult);

                return $this->helpReturn("All Published Posts", $postresult);

//            }
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }

    }

//    public function getAllPublishedPost($request)
//    {
//        try {
//
//            $businessObj = new BusinessEntity();
//            $checkPoint = $this->setCurrentUser($request->get('token'))->userAllow();
//            // user is not found.
//            if ($checkPoint['_metadata']['outcomeCode'] != 200) {
//                return $checkPoint;
//            }
//            $user = $checkPoint['records'];
//            $businessResult = $businessObj->userSelectedBusiness($user);
//            if ($businessResult['_metadata']['outcomeCode'] != 200) {
//                return $this->helpError(1, 'Problem in selection of user busienss.');
//            }
//            $businessId = $businessResult['records']['business_id'];
//            \Codebird\Codebird::setConsumerKey('BWdbf08YosIqErEkRVsYd3xWq', 'Is2XD8hF7phiYAbLMtSbjOcs5oM3f9JnhyIM5gmWj9MvW5WgsL'); // static, see README
//            $cb = \Codebird\Codebird::getInstance();
//            $socialMedia = SocialMediaMaster::where('business_id', $businessId)->where('type', 'Twitter')->first();
//            $cb->setToken($socialMedia->access_token, $socialMedia->page_access_token);
//
//
//            $reply = (array) $cb->statuses_homeTimeline();
//            print_r($reply);
//            exit;
//
//            return $this->helpReturn("Get All Published Posts");
//        } catch (Exception $exception) {
//            Log::info($exception->getMessage());
//            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
//        }
//
//    }


    public function manualTwitterAuthenticaion($request)
    {
        log::info('connecting manual tweeter');
        \Codebird\Codebird::setConsumerKey('BWdbf08YosIqErEkRVsYd3xWq', 'Is2XD8hF7phiYAbLMtSbjOcs5oM3f9JnhyIM5gmWj9MvW5WgsL'); // static, see README
        $cb = \Codebird\Codebird::getInstance();
        $reply = $cb->oauth_requestToken([
            'oauth_callback' => 'https://dev-api.pinpointlocal.com/twitter/manualCallback'
        ]);

        $cb->setToken($reply->oauth_token, $reply->oauth_token_secret);
        $params = [
            'tweet_mode' => 'extended'
        ];
        $response = (array) $cb->statuses_userTimeline($params);
        $auth_url = $cb->oauth_authorize();
        return $auth_url;



        //        try {
//            $businessObj = new BusinessEntity();
//            $checkPoint = $this->setCurrentUser($request->get('token'))->userAllow();
//            // user is not found.
//            if ($checkPoint['_metadata']['outcomeCode'] != 200) {
//                return $checkPoint;
//            }
//            $user = $checkPoint['records'];
//            $businessResult = $businessObj->userSelectedBusiness($user);
//            if ($businessResult['_metadata']['outcomeCode'] != 200) {
//                return $this->helpError(1, 'Problem in selection of user busienss.');
//            }
//            $businessId = $businessResult['records']['business_id'];


//            return $this->helpReturn("Post Successfully Added.",$postMaster);
//        } catch (Exception $exception) {
//            Log::info($exception->getMessage());
//            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
//        }

    }

    public function manualCallback($request)
    {

        \Codebird\Codebird::setConsumerKey('BWdbf08YosIqErEkRVsYd3xWq', 'Is2XD8hF7phiYAbLMtSbjOcs5oM3f9JnhyIM5gmWj9MvW5WgsL'); // static, see README
        $cb = \Codebird\Codebird::getInstance();
        $reply = $cb->oauth_accessToken([
            'oauth_verifier' => $_GET['oauth_verifier']
        ]);

        $cb->setToken($reply->oauth_token, $reply->oauth_token_secret);
        $params = [
            'tweet_mode' => 'extended'
        ];
        $response = (array) $cb->statuses_userTimeline($params);
        return $response;
    }

}
