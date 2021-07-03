<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignAssociation extends Model
{
    protected $table = 'campaign_association_track';

    protected $guarded = [];

    public function campaigns()
    {
        return $this->belongsTo(Category::class,'campaign_id','id');
    }
    public function associations()
    {
        return $this->belongsTo(MarketingAssociation::class,'association_id','id');
    }

}
