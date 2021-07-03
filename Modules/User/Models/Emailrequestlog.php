<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Model;

class Emailrequestlog extends Model
{
    protected $table = 'emailrequestlogs';

    protected $fillable = ["remaining","maximum","users_id", 'used'];

    /**
     * Get the user that owns the emailrequestlog.
     */
    public function user()
    {
        return $this->belongsTo('Modules\User\Models\Users');
    }
}
