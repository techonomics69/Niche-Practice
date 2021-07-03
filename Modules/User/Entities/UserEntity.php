<?php

namespace Modules\User\Entities;

use DB;
use Log;
use Mail;
use Config;
use App\User;
use Carbon\Carbon;
use Modules\User\Models\UserMeta;
use Redirect;
use Exception;
use GuzzleHttp\Client;
use App\Traits\UserAccess;
use Illuminate\Http\Request;
use Modules\User\Models\Users;
use App\Entities\AbstractEntity;
use App\Mail\NotifyAdminNewUser;
use App\Services\SessionService;
use Modules\CRM\Models\Recipient;
use Modules\Business\Models\Niches;
use Modules\CRM\Entities\CRMEntity;
use Modules\CRM\Models\CrmSettings;
use Illuminate\Support\Facades\Hash;
use Modules\Business\Models\Business;
use Modules\Business\Models\Industry;
use Modules\User\Models\UserRolesREF;
use Modules\User\Models\Smsrequestlog;
use App\Mail\CreateWelcomeRegisterEmail;
use Modules\User\Models\Emailrequestlog;
use Modules\User\Models\UserSendGridLogs;
use Modules\Business\Entities\BusinessEntity;
use Modules\User\Entities\Billing\SubscriptionManagerEntity;
use Modules\User\Services\Validations\Auth\AuthLoginValidator;
use Modules\Admin\Models\MarketingAssociation;
/**
 * Class AuthEntity
 * @package Modules\Auth\Entities
 */
class UserEntity extends AbstractEntity
{
    use UserAccess;

    protected $loginValidator;

    protected $sessionService;

    protected $sendGridKey;

    /**
     * AuthEntity constructor.
     */
    public function __construct()
    {
//        $this->authUerInfo = new UserAuthValidator();
        $this->loginValidator = new AuthLoginValidator(resolve('validator'));
        $this->sessionService = new SessionService();

        $this->sendGridKey = Config::get('apikeys.sendgrid_api_key');
    }

    public function saveUserSendGrid($userId, $userData = '', $listId = '')
    {
//        Log::info("saveUserSendGrid");
        $userData = Users::with('business')->where('id', $userId)->first();

        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'https://api.sendgrid.com/v3/'
        ]);

        $data = [];
        if(!empty($listId))
        {
            $sendGridData['list_ids'] = [$listId];
            $data['list_id'] = $listId;
        }

        $businessDetail = $userData['business'][0];

        $sendGridData['contacts'][] =  [
            "email" => $userData['email'],
            "first_name" => $userData['first_name'],
            "last_name" => $userData['last_name'],
            "address_line_1" => $businessDetail['address'],
            "address_line_2" => '',
            "city" => $businessDetail['city'],
            "country" => '',
            "postal_code" => $businessDetail['zip_code'],
            "state_province_region" => $businessDetail['state']
        ];

        $sendgridApi = $this->sendGridKey;

        $data['user_id'] = $userId;
        $data['source'] = 'registration';

        try {
            $response = $client->request('PUT', 'marketing/contacts',
                [
                    'json' => $sendGridData,
                    'headers'  => [
                        'Authorization' => 'Bearer '.$sendgridApi
                    ]
                ]
            );

            $responseData = json_decode($response->getBody()->getContents(), true);

            $data['job_id'] = (!empty($responseData['job_id'])) ? $responseData['job_id'] : '';
            $data['logs'] = 'success_call_'.$userId;
        }
        catch(Exception $e)
        {
            Log::info($e);
            if($e->getResponse()->getStatusCode() == 400)
            {
                $responseBody = $e->getResponse()->getBody()->getContents();

                $data['logs'] = 'error_call code => ' . $responseBody;
            }
            else
            {
                $data['logs'] = 'error_call_'.$userId .' code => ' . $e->getCode() . ' <= messageexception => ' . $e->getMessage();
            }
        }

        UserSendGridLogs::create($data);
    }

    public function register($request)
    {
        try
        {
            $user = Users::where('email', $request->get('email'))->first();

            if(!empty($user))
            {
                return $this->helpError(4, 'This email exists. Please select a different email address.');
            }

            return DB::transaction(function () use ($user, $request)
            {
                $data = $request->all();
                $data['password'] = Hash::make($request->password);

                $data['trial_ends_at'] = date('Y-m-d', strtotime(' +13 day'));

//                Log::info("data creation");
//                Log::info($data);

                $userResult = Users::create($data);

//                $userResult = User::create(
//                    [
//                        'first_name', $request->first_name,
//                        'last_name', $request->last_name,
//                        'email', $request->email,
//                        'password', Hash::make($request->password)
//                    ]
//                );

//                Log::info("user Result " . json_encode($userResult));

                $userID = $userResult['id'];
                // adding default setting of Emailrequestlog while registeration
                $Emailrequestlog = Emailrequestlog::create([
                    'remaining'=> 1000,
                    'maximum' => 1000,
                    'users_id' => $userID
                ]);

                // adding default setting of Smsrequestlog while registeration
                $Smsrequestlog = Smsrequestlog::create([
                    'remaining'=> 10,
                    'maximum' => 10,
                    'users_id' => $userID
                ]);

                    $UserRolesREF = UserRolesREF::create(
                        [
                            'user_id' => $userID,
                            'role_id' => 2
                        ]
                    );

                    $businessAccess = new BusinessEntity();

                    $requestAppend = [
                        'user_id' => $userID,
                    ];
                    $request->merge($requestAppend);

                    $bResult = $businessAccess->registerBusiness($request);

                // Log::info("Email " . $request->email);

                // Free Trial doctors
                $this->saveUserSendGrid($userID, '', '2c2e72ee-ef1b-430f-8afe-987f1d51d2f9');

                try
                {
                    $userBusiness = Business::with([
                        'niche' => function ($q) {
                            $q->with('industry');
                        }
                    ])->where('user_id', $userID)->first();

                    $createdAt = $userResult['created_at'];
                    $registered = Date('d-M-Y H:i', strtotime($createdAt));
                    $firstName = $request->get('first_name');
                    $lastName = $request->get('last_name');
                    $BusinessName = $userBusiness['practice_name'];
                    $Useremail = $request->get('email');
                    $niche = $userBusiness['niche']['niche'];
                    $plan = $userBusiness['niche']['industry']['name'];

                    Mail::to('nichepractice1@gmail.com')->send(new NotifyAdminNewUser($firstName, $lastName, $BusinessName, $Useremail, $registered, $niche, $plan));
                }
                catch(Exception $e)
                {
                    Log::info("admin new user mail failure -> " . $e->getMessage() . ' > ' . $e->getLine() . ' > ' . $e->getCode());
                }

//                try
//                {
//                    Mail::to($request->email)->send(new CreateWelcomeRegisterEmail($request->first_name, $request->email));
//                }
//                catch(Exception $e)
//                {
//                    Log::info("mail failure -> " . $e->getMessage() . ' > ' . $e->getLine() . ' > ' . $e->getCode());
//                }

                return $this->helpReturn('Registration completed.');
            });
        }
        catch(Exception $e)
        {
            Log::info("register -> " . $e->getMessage() . ' > ' . $e->getLine() . ' > ' . $e->getCode());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function login($request)
    {
        $data = $request->except('source');

        if (!$this->loginValidator->with($data)->passes()) {
//            Log::info("login");
//            Log::info($request->all());
//            Log::info($this->loginValidator->errors());
            return $this->helpError(2, "Fields are required to login.", $this->loginValidator->errors());
        }

        $email = $request->email;
        $password = $request->password;

//        $user = Users::with('userRole')
//            ->where('email', $email)
//            ->where(
//                function($query) {
//                    $query->Where('deleted_at','');
//                    $query->orWhereNull('deleted_at');
//                })
//            ->first();

        $user = Users::with('userRole')
            ->where('email', $email)
            ->whereNull('deleted_at')
            ->first();

//        Log::info("user");
//        Log::info($user);

        if(empty($user))
        {
//            return $this->helpError(3, "Record not found.");
//            We couldn't find an account with the email address you entered. Please Sign Up.
        return $this->helpError(3, " We couldn't find an account with the email address you entered. Please ");
        }

        $isMatced = Hash::check($password, $user->password);

        $userModified = $user->toArray();

//        Log::info("isMatced $isMatced");
//        Log::info("user_role ");
//        Log::info($userModified['user_role']);

        if($isMatced == 1 && $userModified['user_role'][0]['slug'] == 'user')
//        if($isMatced == 1)
        {

//            Log::info("user account status ");
//            Log::info($user['account_status']);
            if($user['account_status'] == 'deleted')
            {
                return $this->helpError(403, "Your account has been deleted. Please contact support");
            }

//            Log::info("user account status 01");

            $subscriptionStatus = $this->subscriptionStatusCheck($user['id']);
//            Log::info($subscriptionStatus);

            if ($subscriptionStatus['subscription_expired'] == true) {
                if($subscriptionStatus['subscription_type'] == 'paid')
                {
                    return $this->helpError(3, "Your subscription has expired. Please contact support.");
                }
                else
                {
                    return $this->helpError(3, "Your trial account has expired. Please contact support.");
                }
            }

            $userBusiness = $user->business;

            $phone = '';
            if(!empty($userBusiness))
            {
                $user['business'] = $userBusiness;
                $user['discovery_status'] = $userBusiness[0]['discovery_status'];
                $phone = $userBusiness[0]['phone'];

                if(empty( $userBusiness[0]['email']) )
                {
                    Business::where('user_id', $user['id'])->update([
                        'email' => $email
                    ]);

                    $user['business'][0]['email'] = $email;
                }
            }

//            $user['trial_remaining_days'] = $subscriptionStatus['trial_remaining_days'];
            $user['subscriptionStatus'] = $subscriptionStatus;

            $this->sessionService->setAuthUserSession($user->toArray());
            $userID = $user['id'];

            $crmsetting = CrmSettings::where('user_id', $userID)->first();

            if( empty($crmsetting) ) {
                $crmSettingResult = CrmSettings::create( [
                    'user_id' => $userID,
                    'enable_get_reviews' => 'Yes',
                    'smart_routing' => 'Enable',
                    'sending_option' => '1'
                ]);

                if(!empty($crmSettingResult['id']))
                {

                }
            }

            $crmObj = new CRMEntity();

            $firstName = $user['first_name'];
            $lastName = $user['last_name'];

            $requestAppend = [
                'user_id' => $userID,
                'email' => $email,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'phone_number' => $phone,
                'smart_routing' => 'Enable',
                'user_ref_id' => $userID
            ];
            $request->merge($requestAppend);
            $crmObj->addPatientCustomerN($request);


            $sub = new SubscriptionManagerEntity();
            $sub->updateCreditsSession();


            return $this->helpReturn('You are successfully logged-in');
        }

        return $this->helpError(36, "Incorrect email or password.");
    }

    public function superLogin($request)
    {
        try
        {
        $email = $request->email;

        $user = Users::with('userRole')->where('email', $email)
                ->first();

        if(empty($user))
        {
            return $this->helpError(3, "Record not found.");
        }

        $isMatced = 1;

        $userModified = $user->toArray();

//        Log::info("isMatced $isMatced");
//        Log::info("user_role ");
//        Log::info($userModified['user_role']);

        if($isMatced == 1 && $userModified['user_role'][0]['slug'] == 'user')
        {
            $userBusiness = $user->business;

            $phone = '';
            if(!empty($userBusiness))
            {
                $user['business'] = $userBusiness;
                $user['discovery_status'] = $userBusiness[0]['discovery_status'];
                $phone = $userBusiness[0]['phone'];

                if(empty( $userBusiness[0]['email']) )
                {
                    Business::where('user_id', $user['id'])->update([
                        'email' => $email
                    ]);

                    $user['business'][0]['email'] = $email;
                }
            }

            $subscriptionStatus = $this->subscriptionStatusCheck($user['id']);
            $user['subscriptionStatus'] = $subscriptionStatus;

            $this->sessionService->setAuthUserSession($user->toArray());
            $userID = $user['id'];

            $sub = new SubscriptionManagerEntity();
            $sub->updateCreditsSession();

            $crmsetting = CrmSettings::where('user_id', $userID)->first();

            if( empty($crmsetting) ) {
                $crmSettingResult = CrmSettings::create( [
                    'user_id' => $userID,
                    'enable_get_reviews' => 'Yes',
                    'smart_routing' => 'Enable',
                    'sending_option' => '1'
                ]);
            }

            $crmObj = new CRMEntity();

            $firstName = $user['first_name'];
            $lastName = $user['last_name'];

            $requestAppend = [
                'user_id' => $userID,
                'email' => $email,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'phone_number' => $phone,
                'smart_routing' => 'Enable',
                'user_ref_id' => $userID
            ];
            $request->merge($requestAppend);
            $crmObj->addPatientCustomerN($request);

            return $this->helpReturn('You are successfully logged-in');
        }

        return $this->helpError(36, "Unable to login in this account.");
        }catch(Exception $e)
        {
            Log::info("superlogin -> " . $e->getMessage() . ' > ' . $e->getLine() . ' > ' . $e->getCode());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function updateNewPassword($request)
    {
        $userData = $this->sessionService->getAuthUserSession();
        $user = Users::where('email', $userData['email'])->first();

        if (!Hash::check($request->current_password, $user->password))
        {
            return $this->helpError(404, 'Your old password is not matched with current password.');
        }

        $data['password'] = Hash::make($request->password);

        $user->update($data);

        return $this->helpReturn('Password changed successfully.');
    }

    public function userProfileUpdate($request)
    {
        try
        {
            $user = Users::where('email', $request->get('email'))->first();

            if(empty($user))
            {
                return $this->helpError(404, 'No record exist.');
            }

            if(!empty($request->get('grant')) && $request->get('grant') == 'only_user')
            {
                $data = $request->all();

                $user->update($data);

                $userID = $user['id'];

                return $this->helpReturn('Your profile updated.');
            }
            else
            {
                return DB::transaction(function () use ($user, $request)
                {
                    $data = $request->all();

                    $user->update($data);

                    $userID = $user['id'];

                    Business::where('user_id', $userID)
                        ->update(
                            ['phone' => $data['phone']]
                        );

                    return $this->helpReturn('Your profile updated.');
                });
            }
        }
        catch(Exception $e)
        {
            Log::info("register -> " . $e->getMessage() . ' > ' . $e->getLine() . ' > ' . $e->getCode());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function deactivateUserAccount($request)
    {
        try
        {
            $user = Users::where('email', $request->get('email'))->first();

            if(empty($user))
            {
                return $this->helpError(404, 'No record exist.');
            }

//            $data['account_status'] = $status;
//            $data['leaving_subject'] = $request->leavingTitle;
//            $data['leaving_note'] = $request->leavingNote;

//            Log::info("data");
//            Log::info($data);

            Users::where('email', $request->get('email'))->update(
                [
                    'account_status' => 'deleted',
                    'leaving_subject' => $request->get('leavingTitle'),
                    'leaving_note' => $request->get('leavingNote')
                ]
            );

            return $this->helpReturn('Your profile updated.', $user);
        }
        catch(Exception $e)
        {
            Log::info("deactivateUserAccount -> " . $e->getMessage() . ' > ' . $e->getLine() . ' > ' . $e->getCode());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function changeUserAccountStatus($request)
    {
        try
        {
            $user = Users::where('email', $request->get('email'))->first();

            if(empty($user))
            {
                return $this->helpError(404, 'No record exist.');
            }

            $status = ($request->get('status') == 'deleted') ? 'deleted' : '';
            $deleteBy = (!empty($request->get('delete_by'))) ? $request->get('delete_by') : 0;

            $data['account_status'] = $status;

            Users::where('email', $request->get('email'))->update(
                [
                    'account_status' => $status,
                    'delete_by' => $deleteBy
                ]
            );

            return $this->helpReturn('User profile updated.', $user);
        }
        catch(Exception $e)
        {
            Log::info("deactivateUserAccount -> " . $e->getMessage() . ' > ' . $e->getLine() . ' > ' . $e->getCode());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function deleteUserAccount($request)
    {
        try
        {
            $user = Users::where('id', $request->get('id'))->first();

            if(empty($user))
            {
                return $this->helpError(404, 'No record exist.');
            }

//            Log::info("yes next");

            Users::where('id', $request->get('id'))->update(
                [
                    'deleted_at' => now()
                ]
            );

            return $this->helpReturn('Account has been deleted.');
        }
        catch(Exception $e)
        {
            Log::info("deleteUserAccount -> " . $e->getMessage() . ' > ' . $e->getLine() . ' > ' . $e->getCode());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function updateSession($request)
    {
        if(!empty($request->status))
        {
            $userData = $this->sessionService->getAuthUserSession();

//            Log::info("us > " . $userData['business'][0]['discovery_status']);
//            Log::info("statusof > " . $request->status);

//            $userData['last_name'] = 'TEST';

            if($request->status == 1 || $request->status == 6)
            {
                $userData['discovery_status'] = 1;
                $userData['business'][0]['discovery_status'] = 1;
            }
            else
            {
                $userData['discovery_status'] = $request->status;
                $userData['business'][0]['discovery_status'] = $request->status;
            }

//            Log::info("After Update " . $userData['business'][0]['discovery_status']);

            $this->sessionService->setAuthUserSession($userData);

            $userDataCheck = $this->sessionService->getAuthUserSession();

//            Log::info("userDataCheck");
//            Log::info($userDataCheck);

            $status = $request->status;
            if(!empty($userData) && !empty($request->status)) {

                if($request->status == 6)
                {
                    $status = 1;
                }

                $businessData = Business::where('user_id', $userData['id'])->first();

                if(!empty($businessData))
                {
                    $businessData->update(
                        [
                            'discovery_status' => $status
                        ]
                    );
                }
            }
        }

        return $this->helpReturn('Process done.');
    }

    public function getIndustry()
    {
        try
        {
            $data = Industry::with('niches')->get();

            return $this->helpReturn('Industry Niches', $data);
        }
        catch(Exception $e)
        {
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function getIndustryNiches($request)
    {
        try
        {
            $industry = $request->industry;

            $data = Niches::where('industry_id', $industry)
                ->get();

            return $this->helpReturn('Industry Niches', $data);
        }
        catch(Exception $e)
        {
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }
    public function getNiches()
    {
        try
        {
            $data = Niches::all();

            return $this->helpReturn('Industry Niches', $data);
        }
        catch(Exception $e)
        {
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }
    /**
     * @param string $user
     * @return mixed
     */
    public function subscriptionStatusCheck($user = '')
    {
//        Log::info($user);
        if(!empty($user))
        {
            $userData = Users::find($user);
            $userId = $userData['id'];
        }
        else
        {
            $userData = $this->sessionService->getAuthUserSession();
            $userId = $userData['id'];
        }

//        $userData['id'];

        // track if user has not any subscription then use trial status else use subscription status for counter.

        $sub = new SubscriptionManagerEntity();
        $userSubscription = $sub->getSubscribedPackage($userId);

//        print_r($userSubscription);
//        exit;

//        echo Date('Y-m-d', strtotime('+1 month', strtotime($userSubscription['created_at'])));
//        echo Date('Y-m-d', strtotime('+1 month', strtotime($userSubscription['created_at'])));
//        exit;

        $subscriptionType = 'trial';
        if(!empty($userSubscription))
        {
            $subscriptionType = 'paid';
            $trialEndsAt = Date('Y-m-d', strtotime('+1 month', strtotime($userSubscription['created_at'])));
//            $trialEndsAt = Date('Y-m-d', strtotime($userSubscription['created_at']));
        }
        else
        {
            $trialEndsAt = $userData['trial_ends_at'];
        }

        $currentDay = Date('Y-m-d', time());
//        $targetDay = Date('Y-m-d', strtotime($trialEndsAt));
        $targetDay = Date('Y-m-d', strtotime($trialEndsAt));

        $diff=date_diff(date_create($targetDay),date_create($currentDay));
        $dateDiff = $diff->format("%R%a");

        $data['trial_ends_at'] = $trialEndsAt;

//        echo $dateDiff;
//        exit;

        /**
         * if trial not expired go in If Block.
         * datediff will return in minus (-10) meand 10 days remaining in expiry
         */
        if($dateDiff <= 0)
        {
            // trial expired
            $data['trial_expired'] = false;
            $data['subscription_expired'] = false;
            $data['subscription_type'] = $subscriptionType;

            $data['package_ends_at'] = $trialEndsAt;

            if($dateDiff == 31)
            {
                $dateDiff = 30;
            }
            $data['trial_remaining_days'] = str_replace(["-", "+"], ["", ""], $dateDiff);;
            $data['subscription_remaining_days'] = str_replace(["-", "+"], ["", ""], $dateDiff);;
//            $data['subscription_remaining_days'] = str_replace("-", "", $dateDiff);;
        }
        else
        {
            // trial has been expired
            $data['trial_expired'] = true;
            $data['subscription_expired'] = true;
            $data['trial_remaining_days'] = 0;
            $data['subscription_remaining_days'] = 0;
            $data['subscription_type'] = $subscriptionType;
        }

        return $data;
    }

    public function videoSeen($request)
    {
        # code...
        try {
            //code...
            $userData = $this->sessionService->getAuthUserSession();
            $user_id = $userData['id'];
            Users::where('id',$user_id)->update(['welcome_video_seen' => 1]);
            Log::info("videoSeen Successfully");
            return $this->helpReturn('If you need to know more about nichepractice, you can contact us');
        } catch (Exception $e) {
            //Exception $e;
            Log::info("videoSeen -> " . $e->getMessage() . ' > ' . $e->getLine() . ' > ' . $e->getCode());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function viewedSendReviewInviteSettings($request)
    {
        # code...
        try {
            //code...
            $userData = $this->sessionService->getAuthUserSession();
            $user_id = $userData['id'];
            Users::where('id',$user_id)->update(['viewed_send_review_invite_settings' => 1]);
            Log::info("viewedSendReviewInviteSettings Successfully");
            return $this->helpReturn('You have successfully viewed Send Review Invite Settings');
        } catch (Exception $e) {
            //Exception $e;
            Log::info("viewedSendReviewInviteSettings -> " . $e->getMessage() . ' > ' . $e->getLine() . ' > ' . $e->getCode());
            return $this->helpError(1, 'Some Problem happened. Please try again.');
        }
    }
    public function getUsers($type = 'active_users')
    {
//        $condition = [
//            ['id', "!=", 1],
//            ['first_name', "=", 'Abdul'],
//            ['deleted_at','notnull']
//        ];

//        $condition = [
//            'id' => 1,
//            'ds' => 1,
//            'ds is null' => 'null',
//        ];


//        ->whereNull('deleted_at')
        $list = Users::where('id', '!=', 1)
            ->whereNull('deleted_at')
            ->where(function ($q)
            {
                $q->where('account_status', '=', '');
                $q->orWhereNull('account_status');
            })->get()->toArray();
//            ->toSql();

        return $list;
    }

    public function userMetaManager(Request $request)
    {
        try {
            $userData = $this->sessionService->getAuthUserSession();
            $user_id = $userData['id'];
            $data = $request->except('send');
            $userRes = UserMeta::where('user_id', $user_id)->first();
            if (!empty($userRes)) {
                $userRes->update($data);
            } else {
                $data['user_id'] = $user_id;
                UserMeta::create($data);
            }
            return $this->helpReturn('Suggession successfully removed');
        } catch (Exception $e) {
            //Exception $e;
            Log::info("userMetaManager -> " . $e->getMessage() . ' > ' . $e->getLine() . ' > ' . $e->getCode());
            return $this->helpError(1, 'Some Problem happened. Please try again.');
        }
    }
    public function updateOnlineTime(){
        $userData = $this->sessionService->getAuthUserSession();
        $user_id = $userData['id'];
        $latestTime = Carbon::now();
//        log::info($latestTime);
//        return $latestTime;
//        return $latestTime;
        $results = Users::where('id',$user_id)->update(['online_time' => $latestTime]);
//        if($results){
//            log::info('Updated Successfully');
//        }
//        else{
//            log::info('Not Updated Successfully');
//        }
        return $results;
    }
    public function getMarketingAssociation()
    {
        try
        {
            $data = MarketingAssociation::where('status', '=', 1)->get()->toArray();

            return $this->helpReturn('marketing associations', $data);
        }
        catch(Exception $e)
        {
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }
    public function closeWidget() {
        try {
            $userData = $this->sessionService->getAuthUserSession();

            $user_id = $userData['id'];
            log::info($user_id);
            $results = Users::find($user_id);
            $results1 = $results->update(['close_widget' => 1]);
            log::info($results1);
            return $this->helpReturn('widget closed', $results);
        }
        catch(Exception $e)
        {
            Log::info("closeWidget > " . $e->getMessage());
            return $this->helpError(404, 'An unknown error has occurred. Please try again.' );
        }
    }
}
