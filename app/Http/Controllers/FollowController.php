<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function follow(User $user)
    {
        return $this->toggleFollow($user);
    }

    public function followAjax(User $user)
    {
        $result = $this->toggleFollow($user);
        
        return response()->json([
            'success' => true,
            'following' => $result['following'],
            'followers_count' => $user->followers()->count(),
            'message' => $result['message']
        ]);
    }

    private function toggleFollow(User $user)
    {
        if ($user->id === Auth::id()) {
            return ['following' => false, 'message' => 'You cannot follow yourself.'];
        }

        $follow = Follow::where('follower_id', Auth::id())->where('following_id', $user->id)->first();

        if ($follow) {
            $follow->delete();
            return ['following' => false, 'message' => 'Unfollowed successfully!'];
        }

        Follow::create([
            'follower_id' => Auth::id(),
            'following_id' => $user->id
        ]);

        return ['following' => true, 'message' => 'Followed successfully!'];
    }
}