<?php

namespace Modules\Business\Http\Controllers;

use App\Mail\NotifyAdminNewUser;
use App\Services\SessionService;
use App\Traits\UserAccess;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Modules\Business\Entities\BusinessEntity;
use Modules\Business\Entities\KeywordEntity;
use Modules\Business\Entities\WebsiteEntity;
use Modules\CRM\Entities\CRMEntity;
use Modules\ThirdParty\Entities\ThirdPartyEntity;
use Modules\ThirdParty\Entities\TripAdvisorEntity;
use Exception;
use Log;
use Symfony\Component\HttpKernel\Exception\HttpException;

class BusinessController extends Controller
{
    use UserAccess;

    protected $data;

    protected $sessionService;

    protected $keywordEntity;

    protected $businessEntity;

    protected $websiteEntity;

    protected $thirdPartyEntity;


    public function __construct()
    {
        $this->sessionService = new SessionService();
        $this->businessEntity = new BusinessEntity();
        $this->keywordEntity = new KeywordEntity();
        $this->websiteEntity = new WebsiteEntity();
        $this->thirdPartyEntity = new ThirdPartyEntity();
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

    public function testWebHookLogs(Request $request)
    {
//        HttpException::class
//        throw new Exception("Can't connect to db.", 400);

//        throwException(400);

        Log::info(" testWebHookLogs > ");
        Log::info($request->all());
    }

    public function sendgridWebHookLogs(Request $request)
    {
//        HttpException::class
//        throw new Exception("Can't connect to db.", 400);

//        throwException(400);

        Log::info(" sendgridWebHookLogs > ");
//        Log::info($request->all());

        if(empty($request->get('fromTransfer')) || $request->get('fromTransfer') != 'sendgrid')
        {
            return $this->helpError(3, 'You\'re not authorized to do this action.');
//            return false;
        }

        Log::info(" sendgridWebHookLogs processed > ");

        return $this->businessEntity->sendgridWebHookLogs($request);
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


    public function mailTest()
    {
        $registered = Date('d-M-Y H:i', strtotime('2020-04-27 06:42:25'));
        $firstName = 'aa';
        $lastName = 'adn';
        $BusinessName = 'Test Business';
        $Useremail = 'daakbk';
        $niche = 'niche';
        $plan = 'Plan';
        $registered = 1;

        $mail = Mail::to('fsd.ark03@gmail.com')
            ->send(new NotifyAdminNewUser($firstName, $lastName, $BusinessName, $Useremail, $registered, $niche, $plan));

//         dd($mail);
        if (Mail::failures()) {
//        if ($mail) {
            Log::info('email failed');
            return 'email failed';
        }else{
            Log::info('email success');
            return 'email success';
        }
    }

    public function businessKeywords(Request $request)
    {
        try {
            $userData = $this->sessionService->getAuthUserSession();
            $this->data['userData'] = $userData;
            $this->data['moduleView'] = 'keywords';

            $this->data['userBusiness'] = $this->businessEntity->userSelectedBusiness()['records'];

//            print_r($this->data['userBusiness']);
//            exit;


            $response = $this->keywordEntity->getSelectedKeyword($request);

//            print_r($response);
//            exit;

            $responseCode = $response['_metadata']['outcomeCode'];
            $responseMessage = $response['_metadata']['message'];

            // all is good go inside.
            if ($responseCode == 200 || $responseCode == 404) {
                // to confirm where am I.
                $this->data['pageTitle'] = 'Keywords';
                $this->data['requestedUrl'] = $request->url();
                $this->data['keywords'] = '';

                $this->data['foundError'] = false;

                if (!empty($response['records']['keywordsData'])) {
                    $this->data['keywords'] = $response['records']['keywordsData'];
                }

                return view('layouts.keywords.keywords', $this->data);
            } else {
                return Redirect()->route('home')->with('message', 'An unknown error has occurred. Please try again.');
            }

        }
        catch(Exception $e)
        {
            Log::info(" businessKeywords > " . $e->getMessage());
            print_r($e->getMessage());
            exit;
//            return Redirect()->route('business-directory', $id)->with('message', 'Some Problem found. Unable to complete business flow. Please try again.');
        }
    }
}
