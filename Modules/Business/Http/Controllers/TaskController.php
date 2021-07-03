<?php

namespace Modules\Business\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Models\BusinessTask;
use Modules\Admin\Models\Task;
use Modules\User\Models\UserMeta;
use Modules\User\Models\Users;
use App\Services\SessionService;
use Illuminate\Routing\Controller;
use Modules\CRM\Entities\CRMEntity;
use Modules\Business\Entities\TaskEntity;
use Modules\Business\Entities\WebsiteEntity;
use Modules\Business\Entities\BusinessEntity;
use Modules\ThirdParty\Entities\ThirdPartyEntity;
use Modules\ThirdParty\Entities\TripAdvisorEntity;
use DB;
use Log;


class TaskController extends Controller
{

    protected $businessEntity;

    protected $websiteEntity;

    protected $thirdPartyEntity;

    protected $taskEntity;

    protected $sessionService;

    protected $data = [];


    public function __construct()
    {
        $this->sessionService = new SessionService();
        $this->businessEntity = new BusinessEntity();
        $this->websiteEntity = new WebsiteEntity();
        $this->thirdPartyEntity = new ThirdPartyEntity();
        $this->taskEntity = new TaskEntity();
    }

    /**
     * route: task-list
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function siteTasks(Request $request)
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;
        $userId = $userData['id'];
        $this->data['moduleView'] = 'task_list';

        $this->data['suggessionManager'] = UserMeta::where('user_id', $userId)->first();

        $requestedTask = 'open';

        $user = Users::find($userId);

        $welcome_video_seen = $user->welcome_video_seen;
        $this->data['welcome_video_seen'] = $welcome_video_seen;

        $this->data['business_task_open'] = 0;
        $this->data['business_task_skipped'] = 0;
        $this->data['business_task_done'] = 0;

        return view('layouts.tasks.list', $this->data);
    }
    public function teams(){
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;
        return view('layouts.teams', $this->data);
    }
    public function csv(){
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;
        return view('layouts.csv', $this->data);
    }
}

