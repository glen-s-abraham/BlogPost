<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class PostTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];
    
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];
    
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform($post)
    {
        return [
           'identifier'=>(int)$post->id,
           'title'=>(string)$post->title,
           'content'=>(string)$post->body,
           'image'=>isset($post->image)?url($post->image->url):null,
           'tags'=>isset($post->tags)?$post->tags->pluck('name'):null,
           'likes'=>(int)$post->likes->count(),
           'createdBy'=>(int)$post->user_id,
           'creationDate'=>$post->created_at->diffForHumans(),
           'lastUpdated'=>$post->updated_at->diffForHumans(),
        ];
    }

    public static function getOriginalField($index)
    {
        $fields=[
           'identifier'=>'id',
           'title'=>'title',
           'content'=>'body',
           'createdBy'=>'user_id',
           'likes'=>'likes',
           'image'=>'image',
           'tags'=>'tags',
           'creationDate'=>'created_at',
           'lastUpdated'=>'updated_at',
        ];
        return isset($fields[$index])?$fields[$index]:null;
    }

    public static function getTransformedField($index)
    {
        $fields=[
           'id'=>'identifier',
           'title'=>'title',
           'body'=>'content',
           'user_id'=>'createdBy',
           'likes'=>'likes',
           'image'=>'image',
           'tags'=>'tags',
           'created_at'=>'creationDate',
           'updated_at'=>'lastUpdated',
        ];
        return isset($fields[$index])?$fields[$index]:null;
    }

}
