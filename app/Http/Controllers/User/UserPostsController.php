<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserPostsController extends ApiController
{
    private $userRepositoryInterface;
    
    public function __construct(UserRepositoryInterface $userRepositoryInterface)
    {
        $this->userRepositoryInterface=$userRepositoryInterface;
    }
   
    public function index($userId)
    {
        $posts=$this->userRepositoryInterface->getUserPosts($userId);
        return $this->showCollectionAsResponse($posts);
    }

    
}
