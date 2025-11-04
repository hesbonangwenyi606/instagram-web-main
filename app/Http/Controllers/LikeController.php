<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function like(Post $post)
    {
        return $this->toggleLike($post);
    }

    public function likeAjax(Post $post)
    {
        $result = $this->toggleLike($post);
        
        return response()->json([
            'success' => true,
            'liked' => $result['liked'],
            'likes_count' => $post->likes()->count(),
            'message' => $result['message']
        ]);
    }

    private function toggleLike(Post $post)
    {
        $like = Like::where('user_id', Auth::id())->where('post_id', $post->id)->first();

        if ($like) {
            $like->delete();
            return ['liked' => false, 'message' => 'Post unliked!'];
        }

        Like::create([
            'user_id' => Auth::id(),
            'post_id' => $post->id
        ]);

        return ['liked' => true, 'message' => 'Post liked!'];
    }
}