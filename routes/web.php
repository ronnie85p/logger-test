<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use App\Http\Controllers\Logger\EntityMethodController;

Route::resource('/logger/method', EntityMethodController::class)
    ->parameter('method', 'id')
    ->names([ 
        'index'   => 'method.list', 
        'edit'    => 'method.edit',
        'create'  => 'method.create',
        'store'   => 'method.store',
        'update'  => 'method.update',
        'destroy' => 'method.delete'
    ])
    ->except(['show', 'edit']);

Route::get('/', [EntityMethodController::class, 'index']);
