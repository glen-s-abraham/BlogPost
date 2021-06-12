<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\Post;

class PostsCommentsAndLikesController extends ApiController
{
    public function index()
    {
        $posts=Post::all()
                   ->load('user')
                   ->load('tags')
                   ->load('comments')
                   ->load('likes');

        return $this->showCollectionAsResponse($posts);

    }
}
