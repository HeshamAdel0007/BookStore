<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Roles\Http\Controllers\RolesController;

/*
 *--------------------------------------------------------------------------
 * Routes Prefix('api/v1/etc...')
 *--------------------------------------------------------------------------
*/

// Route::middleware(['auth:sanctum', 'verified', 'role:admin|super-admin', 'ability:admin'])->group(function () {
//     Route::controller(RolesController::class)->group(function () {
//         Route::get('/permissions', 'getAllPermissions')->name('permissions');
//     });
// });
Route::middleware(['auth:sanctum', 'verified', 'role:admin|super-admin', 'ability:admin'])->prefix('v1')->group(function () {
    Route::controller(RolesController::class)->group(function () {
        Route::get('/permissions', 'getAllPermissions')->name('permissions');
    });
});
