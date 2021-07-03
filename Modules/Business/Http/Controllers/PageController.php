<?php

namespace Modules\Business\Http\Controllers;

use Log;
use Exception;
use App\Mail\ContactMail;
use App\Mail\ReferalMail;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Entities\AdminMarketingEntity;
use Modules\Admin\Models\Category;
use Modules\Admin\Models\MarketingAssociation;
use Modules\Business\Models\BusinessCitationList;
use Modules\Business\Models\EmailTemplate;
use Modules\Business\Models\Niches;
use Modules\Business\Models\UnsubscribeList;
use Modules\User\Models\CreditsHistory;
use Modules\User\Models\Users;
use Illuminate\Validation\Rule;
use App\Services\SessionService;
use Modules\CRM\Models\Recipient;
use Illuminate\Routing\Controller;
use Modules\CRM\Entities\CRMEntity;
use Illuminate\Support\Facades\Mail;
use Modules\Business\Models\Contact;
use Modules\Business\Models\Business;
use Modules\Business\Models\Countries;
use Modules\User\Models\Smsrequestlog;
use Modules\User\Models\Emailrequestlog;
use Modules\Business\Models\Referalemail;
use Modules\Business\Models\SocialProfile;
use Modules\CRM\Entities\GetReviewsEntity;
use Modules\Business\Entities\WebsiteEntity;
use Modules\Business\Entities\BusinessEntity;
use Modules\Business\Entities\CampaignEntity;
use Modules\ThirdParty\Entities\SocialEntity;
use Modules\Business\Entities\PromotionEntity;
use Modules\Business\Models\PromotionTemplate;
use Modules\Admin\Entities\AdminCampaignEntity;
use Modules\ThirdParty\Models\SocialMediaMaster;
use Illuminate\Support\Facades\Log as FacadesLog;
use Modules\ThirdParty\Entities\ThirdPartyEntity;
use Modules\ThirdParty\Entities\TripAdvisorEntity;
use Modules\Admin\Models\NewPatientEmailTemplateLogs;

class PageController extends Controller
{

    protected $businessEntity;

    protected $crmEntity;

    protected $websiteEntity;

    protected $thirdPartyEntity;

    protected $sessionService;

    protected $reviewEntity;

    protected $campaignEntity;

    protected $adminCampaignEntity;

    protected $promotionEntity;

    protected $socialEntity;
    protected $adminMarketingEntity;

    protected $data;

    public function __construct()
    {
        $this->businessEntity = new BusinessEntity();
        $this->websiteEntity = new WebsiteEntity();
        $this->thirdPartyEntity = new ThirdPartyEntity();
        $this->sessionService = new SessionService();
        $this->reviewEntity = new GetReviewsEntity();
        $this->campaignEntity = new CampaignEntity();
        $this->adminCampaignEntity = new AdminCampaignEntity();
        $this->crmEntity = new CRMEntity();
        $this->promotionEntity = new PromotionEntity();
        $this->socialEntity = new SocialEntity();
        $this->adminMarketingEntity = new AdminMarketingEntity();
    }

    public function billingScreen()
    {
        $userData = $this->sessionService->getAuthUserSession();
//        print_r($userData);
//        exit();
        $this->data['userData'] = $userData;

        $user_id = session('user_data')['id'];
        $user = Users::find($user_id);
        $customer_id = $user->stripe_id;

        if ($customer_id) {
            # code...
            $this->data['invoices'] = $user->invoices();
        }
        $this->data['moduleView'] = 'billing_and_plans';

        $creditsHistory = CreditsHistory::where('user_id', $user_id)->get()->toArray();

        $this->data['creditsHistory'] = $creditsHistory;
        $this->data['emailLimit'] = '';
        $emailLimit = Emailrequestlog::where('users_id', $userData['id'])->get()->toArray();
        if(!empty($emailLimit)){
            $this->data['emailLimit'] = $emailLimit;
        }
        $this->data['smsLimit'] = '';
        $smsLimit = Smsrequestlog::where('users_id', $userData['id'])->get()->toArray();
        if(!empty($smsLimit)){
            $this->data['smsLimit'] = $smsLimit;
        }
//        log::info($this->data['smsLimit']);
//        exit;
        return view('layouts.billing', $this->data);
    }

    public function unSubscribe($businessId = '', $email = '', $refer = '', $referSource = '')
    {
        $this->data['name'] = '';
        $this->data['logo'] = '';

        $this->data['businessId'] = $businessId;
        $this->data['email'] = $email;
        $this->data['refer'] = $refer;

        if(!empty($businessId))
        {
            $businessId = base64_decode($businessId);
            $businessDetail = Business::where('business_id', $businessId)->get()->toArray();

            if(!empty($refer) && !empty($email))
            {
                if(!empty($referSource) && $referSource == 'patient')
                {
                    $unsubRecord = UnsubscribeList::where(
                        [
                            'associated_template' => $refer,
                            'email' => $email,
                        ])->first();
                }
                else
                {
                    $unsubRecord = UnsubscribeList::where(
                        [
                            'business_id' => $businessId,
                            'email' => $email,
                        ])->first();
                }

                if(!empty($unsubRecord))
                {
                    $this->data['unsubscriptionStatus'] = true;
                }
            }

//            print_r($businessDetail);
//            exit;
            url('storage/app/template-doctor-logo.jpg');

            $this->data['name'] = $businessDetail[0]['practice_name'];
            $this->data['logo'] = $businessDetail[0]['logo'];
            $this->data['referSource'] = $referSource;
        }

        return view('layouts.unsubscribe', $this->data);
    }


    public function unSubscribee($businessId = '', $email = '', $refer = '')
    {
        $this->data['name'] = '';
        $this->data['logo'] = '';

        $this->data['businessId'] = $businessId;
        $this->data['email'] = $email;
        $this->data['refer'] = $refer;

        if(!empty($businessId))
        {
            $businessId = base64_decode($businessId);
            $businessDetail = Business::where('business_id', $businessId)->get()->toArray();

//            print_r($businessDetail);
//            exit;
            url('storage/app/template-doctor-logo.jpg');

            $this->data['name'] = $businessDetail[0]['practice_name'];
            $this->data['logo'] = $businessDetail[0]['logo'];
        }

        return view('layouts.unsubscribee', $this->data);
    }



    public function businessProfile(Request $request)
    {
        $authResponse = '';
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
        else if ($request->has('accessToken') && $request->get('type') != '') {
            $authResponse = $request->get('accessToken');
            $this->data['authType'] = $request->get('type');
            $this->data['authCode'] = ( !empty($request->get('code')) ) ? $request->get('code') : '';
            $this->data['authMessage'] = ( !empty($request->get('message')) ) ? $request->get('message') : '';
        }

        $socialToken = $this->sessionService->getOAuthToken();

        $this->data['authResponse'] = $authResponse;
        $this->data['socialToken'] = '';
        if(!empty($socialToken['accessTokenType']) && $socialToken['accessTokenType'] == 'facebook')
        {
            $this->data['socialToken'] = !empty($socialToken['businessAccessToken']) ? 1 : 0;
        }

        $this->data['accessTokenType'] = !empty($socialToken['accessTokenType']) ? $socialToken['accessTokenType'] : '';


        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;
        $this->data['moduleView'] = 'business_profile';

        $businessResult = $this->businessEntity->userSelectedBusiness();
        $this->data['userBusiness'] = $businessResult['records'];

        $socialRequestData = [
            'businessResult'=> $businessResult,
            'social_module_list' => 'all'
        ];
        $socialMediaPostsDataResponseData = $this->socialEntity->getSocialMediaPosts($socialRequestData);

        $this->data['socialMediaPostsData'] = [];

        if ($socialMediaPostsDataResponseData['_metadata']['outcomeCode'] == 200) {
            $this->data['socialMediaPostsData'] = $socialMediaPostsDataResponseData['records'];
        }
        else
        {
            // All not connected
            $this->data['socialMediaPostsData'] = $socialMediaPostsDataResponseData['errors'];
        }

        $this->data['countries'] = Countries::all()->toArray();

        $social = SocialProfile::where('business_id', $this->data['userBusiness']['business_id'])->get()->toArray();

        $this->data['social'] = getIndexedvalue($social, 0);

        return view('layouts.business-profile', $this->data);
    }


    public function businessListing(Request $request)
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;
        $this->data['moduleView'] = 'citation_listings';
        $userId = $userData['id'];

        $this->data['userBusiness'] = $this->businessEntity->userSelectedBusiness()['records'];

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
                $source = ucwords(strtolower($source));

                $matched = array_search($source, $sourceExist);

                if($matched !== false)
                {
                    $appBusiness = $businessData['records']['businessIssues'][$matched];

                    if($appBusiness['type'] == $source && !empty($appBusiness['name']))
                    {
                        $matchedStatus = 1;
                        $sources[$index] = [
                            'name' => $source, 'status' => 'connected',
                            'data' => $appBusiness
                        ];
                    }
                }
            }

            if($matchedStatus == 0)
            {
                $sources[$index] = ['name' => $source, 'status' => 'not_connected'];
            }
        }

        $this->data['sources'] = $sources;


        $this->data['citationList'] = BusinessCitationList::with(['citationRecord' => function($q) use($userId){
            $q->where('user_id', $userId);
        }])->get()->toArray();


        return view('layouts.business-listings', $this->data);
    }

    public function seoVIew()
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;
        $this->data['moduleView'] = 'advanced_seo';

        return view('layouts.seo', $this->data);
    }

    public function customSocialPosts()
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;

        return view('layouts.custom-social-post', $this->data);
    }

    public function payPerClick()
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;
        $this->data['moduleView'] = 'pay_per_click';

        return view('layouts.pay-per-click', $this->data);
    }

    public function landingPage()
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;

        return view('layouts.landing-page', $this->data);
    }

    public function analyticsView()
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;

        return view('layouts.analytics', $this->data);
    }

    public function websiteContent()
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;
        $this->data['moduleView'] = 'branded-content';

        return view('layouts.website-content', $this->data);
    }

    public function socialMediaProfile()
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;

        return view('layouts.social-media-profiles', $this->data);
    }

    public function blogArticle()
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;
        $this->data['moduleView'] = 'blog_articles';

        return view('layouts.blog-article', $this->data);
    }

    public function pressRelease()
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;
        $this->data['moduleView'] = 'press_releases';

        return view('layouts.press-release', $this->data);
    }

    public function overviewList()
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;
        $responseData = $this->campaignEntity->userTemplateList();

        $this->data['campaignList'] = $responseData['records'];

        return view('layouts.campaign.automated-email-list', $this->data);
    }
    public function referpage()
    {

        $this->data['moduleView'] = 'refer';
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;
        $responseData = $this->campaignEntity->userTemplateList();
        $user_id = session('user_data')['id'];
        $referalemail = Referalemail::where('user_id',$user_id )->get()->toArray();
        $this->data['referalemail'] = $referalemail;
        $this->data['campaignList'] = $responseData['records'];

        return view('layouts.campaign.referpage', $this->data);

    }
    public function upgradepage()
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;
        $responseData = $this->campaignEntity->userTemplateList();
        $user_id = session('user_data')['id'];
        $referalemail = Referalemail::where('user_id',$user_id )->get()->toArray();
        $this->data['referalemail'] = $referalemail;
        $this->data['campaignList'] = $responseData['records'];

        return view('layouts.campaign.upgradepage', $this->data);

    }


    public function referalemailstore(Request $request)
    {
        # code...
        // dd($request->all());
        $user_id = session('user_data')['id'];
        $user = Users::find($user_id);

        $request->validate([

            'email' => [
                'required',
                Rule::unique('referalemails')->where(function ($query) use ($request, $user_id) {
//                    Log::info($request->email);
//                    Log::info($user_id);

                    return $query->where('email', $request->email)->where('user_id', $user_id);
                }),
            ]
            // |unique:referalemails will add
        ]);

        $referalemail =  Referalemail::create([
            'email' => $request->email,
            'user_id' => $user_id,
            'mail_sent_to_user' => false,
        ]);


        $userData = $this->sessionService->getAuthUserSession();
        $businessName = $userData['business'][0]['practice_name'];
        Mail::to($request->email)->send(new ReferalMail($referalemail, $businessName));

        if (Mail::failures()) {
            Log::info('Failure email referalemailstore');
            Referalemail::where('user_id', '=', $user_id)->update([
                'mail_sent_to_user' => false,
            ]);
        } else {
            Log::info('success email referalemailstore');
            Referalemail::where('user_id', '=', $user_id)->update([
                'mail_sent_to_user' => true,
            ]);
            $user->emailrequestlog->increment('used');
        }

        return response()->json($referalemail);
    }
    public function contactus()
    {
        $this->data['moduleView'] = 'contact_us';
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;
        $responseData = $this->campaignEntity->userTemplateList();

        $this->data['campaignList'] = $responseData['records'];

        return view('layouts.campaign.contactus', $this->data);
    }

    public function faq()
    {
        $this->data['moduleView'] = 'contact_us';
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;
        $responseData = $this->campaignEntity->userTemplateList();

        $this->data['campaignList'] = $responseData['records'];

        return view('layouts.campaign.faq', $this->data);
    }

    public function gettingstarted()
    {
        $this->data['moduleView'] = 'contact_us';
        $this->data['hidePartials'] = true;
        $this->data['showHeader'] = true;
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;
        $responseData = $this->campaignEntity->userTemplateList();

        $this->data['campaignList'] = $responseData['records'];

        return view('layouts.gettingstarted', $this->data);
    }
    public function onboard()
    {
        $this->data['moduleView'] = 'contact_us';
        $this->data['hidePartials'] = true;
        $this->data['showHeader'] = true;
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;
        $responseData = $this->campaignEntity->userTemplateList();

        $this->data['campaignList'] = $responseData['records'];

        return view('layouts.onboard', $this->data);
    }

    public function strategy()
    {
        $this->data['moduleView'] = 'contact_us';
        $this->data['hidePartials'] = true;
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;
        $responseData = $this->campaignEntity->userTemplateList();

        $this->data['campaignList'] = $responseData['records'];

        return view('layouts.strategy', $this->data);
    }


    public function marketingPro()
    {
        $this->data['moduleView'] = 'marketing_pro';

        $userData = $this->sessionService->getAuthUserSession();

        $this->data['userData'] = $userData;

        $this->data['list'] = $this->adminMarketingEntity->list('user')['records'];

        return view('layouts.marketingpro', $this->data);
    }

    public function notfount()
    {
        $this->data['hidePartials'] = true;

        $this->data['moduleView'] = 'onboarding';

        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;

        $businessResult = $this->businessEntity->userSelectedBusiness();
//        print_r($businessResult);
//        exit();
        $this->data['userBusiness'] = $businessResult['records'];

        $this->data['countries'] = Countries::all()->toArray();

        $responseData = $this->campaignEntity->userTemplateList();

        return view('errors.404', $this->data);
    }

    public function marketingProDetails(Request $request, $id)
    {
        $id = base64_decode($id);

        $this->data['moduleView'] = 'contact_us';

        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;

        $responseData = $this->adminMarketingEntity->getService($id);

        $this->data['records'] = $responseData['records'];

        return view('layouts.marketingprodetails', $this->data);
    }

    public function onboarding(Request $request)
    {
        $this->data['hidePartials'] = true;

        $this->data['moduleView'] = 'onboarding';

        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;

        $businessResult = $this->businessEntity->userSelectedBusiness();
        $this->data['userBusiness'] = $businessResult['records'];
//        log::info($this->data['userBusiness']);
//        exit();
        $this->data['countries'] = $countries = Countries::all()->toArray();

        $responseData = $this->campaignEntity->userTemplateList();

        $nichesList = Niches::where('industry_id', $this->data['userBusiness']['niche']['industry_id'])->get()->toArray();
        $this->data['nichesList'] = $nichesList;

        return view('layouts.campaign.onboarding', $this->data);
    }

    public function testingg()
    {
        return view('layouts.testingg');
    }

    public function contactusstore(Request $request)
    {
        # code...

        $request->validate([
            'comment' => 'max:500',
            'attachment' => '',
        ]);
        $user_id = session('user_data')['id'];

        $data = [];
        $data = [
            'comment' => $request->comment,
            'feedback_option' => $request->feedback_option,
            'user_id' => $user_id
        ];
        if ($request->file('attachment')) {
            $attachment = $request->file('attachment')->store('attachment','public');
            $data['attachment'] = $attachment;
        }

        $contact = Contact::create($data);
        Mail::to('nichepractice1@gmail.com')->send(new ContactMail($contact));
        if (Mail::failures()) {
            Log::info('email failed');
        }else{
            Log::info('success email');
        }
        return response()->json($contact);
    }

    public function autoCampaignList()
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;
        $responseData = $this->campaignEntity->userTemplateList();

        $this->data['campaignList'] = $responseData['records'];

        return view('layouts.campaign.automated-email-list', $this->data);
    }

    /**
     * route: email-campaigns
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function campaignList()
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;
        $responseData = $this->campaignEntity->userTemplateList();

//        print_r($responseData);
//        exit;

        $this->data['campaignList'] = $responseData['records'];
        $this->data['moduleView'] = 'email_campaigns';

        return view('layouts.campaign.campaign-list', $this->data);
    }

    /**
     * route: new-patient-emails
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function patientEmails()
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;
        $responseData = $this->campaignEntity->userTemplateList('patient_campaign');


        $businessObj = new BusinessEntity();
        $businessResult = $businessObj->userSelectedBusiness();
        $this->data['businessRecord'] = $businessResult['records'];

//        print_r($responseData);
//        exit;
        $this->data['templateLogs'] = NewPatientEmailTemplateLogs::where('send_by', $userData['id'])->get()->toArray();

//        print_r($this->data['templateLogs']);
//        exit;
        $this->data['campaignList'] = $responseData['records'];
        $this->data['template_source'] = 'patient_email';
        $this->data['moduleView'] = 'new_patient_email_campaigns';


//        print_r($responseData['records']);
//        exit;

        return view('layouts.campaign.patient-campaign-list', $this->data);
    }

    /**
     * route: email-templates
     * sow email templates for selection
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function emailTemplates()
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;

        $result = $this->campaignEntity->getTemplate();

        $category = $this->adminCampaignEntity->getCategory();

        $type = $this->adminCampaignEntity->getType();

        if($category['_metadata']['outcomeCode'] == 200)
        {
            $this->data['category'] = $category['records'];
        }

        if($type['_metadata']['outcomeCode'] == 200)
        {
            $this->data['type'] = $type['records'];
        }

//        print_r($this->data);
//        exit;

        $this->data['list'] = '';
        if($result['_metadata']['outcomeCode'] == 200)
        {
            $this->data['list'] = $result['records'];
        }

//        print_r($result);
//        exit;

        $this->data['templates'] = $result['records'];

        return view('layouts.campaign.email-templates', $this->data);
    }

    /**
     * route: email/id
     * @param Request $request
     * @param string $templateId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function emailCampaign(Request $request, $templateId = '')
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;
        $this->data['userId'] = $userId = $userData['id'];
        $this->data['userEmail'] = $userData['email'];
//        $this->data['templateId'] = $templateId;
//        log::info(' before $templateId');
//        log::info($templateId);
        $templateId = intval(str_replace('syx', '', base64_decode($templateId)));
//        log::info(' after $templateId');
//        log::info($templateId);
//        dd($templateId);
        $this->data['templateId'] = $templateId;

        /*if(!empty($templateId))
         {
             $currentTemplate = EmailTemplate::with('templateTypeLink')->where(['id' => $templateId])->first();
             log::info('into if');
 //            log::info($currentTemplate);
 //            print_r($currentTemplate['templateTypeLink']['name']);
 //            exit;

             /**
              * Don't allow user to go next until Premimum template is not purchased
              */
           /*if(!empty($currentTemplate))
           {
//                log::info('into ifs if');
//                log::info($currentTemplate);
               if(!empty($currentTemplate['templateTypeLink']) && ((strtolower($currentTemplate['templateTypeLink']['name']) == 'premium' || strtolower($currentTemplate['templateTypeLink']['name']) == 'premium templates')))
               {
//                    log::info('into ifs ifs if');
//                    log::info($currentTemplate);
                   // checking if this template is purchased by user.
                   $creditHistoryRec = CreditsHistory::where(['user_id' => $userId, 'module_used_credits' => 'email_templates_pre_order', 'module_id' => $templateId])->first();
//                    log::info('into ifs ifs if');
//                    log::info($creditHistoryRec);
                   // user has not purchased this template so user can't use this template.
                   if(empty($creditHistoryRec))
                   {
//                        log::info('into ifs ifs if ');
//                        log::info($creditHistoryRec);
                       return redirect('email-templates');
                   }
               }
           }
//            else
//            {
//                log::info('into else');
//                return redirect()->route('email')->withMessage('Campaign not found.');
//            }
       }
       else
       {
//            log::info('into else');
           return redirect()->route('email')->withMessage('Campaign not found.');
       }*/
       $data = ['screen' => 'web'];
       $responseData = $this->crmEntity->customersList($data);

       if ($templateId != '') {
           $customers = Recipient::leftJoin('campaign_users_track As cut', function ($join) use ($userId, $templateId) {
               $join->on('recipients.id', '=', 'cut.recipient_id');
//                $join->on('cut.recipient_id', '=', 37);
               $join->on('cut.user_id', '=', \DB::raw("$userId"));
               $join->on('cut.template_id', '=', \DB::raw("$templateId"));
           })
               ->select('recipients.id', 'email', 'phone_number', 'first_name', 'last_name', 'cut.recipient_id', 'cut.user_id', 'cut.template_id')
               ->where('recipients.user_id', $userId)
               ->wherenull('deleted_at')
               ->get();
       } else {
           $customers = Recipient::select('id', 'email', 'phone_number', 'first_name', 'last_name')
               ->where('recipients.user_id', $userId)
               ->wherenull('deleted_at')
               ->get();
       }

       $this->data['records'] = $customers->toArray();
       $this->data['third_parties_list'] = [];
       $this->data['enable_get_reviews'] = 'disabled';
       $this->data['actionStatus'] = 'only_save';
       $this->data['emailrequestlogs'] = Emailrequestlog::where('users_id', $userId)->first();

       return view('layouts.campaign.email-campaign', $this->data);
   }

   public function emailCampaignPreview(Request $request, $templateId)
   {
       $userData = $this->sessionService->getAuthUserSession();
       $this->data['userData'] = $userData;
       $this->data['userId'] = $userId = $userData['id'];
       $this->data['userEmail'] = $userData['email'];
       $this->data['templateId'] = $templateId;

       $data = ['screen' => 'web'];
       $responseData = $this->crmEntity->customersList($data);

       if ($templateId != '') {
           $customers = Recipient::leftJoin('campaign_users_track As cut', function ($join) use ($userId, $templateId) {
               $join->on('recipients.id', '=', 'cut.recipient_id');
//                $join->on('cut.recipient_id', '=', 37);
               $join->on('cut.user_id', '=', \DB::raw("$userId"));
               $join->on('cut.template_id', '=', \DB::raw("$templateId"));
           })
               ->select('recipients.id', 'email', 'phone_number', 'first_name', 'last_name', 'cut.recipient_id', 'cut.user_id', 'cut.template_id')
               ->where('recipients.user_id', $userId)
               ->wherenull('deleted_at')
               ->get();
       } else {
           $customers = Recipient::select('id', 'email', 'phone_number', 'first_name', 'last_name')
               ->where('recipients.user_id', $userId)
               ->wherenull('deleted_at')
               ->get();
       }

       $this->data['records'] = $customers->toArray();

       return view('layouts.campaign.email-campaign-preview', $this->data);
   }

   /**
    * route: create-promotion
    *
    * @param Request $request
    * @param string $templateId
    * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
    */
    public function imageBuilder(Request $request, $templateId = '')
    {
//        log::info('$templateId promo s');
//        log::info($templateId);
//        echo base64_decode('MTI4');
//        exit;
        $authResponse = '';
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
        else if ($request->has('accessToken') && $request->get('type') != '') {
            $authResponse = $request->get('accessToken');
            $this->data['authType'] = $request->get('type');
            $this->data['authCode'] = ( !empty($request->get('code')) ) ? $request->get('code') : '';
            $this->data['authMessage'] = ( !empty($request->get('message')) ) ? $request->get('message') : '';
        }

        $socialToken = $this->sessionService->getOAuthToken();

        $this->data['authResponse'] = $authResponse;
        $this->data['socialToken'] = '';
        if(!empty($socialToken['accessTokenType']) && $socialToken['accessTokenType'] == 'facebook')
        {
            $this->data['socialToken'] = !empty($socialToken['businessAccessToken']) ? 1 : 0;
        }

        $this->data['accessTokenType'] = !empty($socialToken['accessTokenType']) ? $socialToken['accessTokenType'] : '';

        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;

        $this->data['promotionData'] = [];

        $this->data['templateId'] = intval(str_replace('syx', '', base64_decode($templateId)));
//        log::info($this->data['templateId']);

        if(!empty($templateId))
        {
            Log::info("template id is ($templateId)");
            $promotionData = $this->promotionEntity->getNichePromotion($templateId);

//            print_r($promotionData);
//            exit;

            if(!empty($promotionData))
            {
                $this->data['promotionData'] = $promotionData->toArray();
            }
            else
            {
                return redirect()->route('promotions-list')->withMessage('Promotion not found.');
            }
        }

        //        $socialPage = SocialMediaMaster::select('type', 'name', 'profile_photo')
        //             ->where('type', 'Facebook')
        //            ->where('business_id', 33)
        //            ->whereNotNull('name')
        //            ->whereNotNull('access_token')
        //            ->first();

        $status = [];

        $businessResult = $this->businessEntity->userSelectedBusiness();

        $data = [
            'status' => $status,
            'businessResult'=> $businessResult
        ];

        $socialMediaPostsData = $this->socialEntity->getSocialMediaPosts($data);

        //            print_r($socialMediaPostsData);
        //            exit;
        $this->data['socialMediaPostsData'] = [];

        if ($socialMediaPostsData['_metadata']['outcomeCode'] == 200) {
//            if(!empty($socialMediaPostsData['records']['Twitter']))
//            {
//                $socialMediaPostsData = $socialMediaPostsData['records'];
//                unset($socialMediaPostsData['Twitter']);
//            }

            $socialMediaPostsData = $socialMediaPostsData['records'];

//                    print_r($socialMediaPostsData);
//                    exit;
            $this->data['socialMediaPostsData'] = $socialMediaPostsData;
        }

        $this->data['socialPage'] = (!empty($socialPage)) ? $socialPage->toArray() : '';

        return view('layouts.image-builder', $this->data);
    }

    /**
     * route: promotion-templates
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function promotionTemplates()
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;

        $result = $this->promotionEntity->getTemplate();

        $this->data['templates'] = $result['records'];

        return view('layouts.promotion.promotion-templates', $this->data);
    }

    public function showBusinessReview(Request $request, $email, $secret, $business, $reviewID)
    {
        $this->data['message'] = '';
        $businessName='';

        try
        {
            $data = [
                'email' => $email,
                'secret' => $secret,
                'id' => $business,
                'review_id' => $reviewID
            ];

            $request->merge($data);
            $businessResponseData = $this->reviewEntity->saveFeedback($request);

            if($businessResponseData['_metadata']['outcomeCode'] == 3)
            {
//              $this->data['message'] = 'We detected that you are not authorized to view this page. please again click the link from your email to view the content of this page.';

                $businessName = $businessResponseData['errors']['business_name'];
                $this->data['message'] = "The business you are trying to review has removed their review sites from ".getDynamicAppName().". Due to this removal, ".getDynamicAppName()." is unable to redirect you to the review site of ".$businessName.". Please contact ".getDynamicAppSupportEmail()." for further assistance.";
            }
            else{
                $businessName = $businessResponseData['records']['business_name'];
            }

        } catch (Exception $e)
        {
            $this->data['message'] = 'Currently unable to show this page. please try again later.';
        }

        if(empty($businessName) && !is_numeric($business)){
            $businessName = $business;
        }
        //$this->data['name'] = $business;
        $this->data['name'] = $businessName;
        $this->data['email'] = $email;
        $this->data['secret'] = $secret;
        $this->data['reviewID'] = $reviewID;
        $requestpath = explode("/",$request->path());
        $this->data['flag'] = end($requestpath);
        // dd($this->data);
        return view('layouts.recipient-feedback', $this->data);
    }

    public function promotionList()
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;

        $this->data['moduleView'] = 'promotions';

        $responseData = $this->promotionEntity->userTemplateList();

        $this->data['campaignList'] = $responseData['records'];

        return view('layouts.promotion.promotion-list', $this->data);
    }

    public function campaignsLibrary()
    {
        $userData = $this->sessionService->getAuthUserSession();

        $this->data['userData'] = $userData;
        $userCampaign = Users::where('id',$userData['id'])->get()->first();
//        log::info('$userCampaign');
//        log::info($userCampaign->upgrade_selected_plan_strategy);
        $planSelected = '';
        if(!empty($userCampaign)){
            $planSelected = $userCampaign->upgrade_selected_plan_strategy;
        }
//        log::info('$planSelected');
//        log::info($planSelected);
////        exit;
        $this->data['selectedPlan'] = $planSelected;
//        log::info($planSelected);
        $this->data['moduleView'] = 'billing_and_plans';

        $result = $this->promotionEntity->getTemplate();

        $this->data['templates'] = $result['records'];
        return view('layouts.campaigns-premium-tasks', $this->data);
    }

    public function businessReviewComplete(Request $request, $email, $secret, $business)
    {
//        $this->data['message'] = 'Thank you '.$email.' for your feedback.';
        $this->data['message'] = 'Thank you for your feedback.';
        $this->data['pageType'] = 'thank-you';

        try
        {
            $data = [
                'email' => $email,
                'secret' => $secret,
            ];

            $request->merge($data);
            $businessResponseData = $this->reviewEntity->saveFeedback($request);

            if($businessResponseData['_metadata']['outcomeCode'] == 3)
            {
//              $this->data['message'] = 'We detected that you are not authorized to view this page. please again click the link from your email to view the content of this page.';

                $businessName = $businessResponseData['errors']['business_name'];
                $this->data['message'] = "The business you are trying to review has removed their review sites from ".getDynamicAppName().". Due to this removal, ".getDynamicAppName()." is unable to redirect you to the review site of ".$businessName.". Please contact ".getDynamicAppSupportEmail()." for further assistance.";
            }

        } catch (Exception $e)
        {
            $this->data['message'] = 'Currently unable to show this page. please try again later.';
        }

        $this->data['name'] = $business;
        $this->data['email'] = $email;
        $this->data['secret'] = $secret;
        $this->data['reviewID'] = '';
        $this->data['flag'] = '';
        // dd($this->data);
        return view('layouts.recipient-feedback', $this->data);
    }

    public function privacyPolicy()
    {
        # code...
        $this->data['hidePartials'] = true;
        return view('layouts.privacyPolicy', $this->data);
    }
    public function welcomeNewPatients()
    {
        $userData = $this->sessionService->getAuthUserSession();
        $this->data['userData'] = $userData;
        return view('layouts.welcome-new-patients', $this->data);
    }
    public function campaignsLibraryStaticPage()
    {
        $userData = $this->sessionService->getAuthUserSession();

        $this->data['userData'] = $userData;

//        $abc = Category::with('marketingAssociation')->where('association' , '!=','')->get()->toArray();
//        $abc = MarketingAssociation::with('campaigns')->get()->toArray();
//        print_r($abc[10]);
//        exit;

        return view('layouts.static-page', $this->data);
    }
    public function showLandingPage(Request $request)
    {
        try {
            $userData = $this->sessionService->getAuthUserSession();


            $businessName = $request->segment(1) ;
            $result = Business::where('user_id', $userData['id'])->where('practice_name', '=', $businessName)->first();
            if(!empty($result)){
                $this->data['userData'] = $userData;
            }
            return view('layouts.landingPage', $this->data);
        }
        catch(Exception $e)
        {
            return view('errors.404');
        }
    }
}
