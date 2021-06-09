<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;
use App\Models\Post;

class CommentController extends ApiController
{
    public function getPostComments($postId)
    {
       $comments=Post::findOrFail($postId)->comments;   
       return $this->showCollectionAsResponse($comments);
    }

    public function getCommentReplies($commentId)
    {
       $replies=Comment::findOrFail($commentId)->replies;   
       return $this->showCollectionAsResponse($replies);
    }

    public function postComment(Request $request,$postId)
    {
       $post=Post::findOrFail($postId);
       if($post && $request->has('body'))
       {
            //user id needs to be replaced
            $comment=$post->comments()->create(['body'=>$request->body,'user_id'=>1]);
            return $this->showModelAsResponse($comment);
       }
       return $this->errorResponse("Post not found",404);

    }

    public function postReply(Request $request,$commentId)
    {
       $comment=Comment::findOrFail($commentId);
       if($comment && $request->has('body'))
       {
            //user id needs to be replaced
            $reply=$comment->replies()->create(['body'=>$request->body,'user_id'=>1]);
            return $this->showModelAsResponse($reply);
       }
       return $this->errorResponse("Comment not found",404);
    }


    public function update(Request $request,$commentId)
    {
       $comment=Comment::findOrFail($commentId);
       if($comment && $request->has('body'))
       {
            $comment->update($request->only(['body']));
            return $this->showModelAsResponse($comment);
       }
       return $this->errorResponse("Comment does'nt exist",404);
       
    }

    public function destroy($commentId)
    {
       $comment=Comment::findOrFail($commentId);
       $comment->delete();
       return $this->showModelAsResponse($comment);
    }

}
