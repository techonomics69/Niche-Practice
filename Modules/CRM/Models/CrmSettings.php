<?php

namespace Modules\CRM\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Auth\Models\User;


class CrmSettings extends Model
{
    protected $table = 'crm_settings';

    protected $primaryKey = 'id';

    protected $fillable = [
        'enable_get_reviews', 'smart_routing', 'sending_option', 'customize_email', 'customize_sms', 'review_site', 'reminder', 'user_id'
    ];

}
