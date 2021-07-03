<?php

namespace Modules\Business\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\CRM\Models\Recipient;
use Modules\User\Models\Users;

class EmailTemplatePlan extends Model
{
    protected $table = 'email_template_plans';

    protected $guarded = [];

    public function templates()
    {
        return $this->belongsTo(EmailTemplate::class,'template_id','id');
    }
}
