<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Auth;
use App\Traits\ApiControllerTrait;

class IsAdmin
{

    use ApiControllerTrait;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (session('status') === 'admin' OR session('status') === 'super_admin') {
            return $next($request);
        }
        return redirect()->guest('login');
    }
}