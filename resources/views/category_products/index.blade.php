{{-- resources/views/category_products/index.blade.php --}}
@extends('layouts.app')

@section('content')
    <h1>Категорії продуктів</h1>

    <!-- Форма пошуку та сортування -->
    <form method="GET" action="{{ route('category-products.index') }}" class="mb-3">
        <div class="row align-items-center">
            <div class="col-auto ms-2">
                <a href="{{ route('category-products.create') }}" class="btn btn-primary">Додати категорію продукту</a>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
            </div>
        </div>
    </form>

    <table class="table mt-3">
        <thead>
            <tr>
                <th>Назва категорії</th>
                <th>Дії</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>
                        <a href="{{ route('category-products.edit', $category) }}" class="btn btn-warning">Редагувати</a>
                        <form action="{{ route('category-products.destroy', $category) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Видалити</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
