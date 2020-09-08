<?php

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

Route::group(['prefix' => 'user', 'as' => 'user.', 'middleware' => ['auth:api']], function () {
    Route::apiResource('users', 'UserController');
    Route::put('{user}/initial-amount', ['as' => 'update-initial-amount', 'uses' => 'UserController@updateInitialAmount']);
});
