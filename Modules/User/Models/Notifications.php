<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Billable;
use Modules\Business\Models\Business;
use Modules\CRM\Models\Recipient;
use Modules\Admin\Models\Task;

class Notifications extends Model
{
    protected $table = 'notifications';

    protected $guarded = [];
}
