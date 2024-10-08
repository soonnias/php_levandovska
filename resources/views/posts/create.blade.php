@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Створити новий пост</h1>

    {{-- помилки валідації --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('posts.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Заголовок</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Контент</label>
            <textarea class="form-control" id="description" name="description" required>{{ old('description') }}</textarea>
        </div>
        
        {{-- Вибір категорій через чекбокси --}}
        <div class="mb-3">
            <label class="form-label">Категорії</label>
            <div>
                @foreach($categories as $category)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="category_{{ $category->category_id }}" name="category_ids[]" value="{{ $category->category_id }}" 
                            {{ in_array($category->category_id, old('category_ids', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="category_{{ $category->category_id }}">
                            {{ $category->name }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
  
        {{-- зображення --}}
        <div class="mb-3">
            <label for="image" class="form-label">Посилання на зображення</label>
            <input type="url" class="form-control" id="image" name="image" value="{{ old('image') }}" required>
        </div>

        <button type="submit" class="btn btn-success">Створити пост</button>
        <a href="{{ route('posts.index') }}" class="btn btn-secondary">Скасувати</a>
    </form>
</div>
@endsection
