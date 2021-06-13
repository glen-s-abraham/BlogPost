<?php

namespace App\Repositories\Interfaces;

interface CommentRepositoryInterface
{
	public function isCommentOwner($userId,$commentId);
	public function updateExistingComment($commentId,$data);
	public function deleteExistingComment($commentId);
	public function getCommentLikes($commentId);
	public function likeOrUnlikeComment($userId,$commentId);
	public function getCommentReplies($commentId);
	public function createCommentReply($commentId,$data);
}