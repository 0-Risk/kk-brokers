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
Route::post('v1/register', 'Users\UserController@register');
Route::post('v1/authenticate', 'Users\UserController@authenticate');
Route::get('v1/open', 'TestData\DataController@open');

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('v1/user', 'Users\UserController@getAuthenticatedUser');
    Route::get('v1/closed', 'TestData\DataController@closed');
});


