<?php

namespace App\Repositories;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Models\Post;
use App\Models\Tag;

class PostRepository implements PostRepositoryInterface
{

	private function creatOrFetchTagIds($taglist)
    {
        $tags=[];
        foreach(explode(',' , $taglist) as $tagname)
        {    
            $tag=Tag::firstOrCreate(['name'=>$tagname]);
         
            if($tag)
            {
                $tags[]=$tag->id;
            }                           
        }
        return $tags;
    }

	public function getPosts()
	{
		$post=Post::all()
                   ->load('image')
                   ->load('tags')
                   ->load('likes')
                   ->map->formatPost();
        return($post);           
	}

	public function createNewPost($data)
	{
		$post=new Post();
		$post->title=$data['title'];
		$post->body=$data['body'];
		$post->user_id=$data['user_id'];
		$post->save();
		if(array_key_exists('image',$data))
		{
			$post->image()->create(['url'=>$data['image']]);
		}
		$post->image()->create(['url'=>'default/default.png']);
		
		if(array_key_exists('tags',$data))
		{
			$tags=$this->creatOrFetchTagIds($data['tags']);
			$post->tags()->attach($tags);
		}
		return $post->formatPost();
	}

	public function getPostById($id)
	{
		$post=Post::where('id', $id)->firstOrFail();
		return $post->formatPost();
	}

	public function isPostOwner($userId,$postId)
	{
		$post=Post::where('id', $postId)->firstOrFail();
		return $post->user_id==$userId;
	}

	public function updateExistingPost($postId,$data)
	{
		$post=Post::where('id', $postId)->firstOrFail();

		if(array_key_exists('title',$data))
		{
			$post->title=$data['title'];
		}

		if(array_key_exists('body',$data))
		{
			$post->body=$data['body'];
		}
		
		if(array_key_exists('image',$data))
		{
			$post->image()->createOrUpdate(['url'=>$data['image']]);
		}
		
		if(array_key_exists('tags',$data))
		{
			$tags=$this->creatOrFetchTagIds($data['tags']);
			$post->tags()->sync($tags);
		}
		return $post->formatPost();
	}

	public function deleteExistingPost($postId)
	{
		$post=Post::where('id', $postId)->firstOrFail();
		$post->delete();
		return $post;
	}

	public function getCompletePostDetails()
	{
		$post=Post::all()
                   ->load('image')
                   ->load('user')
                   ->load('tags')
                   ->load('likes')
                   ->load('comments');
        return($post);           
	}

	public function getPostComments($postId)
	{
		$post=Post::where('id', $postId)->firstOrFail();
        return $post->comments;           
	}

	public function createPostComment($postId,$data)
	{
	
		$post=Post::where('id', $postId)->firstOrFail();
		$comment=$post->comments()->create(['body'=>$data['body'],'user_id'=>$data['user_id']]);
		return $comment;

	}

	public function getPostLikes($postId)
	{
		$post=Post::where('id', $postId)->firstOrFail();
		return $post->likes->count();
	}

	public function likeOrUnlikePost($userId,$postId)
	{
		$post=Post::where('id', $postId)->firstOrFail();
        $liked=$post->likes()->where('user_id',$userId)->get()->count();;
        
        if($liked==0)
        {
            $post->likes()->create(['user_id'=>$userId]);
            return "Post Liked";
        }
        $post->likes()->where('user_id',$userId)->delete();
        return "Post Unliked";
	}
}