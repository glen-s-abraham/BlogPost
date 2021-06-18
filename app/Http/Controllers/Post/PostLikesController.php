<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\Post;
class PostLikesController extends ApiController
{
    public function index(Post $post)
    {
        $likes=$post->likes->pluck('user_id');
        return $this->successResponse(["liked by User_id's"=>$likes],200);
    }

   
   
    public function toggleLike(Post $post)
    {
       
    
       $user_id=auth()->user()->id;

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
