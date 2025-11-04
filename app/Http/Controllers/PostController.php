<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'likes', 'comments.user'])
                    ->withCount(['likes', 'comments'])
                    ->latest()
                    ->paginate(10);
        
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'caption' => 'nullable|string|max:2200',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120'
        ]);

        $imagePath = $request->file('image')->store('posts', 'public');

        $post = Post::create([
            'user_id' => Auth::id(),
            'caption' => $request->caption,
            'image' => $imagePath
        ]);

        return redirect()->route('posts.index')->with('success', 'Post created successfully!');
    }

    public function show(Post $post)
    {
        $post->load(['user', 'comments.user', 'likes.user']);
        return view('posts.show', compact('post'));
    }

    public function destroy(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        Storage::disk('public')->delete($post->image);
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully!');
    }
}