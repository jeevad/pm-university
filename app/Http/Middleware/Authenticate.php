<?php

namespace App\Http\Middleware;

use App\Traits\ApiControllerTrait;
use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    use ApiControllerTrait;

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     * @param string|null              $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return $this->respondUnauthorized(trans('errors.unauthorized'));
            } else {
                return redirect()->guest('login');
            }
        }

        return $next($request);
    }
}
