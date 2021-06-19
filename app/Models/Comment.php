<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Transformers\CommentTransformer;
use App\Models\Comment;
use App\Models\Like;
use App\Models\User;

class Comment extends Model
{
    use HasFactory;

    public $transformer=CommentTransformer::class;

    protected $guarded=[];

    public function commentable()
    {
        return $this->morphTo();
    }

    public function replies()
    {
        return $this->morphMany(Comment::class,name:'commentable');
    }

    public function likes()
    {
        return $this->morphOne(Like::class,name:'likable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
