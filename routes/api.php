<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes for offersonairlines.com
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {
    Route::post('/login', [AdminController::class, 'login']);
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
});
