<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        // Отримує всі пости і передає їх у вигляд
        $posts = Post::all();
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        // Отримуємо всі категорії з бази даних
        $categories = Category::all();
    
        // Передаємо категорії у вигляд 'create'
        return view('posts.create', compact('categories'));
    }
    

    public function store(Request $request)
    {
        // Валідація
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Збереження зображення
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        $user = User::find(1); // Або можете змінити ID на відповідний

        // Створення поста
        Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'user_id' => $user->id,
            'image' => $imagePath, // Якщо зображення є
        ]);

        return redirect()->route('posts.index')->with('success', 'Пост створено успішно');
    }
    

    public function show(Post $post)
    {
        // Повертає вигляд з деталями конкретного поста
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        // Повертає форму для редагування поста
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        // Валідовує нові дані і оновлює пост
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $post->update($request->only(['title', 'content']));
        return redirect()->route('posts.index');
    }

    public function destroy(Post $post)
    {
        // Видаляє пост з бази даних
        $post->delete();
        return redirect()->route('posts.index');
    }
}
