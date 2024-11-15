<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Показати замовлення користувача
    public function show($userId)
    {
        // Отримуємо всі замовлення користувача
        $orders = Order::where('user_id', $userId)->get();
        
        return view('orders.index', compact('orders'));
    }

    // Створити нове замовлення
    public function store(Request $request, $userId)
    {
        // Валідація
        $request->validate([
            'total_price' => 'required|numeric',
            'status' => 'required|string',
        ]);

        // Створюємо замовлення
        $order = Order::create([
            'user_id' => $userId,
            'total_price' => $request->total_price,
            'status' => $request->status,
        ]);

        return redirect()->route('orders.show', ['userId' => $userId])->with('success', 'Order created!');
    }

    // Оновити статус замовлення
    public function updateStatus(Request $request, $orderId)
    {
        // Валідація
        $request->validate([
            'status' => 'required|string',
        ]);

        // Знайти замовлення
        $order = Order::findOrFail($orderId);
        
        // Оновити статус
        $order->update([
            'status' => $request->status,
        ]);

        return redirect()->route('orders.show', ['userId' => $order->user_id])->with('success', 'Order status updated!');
    }
}
