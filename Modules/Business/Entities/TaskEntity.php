<?php

namespace Modules\Business\Entities;

use DB;
use Log;
use Mail;
use Config;
use Exception;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Traits\UserAccess;
use Illuminate\Http\Request;
use Modules\Admin\Models\Task;
use Modules\Admin\Models\UserTaskCategory;
use Modules\User\Models\Users;
use App\Entities\AbstractEntity;
use App\Mail\CreateWebsiteEmail;
use App\Services\SessionService;
use Modules\Admin\Models\Category;
use Modules\Business\Models\Domains;
use Modules\Business\Models\Website;
use Modules\Business\Models\Business;
use phpDocumentor\Reflection\Element;
use Modules\Admin\Models\BusinessTask;
use Illuminate\Database\Eloquent\Builder;
use Modules\ThirdParty\Models\UserIssues;
use Modules\ThirdParty\Entities\ThirdPartyEntity;
use Modules\User\Entities\Billing\SubscriptionManagerEntity;
use App\Mail\CampaignPurchasedNotification;
use App\Mail\CampaignPurchasedNotificationToAdmin;

class TaskEntity extends AbstractEntity
{
    use UserAccess;

    protected $businessEntity;

    protected $sessionService;

    public function __construct()
    {
        $this->sessionService = new SessionService();
        $this->businessEntity = new BusinessEntity();
    }

    public function unlockCampaign(Request $request)
    {
        try {
            $userData = $this->sessionService->getAuthUserSession();

            $userId = $userData['id'];

            if(isActivePaid() == true)
            {
                $sub = new SubscriptionManagerEntity();
                $subData = $sub->getSubscribedPackage($userId);

                $taskCategory = UserTaskCategory::where([
                    'user_id' => $userId,
                    'category_id' => $request->get('campaign'),
                ])->first();

                if(!empty($taskCategory))
                {
                    return $this->helpError(3, 'You have already unlock this campaign.');
                }

                $dateSubStarted = Date('Y-m-d', strtotime($subData['created_at']));
                $dateToExpire = Date('Y-m-d', strtotime('+1 month', strtotime($subData['created_at'])));

                $taskCredits = 0;
                $taskDetail = Category::where('id', $request->get('campaign'))->get()->toArray();

                if(empty($taskDetail[0]['credits']))
                {
//                    return $this->helpError(3, 'Admin has not edit credits on this Campaign yet.Please try again later.');
//                    return $this->helpError(3, 'This campaign can not purchase yet. Please try again later.');
                    return $this->helpError(3, 'Please Contact Support to Access This Campaign.');
                }

                $taskCredits = $taskDetail[0]['credits'];

                // remainingcredits = purchasedcredits - usedcredits
                $credits = $sub->userCreditsBalance();

                if(empty($credits) || $credits < $taskCredits)
                {
                    return $this->helpError(404, 'You don\'t have enough credits to make this purchase. Would you like to add some?');
                }

//                if(!empty($request->get('purchase')) && $request->get('purchase') == "1")
//                {
//                    $taskDetail = Category::where('id', $request->get('campaign'))->get()->toArray();
//
//                if(empty($taskDetail[0]['credits']))
//                {
//                    return $this->helpError(3, 'Admin has not edit credits on this Campaign yet.Please try again later.');
//                }
//
//                    $taskCredits = $taskDetail[0]['credits'];
//
//                    // remainingcredits = purchasedcredits - usedcredits
//                    $credits = $sub->userCreditsBalance();
//
//                    if(empty($credits) || $credits < $taskCredits)
//                    {
//                        return $this->helpError(404, 'You don\'t have enough credits to make this purchase. Would you like to add some?');
//                    }
//                }

/*****************************  bind with option - no need  *******************************/
//                if(empty($request->get('purchase'))) {
//                    $ref = UserTaskCategory::where('user_id', $userId)
//                        ->where('created_at', '>=', DATE($dateSubStarted))
//                        ->where('created_at', '<=', DATE($dateToExpire))
//                        ->wherenull('purchase_status')
//                        ->count();
//
//                    if (!empty($ref) && $ref >= 2) {
//                        return $this->helpError(3, 'You have already unlock two campaigns for this month.');
//                    }
//                }

/*****************************  bind with option - no need  *******************************/

                return DB::transaction(function () use ($userId, $request, $taskCredits)
                {
//                    if(!empty($request->get('purchase')) && $request->get('purchase') == "1")
//                    {
//                        $userTaskCategory = UserTaskCategory::create([
//                            'user_id' => $userId,
//                            'category_id' => $request->get('campaign'),
//                            'purchase_status' => 1,
//                        ]);
//
//                        $moduleId = $userTaskCategory['id'];
//
//                        $sub = new SubscriptionManagerEntity();
//
//                        $sub->manageCreditHistory($taskCredits, 'user_task_category', $moduleId);
//
//                        $sub->updateCreditsSession();
//
//                        $credits = ['creditsBalance' => $sub->userCreditsBalance()];
//
//                        return $this->helpReturn("Campaign unlocked successfully.", $credits);
//                    }
//                    else
//                    {
//                        $userTaskCategory = UserTaskCategory::create([
//                            'user_id' => $userId,
//                            'category_id' => $request->get('campaign'),
//                        ]);
//                    }


                    $userTaskCategory = UserTaskCategory::create([
                        'user_id' => $userId,
                        'category_id' => $request->get('campaign'),
                        'purchase_status' => 1,
                    ]);

                    $moduleId = $userTaskCategory['id'];

                    $campaignTitle = (!empty($request->get('campaignTitle'))) ? $request->get('campaignTitle') : null;

                    $sub = new SubscriptionManagerEntity();

                    $sub->manageCreditHistory($taskCredits, 'user_task_category', $moduleId, $campaignTitle);

                    $sub->updateCreditsSession();

                    $credits = ['creditsBalance' => $sub->userCreditsBalance()];

//                    log::info('$credits');
//                    log::info($credits);
//
//                    log::info('$sub');
//                    log::info($userTaskCategory);
//
//                    log::info('campaign');
//                    log::info($request->get('campaign'));

                    $userPurchasedCampaign = Category::where('id', '=', $request->get('campaign'))->first();
                    $userData = $this->sessionService->getAuthUserSession();
//                    log::info('$userData');
//                    log::info($userData);
//                    log::info('$userPurchasedCampaign');
//                    log::info($userPurchasedCampaign);
//                    log::info($userPurchasedCampaign['name']);
//                    log::info($userPurchasedCampaign['credits']);
                    $userEmail = $userData['email'];
                    $userFirstName = $userData['first_name'];
                    $userLastName = $userData['last_name'];
                    $campaign = $userPurchasedCampaign['name'];
                    $campaignCredits = $userPurchasedCampaign['credits'];
                    $remainingCredits = $credits['creditsBalance'];
//                    log::info('$userEmail');
//                    log::info($userEmail);
//                    log::info($userFirstName);
//                    log::info($userLastName);
//                    log::info($campaign);
//                    log::info($campaignCredits);
//                    log::info($remainingCredits);

                    try {
//                        foreach ($emailList as $email) {
//                            log::info($email);
//                            $mail = mail::to($userEmail)->send(new CampaignPurchasedNotification(
//                                $userFirstName,
//                                $userLastName,
//                                $campaign,
//                                $campaignCredits,
//                                $remainingCredits
//                            ));
////                            Mail::to($recipient)->send(new OrderShipped($order));
//                        }
                        $mail = mail::to($userEmail)->send(new CampaignPurchasedNotification(
                            $userFirstName,
                            $userLastName,
                            $campaign,
                            $campaignCredits,
                            $remainingCredits
                        ));
                        Log::info("email successfully sent to user");
                        $mail = mail::to('nichepractice1@gmail.com')->send(new CampaignPurchasedNotificationToAdmin(
                            $userFirstName,
                            $userLastName,
                            $campaign,
                            $campaignCredits,
                            $remainingCredits,
                            $userEmail
                        ));
                        Log::info("email successfully sent to admin");
//                        Log::info("email successfully sent to admin 123");
//                        Log::info("email successfully sent to admin 1234");
                    }
                    catch(Exception $e)
                    {
                        Log::info("email failed $userEmail");
                        Log::info($e->getMessage());
                    }

                    return $this->helpReturn("Campaign unlocked successfully.", $credits);
                });
            }
            else
            {
                return $this->helpError(1, 'Your subscription has expired.');
            }
        }
        catch(Exception $e)
        {
            Log::info(" unlockCampaign > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function list($request, $userId = '')
    {
        try {
            $userData = $this->sessionService->getAuthUserSession();
            $businessResult = $this->businessEntity->userSelectedBusiness();
            $niche =  $businessResult['records']['niche']['id'];
            $industry =  $businessResult['records']['niche']['industry']['id'];


//            DB::enableQueryLog();
            $requestedTask = $request->get('status');
            $add_to_do_clicked = $request->get('add_to_do_clicked');

//            Log::info('$add_to_do_clicked');
//            Log::info($add_to_do_clicked);
//            $requestedTask = 'open';
//            $requestedTask = 'open';

//            $result = Task::whereDoesntHave('marketingTasks', function(Builder $query) use ($userId, $requestedTask) {
//                $query->where('user_id', $userId);
//                $query->whereIn('status', ['done', 'skipped', 'paid']);
//            })->orderByRaw('ISNULL(impact), impact ASC, created_at desc')
//                ->limit($numPosts)
//                ->get()->toArray();

//            $result = Category::with(['tasks' => function ($q) use ($userId, $requestedTask)
//            {
//                $q->where('sys_status', 1);
//                $q->with(['marketingTasks' =>function($query) use ($userId, $requestedTask)
//                {
//                    $query->where('user_id', $userId);
//                    $query->where('status', 'done');
//                }]);
//            }])->where('status', 1)->get()->toArray();

            if($requestedTask == 'open')
            {
                $user_id = session('user_data')['id'];
                // if clicked on add more task
//                if ($add_to_do_clicked) {
//                    Users::where('id', $user_id)->update([
//                        'tasks_counter' => 5
//                    ]);
//                }
//                $user = Users::find($user_id);
//
//                $numPosts = $user->tasks_counter;


                $result['non_marketing_tasks'] = Category::with(
                    [
                        'tasks' => function ($q) use ($userId, $requestedTask)
                        {
                            $q->where('sys_status', 1);
                            $q->whereDoesntHave('marketingTasks', function($query) use ($userId, $requestedTask)
                            {
                                $query->where('user_id', $userId);
                                $query->whereIn('status', ['done', 'skipped', 'paid']);
                            });
                            $q->leftJoin('week_category as wc', function($join) {
                                $join->on('sys_task.week', '=', 'wc.id');
                            });
                            $q->select('sys_task.*', 'wc.id as wc_id', 'wc.name', 'wc.priority');
//                            $q->orderByRaw('ISNULL(impact), impact ASC, created_at desc');
                            $q->orderByRaw('ISNULL(priority), priority ASC, ISNULL(impact), impact ASC, sys_task.created_at desc');
//                            $q->orderByRaw('ISNULL(impact), impact ASC, created_at desc');
//                            $q->orderByRaw('ISNULL(week), week ASC,ISNULL(impact), impact ASC, created_at desc');
                        }
                    ]
                )->where('type', 'non-marketing-campaign')
                    ->where('industry', $industry)
                        ->where(function($q) use ($niche){
                            $q->where('niche', 0);
                            $q->orWhere('niche', $niche);
                        })
                    ->where('status', 1)
//                    ->orderByRaw('ISNULL(priority), priority ASC, created_at ASC')
                    ->orderByRaw('created_at ASC')
                    ->get()
                    ->toArray();

                $result['marketing_tasks'] = Category::with(
                    [
                        'tasks' => function ($q) use ($userId, $requestedTask, $userData)
                        {
                            $q->where('sys_status', 1);

                            if($userData['subscriptionStatus']['subscription_expired'] == true || $userData['subscriptionStatus']['subscription_type'] == 'trial')
                            {
                                $q->whereIn('category',function($catQuery){
                                    $catQuery->select('id')->from('category')->where('show_to_paid', '=', 0);
                                });
                            }
                            elseif(isActivePaid() == true)
                            {
                                $q->where(function($query) use($userId)
                                {
                                    $query->whereIn('category',function($catQuery1){
                                        $catQuery1->select('id')->from('category')->where('show_to_paid', '=', 0);
                                    });

                                    $query->orWhereIn('category',function($catQuery) use ($userId) {
                                        $catQuery->select('category_id')->from('user_task_category')->where('user_id', '=', $userId);
                                    });
                                });
                            }

                            $q->whereDoesntHave('marketingTasks', function($query) use ($userId, $requestedTask)
                            {
                                $query->where('user_id', $userId);
                                $query->whereIn('status', ['done', 'skipped', 'paid']);
                            });
                            $q->leftJoin('week_category as wc', function($join) {
                                $join->on('sys_task.week', '=', 'wc.id');
                            });
                            $q->select('sys_task.*', 'wc.id as wc_id', 'wc.name', 'wc.priority');
//                            $q->orderByRaw('ISNULL(impact), impact ASC, created_at desc');
                            $q->orderByRaw('ISNULL(priority), priority ASC, ISNULL(impact), impact ASC, sys_task.created_at desc');
//                            $q->orderByRaw('ISNULL(impact), impact ASC, created_at desc');
//                            $q->orderByRaw('ISNULL(week), week ASC,ISNULL(impact), impact ASC, created_at desc');
                        }
                    ]
                )->with(['userCategory' => function($q) use ($userId){
                    $q->where('user_id', $userId);
                }])->where('type', 'marketing-campaign')
                    ->where('industry', $industry)
                    ->where(function($q) use ($niche){
                        $q->where('niche', 0);
                        $q->orWhere('niche', $niche);
                    })
                    ->where('status', 1)
//                    ->orderByRaw('show_to_paid ASC, ISNULL(priority), priority ASC')
                    ->orderByRaw('show_to_paid ASC, priority ASC, created_at ASC')
                    ->get()->toArray();

                /**
                 * Hidden due to again category new flow (marketing and non-marketing flow)
                 */
                // $numPosts = !empty($request->get('get_num_post')) ? $request->get('get_num_post') : 5;
//                $result = Task::whereDoesntHave('marketingTasks', function(Builder $query) use ($userId, $requestedTask) {
//                    $query->where('user_id', $userId);
//                    $query->whereIn('status', ['done', 'skipped', 'paid']);
//                })->orderByRaw('ISNULL(impact), impact ASC, created_at desc')
//                    ->limit($numPosts)
//                    ->get()->toArray();

//                Log::info("result");
//                Log::info($result);
//                $resultcount = count($result);
//                Log::info("resultcount");
//                Log::info($resultcount);

//                if ($resultcount < 5 ) {
//                    # code...
//                    Users::where('id', $user_id)->update([
//                        'tasks_counter' => $resultcount
//                    ]);
//                }
            }
            elseif($requestedTask == 'paid' || $requestedTask == 'skipped')
            {
                $result = DB::table('business_task as bt')
                    ->join('sys_task as st', 'bt.task_id', 'st.id')
                    ->where('user_id', $userId)
                    ->where('bt.status', $requestedTask)
                    ->get()->toArray();
            }
            else
            {
                $result = Category::with(
                    [
                        'tasks' => function ($q) use ($userData, $userId, $requestedTask)
                        {
                            $q->where('sys_status', 1);

                            if($requestedTask == 'done')
                            {
                                log::info('in done');
                                if($userData['subscriptionStatus']['subscription_expired'] == true || $userData['subscriptionStatus']['subscription_type'] == 'trial')
                                {
                                    log::info('in if');
                                    $q->whereIn('category',function($catQuery){
                                        $catQuery->select('id')->from('category')->where('show_to_paid', '=', 0);
                                    });
                                }
                                elseif(isActivePaid() == true)
                                {
                                    log::info('in elseif');
                                    $q->where(function($query) use($userId)
                                    {
                                        $query->whereIn('category',function($catQuery1){
                                            $catQuery1->select('id')->from('category')->where('show_to_paid', '=', 0);
                                        });

                                        $query->orWhereIn('category',function($catQuery) use ($userId) {
                                            $catQuery->select('category_id')->from('user_task_category')->where('user_id', '=', $userId);
                                        });
                                    });
                                }

                                $q->whereHas('marketingTasks', function(Builder $query) use ($userId, $requestedTask)
                                {
                                    $query->where('user_id', $userId);
                                    $query->where('status', $requestedTask);
                                });
//                                $q->with('campaignFeedback');
                                $q->with(['campaignFeedback' => function($q) use ($userId) {
                                    $q->where('user_id', $userId);
                                }]);

                                //  Log::info("abc");
                                //  Log::info(json_encode($abc));
                            }
                            elseif($requestedTask == 'all')
                            {
                                $q->with(['marketingTasks' =>function($query) use ($userId, $requestedTask)
                                {
                                    $query->where('user_id', $userId);
                                }]);
                            }
                            else
                            {
                                // for Ope
                                $q->whereDoesntHave('marketingTasks', function(Builder $query) use ($userId, $requestedTask)
                                {
                                    $query->where('user_id', $userId);
                                    $query->where('status', 'done');
                                });
                            }
                            $q->orderByRaw('ISNULL(impact), impact ASC');
                        }])->with(['userCategory' => function($q) use ($userId){
                    $q->where('user_id', $userId);
                }])
                            ->where('type', 'marketing-campaign')
                            ->orWhere('type', 'non-marketing-campaign')
                            ->where('status', 1)
                            ->orderByRaw('show_to_paid asc, ISNULL(priority), priority ASC')
                                ->get()->toArray();
            }


//            $result = Task::whereHas('marketingTasks', function (Builder $query) {
//                $query->where('user_id', 37);
//                $query->where('status', 'done');
//            })->get();


//            $posts = Category::whereHas('comments', function (Builder $query) {
//                $query->where('content', 'like', 'foo%');
//            }, '>=', 10)->get();

//            print_r(DB::getQueryLog());exit;
//            print_r($result);
//            exit;

            if(!empty($result))
            {
                return $this->helpReturn("Task list.", $result);
            }

            return $this->helpError(404, 'No task found.');
        }
        catch(Exception $e)
        {
            Log::info("list > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function recurringTasks($request, $userId = '')
    {
//        return $this->helpReturn("Task loaded.");
        try {
            // generateRecurringTasks
            $this->generateRecurringTasks($request, $userId);

            $status = $request->get('status');

            $result = DB::table('business_task as bt')
                ->join('sys_task as st', 'bt.task_id', 'st.id')
                ->where('user_id', $userId)
                ->where('bt.type', 'recurring')
                ->where('bt.status', $status)
                ->get()->toArray();

            foreach($result as $index => $row)
            {
                $todayDate = strtotime(Date('Y-m-d'));
                $taskAvailableDate = strtotime(Date('Y-m-d', strtotime(Date($row->available_clickable_at))));

                if ($todayDate >= $taskAvailableDate) {
                    $result[$index]->readyForDone = true;
                }
                else
                {
                    $result[$index]->readyForDone = false;
                }
            }
            return $this->helpReturn("Task loaded.", $result);
        } catch (Exception $e) {
            Log::info(" recurringTasks > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function generateRecurringTasks($request, $userId = '')
    {
        try {
            // generateRecurringTasks

            $result = Task::with(
                [
                    'marketingTasks' => function ($q) use ($userId) {
                        $q->where('user_id', $userId);
                        $q->orderBy('business_task_id', 'desc');
                    }
                ]
            )->wherenotnull('recurring_days')
                ->get()->toArray();

//            print_r($result);
//            exit;
            foreach($result as $task)
            {
                if(!empty($task['marketing_tasks'][0]) && $task['marketing_tasks'][0]['status'] == 'done')
                {
                    $bTask = $task['marketing_tasks'][0];

//                    print_r($task['marketing_tasks'][0]);
//                    exit;
                    $taskDay = Date('Y-m-d', strtotime($bTask['updated_at']));
                    $currentDay = Date('Y-m-d', time());

                    $diff=date_diff(date_create($taskDay),date_create($currentDay));
                    $dateDiff = $diff->format("%R%a");
//                    $dateDiff = $diff->format("%a");

                    $taskId = $task['id'];
//                    echo $taskId;
//                    exit;

                    // show recurring days before 3 days
                    $recurringDaysAvailableAT = $task['recurring_days'];
                    $recurringDays = $recurringDaysAvailableAT - 3;
//                    $recurringDays = 7-3;

                    /**
                     * date difference of created at and current time is greater than (recurring user date) then
                     * generate task in business_task
                     */
                    if($dateDiff >= $recurringDays)
                    {
                        Log::info("IF diff $dateDiff and $recurringDays of task $taskId and user $userId");
                        Log::info("recurringDaysAvailableAT $recurringDaysAvailableAT");
                        Log::info("taskDay $taskDay");

                        $availableAt = Date('Y-m-d',strtotime("+$recurringDaysAvailableAT day", strtotime($taskDay)));

                        // might be this is an open task. so make this entry as status
                        $businessTask = BusinessTask::create([
                            'task_id' => $taskId,
                            'user_id' => $userId,
                            'status' => 'open',
                            'type' => 'recurring',
                            'available_clickable_at' => $availableAt,
                        ]);
                    }
                    else
                    {
                        Log::info("else diff $dateDiff and $recurringDays of task $taskId and user $userId");
                    }


                    // now get the time to see the difference
//                    $bTask['']
                }
                else
                {
                    Log::info("no recurring task available " . $task['id']);
                }
            }

            return $this->helpReturn("Task load refreshed.");
        } catch (Exception $e) {
            Log::info(" generateRecurringTasks > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function taskDetail($request)
    {
        try {
            $userData = $this->sessionService->getAuthUserSession();
            $userId =  $userData['id'];
            $task = $request->get('id');

            if(!empty($request->get('source')))
            {
                $result = Category::where('id', $task)->first();

                if(!empty($result))
                {
                    $result['title'] = $result['name'];
//                    Log::info($result);
//
//                    if(!empty($category))
//                    {
//                        $result['category_type'] = $category['type'];
//                    }
//                    else
//                    {
//                        $result['category_type'] = '';
//                    }

                    return $this->helpReturn("result", $result);
                }
            }
            else
            {
//                Log::info('$task');
//                Log::info($task);
//                $result = Task::with('campaignFeedback')->find($task);
                log::info('here');
                $result = Task::with(['campaignFeedback' => function($q) use ($userId) {
                    $q->where('user_id', $userId);
                }])->find($task);

                if(!empty($result))
                {
//                    Log::info('$result');
//                    Log::info($result);

                    $category = Category::where('id', $result['category'])->first();
//                    Log::info('$category');
//                    Log::info($category);
                    if(!empty($category))
                    {
                        $result['category_type'] = $category['type'];
                        $result['mark_as_complete_check'] = $category['mark_as_complete_check'];
                    }
                    else
                    {
                        $result['category_type'] = '';
                    }
//                    Log::info('$result');
//                    Log::info($result);
                    return $this->helpReturn("Task.", $result);
                }
            }

            return $this->helpError(404, 'No task found.');
        }
        catch(Exception $e)
        {
            Log::info("taskDetail > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    /**
     * Update the Status of the Task
     * @param $request (token, status, id (business_task_id))
     * @return mixed
     */
    public function updateTaskStatus($request)
    {
//        return $this->helpError(3, 'Task has not any credits.');
//        return $this->helpError(404, 'You don\'t. have enough credits to make this purchase. Would you like to add some?');
        try
        {
            $userData = $this->sessionService->getAuthUserSession();

            $userId = $userData['id'];

            $taskId = $request->get('taskId');
            $status = strtolower($request->get('status'));

            $statusAllow = ['open', 'done', 'skipped', 'paid'];

            if($status == '')
            {
                return $this->helpError(404, 'Status should not be empty.');
            }

            if(in_array($status, $statusAllow) == "")
            {
                return $this->helpError(3, 'This status can not be set with task.');
            }

            $taskCredits = 0;
            $sub = new SubscriptionManagerEntity();
            if($status == 'paid')
            {
                $taskDetail = Task::where('id', $taskId)->get()->toArray();
                if(empty($taskDetail[0]['credits']))
                {
                    return $this->helpError(3, 'Task has not any credits.');
                }

                $taskCredits = $taskDetail[0]['credits'];

                // remainingcredits = purchasedcredits - usedcredits
                $credits = $sub->userCreditsBalance();

                if(empty($credits) || $credits < $taskCredits)
                {
                    return $this->helpError(404, 'You don\'t have enough credits to make this purchase. Would you like to add some?');
                }
            }

            $moduleId = '';
            /**
             *
             */
            if(!empty($request->get('businessTaskId')))
            {
                $businessTask = BusinessTask::where([
                    'business_task_id' => $request->get('businessTaskId'),
                    'user_id' => $userId
                ])->first();

                $moduleId = $request->get('businessTaskId');
            }
            else
            {
                // check if task id is available in Business Task Table.
                $businessTask = BusinessTask::where([
                    'task_id' => $taskId,
                    'user_id' => $userId
                ])->first();

                $moduleId = $businessTask['business_task_id'];
            }

//            Log::info("businessTask");
//            Log::info($businessTask);

            return DB::transaction(function () use ($taskCredits, $moduleId, $businessTask, $status, $taskId, $userId, $sub)
            {
                Log::info("businessTask");
                Log::info($businessTask);
                if(empty($businessTask))
                {
                    Log::info("IF block");
                    // might be this is an open task. so make this entry as status
                    $businessTask = BusinessTask::create([
                        'task_id' => $taskId,
                        'user_id' => $userId,
                        'status' => $status
                    ]);

                    Log::info('$moduleId of active ');
                    Log::info($businessTask);

                    $user = Users::find($userId);
                    $user->decrement('tasks_counter');

                    Log::info('tasks_counter');
                    Log::info($user->tasks_counter);

                    $moduleId = $businessTask['business_task_id'];

                    if($status != 'paid')
                    {
                        return $this->helpReturn("Status Action Changed.");
                    }
                }
                else
                {
                    $businessTask = BusinessTask::where(['business_task_id' => $moduleId])
                                    ->update(['status' => $status]);
                }

                Log::info('status is ' . $status);
                Log::info('$moduleId ' . $moduleId);
                if($status == 'paid' && !empty($moduleId))
                {
                    // take credits from user account.
                    $sub->manageCreditHistory($taskCredits, 'business_task', $moduleId);

                    $sub->updateCreditsSession();

                    $credits = ['creditsBalance' => $sub->userCreditsBalance()];

                    return $this->helpReturn("Status Action Changed.", $credits);
                }

                return $this->helpReturn("Status Action Changed.");
            });
        }
        catch(Exception $exception)
        {
            Log::info(" updateTaskStatus > " . $exception->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }
    public function sampleDetail(Request $request)
    {
        try {
            $userData = $this->sessionService->getAuthUserSession();

            $userId = $userData['id'];

            $campaign = $request->get('id');
            $result = Category::where('id', $campaign)->first();
            $sample['description'] = '';
            $sample['title'] = '';
            if(!empty($result))
            {
//                $sample['title'] = $result['name'];
                $sample['description'] = $result['sample_description'];
            }
            return $this->helpReturn("result", $sample);
        } catch (Exception $exception) {
            Log::info("sampleDetail > " . $exception->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }
}


