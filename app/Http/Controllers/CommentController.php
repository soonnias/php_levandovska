<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Post $post)
    {
        $comments = $post->comments; // Отримання всіх коментарів для поста
        return view('comments.index', compact('post', 'comments'));
    }

    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $comment = new Comment([
            'content' => $request->input('content'),
            'post_id' => $post->id,
            'user_id' => session('user_id'), // Ідентифікатор користувача, який коментує
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
