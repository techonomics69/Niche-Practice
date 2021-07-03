<?php

namespace Modules\Business\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Models\Users;

class SocialProfile extends Model
{
    protected $table = 'social_profiles';

    protected $fillable = ['business_id', 'google', 'facebook', 'youtube', 'linkedin', 'twitter', 'instagram', 'pinterest'];
}
