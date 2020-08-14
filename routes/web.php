<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::get('/', function () {
    return view('welcome');
})->name('welcome.login');

Route::get('/logout', function(){
    Auth::logout();
    return Redirect::to('/');
 });

Route::post('login/custom', 'Users\AuthenticateController@loginUser')->name('login.custom');
//ADMIN ROUTES
Route::group(['middleware' => ['role:Administrator']], function() {
    Route::get('clients/dashboard', 'HomeController@index')->name('home.clients');
    Route::get('create/new/client', 'Users\UserController@addClient')->name('create.client.view');
    Route::post('create/client', 'Users\UserController@createNewClient')->name('create.client');
    Route::get('edit/client/{user_id}', 'Users\UserController@editClient')->name('create.client.edit');
    Route::get('client/deactivate/{user_id}', 'Users\UserController@DeactivateClient')->name('create.client.deactivate');
    Route::get('client/activate/{user_id}', 'Users\UserController@activateClient')->name('create.client.activate');
    Route::post('client/update', 'Users\UserController@updateClient')->name('create.client.update');
    Route::get('activity-logs', 'Log\ActivityLogController@index')->name('system.log');
});
