<?php
/**
 * Created by Wahab
 * Date: 10/30/2017
 * Time: 2:51 PM
 */
namespace Modules\Business\Entities;
use App\Entities\AbstractEntity;
use App\Traits\UserAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Entities\AuthEntity;
use Modules\Business\Models\Business;
use Modules\Business\Models\KeywordMaster;
use Modules\Auth\Models\User;
use BrightLocal;
use GuzzleHttp\Client;
use Exception;
use Log;
use JWTAuth;
use DB;
use Config;
use Modules\Business\Entities\BusinessEntity;
use BrightLocal\Api;
use BrightLocal\Batches\V4 as BatchApi;
use Modules\Business\Models\KeywordRankingStat;
use Carbon\Carbon;
use Modules\Business\Models\LocalKeyword;
use Modules\Business\Models\SuggestedKeyword;
use Modules\ThirdParty\Entities\GooglePlaceEntity;

class KeywordEntity extends  AbstractEntity
{
    use UserAccess;

    protected $businessEntity;

    public function __construct()
    {
        //comments for testing purpose
        $this->googleplaceEntity = new GooglePlaceEntity();
    }

    public function saveBusinessKeywords($request)
    {
        try{
            $checkPoint = $this->setCurrentUser($request->get('token'))->userAllow();
            $user = $checkPoint['records'];
            $userId = $user['id'];

            $userKeywords = $request->except('token');

            if(empty($userKeywords['keywords']))
            {
                $userKeywords['keywords'] = [];
            }

            $keywordsData = array_filter($userKeywords['keywords']);

            if( !empty($keywordsData) )
            {
                if(count($keywordsData) > 5)
                {
                    return $this->helpError(3, 'Only 5 keywords of a business can be added.');
                }
            }

            $businessObj = new BusinessEntity();
            //comment original code for tesing
            //$userBusiness = $this->businessEntity->userSelectedBusiness($user);
            $userBusiness = $businessObj->userSelectedBusiness($user);

            if($userBusiness['_metadata']['outcomeCode'] != 200)
            {
                return $this->helpError(404, 'Problem in saving keywords of this business.');
            }

            if($userBusiness['records']['website'] == '')
            {
                return $this->helpError(3, 'Website not Setup.');
            }

            $businessId = $userBusiness['records']['business_id'];

            if(empty($keywordsData))
            {
                KeywordMaster::where('business_id', $businessId)->delete();

                return $this->helpReturn("Keywords deleted.");
            }

            $code = 4;

            $storedKeywordData = KeywordMaster::where('business_id', $businessId)
                ->get();

            if(empty($storedKeywordData->toArray()) && !empty($keywordsData))
            {
                foreach($keywordsData as $keyword)
                {
                    KeywordMaster::create(
                        [
                            'keyword' => $keyword,
                            'website' => $userBusiness['records']['website'],
                            'business_id' => $businessId
                        ]
                    );
                }

                return $this->helpReturn("Keywords saved");
            }
            elseif(!empty($storedKeywordData->toArray()))
            {
                $storedKeywords = [];

                foreach($storedKeywordData as $keyword)
                {
                    $storedKeywords[] = $keyword['keyword'];
                }

                if( !empty($keywordsData) )
                {
                    $userKeywords = $keywordsData;
                }

                // array_diff
                // Returns an array containing all the entries from $userKeywords that are not present in any of the $storedKeywords array.
                $keywordsManager = array_diff($userKeywords, $storedKeywords);
                $removeKeywords = array_diff($storedKeywords, $userKeywords);

                if(!empty($keywordsManager)) {
                    foreach($keywordsManager as $keyword) {
                        KeywordMaster::create(
                            [
                                'keyword' => $keyword,
                                'website' => $userBusiness['records']['website'],
                                'business_id' => $businessId
                            ]
                        );
                    }
                    $code = 200;
                }

                if(!empty($removeKeywords))
                {
                    foreach($removeKeywords as $removalElement)
                    {
                        KeywordMaster::where(
                            [
                                'business_id' => $businessId,
                                'keyword' => $removalElement
                            ]
                        )->delete();
                    }
                }
            }

            return $this->helpReturn("Keywords updated.", [], $code);

        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    /**
     * return keywords if website exist
     * if website not exist delete keywords if exist in database.
     *
     * @param Request $request
     * @return mixed
     */
    public function DisplayKeywordRankings(Request $request)
    {
        try {
            $businessObj = new BusinessEntity();

            $checkPoint = $this->setCurrentUser($request->get('token'))->userAllow();

            // user is not found.
            if($checkPoint['_metadata']['outcomeCode'] != 200)
            {
                return $checkPoint;
            }
            $user = $checkPoint['records'];

            $userBusiness = $businessObj->userSelectedBusiness($user);

            if($userBusiness['_metadata']['outcomeCode'] != 200)
            {
                return $this->helpError(404, 'Problem in fetch keywords of this business.');
            }

            $keywords = [];
            $businessId = $userBusiness['records']['business_id'];
            $keywords['name'] = $userBusiness['records']['name'];
            $keywords['business_id'] = $businessId;

            if($userBusiness['records']['website'] == '')
            {
                KeywordMaster::where('business_id', $businessId)->delete();

                $keywords['website'] = '';
                $keywords['message'] = 'Website not Setup';
                $keywords['keywords_ranking'] = [];
                return $this->helpReturn($keywords['message'], $keywords);
            }

            $keywords['website'] = $userBusiness['records']['website'];

            $keywords['keywords_ranking'] = KeywordMaster::select('id','keyword')
                ->where('business_id', $businessId)
                ->with(['keywordRankStat' => function($query){
                    $query->select('rank','created_date','keyword_master_id');
                }])->get();

            return $this->helpReturn("Graph Keyword Ranking Stats Result.", $keywords);
        }
        catch (Exception $e) {
            Log::info($e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }
    /********************************Keyword Ranking Update CRON JOB Start************************/

    public function updateReportBusinessKeywords(Request $request)
    {
        try {
            if( empty($request->get('requestType')) && empty($request->get('token')) )   // this part use for multiple business based update keyword ranking
            {

                $businessList = Business::where('website', '!=', '')
                    ->whereHas('keywordsRanking', function($q)
                    {
                        $q->where('business_id', '!=', '');
                    })->select('business_id', 'website')->with('keywordsRanking')->get()->toArray();

            }
            else  // this part use for token based update keyword ranking
            {
                $checkPoint = $this->setCurrentUser($request->get('token'))->userAllow();

                if($checkPoint['_metadata']['outcomeCode'] != 200)
                {
                    return $checkPoint;
                }
                $user = $checkPoint['records'];

                $businessList = $user->business()->where('website', '!=', '')->whereHas('keywordsRanking', function($q)
                {
                    $q->where('business_id', '!=', '');
                })->select('business_id', 'website')->with('keywordsRanking')->get()->toArray();
            }


            $keywordsData = [];
            if(!empty($businessList))
            {
                foreach ($businessList as $index => $business) {
                    $keywordsData[$index]['business_id'] = $business['business_id'];
                    $keywordsData[$index]['website'] = $business['website'];
                    foreach ($business['keywords_ranking'] as $keywordRow) {
                        $keywordsData[$index]['search-term'][] = $keywordRow['keyword'];
                        $keywordsData[$index]['keyword_id'][] = $keywordRow['id'];
                    }
                }
            }

            $result = $this->keywordRankingsUpdateCronJob($keywordsData);

            if ($result['_metadata']['outcomeCode'] == 200) {

                return $result;
            }

        } catch (Exception $e) {
            Log::info('Kyword Ranking', $e->getMessage());
            //return $this->helpError(1, 'Record Not Found');
        }
    }
    public function addLocalKeyword($request)
    {
        $businessObj = new BusinessEntity();

        $businessResult = $businessObj->userSelectedBusiness();

        $businessResult = $businessResult['records'];

        $businessId = $businessResult['business_id'];
        $businessWebsite = $businessResult['website'];

        $nonDeletedIds = [];
        $keywords = [];
        $dateFormat = 'Y-m-d';
        $currentDate = Carbon::now();
        $FormatedCurrentDate = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate)->format($dateFormat);

        $data = $request->get('keyword');

        if (!empty($data) && count($data) > 5) {
            return $this->helpError(3, 'Only 5 keywords of a business can be added.');
        }
        if (empty($data) && $businessResult->business_profile_status == 'completed') {
            Log::info('in delete section');
            LocalKeyword::where('business_id', $businessId)->delete();
            return $this->helpReturn("Keywords deleted.");
        }

        if (!empty($data)) {
            foreach ($data as $row) {
                $keywords = [
                    'keyword' => $row['keyword'],
                    'search_engine' => 'google',
                    'date' => $FormatedCurrentDate,
                    'volume' => (!empty($row['volume'])) ? $row['volume'] : 0,
                    'business_id' => $businessId,
                    'rank' => (!empty($row['rank'])) ? $row['rank'] : NULL,
                    'rank_status' => 'progress',
                ];
                Log::info($keywords);
                $id = LocalKeyword::updateOrCreate(['keyword' => $row['keyword'], 'business_id' => $businessId], $keywords);
                $nonDeletedIds[] = [
                    'id' => $id->id,
                ];
                $keywords = [];
            }
            if (!empty($nonDeletedIds)) {
                Log::info($nonDeletedIds);
                LocalKeyword::whereNotIn('id', $nonDeletedIds)->where('business_id',$businessId)->delete();
            }
        }
        return $this->helpReturn("Keywords Successfully Added.");
    }

    public function createProjectForKeyword($request)
    {
        try {
            $businessObj = new BusinessEntity();

            $businessResult = $businessObj->userSelectedBusiness();

            $businessResult = $businessResult['records'];

            $businessId = $businessResult['business_id'];
            $businessWebsite = $businessResult['website'];
            $businessName = $businessResult['practice_name'];
            $filterBusinessName = preg_replace("/[^a-zA-Z]/", "", $businessName);

            $projectId = '';
            $keywordsAppendArray = [];
            $keywords = [];
            $finalResponse = [];

            if (empty($businessWebsite)) {
                return $this->helpError(404, 'Website Not Setup');
            }

            $localKeyword = LocalKeyword::where('business_id', $businessId)
                ->where('rank','=',null)
                ->where(function($q){
                    $q->orWhere('rank_status','=','progress');
                    $q->orWhere('rank_status','=','complete');
                })
                ->get()->toArray();

            if (empty($localKeyword)) {
                return $this->helpError(3, 'No Keyword Found');
            }

            foreach ($localKeyword as $row) {
                $keywordsAppendArray['keywords'][] = [
                    'keyword' => $row['keyword'],
                    'tags' => [$row['keyword']],
                ];

                $keywords[] = [
                    'keyword' => $row['keyword'],
                    'search_engine' => $row['search_engine'],
                    'date' => $row['date'],
                    'volume' => $row['volume'],
                ];
            }

            $http = new \GuzzleHttp\Client;
            Log::info('business name');
            Log::info($businessName);
            /**
             * First Create Project
             * param project_name and url
             */
            try {
                $headers['Content-Type'] = 'application/json';
                $body = ['project_name' => $filterBusinessName, 'url' => $businessWebsite];
                $projectResponse = $http->request('POST', 'https://api.semrush.com/management/v1/projects?key=ebc1d52ac3697a99bd994dc8e46739f4',
                    [
                        'json' => $body,
                        'headers' => [
                            'Content-Type' => 'application/json'
                        ]
                    ]
                );
                $projectResponseData = json_decode($projectResponse->getBody()->getContents(), true);
                $projectId = $projectResponseData['project_id'];
            } catch (Exception $e) {
                Log::info('Project Not Create Due To Exception');
                Log::info('Create Project Section');
                Log::info($e->getMessage());
            }

            Log::info('project created');
            Log::info($projectId);

            if (isset($projectId) && !empty($projectId)) {
                /**
                 * now initialize project for getting rank
                 */
                Log::info('initialize project start');
                $parambody = ['tracking_url' => $businessWebsite, 'tracking_url_type' => 'rootdomain', 'weekly_notification' => 0, 'country_id' => 2840, 'device' => 'desktop'];
                $projectInitializeResponse = $http->request('POST', 'https://api.semrush.com/management/v1/projects/' . $projectId . '/tracking/enable?key=ebc1d52ac3697a99bd994dc8e46739f4',
                    [
                        'json' => $parambody,
                        'headers' => [
                            'Content-Type' => 'application/json'
                        ]
                    ]
                );

                if ($projectInitializeResponse->getStatusCode() == 200) {

                    $projectInitializeResponseData = json_decode($projectInitializeResponse->getBody()->getContents(), true);

                    /**
                     * Add Keyword in added project with project id
                     */
                    Log::info('add keyword in project');
                    $keywordResponse = $http->request('PUT', 'https://api.semrush.com/management/v1/projects/' . $projectId . '/keywords?key=ebc1d52ac3697a99bd994dc8e46739f4',
                        [
                            'json' => $keywordsAppendArray,
                            'headers' => [
                                'Content-Type' => 'application/json'
                            ]
                        ]
                    );
                    Log::info("going to start");
                    sleep(160);
                    Log::info("going to proceed");

                    if (!empty($businessWebsite) && $keywordResponse->getStatusCode() == 200) {
                        $keywordResponseData = json_decode($keywordResponse->getBody()->getContents(), true);
                        $finalResponse = $this->getKeywordsRanks($projectId, $businessWebsite, $businessId);
                    } else {
                        return $this->helpError(404, 'Keyword Not Added In Project');
                    }

                }
            }
            else {
                return $this->helpError(3, 'Project Not Setup');
            }
            Log::info('project create succussfully');
            Log::info('End Process');
            return $this->helpReturn("Create Project Successfully.");
        } catch (Exception $e) {
            Log::info('Create Project Over all exception');
            Log::info($e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }

    }

    public function cronjobForKeywordRanking($request)
    {
        try
        {
            $business = Business::get()->toArray();
            foreach($business as $businessResult){
                $businessId = $businessResult['business_id'];
                $businessName = $businessResult['practice_name'];
                $filterBusinessName = preg_replace("/[^a-zA-Z]/", "", $businessName);

                $businessWebsite = $businessResult['website'];

                $projectId = '';
                $keywordsAppendArray = [];
                $keywords = [];
                $finalResponse = [];

                $localKeyword = LocalKeyword::where('business_id', $businessId)
                    ->where(function($q){
                        $q->orWhere('rank_status','=','progress');
                        $q->orWhere('rank_status','=','complete');
                    })
                    ->get()->toArray();

                if(!empty($localKeyword) && !empty($businessWebsite)){

                    foreach ($localKeyword as $row) {
                        $keywordsAppendArray['keywords'][] = [
                            'keyword' => $row['keyword'],
                            'tags' => [$row['keyword']],
                        ];

                        $keywords[] = [
                            'keyword' => $row['keyword'],
                            'search_engine' => $row['search_engine'],
                            'date' => $row['date'],
                            'volume' => $row['volume'],
                        ];

                    }

                    $http = new \GuzzleHttp\Client;
                    Log::info('start create project');
                    Log::info('business name');
                    Log::info($businessName);
                    /**
                     * First Create Project
                     * param project_name and url
                     */
                    try {
                        $headers['Content-Type'] = 'application/json';
                        $body = ['project_name' => $filterBusinessName, 'url' => $businessWebsite];
                        $projectResponse = $http->request('POST', 'https://api.semrush.com/management/v1/projects?key=ebc1d52ac3697a99bd994dc8e46739f4',
                            [
                                'json' => $body,
                                'headers' => [
                                    'Content-Type' => 'application/json'
                                ]
                            ]
                        );
                        Log::info('project created response start');
                        $projectResponseData = json_decode($projectResponse->getBody()->getContents(), true);
                        $projectId = $projectResponseData['project_id'];
                        Log::info('project created');
                    } catch (Exception $e) {
                        Log::info('Create Project Sectiton');
                        Log::info($e->getMessage());
                    }
                    Log::info('project created');
                    if (isset($projectId) && !empty($projectId)) {
                        /**
                         * now initialize project for getting rank
                         */
                        $parambody = ['tracking_url' => $businessWebsite, 'tracking_url_type' => 'rootdomain', 'weekly_notification' => 0, 'country_id' => 2840, 'device' => 'desktop'];
                        $projectInitializeResponse = $http->request('POST', 'https://api.semrush.com/management/v1/projects/' . $projectId . '/tracking/enable?key=ebc1d52ac3697a99bd994dc8e46739f4',
                            [
                                'json' => $parambody,
                                'headers' => [
                                    'Content-Type' => 'application/json'
                                ]
                            ]
                        );
                        if ($projectInitializeResponse->getStatusCode() == 200) {

                            $projectInitializeResponseData = json_decode($projectInitializeResponse->getBody()->getContents(), true);

                            /**
                             * Add Keyword in added project with project id
                             */
                            Log::info('add keyword in project');
                            $keywordResponse = $http->request('PUT', 'https://api.semrush.com/management/v1/projects/' . $projectId . '/keywords?key=ebc1d52ac3697a99bd994dc8e46739f4',
                                [
                                    'json' => $keywordsAppendArray,
                                    'headers' => [
                                        'Content-Type' => 'application/json'
                                    ]
                                ]
                            );
                            Log::info("going to start");
                            sleep(160);
                            Log::info("going to proceed");

                            if (!empty($businessWebsite) && $keywordResponse->getStatusCode() == 200) {
                                $keywordResponseData = json_decode($keywordResponse->getBody()->getContents(), true);

                                $finalResponse = $this->getKeywordsRanksForCronJob($projectId, $businessWebsite, $businessId);
                            } else {
                                Log::info('Keyword Not Added In Project');
                            }
                        }

                    }else {
                        Log::info('Project Not Setup');
                    }
                    Log::info('project create succussfully');
                    Log::info('End Process');

                }
            }

            Log::info('project create succussfully');
            Log::info('End Process');
            return $this->helpReturn("Cron job Run Successfully.");

        } catch (Exception $e) {
            Log::info('Create Project Over all exception');
            Log::info($e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }

    }


    public function getKeywordsRanks($projectId, $website, $businessId)
    {
        try {
            $website = strtolower($website);
            $http = new \GuzzleHttp\Client;
            $response = $http->request('GET', 'https://api.semrush.com/reports/v1/projects/' . $projectId . '/trackingtracking',
                [
                    'query' =>
                        [
                            'action' => 'report',
                            'key' => 'ebc1d52ac3697a99bd994dc8e46739f4',
                            'type' => 'tracking_position_organic',
                            'url' => '*.' . $website . '/*',
                            'display_offset' => 0,
                            'linktype_filter' => 0,
                            'serp_filter_filter' => 'fsn',
                        ]
                ]
            );

            $finalJsonResponse = json_decode($response->getBody()->getContents(), true);
            $appendArray = [];
            if (isset($finalJsonResponse['data'])) {
                foreach ($finalJsonResponse['data'] as $row) {
                    $i = 1;
                    foreach ($row['Dt'] as $row1) {

                        $rank = $row1['*.' . $website . '/*'];
                        if ($i == 1) {
                            $appendArray = [
                                'keyword' => $row['Ph'],
                                'rank_status' => 'complete',
                                'rank' => !empty($rank) && $rank == '-' ? NULL : $rank,
                            ];

                            LocalKeyword::updateOrCreate(['keyword' => $row['Ph'], 'business_id' => $businessId], $appendArray);

                        }
                        $i++;
                    }

                }
            }

            if (!empty($appendArray)) {
                $http3 = new \GuzzleHttp\Client;
                $deleteProject = $http3->request('DELETE', 'https://api.semrush.com/management/v1/projects/' . $projectId . '?key=ebc1d52ac3697a99bd994dc8e46739f4');
                $deleteProjectResponse = json_decode($deleteProject->getBody()->getContents(), true);
            }
            return $this->helpReturn("Keyword Add Successfully.");
        } catch (Exception $e) {
            Log::info('Get Keyword Ranks');
            Log::info($e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function getKeywordsRanksForCronJob($projectId, $website, $businessId)
    {
        try
        {
            $website = strtolower($website);
            $http = new \GuzzleHttp\Client;
            $response = $http->request('GET', 'https://api.semrush.com/reports/v1/projects/' . $projectId . '/trackingtracking',
                [
                    'query' =>
                        [
                            'action' => 'report',
                            'key' => 'ebc1d52ac3697a99bd994dc8e46739f4',
                            'type' => 'tracking_position_organic',
                            'url' => '*.' . $website . '/*',
                            'display_offset' => 0,
                            'linktype_filter' => 0,
                            'serp_filter_filter' => 'fsn',
                        ]
                ]
            );

            $finalJsonResponse = json_decode($response->getBody()->getContents(), true);
            $appendArray = [];
            Log::info($finalJsonResponse);
            if (isset($finalJsonResponse['data'])) {
                foreach ($finalJsonResponse['data'] as $row) {
                    $i = 1;
                    foreach ($row['Dt'] as $row1) {

                        $rank = $row1['*.' . $website . '/*'];
                        if ($i == 1) {
                            $appendArray = [
                                'keyword' => $row['Ph'],
                                'rank_status' => 'complete',
                                'rank' => !empty($rank) && $rank == '-' ? NULL : $rank,
                            ];
                            LocalKeyword::updateOrCreate(['keyword' => $row['Ph'], 'business_id' => $businessId], $appendArray);
                        }
                        $i++;
                    }

                }
            }

            if (!empty($appendArray)) {
                $http3 = new \GuzzleHttp\Client;
                $deleteProject = $http3->request('DELETE', 'https://api.semrush.com/management/v1/projects/' . $projectId . '?key=ebc1d52ac3697a99bd994dc8e46739f4');
                $deleteProjectResponse = json_decode($deleteProject->getBody()->getContents(), true);
            }
            return $this->helpReturn("Keyword Add Successfully.");
        } catch (Exception $e) {
            Log::info('Get Keyword Ranks');
            Log::info($e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }


    public function getSelectedKeyword($request)
    {
        try {
            $businessObj = new BusinessEntity();

            $businessResult = $businessObj->userSelectedBusiness();

            $businessResult = $businessResult['records'];

            $businessId = $businessResult['business_id'];
            $businessWebsite = $businessResult['website'];
            $appendKeywordRankArray = [];
            $localkeyword = [];
            $sort = 'volume';
            $sort = isset($request['sort']) && $request['sort'] == 'volume' ? 'volume' : (isset($request['sort']) && $request['sort'] == 'rank' ? 'rank' : 'volume');

            $localkeyword = LocalKeyword::where('business_id', $businessId)
                ->orderByRaw("$sort IS NULL , $sort DESC")
                ->limit(5)
                ->get()->toArray();


            $appendKeywordRankArray = [];

            if (empty($localkeyword)) {
                return $this->helpError(404, 'No Keyword Found');
            }

            foreach ($localkeyword as $row) {
                $appendKeywordRankArray[] = [
                    'keyword' => $row['keyword'],
                    'rank' => $row['rank_status'] == 'complete' && $row['rank'] == null ? 'Not in Top 100' : ($row['rank_status'] == 'progress' && $row['rank'] == null ? 'Gathering Data' : $row['rank']),
                ];
            }

            $finalArray['keywordsData'] = $localkeyword;
            $finalArray['ranks'] = !empty($businessWebsite) ? $appendKeywordRankArray : 'Website Not Connected';
            return $this->helpReturn("Get Local Keyword Successfully.", $finalArray);

        } catch (Exception $e) {
            Log::info('Get Seleted Keyword ' . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function getSuggestedKeyword($request)
    {

        try {
            $businessObj = new BusinessEntity();

            $businessResult = $businessObj->userSelectedBusiness();

            $businessResult = $businessResult['records'];

            $businessId = $businessResult['business_id'];
            $businessWebsite = $businessResult['website'];

            $array = [];

            if(!isset($request->keyword)){
                return $this->helpError(3, 'No keyword found.');
            }
            $keyword = $request->keyword;

            /**
             * get suggested keyword
             */
            $http = new \GuzzleHttp\Client;
            $response = $http->request('GET', 'https://api.semrush.com', [
                'query' => ['type' => 'phrase_related', 'key' => 'ebc1d52ac3697a99bd994dc8e46739f4', 'display_limit' => 20, 'phrase' => $keyword, 'database' => 'us', 'export_columns' => 'Ph,Nq,Cp,Co,Nr'],
            ]);

            $lines = explode("\n", $response->getBody());

            if (isset($lines[0]) && !empty($lines[0]) && $lines[0] == 'ERROR 50 :: NOTHING FOUND') {
                return $this->helpError(404, 'No keyword suggestions found. Please consider changing your description above. For better suggestions, follow the format in this example: Plumber New York or Personal Trainer New York');
            }
            $linesArray = array();

            //we split each line in a set of elements
            foreach ($lines as $line) {
                $linesArray[] = explode(";", $line);
            }
            $headers = $linesArray[0];
            //and remove it
            unset($linesArray[0]);

            $keywords = [];
            $i = 0;
            foreach ($linesArray as $l => $ln) {
                if ($i <= 19) {
                    $keywords[] = [
                        'keyword' => $ln[0],
                        'tags' => $ln[0],
                        'volume' => $ln[1],
                        'search_engine' => 'google',
                    ];
                }
                $i++;
            }

            if (empty($keywords)) {
                return $this->helpError(404, 'No keyword suggestions found. Please consider changing your description above. For better suggestions, follow the format in this example: Plumber New York or Personal Trainer New York');
            }
            $keys = array_column($keywords, 'volume');
            array_multisort($keys, SORT_DESC, $keywords);

            return $this->helpReturn("Get Suggested Keyword Successfully.", $keywords);
        } catch (Exception $e) {
            Log::info('Get Suggested Keyword');
            Log::info($e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }
    public function getManualKeywordVolume($request)
    {
        try {
            $businessObj = new BusinessEntity();

            $businessResult = $businessObj->userSelectedBusiness();

            $businessResult = $businessResult['records'];

            $businessId = $businessResult['business_id'];
            $businessWebsite = $businessResult['website'];

            $array = [];
            $acceptedkeyword = [];
            $newArray = array();
            $keyword2 = [];

            if(!isset($request->keyword)){
                return $this->helpError(3, 'No keyword found.');
            }
            $keyword = $request->keyword;
            $keywordArray = explode(';',$keyword);

            /**
             * get user manual enter keyword
             */

            $http = new \GuzzleHttp\Client;
            $response = $http->request('GET', 'https://api.semrush.com', [
                'query' => ['type' => 'phrase_these', 'key' => 'ebc1d52ac3697a99bd994dc8e46739f4', 'display_limit' => 20, 'phrase' => $keyword, 'database' => 'us', 'export_columns' => 'Ph,Nq'],
            ]);

            $lines = explode("\n", $response->getBody());

            if (isset($lines[0]) && !empty($lines[0]) && $lines[0] == 'ERROR 50 :: NOTHING FOUND') {
                // return $this->helpError(404, 'No keyword suggestions found. Please consider changing your description above. For better suggestions, follow the format in this example: Plumber New York or Personal Trainer New York');
            }else{
                $linesArray = array();

                //we split each line in a set of elements
                foreach ($lines as $line) {
                    $linesArray[] = explode(";", $line);
                }

                $headers = $linesArray[0];
                //and remove it
                unset($linesArray[0]);

                $keyword = [];
                $i = 0;

                foreach ($linesArray as $l => $ln) {

                    $acceptedkeyword[] = [
                        $ln[0],
                    ];
                    $keyword1[] = [
                        'keyword' => $ln[0],
                        'tags' => $ln[0],
                        'volume' => $ln[1],
                        'search_engine' => 'google',
                    ];
                }

                //change accepted keyword array format
                foreach ($acceptedkeyword as $v){
                    $newArray = array_merge($newArray , array_values($v)) ;
                }
            }

            //get difference new and user enter keyword array
            $one = array_diff($keywordArray,$newArray);

            foreach($one as  $val){
                $keyword2[] = [
                    'keyword' => $val,
                    'tags' => $val,
                    'volume' => 'N/A',
                    'search_engine' => 'google',
                ];
            }
            //merge keyword1 and keyword2 array with null values

            if(!isset($keyword1)){
                $keyword = $keyword2;
            }else{
                $keyword = array_merge($keyword1,$keyword2);
            }


            return $this->helpReturn("Get Manual Keyword Volume Successfully.", $keyword);
        } catch (Exception $e) {
            Log::info('Get User Manual Enter Keyword Volume');
            Log::info($e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function getBroadMatchKeyword($request)
    {

        try {
            $businessObj = new BusinessEntity();

            $businessResult = $businessObj->userSelectedBusiness();

            $businessResult = $businessResult['records'];

            $businessId = $businessResult['business_id'];
            $businessWebsite = $businessResult['website'];
            $array = [];

            if(!isset($request->keyword)){
                return $this->helpError(3, 'No keyword found.');
            }
            $keyword = $request->keyword;

            /**
             * get suggested keyword
             */
            $http = new \GuzzleHttp\Client;
            $response = $http->request('GET', 'https://api.semrush.com', [
                'query' => ['type' => 'phrase_fullsearch', 'key' => 'ebc1d52ac3697a99bd994dc8e46739f4', 'display_limit' => 20, 'phrase' => $keyword, 'database' => 'us', 'export_columns' => 'Ph,Nq,Cp,Co,Nr'],
            ]);

            $lines = explode("\n", $response->getBody());

            if (isset($lines[0]) && !empty($lines[0]) && $lines[0] == 'ERROR 50 :: NOTHING FOUND') {
                return $this->helpError(404, 'No broad match keywords found. Please consider changing your description above. For better suggestions, follow the format in this example: Plumber New York or Personal Trainer New York');
            }
            $linesArray = array();

            //we split each line in a set of elements
            foreach ($lines as $line) {
                $linesArray[] = explode(";", $line);
            }
            $headers = $linesArray[0];
            //and remove it
            unset($linesArray[0]);

            $keywords = [];
            $i = 0;
            foreach ($linesArray as $l => $ln) {
                if ($i <= 19) {
                    $keywords[] = [
                        'keyword' => $ln[0],
                        'tags' => $ln[0],
                        'volume' => $ln[1],
                        'search_engine' => 'google',
                    ];
                }
                $i++;
            }

            if (empty($keywords)) {
                return $this->helpError(404, 'No broad match keywords found. Please consider changing your description above. For better suggestions, follow the format in this example: Plumber New York or Personal Trainer New York');
            }
            $keys = array_column($keywords, 'volume');
            array_multisort($keys, SORT_DESC, $keywords);

            return $this->helpReturn("Get Broad Match Keywords Successfully.", $keywords);
        } catch (Exception $e) {
            Log::info('Get Broad Match Keyword');
            Log::info($e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function getKeywordVolume($request)
    {

        try {
            $authObj = new AuthEntity();
            $businessObj = new BusinessEntity();

            if (isset($request->token)) {
                $checkPoint = $this->setCurrentUser($request->token)->userAllow();
            } else {
                $userResult = $authObj->retrieveUserInfo($request);

                $responseCode = $userResult['_metadata']['outcomeCode'];

                // Email is required.
                if ($responseCode == 1) {
                    return $this->helpError(36, 'Enter email to go next.');
                } elseif ($responseCode == 404) {
                    return $this->helpError(36, 'You\'re not authorized to do this action. Please enter your email to use this feature.');
                }
                $user = $userResult['records'];
                $token = JWTAuth::fromUser($user);

                $checkPoint = $this->setCurrentUser($token)->guestUserAllow();
            }

            // user is not found.
            if ($checkPoint['_metadata']['outcomeCode'] != 200) {
                return $checkPoint;
            }
            $user = $checkPoint['records'];
            $array = [];

            $businessResult = $businessObj->userSelectedBusiness($user);
            $businessResult = $businessResult['records'];

            if(!isset($request->keyword)){
                return $this->helpError(3, 'No keyword found.');
            }
            $keyword = $request->keyword;

            /**
             * get suggested keyword
             */
            $http = new \GuzzleHttp\Client;
            $response = $http->request('GET', 'https://api.semrush.com', [
                'query' => ['type' => 'phrase_all', 'key' => 'ebc1d52ac3697a99bd994dc8e46739f4', 'phrase' => $keyword, 'database' => 'us', 'export_columns' => 'Ph,Nq'],
            ]);

            $lines = explode("\n", $response->getBody());

            if (isset($lines[0]) && !empty($lines[0]) && $lines[0] == 'ERROR 50 :: NOTHING FOUND') {
                return $this->helpError(404, 'No search volume was found. Try again with the different keyword');
            }
            $linesArray = array();

            //we split each line in a set of elements
            foreach ($lines as $line)
            {
                $linesArray[] = explode(";", $line);
            }
            unset($linesArray[0]);

            $result['Keyword']=$linesArray[1]['0'];
            $result['Search Volume']=$linesArray[1]['1'];

            if (empty($linesArray)) {
                return $this->helpError(404, 'No search volume was found. Try again with the different keyword');
            }

            return $this->helpReturn("Get Search Volume Successfully.", $result);
        } catch (Exception $e) {
            Log::info('Get Keyword Volume');
            Log::info($e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function checkKeywordMatchedWithBusiness($request)
    {

        try {
            $authObj = new AuthEntity();
            $businessObj = new BusinessEntity();

            if (isset($request->token)) {
                $checkPoint = $this->setCurrentUser($request->token)->userAllow();
            } else {
                $userResult = $authObj->retrieveUserInfo($request);

                $responseCode = $userResult['_metadata']['outcomeCode'];

                // Email is required.
                if ($responseCode == 1) {
                    return $this->helpError(36, 'Enter email to go next.');
                } elseif ($responseCode == 404) {
                    return $this->helpError(36, 'You\'re not authorized to do this action. Please enter your email to use this feature.');
                }
                $user = $userResult['records'];
                $token = JWTAuth::fromUser($user);

                $checkPoint = $this->setCurrentUser($token)->guestUserAllow();
            }

            // user is not found.
            if ($checkPoint['_metadata']['outcomeCode'] != 200) {
                return $checkPoint;
            }
            $user = $checkPoint['records'];
            $array = [];

            $businessResult = $businessObj->userSelectedBusiness($user);
            $businessResult = $businessResult['records'];
            $businessId = $businessResult->business_id;
            $businessName = $businessResult->name;
            $originalBusinessName = $businessName;

            $localkeyword = [];
            $sort = 'volume';
            $sort = isset($request['sort']) && $request['sort'] == 'volume' ? 'volume' : (isset($request['sort']) && $request['sort'] == 'rank' ? 'rank' : 'volume');

            $localkeyword = LocalKeyword::where('business_id', '=', $businessId)
                ->orderByRaw("$sort IS NULL , $sort DESC")
                ->limit(5)
                ->get()->toArray();


            if (empty($localkeyword)) {
                return $this->helpError(404, 'No Keyword Found');
            }

            if(isset($localkeyword[0])){
                $keyword =  $localkeyword[0]['keyword'];
            }
            $request->request->add(['keyword' => $keyword,'email' => $request->email,'token' => $request->token]);
            $response = $this->googleplaceEntity->getMapCoordinates($request);


            $status = 'false';
            $finalResponse = [];
            if ($response['_metadata']['outcomeCode'] == 200) {
                $record = $response['records'];
                $business = $record['business'];

                if(!empty($business)) {
                    $i = 1;
                    foreach ($business as $row) {
                        if($i== 1){
                            $firstName = $row['name'];
                        }

                        if ($i < 4) {
                            $compare = stringComparisonScore($businessName,$row['name']);
                            Log::info('check compare value in percentage');
                            Log::info($compare);
                            if ($compare >= '90') {
                                Log::info('inside');
                                $status = 'true';
                                break;
                            }
                        }

                        $i++;
                    }
                    $finalResponse = ['status' => $status,  'business_name' => $originalBusinessName,'top_competitor'=> $firstName];
                }else{
                    $finalResponse = ['status' => $status,  'business_name' => $originalBusinessName];
                }
            }
            Log::info('final response');
            Log::info($finalResponse);
            return $this->helpReturn("Get Keyword Match with Business Successfully.",$finalResponse);
        } catch (Exception $e) {
            Log::info('checkKeywordMatchedWithBusiness');
            Log::info($e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function testAudit($request)
    {

       // try {
            $authObj = new AuthEntity();
            $businessObj = new BusinessEntity();

            if (isset($request->token)) {
                $checkPoint = $this->setCurrentUser($request->token)->userAllow();
            } else {
                $userResult = $authObj->retrieveUserInfo($request);

                $responseCode = $userResult['_metadata']['outcomeCode'];

                // Email is required.
                if ($responseCode == 1) {
                    return $this->helpError(36, 'Enter email to go next.');
                } elseif ($responseCode == 404) {
                    return $this->helpError(36, 'You\'re not authorized to do this action. Please enter your email to use this feature.');
                }
                $user = $userResult['records'];
                $token = JWTAuth::fromUser($user);

                $checkPoint = $this->setCurrentUser($token)->guestUserAllow();
            }

            // user is not found.
            if ($checkPoint['_metadata']['outcomeCode'] != 200) {
                return $checkPoint;
            }
            $user = $checkPoint['records'];
            $array = [];

            $businessResult = $businessObj->userSelectedBusiness($user);
            $businessResult = $businessResult['records'];
            $businessId = $businessResult->business_id;
            $businessName = $businessResult->name;
            $originalBusinessName = $businessName;
            $businessWebsite = $businessResult->website;
            $filterBusinessName = preg_replace("/[^a-zA-Z]/", "", $businessName);

            $http = new \GuzzleHttp\Client;
            $projectId ='2928986';
//            $body = ['domain' => $businessWebsite, 'scheduleDay' => 1,'notify'=>false,'pageLimit'=>1000,'userAgentType'=>2,'crawlSubdomains'=>true,'respectCrawlDelay'=>false];
//            $response = $http->request('POST', 'https://api.semrush.com/management/v1/projects/' . $projectId . '/siteaudit/enable?key=ebc1d52ac3697a99bd994dc8e46739f4',
//                [
//                        'json' => $body,
//                        'headers' => [
//                            'Content-Type' => 'application/json'
//                        ]
//                ]
//            );



          //  $finalJsonResponse = json_decode($response->getBody()->getContents(), true);

            $response = $http->request('GET', 'https://api.semrush.com/reports/v1/projects/' . $projectId . '/siteaudit/info',
                [
                    'query' =>
                        [
                            'key' => 'ebc1d52ac3697a99bd994dc8e46739f4',
                        ]
                ]
            );

            $finalJsonResponse = json_decode($response->getBody()->getContents(), true);
            /**
             * First Create Project
             * param project_name and url
             */
            $projectid = '2928986';
//            try {
//                $headers['Content-Type'] = 'application/json';
//                $body = ['project_name' => $filterBusinessName, 'url' => $businessWebsite];
//                $projectResponse = $http->request('POST', 'https://api.semrush.com/management/v1/projects?key=ebc1d52ac3697a99bd994dc8e46739f4',
//                    [
//                        'json' => $body,
//                        'headers' => [
//                            'Content-Type' => 'application/json'
//                        ]
//                    ]
//                );
//                $projectResponseData = json_decode($projectResponse->getBody()->getContents(), true);
//                $projectId = $projectResponseData['project_id'];
//                dd($projectId);
//            } catch (Exception $e) {
//                Log::info('Project Not Create Due To Exception');
//                Log::info('Create Project Sectiton');
//                Log::info($e->getMessage());
//            }

            return $this->helpReturn("Get Audit Successfully.",$finalJsonResponse);
//        } catch (Exception $e) {
//            Log::info('checkKeywordMatchedWithBusiness');
//            Log::info($e->getMessage());
//            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
//        }
    }

}
