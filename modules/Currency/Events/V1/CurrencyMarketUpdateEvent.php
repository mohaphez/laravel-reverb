<?php

declare(strict_types=1);

namespace Modules\Currency\Events\V1;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CurrencyMarketUpdateEvent implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public mixed $cryptocurrencies;

    public function __construct($cryptocurrencies)
    {
        $this->cryptocurrencies = $cryptocurrencies;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('cryptocurrency-updates');
    }
}
