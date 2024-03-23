<?php

declare(strict_types=1);

namespace Modules\User\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\User\Contracts\Services\UserServiceInterface;
use Modules\User\Services\V1\UserService;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerServices();
        $this->registerObservers();
    }

    /**
     * Register module services.
     *
     * @return void
     */
    private function registerServices(): void
    {
        $this->app->bind(UserServiceInterface::class, UserService::class);
    }


    /**
     * Register model observers
     */
    private function registerObservers(): void
    {

    }
}
