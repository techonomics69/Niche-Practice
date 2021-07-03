<?php

namespace Modules\ThirdParty\Models;

use Illuminate\Database\Eloquent\Model;

class TripadvisorReview extends Model
{
    protected $table = 'third_party_review';

    protected $primaryKey = 'review_id';

    protected $fillable = [
        'rating', 'reviewer', 'message','review_url', 'third_party_id'
    ];

//    public function user()
//    {
//        return $this->belongsTo(TripadvisorMaster::class);
//    }

}
