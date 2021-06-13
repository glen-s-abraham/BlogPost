<?php

namespace App\Repositories\Interfaces;

interface PostRepositoryInterface
{
	
	public function getPosts();
	public function createNewPost($data);
	public function getPostById($id);
	public function isPostOwner($userId,$postId);
	public function updateExistingPost($postId,$data);
	public function deleteExistingPost($postId);
	public function getCompletePostDetails();
	public function getPostComments($postId);
	public function createPostComment($postId,$data);
	public function getPostLikes($postId);
	public function likeOrUnlikePost($userId,$postId);
}