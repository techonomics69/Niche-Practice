<?php

namespace Modules\CRM\Http\Controllers;

use Log;
use Modules\Admin\Models\NewPatientEmailTemplateLogs;
use Session;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\User\Models\Users;
use App\Services\SessionService;
use Illuminate\Routing\Controller;
use Modules\CRM\Entities\CRMEntity;
use Modules\Business\Models\Countries;
use Modules\CRM\Entities\GetReviewsEntity;
use Modules\Business\Models\SendgridEventLogs;
use Modules\ThirdParty\Entities\ThirdPartyEntity;

class CRMController extends Controller
{


    protected $crmEntity;

    protected $sessionService;

    protected $data;

    public function __construct()
    {
        $this->crmEntity = new CRMEntity();

        $this->sessionService = new SessionService();
    }

    public function updateCustomer($id, Request $request)
    {
        return $this->crmEntity->updateCustomer($id, $request);
    }

    public function addCustomerSettings(Request $request)
    {
        return $this->crmEntity->addCustomerSettings($request);
    }

    public function customerSettingsList(Request $request)
    {
        return $this->crmEntity->customerSettingsList($request);
    }

    public function customersList(Request $request)
    {
        $this->data['moduleView'] = 'patient_contacts';
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;

        $data = [
            'screen' => 'web',
            'start' => 0,
            'length' => 1
        ];
        $responseData = $this->crmEntity->customersList($data);

//        print_r($responseData);
//        exit;

//        $this->data['records'] = $responseData['records']['customers']['data'];

        $this->data['countryCodes'] = Countries::all()->toArray();

        $thirdPartiesList = $this->crmEntity->getThirdParties($request);

        $this->data['third_parties_list'] = $thirdPartiesList['records'];

        $customerSettingsList = $this->crmEntity->customerSettingsList($request);

        $this->data['reviewRequestSettings'] = $customerSettingsList['records'];

//        $this->data['enable_get_reviews'] = $responseData['records']['enable_get_reviews'];
        $this->data['enable_get_reviews'] = 'disabled';
        // only_save, sent request
        $this->data['actionStatus'] = 'only_save';
        return view('layouts.crm-customers.crm-customers', $this->data);
    }

    public function addPatient(Request $request)
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;

        $this->data['moduleView'] = 'get_more_reviews';

        $data = ['screen' => 'web'];
        $responseData = $this->crmEntity->customersList($data);

        $this->data['records'] = $responseData['records']['customers']['data'];

        $this->data['countryCodes'] = Countries::all()->toArray();

        $thirdPartiesList = $this->crmEntity->getThirdParties($request);

        $this->data['third_parties_list'] = $thirdPartiesList['records'];

        $customerSettingsList = $this->crmEntity->customerSettingsList($request);

        $this->data['reviewRequestSettings'] = $customerSettingsList['records'];

        $this->data['enable_get_reviews'] = $responseData['records']['enable_get_reviews'];

        $current_user = Users::find($userData['id']);

        $this->data['viewedSendReviewInviteSettings'] = $current_user->viewed_send_review_invite_settings;

        return view('layouts.crm-customers.add-customers', $this->data);



    }

    public function customersListTest(Request $request)
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;

        $data = ['screen' => 'web'];
        $responseData = $this->crmEntity->customersList($data);

        $this->data['records'] = $responseData['records']['customers']['data'];

        $this->data['countryCodes'] = Countries::all()->toArray();

        $thirdPartiesList = $this->crmEntity->getThirdParties($request);

        $this->data['third_parties_list'] = $thirdPartiesList['records'];

        $customerSettingsList = $this->crmEntity->customerSettingsList($request);

        $this->data['reviewRequestSettings'] = $customerSettingsList['records'];

        $this->data['enable_get_reviews'] = $responseData['records']['enable_get_reviews'];

        return view('layouts.crm-customers.customers-list-selection', $this->data);
    }

    /**
     * route: requests-sent
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showRecipientList(Request $request)
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;
        $this->data['moduleView'] = 'review_request';

//        $userData = $this->sessionService->getAuthUserSession();
//        $this->data['businessList'] = $this->businessControl->businessList();
        $this->data['enable_get_reviews']='';
        $this->data['third_parties_list']=[];
        $this->data['reviewRequestSettings']=[];
        $this->data['countryCodes']=[];

        try {

            $this->data['templateLogs'] = NewPatientEmailTemplateLogs::where('send_by', $userData['id'])->get()->toArray();

            $reviewsEntity = new GetReviewsEntity();

            $recipientList = $reviewsEntity->getRecipientsList($request);

            $user = $userData['id'];
            $tiedWIth = 'doctor'.$user.'review';

            $env = config('apikeys.APP_ENV');

            if(strtolower($env) == 'production')
            {
                $category = 'review_production';
            }
            else
            {
                $category = 'review_staging';
            }

            $obj = SendgridEventLogs::where(['tied_up_with' => $tiedWIth, 'category' => $category]);

            $obj1 = clone $obj;
            $obj2 = clone $obj;

            $this->data['open'] = $obj->where('event', 'open')->count();
            $this->data['delivered'] = $obj1->where('event', 'delivered')->count();
            $this->data['click'] = $obj2->where('event', 'click')->count();

            $thirdPartyEntityObj = new ThirdPartyEntity();
            $negativeReviews = $thirdPartyEntityObj->getNegativeFeedback($userData['id']);

            $this->data['negativeFeedback'] = 0;
            if(!empty($negativeReviews['records']))
            {
                $this->data['negativeFeedback'] = count($negativeReviews['records']);
            }


            if ($recipientList['_metadata']['outcomeCode'] == 200) {
                try {
                    $thirdPartyResponse = $reviewsEntity->checkThirdParties($request);

                    if ($thirdPartyResponse['records']['flag'] == 0) {
                        $this->data['flag'] = 0;
                        $this->data['message'] = 'We detected that you have not added your business on Yelp, Tripadvisor, Facebook, or Google My Business. In order to use Get Reviews, you need to register your business in at least one of these sites.';
                    }
                } catch (Exception $e) {
                }

                /*  CRM API */
                /* ---------------------------------------------------*/

                $data = ['screen' => 'web'];
                $responseCRMData = $this->crmEntity->customersList($data);

                if ($responseCRMData['_metadata']['outcomeCode'] == 200) {
                    $this->data['enable_get_reviews'] = $responseCRMData['records']['enable_get_reviews'];
                }
                /* ---------------------------------------------------*/

                $this->data['countryCodes'] = Countries::all()->toArray();

                /* ---------------------------------------------------*/
                $thirdPartiesList = $this->crmEntity->getThirdParties($request);

                $this->data['third_parties_list'] = $thirdPartiesList['records'];

                /* ---------------------------------------------------*/

                $customerSettingsList = $this->crmEntity->customerSettingsList($request);

                $this->data['reviewRequestSettings'] = $customerSettingsList['records'];
                /* ---------------------------------------------------*/
                /*  CRM API */

                $this->data['records'] = $recipientList['records'];
                return view('layouts.crm-customers.recipient', $this->data);
            }
            else
            {
                $this->data['flag'] = 0;
                $this->data['message'] = 'Recipients not found';
                return view('layouts.crm-customers.recipient', $this->data);
            }
        }
        catch(Exception $e)
        {
            $this->data['flag'] = 0;
            $this->data['message'] = 'Problem in retrieving reviews list. Please try again later';
            return view('layouts.crm-customers.recipient', $this->data);
        }

    }

    public function getCustomersById(Request $request)
    {
        return $this->crmEntity->getCustomersById($request);
    }

    public function smsEmailSendCronJob(Request $request)
    {
        return $this->crmEntity->smsEmailSendCronJob($request);
    }

    public function updateCRMStats(Request $request)
    {
        return $this->crmEntity->updateCRMStats($request);
    }

    public function searchCustomers(Request $request)
    {
        return $this->crmEntity->searchCustomers($request);
    }

    public function getThirdParties(Request $request)
    {
        return $this->crmEntity->getThirdParties($request);
    }

    public function sendExistingCustomerReviewRequest(Request $request)
    {
        return $this->crmEntity->sendExistingCustomerReviewRequest($request);
    }

    public function getCRMCustomersList(Request $request)
    {
        try {
            $data = ['screen' => 'web'];
            $responseData = $this->crmEntity->customersList($data);

            $data = [
                "draw" => 1,
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => [],
            ];

            if (!empty($responseData['records']['customers']['data'])) {
                $data = $responseData['records']['customers'];
            }

            return $data;
        }
        catch(Exception $e)
        {
            Log::info("getCRMCustomersList > " . $e->getMessage());

            $data = [
                "draw" => 1,
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => [],
            ];

            return $data;
        }
    }

    public function addCustomer(Request $request)
    {
        $data['first_name'] = $request->get('first_name');
        $data['last_name'] = $request->get('last_name');
        $data['email'] = $request->get('email');
        $data['phone_number'] = $request->get('phone_number');
        $data['country'] = $request->get('country');
        $data['country_code'] = $request->get('country_code');

        if($request->get('enable_get_reviews')){
            $data['enable_get_reviews'] = $request->get('enable_get_reviews');
        }

        if($request->get('smart_routing')){
            $data['smart_routing'] = $request->get('smart_routing');
        }

        if($request->get('sending_option')){
            $data['sending_option'] = $request->get('sending_option');
        }

        if($request->get('review_site')){
            $data['review_site'] = $request->get('review_site');
        }

        if($request->get('reminder')){
            $data['reminder'] = $request->get('reminder');
        }
        if($request->get('customize_email')){
            $data['customize_email'] = $request->get('customize_email');
        }
        if($request->get('customize_sms')){
            $data['customize_sms'] = $request->get('customize_sms');
        }
        if($request->get('customer_id')){
            $data['customer_id'] = $request->get('customer_id');
        }
        if($request->get('varification_code')){
            $data['varification_code'] = $request->get('varification_code');
        }

        $responseData = $this->crmEntity->addCustomers($request);

        return $responseData;
    }

    public function deleteCustomer(Request $request)
    {
        return $this->crmEntity->deleteCustomer($request);
    }

    public function uploadCustomersCSV(Request $request)
    {
        return $this->crmEntity->addCustomersUsingFile($request);
    }

    public function uploadCustomersFile(Request $request)
    {
//        Log::info("file ");
//        Log::info($request->file);
        return $this->crmEntity->uploadCustomersFile($request);
    }

    public function CRMBackgroundService(Request $request)
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;

        return $this->crmEntity->smsEmailSendBackgroundJob($request);
    }

    public function sendEmailCampaign(Request $request)
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;

        return $this->crmEntity->sendMarketingEmails($request);
    }

    public function showAssetList(Request $request)
    {

        $userData = $this->sessionService->getAuthUserSession();

        $this->data['userData'] = $userData;

        $this->data['title'] = 'assets';

//        $this->data['title'] = 'assets';
//        $this->data['']

        $result = $this->crmEntity->showAssetList($request);
        $this->data['record'] = '';
        if($result['_metadata']['outcomeCode'] == 200 ) {
            $this->data['records'] = $result['records'];
        }
//        log::info('$result');
//        log::info($this->data['records']);

        return view('layouts.assets', $this->data);

    }

}
