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
Route::resource('user', 'User\UserController')
    ->only(['store', 'show', 'update', 'destroy']);

//Posts
Route::resource('posts', 'Post\PostController')
    ->only(['index', 'store', 'show', 'update', 'destroy']);

/**
 * Need More routes like - /users/{userId}/posts => specific user's posts
 * There should be APIs for listing all posts with its comments, number of likes, author details. [with eager loading]
 */

//Comments

Route::prefix('comments')->group(function () {
    // this should be like, => /posts/{postId}/comments
    // Naming routes is irrelevant in APIs !! Are you using 'em somewhere ?
    Route::get('/post-comments/{id}', 'Comment\CommentController@getPostComment')->name('post.comments');

    // => /comments/{commentId}/replies
    Route::get('/comment-replies/{id}', 'Comment\CommentController@getCommentReplies')->name('comment.replies');

    // => POST /posts/{postId}/comments
    Route::post('/post-comment/{id}', 'Comment\CommentController@postComment')->name('post.comment.store');

    // => POST /comments/{commentId}/replies
    Route::post('/reply-comment/{id}', 'Comment\CommentController@replyComment')->name('reply.comment.store');

    // PUT OR PATCH /comments/{commentId}
    Route::post('/edit-comment/{id}', 'Comment\CommentController@update')->name('comment.edit');

    // DELETE /comments/{commentId}
    Route::post('/destroy-comment/{id}', 'Comment\CommentController@destroy')->name('comment.delete');
});

/**
 * Should not use POST request every time. Use RESTful Architecture. Read about it.
 */

//likes
Route::prefix('likes')->group(function () {

    // This route is irrelevant, we just need the count. That too should be eager loaded with posts
    Route::get('/post-likes/{id}', 'Like\LikeController@getPostLikes')->name('post.likes');
    Route::get('/comment-likes/{id}', 'Like\LikeController@getCommentLikes')->name('comment.likes');

    // Use PATCH /posts/{postId}/likes => Then toggle => If user haven't liked yet, like it OR ELSE, unlike it
    Route::post('/like-post/{id}', 'Like\LikeController@postLike')->name('post.like.store');

    // Use PATCH /comments/{commentId}/likes => Then toggle => If user haven't liked yet, like it OR ELSE, unlike it
    Route::post('/like-comment/{id}', 'Like\LikeController@commentLike')->name('comment.like.store');
    Route::post('/unlike-post/{id}', 'Like\LikeController@postUnike')->name('post.like.destroy');
    Route::post('/unlike-comment/{id}', 'Like\LikeController@commentUnike')->name('comment.like.destroy');
});
