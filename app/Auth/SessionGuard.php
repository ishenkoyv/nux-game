<?php

namespace App\Auth;

use Illuminate\Auth\SessionGuard as BasicGuard;
use Symfony\Component\HttpFoundation\Request;

class SessionGuard extends BasicGuard
{
    public function attempt(array $credentials = [], $remember = false)
    {
        $this->fireAttemptEvent($credentials, $remember);
        $user = $this->provider->retrieveByCredentials($credentials);


        if ($user) {
            $this->login($user, $remember);

            return true;
        }

        $this->fireFailedEvent($user, $credentials);

        return false;
    }

    public function logout()
    {
        try {
            parent::logout();
        } catch (\Exception $e) {
        }
    }
}
