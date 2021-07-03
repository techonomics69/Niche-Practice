<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Models\MarketingAssociation;
use Modules\Business\Models\Industry;
use Modules\Business\Models\Niches;
use Modules\User\Models\Users;

class Category extends Model
{
    protected $table = 'category';

    protected $guarded = [];

    public function tasks()
    {
        // Table category foreign id is category in task table and Table category primary id is id.
        return $this->hasMany(Task::class, 'category', 'id');
    }

    public function userCategory()
    {
        return $this->hasMany(UserTaskCategory::class, 'category_id', 'id');
    }

    public function niches()
    {
        return $this->hasMany(Niches::class, 'id', 'niche');
    }

    public function industries()
    {
        return $this->hasMany(Industry::class, 'id', 'industry');
    }

    public function marketingAssociation()
    {
        return $this->hasMany(MarketingAssociation::class, 'id', 'association');
    }

    public function hasManyAssociations()
    {
        return $this->belongsToMany(MarketingAssociation::class, 'campaign_association_track', 'campaign_id', 'association_id');
    }
}
