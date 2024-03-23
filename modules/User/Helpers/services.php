<?php

declare(strict_types=1);

use Modules\User\Contracts\Services\UserServiceInterface;

if ( ! function_exists('userService')) {
    /**
     * Get the user service.
     */
    function userService(): UserServiceInterface
    {
        return resolve(UserServiceInterface::class);
    }
}
