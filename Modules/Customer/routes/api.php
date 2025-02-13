<?php

use Illuminate\Support\Facades\Route;
use Modules\Customer\Http\Controllers\CustomerController;

/*
 *--------------------------------------------------------------------------
 * API Routes
 * Routes Prefix ('api/v1/customer/etc.....')
 *--------------------------------------------------------------------------
*/

Route::middleware(['auth:sanctum'])->group(function () {
    Route::controller(CustomerController::class)->group(function () {
        Route::get('orders',  'orders')->name('orders');
    });
});
