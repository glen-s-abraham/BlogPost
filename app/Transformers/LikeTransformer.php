<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class LikeTransformer extends TransformerAbstract
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
    public function transform($like)
    {
        return [
           'liked'=>$like->likable,
        ];
    }
    public static function getOriginalField($index)
    {
        return null;
    }
}
