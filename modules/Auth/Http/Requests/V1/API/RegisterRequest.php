<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Requests\V1\API;

use Illuminate\Validation\Rule;
use Spatie\LaravelData\WithData;
use Illuminate\Validation\Rules\Password;
use Modules\Auth\DTOs\V1\RegisterDTO;
use Modules\Base\Http\Requests\V1\API\BaseAPIRequest;

class RegisterRequest extends BaseAPIRequest
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
            'name'  => ['required', 'string','min:3','max:60'],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')
            ],
            'password' => ['required','confirmed','max:60', Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
            ]
        ];
    }


    protected function dataClass(): string
    {
        return RegisterDTO::class;
    }
}
