<?php

namespace App\Repositories;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Models\Comment;

class CommentRepository implements CommentRepositoryInterface
{
	public function isCommentOwner($userId,$commentId)
	{
		$comment=Comment::where('id', $commentId)->firstOrFail();
		return $comment->user_id==$userId;
	}

	public function updateExistingComment($commentId,$data)
	{
		$comment=Comment::where('id', $commentId)->firstOrFail();
		$comment->body=$data['body'];
		$comment->save();
		return $comment;
	}
	public function deleteExistingComment($commentId)
	{
		$comment=Comment::where('id', $commentId)->firstOrFail();
		$comment->delete();
		return $comment;
	}

	public function getCommentLikes($commentId)
	{
		$comment=Comment::where('id', $commentId)->firstOrFail();
		return $comment->likes->count();
	}

	public function likeOrUnlikeComment($userId,$commentId)
	{
		$comment=Comment::where('id', $commentId)->firstOrFail();
        $liked=$comment->likes()->where('user_id',$userId)->get()->count();
        
        if($liked==0)
        {
            $comment->likes()->create(['user_id'=>$userId]);
            return "Comment Liked";
        }
        $comment->likes()->where('user_id',$userId)->delete();
        return "Comment Unliked";
	}

	public function getCommentReplies($commentId)
	{
		$comment=Comment::where('id', $commentId)->firstOrFail();
        return $comment->replies;           
	}

	public function createCommentReply($commentId,$data)
	{
	
		$comment=Comment::where('id', $commentId)->firstOrFail();
		$reply=$comment->replies()->create(['body'=>$data['body'],'user_id'=>$data['user_id']]);
		return $reply;

	}
}