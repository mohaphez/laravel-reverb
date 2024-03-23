<?php

declare(strict_types=1);

use Modules\User\Entities\V1\User;

if ( ! function_exists('user')) {
    /**
     * Get the user model.
     */
    function user(): User
    {
        return resolve(User::class);
    }
}
