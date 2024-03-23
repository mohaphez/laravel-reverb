<?php

declare(strict_types=1);

namespace Modules\Core\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Modules\Support\Traits\V1\ApiResponse\ApiResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class BaseExceptionHandler extends ExceptionHandler
{
    use ApiResponse;

    public function render($request, $e): \Illuminate\Http\Response|JsonResponse|RedirectResponse|Response
    {
        if ($request->expectsJson() && ! app()->hasDebugModeEnabled()) {
            return $this->handleApiExceptions($request, $e);
        }

        return parent::render($request, $e);
    }


    private function handleApiExceptions($request, Throwable $exception): \Illuminate\Http\Response|JsonResponse|RedirectResponse|Response
    {
        return match (true) {
            $exception instanceof AuthenticationException   => $this->respondUnAuthorized(),
            $exception instanceof ThrottleRequestsException => $this->respondThrottleRequests($exception->getMessage()),
            $exception instanceof ModelNotFoundException, $exception instanceof NotFoundHttpException => $this->respondNotFound(),
            $exception instanceof ValidationException => $this->respondValidationErrors($exception),
            $exception instanceof QueryException      => $this->respondInternalError(message: __('There was Issue with the Query'), exception: $exception),
            default                                   => $this->respondInternalError(message: __('There was some internal error'), exception: $exception),
        };
    }
}
