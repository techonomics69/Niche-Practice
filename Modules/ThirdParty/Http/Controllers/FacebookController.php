<?php

namespace Modules\ThirdParty\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\ThirdParty\Entities\FacebookEntity;
use Modules\ThirdParty\Entities\SocialEntity;
use Laravel\Socialite\Facades\Socialite;
use Redirect;
use Log;
use Config;

class FacebookController extends Controller
{
    protected $socialMediaEntity;

    protected $socialThirdEntity;

    public function __construct()
    {
        $this->socialMediaEntity = new FacebookEntity();
        $this->socialThirdEntity = new SocialEntity();
    }

    public function redirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callback(Request $request)
    {
        Log::info("callbacl" . json_encode($request->all()));
        $requestCheck = $request->all();
        $referType = '';
        $id = '';
        $url = '';
        /**
        Code Change after discussion with Facebook Dev - Keep generic callback and receive business id through session
         */

        \Log::info("refe " . $request->session()->get('referType'));
        $webAppDomain = getDomain();
        if($request->session()->get('referType') == 'scan')
        {
            \Log::info("if " . $request->session()->get('email'));
            $id = $request->session()->pull('email', 0);
            $referType = $request->session()->pull('referType', null);
        }
        elseif($request->session()->get('referType') == 'home' || $request->session()->get('referType') == 'social_post_settings' || $request->session()->get('referType') == 'weekly_report' || $request->session()->get('referType') == 'posts' || $request->session()->get('referType') == 'posts_demo' || $request->session()->get('referType') == 'get_started')
        {
            \Log::info("Else if type  " . $request->session()->get('referType') . " > " . $request->session()->get('business_id'));
            $id = $request->session()->pull('business_id', 0);
            $referType = $request->session()->pull('referType', null);
        }
        elseif($request->session()->get('referType') == 'promotions')
        {
            \Log::info("Else promot type  " . $request->session()->get('referType') . " > " . $request->session()->get('business_id'));

            $id = $request->session()->pull('business_id', 0);
            $promotionId = $request->session()->pull('promotion', 0);
            $referType = $request->session()->pull('referType', null);
        }
        else
        {
            \Log::info("value of refer " . $request->session()->get('referType'));
            \Log::info("Else " . $request->session()->get('business_id'));

            $id = $request->session()->pull('business_id', 0);
        }

        if(!empty($promotionId))
        {
            $response = $this->socialMediaEntity->getToken($id, $referType, $promotionId);
        }
        else
        {
            $response = $this->socialMediaEntity->getToken($id, $referType);
        }

        if (isset($response['_metadata']['outcomeCode']) && $response['_metadata']['outcomeCode'] == 200) {
            $url = $response['records']['url'];

            return Redirect::to($url);
        } else {
            Log::info('in exception section');
            $webAppDomain = getDomain();
            //$request->session()->forget('products');
            $url = $webAppDomain .'/'.$request->session()->get('referType');

            return Redirect::to($url);
        }

    }


    public function getLogin(Request $request)
    {
        return $this->socialMediaEntity->getLogin($request);
    }

    /**
     * @api {get} /social-media/page-detail [ RF-08-01 ] get all facebook pages
     * @apiVersion 1.0.0
     * @apiName get all  facebook page detail
     * @apiParam {String} access_token
     * @apiGroup SocialMedia
     * @apiPermission Secured
     * @apiDescription handle all facebook pages detail on update/add/manualconnect
     */


    public function getUserPageDetail(Request $request)
    {
        return $this->socialMediaEntity->getPageList($request);
    }

    /**
     * @api {get} /social-media/page-info [ RF-08-02 ] Get Single page detail
     * @apiVersion 1.0.0
     * @apiName Get Single facebook page detail
     * @apiParam {String} access_token
     * @apiGroup SocialMedia
     * @apiPermission Secured
     * @apiDescription Get single facebook page detail reviews/rating against access_token
     */

    public function getPageDetail(Request $request)
    {
        return $this->socialMediaEntity->getPageDetail($request);
    }

    public function getUserAccessToken()
    {
        return $this->socialMediaEntity->getUserAccessToken();
    }

    /**
     * @api {get} /social-media/page-info [ RF-08-03 ] Handle facebook pages  detail
     * @apiVersion 1.0.0
     * @apiName handle facebook pages detail
     * @apiParam {String} token
     * @apiParam {String} access_token
     * @apiParam {String} business_id
     * @apiParam {String} type
     * @apiParam {String} page_id
     * @apiGroup SocialMedia
     * @apiPermission Secured
     * @apiDescription handle all facebook pages detail on update/add/manualconnect
     */

    public function manageSocialBusinessPages(Request $request)
    {
        $type = $request->get('type');
        return $this->socialThirdEntity->manageSocialBusinessPages($request, $type);
    }

    /**
     * @api {get} /social-media/get-last-facebook-post [ RF-08-04 ] Cron Job Get Last facebook page post
     * @apiVersion 1.0.0
     * @apiName Check Last 3 days facebook post
     * @apiGroup SocialMedia
     * @apiPermission Secured
     * @apiDescription Cron Job get last facebook page post whcih is less than 3 days AND update in social media master
     */

    public function getLastFacebookPost(Request $request)
    {
        return $this->socialThirdEntity->getLastFacebookPost($request);
    }

    /**
     * @api {get} /social-media/cronjob-review-rating-likes [ RF-08-05 ] Cronjob Update Review Rating likes count for Social_Media_Master
     * @apiVersion 1.0.0
     * @apiName Cron Job Update Facebook Page Counts
     * @apiGroup SocialMedia
     * @apiPermission Secured
     * @apiDescription get all updated facebook pages reviews /rating and likes count and stored in social_media_master table
     */

    public function updateReviewRatingLikeCronJob(Request $request)
    {
        return $this->socialThirdEntity->updateReviewRatingLikeCronJob($request);
    }

    /**
     * @api {get} /social-media/update-notifications-status/{id} [ RF-08-06 ] Update Notification Status
     * @apiVersion 1.0.0
     * @apiName Update Notification Status
     * @apiGroup SocialMedia
     * @apiParam {String} token
     * @apiPermission Secured
     * @apiDescription Update Notification Status in Chat History Table
     */

    public function updateNotificationStatus($id, Request $request)
    {

        return $this->socialThirdEntity->updateNotificationStatus($id,$request);
    }

    /**
     * @api {get} /social-media/cronjob-get-reviews-likes [ RF-08-07 ] get latest all reviews and likes cron job
     * @apiVersion 1.0.0
     * @apiName Cron Job Get Facebook Reviews and Likes
     * @apiGroup SocialMedia
     * @apiPermission Secured
     * @apiDescription get all latest reviews and likes and update count data
     */

    public function getPageReviewsInsightCronJob(Request $request)
    {
        return $this->socialThirdEntity->getPageReviewsInsightCronJob($request);
    }

    /**
     * @api {get} /social-media/cronjob-get-reviews-likes [ RF-08-08 ] Update Social Media Issues Task
     * @apiVersion 1.0.0
     * @apiName Update Social Media Issues Task
     * @apiGroup SocialMedia
     * @apiPermission Secured
     * @apiDescription Update Social Media Issues Task
     */

    public function updateSocialMediaIssuesTask(Request $request)
    {
        return $this->socialThirdEntity->updateSocialMediaIssuesTask($request);
    }


    public function getPageInsights(Request $request)
    {
        return $this->socialMediaEntity->getPageInsights($request);
    }


    public function postSocialMediaDemo(Request $request)
    {
        return $this->socialMediaEntity->postSocialMediaDemo($request);
    }


    public function getSocialMediaPosts(Request $request)
    {
        return $this->socialThirdEntity->getSocialMediaPosts($request);

    }

    public function getSocialMediaPost(Request $request)
    {
        return $this->socialThirdEntity->getSocialMediaPost($request);

    }


    public function deletePost(Request $request)
    {
        return $this->socialThirdEntity->deletePost($request);

    }

    public function addPost(Request $request)
    {
        return $this->socialThirdEntity->addPost($request);
    }

    public function getSocialMediaPostFeed(Request $request)
    {
        return $this->socialMediaEntity->getSocialMediaPostFeed($request);
    }

    public function updateSocialMediaPost(Request $request)
    {
        return $this->socialMediaEntity->updateSocialMediaPost($request);
    }
    public function getSinglePost(Request $request)
    {
        return $this->socialMediaEntity->getSinglePost($request);
    }

    public function deleteSinglePost(Request $request)
    {
        return $this->socialMediaEntity->deleteSinglePost($request);
    }

    public function updateSinglePost(Request $request)
    {
        return $this->socialMediaEntity->updateSinglePost($request);
    }


    public function cronJobSchedulePost(Request $request)
    {
        return $this->socialThirdEntity->cronJobSchedulePost($request);
    }

    public function removeThirdParties(Request $request)
    {
        return $this->socialThirdEntity->removeThirdParties($request);
    }

    /**
    Below is the testing function not used anywhere
     */

    // testing function
    public function getimages(Request $request)
    {
        return $this->socialThirdEntity->getimages($request);
    }
    // testing function
    public function testFacebookPostFeed(Request $request)
    {
        return $this->socialMediaEntity->testFacebookPostFeed($request);
    }

    // testing function not used anywhere
    public function getFacebookPageDetailTesting(Request $request)
    {
        return $this->socialMediaEntity->getFacebookPageDetailTesting($request);
    }

    public function getFacebookAccountDetailTesting(Request $request)
    {
        return $this->socialMediaEntity->getFacebookAccountDetailTesting($request);
    }
}
