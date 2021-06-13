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
Route::get('post/all','Post\PostsCommentsAndLikesController@index');
Route::get('post/{postId}','Post\PostController@show');
Route::get('post/{postId}/comments','Post\PostCommentsController@index');
Route::get('post/{postId}/likes','Post\PostLikesController@index');


//Comment related
Route::get('comment/{commentId}/replies','Comment\CommentRepliesController@index');
Route::get('comment/{commentId}/likes','Comment\CommentLikesController@index');

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
    Route::put('post/{postId}/update','Post\PostController@update');
    Route::delete('post/{postId}/delete','Post\PostController@destroy');
    Route::post('post/{postId}/comment','Post\PostCommentsController@store');
    Route::put('post/{postId}/like','Post\PostLikesController@toggleLike');

    //Comment Related Endpoints
    Route::post('comment/{commentId}/reply','Comment\CommentRepliesController@store');
    Route::put('comment/{commentId}/update','Comment\CommentController@update');
    Route::delete('comment/{commentId}/delete','Comment\CommentController@destroy');
    Route::put('comment/{commentId}/like','Comment\CommentLikesController@toggleLike');

});










