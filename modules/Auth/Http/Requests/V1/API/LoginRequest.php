<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Requests\V1\API;

use Modules\Base\Http\Requests\V1\API\BaseAPIRequest;

class LoginRequest extends BaseAPIRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email'    => ['required', 'email'],
            'password' => ['required', 'string', 'max:60'],
        ];
    }
}
