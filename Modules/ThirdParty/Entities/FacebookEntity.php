<?php
namespace Modules\ThirdParty\Entities;

use App\Entities\AbstractEntity;
use App\Traits\GlobalResponseTrait;
use Config;
use Facebook\Exceptions\FacebookAuthorizationException;
use FuzzyWuzzy\Fuzz;
use GuzzleHttp\Client;
use Modules\Business\Entities\BusinessEntity;
use Modules\ThirdParty\Models\SocialMediaMaster;
use Facebook\Exceptions\FacebookClientException;
use Facebook\Exceptions\FacebookOtherException as FacebookOtherException;
use Facebook\Exceptions\FacebookResponseException as FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException as FacebookSDKException;
use Facebook\Exceptions\FacebookServerException;
use Facebook\Exceptions\FacebookThrottleException;
use Facebook\Facebook;
use Illuminate\Support\Facades\Session;
use App\Traits\UserAccess;
use Carbon\Carbon;
use Log;
use Modules\ThirdParty\Entities\ThirdPartyEntity;
use Modules\ThirdParty\Entities\TripAdvisorEntity;
use Request;
use DB;
use Exception;
use Storage;
use File;
use Modules\ThirdParty\Models\PostMaster;
use Illuminate\Http\Response;
class FacebookEntity extends AbstractEntity
{
    use UserAccess;
    //use GlobalResponseTrait;

    const AUTHENTICATION_EXCEPTION = 2000;
    const AUTHORIZATION_EXCEPTION = 2001;
    const CLIENT_EXCEPTION = 2002;
    const OTHER_EXCEPTION = 2003;
    const SERVER_EXCEPTION = 2004;
    const THROTTLE_EXCEPTION = 2005;
    const SDK_EXCEPTION = 2006;
    const FACEBOOK_THROTTLING_LIMIT_EXCEPTION = 2007;
    const FACEBOOK_TOKEN_EXPIRES_EXCEPTION = 2008;
    /**
     * @var Facebook
     */
    private $fb;
    /**
     * @var array
     */
    private $permissions;
    private $accessToken;
    protected $hidden = ['access_token'];
    protected $businessEntity;

    public function __construct()
    {
//        $this->permissions = ['email', 'read_insights', 'manage_pages', 'pages_show_list', 'ads_management','publish_pages','user_videos'];

        /**
         * user_videos not found
         * ads_management is rejected by fb.
         * read_insights is revoked
         * manage_pages -> pages_show_list
         * publish_pages -> pages_manage_posts &  pages_manage_engagement (comments,like)
         */


//        $this->permissions = ['email', 'manage_pages', 'pages_show_list', 'pages_manage_posts', 'pages_manage_engagement'];
        $this->permissions = ['email', 'pages_manage_ads', 'pages_manage_engagement', 'pages_manage_posts', 'pages_show_list', 'pages_read_engagement', 'pages_read_user_content'];
//        $this->permissions = ['email'];
        $this->fb = new Facebook(
            [
                'app_id' => Config::get('apikeys.FACEBOOK_APP_ID'),
                'app_secret' => Config::get('apikeys.FACEBOOK_APP_SECRET'),
                'default_graph_version' => 'v9.0',
                'persistent_data_handler' => new CustomPersistentDataHandler(),
            ]

        );

    }

    /**
     * @param $accessToken
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    private function getAccessToken()
    {
        return $this->accessToken;
    }

    /*
     * getlogin -> callback
     */
    public function getLogin($request)
    {
        try {
            $apiUrl =  url('/') . '/api/social-media/callback';

            $helper = $this->fb->getRedirectLoginHelper();

//            \Log::info("POST " . $request->get('referType'));

            // Code Change after discussion with Facebook Dev - Get business id through session

            /**
             * This flag is made for to allow guest user or to make this login happen at
             * multiple screen. so this refer type will indicate in next where user will be go.
             */
            if(!empty($request->get('referType')) && ( $request->get('referType') == 'social_post_settings' || $request->get('referType') == 'weekly_report' || $request->get('referType') == 'posts' || $request->get('referType') == 'posts_demo' || $request->get('referType') == 'home' || $request->get('referType') == 'get_started'))
            {
                $business_id = $request->get('business_id');
                $request->session()->put('business_id', $business_id);
                $request->session()->put('referType', $request->get('referType'));
            }
            else if($request->get('referType') == 'promotions')
            {
                $business_id = $request->get('business_id');
                $promotion = $request->get('promotion');

                $request->session()->put('promotion', $promotion);
                $request->session()->put('business_id', $business_id);
                $request->session()->put('referType', $request->get('referType'));
            }
            else
            {
                $business_id = $request->get('business_id');
                $request->session()->put('business_id', $business_id);
            }


            $request->session()->save();

            return redirect($helper->getLoginUrl(
                $apiUrl,
                $this->permissions
            ));
        }
        catch (FacebookResponseException $e) {
            Log::info(" FacebookResponseException > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again. Record not found.');
        }

        catch (FacebookOtherException $e) {
            Log::info(" FacebookOtherException > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again. Record not found.');
        }
        catch (FacebookSDKException $e) {
            Log::info(" FacebookSDKException > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again. Record not found.');
        }
        catch (Exception $e) {
            Log::info(" getLogin " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }


    public function getUserAccessToken()
    {
        $helper = $this->fb->getRedirectLoginHelper();
        $accessToken = $helper->getAccessToken();

    }

    /**
     * @param $id (business_id)
     * @return string
     */
    public function getToken($id, $referType = '', $promotionId = '')
    {
        Log::info("get Token ");
        try{

            $url = '';
            $accessToken = '';
            $webAppDomain = getDomain();
//             $webAppDomain = 'http://localhost:81/projects/nichepractice';
            if($referType == 'posts')
            {
                $url = $webAppDomain . '/social-posts';
            }
            elseif($referType == 'posts_demo')
            {
                $url = $webAppDomain . '/posts-demo';
            }
            elseif($referType == 'social_post_settings')
            {
                $url = $webAppDomain . '/business-profile';
            }
            elseif($referType == 'get_started')
            {
                $url = $webAppDomain . '/practice-profile';
            }
            elseif($referType == 'promotions')
            {
                $url = $webAppDomain . '/create-promotion/'.$promotionId;
            }
            else
            {
                $url = $webAppDomain . '/review-sites';
            }

             $redirect_url = url('/') . '/api/social-media/callback';

            $helper = $this->fb->getRedirectLoginHelper();
            if (Request::has('code')) {
                /**
                Code Change after discussion with Facebook Dev - Get facebook state through session
                 */
                $_SESSION['FBRLH_state'] = $_GET['state'];
                $accessToken = $helper->getAccessToken($redirect_url);
                $url .= '?accessToken=' . $accessToken . '&type=facebook';
            }

            $urlArray =
                [
                    'url' => $url,
                ];
            return $this->helpReturn('Get Url Successfully', $urlArray);
        }
//        catch (FacebookResponseException $e) {
//            Log::info(" FacebookResponseException > " . $e->getMessage());
//            return $this->helpError(1, 'An unknown error has occurred. Please try again. Record not found.');
//        }
//
//        catch (FacebookOtherException $e) {
//            Log::info(" FacebookOtherException > " . $e->getMessage());
//            return $this->helpError(1, 'An unknown error has occurred. Please try again. Record not found.');
//        }
//        catch (FacebookSDKException $e) {
//            Log::info(" FacebookSDKException > " . $e->getMessage());
//            return $this->helpError(1, 'An unknown error has occurred. Please try again. Record not found.');
//        }
        catch (Exception $e) {
            Log::info(" getToken > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    /**
     * Get User Pages.
     * @param $request (access_token)
     * @return mixed
     */
    public function getPageList($request)
    {
        try {
            $access_token = $request->get('access_token');

            if ($access_token != '') {

                $pageList = $this->fb->get('/me/accounts', $access_token);

                $results = $pageList->getDecodedBody();

                $results = array_filter($results);

//                print_r($results);
//                exit;

                if($results)
                {
                    foreach ($results['data'] as $index => $page)
                    {
                        $page_id = $page['id'];

                        $pagePhoto = $this->fb->get('/' . $page_id . '?fields=picture', $access_token);

                        $pageAddress = $this->fb->get('/' . $page_id . '?fields=location', $access_token);


                        $pagePhone = $this->fb->get('/' . $page_id . '?fields=phone', $access_token);

                        $pageLikes = $this->fb->get('/' . $page_id . '?fields=fan_count', $access_token);

                        $pageReviews = $this->fb->get('/' . $page_id . '?fields=overall_star_rating', $access_token);
                        $pageRating = $this->fb->get('/' . $page_id . '?fields=rating_count', $access_token);

                        $pagePhoto = $pagePhoto->getDecodedBody();
                        $pageAddress =  $pageAddress->getDecodedBody();
                        $pagePhone =  $pagePhone->getDecodedBody();
                        $pageRating = $pageRating->getDecodedBody();
                        $pageLikes = $pageLikes->getDecodedBody();
                        $pageReviews = $pageReviews->getDecodedBody();


                        $results['data'][$index]['average_rating'] = !empty($pageRating['rating_count']) ? $pageRating['rating_count'] : '';
                        $results['data'][$index]['page_likes_count'] = !empty($pageLikes['fan_count']) ? $pageLikes['fan_count'] : '';
                        $results['data'][$index]['page_reviews_count'] = !empty($pageReviews['overall_star_rating']) ? $pageReviews['overall_star_rating'] : '';

                        $results['data'][$index]['address'] = !empty($pageAddress['location']['street']) ? $pageAddress['location']['street'] : '';
                        $results['data'][$index]['city'] = !empty($pageAddress['location']['city']) ? $pageAddress['location']['city'] : '';
                        $results['data'][$index]['zipcode'] = !empty($pageAddress['location']['zip']) ? $pageAddress['location']['zip'] : '';
                        $results['data'][$index]['country'] = !empty($pageAddress['location']['country']) ? $pageAddress['location']['country'] : '';

                        $results['data'][$index]['phone'] = !empty($pagePhone['phone']) ? $pagePhone['phone'] : '';
                        $results['data'][$index]['logo'] = !empty($pagePhoto['picture']) ? $pagePhoto['picture']['data']['url'] : '';

                    }

                    return $this->helpReturn('Page Result', $results);
                }
                else
                {
                    $socialEntityObj = new SocialEntity();
                    $socialEntityObj->manageSocialBusinessPages($request, 'facebook');

                    return $this->helpError(404, 'No Page Found.');
                }
            }
            else {
                return $this->helpError(2, 'Access token is missing');
            }
        }

        catch (FacebookResponseException $e) {
            Log::info(" FacebookResponseException > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again. Record not found.');
        }
        catch (FacebookOtherException $e) {
            Log::info(" FacebookOtherException > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again. Record not found.');
        }
        catch (FacebookSDKException $e) {
            Log::info(" FacebookSDKException > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again. Record not found.');
        }
        catch (Exception $e) {
            Log::info(" getPageList > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again. Record not found.');
        }
    }

    /**
     * @param $request (access_token, pageId)
     * @return mixed
     */
    public function getPageDetail($request)
    {
        try {
            $accessToken = $request->get('access_token');

            $currentDate = Carbon::tomorrow();
            $tilldate = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate)->format('Y-m-d');

            $currentDate = Carbon::now()->subMonth(3);
            $since_date = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate)->format('Y-m-d');

            $currentDatee = Carbon::now()->subMonth(1);
            $since_insight_date= Carbon::createFromFormat('Y-m-d H:i:s', $currentDatee)->format('Y-m-d');
            if ($accessToken == '') {
                return $this->helpError(2, 'Access token is missing');
            }

            $pageList = $this->fb->get('/me/accounts', $accessToken);

            $results = $pageList->getDecodedBody();

            $results = array_filter($results);


            if (!empty($request->get('page_id'))) {
                $pageId = $request->get('page_id');

                if ($results) {

                    $pageBasicDetail = $this->fb->get('/' . $pageId . '?fields=name,phone,location, link,overall_star_rating,fan_count,picture, cover, website', $accessToken);
                    $pageAccessToken = $this->fb->get('/' . $pageId . '?fields=access_token', $accessToken);
                    $pageAccessToken = $pageAccessToken->getDecodedBody();
                    $pageAccessShortLifeToken = $pageAccessToken['access_token'];

                    $params = [
                        'grant_type' => 'fb_exchange_token',
                        'client_id' => Config::get('apikeys.FACEBOOK_APP_ID'),
                        'client_secret' => Config::get('apikeys.FACEBOOK_APP_SECRET'),
                        'fb_exchange_token' => $pageAccessShortLifeToken,

                    ];
                    $longTimeAccessToken = $this->fb->post('/oauth/access_token', $params, $accessToken);
                    $longTimeAccessToken = $longTimeAccessToken->getDecodedBody();

                    $pageRecomendationDetail = $this->fb->get('/' . $pageId . '/ratings', $longTimeAccessToken['access_token']);

                    $pageLikeDetail = $this->fb->get('/' . $pageId . '/insights?pretty=0&since=' . $since_date . '&until=' . $tilldate . '&metric=page_fan_adds&limit=9999', $longTimeAccessToken['access_token']);

                    $pagePostDetail = $this->fb->get('/' . $pageId . '/posts', $longTimeAccessToken['access_token']);

                    $pageViewsDetail = $this->fb->get('/' . $pageId . '/insights?pretty=0&since=' . $since_insight_date . '&until=' . $tilldate . '&metric=page_views_total&limit=9999&period=days_28', $longTimeAccessToken['access_token']);
                    $pageTotalReachDetail = $this->fb->get('/' . $pageId . '/insights?pretty=0&since=' . $since_insight_date . '&until=' . $tilldate . '&metric=page_impressions_unique&limit=9999&period=days_28', $longTimeAccessToken['access_token']);
                    $pagePeopleEngagedDetail = $this->fb->get('/' . $pageId . '/insights?pretty=0&since=' . $since_insight_date . '&until=' . $tilldate . '&metric=page_engaged_users&limit=9999&period=days_28', $longTimeAccessToken['access_token']);

                    $pageRecomendationDetail = $pageRecomendationDetail->getDecodedBody();
                    $recommendationCount= count($pageRecomendationDetail['data']);

                    $pageBasicDetail = $pageBasicDetail->getDecodedBody();
                    $pageLikeDetail = $pageLikeDetail->getDecodedBody();
                    $pagePostDetail = $pagePostDetail->getDecodedBody();

                    $pageViewsDetail = $pageViewsDetail->getDecodedBody();
                    $pageTotalReachDetail = $pageTotalReachDetail->getDecodedBody();
                    $pagePeopleEngagedDetail = $pagePeopleEngagedDetail->getDecodedBody();

                    $appendLikeArray['likes_data'] = $pageLikeDetail;
                    $appendPostArray['post_data'] = $pagePostDetail;

                    $appendPageRecommendationArray['page_recommendation_data'] = $pageRecomendationDetail;
                    $appendPageRecommendationCount['recommendation_count'] = $recommendationCount;
                    $appendPageViewsArray['page_views_data'] = $pageViewsDetail;
                    $appendTotalReachArray['total_reach_data'] = $pageTotalReachDetail;
                    $appendPeopleEngagedArray['people_engaged_data'] = $pagePeopleEngagedDetail;

                    $appendlongLifeAccessToken['long_life_access_token'] = $longTimeAccessToken;

                    $finalDetails = array_merge($pageBasicDetail, $appendPageRecommendationCount, $appendPageRecommendationArray, $appendLikeArray,$appendPostArray,$appendPageViewsArray,$appendTotalReachArray,$appendPeopleEngagedArray, $appendlongLifeAccessToken);

                    return $this->helpReturn('Page Result', $finalDetails);

                } else {

                    return $this->helpError(404, 'No Page Found.');
                }
            } else {
                return $this->helpError(2, 'page id is Missing');
            }
        }

        catch (Exception $e) {
            Log::info($e->getMessage());
            return $this->helpError(1, 'Some Problem found. Please Try again.');
        }

    }

    /**
     * Save data of facebook in our system.
     * @param Request $request (business_id,businessKeyword, userId)
     * @return mixed
     */
    public function storeThirdPartyMaster($request)
    {
        Log::info("Business Facebook Register Process started" . json_encode($request->all()));

        try {
            $tripEntity = new TripAdvisorEntity();
            $thirdPartyEntity = new ThirdPartyEntity();

            // get business detail from trip advisor.
            $result = $this->getBusinessDetail($request);
            $responseCode = $result['_metadata']['outcomeCode'];

            //  $data = [];
            $data['type'] = 'Facebook';

            if ($responseCode == 200) {
                $records = $result['records']['Results'];

                $fuzz = new Fuzz();

                if ($records) {

                    $score = $fuzz->tokenSortRatio($request->get('name'), $records['Name']);

                    Log::info("FB Scrapper -> Score of -> $score > Business Name > " . $request->get('name') . " > FB Scrapper Name " . $records['Name']);

                    if ($score >= 40) {
                        Log::info("Ok for FB sc");

                        $businessId = $request->get('business_id');

                        $data['business_id'] = $businessId;
                        $data['name'] = $records['Name'];
                        $data['page_id'] = (!empty($records['Other']['id'])) ? $records['Other']['id'] : "";
                        $data['page_url'] = $records['URL'];
                        $data['page_reviews_count'] = $records['Review'];
                        $data['average_rating'] = $records['Rating'];
                        $data['page_likes_count'] = (!empty($records['Other']['Likes'])) ? $records['Other']['Likes'] : 0;
                        $data['website'] = $records['Website'];
                        $data['phone'] = $records['ContactNo'];
                        $data['street'] = $records['AddressDetail']['Street'];
                        $data['city'] = $records['AddressDetail']['City'];
                        $data['zipcode'] = $records['AddressDetail']['Zip'];
                        $data['state'] = $records['AddressDetail']['State'];
                        $data['country'] = $records ['AddressDetail']['Country'];

                        $data['is_manual_connected'] = 0;


                        // if is_silhouette == 1 then it has not any profile picture
                        if (!empty($records['Other']['picture']['data']['is_silhouette']) && $records['Other']['picture']['data']['is_silhouette'] == 1) {
                            $data['profile_photo'] = '';
                            $profilePicture = 0;
                        } else {
                            $data['profile_photo'] = !empty($records['Other']['picture']) ? $records['Other']['picture']['data']['url'] : '';
                            $profilePicture = 1;
                        }

                        $data['cover_photo'] = (!empty($records['Other']['cover'])) ? $records['Other']['cover']['source'] : '';
                        $data['add_review_url'] = $records['URL'] . '/reviews/?ref=page_internal';

                        /**
                         * Remove http in website before saving into database
                         */
                        $str = $data['website'];
                        $str = preg_replace('#^http?://#', '', rtrim($str, '/'));

                        $data['website'] = $str;

                        $thirdPartyResult = SocialMediaMaster::create($data);

                        $thirdPartyId = (!empty($thirdPartyResult['id'])) ? $thirdPartyResult['id'] : NULL;

                        $issueData = [
                            [
                                'key' => 'phone',
                                'value' => $thirdPartyResult['phone'],
                                'issue' => ($thirdPartyResult['phone'] != '') ? 18 : 49,
                                'oldIssue' => ($thirdPartyResult['phone'] == '') ? 18 : 49
                            ],
                            [
                                'key' => 'address',
                                'value' => $thirdPartyResult['street'],
                                'issue' => ($thirdPartyResult['street'] != '') ? 19 : 51,
                                'oldIssue' => ($thirdPartyResult['street'] == '') ? 19 : 51
                            ],
                            [
                                'key' => 'website',
                                'value' => $thirdPartyResult['website'],
                                'issue' => ($thirdPartyResult['website'] != '') ? 20 : 50,
                                'oldIssue' => ($thirdPartyResult['website'] == '') ? 20 : 50
                            ],
                            [
                                'key' => 'profile_photo',
                                'value' => $profilePicture,
                                'issue' => 22,
                            ],
                            [
                                'key' => 'cover_photo',
                                'value' => $thirdPartyResult['cover_photo'],
                                'issue' => 23,
                            ],
                            [
                                'key' => 'reviews',
                                'value' => $thirdPartyResult['page_reviews_count'],
                                'issue' => 64,
                                'oldIssue' => ""
                            ],
                            [
                                'key' => 'rating',
                                'value' => $thirdPartyResult['average_rating'],
                                'issue' => 60,
                                'oldIssue' => ""
                            ]
                        ];

                        $thirdPartyEntity->globalIssueGenerator($request->get('userID'), $businessId, $thirdPartyId, $issueData, $data['type'], 'social');

                        // here is the new check come for new issues
                        return $this->helpReturn("Facebook record save.");
                    }
                    else
                    {
                        Log::info("FB Name accuracy issue");
                        $responseCode = 404;
                    }
                }
            }

            if($responseCode == 404 || $responseCode == 1) {
                $businessId = $request->get('business_id');
                $data['business_id'] = $businessId;
                $insertIssue = [
                    [
                        'key' => 'name',
                        'userID' => $request->get('userID'),
                        'business_id' => $businessId,
                        'issue' => 17,
                        'type' => $data['type']
                    ]
                ];

                $tripEntity->compareThirdPartyRecord($insertIssue, 'social');
            }

            return $this->helpError(404, 'Record not found.');
        }
        catch (Exception $e)
        {
            Log::info("FacebookEntity > storeThirdPartyMaster >> " . $e->getMessage());

            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }


    public function updateThirdPartyMaster($request)
    {
        Log::info("Business Update -> facebook Process started " . json_encode($request->all()));
        $thirdPartyObj = new TripAdvisorEntity();
        $thirdPartyEntity = new ThirdPartyEntity();

        try {
            /**
             * Get business detail from facebook by search query.
             *
             * Only go in this block If user updating business from business form
             */
            $userId = $request->get('userID');
            $thirdPartyResult = SocialMediaMaster::where(
                [
                    'business_id' => $request->get('business_id'),
                    'type' => 'Facebook'
                ]
            )->first();

            if ($thirdPartyResult) {

                /**
                 * This Business has been Manual deleted
                 * so we can not add this business again.
                 * We can only add this business by two ways
                 * 1- Manual Connect
                 * 2- By Replacing Business Name.
                 */
                if ($thirdPartyResult['is_manual_deleted'] == 1 && empty($request->get('isNameChanged'))) {
                    return $this->helpError(3, 'Business stats showing this business already deleted. so you can only connect it By Manual connect or replace Business Name.');
                }

                /**
                 * if data is manual connected & business name not changed
                 * then only re-compare issues with third party business record.
                 */
                if (($thirdPartyResult['is_manual_connected'] == 1 && empty($request->get('isNameChanged')))
                    ||
                    (!empty($request->get('onlyIssuesCompare')) && empty($request->get('isNameChanged')))
                ) {
                    $thirdPartyId = $thirdPartyResult['id'];

                    $issueData = [
                        [
                            'key' => 'phone',
                            'value' => $thirdPartyResult['phone'],
                            'issue' => ($thirdPartyResult['phone'] != '') ? 18 : 49,
                            'oldIssue' => ($thirdPartyResult['phone'] == '') ? 18 : 49
                        ],
                        [
                            'key' => 'address',
                            'value' => $thirdPartyResult['street'],
                            'issue' => ($thirdPartyResult['street'] != '') ? 19 : 51,
                            'oldIssue' => ($thirdPartyResult['street'] == '') ? 19 : 51
                        ],
                        [
                            'key' => 'website',
                            'value' => $thirdPartyResult['website'],
                            'issue' => ($thirdPartyResult['website'] != '') ? 20 : 50,
                            'oldIssue' => ($thirdPartyResult['website'] == '') ? 20 : 50
                        ],
                        [
                            'key' => 'profile_photo',
                            'value' => $thirdPartyResult['profile_photo'],
                            'issue' => 22,
                        ],
                        [
                            'key' => 'cover_photo',
                            'value' => $thirdPartyResult['cover_photo'],
                            'issue' => 23,
                        ],
                        [
                            'key' => 'reviews',
                            'value' => $thirdPartyResult['page_reviews_count'],
                            'issue' => 64,
                            'oldIssue' => ""
                        ],
                        [
                            'key' => 'rating',
                            'value' => $thirdPartyResult['average_rating'],
                            'issue' => 60,
                            'oldIssue' => ""
                        ]
                    ];


                    $thirdPartyEntity->globalIssueGenerator($userId, $request->get('business_id'), $thirdPartyId, $issueData, 'Facebook', 'social');

                    return $this->helpReturn("Facebook Response.");
                }
            }

            /*
             * onlyIssuesCompare = true
             * we don't want to again call scrapper. we've to only compare issues.
             * But if third party data not found from table then return from here don't go next.
             */
            if (!empty($request->get('onlyIssuesCompare'))) {
                return $this->helpError(3, 'Third party business compared.');
            }

            $data['type'] = 'Facebook';

            /**
             * call scrapper api -> get business detail from tripadvisor
             * yes it takes data every time, may be user has changed some
             * info at tripadvisor.
             */
            $result = $this->getBusinessDetail($request);
            $responseCode = $result['_metadata']['outcomeCode'];

            return DB::transaction(function () use ($request, $result, $userId, $thirdPartyEntity, $thirdPartyObj, $thirdPartyResult) {
                $businessObj = new BusinessEntity();
                $businessId = $request->get('business_id');

                // request response
                $responseCode = $result['_metadata']['outcomeCode'];

                $data = [];
                $data['type'] = 'Facebook';

                if ($responseCode == 200) {
                    $records = $result['records']['Results'];
                    $userReviews = $result['records']['Results']['ReviewsDetail'];

                    /**
                     * if user business record meet on trip advisor area
                     * update trip_advisor_master_table
                     */
                    if ($records) {

                        /**
                         * Purpose of this check to restrict new Listing If previous business is already
                         * Inserted. If business gets updated Except Name but with any field Phone, street
                         *
                         * Previously Sometimes new business occur from scrapper if any field changed from
                         * business fields like phone. so to avoid this. put this check to stop business
                         * replace. Now When new business is occur and this is not matched with our existing
                         * third party Business we'll return from here.
                         */
                        if (empty($request->get('isNameChanged')) && !empty($thirdPartyResult['name'])) {
                            if (strtolower($thirdPartyResult['name']) != strtolower($records['Name'])) {
                                Log::info("FB check stop new listing" . $thirdPartyResult['name'] . " > " . $records['Name']);

                                return $this->helpReturn("Data already saved. New Business try to insert.", $thirdPartyResult);
                            }
                        }
                        else
                        {
                            Log::info("FB New business discovery process started");

                            $fuzz = new Fuzz();

                            $score = $fuzz->tokenSortRatio(strtolower($request->get('businessKeyword')), strtolower($records['Name']));

                            Log::info("Update FB Scrapper -> Score of -> $score > Business Name > " . $request->get('businessKeyword') . " > FB Scrapper Name " . $records['Name']);

                            if ($score < 40) {
                                Log::info("FB Accuracy failure");

                                $businessId = $request->get('business_id');
                                $data['business_id'] = $businessId;
                                $insertIssue = [
                                    [
                                        'key' => 'name',
                                        'userID' => $request->get('userID'),
                                        'business_id' => $businessId,
                                        'issue' => 17,
                                        'type' => $data['type']
                                    ]
                                ];

                                $thirdPartyObj->compareThirdPartyRecord($insertIssue, 'social');

                                if ($thirdPartyResult) {
                                    $thirdPartyResult->delete();
                                }

                                return $this->helpError(404, 'FB Business accuracy failure.');
                            }
                        }

                        Log::info("FB updating process started");


                        $data['business_id'] = $businessId;

                        $data['name'] = $records['Name'];
                        $data['page_id'] = (!empty($records['Other']['id'])) ? $records['Other']['id'] : "";
                        $data['page_url'] = $records['URL'];

                        $data['page_reviews_count'] = $records['Review'];
                        $data['average_rating'] = $records['Rating'];
                        $data['page_likes_count'] = (!empty($records['Other']['Likes'])) ? $records['Other']['Likes'] : 0;
                        $data['website'] = $records['Website'];
                        $data['phone'] = trim($records['ContactNo']);
                        $data['street'] = $records['AddressDetail']['Street'];
                        $data['city'] = $records['AddressDetail']['City'];
                        $data['zipcode'] = $records['AddressDetail']['Zip'];
                        $data['state'] = $records['AddressDetail']['State'];
                        $data['country'] = $records ['AddressDetail']['Country'];

                        // if is_silhouette == 1 then it has not any profile picture
                        if (!empty($records['Other']['picture']['data']['is_silhouette']) && $records['Other']['picture']['data']['is_silhouette'] == 1) {
                            $data['profile_photo'] = '';
                            $profilePicture = 0;
                        } else {
                            $data['profile_photo'] = !empty($records['Other']['picture']) ? $records['Other']['picture']['data']['url'] : '';
                            $profilePicture = 1;
                        }

                        $data['cover_photo'] = (!empty($records['Other']['cover'])) ? $records['Other']['cover']['source'] : '';
                        $data['add_review_url'] = $records['URL'] . '/reviews/?ref=page_internal';

                        /**
                         * Remove http in website before saving into database
                         */
                        $str = $data['website'];
                        $str = preg_replace('#^http?://#', '', rtrim($str, '/'));

                        $data['website'] = $str;

                        $data['is_manual_connected'] = 0;
                        $data['is_manual_deleted'] = 0;

                        if (!empty($thirdPartyResult['id'])) {
                            $thirdPartyId = $thirdPartyResult['id'];
                            $thirdPartyResult->update($data);
                        } else {
                            $thirdPartyResult = SocialMediaMaster::create($data);
                            $thirdPartyId = (!empty($thirdPartyResult['id'])) ? $thirdPartyResult['id'] : NULL;
                        }

                        $issueData = [
                            [
                                'key' => 'phone',
                                'value' => $thirdPartyResult['phone'],
                                'issue' => ($thirdPartyResult['phone'] != '') ? 18 : 49,
                                'oldIssue' => ($thirdPartyResult['phone'] == '') ? 18 : 49
                            ],
                            [
                                'key' => 'address',
                                'value' => $thirdPartyResult['street'],
                                'issue' => ($thirdPartyResult['street'] != '') ? 19 : 51,
                                'oldIssue' => ($thirdPartyResult['street'] == '') ? 19 : 51
                            ],
                            [
                                'key' => 'website',
                                'value' => $thirdPartyResult['website'],
                                'issue' => ($thirdPartyResult['website'] != '') ? 20 : 50,
                                'oldIssue' => ($thirdPartyResult['website'] == '') ? 20 : 50
                            ],
                            [
                                'key' => 'profile_photo',
                                'value' => $profilePicture,
                                'issue' => 22,
                            ],
                            [
                                'key' => 'cover_photo',
                                'value' => $thirdPartyResult['cover_photo'],
                                'issue' => 23,
                            ],
                            [
                                'key' => 'reviews',
                                'value' => $thirdPartyResult['page_reviews_count'],
                                'issue' => 64,
                                'oldIssue' => ""
                            ],
                            [
                                'key' => 'rating',
                                'value' => $thirdPartyResult['average_rating'],
                                'issue' => 60,
                                'oldIssue' => ""
                            ]
                        ];

                        $thirdPartyEntity->globalIssueGenerator($request->get('userID'), $businessId, $thirdPartyId, $issueData, $data['type'], 'social');

                        return $this->helpReturn("Data saved.");
                    }
                }
                else if ($responseCode == 404) {

                    /**
                     * User does not change the Business Name but If we'll not get any Business on change Phone or field
                     * if any chance occured then we'll not delete user existing business because user does not want
                     * to delete that business
                     */
                    if (empty($request->get('isNameChanged')) && !empty($thirdPartyResult['name'])) {
                        Log::info("FB -> no need to delete a business record and generate an issue");
                        return $this->helpError(404, 'Business record not found.');
                    }


                    $businessId = $request->get('business_id');
                    $data['business_id'] = $businessId;
                    $insertIssue = [
                        [
                            'key' => 'name',
                            'userID' => $request->get('userID'),
                            'business_id' => $businessId,
                            'issue' => 17,
                            'type' => $data['type']
                        ]
                    ];

                    $thirdPartyObj->compareThirdPartyRecord($insertIssue, 'social');


                    /**
                     * delete previous stored business trace from >> social_media_master
                     *  first business was present & second time business not found on update
                     * time, then delete the business.
                     */

                    if ($thirdPartyResult) {
                        $thirdPartyResult->delete();
                    }
                }

                return $this->helpError(404, 'Facebook business record not found.');
            });
        } catch (Exception $exception) {
            Log::info(" facebook entity > updateThirdPartyMaster >> " . $exception->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    /**
     * Get data from facebook of given business name.
     * @param $request
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getBusinessDetail($request)
    {
        try {
            if($request->has('businessKeyword'))
            {
                $businessKeyword = $request->get('businessKeyword');
            }
            elseif($request->has('name'))
            {
                $businessKeyword = $request->get('name');
            }

            $query = ['Keyword' => $businessKeyword];

            if($request->has('phone'))
            {
                $query['PhoneNo'] = $request->get('phone');
            }

            $appEnvironment = Config::get('apikeys.APP_ENV');

            $serverUrl = ( $appEnvironment == 'production') ? Config::get('custom.Scrapper_Prod_SERVER_URL'): Config::get('custom.SERVER_URL');


            $detailUrl = ( $appEnvironment == 'production') ? Config::get('custom.facebookProdBusinessDetail'): Config::get('custom.facebookTestBusinessDetail');

            $url = $serverUrl.$detailUrl;

            $client = new Client([]);

            $response = $client->request(
                'GET',
                $url,
                [
                    'query' => $query
                ]
            );

            $responseData = json_decode($response->getBody()->getContents(), true);

            if ($response->getStatusCode() == 200) {
                if (!empty(($responseData['Results']['Name']))) {
                    return $this->helpReturn("Facebook Response.", $responseData);
                }
            }

            return $this->helpError(404, 'Record not found.');
        } catch (Exception $e) {
            Log::info("facebookentity > getBusinessDetail >> " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    /**
     * Get User Page Post
     * @param $request (access_token, pageId)
     * @return mixed
     */

    public function getPagePostInfo($pagToken, $pageId, $type)
    {
        $access_token = $pagToken;
        $page_id = $pageId;

        if ($access_token != '') {
            try {
                if ($page_id != '') {

                    $getpagepost = $this->fb->get('/' . $page_id . '?fields=posts', $access_token);

                    $pagepost = $getpagepost->getDecodedBody();

                    if( !empty($pagepost['posts']['data']) ) {
                        $userPageDetail['posts'] = $pagepost['posts']['data'];
                        return $this->helpReturn('Results are.', $userPageDetail);
                    }

                    return $this->helpError(404, 'page posts not found.');
                } else {
                    return $this->helpError(2, 'page id is Missing');
                }

            }

            catch (FacebookResponseException $e) {
                Log::info(" FacebookResponseException > " . $e->getMessage());
                return $this->helpError(1, 'An unknown error has occurred. Please try again. Record not found.');
            }

            catch (FacebookOtherException $e) {
                Log::info(" FacebookOtherException > " . $e->getMessage());
                return $this->helpError(1, 'An unknown error has occurred. Please try again. Record not found.');
            }
            catch (FacebookSDKException $e) {
                Log::info(" FacebookSDKException > " . $e->getMessage());
                return $this->helpError(1, 'An unknown error has occurred. Please try again. Record not found.');
            }
            catch (Exception $e) {
                Log::info($e->getMessage());
                return $this->helpError(1, 'An unknown error has occurred. Please try again. Record not found.');
            }
        } else
        {
            return $this->helpError(2, 'Token is Missing');
        }
    }

    public function getPageReviewRatingInfo($pagToken, $pageId, $type)
    {

        $accessToken = $pagToken;
        $page_id = $pageId;

        if ($accessToken != '') {
            try {

                if ($page_id != '') {

                    $pageAccessToken = $this->fb->get('/' . $pageId . '?fields=access_token', $accessToken);
                    $pageAccessToken = $pageAccessToken->getDecodedBody();
                    $pageAccessShortLifeToken = $pageAccessToken['access_token'];

                    $params = [
                        'grant_type' => 'fb_exchange_token',
                        'client_id' => Config::get('apikeys.FACEBOOK_APP_ID'),
                        'client_secret' => Config::get('apikeys.FACEBOOK_APP_SECRET'),
                        'fb_exchange_token' => $pageAccessShortLifeToken,

                    ];
                    $longTimeAccessToken = $this->fb->post('/oauth/access_token', $params, $accessToken);
                    $longTimeAccessToken = $longTimeAccessToken->getDecodedBody();

                    $pageRecommendation = $this->fb->get('/' . $pageId . '/ratings', $longTimeAccessToken['access_token']);
                    $pageRecommendation = $pageRecommendation->getDecodedBody();
                    $recommendationCount= count($pageRecommendation['data']);

                    $getPageLikesCount = $this->fb->get('/' . $page_id . '?fields=fan_count', $longTimeAccessToken['access_token']);
                    $getPageLikesCount = $getPageLikesCount->getDecodedBody();

                    $getPageUrl = $this->fb->get('/' . $page_id . '?fields=link', $longTimeAccessToken['access_token']);
                    $getPageUrl = $getPageUrl->getDecodedBody();

                    $appendPageRecommendationCount['page_recommendation_count'] = $recommendationCount;
                    $appendPageLikesCount['page_likes_count'] = $getPageLikesCount;
                    $appendPageUrl['page_url'] = $getPageUrl;

                    $appendLongLifeAccessToken['long_life_access_token'] = $longTimeAccessToken;

                    $finalDetails = array_merge($appendPageRecommendationCount,$appendPageLikesCount, $appendPageUrl,$appendLongLifeAccessToken);

                    return $this->helpReturn('Results are.', $finalDetails);

                } else {
                    Log::info('page id is Missing');
                    return $this->helpError(2, 'page id is Missing');
                }


            } catch (Exception $e) {
                Log::info($e->getMessage());
                return $this->helpError(404, 'Record not found.');
            }
        } else {
            Log::info('Token is Missing');
            return $this->helpError(2, 'Token is Missing');
        }
    }

    public function getPageReviewRatingLikeHistoricalData($request)
    {
        try {
            $pageAccessToken = $request->get('page_access_token');

            $currentDate = Carbon::tomorrow();
            $tilldate = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate)->format('Y-m-d');

            $currentDate = Carbon::now()->subMonth(3);
            $since_date = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate)->format('Y-m-d');


            $currentDatee = Carbon::now()->subMonth(1);
            $since_insight_date= Carbon::createFromFormat('Y-m-d H:i:s', $currentDatee)->format('Y-m-d');

            if ($pageAccessToken == '') {
                Log::info("Page Access token is missing");
                return $this->helpError(2, 'Page Access token is missing');
            }

            if (!empty($request->get('page_id'))) {
                $pageId = $request->get('page_id');
                $params = [
                    'grant_type' => 'fb_exchange_token',
                    'client_id' => Config::get('apikeys.FACEBOOK_APP_ID'),
                    'client_secret' => Config::get('apikeys.FACEBOOK_APP_SECRET'),
                    'fb_exchange_token' => $pageAccessToken,
                ];

                $longTimeAccessToken = $this->fb->post('/oauth/access_token', $params, $pageAccessToken);
                $longTimeAccessToken = $longTimeAccessToken->getDecodedBody();

                $pageRecomendationDetail = $this->fb->get('/' . $pageId . '/ratings', $longTimeAccessToken['access_token']);
                $pageLikeDetail = $this->fb->get('/' . $pageId . '/insights?pretty=0&since=' . $since_date . '&until=' . $tilldate . '&metric=page_fan_adds&limit=9999', $longTimeAccessToken['access_token']);
                $pagePostDetail = $this->fb->get('/' . $pageId . '/posts', $longTimeAccessToken['access_token']);
                $pageViewsDetail = $this->fb->get('/' . $pageId . '/insights?pretty=0&since=' . $since_insight_date . '&until=' . $tilldate . '&metric=page_views_total&limit=9999&period=days_28', $longTimeAccessToken['access_token']);
                $pageTotalReachDetail = $this->fb->get('/' . $pageId . '/insights?pretty=0&since=' . $since_insight_date . '&until=' . $tilldate . '&metric=page_impressions_unique&limit=9999&period=days_28', $longTimeAccessToken['access_token']);
                $pagePeopleEngagedDetail = $this->fb->get('/' . $pageId . '/insights?pretty=0&since=' . $since_insight_date . '&until=' . $tilldate . '&metric=page_engaged_users&limit=9999&period=days_28', $longTimeAccessToken['access_token']);

                $pageRecomendationDetail = $pageRecomendationDetail->getDecodedBody();
                $recommendationCount= count($pageRecomendationDetail['data']);
                $pageLikeDetail = $pageLikeDetail->getDecodedBody();
                $pagePostDetail = $pagePostDetail->getDecodedBody();

                $pageViewsDetail = $pageViewsDetail->getDecodedBody();
                $pageTotalReachDetail = $pageTotalReachDetail->getDecodedBody();
                $pagePeopleEngagedDetail = $pagePeopleEngagedDetail->getDecodedBody();

                $appendLikeArray['likes_data'] = $pageLikeDetail;
                $appendPostArray['post_data'] = $pagePostDetail;

                $appendPageRecommendationArray['page_recommendation_data'] = $pageRecomendationDetail;
                $appendPageRecommendationCount['recommendation_count'] = $recommendationCount;

                $appendPageViewsArray['page_views_data'] = $pageViewsDetail;
                $appendTotalReachArray['total_reach_data'] = $pageTotalReachDetail;
                $appendPeopleEngagedArray['people_engaged_data'] = $pagePeopleEngagedDetail;

                $appendlongLifeAccessToken['long_life_access_token'] = $longTimeAccessToken;

                $finalDetails = array_merge($appendPageRecommendationArray, $appendLikeArray,$appendPostArray,$appendPageViewsArray,$appendTotalReachArray,$appendPeopleEngagedArray, $appendlongLifeAccessToken);

                return $this->helpReturn('Page Result', $finalDetails);

            } else {
                Log::info("page id is Missing");
                return $this->helpError(2, 'page id is Missing');
            }
        } catch (Exception $e) {

            Log::info("error in long life token");
            return $this->helpError(1, 'An unknown error has occurred. Please try again. Please Try Again');

        }
    }

    public function getPageBasicInfo($pagToken, $pageId, $type)
    {

        $access_token = $pagToken;
        $page_id = $pageId;

        if ($access_token != '') {
            try {

                if ($page_id != '') {

                    $getpagepost = $this->fb->get('/' . $page_id . '?fields=name,phone,location, picture, cover, website', $access_token);
                    $pageContent = $getpagepost->getDecodedBody();


                } else {
                    Log::info('page id is Missing');
                    return $this->helpError(2, 'page id is Missing');
                }

                return $this->helpReturn('Results are.', $pageContent);
            } catch (Exception $e) {
                Log::info($e->getMessage());
                return $this->helpError(404, 'Record not found.');
            }
        } else {
            Log::info('Token is Missing');
            return $this->helpError(2, 'Token is Missing');
        }
    }


    public function getPageInsights($request)
    {
        try {
            //  dd("here");

        }

        catch (Exception $e) {
            Log::info($e->getMessage());
            return $this->helpError(404, 'Record not found.');
        }

    }

    public function directPublishedPost($request)
    {
        try {
            Log::info('Your are in Facebook');
            Log::info('$request');
            Log::info($request);

            $businessId = $request['business_id'];
            $post_message = $request['message'];

            Log::info('businessId ' . $businessId);

            $socialMedia = SocialMediaMaster::select('business_id', 'access_token', 'page_access_token', 'page_id')
                ->where('business_id', $businessId)
                ->whereNotNull('page_access_token')
                ->whereNotNull('page_id')
                ->whereNotNull('access_token')
                ->first();

            $data['page_access_token'] = $socialMedia['page_access_token'];
            $data['user_access_token'] = $socialMedia['access_token'];
            $data['page_id'] = $socialMedia['page_id'];

            if ($request->status == 'published' && !isset($request->post_id)) {
                /**
                 * Direct Post To Twitter
                 */
                $media_ids = [];
                $photoIdArray = [];
                $pageAccessToken = $this->fb->get
                (
                    '/' . $data['page_id'] . '?fields=access_token', $data['user_access_token']
                );



                $pageAccessToken = $pageAccessToken->getDecodedBody();

//                Log::info('$pageAccessToken');
//                Log::info($pageAccessToken);

                $pageAccessShortLifeToken = $pageAccessToken['access_token'];
                $params = [
                    'grant_type' => 'fb_exchange_token',
                    'client_id' => Config::get('apikeys.FACEBOOK_APP_ID'),
                    'client_secret' => Config::get('apikeys.FACEBOOK_APP_SECRET'),
                    'fb_exchange_token' => $pageAccessShortLifeToken,
                ];

                $longTimeAccessToken = $this->fb->post('/oauth/access_token', $params, $data['user_access_token']);
                $longTimeAccessToken = $longTimeAccessToken->getDecodedBody();
                $mediaType = '';

                if ($request->hasFile('attach_file')) {
                    $attachedFile = $request->attach_file;
//                    Log::info('$request');
//                    Log::info($request);
                    foreach ($attachedFile as $file) {

                        Log::info('Direct published without post id');
                        $extension = $file->getClientOriginalExtension();
//                        Log::info('$extension');
//                        Log::info($extension);
                        if(empty($extension) && $request->has('blob'))
                        {
//                            Log::info('blob');
//                            Log::info($request->has('blob'));
                            $extension = 'png';
                        }

                        if ($extension == 'jpeg' || $extension == 'jpg' || $extension == 'JPEG' || $extension == 'png' || $extension == 'PNG') {
                            $mediaType = 'image';
                        } else if ($extension == 'mp4') {
                            $mediaType = 'video';
                        }

//                        $mediaType = 'image';
                        if (isset($mediaType) && $mediaType == 'image') {
//                            log::info('before');

                            $uploadImageFeed = $this->fb->post(
                                '/' .
                                $data['page_id'] . '/photos',
                                [
                                    'source' => $this->fb->fileToUpload($file),
                                    'published' => FALSE,
                                    'caption' => $post_message
                                ],
                                $longTimeAccessToken['access_token']
                            );
//                            log::info('after');
//                            log::info('$uploadImageFeed 00');
                            $uploadImageFeed = $uploadImageFeed->getDecodedBody();
//                            log::info('$uploadImageFeed 01');
                            $media_ids[] = $uploadImageFeed['id'];

                        }
                        else if (isset($mediaType) && $mediaType == 'video') {
                            $postVideoFeed = $this->fb->post('/' . $data['page_id'] . '/videos', ['source' => $this->fb->videoToUpload($file), 'description' => $post_message], $longTimeAccessToken['access_token']);
                            $post = $postVideoFeed->getDecodedBody();
                        }
                    }
                }
                $postImageParams = [
                    'message' => $post_message
                ];
                if ($mediaType == 'image') {

                    if (!empty($media_ids)) {
                        foreach ($media_ids as $index => $photoId) {
                            $postImageParams["attached_media"][$index] = '{"media_fbid":"' . $photoId . '"}';
                        }
                    }
                }
                if ($mediaType != 'video') {

                    $posts = $this->fb->post('/' . $data['page_id'] . '/feed', $postImageParams, $longTimeAccessToken['access_token']);
                    $post = $posts->getDecodedBody();
                }
                 PostMaster::create(['business_id' => $businessId, 'post_id' => $post['id'], 'social_media_type' => 'Facebook', 'status' => $request->status]);

            }
            return $this->helpReturn("Post Successfully Added.");

        } catch (Exception $e) {
            Log::info(" directPublishedPost > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function indirectPublishedPost($request)
    {
        try{
        $businessId = $request['business_id'];
        $post_message = $request['message'];
        $socialMedia = SocialMediaMaster::select('business_id','access_token','page_access_token','page_id')
            ->where('business_id',$businessId)
            ->whereNotNull('page_access_token')
            ->whereNotNull('page_id')
            ->whereNotNull('access_token')
            ->first();

        $data['page_access_token'] = $socialMedia['page_access_token'];
        $data['user_access_token'] = $socialMedia['access_token'];
        $data['page_id'] = $socialMedia['page_id'];

        $pageAccessToken = $this->fb->get('/' .  $data['page_id'] . '?fields=access_token',  $data['user_access_token']);
        $pageAccessToken = $pageAccessToken->getDecodedBody();
        $pageAccessShortLifeToken = $pageAccessToken['access_token'];
        $params = [
            'grant_type' => 'fb_exchange_token',
            'client_id' => Config::get('apikeys.FACEBOOK_APP_ID'),
            'client_secret' => Config::get('apikeys.FACEBOOK_APP_SECRET'),
            'fb_exchange_token' => $pageAccessShortLifeToken,
        ];
        $longTimeAccessToken = $this->fb->post('/oauth/access_token', $params,  $data['user_access_token']);
        $longTimeAccessToken = $longTimeAccessToken->getDecodedBody();
        $mediaType = '';
        $record = [];
        if ($request->status == 'published' && isset($request->post_id)) {
            Log::info('post with published and post id');
            //$postMastersRecord = PostMasterSocialMedia::where('post_master_id', $request->post_id)->get()->toArray();

            $attachment = $request['urls'];
            if (!empty($attachment)) {

                foreach ($attachment as $file) {
                    $mediaType = $file['type'];
                    if(isset($mediaType) && $mediaType == 'image'){
                        $request->request->add(['media_type' => 'image']);
                        $uploadImageFeed = $this->fb->post('/' . $data['page_id'] . '/photos', ['source' => $this->fb->fileToUpload($file['media_url']), 'published' => FALSE, 'caption' => $post_message], $longTimeAccessToken['access_token']);
                        $uploadImageFeed = $uploadImageFeed->getDecodedBody();
                        $media_ids[] = $uploadImageFeed['id'];

                    }else if(isset($mediaType) && $mediaType == 'video'){

                        $postVideoFeed = $this->fb->post('/' . $data['page_id'] . '/videos', ['source' => $this->fb->videoToUpload($file['media_url']), 'description'=> $post_message],  $longTimeAccessToken['access_token']);
                        $post = $postVideoFeed->getDecodedBody();

                    }

                }
            }


            $postImageParams = [
                'message' => $post_message
            ];
            if ($mediaType == 'image') {

                if (!empty($media_ids)) {
                    foreach ($media_ids as $index => $photoId) {
                        $postImageParams["attached_media"][$index] = '{"media_fbid":"' . $photoId . '"}';
                    }
                }
            }

            if ($mediaType != 'video') {

                $posts = $this->fb->post('/' . $data['page_id'] . '/feed', $postImageParams, $longTimeAccessToken['access_token']);

                $post = $posts->getDecodedBody();
            }
            $record = ['business_id' => $businessId, 'post_id' => $post['id'], 'social_media_type' => 'Facebook', 'status' => $request->status];


        }

        return $this->helpReturn("Post Successfully Added.",$record);
//        return $this->helpReturn("Post Successfully Added.");

        }
        catch (Exception $exception)
        {
            Log::info($exception->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function getSocialMediaPostFeed($data, $limit =3 , $after = '')
    {
        try {
            $businessId = $data['businessId'];

            $socialResult = SocialMediaMaster::select('business_id','type', 'name', 'access_token', 'page_access_token', 'page_id')
                ->where('type','Facebook')
                ->where('business_id', $businessId)
                ->whereNotNull('page_access_token')
                ->whereNotNull('page_id')
                ->whereNotNull('access_token')
                ->get()->toArray();

            if (empty($socialResult)) {
                return $this->helpError(404, 'No Page Found.');
            }

            $postIdArray  = [];
            $postresult  = [];

            $result=[];

            $data['page_access_token'] = $socialResult[0]['page_access_token'];
            $data['user_access_token'] = $socialResult[0]['access_token'];
            $data['page_id'] = $socialResult[0]['page_id'];

            if ($data['user_access_token'] != '') {
                $pageAccessToken = $this->fb->get('/' . $data['page_id'] . '?fields=access_token', $data['user_access_token']);
                $pageAccessToken = $pageAccessToken->getDecodedBody();
                $pageAccessShortLifeToken = $pageAccessToken['access_token'];

                $params = [
                    'grant_type' => 'fb_exchange_token',
                    'client_id' => Config::get('apikeys.FACEBOOK_APP_ID'),
                    'client_secret' => Config::get('apikeys.FACEBOOK_APP_SECRET'),
                    'fb_exchange_token' => $pageAccessShortLifeToken,
                ];
                $longTimeAccessToken = $this->fb->post('/oauth/access_token', $params, $data['user_access_token']);
                $longTimeAccessToken = $longTimeAccessToken->getDecodedBody();
                if ($after != '') {
                    # code...
                    $pageFeed = $this->fb->get('/' . $data['page_id'] . '/feed?limit='. $limit. '&after='. $after, $longTimeAccessToken['access_token']);

                } else {
                    $pageFeed = $this->fb->get('/' . $data['page_id'] . '/feed?limit='. $limit, $longTimeAccessToken['access_token']);

                }
                $pageFeed = $pageFeed->getDecodedBody();

                foreach ($pageFeed['data'] as $postdetail) {

                    $postId = $postdetail['id'];
                    $postIds = $this->fb->get('/' . $postId . '?fields=id', $data['page_access_token']);
                    //  $postDetail = $this->fb->get('/' . '2274976966065498_2340631602833367' . '?fields=id,message,attachments{media,subattachments}', $data['page_access_token']);
                    $postIds = $postIds->getDecodedBody();

                    $postIdArray[] = $postIds['id'];
                }

                $weekly_array = [];
                $i = 1;
                $postresult = [];
                $postresult['after'] =  $pageFeed['paging']['cursors']['after'];
                $currentDate = '';
                $time = '';
                foreach ($postIdArray as $postdata) {
                  //  echo $k, ' = ', $postdata, '<br />', PHP_EOL;

                    $postDetail = $this->fb->get('/' . $postdata . '?fields=id,message,created_time,permalink_url,attachments{media,subattachments,title},likes.summary(true),comments.summary(true)', $data['page_access_token']);
                    $postDetail = $postDetail->getDecodedBody();
                    !empty($postDetail['created_time']) ? $postDate = $postDetail['created_time'] : '';
                    if(!empty($postDate)) {
                        $carbon = new \Carbon\Carbon();
                        $date = $carbon->createFromTimestamp(strtotime($postDate),'EST');
                        $currentDate =  $date->format('Y-m-d');
                        $time =  $date->format('Y-m-d h:i:s');
                    }


                    $result['post_id'] = !empty($postDetail['id']) ? $postDetail['id'] : '';
                    $result['post_message'] = !empty($postDetail['message']) ? $postDetail['message'] : '';
                    $result['post_time'] = !empty($time) ? $time : '';
                    $result['post_url'] = !empty($postDetail['permalink_url']) ? $postDetail['permalink_url'] : '';
                    $result['post_likes'] = !empty($postDetail['likes']['summary']['total_count']) ? $postDetail['likes']['summary']['total_count'] : '';
                    $result['post_comments'] = !empty($postDetail['comments']['summary']['total_count']) ? $postDetail['comments']['summary']['total_count'] : '';
                    $result['post_image'] = !empty($postDetail['attachments']['data'][0]['media']['image']['src']) ? $postDetail['attachments']['data'][0]['media']['image']['src'] : '';
                    $result['post_multiple_images'] = !empty($postDetail['attachments']['data'][0]['subattachments']['data']) ? $postDetail['attachments']['data'][0]['subattachments']['data'] : '';
                    $result['post_video'] = !empty($postDetail['attachments']['data'][0]['media']['source']) ? $postDetail['attachments']['data'][0]['media']['source'] : '';

                    if (isset($data['screen']) && $data['screen'] == 'mobile') {
                        $postresult[] = $result;
                    }else{

                        if (in_array($currentDate, $weekly_array)) {
                            $postresult[$currentDate][] = $result;

                        } else {
                            $postresult[$currentDate][0] = $result;

                        }

                        array_push($weekly_array, $currentDate);
                        $result = [];
                    }
                }

                return $this->helpReturn('Post Feed Detail', $postresult);

            }


        } catch (FacebookResponseException $e) {
            Log::info(" FacebookResponseException > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again. Record not found.');
        } catch (FacebookOtherException $e) {
            Log::info(" FacebookOtherException > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again. Record not found.');
        } catch (FacebookSDKException $e) {
            Log::info(" FacebookSDKException > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again. Record not found.');
        } catch (Exception $e) {
            Log::info(" Main getSocialMediaPostFeed > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again. Record not found.');
        }

    }

    public function getSinglePost($request)
    {
        try {
            $businessObj = new BusinessEntity();

            $businessResult = $businessObj->userSelectedBusiness();

            if ($businessResult['_metadata']['outcomeCode'] != 200) {
                return $this->helpError(1, 'Problem in selection of your business.');
            }

            $businessResult = $businessResult['records'];
            $businessId = $businessResult['business_id'];


            $data = [];
            $socialResult = SocialMediaMaster::select('business_id','type', 'name', 'access_token', 'page_access_token', 'page_id')
                ->where('type', '=','Facebook')
                ->where('business_id', $businessId)
                ->whereNotNull('page_access_token')
                ->whereNotNull('page_id')
                ->whereNotNull('access_token')
                ->first();

            if ($socialResult == null) {

                return $this->helpError(404, 'No Page Found.');
            }

            $data['page_access_token'] = $socialResult->page_access_token;
            $data['user_access_token'] = $socialResult->access_token;
            $data['page_id'] = $socialResult->page_id;
            $postresult  = [];
            $responseArray  = [];
            if ($data['user_access_token'] != '') {

                $pageAccessToken = $this->fb->get('/' . $data['page_id'] . '?fields=access_token', $data['user_access_token']);
                $pageAccessToken = $pageAccessToken->getDecodedBody();
                $pageAccessShortLifeToken = $pageAccessToken['access_token'];

                $params = [
                    'grant_type' => 'fb_exchange_token',
                    'client_id' => Config::get('apikeys.FACEBOOK_APP_ID'),
                    'client_secret' => Config::get('apikeys.FACEBOOK_APP_SECRET'),
                    'fb_exchange_token' => $pageAccessShortLifeToken,
                ];
                $longTimeAccessToken = $this->fb->post('/oauth/access_token', $params, $data['user_access_token']);
                $longTimeAccessToken = $longTimeAccessToken->getDecodedBody();
                $postId = $request->post_id;

                $pageFeed = $this->fb->get('/' . $postId, $longTimeAccessToken['access_token']);
                $pageFeed = $pageFeed->getDecodedBody();
//                Log::info('facebook response');
//                Log::info($pageFeed);
                $postDate = $pageFeed['created_time'];

                $date = strtotime($postDate);
                //$currentDate = date("d-M-y", $date);
                $time = date("Y-m-d h:i:s", $date);
                $responseArray = [
                    'created_at' => isset($time) && !empty($time) ? $time : '',
                    'message' => isset($pageFeed['message']) && !empty($pageFeed['message']) ? $pageFeed['message'] : '',
                    'id' => $pageFeed['id'],
                ];

                return $this->helpReturn('Get Single Post Successfully', $responseArray);

            }


        } catch (FacebookResponseException $e) {
            Log::info(" FacebookResponseException > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again. Record not found.');
        } catch (FacebookOtherException $e) {
            Log::info(" FacebookOtherException > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again. Record not found.');
        } catch (FacebookSDKException $e) {
            Log::info(" FacebookSDKException > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again. Record not found.');
        } catch (Exception $e) {
            Log::info(" getSinglePost > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again. Record not found.');
        }
    }



    public function updateSinglePost($request)
    {
        try {
            $businessObj = new BusinessEntity();

            $businessResult = $businessObj->userSelectedBusiness();

            if ($businessResult['_metadata']['outcomeCode'] != 200) {
                return $this->helpError(1, 'Problem in selection of your business.');
            }

            $businessResult = $businessResult['records'];
            $businessId = $businessResult['business_id'];

            $data = [];
            $socialResult = SocialMediaMaster::select('business_id','type', 'name', 'access_token', 'page_access_token', 'page_id')
                ->where('type', '=','Facebook')
                ->where('business_id', $businessId)
                ->whereNotNull('page_access_token')
                ->whereNotNull('page_id')
                ->whereNotNull('access_token')
                ->first();

            if ($socialResult == null) {

                return $this->helpError(404, 'No Page Found.');
            }

            $data['page_access_token'] = $socialResult->page_access_token;
            $data['user_access_token'] = $socialResult->access_token;
            $data['page_id'] = $socialResult->page_id;
            $postresult  = [];
            $responseArray  = [];
            if ($data['user_access_token'] != '') {

                $pageAccessToken = $this->fb->get('/' . $data['page_id'] . '?fields=access_token', $data['user_access_token']);
                $pageAccessToken = $pageAccessToken->getDecodedBody();
                $pageAccessShortLifeToken = $pageAccessToken['access_token'];

                $params = [
                    'grant_type' => 'fb_exchange_token',
                    'client_id' => Config::get('apikeys.FACEBOOK_APP_ID'),
                    'client_secret' => Config::get('apikeys.FACEBOOK_APP_SECRET'),
                    'fb_exchange_token' => $pageAccessShortLifeToken,
                ];
                $longTimeAccessToken = $this->fb->post('/oauth/access_token', $params, $data['user_access_token']);
                $longTimeAccessToken = $longTimeAccessToken->getDecodedBody();

                $postId = $request->post_id;

                $pageFeed = $this->fb->post('/' . $postId,['message' => $request->message], $longTimeAccessToken['access_token']);
                $pageFeed = $pageFeed->getDecodedBody();

                if(isset($pageFeed['success']) && !empty($pageFeed['success']) && $pageFeed['success'] == true){
                    return $this->helpReturn('Post Updated Successfully');
                }else{
                    return $this->helpError('404','Post Not Exist');
                }
            }


        } catch (FacebookResponseException $e) {
            Log::info(" FacebookResponseException > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again. Record not found.');
        } catch (FacebookOtherException $e) {
            Log::info(" FacebookOtherException > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again. Record not found.');
        } catch (FacebookSDKException $e) {
            Log::info(" FacebookSDKException > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again. Record not found.');
        } catch (Exception $e) {
            Log::info(" updateSinglePost > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again. Record not found.');
        }
    }

    public function deleteSinglePost($request)
    {
        try {
            $businessObj = new BusinessEntity();

            $businessResult = $businessObj->userSelectedBusiness();

            if ($businessResult['_metadata']['outcomeCode'] != 200) {
                return $this->helpError(1, 'Problem in selection of your business.');
            }

            $businessResult = $businessResult['records'];
            $businessId = $businessResult['business_id'];


            $data = [];
            $socialResult = SocialMediaMaster::select('business_id','type', 'name', 'access_token', 'page_access_token', 'page_id')
                ->where('type', '=','Facebook')
                ->where('business_id', $businessId)
                ->whereNotNull('page_access_token')
                ->whereNotNull('page_id')
                ->whereNotNull('access_token')
                ->first();

            if ($socialResult == null) {

                return $this->helpError(404, 'No Page Found.');
            }

            $data['page_access_token'] = $socialResult->page_access_token;
            $data['user_access_token'] = $socialResult->access_token;
            $data['page_id'] = $socialResult->page_id;
            $postresult  = [];
            $responseArray  = [];
            if ($data['user_access_token'] != '') {

                $pageAccessToken = $this->fb->get('/' . $data['page_id'] . '?fields=access_token', $data['user_access_token']);
                $pageAccessToken = $pageAccessToken->getDecodedBody();
                $pageAccessShortLifeToken = $pageAccessToken['access_token'];

                $params = [
                    'grant_type' => 'fb_exchange_token',
                    'client_id' => Config::get('apikeys.FACEBOOK_APP_ID'),
                    'client_secret' => Config::get('apikeys.FACEBOOK_APP_SECRET'),
                    'fb_exchange_token' => $pageAccessShortLifeToken,
                ];
                $longTimeAccessToken = $this->fb->post('/oauth/access_token', $params, $data['user_access_token']);
                $longTimeAccessToken = $longTimeAccessToken->getDecodedBody();
                $postId = $request->post_id;

                $pageFeed = $this->fb->delete('/' . $postId,[$postId], $longTimeAccessToken['access_token']);
                $pageFeed = $pageFeed->getDecodedBody();
                PostMaster::where('post_id',$postId)->where('social_media_type','Facebook')->delete();
                if(isset($pageFeed['success']) && !empty($pageFeed['success']) && $pageFeed['success'] == true){
                    return $this->helpReturn('Post Deleted Successfully');
                }else{
                    return $this->helpError('404','Post Not Exist');
                }

            }


        } catch (FacebookResponseException $e) {
            Log::info(" FacebookResponseException > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again. Record not found.');
        } catch (FacebookOtherException $e) {
            Log::info(" FacebookOtherException > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again. Record not found.');
        } catch (FacebookSDKException $e) {
            Log::info(" FacebookSDKException > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again. Record not found.');
        } catch (Exception $e) {
            Log::info($e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again. Record not found.');
        }

    }

    public function updateSocialMediaPost($request)
    {

        try {
            if(isset($request->token) && !empty($request->token)) {
                $businessObj = new BusinessEntity();
                $checkPoint = $this->setCurrentUser($request->get('token'))->userAllow();

                if ($checkPoint['_metadata']['outcomeCode'] != 200) {
                    return $checkPoint;
                }

                $user = $checkPoint['records'];
                $businessResult = $businessObj->userSelectedBusiness($user);

                if ($businessResult['_metadata']['outcomeCode'] != 200) {
                    return $this->helpError(1, 'Problem in selection of user business.');
                }
                $businessId = $businessResult['records']['business_id'];

            }else if(isset($request->business_id) && !empty($request->business_id)){
                $businessId = $request->business_id;
            }

         $postId=   $request->get('post_id');
         $message=   $request->get('message');

            if($postId==''){

                return $this->helpError(1, 'Post Id cannot be empty.');
            }

            if($message==''){

                return $this->helpError(1, 'Message cannot be empty.');
            }

            $socialResult = SocialMediaMaster::select('business_id','type', 'name', 'access_token', 'page_access_token', 'page_id')
                ->where('type', '=','Facebook')
                ->where('business_id', $businessId)
                ->whereNotNull('page_access_token')
                ->whereNotNull('page_id')
                ->whereNotNull('access_token')
                ->get()->toArray();

            if (empty($socialResult)) {

                return $this->helpError(404, 'No Page Found.');
            }

            $data['page_access_token'] = $socialResult[0]['page_access_token'];
            $data['user_access_token'] = $socialResult[0]['access_token'];
            $data['page_id'] = $socialResult[0]['page_id'];

            if ($data['user_access_token'] != '') {

                $pageAccessToken = $this->fb->get('/' . $data['page_id'] . '?fields=access_token', $data['user_access_token']);
                $pageAccessToken = $pageAccessToken->getDecodedBody();
                $pageAccessShortLifeToken = $pageAccessToken['access_token'];

                $params = [
                    'grant_type' => 'fb_exchange_token',
                    'client_id' => Config::get('apikeys.FACEBOOK_APP_ID'),
                    'client_secret' => Config::get('apikeys.FACEBOOK_APP_SECRET'),
                    'fb_exchange_token' => $pageAccessShortLifeToken,
                ];
                $longTimeAccessToken = $this->fb->post('/oauth/access_token', $params, $data['user_access_token']);
                $longTimeAccessToken = $longTimeAccessToken->getDecodedBody();

                $pageFeed = $this->fb->post('/' . $postId , ['message' =>$message],  $data['page_access_token']);
                $pageFeed = $pageFeed->getDecodedBody();

                PostMaster::update(['message' => $message,'status' => 'published'])->where('post_id',$postId)
                 ->where('social_media_type','Facebook');

                return $this->helpReturn('Page Post Update Successfully', $pageFeed);

            }


        } catch (FacebookResponseException $e) {
            Log::info(" FacebookResponseException > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again. Record not found.');
        } catch (FacebookOtherException $e) {
            Log::info(" FacebookOtherException > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again. Record not found.');
        } catch (FacebookSDKException $e) {
            Log::info(" FacebookSDKException > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again. Record not found.');
        } catch (Exception $e) {
            Log::info($e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again. Record not found.');
        }

    }

// only used for facebook testing Api's no used inside socialmedia module integration
    public function testFacebookPostFeed($request)
    {
        try {

            $businessObj = new BusinessEntity();
            $checkPoint = $this->setCurrentUser($request->get('token'))->userAllow();

            if ($checkPoint['_metadata']['outcomeCode'] != 200) {
                return $checkPoint;
            }

            $user = $checkPoint['records'];
            $businessResult = $businessObj->userSelectedBusiness($user);

            if ($businessResult['_metadata']['outcomeCode'] != 200) {
                return $this->helpError(1, 'Problem in selection of user business.');
            }

            $socialResult = SocialMediaMaster::select('business_id','name','access_token','page_access_token','page_id')
                ->where('business_id',$businessResult['records']['business_id'])
                ->whereNotNull('page_access_token')
                ->whereNotNull('page_id')
                ->whereNotNull('access_token')
                ->get()->toArray();

            if(empty($socialResult ))
            {

                return $this->helpError(404, 'No Page Found.');
            }

            $data['page_access_token'] = $socialResult[0]['page_access_token'];
            $data['user_access_token'] = $socialResult[0]['access_token'];
            $data['page_id'] = $socialResult[0]['page_id'];

            $post_message = $request->get('message');

            $photoIdArray  = [];
            $result=[];

            $post_video = $request->get('video_url');

            if ($data['user_access_token'] == '') {
                return $this->helpError(2, 'Access token is missing');
            }
            if ($request->hasFile('file')) {
                $i = 0;
                foreach ($request->file as $file) {
                    $file = $request->file('file')[$i];
                    $extension = $file->getClientOriginalExtension();
                    $fileName = $file->getFilename() . '.' . $extension;
                    Storage::disk('local')->put($fileName, File::get($file));
                    $url = storage_path('app/' . $fileName);
                    $urlAppend[] = [
                        'media_url' => $url,
                    ];

                    $i++;
                }
            }
            if ($request->hasFile('video_file')) {
                $i = 0;
                foreach ($request->video_file as $file) {
                    $file = $request->file('video_file')[$i];
                    $extension = $file->getClientOriginalExtension();
                    $fileName = $file->getFilename() . '.' . $extension;
                    Storage::disk('local')->put($fileName, File::get($file));
                    $url = storage_path('app/' . $fileName);
                    $urlAppend[] = [
                        'media_url' => $url,
                    ];

                    $i++;
                }

            }
            if ($post_message != ''&& $request->hasFile('video_file')  =='' && $request->hasFile('file')=='' ) {

                //  dd("only message");

                $pageAccessToken = $this->fb->get('/' .  $data['page_id'] . '?fields=access_token',  $data['user_access_token']);
                $pageAccessToken = $pageAccessToken->getDecodedBody();
                $pageAccessShortLifeToken = $pageAccessToken['access_token'];

                $params = [
                    'grant_type' => 'fb_exchange_token',
                    'client_id' => Config::get('apikeys.FACEBOOK_APP_ID'),
                    'client_secret' => Config::get('apikeys.FACEBOOK_APP_SECRET'),
                    'fb_exchange_token' => $pageAccessShortLifeToken,
                ];

                $postFeedParams=[
                    'message'=> $post_message
                ];
                $longTimeAccessToken = $this->fb->post('/oauth/access_token', $params,  $data['user_access_token']);
                $longTimeAccessToken = $longTimeAccessToken->getDecodedBody();

                $pageFeed = $this->fb->post('/' . $data['page_id'] . '/feed', $postFeedParams, $longTimeAccessToken['access_token']);

                $pageFeed = $pageFeed->getDecodedBody();

                return $this->helpReturn('Post message successfully added', $pageFeed);
            }

            elseif($request->hasFile('file') !=''  )
            {
                //  dd("image with text and only image");

                $pageAccessToken = $this->fb->get('/' .  $data['page_id'] . '?fields=access_token',  $data['user_access_token']);
                $pageAccessToken = $pageAccessToken->getDecodedBody();
                $pageAccessShortLifeToken = $pageAccessToken['access_token'];
                $params = [
                    'grant_type' => 'fb_exchange_token',
                    'client_id' => Config::get('apikeys.FACEBOOK_APP_ID'),
                    'client_secret' => Config::get('apikeys.FACEBOOK_APP_SECRET'),
                    'fb_exchange_token' => $pageAccessShortLifeToken,
                ];
                $longTimeAccessToken = $this->fb->post('/oauth/access_token', $params,  $data['user_access_token']);
                $longTimeAccessToken = $longTimeAccessToken->getDecodedBody();

                if ($request->hasFile('file')){
                    foreach ($request->file as $file) {

                        $uploadImageFeed= $this->fb->post('/' . $data['page_id'] . '/photos', ['source' => $this->fb->fileToUpload($file),'published' => FALSE,'caption' => $post_message], $longTimeAccessToken['access_token']);
                        $uploadImageFeed = $uploadImageFeed->getDecodedBody();
                        $photoIdArray[] = $uploadImageFeed['id'];

                    }

                }
                $postImageParams=[
                    'message'=> $post_message
                ];

                foreach($photoIdArray  as $index=> $photoId) {

                    $postImageParams["attached_media"][$index] = '{"media_fbid":"' . $photoId . '"}';
                }

                $postImageFeed = $this->fb->post('/' . $data['page_id'] . '/feed',$postImageParams, $longTimeAccessToken['access_token']);

                $postImageFeed = $postImageFeed->getDecodedBody();

                return $this->helpReturn('Image is posted successfully', $postImageFeed);

            }

            elseif($request->hasFile('video_file') !='' && $post_message != '' )
            {
                //  dd(" video only or video with text");

                $pageAccessToken = $this->fb->get('/' .  $data['page_id'] . '?fields=access_token',  $data['user_access_token']);
                $pageAccessToken = $pageAccessToken->getDecodedBody();
                $pageAccessShortLifeToken = $pageAccessToken['access_token'];

                $params = [
                    'grant_type' => 'fb_exchange_token',
                    'client_id' => Config::get('apikeys.FACEBOOK_APP_ID'),
                    'client_secret' => Config::get('apikeys.FACEBOOK_APP_SECRET'),
                    'fb_exchange_token' => $pageAccessShortLifeToken,
                ];


                $longTimeAccessToken = $this->fb->post('/oauth/access_token', $params,  $data['user_access_token']);
                $longTimeAccessToken = $longTimeAccessToken->getDecodedBody();
                if ($request->hasFile('video_file'))
                {
                    foreach ($request->video_file as $file)
                    {

                        $postVideoFeed = $this->fb->post('/' . $data['page_id'] . '/videos', ['source' => $this->fb->videoToUpload($file), 'description'=> $post_message],  $longTimeAccessToken['access_token']);

                        $postVideoFeed = $postVideoFeed->getDecodedBody();

                        $videoIdArray[] = $postVideoFeed['id'];

                    }}

                return $this->helpReturn('Video is successfully added', $postVideoFeed);

            }

            else {
                return $this->helpError(2, 'Post Message cannot be empty');
            }
        }

        catch (FacebookResponseException $e) {
            Log::info(" FacebookResponseException > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again. Record not found.');
        }
        catch (FacebookOtherException $e) {
            Log::info(" FacebookOtherException > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again. Record not found.');
        }
        catch (FacebookSDKException $e) {
            Log::info(" FacebookSDKException > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again. Record not found.');
        }
        catch (Exception $e) {
            Log::info($e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again. Record not found.');
        }
    }

    // only used for facebook demo permission purpose

    public function postSocialMediaDemo($request){

        try {

            $businessObj = new BusinessEntity();
            $checkPoint = $this->setCurrentUser($request->get('token'))->userAllow();

            if ($checkPoint['_metadata']['outcomeCode'] != 200) {
                return $checkPoint;
            }

            $user = $checkPoint['records'];
            $businessResult = $businessObj->userSelectedBusiness($user);

            if ($businessResult['_metadata']['outcomeCode'] != 200) {
                return $this->helpError(1, 'Problem in selection of user business.');
            }

            $socialResult = SocialMediaMaster::select('business_id','name','page_id','page_access_token','access_token')
                ->where('business_id',$businessResult['records']['business_id'])
                ->whereNotNull('page_access_token')
                ->whereNotNull('page_id')
                ->whereNotNull('access_token')
                ->get()->toArray();

            if(empty($socialResult ))
            {
                return $this->helpError(404, 'No Page Found.');
            }

            $data['page_access_token'] = $socialResult[0]['page_access_token'];
            $data['user_access_token'] = $socialResult[0]['access_token'];
            $data['page_id'] = $socialResult[0]['page_id'];

            $post_message = $request->get('message');

            if ($data['user_access_token']  &&  $post_message != '') {

                $pageAccessToken = $this->fb->get('/' .  $data['page_id'] . '?fields=access_token', $data['user_access_token'] );
                $pageAccessToken = $pageAccessToken->getDecodedBody();
                $pageAccessShortLifeToken = $pageAccessToken['access_token'];

                $params = [
                    'grant_type' => 'fb_exchange_token',
                    'client_id' => Config::get('apikeys.FACEBOOK_APP_ID'),
                    'client_secret' => Config::get('apikeys.FACEBOOK_APP_SECRET'),
                    'fb_exchange_token' => $pageAccessShortLifeToken,
                ];

                $postFeedParams=[

                    'message'=> $post_message
                ];
                $longTimeAccessToken = $this->fb->post('/oauth/access_token', $params, $data['user_access_token']);
                $longTimeAccessToken = $longTimeAccessToken->getDecodedBody();

                $pageFeed = $this->fb->post('/' . $data['page_id'] . '/feed', $postFeedParams, $longTimeAccessToken['access_token']);

                $pageFeed = $pageFeed->getDecodedBody();

                return $this->helpReturn('Post successfully added', $pageFeed);

            }


            else {
                return $this->helpError(2, 'Post Message cannot be empty');
            }
        }

        catch (FacebookResponseException $e) {
            Log::info(" FacebookResponseException > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again. Record not found.');
        }
        catch (FacebookOtherException $e) {
            Log::info(" FacebookOtherException > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again. Record not found.');
        }
        catch (FacebookSDKException $e) {
            Log::info(" FacebookSDKException > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again. Record not found.');
        }
        catch (Exception $e) {
            Log::info($e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again. Record not found.');
        }

    }
    // testing function not used anywhere
    public function getFacebookPageDetailTesting($request)
    {
        try {

            $access_token = $request->get('access_token');
            $page_name = $request->get('page_name');

            $page_detail = $request->get('page_detail');
            $page_post = $request->get('page_post');


            if ($access_token == '') {
                return $this->helpError(2, 'Access token is missing');
            }

            if ($page_name == '') {
                return $this->helpError(2, 'Page Name is missing');
            }


            $pageId = $this->fb->get('/' . $page_name . '?fields=id', $access_token);
            $pageId = $pageId->getDecodedBody();


            if ($page_detail != '') {
                $pageBasicDetail = $this->fb->get('/' . $pageId['id'] . '?fields=name,rating_count,fan_count,description,overall_star_rating,website,phone,single_line_address', $access_token);

                $pageBasicDetail = $pageBasicDetail->getDecodedBody();

                //  dd($pageBasicDetail);
                $data['page name'] = !empty($pageBasicDetail['name']) ? $pageBasicDetail['name'] : '';
                $data['page likes'] = !empty($pageBasicDetail['fan_count']) ? $pageBasicDetail['fan_count'] : '';
                $data['page description'] = !empty($pageBasicDetail['description']) ? $pageBasicDetail['description'] : '';
                $data['page website'] = !empty($pageBasicDetail['website']) ? $pageBasicDetail['website'] : '';
                $data['page phone'] = !empty($pageBasicDetail['phone']) ? $pageBasicDetail['phone'] : '';
                $data['page address'] = !empty($pageBasicDetail['single_line_address']) ? $pageBasicDetail['single_line_address'] : '';
                $data['page rating'] = !empty($pageBasicDetail['overall_star_rating']) ? $pageBasicDetail['overall_star_rating'] : '';
                $data['page reviews'] = !empty($pageBasicDetail['rating_count']) ? $pageBasicDetail['rating_count'] : '';

                return $this->helpReturn('Page Detail', $data);

            }

            elseif ($page_post != '') {
                $pageFeed = $this->fb->get('/' . $pageId['id'] . '/feed?fields=id,message,created_time,link,comments,reactions.type(LOVE).limit(0).summary(total_count).as(reactions_love),reactions.type(WOW).limit(0).summary(total_count).as(reactions_wow),reactions.type(HAHA).limit(0).summary(total_count).as(reactions_haha),reactions.type(SAD).limit(0).summary(total_count).as(reactions_sad),reactions.type(LIKE).limit(0).summary(total_count).as(reactions_like),reactions.type(ANGRY).limit(0).summary(total_count).as(reactions_angry)', $access_token);

                $pageFeed = $pageFeed->getDecodedBody();

                $results = array_filter($pageFeed);

                foreach ($results['data'] as $post) {

                    $data['id'] = !empty($post['id']) ? $post['id'] : '';
                    $data[' message'] = !empty($post['message']) ? $post['message'] : '';
                    $data['created_time'] = !empty($post['created_time']) ? $post['created_time'] : '';

                    $post_url = !empty($post['link']) ? $post['link'] : '';

                    if ($post_url != '') {
                        if (strpos($post_url, "photos") != false) {
////
                            $data['link'] = !empty($post['link']) ? $post['link'] : '';
                            $data['Media_Type'] = 'Image';
                        } else {

                            $data['link'] = !empty($post['link']) ? $post['link'] : '';
                            $data['Media_Type'] = 'Video';
                        }
                    }

                    $data['Emotions']['LIKE'] =  !empty( $post['reactions_like']['summary']['total_count']) ? $post['reactions_like']['summary']['total_count'] : '' ;
                    $data['Emotions']['LOVE'] =  !empty( $post['reactions_love']['summary']['total_count']) ? $post['reactions_love']['summary']['total_count'] : '' ;
                    $data['Emotions']['HAHA'] =  !empty( $post['reactions_haha']['summary']['total_count']) ? $post['reactions_haha']['summary']['total_count'] : '' ;
                    //   $data['Emotions']['YAY'] =  !empty( $post['reactions_l']['summary']['total_count']) ? $post['reactions_love']['summary']['total_count'] : '' ;
                    $data['Emotions']['WOW'] =  !empty( $post['reactions_wow']['summary']['total_count']) ? $post['reactions_wow']['summary']['total_count'] : '' ;
                    $data['Emotions']['SAD'] =  !empty( $post['reactions_love']['summary']['total_count']) ? $post['reactions_love']['summary']['total_count'] : '' ;
                    $data['Emotions']['ANGRY'] =  !empty( $post['reactions_angry']['summary']['total_count']) ? $post['reactions_angry']['summary']['total_count'] : '' ;

                    $data['comments'] = !empty($post['comments']['data']) ? $post['comments']['data'] : '';
                    $results[] = $data;

                }
                return $this->helpReturn('Page Detail', $results);
            }

            else

            {
                return $this->helpError(2, 'Either Page Post or Page Feed Request is Required');

            }

        }

        catch (FacebookResponseException $e) {
            Log::info(" FacebookResponseException > " . $e->getMessage());
            return $this->helpError(1, 'Record not found.');
        }
        catch (FacebookOtherException $e) {
            Log::info(" FacebookOtherException > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again. Record not found.');
        }
        catch (FacebookSDKException $e) {
            Log::info(" FacebookSDKException > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again. Record not found.');
        }
        catch (Exception $e) {
            Log::info($e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again. Record not found.');
        }

    }


    // testing function not used anywhere
    public function getFacebookAccountDetailTesting($request)
    {
        try {

            $access_token = $request->get('access_token');
            $page_id = $request->get('page_id');
            if ($access_token == '') {
                return $this->helpError(2, 'Access token is missing');
            }

            if ($page_id == '') {
                return $this->helpError(2, 'Page Name is missing');
            }

            $AccountName = $this->fb->get('/' . $page_id . '?fields=name', $access_token);
            $AccountName = $AccountName->getDecodedBody();

            $AccountPicture= $this->fb->get('/' . $page_id . '/picture?type=large&redirect=false', $access_token);
            $AccountPicture = $AccountPicture->getDecodedBody();

            $data['Account Id'] = !empty($AccountName['id']) ? $AccountName['id'] : '';
            $data['Account Name'] = !empty($AccountName['name']) ? $AccountName['name'] : '';
            $data['Account Picture'] = !empty($AccountPicture['data']['url']) ? $AccountPicture['data']['url'] : '';


            return $this->helpReturn('Facebook Account Detail', $data);
        }

        catch (FacebookResponseException $e) {
            Log::info(" FacebookResponseException > " . $e->getMessage());
            return $this->helpError(1, 'Record not found.');
        }
        catch (FacebookOtherException $e) {
            Log::info(" FacebookOtherException > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again. Record not found.');
        }
        catch (FacebookSDKException $e) {
            Log::info(" FacebookSDKException > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again. Record not found.');
        }
        catch (Exception $e) {
            Log::info($e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again. Record not found.');
        }
    }

    public function nextPosts($limit = 3, $after = '')
    {
        $data = [];
        $data['page_id'] = '271500120153293';
        $data['user_access_token'] = 'EAARVtl7mZAdoBALFKaWcjt6mnJZASMv06zrxrcaZCr4QZCZBehZB1nl7Ib6TJp1cb2uGER1OqBrWYUxqH8DhgRq8iZB9GBv3spftOHamzQLZBYA8HrpaR8tpcMqaxTctxMKHRnGyZCq89VnZBRccz5qtYyvMBLYiVjlumrQtVpQUlckAZDZD';
        $data['page_access_token'] = 'EAARVtl7mZAdoBAG3qvLIQKzFazehxgQOGNtY72NvRVbcHoZBX4Es8C2X73DQZAwZCLBTaybjbAp8kLY20a9r2UavDicYT89dxQgEWIqgi5XQU6OBKEqDIKBAjgis5dR1iwhBXvOz6P5PJIghM4kC08ZBB1d91lYkQKkpk3pFkJf93DH9sv1jo';
        $pageAccessToken = $this->fb->get('/' . $data['page_id'] . '?fields=access_token', $data['user_access_token']);
        $pageAccessToken = $pageAccessToken->getDecodedBody();
        $pageAccessShortLifeToken = $pageAccessToken['access_token'];

                $params = [
                    'grant_type' => 'fb_exchange_token',
                    'client_id' => Config::get('apikeys.FACEBOOK_APP_ID'),
                    'client_secret' => Config::get('apikeys.FACEBOOK_APP_SECRET'),
                    'fb_exchange_token' => $pageAccessShortLifeToken,
                ];

                $longTimeAccessToken = $this->fb->post('/oauth/access_token', $params, $data['user_access_token']);
                $longTimeAccessToken = $longTimeAccessToken->getDecodedBody();

        $pageFeed = $this->fb->get('/' . $data['page_id'] . '/feed?limit=3', $longTimeAccessToken['access_token']);
        $pageFeed = $pageFeed->getDecodedBody();

//        Log::info('$pageFeed');
//        Log::info($pageFeed);
        foreach ($pageFeed['data'] as $postdetail) {

            $postId = $postdetail['id'];
            $postIds = $this->fb->get('/' . $postId . '?fields=id', $data['page_access_token']);
            //  $postDetail = $this->fb->get('/' . '2274976966065498_2340631602833367' . '?fields=id,message,attachments{media,subattachments}', $data['page_access_token']);
            $postIds = $postIds->getDecodedBody();

            $postIdArray[] = $postIds['id'];
        }

//        Log::info('$postIdArray');
//        Log::info($postIdArray);
        $weekly_array = [];
        $i = 1;
        $postresult = [];
        $postresult['after'] =  $pageFeed['paging']['cursors']['after'];
        $currentDate = '';
        $time = '';
        foreach ($postIdArray as $postdata) {

          //  echo $k, ' = ', $postdata, '<br />', PHP_EOL;

            $postDetail = $this->fb->get('/' . $postdata . '?fields=id,message,created_time,permalink_url,attachments{media,subattachments,title},likes.summary(true),comments.summary(true)', $data['page_access_token']);
            $postDetail = $postDetail->getDecodedBody();
            !empty($postDetail['created_time']) ? $postDate = $postDetail['created_time'] : '';
            if(!empty($postDate)) {
                $carbon = new \Carbon\Carbon();
                $date = $carbon->createFromTimestamp(strtotime($postDate),'EST');
                $currentDate =  $date->format('Y-m-d');
                $time =  $date->format('Y-m-d h:i:s');
            }


            $result['post_id'] = !empty($postDetail['id']) ? $postDetail['id'] : '';
            $result['post_message'] = !empty($postDetail['message']) ? $postDetail['message'] : '';
            $result['post_time'] = !empty($time) ? $time : '';
            $result['post_url'] = !empty($postDetail['permalink_url']) ? $postDetail['permalink_url'] : '';
            $result['post_likes'] = !empty($postDetail['likes']['summary']['total_count']) ? $postDetail['likes']['summary']['total_count'] : '';
            $result['post_comments'] = !empty($postDetail['comments']['summary']['total_count']) ? $postDetail['comments']['summary']['total_count'] : '';
            $result['post_image'] = !empty($postDetail['attachments']['data'][0]['media']['image']['src']) ? $postDetail['attachments']['data'][0]['media']['image']['src'] : '';
            $result['post_multiple_images'] = !empty($postDetail['attachments']['data'][0]['subattachments']['data']) ? $postDetail['attachments']['data'][0]['subattachments']['data'] : '';
            $result['post_video'] = !empty($postDetail['attachments']['data'][0]['media']['source']) ? $postDetail['attachments']['data'][0]['media']['source'] : '';

            if (isset($data['screen']) && $data['screen'] == 'mobile') {
                $postresult[] = $result;
            }else{

                if (in_array($currentDate, $weekly_array)) {
                    $postresult[$currentDate][] = $result;

                } else {
                    $postresult[$currentDate][0] = $result;

                }

                array_push($weekly_array, $currentDate);
                $result = [];
            }
        }
        return $postresult;
    }

}
