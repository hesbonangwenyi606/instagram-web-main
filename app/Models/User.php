<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'bio',
        'image'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = ['posts_count', 'followers_count', 'following_count'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id')
                    ->withTimestamps();
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'following_id')
                    ->withTimestamps();
    }

    public function isFollowing(User $user)
    {
        if (!auth()->check()) return false;
        
        return $this->following()
                    ->where('following_id', $user->id)
                    ->exists();
    }

    public function getPostsCountAttribute()
    {
        return $this->posts()->count();
    }

    public function getFollowersCountAttribute()
    {
        return $this->followers()->count();
    }
    public function getFollowingCountAttribute()
    {
        return $this->following()->count();
    }
    public function getCanBeFollowedAttribute()
    {
        if (!auth()->check()) return false;
        return $this->id !== auth()->id();
    }
}