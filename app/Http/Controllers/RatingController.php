<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    // app/Http/Controllers/RatingController.php
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5'
        ]);

        $post->ratings()->updateOrCreate(
            ['user_id' => auth()->id()],
            ['rating' => $request->rating]
        );

        return back()->with('success', 'Rating submitted!');
    }
}
