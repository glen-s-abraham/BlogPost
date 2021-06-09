<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;
use App\Models\Post;

class CommentController extends ApiController
{
   

    
    public function update(Request $request,$commentId)
    {
       $user_id=2;//test case,need to change according to loggin in user 

       $owncomment=Comment::where('user_id',$user_id)
       ->where('id',$commentId)
       ->count();

       if($owncomment)
       {  
          $comment=Comment::findOrFail($commentId);
          if($comment && $request->has('body'))
          {
               $comment->update($request->only(['body']));
               return $this->showModelAsResponse($comment);
          }
          return $this->errorResponse("No updates given",404);
       }
       return $this->errorResponse("Object not found",404);
       
    }

    public function destroy($commentId)
    {
       $user_id=2;//test case,need to change according to loggin in user 

       $owncomment=Comment::where('user_id',$user_id)
       ->where('id',$commentId)
       ->count();

       if($owncomment)
       {
         $comment=Comment::findOrFail($commentId);
         $comment->delete();
         return $this->showModelAsResponse($comment);
       }
       return $this->errorResponse("Object not found",404);
       
    }

}
