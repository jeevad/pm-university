<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use App\Traits\ApiControllerTrait;

class Handler extends ExceptionHandler
{

    use ApiControllerTrait;
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        // 404
        if ($e instanceof ModelNotFoundException) {
            if ($request->ajax() || $request->wantsJson() || $request->isJson()) {
                return $this->respondNotFound(trans('errors.resource_not_found'));
            }
            abort(404);
        }

        // Session token or CSRF token mismatch
        if ($e instanceof TokenMismatchException) {
            if ($request->ajax() || $request->wantsJson() || $request->isJson()) {
                return $this->respondUnauthorized(trans('errors.csrf_error'));
            }
            return redirect(route(env('AUTH_URL')))->with('message',
                    trans('errors.token_mismatch'));
        }

        // Http
        if ($this->isHttpException($e)) {
            if (view()->exists('errors.'.$e->getStatusCode())) {
                return response()->view('errors.'.$e->getStatusCode(), [],
                        $e->getStatusCode());
            }
        }
        return parent::render($request, $e);
    }

    /**
     * Create a Symfony response for the given exception.
     *
     * @param  \Exception  $e
     * @return mixed
     */
    protected function convertExceptionToResponse(Exception $e)
    {
        if (config('app.debug')) {
            $whoops = new \Whoops\Run;
            $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);

            return response()->make(
                    $whoops->handleException($e),
                    method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500,
                    method_exists($e, 'getHeaders') ? $e->getHeaders() : []
            );
        }

        return parent::convertExceptionToResponse($e);
    }
}