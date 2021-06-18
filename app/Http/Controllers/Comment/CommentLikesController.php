<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentLikesController extends ApiController
{
    public function index(Comment $comment)
    {
        $likes=$comment->likes;
        return $this->successResponse(["likes"=>$likes],200);
    }

   
   
    public function toggleLike(Comment $comment)
    {
        $user_id=auth()->user()->id;

        $liked=$comment->likes()->where('user_id',$user_id)->get()->count();
        if($liked==0)
        {
            $comment->likes()->create(['user_id'=>$user_id]);
            return $this->successResponse(["message"=>"Comment Liked"],200);
        }
        $comment->likes()->where('user_id',$user_id)->delete();
        return $this->successResponse(["message"=>"Comment Unliked"],200);
        
    }
}
