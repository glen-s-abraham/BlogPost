<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Like extends Model
{
    use HasFactory;

    protected $guarded=[];

    public $timestamps = false;

    public function likable()
    {
        return $this->morphTo();
    }
    public function user()
    {
        return $this->belongsToOne(User::class);
    }
}
