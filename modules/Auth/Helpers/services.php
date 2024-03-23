<?php

declare(strict_types=1);

use Modules\Auth\Contracts\V1\AuthService\AuthServiceInterface;

if ( ! function_exists('authService')) {
    /**
     * Get the uth service
     *
     * @return AuthServiceInterface
     */
    function authService(): AuthServiceInterface
    {
        return resolve(AuthServiceInterface::class);
    }
}
