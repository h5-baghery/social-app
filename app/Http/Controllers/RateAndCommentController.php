<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class RateAndCommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate(['content' => 'required|string|max:1000']);

        $post->comments()->create([
            'user_id' => auth()->id(),
            'body' => $request->content
        ]);

        return back()->with('success', 'Comment added!');
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();
        return back()->with('success', 'Comment deleted');
    }
}
