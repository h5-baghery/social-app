<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Mail\NewPostEmail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PostController extends Controller
{
    public function search($term)
    {
        $posts = Post::search($term)->get();
        $posts->load('user:id,username,avatar');
        return $posts;
    }

    public function rate(Request $request, Post $post)
    {
        $request->validate(['rating' => 'required|integer|min:1|max:5']);

        $post->ratings()->updateOrCreate(['user_id' => auth()->id()], ['rating' => $request->rating]);
        return back();
    }

    public function explorer(Request $request)
    {
        $sort = $request->input('sort', 'newest');

        $posts = Post::with(['user', 'comments', 'ratings'])
            ->withCount(['comments'])
            ->withAvg('ratings', 'rating') // Using your 'rating' column
            ->withCount('ratings as ratings_count');

        // Complete sorting logic
        switch ($sort) {
            case 'oldest':
                $posts->oldest();
                break;

            case 'top-rated':
                $posts->orderByDesc('ratings_avg_rating') // Sorts by average rating
                    ->orderByDesc('ratings_count');           // Secondary sort
                break;

            case 'most-rated':
                $posts->orderByDesc('ratings_count') // Sorts by number of ratings
                    ->orderByDesc('ratings_avg_rating'); // Secondary sort
                break;

            default: // 'newest'
                $posts->latest();
                break;
        }

        // Sidebar data
        $topRatedPosts = Post::with(['user'])
            ->withAvg('ratings', 'rating')
            ->orderByDesc('ratings_avg_rating')
            ->limit(5)
            ->get();

        $activePosters = User::withCount('posts')
            ->orderByDesc('posts_count')
            ->limit(5)
            ->get();

        return view('components.explorer.index', [
            'posts'         => $posts->paginate(10),
            'currentSort'   => $sort,
            'topRatedPosts' => $topRatedPosts,
            'activePosters' => $activePosters,
        ]);
    }
    public function editPost(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $incomingFields = $request->validate([
            'title' => 'required|max:40',
            'body'  => 'required|max:500',
        ]);

        $post['title'] = strip_tags($incomingFields['title']);
        $post['body']  = strip_tags($incomingFields['body']);
        Log::info($post->user->id);
        $post->save();

        return redirect()->route('singlepost', ['post' => $post->id])->with('success', 'Post successfully updated.');

        // return view('create-post', ['post' => $post, 'edit' => true]);
    }

    public function deletePost(Request $request, Post $post)
    {
        // $this->authorize('delete', $post);
        $post->delete();

        $redirectTo = $request->input('redirect_to', route('login'));
        return redirect($redirectTo)->with('success', 'Post successfuly deleted');
    }

    public function showEditSinglePost(Post $post)
    {
        $this->authorize('update', $post);
        return view('create-post', ['post' => $post, 'edit' => true]);
    }

    public function showSinglePost(Post $post)
    {
        $user         = $post->user;
        $post['body'] = strip_tags(Str::markdown($post->body), '<p><strong><li><ul><ol><h3><br><em><hr>');

        // Load ratings data
        $post->load(['ratings', 'comments.user'])
            ->loadAvg('ratings', 'rating')
            ->loadCount('ratings');

        $userRating  = null;
        $userComment = null;

        if (auth()->check()) {
            $userRating = $post->ratings()
                ->where('user_id', auth()->id())
                ->first();

            $userComment = $post->comments()
                ->where('user_id', auth()->id())
                ->latest()
                ->first();
        }

        return view('singlepost', [
            'post'        => $post,
            'user'        => $user,
            'userRating'  => $userRating,
            'userComment' => $userComment,
        ]);
    }

    // public function showSinglePost(Post $post)
    // {
    //     $user = $post->user();
    //     $post['body'] = strip_tags(Str::markdown($post->body), '<p><strong><li><ul><ol><h3><br><em><hr>');
    //     return view('singlepost', ['post' => $post, 'user' => $user]);
    // }

    public function createPost(Request $request)
    {
        $incomingFields = $request->validate([
            'title' => 'required|max:40',
            'body'  => 'required|max:500',
        ]);

        $incomingFields['title']   = strip_tags($incomingFields['title']);
        $incomingFields['body']    = strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = auth()->user()->id;

        $newPost = Post::create($incomingFields);

        Mail::to(auth()->user()->email)->send(new NewPostEmail(['name' => auth()->user()->username, 'title' => $newPost->title]));

        return redirect()->route('singlepost', ['post' => $newPost->id])->with('success', 'New post successfully created.');
    }

    public function showCreateForm()
    {
        if (auth()->check()) {
            return view('create-post', ['edit' => false]);
        }
    }
}
