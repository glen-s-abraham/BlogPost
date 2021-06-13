<?php

namespace App\Http\Controllers\Post;


use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class PostCommentsController extends ApiController
{

    private $postRepositoryInterface;
    
    public function __construct(PostRepositoryInterface $postRepositoryInterface)
    {
        $this->postRepositoryInterface=$postRepositoryInterface;
    }
   
    public function index($postId)
    {
        $comments=$this->postRepositoryInterface->getPostComments($postId);
        return $this->showCollectionAsResponse($comments);
    }


    public function store(Request $request,$postId)
    {
        if($request->has('body'))
        {
            $data=$request->only(['body']);
            $data['user_id']=auth()->user()->id;
            $comment=$this->postRepositoryInterface->createPostComment($postId,$data);
            return $this->showModelAsResponse($comment);
        }
        return $this->errorResponse("No data Given",422);
        
    }

   
}
