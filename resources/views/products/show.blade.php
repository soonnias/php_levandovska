@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $product->name }}</h1>
        <p><strong>Ціна:</strong> {{ $product->price }} грн</p>
        <p><strong>Категорія:</strong> {{ $product->category?->name ?? 'Без категорії' }}</p>
        <p><strong>Статус:</strong> {{ $product->is_available ? 'Доступний' : 'Недоступний' }}</p>

        <a href="{{ route('products.index') }}" class="btn btn-secondary">Назад</a>
        <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">Редагувати</a>
        <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Видалити</button>
        </form>
    </div>
@endsection
