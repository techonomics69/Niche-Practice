<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Admin\Models\BusinessTask;
use Modules\User\Models\Users;

class MarketingProServices extends Model
{
    use SoftDeletes;

    protected $table = 'marketing_pro_services';

    protected $guarded = [];

    function serviceCredits()
    {
        return $this->hasMany(ServiceCredits::class,'pro_service_id', 'id');
    }
}
