<?php

use Illuminate\Support\Facades\Route;
use Modules\Publisher\Http\Controllers\PublisherController;

/*
 *--------------------------------------------------------------------------
 * API Routes
 *  Routes Prefix('api/v1/publisher/etc...')
 *--------------------------------------------------------------------------
*/

Route::middleware(['auth:sanctum', 'verified', 'role:super-admin|publisher', 'ability:publisher'])
    ->prefix('publisher')->group(function () {
        Route::controller(PublisherController::class)->group(function () {
            Route::get('/publisher',  'getPublisher')->name('publisher');
            Route::get('/publisher/books',  'getPublisherBooks')->name('publisher.books');
            Route::get('/publisher/orders',  'getPublisherOrders')->name('publisher.orders');
            Route::get('/publisher/order/info/{orderID}',  'getOrdersInfo')->name('publisher.order.info');
            Route::post('/edit/{id}', 'editPublisher')->name('edit');
            Route::delete('/delete/{id}',  'delete')->name('delete');
        });
    });

/*
 *--------------------------------------------------------------------------
 *  Routes Prefix('api/v1/user/etc...')
 *--------------------------------------------------------------------------
*/
Route::middleware('guest')->prefix('user')->group(function () {
    Route::get('/show/publisher/{id}', [PublisherController::class, 'showPublisher'])->name('show');
});
