<?php


namespace Modules\ThirdParty\Models;
use Illuminate\Database\Eloquent\Model;

class SMediaReview extends Model
{
    protected $table = 'smedia_review';

    protected $fillable = [
        'message', 'rating', 'reviewer', 'review_url', 'review_date', 'social_media_id'
    ];
}