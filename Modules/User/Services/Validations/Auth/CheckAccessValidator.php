<?php

namespace Modules\Auth\Services\Validations\Auth;


use App\Services\Validations\LaravelValidator;

class CheckAccessValidator extends LaravelValidator
{
    protected $messages = [

    ];

    protected $rules = [
        'email' => 'required',
    ];
}