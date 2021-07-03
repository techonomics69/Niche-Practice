<?php

namespace Modules\Admin\Http\Controllers;

use App\Services\SessionService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Log;
use Modules\Admin\Entities\AdminCampaignEntity;
use Modules\Admin\Entities\AdminTaskEntity;
use Modules\Admin\Entities\CampaignEntity;
use Modules\Admin\Models\Category;
use Modules\Admin\Models\MarketingAssociation;
use Modules\Admin\Models\Reports;
use Modules\User\Entities\UserEntity;
use Modules\User\Models\Users;
use Redirect;

class AdminTaskController extends Controller
{

    protected $data = []; // the information we send to the view

    protected $sessionService = '';
    protected $campaignEntity = '';
    protected $userEntity = '';
    protected $adminTaskEntity = '';

    public function __construct()
    {
        $this->sessionService = new SessionService();
        $this->campaignEntity = new AdminCampaignEntity();
        $this->adminTaskEntity = new AdminTaskEntity();
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
            $this->data['title'] = 'Task List';
            $userData = $this->sessionService->getAdminUserSession();

            $this->data['userData'] = $userData;
            $this->data['userId'] = $userData['id'];


            $result = $this->adminTaskEntity->list();

            $this->data['title'] = 'Task List'; // set the page title

            $this->data['records'] = '';
            if($result['_metadata']['outcomeCode'] == 200)
            {
                $this->data['records'] = $result['records'];
            }

            $catResult = $this->adminTaskEntity->getCategory();

            $this->data['categories'] = '';
            if($catResult['_metadata']['outcomeCode'] == 200)
            {
                $this->data['categories'] = $catResult['records'];
            }

//            print_r($this->data['list']);
//            exit;

            return view('admin.task.list', $this->data);
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

            $result = $this->adminTaskEntity->getCategory();

            $this->data['categories'] = '';
            if($result['_metadata']['outcomeCode'] == 200)
            {
                $this->data['categories'] = $result['records'];
            }
            $categories = $result['records'];
//            foreach($categories as $category)
//            {
//                echo($category['name']);exit;
//            }

            return view('admin.task.add-task', $this->data);
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

            $taskResult = $this->adminTaskEntity->getTask($id);

            if ($taskResult['_metadata']['outcomeCode'] != 200) {
                return Redirect()->route('task.list')->with('message', $taskResult['_metadata']['message']);
            }

            $this->data['records'] = $taskResult['records'];

            $result = $this->adminTaskEntity->getCategory();

            $this->data['categories'] = '';
            if($result['_metadata']['outcomeCode'] == 200)
            {
                $this->data['categories'] = $result['records'];
            }

            return view('admin.task.edit', $this->data);
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

//            log::info('$request');
//            log::info($request);
            $userData = $this->sessionService->getAdminUserSession();

            $this->data['userData'] = $userData;
            $this->data['userId'] = $userData['id'];

            $responseData = $this->adminTaskEntity->createTask($request);

            $responseMessage = $responseData['_metadata']['message'];

            if ($responseData['_metadata']['outcomeCode'] == 200) {
                // I've to redirect on edit task
                return Redirect()->route('task.list');
            } else {
                $errors = [];
                foreach ($responseData['errors'] as $error) {
                    $errors[$error['map']] = $error['message'];
                }

                return Redirect()->route('task.create')->withInput()->withErrors($errors)->with('message', $responseMessage);
            }
        }
        catch(Exception $e)
        {
            Log::info($e->getMessage());
            return Redirect()->route('task.create')->withInput()->withMessage('Problem in submission. Please try again.');
        }
    }

    public function updateTask(Request $request, $id)
    {
        $userData = $this->sessionService->getAdminUserSession();

        $this->data['userData'] = $userData;

        $responseData = $this->adminTaskEntity->taskUpdate($request, $id);

        $responseMessage = $responseData['_metadata']['message'];

        // all is good go inside.
        if ($responseData['_metadata']['outcomeCode'] == 200) {
            return Redirect()->route('task.edit', $id)
                ->with('messageCode', 200)
                ->with('message', $responseMessage);
        } else {
            $errors = [];
            foreach ($responseData['errors'] as $error) {
                $errors[$error['map']] = $error['message'];
            }

            return Redirect()->route('task.edit', $id)->withInput()->withErrors($errors)->with('message', $responseMessage);
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

    /**
     * route: admin/task/add-category
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function categoryPanel(Request $request)
    {
//        echo $request->segment(3
//        );
//        exit;
        $userData = $this->sessionService->getAdminUserSession();

        $this->data['userData'] = $userData;
        $this->data['userId'] = $userData['id'];
//        $ob
//        $nicheList =
        $this->data['association'] = '';
//        $association = $this->userEntity->getMarketingAssociation();
        $association = MarketingAssociation::orderBy('priority')->where('status', '=', 1)->get()->toArray();
//        print_r($association);
//        exit();
        if(!empty($association))
        {
            $this->data['association'] = $association;
        }
        $result = $this->userEntity->getIndustry();

        $this->data['records'] = '';
        if($result['_metadata']['outcomeCode'] == 200)
        {
            $this->data['records'] = $result['records'];
        }

        if($request->segment(3) == 'add-category') {
            return view('admin.task.add-list-category', $this->data);
        }
        else if($request->segment(3) == 'add-campaign' ) {
            return view('admin.task.add-months-campaign', $this->data);
        }
    }

    /**
     * route: category/{id}/edit
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editTaskCategory(Request $request, $id)
    {
        $userData = $this->sessionService->getAdminUserSession();

        $category = Category::find($id);

        $this->data['category'] = $category;
//        log::info('$category');
//        log::info($category->toArray() );

        $this->data['association'] = '';
        $association = $this->userEntity->getMarketingAssociation();
        if($association['_metadata']['outcomeCode'] == 200)
        {
            $this->data['association'] = $association['records'];
        }

        $result = $this->userEntity->getIndustry();
        $this->data['records'] = '';
        if($result['_metadata']['outcomeCode'] == 200)
        {
            $this->data['records'] = $result['records'];
        }
//        print_r($this->data['category']);
//        exit;

        $this->data['userData'] = $userData;
        $this->data['userId'] = $userData['id'];
        if($request->segment(3) == 'category'){
            return view('admin.task.edit-list-category', $this->data);
        }
        if($request->segment(3) == 'campaign' ){
            return view('admin.task.edit-month-campaign', $this->data);
        }
//        return view('admin.task.edit-list-category', $this->data);
    }

    /**
     * route: admin/task/category/list
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function taskCategoryPanel(Request $request)
    {
        $userData = $this->sessionService->getAdminUserSession();

        $this->data['userData'] = $userData;
        $this->data['userId'] = $userData['id'];
        $result = '';
        if($request->segment(3) == 'campaign'){
            $result = $this->adminTaskEntity->getCategory(1);
        }
        if($request->segment(3) == 'category'){
            $result = $this->adminTaskEntity->getCategory(2);
        }


        $this->data['list'] = '';
        if($result['_metadata']['outcomeCode'] == 200)
        {
            $this->data['list'] = $result['records'];
        }

//        Log::info($this->data['list']) ;
        if($request->segment(3) == 'category'){
            return view('admin.task.task-category-list', $this->data);
        }
        if($request->segment(3) == 'campaign' ){
            return view('admin.task.task-campaign-list', $this->data);
        }
//        return view('admin.task.task-category-list', $this->data);
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
    public function marketingAssociation(){

        $userData = $this->sessionService->getAdminUserSession();
        $this->data['userData'] = $userData;
        $this->data['userId'] = $userData['id'];
        $this->data['association'] = '';
        $association = $this->userEntity->getMarketingAssociation();
        if($association['_metadata']['outcomeCode'] == 200)
        {
            $this->data['association'] = $association['records'];
        }
        return view('admin.campaign.marketing-association', $this->data);
    }
    public function editMarketingAssociation(Request $request, $id) {

//        log::info('$id editMarketingAssociation');
//        log::info($id);
        $userData = $this->sessionService->getAdminUserSession();

        $data = MarketingAssociation::find($id);

//        log::info('$id editMarketingAssociation');

//        log::info($data);

        $this->data['association'] = $data;

        $this->data['userData'] = $userData;

        $this->data['userId'] = $userData['id'];

        return view('admin.campaign.edit-marketing-association', $this->data);
    }
    public function reports(Request $request) {

        $userData = $this->sessionService->getAdminUserSession();

        $this->data['title'] = 'Reports';

        $this->data['userData'] = $userData;

        $usersList = Users::where('id', '!=', 1)->get();

        $result = $this->adminTaskEntity->getReports();
//        print_r($result);
//        exit;

//        log::info('$result');
//        log::info($usersList);

        $this->data['usersList'] = $usersList;

        $this->data['records'] = $result['records'];

        return view('admin.reports.admin-reports', $this->data);

    }
    public function addReports(Request $request) {

        $userData = $this->sessionService->getAdminUserSession();

        $this->data['title'] = 'Reports';

        $this->data['userData'] = $userData;

        $guestData1 = Users::where('email', 'guest@nichepractice.com')->get()->toArray();
        $guestData2 = Users::where('email', 'guest1@nichepractice.com')->get()->toArray();
//        print_r($guestData1[0]['id']);
//        exit();
        $guest1 = $guestData1[0]['id'];
        $guest2 = $guestData2[0]['id'];
        $usersList = Users::where('id', '!=', 1)->where('id', '!=', $guest1)->where('id', '!=', $guest2)->get()->toArray();

//        log::info('$result');
//        log::info($usersList);

        $this->data['usersList'] = $usersList;

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $extension = $file->getClientOriginalExtension();
            $fileName = $file->getFilename() . '.' . $extension;
            $path = request()->file('file')->getRealPath();
            Storage::disk('local')->put($fileName, File::get($file));
        }

        return view('admin.reports.add-reports', $this->data);
    }
    public function editReport(Request $request) {
        $userData = $this->sessionService->getAdminUserSession();
        $this->data['title'] = 'Reports';
        $this->data['userData'] = $userData;


        $report = Reports::where('id', $request->id)->get()->toArray();
//        log::info('$report');
//        log::info($report);
        $this->data['report'] = $report;
        $guestData1 = Users::where('email', 'guest@nichepractice.com')->get()->toArray();
        $guestData2 = Users::where('email', 'guest1@nichepractice.com')->get()->toArray();
//        print_r($guestData1[0]['id']);
//        exit();
        $guest1 = $guestData1[0]['id'];
        $guest2 = $guestData2[0]['id'];
        $usersList = Users::where('id', '!=', 1)->where('id', '!=', $guest1)->where('id', '!=', $guest2)->get()->toArray();

        $this->data['usersList'] = $usersList;
        return view('admin.reports.edit-report', $this->data);
    }
    public function updateReport(Request $request) {
        $userData = $this->sessionService->getAdminUserSession();
        $this->data['title'] = 'Reports';
        $this->data['userData'] = $userData;

        $report = Reports::where('id', $request->id)->get()->toArray();
//        log::info('$report');
//        log::info($report);
        $this->data['report'] = $report;
        $usersList = Users::where('id', '!=', 1)->get();

        $this->data['usersList'] = $usersList;
        return view('admin.reports.edit-report', $this->data);
    }
    public function reportUser(Request $request) {

        $userData = $this->sessionService->getAdminUserSession();

        $this->data['title'] = 'Reports';

        $this->data['userData'] = $userData;

        $result = $this->adminTaskEntity->reportUser();

//        print_r($result);
//        exit;

        $this->data['list'] = '';
        if($result['_metadata']['outcomeCode'] == 200)
        {
            $this->data['list'] = $result['records'];
        }
        return view('admin.reports.report-user', $this->data);
    }

    public function editReportUser(Request $request) {
        $userData = $this->sessionService->getAdminUserSession();
        $this->data['title'] = 'Reports';
        $this->data['userData'] = $userData;


        $usersData = Users::where('id', $request->id)->get()->toArray();
//        log::info($usersData);


        $this->data['reportUser'] = $usersData;
        return view('admin.reports.edit-report-user', $this->data);
    }

    public function clientInfo(Request $request)
    {
        $userData = $this->sessionService->getAdminUserSession();
        $this->data['userData'] = $userData;
//        print_r($userData);
//        exit();
//         $userData = Users::get();
//        $this->data['displayUsers'] = $userData;

//        if ($request->ajax())
//        {
//            $data = Users::get();
//
//            return Datatables::of($data)
//                ->addIndexColumn()
//                ->make(true);
//        }
        return view('admin.task.client-info' , $this->data);

    }
    public function NotesInfo(Request $request)
        {
            $userData = $this->sessionService->getAdminUserSession();
            $this->data['userData'] = $userData;
    //        print_r($userData);
    //        exit();
    //         $userData = Users::get();
    //        $this->data['displayUsers'] = $userData;

    //        if ($request->ajax())
    //        {
    //            $data = Users::get();
    //
    //            return Datatables::of($data)
    //                ->addIndexColumn()
    //                ->make(true);
    //        }
            return view('admin.task.notes-info' , $this->data);

        }
    public function addClient(Request $request)
    {
        $userData = $this->sessionService->getAdminUserSession();
        $this->data['userData'] = $userData;

        return view('admin.task.addClient' , $this->data);

    }
    public function addInvoice(Request $request)
    {
        $userData = $this->sessionService->getAdminUserSession();
        $this->data['userData'] = $userData;

        return view('admin.task.addInvoice' , $this->data);
    }
 }
