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
use Modules\Admin\Models\Category;
use Modules\Admin\Models\MarketingProServices;
use Modules\Admin\Models\ServiceCredits;
use Modules\Admin\Models\Task;
use Modules\Admin\Services\Validations\Task\TaskValidator;
use Modules\Business\Entities\BusinessEntity;
use Modules\Business\Models\Business;
use Modules\Business\Models\CampaignUsersTrack;
use Modules\Business\Models\EmailTemplate;
use Modules\Business\Models\EmailTemplatePlan;
use Modules\Business\Models\Industry;
use Modules\Business\Models\Niches;
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
use Redirect;
/**
 * Class AuthEntity
 * @package Modules\Auth\Entities
 */
class AdminMarketingEntity extends AbstractEntity
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

    protected $taskValidator;



    public function __construct()
    {
        $this->googlePlaces = new GooglePlaceEntity();
        $this->businessEntity = new BusinessEntity();
        $this->facebook = new FacebookEntity();
        $this->yelp = new YelpEntity();
        $this->thirdPartyEntity = new ThirdPartyEntity();
        $this->socialEntity = new SocialEntity();
        $this->taskValidator = new TaskValidator(resolve('validator'));

        $this->sessionService = new SessionService();
    }

    public function getCategory()
    {
        try
        {
//            $data = Category::orderBy('priority', 'desc')->get()->toArray();
//            $data = Category::orderByRaw('ISNULL(priority), priority ASC')->get()->toArray();
            $data = Category::orderByRaw('type DESC')->get()->toArray();


            return $this->helpReturn('Category List', $data);
        }
        catch(Exception $e)
        {
            Log::info("getCategory > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function getService($id)
    {
        try
        {
            $data = MarketingProServices::with('serviceCredits')->find($id);

            if(!empty($data))
            {
                return $this->helpReturn('Record', $data->toArray());
            }

            return $this->helpError(404, ' No Service exists');
        }
        catch(Exception $e)
        {
            Log::info("getService > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function serviceCreditRecord($id)
    {
        $result = ServiceCredits::find($id);

        if(!empty($result))
        {
            return $this->helpReturn('Record', $result->toArray());
        }

        return $this->helpError(404, ' No Service exists');
    }

    public function list($access = '')
    {
        try
        {
            if($access == 'user')
            {
                $data = MarketingProServices::where('sys_status', 1)->orderByRaw('ISNULL(priority), priority ASC, created_at desc')->get()->toArray();
            }
            else
            {
                $data = MarketingProServices::orderByRaw('ISNULL(priority), priority ASC, created_at desc')->get()->toArray();
            }


            return $this->helpReturn('List', $data);
        }
        catch(Exception $e)
        {
            Log::info("marketing list > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function createUpdateService(Request $request)
    {
        try {
            $data = $request->except('_token', 'add_logo_image', 'credit_title', 'credits');

//            print_r($data);
//            exit;
            if (!$this->taskValidator->with($data)->passes()) {
                return $this->helpError(2, 'Required field must not be missed.', $this->taskValidator->errors());
            }

            if ($request->file('add_logo_image')) {
                $attachment = $request->file('add_logo_image')->store('services','public');
                $data['thumbnail'] = $attachment;
            }

            return DB::transaction(function () use ($data, $request)
            {
                if (!empty($data['id'])) {

                    $taskData = MarketingProServices::where('id', $data['id'])->update($data);
                }
                else
                {
                    $taskData = MarketingProServices::create($data);

                    $request->merge(['id' => $taskData['id']]);
                }

                $this->saveServiceCredits($request);

                if (!empty($data['id'])) {
                    return $this->helpReturn("Service Updated.");
                }

                return $this->helpReturn("Service created.", $taskData->toArray());
            });
        } catch (Exception $e) {
            Log::info(" createService > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function saveServiceCredits($request)
    {
        try {

//        print_r($request->all());
//        exit;
        $credits = $request->get('credits');
        $creditTitle = $request->get('credit_title');
        $id = $request->get('id');

//        print_r($credits);
//        exit;

        $res = ServiceCredits::where(['pro_service_id' => $id])->get()->toArray();

        $storedIds = array_column($res, 'id');

//        print_r($storedIds);
//        exit;
        $requestedIds = [];
        foreach($credits as $index => $credit)
        {
            $requestedIds[] = $index;
            $title = $creditTitle[$index];

            $data = ['pro_service_id' => $id, 'credits' => $credit, 'title' => $title];

            $creditsExist = ServiceCredits::where(['pro_service_id' => $id, 'id' => $index])->first();

            if(!empty($creditsExist))
            {
                $creditsExist->update($data);
            }
            else
            {
                ServiceCredits::create($data);
            }
        }

//        print_r($requestedIds);

        $toBeDelete = array_diff($storedIds, $requestedIds);

//            print_r($toBeDelete);
//            exit;

        if(!empty($toBeDelete))
        {
            foreach($toBeDelete as $deleteThis)
            {
                ServiceCredits::where(['pro_service_id' => $id, 'id' => $deleteThis])->delete();
            }
        }
        }catch (Exception $e)
        {
            Log::info(" saveServiceCredits > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function serviceUpdate($request, $id)
    {
        try {
            $data = $request->except('files', '_token');

//            print_r($data);
//            exit;
            if (!$this->taskValidator->with($data)->passes()) {
                return $this->helpError(2, 'Required field must not be missed.', $this->taskValidator->errors());
            }

            $task = MarketingProServices::find($id);
            $taskData = $task->update($data);

            return $this->helpReturn("Service updated.");
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function saveCategory(Request $request)
    {
        try {
            $name = $request->name;
            $priority = $request->priority;
            $type = !empty($request->type) ? $request->type : '';
            $description = !empty($request->description) ? $request->description : '';
            $show_to_paid = !empty($request->show_to_paid) ? $request->show_to_paid : 0;
            $credits = !empty($request->credits) ? $request->credits : 0;
            $content = (!empty($request->get('content'))) ? $request->get('content') : null;


            if (!empty($request->id)) {
                // update
            } else {
                $recordExist = Category::where('name', $name)->first();

                if (!empty($recordExist)) {
                    return $this->helpError(4, 'Name already exist.');
                }

                $thumbnail = null;
                if ($request->hasFile('attach_logo')) {
                    $attachedFile = $request->attach_logo;
                    $i = 0;

                    foreach ($attachedFile as $file) {
                        $file = $attachedFile[$i];
                        $extension = $file->getClientOriginalExtension();

                        $file_size = $file->getSize();
                        $file_size = number_format($file_size / 1048576, 2);

                        $logoName = 'campaign' . time() . '.' . $extension;

                        Storage::disk('local')->put($logoName, File::get($file));

                        $logoUrl = Storage::url($logoName);
                    }

                    if(!empty($logoName))
                    {
                        $thumbnail = $logoName;
                    }
                }

                $data = Category::create(
                    [
                        'name' => $name,
                        'priority' => $priority,
                        'type' => $type,
                        'description' => $description,
                        'show_to_paid' => $show_to_paid,
                        'thumbnail' => $thumbnail,
                        'content' => $content,
                        'credits' => $credits,
                        'settings_module' => (!empty($request->get('settings'))) ? $request->get('settings') : null
                    ]
                );

//                if(!empty($data['id']))
//                {
//                    $categories = Category::get()->all();
//
//                    return $this->helpReturn('Category added.', $categories);
//                }

                return $this->helpReturn('Category added.', $data);
            }

            return $this->helpError(3, 'No access.');
        } catch (Exception $e) {
            Log::info(" saveCategory > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function updateCategory(Request $request)
    {
        try {
            $name = $request->name;
            $priority = $request->priority;

            $dataToUpdate = [
                'name' => $name,
                'priority' => $priority,
                'show_to_paid' => $request->show_to_paid,
                'description' => $request->description,
                'credits' => !empty($request->credits) ? $request->credits : 0,
                'content' => (!empty($request->get('content'))) ? $request->get('content') : null,
                'settings_module' => (!empty($request->get('settings'))) ? $request->get('settings') : null
            ];


            if ($request->hasFile('attach_logo')) {
                $attachedFile = $request->attach_logo;
                $i = 0;

                foreach ($attachedFile as $file) {
                    $file = $attachedFile[$i];
                    $extension = $file->getClientOriginalExtension();

                    $file_size = $file->getSize();
                    $file_size = number_format($file_size / 1048576, 2);

                    $logoName = 'campaign' . time() . '.' . $extension;

                    Storage::disk('local')->put($logoName, File::get($file));

                    $logoUrl = Storage::url($logoName);
                }

                if(!empty($logoName))
                {
                    $dataToUpdate['thumbnail'] = $logoName;
                }
            }



//            if(isset($request->type))
//            {
//                $dataToUpdate['type'] = $request->type;
//            }
//            else if(!empty($request->type))
//            {
//                $dataToUpdate['type'] = $request->type;
//            }

            $dataToUpdate['type'] = $request->type;

            Log::info("sddsd");
            Log::info($dataToUpdate);

            if (!empty($request->id)) {
                $id = $request->id;

                $category = Category::where('name', $name)
                    ->where('id', '!=',$id)
                    ->first();

                if(empty($category))
                {
                    $category = Category::find($id);
                }
                else
                {
                    return $this->helpError(4, 'Name already exist.');
                }

                Log::info("category");
                Log::info($category);

                if(!empty($category))
                {
                    $res = $category->update($dataToUpdate);

                    Log::info("tes");
                    Log::info($res);

                    return $this->helpReturn("Record updated.");
                }
            }

            return $this->helpError(3, 'No access.');
        } catch (Exception $e) {
            Log::info(" saveCategory > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function changeStatus($request)
    {
        try {
            $response = MarketingProServices::find($request->id);

            if(!empty($response)) {
                $response->update([
                    'sys_status' => $request->status,
                ]);
            }

            return $this->helpReturn("Status is updated.");
        } catch (Exception $e) {
            Log::info("changeStatus > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function deleteService($request)
    {
        try {

            $response = MarketingProServices::find($request->id)->delete();

            return $this->helpReturn("Service deleted.");
        } catch (Exception $e) {
            Log::info("deleteTask > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function deleteCategory($request)
    {
        try {

            $response = Category::where('id', $request->id)->delete();

            Log::info("response");
            Log::info("$response");
            if(!empty($response))
            {
                Task::where('category', $request->id)->delete();
            }

            return $this->helpReturn("Category deleted.");
        } catch (Exception $e) {
            Log::info("deleteTask > admin marketing entity > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function saveTemplate($request)
    {
        try {
            $userData = $this->sessionService->getAdminUserSession();
            $userId = $userData['id'];

            $data = $request->except('send', 'id', 'attach_logo', 'type', 'plan');
            $data['user_id'] = $userId;

            $data['template_preview'] = $request->template_preview;

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

            $templateData = EmailTemplate::where('id', $templateId)->first();

            if(empty($templateData))
            {
                $response = EmailTemplate::create($data);

                $request->merge(['id' => $response['id']]);
                $this->updateTemplatePlans($request);

                return $this->helpReturn("Template is Saved.", $response);
            }
            elseif(!empty($templateData))
            {
                $this->updateTemplatePlans($request);
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
                EmailTemplatePlan::where('template_id', $template)->delete();

                return $this->helpReturn("Plans deleted.");
            }

            $keywordsData = $plans;

            $code = 4;

            $storedPlansData = EmailTemplatePlan::where('template_id', $template)
                ->get();

            if(empty($storedPlansData->toArray()) && !empty($plans))
            {
                foreach($plans as $keyword)
                {
                    Log::info("create " . $keyword);
                    EmailTemplatePlan::create(
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
                        EmailTemplatePlan::create(
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
                        EmailTemplatePlan::where(
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
//            $response = EmailTemplate::with('templatePlans')->where('user_id', 1)->where('is_deleted', 0)->get()->toArray();

            $response = EmailTemplate::with('templatePlans')->with('industry')->with('niche')
                ->where('user_id', 1)->where('is_deleted', 0)->get()->toArray();

//            print_r($response);
//            exit;
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

    public function deleteThisTemplate($request)
    {
        try {
            $response = EmailTemplate::find($request->id);

            if(!empty($response)) {
                $response->update([
                    'is_deleted' => 1,
                ]);
            }

            return $this->helpReturn("Campaign is deleted.");
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
}
