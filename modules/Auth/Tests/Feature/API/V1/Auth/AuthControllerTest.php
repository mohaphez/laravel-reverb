<?php

declare(strict_types=1);

namespace Modules\Auth\Tests\Feature\API\V1\Auth;

use Modules\Base\Tests\BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\User\Enums\V1\AccountStatus\AccountStatus;
use Modules\User\Enums\V1\AccountType\AccountType;
use Modules\User\Http\Resources\API\V1\User\UserResource;

use function route;

uses(BaseTestCase::class, RefreshDatabase::class);

it('can authenticate a user and return user data with token', function (): void {

    $user = user()->factory()->create([
        'email'    => 'test@example.com',
        'password' => bcrypt('password123'),
    ]);

    $this->postJson(route('api.v1.auth.login'), [
        'email'    => 'test@example.com',
        'password' => 'password123',
    ])
        ->assertStatus(200)
        ->assertJsonStructure([
            'result' => [
                'user' => [
                    'name',
                    'email',
                    'account_status',
                    'account_type',
                ],
                'access_token',
            ]
        ])
        ->assertJson([
            'message' => __('base::http_message.authenticate.success'),
            'result'  => [
                'user' => (new UserResource($user))->toArray(request()),
            ]
        ]);
});

it('returns 401 for invalid user credentials', function (): void {
    $this->postJson(route('api.v1.auth.login'), [
        'email'    => 'nonexistent@example.com',
        'password' => 'invalidPassword',
    ])
        ->assertStatus(401)
        ->assertJson([
            'message' => __('base::http_message.authenticate.error'),
        ]);
});

it('can register a new user and return user data', function (): void {
    $userData = [
        'name'                  => 'John Doe',
        'email'                 => 'john.doe@example.com',
        'password'              => 'Password@123',
        'password_confirmation' => 'Password@123',
    ];

    $this->postJson(route('api.v1.auth.register'), $userData)
        ->assertStatus(200)
        ->assertJsonStructure([
            'message',
            'result' => [
                'name',
                'email',
                'account_status',
                'account_type',
            ]
        ])
        ->assertJson([
            'message' => __('base::http_message.authenticate.registered'),
            'result'  => [
                'name'           => $userData['name'],
                'email'          => $userData['email'],
                'account_status' => AccountStatus::Free->value,
                'account_type'   => AccountType::Client->value,
            ]
        ]);
});

it('returns 422 for invalid registration data', function (): void {
    $invalidUserData = [
        'name'                  => 'A',
        'email'                 => 'invalid-email',
        'password'              => 'short',
        'password_confirmation' => 'mismatch',
    ];

    $this->postJson(route('api.v1.auth.register'), $invalidUserData)
        ->assertStatus(422)
        ->assertJsonValidationErrors([
            'name',
            'email',
            'password',
        ]);
});

it('returns 422 if the provided email is already taken', function (): void {

    $existingUser = user()->factory()->create([
        'email' => 'existing@example.com'
    ]);

    $duplicateUserData = [
        'name'                  => 'Duplicate User',
        'email'                 => $existingUser->email,
        'password'              => 'Password@123',
        'password_confirmation' => 'Password@123',
    ];

    $this->postJson(route('api.v1.auth.register'), $duplicateUserData)
        ->assertStatus(422)
        ->assertJsonValidationErrors([
            'email' => __('validation.unique', ['attribute' => 'email']),
        ]);
});
