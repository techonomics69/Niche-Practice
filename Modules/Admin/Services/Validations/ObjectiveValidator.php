<?php

namespace Modules\Task\Services\Validations;

use App\Services\Validations\LaravelValidator;

class ObjectiveValidator extends LaravelValidator
{
    protected $rules = [
        'title' => 'required|string|max:255',
//        'sequence' => 'nullable|integer|unique:sys_objectives',
        'sequence' => 'nullable|integer',
        'add_marketing_plan' => 'required|integer',
        'sys_status' => 'required'
    ];
}