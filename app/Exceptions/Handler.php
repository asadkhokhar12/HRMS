<?php

namespace App\Exceptions;

use Throwable;
use App\Models\Company\Company;
use Illuminate\Support\Facades\Schema;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (AuthenticationException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'result' => false,
                    'message' => 'Unauthenticated.',
                ], 401);
            }
        });

    }

    public function report(Throwable $exception)
    {
        if (strpos($exception->getMessage(), "Tenant could not be identified on domain") !== false) {
            abort(response("Tenant could not be identified on domain, Please update 'APP_DOMAIN' in env file", 404) );
        }

        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */

}
