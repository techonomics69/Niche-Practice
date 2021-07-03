<?php

namespace Modules\Business\Http\Controllers;

use App\Services\SessionService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Business\Entities\BusinessEntity;
use Modules\Business\Entities\WebsiteEntity;
use Modules\Business\Models\Website;
use Modules\ThirdParty\Entities\ThirdPartyEntity;
use Modules\ThirdParty\Entities\TripAdvisorEntity;
use Log;

class CustomerController extends Controller
{
    protected $data;

    protected $businessEntity;

    protected $websiteEntity;

    protected $tripPartyEntity;

    protected $thirdPartyEntity;

    protected $sessionService;

    public function __construct()
    {
        $this->businessEntity = new BusinessEntity();
        $this->websiteEntity = new WebsiteEntity();
        $this->tripPartyEntity = new TripAdvisorEntity();
        $this->thirdPartyEntity = new ThirdPartyEntity();
        $this->sessionService = new SessionService();
    }

    public function websiteReportList(Request $request)
    {
//        log::info('customer controller request');
//        log::info($request);
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;
        $this->data['moduleView'] = 'web_audit';

        $businessResult = $this->businessEntity->userSelectedBusiness();


        $businessResult = $businessResult['records'];

        $this->data['businessResult'] = $businessResult;

        if(!empty($businessResult['website']))
        {
            $webObj = new WebsiteEntity();

            $webResult = $webObj->trackWebsiteStatus($request, true);

            if($webResult['_metadata']['outcomeCode'] == 200)
            {
                $webResult = $webResult['records'];
                $this->data['webResult'] = $webResult;
                $this->data['metaData'] = decSerBase($webResult['meta_data']);
                $this->data['keywordsCloud'] = decSerBase($webResult['keywords_cloud']);
                $this->data['pageSize'] = base64_decode($webResult['404_page']);
                $this->data['loadTime'] = decSerBase($webResult['load_time']);
            }
        }

        return view('layouts.website-report', $this->data);
    }
}
