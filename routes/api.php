<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Users


Route::post('user/register','User\UserController@store');
Route::post('user/login','User\UserController@login')->name('login');



Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('user/profile','User\UserController@show');
    Route::put('user/profile/update','User\UserController@update');
    Route::delete('user/profile/delete','User\UserController@destroy');
    Route::get('user/logout','User\UserController@logout');

});










