<?php

use Illuminate\Support\Facades\Route;
use Modules\Category\Http\Controllers\CategoryController;

/*
 *--------------------------------------------------------------------------
 * API Routes
 * Routes Prefix('api/v1/etc...')
 *--------------------------------------------------------------------------
*/

Route::middleware(['auth:sanctum', 'verified', 'role:super-admin|admin', 'ability:admin'])->group(function () {
    Route::controller(CategoryController::class)->group(function () {
        Route::post('category/create', 'store')->name('create');
        Route::get('show/category/{id}', 'show')->name('show');
        Route::post('category/edit/{id}', 'update')->name('update');
        Route::delete('category/delete/{id}', 'destroy')->name('delete');
    });
});
Route::middleware(['auth:sanctum', 'verified', 'role:super-admin|admin|publisher'])->group(function () {
    Route::get('categories', [CategoryController::class, 'index'])->name('categories');
});
