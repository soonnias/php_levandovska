<!-- resources/views/userOrders/show.blade.php -->
@include('layouts.navigationUser')

<div class="container mt-5">
    <h1>Деталі замовлення #{{ $order->id }}</h1>

    <div class="row">
        <div class="col-md-6">
            <p><strong>Ім'я:</strong> {{ $order->customer_name }} {{ $order->customer_surname }}</p>
            <p><strong>Телефон:</strong> {{ $order->customer_phone }}</p>
        </div>
        <div class="col-md-6">
            <p><strong>Адреса доставки:</strong> {{ $order->delivery_address }}</p>
            <p><strong>Статус:</strong> {{ ucfirst($order->status) }}</p>
        </div>
    </div>

    <h4>Замовлення</h4>
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
        @foreach ($order->items as $orderItem)
            <tr>
                <td>{{ $orderItem->product_name }}</td>
                <td>${{ $orderItem->product_price }}</td>
                <td>{{ $orderItem->quantity }}</td>
                <td>${{ $orderItem->total_price }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-between">
        <h4>Загальна сума: ${{ $order->total_price }}</h4>
    </div>

    <a href="{{ route('userOrders.index') }}" class="btn btn-secondary mb-5">Назад до моїх замовлень</a>
</div>
</body>
</html>
