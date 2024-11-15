<?php

namespace App\Http\Controllers;

use App\Models\CategoryProduct;
use Illuminate\Http\Request;

class CategoryProductController extends Controller
{
    // Показати всі категорії продуктів
    public function index()
    {
        $categories = CategoryProduct::all();
        return view('category_products.index', compact('categories'));
    }

    // Показати форму для створення категорії
    public function create()
    {
        return view('category_products.create');
    }

    // Зберегти нову категорію
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        CategoryProduct::create($request->all());

        return redirect()->route('category-products.index')->with('success', 'Категорія продукту створена!');
    }

    // Показати форму для редагування категорії
    public function edit($id)
    {
        $category = CategoryProduct::findOrFail($id);
        return view('category_products.edit', compact('category'));
    }

    // Оновити категорію
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = CategoryProduct::findOrFail($id);
        $category->update($request->all());

        return redirect()->route('category-products.index')->with('success', 'Категорія продукту оновлена!');
    }

    // Видалити категорію
    public function destroy($id)
    {
        $category = CategoryProduct::findOrFail($id);
        $category->delete();

        return redirect()->route('category-products.index')->with('success', 'Категорія продукту видалена!');
    }
}
