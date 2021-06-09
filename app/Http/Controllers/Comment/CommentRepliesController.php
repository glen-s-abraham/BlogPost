<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\ApiController;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentRepliesController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Comment $comment)
    {
        $comments=$comment->replies;
        return $this->showCollectionAsResponse($comments);
    }


    public function store(Request $request,Comment $comment)
    {
        if($request->has('body'))
        {
            //user id needs to be replaced
            $comment=$comment->replies()->create(['body'=>$request->body,'user_id'=>2]);
            return $this->showModelAsResponse($comment);
        }
        return $this->errorResponse("Comment not found",404);
    }
}
