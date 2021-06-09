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
Route::resource('user','User\UserController')
->only(['store','show','update','destroy']);

Route::resource('user.posts','User\UserPostsController')->only(['index']);

Route::resource('user.comments','User\UserCommentsController')->only(['index']);

Route::resource('user.likes','User\UserLikesController')->only(['index']);

//Posts
Route::resource('posts','Post\PostController')
->only(['index','store','show','update','destroy']);

Route::get('/post/all','Post\PostsCommentsAndLikesController@index')->name('posts.all');

Route::resource('post.comments','Post\PostCommentsController')
->only(['index','store']);

Route::get('post/{postId}/likes','Post\PostLikesController@index');

Route::put('post/{postId}/likes','Post\PostLikesController@toggleLike');


/**
 * Need More routes like - /users/{userId}/posts => specific user's posts
 * There should be APIs for listing all posts with its comments, number of likes, author details. [with eager loading]
 */

//Comments

Route::resource('comment.replies','Comment\CommentRepliesController')
->only(['index','store']);

Route::put('/comments/{commentId}/update','Comment\CommentController@update')->name('comment.edit');

Route::delete('/comments/{commentId}/delete','Comment\CommentController@destroy')->name('comment.delete');

Route::get('/comment/{commentId}/likes','Comment\CommentLikesController@index')->name('posts.like');

Route::put('/comment/{commentId}/likes','Comment\CommentLikesController@toggleLike')->name('comments.like');








