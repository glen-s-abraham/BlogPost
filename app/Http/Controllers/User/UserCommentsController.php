<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserCommentsController extends ApiController
{
    private $userRepositoryInterface;
    
    public function __construct(UserRepositoryInterface $userRepositoryInterface)
    {
        $this->userRepositoryInterface=$userRepositoryInterface;
    }

    public function index()
    {
        $comments=$this->userRepositoryInterface->getUserComments(auth()->user()->id);
        return $this->successResponse(['comments'=>$comments],200);
    }

    
}
