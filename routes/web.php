<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('api', 'documentation\SampleController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('oauth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('oauth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');