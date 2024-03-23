<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\V1\API\Profile\ProfileController;

Route::prefix('v1/profile')
    ->middleware('auth:sanctum')
    ->as('api.v1.profile.')
    ->group(
        static function (): void {
            Route::get('profile', [ProfileController::class,'show'])->name('show');
            Route::put('profile', [ProfileController::class,'update'])->name('update');
        }
    );
