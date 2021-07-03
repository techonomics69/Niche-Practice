<?php

namespace Modules\Business\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Business\Entities\GoogleSearchEntity;


class GoogleSearchController extends Controller
{
    protected $googleEntity;

    public function  __construct()
    {
        $this->googleEntity = new GoogleSearchEntity();
    }

    /**
     * @api {post} /google-search/get-search-result [ RF-05-01 ] Google Search Results
     * @apiVersion 1.0.0
     * @apiName Google Search Results
     * @apiGroup Google Search
     * @apiParam {String} searchFor
     * @apiPermission Secured
     * @apiDescription Search keyword and get the top 5 results
     */


    public function getSearchResult(Request $request)
    {
        return $this->googleEntity->getSearchResult($request);
    }

    public function testTimeFormat(Request $request)
    {
        return $this->googleEntity->testTimeFormat($request);
    }
}
