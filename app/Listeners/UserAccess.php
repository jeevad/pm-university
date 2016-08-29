<?php

namespace App\Listeners;

use App\Events\UserAccess as UserAccessEvent;
use App\Services\Locale;
use App\Services\Status;

class UserAccess
{
    /**
     * Handle the event.
     *
     * @param UserAccess $event
     *
     * @return void
     */
    public function handle(UserAccessEvent $event)
    {
        Status::setStatus();

        Locale::setLocale();
    }
}
