<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;
use App\Models\Like;

class Comment extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function commentable()
    {
        return $this->morphTo();
    }

    public function replies()
    {
        $this->morphMany(Comment::class,name:'commentable');
    }

    public function likes()
    {
        $this->morphOne(Like::class,name:'commentable');
    }
}
