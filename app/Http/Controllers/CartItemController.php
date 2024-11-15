<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    // Додати товар у кошик
    public function store(Request $request, $cartId)
    {
        // Валідація
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::findOrFail($cartId);

        // Перевіряємо, чи цей товар вже є в кошику
        $existingItem = CartItem::where('cart_id', $cartId)
            ->where('product_id', $request->product_id)
            ->first();

        if ($existingItem) {
            // Оновлюємо кількість товару, якщо вже є в кошику
            $existingItem->update([
                'quantity' => $existingItem->quantity + $request->quantity,
            ]);
        } else {
            // Створюємо новий елемент у кошику
            CartItem::create([
                'cart_id' => $cartId,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->route('carts.show', ['userId' => $cart->user_id]);
    }

    // Оновити кількість товару в кошику
    public function update(Request $request, $cartId, $itemId)
    {
        // Валідація
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Знаходимо товар у кошику
        $cart = Cart::findOrFail($cartId);
        $item = CartItem::where('cart_id', $cartId)->where('id', $itemId)->firstOrFail();

        // Оновлюємо кількість товару
        $item->update([
            'quantity' => $request->quantity,
        ]);

        return redirect()->route('carts.show', ['userId' => $cart->user_id]);
    }

    // Видалити елемент з кошика
    public function destroy($cartId, $itemId)
    {
        $cart = Cart::findOrFail($cartId);
        $item = CartItem::findOrFail($itemId);

        if ($item->cart_id === $cart->id) {
            $item->delete();
        }

        return redirect()->route('carts.show', ['userId' => $cart->user_id]);
    }
}
