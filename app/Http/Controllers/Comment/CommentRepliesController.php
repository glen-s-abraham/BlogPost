<?php

namespace App\Http\Controllers\Comment;

use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Http\Controllers\ApiController;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentRepliesController extends ApiController
{
    private $commentRepositoryInterface;
    
    public function __construct(CommentRepositoryInterface $commentRepositoryInterface)
    {
        $this->commentRepositoryInterface=$commentRepositoryInterface;
    }

    public function index($commentId)
    {
        $replies=$this->commentRepositoryInterface->getCommentReplies($commentId);
        return $this->showCollectionAsResponse($replies);
    }


    public function store(Request $request,$commentId)
    {
        if($request->has('body'))
        {
            $data=$request->only(['body']);
            $data['user_id']=auth()->user()->id;
            $reply=$this->commentRepositoryInterface->createCommentreply($commentId,$data);
            return $this->showModelAsResponse($reply);
        }
        return $this->errorResponse("No data Given",422);
    }
}
