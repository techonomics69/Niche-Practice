<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Billable;
use Modules\Business\Models\Business;
use Modules\Admin\Models\Reports;
use Modules\CRM\Models\Recipient;
use Modules\Admin\Models\Task;

class Users extends Model
{
    use Billable;

    protected $table = 'users';

    protected $fillable = ['first_name', 'last_name', 'email', 'password', 'account_status', 'delete_by', 'status', 'status_change_by', 'deleted_at', 'leaving_subject','leaving_note', 'timezone_offset', 'welcome_video','welcome_video_seen', 'stripe_id', 'card_last_four', 'card_brand', 'trial_ends_at', 'tasks_counter', 'do_yourself','viewed_send_review_invite_settings', 'admin_panel_user', 'close_widget'];

//    protected $dates = ['online_time'];
//    protected $guarded = [];

    public function userRole()
    {
        return $this->belongsToMany(UserRoles::class, 'user_role_xref', 'user_id', 'role_id');
    }

    public function userRef() {
        return $this->belongsTo(UserRolesREF::class, 'id', 'user_id');
    }

    public function business()
    {
        return $this->hasMany(Business::class, 'user_id', 'id');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'users_id', 'id');
    }
    public function descSubscriptions()
    {
        return $this->hasMany(Subscription::class, 'users_id', 'id')->orderBy('id', 'desc');
    }

    public function singleBusiness()
    {
        return $this->hasOne(Business::class)->select(['name', 'business_id', 'website', 'user_id']);
    }

    public function recipients()
    {
        return $this->hasMany(Recipient::class);
    }

    public function taskStatus()
    {
        return $this->belongsToMany(Task::class, 'business_task', 'user_id', 'task_id');
    }

    /**
     * Get the emailrequestlog record associated with the user.
     */
    public function emailrequestlog()
    {
        return $this->hasOne('Modules\User\Models\Emailrequestlog');
    }
    /**
     * Get the smsrequestlog record associated with the user.
     */
    public function smsrequestlog()
    {
        return $this->hasOne('Modules\User\Models\Smsrequestlog');
    }
    public function UserReports()
    {
        return $this->belongsToMany(Reports::class, 'reports', 'customer', 'id');
    }
}
