<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\ApiController;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;

class PostController extends ApiController
{

    private $postRepositoryInterface;
    
    public function __construct(PostRepositoryInterface $postRepositoryInterface)
    {
        $this->postRepositoryInterface=$postRepositoryInterface;
    }
    
    public function index()
    {
        $posts=$this->postRepositoryInterface->getPosts();
        return $this->showCollectionAsResponse($posts);
    }

    
  
    public function store(PostStoreRequest $request)
    {

        $data=$request->only(['title','body','tags']);
        $data['user_id']=auth()->user()->id;

        if($request->hasFile('image'))
        {
            $image=$request->file('image')->store('public/posts');
            $data['image']=$image;
        }

        $post=$this->postRepositoryInterface->createNewPost($data);
        return $this->successResponse($post,201); 
           
    }

    
    public function show($postId)
    {
        $post=$this->postRepositoryInterface->getPostById($postId);
        return $this->successResponse($post,201);
    }

  
    public function update(PostUpdateRequest $request,$postId)
    {
        
        if(!$this->postRepositoryInterface->isPostOwner(auth()->user()->id,$postId))
        {
            return $this->errorResponse("You don't have permission to update this post",409);   
        }

        $data=$request->only(['title','body','tags']);

        if($request->hasFile('image'))
        {
            $image=$request->file('image')->store('public/posts');
            $data['image']=$image;
        }

        $post=$this->postRepositoryInterface->updateExistingPost($postId,$data);
        return $this->successResponse($post,201);
    }

   
    public function destroy($postId)
    {
        if(!$this->postRepositoryInterface->isPostOwner(auth()->user()->id,$postId))
        {
            return $this->errorResponse("You don't have permission to update this post",409);   
        }

        $post=$this->postRepositoryInterface->deleteExistingPost($postId);
        return $this->successResponse(['message'=>'Removed Post'],200);
    }
}
