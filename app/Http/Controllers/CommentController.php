<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        $comment = Comment::create([
            'user_id' => Auth::id(),
            'post_id' => $post->id,
            'content' => $request->content
        ]);

        $comment->load('user');

        return back()->with('success', 'Comment added!');
    }

    public function storeAjax(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        $comment = Comment::create([
            'user_id' => Auth::id(),
            'post_id' => $post->id,
            'content' => $request->content
        ]);

        $comment->load('user');

        return response()->json([
            'success' => true,
            'comment' => [
                'id' => $comment->id,
                'content' => $comment->content,
                'created_at' => $comment->created_at->diffForHumans(),
                'user' => [
                    'username' => $comment->user->username,
                    'image' => $comment->user->image ? asset('storage/' . $comment->user->image) : null,
                    'name_initial' => strtoupper(substr($comment->user->name, 0, 1))
                ]
            ],
            'comments_count' => $post->comments()->count()
        ]);
    }

    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $comment->delete();
        return back()->with('success', 'Comment deleted!');
    }

    public function destroyAjax(Comment $comment)
    {
        if ($comment->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized action.'], 403);
        }

        $post = $comment->post;
        $comment->delete();

        return response()->json([
            'success' => true,
            'comments_count' => $post->comments()->count()
        ]);
    }
}