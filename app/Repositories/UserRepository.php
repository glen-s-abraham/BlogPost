<?php

namespace App\Repositories;
use App\Repositories\Interfaces\UserRepositoryInterface;

use App\Models\User;


class UserRepository implements UserRepositoryInterface
{
	public function addNewUser($data)
	{
		$user=User::create($data);
		if(array_key_exists('image',$data))
		{
			$user->image()->create(['url'=>$data['image']]);
		}
		$user->image()->create(['url'=>'default/default.png']);
		return $user->formatProfile();

	}

	public function updateExistingUser($id,$data)
	{
		$user=User::where('id', $id)->firstOrFail();
		$user->update($data);
		if(array_key_exists('image',$data))
		{
			$user->image()->createOrUpdate(['url'=>$data['image']]);
		}
		return $user->formatProfile();
	}

	public function deleteExistingUser($id)
	{
		$user=User::where('id', $id)->firstOrFail();
		$user->delete();
		return $user;
	}

	public function createUserToken($email)
	{
		$user=User::where('email', $email)->firstOrFail();
		$token = $user->createToken('auth_token')->plainTextToken;
		return $token;
	}

	public function deleteUserToken($id)
	{
		$user=User::where('id', $id)->firstOrFail();
		$token = $user->tokens()->delete();
		return;
	}

	public function getUserComments($id)
	{
		$user=User::where('id', $id)->firstOrFail();
		$comments = $user->comments()->with('commentable')->get();
		return $comments;
	}

	public function getUserPosts($id)
	{
		$user=User::where('id', $id)->firstOrFail();
		$posts = $user->posts;
		return $posts;
	}

	public function getUserLikes($id)
	{
		$user=User::where('id', $id)->firstOrFail();
		$likes=$user->likes()->with('likable')->get();
		return $likes;
	}


}