<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'caption', 'image'];

    protected $with = ['user', 'likes', 'comments.user'];
    protected $withCount = ['likes', 'comments'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function isLikedBy(User $user)
    {
        if (!$user) return false;
        return $this->likes->contains('user_id', $user->id);
    }
}