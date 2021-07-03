<?php

namespace Modules\Admin\Http\Controllers;

use App\Services\SessionService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Log;
use Modules\Admin\Entities\AdminCampaignEntity;
use Modules\Admin\Entities\CampaignEntity;
use Modules\User\Entities\UserEntity;
use Modules\User\Models\Users;
use Redirect;

class CampaignController extends Controller
{

    protected $data = []; // the information we send to the view

    protected $sessionService = '';
    protected $campaignEntity = '';
    protected $userEntity = '';

    public function __construct()
    {
        $this->sessionService = new SessionService();
        $this->campaignEntity = new AdminCampaignEntity();
        $this->userEntity = new UserEntity();
    }

    public function list()
    {
        $userData = $this->sessionService->getAdminUserSession();

        $this->data['userData'] = $userData;

        $this->data['title'] = 'Campaign List'; // set the page title

        $responseData = $this->campaignEntity->getTemplate();

        $this->data['records'] = $responseData['records'];

//        print_r($responseData['records']);
//        exit;
        return view('admin.campaign.list', $this->data);
    }

    /**
     * route: new-patient-templates
     * name: admin.new-patient-emails
     */
    public function adminPatientEmailTemplates()
    {
        $userData = $this->sessionService->getAdminUserSession();

        $this->data['userData'] = $userData;

        $this->data['title'] = 'New Patient Templates List';

        $responseData = $this->campaignEntity->getTemplate('patient_campaign');

        $this->data['records'] = $responseData['records'];

        return view('admin.campaign.admin-patient-templates-list', $this->data);
    }

    public function categoryPanel(Request $request)
    {
        $userData = $this->sessionService->getAdminUserSession();

        $this->data['userData'] = $userData;
        $this->data['userId'] = $userData['id'];

        $result = $this->campaignEntity->getCategory();

        $this->data['list'] = '';
        if($result['_metadata']['outcomeCode'] == 200)
        {
            $this->data['list'] = $result['records'];
        }

        return view('admin.campaign.add-list-category', $this->data);
    }

    public function typePanel(Request $request)
    {
        $userData = $this->sessionService->getAdminUserSession();

        $this->data['userData'] = $userData;
        $this->data['userId'] = $userData['id'];

        $result = $this->campaignEntity->getType();

        $this->data['list'] = '';
        if($result['_metadata']['outcomeCode'] == 200)
        {
            $this->data['list'] = $result['records'];
        }

        return view('admin.campaign.add-list-type', $this->data);
    }

    public function emailCampaign(Request $request, $templateId = '')
    {
        $userData = $this->sessionService->getAdminUserSession();
        $this->data['userData'] = $userData;
        $this->data['userId'] = $userData['id'];
        $this->data['templateId'] = $templateId;

        $result = $this->userEntity->getIndustry();

        $category = $this->campaignEntity->getCategory();
//        log::info('$category');
//        log::info($category);
        if($category['_metadata']['outcomeCode'] == 200)
        {
            $this->data['categories'] = $category['records'];
        }

        $type = $this->campaignEntity->getType();


        if($type['_metadata']['outcomeCode'] == 200)
        {
            $this->data['types'] = $type['records'];
        }

        $this->data['industry'] = '';
        if($result['_metadata']['outcomeCode'] == 200)
        {
            $this->data['industry'] = $result['records'];
        }

        $userEntity = new UserEntity();
        $usersList = $userEntity->getUsers();;

        $this->data['usersList'] = $usersList;

        return view('admin.campaign.email-template', $this->data);
    }

    public function patientEmailBuilder(Request $request, $templateId = '')
    {
        $userData = $this->sessionService->getAdminUserSession();
        $this->data['userData'] = $userData;
        $this->data['userId'] = $userData['id'];
        $this->data['templateId'] = $templateId;

        $result = $this->userEntity->getIndustry();

        $category = $this->campaignEntity->getCategory();

        if($category['_metadata']['outcomeCode'] == 200)
        {
            $this->data['categories'] = $category['records'];
        }

        $type = $this->campaignEntity->getType();

        if($type['_metadata']['outcomeCode'] == 200)
        {
            $this->data['types'] = $type['records'];
        }

        $this->data['industry'] = '';
        if($result['_metadata']['outcomeCode'] == 200)
        {
            $this->data['industry'] = $result['records'];
        }

        $usersList = Users::where('id', '!=', 1)->get();

        $this->data['usersList'] = $usersList;

        return view('admin.campaign.admin-patient-email-builder', $this->data);
    }

    public function emailCampaignDemo(Request $request, $templateId = '')
    {
        $this->data['showHeader'] = true;
        $this->data['userId'] = 1;

        return view('admin.campaign.email-template-demo-custom', $this->data);
    }

    public function emailCampaignDemo2(Request $request, $templateId = '')
    {
        $this->data['showHeader'] = true;
        $this->data['userId'] = 1;

        return view('admin.campaign.email-template-demo-topol', $this->data);
    }

    public function industryPanel(Request $request)
    {
        $userData = $this->sessionService->getAdminUserSession();

        $this->data['userData'] = $userData;
        $this->data['userId'] = $userData['id'];

        $result = $this->userEntity->getIndustry();

        $this->data['industry'] = '';
        if($result['_metadata']['outcomeCode'] == 200)
        {
            $this->data['industry'] = $result['records'];
        }

//        print_r($this->data['industry'][0]['niches']->toArray());
//        exit;

        return view('admin.niches.add-industry', $this->data);
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
    public function addNiche(Request $request)
    {
        $userData = $this->sessionService->getAdminUserSession();

        $this->data['userData'] = $userData;
        $this->data['userId'] = $userData['id'];

        $result = $this->userEntity->getNiches();

        $this->data['industry'] = '';
        if($result['_metadata']['outcomeCode'] == 200)
        {
            $this->data['industry'] = $result['records'];
        }
        return view('admin.niches.add-niche', $this->data);
    }
}
