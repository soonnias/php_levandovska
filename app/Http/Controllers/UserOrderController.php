<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserOrderController extends Controller
{
    // Перегляд замовлень користувача
    public function index()
    {
        // Отримання всіх замовлень користувача
        $orders = Order::where('user_id', Auth::id())
            ->with('items') // Завантаження товарів для кожного замовлення
            ->orderBy('created_at', 'desc')
            ->get();

        return view('userOrders.index', compact('orders'));
    }

    public function create()
    {
        // Отримуємо кошик користувача
        $cart = Cart::where('user_id', Auth::id())->first();

        // Перевірка, чи існує кошик і чи є в ньому товари
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Ваш кошик порожній або всі товари недоступні.');
        }

        // Повертаємо в представлення створення замовлення разом з кошиком
        return view('userOrders.create', compact('cart'));
    }

    // Оформлення замовлення
    public function store(Request $request)
    {
        // Валідатор для перевірки даних
        $validated = $request->validate([
            'delivery_address' => 'required|string|max:255',
            'customer_name' => 'required|string|max:255',
            'customer_surname' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:15',
        ]);

        // Отримання кошика користувача
        $cart = Cart::where('user_id', Auth::id())->first();

        // Перевірка, чи є товари в кошику
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->back()->withErrors('Ваш кошик порожній!');
        }

        // Перевірка доступності товарів та видалення недоступних
        $availableItems = $cart->items->filter(function ($item) {
            return $item->product->is_available; // Перевіряємо чи товар доступний
        });

        // Якщо в кошику не залишилось доступних товарів
        if ($availableItems->isEmpty()) {
            return redirect()->back()->withErrors('Усі товари в кошику недоступні!');
        }

        // Обчислення загальної ціни замовлення для доступних товарів
        $totalPrice = $availableItems->sum(function ($item) {
            return $item->quantity * $item->product->price; // Враховуємо ціну товару з продукту
        });

        // Створення нового замовлення
        $order = Order::create([
            'user_id' => Auth::id(),
            'total_price' => $totalPrice,
            'delivery_address' => $validated['delivery_address'],
            'customer_name' => $validated['customer_name'],
            'customer_surname' => $validated['customer_surname'],
            'customer_phone' => $validated['customer_phone'],
            'status' => 'pending', // Спочатку замовлення має статус "pending"
        ]);

        // Створення позицій для кожного товару в кошику
        foreach ($availableItems as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_name' => $cartItem->product->name, // Використовуємо назву товару з продукту
                'product_price' => $cartItem->product->price, // Ціна товару з продукту
                'quantity' => $cartItem->quantity,
                'total_price' => $cartItem->quantity * $cartItem->product->price, // Загальна ціна за товар
            ]);
        }

        // Очищення кошика після оформлення замовлення
        $cart->items->each->delete();

        return redirect()->route('userOrders.index')->with('success', 'Замовлення успішно оформлено!');
    }

    // Функція для перегляду детального замовлення
    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Ви не маєте доступу до цього замовлення');
        }

        return view('userOrders.show', compact('order'));
    }

}
