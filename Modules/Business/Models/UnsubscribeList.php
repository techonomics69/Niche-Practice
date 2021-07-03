<?php

namespace Modules\Business\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Models\Users;

class UnsubscribeList extends Model
{
    protected $table = 'unsubscribe_list';

    protected $guarded = [];
}
