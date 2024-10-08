<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Post $post)
    {
        $comments = $post->comments;
        return view('comments.index', compact('post', 'comments'));
    }

    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => [
                'required',
                'string',
                'max:255',
            ]
        ]);

        $comment = new Comment([
            'content' => $request->input('content'),
            'post_id' => $post->post_id,
            'user_id' => session('current_user_id'), // ID користувача
        ]);
        $comment->save();

        return redirect()->route('comments.index', $post)->with('success', 'Коментар успішно додано.');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect()->back()->with('success', 'Коментар успішно видалено.');
    }
}
