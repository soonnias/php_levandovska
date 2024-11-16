@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Всі замовлення</h1>

        <!-- Форма для фільтрації замовлень за статусом -->
        <form action="{{ route('orders.index') }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <select name="status" class="form-control" onchange="this.form.submit()">
                        <option value="">-- Виберіть статус --</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Очікує</option>
                        <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Відправлено</option>
                        <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Доставлено</option>
                        <option value="canceled" {{ request('status') == 'canceled' ? 'selected' : '' }}>Скасовано</option>
                    </select>
                </div>
            </div>
        </form>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Клієнт</th>
                <th>Загальна сума</th>
                <th>Статус</th>
                <th>Дії</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->customer_name }} {{ $order->customer_surname }}</td>
                    <td>${{ $order->total_price }}</td>
                    <td>{{ ucfirst($order->status) }}</td>
                    <td>
                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-info">Переглянути</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
