<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    // Додати товар до замовлення
    public function store(Request $request, $orderId)
    {
        // Валідація
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric',
        ]);

        $order = Order::findOrFail($orderId);

        // Створити новий елемент замовлення
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'price' => $request->price,
        ]);

        return redirect()->route('orders.show', ['userId' => $order->user_id])->with('success', 'Item added to order!');
    }

    // Видалити товар з замовлення
    public function destroy($orderId, $itemId)
    {
        $order = Order::findOrFail($orderId);
        $item = OrderItem::findOrFail($itemId);

        if ($item->order_id === $order->id) {
            $item->delete();
        }

        return redirect()->route('orders.show', ['userId' => $order->user_id])->with('success', 'Item removed from order!');
    }
}
