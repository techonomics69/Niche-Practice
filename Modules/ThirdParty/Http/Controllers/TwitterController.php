<?php

namespace Modules\ThirdParty\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Laravel\Socialite\Facades\Socialite;
use Modules\ThirdParty\Entities\TwitterEntity;
use Modules\ThirdParty\Entities\FacebookEntity;
use Modules\ThirdParty\Entities\SocialEntity;
use Laravel\Socialite\Two\ProviderInterface;
use Redirect;
use Config;
use Modules\Business\Entities\BusinessEntity;
use App\Traits\UserAccess;
use Log;
use Session;
use Illuminate\Support\Facades\URL;

class TwitterController extends Controller
{

    use UserAccess;

    protected $linkedInEntity;

    protected $socialMediaEntity;

    protected $socialThirdEntity;

    protected $twitterEntity;

    public function __construct()
    {
        $this->socialMediaEntity = new FacebookEntity();
        $this->socialThirdEntity = new SocialEntity();
        $this->twitterEntity = new TwitterEntity();
    }



    public function redirectToProvider(Request $request)
    {
        log::info('coming in redirectToProvider');
        log::info($request);

        $businessId = $request->get('business_id');
        $request->session()->put('business_id', $businessId);

        if($request->has('promotion'))
        {
            Log::info("get pro " . $request->get('promotion'));

            $promotion = $request->get('promotion');
            $request->session()->put('promotion_id', $promotion);
        }

        if(isset($request->screen) && !empty($request->screen)) {
            $request->session()->put('screen', $request->screen);
        }

        Log::info("reque " . $request->get('referType'));

        if( !empty($request->get('referType')) && ( $request->get('referType') == 'social_post_settings' || $request->get('referType') == 'get_started' || $request->get('referType') == 'promotions' ) )
        {
            $request->session()->put('referType', $request->get('referType'));
        }

        $request->session()->save();

        return Socialite::driver('twitter')->redirect();
      //  return Socialite::driver('twitter')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback(Request $request)
    {
        Log::info("handleProviderCallback");

        /**
         * if user cancel login below handle exception
         */
        $webAppDomain = getDomain();
        $referType = '';

        if($request->session()->get('referType') == 'social_post_settings')
        {
            \Log::info("refer type Twitter " . $request->session()->get('referType'));
            $referType = $request->session()->pull('referType', null);
//            $url = $webAppDomain . '/social-media';
            $url = $webAppDomain . '/business-profile';
        }
        elseif($request->session()->get('referType') == 'get_started')
        {
            \Log::info("get_started refer type Twitter " . $request->session()->get('referType'));
            $referType = $request->session()->pull('referType', null);
            $url = $webAppDomain . '/practice-profile';
        }
        elseif($request->session()->get('referType') == 'promotions')
        {
            \Log::info("get_started refer type Twitter " . $request->session()->get('referType'));
            $referType = $request->session()->pull('referType', null);
            $promotion = $request->session()->pull('promotion_id', 0);

            Log::info("promotion of $promotion");
            $url = $webAppDomain . '/create-promotion/'.$promotion;
        }
        else
        {
            $url = $webAppDomain . '/social-posts';
        }

        $requestCheck = $request->all();
        if(isset($requestCheck['denied']) && !empty($requestCheck['denied'])){
            return Redirect::to($url);
        }

        /**
         * if user proceed to login
         */
        $screen = '';
        Log::info('inside call back ' . $url);
        $user = Socialite::driver('twitter')->user();

        $id = $request->session()->pull('business_id', 0);
        $screen = $request->session()->pull('screen');

        if(!empty($promotion))
        {
            $response =  $this->twitterEntity->Callback($user, $id, $referType, $promotion);
        }
        else
        {
            $response =  $this->twitterEntity->Callback($user, $id, $referType);
        }

        if($response['_metadata']['outcomeCode'] == 200)
        {
            $url = $response['records']['url'];
            return redirect()->to($url);
        }
        else
        {
            $url .= '?accessToken=error&type=Twitter&code='.$response['_metadata']['outcomeCode'].'&message='.$response['_metadata']['message'];

            return redirect()->to($url);
        }
    }


    public function addPost(Request $request)
    {
        return $this->twitterEntity->addPost($request);
    }

    public function getPosts(Request $request)
    {
        return $this->twitterEntity->getPosts($request);
    }

    public function getAllPublishedPost(Request $request)
    {
        return $this->twitterEntity->getAllPublishedPost($request);
    }
    public function manualTwitterAuthenticaion(Request $request){
        return $this->twitterEntity->manualTwitterAuthenticaion($request);
    }
    public function manualCallback(Request $request){

        return $this->twitterEntity->manualCallback($request);
    }
}
