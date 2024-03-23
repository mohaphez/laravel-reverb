<?php

declare(strict_types=1);

namespace Modules\User\Http\Controllers\V1\API\Profile;

use Illuminate\Http\JsonResponse;
use Modules\User\Http\Resources\API\V1\User\UserResource;
use Modules\Base\Http\Controllers\API\V1\BaseAPIController;
use Modules\User\Http\Requests\V1\API\ProfileUpdateRequest;

class ProfileController extends BaseAPIController
{
    public function show(): JsonResponse
    {
        $user = auth()->user();
        return $this->respondWithResource(
            resource:new UserResource($user),
            message:__('base::http_message.entity.retrieved', ['entity' => 'profile'])
        );
    }

    public function update(ProfileUpdateRequest $request): JsonResponse
    {
        $user = auth()->user();

        $user->update($request->validated());

        return $this->respondWithResource(
            resource:new UserResource($user),
            message:__('base::http_message.entity.updated', ['entity' => 'profile'])
        );
    }
}
