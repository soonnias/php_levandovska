@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Створити продукт</h1>

        {{-- помилки валідації --}}
        @include('layouts.validation-errors')

        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Назва</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Опис</label>
                <textarea class="form-control" id="description" name="description"></textarea>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Ціна</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">URL картинки</label>
                <input type="url" class="form-control" id="image" name="image">
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label">Категорія</label>
                <select class="form-control" id="category_id" name="category_id">
                    <option value="">Оберіть категорію</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Створити</button>
        </form>
    </div>
@endsection
