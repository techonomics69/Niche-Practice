<?php


namespace Modules\ThirdParty\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ThirdParty\Entities\ContentDiscoveryEntity;

class ContentDiscoveryController extends Controller
{

    protected $contentDiscoveryEntity;

    public function __construct()
    {
        $this->contentDiscoveryEntity = new ContentDiscoveryEntity();
    }

    public function getViralContent(Request $request)
    {
        return $this->contentDiscoveryEntity->getSocialViralContent($request);
    }
}