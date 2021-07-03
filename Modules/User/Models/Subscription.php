<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Billable;
use Modules\Business\Models\Business;
use Modules\CRM\Models\Recipient;
use Modules\Admin\Models\Task;

class Subscription extends Model
{
    use Billable;

    protected $table = 'subscriptions';

//    protected $fillable = ['first_name', 'last_name', 'email', 'password'];

    protected $guarded = [];

//    public function users()
//    {
//        return $this->hasMany(Users::class, 'users_id', 'id');
//    }
}
