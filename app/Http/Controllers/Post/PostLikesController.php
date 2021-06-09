<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\Post;
class PostLikesController extends ApiController
{
    public function index($postId)
    {
        $post=Post::findOrFail($postId);
        $likes=$post->likes->count();
        return $this->successResponse(["likes"=>$likes],200);
    }

   
   
    public function toggleLike($postId)
    {
       $post=Post::findOrFail($postId);
    
       $user_id=9;//test case,needs to be replaced with authenticated user

       $liked=$post->likes()->where('user_id',$user_id)->get()->count();;
        
       if($liked==0)
       {
           $post->likes()->create(['user_id'=>$user_id]);
           return $this->successResponse(["message"=>"Post Liked"],200);
       }
       $post->likes()->where('user_id',$user_id)->delete();
       return $this->successResponse(["message"=>"Post Unliked"],200);
    }
}
