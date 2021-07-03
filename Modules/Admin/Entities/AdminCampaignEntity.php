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
use Illuminate\Support\Facades\Log as FacadesLog;
use Modules\Admin\Models\MarketingAssociation;
use Modules\Admin\Models\Task;
use Modules\Admin\Models\TemplateCategory;
use Modules\Admin\Models\TemplateTypes;
use Modules\Business\Entities\BusinessEntity;
use Modules\Business\Models\Business;
use Modules\Business\Models\CampaignUsersTrack;
use Modules\Business\Models\EmailTemplate;
use Modules\Business\Models\EmailTemplatePlan;
use Modules\Business\Models\EmailTemplateSavedBlock;
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

class AdminCampaignEntity extends AbstractEntity
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
        try {
            $userData = $this->sessionService->getAdminUserSession();
            $userId = $userData['id'];

            $data = $request->except('send', 'id', 'attach_logo', 'attach_screenshot', 'type', 'plan');
            $data['user_id'] = $userId;
//            log::info('$data 11111');
//            log::info($data);

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
//                    Log::info("response test");
//                    $urlTest = json_encode("https://nichepractice.test/storage/app/template-doctor-logo.jpg");

//                    Log::info("new check1111 " . strpos(json_encode($request->get('response')), $urlTest));

//                    Log::info("one more check" . strpos(json_encode($request->get('response')), "https:\/\/nichepractice.test\/storage\/app\/template-doctor-logo.jpg"));

//                    $data['response'] = json_encode($request->get('response'));

                    $domainOnly = domainPathGet();

                    Log::info("domain " . $domainOnly);

                    $formatToReplace = array(
                        "https:\/\/$domainOnly\/storage\/app\/template-doctor-logo.jpg",
                        "http:\/\/$domainOnly\/storage\/app\/template-doctor-logo.jpg",

                        "https://$domainOnly/storage/app/template-doctor-logo.jpg",
                        "http://$domainOnly/storage/app/template-doctor-logo.jpg",

                        "https:\/\/$domainOnly\/storage\/app\/template-doc-photo.jpg",
                        "http:\/\/$domainOnly\/storage\/app\/template-doc-photo.jpg",

                        "https://$domainOnly/storage/app/template-doc-photo.jpg",
                        "http://$domainOnly/storage/app/template-doc-photo.jpg",
                    );
//                    $formatToReplace = array(
//                        $imageDir = json_encode(url('storage/app/template-doctor-logo.jpg')),
//                        $imageDir = url('storage/app/template-doctor-logo.jpg'),
//
//                        $imageDir = url('storage/app/template-doc-photo.jpg'),
//                        $imageDir = url('storage/app/template-doc-photo.jpg')
//                    );

                    $replaceFormat = array(
                        "%%Doctor_Logo%%",
                        "%%Doctor_Logo%%",
                        "%%Doctor_Logo%%",
                        "%%Doctor_Logo%%",
                        "%%Doctor_Photo%%",
                        "%%Doctor_Photo%%",
                        "%%Doctor_Photo%%",
                        "%%Doctor_Photo%%"
                    );

//                    $data['response'] = str_replace(
//                        "https:\/\/nichepractice.test\/storage\/app\/template-doctor-logo.jpg",
//                        "%%Doctor_Logo%%",
//                        json_encode($request->get('response')));

//                    $data['response'] = json_encode($request->get('response'), JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);

//                    Log::info(json_encode($request->get('response'), true));

                    // again convert and then
//                    json_encode(json_decode($json, true)

//
//                    Log::info("showing 2");
//                    Log::info(json_encode(json_decode($request->get('response'), true)));

//                    $request->get('response')
//                    return false;
                    $data['response'] = str_replace
                    (
                        $formatToReplace,
                        $replaceFormat,
                        $request->get('response')
//                        json_encode(json_decode($request->get('response'), true))
//                        json_encode($request->get('response'))
//                        json_encode($request->get('response'), JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)
                    );

                    Log::info("modufied");
                    Log::info($data['response']);
//                    $data['response'] = str_replace
//                    (
//                        $formatToReplace,
//                        $replaceFormat,
//                        json_encode($request->get('response'))
//                    );
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

            if ($request->hasFile('attach_screenshot')) {
                $attachedFile = $request->attach_screenshot;
                Log::info("file is");
                Log::info($request->attach_screenshot);

                foreach ($request->attach_screenshot as $index => $file) {
                    $file = $attachedFile[$index];
                    Log::info("file");
                    Log::info($file);
                    $extension = $file->getClientOriginalExtension();

                    Log::info("extension");
                    Log::info($extension);

                    if(empty($extension))
                    {
                        $extension = 'jpg';
                    }

                    $file_size = $file->getSize();
                    $file_size = number_format($file_size / 1048576, 2);

                    if(empty($templateId))
                    {
                        $picName = 'screenshot-' . time() . '.' . $extension;
                    }
                    else
                    {
                        $picName = 'screenshot-' . $templateId . '.' . $extension;
                    }

                    Storage::disk('local')->put($picName, File::get($file));

                    $logoUrl = Storage::url($picName);

                    if(!empty($picName))
                    {
                        $data['screenshot'] = $picName;
                    }
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

                if(!empty($data['screenshot']))
                {
                    $data['screenshot'] = uploadImagePath($data['screenshot']);
                    return $this->helpReturn("Template is updated.", $data);
                }
                else
                {
                    return $this->helpReturn("Template is updated.");
                }

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

    public function getTemplate($source = 'email_campaign')
    {
//        $data = Task::with('category')->orderByRaw('ISNULL(impact), impact ASC')->toSql();
//
//        print_r($data);
//        exit;
        try {
//            $response = EmailTemplate::with('templatePlans')->where('user_id', 1)->where('is_deleted', 0)->get()->toArray();

            $response = EmailTemplate::with('templatePlans')
                ->with('category')
                ->with('templateTypeLink')
                ->with('industry')
                ->with('niche')
                ->with('templateLinkedUser')
                ->where('user_id', 1)
                ->where('template_source', $source)
                ->where('is_deleted', 0);

            if($source == 'patient_campaign')
            {
                $response = $response->orderByRaw('ISNULL(date), date ASC, updated_at desc')->get()->toArray();
            }
            else
            {
                $response = $response->get()
                    ->toArray();
            }

            return $this->helpReturn("Result.", $response);
        } catch (Exception $e) {
            Log::info("getTemplate > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function getCategory()
    {
        try
        {
//            $data = Category::orderBy('priority', 'desc')->get()->toArray();
            $data = TemplateCategory::orderByRaw('ISNULL(priority), priority ASC')->get()->toArray();


            return $this->helpReturn('Category List', $data);
        }
        catch(Exception $e)
        {
            Log::info("admin campaign -> getCategory > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function saveCategory(Request $request)
    {
        try {
            $name = $request->name;
            $priority = $request->priority;

            if (!empty($request->id)) {
                // update
            } else {
                $recordExist = TemplateCategory::where('name', $name)->first();

                if (!empty($recordExist)) {
                    return $this->helpError(4, 'Name already exist.');
                }

                $data = TemplateCategory::create(
                    [
                        'name' => $name,
                        'priority' => $priority
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

            if (!empty($request->id)) {
                $id = $request->id;
                $category = TemplateCategory::find($id);

                Log::info("category");
                Log::info($category);

                if(!empty($category))
                {
                    $res = $category->update([
                        'name' => $name,
                        'priority' => $priority,
                    ]);

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

    public function deleteCategory($request)
    {
        try {
            $response = TemplateCategory::where('id', $request->id)->delete();

//            Log::info("response");
//            Log::info("$response");

            if(!empty($response))
            {
                // unlink this category to default panel

//                Task::where('category', $request->id)->delete();
            }

            return $this->helpReturn("Category deleted.");
        } catch (Exception $e) {
            Log::info("deleteTask > admin campaign entity > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }


    public function getType()
    {
        try
        {
//            $data = Category::orderBy('priority', 'desc')->get()->toArray();
            $data = TemplateTypes::orderByRaw('ISNULL(priority), priority ASC')->get()->toArray();


            return $this->helpReturn('Types List', $data);
        }
        catch(Exception $e)
        {
            Log::info("admincampaign -> getType > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function saveType(Request $request)
    {
        try {
            $name = $request->name;
            $priority = $request->priority;

            if (!empty($request->id)) {
                // update
            } else {
                $recordExist = TemplateTypes::where('name', $name)->first();

                if (!empty($recordExist)) {
                    return $this->helpError(4, 'Name already exist.');
                }

                $data = TemplateTypes::create(
                    [
                        'name' => $name,
                        'priority' => $priority
                    ]
                );

//                if(!empty($data['id']))
//                {
//                    $categories = Category::get()->all();
//
//                    return $this->helpReturn('Category added.', $categories);
//                }

                return $this->helpReturn('Type added.', $data);
            }

            return $this->helpError(3, 'No access.');
        } catch (Exception $e) {
            Log::info(" saveType > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function updateType(Request $request)
    {
        try {
            $name = $request->name;
            $priority = $request->priority;

            if (!empty($request->id)) {
                $id = $request->id;
                $category = TemplateTypes::find($id);

                Log::info("category");
                Log::info($category);

                if(!empty($category))
                {
                    $res = $category->update([
                        'name' => $name,
                        'priority' => $priority,
                    ]);

                    return $this->helpReturn("Record updated.");
                }
            }

            return $this->helpError(3, 'No access.');
        } catch (Exception $e) {
            Log::info(" saveCategory > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function deleteType($request)
    {
        try {
            $response = TemplateTypes::where('id', $request->id)->delete();

            if(!empty($response))
            {
                // unlink this category to default panel

//                Task::where('category', $request->id)->delete();
            }

            return $this->helpReturn("Type deleted.");
        } catch (Exception $e) {
            Log::info("deleteTask > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function changeStatus($request)
    {
        try {
            Log::info("request->target Test");
            Log::info($request->target);

            if($request->target == 'category')
            {
                $response = TemplateCategory::find($request->id);

                if(!empty($response)) {
                    $response->update([
                        'status' => $request->status,
                    ]);
                }

                return $this->helpReturn("Status is updated.");
            }
            else
            {
                $response = TemplateTypes::find($request->id);

//                Log::info("res");
//                Log::info($response);

                if(!empty($response)) {
                    $response->update([
                        'status' => $request->status,
                    ]);
                }

                return $this->helpReturn("Type status is updated.");
            }
        } catch (Exception $e) {
            Log::info("changeStatus > " . $e->getMessage());
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

    public function getThisTemplate($request)
    {
        try {
            $response = EmailTemplate::with('templatePlans')->find($request->id);


            $domainOnly = domainPathGet();

            Log::info("domain " . $domainOnly);

            $formatToReplace = array(
                "%%Doctor_Logo%%",
                "%%Doctor_Photo%%");

//            $replaceFormat = array(
//                "https:\/\/$domainOnly\/storage\/app\/template-doctor-logo.jpg",
//                "http:\/\/$domainOnly\/storage\/app\/template-doctor-logo.jpg",
//
//                "https:\/\/$domainOnly\/storage\/app\/template-doc-photo.jpg",
//                "http:\/\/$domainOnly\/storage\/app\/template-doc-photo.jpg",
//            );

            $replaceFormat = array(
                url('storage/app/template-doctor-logo.jpg'),
                url('storage/app/template-doc-photo.jpg')
            );

            $response['response'] = str_replace
            (
                $formatToReplace,
                $replaceFormat,
                $response['response']
            );


            return $this->helpReturn("Result.", $response);
        } catch (Exception $e) {
            Log::info("getTemplate > " . $e->getMessage());
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

    public function copyThisTemplate($request)
    {
        # code...

        try {
            //code...
            $response = EmailTemplate::find($request->id);
            if(!empty($response)) {
                $copyEmailTemplate = EmailTemplate::create([
                    'campaign_for_user' => $response->campaign_for_user,
                    'category' => $response->category,
                    'credits' => $response->credits,
                    'date' => $response->date,
                    'from' => $response->from,
                    'industry' => $response->industry,
                    'is_deleted' => $response->is_deleted,
                    'list_id' => $response->list_id,
                    'list_name' => $response->list_name,
                    'niche' => $response->niche,
                    'plan' => $response->plan,
                    'reply_email' => $response->reply_email,
                    'response' => $response->response,
                    'schedule_at' => $response->schedule_at,
                    'single_send_id' => $response->single_send_id,
                    'single_send_name' => $response->single_send_name,
                    'status' => $response->status,
                    'step_status' => $response->step_status,
                    'subject' => $response->subject,
                    'template_linked_id' => $response->template_linked_id,
                    'template_preview' => $response->template_preview,
                    'template_source' => $response->template_source,
                    'template_type_link' => $response->template_type_link,
                    'thumbnail' => $response->thumbnail,
                    'title' => $response->title,
                    'user_id' => $response->user_id

                ]);
                $response = $copyEmailTemplate->with('templatePlans')
                ->with('category')->with('templateTypeLink')
                ->with('industry')
                ->with('niche')
                ->with('templateLinkedUser')
                ->where('user_id', 1)
                ->where('template_source', 'email_campaign')
                ->where('is_deleted', 0)->get()->toArray();

                return $this->helpReturn("Campaign is Copied.",$response);

                // $response = $copyEmailTemplate->with('templatePlans')
                // ->with('category')->with('templateTypeLink')
                // ->with('industry')
                // ->with('niche')
                // ->with('templateLinkedUser')
                // ->where('user_id', 1)
                // ->where('template_source', 'email_campaign')
                // ->where('is_deleted', 0)->get()->toArray();
            }
        } catch (Exception $e) {
            //Exception $e;
            Log::info("copyThisTemplate > " . $e->getMessage());
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

//                Log::info("userRecipients");
//                Log::info($userRecipients);

                // array_diff
                // Returns an array containing all the entries from $userRecipients that are not present in any of
                // the $storedRecipients array.
                $recipientsManager = array_diff($userRecipients, $storedRecipients);
                $removeKeywords = array_diff($storedRecipients, $userRecipients);

                Log::info("recipientsManager");
//                Log::info($recipientsManager);
//
//                Log::info("removeKeywords");
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

    /************************************** Template Saved Block **************************************/

    public function saveTemplateBlock($request)
    {
        try {
            $userData = $this->sessionService->getAdminUserSession();
            $userId = $userData['id'];
            $data = $request->except('send', 'blockId');
            $data['created_by'] = $userId;
//            $data['template_preview'] = $request->template_preview;

//            $request->get('id')
//            Log::info("data sa");
//            Log::info($data);

            $templateData = EmailTemplateSavedBlock::where('id', $request->get('blockId'))->get()->toArray();

//            Log::info("data templae");
//            Log::info($templateData);

            if(empty($templateData))
            {
//                Log::info("if");
                EmailTemplateSavedBlock::create(
                    [
                        'name' => $request->get('name'),
                        'definition' => json_encode($request->get('json')),
                        'created_by' => $request->get('created_by'),
                        'block_associated_template' => $request->get('block_associated_template'),
                    ]
                );

                return $this->helpReturn("Block saved.");
            }
            else
            {
//                Log::info("ELSE");

                EmailTemplateSavedBlock::where('id', $request->get('blockId'))->update(
                    [
                        'name' => $request->get('name')
                    ]
                );

                return $this->helpReturn("Block update.");
            }
        }
        catch(Exception $e)
        {
            Log::info("saveTemplateBlock > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function getSavedBlock()
    {
        try {
//            $response = EmailTemplate::with('templatePlans')->where('user_id', 1)->where('is_deleted', 0)->get()->toArray();

            $response = EmailTemplateSavedBlock::get()->toArray();

            return $this->helpReturn("List.", $response);
        } catch (Exception $e) {
            Log::info("getSavedBlock > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function deleteSavedBlock($request)
    {
        try {

            EmailTemplateSavedBlock::where('id', $request->get('id'))->delete();

            return $this->helpReturn("Block deleted.");
        } catch (Exception $e) {
            Log::info("deleteSavedBlock > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }


    /************************************** Template Saved Block **************************************/
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
    public function deleteMarketingAssociation($request)
    {
        try {
            $response = MarketingAssociation::where('id', $request->id)->delete();

//            Log::info("response");
//            Log::info("$response");

            if(!empty($response))
            {
                // unlink this category to default panel

//                Task::where('category', $request->id)->delete();
            }

            return $this->helpReturn("Marketing Association deleted.");
        } catch (Exception $e) {
            Log::info("deleteAssociation > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }
    public function updateMarketingAssociation($request)
    {
        try {
            log::info('$request');
//            log::info($request);
            $thumbnail = '';
            $name = $request->name;
            $priority = $request->priority;
            $description = $request->description;

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
                    $thumbnail = $logoName;
                }
            }
            log::info('$thumbnail');
            log::info($thumbnail);

            if (!empty($request->id)) {
                $id = $request->id;

                $recordExist = MarketingAssociation::where('name', $name)->first();
                if (!empty($recordExist)) {
                    return $this->helpError(4, 'Name already exist.');
                }

                $association = MarketingAssociation::find($id);

                Log::info('$association');
//                Log::info($association);

                if(!empty($association))
                {
                    $res = $association->update([
                        'name' => $name,
                        'priority' => $priority,
                        'thumbnail' => $thumbnail,
                        'description' => $description
                    ]);

                    Log::info("tes");
//                    Log::info($res);

                    return $this->helpReturn("Record updated.");
                }
            }

            return $this->helpError(3, 'No access.');
        } catch (Exception $e) {
            Log::info(" saveAssociation > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }
}
