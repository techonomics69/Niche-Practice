<?php

namespace Modules\Business\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\CRM\Models\Recipient;
use Modules\User\Models\Users;

class PromotionTemplate extends Model
{
    protected $table = 'promotion_templates';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(Users::class,'user_id','id');
    }

    public function templatePlans()
    {
        return $this->hasMany(PromotionTemplatePlan::class,'template_id', 'id');
    }

    public function industry()
    {
        return $this->hasOne(Industry::class, 'id', 'industry');
    }

    public function niche()
    {
        return $this->hasOne(Niches::class, 'id', 'niche');
    }

//    public function campaignUsersLinked()
//    {
//        return $this->hasMany(CampaignUsersTrack::class,'template_id', 'id');
//    }
//
//    public function hasManyRecipients()
//    {
//        return $this->belongsToMany(Recipient::class, 'campaign_users_track', 'template_id', 'recipient_id');
//    }
}
