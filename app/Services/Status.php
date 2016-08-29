<?php

namespace App\Services;

class Status {
	/**
	 * Set the login user status.
	 *
	 * @param Illuminate\Auth\Events\Login $login        	
	 *
	 * @return void
	 */
	public static function setLoginStatus($login) {
		session ( [ 
				'status' => $login->user->getStatus () 
		] );
	}
	
	/**
	 * Set the visitor user status.
	 *
	 * @return void
	 */
	public static function setVisitorStatus() {
		session ( [ 
				'status' => 'visitor' 
		] );
	}
	
	/**
	 * Set the status.
	 *
	 * @return void
	 */
	public static function setStatus() {
		if (! session ()->has ( 'status' )) {
			session ( [ 
					'status' => auth ()->check () ? auth ()->user ()->getStatus () : 'visitor' 
			] );
		}
	}
}
