<?php

namespace Modules\Travel\Providers;

use Illuminate\Support\ServiceProvider;

class TravelServiceProvider extends ServiceProvider
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
        // write sth you'd like to do...
    }


    /**
     * Register model observers
     */
    private function registerObservers(): void
    {

    }
}
