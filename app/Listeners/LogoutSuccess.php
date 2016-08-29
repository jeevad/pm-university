<?php

namespace App\Listeners;

use App\Services\Status;
use Illuminate\Auth\Events\Logout;

class LogoutSuccess
{
    /**
     * Handle the event.
     *
     * @param Logout $event
     *
     * @return void
     */
    public function handle(Logout $event)
    {
        Status::setVisitorStatus();
    }
}
