<?php

namespace Modules\Auth\Services\Validations\Auth;


use App\Services\Validations\LaravelValidator;

class SuperLoginValidator extends LaravelValidator
{
    protected $rules = [
        'email' => 'required|email',
        'user_email' => 'required|email',
        'password' => 'required',
    ];
}