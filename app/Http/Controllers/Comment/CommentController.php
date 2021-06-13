<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;
use App\Models\Post;

class CommentController extends ApiController
{
   

    
    public function update(Request $request,Comment $comment)
    {
       $user_id=auth()->user()->id;

       if($comment->user_id!=$user_id)
       {  
          return $this->errorResponse("You don't have permission to update this Comment",409);
       }

       if($request->has('body'))
       {
         $comment->update($request->only(['body']));
       }
       
       return $this->showModelAsResponse($comment);
          
    }

    public function destroy(Comment $comment)
    {
       $user_id=auth()->user()->id; 

       if($comment->user_id!=$user_id)
       {  
          return $this->errorResponse("You don't have permission to update this post",409);
       }

       $comment->delete();
       
       return $this->showModelAsResponse($comment);
  
       
    }

}
