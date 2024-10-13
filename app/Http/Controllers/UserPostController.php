<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;

use Illuminate\Http\Request;

class UserPostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::query();

        // Пошук за заголовком
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->input('search') . '%');
        }

        // Сортування
        if ($request->filled('sort_option')) {
            $sortOption = $request->input('sort_option');

            if (in_array($sortOption, ['asc', 'desc'])) {
                $query->orderBy('title', $sortOption);
            } elseif (in_array($sortOption, ['new', 'old'])) {
                $query->orderBy('created_at', $sortOption === 'new' ? 'desc' : 'asc');
            }
        }

        // Фільтрація за кількома категоріями
        if ($request->filled('categories')) {
            $categoryIds = $request->input('categories');
            $query->whereHas('categories', function ($query) use ($categoryIds) {
                $query->whereIn('categories.category_id', $categoryIds);
            });
        }

        // Інші фільтри (дата, тощо)
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->input('from_date'));
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->input('to_date'));
        }

        // Отримання всіх категорій для фільтра
        $categories = Category::all();

        // Отримання відфільтрованих постів
        $posts = $query->orderBy('created_at', 'desc')->get();

        // Показати активні фільтри
        $activeFilters = [
            'categories' => $request->input('categories', []),
            'search' => $request->input('search', ''),
            'from_date' => $request->input('from_date', ''),
            'to_date' => $request->input('to_date', ''),
        ];

        return view('userPosts.index', compact('posts', 'categories', 'activeFilters'));
    }

    public function show($id)
    {
        $post = Post::with(['categories', 'comments', 'likes'])->find($id);

        if (!$post) {
            return abort(404); // обробка помилки
        }

        $categories = Category::all();
        $userLiked = true;
        return view('userPosts.show', compact('post', 'categories', 'userLiked'));
    } 
}
