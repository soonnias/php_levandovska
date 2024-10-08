@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Редагувати пост</h1>

    {{-- помилки валідації --}}
    @include('layouts.validation-errors')

    <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="title" class="form-label">Заголовок</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $post->title }}" required>
        </div>
        
        <div class="mb-3">
            <label for="description" class="form-label">Контент</label>
            <textarea class="form-control" id="description" name="description" required>{{ $post->description }}</textarea>
        </div>
        
        <div class="mb-3">
            <label for="image" class="form-label">URL зображення</label>
            <input type="url" class="form-control" id="image" name="image" value="{{ $post->image }}" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Категорії</label>
            @foreach($categories as $category)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="category_{{ $category->category_id }}" name="category_ids[]" value="{{ $category->category_id }}"
                    {{ in_array($category->category_id, $post->categories->pluck('category_id')->toArray()) ? 'checked' : '' }}>
                    <label class="form-check-label" for="category_{{ $category->category_id }}">
                        {{ $category->name }}
                    </label>
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary">Оновити пост</button>
        <a href="{{ route('posts.index') }}" class="btn btn-secondary">Скасувати</a>
    </form>
</div>
@endsection
