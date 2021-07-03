<?php

namespace Modules\Business\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Models\TemplateCategory;
use Modules\Admin\Models\TemplateTypes;
use Modules\CRM\Models\Recipient;
use Modules\User\Models\Users;

class EmailTemplate extends Model
{
    protected $table = 'email_templates';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(Users::class,'user_id','id');
    }

    public function associateEmailTemplate()
    {
        return $this->belongsTo(EmailTemplate::class,'template_linked_id','id');
    }

    public function templateLinkedUser()
    {
        return $this->belongsTo(Users::class,'campaign_for_user','id');
    }

    public function campaignUsersLinked()
    {
        return $this->hasMany(CampaignUsersTrack::class,'template_id', 'id');
    }

    public function templatePlans()
    {
        return $this->hasMany(EmailTemplatePlan::class,'template_id', 'id');
    }

    public function sendgridEvents()
    {
        return $this->hasMany(SendgridEventLogs::class,'event_target_id', 'single_send_id');
    }

    public function hasManyRecipients()
    {
        return $this->belongsToMany(Recipient::class, 'campaign_users_track', 'template_id', 'recipient_id');
    }

    public function templateTypeLink()
    {
        return $this->hasOne(TemplateTypes::class, 'id', 'template_type_link');
    }

    public function category()
    {
        return $this->hasOne(TemplateCategory::class, 'id', 'category');
    }

    public function industry()
    {
        return $this->hasOne(Industry::class, 'id', 'industry');
    }

    public function niche()
    {
        return $this->hasOne(Niches::class, 'id', 'niche');
    }
}
