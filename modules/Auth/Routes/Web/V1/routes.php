<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\V1\Web\Auth\VerificationController;

Route::get('email/verify', [VerificationController::class, 'verify'])->name('verification.verify');
Route::get('email/resend', [VerificationController::class,'resend'])->name('verification.resend');
