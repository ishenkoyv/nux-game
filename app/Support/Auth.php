<?php

namespace App\Support;

use Illuminate\Support\Facades\Auth;

class AppAuth extends Auth
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'appauth';
    }
}
