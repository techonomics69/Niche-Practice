<?php

namespace Modules\User\Http\Controllers;

use Log;
use Modules\User\Models\CreditsPlan;
use Modules\User\Models\UserCreditsPurchaseHistory;
use Redirect;
// use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\User\Models\Users;
// use Modules\User\Models\PasswordReset;
use App\Mail\PasswordResetMail;
use App\Services\SessionService;
use App\Mail\NotificationSendToReferer;
use Exception;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Mockery\Generator\StringManipulation\Pass\Pass;
use Modules\User\Entities\UserEntity;
use Modules\User\Models\PasswordReset;
use Modules\Business\Entities\BusinessEntity;
use Modules\ThirdParty\Models\SocialMediaMaster;
use Modules\User\Entities\Billing\SubscriptionManagerEntity;
use Modules\Business\Models\Referalemail;

class UserController extends Controller
{
    protected $userEntity;

    protected $data;

    protected $sessionService;

    protected $billingEntity;

    protected $businessEntity;

    /**
     * AuthEntity constructor.
     */
    public function __construct()
    {
        $this->businessEntity = new BusinessEntity();
        $this->userEntity = new UserEntity();
        $this->sessionService = new SessionService();
        $this->billingEntity = new SubscriptionManagerEntity();
    }

    public function userProfileLayout()
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;

        return view('layouts.user-profile', $this->data);
    }

    public function userPracticeProfile(Request $request)
    {
        $authResponse = '';
        if ($request->has('accessToken') && $request->get('type') == 'facebook') {
            // set analytics token in session to make request.
            $this->sessionService->setOAuthToken(
                [
                    'businessAccessToken' => $request->get('accessToken'),
                    'accessTokenType' => $request->get('type'),
                ]
            );
            // redirecting to url because we don't want to show query string parameter in url
            return redirect()->to($request->url());
        } else if ($request->has('accessToken') && $request->get('type') != '') {
            $authResponse = $request->get('accessToken');
            $this->data['authType'] = $request->get('type');
            $this->data['authCode'] = (!empty($request->get('code'))) ? $request->get('code') : '';
            $this->data['authMessage'] = (!empty($request->get('message'))) ? $request->get('message') : '';
        }

        $socialToken = $this->sessionService->getOAuthToken();

        $this->data['authResponse'] = $authResponse;
        $this->data['socialToken'] = '';
        if (!empty($socialToken['accessTokenType']) && $socialToken['accessTokenType'] == 'facebook') {
            $this->data['socialToken'] = !empty($socialToken['businessAccessToken']) ? 1 : 0;
        }

        $this->data['accessTokenType'] = !empty($socialToken['accessTokenType']) ? $socialToken['accessTokenType'] : '';

        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;

        $this->data['userBusiness'] = $userData['business'][0];
        $businessId = $userData['business'][0]['business_id'];

        $businessData = $this->businessEntity->businessDirectoryList($request);

        $thirdPartyData = $businessData['records']['businessIssues'];


        $appRecord = [];

        $sources = moduleSocialList();

        $socialMedia = SocialMediaMaster::where('business_id', $businessId)
            ->where('access_token', '!=', '')
            ->get()->toArray();

        if (!empty($socialMedia)) {
            $sourceExist = array_column($socialMedia, 'type');
        }

        foreach ($sources as $index => $source) {
            $matchedStatus = 0;

            if (!empty($sourceExist)) {
                $source = ucwords(strtolower($source));

                $matched = array_search($source, $sourceExist);
//                print_r($sourceExist);
//                exit;

//                $sources[$index] =
                if ($matched !== false) {
                    $appBusiness = $socialMedia[$matched];

                    if ($appBusiness['type'] == $source && !empty($appBusiness['name'])) {
                        $matchedStatus = 1;
                        $appRecord[$source] = ['type' => $source, 'status' => 'connected'];
                    }
                }
            }

            if ($matchedStatus == 0) {
                $appRecord[$source] = ['type' => $source, 'status' => 'not_connected'];
            }
        }

        $appRecord['Google'] = [
            'status' => 'not_connected',
            'type' => 'Google Places',
        ];

        foreach ($thirdPartyData as $thirdPartyApp) {
            if (strtolower(str_replace(" ", "", $thirdPartyApp['type'])) == 'googleplaces') {
                if (!empty($thirdPartyApp['name'])) {
                    $appRecord['Google'] = [
                        'status' => 'connected',
                        'type' => $thirdPartyApp['type'],
                    ];
                }
                break;
            }
        }

        $this->data['appRecord'] = $appRecord;
//        print_r($appRecord);
//        exit;
        return view('layouts.practice-profile', $this->data);
    }

//    public function userPracticeProfile(Request $request)
//    {
//
//        if ($request->has('accessToken') && $request->get('type') == 'facebook') {
//            // set analytics token in session to make request.
//            $this->sessionService->setOAuthToken(
//                [
//                    'businessAccessToken' => $request->get('accessToken'),
//                    'accessTokenType' => $request->get('type'),
//                ]
//            );
//            // redirecting to url because we don't want to show query string parameter in url
//            return redirect()->to($request->url());
//        }
//        $socialToken = $this->sessionService->getOAuthToken();
//
//        $this->data['socialToken'] = '';
//        if(!empty($socialToken['accessTokenType']) && $socialToken['accessTokenType'] == 'facebook')
//        {
//            $this->data['socialToken'] = !empty($socialToken['businessAccessToken']) ? 1 : 0;
//        }
//
//        $this->data['accessTokenType'] = !empty($socialToken['accessTokenType']) ? $socialToken['accessTokenType'] : '';
//
//        $userData = $this->sessionService->getAuthUserSession();
//        $this->data['userData'] = $userData;
//
//        $businessData = $this->businessEntity->businessDirectoryList($request);
//
////        print_r($businessData);
////        exit;
//
//        $sources = thirdPartySources();
//
//        $sources = [
//            'Yelp',
//            'Google Places',
//            'Facebook'
//        ];
//
//        if(!empty($businessData['records']['businessIssues']))
//        {
//            $sourceExist = array_column($businessData['records']['businessIssues'], 'type');
//        }
////print_r($sourceExist);
////        exit;
//        foreach($sources as $index => $source)
//        {
//            $matchedStatus = 0;
//
//            if(!empty($sourceExist))
//            {
////                $source = strtolower($source);
//
//                $source = ucwords(strtolower($source));
//
////                if(strtolower($source) == 'healthgrades')
////                {
////                    $source = 'Healthgrades';
////                }
////                elseif(strtolower($source) == 'ratemd')
////                {
////                    $source = 'Ratemd';
////                }
//
//
//                $matched = array_search($source, $sourceExist);
//
////                $sources[$index] =
//                if($matched !== false)
//                {
//                    $appBusiness = $businessData['records']['businessIssues'][$matched];
//
//                    if($appBusiness['type'] == $source && !empty($appBusiness['name']))
//                    {
//                        $matchedStatus = 1;
//                        $sources[$index] = ['name' => $source, 'status' => 'connected'];
//                    }
//                }
//            }
//
//
//            if($matchedStatus == 0)
//            {
//                $sources[$index] = ['name' => $source, 'status' => 'not_connected'];
//            }
//
////            if($source)
//        }
////echo "sources";
////        print_r($sources);
////        exit;
//        $this->data['sources'] = $sources;
//
//        return view('layouts.practice-profile', $this->data);
//    }

    /**
     * route: upgrade
     */
    public function upgrade()
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;
        $this->data['moduleView'] = 'upgrade';

        $this->data['subscribedPackageDetail'] = $this->billingEntity->getSubscribedPackage($userData['id']);

//        echo $userData['id'];

//        print_r($this->data['subscribedPackageDetail']);
//        exit;

        return view('layouts.upgrade', $this->data);
    }

    public function upgradeLiveTest()
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;
        $this->data['moduleView'] = 'upgrade';

        $this->data['subscribedPackageDetail'] = [];


//        echo $userData['id'];

//        print_r($this->data['subscribedPackageDetail']);
//        exit;

        return view('layouts.upgrade-live', $this->data);
    }

    public function credits(Request $request)
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;
        $this->data['moduleView'] = 'credits';

        $this->data['creditPlan'] = CreditsPlan::get()->toArray();

        if (!empty($request->get('token')) && !empty($request->get('session_id'))) {
            $this->billingEntity->updateCreditsStatus($request);

            $condition = [
                'token' => $request->get('token'), 'session_id' => $request->get('session_id')
            ];

            $recentPurchase = UserCreditsPurchaseHistory::where($condition)->get()->toArray();

            $credits = 0;
            $orderCredits = 0;
            if (!empty($recentPurchase[0])) {
                $credits = $this->billingEntity->userCreditsBalance();
                $orderCredits = $recentPurchase[0]['credits'];
            }

            return redirect()->route('credits', ['purchase' => 'success_complete', 'credits' => $credits, 'order_credits' => $orderCredits]);
        }

        return view('layouts.credits', $this->data);
    }

    public function sms(Request $request)
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;
        $this->data['moduleView'] = 'SMS';

        $this->data['creditPlan'] = CreditsPlan::get()->toArray();
//        $this->data['creditPlan'] = '';

        if (!empty($request->get('token')) && !empty($request->get('session_id'))) {
            $this->billingEntity->updateCreditsStatus($request);

            $condition = [
                'token' => $request->get('token'), 'session_id' => $request->get('session_id')
            ];

            $recentPurchase = UserCreditsPurchaseHistory::where($condition)->get()->toArray();

            $credits = 0;
            $orderCredits = 0;
            if (!empty($recentPurchase[0])) {
                $credits = $this->billingEntity->userCreditsBalance();
                $orderCredits = $recentPurchase[0]['credits'];
            }

            return redirect()->route('credits', ['purchase' => 'success_complete', 'credits' => $credits, 'order_credits' => $orderCredits]);
        }
//        return view ('layouts.sms', $this->data);
        return view('layouts.sms', $this->data);
    }

    public function accountDelete(Request $request)
    {
        $request->session()->flush();

        return view('auth.account-delete');
    }

    /**
     * Show the form for creating a new resource
     * @return Response
     */
    public function create(Request $request)
    {

//        $userData = $this->sessionService->getAuthUserSession();
//        Log::info('create user data check');
//        Log::info($userData);
        $result = $this->userEntity->getIndustry();

        $this->data['industry'] = '';
        if ($result['_metadata']['outcomeCode'] == 200) {
            $this->data['industry'] = $result['records'];
        }

        return view('auth.register', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response 200, 404, 1
     */
    public function store(Request $request)
    {
        Log::info("register store");
        $result = $this->userEntity->register($request);
//        Log::info($request);
//        Log::info($result);

//        Log::info(json_encode($request->all()));

        $statusData = [
            'status_code' => $result['_metadata']['outcomeCode'],
            'status_message' => $result['_metadata']['message'],
            'data' => $result['records'],
            'errors' => '',
        ];

        Log::info("register END");

        LOG::INFO('BEFORE');


        if (!empty($request['u_id'])) {

            log::info('into database updating referal status');
            $user_id = $request['u_id'];
//            log::info('user_id');
//            log::info($user_id);
            $findReferer = Referalemail::where('user_id', $user_id)->where('email', $request['email'])->update(['onboarding_status' => 1]);
            $refererEmail = Users::where('id', $user_id)->first();
            $email = $refererEmail->email;
            $mail = Mail::to($email)->send(new NotificationSendToReferer($request['email']));
//           log::info('here comes after updaing referer');
//           log::info($findReferer);
//            log::info('here comes referee');
//            log::info($refererEmail->email);
            if (Mail::failures()) {
                log::info('i am failed to send referee email');
            } else {
                log::info('i am not failed to send referee email');
            }
        }
        LOG::INFO('AFTER');

        return json_encode($statusData);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('user::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('user::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function showLogin()
    {
        $this->data['hidePartials'] = true;

//        if(!empty($this->data['hidePartials']))
//        {
//            echo "if";
//        }
//
//        exit;
        return view('auth.login', $this->data);
    }


    public function showForgotPasswordLayout()
    {
        $this->data['hidePartials'] = true;

//        if(!empty($this->data['hidePartials']))
//        {
//            echo "if";
//        }
//
//        exit;

        return view('auth.forgot-password', $this->data);
    }

    public function sendResetLinkEmail(Request $request)
    {

        // dd($request->all());
        $user = Users::where('email', $request->email)->whereNull('deleted_at')->first();

        if ($user) {
            # code...
            $token = rand(10000000, 99999999);
            $PasswordReset = PasswordReset::create([
                'email' => $user->email,
                'token' => $token,
                'created_at' => now()
            ]);

            Mail::to($request->email)->send(new PasswordResetMail($user->email, $token));

            if ($PasswordReset) {

                $statusData = [
                    'status_code' => '200',
                    'status_message' => 'Reset link has been sent to you in email.',
                ];

                return json_encode($statusData);
            }
        } else {
            $statusData = [
                'status_code' => '302',
//                'status_message' => 'Your account may not exist or deleted',
                'status_message' => 'We could not find an account for the email address you entered.',
            ];

            return json_encode($statusData);
        }
        // $user = Users::where('email', $request->email)->first();


    }

    public function showResetForm(Request $request, $token)
    {
        # code...
        // dd($request->all());
        $PasswordReset = PasswordReset::where('token', $token)->first();

        $this->data['hidePartials'] = true;
        // dd()
        $this->data['PasswordReset'] = $PasswordReset->email;
        $this->data['token'] = $token;
        $this->data['email'] = $request->email;

        return view('password.resetpassword', $this->data);
    }

    public function passwordUpdate(Request $request)
    {
        # code...
        // dd($request->all());
        $PasswordReset = PasswordReset::where('token', $request->token)->where('email', $request->email)->first();

        if ($PasswordReset) {
            # code...
            Users::where('email', $request->email)->update([
                'password' => bcrypt($request->password)
            ]);
            PasswordReset::where('email', $request->email)->delete();

            $statusData = [
                'status_code' => '200',
                'status_message' => 'Your password is reset',
            ];
            return json_encode($statusData);
        } else {
            $statusData = [
                'status_code' => '200',
                'status_message' => 'Reset link has been sent to you in email.',
            ];

            return json_encode($statusData);
            # code...
        }


    }

    public function login(Request $request)
    {
//        log::info('logggin');
        $result = $this->userEntity->login($request);
//        log::info('request');
//        log::info($request);
        Users::where('id', $request['user_id'])->update(['login_status' => 1]);
        $statusData = [
            'status_code' => $result['_metadata']['outcomeCode'],
            'status_message' => $result['_metadata']['message'],
            'data' => $result['records'],
            'errors' => $result['errors']
        ];
        return json_encode($statusData);
    }

    public function getNiches(Request $request)
    {
        $result = $this->userEntity->getIndustryNiches($request);

        $responseCode = $result['_metadata']['outcomeCode'];


        $statusData = [
            'status_code' => $responseCode,
            'status_message' => '',
            'data' => $result['records'],
            'errors' => '',
        ];

        return json_encode($statusData);
    }

    public function logOut(Request $request)
    {

        $userSession = $this->sessionService->getAuthUserSession();
//        log::info('$userSession');
//        log::info($userSession);
        if (!empty($userSession)) {
            Users::where('id', $userSession['id'])->update(['login_status' => 0]);
        }
        $request->session()->forget(['user_data', 'auth_token', 'social_token']);
//        $request->session()->flush();

        return Redirect('login')
            ->with('messageCode', 200)
            ->with('message', 'Successfully logged out.');
    }

    public function oauthManager(Request $request)
    {
//        Log::info("oauth");
        if (empty($request->get('type'))) {
            return Redirect::route('social-posts');
        }

//        $userData = $this->sessionService->getAuthUserSession();
//        $token = $userData['token'];
        $type = $request->get('type');
        $businessId = $request->get('business_id');

        $referType = (!empty($request->get('referType'))) ? $request->get('referType') : '';

        if (!empty($referType)) {
            if ($request->has('promotion')) {
                $url = getDomain() . '/api/' . $type . '/login?referType=' . $referType . '&business_id=' . $businessId . '&promotion=' . $request->get('promotion');
            } else {
                $url = getDomain() . '/api/' . $type . '/login?referType=' . $referType . '&business_id=' . $businessId;
            }
        } else {
            $url = getDomain() . '/api/' . $type . '/login?business_id=' . $businessId;
        }

        return Redirect::to($url);
    }

    public function videoSeen(Request $request)
    {
        # code...
        $result = $this->userEntity->videoSeen($request);

        $responseCode = $result['_metadata']['outcomeCode'];

        $statusData = [
            'status_code' => $responseCode,
            'status_message' => '',
            'data' => $result['records'],
            'errors' => '',
        ];

        return json_encode($statusData);
    }

    public function viewedSendReviewInviteSettings(Request $request)
    {
        # code...
        $result = $this->userEntity->viewedSendReviewInviteSettings($request);

        $responseCode = $result['_metadata']['outcomeCode'];

        $statusData = [
            'status_code' => $responseCode,
            'status_message' => '',
            'data' => $result['records'],
            'errors' => '',
        ];

        return json_encode($statusData);
    }
}
