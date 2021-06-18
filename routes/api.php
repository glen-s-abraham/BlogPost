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
Route::get('user/profile/{user}','User\UserController@show')->name('user.show');
Route::get('user/{user}/posts','User\UserPostsController@index')->name('user.posts.index');
Route::get('user/{user}/comments','User\UserCommentsController@index')->name('user.comments.index');
Route::get('user/{user}/likes','User\UserLikesController@index')->name('user.likes.index');

//Post related endpoints
Route::get('post','Post\PostController@index')->name('post.index');
Route::get('post/all','Post\PostsCommentsAndLikesController@index')->name('post.all');
Route::get('post/{post}','Post\PostController@show')->name('post.show');
Route::get('post/{post}/comments','Post\PostCommentsController@index')->name('post.comments.index');
Route::get('post/{post}/likes','Post\PostLikesController@index')->name('post.likes.index');


//Comment related
Route::get('comment/{comment}/replies','Comment\CommentRepliesController@index')->name('comment.replies.index');
Route::get('comment/{comment}/likes','Comment\CommentLikesController@index')->name('comment.likes.index');

Route::group(['middleware' => ['auth:sanctum']], function () {
    //User Related endpoints
    Route::get('user/profile','User\UserController@profile')->name('user.profile');
    Route::put('user/profile/update','User\UserController@update');
    Route::delete('user/profile/delete','User\UserController@destroy');
    Route::get('user/logout','User\UserController@logout')->name('user.logout');
    


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










