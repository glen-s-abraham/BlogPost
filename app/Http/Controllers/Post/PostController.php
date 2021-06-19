<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\ApiController;
use App\Transformers\PostTransformer;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;

class PostController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('transform.input:'.PostTransformer::class)->only(['store','update']);
    }
    
    public function index()
    {
        $posts=Post::all()
                   ->load('image')
                   ->load('tags');
        return $this->showCollectionAsResponse($posts);
    }

    
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

  
    public function store(PostStoreRequest $request)
    {
        $data=$request->only(['title','body']);
        $data['user_id']=auth()->user()->id;
        $post=Post::create($data);
        
        if($request->has('tags'))
        {
            $tags=$this->creatOrFetchTagIds($request->tags);
            $post->tags()->attach($tags);
        }

        if($request->hasFile('image'))
        {
            $image=$request->file('image')->store('public/posts');
            $post->image()->create(['url'=>$image]);
        }

        return $this->showModelAsResponse($post,201);    
    }

    
    public function show(Post $post)
    {
        return $this->showModelAsResponse($post);
    }

  
    public function update(PostUpdateRequest $request, Post $post)
    {
        
        if(auth()->user()->cannot('update',$post))
        {
            return $this->errorResponse("You don't have permission to update this post",403);   
        }

        $post->update($request->only(['title','body']));

        if($request->has('tags'))
        {
            $tags=$this->creatOrFetchTagIds($request->tags);
            $post->tags()->syncWithoutDetaching($tags);
        }

        if($request->hasFile('image'))
        {
            $image=$request->file('image')->store('public/posts');
            $post->image()->updateOrCreate(['url'=>$image]);
        }

        return $this->showModelAsResponse($post);
    }

   
    public function destroy(Post $post)
    {
        if(auth()->user()->cannot('delete',$post))
        {
            return $this->errorResponse("You don't have permission to delete this post",403);   
        }

        $post->delete();
        return $this->showModelAsResponse($post);
    }
}
