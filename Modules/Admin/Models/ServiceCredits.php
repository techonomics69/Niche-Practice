<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Models\BusinessTask;
use Modules\User\Models\Users;

class ServiceCredits extends Model
{
    protected $table = 'service_credits';

    protected $guarded = [];
}
