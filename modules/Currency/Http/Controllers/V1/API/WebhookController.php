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
            'XRP' => [
                'currency' => 'XRP',
                'amount' => rand(10, 100),
                'change' => rand(-10, 10),
            ],
            'BCH' => [
                'currency' => 'BCH',
                'amount' => rand(100, 1000),
                'change' => rand(-10, 10),
            ],
            'ADA' => [
                'currency' => 'ADA',
                'amount' => rand(20, 200),
                'change' => rand(-10, 10),
            ],
            'DOT' => [
                'currency' => 'DOT',
                'amount' => rand(5, 50),
                'change' => rand(-10, 10),
            ],
            'XLM' => [
                'currency' => 'XLM',
                'amount' => rand(10, 200),
                'change' => rand(-10, 10),
            ],
            'LINK' => [
                'currency' => 'LINK',
                'amount' => rand(50, 500),
                'change' => rand(-10, 10),
            ],
            'BNB' => [
                'currency' => 'BNB',
                'amount' => rand(100, 1000),
                'change' => rand(-10, 10),
            ],
            'USDT' => [
                'currency' => 'USDT',
                'amount' => rand(500, 5000),
                'change' => rand(-10, 10),
            ],
            'DOGE' => [
                'currency' => 'DOGE',
                'amount' => rand(10, 1000),
                'change' => rand(-10, 10),
            ],
            'UNI' => [
                'currency' => 'UNI',
                'amount' => rand(10, 200),
                'change' => rand(-10, 10),
            ],
            'WBTC' => [
                'currency' => 'WBTC',
                'amount' => rand(50, 500),
                'change' => rand(-10, 10),
            ],
            'AAVE' => [
                'currency' => 'AAVE',
                'amount' => rand(20, 200),
                'change' => rand(-10, 10),
            ],
            'ATOM' => [
                'currency' => 'ATOM',
                'amount' => rand(30, 300),
                'change' => rand(-10, 10),
            ],
            'XTZ' => [
                'currency' => 'XTZ',
                'amount' => rand(10, 100),
                'change' => rand(-10, 10),
            ],
            'SUSHI' => [
                'currency' => 'SUSHI',
                'amount' => rand(20, 200),
                'change' => rand(-10, 10),
            ],
            'SNX' => [
                'currency' => 'SNX',
                'amount' => rand(20, 200),
                'change' => rand(-10, 10),
            ],
            'FTT' => [
                'currency' => 'FTT',
                'amount' => rand(50, 500),
                'change' => rand(-10, 10),
            ],
            'RUNE' => [
                'currency' => 'RUNE',
                'amount' => rand(10, 100),
                'change' => rand(-10, 10),
            ],
            'MKR' => [
                'currency' => 'MKR',
                'amount' => rand(10, 100),
                'change' => rand(-10, 10),
            ],
            'COMP' => [
                'currency' => 'COMP',
                'amount' => rand(10, 100),
                'change' => rand(-10, 10),
            ],
            'CPR' => [
                'currency' => 'MKR',
                'amount' => rand(10, 100),
                'change' => rand(-10, 10),
            ],
            'CLAP' => [
                'currency' => 'COMP',
                'amount' => rand(10, 100),
                'change' => rand(-10, 10),
            ],
        ];

        CurrencyMarketUpdateEvent::dispatch($cryptocurrencies);

    }
}
