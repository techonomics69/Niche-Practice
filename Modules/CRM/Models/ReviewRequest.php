<?php

namespace Modules\CRM\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Auth\Models\User;
use Carbon\Carbon;
use Log;

class ReviewRequest extends Model
{
    protected $table = 'review_requests';

    protected $primaryKey = 'id';
    protected $appends = ["negativereviewstatus"];
    protected $fillable = [
        'message', 'recipient_id', 'date_sent', 'site', 'type', 'message_body', 'status', 'flag', 'review_status'
    ];

    public function getNegativeReviewStatusAttribute($value)
    {
//        Log::info('check message details');
//        Log::info($this->message);
//        Log::info($this->site);
//        Log::info($this->type);

        if ($this->message != null) {
            return $this->attributes['negativereviewstatus'] = "true";
        } else {
            return $this->attributes['negativereviewstatus'] = 'false';
        }
    }
}
