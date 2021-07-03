<?php

namespace Modules\Business\Http\Controllers;

use App\Services\SessionService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Business\Entities\BusinessEntity;
use Modules\Business\Entities\WebsiteEntity;
use Modules\ThirdParty\Entities\ThirdPartyEntity;
use Modules\ThirdParty\Entities\TripAdvisorEntity;
use Log;

class ReviewsController extends Controller
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

    /**
     * route: monitor-your-reviews
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function reviewsList(Request $request)
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;

        $this->data['moduleView'] = 'reviews';
        $this->data['reviewsResult'] = $this->thirdPartyEntity->thirdPartyReviews($request);

        $negativeReviews = $this->thirdPartyEntity->getNegativeFeedback($userData['id']);

        $this->data['negativeReviews'] = '';
        if ($negativeReviews['_metadata']['outcomeCode'] == 200) {
//            $negativeRec = $negativeReviews['records'];
            $this->data['negativeReviews'] = $negativeReviews['records'];

//            if(!empty($negativeRec))
//            {
//                foreach()
//            }
        }

//        print_r($this->data['reviewsResult']);
//        exit;
        return view('layouts.reviews', $this->data);
    }

    public function customizeInvitationLayout(Request $request)
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;

        return view('layouts.customize-invitation', $this->data);
    }

    public function thirdPartyAppsList(Request $request)
    {

        $this->data['moduleView'] = 'review_sites';
        if ($request->has('accessToken') && $request->get('type') == 'facebook') {
            // set analytics token in session to make request.
            $this->sessionService->setOAuthToken(
                [
                    'businessAccessToken' => $request->get('accessToken'),
                    'accessTokenType' => $request->get('type'),
                ]
            );
            // redirecting to url because we don't want to show query string parameter in url
            return redirect()->to($request->url());
        }
        $socialToken = $this->sessionService->getOAuthToken();

        $this->data['socialToken'] = '';
        if(!empty($socialToken['accessTokenType']) && $socialToken['accessTokenType'] == 'facebook')
        {
            $this->data['socialToken'] = !empty($socialToken['businessAccessToken']) ? 1 : 0;
        }

        $this->data['accessTokenType'] = !empty($socialToken['accessTokenType']) ? $socialToken['accessTokenType'] : '';

        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;

        $businessData = $this->businessEntity->businessDirectoryList($request);

        $sources = thirdPartySources();

        if(!empty($businessData['records']['businessIssues']))
        {
            $sourceExist = array_column($businessData['records']['businessIssues'], 'type');
        }
//print_r($sourceExist);
//        exit;
        foreach($sources as $index => $source)
        {
            $matchedStatus = 0;

            if(!empty($sourceExist))
            {
//                $source = strtolower($source);

                $source = ucwords(strtolower($source));

//                if(strtolower($source) == 'healthgrades')
//                {
//                    $source = 'Healthgrades';
//                }
//                elseif(strtolower($source) == 'ratemd')
//                {
//                    $source = 'Ratemd';
//                }


                $matched = array_search($source, $sourceExist);

//                $sources[$index] =
                if($matched !== false)
                {
                    $appBusiness = $businessData['records']['businessIssues'][$matched];

                    if($appBusiness['type'] == $source && !empty($appBusiness['name']))
                    {
                        $matchedStatus = 1;
                        $sources[$index] = ['name' => $source, 'status' => 'connected'];
                    }
                }
            }


            if($matchedStatus == 0)
            {
                $sources[$index] = ['name' => $source, 'status' => 'not_connected'];
            }
//            if($source)
        }
//echo "sources";
//        print_r($sources);
//        exit;
        $this->data['sources'] = $sources;

        return view('layouts.connect-apps', $this->data);
    }
}
