<?php

namespace Modules\Auth\Services\Validations\Auth;

use Modules\Auth\Models\User;
use App\Services\Validations\LaravelValidator;

class AuthRegisterValidator extends LaravelValidator
{
    protected $messages = [
    'email.unique' => 'Already taken!'
    ];

    protected $rules = [
    'first_name' => 'required|string|max:50',
    'last_name' => 'required|string|max:50',
    'email' => 'required|string|email|max:50',
    'password' => 'required|min:8|confirmed',
    ];
}