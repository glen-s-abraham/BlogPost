<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Models\User;
use Illuminate\Http\Request;

class UserPostsController extends ApiController
{
   
    public function index(User $user)
    {
        $posts=$user->posts;
        return $this->showCollectionAsResponse($posts);
    }

    
}
