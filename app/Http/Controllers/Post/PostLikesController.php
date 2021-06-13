<?php

namespace App\Http\Controllers\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class PostLikesController extends ApiController
{
    private $postRepositoryInterface;
    
    public function __construct(PostRepositoryInterface $postRepositoryInterface)
    {
        $this->postRepositoryInterface=$postRepositoryInterface;
    }

    public function index($postId)
    {
        $likes=$this->postRepositoryInterface->getPostLikes($postId);
        return $this->successResponse(["likes"=>$likes],200);
    }

   
   
    public function toggleLike($postId)
    {
        $userId=auth()->user()->id;
        $likeStatus=$this->postRepositoryInterface->likeOrUnlikePost($userId,$postId);
        return $this->successResponse([$likeStatus],200);
       
    }
}
