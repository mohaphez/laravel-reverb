<?php

namespace Themes\Mars\Http\Controllers\V1\Currency;

use Modules\Base\Http\Controllers\API\V1\BaseAPIController;
use Modules\Currency\Events\API\V1\CurrencyMarketUpdateEvent;

// use Modules\Currency\Events\Api\V1\CurrencyMarketUpdateEvent;

class CurrencyController extends BaseAPIController
{
    public function currencyDispatch()
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

    public function currency()
    {
        return view("currency.index");
    }
}
