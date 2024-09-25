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

            // Якщо вибрано сортування за заголовком
            if ($sortOption === 'asc' || $sortOption === 'desc') {
                $query->orderBy('title', $sortOption);
            }

            // Якщо вибрано сортування за датою
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

        // Отримуємо категорії для фільтрації
        $categories = Category::all(); // Змініть на ваш шлях отримання категорій

        $posts = $query->paginate(10); // Або інше число для пагінації

        return view('posts.index', compact('posts', 'categories'));
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
            'description' => 'required',
            'category_ids' => 'required|array', // Змінили на масив
            'category_ids.*' => 'exists:categories,category_id', // Валідація для кожної категорії
            'image' => 'required|url',
        ]);

        $user = User::find(2); // Або можете змінити ID на відповідний

        // Створення поста
        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => $user->user_id,
            'image' => $request->image, 
        ]);

        // Прив'язка категорій до поста
        $post->categories()->attach($request->category_ids);

        return redirect()->route('posts.index')->with('success', 'Пост створено успішно');
    }

    public function show(Post $post)
    {
        // Завантажуємо категорії разом з постом
        $post->load('categories');
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        // Отримуємо всі категорії
        $categories = Category::all();

        return view('posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_ids' => 'required|array',
            'category_ids.*' => 'exists:categories,category_id', // Перевірка, що всі обрані категорії існують
            'image' => 'required|url',
        ]);

        // Оновлюємо заголовок та опис
        $post->update($request->only(['title', 'description']));

        // Оновлюємо категорії
        $post->categories()->sync($request->category_ids);

        // Оновлюємо зображення
        $post->image = $request->image; // Зберігаємо новий URL зображення
        $post->save(); // Зберігаємо зміни

        return redirect()->route('posts.index')->with('success', 'Пост успішно оновлено!');
    }



    public function destroy(Post $post)
    {
        // Видаляє пост з бази даних
        $post->delete();
        return redirect()->route('posts.index');
    }
}
