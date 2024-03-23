<?php

declare(strict_types=1);

use Modules\Travel\Entities\V1\Travel;

if ( ! function_exists('travel')) {
    /**
     * Get the travel model.
     */
    function travel(): Travel
    {
        return resolve(Travel::class);
    }
}
