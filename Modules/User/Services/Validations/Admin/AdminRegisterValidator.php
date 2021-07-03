<?php

namespace Modules\Auth\Services\Validations\Admin;

use App\Services\Validations\LaravelValidator;

class AdminRegisterValidator extends LaravelValidator
{

    protected $messages = [
        'email.unique' => 'Already taken!'
    ];

    protected $rules = [
        'first_name' => 'required|string|max:50',
        'email' => 'required|string|email|max:50|unique:user_master',
        'status' => 'required',
        'password' => 'required|min:8',
    ];


}