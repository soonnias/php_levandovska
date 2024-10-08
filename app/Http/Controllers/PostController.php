<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;

class PostController extends Controller
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

            if ($sortOption === 'asc' || $sortOption === 'desc') {
                $query->orderBy('title', $sortOption);
            }

            if ($sortOption === 'new' || $sortOption === 'old') {
                $query->orderBy('created_at', $sortOption === 'new' ? 'desc' : 'asc');
            }
        }

        // Фільтрація за категоріями
        if ($request->filled('categories')) {
            $query->whereHas('categories', function ($query) use ($request) {
                $query->whereIn('categories.category_id', $request->input('categories'));
            });
        }

        $categories = Category::all(); 
        $posts = $query->get(); 

        return view('posts.index', compact('posts', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'title' => [
                'required',
                'max:255',
            ],
            'description' => [
                'required',
            ],
            'category_ids' => [
                'required',
                'array',
            ],
            'category_ids.*' => [
                'exists:categories,category_id',
            ],
            'image' => [
                'required',
                'url',
            ],
        ]);        

        $user = User::find(2); // поки від адміна створення постів

        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => $user->user_id,
            'image' => $request->image, 
        ]);

        // додає записи до CategoryPost
        $post->categories()->attach($request->category_ids);

        return redirect()->route('posts.index')->with('success', 'Пост створено успішно');
    }

    public function show(Post $post)
    {
        $post->load('categories');
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'description' => [
                'required',
                'string',
            ],
            'category_ids' => [
                'required',
                'array',
            ],
            'category_ids.*' => [
                'exists:categories,category_id',
            ],
            'image' => [
                'required',
                'url',
            ],
        ]);        

        // Оновлюємо заголовок та опис
        $post->update($request->only(['title', 'description']));

        // Оновлюємо категорії
        $post->categories()->sync($request->category_ids);

        $post->image = $request->image; 
        $post->save(); 

        return redirect()->route('posts.index')->with('success', 'Пост успішно оновлено!');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index');
    }
}
