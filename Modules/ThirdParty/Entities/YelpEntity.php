<?php

namespace Modules\ThirdParty\Entities;

use App\Entities\AbstractEntity;
use App\Traits\UserAccess;
use Exception;
use FuzzyWuzzy\Fuzz;
use Illuminate\Http\Request;
use Modules\Business\Entities\BusinessEntity;
use Modules\ThirdParty\Models\StatTracking;
use Modules\ThirdParty\Entities\ThirdPartyEntity;
use Modules\ThirdParty\Models\TripadvisorMaster;
use Modules\ThirdParty\Models\TripadvisorReview;
use Modules\Business\Models\Business;
use Modules\Business\Models\ChatMaster;
use Modules\MadisonCentral\Entities\ChatHistoryEntity;
use Modules\MadisonCentral\Models\ChatHistory;
use Modules\MadisonCentral\Models\ChatIssueLogs;
use GuzzleHttp\Client;
use Config;
use Log;
use DB;
use Modules\ThirdParty\Entities\TripAdvisorEntity;


class YelpEntity extends AbstractEntity
{

    use UserAccess;

//    protected $ChatHistoryEntity;

    public function __construct()
    {
//        $this->ChatHistoryEntity = new ChatHistoryEntity();
    }


    /**
     * Get data from yelp of given business name.
     * @param Request $request
     * @return mixed
     */

    public function getBusinessDetail(Request $request)
    {
        Log::info("automatic connection for yelp");
        try {
            if($request->has('businessKeyword'))
            {
                $businessKeyword = $request->get('businessKeyword');
            }
            elseif($request->has('name'))
            {
                $businessKeyword = $request->get('name');
            }
            Log::info('this is business businessKeyword');
            Log::info($businessKeyword);
            $query = ['keyword' => $businessKeyword, 'key' => 'AEFFA66A3F48B', 'pagination' => 'true', 'paginationLimit' => '1'];

            if($request->has('phone'))
            {
                $query['PhoneNo'] = $request->get('phone');
            }

            Log::info("yelp query " . json_encode($query));

            $appEnvironment = Config::get('apikeys.APP_ENV');


//            $serverUrl = ( $appEnvironment == 'production') ? Config::get('custom.Scrapper_Prod_SERVER_URL'): Config::get('custom.SERVER_URL');
//            $detailUrl = ( $appEnvironment == 'production') ? Config::get('custom.yelpProdBusinessDetail'): Config::get('custom.yelpTestBusinessDetail');

            $serverUrl = ( $appEnvironment == 'production') ? Config::get('custom.PEN_Scrapper_Prod_SERVER_URL'): Config::get('custom.PEN_SERVER_URL');
            $detailUrl = ( $appEnvironment == 'production') ? Config::get('custom.yelpProdBusinessDetail'): Config::get('custom.yelpTestBusinessDetail');

            $url = $serverUrl.$detailUrl;

            $client = new Client([]);

            Log::info("yelp URL " . $url);

            $response = $client->request(
                'GET', $url,
                [
                    'query' => $query
                ]
            );
            $responseData = json_decode($response->getBody()->getContents(), true);
            Log::info('automatic responseData check');
            Log::info($responseData);
            $records = $responseData['Results'];

            if($response->getStatusCode() == 200)
            {
                if (!empty(($responseData['Results']['Name']))) {
                    return $this->helpReturn("Yelp Response.", $responseData);
                }
            }

            return $this->helpError(404, 'Record not found.');
        }
        catch(Exception $e)
        {
            Log::info("yelpentity > getBusinessDetail >> " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }


    public function getBusinessListed($businessName, $businessState, $businessCountry)
    {
        try {

            Log::info("Business Listed TA Cron Job > $businessName");

            $client = new Client([]);

            $response = $client->request(
                'GET',
                'http://67.227.145.153:4548/sandbox/api/home/GetYelpBuisnessDetail',
                [
                    'query' => [
                        'keyword' => $businessName,
                        'location'=>$businessState,$businessCountry
                    ],
                ]
            );
            $responseData = json_decode($response->getBody()->getContents(), true);

            $records = $responseData['Results'];

            if($response->getStatusCode() == 200)
            {
                Log::info("YELP complte in");
                if (!empty(($responseData['Results']['Name']))) {
                    return $this->helpReturn("Yelp Response.", $responseData);
                }

                return $this->helpError(404, 'Record not found.');
            }

        }
        catch(Exception $e)
        {
            Log::info("yelpentity > getBusinessListed >> " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function getBusinessHistoricalDetail(Request $request)
    {
        try {
            $businessKeyword = $request->get('businessKeyword');
            $client = new Client([]);
            $response = $client->request(
                'GET',
                'http://67.227.145.153:4548/sandbox/api/home/GetYelpBuisnessDetail',
                [
                    'query' => [
                        'HistoricalReviews' => 'true',
                        'Keyword' => $businessKeyword,
                    ],
                ]
            );

            $responseData = json_decode($response->getBody()->getContents(), true);
            $records = $responseData['Results'];
            if ($response->getStatusCode() == 200) {
                if (!empty(($responseData['Results']['Name']))) {
                    return $this->helpReturn("Yelp Historical Business Detail.", $responseData);
                }
                return $this->helpError(404, 'Record not found.');
            }
        } catch (Exception $e) {
            Log::info("yelpentity > getBusinessHistoricalDetail >> " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    /**
     * Get data from yelp of given business url
     * @param Request $request
     * @return mixed
     */
    public function getBusinessUrlDetail(Request $request)
    {
        try {
            $businessUrl = $request->get('businessUrl');
            $client = new Client([]);

            $response = $client->request(
                'GET',
                'http://144.217.182.179:4548/sandbox/api/home/GetYelpBuisnessDetailByURL',
                [
                    'query' => [
                        'BuisnessURL' => $businessUrl,
                    ],
                ]
            );

            $responseData = json_decode($response->getBody()->getContents(), true);

            $records = $responseData['Results'];

            if($response->getStatusCode() == 200)
            {
                if (!empty(($responseData['Results']['Name']))) {
                    return $this->helpReturn("Yelp Response.", $responseData);
                }
            }

            return $this->helpError(404, 'Record not found.');
        }
        catch(Exception $e)
        {
            Log::info("yelpentity > getBusinessUrlDetail >> " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }


    public function getBusinessUrlHistoricalDetail($data)
    {

        try {
            $businessUrl = $data;

            $client = new Client([]);

//            $appEnvironment = Config::get('apikeys.APP_ENV');
//    fn
            $queryParams1 = [
                'key' => 'AEFFA66A3F48B',
                'url' => $businessUrl,
                'pagination' => 'true',
                'paginationLimit' => '1'
            ];
            $queryParams2 = [
                'HistoricalReviews' => 'true',
                'BuisnessURL' => $businessUrl,
            ];

//            $serverUrl = ( $appEnvironment == 'production') ? Config::get('custom.Scrapper_Prod_SERVER_URL'): Config::get('custom.SERVER_URL');
//            $detailUrl = ( $appEnvironment == 'production') ? Config::get('custom.yelpProdManualConnect'): Config::get('custom.yelpTestManualConnect');
            $backupMode = Config::get('apikeys.backupMode');

            $serverUrl = ( $backupMode == 'live' ) ? Config::get('custom.PEN_Scrapper_Prod_SERVER_URL'): Config::get('custom.SERVER_URL');

            $detailUrl = ( $backupMode == 'live' ) ? Config::get('custom.yelpProdManualConnect'): Config::get('custom.landingYelpTestManualConnect');

            $queryParams = ( $backupMode == 'live' ) ? $queryParams1 : $queryParams2;

            $url = $serverUrl.$detailUrl;
            Log::info($url);

            $response = $client->request(
                'GET',
                $url,
                [
                    'query' => $queryParams,
                ]
            );

            $responseData = json_decode($response->getBody()->getContents(), true);

            Log::info("YELP Complete");

            if($response->getStatusCode() == 200)
            {
                Log::info("YELP Complete in");

                if (!empty(($responseData['Results']['Name']))) {
                    return $this->helpReturn("Yelp Historical Business Url Detail.", $responseData);
                }
            }

            Log::info('Record not found');
            return $this->helpError(404, 'Record not found.');
        }
        catch(Exception $e)
        {
            Log::info("yelpentity getBusinessUrlHistoricalDetail >> " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }

    }

    public function storeThirdPartyMaster(Request $request)
    {
        Log::info("Business Yelp Register Process started" . json_encode($request->all()));
        $thirdPartyObj = new TripAdvisorEntity();

        // get business detail from yelp.
        $result = $this->getBusinessDetail($request);
        $responseCode = $result['_metadata']['outcomeCode'];

        $data['type'] = 'Yelp';

        if ($responseCode == 200) {

            $records = $result['records']['Results'];

            $userReviews = $result['records']['Results']['ReviewsDetail'];

            $fuzz = new Fuzz();

            if ($records) {
                $score = $fuzz->tokenSortRatio($request->get('name'), $records['Name']);
                Log::info("Yelp Scrapper -> Score of -> $score > Business Name > " . $request->get('name') . " > Yelp Scrapper Name " . $records['Name']);

                if ($score >= 40) {
                    Log::info("Ok for Yelp sc");

                    $data = [];
                    $businessId = $request->get('business_id');
                    $data['type'] = 'Yelp';
                    $data['business_id'] = $businessId;
                    $data['name'] = $records['Name'];
                    $data['page_url'] = $records['URL'];
                    $data['review_count'] = (!empty($records['Review'])) ? $records['Review'] : 0;
                    $data['average_rating'] = (!empty($records['Rating'])) ? $records['Rating'] : 0;

                    $data['phone'] = $records['ContactNo'];
                    $data['street'] = $records['AddressDetail']['Street'];
                    $data['city'] = $records['AddressDetail']['City'];
                    $data['zipcode'] = $records['AddressDetail']['Zip'];
                    $data['state'] = $records['AddressDetail']['State'];
                    $data['country'] = $records ['AddressDetail']['Country'];
                    $data['website'] = $records['Website'];
                    $data['add_review_url'] = $records['AddReviewURL'];
                    /**
                     * Remove extra spaces from address
                     */
                    $address = $data['street'];
                    $address = preg_replace('/\s+/', ' ', $address);
                    $data['street'] = $address;
                    $YelpResult = YelpMaster::create($data);
                    $thirdPartyId = (!empty($YelpResult['third_party_id'])) ? $YelpResult['third_party_id'] : NULL;
                    $issueData = [
                        [
                            'key' => 'phone',
                            'value' => $data['phone'],
                            'issue' => (filterPhoneNumber($data['phone']) != '') ? 13 : 43,
                            'oldIssue' => (filterPhoneNumber($data['phone']) == '') ? 13 : 43
                        ],
                        [
                            'key' => 'address',
                            'value' => $data['street'],
                            'issue' => ($data['street'] != '') ? 14 : 45,
                            'oldIssue' => ($data['street'] == '') ? 14 : 45
                        ],
                        [
                            'key' => 'website',
                            'value' => $data['website'],
                            'issue' => ($data['website'] != '') ? 15 : 44,
                            'oldIssue' => ($data['website'] == '') ? 15 : 44
                        ],
                        [
                            'key' => 'reviews',
                            'value' => $data['review_count'],
                            'issue' => 66,
                            'oldIssue' => ""
                        ],
                        [
                            'key' => 'rating',
                            'value' => $data['average_rating'],
                            'issue' => 62,
                            'oldIssue' => ""
                        ]
                    ];
                    $thirdPartyEntity = new ThirdPartyEntity();
                    $thirdPartyEntity->globalIssueGenerator($request->get('userID'), $businessId, $thirdPartyId, $issueData, $data['type'], 'local');
                    return $this->helpReturn("Yelp Response.", $YelpResult);
                }
                else {
                    Log::info("Yelp Name accuracy issue");
                    $responseCode = 404;
                }
            }


        }

        if($responseCode == 404 || $responseCode == 1) {
            $businessId = $request->get('business_id');

            $insertIssue = [
                [
                    'key' => 'name',
                    'userID' => $request->get('userID'),
                    'business_id' => $businessId,
                    'issue' => 12,
                    'type' => 'Yelp'
                ]
            ];

            $thirdPartyObj->compareThirdPartyRecord($insertIssue);
        }

        return $this->helpError(404, 'Record not found.');
    }

    public function updateYelpMaster(Request $request)
    {
        Log::info("Business Update -> yelp Process started " . json_encode($request->all()));

        $thirdPartyObj = new TripAdvisorEntity();
        $thirdPartyEntity = new ThirdPartyEntity();
        $userId = $request->get('userID');

        try {
            if( empty( $request->get('targetUrl') ) )
            {
                $thirdPartyResult = TripadvisorMaster::where(
                    [
                        'business_id' => $request->get('business_id'),
                        'type' => 'yelp'
                    ]
                )->first();

                if( $thirdPartyResult )
                {
                    /**
                     * This Business has been Manual deleted
                     * so we can not add this business again.
                     * We can only add this business by two ways
                     * 1- Manual Connect
                     * 2- By Replacing Business Name.
                     */
                    if( $thirdPartyResult['is_manual_deleted'] == 1 && empty($request->get('isNameChanged')) )
                    {
                        return $this->helpError(3, 'Business stats showing this business already deleted. so you can only connect it By Manual connect or replace Business Name.');
                    }

                    /**
                     * if data is manual connected & business name not changed
                     * then only get data & recompare with the issues.
                     */
                    if(  $thirdPartyResult['is_manual_connected'] == 1 && empty($request->get('isNameChanged')) )
                    {
                        $thirdPartyId = $thirdPartyResult['third_party_id'];

                        $issueData = [
                            [
                                'key' => 'phone',
                                'value' => $thirdPartyResult['phone'],
                                'issue' => (filterPhoneNumber($thirdPartyResult['phone']) != '') ? 13 : 43,
                                'oldIssue' => (filterPhoneNumber($thirdPartyResult['phone']) == '') ? 13 : 43
                            ],
                            [
                                'key' => 'address',
                                'value' => $thirdPartyResult['street'],
                                'issue' => ($thirdPartyResult['street'] != '') ? 14 : 45,
                                'oldIssue' => ($thirdPartyResult['street'] == '') ? 14 : 45
                            ],
                            [
                                'key' => 'website',
                                'value' => $thirdPartyResult['website'],
                                'issue' => ($thirdPartyResult['website'] != '') ? 15 : 44,
                                'oldIssue' => ($thirdPartyResult['website'] == '') ? 15 : 44
                            ],
                            [
                                'key' => 'reviews',
                                'value' => $thirdPartyResult['review_count'],
                                'issue' => 66,
                                'oldIssue' => ""
                            ],
                            [
                                'key' => 'rating',
                                'value' => $thirdPartyResult['average_rating'],
                                'issue' => 62,
                                'oldIssue' => ""
                            ]
                        ];

                        $thirdPartyEntity->globalIssueGenerator($userId, $request->get('business_id'), $thirdPartyId, $issueData, 'Yelp', 'local');

                        return $this->helpReturn("Yelp Response.");
                    }
                }

                /*
                 * onlyIssuesCompare = true
                 * we don't want to again call scrapper. we've to only compare issues.
                 * But if third party data not found from table then return from here don't go next.
                 */
                if(!empty($request->get('onlyIssuesCompare')))
                {
                    return $this->helpError(3, 'Third party business compared.');
                }

                Log::info("YELP going to call API");


                $data['type'] = 'Yelp';
                /**
                 * call scrapper api -> get business detail from yelp.
                 * yes it takes data every time, may be user has changed some
                 * info at yelp.
                 */
                $result = $this->getBusinessDetail($request);
            }
            else
            {
                $result = $this->getBusinessUrlHistoricalDetail($request->get('targetUrl'));
            }

            return DB::transaction(function () use ($request, $result, $userId, $thirdPartyObj, $thirdPartyEntity) {
                $businessId = $request->get('business_id');

                // request response
                $responseCode = $result['_metadata']['outcomeCode'];

                $data = [];
                $data['type'] = 'Yelp';

                $businessObj = new BusinessEntity();

                $thirdPartyResult = TripadvisorMaster::where(
                    [
                        'business_id' => $businessId,
                        'type' => $data['type']
                    ]
                )->first();

                if($responseCode == 200)
                {
                    $records = $result['records']['Results'];
                    $userReviews = $result['records']['Results']['ReviewsDetail'];

                    Log::info("usereviews");
                    Log::info($userReviews);

                    /**
                     * if user business record meet on yelp area
                     * save data to third_party_master_table
                     */
                    if ($records)
                    {
                        /**
                         * Purpose of this check to restrict new Listing If previous business is already
                         * Inserted. If business gets updated Except Name but with any field Phone, street
                         *
                         * Previously Sometimes new business occur from scrapper if any field changed from
                         * business fields like phone. so to avoid this. put this check to stop business
                         * replace. Now When new business is occur and this is not matched with our existing
                         * third party Business we'll return from here.
                         */
                        if (empty($request->get('targetUrl'))) {
                            if (empty($request->get('isNameChanged')) && !empty($thirdPartyResult['name'])) {
                                if (strtolower($thirdPartyResult['name']) != strtolower($records['Name'])) {
                                    Log::info("YELP  stop new listing" . $thirdPartyResult['name'] . " > " . $records['Name']);

                                    return $this->helpReturn("Data already saved. New Business try to insert.", $thirdPartyResult);
                                }
                            }
                            else
                            {
                                Log::info("Yelp New business discovery process started");

                                $fuzz = new Fuzz();

                                $score = $fuzz->tokenSortRatio(strtolower($request->get('businessKeyword')), strtolower($records['Name']));

                                Log::info("Update Yelp Scrapper -> Score of -> $score > Business Name > " . $request->get('businessKeyword') . " > Yelp Scrapper Name " . $records['Name']);

                                if ($score < 40) {
                                    Log::info("Yelp Accuracy failure");

                                    /**
                                     * name issue not generate in third party master row,
                                     * It will only generate into userissues table.
                                     */
                                    $thirdPartyMasterObj = new TripadvisorMaster();
                                    $insertIssue = [
                                        [
                                            'key' => 'name',
                                            'userID' => $userId,
                                            'business_id' => $businessId,
                                            'issue' => 12,
                                            'type' => $data['type']
                                        ]
                                    ];

                                    $thirdPartyObj->compareThirdPartyRecord($insertIssue);

                                    /**
                                     * delete previous stored business trace
                                     *  first business was present & second time busienss not found on update
                                     * time, so delete the business.
                                     */
                                    $thirdPartyMasterObj->delThirdPartyBusiness($businessId, $data['type']);

                                    return $this->helpError(404, 'Yelp Business accuracy failure.');
                                }
                            }
                        }

                        Log::info("YELP updating process started");

                        $data['business_id'] = $businessId;


                        $data['average_rating'] = (!empty($records['Rating'])) ? $records['Rating'] : 0;
                        $data['review_count'] = (!empty($records['Review'])) ? $records['Review'] : 0;

                        $data['phone'] = trim($records['ContactNo']);
                        $data['street'] = $records['AddressDetail']['Street'];
                        $data['city'] = $records['AddressDetail']['City'];
                        $data['zipcode'] = $records['AddressDetail']['Zip'];
                        $data['state'] = $records['AddressDetail']['State'];
                        $data['country'] = $records ['AddressDetail']['Country'];
                        $data['website'] = (!empty($records['Website'])) ? $records['Website'] : '';
                        $data['add_review_url'] = (!empty($records['add_review_url'])) ? $records['add_review_url'] : '';
//                        $data['add_review_url'] = $records['AddReviewURL'];

                        /**
                         * Remove extra spaces from address
                         */
                        $address = $data['street'];
                        $address = preg_replace('/\s+/', ' ', $address);
                        $data['street'] = $address;


                        if (empty($request->get('targetUrl')))
                        {
                            $isNameChanged = $request->get('isNameChanged');
                            $data['is_manual_connected'] = 0;
                        }
                        else if (!empty($request->get('targetUrl')))
                        {
                            /**
                             * check if business name changed and we search from
                             * url by manual connect
                             */
                            $oldBusinessName = strtolower(@$thirdPartyResult['name']);

                            // tYelp name
                            $newBusinessName = strtolower($records['Name']);
                            $isNameChanged = ($newBusinessName != $oldBusinessName) ? true : false;

                            $data['is_manual_connected'] = 1;
                        }


                        /**
                         * isNameChanged = true
                         * Delete previously stored reviews
                         * Store new reviews in system.
                         */
                        if (empty($thirdPartyResult['third_party_id']))
                        {
                            $isNameChanged = true;
                        }
                        else
                        {
                            if ($thirdPartyResult['name'] == '')
                            {
                                $isNameChanged = true;
                            }
                        }

                        // name will be replaced with the new one.
                        if ($isNameChanged)
                        {
                            $data['name'] = $records['Name'];
                            $data['page_url'] = $records['URL'];
                        }

                        $data['is_manual_deleted'] = 0;
                        if (!empty($thirdPartyResult['third_party_id']))
                        {
                            Log::info("update yelp");
                            $thirdPartyId = $thirdPartyResult['third_party_id'];
                            $thirdPartyResult->update($data);
                        }
                        else
                        {
                            Log::info("update create");
                            $thirdPartyResult = TripadvisorMaster::create($data);

                            $thirdPartyId = (!empty($thirdPartyResult['third_party_id'])) ? $thirdPartyResult['third_party_id'] : NULL;
                        }

                        $issueData = [
                            [
                                'key' => 'phone',
                                'value' => $data['phone'],
                                'issue' => (filterPhoneNumber($data['phone']) != '') ? 13 : 43,
                                'oldIssue' => (filterPhoneNumber($data['phone']) == '') ? 13 : 43
                            ],
                            [
                                'key' => 'address',
                                'value' => $data['street'],
                                'issue' => ($data['street'] != '') ? 14 : 45,
                                'oldIssue' => ($data['street'] == '') ? 14 : 45
                            ],
                            [
                                'key' => 'website',
                                'value' => $data['website'],
                                'issue' => ($data['website'] != '') ? 15 : 44,
                                'oldIssue' => ($data['website'] == '') ? 15 : 44
                            ],
                            [
                                'key' => 'reviews',
                                'value' => $data['review_count'],
                                'issue' => 66,
                                'oldIssue' => ""
                            ],
                            [
                                'key' => 'rating',
                                'value' => $data['average_rating'],
                                'issue' => 62,
                                'oldIssue' => ""
                            ]
                        ];

                        $thirdPartyEntity->globalIssueGenerator($userId, $businessId, $thirdPartyId, $issueData, $data['type'], 'local');

                        /**
                         * If business name replaced with the new one.
                         * Delete previously stored reviews
                         * Store new reviews in system.
                         */
                        if ($thirdPartyId && $isNameChanged)
                        {
                            TripadvisorReview::where('third_party_id', $thirdPartyId)->delete();
                            StatTracking::where('third_party_id', $thirdPartyId)->delete();

                            /**
                             * Only save reviews in system
                             * if business is updated VIA Manual connect
                             */
                            if (!empty($userReviews) && !empty($request->get('targetUrl')))
                            {
                                $thirdPartyObj->storeUserReviews($userReviews, $thirdPartyId, $data['type'], $request);
                            }
                        }

                        return $this->helpReturn("Yelp Response.", $thirdPartyResult);

//                        if (empty($request->get('targetUrl')))
//                        {
//                            return $this->helpReturn("Yelp Response.", $thirdPartyResult);
//                        }
//                        else
//                        {
////                            $businessIssuesData = $businessObj->businessIssues($request, $businessId);
//
//                            if ($businessIssuesData['_metadata']['outcomeCode'] == 200)
//                            {
//                                $thirdPartyResult['businessIssues'] = $businessIssuesData['records'];
//                            }
//
//                            return $this->helpReturn("Yelp Response.", $thirdPartyResult);
//                        }
                    }
                }
                else if ($responseCode == 404 && empty( $request->get('targetUrl') ) )
                {
                    /**
                     * User does not change the Business Name but If we'll not get any Business on change Phone or field
                     * if any chance occured then we'll not delete user existing business because user does not want
                     * to delete that business
                     */
                    if (empty($request->get('isNameChanged')) && !empty($thirdPartyResult['name'])) {
                        Log::info("Yelp -> no need to delete a business record and generate an issue");
                        return $this->helpError(404, 'Business record not found.');
                    }

                    /**
                     * name issue not generate in third party master row,
                     * It will only generate into userissues table.
                     */
                    $thirdPartyMasterObj = new TripadvisorMaster();
                    $insertIssue = [
                        [
                            'key' => 'name',
                            'userID' => $userId,
                            'business_id' => $businessId,
                            'issue' => 12,
                            'type' => $data['type']
                        ]
                    ];

                    $thirdPartyObj->compareThirdPartyRecord($insertIssue);

                    /**
                     * delete previous stored business trace
                     *  first business was present & second time busienss not found on update
                     * time, so delete the business.
                     */
                    $thirdPartyMasterObj->delThirdPartyBusiness($businessId, $data['type']);
                }

                return $this->helpError(404, 'Business record not found.');
            });
        }
        catch (Exception $exception) {
            Log::info("yelpeneity > updateYelpMaster >> " . $exception->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function notifyUsers($request)
    {
        try{
            $businessResult = DB::table('business_master as bm')
                ->join('third_party_master as ypm', 'bm.business_id', '=', 'ypm.business_id')
                ->join('user_master as usm', 'bm.user_id', '=', 'usm.id')
                ->select('bm.user_id', 'usm.first_name', 'bm.business_id', 'ypm.business_id as yelpBusinessId', 'bm.name', 'third_party_id', 'page_url')
                ->where('ypm.type', 'Yelp')
                ->get();


            if(!empty($businessResult))
            {
                $yelpEntity = new YelpEntity();


                foreach($businessResult as $row) {

                    $arra = ['businessKeyword' => $row->name];
                    $request->merge($arra);

                    // get business detail from yelp
                    $result = $yelpEntity->getBusinessDetail($request);

                    if ($result['_metadata']['outcomeCode'] == 200) {

                        $records = $result['records']['Results'];
                        $userReviews = $result['records']['Results']['ReviewsDetail'];

                        /**
                         * if user business record meet on yelp area
                         * update third_party_master_table
                         */

                        if ($records) {
                            /**
                             * if user has reviews of current business then also update user Review
                             * against in third_party_review table..
                             */
                            if ((!empty($userReviews))) {
                                $thirdPartyObj = new TripAdvisorEntity();
                                $thirdPartyObj->storeUserReviews($userReviews, $row->third_party_id, 'Yelp');

                                /**
                                 * send notify to user, If any new entry posted
                                 */
                                if($result != 0) {

                                    // get yelp message.
                                    $chatMasterResult = ChatMaster::select('message')->find(18);

                                    $message = $chatMasterResult['message'] . ' >>' . $row->page_url;
                                    $message = reformatText($message, $row->first_name);

//                                User::find($row->user_id);

                                    $chatRequest = [
                                        'message' => $message,
                                        'user_id' => $row->user_id,
                                        'action' => 'reply_awaiting',
                                        'unread' => 1,
                                    ];

                                    $request->merge($chatRequest);

                                    // madison send notification to user.
                                    $chatResult = $this->ChatHistoryEntity->systemSendNotification($request);

                                    if($chatResult['_metadata']['outcomeCode'] == 200)
                                    {
                                        // make logs of current chat id against specific issue.
                                        $chatid = $chatResult['records']['chat_id'];


                                        /**
                                         * 16 is linked with yelp if user click yelp then
                                         *we take this id to get our result.
                                         */
                                        $data = [
                                            'chat_id' => $chatid,
                                            'issue_id' => 16,
                                        ];

                                        ChatIssueLogs::create($data);
                                    }
                                }
                            }
                        }
                    }
                }



                return $this->helpReturn("Yelp Cron Job Process Complete");
            }
        } catch (Exception $e) {
            Log::info("notifyUsers > Yelp Entity >> " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }
}
