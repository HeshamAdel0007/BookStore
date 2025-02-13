<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\AdminController;
use Modules\Admin\Http\Controllers\AdminSoftDeleteController;

/*
 *--------------------------------------------------------------------------
 * API Routes
 *  Routes Prefix('api/v1/admin/etc...')
 *--------------------------------------------------------------------------
*/

Route::middleware(['auth:sanctum', 'verified', 'role:admin|super-admin', 'ability:admin'])->group(function () {
    Route::controller(AdminController::class)->group(function () {
        Route::get('/profile', 'adminProfile')->name('profile');
        Route::get('/all-admins', 'getAdmins')->name('all');
        Route::get('/all-publishers', 'getPublishers')->name('all.publishers');
        Route::get('/all-customers', 'getCustomers')->name('all.customers');
        Route::get('/show/{type}/{id}', 'showUser')->name('show');
        Route::post('/create', 'createAdmin')->name('create');
        Route::post('/edit/{id}', 'editAdmins')->name('edit');
        Route::post('/edit/publisher/{id}', 'editPublishers')->name('edit.publisher');
        Route::post('/edit/customer/{id}', 'editCustomers')->name('edit.customer');
        Route::delete('/delete/{id}', 'deleteAdmin')->name('delete');
    });

    Route::controller(AdminSoftDeleteController::class)->group(function () {
        Route::delete('/publisher/delete/{id}', 'softDeletePublisher')->name('publisher.softdelete');
        Route::delete('/customer/delete/{id}', 'softDeleteCustomer')->name('customer.softdelete');

        Route::get('/publishers/trash', 'publisherTrashed')->name('publisher.trash');
        Route::get('/customers/trash', 'customerTrashed')->name('customer.trash');

        Route::get('/publisher/restore/{id}', 'restorePublisher')->name('publisher.restore');
        Route::get('/customer/restore/{id}', 'restoreCustomer')->name('customer.restore');

        Route::delete('/publisher/destroy/{id}', 'destroyPublisher')->name('publisher.forcedelete');
        Route::delete('/customer/destroy/{id}', 'destroyCustomer')->name('customer.forcedelete');
    });
});
