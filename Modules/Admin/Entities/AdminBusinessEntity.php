<?php

namespace Modules\Admin\Entities;

use App\Entities\AbstractEntity;
use App\Http\Controllers\JobController;
use App\Services\SessionService;
use App\Traits\UserAccess;
use App\User;
use DB;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Hash;
use Log;
use Mail;
use Config;
use Modules\Business\Entities\BusinessEntity;
use Modules\Business\Models\Business;
use Modules\Business\Models\CampaignUsersTrack;
use Modules\Business\Models\EmailTemplate;
use Modules\Business\Models\Industry;
use Modules\Business\Models\Niches;
use Modules\Business\Models\SocialProfile;
use Modules\CRM\Models\Recipient;
use Modules\ThirdParty\Entities\FacebookEntity;
use Modules\ThirdParty\Entities\GooglePlaceEntity;
use Modules\ThirdParty\Entities\SocialEntity;
use Modules\ThirdParty\Entities\ThirdPartyEntity;
use Modules\ThirdParty\Models\SocialMediaMaster;
use Modules\ThirdParty\Models\TripadvisorMaster;
use Modules\User\Models\UserRolesREF;
use Modules\ThirdParty\Entities\YelpEntity;
use Redirect;
/**
 * Class AuthEntity
 * @package Modules\Auth\Entities
 */
class AdminBusinessEntity extends AbstractEntity
{
    use UserAccess;

    protected $loginValidator;

    protected $googlePlaces;

    protected $facebook;

    protected $yelp;

    protected $sessionService;

    protected $socialEntity;

    protected $thirdPartyEntity;

    protected $businessEntity;

    public function __construct()
    {
        $this->googlePlaces = new GooglePlaceEntity();
        $this->businessEntity = new BusinessEntity();
        $this->facebook = new FacebookEntity();
        $this->yelp = new YelpEntity();
        $this->thirdPartyEntity = new ThirdPartyEntity();
        $this->socialEntity = new SocialEntity();

        $this->sessionService = new SessionService();
    }

    public function saveIndustry(Request $request)
    {
        try {
            $name = $request->name;
            if (!empty($request->id)) {
                // update
            } else {
                $recordExist = Industry::where('name', $name)->first();

                if (!empty($recordExist)) {
                    return $this->helpError(4, 'Industry already exist.');
                }

                Industry::create(
                    [
                        'name' => $name
                    ]
                );

                return $this->helpReturn('Industry added.');
            }

            return $this->helpError(3, 'No access.');
        } catch (Exception $e) {
            Log::info(" saveIndustry > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }
    public function saveNiche(Request $request)
    {
        try {
            $name = $request->name;
            $id = $request->id;

            if (empty($request->id)) {
                // update
            } else {
                $recordExist = Niches::where('niche', $name)->first();

                if (!empty($recordExist)) {
                    return $this->helpError(4, 'Niche already exist.');
                }

                Niches::create(
                    [
                        'niche' => $name,
                        'industry_id' => $id,
                    ]
                );

                return $this->helpReturn('Niche added.');
            }

            return $this->helpError(3, 'No access.');
        } catch (Exception $e) {
            Log::info(" saveNiche > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }
}
