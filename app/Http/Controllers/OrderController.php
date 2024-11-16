<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Показати всі замовлення з можливістю фільтрації
    public function index(Request $request)
    {
        $status = $request->input('status');

        // Якщо статус вказаний, фільтруємо за статусом, інакше виводимо всі замовлення
        if ($status) {
            $orders = Order::where('status', $status)->get();
        } else {
            $orders = Order::all();
        }

        return view('orders.index', compact('orders', 'status'));
    }

    // Показати деталі конкретного замовлення
    public function show($orderId)
    {
        $order = Order::findOrFail($orderId);

        return view('orders.show', compact('order'));
    }

    // Оновити статус замовлення
    public function updateStatus(Request $request, $orderId)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $order = Order::findOrFail($orderId);

        $order->update([
            'status' => $request->status,
        ]);

        return redirect()->route('orders.show', $orderId)
            ->with('success', 'Статус замовлення оновлено!');
    }
}

