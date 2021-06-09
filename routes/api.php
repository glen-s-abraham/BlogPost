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

//Likes

//test purposes
Route::get('/posts/{postId}/likes','Like\LikeController@getPostLikes')->name('posts.like');

Route::get('/comments/{commentId}/likes','Like\LikeController@getCommentLikes')->name('posts.like');

// toggle => If user haven't liked yet, like it OR ELSE, unlike it

Route::put('/posts/{postId}/likes','Like\LikeController@togglePostlikes')->name('posts.like');

Route::put('/comments/{commentId}/likes','Like\LikeController@toggleCommentLikes')->name('comments.like');


