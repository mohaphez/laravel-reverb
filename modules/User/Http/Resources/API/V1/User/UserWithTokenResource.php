<?php

declare(strict_types=1);

namespace Modules\User\Http\Resources\API\V1\User;

use Illuminate\Http\Request;
use Modules\Base\Http\Resources\API\V1\BaseAPIResource;

use function authService;

class UserWithTokenResource extends BaseAPIResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'user'         => new UserResource($this),
            'access_token' => authService()->createToken($this->resource)
        ];
    }
}
