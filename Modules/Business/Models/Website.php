<?php

namespace Modules\Business\Models;

use Illuminate\Database\Eloquent\Model;

class Website extends Model{

    protected $table = 'website_master';

 protected $fillable = [
     'website', 'business_id', 'mobile_ready', 'page_speed_score', 'title_tag', 'mobile_ready_score', 'page_speed_suggestion', 'mobile_ready_suggestion', 'google_analytics'
 ];
    protected $primaryKey = 'website_id';

    public function webmaster()
    {
        return $this->belongsTo(Business::class);
    }


}