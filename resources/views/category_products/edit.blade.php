{{-- resources/views/category_products/edit.blade.php --}}
@extends('layouts.app')

@section('content')
    <h1>Редагувати категорію продукту</h1>

    {{-- Помилки валідації --}}
    @include('layouts.validation-errors')

    <form action="{{ route('category-products.update', $category) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Назва категорії</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $category->name }}" required>
        </div>
        <button type="submit" class="btn btn-success">Оновити</button>
        <a href="{{ route('category-products.index') }}" class="btn btn-secondary">Назад</a>
    </form>
@endsection
