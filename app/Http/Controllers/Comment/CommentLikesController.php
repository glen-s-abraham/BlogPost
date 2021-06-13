<?php

namespace App\Http\Controllers\Comment;

use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentLikesController extends ApiController
{

    private $commentRepositoryInterface;
    
    public function __construct(CommentRepositoryInterface $commentRepositoryInterface)
    {
        $this->commentRepositoryInterface=$commentRepositoryInterface;
    }

    public function index($commentId)
    {
        $likes=$this->commentRepositoryInterface->getCommentLikes($commentId);
        return $this->successResponse(["likes"=>$likes],200);
    }

   
   
    public function toggleLike($commentId)
    {
        $userId=auth()->user()->id;
        $likeStatus=$this->commentRepositoryInterface->likeOrUnlikeComment($userId,$commentId);
        return $this->successResponse([$likeStatus],200);
        
    }
}
