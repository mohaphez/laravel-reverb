<?php

declare(strict_types=1);

namespace Modules\Auth\Tests\Feature\API\V1\MobileLogin;

use Modules\User\Entities\V1\User;

use Modules\Base\Tests\BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function route;

uses(BaseTestCase::class, RefreshDatabase::class);

it('can log out a user and delete their tokens', function (): void {

    $user = user()->factory()->create();
    $user->createToken('auth_app_token')->plainTextToken;

    $this->actingAs($user)->get(route('api.v1.auth.logout'))
        ->assertStatus(200)
        ->assertJson([
            'message' => __('base::http_message.authenticate.logout'),
        ]);

    // Ensure that the user's tokens have been deleted
    $this->assertEmpty($user->tokens);
});
