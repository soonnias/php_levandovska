<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::query();

        // Пошук
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Сортування
        if ($request->filled('sort') && in_array($request->sort, ['asc', 'desc'])) {
            $query->orderBy('name', $request->sort);
        }

        $categories = $query->get();

        return view('categories.index', compact('categories'));
    }


    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name|max:255',
        ]);
        

        Category::create($request->only('name'));

        return redirect()->route('categories.index')->with('success', 'Категорію успішно створено!');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|unique:categories,name|max:255',
        ]);        

        $category->update($request->only('name'));

        return redirect()->route('categories.index')->with('success', 'Категорію успішно оновлено!');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Категорію успішно видалено!');
    }
}
