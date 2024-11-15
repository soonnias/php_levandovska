<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\CategoryProduct; // Ваші категорії
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Пошук за назвою товару
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        // Сортування
        if ($request->filled('sort_option')) {
            $sortOption = $request->input('sort_option');

            if (in_array($sortOption, ['asc', 'desc'])) {
                $query->orderBy('name', $sortOption);
            } elseif (in_array($sortOption, ['new', 'old'])) {
                $query->orderBy('created_at', $sortOption === 'new' ? 'desc' : 'asc');
            }
        }

        // Фільтрація за категоріями
        if ($request->filled('categories')) {
            $categoryIds = $request->input('categories');
            $query->whereIn('category_id', $categoryIds);
        }

        // Інші фільтри (ціна, дата)
        if ($request->filled('from_price')) {
            $query->where('price', '>=', $request->input('from_price'));
        }

        if ($request->filled('to_price')) {
            $query->where('price', '<=', $request->input('to_price'));
        }

        // Отримання всіх категорій для фільтра
        $categories = CategoryProduct::all();

        // Отримання відфільтрованих товарів
        $products = $query->orderBy('created_at', 'desc')->get();

        // Показати активні фільтри
        $activeFilters = [
            'categories' => $request->input('categories', []),
            'search' => $request->input('search', ''),
            'from_price' => $request->input('from_price', ''),
            'to_price' => $request->input('to_price', ''),
        ];

        return view('userProducts.index', compact('products', 'categories', 'activeFilters'));
    }

    public function show($id)
    {
        $product = Product::with('category')->find($id);

        if (!$product) {
            return abort(404); // обробка помилки
        }

        $categories = CategoryProduct::all();

        // Отримуємо кошик користувача
        $cart = Auth::check() ? Auth::user()->cart : null;

        return view('userProducts.show', compact('product', 'categories', 'cart'));
    }

}
