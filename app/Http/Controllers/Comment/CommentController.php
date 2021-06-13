<?php

namespace App\Http\Controllers\Comment;

use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;


class CommentController extends ApiController
{
   
    private $commentRepositoryInterface;
    
    public function __construct(CommentRepositoryInterface $commentRepositoryInterface)
    {
        $this->commentRepositoryInterface=$commentRepositoryInterface;
    }
    
    public function update(Request $request,$commentId)
    {
       

       if(!$this->commentRepositoryInterface->isCommentOwner(auth()->user()->id,$commentId))
        {
            return $this->errorResponse("You don't have permission to update this comment",409);   
        }

       if($request->has('body'))
        {
            $data=$request->only(['body']);
            $comment=$this->commentRepositoryInterface->updateExistingComment($commentId,$data);
            return $this->showModelAsResponse($comment);
        }
        return $this->errorResponse("No data Given",422);
          
    }

    public function destroy($commentId)
    {

        if(!$this->commentRepositoryInterface->isCommentOwner(auth()->user()->id,$commentId))
         {
            return $this->errorResponse("You don't have permission to update this comment",409);   
         }

        $comment=$this->commentRepositoryInterface->deleteExistingComment($commentId);
        return $this->successResponse(['message'=>'Removed Comment'],200);
  
       
    }

}
