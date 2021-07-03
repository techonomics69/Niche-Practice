<?php

namespace Modules\Auth\Services\Validations\Auth;

use App\Services\Validations\LaravelValidator;

class ResetPasswordValidator extends LaravelValidator
{
    protected $messages = [

    ];

    protected $rules = [
        'password' => 'required',
        'confirm_password' => 'required|same:password',
        'current_password' => 'required',
    ];
}