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
use Modules\Admin\Models\Reports;
use Modules\Admin\Models\CampaignAssociation;
use Modules\Admin\Models\CampaignFeedback;
use Modules\Admin\Models\Category;
use Modules\Admin\Models\Task;
use Modules\Admin\Services\Validations\Task\TaskValidator;
use Modules\Admin\Models\MarketingAssociation;
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
use Modules\ThirdParty\Entities\YelpEntity;
use Modules\User\Models\Users;
use Modules\User\Models\UserRolesREF;
use Redirect;

/**
 * Class AuthEntity
 * @package Modules\Auth\Entities
 */
class AdminTaskEntity extends AbstractEntity
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

    public function getCategory($monthlyCampaign = '')
    {
        try {
//            $data = Category::orderBy('priority', 'desc')->get()->toArray();
//            $data = Category::orderByRaw('ISNULL(priority), priority ASC')->get()->toArray();
            if ($monthlyCampaign == 1) {
                $data = Category::orderByRaw('type DESC')->where('month_campaign', '=', 1)->where('type', '=', '12-month-campaign')
                    ->orderBy('id', 'desc')
                    ->get()->toArray();
            } else if ($monthlyCampaign == 2) {
                $data = Category::orderByRaw('type DESC')->with('niches')->with('industries')
                    ->where('type', '!=', '12-month-campaign')
                    ->orderBy('id', 'desc')
                    ->get()->toArray();
            } else {
//                log::info('into else');
                $data = Category::orderByRaw('type DESC')
                    ->orderBy('id', 'desc')->get()->toArray();
            }

            return $this->helpReturn('Category List', $data);
        } catch (Exception $e) {
            Log::info("getCategory > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function getTask($id)
    {
        try {
            $data = Task::find($id);

            if (!empty($data)) {
                return $this->helpReturn('Record', $data);
            }

            return $this->helpError(404, ' No Task exists');
        } catch (Exception $e) {
            Log::info("getTask > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function list()
    {
        try {
            $data = Task::with('category')
//                ->where('type', '!=', 'inner')
                ->whereNull('type')
                ->orderByRaw('ISNULL(impact), impact ASC, created_at desc')->get()->toArray();

            return $this->helpReturn('Task List', $data);
        } catch (Exception $e) {
            Log::info("task list > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function createTask(Request $request)
    {
        try {
            $data = $request->except('_token', 'files');
            if (!$this->taskValidator->with($data)->passes()) {
                return $this->helpError(2, 'Required field must not be missed.', $this->taskValidator->errors());
            }

            $taskData = Task::create($data);

            if (!empty($taskData['id'])) {
                return $this->helpReturn("Task created.", $taskData);
            }

            return $this->helpError(42, 'Task not created. Please try again.');

        } catch (Exception $e) {
            Log::info(" createTask > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function taskUpdate($request, $id)
    {
        try {
            $data = $request->except('files', '_token');

//            print_r($data);
//            exit;
            if (!$this->taskValidator->with($data)->passes()) {
                return $this->helpError(2, 'Required field must not be missed.', $this->taskValidator->errors());
            }

            $task = Task::find($id);
            $taskData = $task->update($data);

            return $this->helpReturn("Task updated.");
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function saveCategory(Request $request)
    {
//        log::info('$request');
//        log::info($request);
//        $assoc = $request->association;
//        $arr = json_decode($assoc, true);

//        json_decode($assoc);
//        log::info($arr);
//        foreach ($arr as $assoc){
//            log::info($assoc);
//        }
//        for ($i = 0;  $i < count($assoc) ; $i++){
//            log::info($assoc[$i]);
//        }
//        exit();
//        log::info('$request->month_campaign');
//        log::info(intval($request->month_campaign));
//        exit;
        try {

            $name = !empty($request->name) ? $request->name : '';
            $priority = (checkValue($request->priority)) ? $request->priority : null;
            $type = !empty($request->type) ? $request->type : '';
            $campaign_filter = !empty($request->campaign_filter) ? $request->campaign_filter : '';
            $campaign_filter_priority = (checkValue($request->campaign_filter_priority)) ? $request->campaign_filter_priority : null;
            $status = (checkValue($request->status)) ? $request->status : 1;
            $description = !empty($request->description) ? $request->description : '';
            $show_to_paid = !empty($request->show_to_paid) ? $request->show_to_paid : 0;
            $credits = !empty($request->credits) ? $request->credits : 0;
            $content = (!empty($request->get('content'))) ? $request->get('content') : null;
            $month_campaign = (!empty($request->get('month_campaign'))) ? intval($request->get('month_campaign')) : 0;
            $industry = (checkValue($request->industry)) ? $request->industry : null;
            $niche = (checkValue($request->niche)) ? $request->niche : null;
            $markAsComplete = $request->mark_as_complete_check;
            $sample_description = (!empty($request->get('sample_description'))) ? $request->get('sample_description') : null;
//            $showRating = $request->show_rating;
//            $association = !empty($request->association) ? $request->association : null;
//            log::info('$association');
//           / log::info(count($association));
//            foreach ($association as $assoc) {
//                log::info($assoc);
//            }
//            exit;
//            $resulting['results'] = Category::with('tasks');
//            log::info('$resulting');
//            log::info($resulting->toArray());


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

                    if (!empty($logoName)) {
                        $thumbnail = $logoName;
                    }
                }
                $data = Category::create(
                    [
                        'name' => $name,
                        'priority' => $priority,
                        'type' => $type,
                        'campaign_filter' => $campaign_filter,
                        'campaign_filter_priority' => $campaign_filter_priority,
                        'description' => $description,
                        'show_to_paid' => $show_to_paid,
                        'status' => $status,
                        'thumbnail' => $thumbnail,
                        'content' => $content,
                        'credits' => $credits,
//                        'library_type' => $request->get('library_type'),
                        'library_type' => (!empty($request->get('library_type'))) ? $request->get('library_type') : 1,
                        'settings_module' => (!empty($request->get('settings'))) ? $request->get('settings') : null,
                        'month_campaign' => $month_campaign,
                        'industry' => $industry,
                        'niche' => $niche,
                        'mark_as_complete_check' => $markAsComplete,
                        'sample_description' => $sample_description,
//                        'show_rating' => $showRating
//                        'association' => $association
                    ]
                );
//                log::info($data->id);
//                log::info('$data->id');
//                log::info('$request');
//                log::info($request);
                $request->merge(['id' => $data->id]);
                $campaignId = $data->id;
                $assoc = $request->association;
                $association = json_decode($assoc, true);
//                $res =  $this->saveAssociationCampaign($request);
                $res = $this->saveAssociationCampaign($campaignId, $association);
//                log::info($res);

///////////////////////////////////////////////////////////////
/////////////////// Trying new functionality //////////////////
///////////////////////////////////////////////////////////////

//                $catTasksList = Category::with('tasks')->get();
                $catTasksList = Category::with([
                    'tasks' => function ($q) {
                        $q->where('type', 'inner');
                    }
                ])->get()->toArray();

                foreach ($catTasksList as $category) {
                    if (empty($category['tasks'])) {
//                       log::info("here for " . $category['id']);
                        $createInnerTask = Task::create([
                            'title' => 'Tell Us How We Did?',
                            'sys_status' => 1,
                            'category' => $category['id'],
                            'type' => 'inner'
//                           'impact' => 1
                        ]);
                    }
                }

///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////
/// foreach ($catTasksList as $category)
//                {
//                    $countInnerTasks = 0;
////                    $noTasks = '';
//                    log::info("category id . $category->id");
//                    log::info("category Task . $category->tasks");
//
//                    if(!empty($category->tasks)) {
//                        foreach ($category->tasks as $tasksList) {
////                            log::info('$tasksList');
////                            log::info($tasksList);
//                            if(!empty($tasksList['type']) && $tasksList['type'] == 'inner') {
//                                $countInnerTasks++;
//                            }
//                        }
//                    }
////                    log::info('$countInnerTasks');
////                    log::info($countInnerTasks);
//                    if( empty($countInnerTasks) ) {
//                        log::info("here for . $category->id");
//                        $createInnerTask = Task::create([
//                            'title' => 'Tell Us How We Did?',
//                            'sys_status' => 1,
//                            'category' => $category->id,
//                            'type' => 'inner'
//                        ]);
//                    }
//
//                }
///////////////////////////////////////////////////////////////
//                    log::info($category->id);
//                    $taskCheck = $category->tasks;
//                    if( empty($taskCheck) ) {
//                        log::info('no tasks.');
//                        $noTasks = 'no';
//                    }
//                    log::info('$noTasks');
//                    log::info($noTasks);
//                log::info($res);


//                exit;


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
//        log::info('request');
//        log::info($request);
//        exit;
        try {
            $name = $request->name;
            $priority = $request->priority;

            $dataToUpdate = [
                'name' => $name,
                'priority' => $priority,
                'show_to_paid' => !empty($request->show_to_paid) ? $request->show_to_paid : 0,
                'description' => !empty($request->description) ? $request->description : null,
                'credits' => !empty($request->credits) ? $request->credits : 0,
                'campaign_filter' => !empty($request->campaign_filter) ? $request->campaign_filter : '',
                'campaign_filter_priority' => (checkValue($request->campaign_filter_priority)) ? $request->campaign_filter_priority : null,
                'library_type' => !empty($request->get('library_type')) ? $request->get('library_type') : 1,
                'content' => (!empty($request->get('content'))) ? $request->get('content') : null,
                'settings_module' => (!empty($request->get('settings'))) ? $request->get('settings') : null,
                'industry' => (checkValue($request->industry)) ? $request->industry : null,
                'niche' => (checkValue($request->niche)) ? $request->niche : null,
                'status' => (checkValue($request->status)) ? $request->status : 1,
                'mark_as_complete_check' => $request->mark_as_complete_check,
                'sample_description' => (!empty($request->get('sample_description'))) ? $request->get('sample_description') : null
//                'show_rating' =>  $request->show_rating
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

                if (!empty($logoName)) {
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

//            Log::info("sddsd");
//            Log::info($dataToUpdate);

            if (!empty($request->id)) {
                $id = $request->id;

                $category = Category::where('name', $name)
                    ->where('id', '!=', $id)
                    ->first();

                if (empty($category)) {
                    $category = Category::find($id);
                } else {
                    return $this->helpError(4, 'Name already exist.');
                }

//                Log::info("category");
//                Log::info($category);

                if (!empty($category)) {
                    $res = $category->update($dataToUpdate);

                    $assoc = $request->association;
                    $association = json_decode($assoc, true);

//                    log::info('associationcheck');
//                    log::info($association);

                    if (empty($association)) {
                        CampaignAssociation::where('campaign_id', $id)
                            ->delete();
                    }

                    $updateAssocCatLink = $this->saveAssociationCampaign($id, $association);
//                    if($res != true || $updateAssocCatLink['_metadata']['outcomeCode'] != 200 ){
//                        return $this->helpError(1, $updateAssocCatLink['_metadata']['message']);
//                    }
//                    log::info('$updateAssocCatLink');
//                    log::info($updateAssocCatLink);


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
//            Log::info("request->target");
//            Log::info($request->target);
            if ($request->target == 'category') {
                $response = Category::find($request->id);

                if (!empty($response)) {
                    $response->update([
                        'status' => $request->status,
                    ]);
                }

                return $this->helpReturn("Status is updated.");
            } else {
                $response = Task::find($request->id);

                if (!empty($response)) {
                    $response->update([
                        'sys_status' => $request->status,
                    ]);
                }

                return $this->helpReturn("Task status is updated.");
            }
        } catch (Exception $e) {
            Log::info("changeStatus > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function deleteTask($request)
    {
        try {

            $response = Task::where('id', $request->id)->delete();

            return $this->helpReturn("Task deleted.");
        } catch (Exception $e) {
            Log::info("deleteTask > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function deleteCategory($request)
    {
        try {

            $response = Category::where('id', $request->id)->delete();

//            Log::info("response");
//            Log::info("$response");
            if (!empty($response)) {
                Task::where('category', $request->id)->delete();
            }

            return $this->helpReturn("Category deleted.");
        } catch (Exception $e) {
            Log::info("deleteTask > admin task entity > " . $e->getMessage());
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

            if ($request->get('response')) {
                if ($request->has('type') && $request->get('type') == 'import') {
                    $data['response'] = $request->get('response');
                } else {
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

                if (!empty($logoName)) {
                    $data['thumbnail'] = $logoName;
                }
            }

            $templateData = EmailTemplate::where('id', $templateId)->first();

            if (empty($templateData)) {
                $response = EmailTemplate::create($data);

                $request->merge(['id' => $response['id']]);
                $this->updateTemplatePlans($request);

                return $this->helpReturn("Template is Saved.", $response);
            } elseif (!empty($templateData)) {
                $this->updateTemplatePlans($request);
                $response = $templateData->update($data);

                return $this->helpReturn("Template is updated.");
            }

            return $this->helpError(3, 'An unknown error has occurred. Please try again.');
        } catch (Exception $e) {
            Log::info("saveTemplate > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function updateTemplatePlans($request)
    {
        try {
            $userData = $this->sessionService->getAdminUserSession();
            $userId = $userData['id'];

            $plans = $request->get('plan');
            $template = $request->get('id');

//            Log::info("template > $template" );

            if (empty($plans)) {
                EmailTemplatePlan::where('template_id', $template)->delete();

                return $this->helpReturn("Plans deleted.");
            }

            $keywordsData = $plans;

            $code = 4;

            $storedPlansData = EmailTemplatePlan::where('template_id', $template)
                ->get();

            if (empty($storedPlansData->toArray()) && !empty($plans)) {
                foreach ($plans as $keyword) {
//                    Log::info("create " . $keyword);
                    EmailTemplatePlan::create(
                        [
                            'template_id' => $template,
                            'user_id' => $userId,
                            'plan' => $keyword
                        ]
                    );
                }

                return $this->helpReturn("Plan saved");
            } elseif (!empty($storedPlansData->toArray())) {
                $storedPlans = [];

                foreach ($storedPlansData as $keyword) {
                    $storedPlans[] = $keyword['plan'];
                }

                if (!empty($plans)) {
                    $userPlans = $plans;
                }

                // array_diff
                // Returns an array containing all the entries from $userPlans that are not present in any of the $storedPlans array.
                $keywordsManager = array_diff($userPlans, $storedPlans);
                $removePlans = array_diff($storedPlans, $userPlans);

                if (!empty($keywordsManager)) {
                    foreach ($keywordsManager as $keyword) {
//                        Log::info("create2 " . $keyword);
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

                if (!empty($removePlans)) {
                    foreach ($removePlans as $removalElement) {
//                        Log::info("dele " . $removalElement);
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

            if (!empty($response)) {
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
        try {
            $userData = $this->sessionService->getAuthUserSession();
            $userId = $userData['id'];

            $recipients = $request->recipients;

//            Log::info("re");
//            Log::info($request->all());
//            Log::info("recipients");
//            Log::info($recipients);


            if (empty($recipients)) {
                return $this->helpError(2, "Recipients are required.");
            }

            $templateId = $request->template_id;

            $code = 4;

            $storedData = CampaignUsersTrack::where('user_id', $userId)
                ->where('template_id', $templateId)
                ->get()->toArray();

            if (empty($storedData)) {
                foreach ($recipients as $recipient) {
                    CampaignUsersTrack::create(
                        [
                            'template_id' => $templateId,
                            'user_id' => $userId,
                            'recipient_id' => $recipient
                        ]
                    );
                }
                return $this->helpReturn("Recipients saved");
            } elseif (!empty($storedData)) {
                $storedRecipients = [];

                foreach ($storedData as $storedRow) {
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

//                Log::info("recipientsManager");
//                Log::info($recipientsManager);
//
//                Log::info("removeKeywords");
//                Log::info($removeKeywords);

                if (!empty($recipientsManager)) {
                    foreach ($recipientsManager as $recipient) {
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

                if (!empty($removeKeywords)) {
                    foreach ($removeKeywords as $removalElement) {
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
//        Log::info("processsssssss sendTemplatePreviewToUsers");
//        Log::info($request);
        try {
            $result = EmailTemplate::with(
                [
                    'campaignUsersLinked' => function ($q) use ($request) {
                        $q->where('user_id', $request->user_id);
                        $q->with([
                            'recipients' => function ($m) {
                                $m->where('email', '!=', '');
                                $m->where('deleted_at', null);
//                                $m->orWhere('deleted_at', '');
                            },
                        ]);
                    },
                ]
            )->where('id', $request->template_id)->get()->toArray();

//            Log::info("res");
//            Log::info($result);
            if (empty($result) || empty($result[0]['template_preview']) || empty($result[0]['campaign_users_linked'])) {
                return $this->helpError(404, 'Required data not found.');
            }

            $templateData = $result[0];

            // template from name is empty so I'm using user default practice name.
            if (empty($templateData['from'])) {
                $businessObj = new BusinessEntity();
                $businessResult = $businessObj->userSelectedBusiness();

                if ($businessResult['_metadata']['outcomeCode'] != 200) {
                    return $this->helpError(1, 'Problem in selection of user business.');
                }

                $businessResult = $businessResult['records'];
                $templateData['fromBusinessName'] = $businessResult['practice_name'];
            } else {
                $templateData['fromBusinessName'] = $templateData['from'];
            }

            $job = new JobController();
            $job->runEmailCampaign($templateData);
        } catch (Exception $e) {
            Log::info("sendTemplatePreviewToUsers > " . $e->getMessage());
        }
    }

    public function copyThisCategory($request)
    {
        try {
            $response = Category::find($request->id);

            $nameExist = Category::where('name', $response->name)->count();


            if (!empty($response)) {
                $data = Category::create([
                    'name' => $response->name . " $nameExist ",
                    'settings_module' => $response->settings_module,
                    'type' => $response->type,
                    'show_to_paid' => $response->show_to_paid,
                    'library_type' => $response->library_type,
                    'priority' => $response->priority,
                    'status' => 0,
                    'content' => $response->content,
                    'credits' => $response->credits,
                    'description' => $response->description,
                    'parent' => $response->id,
                    'thumbnail' => $response->thumbnail,
                    'niche' => $response->niche,
                    'industry' => $response->industry,
                    'month_campaign' => $response->month_campaign,
                ]);
//                log::info($data->id);
                $result = CampaignAssociation::where('campaign_id', '=', $request->id)->get()->toArray();
                $resultTask = Task::where('category', '=', $request->id)->whereNull('type')->get()->toArray();

//                log::info($resultTask);
                if (!empty($result)) {
                    foreach ($result as $item) {
                        CampaignAssociation::create(
                            [
                                'campaign_id' => $data->id,
                                'association_id' => $item['association_id']
                            ]
                        );
                    }
                }
                if (!empty($resultTask)) {
                    foreach ($resultTask as $items) {
                        $taskNameExist = Task::where('title', $items['title'])->count();
//                        log::info('$taskNameExist');
//                        log::info($taskNameExist);
//                        log::info($items['title'] . " $taskNameExist ");
                        Task::create(
                            [
                                'title' => $items['title'] . " $taskNameExist ",
                                'description' => $items['description'],
                                'impact' => $items['impact'],
                                'sys_status' => 0,
                                'title' => $items['title'],
                                'month' => $items['month'],
                                'estimated_time' => $items['estimated_time'],
                                'category' => $data->id,
                                'week' => $items['week'],
                                'recurring_days' => $items['recurring_days'],
                                'credits' => $items['credits'],
                                'credits_description' => $items['credits_description']
                            ]
                        );
                    }
                }

                return $this->helpReturn("Category is Copied.");
            }
        } catch (Exception $e) {
            //Exception $e;
            Log::info("copyThisCategory > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function marketingAssociation($request)
    {
        try {
//            log::info('$request');
//            log::info($request);
//            exit;
            $recordExist = MarketingAssociation::where('name', $request->name)->first();

            if (!empty($recordExist)) {
                return $this->helpError(4, 'Name already exist.');
            }

            $icon = null;
            if ($request->hasFile('attach_logo')) {
                $attachedFile = $request->attach_logo;
                $i = 0;

                foreach ($attachedFile as $file) {
                    $file = $attachedFile[$i];
                    $extension = $file->getClientOriginalExtension();

                    $file_size = $file->getSize();
                    $file_size = number_format($file_size / 1048576, 2);

                    $logoName = 'association' . time() . '.' . $extension;

                    Storage::disk('local')->put($logoName, File::get($file));

                    $logoUrl = Storage::url($logoName);
                }

                if (!empty($logoName)) {
                    $icon = $logoName;
                }
            }


            $data = MarketingAssociation::create([
                'name' => $request->name,
                'description' => !empty($request->description) ? $request->description : null,
                'thumbnail' => $icon,
                'status' => !empty($request->status) ? $request->status : 1,
                'priority' => (checkValue($request->priority)) ? $request->priority : null
            ]);

            return $this->helpReturn("Marketing Association Added Successfully.", $data);
        } catch (Exception $e) {
            //Exception $e;
            Log::info("addmarketingservices > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function changeAssociationStatus($request)
    {
        try {

            $response = MarketingAssociation::find($request->id);

            if (!empty($response)) {
                $response->update([
                    'status' => $request->status,
                ]);
            }

            return $this->helpReturn("status is updated.");
        } catch (Exception $e) {
            Log::info("changeStatus > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function saveAssociationCampaign($campaignsId = '', $association = [])
    {
        try {
            $associations = $association;

            if (empty($associations)) {
                return $this->helpError(2, "Associations are required.");
            }

//            $campaignId = $request->id;
            $campaignId = $campaignsId;
//            $associationId = $request->association_id;

            $code = 4;

            $storedData = CampaignAssociation::where('campaign_id', $campaignId)->get()->toArray();
//                ->where('template_id', $templateId)

            if (empty($storedData)) {
                foreach ($associations as $association) {
                    CampaignAssociation::create(
                        [
                            'campaign_id' => $campaignId,
                            'association_id' => $association,
                        ]
                    );
                }
                return $this->helpReturn("Association and Category saved");
            } elseif (!empty($storedData)) {
                $storedRecipients = [];

                foreach ($storedData as $storedRow) {
                    $storedAssociation[] = $storedRow['association_id'];
                }

                $userAssociation = $associations;

//                Log::info("userRecipients");
//                Log::info($userRecipients);

                // array_diff
                // Returns an array containing all the entries from $userRecipients that are not present in any of
                // the $storedRecipients array.
                $recipientsManager = array_diff($userAssociation, $storedAssociation);
                $removeKeywords = array_diff($storedAssociation, $userAssociation);

//                Log::info("recipientsManager");
//                Log::info($recipientsManager);
//
//                Log::info("removeKeywords");
//                Log::info($removeKeywords);

                if (!empty($recipientsManager)) {
                    foreach ($recipientsManager as $recipient) {
                        CampaignAssociation::create(
                            [
                                'campaign_id' => $campaignId,
                                'association_id' => $recipient
                            ]
                        );
                    }

                    $code = 200;
                }

                if (!empty($removeKeywords)) {
                    foreach ($removeKeywords as $removalElement) {
                        CampaignAssociation::where(
                            [
                                'campaign_id' => $campaignId,
                                'association_id' => $removalElement
                            ])->delete();
                    }
                }
            }

            return $this->helpReturn(200, "Association Links updated.", [], $code);

        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function getLinkedAssociations(Request $request)
    {
        try {
            $category = CampaignAssociation::where('campaign_id', '=', $request->id)->get()->toArray();
//            log::info('$category');

            $associations = [];

            if (!empty($category)) {
                foreach ($category as $key => $element) {
                    $associations[$key] = $element['association_id'];
                }
            }

            $this->data['associationsList'] = $associations;

            return $this->helpReturn("Associations List.", $this->data);


        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function updateUserInfo($request)
    {
        try {

            //        $userData = $this->sessionService->getAuthUserSession();
            $id = $request->id;
            $password = $request->password;
//            log::info('$password');
//            log::info($password);
            $niche = $request->niche;
            $user = Users::where('id', $id)->first();

            //        if (!Hash::check($request->current_password, $user->password))
            //        {
            //            return $this->helpError(404, 'Your old password is not matched with current password.');
            //        }

            $data['password'] = Hash::make($password);
//            log::info('password');
//            log::info($data['password']);
            $user->update($data);

            $business = Business::where('user_id', $id)->first();
//            log::info('$business');
//            log::info($business);
            $businessUpdate = $business->update(['niche_id' => $niche]);
//            log::info( '$businessUpdate' );
//            log::info( $businessUpdate );
            $niche = Niches::where('id', '=', $niche)->first();
            $this->data['niche'] = $niche;
            return $this->helpReturn('Record Updated successfully.', $this->data);
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function campaignFeedback($request)
    {
        try {
//            log::info('$request');
//            log::info($request);
            $userData = $this->sessionService->getAuthUserSession();
//            log::info('$userData');
            $user_id = $userData['id'];
//            log::info($userData);

            $star = $request->star;
            $comment = $request->comment;
            $categoryId = $request->category_id;
            $taskId = $request->task_id;
            $result = CampaignFeedback::create(
                [
                    'star_rating' => $star,
                    'comment' => $comment,
                    'category' => $categoryId,
                    'task' => $taskId,
                    'user_id' => $user_id
                ]
            );
            return $this->helpReturn('Your valuable feedback is submitted successfully.');
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function saveReport($request)
    {
        try {

//            $fileName = '';

            $userDataAdmin = $this->sessionService->getAdminUserSession();

//            log::info('$userData');
//            log::info($userDataAdmin);
            $user_id = $userDataAdmin['id'];

            $title = $request->title;
            $content = $request->content;
            $customer = $request->customer;
            $status = $request->status;
//            log::info('$request');
//            log::info($request);
////            exit();
//            $file = $request->file('file');
//            log::info('$file');
//            log::info($file);
//            $extension = $file->getClientOriginalExtension();
//
//
//            $fileName = $file->getFilename() . '.' . $extension;
//
//            $path = request()->file('file')->getRealPath();
//            log::info('$extension');
//            log::info($extension);
//            log::info('$fileName');
//            log::info($fileName);
//            log::info('$path');
//            log::info($request->file);
//            $ename = $file->getClientOriginalName();
//            log::info('$request');
//            log::info($ename);
//            exit();
            if ($request->hasFile('file')) {
//                log::info('inside file');
                $file = $request->file('file');

                $extension = $file->getClientOriginalExtension();
//                $fileName = $file->getFilename() . '.' . $extension;
                $fileName = $file->getClientOriginalName();
//                log::info('$fileName');
//                log::info($fileName);
                $path = request()->file('file')->getRealPath();
                Storage::disk('local')->put($fileName, File::get($file));
            }

            $result = Reports::create(
                [
                    'title' => $title,
                    'content' => $content,
                    'customer' => $customer,
                    'status' => $status,
                    'file_name' => !empty($fileName) ? $fileName : '',
                    'assignee' => $user_id
                ]
            );
            return $this->helpReturn('Report added successfully.');
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function getReports()
    {
        try {
            $userDataAdmin = $this->sessionService->getAdminUserSession();

//            log::info('$userData');
//            log::info($userDataAdmin);
            $user_id = $userDataAdmin['id'];
            if ($userDataAdmin['email'] == 'admin@nichepractice.com') {

                $data = Reports::with('relatedUser')->orderBy('id', 'desc')->get()->toArray();
            } else {
                $data = Reports::with('relatedUser')->where('assignee', $user_id)->orderBy('id', 'desc')->get()->toArray();
            }
//            log::info('$userData');


            return $this->helpReturn('Report List', $data);
        } catch (Exception $e) {
            Log::info("getReports > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function deleteReport($request)
    {
        try {

            $response = Reports::where('id', $request->id)->delete();

//            Log::info("response");
//            Log::info("$response");
//            if(!empty($response))
//            {
//                Task::where('category', $request->id)->delete();
//            }

            return $this->helpReturn("Report deleted.");
        } catch (Exception $e) {
            Log::info("deleteReport > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function updateReport($request)
    {
        try {
            $name = $request->title;
//            log::info('$request');
//            log::info($request);


//            $file = $request->file('file');
//            if(!empty( $file ) ) {
//                $extension = $file->getClientOriginalExtension();
//                $fileName = $file->getFilename() . '.' . $extension;
//                $path = request()->file('file')->getRealPath();
//            }


            if ($request->hasFile('file')) {
                $file = $request->file('file');

                $extension = $file->getClientOriginalExtension();
//                $fileName = $file->getFilename() . '.' . $extension;
                $fileName = $file->getClientOriginalName();
                $path = request()->file('file')->getRealPath();
                Storage::disk('local')->put($fileName, File::get($file));
            }

            if (!empty($request->id)) {
                $id = $request->id;

                $report = Reports::where('title', $name)->where('id', '!=', $id)->first();

                if (empty($report)) {
                    $report = Reports::find($id);
                } else {
                    return $this->helpError(4, 'Title already exist.');
                }
//                log::info('$report');
//                log::info($report);
                $dataToUpdate = [
                    'title' => $request->title,
                    'content' => !empty($request->content) ? $request->content : $report->content,
                    'customer' => !empty($request->customer) ? $request->customer : $report->customer,
                    'status' => checkValue($request->status) ? $request->status : $report->status,
                    'file_name' => !empty($fileName) ? $fileName : $report->file_name,
                ];

                if (!empty($report)) {
                    $res = $report->update($dataToUpdate);

                }
                return $this->helpReturn("Record updated.");
            }
        } catch (Exception $e) {
            Log::info($e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function changeReportStatus($request)
    {
        try {
//            log::info('$response');
////            log::info($request->id);
//            log::info($request->status);
            $response = Reports::find($request->id);
//                log::info('$response');
////                log::info($response);

            if (checkValue($response)) {
                $response->update([
                    'status' => $request->status,
                ]);
            }

            return $this->helpReturn("Report status is updated.");
        } catch (Exception $e) {
            Log::info("changeReportStatus > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function reportUser()
    {
        try {
//            log::info('request');
//            $reportUser = Users::with(['userRole' => function ($q) {
//                $q->where('role_id', 4);
//            }])->get()->toArray();
            $reportUser = UserRolesREF::with('usersRef')->where('role_id', 4)->get()->toArray();

            return $this->helpReturn("report user list.", $reportUser);

        } catch (Exception $e) {
            Log::info("addReportUser > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function addReportUser($request)
    {
        try {
//            log::info('$response');
//            log::info($request);

            $user = Users::where('email', $request->get('email'))->first();

            if (!empty($user)) {
                return $this->helpError(4, 'This email exists. Please select a different email address.');
            }
//            log::info('addReportUser');
            $data['first_name'] = $request['first_name'];
            $data['last_name'] = $request['last_name'];
            $data['email'] = $request['email'];
            $data['password'] = Hash::make($request['password']);
            $data['admin_panel_user'] = 'admin_user';

//            log::info($data);
//            log::info('addReportUser 1');
            $result = Users::create($data);
//            log::info('addReportUser 2');
//            log::info($result);
            $refUser['user_id'] = $result['id'];

            $refUser['role_id'] = 4;

//            log::info($result);

            $userRole = UserRolesREF::create($refUser);

//            log::info($userRole);

            return $this->helpReturn("User added successfully.", $result);

        } catch (Exception $e) {
            Log::info("addReportUser > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function changeReportUserStatus($request)
    {
        try {
//            log::info('$response');
////            log::info($request->id);
//            log::info($request->status);

            $response = Users::find($request->id);

//            log::info('$response');
////                log::info($response);

            if (checkValue($response)) {
                $response->update([
                    'status' => $request->status,
                ]);
            }

            return $this->helpReturn("Report user status is updated.");
        } catch (Exception $e) {
            Log::info("changeReportUserStatus > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function deleteReportUser($request)
    {
        try {
            $response = Users::where('id', $request->id)->delete();

//            Log::info("response");
//            Log::info("$response");

            if (!empty($response)) {
                // unlink this category to default panel

//                Task::where('category', $request->id)->delete();
            }

            return $this->helpReturn("User deleted.");
        } catch (Exception $e) {
            Log::info("deleteTask > admin task entity > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function updateReportUser($request)
    {
        try {
            $user = Users::where('email', $request->get('email'))->first();

            if (!empty($user)) {
                return $this->helpError(4, 'This email exists. Please select a different email address.');
            }

//            $first_name = $request->first_name;
//            $last_name = $request->last_name;


            if (!empty($request->id)) {
                $id = $request->id;

//                $report = Users::where('title', $name)->where('id', '!=', $id)->first();.
                $user = Users::where('email', $request->get('email'))->first();

                if (!empty($user)) {
                    return $this->helpError(4, 'This email exists. Please select a different email address.');
                } else {
                    $existingUser = Users::find($id);
                }

//                if (empty($report)) {
//                    $report = Reports::find($id);
//                } else {
//                    return $this->helpError(4, 'Title already exist.');
//                }
//                log::info('$report');
//                log::info($report);
                $dataToUpdate = [
                    'first_name' => $request->first_name,
                    'last_name' => !empty($request->last_name) ? $request->last_name : $existingUser->last_name,
                    'email' => $request->email

                ];

                if (!empty($existingUser)) {
                    $res = $existingUser->update($dataToUpdate);

                }
                return $this->helpReturn("User updated.");
            }
        } catch (Exception $e) {
            Log::info($e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }
}
