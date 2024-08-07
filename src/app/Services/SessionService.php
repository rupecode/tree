<?php

namespace App\Services;

use App\Request\Request;

class SessionService
{
    public function setAuth(): void
    {
        $_SESSION['auth'] = true;
    }

    public function isAuth(): bool
    {
        return (bool)Request::getValue($_SESSION, 'auth', false);
    }

    public function removeAuth()
    {
        $_SESSION['auth'] = false;
        session_destroy();
    }
}
