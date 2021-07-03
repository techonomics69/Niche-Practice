<?php

namespace Modules\Business\Entities;

use DB;
use Log;
use Mail;
use Config;
use App\User;
use Redirect;
use Exception;
use App\Traits\UserAccess;
use Illuminate\Http\Request;
use App\Entities\AbstractEntity;
use App\Services\SessionService;
use Modules\CRM\Models\Recipient;
use Modules\Business\Models\Niches;
use Illuminate\Support\Facades\Hash;
use Modules\Business\Models\Business;
use Modules\Business\Models\Industry;
use Modules\User\Models\UserRolesREF;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Storage;
use Modules\Business\Models\EmailTemplate;
use Modules\Business\Models\SocialProfile;
use Modules\ThirdParty\Entities\YelpEntity;
use Modules\ThirdParty\Entities\SocialEntity;
use Modules\Business\Models\PromotionTemplate;
use Modules\Business\Models\CampaignUsersTrack;
use Modules\ThirdParty\Entities\FacebookEntity;
use Modules\ThirdParty\Models\SocialMediaMaster;
use Modules\ThirdParty\Models\TripadvisorMaster;
use Modules\ThirdParty\Entities\ThirdPartyEntity;
use Modules\ThirdParty\Entities\GooglePlaceEntity;
/**
 * Class AuthEntity
 * @package Modules\Auth\Entities
 */
class PromotionEntity extends AbstractEntity
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
        // dd('gfhfgh');

//        Log::info($request->get('response'));
        try {
            $userData = $this->sessionService->getAuthUserSession();
            $userId = $userData['id'];

            $data = $request->except('send', 'id', 'flag');
            $data['user_id'] = $userId;
            //            $data['user_id'] = 1;

            $response = [];

            $data['template_preview'] = $request->template_preview;
            //            $data = [];

            //            foreach($request->except('send') as $templateData)
            //            {
            //                $data['user_id'] = $request->get('user_id');
            //
            //                if($request->get('response'))
            //                {
            //                    $data['response'] = json_encode($request->get('response'));
            //                }
            //            }
            $templateId = $request->get('id');

            if($request->get('response'))
            {
                $data['response'] = json_encode($request->get('response'));
            }

            $templateData = PromotionTemplate::where('id', $templateId)->first();

            //            ->where('user_id', $userId)

            //            $templateData['subject'];

            //            if(empty($templateData))
            if($templateData['user_id'] != $userId)
            {
                $action = 'create';
//                Log::info('crea');
                $data['title'] = $templateData['title'];
                $data['template_linked_id'] = $templateData['id'];

                $businessObj = new BusinessEntity();
                $businessResult = $businessObj->userSelectedBusiness();

                $businessResult = $businessResult['records'];
                $industry = $businessResult['niche']['industry_id'];
                $niche = $businessResult['niche_id'];

                $data['industry'] = $industry;
                $data['niche'] = $niche;

                $response = PromotionTemplate::create($data);

                $savedTemplateId = $response['id'];

//                Log::info("success response ");
//                Log::info($response);

                //                return $this->helpReturn("Template is Saved.", $response);
            }
            elseif(!empty($templateData))
            {
                $action = 'update';
                $savedTemplateId = $templateData['id'];
                $response = $templateData->update($data);

                Log::info("update response ");
                Log::info($response);

                //                return $this->helpReturn("Template is Saved.");
            }
            // dd($request->get('flag'));
            if(!empty($request->template_preview) && !empty($savedTemplateId))
            {
                if($request->has('flag') && $request->get('flag') == 'embed')
                {
                    if(!empty($response['id']))
                    {
                        $templateData = PromotionTemplate::where('id', $savedTemplateId)->first();
                    }

                    $img = $request->get('template_preview');
                    $img = str_replace('data:image/png;base64,', '', $img);
                    $img = str_replace(' ', '+', $img);
                    $imageData = base64_decode($img);
                    $time = time();

                    $file = "image0xa4b".$userId."d$savedTemplateId"."_ts_"."$time.png";
                    $success = file_put_contents(public_path().'/poster/'.$file, $imageData);
                    $s3 = Storage::disk('s3');
                    $filePath = '/poster/' . $file;
                    $abc = $s3->put($filePath, file_get_contents(public_path().'/poster/'.$file, $imageData), 'public');
                    // file_put_contents('s3://webcamapp/'.$file, $imageData);
                    // $path = $request->response->store('promotion', 's3');
                    // dd($path);

                    $data['thumbnail'] = $file;
                    $templateData->update($data);

                    $image = 'https://nichespace.sfo2.digitaloceanspaces.com/poster/'.$file;
                }
            }

            if(!empty($response['id']) && $action == 'create')
            {
                $response = $response->toArray();

                Log::info("id respnse");
//                Log::info($response);

                if(!empty($image))
                {
                    Log::info("image respnse");
                    Log::info($image);

                    $response['image'] = $image;
                }

//                Log::info("modification respnse");
//                Log::info($response);

                if(!empty($image))
                {
                    $response[]['image'] = $image;
                }

                return $this->helpReturn("Template is Saved.", $response);
            }
            else if(!empty($savedTemplateId))
            {
                Log::info("else ifs");
                if(!empty($image))
                {
                    $data['image'] = $image;
                }
                return $this->helpReturn("Template is Saved.", $data);
            }


            return $this->helpError(3, 'Problem in saving template.');
        }
        catch(Exception $e)
        {
            Log::info("Promotion > saveTemplate > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function getTemplate()
    {
        try {
            $businessObj = new BusinessEntity();
            $businessResult = $businessObj->userSelectedBusiness();

            if ($businessResult['_metadata']['outcomeCode'] != 200) {
                return $this->helpError(1, 'Problem in selection of user business.');
            }

            $businessResult = $businessResult['records'];
            $industry = $businessResult['niche']['industry_id'];
            $niche = $businessResult['niche_id'];

            $response = PromotionTemplate::where('user_id', 1)
                ->where('is_deleted', 0)
                ->where('show_in_dashboard', 0)
                ->where('template_type', '!=', 3)
                ->where(function($query)
                {
                    $query->where('status', 'active');
                    $query->orWhereNull('status');
                })
                ->where('industry', $industry)
                ->where(function($q) use ($niche){
                    $q->where('niche', 0);
                    $q->orWhere('niche', $niche);
                })->get()->toArray();

            return $this->helpReturn("Result.", $response);
        } catch (Exception $e) {
            Log::info("Promo -> getTemplate > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function getNichePromotion($templateId, $type = 'encoded')
    {
        $businessObj = new BusinessEntity();
        $businessResult = $businessObj->userSelectedBusiness();

        $businessResult = $businessResult['records'];
        $industry = $businessResult['niche']['industry_id'];
        $niche = $businessResult['niche_id'];

        if($type == 'encoded')
        {
            $templateId = intval(str_replace('syx', '', base64_decode($templateId)));
        }

        $promotionData = PromotionTemplate::where('id', $templateId)
            ->where('industry', $industry)
            ->where(function($q) use ($niche){
                $q->where('niche', 0);
                $q->orWhere('niche', $niche);
            })
            ->first();

        return $promotionData;
    }

    public function userTemplateList()
    {
        try {
            $userData = $this->sessionService->getAuthUserSession();

            $businessObj = new BusinessEntity();
            $businessResult = $businessObj->userSelectedBusiness();
            $businessResult = $businessResult['records'];
            $userId = $businessResult['user_id'];
            $industry = $businessResult['niche']['industry_id'];
            $niche = $businessResult['niche']['id'];

            try {
                // make this for old promotions which not yet assigned with any niches.
                PromotionTemplate::where('user_id',$userId)
                    ->whereNull('industry')
                    ->whereNull('niche')
                    ->update([
                        'industry' => $industry,
                        'niche' => $niche,
                    ]);
            }
            catch (Exception $exception)
            {

            }

            $response = PromotionTemplate::where('user_id', $userData['id'])
                            ->whereNotNull('industry')
                            ->whereNotNull('niche')
                            ->where('is_deleted', 0)
                            ->get()->toArray();

//            $response = PromotionTemplate::where('user_id', $userData['id'])->get()->toArray();

            return $this->helpReturn("Result.", $response);
        } catch (Exception $e) {
            Log::info("userTemplateList > " . $e->getMessage());
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
                Log::info($userRecipients);

                // array_diff
                // Returns an array containing all the entries from $userRecipients that are not present in any of
                // the $storedRecipients array.
                $recipientsManager = array_diff($userRecipients, $storedRecipients);
                $removeKeywords = array_diff($storedRecipients, $userRecipients);

                Log::info("recipientsManager");
                Log::info($recipientsManager);

                Log::info("removeKeywords");
                Log::info($removeKeywords);

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
}
