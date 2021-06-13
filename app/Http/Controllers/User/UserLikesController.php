<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserLikesController extends ApiController
{
    private $userRepositoryInterface;

    public function __construct(UserRepositoryInterface $userRepositoryInterface)
    {
        $this->userRepositoryInterface=$userRepositoryInterface;
    }

    public function index()
    {
        $user=auth()->user();
        $likes=$this->userRepositoryInterface->getUserLikes(auth()->user()->id);
        return $this->showCollectionAsResponse($likes);
    }
}
