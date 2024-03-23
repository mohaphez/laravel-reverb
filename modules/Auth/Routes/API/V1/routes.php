<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\V1\API\Auth\AuthController;
use Modules\Auth\Http\Controllers\V1\API\Session\SessionController;

Route::prefix('v1/auth')->as('api.v1.auth.')->group(
    static function (): void {
        Route::post('login', [AuthController::class,'login'])->name('login');
        Route::post('register', [AuthController::class,'register'])->name('register');

        Route::middleware('auth:sanctum')->group(
            static function (): void {
                Route::get('logout', [SessionController::class,'logout'])->name('logout');
            }
        );
    }
);
