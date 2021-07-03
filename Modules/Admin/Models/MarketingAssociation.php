<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Admin\Models\Category;

class MarketingAssociation extends Model
{
    use SoftDeletes;

    protected $table = 'marketing_associations';

    protected $fillable = ['name','description','thumbnail','status','priority'];

    public function campaigns(){
        return $this->hasMany(Category::class, 'association', 'id');
    }

    public function hasManyCampaigns()
    {
        return $this->belongsToMany(Category::class, 'campaign_association_track',  'association_id', 'campaign_id');
    }
}
