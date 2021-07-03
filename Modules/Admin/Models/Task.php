<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Models\CampaignFeedback;
use Modules\Admin\Models\WeekCategory;
use Modules\Admin\Models\BusinessTask;
use Modules\User\Models\Users;

class Task extends Model
{
    protected $table = 'sys_task';

    protected $guarded = [];

    public function marketingTasks()
    {
//        return $this->belongsToMany(Users::class, 'business_task', 'task_id', 'user_id');
        return $this->hasMany(BusinessTask::class,'task_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category', 'id');
    }

    public function week_category()
    {
        return $this->belongsTo(WeekCategory::class, 'week','id');
    }

    public function campaignFeedback()
    {
        return $this->hasMany(CampaignFeedback::class,'task', 'id');
    }
}
