<?php

namespace Modules\Business\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Models\Users;

class Business extends Model
{
    protected $table = 'business_master';

    protected $primaryKey = 'business_id';

    protected $fillable = ['user_id', 'email', 'practice_name', 'phone', 'website', 'address', 'practice_status', 'discovery_status', 'niche_id', 'country_id', 'country', 'state', 'city', 'zip_code', 'is_iframe_loaded', 'user_agent'];

    public function user()
    {
        return $this->belongsTo(Users::class,'user_id','id');
    }

    public function webBusiness()
    {
        return $this->hasOne(Website::class, 'business_id', 'business_id');
    }

    public function country()
    {
        return $this->belongsTo(Countries::class,'country_id','id');
    }

    public function industry()
    {
        return $this->hasOne(Industry::class, 'id', 'industry');
    }

    public function niche()
    {
        return $this->hasOne(Niches::class, 'id', 'niche_id');
    }
}
