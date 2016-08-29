<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use App\Services\Status;

class LogoutSuccess {
	/**
	 * Handle the event.
	 *
	 * @param Logout $event        	
	 * @return void
	 */
	public function handle(Logout $event) {
		Status::setVisitorStatus ();
	}
}
