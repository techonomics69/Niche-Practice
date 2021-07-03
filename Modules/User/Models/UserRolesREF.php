<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Model;

class UserRolesREF extends Model
{
    protected $table = 'user_role_xref';

    protected $guarded = [];

    public function usersRef() {
        return $this->belongsTo(Users::class, 'user_id', 'id');
    }


}
