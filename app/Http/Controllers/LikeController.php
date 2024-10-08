<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Post;

class LikeController extends Controller
{
    public function store(Request $request)
    {
        $like = new Like();
        $like->post_id = $request->post_id;
        $like->user_id = session('current_user_id'); // ID користувача з сесії
        $like->save();

        return redirect()->back()->with('success', 'Ви лайкнули пост!');
    }

    public function destroy(Post $post, $userId)
    {
        $like = Like::where('post_id', $post->post_id)->where('user_id', $userId)->first();
        if ($like) {
            $like->delete();
        }

        return redirect()->back()->with('success', 'Ви видалили лайк з поста!');
    }
}
