
    @include('layouts.navigationUser')

    <div class="container mt-5">
        <h1>Ваші замовлення</h1>

        @if ($orders->isNotEmpty())
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Номер замовлення</th>
                    <th>Дата</th>
                    <th>Статус</th>
                    <th>Загальна сума</th>
                    <th>Дія</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                        <td>{{ ucfirst($order->status) }}</td>
                        <td>${{ $order->total_price }}</td>
                        <td>
                            <a href="{{ route('userOrders.show', $order->id) }}" class="btn btn-info btn-sm">Переглянути</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>У вас немає жодного замовлення.</p>
        @endif
    </div>

    </body>
    </html>
