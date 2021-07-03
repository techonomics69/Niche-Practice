<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Models\Users;

class TemplateTypes extends Model
{
    protected $table = 'template_type';

    protected $fillable = ['name', 'status', 'priority'];
}
