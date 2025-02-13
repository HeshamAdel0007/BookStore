<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\AuthController;
use Modules\Auth\Http\Controllers\VerifyEmailController;
use Modules\Auth\Http\Controllers\RegisteredUserController;
use Modules\Auth\Http\Controllers\ResetCodePasswordController;
use Modules\Auth\Http\Controllers\AuthenticatedSessionController;
use Modules\Auth\Http\Controllers\EmailVerificationNotificationController;

/*
 *--------------------------------------------------------------------------
 * Authentication Routes
 * Routes Prefix('api/v1/auth/etc...')
 *--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::post('/login/{type}', [AuthenticatedSessionController::class, 'login'])->name('login');
    Route::post('/register/publisher', [RegisteredUserController::class, 'storePublisher'])->name('register.publisher');
    Route::post('/register/customer', [RegisteredUserController::class, 'storeCustomer'])->name('register.customer');
    Route::post('/forgot-password/{type}', [ResetCodePasswordController::class, 'forgotPassword'])->name('password.email');
    Route::post('/reset-password/{type}', [ResetCodePasswordController::class, 'resetPassword'])->name('password.reset');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get(
        '/verify-email/{id}/{hash}',
        VerifyEmailController::class
    )->middleware(['signed', 'throttle:6,1'])->name('verification.verify');

    Route::get(
        '/email/verification',
        [EmailVerificationNotificationController::class, 'store']
    )->middleware('throttle:6,1')->name('verification.send');

    Route::post('/logout', [AuthenticatedSessionController::class, 'userLogout'])->name('logout');
});

/*
 *--------------------------------------------------------------------------
 * Routes Prefix('api/v1/auth/info/etc...')
 *--------------------------------------------------------------------------
*/

Route::controller(AuthController::class)
    ->middleware(['auth:sanctum', 'verified'])
    ->prefix('info')->name('api.auth.')
    ->group(function () {
        Route::get('/admin', 'admin')
            ->middleware('role:admin')->name('admin.info');

        Route::get('/publisher', 'publisher')
            ->middleware('role:publisher')->name('publisher.info');

        Route::get('/customer', 'customer')
            ->middleware('role:customer')->name('customer.info');
    });
