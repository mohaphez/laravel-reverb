<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Controllers\V1\API\Auth;

use Illuminate\Http\JsonResponse;
use Modules\Auth\Http\Requests\V1\API\LoginRequest;
use Modules\Auth\Http\Requests\V1\API\RegisterRequest;
use Modules\User\Http\Resources\API\V1\User\UserResource;
use Modules\Base\Http\Controllers\API\V1\BaseAPIController;

use Modules\User\Http\Resources\API\V1\User\UserWithTokenResource;

use function auth;
use function authService;

class AuthController extends BaseAPIController
{
    public function login(LoginRequest $request): JsonResponse
    {
        if ( ! authService()->isUserCredentialsValid($request->only('email', 'password'))) {
            return $this->respondUnAuthorized(message:__('base::http_message.authenticate.error'));
        }

        return $this->respondWithResource(
            resource: new UserWithTokenResource(auth()->user()),
            message:  __('base::http_message.authenticate.success')
        );
    }



    public function register(RegisterRequest $request): JsonResponse
    {
        $user = authService()->register($request->getData());

        return $this->respondWithResource(
            resource: new UserResource($user),
            message: __('base::http_message.authenticate.registered')
        );
    }
}
