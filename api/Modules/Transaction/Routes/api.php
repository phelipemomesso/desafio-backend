<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'transaction', 'as' => 'transaction.', 'middleware' => ['auth:api']], function () {
    Route::apiResource('transactions', 'TransactionController', ['except' => ['update']]);
    Route::post('/export', ['as' => 'export', 'uses' => 'TransactionController@export']);
});
