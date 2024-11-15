@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Продукти</h1>
        <a href="{{ route('products.create') }}" class="btn btn-success mb-3">Створити продукт</a>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Назва</th>
                <th>Опис</th>
                <th>Ціна</th>
                <th>Картинка</th>
                <th>Категорія</th>
                <th>Дії</th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->description }}</td>
                    <td>${{ $product->price }}</td>
                    <td>
                        @if($product->image)
                            <img src="{{ $product->image }}" alt="{{ $product->name }}" width="50">
                        @endif
                    </td>
                    <td>{{ $product->category->name ?? 'No Category' }}</td>
                    <td>
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary btn-sm">Редагувати</a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Видалити</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
