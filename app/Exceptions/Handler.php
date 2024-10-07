<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $levels = [
        //
    ];

    protected $dontReport = [
        //
    ];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    /**
     * This is a custom exception handler method that renders responses for exceptions
     * @param mixed $request: Represents the HTTP request that caused the exception. It allows us to access request data if needed.
     * @param \Throwable $exception : Represents the caught exception that occurred during the request processing.
     * @return mixed|\Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Throwable $exception)
    {
        // Check if the exception is an instance of ModelNotFoundException
        if ($exception instanceof ModelNotFoundException) {

            return response()->json([
                // 'data' is set to null because the requested resource was not found
                'data' => null,
                'message' => 'Book not found',
            ], 404);
        }

        // If the exception is not a ModelNotFoundException, call the parent render method
        return parent::render($request, $exception);
    }
}
