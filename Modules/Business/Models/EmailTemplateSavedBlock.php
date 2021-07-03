<?php

namespace Modules\Business\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Models\TemplateCategory;
use Modules\Admin\Models\TemplateTypes;
use Modules\CRM\Models\Recipient;
use Modules\User\Models\Users;

class EmailTemplateSavedBlock extends Model
{
    protected $table = 'email_templates_saved_block';

    protected $guarded = [];
}
