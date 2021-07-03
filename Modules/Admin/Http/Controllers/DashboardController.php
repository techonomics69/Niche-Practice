<?php

namespace Modules\Admin\Http\Controllers;
use App\Services\SessionService;
use App\Traits\UserAccess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Log;
use Modules\Admin\Entities\AdminEntity;
use Modules\Business\Entities\BusinessEntity;
use Modules\Business\Entities\WebsiteEntity;
use Modules\Business\Http\Controllers\HomeController;
use Modules\ThirdParty\Entities\SocialEntity;
use Modules\ThirdParty\Entities\ThirdPartyEntity;
use Modules\ThirdParty\Models\TripadvisorMaster;
use Modules\ThirdParty\Models\TripadvisorReview;
use Modules\User\Models\CreditsHistory;
use Modules\User\Models\Subscription;
use Modules\User\Models\Users;
use Redirect;
use Exception;
use Carbon\Carbon;
use DB;

class DashboardController extends Controller
{
    use UserAccess;
    protected $data = []; // the information we send to the view

    protected $sessionService = '';

    protected $adminEntity = '';


    public function __construct()
    {
        $this->sessionService = new SessionService();
        $this->adminEntity = new AdminEntity();
        $this->homeController = new HomeController();
        $this->thirdPartyEntity = new ThirdPartyEntity();
        $this->businessEntity = new BusinessEntity();
    }


    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function dashboard(Request $request)
    {
        $userData = $this->sessionService->getAdminUserSession();


//        dd($userData);
        $this->data['pageTitle'] = 'Dashboard';
        $this->data['userData'] = $userData;
//        print_r($userData);
//        exit();

        $users = $this->adminEntity->index();

        $this->data['records'] = '';
        if ($users['_metadata']['outcomeCode'] == 200) {
            $this->data['records'] = $users['records'];
        }
//        $cont = $this->homeController->home($request);
//        log::info('cont');
//        log::info($cont);

//        $called = $this->homeController->home($request);


        $timer = Carbon::now();
        log::info('time');
//        log::info($timer);

        $time = [];
        $totalDuration = [];
        $countRecords = count($users['records']);
        $reviews = [];
        $negativeFeedback = [];
        $businessLogo = [];
        $socialMedia = [];
        $scanResult = [];
        $businessResults = [];

        $webDomain = [];
//        Log::info($countRecords);
        $socialEntity = new SocialEntity();
        for ($i = 0; $i < $countRecords; $i++) {

            if (!empty($users['records'][$i]['online_time'])) {
                $userTime = $users['records'][$i]['online_time'];
                $totalDuration[$i] = $timer->diffInSeconds($userTime);
            } else {
                $totalDuration[$i] = '';
            }

            $type = 'all';
            if (!empty($users['records'][$i]['business'][0]['business_id'])) {
                $reviews[$i] = $this->thirdPartyEntity->thirdPartyReviews('', $users['records'][$i]['business'][0]['business_id'], $type);
            } else {
                $reviews[$i] = [];
            }

//            Log::info('reviews');
//            Log::info($this->data['reviewsResult']);

            $negativeReviews = $this->thirdPartyEntity->getNegativeFeedback($users['records'][$i]['id']);

            if ($negativeReviews['_metadata']['outcomeCode'] == 200) {
                $negativeFeedback[$i] = $negativeReviews['records'];
            }
            $businessResult = $this->businessEntity->userSelectedBusiness('', $users['records'][$i]['id']);
//            log::info('businessResult');
//            log::info($businessResult);
            $businessLogo[$i] = $businessResult;
            $socialRequestData = [
                'businessResult' => $businessResult,
                'social_module_list' => 'all'
            ];

            $socialMediaPostsDataResponseData = $socialEntity->getSocialMediaPosts($socialRequestData);

//            $this->data['socialMediaPostsData'] = [];

            if ($socialMediaPostsDataResponseData['_metadata']['outcomeCode'] == 200) {
                $socialMedia[$i] = $socialMediaPostsDataResponseData['records'];
            }

//            $ob = new BusinessEntity();
//            $businessData = $ob->businessDirectoryList('','', $businessResult);


//            $userBusiness = $businessData['records']['userBusiness'];
//            $scanResult[$i] = $businessData['records']['businessIssues'];
//            $businessResults[$i] = $userBusiness;
//            Log::info('userBusiness');
//            Log::info($userBusiness);
            if (!empty($businessResult['records']['website'])) {
//                Log::info('webResult');
                $webObj = new WebsiteEntity();

                $webResult = $webObj->trackWebsiteStatus($request, true, $businessResult);
//            Log::info('webResult');
//            Log::info($webResult);
//                if($webResult['_metadata']['outcomeCode'] == 200)
//                {
//                    $this->data['webResult'] = $webResult['records'];
                $webDomain[$i] = $webResult['records'];
            }
        }
        for ($j = 0; $j < $countRecords; $j++) {
            if ( !empty($totalDuration[$j]) && $totalDuration[$j] <120) {
                $time[$j] = 'active';
            }
            else {
                $time[$j] = 'not-active';
            }
        }
        $subscriptionCount = 0;
        $creditsSum = 0;
        $billingToday = 0;
        $totalCampaignPurchased = 0;
        $freeTrials = 0;
//        $resultSubs = Subscription::count();
//        $resultSubs = Users::with('subscriptions')->whereNull('deleted_at')->count();

        //        print_r($user_issues_list);
//        $objectToArray = (string)$resultSubs;
//        $result = json_decode($objectToArray);

        $resultSubs = DB::select(('SELECT COUNT(us.id) as counted FROM users as us INNER JOIN subscriptions as sb on us.id = sb.users_id WHERE ISNULL(deleted_at)'));
        $resultFreeTrials = DB::select(('SELECT COUNT(us.id) as countedFreeTrials from users as us LEFT JOIN subscriptions as sb ON us.id = sb.users_id   WHERE ISNULL(sb.users_id) and ISNULL(deleted_at) and ISNULL(admin_panel_user);'));
//        $resultSubs = DB::select(('SELECT COUNT(us.id) as counted FROM users as us INNER JOIN subscriptions as sb on us.id = sb.users_id WHERE ISNULL(deleted_at)'));
//        SELECT count(*) from users as us LEFT JOIN subscriptions as sb ON us.id = sb.users_id   WHERE ISNULL(sb.users_id) and ISNULL(deleted_at) and ISNULL(admin_panel_user);
//        SELECT count(*) from users as us LEFT JOIN subscriptions as sb ON us.id = sb.users_id WHERE ISNULL(sb.users_id) and ISNULL(deleted_at) and ISNULL(card_last_four);
//        $resultSubs1 = DB::select(('SELECT COUNT(us.id) as counted FROM users as us INNER JOIN subscriptions as sb on us.id != sb.users_id WHERE ISNULL(deleted_at)'));

//        print_r($resultSubs1[0]->counted);
////        print_r($result );
//        exit();
        if(checkValue($resultSubs)) {
            $subscriptionCount = $resultSubs[0]->counted;
        }
        if(checkValue($resultSubs)) {
            $freeTrials = $resultFreeTrials[0]->countedFreeTrials;
        }

        $resultCredits = CreditsHistory::sum('credits');
        if(checkValue($resultCredits)) {
            $creditsSum = $resultCredits;
        }

        $resultBillingToday = Subscription::where('created_at', '>=', Carbon::now()->subDay()->toDateTimeString())->count();
        if(checkValue($resultBillingToday)) {
            $billingToday = $resultBillingToday;
        }

        $resultTotalCampaignPurchased = CreditsHistory::where('module_used_credits', '=', 'user_task_category')->count();
        if(checkValue($resultTotalCampaignPurchased)) {
            $totalCampaignPurchased = $resultTotalCampaignPurchased;
        }



//        print_r($resultTotalCampaignPurchased);
//        exit();
        $this->data['subscriptionCount'] = $subscriptionCount;
        $this->data['creditsSum'] = $creditsSum;
        $this->data['BillingToday'] = $billingToday;
        $this->data['totalCampaignPurchased'] = $totalCampaignPurchased;
        $this->data['freeTrials'] = $freeTrials;


//        Log::info('totalDuration');
//        Log::info($totalDuration);
//
//        Log::info('this data');
//        Log::info($time);


        $this->data['reviews'] = $reviews;
        $this->data['negativeReviews'] = $negativeFeedback;
        $this->data['businessLogo'] = $businessLogo;
        $this->data['socialMedia'] = $socialMedia;
        $this->data['webDomain'] = $webDomain;
        $this->data['online'] = $time;


        return view('admin.dashboard', $this->data);
    }

}
