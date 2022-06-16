<?php

use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
*/

Route::prefix('/v1')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{userId}', [UserController::class, 'show'])->name('users.show');
    /* Ideally a PUT but limitations of framework/php require post */
    Route::post('/users/{userId}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{userId}', [UserController::class, 'destroy'])->name('users.destroy');
});
