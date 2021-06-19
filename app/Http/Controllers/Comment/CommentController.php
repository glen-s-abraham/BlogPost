<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\ApiController;
use App\Transformers\CommentTransformer;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;
use App\Models\Post;

class CommentController extends ApiController
{
   
   public function __construct()
    {
        parent::__construct();
        $this->middleware('transform.input:'.CommentTransformer::class)->only(['store','update']);
    }
    
    public function update(Request $request,Comment $comment)
    {
       

       if(auth()->user()->cannot('update',$comment))
       {  
          return $this->errorResponse("You don't have permission to update this post",409);
       }

       if($request->has('body'))
       {
         $comment->update($request->only(['body']));
       }
       
       return $this->showModelAsResponse($comment);
          
    }

    public function destroy(Comment $comment)
    {
       

       if(auth()->user()->cannot('delete',$post))
       {  
          return $this->errorResponse("You don't have permission to update this post",409);
       }

       $comment->delete();
       
       return $this->showModelAsResponse($comment);
  
       
    }

}
