<?php

namespace Modules\Admin\Services\Validations\Task;

use Modules\Task\Models\Task;
use App\Services\Validations\LaravelValidator;

class TaskValidator extends LaravelValidator
{
    protected $rules = [
        'title' => 'required|string|max:255',
        'sys_status' => 'required',
        'category' => 'nullable',
    ];
}
