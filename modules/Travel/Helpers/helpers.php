<?php

declare(strict_types=1);


if ( ! function_exists('is_driver')) {
    /**
     * Get the is_driver model.
     */
    function is_driver(): bool
    {
        if(auth()->check()) {
            return 'driver@example.com' === auth()->user()->email;
        }
        return false;
    }
}
