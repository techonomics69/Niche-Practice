<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Billable;
use Modules\Business\Models\Business;
use Modules\CRM\Models\Recipient;
use Modules\Admin\Models\Task;

class UserCreditsPurchaseHistory extends Model
{
    protected $table = 'user_credit_purchase_history';

//    protected $fillable = ['first_name', 'last_name', 'email', 'password'];

    protected $guarded = [];
}
