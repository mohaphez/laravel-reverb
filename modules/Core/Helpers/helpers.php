<?php

declare(strict_types=1);

if ( ! function_exists('installed')) {
    /**
     * Return app installed or not status
     */
    function installed(): bool
    {
        return true === (bool) config('core.config.installed');
    }
}

if ( ! function_exists('not_installed')) {
    /**
     * Return app installed or not status
     */
    function not_installed(): bool
    {
        return false === (bool) config('core.config.installed');
    }
}


if ( ! function_exists('attributes')) {
    /**
     * Get module translation attributes.
     */
    function attributes(string $module): array
    {
        return __("{$module}::attributes") ?? [];
    }
}
