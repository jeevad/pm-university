<?php

namespace App\Http\Middleware\Api;

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
        $user = Auth::guard('api')->user();
        if ($user->accessApisAll()) {
            return $next($request);
        }
        return $this->respondUnauthorized(trans('errors.unauthorized'));
    }
}