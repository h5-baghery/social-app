<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class FollowController extends Controller
{
    public function follow(User $user)
    {
        $followedId = $user->id;
        $followerId = Auth::user()->id;

        if ($followedId === $followerId) {
            return back()->with('error', 'you cannot follow yourself ' . $user->username . '.');
        }

        $followExistCheck = Follow::where([['user_id', '=', $followerId], ['followed_id', '=', $followedId]])->count();

        if ($followExistCheck) {
            return back()->with('error', 'You are already following ' . $user->username . '.');
        }

        // $follow['user_id'] = $followerId;
        // $follow['followed_id'] = $followedId;
        // Follow::firstOrCreate($follow);

        $newFollow = new Follow();
        $newFollow->user_id = $followerId;
        $newFollow->followed_id = $followedId;
        $newFollow->save();

        return back()->with('success', 'you are now following ' . $user->username . '.');
    }

    public function unFollow(User $user): RedirectResponse
    {
        $currentUser = Auth::user();
        if ($currentUser->isFollowing($user)) {
            //Follow::where([['user_id', '=', auth()->user()->id], ['followed_id', '=', $user->id]])->delete();
            $currentUser->unfollow($user);
            return back()->with('success', 'You have unfollowed ' . $user->username . '.');
        }

        return back()->with('message', 'you are not following ' . $user->username . '.');
    }
}
