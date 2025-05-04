<?php

declare(strict_types=1);

namespace Modules\User\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Laravel\Reverb\Events\MessageReceived;
use Modules\User\Contracts\Services\UserServiceInterface;
use Modules\User\Listeners\V1\HandleMessage;
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
        $this->registerEventListeners();
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

    /**
     * Register event listeners
     */
    private function registerEventListeners(): void
    {
        Event::listen(
            MessageReceived::class,
            HandleMessage::class
        );
    }
}
