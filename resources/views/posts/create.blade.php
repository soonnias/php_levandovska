@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Створити новий пост</h1>

    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Заголовок</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Контент</label>
            <textarea class="form-control" id="content" name="content" required>{{ old('content') }}</textarea>
        </div>
        <div class="mb-3">
            <label for="category_id" class="form-label">Категорія</label>
            <select class="form-select" id="category_id" name="category_id" required>
                <option value="">Виберіть категорію</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Зображення</label>
            <input type="file" class="form-control" id="image" name="image">
        </div>
        <button type="submit" class="btn btn-success">Створити пост</button>
        <a href="{{ route('posts.index') }}" class="btn btn-secondary">Скасувати</a>
    </form>
</div>
@endsection
