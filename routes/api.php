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

//Posts
Route::resource('posts','Post\PostController')
->only(['index','store','show','update','destroy']);

/**
 * Need More routes like - /users/{userId}/posts => specific user's posts
 * There should be APIs for listing all posts with its comments, number of likes, author details. [with eager loading]
 */

//Comments

Route::get('/posts/{postId}/comments','Comment\CommentController@getPostComments')->name('post.comments');

Route::get('/comments/{commentId}/replies','Comment\CommentController@getCommentReplies')->name('comments.replies');

Route::post('/posts/{postId}/comments','Comment\CommentController@postComment')->name('post.comment.store');

Route::post('/comments/{commentId}/replies','Comment\CommentController@postReply')->name('reply.comment.store');

Route::put('/comments/{commentId}','Comment\CommentController@update')->name('comment.edit');

Route::delete('/comments/{commentId}/delete','Comment\CommentController@destroy')->name('comment.delete');


// toggle => If user haven't liked yet, like it OR ELSE, unlike it
Route::patch('/posts/{postId}/likes','Like\LikeController@postLike')->name('posts.like');

Route::patch('/comments/{commentId}/likes','Like\LikeController@commentLike')->name('comments.like');


