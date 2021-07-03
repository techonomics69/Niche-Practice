<?php


namespace Modules\ThirdParty\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ThirdParty\Entities\OnlineDirectoryEntity;

class OnlineDirectoryController extends Controller
{

    protected $onlineListingEntity;

    public function __construct()
    {
        $this->onlineListingEntity = new OnlineDirectoryEntity();
    }

    public function getZocDocListingDetail(Request $request)
    {
        return $this->onlineListingEntity->getZocDocListingDetail($request);
    }

    public function getHealthGradeListingDetail(Request $request)
    {
        return $this->onlineListingEntity->getHealthGradeListingDetail($request);
    }

    public function getRateMdsListingDetail(Request $request)
    {
        return $this->onlineListingEntity->getRateMdsListingDetail($request);
    }

}