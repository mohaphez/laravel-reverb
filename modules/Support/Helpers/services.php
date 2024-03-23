<?php

declare(strict_types=1);

use Modules\Support\Contracts\V1\FloodService\FloodServiceInterface;

if ( ! function_exists('floodService')) {
    /**
     * Get the flood service
     *
     * @return FloodServiceInterface
     */
    function floodService(): FloodServiceInterface
    {
        return resolve(FloodServiceInterface::class);
    }
}
