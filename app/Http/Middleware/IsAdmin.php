<?php

namespace App\Http\Middleware;

use App\Traits\ApiControllerTrait;
use Closure;

class IsAdmin {
	use ApiControllerTrait;
	
	/**
	 * Handle an incoming request.
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @param \Closure $next        	
	 *
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		if (session ( 'status' ) === 'admin' or session ( 'status' ) === 'super_admin') {
			return $next ( $request );
		}
		
		return redirect ()->guest ( 'login' );
	}
}
