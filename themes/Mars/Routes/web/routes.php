<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Themes\Mars\Http\Controllers\V1\Auth\LoginController;
use Themes\Mars\Http\Controllers\V1\Client\DashboardController;
use Themes\Mars\Http\Controllers\V1\Currency\CurrencyController;
use Themes\Mars\Http\Controllers\V1\Document\DocumentController;
use Themes\Mars\Http\Controllers\V1\Travel\TravelController;

Route::get('/',       [LoginController::class,'show'])->name('home');
Route::post('/login', [LoginController::class,'login'])->name('auth.login');
Route::get('/login',  [LoginController::class,'show'])->name('login');

Route::group(['middleware' => 'auth'], function (): void {
    Route::get('/logout',   [LoginController::class,'logout'])->name('auth.logout');
    Route::get('dashboard', DashboardController::class)->name('client.dashboard');
});

Route::group(['middleware' => 'auth'], function (): void {
    Route::get('/travel',   [TravelController::class,'show'])->name('travel');
});

Route::group(['middleware' => 'auth'], function (): void {
    Route::get('/currency', [CurrencyController::class,'currency'])->name('currency');
});

Route::group(['middleware' => 'auth'], function (): void {
    Route::get('/document', [DocumentController::class,'document'])->name('document');
});
