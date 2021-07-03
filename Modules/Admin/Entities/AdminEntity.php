<?php

namespace Modules\Admin\Entities;

use App\Entities\AbstractEntity;
use App\Mail\CreateWelcomeRegisterEmail;
use App\Services\SessionService;
use App\Traits\UserAccess;
use App\User;
use DB;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Hash;
use Log;
use Mail;
use Config;
use Modules\Business\Entities\BusinessEntity;
use Modules\Business\Models\Business;
use Modules\Business\Models\Industry;
use Modules\Business\Models\Niches;
use Modules\CRM\Models\CrmSettings;
use Modules\User\Models\UserRolesREF;
use Modules\User\Models\Users;
use Modules\User\Services\Validations\Auth\AuthLoginValidator;
use Redirect;
/**
 * Class AuthEntity
 * @package Modules\Auth\Entities
 */
class AdminEntity extends AbstractEntity
{
    use UserAccess;

    protected $loginValidator;

    protected $sessionService;

    /**
     * AuthEntity constructor.
     */
    public function __construct()
    {
//        $this->authUerInfo = new UserAuthValidator();
        $this->loginValidator = new AuthLoginValidator(resolve('validator'));
        $this->sessionService = new SessionService();
    }

    public function index()
    {
        try
        {
//            $list = Users::
//            with(
//                [
//                    'business' => function($q) {
//                    $q->with('niche');
//                }
//                ]
//            )
//                ->where('id', '!=', 1)
//                ->where(
//                function($query) {
//                    $query->Where('deleted_at', '=', "");
//                    $query->orWhereNull('deleted_at');
//                })
//                ->get()->toArray();
//            $guestUser = Users::where('email', 'guest@nichepractice.com')->first();
//            $guestUser1 = Users::where('email', 'guest1@nichepractice.com')->first();
//            log::info('$guestUser');
//            log::info($guestUser['id']);
            $list = Users::
            with(
                [
                    'business' => function($q) {
                        $q->with('niche');
                    }
                ]
            )->with(
                [
                    'subscriptions' => function($q) {
                        $q->orderBy('id', 'desc')->get();
                    }
                ]
            )
                ->where('id', '!=', 1)
//                ->where('id', '!=', $guestUser['id'])
//                ->where('id', '!=', $guestUser1['id'])
                ->orderBy('created_at', 'DESC')
                ->whereNull('deleted_at')
                ->whereNull('admin_panel_user')
                ->get()->toArray();

            return $this->helpReturn('list', $list);
        }
        catch(Exception $e)
        {
            Log::info("admin -> index -> " . $e->getMessage() . ' > ' . $e->getLine() . ' > ' . $e->getCode());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }

    }


    public function login($request)
    {
        $data = $request->all();

        if (!$this->loginValidator->with($data)->passes()) {
            return $this->helpError(2, "Fields are required to login.", $this->loginValidator->errors());
        }

        $email = $request->email;
        $password = $request->password;

        $user = Users::with('userRole')->where('email', $email)
            ->first();

        if(empty($user))
        {
            return $this->helpError(3, "Record not found.");
        }

        $isMatced = Hash::check($password, $user->password);

        $userModified = $user->toArray();

//        Log::info("isMatced $isMatced");
//        Log::info("user_role ");
//        Log::info($userModified['user_role']);

        if($isMatced == 1 && $userModified['user_role'][0]['slug'] == 'admin')
        {
//            $userID = $user['id'];
//
//            $crmsetting = CrmSettings::where('user_id', $userID)->first();
//
//            if( empty($crmsetting) ) {
//                CrmSettings::create( [
//                    'user_id' => $userID,
//                    'enable_get_reviews' => 'Yes',
//                    'smart_routing' => 'Enable',
//                    'sending_option' => '1'
//                ]);
//            }

            return $this->helpReturn('You are successfully logged-in', $userModified);
        }

        return $this->helpError(36, "Incorrect email or password.");
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

            $data['account_status'] = 'deleted';
            $data['leaving_subject'] = $request->leavingTitle;
            $data['leaving_note'] = $request->leavingNote;

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

    public function updateSession($request)
    {
        if(!empty($request->status))
        {
            $userData = $this->sessionService->getAuthUserSession();

            Log::info("us " . $userData['business'][0]['discovery_status']);

            $userData['discovery_status'] = $request->status;

//            Log::info("After Update " . $userData['business'][0]['discovery_status']);

            $this->sessionService->setAuthUserSession($userData);

            if(!empty($userData) && $request->status == 6) {
                $businessData = Business::where('user_id', $userData['id'])->first();

                if(!empty($businessData))
                {
                    $businessData->update(
                        [
                            'discovery_status' => 1
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
}
