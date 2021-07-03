<?php

namespace Modules\Business\Entities;

use App\Entities\AbstractEntity;
use App\Services\SessionService;
use App\Traits\UserAccess;
use App\User;
use DB;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use File;
use Log;
use Mail;
use Config;
use Modules\Admin\Models\MarketingAssociation;
use Modules\Business\Models\Business;
use Modules\Business\Models\Countries;
use Modules\Business\Models\Industry;
use Modules\Business\Models\Niches;
use Modules\Business\Models\SendgridEventLogs;
use Modules\Business\Models\SocialProfile;
use Modules\Business\Models\UserBusinessCitationList;
use Modules\Business\Models\UserOnboard;
use Modules\GoogleAnalytics\Entities\GoogleAnalyticsEntity;
use Modules\ThirdParty\Entities\FacebookEntity;
use Modules\ThirdParty\Entities\GooglePlaceEntity;
use Modules\ThirdParty\Entities\SocialEntity;
use Modules\ThirdParty\Entities\ThirdPartyEntity;
use Modules\ThirdParty\Models\SocialMediaMaster;
use Modules\ThirdParty\Models\TripadvisorMaster;
use Modules\User\Models\UserRolesREF;
use Modules\ThirdParty\Entities\YelpEntity;
use Redirect;
/**
 * Class AuthEntity
 * @package Modules\Auth\Entities
 */
class BusinessEntity extends AbstractEntity
{
    use UserAccess;

    protected $loginValidator;

    protected $googlePlaces;

    protected $facebook;

    protected $yelp;

    protected $sessionService;

    protected $socialEntity;

    protected $thirdPartyEntity;

    public function __construct()
    {
        $this->googlePlaces = new GooglePlaceEntity();
        $this->facebook = new FacebookEntity();
        $this->yelp = new YelpEntity();
        $this->socialEntity = new SocialEntity();
        $this->thirdPartyEntity = new ThirdPartyEntity();
        $this->sessionService = new SessionService();
    }

    public function userSelectedBusiness($full = '', $userId = '')
    {
//        $userBusiness = Business::where('user_id', 7)->first();
//        return $this->helpReturn("Business Result.", $userBusiness->toArray());
        try {
            if(empty($userId))
            {
                $userData = $this->sessionService->getAuthUserSession();
                $userId = $userData['id'];
//                log::info($userData);
            }
            else
            {
                $userData = $userId;
//                log::info('1');
//                log::info($userData);
            }

            if(!empty($userData)) {
                if($full == '')
                {
                    $userBusiness = Business::
                    with([
                        'niche' => function ($q) {
                            $q->with('industry');
                        }
                    ])->where('user_id', $userId)->first();
                }
                else
                {


                    $userBusiness = Business::with('country')->with([
                        'niche' => function ($q) {
                            $q->with('industry');
                        }
                    ])->where('user_id', $userId)->first();

                }
            }

            if (!empty($userBusiness)) {
                $userBusiness = $userBusiness->toArray();
                return $this->helpReturn("Business Result.", $userBusiness);
            } else {
                return $this->helpError(404, ' No Business found in our system.');
            }
        } catch (Exception $exception) {
            Log::info(" userSelectedBusiness > " . $exception->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function businessProfileUpdate($request)
    {
        try
        {
            $businessResult = $this->userSelectedBusiness();

            if($businessResult['_metadata']['outcomeCode'] != 200)
            {
                return $businessResult;
            }

            $businessResult = $businessResult['records'];
            $businessId = $businessResult['business_id'];
            log::info('bpu');
            log::info($businessId);


            $data = $request->except('send', 'attach_logo', 'attach_avatar');
//            log::info('$data');
//            log::info($data);
//            log::info('$data');
//            log::info($request->hasFile('attach_logo'));
            if ($request->hasFile('attach_avatar')) {
                $attachedFile = $request->attach_avatar;
                $i = 0;

                foreach ($attachedFile as $file) {

                    $file = $attachedFile[$i];
                    $extension = $file->getClientOriginalExtension();

                    $file_size = $file->getSize();
                    $file_size = number_format($file_size / 1048576, 2);

                    $avatarName = 'avatar' . time() . '.' . $extension;

                    Storage::disk('local')->put($avatarName, File::get($file));

                    $url = Storage::url($avatarName);
                }

                if(!empty($avatarName))
                {
                    $data['avatar'] = $avatarName;
                }
            }

            if ($request->hasFile('attach_logo')) {
                log::info( 'working on logo');

                $attachedFile = $request->attach_logo;
                $i = 0;

                foreach ($attachedFile as $file) {
                    $file = $attachedFile[$i];
                    $extension = $file->getClientOriginalExtension();

                    $file_size = $file->getSize();
                    $file_size = number_format($file_size / 1048576, 2);

                    $logoName = 'logo' . time() . '.' . $extension;

                    Storage::disk('local')->put($logoName, File::get($file));

                    $logoUrl = Storage::url($logoName);
                }

                if(!empty($logoName))
                {
                    $data['logo'] = $logoName;
                }
            }

            $isWebsiteChanged = false;

            $existingWebsite = $businessResult['website'];



            if(!empty($data['website']))
            {
                $website = cleanReferUrl($data['website']);
                log::info('business inside');

                if(cleanReferUrl($existingWebsite) != $website)
                {
                    // change detected.
                    log::info('change inside');
                    $isWebsiteChanged = true;
                }

                $data['website'] = $website;
            }

            Business::where('business_id', $businessId)
                ->update($data);

            $businessData = Business::where('business_id', $businessId)->get()->toArray();

            $businessData[0]['isWebsiteChanged'] = $isWebsiteChanged;

            if($isWebsiteChanged == true)
            {
//                log::info('removing analytics');
                $businessData[0]['websiteChecker'] = getUrlDomain($website);
//                log::info('$abc');
//                log::info($abc);
            }
            if ($request->has('website')) {
//                log::info('website');
                $website = cleanReferUrl($data['website']);
//                log::info('incoming website '.$website);
//                log::info('existing website '.$existingWebsite);
                if(cleanReferUrl($existingWebsite) != $website) {
//                    log::info('in delete process');
                    $removeGoogleAnalyticsAccount = new GoogleAnalyticsEntity();
                    $removeGoogleAnalyticsAccount->removeGoogleAnalytics($businessId);
                }
            }

//            return $this->helpReturn('Business profile updated.', $businessData);
            return $this->helpReturn('Profile Being Updated.', $businessData);
        }
        catch(Exception $e)
        {
            Log::info("businessProfileUpdate -> " . $e->getMessage() . ' > ' . $e->getLine() . ' > ' . $e->getCode());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function socialProfileUpdate($request)
    {
        try
        {
            $businessResult = $this->userSelectedBusiness();

            if($businessResult['_metadata']['outcomeCode'] != 200)
            {
                return $businessResult;
            }

            $businessResult = $businessResult['records'];
            $businessId = $businessResult['business_id'];

            $data = $request->except('send');

            SocialProfile::updateorCreate(
                ['business_id' => $businessId],
                $data
            );

            return $this->helpReturn('Social profile updated.');
        }
        catch(Exception $e)
        {
            Log::info("businessProfileUpdate -> " . $e->getMessage() . ' > ' . $e->getLine() . ' > ' . $e->getCode());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function registerBusiness($request)
    {
        $data = $request->all();

        if(!empty($data['website']))
        {
            $data['website'] = cleanReferUrl($data['website']);
        }
        if(!empty($data['postal_code']))
        {
            $data['zip_code'] = $data['postal_code'];
            unset($data['postal_code']);
        }
        if(!empty($data['country']))
        {
            $country = $data['country'];
            $country = Countries::where('name', $data['country'])
                ->orWhere('iso3', $country)
                ->orWhere('iso2', $country)
                ->first();

            if(!empty($country))
            {
                $data['country_id'] = $country->id;
            }
//            unset($data['country']);
        }

        $result = Business::create($data);

        if(!empty($result['business_id']))
        {
            return $this->helpReturn('Business Registered', $result);
        }

        return $this->helpError(1, 'An unknown error has occurred. Please try again.');

//        try
//        {
//
//        }
//        catch(Exception $e)
//        {
//            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
//        }
    }

    public function completeBusinessProcess(Request $request)
    {

    }

    public function sendgridWebHookLogs($request)
    {
        try{
            $data = $request->except('fromTransfer');

            foreach ($data as $row) {
//                Log::info("row");
//                Log::info($row);

                $category = '';

                if(!empty($row['category']))
                {
                    if(is_array($row['category']))
                    {
                        $category = $row['category'][0];
                    }
                    else
                    {
                        $category = $row['category'];
                    }
                }

                $tiedUpWith = '';
                if(!empty($row['tied_up_with']))
                {
                    $tiedUpWith = $row['tied_up_with'];
                }

//                if((!(isset($row['singlesend_id'])) || (!empty($category))))
//                {
//                    Log::info("missing singlesend or category ");
//                    return false;
//                }

                Log::info("missing Check crossed");

                $eventTargetId = getIndexedvalue($row, 'singlesend_id', '');
                $eventSourceName = getIndexedvalue($row, 'singlesend_name', '');

                $eventSource = '';

                if(isset($row['singlesend_id']))
                {
                    $eventSource = 'singlesend';
                }

                SendgridEventLogs::create([
                    'event' => getIndexedvalue($row, 'event', ''),
                    'email' => getIndexedvalue($row, 'email', ''),
                    'sg_event_id' => getIndexedvalue($row, 'sg_event_id', ''),

                    'event_target_id' => $eventTargetId,
                    'event_source_name' => $eventSourceName,
                    'event_source' => $eventSource,

                    'sg_message_id' => getIndexedvalue($row, 'sg_message_id', ''),
                    'sg_template_id' => getIndexedvalue($row, 'sg_template_id', ''),
                    'category' => $category,
                    'response_meta' => json_encode($row),
                    'tied_up_with' => $tiedUpWith,

                    'timestamp' => getIndexedvalue($row, 'timestamp', '')
                ]);
            }
        }
        catch(Exception $e)
        {
            Log::info("BusinessEntity > sendgridWebHookLogs >> " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function collectBusinessData($request)
    {
        Log::info("saa");
        $userData = $this->sessionService->getAuthUserSession();

        if(!empty($userData))
        {
            $businessData = Business::where('user_id', $userData['id'])->first();

            if(!empty($businessData))
            {
                $requestAppend = [
                    'userID' => $userData['id'],
                    'business_id' => $businessData['business_id'],
                    'name' => $businessData['practice_name'],
                    'businessKeyword' => $businessData['practice_name'],
                    'business_address' => $businessData['address'],
                    'phone' => $businessData['phone'],
                ];
                $request->merge($requestAppend);

                $result = $this->thirdPartyConnect($request);

                if($result['_metadata']['outcomeCode'] == 200)
                {
                    $businessData->update(
                        [
                            'discovery_status' => 5
                        ]
                    );

                    // change status in db.
                    Log::info("done ");
                    return $this->helpReturn('Business Registered');
                }
            }
        }

        return $this->helpError(1, 'An unknown error has occurred. Please try again.');
    }

    public function thirdPartyConnect($request)
    {
        try {
            Log::info("Ready");

            $type = !empty($request->type) ? $request->type : 'all';

            if(empty($request->get('business_id')) || empty($request->get('userID')))
            {
                $businessResult = $this->userSelectedBusiness();

                if ($businessResult['_metadata']['outcomeCode'] != 200) {
                    return $this->helpError(1, 'Problem in selection of your business.');
                }
                $businessResult = $businessResult['records'];
                $requestAppended = [
                    'business_id' => $businessResult['business_id'],
                    'userID' => $businessResult['user_id'],
                ];
                $request->merge($requestAppended);
            }

            $response = '';
            $type = strtolower($type);

            if ($type == 'googleplaces' || $type == 'all') {
                $response = $this->googlePlaces->updateGooglePlacesMaster($request);
            }

            if ($type == 'yelp' || $type == 'all') {
                $response = $this->yelp->updateYelpMaster($request);
            }

            if ($type == 'facebook' || $type == 'all') {
                $response = $this->facebook->updateThirdPartyMaster($request);
            }

            if($type == 'zocdoc' || $type == 'healthgrades' || $type == 'ratemd') {
//                dd("ye");
                $response = $this->thirdPartyEntity->updateThirdPartyApp($request);
            }
//            dd("out");

//            return $response;

            if($type == 'all')
            {
                return $this->helpReturn('Process completed');
            }

            return $response;
        }
        catch(Exception $e)
        {
            Log::info("BusinessEntity > thirdPartyConnect >> " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }


    public function businessDirectoryList($request, $businessInfo = '', $requestedUser = 'user')
    {
        try {

            $businessResult = $this->userSelectedBusiness();

            if ($businessResult['_metadata']['outcomeCode'] != 200) {
                return $this->helpError(1, 'Problem in selection of your business.');
            }

            $userBusiness = $businessResult['records'];
            $businessId = $userBusiness['business_id'];

            $thirdObj = new TripadvisorMaster();
            $socialMasterObj = new SocialMediaMaster();

            $requestAppended = [
                'business_id' => $businessId,
            ];
            $request->merge($requestAppended);

            if ($requestedUser != 'guest')  {
                $this->socialEntity->socialModuleUpdate($request);
            }

            // get business issues
            $businessIssues = $thirdObj->businessApiResponse($businessId);

//            print_r($businessIssues);
//            exit;

            $SocialApiIssues = $socialMasterObj->SocialApiResponse($businessId, 'Facebook');

//            print_r($SocialApiIssues);
//            exit;
            if ($SocialApiIssues) {
                $businessIssues = array_merge($businessIssues->toArray(), $SocialApiIssues->toArray());
            }

//                        print_r($userBusiness);
//            exit;
            $businessIssues = json_decode(json_encode($businessIssues), true);

            $businessRecord['userBusiness'] = $userBusiness;
            $businessIssues = $this->businessIssuesSorting($businessIssues, 'directory');

//            print_r($businessIssues);
//            exit;
            $data = [];
            foreach ($businessIssues as $issueData) {
                $data[] = $issueData;
            }
            $businessRecord['businessIssues'] = $data;
            return $this->helpReturn("Business Result.", $businessRecord);
        } catch (Exception $exception) {
            Log::info(" businessDirectoryList > " . $exception->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    /**
     * @param $businessIssues
     * @param string $module (all, directory)
     * @return array
     */
    public function businessIssuesSorting($businessIssues, $module = 'all')
    {
        try {
            $issueData = [];

            $i = 0;
            $totalIssues = 0;
            $moduleSites = moduleSiteList();

            foreach ($businessIssues as $index => $businessIssue) {
//                Log::info("index " . $index);
//                Log::info("businessIssue");
//                Log::info($businessIssue);
                $issuesFound = 0;

                $currentCounterType = str_replace(' ', '', strtolower($businessIssue['type']));

                $name = $businessIssue['name'];
                $issueId = $businessIssue['issue_id'];
                $type = $businessIssue['type'];

                if ($module == 'all') {
                    /**
                     * 1)
                     * module sites deleted if this matched from
                     * business issue type
                     * like if tripadvisor == tripadvisor delete it
                     * so which module not matched with any issue type that will be left
                     * so we handle that unmatched module later in this code.
                     */
                    foreach ($moduleSites as $key => $site) {
                        $currentSite = str_replace(' ', '', strtolower($site));
                        if ($currentCounterType == $currentSite) {
                            unset($moduleSites[$key]);
                            break;
                        }
                    }
                }

                if ($name == '' && $issueId == '') {
//                    Log::info("empty");
//                    Log::info($businessIssue);
                    // not setup
                    if ($module == 'all') {
                        $issueData[$i]['type'] = $type;
                        $issueData[$i]['message'] = 'Not Setup';
                    } else {
                        $issueData[$i] = $businessIssue;
                        $issueData[$i]['issueList'] = [];
                    }
                }
                else {
//                    Log::info("Not empty");
//                    Log::info($businessIssue);
                    $matched = false;

//                    Log::info("issueData");
//                    Log::info($issueData);

                    if (!empty($issueData)) {
                        foreach ($issueData as $issueIndex => $issueRecord) {
                            $currentIssueType = str_replace(' ', '', strtolower($issueRecord['type']));
                            if ($currentCounterType == $currentIssueType) {
                                $matched = true;
                                $issuesFound = ( !empty($issueData[$issueIndex]['issuesFound']) ) ? $issueData[$issueIndex]['issuesFound'] : 0;
                                $issuesFound++;
                                $totalIssues++;
                                $issueData[$issueIndex]['issueList'][] = $businessIssue['title'];
                                $issueData[$issueIndex]['issuesFound'] = $issuesFound;
                                break;
                            }
                        }
                    }

                    if ($matched == '') {
                        if ($module == 'all') {
                            $issueData[$i]['type'] = $businessIssue['type'];
                        } else {
                            $issueData[$i] = $businessIssue;
                        }

                        if ($businessIssue['issue_id'] != '') {
                            $issueData[$i]['issueList'][] = $businessIssue['title'];
                            $issuesFound++;
                            $totalIssues++;
                        } else {
                            $issueData[$i]['issueList'] = [];
                        }

                        $issueData[$i]['issuesFound'] = $issuesFound;
                    }
                }

                $i++;
            }

            if ($module == 'all') {
                /**
                 * 2)
                 * which module is left from Procedure-1
                 * we'll handling this here
                 * so we can tell this page is not setup yet.
                 */
                foreach ($moduleSites as $site) {
                    $issueData[$i]['type'] = $site;
                    $issueData[$i]['message'] = 'Not Setup';
                    $i++;
                }

                $issueData['totalIssues'] = $totalIssues;
            }

            return $issueData;
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
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

    public function saveCitation($request)
    {
        try
        {
            $userData = $this->sessionService->getAuthUserSession();
            $userId = $userData['id'];
            $citationId = $request->get('id');
            $citationState = $request->get('state');

//            $citationRec = UserBusinessCitationList::where(['user_id' => $userId, 'citation_app_id' => $citationId])->get()->toArray();

            if(!empty($citationState))
            {
                UserBusinessCitationList::create(
                    [
                        'user_id' => $userId,
                        'citation_app_id' => $citationId,
                    ]
                );
            }
            else
            {
                UserBusinessCitationList::where(['user_id' => $userId, 'citation_app_id' => $citationId])->delete();
            }

            return $this->helpReturn('Status updated');
        }
        catch(Exception $e)
        {
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }



    public function donemeonboard($request)
    {
        try
        {
            $userData = $this->sessionService->getAuthUserSession();
            $userId = $userData['id'];


            Log::info("steps items");
            Log::info($request->id);

            if(!empty($request->id))
            {
                foreach ($request->id as $id) {
                    UserOnboard::create(
                        [
                            'user_id' => $userId,
                            'onboard_id' => $id,
                        ]
                    );
                }

            }

            return $this->helpReturn('Status updated');
        }
        catch(Exception $e)
        {
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function saveNotification(Request $request){
        try {
            $userData = $this->sessionService->getAuthUserSession();

            $businessData = Business::where('user_id', $userData['id'])->first();

            $detailsNotification = array(
                'notification_email' => $request->get('notificationEmail'),
                'notification_switch' => $request->get('notificationSwitch')
            );
            log::info('here 1');
            log::info('here 1');
            if(!empty($businessData) ){
                log::info('here 2');
                Business::where('user_id', $userData['id'])->update($detailsNotification);
            }
            return $this->helpReturn('Email notification setting updated');
        }
        catch(Exception $e)
        {
            return $this->helpError(404, 'An unknown error has occurred. Please try again.' );
        }
    }

    public function associationListWithCampaigns()
    {
        $userData = $this->sessionService->getAuthUserSession();
        $businessResult = $this->userSelectedBusiness();
        $niche =  $businessResult['records']['niche']['id'];
        $industry =  $businessResult['records']['niche']['industry']['id'];
//        log::info('$niche');
//        log::info($niche);
//        log::info('$industry');
//        log::info($industry);
//
        $data = MarketingAssociation::with(
//            [
//                'campaigns' => function ($q) use ($niche, $industry) {
//                    $q->where('industry',$industry);
//                    $q->where(function($q) use ($niche){
//                        $q->where('niche', 0);
//                        $q->orWhere('niche', $niche);
//                    });
//                }
//            ]
            [
                'hasManyCampaigns' => function ($q) use ($niche, $industry) {
                    $q->where('industry',$industry);
                    $q->where(function($q) use ($niche){
                        $q->where('niche', 0);
                        $q->orWhere('niche', $niche);
                    });
                }
            ]
        )->where('status', '=', 1)->get()->toArray();

//        log::info('data');
//        log::info($data);
//        $data = MarketingAssociation::with('campaigns')->get()->toArray();
        $this->data['association'] = '';

        if(!empty($data)){
            $this->data['association'] = $data;
        }
        return $this->helpReturn('Marketing Association List With Campaigns.', $this->data);
    }
}
