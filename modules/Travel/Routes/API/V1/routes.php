<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Travel\Http\Controllers\V1\API\Travel\TravelController;
use Modules\User\Http\Controllers\V1\API\Profile\ProfileController;

Route::prefix('v1/travel')
    ->middleware('auth')
    ->as('api.v1.travel.')
    ->group(
        static function (): void {
            Route::get('store', [TravelController::class,'store'])->name('store');
        }
    );
