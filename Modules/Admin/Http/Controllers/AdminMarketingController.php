<?php

namespace Modules\Admin\Http\Controllers;

use App\Services\SessionService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Log;
use Modules\Admin\Entities\AdminCampaignEntity;
use Modules\Admin\Entities\AdminMarketingEntity;
use Modules\Admin\Entities\AdminTaskEntity;
use Modules\Admin\Entities\CampaignEntity;
use Modules\Admin\Models\Category;
use Modules\User\Entities\UserEntity;
use Redirect;

class AdminMarketingController extends Controller
{

    protected $data = []; // the information we send to the view

    protected $sessionService = '';
    protected $campaignEntity = '';
    protected $userEntity = '';
    protected $adminMarketingEntity = '';

    public function __construct()
    {
        $this->sessionService = new SessionService();
        $this->campaignEntity = new AdminCampaignEntity();
        $this->adminMarketingEntity = new AdminMarketingEntity();
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

            $result = $this->adminMarketingEntity->list();

            $this->data['title'] = 'List'; // set the page title

            $this->data['records'] = '';
            if($result['_metadata']['outcomeCode'] == 200)
            {
                $this->data['records'] = $result['records'];
            }

//            print_r($this->data['list']);
//            exit;

            return view('admin.marketing-pro.list', $this->data);
        }
        catch(Exception $e)
        {
            Log::info("index > " . $e->getMessage());
            return Redirect::route('adminDashboard')->withInput()->withMessage('Problem in access task Listing Page. Please try again.');
        }
    }

    /**
     * route: create-task
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        try {
            $userData = $this->sessionService->getAdminUserSession();

            $this->data['userData'] = $userData;
            $this->data['userId'] = $userData['id'];

            $this->data['pageTitle'] = 'Add Service';
            $this->data['action'] = route('pro.store');
            $this->data['records'] = [];

            return view('admin.marketing-pro.add-edit', $this->data);
//            return view('admin.marketing-pro.add', $this->data);
        }
        catch(Exception $e)
        {
            Log::info("taskcreate > " . $e->getMessage());
            return Redirect::route('adminDashboard')->withInput()->withMessage('Problem in access task Page. Please try again.');
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            $userData = $this->sessionService->getAdminUserSession();

            $this->data['userData'] = $userData;
            $this->data['userId'] = $userData['id'];
            $this->data['task_id'] = $id;
            $this->data['pageTitle'] = 'Edit Service';
//            $this->data['action'] = route('pro.update', $id);
            $this->data['action'] = route('pro.store');

            $taskResult = $this->adminMarketingEntity->getService($id);

            if ($taskResult['_metadata']['outcomeCode'] != 200) {
                return Redirect()->route('pro.list')->with('message', $taskResult['_metadata']['message']);
            }

            $this->data['records'] = $taskResult['records'];


            return view('admin.marketing-pro.add-edit', $this->data);
        }
        catch(Exception $e)
        {
            Log::info("edit > " . $e->getMessage());
            return Redirect::route('adminDashboard')->withInput()->withMessage('Problem in access service Page. Please try again.');
        }
    }

    public function addEdit(Request $request, $id)
    {
        try {
            $userData = $this->sessionService->getAdminUserSession();

            $this->data['userData'] = $userData;
            $this->data['userId'] = $userData['id'];
            $this->data['task_id'] = $id;

            $title = '';
            if(!empty($id))
            {
                $this->data['pageTitle'] = 'Edit Service';
                $taskResult = $this->adminMarketingEntity->getService($id);

                if ($taskResult['_metadata']['outcomeCode'] != 200) {
                    return Redirect()->route('pro.list')->with('message', $taskResult['_metadata']['message']);
                }

                $this->data['records'] = $taskResult['records'];
            }
            else
            {
                $this->data['pageTitle'] = 'Add Service';
            }

            return view('admin.marketing-pro.add-edit', $this->data);
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
            $responseData = $this->adminMarketingEntity->createUpdateService($request);
//            print_r($responseData);
//            exit;

            $responseMessage = $responseData['_metadata']['message'];

            if ($responseData['_metadata']['outcomeCode'] == 200) {
                // I've to redirect on edit task
//                print_r($responseData['records']['id']);exit;
                if(!empty($responseData['records']['id']))
                {
                    return Redirect()->route('pro.edit', $responseData['records']['id'])->with('messageCode', 200)->with('message', $responseMessage);
                }
                if(!empty($request->id))
                {
                    return Redirect()->route('pro.edit', $request->id)->with('messageCode', 200)->with('message', $responseMessage);
                }
                else
                {
                    return Redirect()->route('pro.list');
                }
            } else {
                $errors = [];
                foreach ($responseData['errors'] as $error) {
                    $errors[$error['map']] = $error['message'];
                }

                return Redirect()->back()->withInput()->withErrors($errors)->with('message', $responseMessage);
            }
        }
        catch(Exception $e)
        {
            Log::info($e->getMessage());
            return Redirect()->route('task.create')->withInput()->withMessage('Problem in submission. Please try again.');
        }
    }

    public function updateService(Request $request, $id)
    {
        $userData = $this->sessionService->getAdminUserSession();

        $this->data['userData'] = $userData;

        $responseData = $this->adminMarketingEntity->serviceUpdate($request, $id);

        $responseMessage = $responseData['_metadata']['message'];

        // all is good go inside.
        if ($responseData['_metadata']['outcomeCode'] == 200) {
            return Redirect()->route('pro.edit', $id)
                ->with('messageCode', 200)
                ->with('message', $responseMessage);
        } else {
            $errors = [];
            foreach ($responseData['errors'] as $error) {
                $errors[$error['map']] = $error['message'];
            }

            return Redirect()->route('pro.edit', $id)->withInput()->withErrors($errors)->with('message', $responseMessage);
        }
    }
}
