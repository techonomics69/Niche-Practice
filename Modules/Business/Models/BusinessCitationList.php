<?php

namespace Modules\Business\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\User\Models\Users;

class BusinessCitationList extends Model
{
    use SoftDeletes;

    protected $table = 'business_citation_list';

    protected $guarded = [];

    public function citationRecord()
    {
        return $this->hasMany(UserBusinessCitationList::class, 'citation_app_id', 'id');
    }
}
