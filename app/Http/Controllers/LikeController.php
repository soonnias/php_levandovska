<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Post;

use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store(Request $request)
    {
        $like = new Like();
        $like->post_id = $request->post_id;
        //$like->user_id = session('current_user_id');  ID користувача з сесії
        $like->user_id = Auth::id();
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

    public function toggle(Post $post)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Перевіряємо, чи поточний користувач вже лайкнув цей пост
            $like = Like::where('post_id', $post->post_id)->where('user_id', $user->user_id)->first();

            if ($like) {
                // Якщо лайк існує, видаляємо його
                $like->delete();
                return redirect()->back()->with('success', 'Ви видалили лайк з поста!');
            } else {
                // Якщо лайк не існує, створюємо новий
                $newLike = new Like();
                $newLike->post_id = $post->post_id;
                $newLike->user_id = $user->user_id;
                $newLike->save();

                return redirect()->back()->with('success', 'Ви лайкнули пост!');
            }
        } else {
            return redirect()->route('login')->with('error', 'Вам потрібно увійти, щоб лайкнути пост.');
        }
    }

}

