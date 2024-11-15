<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Показати кошик користувача
    public function show($userId)
    {
        // Отримуємо кошик для певного користувача
        $cart = Cart::where('user_id', $userId)->first();
        $items = $cart ? $cart->items : [];

        // Обчислюємо загальну вартість кошика
        $totalPrice = $items->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        return view('cart.show', compact('cart', 'items', 'totalPrice'));
    }


    // Створити кошик для користувача
    public function create($userId)
    {
        // Перевіряємо, чи вже існує кошик для цього користувача
        $cart = Cart::firstOrCreate(['user_id' => $userId]);

        return redirect()->route('carts.show', ['userId' => $userId]);
    }

    // Очищення кошика
    public function clear($userId)
    {
        $cart = Cart::where('user_id', $userId)->first();
        if ($cart) {
            $cart->items()->delete(); // Видалити всі елементи кошика
        }

        return redirect()->route('carts.show', ['userId' => $userId])->with('success', 'Cart cleared!');
    }
}
