<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Models\Users;

class TemplateCategory extends Model
{
    protected $table = 'template_category';

    protected $fillable = ['name', 'status', 'priority'];

//    public function tasks()
//    {
//        return $this->hasMany(Task::class, 'category', 'id');
//    }
}
