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

//Comments

Route::prefix('comments')->group(function(){

    Route::get('/post-comments/{id}','Comment\CommentController@getPostComment')->name('post.comments');
    Route::get('/comment-replies/{id}','Comment\CommentController@getCommentReplies')->name('comment.replies');
    Route::post('/post-comment/{id}','Comment\CommentController@postComment')->name('post.comment.store');
    Route::post('/reply-comment/{id}','Comment\CommentController@replyComment')->name('reply.comment.store');
    Route::post('/edit-comment/{id}','Comment\CommentController@update')->name('comment.edit');
    Route::post('/destroy-comment/{id}','Comment\CommentController@destroy')->name('comment.delete');
});

//likes
Route::prefix('likes')->group(function(){
    Route::get('/post-likes/{id}','Like\LikeController@getPostLikes')->name('post.likes');
    Route::get('/comment-likes/{id}','Like\LikeController@getCommentLikes')->name('comment.likes');
    Route::post('/like-post/{id}','Like\LikeController@postLike')->name('post.like.store');
    Route::post('/like-comment/{id}','Like\LikeController@commentLike')->name('comment.like.store');
    Route::post('/unlike-post/{id}','Like\LikeController@postUnike')->name('post.like.destroy');
    Route::post('/unlike-comment/{id}','Like\LikeController@commentUnike')->name('comment.like.destroy');
});
    
