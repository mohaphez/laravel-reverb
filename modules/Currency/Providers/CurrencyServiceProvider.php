<?php

namespace Modules\Currency\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Currency\Console\SubscribeToExchangeChannel;

class CurrencyServiceProvider extends ServiceProvider {

    public function register(): void
    {
        $this->commands([SubscribeToExchangeChannel::class]);
    }
}
