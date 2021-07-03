<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Models\Users;

class BusinessTask extends Model
{
    protected $table = 'business_task';

    protected $primaryKey = 'business_task_id';

    protected $guarded = [];
}
