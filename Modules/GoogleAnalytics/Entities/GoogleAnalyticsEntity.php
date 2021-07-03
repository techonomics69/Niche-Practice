<?php

namespace Modules\GoogleAnalytics\Entities;

use App\Entities\AbstractEntity;
use App\Services\SessionService;
use App\Traits\UserAccess;
use Modules\GoogleAnalytics\Models\GoogleAnalyticsMaster;
use Modules\Business\Entities\BusinessEntity;
use Modules\ThirdParty\Entities\DashboardEntity;
use Modules\ThirdParty\Models\StatTracking;
use Socialite;
use Google_Client;
use Google_Service_People;
use Request;
use DB;
use Config;
use Log;
use Exception;
use Modules\GoogleAnalytics\Entities\Google;
use Google_Service_Analytics;
use Google_Service_Drive;
use GuzzleHttp;
use Carbon\Carbon;
use Analytics;

class GoogleAnalyticsEntity extends AbstractEntity
{
    use UserAccess;

    protected $googleAnalyticsEntity;

    protected $businessEntity;

    protected $sessionService;

    public function __construct()
    {
        $this->sessionService = new SessionService();
    }

    function getLogin($request)
    {
//        Log::info('google analytics testing');
//        Log::info($request);
//        &client_secret=2JbNnX3Tqz0yy_0ZBVSjNoav
        /////////////////////////////////////////////////////////////
//        /////////////////////old netblaze client id///////////////
        /////////////////////////////////////////////////////////////
//        return redirect('https://accounts.google.com/o/oauth2/auth?client_id=768410942916-5oap60en0v2lib3ehth5eerr8f31j4fu.apps.googleusercontent.com&redirect_uri=' . config::get('apikeys.CallBack') . '&scope=https://www.googleapis.com/auth/analytics&response_type=code&approval_prompt=force&access_type=offline');
//         /////////////////////////////////////////////////////////////
////        /////////////////////niche staging and live client id///////////////
//        /////////////////////////////////////////////////////////////
//        return redirect('https://accounts.google.com/o/oauth2/auth?client_id=282094427801-8bkscb0tgc3o6282sl3425mg88eij1g1.apps.googleusercontent.com&redirect_uri=' . config::get('apikeys.CallBack') . '&scope=https://www.googleapis.com/auth/analytics&response_type=code&approval_prompt=force&access_type=offline');

//        //////////////////////////////////////////////////////////
//        /////////////////Localhost client id//////////////////////
//        //////////////////////////////////////////////////////////
//        log::info('apikeys.CallBack');
//        log::info(config::get('apikeys.CallBack'));
//        return redirect('https://accounts.google.com/o/oauth2/auth?client_id=768410942916-5oap60en0v2lib3ehth5eerr8f31j4fu.apps.googleusercontent.com&redirect_uri=' . config::get('apikeys.CallBack') . '&scope=https://www.googleapis.com/auth/analytics&response_type=code&approval_prompt=force&access_type=offline');
        return redirect('https://accounts.google.com/o/oauth2/auth?client_id=282094427801-8bkscb0tgc3o6282sl3425mg88eij1g1.apps.googleusercontent.com&redirect_uri=' . config::get('apikeys.CallBack') . '&scope=https://www.googleapis.com/auth/analytics&response_type=code&approval_prompt=force&access_type=offline');
    }

    /**
     * @param $request
     * @return mixed|string
     */
    public function getAccessToken($request)
    {
        try
        {
            $webAppDomain = getDomain();

            $client = new Google_Client();
//            $client->setAuthConfig(public_path('/client_secret_768410942916-5oap60en0v2lib3ehth5eerr8f31j4fu.apps.googleusercontent.com.json'));
//            $client->setAuthConfig(public_path('/client_secret_768410942916-5oap60en0v2lib3ehth5eerr8f31j4fu.apps.googleusercontent.com.json'));
            $client->setAuthConfig(public_path('/client_secret_282094427801-8bkscb0tgc3o6282sl3425mg88eij1g1.apps.googleusercontent.com.json'));
//            log::info('client');
//            log::info($client);
            $client->setApplicationName("Hello Analytics Reportings");

            if(isset($request['error']))
            {
                $url = $webAppDomain;
                return $url;
            }

            $client->addScope('https://www.googleapis.com/auth/analytics.manage.users');
            //$client->setAccessType('offline');
            $client->setIncludeGrantedScopes(true);   // incremental auth

            $client->setRedirectUri(config::get('apikeys.CallBack'));

            // $client->setApprovalPrompt ("force");
            $client->setApprovalPrompt('consent');

            $client->fetchAccessTokenWithAuthCode($request['code']);

            $webAppDomain = getDomain();

            $url = $webAppDomain;

            $refresh_token = $client->getAccessToken()['refresh_token'];
            if (!empty($refresh_token))
            {
                $url .= '?accessToken=' . $refresh_token . '&type=googleanalytics';
//                log::info('$url');
//                log::info($url);
                return $url;
            }

        }
        catch (Exception $e)
        {
            Log::info($e->getMessage());
            return $this->helpError(1, 'Some Problem happened.');
        }

    }

    /**
     * @param token, refresh_token
     * @return mixed
     */
    function getAccounts($request)
    {
        try
        {

//            $businessObj = new BusinessEntity();
//            $checkPoint = $this->setCurrentUser($request->get('token'))->userAllow();

            // user is not found.
//            if ($checkPoint['_metadata']['outcomeCode'] != 200)
//            {
//                return $checkPoint;
//            }
//            $user = $checkPoint['records'];
//            $businessResult = $businessObj->userSelectedBusiness($user);
            $businessResult = $this->sessionService->getAuthUserSession();
//            log::info('$businessResult var');
//            log::info($businessResult);

//            if ($businessResult['_metadata']['outcomeCode'] != 200)
//            {
//                return $this->helpError(1, 'Problem in selection of user busienss.');
//            }

            $businessId = $businessResult['business'][0]['business_id'];
//            log::info('$businessId');
//            log::info($businessId);
//            exit;
            $client = new Google_Client();

            // Get the list of accounts for the authorized user.
            $tokenDetails = $this->exchangeRefreshToken($request->refresh_token);
//            log::info('$tokenDetails');
//            log::info($tokenDetails);
            if(!empty($tokenDetails['access_token'])){
                $client->setAccessToken($tokenDetails['access_token']);

                try {
                    $analytics = new Google_Service_Analytics($client);
                    $accounts = $analytics->management_accounts->listManagementAccounts();
                }
                catch (Exception $e) {
                    return $this->helpError(404, 'User does not have any Google Analytics account.');
                }

                if (count($accounts->getItems()) > 0)
                {
                    $items = $accounts->getItems();

                    foreach ($items as $item)
                    {
                        $accountAppendArray[] = [
                            'id' => $item->id,
                            'name' => $item->name,
                            'refresh_token' => $request->refresh_token,
                        ];
                    }

                    return $this->helpReturn("Google Analytics account listing.", $accountAppendArray);
                }
                else
                {
                    return $this->helpError(404, 'User does not have any Google Analytics account.');
                }
            }
            else
            {
                return $this->helpError(3, 'Access token is required.');
            }

        }
        catch (Exception $e)
        {
            Log::info($e->getMessage());
            return $this->helpError(1, 'Some Problem happened.');
        }

    }

    /**
     * @param account_id, refresh_token , token
     * @return all websites that belong to specific account
     */
    function getWebProperties($request)
    {
//        log::info('getWebProperties');
//        log::info($request);
        try
        {
            $currentDate = Carbon::now()->subMonth(1);
            $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate)->format('Y-m-d');

//            $businessObj = new BusinessEntity();
            $businessObj = $this->sessionService->getAuthUserSession();
//            $checkPoint = $this->setCurrentUser($request->get('token'))->userAllow();
//            $checkPoint = $this->setCurrentUser($request->get('refresh_token'))->userAllow();
//            log::info('$checkPoint');
//            log::info($checkPoint);
            // user is not found.
//            if ($checkPoint['_metadata']['outcomeCode'] != 200) {
//                return $checkPoint;
//            }
//            $user = $checkPoint['records'];
//            $businessResult = $businessObj->userSelectedBusiness($user);

//            if ($businessResult['_metadata']['outcomeCode'] != 200)
//            {
//                return $this->helpError(1, 'Problem in selection of user business.');
//            }
            $businessId = $businessObj['business'][0]['business_id'];

            if (!isset($request->acount_id))
            {
                return $this->helpError(3, 'Account Id Required.');
            }

            if (isset($request->refresh_token) && !empty($request->refresh_token))
            {
                $tokenDetails = $this->exchangeRefreshToken($request->refresh_token);  //get access token

                $http = new \GuzzleHttp\Client;
                $response = $http->request('GET', 'https://www.googleapis.com/analytics/v3/management/accounts/' . $request->acount_id . '/webproperties', [
                    'query' => ['access_token' => $tokenDetails['access_token']]
                ]);
//                log::info('getWebProperties $response');
//                log::info(json_decode((string)$response->getBody(), true));
                if (!empty($response))
                {
                    $response = json_decode((string)$response->getBody(), true);

                    foreach ($response['items'] as $item)
                    {
                        if(!isset($item['defaultProfileId'])){

                        }
                        else
                        {
                            $propertyAppendArray[] = [
                                'view_id' => $item['defaultProfileId'],
                                'name' => $item['name'],
                                'website' => $item['websiteUrl'],
                            ];
                        }
                    }

                    if(empty($propertyAppendArray))
                    {
                        return $this->helpError(404, 'No Website found of this Google Analytics Account.');
                    }

                    return $this->helpReturn("Website listing.", $propertyAppendArray);
                }
                else
                {
                    return $this->helpError(404, 'No Website found for this user.');
                }
            }
            else
            {
                return $this->helpError(3, 'Access token required.');
            }
        }
        catch (Exception $e)
        {
            Log::info($e->getMessage());
            return $this->helpError(1, 'Some Problem happened.');
        }

    }

    /**
     * @param refresh_token,view_id,token,name,website
     * @return all views of specific website
     */
    public function getProfileViews($request)
    {
//        log::info('getProfileViews $request');
//        log::info($request);
        try
        {
            $currentDate = Carbon::now()->subMonth(1);
            $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate)->format('Y-m-d');



//            $businessObj = new BusinessEntity();

            $businessObj = $this->sessionService->getAuthUserSession();

//            $checkPoint = $this->setCurrentUser($request->get('token'))->userAllow();

            // user is not found.
//            if ($checkPoint['_metadata']['outcomeCode'] != 200)
//            {
//                return $checkPoint;
//            }
//            $user = $checkPoint['records'];

//            $businessResult = $businessObj->userSelectedBusiness($user);

//            if ($businessResult['_metadata']['outcomeCode'] != 200)
//            {
//                return $this->helpError(1, 'Problem in selection of user business.');
//            }
//
//            $businessId = $businessResult['records']['business_id'];
//            $businessWebsite = $businessResult['records']['website'];
            $userId = $businessObj['id'];
            $businessId = $businessObj['business'][0]['business_id'];
            $businessWebsite = $businessObj['business'][0]['website'];

            if(empty($businessWebsite))
            {
                return $this->helpError(403, 'Website not setup in your business.');
            }

            if (!isset($request->view_id))
            {
                return $this->helpError(3, 'View Id required.');
            }
            if (!isset($request->refresh_token)) {
                return $this->helpError(3, 'Access token required.');
            }

            if (!isset($request->name))
            {
                return $this->helpError(3, 'Name required.');
            }

            if (!isset($request->website))
            {
                return $this->helpError(3, 'Website required.');
            }

            $tokenDetails = $this->exchangeRefreshToken($request->refresh_token);  //get access token
            if (empty($tokenDetails))
            {
                return $this->helpError(3, 'Access token required Please try again.');
            }

            $http = new \GuzzleHttp\Client;
            $response = $http->request('GET', 'https://www.googleapis.com/analytics/v3/data/ga', [
                'query' => ['access_token' => $tokenDetails['access_token'], 'ids' => 'ga:' . $request->view_id, 'start-date' => $formatedDate, 'end-date' => 'today', 'metrics' => 'ga:pageviews', 'dimensions' => 'ga:date']

            ]);
//            log::info('getProfileViews $response');
//            log::info(json_decode((string)$response->getBody(), true));
//            exit();
            if (!empty($response))
            {
                $response = json_decode((string)$response->getBody(), true);

                $masterAppendArray = [
                    'business_id' => $businessId,
                    'access_token' => $request->refresh_token,
                    'profile_id' => $request->view_id,
                    'name' => $request->name,
                    'website' => $request->website,
                    'type' => 'GoogleAnalytics',
                ];

                $googleAnalyticsId = GoogleAnalyticsMaster::create($masterAppendArray);
                foreach ($response['rows'] as $item)
                {
                    $t = strtotime($item['0']);
                    $activity_date = date('Y-m-d', $t);
                    $viewsAppendArray[] = [
                        'user_id' => $userId,
                        'google_analytics_id' => $googleAnalyticsId->id,
                        'type' => 'PV',
                        'site_type' => 'Googleanalytics',
                        'activity_date' => $activity_date,
                        'count' => $item['1'],
                    ];
                }

                StatTracking::insert($viewsAppendArray);
                log::info('viewsAppendArray + viewsAppendArray');
                $websiteGoogleAnalytics = $request->website;
                $types =
                    [
                        'category_type'=> 'PV',
                        'type' => 'google-analytics',
                        'is_type' => 'all'
                    ];
                $request->merge($types);
                $dashboardEntity = new DashboardEntity();
                $response  = $dashboardEntity->getGraphStatsCount($request);
                $insightStatus = $response['records'][0]['insightStatus'];
                $insightTitle = $response['records'][0]['insightTitle'];

                $websiteName =array(
                    'websiteGoogleAnalytics' => $websiteGoogleAnalytics,
                    'insightStatus' => $insightStatus,
                    'insightTitle' => $insightTitle
                );
                $appendedArray = array_merge($viewsAppendArray, $websiteName);

//                log::info('$appendedArray');
//                log::info($appendedArray);
//                return $this->helpReturn("Views Result.", $viewsAppendArray);
                return $this->helpReturn("Views Result.", $appendedArray);
            }
            else
            {
                return $this->helpError(3, 'No Website found for this user.');
            }
        }
        catch (Exception $e)
        {
            Log::info($e->getMessage());
            return $this->helpError(1, 'Some Problem happened.');
        }

    }

    /**
     * @param refresh_token
     * @return access_token return
     */
    function exchangeRefreshToken($token)
    {
        try
        {
//            log::info('$token');
//            log::info($token);
            if (isset($token) && !empty($token))
            {
//                log::info('$token');
//                log::info($token);
//                exit;
                $http = new \GuzzleHttp\Client;
                $response = $http->request('POST', 'https://accounts.google.com/o/oauth2/token', [
                    'form_params' => [
                        'grant_type' => 'refresh_token',
//                        'client_id' => '768410942916-5oap60en0v2lib3ehth5eerr8f31j4fu.apps.googleusercontent.com',
                        'client_id' => '282094427801-8bkscb0tgc3o6282sl3425mg88eij1g1.apps.googleusercontent.com',
//                        'client_secret' => 'Qzakldnw0xHQKuI0m5N6cU4p',
                        'client_secret' => '2JbNnX3Tqz0yy_0ZBVSjNoav',
                        'refresh_token' => $token,
                    ]
                ]);
//                log::info('client analytics');
//                log::info('$response');
                if (!empty($response))
                {
                    $response = json_decode((string)$response->getBody(), true);
                    return $response;
                }
                else
                {
                    return $this->helpError(3, 'No Website found for this user.');
                }
            }
            else
            {
                return $this->helpError(3, 'Refresh Token Required.');
            }

        }
        catch (Exception $e)
        {
            Log::info($e->getMessage());
            return $this->helpError(1, 'Some Problem happened.');
        }

    }

    /**
     * @param $id
     * @param token
     * @return remove all record of google analytics and state tracking
     */
    function removeGoogleAnalytics($id)
    {
        try
        {
            $analyticsResult = GoogleAnalyticsMaster::where('business_id', $id)
                ->select('id')->first();

            if(!empty($analyticsResult['id']))
            {
                StatTracking::where('google_analytics_id', $analyticsResult['id'])->delete();

                GoogleAnalyticsMaster::where('id', $analyticsResult['id'])->delete();

                return $this->helpReturn("Delete Successfully");
            }
            return $this->helpError(3, 'No Access of this action.');
        }
        catch (Exception $e)
        {
            Log::info($e->getMessage());
            return $this->helpError(1, 'Some Problem happened.');
        }

    }

    public function getProfileViewsCronJob($request)
    {
        try
        {
            $currentDate = Carbon::now()->subMonth(1);
            $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate)->format('Y-m-d');
            $googleAnalytics = GoogleAnalyticsMaster::select('id', 'access_token', 'profile_id')->where('access_token', '!=', null)->where('profile_id', '!=', null);
            $data = $googleAnalytics->get();

            $viewsAppendArray = [];
            $googleAnalyticsIds = [];

            foreach ($data as $row)
            {
                try
                {
                    $tokenDetails = $this->exchangeRefreshToken($row['access_token']);  //get access token
                    $http = new \GuzzleHttp\Client;
                    $response = $http->request('GET', 'https://www.googleapis.com/analytics/v3/data/ga', [
                        'query' => ['access_token' => $tokenDetails['access_token'], 'ids' => 'ga:' . $row['profile_id'], 'start-date' => $formatedDate, 'end-date' => 'today', 'metrics' => 'ga:pageviews', 'dimensions' => 'ga:date']

                    ]);

                    $response = json_decode((string)$response->getBody(), true);

                    foreach ($response['rows'] as $item)
                    {
                        $t = strtotime($item['0']);
                        $activity_date = date('Y-m-d', $t);
                        $viewsAppendArray[] = [
                            'google_analytics_id' => $row['id'],
                            'type' => 'PV',
                            'site_type' => 'Googleanalytics',
                            'activity_date' => $activity_date,
                            'count' => $item['1'],
                        ];

                        $googleAnalyticsIds[] = [
                            'id' => $row['id'],
                        ];
                    }
                }
                catch (Exception $e)
                {
                    Log::info($row['id']);
                    Log::info($e->getMessage());
                }
            }

            if (!empty($viewsAppendArray) && !empty($googleAnalyticsIds))
            {
                StatTracking::whereIn('google_analytics_id', $googleAnalyticsIds)->delete();
                StatTracking::insert($viewsAppendArray);
            }

            return $this->helpReturn("Google Analytics Stats update successfully");

        }
        catch (Exception $e)
        {
            Log::info(" getProfileViewsCronJob > " . $e->getMessage());
            return $this->helpError(1, 'Some Problem happened.');
        }

    }
//    public function getData(Request $request) {
//
//        $token = $this->sessionService->getAuthTokenSession();
//        log::info('$token $token $token');
//        log::info($token);
//        if($request->get('accessToken')) {
//            $socialToken = $this->sessionService->getOAuthToken()->toArray();
//            $this->data['refresh_token'] = $socialToken['analyticsAccessToken'];
//            $this->data['token'] = $token;
//
//            // $requestType = 'accounts';
//            $urlAction = 'google-analytics/get-accounts';
//
//            if( $request->has('id') )
//            {
//                Log::info("id");
//                // $requestType =  Get account properties
//                $urlAction = 'google-analytics/get-web-property';
//                $data['account_id'] = $request->get('id');
//            }
//            elseif ( $request->has('view_id') )
//            {
//                Log::info("view_id ");
//                // Get website page views
//                $urlAction = 'google-analytics/get-profile-view';
//                $data['view_id'] = $request->get('view_id');
//                $data['name'] = $request->get('name');
//                $data['website'] = $request->get('website');
//            }
//        }
//        return $this->helpReturn('data got');
//    }
}
