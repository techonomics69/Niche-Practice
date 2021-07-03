<?php

namespace Modules\ThirdParty\Models;

use Illuminate\Database\Eloquent\Model;

class SysIssue extends Model
{
    protected $table = 'sys_issue';

    protected $primaryKey = 'issue_id';

    protected $fillable = ['title', 'site', 'module'];

}
