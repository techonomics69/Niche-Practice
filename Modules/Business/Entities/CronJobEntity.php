<?php

namespace Modules\Business\Entities;

use App\Entities\AbstractEntity;
use App\Services\SessionService;
use App\Traits\UserAccess;
use App\User;
use Carbon\Carbon;
use DB;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use File;
use Log;
use Mail;
use Config;
use Modules\Business\Models\Business;
use Modules\Business\Models\Niches;
use Modules\ThirdParty\Entities\FacebookEntity;
use Modules\ThirdParty\Entities\GooglePlaceEntity;
use Modules\ThirdParty\Entities\OnlineDirectoryEntity;
use Modules\ThirdParty\Entities\SocialEntity;
use Modules\ThirdParty\Entities\ThirdPartyEntity;
use Modules\ThirdParty\Entities\TripAdvisorEntity;
use Modules\ThirdParty\Entities\YelpEntity;
use Modules\ThirdParty\Models\TripadvisorReview;
use Modules\User\Entities\NotificationEntity;
use Redirect;
/**
 * Class AuthEntity
 * @package Modules\Auth\Entities
 */
class CronJobEntity extends AbstractEntity
{

    use UserAccess;

    protected $loginValidator;

    protected $googlePlaces;

    protected $facebook;

    protected $yelp;

    protected $sessionService;

    protected $socialEntity;

    protected $thirdPartyEntity;
    protected $tripAdvisorEntity;
    protected $onlineEntity;

    public function __construct()
    {
        $this->googlePlaces = new GooglePlaceEntity();
        $this->facebook = new FacebookEntity();
        $this->yelp = new YelpEntity();
        $this->socialEntity = new SocialEntity();
        $this->thirdPartyEntity = new ThirdPartyEntity();
        $this->tripAdvisorEntity = new TripAdvisorEntity();
        $this->sessionService = new SessionService();
        $this->onlineEntity = new OnlineDirectoryEntity();
    }

    public function checkScrapperStatus($request)
    {
        try{

            Log::info("Start check Scrapper Status" );
            $query = ['Keyword' => "The House","PhoneNo"=>"+1 415-986-8612"];
            $appEnvironment = Config::get('apikeys.APP_ENV');

            $directoryTypes = ['yelp','tripAdvisor','foursquare'];
            $allscrapperOk=0;
            foreach($directoryTypes as $type)
            {
                $serverUrl = ( $appEnvironment == 'production') ? Config::get('custom.Scrapper_Prod_SERVER_URL'): Config::get('custom.SERVER_URL');
                if($type=='tripAdvisor'){
                    $detailUrl = ($appEnvironment == 'production') ? Config::get('custom.tripAdvisorProdBusinessDetail') : Config::get('custom.tripAdvisorTestBusinessDetail');
                }else if($type=='yelp'){
                    $detailUrl = ( $appEnvironment == 'production') ? Config::get('custom.yelpProdBusinessDetail'): Config::get('custom.yelpTestBusinessDetail');
                }else if($type=='foursquare'){
                    $detailUrl = ( $appEnvironment == 'production') ? Config::get('custom.foursquareProdBusinessDetail'): Config::get('custom.foursquareTestBusinessDetail');
                }

                $url = $serverUrl . $detailUrl;
                $client = new Client([]);
                $response = $client->request(
                    'GET', $url,
                    [
                        'query' => $query
                    ]
                );

                $responseData = json_decode($response->getBody()->getContents(), true);
                $records = $responseData['Results'];
                Log::info('checkScrapperStatus call back');
                if ($response->getStatusCode() != 200) {
                    //need to send the email
                    $allscrapperOk=1;
                    Mail::to(['ahtesham.asghar@vaivaltech.com','waseem.akram@vaivaltech.com', 'bilal.zafar@vaival.com','imran.khalid@vaivaltech.com'])
                        ->send(new SendScrapperStatusEmail($type));
                }else{
                    //echo "Get ".$type;
                }

            }
            if($allscrapperOk==1){
                return $this->helpReturn("Email sent. ");
            }else{
                return $this->helpReturn("No scrapper is Down! ");
            }


        }
        catch(Exception $exception)
        {
            Log::info(" checkScrapperStatus > " . $exception->getMessage());
            return $this->helpError(1, 'Some Problem happened. please try again.');
        }
    }
    public function checkDecryptScript($request)
    {
        $user_issues_list = DB::select(
            DB::raw('SELECT * FROM recipients WHERE   ( LENGTH(recipients.first_name) > 20 || LENGTH(recipients.last_name) > 20)   ')
        );

        if(!empty($user_issues_list)) {
            Log::info("user_issues have issue for Foursquare. ");
            foreach($user_issues_list as $row_user_issues) {
                echo "\n";
                echo $row_user_issues->id;echo "---Real::";
                $id=$row_user_issues->id;
                echo "------";
                try{
                    echo $first_name=addslashes(ucfirst(Crypt::decrypt($row_user_issues->first_name)));
                    DB::statement("UPDATE recipients SET first_name = '$first_name' where id = $id");

                }catch(Exception $exception) {
                    echo ucfirst(($row_user_issues->first_name));

                }

                echo "------";
                try{
                    echo $last_name=addslashes(ucfirst(Crypt::decrypt($row_user_issues->last_name)));

                    echo "------";
                    DB::statement("UPDATE recipients SET last_name = '$last_name' where id = $id");
                }catch(Exception $exception) {
                    echo ucfirst(($row_user_issues->last_name));
                }
                echo "\n";
            }
        }

        die('---');
    }

//    public function getNewReviewsNotification($request)
    public function getNewReviewsNotification()
    {
        try
        {
            $request = new Request();

            $dateFormat = 'Y-m-d H:i';
            $currentTime = Carbon::now();
            $businessToReviews = date("Y-m-d H:i",strtotime("-30 minutes",strtotime($currentTime)));

//            $userTypeArray = [
//                [
//                    'id' => 3,
//
//                ],
//                [
//                    'id' => 4,
//
//                ],
//                [
//                    'id' => 7,
//
//                ],
//                [
//                    'id' => 8,
//
//                ],
//                [
//                    'id' => 9,
//
//                ]];

//            $allBusiness = Business::select('business_id')->get();
//
//            return $allBusiness;

            Log::info("cronjob " . Carbon::now());

            if (empty($request->business_id)) {
                $thirdPartyData = DB::table('business_master as bm')
                    ->join('third_party_master as tpm', 'bm.business_id', '=', 'tpm.business_id')
                    ->join('users as usm', 'bm.user_id', '=', 'usm.id')
                    ->where('tpm.updated_at', '<=', $businessToReviews)
                    ->where('bm.discovery_status', 1)
                    ->wherenotnull('page_url')
                    ->select('bm.user_id', 'bm.niche_id', 'usm.first_name', 'usm.email', 'bm.business_id', 'bm.practice_name as ThirdPartyBusinessName', 'third_party_id', 'page_url', 'type')
                    ->orderby('bm.business_id', 'DESC')
                    ->get()
                    ->toArray();
            }
            else
            {
                $thirdPartyData = DB::table('business_master as bm')
                    ->join('third_party_master as tpm', 'bm.business_id', '=', 'tpm.business_id')
                    ->join('user_master as usm', 'bm.user_id', '=', 'usm.id')
                    ->where('bm.business_id', $request->get('business_id'))
                    ->where('tpm.created_at', '<=', $businessToReviews)
                    ->where('tpm.updated_at', '<=', $businessToReviews)
                    ->where('bm.discovery_status', 1)
                    ->select('bm.user_id', 'usm.first_name', 'usm.user_type', 'usm.company_name', 'usm.device_id', 'bm.business_id', 'bm.name as ThirdPartyBusinessName', 'third_party_id', 'page_url', 'type')
                    ->orderby('bm.business_id', 'DESC')
                    ->get()->toArray();
            }

//            print_r($thirdPartyData);
//            exit;

            $notifyEntity = new NotificationEntity();

            $loop = 0;
            if (!empty($thirdPartyData)) {
                $report = [];
                $abc = [];
                foreach ($thirdPartyData as $tIndex => $row) {
                    Log::info("index is $tIndex");
                    $loop++;
                    $thirdPartyId = $row->third_party_id;
                    $type = $row->type;
                    $user = $row->user_id;
                    $email = $row->email;
                    $bName = $row->ThirdPartyBusinessName;
                    $pageUrl = $row->page_url;

                    // is user account is not active then don't do to reviews process.
                    if(isActive($user) == false)
                    {
                        continue;
                    }

//                    $userDetails = \Modules\Auth\Models\User::select('email','first_name','company_name')
//                                    ->where('id',$user)->first();

                    if ($type == 'Yelp') {
                        $result = $this->yelp->getBusinessUrlHistoricalDetail($pageUrl);
                    } else if ($type == 'Tripadvisor') {
                        $result = $this->tripAdvisorEntity->getBusinessUrlHistoricalDetail($pageUrl);
                    } else if ($type == 'Google Places') {
                        $result = $this->googlePlaces->getBusinessUrlHistoricalDetail($pageUrl);
                    }else if ($type == 'Foursquare') {
//                        $result = $foursquareEntity->getBusinessUrlHistoricalDetail($row->page_url);
                    }
                    else if($type == 'Zocdoc')
                    {
                        $result = $this->onlineEntity->getZocDocListingDetail($pageUrl);
                    }
                    elseif($type == 'Healthgrades')
                    {
                        $result = $this->onlineEntity->getHealthGradeListingDetail($pageUrl);
                    }
                    elseif($type == 'Ratemd')
                    {
                        $result = $this->onlineEntity->getRateMdsListingDetail($pageUrl);
                    }

                    if ($result['_metadata']['outcomeCode'] == 200) {
                        if(!empty($result['records']['Results']['ReviewsDetail']))
                        {
                            $userReviews = @$result['records']['Results']['ReviewsDetail'];
                        }
                        else
                        {
                            $userReviews = @$result['records']['ReviewsDetail'];
                        }

                        /**
                         * if user business record meet on third party api scrappers
                         * update third_party_master_table
                         * if user has reviews of current business then also update user Review
                         * against in third_party_review table..
                         */
                        $request->merge(
                            [
                            'business_id' =>$row->business_id
                        ]
                        );

                        if ((!empty($userReviews))) {
                            DB::transaction(function () use ($userReviews, $thirdPartyId, $type, $request, $row, $user, $notifyEntity, $tIndex, &$report) {
                                $industry = Niches::with('industry')->where('id', $row->niche_id)->first();

                                $niche = '';
                                $nicheIndustry = '';
                                if(!empty($industry))
                                {
                                    $industry = $industry->toArray();
                                    $niche = $industry['niche'];
                                    $nicheIndustry = $industry['industry']['name'];
                                }

                                $job = 'cronjob';
                                $reviewsStored = $this->tripAdvisorEntity->storeUserReviews($userReviews, $thirdPartyId, $type, $request,$job);

                                $report[$user][$thirdPartyId]['reviewsCount'] = count($userReviews);
                                $report[$user][$thirdPartyId]['third_party_id'] = $thirdPartyId;
                                $report[$user][$thirdPartyId]['storing'] = "reviews stored of type $type of $user";
                                $report[$user][$thirdPartyId]['reviewsStored'] = $reviewsStored;

                                $dateFormat = dateFormatUsing();
                                $threeDate = Carbon::now()->subDays(2);
                                $formatedThreeDate = Carbon::createFromFormat('Y-m-d H:i:s', $threeDate)->format($dateFormat);

                                /**
                                 * send notification to user, If any new entry posted
                                 */
                                if ($reviewsStored != 0) {
                                    $data = [
                                        'type' => $type,
                                        'third_party_id' => $thirdPartyId,
                                        'notification' => $reviewsStored,
                                        'page_url' => $row->page_url,
                                        'email' => $row->email,
                                        'first_name' => $row->first_name,
                                        'company_name' => $row->ThirdPartyBusinessName,
                                        'niche' => $niche,
                                        'industry' => $nicheIndustry
                                    ];

                                    $notificationResponse = $notifyEntity->storeNotifications($data, 'Reviews', $user);

                                    $report[$user][$thirdPartyId]['code'] = $notificationResponse['_metadata']['outcomeCode'];

                                     if ($notificationResponse['_metadata']['outcomeCode'] == 200 && (!empty($notificationResponse['records'])) ) {
                                         $totalCount = count($notificationResponse['records']);
                                         $report[$user][$thirdPartyId]['totalCount'] = $totalCount;
                                         foreach($notificationResponse['records'] as $notify)
                                         {
                                             $user = ($notify['user_id'] == $user) ? $user : $notify['user_id'];
                                             $chatId = $notify['chat_id'];

                                             $report[$user][$thirdPartyId][$chatId]['emailResponse'] = $notify['emailResponse'];
                                         }
                                     }


//                                    if ($row->device_id !== '' && $notificationResponse['_metadata']['outcomeCode'] == 200) {
//                                        $recentNotificationRecord = $notificationResponse['records'];
//                                        if (!empty($recentNotificationRecord)) {
//                                            $z = 1;
//                                            foreach($lastReviewsDetails as $notifications){
//
//                                                $message = $notifications['reviewer'] . " rated you " . $notifications['rating'] . " on " .$notifications['type']. "Read full review now!";
//                                                $this->pushNotificationTemplate($recentNotificationRecord, $message, $row->device_id, $user);
//                                                $z++;
//                                            }
//
//                                        }
//                                    }
                                }
                            });
                        }
                    }
                }


                Log::info("cron review loop executed for time " . $loop);
                Log::info($report);
                return $this->helpReturn("Notification successfully sent.");
            }

            return $this->helpError(404, 'Business not found.');
        }
        catch(Exception $exception)
        {
            Log::info(" getNewReviewsNotification > " . $exception->getMessage());
            return $this->helpError(1, 'Some Problem happened. please try again.');
        }
    }

    public function pushNotificationTemplate($recentNotificationRecord, $message, $deviceToken, $user)
    {
        $pushNotificationData = [];
        $chatObj = new ChatHistoryEntity();

        $pushNotificationData['message'] = $message;
        $unreadNotifications = $chatObj->unreadNotifications('', $user);

        if ($unreadNotifications['_metadata']['outcomeCode'] == 200) {
            $pushNotificationData['unread'] = $unreadNotifications['records']['unread'];
        }
        else
        {
            $pushNotificationData['unread'] = 0;
        }

        foreach ($recentNotificationRecord as $recentNotification) {
            $chatObj->sendPushNotifications($deviceToken, $pushNotificationData,$recentNotification);
        }
    }

}
