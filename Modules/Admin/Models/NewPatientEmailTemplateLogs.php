<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Models\Users;

class NewPatientEmailTemplateLogs extends Model
{
    protected $table = 'new_patient_template_logs';

    protected $guarded = [];

//    public function tasks()
//    {
//        return $this->hasMany(Task::class, 'category', 'id');
//    }
}
