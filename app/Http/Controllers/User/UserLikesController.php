<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Models\User;
use Illuminate\Http\Request;

class UserLikesController extends ApiController
{
    public function index(User $user)
    {
       
        $likes=$user->likes()->with('likable')->get();;
        return $this->showCollectionAsResponse($likes);
    }
}
