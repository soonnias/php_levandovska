<!-- Включення навігації -->
@include('layouts.navigationUser')

<div class="container mt-5">
    <h1>Ваш кошик</h1>

    {{-- помилки валідації --}}
    @include('layouts.validation-errors')

    @if ($cart && count($items) > 0)
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Назва товару</th>
                <th>Ціна за одиницю</th>
                <th>Кількість</th>
                <th>Загальна ціна</th>
                <th>Дія</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($items as $item)
                <tr id="item-{{ $item->id }}">
                    <td>{{ $item->product->name }}</td>
                    <td>${{ $item->product->price }}</td> <!-- Ціна за одиницю -->
                    <td>
                        <!-- Форма для зміни кількості товару -->
                        <form action="{{ route('cartItems.update', ['cartId' => $cart->id, 'itemId' => $item->id]) }}" method="POST" id="update-form-{{ $item->id }}">
                            @csrf
                            @method('PATCH') <!-- Використовуємо PATCH замість PUT -->
                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control quantity-input" style="width: 60px;" data-item-id="{{ $item->id }}">
                        </form>
                    </td>
                    <td id="total-price-{{ $item->id }}">
                        ${{ $item->product->price * $item->quantity }} <!-- Початкова загальна ціна -->
                    </td>
                    <td>
                        <!-- Кнопка для видалення товару з кошика -->
                        <form action="{{ route('cartItems.destroy', ['cartId' => $cart->id, 'itemId' => $item->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Видалити</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <!-- Форма для оформлення замовлення -->
        <form action="{{ route('userOrders.create') }}" method="GET" class="d-flex justify-content-between">
            <h4>Загальна вартість: $<span id="total-cart-price">{{ $totalPrice }}</span></h4> <!-- Вартість кошика -->
            <input type="hidden" name="cart_id" value="{{ $cart->id }}">
            <button type="submit" class="btn btn-primary">Оформити замовлення</button>
        </form>

        <!-- Кнопка для очищення кошика -->
        <form action="{{ route('carts.clear', ['userId' => $cart->user_id]) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-warning">Очистити кошик</button>
        </form>

    @else
        <p>Ваш кошик порожній. Додайте товари до кошика!</p>
    @endif
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    // Оновлення кількості товару при зміні значення в полі
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('input', function() {
            const itemId = this.getAttribute('data-item-id');
            const form = document.getElementById('update-form-' + itemId);

            // Відправляємо форму при зміні значення
            form.submit();
        });
    });
</script>

</body>
</html>
