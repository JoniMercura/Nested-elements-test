<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/', function () {
        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    });

    // Authentication routes
    Route::get('auth/google', [App\Http\Controllers\Auth\LoginController::class, 'redirectToGoogle']);
    Route::get('auth/google/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleGoogleCallback']);
    Route::get('auth/microsoft', [App\Http\Controllers\Auth\LoginController::class, 'redirectToMicrosoft']);
    Route::get('auth/microsoft/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleMicrosoftCallback']);
});
