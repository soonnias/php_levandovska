@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        {{-- помилки валідації --}}
        @include('layouts.validation-errors')

        <h1>Замовлення #{{ $order->id }}</h1>

        <!-- Інформація про клієнта -->
        <div class="mt-4">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Ім'я:</strong> {{ $order->customer_name }} {{ $order->customer_surname }}</p>
                    <p><strong>Телефон:</strong> {{ $order->customer_phone }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Адреса доставки:</strong> {{ $order->delivery_address }}</p>
                </div>
            </div>
        </div>

        <!-- Товари в замовленні -->
        <div class="mt-4">
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
                @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $item->product_name }}</td>
                        <td>${{ $item->product_price }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ $item->total_price }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <hr>

        <!-- Загальна сума -->
        <div class="d-flex justify-content-between mt-4">
            <h4>Загальна сума: ${{ $order->total_price }}</h4>
        </div>

        <hr>

        <!-- Статус замовлення -->
        <div class="mt-4">
            <h4>Статус замовлення: {{ ucfirst($order->status) }}</h4>
        </div>

        <hr>

        <!-- Форма зміни статусу -->
        <div class="mt-4">
            <h4>Змінити статус</h4>
            <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST">
                @csrf
                <select name="status" class="form-control mb-3">
                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Очікує</option>
                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Відправлено</option>
                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Доставлено</option>
                    <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>Скасовано</option>
                </select>
                <button type="submit" class="btn btn-primary">Змінити статус</button>
            </form>
        </div>

        <div class="mt-4">
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Назад до списку замовлень</a>
        </div>
    </div>
@endsection
