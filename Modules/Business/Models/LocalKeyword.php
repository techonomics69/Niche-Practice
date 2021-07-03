<?php

namespace Modules\Business\Models;

use Illuminate\Database\Eloquent\Model;

class LocalKeyword extends Model{

    protected $table = 'local_keyword';

    protected $fillable = [
        'business_id','keyword','volume','rank','rank_status','search_engine','date','created_at','updated_at'
    ];


}

