<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
	public function addNewUser($data);
	public function updateExistingUser($id,$data);
	public function deleteExistingUser($id);
	public function createUserToken($email);
	public function deleteUserToken($id);
	public function getUserPosts($id);
	public function getUserLikes($id);
	public function getUserComments($id);
}