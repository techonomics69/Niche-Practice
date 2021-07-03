<?php

namespace Modules\Business\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\CRM\Models\Recipient;
use Modules\User\Models\Users;

class CampaignUsersTrack extends Model
{
    protected $table = 'campaign_users_track';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(Users::class,'user_id','id');
    }

    public function templates()
    {
        return $this->belongsTo(EmailTemplate::class,'template_id','id');
    }

    public function recipients()
    {
        return $this->belongsTo(Recipient::class,'recipient_id','id');
    }


}
