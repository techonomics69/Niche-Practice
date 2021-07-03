<?php

namespace Modules\Admin\Entities;

use App\Entities\AbstractEntity;
use App\Http\Controllers\JobController;
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
use Modules\Business\Entities\BusinessEntity;
use Modules\Business\Models\Business;
use Modules\Business\Models\CampaignUsersTrack;
use Modules\Business\Models\EmailTemplate;
use Modules\Business\Models\EmailTemplatePlan;
use Modules\Business\Models\Industry;
use Modules\Business\Models\Niches;
use Modules\Business\Models\PromotionTemplate;
use Modules\Business\Models\PromotionTemplatePlan;
use Modules\Business\Models\SocialProfile;
use Modules\CRM\Models\Recipient;
use Modules\ThirdParty\Entities\FacebookEntity;
use Modules\ThirdParty\Entities\GooglePlaceEntity;
use Modules\ThirdParty\Entities\SocialEntity;
use Modules\ThirdParty\Entities\ThirdPartyEntity;
use Modules\ThirdParty\Models\SocialMediaMaster;
use Modules\ThirdParty\Models\TripadvisorMaster;
use Modules\User\Models\UserRolesREF;
use Modules\ThirdParty\Entities\YelpEntity;
use Modules\User\Models\Users;
use Redirect;
/**
 * Class AuthEntity
 * @package Modules\Auth\Entities
 */
class AdminPromotionEntity extends AbstractEntity
{
    use UserAccess;

    protected $loginValidator;

    protected $googlePlaces;

    protected $facebook;

    protected $yelp;

    protected $sessionService;

    protected $socialEntity;

    protected $thirdPartyEntity;

    protected $businessEntity;

    public function __construct()
    {
        $this->googlePlaces = new GooglePlaceEntity();
        $this->businessEntity = new BusinessEntity();
        $this->facebook = new FacebookEntity();
        $this->yelp = new YelpEntity();
        $this->thirdPartyEntity = new ThirdPartyEntity();
        $this->socialEntity = new SocialEntity();

        $this->sessionService = new SessionService();
    }

    public function saveTemplate($request)
    {

        Log::info('$request');
//        Log::info($request);
        try {
            $userData = $this->sessionService->getAdminUserSession();
            $userId = $userData['id'];

            $data = $request->except('send', 'id', 'attach_logo', 'type', 'plan');
            $data['user_id'] = $userId;
            log::info('$data');
//            log::info($data);
            $templateId = $request->get('id');

            if($request->get('response'))
            {
                if($request->has('type') && $request->get('type') == 'import')
                {
                    $data['response'] = $request->get('response');
                }
                else
                {
                    $data['response'] = json_encode($request->get('response'));
                }
            }

            if ($request->hasFile('attach_logo')) {
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
                    $data['thumbnail'] = $logoName;
                }
            }

            $templateData = PromotionTemplate::where('id', $templateId)->first();

            if(empty($templateData))
            {
                $response = PromotionTemplate::create($data);

                $request->merge(['id' => $response['id']]);
                $this->updateTemplatePlans($request);

                return $this->helpReturn("Template is Saved.", $response);
            }
            elseif(!empty($templateData))
            {
                $this->updateTemplatePlans($request);
//                log::info($data);
//                exit();
                $response = $templateData->update($data);

                return $this->helpReturn("Template is updated.");
            }

            return $this->helpError(3, 'An unknown error has occurred. Please try again.');
        }
        catch(Exception $e)
        {
            Log::info("saveTemplate > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function updateTemplatePlans($request)
    {
        try{
            $userData = $this->sessionService->getAdminUserSession();
            $userId = $userData['id'];

            $plans = $request->get('plan');
            $template = $request->get('id');

//            Log::info("template > $template" );

            if(empty($plans))
            {
                PromotionTemplatePlan::where('template_id', $template)->delete();

                return $this->helpReturn("Plans deleted.");
            }

            $keywordsData = $plans;

            $code = 4;

            $storedPlansData = PromotionTemplatePlan::where('template_id', $template)
                ->get();

            if(empty($storedPlansData->toArray()) && !empty($plans))
            {
                foreach($plans as $keyword)
                {
                    Log::info("create " . $keyword);
                    PromotionTemplatePlan::create(
                        [
                            'template_id' => $template,
                            'user_id' => $userId,
                            'plan' => $keyword
                        ]
                    );
                }

                return $this->helpReturn("Plan saved");
            }
            elseif(!empty($storedPlansData->toArray()))
            {
                $storedPlans = [];

                foreach($storedPlansData as $keyword)
                {
                    $storedPlans[] = $keyword['plan'];
                }

                if( !empty($plans) )
                {
                    $userPlans = $plans;
                }

                // array_diff
                // Returns an array containing all the entries from $userPlans that are not present in any of the $storedPlans array.
                $keywordsManager = array_diff($userPlans, $storedPlans);
                $removePlans = array_diff($storedPlans, $userPlans);

                if(!empty($keywordsManager)) {
                    foreach($keywordsManager as $keyword) {
                        Log::info("create2 " . $keyword);
                        PromotionTemplatePlan::create(
                            [
                                'template_id' => $template,
                                'user_id' => $userId,
                                'plan' => $keyword
                            ]
                        );
                    }
                    $code = 200;
                }

                if(!empty($removePlans))
                {
                    foreach($removePlans as $removalElement)
                    {
                        Log::info("dele " . $removalElement);
                        PromotionTemplatePlan::where(
                            [
                                'user_id' => $userId,
                                'template_id' => $template,
                                'plan' => $removalElement
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

    public function getTemplate()
    {
        try {
            $request = request();
            $promotionUrl = $request->segment(3);
//            print_r($ab);
//            exit();
            $guestUser = Users::where('email', 'guest@nichepractice.com')->first();
            if($promotionUrl == 'guest-promotion-list') {
                $response = PromotionTemplate::with('templatePlans')->with('industry')->with('niche')
                    ->where('user_id', $guestUser['id'])->where('is_deleted', 0)->get()->toArray();
            }
            else {
                $userData = $this->sessionService->getAdminUserSession();

                $response = PromotionTemplate::with('templatePlans')->with('industry')->with('niche')
                    ->where('user_id', $userData['id'])->where('is_deleted', 0)->get()->toArray();
            }

            return $this->helpReturn("Result.", $response);

        } catch (Exception $e) {
            Log::info("getTemplate > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function userTemplateList()
    {
        try {
            $userData = $this->sessionService->getAdminUserSession();

            $response = EmailTemplate::where('user_id', $userData['id'])->get()->toArray();

            return $this->helpReturn("Result.", $response);
        } Catch (Exception $e) {
            Log::info("userTemplateList > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function getThisPromotion($request)
    {
        try {
            $response = PromotionTemplate::with('templatePlans')->find($request->id);

            Log::info("re");
//            Log::info($response);

            return $this->helpReturn("Result.", $response);
        } catch (Exception $e) {
            Log::info("getTemplate > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function deleteThisTemplate($request)
    {
        try {
            $response = PromotionTemplate::find($request->id);

            if(!empty($response)) {
                $response->update([
                    'is_deleted' => 1,
                ]);
            }

            return $this->helpReturn("Promotion is deleted.");
        } catch (Exception $e) {
            Log::info("deleteThisTemplate > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function changeStatus($request)
    {
        try {
            $response = PromotionTemplate::find($request->id);

            if(!empty($response)) {
                $response->update([
                    'status' => $request->status,
                ]);
            }

            return $this->helpReturn("Promotion status is updated.");
        } catch (Exception $e) {
            Log::info("deleteThisTemplate > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    /**
     * templateCustomerLink - when user will save we'll link of users with recipients
     * @param $request
     * @return mixed
     */
    public function linkTemplateUsers($request)
    {
        try{
            $userData = $this->sessionService->getAuthUserSession();
            $userId = $userData['id'];

            $recipients = $request->recipients;

//            Log::info("re");
//            Log::info($request->all());
//            Log::info("recipients");
//            Log::info($recipients);


            if(empty($recipients))
            {
                return $this->helpError(2, "Recipients are required.");
            }

            $templateId = $request->template_id;

            $code = 4;

            $storedData = CampaignUsersTrack::where('user_id', $userId)
                                    ->where('template_id', $templateId)
                                    ->get()->toArray();

            if(empty($storedData))
            {
                foreach($recipients as $recipient)
                {
                    CampaignUsersTrack::create(
                        [
                            'template_id' => $templateId,
                            'user_id' => $userId,
                            'recipient_id' => $recipient
                        ]
                    );
                }
                return $this->helpReturn("Recipients saved");
            }
            elseif(!empty($storedData))
            {
                $storedRecipients = [];

                foreach($storedData as $storedRow)
                {
                    $storedRecipients[] = $storedRow['recipient_id'];
                }

                $userRecipients = $recipients;

                Log::info("userRecipients");
//                Log::info($userRecipients);

                // array_diff
                // Returns an array containing all the entries from $userRecipients that are not present in any of
                // the $storedRecipients array.
                $recipientsManager = array_diff($userRecipients, $storedRecipients);
                $removeKeywords = array_diff($storedRecipients, $userRecipients);

                Log::info("recipientsManager");
//                Log::info($recipientsManager);

                Log::info("removeKeywords");
//                Log::info($removeKeywords);

                if(!empty($recipientsManager)) {
                    foreach($recipientsManager as $recipient) {
                        CampaignUsersTrack::create(
                            [
                                'template_id' => $templateId,
                                'user_id' => $userId,
                                'recipient_id' => $recipient
                            ]
                        );
                    }

                    $code = 200;
                }

                if(!empty($removeKeywords))
                {
                    foreach($removeKeywords as $removalElement)
                    {
                        CampaignUsersTrack::where(
                            [
                                'template_id' => $templateId,
                                'recipient_id' => $removalElement
                            ])->delete();
                    }
                }
            }

            return $this->helpReturn("Recipients updated.", [], $code);

        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function sendTemplatePreviewToUsers($request)
    {
        Log::info("processsssssss sendTemplatePreviewToUsers");
//        Log::info($request);
        try
        {
            $result = EmailTemplate::with(
                [
                    'campaignUsersLinked' => function($q) use($request)
                    {
                        $q->where('user_id', $request->user_id);
                        $q->with([
                            'recipients' => function($m)
                            {
                                $m->where('email', '!=', '');
                                $m->where('deleted_at', null);
//                                $m->orWhere('deleted_at', '');
                            },
                        ]);
                    },
                ]
            )->where('id', $request->template_id)->get()->toArray();

            Log::info("res");
//            Log::info($result);
            if( empty($result) || empty($result[0]['template_preview']) || empty($result[0]['campaign_users_linked']) )
            {
                return $this->helpError(404, 'Required data not found.');
            }

            $templateData = $result[0];

            // template from name is empty so I'm using user default practice name.
            if(empty($templateData['from']))
            {
                $businessObj = new BusinessEntity();
                $businessResult = $businessObj->userSelectedBusiness();

                if ($businessResult['_metadata']['outcomeCode'] != 200) {
                    return $this->helpError(1, 'Problem in selection of user business.');
                }

                $businessResult = $businessResult['records'];
                $templateData['fromBusinessName'] = $businessResult['practice_name'];
            }
            else
            {
                $templateData['fromBusinessName'] = $templateData['from'];
            }

            $job = new JobController();
            $job->runEmailCampaign($templateData);
        }
        catch (Exception $e)
        {
            Log::info("sendTemplatePreviewToUsers > " . $e->getMessage());
        }
    }
    public function copyThisPromotion($request)
    {
        # code...

        try {
            //code...
            $response = PromotionTemplate::with('templatePlans')->find($request->id);
//            log::info('$response');
//            log::info($response);

            if(!empty($response)) {
//                log::info('in');
                $copyPromotionTemplate = PromotionTemplate::create([
                    'user_id' => $response->user_id,
                    'title' => $response->title,
                    'subject' => $response->subject,
                    'response' => $response->response,
                    'template_preview' => $response->template_preview,
                    'thumbnail' => $response->thumbnail,
                    'template_linked_id' => $response->template_linked_id,
                    'step_status' => $response->step_status,
                    'from' => $response->from,
                    'reply_email' => $response->reply_email,
                    'status' => $response->status,
                    'is_deleted' => $response->is_deleted,
                    'schedule_at' => $response->schedule_at,
                    'industry' => $response->industry,
                    'niche' => $response->niche,
                    'template_type' => $response->template_type,
                    'credits' => $response->credits,
                ]);
//                log::info('out');
                $res = $response->toArray();
//                log::info($res);
                if(!empty($res['template_plans']))
                {
                    $plans = $res['template_plans'];
//                    log::info('$plans');
//                    log::info($plans);
                    $id = $copyPromotionTemplate->id;
//                    log::info('$id');
//                    log::info($id);
                    foreach($plans as $keyword)
                    {
                        PromotionTemplatePlan::create(
                            [
                                'template_id' => $id,
                                'user_id' => 1,
                                'plan' => $keyword['plan']
                            ]
                        );
                    }
                }

                return $this->helpReturn("Promotion is Copied.",$response);


            }
        } catch (Exception $e) {
            //Exception $e;
            Log::info("copyThisPromotionTemplate > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }
}
