<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

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
            'user_id' => Auth::id(),
        ]);

        $comment->save();

        // Перевірка ролі користувача
        if (Auth::user()->role === 'admin') {
            return redirect()->route('comments.index', $post)->with('success', 'Коментар успішно додано.');
        } else {
            return redirect()->route('userPosts.show', $post)->with('success', 'Коментар успішно додано!');
        }
    }

    public function destroy(Comment $comment)
    {
        if (Auth::id() === $comment->user_id || Auth::user()->role === 'admin') {
            $post = $comment->post;

            $comment->delete();
            return redirect()->route('userPosts.show', $post)->with('success', 'Коментар успішно видалено!');
        }

        return redirect()->back()->with('error', 'Ви не маєте права видаляти цей коментар.');
    }

}

