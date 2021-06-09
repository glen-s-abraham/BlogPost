<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentLikesController extends ApiController
{
    public function index($commentId)
    {
        $likes=Comment::findOrFail($commentId)->likes()->count();
       return $this->successResponse(["likes"=>$likes],200);
    }

   
   
    public function toggleLike($commentId)
    {
        $user_id=9;//test case,needs to be replaced with authenticated user

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
