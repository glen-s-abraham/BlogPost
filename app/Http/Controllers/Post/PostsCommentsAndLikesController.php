<?php

namespace App\Http\Controllers\Post;

use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;


class PostsCommentsAndLikesController extends ApiController
{
    private $postRepositoryInterface;
    
    public function __construct(PostRepositoryInterface $postRepositoryInterface)
    {
        $this->postRepositoryInterface=$postRepositoryInterface;
    }

    public function index()
    {

        

        $posts=$this->postRepositoryInterface->getCompletePostDetails();

        return $this->showCollectionAsResponse($posts);

    }
}
