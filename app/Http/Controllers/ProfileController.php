<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        $posts = $user->posts()->withCount(['likes', 'comments'])->latest()->get();
        $isFollowing = Auth::check() ? Auth::user()->isFollowing($user) : false;
        
        return view('profile.show', compact('user', 'posts', 'isFollowing'));
    }

    public function edit()
    {
        return view('profile.edit');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'bio' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->only(['name', 'username', 'bio']);

        if ($request->hasFile('image')) {
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            $data['image'] = $request->file('image')->store('profiles', 'public');
        }

        $user->update($data);

        return redirect()->route('profile.show', $user)->with('success', 'Profile updated successfully!');
    }
}