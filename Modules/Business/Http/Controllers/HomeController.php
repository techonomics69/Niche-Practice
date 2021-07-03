<?php

namespace Modules\Business\Http\Controllers;

use App\Mail\NotificationSendToReferer;
use App\Mail\NotifyNewReview;
use Log;
use Mail;
use DB;
use Modules\Admin\Models\Category;
use Modules\Admin\Models\UserTaskCategory;
use Modules\Business\Models\BusinessCitationList;
use Modules\Business\Models\PromotionTemplate;
use Modules\Business\Models\PromotionTemplatePlan;
use Modules\Business\Models\UnsubscribeList;
use Modules\Business\Models\UserBusinessCitationList;
use Modules\GoogleAnalytics\Models\GoogleAnalyticsMaster;
use Modules\ThirdParty\Entities\DashboardEntity;
use Modules\ThirdParty\Entities\SocialEntity;
use Modules\ThirdParty\Models\TripadvisorReview;
use Modules\User\Entities\Billing\SubscriptionManagerEntity;
use Modules\User\Models\UserMeta;
use Modules\User\Models\Subscription;
use Storage;
use Exception;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Traits\ApiServer;
use App\Mail\EmailForInvite;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Models\Task;
use Modules\User\Models\Users;
use App\Mail\NotifyAdminNewUser;
use App\Services\SessionService;
use Illuminate\Routing\Controller;
use Modules\CRM\Entities\CRMEntity;
use Modules\Business\Models\Domains;
use Modules\Business\Models\Website;
use Modules\Business\Models\Business;
use Modules\User\Entities\UserEntity;
use Modules\Admin\Models\BusinessTask;
use Modules\Business\Models\Countries;
use App\Http\Controllers\JobController;
use App\Mail\CreateWelcomeRegisterEmail;
use Illuminate\Database\Eloquent\Builder;
use Modules\Business\Entities\TaskEntity;
use Modules\Business\Models\EmailTemplate;
use Modules\ThirdParty\Models\StatTracking;
use Modules\Admin\Entities\AdminAlertEntity;
use Modules\Business\Entities\KeywordEntity;
use Modules\Business\Entities\WebsiteEntity;
use Modules\Business\Entities\BusinessEntity;
use Modules\Business\Entities\CampaignEntity;
use Modules\Business\Models\SendgridEventLogs;
use Modules\ThirdParty\Models\SocialMediaMaster;
use Modules\GoogleAnalytics\Entities\GoogleAnalyticsEntity;



use Modules\ThirdParty\Entities\ThirdPartyEntity;





class HomeController extends Controller
{
    use ApiServer;

    protected $crmEntity;

    protected $data;

    protected $sessionService;

    protected $thirdPartyEntity;

    protected $businessEntity;

    protected $WebsiteEntity;

    protected $dashboardEntity;

    public function __construct()
    {
        $this->crmEntity = new CRMEntity();
        $this->sessionService = new SessionService();
        $this->thirdPartyEntity = new ThirdPartyEntity();
        $this->businessEntity = new BusinessEntity();
        $this->googleAnalyticsEntity = new GoogleAnalyticsEntity();
        $this->WebsiteEntity = new WebsiteEntity();
        $this->dashboardEntity = new DashboardEntity();
    }
    public function getCountries()
    {
        # code...
        // countryCodes
        $this->data['countryCodes'] = Countries::all()->toArray();

        return $this->data;
    }


    public function home(Request $request)
    {

//        DB::enableQueryLog();
//        $res = Task::with('campaignFeedback')
//            ->where('id', 746)
//            ->get()->toArray();
//
//
//        print_r($res);
//        exit;

//            $catTasksList = Category::with([
//                'tasks' => function ( $q ) {
//                    $q->where('type','inner');
//                }
//            ])->get()->toArray();
//            foreach ($catTasksList as $task) {
//
//                print_r($task['id']);
//                print_r($task['name']);
////                print_r($task['tasks']);
//            }
//            exit();
//          $result = '';
//          $subscribedUser = Subscription::all()->toArray();
//          foreach($subscribedUser as  $sub) {
//              $result = Users::where('id','=',$sub['users_id'])->where('upgrade_selected_plan_strategy', '=', null)->update(['upgrade_selected_plan_strategy' => 1]);
//          }
//          echo $result;
//          exit();

//        $userData = $this->sessionService->getAuthUserSession();
//        $userData = $this->businessEntity->userSelectedBusiness();
//        $response =  $userData['records']['niche']['niche'];
//        $response1 =  $userData['records']['niche']['industry']['name'];
//
//        print_r($userData['business'][0]['practice_name']);
//        print_r($userData);
//        $a = $request->segment(0) ;
//        echo  $a;
//        print_r( );
//        print_r($response);
//        print_r($response1);
//        exit();
//        $mail = mail::to('ibrahim.official125@gmail.com')->send(new NotifyNewReview());
//        if (Mail::failures()) {
//            dd('email failed');
//        } else {
//            dd('email success');
//        }
//        exit();
//        $types =
//            [
//                'category_type'=> 'PV',
//                'type' => 'google-analytics',
//                'is_type' => 'day',
//            ];
//
//        $request->merge($types);
//        $response  = $this->dashboardEntity->getGraphStatsCount($request);
//        print_r($response);
//        exit();
//       $assoc = array(
//        'accessToken' => '1',
//            'send' => 'analytics-views',
//  'urlAction' => 'google-analytics/get-accounts',
//  'refresh_token' => '1//03etF78gE8q_LCgYIARAAGAMSNwF-L9IrvOfSXur1_dL6BE6oVNXFmopz6ZI-fz_msKriRk3GiN1D3fNEKCkO5Mm9Qh88H_Oq9lg',
//    );
//        $request->merge($assoc);
////        print_r($request->all());
////        exit;
//        $response = $this->googleAnalyticsEntity->getAccounts($request);
//
//        print_r($response);
//        exit;
//        $token = $this->sessionService->getAuthTokenSession();
//
//        if($request->get('accessToken')) {
//            $socialToken = $this->sessionService->getOAuthToken();
//            $data['refresh_token'] = $socialToken['analyticsAccessToken'];
//            $data['token'] = $token;
//
//            // $requestType = 'accounts';
//            $urlAction = 'google-analytics/get-accounts';
//
//            if( $request->has('id') )
//            {
//                Log::info("id ");
//                // $requestType =  Get account properties
//                $urlAction = 'google-analytics/get-web-property';
//                $data['acount_id'] = $request->get('id');
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


//        $userDataa = $this->sessionService->getAuthUserSession();
//        Log::info('userData');
//        Log::info($userDataa);
//        $templateId = 88;
//        echo $uid =  base64_encode('syx') .  base64_encode($templateId);
//        echo '<br>';
//        echo intval(str_replace('syx', '', base64_decode($uid)));
//        exit;

//        $response = PromotionTemplate::with('templatePlans')->find(77)->toArray();
//
//        print_r($response);
//        exit;

//        $response = PromotionTemplate::with('templatePlans')
//            ->where('id', 77)
//            ->where('is_deleted', 0)->get()->toArray();
//
//        print_r($response);
//        exit;
//
//
//        exit;
//        DB::enableQueryLog();
//
////        $res = Category::where('id',36)->get();
//        $res = Category::with('tasks')->where('id',36)->get();
//
////        print_r($res->toArray());
////        exit;
//        print_r(DB::getQueryLog());exit;

//        log::info('home controller request');
//        log::info($request);
//        $mail = mail::to('admin@nichepractice.com')->send(new NotifyNewReview());
//
//        if (Mail::failures()) {
//            dd('email failed');
//        } else {
//            dd('email success');
//        }
//        exit();
//        $mail = Mail::to('fsd.ark03@gmail.com')->send(new NotifyNewReview());

//        echo Date('F d, Y g:i a', strtotime('2020-08-24 10:54:41'));
//        exit;

//        $sendGridData['list_ids'] = ['2c2e72ee-ef1b-430f-8afe-987f1d51d2f9'];
//        $userEn = new UserEntity();
//        $userEn->saveUserSendGrid(96, '', '2c2e72ee-ef1b-430f-8afe-987f1d51d2f9');
//        exit;
//        $sendGridData['contacts'][] =
//            [
//                "email" => 'abdultrial1@mailinator.com',
//                "first_name" => 'Ad',
//                "last_name" => 're',
//                "address_line_1" => '',
//                "address_line_2" => '',
//                "city" => '',
//                "country" => '',
//                "postal_code" => '',
//                "state_province_region" => ''
//            ];
//
//
//        Log::info("Home sendgrid data ");
//        Log::info($sendGridData);
////        exit;
//        $sendgridApi = \Config::get('apikeys.sendgrid_api_key');
//
//        $response = $this->sendgridServeApiRequest()->request('PUT', 'marketing/contacts',
//            [
//                'json' => $sendGridData,
//                'headers'  => [
//                    'Authorization' => 'Bearer '.$sendgridApi
//                ]
//            ]
//        );
//
//        $responseData = json_decode($response->getBody()->getContents(), true);
//
//        print_r($responseData);
//        exit;
//        Log::info("test on the ");
//        $json = '{"tagName":"mj-global-style","attributes":{"h1:color":"#000","h1:font-family":"Helvetica, sans-serif","h2:color":"#000","h2:font-family":"Ubuntu, Helvetica, Arial, sans-serif","h3:color":"#000","h3:font-family":"Ubuntu, Helvetica, Arial, sans-serif",":color":"#000",":font-family":"Ubuntu, Helvetica, Arial, sans-serif",":line-height":"1.5","a:color":"#24bfbc","button:background-color":"#e85034","containerWidth":600,"fonts":"Helvetica,sans-serif,Ubuntu,Arial","mj-text":{"line-height":1.5,"font-size":15},"mj-button":{"background-color":"#30ABDB"}},"children":[{"tagName":"mj-body","attributes":{"background-color":"#ECFAF9","containerWidth":600},"children":[{"tagName":"mj-section","attributes":{"full-width":"full-width","padding":"0px 0px 0px 0px","background-color":"#40b7d1","containerWidth":600},"children":[{"tagName":"mj-column","attributes":{"width":"100%","vertical-align":"top"},"children":[{"tagName":"mj-spacer","attributes":{"height":"50px","containerWidth":600},"uid":"_R78s44ip"}],"uid":"HJQ8ytZzW"}],"layout":1,"backgroundColor":null,"backgroundImage":null,"paddingTop":0,"paddingBottom":0,"paddingLeft":0,"paddingRight":0,"uid":"Byggju-zb"},{"tagName":"mj-section","attributes":{"full-width":"full-width","padding":"0px 0px 0px 0px","background-color":"#40b7d1","containerWidth":600},"type":null,"children":[{"tagName":"mj-column","attributes":{"width":"100%","background-color":"#FFFFFF","vertical-align":"top"},"children":[{"tagName":"mj-image","attributes":{"src":"https://storage.googleapis.com/topol-io-team-2823/plugin-assets/6320/2823/add_logo2.png","padding":"0px 0px 0px 0px","alt":"","href":"","containerWidth":600,"width":306,"widthPercent":51},"uid":"Ue8c97Oy6"}],"uid":"ny5IcwwHA"}],"layout":1,"backgroundColor":"","backgroundImage":"","paddingTop":0,"paddingBottom":0,"paddingLeft":0,"paddingRight":0,"uid":"ij0Pong3n"},{"tagName":"mj-section","attributes":{"full-width":"full-width","padding":"0px 0px 0px 0px","background-color":"#40b7d1"},"type":null,"children":[{"tagName":"mj-column","attributes":{"width":"100%","vertical-align":"top"},"children":[{"tagName":"mj-text","attributes":{"align":"left","font-size":"11px","padding":"16px 17px 17px 17px","line-height":1.5,"color":"#000000","containerWidth":600,"container-background-color":"#798c8a"},"uid":"EPxOXmJuM","content":"<p style=\"text-align: center;\"><strong><span style=\"color: #ffffff; font-size: 26px;\">Your Smile Is Our Business</span></strong></p>"}],"uid":"tK60scuwM"}],"layout":1,"backgroundColor":"","backgroundImage":"","paddingTop":0,"paddingBottom":0,"paddingLeft":0,"paddingRight":0,"uid":"pULUXCXYz"},{"tagName":"mj-section","attributes":{"full-width":"full-width","padding":"0px 0px 0px 0px","background-url":"https://topolio.s3-eu-west-1.amazonaws.com/uploads/59390fe4352f4/1496913234.jpg","background-color":"#60B5CE","containerWidth":600},"children":[{"tagName":"mj-column","attributes":{"width":"100%","vertical-align":"top"},"children":[{"tagName":"mj-image","attributes":{"src":"https://storage.googleapis.com/topol-io-team-2823/plugin-assets/6320/2823/senior.png","padding":"0px 0px 0px 0px","alt":null,"href":null,"containerWidth":600,"width":600,"widthPercent":100},"uid":"SkHH-9IMZ"},{"tagName":"mj-spacer","attributes":{"height":"20px","containerWidth":600,"container-background-color":"#FFFFFF"},"uid":"zVY2_LQkV"}],"uid":"rkm815SfZ"}],"layout":1,"backgroundColor":null,"backgroundImage":null,"paddingTop":0,"paddingBottom":0,"paddingLeft":0,"paddingRight":0,"uid":"SkseRYHfZ"},{"tagName":"mj-section","attributes":{"full-width":false,"padding":"9px 0px 9px 0px","background-color":"#FFFFFF","containerWidth":600},"children":[{"tagName":"mj-column","attributes":{"width":"100%","vertical-align":"top"},"children":[{"tagName":"mj-text","attributes":{"align":"left","font-size":"11px","padding":"0px 30px 15px 30px","line-height":1.5,"containerWidth":600},"uid":"O3W0ihtWm","content":"<p style=\"text-align: center;\"><span style=\"font-size: 18px; color: #34495e;\">For years we&rsquo;ve helped our patients enjoy the lifelong benefits of healthy teeth. You&rsquo;ve been coming to us for all your dental needs and we&rsquo;ve been happy to give you confidence in your great smile.</span></p>"},{"tagName":"mj-text","attributes":{"align":"left","font-size":"11px","padding":"15px 60px 15px 60px","line-height":1.5,"containerWidth":600},"uid":"P3hKm34ix","content":"<p style=\"text-align: center;\"><span style=\"font-size: 24px; color: #3598db;\"><strong>Did You Know We&rsquo;re Also a Leading Provider of Dental Implants?</strong></span></p>"}],"uid":"HJcdc5UGW"}],"layout":1,"backgroundColor":null,"backgroundImage":null,"paddingTop":0,"paddingBottom":0,"paddingLeft":0,"paddingRight":0,"uid":"B11-i58fb"},{"tagName":"mj-section","attributes":{"full-width":false,"padding":"0px 0px 0px 0px","background-color":"#FFFFFF","containerWidth":600},"type":null,"children":[{"tagName":"mj-column","attributes":{"width":"25%","vertical-align":"top"},"children":[{"tagName":"mj-image","attributes":{"src":"https://storage.googleapis.com/topol-io-team-2823/plugin-assets/6320/2823/doc_photo.jpg","padding":"0px 0px 0px 0px","alt":"","href":"","containerWidth":150,"width":118,"widthPercent":79},"uid":"EFgrGmTd4"},{"tagName":"mj-text","attributes":{"align":"left","font-size":"11px","padding":"2px 15px 15px 15px","line-height":1.5,"containerWidth":150},"uid":"-asB1bBCm","content":"<p style=\"text-align: center;\"><span style=\"font-family: \'arial black\', sans-serif; font-size: 12px;\">Smith Dr</span></p>"}],"uid":"tpIkOL_xYy"},{"tagName":"mj-column","attributes":{"width":"75%","vertical-align":"top"},"children":[{"tagName":"mj-text","attributes":{"align":"left","font-size":"11px","padding":"0px 15px 15px 15px","line-height":1.8,"containerWidth":450},"uid":"PljzZAZhp","content":"<p><span style=\"font-size: 14px; color: #34495e;\"><strong>We listen to our patients.</strong> And we&rsquo;ve heard a lot of our patients asking what we can do about their most problematic teeth.&nbsp;</span><span style=\"font-size: 14px; color: #34495e;\">Because we want to meet your needs, we&rsquo;ve implemented the least invasive, most natural-looking techniques to replace missing or damaged teeth with dental implants.&nbsp;</span></p>"}],"uid":"B394DTGaa_"}],"layout":1,"backgroundColor":"","backgroundImage":"","paddingTop":0,"paddingBottom":0,"paddingLeft":0,"paddingRight":0,"uid":"R28Eha4kg"},{"tagName":"mj-section","attributes":{"full-width":false,"padding":"0px 0px 0px 0px","background-color":"#FFFFFF","containerWidth":600},"type":null,"children":[{"tagName":"mj-column","attributes":{"width":"100%","vertical-align":"top"},"children":[{"tagName":"mj-text","attributes":{"align":"left","font-size":"11px","padding":"0px 15px 15px 15px","line-height":1.8,"containerWidth":600},"uid":"ZwA35loGm","content":"<p><span style=\"font-size: 14px; color: #34495e;\">Everything can be done in our office, from your initial consultation to when you walk out our door with a beautifully restored smile. We want you to feel great about your smile. With proper care and cleaning, your implants can last a lifetime.&nbsp; Make an appointment and we can talk about what matters to you.</span></p>"},{"tagName":"mj-spacer","attributes":{"height":"25px","containerWidth":600},"uid":"om6xfvtL7"},{"tagName":"mj-text","attributes":{"align":"left","font-size":"11px","padding":"15px 50px 15px 50px","line-height":1.8,"containerWidth":600,"container-background-color":"#DCEBE9"},"uid":"H-hLYY05V","content":"<p style=\"text-align: center;\"><span style=\"font-size: 16px; color: #3598db;\"><span style=\"font-size: 18px;\">Contact our office to determine if you are a candidate for dental implants. Ask us about our monthly specials.&nbsp;</span><br /></span></p>\n<p style=\"text-align: center;\"><strong><span style=\"font-size: 24px;\">Call Us Now:&nbsp; 234-234-2344</span></strong></p>"}],"uid":"f9JbAeZLv7"}],"layout":1,"backgroundColor":"","backgroundImage":"","paddingTop":0,"paddingBottom":0,"paddingLeft":0,"paddingRight":0,"uid":"ihBG1hr0p"},{"tagName":"mj-section","attributes":{"full-width":false,"padding":"9px 0px 9px 0px","background-color":"#FFFFFF","containerWidth":600},"type":null,"children":[{"tagName":"mj-column","attributes":{"width":"100%","vertical-align":"top"},"children":[{"tagName":"mj-social","attributes":{"padding":"10px 10px 10px 10px","text-mode":"false","icon-size":"24px","align":"center","containerWidth":600},"children":[{"tagName":"mj-social-element","attributes":{"src":"https://s3-eu-west-1.amazonaws.com/ecomail-assets/editor/social-icos/rounded/facebook.png","name":"Facebook","href":"https://www.facebook.com/PROFILE","background-color":"transparent"}},{"tagName":"mj-social-element","attributes":{"src":"https://s3-eu-west-1.amazonaws.com/ecomail-assets/editor/social-icos/rounded/twitter.png","name":"Twitter","href":"https://www.twitter.com/PROFILE","background-color":"transparent"}},{"tagName":"mj-social-element","attributes":{"src":"https://s3-eu-west-1.amazonaws.com/ecomail-assets/editor/social-icos/rounded/linkedin.png","name":"LinkedIn","href":"https://www.linkedin.com/PROFILE","background-color":"transparent"}}],"uid":"GExaROYdJP","style":"rounded"},{"tagName":"mj-text","attributes":{"align":"left","font-size":"11px","padding":"15px 15px 15px 15px","line-height":1.8,"containerWidth":600},"uid":"DA6KwjKce","content":"<p style=\"text-align: center;\"><span style=\"font-size: 12px;\">%%Dcompany%%</span><br /><span style=\"font-size: 12px;\">%%Doctor_Address%% | %%Doctor_City%% | %%Doctor_State%% | %%Doctor_Zip%%</span><br /><span style=\"font-size: 12px;\">Ph. %%Doctor_Phone%% | Visit Our Website | Email Us | Unsubscribe</span></p>"}],"uid":"CilX_kJSPH"}],"layout":1,"backgroundColor":"","backgroundImage":"","paddingTop":0,"paddingBottom":0,"paddingLeft":0,"paddingRight":0,"uid":"njBO5273kS"},{"tagName":"mj-section","attributes":{"full-width":"full-width","padding":"0px 0px 0px 0px","containerWidth":600},"children":[{"tagName":"mj-column","attributes":{"width":"100%","vertical-align":"top"},"children":[{"tagName":"mj-spacer","attributes":{"height":"50px","containerWidth":600},"uid":"0luG5OlO3"}],"uid":"ByDQL1FbzZ"}],"layout":1,"backgroundColor":null,"backgroundImage":null,"paddingTop":0,"paddingBottom":0,"paddingLeft":0,"paddingRight":0,"uid":"rkYKjdZMb"}]}],"style":{"h1":{"font-family":"\"Cabin\", sans-serif","color":"#FFFFFF","font-size":"44px"},"h2":{"color":"#32C1E9"},"h3":{"font-family":"\"Cabin\", sans-serif","font-size":"20px","color":"#555555"}},"fonts":["\"Cabin\", sans-serif"]}';
//
////        print_r(json_encode($json, true));
////        exit;
////        echo json_encode($json);
////        exit;
////        //
//        print_r(json_encode(json_decode($json, true)));
//        exit;

//        $useren = new UserEntity();
//
//        print_r($useren->subscriptionStatusCheck());
//        exit;

//        echo date('Y-m-d', strtotime(' +13 day', strtotime('2019-07-01')));
//        $user = Users::where('id', '!=', 1)->get()->toArray();

//        echo $taskDay = Date('Y-m-d', strtotime('2020-07-19'));
//        exit;
//        print_r($user);
//        exit;

//        foreach($user as $userRec)
//        {
//            Users::where('id', $userRec['id'])->update(
//                [
//                    'trial_ends_at' => date('Y-m-d', strtotime(' +13 day'))
//                ]
//            );
//            date('Y-m-d', strtotime(' +13 day'));
//            echo date('Y-m-d', strtotime(' +13 day'));
//            exit;
//        }

//        echo date('Y-m-d', strtotime(' +13 day', strtotime('2019-07-01')));
//        exit;

//        $currentDay = Date('Y-m-d', strtotime('2020-07-18'));
//        echo $currentDay = Date('Y-m-d', time());
//        exit;
//
//        $diff=date_diff(date_create($taskDay),date_create($currentDay));
//        $dateDiff = $diff->format("%R%a");

//        echo str_replace("-", "", $dateDiff);
//        exit;
//        if($dateDiff <= 0)
//        {
//            // trial expired
//            $data['trial_expired'] = false;
//            $data['trial_remaining_days'] = str_replace("-", "", $dateDiff);;
//        }
//        else
//        {
//            $data['trial_expired'] = true;
//            $data['trial_remaining_days'] = 0;
//        }
//        print_r($data);
//        exit;
//        echo $dateDiff;
//        exit;

//        $g = 2;
////        $g.'anc' = 1;
//
//        ${'standard_query_'.$g} = 1;
//
//        echo ${'standard_query_'.$g}->where;
//        exit;
//
////        $var.'_'.$g = 1;
//        $res = StatTracking::whereMonth('activity_date', '=', '11')->whereYear('activity_date', '=', 19)
//            ->toSql();
//
//        print_r($res);
//        exit;
//        $data = [
//            "may 2020" => 1011,
//            "jun 2020" => 1011
//        ];
//
//        $encodedData = [];
//        $i= 0;
//        foreach($data as $index => $val)
//        {
//            $encodedData[$i]['label'] = $index;
//            $encodedData[$i]['count'] = $val;
//
//            $i++;
//        }
//
////        print_r($encodedData);
//        print_r(json_encode($encodedData));
//        exit;
//        $task = 19;
//
//        $result = Task::find($task);
//        print_r($result);
//        exit;
//        echo Date('Y-m-d',strtotime("+3 day", strtotime('2020-06-22')));
//        exit;
//        echo Date('l,M-y', strtotime('2020-06-25'));

//        echo time();
//        exit;

//        echo Date('Y-m-d', time());
//        exit;
//        $task = new TaskEntity();

//        $res = $task->generateRecurringTasks($request, 37);
//
//        print_r($res);
//        exit;


//        Log::info("em > " . $request->get('email'));
//        $campaignObj = new CampaignEntity();
//        print_r($campaignObj->sendPatientEmailInvite($request));
//
//        exit;

//        $email = new EmailForInvite("test", "abdul", "", $templatePreview);

//        print_r($res);
//        exit;



        // return $response;
//        $response = json_decode($response->getBody()->getContents(), true);


//        print_r($res);
//        exit;

//        echo base64_encode(33);

//        echo base64_decode('MjA=');
//        exit;
//        $web = 'http://www.davidjones.com/';
//        $web = 'www.davidjones.com/';
//        $web = 'https://davidjones.com/';
//        $web = 'http://beaches.lacounty.gov/dockweiler-beach';

//        $parseUrl = parse_url(trim($web));
//
//        print_r($parseUrl);
//
//        if(empty($parseUrl['scheme']))
//        {
//
//        }
//        scheme

//        exit;

//        echo getUrlDomain($web);

//       $webUrl = $url = 'http://abc.com';

//        $encodedWeb1 = "$webUrl\"";
//        $webUrl = '';
//       echo trim(json_encode($webUrl), '"');
//       exit;

//       Log::info("home " .json_encode($url));

//       $str = '{"tagName":"mj-global-style","attributes":{"h1:color":"#000","h1:font-family":"Helvetica, sans-serif","h2:color":"#000","h2:font-family":"Ubuntu, Helvetica, Arial, sans-serif","h3:color":"#000","h3:font-family":"Ubuntu, Helvetica, Arial, sans-serif",":color":"#000",":font-family":"Ubuntu, Helvetica, Arial, sans-serif",":line-height":"1.5","a:color":"#24bfbc","button:background-color":"#e85034","containerWidth":"600","fonts":"Helvetica,sans-serif,Ubuntu,Arial","mj-text":{"line-height":"1.5","font-size":"15"}},"children":[{"tagName":"mj-body","attributes":{"background-color":"#FFFFFF","containerWidth":"600"},"children":[{"tagName":"mj-section","attributes":{"full-width":"false","padding":"9px 0px 9px 0px","containerWidth":"600"},"children":[{"tagName":"mj-column","attributes":{"width":"100%","vertical-align":"top"},"children":[{"tagName":"mj-text","attributes":{"align":"left","font-size":"11px","padding":"15px 15px 15px 15px","line-height":"1.5","containerWidth":"600"},"uid":"q5GEr_y1Q","content":"<p>This is your new text block with first paragraph.<\/p>
//<p><a style=\"\/* text-decoration: none !important; *\/    background-color: none !important; background-color: none !important;\" href=\"http:\/\/abc.com\">';
//
//       echo json_decode($str);
//       echo str_replace(json_encode($url), "abdulTest", $str);
//       exit;

        /***** worked ****/

//        $str = 'Sbfl Test
//<span class="test">Hi</span>
//AbdulTesting
//<span class="template-token-tag" data-token="Doctor_Last_Name">Test</span>
//<span class="template-token-tag" data-token="Doctor_First_Name">Abdul</span>
//<span class="template-token-tag" data-token="Doctor_Last_Name">Test2</span>
//<p><span class="template-token-tag" data-token="Doctor_First_qame">Abdul</span> </p>skd
//
//';
//
//
//        $str = 'foo
//        {Vimeo class="test1"}dssjbd9{/Vimeo} bar
//        {Vimeo class="test"}123456789{/Vimeo} bar
//        ';
//
//        $str = '
//<span class="template-token-tag" data-token="Doctor_Last_Name">Test</span>
//<span class="template-token-tag" data-token="Doctor_First_Name">Abdul</span>
//<span class="template-token-tag" data-token="Doctor_Phone_Number">123456</span>
//<span class="template-token-tag" data-token="Doctor_First_Name">Abdul</span>
//';
//
//        function get_string_between($string, $start, $end){
//            $string = ' ' . $string;
//            $ini = strpos($string, $start);
//            if ($ini == 0) return '';
//            $ini += strlen($start);
//            $len = strpos($string, $end, $ini) - $ini;
////            echo $len;
////            exit;
//            return substr($string, $ini, $len);
//        }
//
//        $fullstring = 'this is my [tag]dog[/tag]';
//        $parsedFirst = get_string_between($str, '<span class="template-token-tag" data-token="Doctor_First_Name">', '</span>');
//        $parsedPhone = get_string_between($str, '<span class="template-token-tag" data-token="Doctor_Phone_Number">', '</span>');
//
//        $str = str_replace('<span class="template-token-tag" data-token="Doctor_First_Name">'.$parsedFirst.'</span>','<span class="template-token-tag" data-token="Doctor_First_Name">testingdynamic</span>', $str);
//
//        $str = str_replace('<span class="template-token-tag" data-token="Doctor_Phone_Number">'.$parsedPhone.'</span>','<span class="template-token-tag" data-token="Doctor_Phone_Number">77877877</span>', $str);
//        echo $str;
//
//        exit;

        /***** worked ****/

        /***** not worked ****/
//        $str = 'foo {Vimeo}123456789{/Vimeo} bar';
//        preg_match('~{Vimeo class="test1"}([^{]*){/Vimeo}~i', $str, $match);
//        preg_match('~<span class="template-token-tag" data-token="Doctor_First_Name">([^{]*)</span>~i', $str, $match);
//        echo $match[1];

//        echo preg_match_all('/{Vimeo}(.*?){\/Vimeo}/s', $str, $matches);
//        exit;


//        echo strlen('data-token="Doctor_First_Name">');
//        exit;

//        $str = '<span class="template-token-tag" data-token="Doctor_First_Name">123456789</span>';

//        echo strpos($str,  '<span class="template-token-tag" data-token="Doctor_First_Name">');

//        echo $m = substr($str, 0, strpos($str, '</span>'));
//    exit;

//        $m = substr($str, strpos($str, '<span class="template-token-tag" data-token="Doctor_First_Name">')+64);
//        echo $m;
//        exit;
//        $m = substr($m, 0, strpos($m, '</span>'));
//        echo $m;
//        exit;

//        echo str_replace($m, "Rehman", $str);
//
//        exit;
        /***** not worked ****/

//        $data['category'][0] = 'anc';
//        $data['category'][1] = 'cde';
//        $data['category'] = 'anc';
//
//        foreach($data['category'] as $row)
//        {
//            echo $row;
//        }
//
//        print_r($data['category']);
//        exit;
//        if(is_array($data['category']))
//        {
//            echo "if";
//        }
//        echo is_array($data['category']);
//        exit;

//        print_r($data['category'][0]);

//        print_r($data);
//        exit;
//        $camp = new CampaignEntity();
//
//        $templateData = EmailTemplate::with(
//            [
//                'campaignUsersLinked' => function($q) use($request)
//                {
//                    $q->where('user_id', 37);
//                    $q->with([
//                        'recipients' => function($m)
//                        {
//                            $m->where('email', '!=', '');
//                            $m->where('deleted_at', null);
////                                $m->orWhere('deleted_at', '');
//                        },
//                    ]);
//                },
//            ]
//        )->where('id', 76)
//            ->get()
//            ->toArray();
//
//        $camp->createContactList($templateData);
//        exit;

////        print_r($camp->checkCurrentJobStatus('47fd4197-68a4-4034-9293-a8473fc05af3'));
//        $data['single_send_id'] = '39d30086-9ca6-11ea-a189-9ad437cac864';
//        print_r($camp->scheduleSingleSend([]));
////        echo randomString(3);
//        exit;
//        echo rand(3,6);
//        exit;

//        echo strtotime(now()->addMinutes(2));
//            exit;
//        try {
//            echo "if";
//
////            $error = 'Always throw this error';
////            throw new Exception($error);
//            throwException(null);
//
//            echo "after exec";
//        }catch(\Exception $e)
//        {
//            echo "catch";
//            print_r($e->getMessage());
//
//        }
//
//
//        Log::info("process END");


//        echo strtotime(now()->addMinutes(2));
//            exit;
//        $job = new JobController();
//        $job->runSingleSendCampaign([]);
//
//        echo "run";
//        exit;
//        $result = EmailTemplate::with(
//            [
//                'campaignUsersLinked' => function($q) use($request)
//                {
//                    $q->where('user_id', 37);
//                    $q->with([
//                        'recipients' => function($m)
//                        {
//                            $m->where('email', '!=', '');
//                            $m->where('deleted_at', null);
////                                $m->orWhere('deleted_at', '');
//                        },
//                    ]);
//                },
//            ]
//        )->where('id', 76)
//            ->get()
//            ->toArray();
//
//
//        $client = new Client([
//            // Base URI is used with relative requests
//            'base_uri' => 'https://api.sendgrid.com/v3/'
//        ]);
//
//        $sendGridData =  [
//            "name" => 'test singlesnd from code 5',
//        ];
//
//        $sendGridData['send_to']['list_ids'][] = 'd279cf20-dfba-440a-9a36-9212cb76e62b';
//
//        $sendGridData['email_config']['subject'] = 'Testing';
//        $sendGridData['email_config']['html_content'] = $result[0]['template_preview'];
//        $sendGridData['email_config']['suppression_group_id'] = -1;
//        $sendGridData['email_config']['sender_id'] = 819435;
//
////        print_r(json_encode($sendGridData));
////        exit;
//
//        $sendgridApi = env('sendgrid_key');
//
//
//        try {
//            $response = $client->request('POST', 'marketing/singlesends',
//                [
//                    'json' => $sendGridData,
//                    'headers'  => [
//                        'Authorization' => 'Bearer '.$sendgridApi
//                    ]
//                ]
//            );
//
//            $responseData = json_decode($response->getBody()->getContents(), true);
//
//            print_r($responseData);
//        }catch(\Exception $e)
//        {
//            print_r($e->getMessage());
//        }
//
//        exit;

//        $result = EmailTemplate::with(
//            [
//                'campaignUsersLinked' => function($q) use($request)
//                {
//                    $q->where('user_id', 37);
//                    $q->with([
//                        'recipients' => function($m)
//                        {
//                            $m->where('email', '!=', '');
//                            $m->where('deleted_at', null);
////                                $m->orWhere('deleted_at', '');
//                        },
//                    ]);
//                },
//            ]
//        )->where('id', 76)
//            ->get()
//            ->toArray();


//        print_r($result);
//        exit;
//        $sendGridData['list_ids'] = ['d279cf20-dfba-440a-9a36-9212cb76e62b'];
//
//        foreach ($result[0]['campaign_users_linked'] as $userLinked)
//        {
//            $recipientData = $userLinked['recipients'];
//
//            $sendGridData['contacts'][] =
//                [
//                    "email" => strtolower($recipientData['email']),
//                    "first_name" => $recipientData['first_name'],
//                    "last_name" => $recipientData['last_name'],
//                    "address_line_1" => '',
//                    "address_line_2" => '',
//                    "city" => '',
//                    "country" => '',
//                    "postal_code" => '',
//                    "state_province_region" => ''
//                ];
//        }

//        $camp = new CampaignEntity();
//        print_r($camp->createContactList($result));
//        exit;

//        print_r($result);
//        exit;
//        $sendGridData['list_ids'] = ['514a19fc-58b3-45d3-9f48-e9ba786c95a3'];
//        $sendGridData['contacts'][0] =
//            [
//            "email" => 'test@t.com',
//            "first_name" => 'A',
//            "last_name" => 'B',
//            "address_line_1" => 'housp-5',
//            "address_line_2" => '',
//            "city" => 'c',
//            "country" => '',
//            "postal_code" => 'zip',
//            "state_province_region" => 'state'
//        ];
//        $sendGridData['contacts'][1] =
//            [
//            "email" => 'test111@t.com',
//            "first_name" => 'A',
//            "last_name" => 'B',
//            "address_line_1" => 'housp-5',
//            "address_line_2" => '',
//            "city" => 'c',
//            "country" => '',
//            "postal_code" => 'zip',
//            "state_province_region" => 'state'
//        ];
//
//        $sendGridData = json_encode($sendGridData);
//
//        print_r($sendGridData);
//        exit;
//        $businessUrl = 'https://maps.google.com/?cid=5263329245545035741';
//        $client = new Client([]);
//
//        $serverUrl = 'http://landingpagelaunchpad.com/';
//        $detailUrl = 'madisonsandbox/api/home/GetGooglePlaceBusinessDetailByURL';
//
//        $url = $serverUrl.$detailUrl;
//
//        \Log::info("url re $url");
//        $response = $client->request(
//            'GET',
//            $url,
//            [
//                'query' => [
//                    'HistoricalReviews'=>'true',
//                    'BusinessURL' => $businessUrl
//                ],
//            ]
//        );
//        $responseData = json_decode($response->getBody()->getContents(), true);
//
//        print_r($responseData);
//        exit;


//        $businessUrl = 'https://maps.google.com/?cid=5263329245545035741';
//        $client = new Client([]);
//
//        $serverUrl = 'http://landingpagelaunchpad.com/';
//        $detailUrl = 'madisonsandbox/api/home/GetGooglePlaceBusinessDetailByURL';
//
//        $url = $serverUrl.$detailUrl;
//
//        \Log::info("url re $url");
//        $response = $client->request(
//            'GET',
//            $url,
//            [
//                'query' => [
//                    'HistoricalReviews'=>'true',
//                    'BusinessURL' => $businessUrl
//                ],
//            ]
//        );
//        $responseData = json_decode($response->getBody()->getContents(), true);
//
//        print_r($responseData);
//        exit;
//        $stripe::setApiKey('sk_test_7WmoKUtx9KQ7z2y0sv0KR3KB004E8jm2GR');
//
//        $stripe->customers->create([
//            'description' => 'My First Test Customer (created for API docs)',
//        ]);
//        exit;
//        $user = Users::find(37);


//        $creditPlanData = CreditsPlan::where('price_id', 'price_1GxAPoKahC1NqiCddLtUHh9p')->get()->toArray();
//
//            print_r($creditPlanData);
//            exit;

//        $user->invoiceFor('One Time Fee', 'price_1GxAQEKahC1NqiCdyrqK9IDl');

//        $response = $user->newSubscription('diy', 'plan_HBExjYxGIzcZ2E')
//            ->create("tok_1GzkupKahC1NqiCdK9ufI18E");

//        echo $user['id'] .'_' . randomString(12);
//        exit;

//        $stripe = new Stripe();
//
//        $stripe::setApiKey('sk_test_7WmoKUtx9KQ7z2y0sv0KR3KB004E8jm2GR');
//
//        $res = Customer::create(
//            [
//                'email' => 'abdul8-1@mailinator.com'
//            ]
//        );

//        print_r($res);
//        exit;

//        $stripe1 = new \Stripe\StripeClient(
//            'sk_test_7WmoKUtx9KQ7z2y0sv0KR3KB004E8jm2GR'
//        );
//        $res =  $stripe1->setupIntents->all(['limit' => 3]);
//        print_r($res);
//        exit;

//        $price = Price::create([
//            'product' => 'price_1GxAQEKahC1NqiCdyrqK9IDl',
//            'customer' => 'cus_HPQVHThun2Blx5',
//            'unit_amount' => 2000,
//            'currency' => 'usd',
//        ]);
//
//        print_r($price);
//        exit;
//        $res = Charge::create ([
//            "amount" => 100 * 100,
//            "currency" => "usd",
//            "source" => 'tok_1GzkupKahC1NqiCdK9ufI18E',
//            "description" => "Test payment from itsolutionstuff.com."
//        ]);

//        print_r($stripeObj);
//        exit;

//        $stripe = \Stripe\Stripe::setApiKey('sk_test_7WmoKUtx9KQ7z2y0sv0KR3KB004E8jm2GR');

//        InvoiceItem::

//        $subscription = \Stripe\Subscription::create([
//            'customer' => 'cus_HPQVHThun2Blx5',
////              'plan' => 'price_1GxAQEKahC1NqiCdyrqK9IDl'
//            'add_invoice_items' => [[
//                'price' => 'price_1GxAQEKahC1NqiCdyrqK9IDl'
//            ]],
//            'items' => [[
//                'price' => 'price_1GxAQEKahC1NqiCdyrqK9IDl',
//            ]],
////            'add_invoice_items' => [[
////                'price' => 'price_1GxAQEKahC1NqiCdyrqK9IDl',
////            ]],
//        ]);

//        print_r($subscription);
//        exit;
//        $invoice_item = InvoiceItem::create([
//            'customer' => 'cus_HPQVHThun2Blx5',
//            'price' => 'price_1GxAQEKahC1NqiCdyrqK9IDl',
//        ]);
////
//        $invoice = Invoice::create([
//            'customer' => 'cus_HPQVHThun2Blx5',
//        ]);
//
//        print_r($invoice);
//exit;
//        $stripe->paymentIntents->confirm(
//            'pi_1GcUkeKahC1NqiCdKIfTlc39',
//            ['payment_method' => 'pm_card_visa']
//        );

//        $session = Session::create([
//            'customer' => 'cus_HPQVHThun2Blx5',
//            'mode' => 'payment',
//            'line_items' => [[
//                'price' => 'price_1GxAQEKahC1NqiCdyrqK9IDl',
//                'quantity' => 1,
//            ]],
////            'payment_intent' => 'pi_1GcUkeKahC1NqiCdKIfTlc39',
////            'payment_method' => 'pm_1F0c9v2eZvKYlo2CJDeTrB4n',
//            'payment_method_types' => ['card'],
////            "payment_intent" => "pi_1GcUkeKahC1NqiCdKIfTlc39",
////            'payment_intent_data' => [
////                [
////                    'payment_method' => 'pm_1F0c9v2eZvKYlo2CJDeTrB4n',
////                    'capture_method' => 'automatic'
////                ]
////            ],
////            'success_url' => url('/') . 'https://nichepractice.test/abc',
//            'success_url' => route('credits?purchase=success'),
//            'cancel_url' => route('credits?purchase=cancel'),
////            'cancel_url' => 'https://example.com/cancel',
//        ]);
//exit;
//        print_r($session);
//        exit;
//        return true;
//
//        $response = $user->newSubscription('diy', 'plan_HBExjYxGIzcZ2E')
//            ->create("tok_1GfmEZKahC1NqiCdrCugqzUR");
//
//        print_r($response);
//        exit;
//        $userBusiness = Business::
//        with([
//            'niche' => function ($q) {
//                $q->with('industry');
//            }
//        ])->where('user_id', 37)->first();
//
//        $registered = Date('d-M-Y H:i', strtotime('2020-04-27 06:42:25'));
//        $firstName = 'Abdul';
//        $lastName = $request->get('last_name');
//        $BusinessName = 'Test Business';
//        $Useremail = $request->get('email');
//        $niche = 'niche';
//        $plan = 'Plan';
//        $registered = 1;

//        $emails = ['fsd.ark03@gmail.com', 'abc@gmail.com'];
//        $emails = ['fsd.ark03@gmail.com', 'abc@gmail.com'];
//         $mail = Mail::to('fsd.ark03@gmail.com')
//            ->send(new NotifyAdminNewUser($firstName, $lastName, $BusinessName, $Useremail, $registered, $niche, $plan));

//         $mail = Mail::to('fsd.ark03@gmail.com')
//            ->send(new CreateWelcomeRegisterEmail($firstName, 'fsd.ark11@gmail.com'));
//
////         dd($mail);
//        if (Mail::failures()) {
////        if ($mail) {
//            dd('email failed');
//        }else{
//            dd('email success');
//        }

//        $viewsAppendArray[] = [
//            'user_id' => 13,
//            'google_analytics_id' => 1,
//            'type' => 'PV',
//            'site_type' => 'Googleanalytics',
//        ];
//        $a1=array(
//            'websiteGoogleAnalytics' => 'abc'
//        );
//        $abc = array_merge($viewsAppendArray, $a1);
//        print_r($abc['websiteGoogleAnalytics']);
//        exit();

//        $types = [
//            'category_type'=> 'PV',
//            'type' => 'google-analytics',
//            'is_type' => 'day',
//        ];
//        $request->merge($types);
//        $response  = $this->dashboardEntity->getGraphStatsCount($request);
//        print_r($response);
//        exit();
//        print_r($response);
//        exit();
//        $this->data['googleAnalytics'] = 'not-installed';
//        if (!empty($userData['business'][0]['website']) ){
//            $resultWebsite = $this->WebsiteEntity->getGoogleAnalyticResponse($userData['business'][0]['website']);
////            Log::info('$resultWebsite');
////            Log::info($resultWebsite);
//            if($resultWebsite['_metadata']['outcomeCode'] == 200){
//                $this->data['googleAnalytics'] = 'installed';
//            }
//        }

        $ob = new BusinessEntity();

        $userData = $this->sessionService->getAuthUserSession();
//        print_r($userData);
//        exit();
        $WebsitefromBusiness = $this->businessEntity->userSelectedBusiness();

//        getting third party reviews from third party entity for online patients reviews

        $this->data['reviewsResult'] = '';
        $reviewsResult = $this->thirdPartyEntity->thirdPartyReviews($request);
        if ($reviewsResult['_metadata']['outcomeCode'] == 200) {
            $this->data['reviewsResult'] = $reviewsResult['records'];
        }

        $this->data['userBusiness'] = $WebsitefromBusiness['records'];
        $this->data['googleAnalytics'] = 'not-installed';
        if (!empty($WebsitefromBusiness['records']['website']) ){
            $resultWebsite = $this->WebsiteEntity->getGoogleAnalyticResponse($WebsitefromBusiness['records']['website']);
            if($resultWebsite['_metadata']['outcomeCode'] == 200){
                $this->data['googleAnalytics'] = 'installed';
            }
        }

        $googleAnalyticsData = GoogleAnalyticsMaster::where('business_id',$userData['business'][0]['business_id'])->first();
//        print_r($googleAnalyticsData['website']);
//        exit();

        $this->data['googleAnalyticsWebsite'] = '';
        $this->data['statTractingCount'] = '';
        $this->data['insightStatus'] = '';
        $this->data['insightTitle'] = '';
        if(!empty($googleAnalyticsData)){
            $this->data['statTractingCount'] = StatTracking::where('google_analytics_id', $googleAnalyticsData['id'])->sum('count');
            $this->data['googleAnalyticsWebsite'] = $googleAnalyticsData['website'];
            $types =
                [
                    'category_type'=> 'PV',
                    'type' => 'google-analytics',
                    'is_type' => 'all',
                ];
            $request->merge($types);
            $response  = $this->dashboardEntity->getGraphStatsCount($request);
            $this->data['insightStatus'] = $response['records'][0]['insightStatus'];
            $this->data['insightTitle'] = $response['records'][0]['insightTitle'];
//            print_r($response);
        }
//        print_r($this->data['statTractingCount']);
//        $this->data['googleAnalyticsViewsCount'] = $current_user['google_analytics_views_count'];
//        Log::info('userData');
//
//        Log::info($userData['business'][0]['website']);
//        print_r($userData['id']);
//        StatTracking::where('user_id')
//        echo "id : " . $userData['id'];
//        exit;
//        $userDataa = $this->sessionService->getAuthUserSession();

//        if( $request->has('accessToken') && $request->get('type') == 'googleanalytics') {
        if( $request->query('accessToken') && $request->query('type') == 'googleanalytics') {

            // set analytics token in session to make request.
//            log::info('accessToken');
//            log::info($request->query('accessToken'));
//            log::info('type');
//            log::info($request->query('type'));
            $this->sessionService->setOAuthToken(
                [
//                    'analyticsAccessToken' => $request->get('accessToken'),
                    'analyticsAccessToken' => $request->query('accessToken'),
//                    'accessTokenType' => $request->get('type'),
                    'accessTokenType' => $request->query('type'),
                ]
            );

            // redirecting to url becuause we don't want to show query string parameter in url
            return redirect()->to($request->url());
        }

//        log::info('check auth user $userData');
//        log::info('auth token');
//        log::info($this->sessionService->getOAuthToken());
        $socialToken = (!empty($this->sessionService->getOAuthToken())) ? $this->sessionService->getOAuthToken()->toArray() : '' ;
//        log::info('$socialToken');
//        log::info($socialToken);
        $this->data['socialToken'] = !empty($socialToken['analyticsAccessToken']) ? 1 : 0;
        $this->data['accessTokenType'] = !empty($socialToken['accessTokenType']) ? $socialToken['accessTokenType'] : '';
//        log::info('socialToken');
//        log::info($this->data['socialToken']);
//        log::info('accessTokenType');
//        log::info($this->data['accessTokenType']);


//        Log::info('googleAnalytics');
//        Log::info($this->data['googleAnalytics']);


        $this->data['moduleView'] = 'reviews';
//        log::info('this is loging first time into dashboard');
//        log::info($request);


//            print_r($this->data['reviewsResult']);
//            print_r($businessId);
//            exit;
        $negativeReviews = $this->thirdPartyEntity->getNegativeFeedback($userData['id']);

        $this->data['negativeReviews'] = '';
        if ($negativeReviews['_metadata']['outcomeCode'] == 200) {
            $this->data['negativeReviews'] = $negativeReviews['records'];
        }
//        Log::info('negative review for single check');
//        Log::info($negativeReviews['records']);



        $businessResult = $this->businessEntity->userSelectedBusiness();
        $this->data['userBusiness'] = $businessResult['records'];
//        Log::info($businessResult);
        $this->data['moduleView'] = 'web_audit';



        $socialRequestData = [
            'businessResult'=> $businessResult,
            'social_module_list' => 'all'
        ];
        $socialEntity = new SocialEntity();
        $socialMediaPostsDataResponseData = $socialEntity->getSocialMediaPosts($socialRequestData);

        $this->data['socialMediaPostsData'] = [];

        if ($socialMediaPostsDataResponseData['_metadata']['outcomeCode'] == 200) {
            $this->data['socialMediaPostsData'] = $socialMediaPostsDataResponseData['records'];


        }

        $this->data['userData'] = $userData;
//        print_r($userData);
//        exit();

        $this->data['moduleView'] = 'dashboard';

        $this->data['businessData'] = '';
        $this->data['scanResult'] = '';

        if($userData['discovery_status'] == 0)
        {
            $pageObj = new PageController();
            return $pageObj->onboarding($request);
        }
        else if($userData['discovery_status'] == 1 || $userData['discovery_status'] == 6)
        {
            $this->data['discoveryComplete'] = 'yes';

            $businessData = $ob->businessDirectoryList($request);
            $businessResult = $businessData['records']['userBusiness'];
            $this->data['scanResult'] = $businessData['records']['businessIssues'];
            $this->data['businessResult'] = $businessResult;

            if(!empty($businessResult['website']))
            {
//                Log::info('webResult');
                $webObj = new WebsiteEntity();

                $webResult = $webObj->trackWebsiteStatus($request, true);

                if($webResult['_metadata']['outcomeCode'] == 200)
                {
                    $this->data['webResult'] = $webResult['records'];
//                    Log::info('webResult');
//                    Log::info($this->data['webResult']);
                }
            }
            $socialResult = SocialMediaMaster::where('business_id', $businessResult['business_id'])->orderBy('type')->get()->toArray();


            if(!empty($socialResult))
            {
                $this->data['socialResult'] = $socialResult[0];
            }

            $this->data['twitterResult'] = ( !empty($socialResult[1]) && strtolower($socialResult[1]['type']) == 'twitter') ? $socialResult[1] : '';

            $alertObj = new AdminAlertEntity();

            $widgetItems = $alertObj->list();

            if($widgetItems['_metadata']['outcomeCode'] == 200)
            {
                $this->data['widgetItems'] = $widgetItems['records'];
            }
//            $this->data['widgetItems']

//            print_r($this->data['widgetItems']);
//            exit;

            $keywordObj = new KeywordEntity();
            $keywordData = $keywordObj->getSelectedKeyword($request);

            if($keywordData['_metadata']['outcomeCode'] == 200)
            {
                $this->data['keywords'] = !empty($keywordData['records']['keywordsData']) ? $keywordData['records']['keywordsData'] : '';
            }

            /***************************  CRM Invite sent Start ***********************/

//            $this->data['moduleView'] = 'get_more_reviews';

            $data = ['screen' => 'web'];
            $responseData = $this->crmEntity->customersList($data);

//            print_r($responseData);
//            exit;

            $this->data['records'] = $responseData['records']['customers']['data'];

            $this->data['countryCodes'] = Countries::all()->toArray();

            $thirdPartiesList = $this->crmEntity->getThirdParties($request);

            $this->data['third_parties_list'] = $thirdPartiesList['records'];

            $customerSettingsList = $this->crmEntity->customerSettingsList($request);

            $this->data['reviewRequestSettings'] = $customerSettingsList['records'];

            $this->data['enable_get_reviews'] = $responseData['records']['enable_get_reviews'];

            /***************************  CRM Invite sent End ***********************/


            $sources = thirdPartySources();

            if(!empty($businessData['records']['businessIssues']))
            {
                $sourceExist = array_column($businessData['records']['businessIssues'], 'type');
            }
//print_r($sourceExist);
//        exit;
            foreach($sources as $index => $source)
            {
                $matchedStatus = 0;

                if(!empty($sourceExist))
                {
                    $source = ucwords(strtolower($source));

                    $matched = array_search($source, $sourceExist);

                    if($matched !== false)
                    {
                        $appBusiness = $businessData['records']['businessIssues'][$matched];

                        if($appBusiness['type'] == $source && !empty($appBusiness['name']))
                        {
                            $matchedStatus = 1;
                            $sources[$index] = [
                                'name' => $source, 'status' => 'connected',
                                'data' => $appBusiness
                            ];
                        }
                    }
                }

                if($matchedStatus == 0)
                {
                    $sources[$index] = ['name' => $source, 'status' => 'not_connected'];
                }
            }

            $this->data['sources'] = $sources;

            $statusData = array_column($sources, 'status');

            $incomplete = 0;
            $complete = 0;
            foreach($statusData as $statusVal)
            {
                if($statusVal == 'not_connected')
                {
                    $incomplete++;
                }
                elseif($statusVal == 'connected')
                {
                    $complete++;
                }
            }

//            $this->data['completeListing'] = $complete;
//            $this->data['incompleteListing'] = $incomplete;

            $user = $userData['id'];

            $businessCitations = BusinessCitationList::count('id');
            $userCitations = UserBusinessCitationList::where('user_id', $user)->count('id');

            $completeCitation = $complete + $userCitations;
            $inCompleteCitation = $incomplete + ($businessCitations - $userCitations);

            $this->data['completeListing'] = $completeCitation;
            $this->data['incompleteListing'] = $inCompleteCitation;

            $tiedWIth = 'doctor'.$user.'review';

            $env = config('apikeys.APP_ENV');

            if(strtolower($env) == 'production')
            {
                $category = 'review_production';
            }
            else
            {
                $category = 'review_staging';
            }

            $obj = SendgridEventLogs::where(['tied_up_with' => $tiedWIth, 'category' => $category]);

            $obj1 = clone $obj;
            $obj2 = clone $obj;

            $this->data['requestOpen'] = $obj->where('event', 'open')->count();
            $this->data['requestDelivered'] = $obj1->where('event', 'delivered')->count();

            $campaignObj = new CampaignEntity();
            $this->data['campaignStatsCount'] = $campaignObj->campaignStatsCount()['records'];

//            print_r($this->data);
//            exit;

//            $this->data['click'] = $obj2->where('event', 'click')->count();

        }

        $camp = new CampaignEntity();
        $campaignObj = $camp->getPatientEmailTemplate();

        if(!empty($campaignObj))
        {
            $this->data['campaignId'] = $campaignId = (!empty($campaignObj['id'])) ? $campaignObj['id'] : $campaignObj['parent_id'];
        }

        $userId = $user = $userData['id'];

//        $business_task_open = Task::whereDoesntHave('marketingTasks', function(Builder $query) use ($user) {
//            $query->where('user_id', $user);
//            $query->whereIn('status', ['done', 'skipped', 'paid']);
//        })->count();


        DB::enableQueryLog();
//        $requestedTask = 'open';
//        $business_task_open = Task::with(['category' => function ($category) use ($userId, $requestedTask) {
//            $category->where('show_to_paid', '=', 0);
//            $category->where('type', 'marketing-campaign');
//        }])->where(function ($query) use ($userId) {
//            $query->whereIn('category', function ($catQuery1) {
//                $catQuery1->select('id')->from('category')->where('show_to_paid', '=', 0)->where('type', 'marketing-campaign');
//            });
//            $query->orWhereIn('category', function ($catQuery) use ($userId) {
//                $catQuery->select('category_id')->from('user_task_category')->where('user_id', '=', $userId);
//            });
//        })->whereDoesntHave('marketingTasks', function ($query) use ($userId, $requestedTask) {
//            $query->where('user_id', $userId);
//            $query->whereIn('status', ['done', 'skipped', 'paid']);
//        })->where('sys_status', 1)
//            ->get()->toArray();
//            ->count();

//        print_r(DB::getQueryLog());exit;
//        print_r($business_task_open);
//        exit;

        $current_user = Users::find($user);
        $current_widget_close = $current_user->close_widget;
        $this->data['closeWidget'] = $current_widget_close;

//        print_r($current_widget_close);
////        echo "id : " . $userData['id'];
//        exit;
//        $business_task_open = $current_user->tasks_counter;
//        $business_task_skipped = BusinessTask::where('user_id', $user)->where('status', 'skipped')->count();
//        $business_task_done = BusinessTask::where('user_id', $user)->where('status', 'done')->count();
//
        $this->data['business_task_open'] = 0;
        $this->data['business_task_skipped'] = 0;
        $this->data['business_task_done'] = 0;
        $this->data['viewedSendReviewInviteSettings'] = $current_user->viewed_send_review_invite_settings;

//        print_r($this->data['userData']);
//        exit;
//        $this->data['hidePartials'] = true;
//        $userData['discovery_status'] = 0;
//        $this->data['userData']['discovery_status'] = 0;
//        $this->data['countries'] = Countries::all()->toArray();
//        if($userData['discovery_status'] == 0)
//        {
//            $this->data['hidePartials'] = true;
//        }

        // dd($this->data['enable_get_reviews']);
        return view('layouts.home', $this->data);
    }


    public function testissue1()
    {
        // html decoding issues

        //  $str = "\n    <!doctype html>\n    <html xmlns=\\"http://www.w3.org/1999/xhtml\\" xmlns:v=\\"urn:schemas-microsoft-com:vml\\" xmlns:o=\\"urn:schemas-microsoft-com:office:office\\">\n      <head>\n        <title>\n          \n        </title>\n        <!--[if !mso]><!-- -->\n        <meta http-equiv=\\"X-UA-Compatible\\" content=\\"IE=edge\\">\n        <!--<![endif]-->\n        <meta http-equiv=\\"Content-Type\\" content=\\"text/html; charset=UTF-8\\">\n        <meta name=\\"viewport\\" content=\\"width=device-width, initial-scale=1\\">\n        <style type=\\"text/css\\">\n          #outlook a { padding:0; }\n          .ReadMsgBody { width:100%; }\n          .ExternalClass { width:100%; }\n          .ExternalClass * { line-height:100%; }\n          body { margin:0;padding:0;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%; }\n          table, td { border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt; }\n          img { border:0;height:auto;line-height:100%; outline:none;text-decoration:none;-ms-interpolation-mode:bicubic; }\n          p { display:block;margin:13px 0; }\n        </style>\n        <!--[if !mso]><!-->\n        <style type=\\"text/css\\">\n          @media only screen and (max-width:480px) {\n            @-ms-viewport { width:320px; }\n            @viewport { width:320px; }\n          }\n        </style>\n        <!--<![endif]-->\n        <!--[if mso]>\n        <xml>\n        <o:OfficeDocumentSettings>\n          <o:AllowPNG/>\n          <o:PixelsPerInch>96</o:PixelsPerInch>\n        </o:OfficeDocumentSettings>\n        </xml>\n        <![endif]-->\n        <!--[if lte mso 11]>\n        <style type=\\"text/css\\">\n          .outlook-group-fix { width:100% !important; }\n        </style>\n        <![endif]-->\n        \n      <!--[if !mso]><!-->\n        <link href=\\"https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700\\" rel=\\"stylesheet\\" type=\\"text/css\\">\n<link href=\\"https://fonts.googleapis.com/css?family=Cabin:400,700\\" rel=\\"stylesheet\\" type=\\"text/css\\">\n        <style type=\\"text/css\\">\n          @import url(https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700);\n@import url(https://fonts.googleapis.com/css?family=Cabin:400,700);\n        </style>\n      <!--<![endif]-->\n\n    \n        \n    <style type=\\"text/css\\">\n      @media only screen and (min-width:480px) {\n        .mj-column-per-100 { width:100% !important; max-width: 100%; }\n      }\n    </style>\n    \n  \n        <style type=\\"text/css\\">\n        \n        \n        </style>\n        <style type=\\"text/css\\">.hide_on_mobile { display: none !important;} \n        @media only screen and (min-width: 480px) { .hide_on_mobile { display: block !important;} }\n        .hide_section_on_mobile { display: none !important;} \n        @media only screen and (min-width: 480px) { .hide_section_on_mobile { display: table !important;} }\n        .hide_on_desktop { display: block !important;} \n        @media only screen and (min-width: 480px) { .hide_on_desktop { display: none !important;} }\n        .hide_section_on_desktop { display: table !important;} \n        @media only screen and (min-width: 480px) { .hide_section_on_desktop { display: none !important;} }\n        [owa] .mj-column-per-100 {\n            width: 100%!important;\n          }\n          [owa] .mj-column-per-50 {\n            width: 50%!important;\n          }\n          [owa] .mj-column-per-33 {\n            width: 33.333333333333336%!important;\n          }\n          p {\n              margin: 0px;\n          }\n          @media only print and (min-width:480px) {\n            .mj-column-per-100 { width:100%!important; }\n            .mj-column-per-40 { width:40%!important; }\n            .mj-column-per-60 { width:60%!important; }\n            .mj-column-per-50 { width: 50%!important; }\n            mj-column-per-33 { width: 33.333333333333336%!important; }\n            }</style>\n        \n      </head>\n      <body style=\\"background-color:#FFFFFF;\\">\n        \n        \n      <div style=\\"background-color:#FFFFFF;\\">\n        \n      \n      <!--[if mso | IE]>\n      <table\n         align=\\"center\\" border=\\"0\\" cellpadding=\\"0\\" cellspacing=\\"0\\" class=\\"\\" style=\\"width:600px;\\" width=\\"600\\"\n      >\n        <tr>\n          <td style=\\"line-height:0px;font-size:0px;mso-line-height-rule:exactly;\\">\n      <![endif]-->\n    \n      \n      <div style=\\"Margin:0px auto;max-width:600px;\\">\n        \n        <table align=\\"center\\" border=\\"0\\" cellpadding=\\"0\\" cellspacing=\\"0\\" role=\\"presentation\\" style=\\"width:100%;\\">\n          <tbody>\n            <tr>\n              <td style=\\"direction:ltr;font-size:0px;padding:9px 0px 9px 0px;text-align:center;vertical-align:top;\\">\n                <!--[if mso | IE]>\n                  <table role=\\"presentation\\" border=\\"0\\" cellpadding=\\"0\\" cellspacing=\\"0\\">\n                \n        <tr>\n      \n            <td\n               class=\\"\\" style=\\"vertical-align:top;width:600px;\\"\n            >\n          <![endif]-->\n            \n      <div class=\\"mj-column-per-100 outlook-group-fix\\" style=\\"font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;\\">\n        \n      <table border=\\"0\\" cellpadding=\\"0\\" cellspacing=\\"0\\" role=\\"presentation\\" style=\\"vertical-align:top;\\" width=\\"100%\\">\n        \n            <tr>\n              <td align=\\"left\\" style=\\"font-size:0px;padding:15px 15px 15px 15px;word-break:break-word;\\">\n                \n      <div style=\\"font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:11px;line-height:1.5;text-align:left;color:#000000;\\">\n        <p>This is your new text block with first paragraph.</p>\n<p><a style=\\"/* text-decoration: none !important; */    background-color: none !important; background-color: none !important;\\" href=\\"%%Doctor_Website_Url%%\\"><img class=\\"template-token-tag\\" style=\\"max-width: 250px; max-height: 60px;\\" src=\\"%%Doctor_Logo%%\\" data-token-name=\\"Doctor_Logo\\"></a></p>\n<p> </p>\n<p> </p>\n<p><span class=\\"template-token-tag\\" data-token-name=\\"Doctor_Unsubscribe_handler\\"><a href=\\"https://nichepractice.test/unsubscribe/33\\">Unsubscribe</a></span></p>\n<p> </p>\n<p> </p>\n<p><span class=\\"template-token-tag\\" data-token=\\"Doctor_Practice\\">Health Sciences Centre Winnipeg</span></p>\n<p> </p>\n<p><span class=\\"template-token-tag\\" data-token=\\"Doctor_First_Name\\">Abdul</span></p>\n<p> </p>\n<p><span class=\\"template-token-tag\\" data-token=\\"Doctor_Last_Name\\">Rehman k</span></p>\n<p> </p>\n<p><span class=\\"template-token-tag\\" data-token=\\"Doctor_Phone\\">+1-303-499-7111</span></p>\n<p><a href=\\"tel:+1 (303) 499-711\\">+1 (303) 499-711</a></p>\n<p> </p>\n<p> </p>\n<p><a href=\\"tel:13034997111\\">+13034997111</a></p>\n<p> </p>\n<p><a href=\\"tel:13034997111\\">tsti</a></p>\n<p> </p>\n<p><a title=\\"wow\\" href=\\"+13034997111\\">+13034997111</a></p>\n<p> </p>\n<p><a href=\\"mailto:yourmail@mysite.com\\">yourmail@mysite.com</a></p>\n      </div>\n    \n              </td>\n            </tr>\n          \n      </table>\n    \n      </div>\n    \n          <!--[if mso | IE]>\n            </td>\n          \n        </tr>\n      \n                  </table>\n                <![endif]-->\n              </td>\n            </tr>\n          </tbody>\n        </table>\n        \n      </div>\n    \n      \n      <!--[if mso | IE]>\n          </td>\n        </tr>\n      </table>\n      <![endif]-->\n    \n    \n      </div>\n    \n      </body>\n    </html>\n";
//        $client = new Client();
//        $url = '';
//        $response = $client->request('POST', 'https://o3s5p0dx21.execute-api.eu-west-1.amazonaws.com/v4/save',
//            [
//                'json' => $sendGridData,
//                'headers'  => [
//                    'Authorization' => 'Bearer '.$sendgridApi
//                ]
//            ]
//        );

    }



    public function testThing(Request $request)
    {
//        $data = array();
//
//        $payload = json_encode($data);
//
//        $shortcode = 'CAodFgLgeBJ';
//        $ch = curl_init('https://www.instagram.com/p/'.$shortcode.'/?__a=1');
//
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
//        curl_setopt($ch, CURLOPT_POST, true);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//                'Content-Type: application/json'
//        ));
//
//        // Submit the POST request
//        $generate_token = curl_exec($ch);
//
//        // Close cURL session handle
//        curl_close($ch);
//
//
//        print_r($generate_token);
//        exit;

        try {

            $shortcode = 'CAodFgLgeBJ';
//        $url = 'https://www.instagram.com/p/'.$shortcode.'/?__a=1';
            $url = 'https://www.instagram.com/p/'.$shortcode;
//        $url = $shortcode.'/?__a=1';
//        /?__a=1
            // guzzle request
            // $response = $this->api($url);
            $client = new Client();
            $type = 'GET';

//            $client = new \GuzzleHttp\Client([
//                'base_uri' => 'http://localhost:8000',
//                'defaults' => [
//                    'exceptions' => false
//                ]
//            ]);

//        $response = $client->get($url);

//        $response = $client->request($type, $url);

            $response = $client->request($type, $url,
                [
                    'query' => [
                        '__a' => 1
                    ],
                    'debug' => true,
                    'timeout'  => 50,
                ]
            );


            // return $response;
            $response = json_decode($response->getBody()->getContents(), true);

            dd($response);
//        exit;
        }catch (Exception $e)
        {
            print_r($e->getMessage());
        }
    }
}
