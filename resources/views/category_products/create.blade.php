{{-- resources/views/category_products/create.blade.php --}}
@extends('layouts.app')

@section('content')
    <h1>Додати категорію продукту</h1>

    {{-- Помилки валідації --}}
    @include('layouts.validation-errors')

    <form action="{{ route('category-products.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Назва категорії</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Додати</button>
        <a href="{{ route('category-products.index') }}" class="btn btn-secondary">Назад</a>
    </form>
@endsection
