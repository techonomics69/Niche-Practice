<?php

namespace Modules\Business\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Business\Entities\BusinessEntity;
use Modules\Business\Entities\CampaignEntity;
use Modules\Business\Entities\WebsiteEntity;
use Modules\CRM\Entities\CRMEntity;
use Modules\ThirdParty\Entities\ThirdPartyEntity;
use Modules\ThirdParty\Entities\TripAdvisorEntity;

class CampaignController extends Controller
{

    protected $businessEntity;

    protected $websiteEntity;

    protected $thirdPartyEntity;

    protected $campaignEntity;

    public function __construct()
    {
        $this->businessEntity = new BusinessEntity();
        $this->websiteEntity = new WebsiteEntity();
        $this->thirdPartyEntity = new ThirdPartyEntity();
        $this->campaignEntity = new CampaignEntity();
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('business::index');
    }

    public function home()
    {
        return "Welcome Dashboard";
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('business::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('business::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('business::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function thirdPartyConnect(Request $request)
    {
        return $this->businessEntity->thirdPartyConnect($request);
    }

    public function webConnect(Request $request)
    {
        $crmObj = new CRMEntity();
        return  $crmObj->addCustomers($request);
//        return $this->websiteEntity->getWebsiteDetails($request);

        return $this->thirdPartyEntity->thirdPartyReviews($request);
    }

    public function scheduleEmailCampaign(Request $request)
    {
        return $this->campaignEntity->scheduleEmailCampaign($request);
    }
}
