<?php

namespace Modules\Currency\Http\Controllers\V1\API;

use Illuminate\Http\Request;
use Modules\Base\Http\Controllers\API\V1\BaseAPIController;
use Modules\Currency\Events\API\V1\CurrencyMarketUpdateEvent;

class WebhookController extends BaseAPIController
{
    public function handle(Request $request)
    {
        $cryptocurrencies = [
            'BTC' => [
                'currency' => 'BTC',
                'amount' => rand(100, 1000),
                'change' => rand(-10, 10),
            ],
            'ETH' => [
                'currency' => 'ETH',
                'amount' => rand(50, 500),
                'change' => rand(-10, 10),
            ],
            'LTC' => [
                'currency' => 'LTC',
                'amount' => rand(200, 1500),
                'change' => rand(-10, 10),
            ],
        ];

       CurrencyMarketUpdateEvent::dispatch($cryptocurrencies);
    }
}
