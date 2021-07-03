<?php

namespace Modules\Business\Entities;

use DB;
use Log;
use Mail;
use Config;
use App\User;
use Modules\Business\Models\UnsubscribeList;
use Redirect;
use Exception;
use App\Traits\ApiServer;
use App\Traits\UserAccess;
use App\Mail\EmailForInvite;
use Illuminate\Http\Request;
use App\Mail\EmailForQueuing;
use Modules\User\Models\Users;
use App\Entities\AbstractEntity;
use App\Services\SessionService;
use Modules\CRM\Models\Recipient;
use Modules\Business\Models\Niches;
use Illuminate\Support\Facades\Hash;
use Modules\Business\Models\Business;
use Modules\Business\Models\Industry;
use Modules\User\Models\UserRolesREF;
use App\Http\Controllers\JobController;
use App\Mail\CreateWelcomeRegisterEmail;
use Modules\User\Models\UserSendGridLogs;
use Modules\Business\Models\EmailTemplate;
use Modules\Business\Models\SocialProfile;
use Modules\ThirdParty\Entities\YelpEntity;
use Modules\ThirdParty\Entities\SocialEntity;
use Modules\Business\Models\SendgridEventLogs;
use Modules\Business\Models\CampaignUsersTrack;
use Modules\ThirdParty\Entities\FacebookEntity;
use Modules\ThirdParty\Models\SocialMediaMaster;
use Modules\ThirdParty\Models\TripadvisorMaster;
use Modules\ThirdParty\Entities\ThirdPartyEntity;
use Modules\ThirdParty\Entities\GooglePlaceEntity;
use Modules\Admin\Models\NewPatientEmailTemplateLogs;

/**
 * Class AuthEntity
 * @package Modules\Auth\Entities
 */
class CampaignEntity extends AbstractEntity
{
    use UserAccess, ApiServer;

    protected $loginValidator;

    protected $googlePlaces;

    protected $facebook;

    protected $yelp;

    protected $sessionService;

    protected $socialEntity;

    protected $thirdPartyEntity;

    protected $businessEntity;

    protected $sendGridKey;

    public function __construct()
    {
        $this->googlePlaces = new GooglePlaceEntity();
        $this->businessEntity = new BusinessEntity();
        $this->facebook = new FacebookEntity();
        $this->yelp = new YelpEntity();
        $this->thirdPartyEntity = new ThirdPartyEntity();
        $this->socialEntity = new SocialEntity();

        $this->sessionService = new SessionService();

        $this->sendGridKey = Config::get('apikeys.sendgrid_api_key');
    }

    public function sendTestMail($request)
    {
        try
        {
            $templatePreview = $request->template_preview;
            $templateID = 1;
            $templateSubject = 'Your Email builder Template';
            $senderBusinessName = 'Your email Preview';
            $replyTo = 'support@nichepractice.com';

            $recipientEmail = $request->email;


            $email = new EmailForQueuing($templateSubject, $senderBusinessName, $replyTo, $templatePreview);
            Mail::to($recipientEmail)->send($email);

            if (Mail::failures()) {
                Log::info('email failed');
                return $this->helpReturn('Email not sent.');
            }else{
                Log::info('success email');
                return $this->helpReturn('Test Email Sent Successfully.');
            }


//            Log::info("send");
//            Log::info($request->email);
//            Mail::to($request->email)->send(
//                json_encode($request->get('response'))
//            );
//
//            return $this->helpReturn('Test Email Sent.');
        }
        catch(Exception $e)
        {
            Log::info("Test mail failure -> " . $e->getMessage() . ' > ' . $e->getLine() . ' > ' . $e->getCode());

            return $this->helpReturn('Email not sent.');
        }
    }


    public function saveTemplate($request)
    {
        try {
            $userData = $this->sessionService->getAuthUserSession();
            $userId = $userData['id'];

            $data = $request->except('send', 'id', 'templatePhoto', 'templateLogo', 'webUrl');
            $data['user_id'] = $userId;

            $data['template_preview'] = $request->template_preview;
//            $data = [];

//            foreach($request->except('send') as $templateData)
//            {
//                $data['user_id'] = $request->get('user_id');
//
//                if($request->get('response'))
//                {
//                    $data['response'] = json_encode($request->get('response'));
//                }
//            }
            $templateId = $request->get('id');

            $templatePhoto=  !empty( $request->get('templatePhoto') ) ? $request->get('templatePhoto') : 'template-doc-photo.jpg';
            $templateLogo = !empty( $request->get('templateLogo') ) ? $request->get('templateLogo') : 'template-doctor-logo.jpg';


            $webUrl = $request->get('webUrl');
            $webUrl11 = $request->get('webUrl');

//            Log::info("webUrl");
//            Log::info($webUrl);
//            $abc = json_encode($request->get('response'));
//            Log::info($abc);
//
//            Log::info("response decoded");
//            Log::info(json_decode($abc, true));


//            foreach($request->get('response') as $index => $resp)
//            {
//                Log::info("index");
//                Log::info($index);
//
//                Log::info("loop");
//                Log::info($resp);
//            }

            if($request->get('response'))
            {
                $domainOnly = domainPathGet();

//                Log::info("response of save");
//                Log::info($request->get('response'));
                Log::info("domain " . $domainOnly);

//                Log::info("web " . json_encode($webUrl, JSON_NUMERIC_CHECK ));

//                $encodedWeb = htmlspecialchars(json_encode($webUrl), ENT_QUOTES);
//                $webUrl = "$webUrl\"";
                if(strpos($webUrl, '?web_url=0') !== false)
                {
                    $webUrl = "http://$domainOnly/storage/app/$templateLogo?web_url=0";
                    $encodedWeb = json_encode($webUrl);

                    $webUrl = "https://$domainOnly/storage/app/$templateLogo?web_url=0";
                    $webUrl11 = "https://$domainOnly/storage/app/$templateLogo?web_url=0";
                    $encodedWeb11 = json_encode($webUrl);

                    $encodedWeb = trim($encodedWeb, '"');
                    $encodedWeb11 = trim($encodedWeb11, '"');
                }
                else
                {
                    if(!empty($webUrl))
                    {
                        $encodedWeb = json_encode($webUrl);
                        $encodedWeb11 = $encodedWeb = trim($encodedWeb, '"');
                    }
                }

//                $encodedWeb = str_replace("", "", $encodedWeb);

//                Log::info("ecn ");
//                Log::info($encodedWeb);
//                Log::info("ecn ");
//                Log::info($encodedWeb11);

                $formatToReplace = array(
                    "https:\/\/$domainOnly\/storage\/app\/$templateLogo",
                    "http:\/\/$domainOnly\/storage\/app\/$templateLogo",
                    "https://$domainOnly/storage/app/$templateLogo",
                    "http://$domainOnly/storage/app/$templateLogo",

                    "https:\/\/$domainOnly\/storage\/app\/$templatePhoto",
                    "http:\/\/$domainOnly\/storage\/app\/$templatePhoto",

                    "https://$domainOnly/storage/app/$templatePhoto",
                    "http://$domainOnly/storage/app/$templatePhoto",
//                    "abc.com"
//                    json_encode($webUrl),
//                    "mj-global-style",
                );

                // this need to be on first index (Doctor_Website_Url) neither It will replace the
                // Doctor_Logo token instead of Doctor_website_url
                $replaceFormat = array(
                    "%%Doctor_Logo%%",
                    "%%Doctor_Logo%%",
                    "%%Doctor_Logo%%",
                    "%%Doctor_Logo%%",
                    "%%Doctor_Photo%%",
                    "%%Doctor_Photo%%",
                    "%%Doctor_Photo%%",
                    "%%Doctor_Photo%%"
//                    "abdul-testing",
//                    "http://dajbdaj.com"
                );

                if(!empty($encodedWeb11))
                {
                    Log::info("yes not emoty");
                    array_unshift($formatToReplace, $webUrl11);
                    array_unshift($replaceFormat, "%%Doctor_Website_Url%%");

                    array_unshift($formatToReplace, $encodedWeb11);
                    array_unshift($replaceFormat, "%%Doctor_Website_Url%%");
                }

                if(!empty($encodedWeb))
                {
                    Log::info("yes emoty");
                    array_unshift($formatToReplace, $webUrl);
                    array_unshift($replaceFormat, "%%Doctor_Website_Url%%");
                    array_unshift($formatToReplace, $encodedWeb);
                    array_unshift($replaceFormat, "%%Doctor_Website_Url%%");
                }


//                Log::info("formatToReplace ");
//                Log::info($formatToReplace);
//
//                Log::info("replaceFormat ");
//                Log::info($replaceFormat);

//                $data['response'] = str_replace("abc.com", "abdul.com", json_encode($request->get('response')));

//                $data['response'] = $request->get('response');

                $data['response'] = str_replace
                (
                    $formatToReplace,
                    $replaceFormat,
                    $request->get('response')
                );

//                Log::info("response");
//                Log::info($data['response']);
            }

//            Log::info("response of mod");
//            Log::info($data['response']);

            $templateData = EmailTemplate::where('id', $templateId)->first();

            if($templateData['user_id'] != $userId)
            {
                Log::info('crea');
                $data['title'] = $templateData['title'];
                $data['template_linked_id'] = $templateData['id'];

                $data['template_source'] = (!empty($templateData['template_source'])) ? $templateData['template_source'] : 'email_campaign';

                $data['date'] = $templateData['date'];

                $response = EmailTemplate::create($data);

                return $this->helpReturn("Template is Saved.", $response);
            }
            elseif(!empty($templateData))
            {
                $response = $templateData->update($data);

                return $this->helpReturn("Template is Saved.");
            }

            return $this->helpError(3, 'Problem is saving template.');
        }
        catch(Exception $e)
        {
            Log::info("saveTemplate > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function getTemplate()
    {
        try {
            $businessObj = new BusinessEntity();
            $businessResult = $businessObj->userSelectedBusiness();

            if ($businessResult['_metadata']['outcomeCode'] != 200) {
                return $this->helpError(1, 'Problem in selection of user business.');
            }

            $businessResult = $businessResult['records'];

//            print_r($businessResult);
//            exit;

//            echo $industry;
//            exit;
            $niche = $businessResult['niche_id'];

//            $response = EmailTemplate::where('user_id', 1)
//                            ->where('is_deleted', 0)
//                            ->where('niche', $niche)
//                            ->orWhere('campaign_for_user', $businessResult['user_id'])
//                            ->get()->toArray();

            $campaignUser = $businessResult['user_id'];
            $industry = $businessResult['niche']['industry_id'];


//            echo $industry;
//            exit;

            // SHowing campaign according to Niche and also user (if linked with user
            $response = EmailTemplate::with('templateTypeLink')
                ->where(function($query)
                {
                    $query->where('status', 'active');
                    $query->orWhereNull('status');
                })
                ->where('is_deleted', 0)
                ->where('show_in_dashboard', 0)
                ->where(function($query) use ($niche, $campaignUser, $industry)
                {
                $query->where('user_id', 1)
                    ->where('industry', $industry)
                    ->where(function($q) use ($niche){
                        $q->where('niche', 0);
                        $q->orWhere('niche', $niche);
                    })
                    ->orWhere('campaign_for_user', $campaignUser);
                    })
                ->whereNotIn('id', function($q) use ($niche, $campaignUser, $industry){
                    $q->from('email_templates')
                        ->selectRaw('id')
                        ->where(function($query)
                        {
                            $query->where('status', 'active');
                            $query->orWhereNull('status');
                        })
                        ->where('is_deleted', 0)
                        ->where('user_id', 1)
                        ->where('industry', $industry)
                        ->where(function($q) use ($niche){
                            $q->where('niche', 0);
                            $q->orWhere('niche', $niche);
                        })
                        ->where('campaign_for_user', '!=', $campaignUser);
//                    $q->selectRaw('select id from email_templates where niche = 11 and campaign_for_user != 36');
                })->get()->toArray();

//            print_r($response);
//            exit;

            return $this->helpReturn("Result.", $response);
        } catch (Exception $e) {
            Log::info("getTemplate > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    /**
     * show user templates panel
     * @param string $source
     * @return mixed
     */
    public function userTemplateList($source = 'email_campaign')
    {
        try {
            $userData = $this->sessionService->getAuthUserSession();

//            $response = EmailTemplate::where('user_id', $userData['id'])
//                ->where('is_deleted', 0)
//                ->where('template_source', $source)
//                ->get()->toArray();

//            $userId = $userData['id'];
//            $response = DB::table('email_templates as et')->leftJoin('email_templates As emt', function ($join) use ($userId) {
//                $join->on('et.id', '=', 'emt.template_linked_id');
//                $join->on('emt.user_id', '=', \DB::raw("$userId"));
//            })
//                ->where('et.is_deleted', 0)
//                ->where('et.template_source', 'patient_campaign')
//                ->where('et.user_id', 1)
//                ->select('et.id', 'et.user_id', 'emt.id', 'emt.user_id as emt_user_id', 'emt.response as emt_response', 'emt.single_send_id as emt_single_send_id')
//                ->get();

//                print_r($response);
//                exit;

            if($source == 'patient_campaign')
            {
                /**
                 * Parent here using as Admin Template
                 * child here using as  Child Template
                 */
                $userId = $userData['id'];
                $templateResponse = DB::table('email_templates as et')->leftJoin('email_templates As child', function ($join) use ($userId) {
                    $join->on('et.id', '=', 'child.template_linked_id');
                    $join->on('child.user_id', '=', \DB::raw("$userId"));
                })
                    ->where('et.is_deleted', 0)
                    ->where('et.template_source', 'patient_campaign')
                    ->where('et.user_id', 1)
                    ->where(function($q){
                        $q->wherenull('et.status');
                        $q->orWhere('et.status', 'active');
                    })
                    ->select('et.id as parent_id', 'et.title','et.subject', 'et.status', 'et.user_id as parent_user_id', 'child.id', 'child.user_id as user_id', 'child.response as child_response', 'child.single_send_id', 'child.status as child_status', 'child.schedule_at', 'et.date', 'child.date as child_date')
//                    ->orderBy('et.date', 'asc')
                    ->orderByRaw('ISNULL(et.date), et.date ASC, et.updated_at desc')
//                    ->orderBy('et.updated_at', 'desc')
                    ->get();

//                $d = (array) $response;
//                print_r($d);
//                exit;
                $response = [];
                foreach($templateResponse as $index => $templateRes)
                {
//                    $d = (array) $templateRes;

//                    print_r($d);
//                    exit;
//                    print_r($templateRes);
//                    exit;
                    $response[$index] = (array) $templateRes;
                }


//                print_r($response);
//                exit;


//                $response = EmailTemplate::where('user_id', 1)
//                    ->where('is_deleted', 0)
//                    ->where('template_source', $source)
//                    ->get()->toArray();
            }
            else{
                $response = EmailTemplate::where('user_id', $userData['id'])
                    ->where('is_deleted', 0)
                    ->where('template_source', $source)
                    ->get()->toArray();
            }


//            $res = EmailTemplate::wherenotnull('single_send_id')->get()->toArray();

            foreach($response as $index => $template)
            {
//                print_r($template);
//                exit;
//                if($source == 'patient_campaign')
//                {
//                    $tempSingleSend = $template->single_send_id;
//                }
//                else
//                {
//                    $tempSingleSend = $template['single_send_id'];
//                }
                $tempSingleSend = $template['single_send_id'];

                if(!empty($tempSingleSend))
                {
                    $obj = SendgridEventLogs::where('event_target_id', $tempSingleSend);

                    $obj1 = clone $obj;
                    $obj2 = clone $obj;

//                print_r($obj->where('event', 'open')->get());
//                echo "\n";
//                print_r($obj1->where('event', 'delivered')->toSql());
//                exit;

                    $response[$index]['open'] = $obj->where('event', 'open')->count();
                    $response[$index]['delivered'] = $obj1->where('event', 'delivered')->count();
                    $response[$index]['click'] = $obj2->where('event', 'click')->count();
//                exit;
//            print_r($template->)
                }
            }

//            print_r($response);
//            exit;
            return $this->helpReturn("Result.", $response);
        } Catch (Exception $e) {
            Log::info("userTemplateList > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function campaignStatsCount()
    {
        try {
            $userData = $this->sessionService->getAuthUserSession();

            $response = EmailTemplate::where('user_id', $userData['id'])
                        ->where('is_deleted', 0)
                        ->wherenotnull('single_send_id')
                        ->get()->toArray();

//            print_r($response);
//            exit;

//            $res = EmailTemplate::wherenotnull('single_send_id')->get()->toArray();

        $open = 0;
        $sent = 0;
        $click = 0;
            foreach($response as $index => $template)
            {
//                echo $template['subject'] . ' > title > ' . $template['title'];
//                echo "\n";
                if(!empty($template['single_send_id']))
                {
                    $obj = SendgridEventLogs::where('event_target_id', $template['single_send_id']);

                    $obj1 = clone $obj;
                    $obj2 = clone $obj;

//                print_r($obj->where('event', 'open')->get());
//                echo "\n";
//                print_r($obj1->where('event', 'delivered')->toSql());
//                exit;

                    $open = $open + $obj->where('event', 'open')->count();
                    $sent = $sent + $obj1->where('event', 'delivered')->count();
                    $click = $click + $obj2->where('event', 'click')->count();

//                    echo "\n";
//                    echo "open is ". $open;
//                    echo "\n";

//                    $response[$index]['open'] = $obj->where('event', 'open')->count();
//                    $response[$index]['delivered'] = $obj1->where('event', 'delivered')->count();
//                    $response[$index]['click'] = $obj2->where('event', 'click')->count();
//                exit;
//            print_r($template->)
                }
            }

            $campaignResponse['open'] = $open;
            $campaignResponse['sent'] = $sent;
            $campaignResponse['click'] = $click;
//            print_r($open);
//        echo "\n";
//            print_r($sent);
//            exit;
            return $this->helpReturn("Result.", $campaignResponse);
        } catch (Exception $e) {
            Log::info("userTemplateList > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    /**
     * send: 'get-template'
     * @param $request
     * @return mixed
     */
    public function getThisTemplate($request)
    {
        try {
//            $response = EmailTemplate::with('templateTypeLink')->find($request->id);
            $response = EmailTemplate::find($request->id);

//            if(!empty($response))
//            {
//                $response = $response->toArray();
//            }

            $businessObj = new BusinessEntity();
            $businessResult = $businessObj->userSelectedBusiness();

            $businessRecord = $businessResult['records'];
            $businessName = getIndexedvalue($businessRecord, 'practice_name', '');
            $address = getIndexedvalue($businessRecord, 'address', '');
            $city = getIndexedvalue($businessRecord, 'city', '');
            $state = getIndexedvalue($businessRecord, 'state', '');
            $zip = getIndexedvalue($businessRecord, 'zip_code', '');

            $phone = getIndexedvalue($businessRecord, 'phone', '');
            $website = getIndexedvalue($businessRecord, 'website', '');

            $userData = $this->sessionService->getAuthUserSession();
//            $email = $userData['email'];
            $email = !empty($userData['business'][0]['email']) ? $userData['business'][0]['email'] : $userData['email'];
            $firstName = $userData['first_name'];
            $lastName = $userData['last_name'];
            $name = $firstName . ' ' . $lastName;

//            Log::info("fist name " . $userData['first_name']);

//            $doctorPhoto = asset('public/images/template-doc-photo.jpg');
//            storage_path();

            $imageDir = url('storage/app');

            $doctorPhoto = url('storage/app/template-doc-photo.jpg');
            $doctorLogo = url('storage/app/template-doctor-logo.jpg');

            $userPhoto = getIndexedvalue($businessRecord, 'avatar', '');
            $userLogo = getIndexedvalue($businessRecord, 'logo', '');
            $websiteUrl = getIndexedvalue($businessRecord, 'website', '');

            if(!empty($userPhoto))
            {
                $response['userPhoto'] = $userPhoto;
                $doctorPhoto = $imageDir.'/'.$userPhoto;
            }
            else
            {
                $response['userPhoto'] = 'template-doc-photo.jpg';
            }

            if(!empty($userLogo))
            {
                $response['userLogo'] = $userLogo;
                $doctorLogo = $imageDir.'/'.$userLogo;
            }
            else
            {
                $response['userLogo'] = 'template-doctor-logo.jpg';
            }


            $response['Doctor_Website_Url'] = '';
            if(empty($websiteUrl))
            {
                // if website url is empty then logo should be click Logo image Link.
                $docWebUrl = $doctorLogo."?web_url=0";
            }
            else
            {
//                $response['Doctor_Website_Url'] = 'http://abc.com';
                $parseUrl = parse_url(trim($websiteUrl));

                if(empty($parseUrl['scheme']))
                {
                    $websiteUrl = 'http://'.$websiteUrl;
                }

                $docWebUrl = $websiteUrl;
            }

            $response['Doctor_Website_Url'] = $docWebUrl;

//            Log::info("pot > $doctorLogo ");
//            Log::info("potw > $doctorPhoto ");

            $formatToReplace = array("%%Doctor_Name%%", "%%Doctor_First_Name%%", "%%Doctor_Last_Name%%",
                "%%Doctor_Email%%","%%Doctor_Address%%","%%Doctor_City%%", "%%Doctor_State%%", "%%Doctor_Zip%%",
                "%%Doctor_Practice%%", "%%Doctor_Website%%", "%%Doctor_Phone%%",
                "%%Doctor_Logo%%", "%%Doctor_Photo%%",
                "%%Doctor_Website_Url%%",
                "%%Unsubscribe%%",
                "%%Doctor_Personal_Email%%"
            );

            $businessId = base64_encode($businessRecord['business_id']);
            $bRoute = route('unsubscribe', $businessId);
            $replaceFormat   = array(
                "<span class='template-token-tag' data-token='Doctor_Name'>$name</span>",
                "<span class='template-token-tag' data-token='Doctor_First_Name'>$firstName</span>",
                "<span class='template-token-tag' data-token='Doctor_Last_Name'>$lastName</span>",
                "<span class='template-token-tag' data-token='Doctor_Email'>$email</span>",
                "<span class='template-token-tag' data-token='Doctor_Address'>$address</span>",
                "<span class='template-token-tag' data-token='Doctor_City'>$city</span>",
                "<span class='template-token-tag' data-token='Doctor_State'>$state</span>",
                "<span class='template-token-tag' data-token='Doctor_Zip'>$zip</span>",
                "<span class='template-token-tag' data-token='Doctor_Practice'>$businessName</span>",
                "<span class='template-token-tag' data-token='Doctor_Website'>$website</span>",
                "<span class='template-token-tag' data-token='Doctor_Phone'>$phone</span>",
                $doctorLogo,
                $doctorPhoto,
                $docWebUrl,
                "<span class='template-token-tag' data-token-name='Doctor_Unsubscribe_handler'><a href='$bRoute'>Unsubscribe</a></span>",
                $email
                );

//            Log::info("template logo");
//            Log::info($doctorLogo);
//            '<span class="template-token-tag" data-token-name="Doctor_Unsubscribe_handler"><a href="'.$bRoute.'">Unsubscribe</a></span>',
            //                "Unsubscribe",
//                route('unsubscribe', $businessRecord['business_id']),
//                "http://abc.com"
//                $doctorLogo."?web_url=0"

//            "https://nichepractice.test/public/images/template-doc-photo.jpg"

//            $urlTest = json_encode("https://nichepractice.test/storage/app/template-doc-photo.jpg");
//            Log::info("json > ");
//            Log::info($urlTest);

//            Log::info("res > ");
//            Log::info($response['response']);
//
//            Log::info("anse " . strpos($response['response'], "template-doc-photo.jpg"));
//            Log::info(
//                "new check " . strpos(json_encode($response['response']), $urlTest));
//
//            Log::info(
//                "new check00 " . strpos(json_encode($response['response'], JSON_UNESCAPED_SLASHES), $urlTest));
//
//            Log::info(
//                "new check01 " . strpos
//                ($response['response']  , "\"https://nichepractice.test/storage/app/template-doc-photo.jpg\"")
//            );
//
//            Log::info("new check1111 " . strpos($response['response'], $urlTest));
//
//            Log::info("Logo Check " . strpos($response['response'], "%%Doctor_Logo%%"));


//            Log::info("one more check" . strpos($response['response'], "https:\/\/nichepractice.test\/storage\/app\/template-doc-photo.jpg"));

            $response['response'] = str_replace($formatToReplace, $replaceFormat, $response['response']);

            $templatePostStatus = $response['status'];
            $templatePublishStatus = $response['template_status'];

            if($templatePostStatus != 'published' && empty($templatePublishStatus))
            {
//                Log::info("checking this remplate for no publised and queue");
                $businessId = $businessRecord['business_id'];
                $socialProfiles = SocialProfile::where('business_id', $businessId)
                    ->select('facebook', 'twitter', 'linkedin', 'youtube', 'instagram', 'google', 'pinterest')
                    ->first();

                $socialProfileList =
                    [
                        'facebook' => '',
                        'twitter' => '',
                        'linkedin' => '',
                        'youtube' => '',
                        'instagram' => '',
                        'google' => '',
                        'pinterest' => ''
                    ];

                if(!empty($socialProfiles))
                {
                    $socialProfiles = $socialProfiles->toArray();
                    $socialProfileList = array_merge($socialProfileList, $socialProfiles);
                }

                $template = json_decode($response['response'], true);
                $templateContainer = &$template['children'][0]['children'];

                foreach($templateContainer as $index => $val) {
                    foreach ($val['children'] as $childIndex => $childVal) {
//                    echo "Parent Index is $index >> child >> $childIndex";
//                    echo "<br /> \n";
                        foreach ($childVal['children'] as $childIndex2 => $childVal2) {
                            if (!empty($childVal['children'][$childIndex2]['tagName']) && $childVal['children'][$childIndex2]['tagName'] == 'mj-social') {
                                $childTarget = $childVal['children'][$childIndex2]['children'];
                                $res = $childTarget;
                                $socialProfileModified[$childIndex2] = $socialProfileList;

                                if(!empty($childTarget))
                                {
                                    foreach ($childTarget as $childIndex3 => $childVal3) {
                                        $socialTemplateName = strtolower($childVal3['attributes']['name']);
                                        $socialAttributeName = $socialProfileModified[$childIndex2][$socialTemplateName];

                                        if (!empty($socialAttributeName)) {
                                            $res[$childIndex3]['attributes']['href'] = $socialAttributeName;
                                        } else if (empty($socialAttributeName)) {
                                            unset($res[$childIndex3]);
                                        }

                                        unset($socialProfileModified[$childIndex2][$socialTemplateName]);
                                    }
                                }

                                foreach($socialProfileModified[$childIndex2] as $socialIndex => $socialLinksRemaining)
                                {
                                    if(!empty($socialLinksRemaining))
                                    {
                                        if($socialIndex == 'linkedin')
                                        {
                                            $socialIndexName = 'LinkedIn';
                                        }
                                        else
                                        {
                                            $socialIndexName = ucfirst($socialIndex);
                                        }

                                        $res[] = [
                                            'tagName' => 'mj-social-element',
                                            'attributes' => [
                                                'src' => 'https://s3-eu-west-1.amazonaws.com/ecomail-assets/editor/social-icos/outlined/'.$socialIndex.'.png',
                                                'name' => $socialIndexName,
                                                'href' => $socialLinksRemaining,
                                                'background-color' => 'transparent',
                                            ]
                                        ];
                                    }
                                }

                                $templateContainer[$index]['children'][$childIndex]['children'][$childIndex2]['children'] = array_values($res);
                            }
                        }
                    }
                }

                $response['response'] = json_encode($template);
            }

            if($request->has('target') && $request->has('target') == 'email-templates')
            {
                unset($response['template_preview']);
                return $this->helpReturn("Result.", $response);
            }
            else
            {
                return $this->helpReturn("Result.", $response);
            }

        } catch (Exception $e) {
            Log::info("getThisTemplate > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function deleteThisTemplate($request)
    {
        try {
            $response = EmailTemplate::find($request->id);

            if(!empty($response)) {
                $response->update([
                    'is_deleted' => 1,
                ]);
            }

            return $this->helpReturn("Campaign is deleted.");
        } catch (Exception $e) {
            Log::info("deleteThisTemplate > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function changeStatus($request)
    {
        try {
            $response = EmailTemplate::find($request->id);

            if(!empty($response)) {
                $response->update([
                    'status' => $request->status,
                ]);
            }

            return $this->helpReturn("Template status is updated.");
        } catch (Exception $e) {
            Log::info("deleteThisTemplate > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    /**
     * templateCustomerLink - when user will save we'll link of users with recipients
     * @param $request
     * @return mixed
     */
    public function linkTemplateUsers($request)
    {
        try{
//            Log::info('linkTemplateUsers');
//            Log::info('$request');
//            Log::info($request);
            $userData = $this->sessionService->getAuthUserSession();
            $userId = $userData['id'];

            $recipients = $request->recipients;

//            Log::info("re");
//            Log::info($request->all());
//            Log::info("recipients");
//            Log::info($recipients);


            if(empty($recipients))
            {
                return $this->helpError(2, "Recipients are required.");
            }

            $templateId = $request->template_id;

            $code = 4;

            $storedData = CampaignUsersTrack::where('user_id', $userId)
                ->where('template_id', $templateId)
                ->get()->toArray();

            if(empty($storedData))
            {
                foreach($recipients as $recipient)
                {
                    CampaignUsersTrack::create(
                        [
                            'template_id' => $templateId,
                            'user_id' => $userId,
                            'recipient_id' => $recipient
                        ]
                    );
                }
                return $this->helpReturn("Recipients saved");
            }
            elseif(!empty($storedData))
            {
                $storedRecipients = [];

                foreach($storedData as $storedRow)
                {
                    $storedRecipients[] = $storedRow['recipient_id'];
                }

                $userRecipients = $recipients;

//                Log::info("userRecipients");
//                Log::info($userRecipients);

                // array_diff
                // Returns an array containing all the entries from $userRecipients that are not present in any of
                // the $storedRecipients array.
                $recipientsManager = array_diff($userRecipients, $storedRecipients);
                $removeKeywords = array_diff($storedRecipients, $userRecipients);

//                Log::info("recipientsManager");
//                Log::info($recipientsManager);
//
//                Log::info("removeKeywords");
//                Log::info($removeKeywords);

                if(!empty($recipientsManager)) {
                    foreach($recipientsManager as $recipient) {
                        CampaignUsersTrack::create(
                            [
                                'template_id' => $templateId,
                                'user_id' => $userId,
                                'recipient_id' => $recipient
                            ]
                        );
                    }

                    $code = 200;
                }

                if(!empty($removeKeywords))
                {
                    foreach($removeKeywords as $removalElement)
                    {
                        CampaignUsersTrack::where(
                            [
                                'template_id' => $templateId,
                                'recipient_id' => $removalElement
                            ])->delete();
                    }
                }
            }

            return $this->helpReturn("Recipients updated.", [], $code);

        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function getLinkTemplateUsers($request)
    {
        try{
            $userData = $this->sessionService->getAuthUserSession();
            $userId = $userData['id'];

            $templateId = $request->id;

            $userTemplateData = EmailTemplate::where('id', $templateId)->where('user_id', $userId)->first();

            if ($templateId != '' && !empty($userTemplateData)) {

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

            return $this->helpReturn("Recipients.", $customers);

        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    /**
     * Make singlesend on sendgrid so we've to select user template and send it to sendgrid.
     * 1) Create Contact list on sendgrid of this Email Template
     *
     * @param $request
     * @return mixed
     */
    public function sendTemplatePreviewToUsers($request)
    {

//            Log::info('sendTemplatePreviewToUsers');
            Log::info('$request');
            Log::info($request->user_id);
//            exit;
        try
        {
            $userId = $request->user_id;
            $result = EmailTemplate::with(
                [
                    'campaignUsersLinked' => function($q) use($request)
                    {
                        $q->where('user_id', $request->user_id);
                        $q->with([
                            'recipients' => function($m)
                            {
                                $m->where('email', '!=', '');
                                $m->where('deleted_at', null);
//                                $m->orWhere('deleted_at', '');
                            },
                        ]);
                    },
                ]
            )->where('id', $request->template_id)->get()->toArray();

            Log::info("res");
//            Log::info($result);

            $total_recipients = count($result[0]['campaign_users_linked']);
//            $user_id = session('user_data')['id'];
            $user = Users::find($userId);

            $user->emailrequestlog->increment('used', $total_recipients);
            // for ($i=0; $i < $total_recipients; $i++) {
            //     # code...
            //     $total_recipients[$i]['recipients']['email'];
            // }

            if( empty($result) || empty($result[0]['template_preview']) || empty($result[0]['campaign_users_linked']) )
            {
                return $this->helpError(404, 'Required data not found.');
            }

//            Log::info("0 index");
//            Log::info($result[0]);
            $templateData = $result[0];

            $jobType = '';
            if($request->has('job_type') && $request->get('job_type') == 'schedule')
            {
                $jobType = 'schedule';
            }

            Log::info("0 from");
//            Log::info($templateData);

            $this->createContactList($result, $jobType);

//            $job = new JobController();
//            $job->runEmailCampaign($templateData);
        }
        catch (Exception $e)
        {
            Log::info("sendTemplatePreviewToUsers > " . $e->getMessage());
        }
    }

    /**
     * 1) Create list
     * 2) Push Contacts into list.
     *
     * @param $data
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function createContactList($data, $jobType = '')
    {
//        $urlPathSelector = Config::get('custom.sendgrid');
        $urlPath = Config::get('custom.sendgrid.list.create_list');
//        $urlPath = Config::get('custom.sendgrid.list');
        $sendgridApi = $this->sendGridKey;

//        print_r($templateId);
//        exit;
        $userId = $data[0]['user_id'];
        $templateId = $data[0]['id'];

        $templateData = EmailTemplate::where('id', $templateId)->first();

//        print_r($data);
//        exit;
        // preapring campaign list for sendgrid user specific.
        $sendGridData['name'] = "Doc_$userId"."_$templateId"."_campaign_list_".randomString(3);
        log::info('$responseData 1');
        try {
            log::info('$responseData 12');
            $response = $this->sendgridServeApiRequest()->request('POST', $urlPath,
                [
                    'json' => $sendGridData,
                    'headers'  => [
                        'Authorization' => 'Bearer '.$sendgridApi
                    ]
                ]
            );

            $responseData = json_decode($response->getBody()->getContents(), true);

            log::info('$responseData 123');
            log::info($responseData);

            if($response->getStatusCode() == 201)
            {
                log::info('$responseData 1234');
//                print_r($responseData);
//                exit;
                $listStatus = (!empty($responseData['id'])) ? $responseData['id'] : '';
                $tempData['list_name'] = (!empty($responseData['name'])) ? $responseData['name'] : '';
                $tempData['list_id'] = $listStatus;

                $tempData['list_id'] = $listStatus;
                $templateData->update($tempData);
            }
        }
       catch(Exception $e)
        {
            log::info('$responseData 12345');
           $listStatus = 'error';
           $tempData['list_id'] = $listStatus;

            $templateData->update($tempData);

            return $this->helpError(3, 'Problem in creating your campaign.');
        }

//        Log::info("d " . $listStatus);

        /**
         * processed next if list_id is created
         */
        if(!empty($listStatus) && $listStatus != 'error')
        {
            $businessObj = new BusinessEntity();
            if($jobType == 'schedule')
            {
                $businessResult = $businessObj->userSelectedBusiness('', $userId);
            }
            else
            {
                $businessResult = $businessObj->userSelectedBusiness();
            }

            $businessResult = $businessResult['records'];
            $businessId = $businessResult['business_id'];

            $sendGridData['list_ids'] = [$listStatus];

            foreach ($data[0]['campaign_users_linked'] as $userLinked)
            {
                $recipientData = $userLinked['recipients'];

                if(!empty($recipientData['email']))
                {
                    $recordExist = UnsubscribeList::where(['email' => $recipientData['email'], 'business_id' => $businessId, 'associated_notes' => 'campaign'])
                                                    ->first();

                    if(empty($recordExist))
                    {
                        $sendGridData['contacts'][] =
                            [
                                "email" => $recipientData['email'],
                                "first_name" => $recipientData['first_name'],
                                "last_name" => $recipientData['last_name'],
                                "address_line_1" => '',
                                "address_line_2" => '',
                                "city" => '',
                                "country" => '',
                                "postal_code" => '',
                                "state_province_region" => ''
                            ];
                    }
                }
            }

            Log::info("sendgrid");
            Log::info($sendGridData);

            $tdata['sendgridData'] = $sendGridData;
            $tdata['list_id'] = $listStatus;
            $tdata['template_id'] = $templateId;

            $contactResult = $this->saveContactsSendGrid($userId, $tdata, $source = 'campaign_contact');

            if ($contactResult['_metadata']['outcomeCode'] != 200) {
                return $this->helpError(3, 'Some Problem Found.');
            }

            $singleSendData['job_id'] = $contactResult['records']['job_id'];
            $singleSendData['list_id'] = $listStatus;
            $singleSendData['templateData'] = $data[0];

            $res = $this->createSingleSend($singleSendData, $jobType);

            if ($contactResult['_metadata']['outcomeCode'] != 200) {
                return $this->helpError(70, 'Problem in creating campaign.');
            }

            $tempData['single_send_id'] = $res['records']['single_send_id'];
            $tempData['single_send_name'] = $res['records']['single_send_name'];

            $templateData->update($tempData);

            return $this->helpReturn('Campaign created.');
        }

        return $this->helpError(70, 'Problem in saving contacts.');

//        print_r($data);
//        exit;
    }

    public function saveContactsSendGrid($userId, $userData = '', $source = '')
    {
        $sendgridApi = $this->sendGridKey;

        $data = [];
        $data['user_id'] = $userId;
        $data['source'] = $source;

        $sendGridData = $userData['sendgridData'];

        if($source == 'campaign_contact')
        {
            Log::info("list id " . $userData['list_id']);
            $data['list_id'] = $userData['list_id'];

            $data['associated_id'] = $userData['template_id'];
        }

        try {
            $response = $this->sendgridServeApiRequest()->request('PUT', 'marketing/contacts',
                [
                    'json' => $sendGridData,
                    'headers'  => [
                        'Authorization' => 'Bearer '.$sendgridApi
                    ]
                ]
            );

            $responseData = json_decode($response->getBody()->getContents(), true);

            $status = 'success';
            $data['job_id'] = (!empty($responseData['job_id'])) ? $responseData['job_id'] : '';
            $data['logs'] = 'success_call_'.$userId;
        }
        catch(Exception $e)
        {
            $status = 'error';
            if($e->getResponse()->getStatusCode() == 400)
            {
                $responseBody = $e->getResponse()->getBody()->getContents();

                $data['logs'] = 'error_call code => ' . $responseBody;
            }
            else
            {
                $data['logs'] = 'error_call_'.$userId .' code => ' . $e->getCode() . ' <= messageexception => ' . $e->getMessage();
            }
        }

        UserSendGridLogs::create($data);

        if($status == 'error')
        {
            return $this->helpError(3, 'Problem in saving contacts.');
        }

        return $this->helpReturn('Contacts uploaded.', $data);
    }

    /**
     * Push job in quee
     * @param $data
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function createSingleSend($data, $jobType ='')
    {
        $templateData = $data['templateData'];
        $userId = $templateData['user_id'];
        $templateId = $templateData['id'];
        $title = $templateData['title'];
        $jobId = $data['job_id'];

        $title = "Doc_$userId"."_$templateId"."_campaign_".randomString(3);;
        $sendGridData =  [
            "name" => $title,
        ];

        $sendGridData['send_to']['list_ids'][] = $data['list_id'];
        $businessObj = new BusinessEntity();
        if($jobType == 'schedule')
        {
            $businessResult = $businessObj->userSelectedBusiness('', $userId);
        }
        else
        {
            $businessResult = $businessObj->userSelectedBusiness();
        }

        $businessResult = $businessResult['records'];

        $templateCampaignSubject = '';

        // template from name is empty so I'm using user default practice name.
        if(empty($templateData['from']))
        {
            $fromCampaignName = $businessResult['practice_name'];
        }
        else
        {
            $fromCampaignName = $templateData['from'];
        }

        if(!empty($templateData['subject']) && !empty($fromCampaignName))
        {
            $templateCampaignSubject = $templateData['subject'] . ' - ' . $fromCampaignName;
        }
        else
        {
            $templateCampaignSubject = $fromCampaignName;
        }

//        $sendGridData['email_config']['subject'] = (!empty($templateData['subject'])) ? $templateData['subject'] : $businessResult['practice_name'];
        $sendGridData['email_config']['subject'] = $templateCampaignSubject;
        $businessId = base64_encode($businessResult['business_id']);
        $bRoute = route('unsubscribe', $businessId);

        $templatePreview = $templateData['template_preview'];
        $templatePreview = str_replace($bRoute,$bRoute.'/{{email}}/'.$templateId, $templatePreview);

        $sendGridData['email_config']['html_content'] = $templatePreview;
//        $sendGridData['email_config']['suppression_group_id'] = 14095;
//        $sendGridData['email_config']['suppression_group_id'] = -1;
        $sendGridData['email_config']['custom_unsubscribe_url'] = $bRoute;
//        $sendGridData['email_config']['sender_id'] = 819435;
//        $sendGridData['email_config']['sender_id'] = 1030621; // admin@penandweb.com
        $sendGridData['email_config']['sender_id'] = 816885;

        $sendgridApi = $this->sendGridKey;

        try {
            $response = $this->sendgridServeApiRequest()->request('POST', 'marketing/singlesends',
                [
                    'json' => $sendGridData,
                    'headers'  => [
                        'Authorization' => 'Bearer '.$sendgridApi
                    ]
                ]
            );

            $responseData = json_decode($response->getBody()->getContents(), true);

            $res['single_send_id'] = (!empty($responseData['id'])) ? $responseData['id'] : '';
            $res['single_send_name'] = (!empty($responseData['name'])) ? $responseData['name'] : '';

            $job = new JobController();

            $queueData = [
                'single_send_id' => $res['single_send_id'],
                'job_id' => $jobId,
                'template_id' => $templateId
            ];
            $job->runSingleSendCampaign($queueData);

            EmailTemplate::where('id', $templateId)->update(
                [
                    'template_status' => 'queue'
                ]
            );

            return $this->helpReturn('Single send created.', $res);
//            print_r($responseData);
        }catch(Exception $e)
        {
            Log::info("createSInglesed > " .$e->getMessage());
            return $this->helpError(3, 'Problem in Creating the singlesend.');
        }
    }

    public function scheduleSingleSend($data)
    {


        Log::info("inside func");
//        Log::info($data);

//        $singleSendId = '2c9d4124-9c54-11ea-8752-364e9685b00f';
        $singleSendId = $data['single_send_id'];

        $sendgridApi = $this->sendGridKey;

        $sendGridData =  [
            "send_at" => 'now'
        ];

        try {
            $response = $this->sendgridServeApiRequest()->request('PUT', "marketing/singlesends/$singleSendId/schedule",
                [
                    'json' => $sendGridData,
                    'headers'  => [
                        'Authorization' => 'Bearer '.$sendgridApi
                    ]
                ]
            );

            $responseData = json_decode($response->getBody()->getContents(), true);

            if($response->getStatusCode() == 200)
            {
                return $this->helpReturn('SingleSend scheduled.');
            }
        }
        catch(Exception $e)
        {
            return $this->helpError(1, "exception > " . $e->getMessage());
        }

        return $this->helpError(3, 'Problem in scheduling the singlesend.');
    }

    public function checkCurrentJobStatus($jobId)
    {
        $sendgridApi = $this->sendGridKey;

//        Log::info("sendgrid job status 1" . $sendgridApi);

        try {
            // 47fd4197-68a4-4034-9293-a8473fc05af3
            $url = 'marketing/contacts/imports/'.$jobId;
            $response = $this->sendgridServeApiRequest()->request('GET', $url,
                [
                    'headers'  => [
                        'Authorization' => 'Bearer '.$sendgridApi
                    ]
                ]
            );

            $responseData = json_decode($response->getBody()->getContents(), true);

            $jobStatus = '';
//            print_r($responseData);
//            exit;
            if(!empty($responseData['status']) && $responseData['status'] == 'completed')
            {
                return $this->helpReturn('Job status is completed ready to go.', $responseData);
            }

            $jobStatus = $responseData['status'];

            return $this->helpError(3, 'Contact Job status is not found completed. > status > '.$jobStatus);
//            print_r($responseData);
        }catch(Exception $e)
        {
            Log::info("message one");
            Log::info($e->getMessage());
            return $this->helpError(1, 'Problem in fetch the Job status report.');
        }
    }

    public function sendPatientEmailInvite($request)
    {
        try {
            $templateResponse = $this->getPatientEmailTemplate(0);
            log::info('$templateResponse 99');
            log::info($templateResponse);

            if (empty($templateResponse)) {
                return $this->helpError(3, 'No template assigned with Immediately. Please see if any template is linked with Date Immediately.');
            }

            if(empty($templateResponse['child_template_preview']))
            {
                log::info('preview empty');
                return $this->helpError(42, 'Your template is not ready. Please try again later.');
            }

            $businessObj = new BusinessEntity();
            $businessResult = $businessObj->userSelectedBusiness();

            if ($businessResult['_metadata']['outcomeCode'] != 200) {
                return $this->helpError(1, 'Problem in selection of user business.');
            }

            $businessResult = $businessResult['records'];

            $recipientEmail = $request->get('email');
            $businessId = $businessResult['business_id'];

            $unsubRecord = UnsubscribeList::where(
                [
                    'business_id' => $businessId,
                    'email' => $recipientEmail,
                    'associated_notes' => 'patient',
                ])->first();

            if(!empty($unsubRecord))
            {
                return $this->helpError(1, 'This email has been unsubscribed from your patient email template list.');
            }

            $templateId = $templateResponse['id'];
            $templatePreview = $templateResponse['child_template_preview'];
            $templateSubject = $templateResponse['subject'];
//            $templateID = $this->details['id'];
            $senderBusinessName = $businessResult['practice_name'];



            $templateSubject = $this->extractTokenToValue($templateSubject, $businessResult);
//            echo $templateSubject;
//            exit;

//            $templateSubject = str_replace($formatToReplace, $replaceFormat, $templateSubject);

            $businessId = base64_encode($businessResult['business_id']);
            $bRoute = route('unsubscribe', $businessId);

            $templatePreview = str_replace($bRoute,$bRoute.'/'.$recipientEmail.'/'.$templateId.'/patient', $templatePreview);

            $userId = $businessResult['user_id'];
            $emailData = new EmailForInvite($templateSubject, $senderBusinessName, "", $templatePreview, $userId, $templateId);

            try {
                Mail::to($recipientEmail)->send($emailData);

                NewPatientEmailTemplateLogs::create(
                    [
                        'template_id' => $templateId,
                        'name' => $request->get('name'),
                        'email' => $recipientEmail,
                        'send_by' => $userId
                    ]
                );

                return $this->helpReturn('Email sent.');
            }
            catch (Exception $e)
            {
                Log::info("email sent");
                Log::info($e->getMessage());
                return $this->helpError(1, 'EMail not sent. Please try again.');
            }
        } catch(Exception $e)
        {
            Log::info("sendPatientEmailInvite");
            Log::info($e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function getPatientEmailTemplate($id = 0)
    {
        $userData = $this->sessionService->getAuthUserSession();
        $userId = $userData['id'];
//        $userId = 38;
        $templateResponse = DB::table('email_templates as et')
            ->leftJoin('email_templates As child', function ($join) use ($userId) {
            $join->on('et.id', '=', 'child.template_linked_id');
            $join->on('child.user_id', '=', \DB::raw("$userId"));
        })
            ->where('et.is_deleted', 0)
            ->where('et.template_source', 'patient_campaign')
            ->where('et.user_id', 1)
            ->where('et.date', $id)
            ->where(function($q){
                $q->wherenull('et.status');
                $q->orWhere('et.status', 'active');
            })

            ->select('et.id as parent_id', 'et.title','et.subject', 'et.status', 'et.user_id as parent_user_id', 'child.id', 'child.user_id as user_id', 'child.response as child_response', 'child.single_send_id', 'child.status as child_status', 'child.schedule_at', 'et.date', 'child.date as child_date', 'et.response', 'child.response as child_response', 'et.template_preview', 'child.template_preview as child_template_preview' )
            ->orderBy('et.date', 'asc')
            ->orderBy('et.updated_at', 'desc')
            ->first();

//        print_r('$templateResponse 88');
//        print_r( $templateResponse);
//        log::info($templateResponse);
//        exit;

        if(!empty($templateResponse))
        {
            return (array) $templateResponse;
        }

        return false;
    }

    public function extractTokenToValue($valueFromReplace, $businessRecord = '')
    {
        if(empty($businessRecord))
        {
            $businessObj = new BusinessEntity();
            $businessResult = $businessObj->userSelectedBusiness();
            $businessRecord = $businessResult['records'];
        }

//        print_r($businessRecord['business_id']);
//        exit;

        $businessName = getIndexedvalue($businessRecord, 'practice_name', '');
//        echo $businessName;
//        exit;
        $address = getIndexedvalue($businessRecord, 'address', '');
        $city = getIndexedvalue($businessRecord, 'city', '');
        $state = getIndexedvalue($businessRecord, 'state', '');
        $zip = getIndexedvalue($businessRecord, 'zip_code', '');

        $phone = getIndexedvalue($businessRecord, 'phone', '');
        $website = getIndexedvalue($businessRecord, 'website', '');

        $userData = $this->sessionService->getAuthUserSession();
        $email = $userData['email'];
        $firstName = $userData['first_name'];
        $lastName = $userData['last_name'];
        $name = $firstName . ' ' . $lastName;
        $formatToReplace = array(
            "%%Doctor_Name%%",
            "%%Doctor_First_Name%%",
            "%%Doctor_Last_Name%%",
            "%%Doctor_Email%%",
            "%%Doctor_Address%%",
            "%%Doctor_City%%",
            "%%Doctor_State%%",
            "%%Doctor_Zip%%",
            "%%Doctor_Practice%%",
            "%%Doctor_Website%%",
            "%%Doctor_Phone%%",
        );

        $businessId = base64_encode($businessRecord['business_id']);
        $bRoute = route('unsubscribe', $businessId);
        $replaceFormat  = array(
            $name,
            $firstName,
            $lastName,
            $email,
            $address,
            $city,
            $state,
            $zip,
            $businessName,
            $website,
            $phone
        );

        return str_replace($formatToReplace, $replaceFormat, $valueFromReplace);
    }

    public function unsubscribeUser($request)
    {
        $businessId = base64_decode($request->get('identifier'));
        $referId = $request->get('refer');


        $business = Business::where('business_id', $businessId)->get()->toArray();

        Log::info("business");
        Log::info($businessId);

        if(empty($business))
        {
            return $this->helpError(70, 'Information missing. Please click unsubscribe link from your email.');
        }

        $user = $business[0]['user_id'];
        $referType = '';
        $associatedWith = null;

        if($referId != 'refferal')
        {
            $associatedWith = $referId;
            $referType = !empty($request->get('referSource')) ? $request->get('referSource') : 'campaign';
            $emailRes = EmailTemplate::where(['id' => $referId])->get()->toArray();
            if(empty($emailRes))
            {
                return $this->helpError(3, 'Information missing. Please click unsubscribe link from your email.');
            }
        }

        $email = $request->get('email');
        $sendGridData['recipient_emails'] =  [
            $request->get('email')
        ];

//        Log::info("send");
//        Log::info(json_encode($sendGridData));

        $urlPath = 'asm/groups/14095/suppressions';
        $sendgridApi = $this->sendGridKey;

        try {
//            $response = $this->sendgridServeApiRequest()->request('POST', $urlPath,
//                [
//                    'json' => $sendGridData,
//                    'headers'  => [
//                        'Authorization' => 'Bearer '.$sendgridApi
//                    ]
//                ]
//            );
//
//            $responseData = json_decode($response->getBody()->getContents(), true);

            UnsubscribeList::create([
                'user_id' => $user,
                'email' => $email,
                'business_id' => $businessId,
                'associated_template' => $associatedWith,
                'associated_notes' => $referType,
            ]);

            return $this->helpReturn('Unsubscribed successfully.');

//            return $this->helpError(3, 'Please try again. Please click unsubscribe link from your email.');
        }
        catch(Exception $e)
        {
            Log::info("unsubscribeUser -> " .$e->getMessage());
            return $this->helpError(3, 'Please try again. Please click unsubscribe link from your email.');
        }
    }

    public function scheduleEmailCampaign()
    {
//        Illuminate\Http\Request::
        $request = new Request();

//        $request->merge(['job_type' => 'schedule']);
//        print_r($request->all());
//        exit;
//        $this->sendTemplatePreviewToUsers($request)
//        2019-11-28 10:30:00
        Log::info("scheduleEmailCampaign data");

//        $currentTime =  Date('Y-m-d h:i') . ':00';

        $timezoneOffset = 14;
        $timestamp = strtotime(now()) + ($timezoneOffset * 60 * 60);

        $currentTime =  date("Y-m-d h:i", $timestamp) . ':00';
//        return $currentTime;
//        $currentTime =  date("Y-m-d h:i", strtotime('+1 day')) . ':00';
         $templatesToSchedule = EmailTemplate::where('user_id', '!=', 1)
            ->whereNotNull('schedule_at')
            ->whereNotNull('template_preview')
            ->whereNull('template_status')
            ->where('status', 'schedule')
            ->where('schedule_at', '<=', $currentTime)
             ->select('id', 'user_id', 'status', 'schedule_at', 'template_status', 'timezone_offset')
             ->orderBy('user_id')
            ->get()->toArray();

//        $serverTime = date("Y-m-d H:i", strtotime('2020-08-27 09:20'));
        $serverTime = date("Y-m-d H:i");

//        echo 'server time is ' . $serverTime;

        if(!empty($templatesToSchedule))
        {
            foreach($templatesToSchedule as $templates)
            {
                $templateId = $templates['id'];
                $timezoneOffset = $templates['timezone_offset'];
                $schedule_at = $templates['schedule_at'];

//            echo $timezone;
//            exit;
                if(!empty($timezoneOffset))
                {
                    $formatToReplace = array('GMT ', 'EST ');
                    $replaceFormat = array('', '');

                    $timezoneOffset = str_replace($formatToReplace, $replaceFormat, $timezoneOffset);


//                Log::info("timezone is $timezoneOffset");

                    $TimeZone = strtotime($serverTime) + ($timezoneOffset * 60 * 60);

                    $userTimeZoneDate = date("Y-m-d H:i", $TimeZone);
                    $userTimeZone = $TimeZone;
//                echo $userTimeZone;
//                exit;
                }
                else
                {
                    $userTimeZoneDate = date("Y-m-d H:i");
                    $userTimeZone = strtotime(now());
                }

                $templateScheduleTimeZoneDate = date("Y-m-d H:i", strtotime($schedule_at));
                $templateScheduleTimeZone = strtotime($schedule_at);

//            echo "\n";
//            echo $templateScheduleTimeZone . ' > ' . $userTimeZone;
//            echo "\n";

                // uzer time zone hascrossed scehduled time zone.
                if($templateScheduleTimeZone <= $userTimeZone)
                {
                    Log::info("template id is $templateId $templateScheduleTimeZone ( $templateScheduleTimeZoneDate ) . ' <= ' . $userTimeZone ( $userTimeZoneDate );");
                    Log::info('yes it has to be scheduled');

                    $request->merge(['job_type' => 'schedule', 'template_id' => $templates['id'], 'user_id' => $templates['user_id']]);

                    $response = $this->sendTemplatePreviewToUsers($request);
                }
                else
                {
                    Log::info("template id is $templateId $templateScheduleTimeZone ( $templateScheduleTimeZoneDate ) . ' > ' . $userTimeZone ( $userTimeZoneDate )");
                    Log::info('no scheduled time yet');
                }
            }
        }
    }
}
