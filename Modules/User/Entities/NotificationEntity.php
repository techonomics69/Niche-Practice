<?php

namespace Modules\User\Entities;

use App\Mail\CreateNotificationEmail;
use Davibennun\LaravelPushNotification\PushNotification;
use App\Mail\NotifyNewReview;
use DB;
use Log;
use Mail;
use Config;
use App\User;
use Carbon\Carbon;
use Modules\ThirdParty\Models\SMediaReview;
use Modules\ThirdParty\Models\TripadvisorReview;
use Modules\User\Models\Notifications;
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
/**
 * Class NotificationEntity
 * @package Modules\Auth\Entities
 */
class NotificationEntity extends AbstractEntity
{
    /**
     * @param $request
     * @param string $notifyType (system, reviews, contentresearch)
     * @param string $user
     * @return mixed
     */
    public function storeNotifications($request, $notifyType = 'system', $user = '')
    {
        try
        {
            $currentTime = Carbon::now();

            // for reviews
            $dateFormat = dateFormatUsing();
            $threeDate = Carbon::now()->subDays(2);
            $formatedThreeDate = Carbon::createFromFormat('Y-m-d H:i:s', $threeDate)->format($dateFormat);

            if($user == '') {
                // retrieve user data from token.
                $user = JWTAuth::toUser($request->get('token'));
            }

            if($notifyType == 'citation' || $notifyType == 'missing_website' || $notifyType == 'Reviews' || $notifyType == 'content_research') {
                log::info('condition 00');
                $userId = $user;
                $data = $request;
                $subject = '';

                $notification = $data['notification'];
                $type = $data['type'];
                $thirdPartyId = $data['third_party_id'];
                $pageUrl = $data['page_url'];

                if($notifyType != 'Reviews') {
                    $message = $data['message'];
                }

                if ($notifyType == 'missing_website') {
                    $subject = $request['company_name'].' Get a fast and seo-friendly website';
                } else if ($notifyType == 'citation') {
                    $subject = 'Request for citations now!';
                } else if ($notifyType == 'content_research') {
                    $subject = $request['company_name'].' Share viral content on your Facebook page';
                }

                $reviewsNotification = [];
                if ($notifyType == 'Reviews') {
                    if ($type == 'Facebook') {
                        $reviewsNotification = SMediaReview::where(
                            [
                                'social_media_id' => $thirdPartyId
                            ])->where('review_id', '>=', $notification)
                            ->where(DB::raw("STR_TO_DATE(`review_date`, '%Y-%m-%d')"), '>=', $formatedThreeDate)
                            ->get()->toArray();
                    } else {
                        $reviewsNotification = TripadvisorReview::where(
                            [
                                'third_party_id' => $thirdPartyId,
                                'type' => $type,
                            ])->where('review_id', '>=', $notification)
//                            ->where(DB::raw("STR_TO_DATE(`review_date`, '%Y-%m-%d')"), '>=', $formatedThreeDate)
                            ->get()->toArray();
                    }
                } else {
                    $reviewsNotification[] = [
                        'review_id' => ''
                    ];
                }

                if (!empty($reviewsNotification)) {
                    log::info('condition 01');
                    $notificationTaskRef = [];
                    $notificationSample = [];
                    $i = 0;

                    foreach ($reviewsNotification as $in => $notifications) {
                        if($notifyType == 'Reviews')
                        {
                            $message = $notifications['reviewer'] . " rated you " . $notifications['rating'] . " on " .$notifications['type']. ". <a href=". $pageUrl .">Read full review now!</a>";
                            $subject = $request['company_name'].' New Review on '.$notifications['type'];
                        }

                        // saving notification in system
                        $chat = Notifications::create(
                            [
                                'sender' => 1,
                                'receiver' => $userId,
                                'message' => $message,
                            ]
                        );

                        if(!empty($chat['id']))
                        {
                            $emailResponse = false;

                            try {
                                $email = $request['email'];
//                            $email = 'fsd.ark03@gmail.com';
                                $mail = mail::to($email)->send(new NotifyNewReview(
                                    $request['first_name'],
                                    $request['company_name'],
                                    $message,
                                    $subject,
                                    $notifyType,
                                    $request['niche'],
                                    $request['industry'],
                                    $notifications['rating']
                                ));

                                $emailResponse = true;
                            }
                            catch(Exception $e)
                            {
                                Log::info("email failed $email");
                                Log::info($e->getMessage());
                            }
                        }

                        $notificationSample[] = [
                            'chat_id' => $chat['id'],
                            'user_id' => $userId,
                            'emailResponse' => $emailResponse
                        ];

                        $i++;
                    }

                    return $this->helpReturn("Notification Stored.", $notificationSample);
                }
            }

            return $this->helpError(42, 'Notification not storing in system.');
        }
        catch(Exception $e)
        {
            Log::info($e->getMessage());
            return $this->helpError(1, 'Some Problem happened. please try again.');
        }
    }

    public function showNotifications($request)
    {
        $chatNumber = (!empty($request->get('chatNumber')) ) ? $request->get('chatNumber') : 1;

        $businessObj = new BusinessEntity();
        $businessResult = $businessObj->userSelectedBusiness();

        if ($businessResult['_metadata']['outcomeCode'] != 200) {
            return $this->helpError(1, 'Problem in selection of user business.');
        }

        $businessResult = $businessResult['records'];

        try {
            $userTimeZone = 'UTC';
            $user = $businessResult['user_id'];

            $chatSize = 10; // load 10 messages
            $start = ($chatNumber - 1) * $chatSize;
            $chatObj = new Notifications();

            $notifications = Notifications::where('receiver', $user)
                ->offset($start)
                ->limit($chatSize)
                ->orderBy('id', 'desc')
                ->get()->toArray();

            if (!empty($notifications)) {
                foreach ($notifications as $index=>$chat) {
                    $notifications[$index]['messageFormattedTime'] = Carbon::parse($chat['created_at'])->setTimezone($userTimeZone)->diffForHumans(null, true).' ago';
                }

                $notificationsRecord = [];
                $notificationsRecord['unread'] = '';
                $notificationsRecord['notifications'] = $notifications;

                if($chatNumber == 1)
                {
                    $notificationsRecord['unread'] = Notifications::where('receiver', $user)->where('read', 0)->count();;
                }

                return $this->helpReturn('chat list', $notificationsRecord);
            }

            return $this->helpError(404, 'No notification found.');
        }
        catch(Exception $e)
        {
            Log::info($e->getMessage());
            return $this->helpError(1, 'Some Problem happened. Please try again.');
        }
    }

    public function unreadNotifications($request = '', $user = '')
    {
        try {
            if ($user == '') {
                $checkPoint = $this->setCurrentUser($request->get('token'))->userAllow();
                if ($checkPoint['_metadata']['outcomeCode'] != 200) {
                    return $checkPoint;
                }

                $user = $checkPoint['records'];
                $user = $user['id'];
            }

            $counts =  DB::table('madison_chat_history as mch')
                ->leftJoin('notification_task_ref as ntr', 'mch.chat_id', 'ntr.chat_id')
                ->where('receiver', $user)
                ->where('unread', 1)
                ->where(function ($q) use ($user) {
                    $q->WhereNotNull('ntr.chat_id');
                    $q->orWhere('notification_type', 'link_building');
                })
                ->count();

            $data = ['unread' => $counts];

            return $this->helpReturn('Unread notifications', $data);
        }
        catch(Exception $e)
        {
            Log::info(" unreadNotifications > " . $e->getMessage());
            return $this->helpError(1, 'Some Problem happened. please try again.');
        }

    }

    public function changeUnreadStatus($request)
    {
        try {
            $businessObj = new BusinessEntity();
            $businessResult = $businessObj->userSelectedBusiness();

            if ($businessResult['_metadata']['outcomeCode'] != 200) {
                return $this->helpError(1, 'Problem in selection of user business.');
            }

            $businessResult = $businessResult['records'];
            $user = $businessResult['user_id'];

            Notifications::where('receiver', $user)->where('id', $request->get('chat_identity'))->update(
                ['read' => 1]
            );

            return $this->helpReturn("Action Completed.");
        }
        catch(Exception $exception)
        {
            Log::info($exception->getMessage());
            return $this->helpError(1, 'Some Problem happened. please try again.');
        }
    }

    public function readAllNotification()
    {
        try {
            $businessObj = new BusinessEntity();
            $businessResult = $businessObj->userSelectedBusiness();

            if ($businessResult['_metadata']['outcomeCode'] != 200) {
                return $this->helpError(1, 'Problem in selection of user business.');
            }

            $businessResult = $businessResult['records'];
            $user = $businessResult['user_id'];

            Notifications::where('receiver', $user)->where('read','=',0 )->update(
                ['read' => 1]
            );

            return $this->helpReturn("Action Completed.");
        }
        catch(Exception $exception)
        {
            Log::info($exception->getMessage());
            return $this->helpError(1, 'Some Problem happened. please try again.');
        }
    }
}
