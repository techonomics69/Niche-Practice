<?php

namespace Modules\Admin\Models;

use Modules\User\Models\Users;
use Modules\Admin\Models\BusinessTask;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alert extends Model
{
    use SoftDeletes;
    protected $table = 'alert_controller';

    protected $guarded = [];
    
}
