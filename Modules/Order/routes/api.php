<?php

use Illuminate\Support\Facades\Route;
use Modules\Order\Http\Controllers\CouponController;
use Modules\Order\Http\Controllers\OrderController;

/*
 *--------------------------------------------------------------------------
 * API Routes
 *--------------------------------------------------------------------------
*/

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::controller(OrderController::class)->group(function () {
        Route::get('customer/order/{id}',  'order')->name('order');
        Route::post('order',  'createOrder')->name('order.create');
        Route::get('payment/info/{id}',  'paymentInfo')->name('payment.info');
        Route::post('payment/{orderID}',  'payment')->name('payment');
        Route::post('discount/{bookID}',  'create')->name('discount.create');
    });
    Route::controller(CouponController::class)->group(function () {
        Route::get('coupon/{code}',  'check')->name('coupon.check');
        Route::post('coupon/create',  'create')->name('coupon.create');
    });
});
