<?php

namespace Modules\Admin\Http\Controllers;

use Log;
use Redirect;
use Exception;
use Illuminate\Http\Request;
use Modules\Admin\Models\Alert;
use App\Services\SessionService;
use App\Http\Controllers\Controller;
use Modules\User\Entities\UserEntity;
use Modules\Admin\Entities\CampaignEntity;
use Modules\Admin\Entities\AdminTaskEntity;
use Modules\Admin\Entities\AdminAlertEntity;
use Modules\Admin\Entities\AdminCampaignEntity;

class AdminAlertController extends Controller
{

    protected $data = []; // the information we send to the view

    protected $sessionService = '';
    protected $campaignEntity = '';
    protected $userEntity = '';
    protected $adminTaskEntity = '';
    protected $adminAlertEntity = '';

    public function __construct()
    {
        $this->sessionService = new SessionService();
        $this->campaignEntity = new AdminCampaignEntity();
        $this->adminTaskEntity = new AdminTaskEntity();
        $this->adminAlertEntity = new AdminAlertEntity();
        $this->userEntity = new UserEntity();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $this->data['title'] = 'List';
            $userData = $this->sessionService->getAdminUserSession();

            $this->data['userData'] = $userData;
            $this->data['userId'] = $userData['id'];

            $result = $this->adminAlertEntity->list();

            $this->data['title'] = 'List'; // set the page title

            $this->data['records'] = '';
            if($result['_metadata']['outcomeCode'] == 200)
            {
                $this->data['records'] = $result['records'];
            }

            return view('admin.alert.list', $this->data);

        }
        catch(Exception $e)
        {
            Log::info("index > " . $e->getMessage());
            return Redirect::route('adminDashboard')->withInput()->withMessage('Problem in access task Listing Page. Please try again.');
        }
    }

    public function helpList()
    {
        try {
            $this->data['title'] = 'Help';
            $userData = $this->sessionService->getAdminUserSession();

            $this->data['userData'] = $userData;
            $this->data['userId'] = $userData['id'];

//            echo "f";
//            exit;
            $result = $this->adminAlertEntity->helpAlertsList();

            $this->data['title'] = 'List'; // set the page title

            $this->data['records'] = '';
            if($result['_metadata']['outcomeCode'] == 200)
            {
                $this->data['records'] = $result['records'];
            }

            return view('admin.alert.help-list', $this->data);
        }
        catch(Exception $e)
        {
            Log::info("index > " . $e->getMessage());
            return Redirect::route('adminDashboard')->withInput()->withMessage('Problem in access task Listing Page. Please try again.');
        }
    }

    public function create()
    {
        try {
            $userData = $this->sessionService->getAdminUserSession();

            $this->data['userData'] = $userData;
            $this->data['userId'] = $userData['id'];

            $this->data['categories'] = '';

            $module = appModule();
            if(!empty($moduleList['records']))
            {
//                $module = appModule();
//                $moduleSlug = array_column($module, 'id');

//                $availableModules = array_diff($moduleSlug, $moduleList['records']);
//                print_r($availableModules);
//                exit;
            }
//            foreach($availableModules as $index => $moduleRow)
//            {
//                print_r($availableModules[$index]);
//            }
//exit;
//            $this->data['module'] = $availableModules;

//            if($result['_metadata']['outcomeCode'] == 200)
//            {
//                $this->data['categories'] = $result['records'];
//            }
//            $categories = $result['records'];
//            foreach($categories as $category)
//            {
//                echo($category['name']);exit;
//            }

            return view('admin.alert.add-alert', $this->data);
        }
        catch(Exception $e)
        {
            Log::info("taskcreate > " . $e->getMessage());
            return Redirect::route('adminDashboard')->withInput()->withMessage('Problem in access task Page. Please try again.');
        }
    }

    public function editTask(Request $request, $id)
    {
        try {
            $userData = $this->sessionService->getAdminUserSession();

            $this->data['userData'] = $userData;
            $this->data['userId'] = $userData['id'];
            $this->data['task_id'] = $id;

            $taskResult = $this->adminAlertEntity->getTask($id);

            if ($taskResult['_metadata']['outcomeCode'] != 200) {
                return Redirect()->route('alert.list')->with('message', $taskResult['_metadata']['message']);
            }

//            print_r($taskResult);
//            exit;

            $this->data['records'] = $taskResult['records'];

//            $result = $this->adminTaskEntity->getCategory();

            $this->data['categories'] = '';
//            if($result['_metadata']['outcomeCode'] == 200)
//            {
//                $this->data['categories'] = $result['records'];
//            }

            return view('admin.alert.edit', $this->data);
        }
        catch(Exception $e)
        {
            Log::info("taskcreate > " . $e->getMessage());
            return Redirect::route('adminDashboard')->withInput()->withMessage('Problem in access task Page. Please try again.');
        }
    }

    public function store(Request $request)
    {
        try {
            $userData = $this->sessionService->getAdminUserSession();

            $this->data['userData'] = $userData;
            $this->data['userId'] = $userData['id'];

            $responseData = $this->adminAlertEntity->createTask($request);

            $responseMessage = $responseData['_metadata']['message'];

            if ($responseData['_metadata']['outcomeCode'] == 200) {
                // I've to redirect on edit task
                return Redirect()->route('alert.list');
            } else {
                $errors = [];
                foreach ($responseData['errors'] as $error) {
                    $errors[$error['map']] = $error['message'];
                }

                return Redirect()->route('alert.create')->withInput()->withErrors($errors)->with('message', $responseMessage);
            }
        }
        catch(Exception $e)
        {
            Log::info(" alert store " . $e->getMessage());
            return Redirect()->route('alert.create')->withInput()->withMessage('Problem in submission. Please try again.');
        }
    }

    public function updateTask(Request $request, $id)
    {

        $userData = $this->sessionService->getAdminUserSession();

        $this->data['userData'] = $userData;

        $responseData = $this->adminAlertEntity->taskUpdate($request, $id);

        $responseMessage = $responseData['_metadata']['message'];
        $task = Alert::find($id);

        // all is good go inside.
        if ($responseData['_metadata']['outcomeCode'] == 200) {
            return Redirect()->route('alert.edit', $id)
                        ->with('messageCode', 200)
                        ->with('message', $responseMessage);
                // if ($task->module) {
                //     return Redirect()->route('alert.help.list', $id)
                //         ->with('messageCode', 200)
                //         ->with('message', $responseMessage);
                // } else {
                //     return Redirect()->route('alert.list', $id)
                //         ->with('messageCode', 200)
                //         ->with('message', $responseMessage);
                // }

        } else {
            $errors = [];
            foreach ($responseData['errors'] as $error) {
                $errors[$error['map']] = $error['message'];
            }

            return Redirect()->route('alert.edit', $id)->withInput()->withErrors($errors)->with('message', $responseMessage);
        }
    }

    public function emailCampaign(Request $request, $templateId = '')
    {
        $userData = $this->sessionService->getAdminUserSession();
        $this->data['userData'] = $userData;
        $this->data['userId'] = $userData['id'];
        $this->data['templateId'] = $templateId;

        $result = $this->userEntity->getIndustry();

        $this->data['industry'] = '';
        if($result['_metadata']['outcomeCode'] == 200)
        {
            $this->data['industry'] = $result['records'];
        }


        return view('admin.campaign.email-template', $this->data);
    }

    public function industryNichesList(Request $request)
    {
        $userData = $this->sessionService->getAdminUserSession();

        $this->data['userData'] = $userData;
        $this->data['userId'] = $userData['id'];

        $result = $this->userEntity->getIndustry();

//        print_r($result['records']);
//        exit;

        $this->data['industry'] = '';
        if($result['_metadata']['outcomeCode'] == 200)
        {
            $this->data['records'] = $result['records'];
        }


        return view('admin.niches.list', $this->data);
    }
}
