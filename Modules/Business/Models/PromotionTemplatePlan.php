<?php

namespace Modules\Business\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\CRM\Models\Recipient;
use Modules\User\Models\Users;

class PromotionTemplatePlan extends Model
{
    protected $table = 'promotion_templates_plan';

    protected $guarded = [];

    public function templates()
    {
        return $this->belongsTo(PromotionTemplate::class,'template_id','id');
    }
}
