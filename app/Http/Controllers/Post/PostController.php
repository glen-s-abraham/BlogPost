<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\ApiController;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;

class PostController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts=Post::all();
        return $this->showCollectionAsResponse($posts);

    }

    /**
     * Returns the tag id's of tags passed in
     * Array of tags passed in
     * Returns the ids of those tags
     */
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostStoreRequest $request)
    {
        $data=$request->only(['title','body']);
        $data['user_id']=1; //to be replace with id of current logged in user
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return $this->showModelAsResponse($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostUpdateRequest $request, Post $post)
    {
        $post->update($request->only(['title','body']));

        if($request->has('tags'))
        {
            $tags=$this->creatOrFetchTagIds($request->tags);
            $post->tags()->sync($tags);
        }

        if($request->hasFile('image'))
        {
            $image=$request->file('image')->store('public/posts');
            $post->image()->updateOrCreate(['url'=>$image]);
        }

        return $this->showModelAsResponse($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        
        return $this->showModelAsResponse($post);
    }
}
