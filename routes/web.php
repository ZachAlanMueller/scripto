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

//Basic Routes
Route::get('/', 'BlogController@landing');
Route::get('/profile', 'BlogController@profile');


//Authentication Routes
Auth::routes();
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
//Ajax Routes
Route::post('/ajax/updateUser', 'AjaxController@updateUser');