<?php

declare(strict_types=1);

namespace Modules\Support\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Support\Console\V1\Panic\Venus;
use Modules\Support\Services\V1\FloodService\FloodService;
use Modules\Support\Contracts\V1\FloodService\FloodServiceInterface;

class SupportServiceProvider extends ServiceProvider
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

        $this->commands(
            [
                Venus::class,
            ]
        );
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
        $this->app->bind(FloodServiceInterface::class, FloodService::class);
    }


    /**
     * Register model observers
     */
    private function registerObservers(): void
    {

    }
}
