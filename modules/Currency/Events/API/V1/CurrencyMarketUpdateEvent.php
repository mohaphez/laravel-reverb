<?php

namespace Modules\Currency\Events\Api\V1;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CurrencyMarketUpdateEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

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
