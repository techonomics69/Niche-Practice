<?php

namespace Modules\ThirdParty\Entities;

use App\Entities\AbstractEntity;
use App\Services\SessionService;
use App\Traits\UserAccess;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Modules\Business\Entities\BusinessEntity;
use Modules\CRM\Models\Recipient;
use Modules\ThirdParty\Models\IssuesList;
use Modules\ThirdParty\Models\SMediaReview;
use Modules\ThirdParty\Models\SocialMediaLike;
use Modules\ThirdParty\Models\SocialMediaMaster;
use Modules\ThirdParty\Models\StatTracking;
use Modules\ThirdParty\Models\ThirdPartyMaster;
use Modules\ThirdParty\Entities\YelpEntity;
use Modules\ThirdParty\Models\TripadvisorMaster;
use Modules\ThirdParty\Models\TripadvisorReview;
use Modules\ThirdParty\Models\UserIssues;
use Request;
use SKAgarwal\GoogleApi\PlacesApi;
use Log;
use DB;

class ThirdPartyEntity extends AbstractEntity
{
    use UserAccess;

    protected $tripAdvisor;

    protected $googlePlaces;

    protected $facebook;

    protected $yelp;

    protected $onlineEntity;

    protected $thirdPartyMaster;

    protected $sessionService;

    public function __construct()
    {
        $this->tripAdvisor = new TripAdvisorEntity();
        $this->googlePlaces = new GooglePlaceEntity();
        $this->facebook = new FacebookEntity();
        $this->yelp = new YelpEntity();
        $this->onlineEntity = new OnlineDirectoryEntity();
        $this->thirdPartyMaster = new ThirdPartyMaster();

        $this->sessionService = new SessionService();
    }



    /**
     * This method connect with all third party Api
     * of user business.
     *
     * @param $request
     */
    public function thirdPartyConnect($request)
    {
        Log::info("Business third party Register Process started " . json_encode($request->all()));

        // store data in trip advisor
        $this->tripAdvisor->storeThirdPartyMaster($request);

        $this->facebook->storeThirdPartyMaster($request);

        // store data in google places.
        $this->googlePlaces->storeThirdPartyMaster($request);

        // store data in yelp.
        $this->yelp->storeThirdPartyMaster($request);
    }

    /**
     * This will update third party apis data if any change happened.
     * @param $request
     * @param string $type
     * @return mixed|string
     */
    public function thirdPartyUpdate($request, $type = 'all')
    {
//        print_r($request->all());
//        exit;
        Log::info("Business third party Update Process started " . json_encode($request->all()));
        try{

            $response = '';
            $type = strtolower($type);

//        if( $type != 'googleplaces' ) {
            if ($type == 'tripadvisor' || $type == 'all') {
                $response = $this->tripAdvisor->updateThirdPartyMaster($request);
            }

            if ($type == 'googleplaces' || $type == 'all') {
                $response = $this->googlePlaces->updateGooglePlacesMaster($request);
            }

            if ($type == 'yelp' || $type == 'all') {
                $response = $this->yelp->updateYelpMaster($request);
            }

            if(!empty($request->get('requestType')) && $request->get('requestType') == 'guest')
            {
                Log::info("face If");
                $response = $this->facebook->updateThirdPartyMaster($request);
            }
            else
            {
                if($type == 'all')
                {
                    LOg::info("face Else");
                    $this->storedApiCompareData($request, 'Facebook');
                }
            }

//        }
//        else
//        {
//            return $this->helpError(70, "$type functionality is not available yet.");
//        }

            return $response;
        }
        catch(Exception $e)
        {
            Log::info("thirdPartyEntity > getBusinessDetail >> " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    /**
     * connect with third parties to fetch User Business Primary Information
     * so user has not to manual enter those.
     * @param $request
     * @return mixed
     */
    public function retrieveBusinessPrimaryDetails($request)
    {
//        return false;

        Log::info("Fetching details " . json_encode($request->all()));

        // Priority is --> 1- Google, 2- Facebook, 3- Yelp, 4- Tripadvisor
        $detailsNeeded = ['website', 'street', 'city', 'state', 'zipcode', 'country'];
        $businessDetailsFilled = [];

        $fuzz = new Fuzz();

        try
        {
            /************************************************* Google Process start ***************************************************/
            // get business detail from google places.

            $result = $this->googlePlaces->getFirstPlaceID($request);

            $responseCode = $result['_metadata']['outcomeCode'];

            if($responseCode == 200) {
                $placeid = $result['records']['place_id'];
                $request->merge(['placeid' => $placeid]);

                $result = $this->googlePlaces->getPlaceResult($request);

//                echo "details";
//            print_r($result);
//                exit;

                $responseCode = $result['_metadata']['outcomeCode'];

                if ($responseCode == 200) {
                    $googleBusinessResult = $result['records'];

                    $score = $fuzz->tokenSortRatio($request->get('name'), $googleBusinessResult['name']);

                    Log::info("Google -> Score of -> $score > Business Name > " . $request->get('name') . " > Google Name " . $googleBusinessResult['name']);

                    if($score >= 40)
                    {
                        Log::info("Ok for google");
                        foreach ($detailsNeeded as $key => $component) {
                            if (!empty($googleBusinessResult[$component])) {
                                $businessDetailsFilled[$component] = $googleBusinessResult[$component];
                                unset($detailsNeeded[$key]);
                            }
                        }
                    }
                }
            }


//            echo "details";
//            print_r($detailsNeeded);
//            exit;

            if(empty($detailsNeeded))
            {
                Log::info("all data got from google");
                return $this->helpReturn("Business primary Information.", $businessDetailsFilled);
            }

            /************************************************* Google Process End ***************************************************/

            /************************************************* Third party Process Start ***************************************************/

            $types = ['facebook', 'yelp', 'tripAdvisor'];

            foreach($types as $type)
            {
                Log::info("Going to $type to get data " . json_encode($detailsNeeded));

                $result = $this->{$type}->getBusinessDetail($request);

                $responseCode = $result['_metadata']['outcomeCode'];

                if ($responseCode == 200) {
                    $businessResult = $result['records']['Results'];

                    $score = $fuzz->tokenSortRatio($request->get('name'), $businessResult['Name']);

                    Log::info("Google -> Score of -> $score > Business Name > " . $request->get('name') . " > $type Name " . $businessResult['Name']);

                    if($score >= 40) {
                        Log::info("Ok for $type");
                        if (!empty($businessResult['AddressDetail'])) {

                            $businessResult['AddressDetail']['Website'] = $businessResult['Website'];
                            $addressDetail = $businessResult['AddressDetail'];
                            foreach ($detailsNeeded as $key => $component) {

                                if ($component == 'zipcode') {
                                    $component = 'zip';
                                }
                                if (!empty($addressDetail[ucfirst($component)])) {

                                    $addressVal = $addressDetail[ucfirst($component)];
                                    if ($component == 'zip') {
                                        $component = 'zipcode';
                                    }
                                    $businessDetailsFilled[$component] = $addressVal;
                                    unset($detailsNeeded[$key]);
                                }
                            }
                        }
                    }
                }

                if(empty($detailsNeeded))
                {
                    Log::info("Data got from $type");
                    return $this->helpReturn("Business primary Information Got till $type", $businessDetailsFilled);
                }
            }

            /************************************************* Third Party Process End ***************************************************/

            Log::info("Not get fully data 404" . json_encode($detailsNeeded));
            return $this->helpReturn('Details not fully found.', $businessDetailsFilled, 404);
//            return $this->helpError('Details not fully found.', $businessDetailsFilled, 404);
        }
        catch(Exception $e)
        {
            Log::info("thirdPartyEntity > retrieveBusinessPrimaryDetails >> " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function globalIssueGenerator($userId, $businessId, $thirdPartyId, $arrayData, $type, $module = 'local')
    {
        $compareData = [];

        foreach($arrayData as $row)
        {
            $oldIssue = ( !empty( $row['oldIssue'] ) ) ? $row['oldIssue'] : '';

            $compareData[] = [
                'key' => $row['key'],
                'value' => $row['value'],
                'userID' => $userId,
                'business_id' => $businessId,
                'third_party_id' => $thirdPartyId,
                'issue' => $row['issue'],
                'oldIssue' => $oldIssue,
                'type' => $type
            ];
        }

        $this->tripAdvisor->compareThirdPartyRecord($compareData, $module);
    }

//    public function thirdPartyReviews($request)
//    {
//        try{
//            $dashboard = new DashboardEntity();
//            return $dashboard->thirdPartyReviews($request);
//        }
//        catch(Exception $e)
//        {
//            Log::info("thirdPartyEntity > thirdPartyReviews >> " . $e->getMessage());
//            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
//        }
//    }

    public function thirdPartyReviews($request, $businessId = '', $type = '')
    {
        try {
//            print_r($type);
//            print_r($businessId);
//            exit;
            if(empty($businessId)) {
                $businessObj = new BusinessEntity();
                $businessResult = $businessObj->userSelectedBusiness();

                if ($businessResult['_metadata']['outcomeCode'] != 200) {
                    return $this->helpError(1, 'Problem in selection of user business.');
                }
                $businessResult = $businessResult['records'];
                $businessId = $businessResult['business_id'];

                $type = !empty(($request->get('type'))) ? $request->get('type') : 'all';
            }


            $data = TripadvisorMaster::where('business_id', $businessId)
                ->where('page_url', '!=', '')
                ->where(function ($q) use ($type) {
                    if ($type != 'all') {
                        $q->where('type', $type);
                    }
                })
                ->get()->toArray();


            if (empty($data)) {
                return $this->helpError(404, 'Data not found of requested type.');
            }

//            dd("hi");

            $result = [];
            foreach ($data as $index => $thirdBusiness) {
                $result[] = TripadvisorReview::where('third_party_id', $thirdBusiness['third_party_id'])
                    ->orderBy('type')
                    ->get()->toArray();
            }

//            print_r($result);
//            exit;

            if(!empty(array_filter($result)) )
            {
                return $this->helpReturn("Business Reviews.", $result);
            }

            return $this->helpError(404, 'We are collecting your business Reviews. Once we done the data will be load here.');
        } catch (Exception $e) {
            Log::info("thirdPartyEntity > thirdPartyReviews >> " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function getNegativeFeedback($user = '')
    {
//        $result = Recipient::with(
//            ['reviewRequest' => function ($q)
//            {
//                $q->where('message', '!=', '');
//            }]
//        )
////            ->where('reviewRequest.message', '!=', '')
//            ->where('user_id', $user)
//            ->get()->toArray();

        try {
            $result = Recipient::with(['reviewRequest' => function ($q) {
                $q->where('message', '!=', '');
            }])->whereHas(
                'reviewRequest', function (Builder $query) {
                $query->where('message', '!=', '');
            }
            )->where('user_id', $user)
                ->get()->toArray();

            return $this->helpReturn("Response.", $result);
        }
        catch(Exception $e)
        {
            Log::info("thirdPartyEntity > getNegativeFeedback >> " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function thirdPartyReviewsCount($request)
    {
        try{
            $dashboard = new DashboardEntity();
            return $dashboard->thirdPartyReviewsCount($request);
        }
        catch(Exception $e)
        {
            Log::info("thirdPartyEntity > getBusinessDetail >> " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    /**
     * It checks the social data and compare the issues
     * @param $request (token, business_id)
     * @param $apiType
     * @return mixed
     */
    public function storedApiCompareData($request, $apiType)
    {
        try{
            $businessEntityObj = new BusinessEntity();

            $apiModule = IssuesList::where('site', $apiType)
                ->select("module")
                ->first();

            if($apiModule)
            {
                $module = explode(' ', trim($apiModule['module']));
                $module = strtolower($module[0]);

                $businessId = $request->get('business_id');

                $userBusinessResult = $businessEntityObj->getBusinessDetail($request);

                if($userBusinessResult['_metadata']['outcomeCode'] != 200)
                {
                    return $userBusinessResult;
                }

                $userBusinessResult = $userBusinessResult['records'];

                $userId = $userBusinessResult[0]['user_id'];

                if($module == 'social')
                {
                    $thirdPartyResult = SocialMediaMaster::where(
                        [
                            'business_id' => $businessId,
                            'type' => $apiType
                        ]
                    )->first();

                    if( $thirdPartyResult['name'] == '' && $thirdPartyResult['page_id'] == '')
                    {
                        return null;
                    }

                    $phoneIssue = ($thirdPartyResult['phone'] != '') ? 18 : 49;
                    $phoneOldIssue = ($thirdPartyResult['phone'] == '') ? 18 : 49;

                    $streetIssue = ($thirdPartyResult['street'] != '') ? 19 : 51;
                    $streetOldIssue = ($thirdPartyResult['street'] == '') ? 19 : 51;

                    $websiteIssue = ($thirdPartyResult['website'] != '') ? 20 : 50;
                    $websiteOldIssue = ($thirdPartyResult['website'] == '') ? 20 : 50;
                }

                if($thirdPartyResult)
                {
                    $thirdPartyId = $thirdPartyResult['id'];

                    $issueData = [
                        [
                            'key' => 'phone',
                            'value' => $thirdPartyResult['phone'],
                            'issue' => $phoneIssue,
                            'oldIssue' => $phoneOldIssue
                        ],
                        [
                            'key' => 'address',
                            'value' => $thirdPartyResult['street'],
                            'issue' => $streetIssue,
                            'oldIssue' => $streetOldIssue
                        ],
                        [
                            'key' => 'website',
                            'value' => $thirdPartyResult['website'],
                            'issue' => $websiteIssue,
                            'oldIssue' => $websiteOldIssue
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

                    $this->globalIssueGenerator($userId, $businessId, $thirdPartyId, $issueData, $apiType, $module);
                }
            }
            else
            {
                Log::info("api module is missing");
            }
        }
        catch(Exception $e)
        {
            Log::info("thirdPartyEntity > storedApiCompareData >> " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function updateThirdPartyApp($request)
    {
        Log::info("updateThirdPartyApp " . json_encode($request->all()));

        $thirdPartyObj = new TripAdvisorEntity();
        $businessObj = new BusinessEntity();

        try {
            $businessResult = $businessObj->userSelectedBusiness();

            if ($businessResult['_metadata']['outcomeCode'] != 200) {
                return $this->helpError(1, 'Problem in selection of your business.');
            }

            $type = strtolower($request->type);
            Log::info("Business updateThirdPartyApp -> $type Process started " . json_encode($request->all()));

            if($type == 'zocdoc')
            {
                $result = $this->onlineEntity->getZocDocListingDetail($request->get('targetUrl'));
            }
            elseif($type == 'healthgrades')
            {
                $result = $this->onlineEntity->getHealthGradeListingDetail($request->get('targetUrl'));
            }
            elseif($type == 'ratemd')
            {
                $result = $this->onlineEntity->getRateMdsListingDetail($request->get('targetUrl'));
            }

            $responseCode = $result['_metadata']['outcomeCode'];

            if($responseCode != 200)
            {
                return $result;
            }

            $userBusiness = $businessResult['records'];
            $businessId = $userBusiness['business_id'];
            $userId = $userBusiness['user_id'];

            return DB::transaction(function () use ($request, $responseCode, $result, $businessId, $userId, $type, $businessObj, $thirdPartyObj)
            {
                $data = [];

                $data['type'] = ucfirst($type);

                $thirdPartyResult = ThirdPartyMaster::where(
                    [
                        'business_id' => $businessId,
                        'type' => $data['type']
                    ]
                )->first();

                if($responseCode == 200)
                {
                    $records = $result['records'];
                    $userReviews = '';

                    if(!empty($records['ReviewsDetails']))
                    {
                        $userReviews = $records['ReviewsDetails'];
                    }
                    else if(!empty($records['ReviewsDetail']))
                    {
                        $userReviews = $records['ReviewsDetail'];
                    }

                    /**
                     * if user business record meet on type area
                     * save data to third_party_master_table
                     */
                    if ($records)
                    {
                        Log::info("$type updating process started");


                        $data['business_id'] = $businessId;

                        $data['name'] = $records['Name'];

                        if(!empty($records['Url']))
                        {
                            $data['page_url'] = $records['Url'];
                        }
                        else if(!empty($records['URL']))
                        {
                            $data['page_url'] = $records['URL'];
                        }

                        $data['average_rating'] = getIndexedvalue($records, 'Rating');
                        $phoneNo = trim(getIndexedvalue($records, 'Phone'));

                        if(empty($phoneNo))
                        {
                            $phoneNo = trim(getIndexedvalue($records, 'ContactNo'));
                        }

                        $data['phone'] = $phoneNo;

                        $streetAddress = $records['AddressDetail']['Street'];

                        if(empty($streetAddress))
                        {
                            $streetAddress = getIndexedvalue($records['Address'], 0);
                        }
                        Log::info("ste");
                        Log::info($streetAddress);

                        $data['street'] = $streetAddress;

                        $data['city'] = $records['AddressDetail']['City'];
                        $data['zipcode'] = $records['AddressDetail']['Zip'];
                        $data['state'] = $records['AddressDetail']['State'];
                        $data['country'] = $records ['AddressDetail']['Country'];
                        $data['website'] = trim(getIndexedvalue($records, 'Website'));
                        $reviewCount = getIndexedvalue($records, 'Reviews');

                        if(empty($reviewCount))
                        {
                            $reviewCount = getIndexedvalue($records, 'Review');
                        }

                        $data['review_count'] = $reviewCount;

                        $data['is_manual_deleted'] = 0;
                        $data['is_manual_connected'] = 1;

                        if (!empty($thirdPartyResult['third_party_id']))
                        {
                            Log::info("update $type");
                            $thirdPartyId = $thirdPartyResult['third_party_id'];

                            $this->thirdPartyMaster->delThirdPartyBusiness($businessId, $type);
                        }

                        Log::info("update create");
                        $thirdPartyResult = ThirdPartyMaster::create($data);

                        $thirdPartyId = (!empty($thirdPartyResult['third_party_id'])) ? $thirdPartyResult['third_party_id'] : NULL;



                        /**
                         * If business name replaced with the new one.
                         * Delete previously stored reviews
                         * Store new reviews in system.
                         */
                        if ($thirdPartyId)
                        {

                            Log::info("inside > $thirdPartyResult");

                            /**
                             * Only save reviews in system
                             * if business is updated VIA Manual connect
                             */
                            if (!empty($userReviews))
                            {
                                $thirdPartyObj->storeUserReviews($userReviews, $thirdPartyId, $data['type'], $request);
                            }
                        }

                        return $this->helpReturn("Response.", $thirdPartyResult);
                    }
                }

                return $this->helpError(404, 'Business record not found.');
            });
        }
        catch (Exception $exception) {
            Log::info("ThirdPartyEntity > updateThirdPartyApp >> " . $exception->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function removeThirdPartyBusiness($request)
    {
        Log::info("inside of removeThirdPartyBusiness");
        try {
            $businessObj = new BusinessEntity();
            $businessResult = $businessObj->userSelectedBusiness();
            log::info('$businessResult');
//            log::info($businessResult);
//            log::info($request);

            if ($businessResult['_metadata']['outcomeCode'] == 200) {
                $businessResult = $businessResult['records'];
                $businessId = $businessResult['business_id'];
                $userId = $businessResult['user_id'];
                $type = $request->get('type');

                if ($type == '') {
                    return $this->helpError(3, 'Problem in unlink this business');
                }

                return DB::transaction(function () use ($type, $businessId, $userId, $request) {
                    $name = '';

                    $typeModule = IssuesList::where('site', $type)->select('module')->first();

                    $module = 'local';

                    if(!empty($typeModule))
                    {
                        $module = explode(' ', trim($typeModule['module']));
                        $module = strtolower($module[0]);
                    }
//                    log::info('$typeModule');
//                    log::info($typeModule);
//                    log::info('$module');
//                    log::info($module);
                    if (strtolower($module) == 'social') {
                        $thirdPartyResult = SocialMediaMaster::where(
                            [
                                'business_id' => $businessId,
                                'type' => $type,
                            ]
                        )->first();


                        if (!empty($thirdPartyResult['name'])) {
                            $name = $thirdPartyResult['name'];

                            UserIssues::where
                            (
                                [
                                    'social_media_id' => $thirdPartyResult['id'],
                                    'business_id' => $businessId
                                ]
                            )->delete();

                            $thirdPartyResult->update(
                                [
                                    'page_id' => NULL,
                                    'access_token' => NULL,
                                    'page_access_token' => NULL,
                                    'name' => NULL,
                                    'page_url' => NULL,
                                    'add_review_url' => NULL,
                                    'average_rating' => NULL,
                                    'page_reviews_count' => NULL,
                                    'page_likes_count' => NULL,
                                    'website' => NULL,
                                    'phone' => NULL,
                                    'street' => NULL,
                                    'city' => NULL,
                                    'zipcode' => NULL,
                                    'country' => NULL,
                                    'cover_photo' => NULL,
                                    'profile_photo' => NULL,
                                    'is_manual_connected' => 0,
                                    'is_manual_deleted' => 1
                                ]
                            );
                        }

                        SMediaReview::where('social_media_id', $thirdPartyResult['id'])->delete();
                        SocialMediaLike::where('social_media_id', $thirdPartyResult['id'])->delete();
//                        SocialMediaInsight::where('social_media_id', $thirdPartyResult['id'])->delete();
                        StatTracking::where('social_media_id', $thirdPartyResult['id'])->delete();
                        //remove all posts record

//                        $request->request->add(['business_id' => $businessId, 'type' => 'Facebook']);
//                        $this->socialEntity->removeThirdParties($request);


                    } else {
                        $thirdPartyResult = ThirdPartyMaster::where(
                            [
                                'business_id' => $businessId,
                                'type' => $type,
                            ]
                        )->first();

//                        log::info('$thirdPartyResult');
//                        log::info($thirdPartyResult);

//                        $thirdPartyMasterObj->delThirdPartyBusiness()

                        if (!empty($thirdPartyResult['name'])) {
                            $name = $thirdPartyResult['name'];

                            UserIssues::where
                            (
                                [
                                    'third_party_id' => $thirdPartyResult['third_party_id'],
                                    'business_id' => $businessId
                                ]
                            )->delete();

                            $thirdPartyResult->update(
                                [
                                    'name' => NULL,
                                    'location_id' => NULL,
                                    'page_url' => NULL,
                                    'review_count' => NULL,
                                    'average_rating' => NULL,
                                    'website' => NULL,
                                    'phone' => NULL,
                                    'fax' => NULL,
                                    'street' => NULL,
                                    'city' => NULL,
                                    'zipcode' => NULL,
                                    'state' => NULL,
                                    'country' => NULL,
                                    'is_manual_connected' => 0,
                                    'is_manual_deleted' => 1,
                                ]
                            );
                        }

                        $thirdReview = TripadvisorReview::where('third_party_id', $thirdPartyResult['third_party_id'])->delete();
                        $statTracking = StatTracking::where('third_party_id', $thirdPartyResult['third_party_id'])->delete();
//                        log::info('$thirdReview');
//                        log::info($thirdReview);
//                        log::info('$statTracking');
//                        log::info($statTracking);



                    }

                    if (!empty($name)) {
                        return $this->helpReturn("App is removed from your account.");
                    } else {
                        return $this->helpError(404, 'No business record exist in system.');
                    }
                });
            } else {

                return $this->helpError(3, 'Your request is not fulfilled. Please try again.');
            }
        } catch (Exception $exception) {
            Log::info(" ThirdPartyEntity -> removeThirdPartyBusiness " . $exception->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }
}
