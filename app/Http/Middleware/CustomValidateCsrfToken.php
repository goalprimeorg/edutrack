<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;

class CustomValidateCsrfToken extends ValidateCsrfToken
{
    protected $except = [
        'api/*',
    ];
}
