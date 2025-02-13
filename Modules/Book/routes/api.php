<?php

use Illuminate\Support\Facades\Route;
use Modules\Book\Http\Controllers\BookController;

/*
 *--------------------------------------------------------------------------
 * API Routes
 * Routes Prefix('api/v1/etc...')
 *--------------------------------------------------------------------------
*/

Route::middleware(['auth:sanctum', 'verified', 'role:super-admin|publisher', 'ability:publisher'])
    ->prefix('publisher/book')->group(function () {
        Route::controller(BookController::class)->group(function () {
            Route::post('create', 'store')->name('create');
            Route::get('show/{id}', 'show')->name('show');
            Route::post('edit/{id}', 'edit')->name('edit');
            Route::delete('delete/{id}', 'softDelete')->name('softdelete');
            Route::get('/trash', 'trash')->name('trash');
            Route::get('/restore/{id}', 'restore')->name('restore');
            Route::delete('/destroy/{id}', 'destroy')->name('forcedelete');
        });
    });

Route::get('books', [BookController::class, 'books'])->name('all');
