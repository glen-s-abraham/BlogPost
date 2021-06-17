<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
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
    public function transform($user)
    {
        return [
           'identifier'=>(int)$user->id,
           'name'=>(string)$user->name,
           'email'=>(string)$user->email,
           'isVerified'=>isset($user->email_verified_at)?(string)$user->email_verified_at->diffForHumans():null,
           'creationDate'=>$user->created_at->diffForHumans(),
           'lastUpdated'=>$user->updated_at->diffForHumans(),
           'deleteDate'=>isset($user->deleted_at)?(string)$user->deleted_at:null,
        ];
    }
    
    public static function getOriginalField($index)
    {
        return null;
    }

    
}
