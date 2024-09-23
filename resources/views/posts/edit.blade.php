{{-- resources/views/posts/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Редагувати пост</h1>

    <form action="{{ route('posts.update', $post) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Заголовок</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $post->title }}" required>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Контент</label>
            <textarea class="form-control" id="content" name="content" required>{{ $post->content }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Оновити пост</button>
        <a href="{{ route('posts.index') }}" class="btn btn-secondary">Скасувати</a>
    </form>
</div>
@endsection
