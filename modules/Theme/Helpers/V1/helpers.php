<?php

use Qirolab\Theme\Theme;

if (!function_exists('theme'))
{
    /**
     * Get theme.
     */
    function theme(bool $parent = false): string
    {
        return $parent
            ? Theme::parent()
            : Theme::active();
    }
}

if (!function_exists('active_theme'))
{
    /**
     * Get the active theme.
     */
    function active_theme(): string
    {
        return Theme::active();
    }
}

if (!function_exists('parent_theme'))
{
    /**
     * Get the parent theme.
     */
    function parent_theme(): string
    {
        return Theme::parent();
    }
}
