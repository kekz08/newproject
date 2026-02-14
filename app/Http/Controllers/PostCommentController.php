<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostComment;
use Illuminate\Http\Request;

class PostCommentController extends Controller
{
    public function index(Post $post)
    {
        $comments = $post->comments()->with('user:id,username')->latest()->get();
        return response()->json($comments);
    }

    public function store(Request $request, Post $post)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        $comment = PostComment::create([
            'user_id' => auth()->id(),
            'post_id' => $post->id,
            'comment' => $request->comment,
        ]);

        return response()->json($comment->load('user:id,username'));
    }
}
