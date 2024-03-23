<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Controllers\V1\API\Session;

use Illuminate\Http\JsonResponse;
use Modules\Base\Http\Controllers\API\V1\BaseAPIController;

class SessionController extends BaseAPIController
{
    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();

        return $this->respondSuccess(message:__('base::http_message.authenticate.logout'));
    }
}
