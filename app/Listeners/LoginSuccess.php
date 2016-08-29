<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Services\Status;

class LoginSuccess
{
    /**
     * Handle the event.
     *
     * @param  Login  $login
     * @return void
     */
    public function handle(Login $login)
    {
        Status::setLoginStatus($login);
    }
}
