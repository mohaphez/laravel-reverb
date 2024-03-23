<?php


declare(strict_types=1);


if ( ! function_exists('cacheKey')) {
    /**
     * Generate cache key
     *
     */
    function cacheKey(...$arguments): string
    {
        return implode('_', $arguments);
    }
}

if ( ! function_exists('cacheFlush')) {
    /**
     * clean cache by key
     *
     */
    function cacheFlush(...$arguments): void
    {
        $cacheKey = cacheKey(...$arguments);
        empty($cacheKey) ? cache()->flush() : cache()->forget($cacheKey);
    }
}
