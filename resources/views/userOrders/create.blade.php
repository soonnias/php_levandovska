<!-- resources/views/userOrders/create.blade.php -->
<!-- Включення навігації -->
@include('layouts.navigationUser')

<div class="container mt-5">
    <h1>Оформлення замовлення</h1>

    {{-- помилки валідації --}}
    @include('layouts.validation-errors')

    @if ($cart && $cart->items->isNotEmpty())
        <form action="{{ route('userOrders.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="delivery_address">Адреса доставки</label>
                        <input type="text" name="delivery_address" id="delivery_address" class="form-control" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="customer_name">Ім'я</label>
                        <input type="text" name="customer_name" id="customer_name" class="form-control" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="customer_surname">Прізвище</label>
                        <input type="text" name="customer_surname" id="customer_surname" class="form-control" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="customer_phone">Телефон</label>
                        <input type="text" name="customer_phone" id="customer_phone" class="form-control" required>
                    </div>
                </div>
            </div>

            <h3>Товари в кошику</h3>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Назва товару</th>
                    <th>Ціна за одиницю</th>
                    <th>Кількість</th>
                    <th>Загальна ціна</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($cart->items as $cartItem)
                    @if ($cartItem->product->is_available)
                        <tr>
                            <td>{{ $cartItem->product->name }}</td>
                            <td>${{ $cartItem->product->price }}</td>
                            <td>{{ $cartItem->quantity }}</td>
                            <td>${{ $cartItem->quantity * $cartItem->product->price }}</td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-between">
                <h4>Загальна сума: $<span id="total-cart-price">{{ $cart->items->sum(function ($item) { return $item->quantity * $item->product->price; }) }}</span></h4>
                <button type="submit" class="btn btn-primary">Оформити замовлення</button>
            </div>
        </form>
    @else
        <p>Ваш кошик порожній або всі товари недоступні.</p>
    @endif
</div>

</body>
</html>
