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
           'username'=>(string)$user->name,
           'mailId'=>(string)$user->email,
           'image'=>url($user->image->url),
           'isVerified'=>isset($user->email_verified_at)?(string)$user->email_verified_at->diffForHumans():null,
           'creationDate'=>$user->created_at->diffForHumans(),
           'lastUpdated'=>$user->updated_at->diffForHumans(),
           'deleteDate'=>isset($user->deleted_at)?(string)$user->deleted_at:null,
        ];
    }
    
    public static function getOriginalField($index)
    {
        $fields=[
           'identifier'=>'id',
           'username'=>'name',
           'mailId'=>'email',
           'password'=>'password',
           'password_confirmation'=>'password_confirmation',
           'image'=>'image',
           'isVerified'=>'email_verified_at',
           'creationDate'=>'created_at',
           'lastUpdated'=>'updated_at',
           'deleteDate'=>'deleted_at',
        ];
        return isset($fields[$index])?$fields[$index]:null;
    }

    public static function getTransformedField($index)
    {
        $fields=[
           'id'=>'identifier',
           'name'=>'username',
           'email'=>'mailId',
           'password'=>'password',
           'password_confirmation'=>'password_confirmation',
           'image'=>'image',
           'email_verified_at'=>'isVerified',
           'deleted_at'=>'deleteDate',
           'created_at'=>'creationDate',
           'updated_at'=>'lastUpdated',
        ];
        return isset($fields[$index])?$fields[$index]:null;
    }

    
}
