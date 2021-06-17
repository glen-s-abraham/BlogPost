<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class CommentTransformer extends TransformerAbstract
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
    public function transform($comment)
    {
        return [
           'identifier'=>(int)$comment->id,
           'comment'=>(string)$comment->body,
           'commentBy'=>(string)$comment->user_id,
           'likes'=>isset($comment->likes)?(int)$comment->likes->count():0,
           'creationDate'=>$comment->created_at->diffForHumans(),
           'lastUpdated'=>$comment->updated_at->diffForHumans(),
        ];
    }
}
