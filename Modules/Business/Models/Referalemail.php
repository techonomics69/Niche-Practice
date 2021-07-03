<?php

namespace Modules\Business\Models;

use Illuminate\Database\Eloquent\Model;

class Referalemail extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'referalemails';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

}
