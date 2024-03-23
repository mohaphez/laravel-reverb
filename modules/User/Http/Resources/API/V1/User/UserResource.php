<?php

declare(strict_types=1);

namespace Modules\User\Http\Resources\API\V1\User;

use Illuminate\Http\Request;
use Modules\Base\Http\Resources\API\V1\BaseAPIResource;

class UserResource extends BaseAPIResource
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
            'name'           => $this->name,
            'email'          => $this->email,
            'account_status' => $this->account_status->value,
            'account_type'   => $this->account_type->value,
        ];
    }
}
