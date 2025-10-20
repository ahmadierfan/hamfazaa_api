<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Auth\AuthenticationException;
use Throwable;
use App\Exceptions\ForeignKeyConstraintException;

use Illuminate\Database\QueryException;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $e)
    {
        if ($e instanceof JWTException)
            return response()->json(['error' => __('auth.invalid_token')], 401);

        if ($e instanceof AuthenticationException)
            return response()->json(['error' => __('auth.unauthorized')], 401);

        if ($e instanceof QueryException) {
            if ($e->getCode() === '23000' && str_contains($e->getMessage(), 'foreign key constraint')) {
                throw new ForeignKeyConstraintException($e->getMessage());
            }
        }

        return parent::render($request, $e);

    }
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {

        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
