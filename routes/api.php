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



//User related end points
Route::post('user/register','User\UserController@store');
Route::post('user/login','User\UserController@login');
Route::get('user/{user}/posts','User\UserPostsController@index');

//Post related endpoints
Route::get('post','Post\PostController@index');
Route::get('post/{post}','Post\PostController@show');
Route::get('post/{post}/comments','Post\PostCommentsController@index');
Route::get('post/{post}/likes','Post\PostLikesController@index');
Route::get('post/all','Post\PostsCommentsAndLikesController@index');

//Comment related
Route::get('comment/{comment}/replies','Comment\CommentRepliesController@index');
Route::get('comment/{comment}/likes','Comment\CommentLikesController@index');

Route::group(['middleware' => ['auth:sanctum']], function () {
    //User Related endpoints
    Route::get('user/profile','User\UserController@show');
    Route::put('user/profile/update','User\UserController@update');
    Route::delete('user/profile/delete','User\UserController@destroy');
    Route::get('user/logout','User\UserController@logout');
    Route::get('user/comments','User\UserCommentsController@index');
    Route::get('user/likes','User\UserLikesController@index');


    //Post Related Endpoints
    Route::post('post/create','Post\PostController@store');
    Route::put('post/{post}/update','Post\PostController@update');
    Route::delete('post/{post}/delete','Post\PostController@destroy');
    Route::post('post/{post}/comment','Post\PostCommentsController@store');
    Route::put('post/{post}/like','Post\PostLikesController@toggleLike');

    //Comment Related Endpoints
    Route::post('comment/{comment}/reply','Comment\CommentRepliesController@store');
    Route::put('comment/{comment}/update','Comment\CommentController@update');
    Route::delete('comment/{comment}/delete','Comment\CommentController@update');
    Route::put('comment/{comment}/like','Comment\CommentLikesController@toggleLike');

});










