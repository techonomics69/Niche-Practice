<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Models\Users;

class UserTaskCategory extends Model
{
    protected $table = 'user_task_category';

    protected $guarded = [];
}
