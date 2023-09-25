<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

use App\Http\Controllers\Api\Logger\EntityMethodController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/logger/method/{id}/exec', [EntityMethodController::class, 'exec'])
    ->name('api.method.exec');

Route::delete('/logger/method/{id}', [EntityMethodController::class, 'destroy'])
    ->name('api.method.delete');

// comment