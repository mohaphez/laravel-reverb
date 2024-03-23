<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature\API\V1\Profile;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Base\Tests\BaseTestCase;

uses(BaseTestCase::class, RefreshDatabase::class);


it('returns 401 if user is not authenticated', function (): void {

    $this->getJson(route('api.v1.profile.show'))
        ->assertStatus(401);
});

it('can retrieve the user\'s own profile', function (): void {

    $user = user()->factory()->create();

    $this->actingAs($user)
        ->getJson(route('api.v1.profile.show'))
        ->assertStatus(200)
        ->assertJson([
            'message' => __('base::http_message.entity.retrieved', ['entity' => 'profile']),
            'result'  => [
                'name'           => $user->name,
                'email'          => $user->email,
                'account_status' => $user->account_status->value,
                'account_type'   => $user->account_type->value,
            ]
        ]);
});

it('returns 422 for invalid profile update data', function (): void {

    $user = user()->factory()->create();

    $this->actingAs($user)
        ->putJson(route('api.v1.profile.update'), [
            'name' => '',
        ])
        ->assertStatus(422)
        ->assertJsonValidationErrors([
            'name',
        ]);
});

it('can update the user\'s profile and assert database is updated', function (): void {

    $user = user()->factory()->create();

    $this->actingAs($user)
        ->putJson(route('api.v1.profile.update'), [
            'name'                  => 'Updated Name',
            'password'              => 'Password@123',
            'password_confirmation' => 'Password@123',
        ])
        ->assertStatus(200)
        ->assertJson([
            'result' => [
                'name'           => 'Updated Name',
                'email'          => $user->email,
                'account_status' => $user->account_status->value,
                'account_type'   => $user->account_type->value,
            ]
        ]);

    $this->assertDatabaseHas('users', [
        'id'   => $user->id,
        'name' => 'Updated Name'
    ]);
});
