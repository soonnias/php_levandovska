<?php

namespace App\Http\Controllers;

use App\Models\CategoryProduct;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
   // Показати всі продукти
   public function index()
   {
       $products = Product::all();
       return view('products.index', compact('products'));
   }

   // Показати форму для створення продукту
    public function create()
    {
        $categories = CategoryProduct::all();
        return view('products.create', compact('categories'));
    }

   // Створити новий продукт
    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'price' => [
                'required',
                'numeric',
                'min:0', // Перевірка на позитивну ціну
            ],
            'image' => [
                'nullable',
                'url',
                'max:255', // Максимальна довжина URL зображення
            ],
            'category_id' => [
                'nullable',
                'exists:category_products,id',
            ],
        ]);

        Product::create($request->all());

        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }

    // Показати продукт
   public function show($id)
   {
       $product = Product::findOrFail($id);
       return view('products.show', compact('product'));
   }

   // Показати форму для редагування продукту
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = CategoryProduct::all();
        return view('products.edit', compact('product', 'categories'));
    }

   // Оновити продукт
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'price' => [
                'required',
                'numeric',
                'min:0', // Перевірка на позитивну ціну
            ],
            'image' => [
                'nullable',
                'url',
                'max:255', // Максимальна довжина URL зображення
            ],
            'category_id' => [
                'nullable',
                'exists:category_products,id',
            ],
        ]);

        $product = Product::findOrFail($id);
        $product->update($request->all());

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }



    // Видалити продукт
   public function destroy($id)
   {
       $product = Product::findOrFail($id);
       $product->delete();

       return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
   }
}
