<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Image;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Tag;

class Post extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class,name:'imagable');
    }
    public function comments()
    {
        return $this->morphMany(Comment::class,name:'commentable');
    }
    public function likes()
    {
        return $this->morphMany(Like::class,name:'likable');
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function formatPost()
    {

        return [
            'post_id'=>$this->id,
            'title'=>$this->title,
            'body'=>$this->body,
            'author'=>$this->user->name,
            'tags'=>$this->tags,
            'image'=>$this->image,
            'created_at'=>$this->created_at->diffForHumans(),
            'updated_at'=>$this->updated_at->diffForHumans(),
            'likes'=>$this->likes->count()

        ];
    }
}
