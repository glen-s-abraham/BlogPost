<?php

namespace App\Http\Controllers\Like;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Models\Like;
use App\Models\Post;
use App\Models\Comment;

class LikeController extends ApiController
{

    public function getPostLikes($postId)
    {
       $likes=Post::findOrFail($postId)->likes->count();
       return $this->successResponse(["likes"=>$likes],200);
    }

    public function getCommentLikes($commentId)
    {
       $likes=Comment::findOrFail($commentId)->likes()->count();
       return $this->successResponse(["likes"=>$likes],200);
    }

    public function togglePostLikes($postId)
    {
        $user_id=1;//test case,needs to be replaced with authenticated user

        $post=Post::findOrFail($postId);
        $liked=$post->likes()->where('user_id',$user_id)->get()->count();
        if($liked==0)
        {
            $post->likes()->create(['user_id'=>$user_id]);
            return $this->successResponse(["message"=>"Post Liked"],200);
        }
        $post->likes()->where('user_id',$user_id)->delete();
        return $this->successResponse(["message"=>"Post Unliked"],200);
    }

    public function toggleCommentLikes($commentId)
    {
        $user_id=1;//test case,needs to be replaced with authenticated user

        $comment=Comment::findOrFail($commentId);
        $liked=$comment->likes()->where('user_id',$user_id)->get()->count();
        if($liked==0)
        {
            $comment->likes()->create(['user_id'=>$user_id]);
            return $this->successResponse(["message"=>"Comment Liked"],200);
        }
        $comment->likes()->where('user_id',$user_id)->delete();
        return $this->successResponse(["message"=>"Comment Unliked"],200);
        return($liked);
    }


}
