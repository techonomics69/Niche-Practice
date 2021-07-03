<?php

namespace Modules\Admin\Http\Controllers;

use App\Services\SessionService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Log;
use Modules\Admin\Entities\AdminCampaignEntity;
use Modules\Admin\Entities\AdminPromotionEntity;
use Modules\Admin\Entities\CampaignEntity;
use Modules\Business\Models\PromotionTemplate;
use Modules\User\Entities\UserEntity;
use Redirect;

class AdminPromotionController extends Controller
{

    protected $data = []; // the information we send to the view

    protected $sessionService = '';
    protected $campaignEntity = '';
    protected $promotionEntity = '';
    protected $userEntity = '';

    public function __construct()
    {
        $this->sessionService = new SessionService();
        $this->campaignEntity = new AdminCampaignEntity();
        $this->promotionEntity = new AdminPromotionEntity();
        $this->userEntity = new UserEntity();
    }

    public function list()
    {
        $userData = $this->sessionService->getAdminUserSession();

        $this->data['userData'] = $userData;

        $request = request();
        $promotionUrl = $request->segment(3);
        if($promotionUrl == 'list'){
            $this->data['title'] = 'Promotions List'; // set the page title
        }else{
            $this->data['title'] = 'Guest Promotions List';
        }

        $responseData = $this->promotionEntity->getTemplate();

        $this->data['records'] = $responseData['records'];

        return view('admin.promotion.list', $this->data);
    }

    public function promotionCampaign(Request $request, $templateId = '')
    {
        $userData = $this->sessionService->getAdminUserSession();
//        if( $userData['id'] == 1 ) {
//
//        }
        $this->data['userData'] = $userData;
        $this->data['userId'] = $userData['id'];
        $this->data['templateId'] = $templateId;

        $result = $this->userEntity->getIndustry();

        $this->data['industry'] = '';
        if($result['_metadata']['outcomeCode'] == 200)
        {
            $this->data['industry'] = $result['records'];
        }

        $this->data['promotionData'] = [];
        $this->data['templateId'] = $templateId;

        $promotionData = '';
        $this->data['promotionData'] = '';

        if(!empty($templateId))
        {
            if( $userData['id'] == 1 ) {
                $promotionData  = PromotionTemplate::where('id', $templateId)->first();
            }
            else {
                $promotionData  = PromotionTemplate::where('user_id', '=', $userData['id'])->where('id', $templateId)->first();
            }
            if(! empty ($promotionData) ) {
                $promotionDetails = $promotionData->toArray();
                $this->data['promotionData'] = $promotionDetails;
            }
            else {
//            return view('errors.404');
                return redirect()->route('admin.promotions.list')->withMessage('Promotion Not Found.');
            }
        }

//        $this->data['promotionData'];
//        print_r($promotionData);
//        exit();
        // dd($this->data);
        return view('admin.promotion.promotion-template', $this->data);
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
}
