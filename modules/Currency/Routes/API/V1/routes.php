<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Currency\Http\Controllers\V1\API\WebhookController;

Route::prefix('v1/webhook')
    ->as('api.v1.webhook.')
    ->controller(WebhookController::class)
    ->group(
        static function (): void {
            Route::get('handle', 'handle')->name('handle');
        }
    );
