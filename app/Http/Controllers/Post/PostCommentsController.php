<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\ApiController;
use App\Models\Post;
use Illuminate\Http\Request;

class PostCommentsController extends ApiController
{
   
    public function index(Post $post)
    {
        $comments=$post->comments;
        return $this->showCollectionAsResponse($comments);
    }


    public function store(Request $request,Post $post)
    {
        if($request->has('body'))
        {
            $user_id=auth()->user()->id;
            $comment=$post->comments()->create(['body'=>$request->body,'user_id'=>$user_id]);
            return $this->showModelAsResponse($comment);
        }
        return $this->errorResponse("Post not found",404);
    }

   
}
