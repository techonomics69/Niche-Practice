<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\User\Models\Users;

class Reports extends Model
{
    use softDeletes;

    protected $table = 'reports';

    protected $guarded = [];

    public function relatedUser () {
        return $this->belongsTo(Users::class,'customer','id');
    }
}
