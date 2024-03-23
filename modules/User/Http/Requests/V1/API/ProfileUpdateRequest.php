<?php

declare(strict_types=1);

namespace Modules\User\Http\Requests\V1\API;

use Illuminate\Validation\Rules\Password;
use Modules\Base\Http\Requests\V1\API\BaseAPIRequest;
use Modules\User\Data\V1\UserData;
use Spatie\LaravelData\WithData;

class ProfileUpdateRequest extends BaseAPIRequest
{
    use WithData;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:255', 'min:3'],
            'mobile'   => ['sometimes', 'string', 'max:255', 'min:8'],
            'password' => ['sometimes', 'confirmed', 'max:60', Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
            ],
        ];
    }

    protected function dataClass(): string
    {
        return UserData::class;
    }
}
