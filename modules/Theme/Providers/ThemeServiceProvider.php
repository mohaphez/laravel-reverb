<?php

namespace Modules\Theme\Providers;

use Illuminate\Support\ServiceProvider;
use Qirolab\Theme\Theme;

class ThemeServiceProvider extends ServiceProvider
{
    /**
     * The active theme.
     */
    private string $active;

    /**
     * The parent theme.
     */
    private string $parent;

    /**
     * Bootstrap any application configuration.
     */
    public function boot(): void
    {
        $this->syncTheme();
        $this->registerTheme();
    }

    /**
     * Sync the current application theme.
     */
    private function syncTheme(): void
    {
        $this->active = config('theme.active');
        $this->parent = config('theme.parent');
        Theme::set($this->active, $this->parent);
    }

    /**
     * Register the current theme.
     */
    private function registerTheme(): void
    {
        $this->registerProvider();
        $this->registerProvider('Route');
    }

    /**
     * Register theme providers.
     */
    private function registerProvider(string $suffix = ''): void
    {
        $providerNamespace = 'Themes\\' . $this->active . '\\Providers\\Theme' . $suffix . 'ServiceProvider';
        $parentProviderNamespace = 'Themes\\' . $this->parent . '\\Providers\\Theme' . $suffix . 'ServiceProvider';

        $this->registerIfClassExists($providerNamespace);

        if ($this->active !== $this->parent)
            $this->registerIfClassExists($parentProviderNamespace);
    }

    /**
     * Register a provider if the class exists.
     *
     * @param string $providerNamespace
     */
    private function registerIfClassExists(string $providerNamespace): void
    {
        if (class_exists($providerNamespace))
            $this->app->register($providerNamespace);
    }
}
