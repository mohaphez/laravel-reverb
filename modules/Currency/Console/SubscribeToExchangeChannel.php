<?php

declare(strict_types=1);

namespace Modules\Currency\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use Modules\Currency\Events\V1\CurrencyMarketUpdateEvent;
use Predis\Connection\ConnectionException;
use Exception;

class SubscribeToExchangeChannel extends Command
{
    protected $name = 'redis:subscribe-exchange';

    protected $description = 'Subscribe to exchanges channel.';

    protected const BINANCE_CHANNEL = 'binance';
    protected const KUCOIN_CHANNEL = 'kucoin';

    protected array $currencyPairs = [];

    protected array $defaultPairs = [
        'BTCUSDT', 'ETHUSDT', 'LTCUSDT', 'XRPUSDT', 'DOGEUSDT',
        'ADAUSDT', 'DOTUSDT', 'XLMUSDT', 'LINKUSDT', 'BNBUSDT'
    ];

    public function __construct()
    {
        parent::__construct();
        $this->initializeCurrencyPairs();
    }

    public function handle(): void
    {
        try {
            $this->connectToRedis();
            $this->info('Redis connected.');
            $this->subscribeToChannels();
        } catch (ConnectionException $e) {
            $this->error('Error connecting to Redis: '.$e->getMessage());
        }
    }

    protected function initializeCurrencyPairs(): void
    {
        foreach ([$this::BINANCE_CHANNEL, $this::KUCOIN_CHANNEL] as $exchange) {
            foreach ($this->defaultPairs as $pair) {
                $this->currencyPairs[$exchange][$pair] = [
                    'currency' => explode('USDT', $pair)[0],
                    'amount'   => 0,
                    'change'   => 0,
                ];
            }
        }
    }

    protected function connectToRedis(): void
    {
        Redis::connect('redis', 6379);
    }

    protected function subscribeToChannels(): void
    {
        Redis::psubscribe(['exchange-*'], function ($message, $channel): void {
            $this->info("Data received from Redis {$channel} channel");
            try {
                $currency = $this->processMessage($message, $channel);
                $this->updateCurrencyPair($currency, $channel);
                CurrencyMarketUpdateEvent::dispatch($this->currencyPairs, $channel);
            } catch (Exception $e) {
                $this->error($e);
            }
        });
    }

    protected function processMessage($message, $channel): array
    {
        $messageArray = json_decode($message, true);
        $data = [];

        if (str_contains($channel, self::BINANCE_CHANNEL)) {
            $amountFormatNumber = $messageArray['c'] > 10000 ? 1 : 3;
            $data = [
                'currency' => $messageArray['s'],
                'amount'   => number_format($messageArray['c'], $amountFormatNumber),
                'change'   => $messageArray['P'],
            ];
        } elseif (str_contains($channel, self::KUCOIN_CHANNEL)) {
            $amountFormatNumber = $messageArray['data']['data']['close'] > 10000 ? 1 : 3;
            $data = [
                'currency' => $messageArray['data']['data']['baseCurrency'].'USDT',
                'amount'   => number_format($messageArray['data']['data']['close'], $amountFormatNumber),
                'change'   => $messageArray['data']['data']['changeRate'],
            ];
        }

        return $data;
    }

    protected function updateCurrencyPair(array $currency, string $channel): void
    {
        $exchange = str_replace('exchange-', '', $channel);
        $this->currencyPairs[$exchange][$currency['currency']] = $currency;
    }
}
