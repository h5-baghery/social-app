<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Queue\RedisQueue;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;

class UserController extends Controller
{
    public function avatarImageSave(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|max:3000'
        ]);
        $user = auth()->user();
        $fileName = $user->id . "-" . uniqid() . '.jpg';

        $manager = new ImageManager(new Driver());
        $image = $manager->read($request->file('avatar'));
        $imageData = $image->cover(120, 120)->toJpeg();
        Storage::disk('public')->put('avatars/' . $fileName, $imageData);
        $oldAvatar = $user->getRawOriginal('avatar');
        $user->avatar = $fileName;
        $user->save();
        if ($oldAvatar && Storage::disk('public')->exists('avatars/' . $oldAvatar)) {
            Storage::disk('public')->delete('avatars/' . $oldAvatar);
        }
        return redirect()->route('user.profile', ['user' => $user->username]);
    }

    public function uploadAvatarImageForm(User $user)
    {
        return view('avatar-form');
    }

    private function userProfileHelper($user)
    {
        $posts = $user->posts()->latest()->get();
        $postCount = $posts->count();
        $followersCount = $user->followers()->count();
        $followingsCount = $user->followings()->count();
        $data = [
            'user' => $user,
            'posts' => $posts,
            'postCount' => $postCount,
            'followingsCount' => $followingsCount,
            'followersCount' => $followersCount
        ];

        return $data;
    }

    public function userProfile(User $user)
    {
        $data = $this->userProfileHelper($user);
        $posts = $user->posts()->withCount(['ratings', 'comments'])->paginate(10);

        return view('user-profile', ['data' => $data, 'title' => 'profile', 'posts' => $posts]);
    }

    public function userProfileFollowers(User $user)
    {
        $data = $this->userProfileHelper($user);
        $followers = $user->followers()->withCount(['followers', 'followings'])->paginate(10);
        return view('user-profile', ['data' => $data, 'title' => 'followers', 'followers' => $followers]);
    }

    public function userProfileFollowings(User $user)
    {
        $data = $this->userProfileHelper($user);
        $followings = $user->followings()->withCount(['followers', 'followings'])->paginate(10);

        return view('user-profile', ['data' => $data, 'title' => 'followings', 'followings' => $followings]);
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login')->with('success', 'Logged out successfuly');
    }

    public function login(Request $request)
    {
        $incomingFields = $request->validate([
            'loginusername' => 'required',
            'loginpassword' => 'required'
        ]);
        if (auth()->attempt(['username' => $incomingFields['loginusername'], 'password' => $incomingFields['loginpassword']])) {
            $request->session()->regenerate();
            return redirect()->route('login')->with('success', 'Logged in successfully');
        } else {

            return redirect()->route('login')->with('failure', 'Invalid login');
        }
    }

    public function register(Request $request)
    {
        $incomingFields = $request->validate([
            'username' => ['required', 'min:3', 'max:10', Rule::unique('users', 'username')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min: 6', 'confirmed']
        ]);
        $user = User::create($incomingFields);
        auth()->login($user);
        return redirect()->route('login')->with('success', 'Thank you for creating an account');
    }

    public function homepage()
    {
        if (auth()->check()) {
            return view('homepage-feed');
        } else {
            return view('homepage');
        }
    }

    public function test()
    {
        return 'hi';
    }
}
