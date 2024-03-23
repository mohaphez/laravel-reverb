<?php

declare(strict_types=1);

namespace Modules\Auth\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Auth\Services\V1\AuthService\AuthService;
use Modules\Auth\Contracts\V1\AuthService\AuthServiceInterface;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerRepositories();
        $this->registerServices();
        $this->registerObservers();
    }

    /**
     * Register module repositories.
     *
     * @return void
     */
    private function registerRepositories(): void
    {
        // write sth you'd like to do...
    }

    /**
     * Register module services.
     *
     * @return void
     */
    private function registerServices(): void
    {
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
    }


    /**
     * Register model observers
     */
    private function registerObservers(): void
    {

    }
}
